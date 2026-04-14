<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\funds\function24Controller;

class StoreController extends Controller
{
    protected $function24;

    public function __construct()
    {
        $this->function24 = new function24Controller;
    }

    public function index()
    {
        $biddings = DB::table('tblcontract_bidding as cb')
            ->leftJoin('tblcontract_bidding_store as cbs', 'cb.contract_biddingID', '=', 'cbs.contractBiddingID')
            ->join('tblcontract_details as cd', 'cb.contractID', '=', 'cd.contract_detailsID')
            ->join('protblcontract_category as cc', 'cd.contract_categoryID', '=', 'cc.contractCategoryID')
            ->join('tblcontractor_registration as cr', 'cb.contractorID', '=', 'cr.contractor_registrationID')
            ->leftJoin('users as us', 'us.id', 'cbs.assignedTo')
            ->where('cb.status', 3)
            ->where('cd.contract_categoryID', 9)
            ->where('cc.contractCategoryID', 9)
            ->select(
                'cb.contract_biddingID',
                'cb.bidding_amount',
                'cb.awarded_amount',
                'cd.contract_name',
                'cd.lot_number',
                'cd.contract_description',
                'cd.proposed_budget',
                'cc.category_name',
                'cbs.id as store_id',
                'cbs.status as store_status',
                'cbs.assignedTo',
                'cr.company_name',
                'cr.address',
                'cr.email_address',
                'cr.phone_number',
                'us.name as assignedName',
            )
            ->paginate(10);

        $users = $this->function24->UnitStaff('ST');

        return view("procurement.store.index", compact('biddings', 'users'));
    }


    public function viewBidding($id)
    {
        $bidding = DB::table('tblcontract_bidding as cb')
            ->leftJoin('tblcontract_bidding_store as cbs', 'cb.contract_biddingID', '=', 'cbs.contractBiddingID')
            ->join('tblcontract_details as cd', 'cb.contractID', '=', 'cd.contract_detailsID')
            ->join('protblcontract_category as cc', 'cd.contract_categoryID', '=', 'cc.contractCategoryID')
            ->join('tblcontractor_registration as cr', 'cb.contractorID', '=', 'cr.contractor_registrationID')
            ->leftJoin('users', 'cbs.assignedTo', '=', 'users.id')
            ->where('cb.contract_biddingID', $id)
            ->select(
                'cb.contract_biddingID',
                'cb.bidding_amount',
                'cb.awarded_amount',
                'cd.contract_name',
                'cd.lot_number',
                'cd.contract_description',
                'cd.proposed_budget',
                'cc.category_name',
                'cbs.id as store_id',
                'cbs.status as store_status',
                'cbs.assignedTo',
                'users.name as assigned_user_name',
                'cr.company_name',
                'cr.address',
                'cr.email_address',
                'cr.phone_number'
            )
            ->first();

        if (!$bidding) {
            return response()->json(['error' => 'Bidding not found'], 404);
        }

        return response()->json($bidding);
    }

    public function approveBidding(Request $request)
    {
        try {
            // First check if record exists in store table
            $existing = DB::table('tblcontract_bidding_store')
                ->where('contractBiddingID', $request->id)
                ->first();

            if ($existing) {
                // Update existing record - ONLY update status, not assignedTo
                DB::table('tblcontract_bidding_store')
                    ->where('contractBiddingID', $request->id)
                    ->update([
                        'status' => 1, // Only approve, don't assign
                        'updated_at' => now()
                    ]);
            } else {
                // Create new record - don't set assignedTo
                DB::table('tblcontract_bidding_store')->insert([
                    'contractBiddingID' => $request->id,
                    'status' => 1, // Only approve
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function assignUser(Request $request)
    {
        try {
            // First check if record exists in store table
            $existing = DB::table('tblcontract_bidding_store')
                ->where('contractBiddingID', $request->bidding_id)
                ->first();

            if ($existing) {
                // Update existing record
                DB::table('tblcontract_bidding_store')
                    ->where('contractBiddingID', $request->bidding_id)
                    ->update([
                        'assignedTo' => $request->user_id,
                        'updated_at' => now()
                    ]);
            } else {
                // Create new record
                DB::table('tblcontract_bidding_store')->insert([
                    'contractBiddingID' => $request->bidding_id,
                    'assignedTo' => $request->user_id,
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function assignedStoreItems()
    {
        $assigned = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bid', 'store.contractBiddingID', '=', 'bid.contract_biddingID')
            ->join('tblcontract_details as contract', 'bid.contractID', '=', 'contract.contract_detailsID')
            ->join('tblcontractor_registration as contractor', 'bid.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.assignedTo', Auth::id())
            ->select(
                'store.id as store_id',
                'contract.contract_name',
                'contract.contract_description',
                'contract.proposed_budget',
                'contract.lot_number',
                'contract.sublot_number',
                'bid.bidding_amount',
                'bid.awarded_amount',
                'bid.contract_biddingID',
                'store.status',
                'contractor.company_name',
                'contractor.address',
                'contractor.phone_number',
                'contractor.email_address'
            )
            ->paginate(10);

        // \Log::info($assigned);
        return view('procurement.store.assigneditems', compact('assigned'));
    }


    public function acceptAssignItem($id)
    {
        DB::table('tblcontract_bidding_store')
            ->where('id', $id)
            ->where('assignedTo', Auth::id())
            ->update(['status' => 2]);

        // return redirect()->back();
        return redirect()->back()->with('success', 'Items successfully accepted!');
    }


    public function approveOLD(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'specification_id' => 'required',
            'approved_quantity' => 'required|integer|min:1',
        ]);

        // Ensure approved quantity does not exceed received quantity
        if ($request->approved_quantity > $request->max_quantity) {
            return back()->withInput()->with('error', 'Approved quantity exceeds received quantity.');
        }

        DB::beginTransaction();

        try {
            // Step 1: Get existing purchase item
            $purchaseItem = DB::table('purchase_items')
                ->where('itemId', $request->item_id)
                ->where('specificationId', $request->specification_id)
                ->where('specificationId', $request->specification_id)
                ->first();

            dd($purchaseItem);
            dd($request->all());

            if (!$purchaseItem) {
                return back()->with('error', 'Purchase item not found.');
            }

            $newApprovedQty = ($purchaseItem->approvedQuantity ?? 0) + $request->approved_quantity;

            // Step 2: Update purchase_items with new approvedQuantity
            DB::table('purchase_items')
                ->where('id', $purchaseItem->id)
                ->update([
                    'approvedQuantity' => $newApprovedQty,
                    'status' => 2,
                    'updated_at' => now(),
                ]);

            // Step 3: Update or insert into items_in_stores
            $existing = DB::table('items_in_stores')
                ->where('itemId', $request->item_id)
                ->where('specificationId', $request->specification_id)
                ->first();

            if ($existing) {
                DB::table('items_in_stores')
                    ->where('id', $existing->id)
                    ->update([
                        'remainingQuantity' => $existing->remainingQuantity + $request->approved_quantity,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('items_in_stores')->insert([
                    'itemId' => $request->item_id,
                    'specificationId' => $request->specification_id,
                    'remainingQuantity' => $request->approved_quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return back()->with('success', 'Item approved and added to store successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function approve2025(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'specification_id' => 'required',
            'approved_quantity' => 'required|integer|min:1',
        ]);

        // Ensure approved quantity does not exceed received quantity
        if ($request->approved_quantity > $request->max_quantity) {
            return back()->withInput()->with('error', 'Approved quantity exceeds received quantity.');
        }

        DB::beginTransaction();

        try {
            // Step 1: Get existing purchase item
            $purchaseItem = DB::table('purchase_items')
                ->where('id', $request->id)
                ->first();

            if (!$purchaseItem) {
                return back()->with('error', 'Purchase item not found.');
            }
            $biddingStoreId = $purchaseItem->biddingStoreId;


            $purchaseItem2 = DB::table('purchase_items')
                ->where('biddingStoreId', $biddingStoreId)
                ->where('specificationId', $request->specification_id)
                ->where('specificationId', $request->specification_id)
                ->first();

            // dd($purchaseItem2);

            // dd($request->all());
            $newApprovedQty = ($purchaseItem2->approvedQuantity ?? 0) + $request->approved_quantity;


            // ✅ Calculate approved_total_price = approvedQuantity * unit_price
            $unitPrice = $purchaseItem->unit_price ?? 0;
            $newApprovedTotal = $unitPrice * $newApprovedQty;

            // // Step 2: Update purchase_items with new approvedQuantity
            DB::table('purchase_items')
                ->where('id', $purchaseItem2->id)
                ->update([
                    'approvedQuantity' => $newApprovedQty,
                    'approved_total_price' => $newApprovedTotal,
                    'status' => 2,
                    'createdBy' => auth()->id(), // 👈 add this line
                    'updated_at' => now(),
                ]);

            // // Step 3: Update or insert into items_in_stores
            $existing = DB::table('items_in_stores')
                ->where('itemId', $request->item_id)
                ->where('specificationId', $request->specification_id)
                ->first();

            if ($existing) {
                DB::table('items_in_stores')
                    ->where('id', $existing->id)
                    ->update([
                        'remainingQuantity' => $existing->remainingQuantity + $request->approved_quantity,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('items_in_stores')->insert([
                    'itemId' => $request->item_id,
                    'specificationId' => $request->specification_id,
                    'remainingQuantity' => $request->approved_quantity,
                    'created_by' => auth()->id(), // 👈 capture user who approved
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return back()->with('success', 'Item approved and added to store successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function approve_12_03_2026(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'specification_id' => 'required',
            'approved_quantity' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:1000', // ✅ add this
        ]);

        if ($request->approved_quantity > $request->max_quantity) {
            return back()->withInput()->with('error', 'Approved quantity exceeds received quantity.');
        }

        DB::beginTransaction();

        try {
            // ✅ Get the purchase item by ID
            $purchaseItem = DB::table('purchase_items')->where('id', $request->id)->first();

            if (!$purchaseItem) {
                return back()->with('error', 'Purchase item not found.');
            }

            // ✅ Prevent approval if unit price is missing or zero
            if (empty($purchaseItem->unit_price) || $purchaseItem->unit_price <= 0) {
                return back()->with('error', 'Unit price is not set or is zero. Please update the unit price before approving.');
            }

            // ✅ New approved quantity
            $newApprovedQty = ($purchaseItem->approvedQuantity ?? 0) + $request->approved_quantity;

            // ✅ Calculate new approved total price
            $unitPrice = $purchaseItem->unit_price ?? 0;
            $newApprovedTotal = $unitPrice * $newApprovedQty;

            // ✅ Update purchase_items table
            DB::table('purchase_items')->where('id', $purchaseItem->id)->update([
                'approvedQuantity' => $newApprovedQty,
                'approved_total_price' => $newApprovedTotal,
                'comment' => $request->comment, // ✅ store the comment here
                'status' => 2,
                'createdBy' => auth()->id(),
                'updated_at' => now(),
            ]);

            // ✅ Update or insert into items_in_stores
            $existing = DB::table('items_in_stores')
                ->where('itemId', $request->item_id)
                ->where('specificationId', $request->specification_id)
                ->first();

            if ($existing) {
                DB::table('items_in_stores')->where('id', $existing->id)->update([
                    'remainingQuantity' => $existing->remainingQuantity + $request->approved_quantity,
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('items_in_stores')->insert([
                    'itemId' => $request->item_id,
                    'specificationId' => $request->specification_id,
                    'remainingQuantity' => $request->approved_quantity,
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return back()->with('success', 'Item approved and added to store successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }






    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:purchase_items,id',
            'item_id' => 'required|exists:tblitems,itemID',
            'approved_quantity' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:1000',
            'transaction_date' => 'required|date',
        ]);

        if ($request->approved_quantity > $request->max_quantity) {
            return back()->withInput()->with('error', 'Approved quantity exceeds available quantity.');
        }

        DB::beginTransaction();

        try {
            $purchaseItem = DB::table('purchase_items')->where('id', $request->id)->first();

            if (!$purchaseItem) {
                return back()->with('error', 'Purchase item not found.');
            }

            if ($purchaseItem->unit_price <= 0) {
                return back()->with('error', 'Unit price is not set or invalid.');
            }

            $srvNo = generateSivAndSrvNo('srv');

            // 1️⃣ INSERT NEW APPROVAL RECORD
            DB::table('items_in_stores')->insert([
                'itemId'            => $request->item_id,
                'item_in'           => $request->approved_quantity,
                'remark'            => $request->comment,
                'transaction_date'  => $request->transaction_date,
                'contractorID'      => $request->contractorID,
                'contractID'        => $request->contractID,
                'biddingStoreId'    => $request->biddingStoreId,
                'purchaseItemId'    => $purchaseItem->id,
                'srv_no'            => $srvNo, // ✅ generate and store SRV number
                'created_by'        => auth()->id(),
                'created_at'        => now(),
            ]);

            // 2️⃣ RECALCULATE TOTAL APPROVED QUANTITY
            $sumApproved = DB::table('items_in_stores')
                ->where('purchaseItemId', $purchaseItem->id)
                ->sum('item_in');

            // 3️⃣ UPDATE APPROVED TOTAL PRICE
            $approvedTotal = $sumApproved * $purchaseItem->unit_price;

            // 4️⃣ DETERMINE STATUS
            $status = $sumApproved >= $purchaseItem->totalQuantity ? 2 : 1;

            // 5️⃣ UPDATE purchase_items
            DB::table('purchase_items')->where('id', $purchaseItem->id)->update([
                'approvedQuantity'     => $sumApproved,
                'approved_total_price' => $approvedTotal,
                'comment'              => $request->comment,
                'status'               => $status,
                'updated_at'           => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Item received and added to store successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function showPendingItems($storeId)
    {
        $pendingItems = DB::table('purchase_items')
            ->join('tblitems', 'tblitems.itemID', '=', 'purchase_items.itemid')
            ->join('tblspecifications', 'tblspecifications.specificationID', '=', 'purchase_items.specificationid')
            ->select(
                'purchase_items.*',
                'tblitems.item as item_name',
                'tblspecifications.specification as spec_name',
                DB::raw('purchase_items.totalQuantity - purchase_items.approvedQuantity as pendingQuantity')
            )
            ->where('purchase_items.biddingStoreId', $storeId)
            ->whereRaw('purchase_items.totalQuantity > purchase_items.approvedQuantity')
            ->get();

        return view('store.pending', compact('pendingItems'));
    }



    public function itemInputPage_17_03_2026($id)
    {
        // Get contract info
        $contract = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bid', 'store.contractBiddingID', '=', 'bid.contract_biddingID')
            ->join('tblcontract_details as contract', 'bid.contractID', '=', 'contract.contract_detailsID')
            ->join('tblcontractor_registration as contractor', 'bid.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.id', $id)
            ->select('store.*', 'contract.contract_name', 'bid.contract_biddingID', 'contractor.company_name')
            ->first();

        // Get items under category ID 4
        $items = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        // Get specifications for these items
        $itemIDs = $items->pluck('itemID'); // extract item IDs

        $specs = DB::table('tblspecifications')
            ->whereIn('itemID', $itemIDs) // assuming `tblspecifications` has `itemID` column
            ->select('specificationID', 'specification', 'itemID')
            ->get();

        return view('procurement.store.item-input', compact('contract', 'items', 'specs'));
    }

    public function itemInputPage_18_03_2026($id)
    {
        // Get contract info
        $contract = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bid', 'store.contractBiddingID', '=', 'bid.contract_biddingID')
            ->join('tblcontract_details as contract', 'bid.contractID', '=', 'contract.contract_detailsID')
            ->join('tblcontractor_registration as contractor', 'bid.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.id', $id)
            ->select('store.*', 'contract.contract_name', 'bid.contract_biddingID', 'contractor.company_name')
            ->first();

        // Items for dropdown
        $items = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        // Specifications
        $itemIDs = $items->pluck('itemID');

        $specs = DB::table('tblspecifications')
            ->whereIn('itemID', $itemIDs)
            ->select('specificationID', 'specification', 'itemID')
            ->get();

        // ✅ GET SAVED ITEMS FROM purchase_items
        // $savedItems = DB::table('purchase_items as pi')
        //     ->join('tblitems as i', 'pi.itemId', '=', 'i.itemID')
        //     ->where('pi.biddingStoreid', $id) // IMPORTANT: link to this store
        //     ->select(
        //         'pi.*',
        //         'i.item'
        //     )
        //     ->orderBy('pi.id', 'desc')
        //     ->get();

        $savedItems = DB::table('purchase_items')
            ->join('tblitems', 'purchase_items.itemId', '=', 'tblitems.itemID')
            ->where('purchase_items.biddingStoreid', $id)
            ->select('purchase_items.*', 'tblitems.item as itemName')
            ->get();

        // Get all item IDs
        $itemIds = $savedItems->pluck('itemId')->toArray(); // lowercase

        // Load all specifications for these items
        $specs = DB::table('tblspecifications')
            ->whereIn('itemID', $itemIds)
            ->select('itemID', 'specification')
            ->get()
            ->groupBy('itemID') // groupBy keeps original key (itemID)
            ->map(function ($group) {
                return $group->pluck('specification');
            });

        // Attach specifications to each item
        foreach ($savedItems as $item) {
            // Convert lookup to string key to match tblspecifications.itemID
            $item->specifications = $specs[$item->itemId] ?? collect([]);
        }




        return view('procurement.store.item-input', compact(
            'contract',
            'items',
            'specs',
            'savedItems'
        ));
    }

    public function itemInputPage($id)
    {
        // ===============================
        // 1. GET CONTRACT INFORMATION
        // ===============================
        $contract = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bid', 'store.contractBiddingID', '=', 'bid.contract_biddingID')
            ->join('tblcontract_details as contract', 'bid.contractID', '=', 'contract.contract_detailsID')
            ->join('tblcontractor_registration as contractor', 'bid.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.id', $id)
            ->select('store.*', 'contract.contract_name', 'bid.contract_biddingID', 'contractor.company_name')
            ->first();

        // ===============================
        // 2. GET ITEMS FOR SELECT DROPDOWN
        // ===============================
        $items = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        // Get all specs for these dropdown items
        $dropdownSpecs = DB::table('tblspecifications')
            ->whereIn('itemID', $items->pluck('itemID'))
            ->select('itemID', 'specification')
            ->get()
            ->groupBy('itemID')
            ->map(function ($group) {
                return $group->pluck('specification')->toArray();
            });

        // Attach specs to each dropdown item
        foreach ($items as $item) {
            $item->specs = $dropdownSpecs[$item->itemID] ?? [];
        }

        // ===============================
        // 3. GET SAVED ITEMS
        // ===============================
        $savedItems = DB::table('purchase_items')
            ->join('tblitems', 'purchase_items.itemId', '=', 'tblitems.itemID')
            ->where('purchase_items.biddingStoreid', $id)
            ->select('purchase_items.*', 'tblitems.item as itemName')
            ->get();

        // Specs for saved items
        $savedItemSpecs = DB::table('tblspecifications')
            ->whereIn('itemID', $savedItems->pluck('itemId'))
            ->select('itemID', 'specification')
            ->get()
            ->groupBy('itemID')
            ->map(function ($group) {
                return $group->pluck('specification')->toArray();
            });

        // Attach specs to saved items
        foreach ($savedItems as $item) {
            $item->specifications = $savedItemSpecs[$item->itemId] ?? [];
        }

        // ===============================
        // 4. RETURN VIEW
        // ===============================
        return view('procurement.store.item-input', compact(
            'contract',
            'items',
            'savedItems'
        ));
    }

    public function storeItemPage()
    {


        // Get items under category ID 4
        $items = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        // Get specifications for these items
        $itemIDs = $items->pluck('itemID'); // extract item IDs

        $specs = DB::table('tblspecifications')
            ->whereIn('itemID', $itemIDs) // assuming `tblspecifications` has `itemID` column
            ->select('specificationID', 'specification', 'itemID')
            ->get();

        return view('procurement.store.insert-item', compact('items', 'specs'));
    }


    public function getItemSpecifications($itemID)
    {
        $specs = DB::table('tblspecifications')
            ->where('itemID', $itemID)
            ->select('specificationID', 'specification')
            ->get();

        return response()->json($specs);
    }

    public function saveItemQty1(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|exists:tblitems,itemID',
            'specification_id' => 'required|array|min:1',
            'specification_id.*' => 'required|exists:tblspecifications,specificationID',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:0',
            'unit_price' => 'required|array|min:1',
            'unit_price.*' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($request->item_id as $index => $itemID) {
                $specID = $request->specification_id[$index];
                $qty = $request->quantity[$index];
                $price = $request->unit_price[$index];
                $totalPrice = $qty * $price;

                // Check if the item+spec already exists for this store
                $existing = DB::table('purchase_items')
                    ->where('biddingStoreid', $storeId)
                    ->where('itemid', $itemID)
                    ->where('specificationid', $specID)
                    ->first();

                if ($existing) {
                    // Update existing quantity
                    DB::table('purchase_items')
                        ->where('id', $existing->id)
                        ->update([
                            'totalQuantity' => $existing->totalQuantity + $qty,
                            'total_price' => $existing->total_price + $totalPrice,
                            'updated_at' => now(),
                            'status' => 1,
                        ]);
                } else {
                    // Insert new item
                    DB::table('purchase_items')->insert([
                        'biddingStoreid' => $storeId,
                        'itemid' => $itemID,
                        'specificationid' => $specID,
                        'totalQuantity' => $qty,
                        'unit_price' => $price,
                        'total_price' => $totalPrice,
                        'status' => 1,
                        'createdBy' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('assign.items')->with('success', 'Items saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save items: ' . $e->getMessage())->withInput();
        }
    }

    public function saveItemQty_13_03_2026(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|exists:tblitems,itemID',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:0',
            'unit_price' => 'required|array|min:1',
            'unit_price.*' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($request->item_id as $index => $itemID) {
                $qty = $request->quantity[$index];
                $price = $request->unit_price[$index];
                $totalPrice = $qty * $price;

                // Since you don't want to save specifications, set specificationid to null or 0
                // Or remove it completely from the insert if the column allows NULL
                DB::table('purchase_items')->insert([
                    'biddingStoreid' => $storeId,
                    'itemid' => $itemID,
                    // 'specificationid' => null, // Uncomment if you want to keep the column but set it to null
                    'totalQuantity' => $qty,
                    'unit_price' => $price,
                    'total_price' => $totalPrice,
                    'status' => 1,
                    'createdBy' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('assign.items')->with('success', 'Items saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save items: ' . $e->getMessage())->withInput();
        }
    }



    public function saveItemQty(Request $request, $storeId)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|exists:tblitems,itemID',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:0',
            'unit_price' => 'required|array|min:1',
            'unit_price.*' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($request->item_id as $index => $itemID) {
                $qty = $request->quantity[$index];
                $price = $request->unit_price[$index];
                $totalPrice = $qty * $price;

                // Check if item already exists
                $existing = DB::table('purchase_items')
                    ->where('biddingStoreid', $storeId)
                    ->where('itemid', $itemID)
                    ->first();

                if ($existing) {
                    // Update existing row
                    DB::table('purchase_items')
                        ->where('id', $existing->id)
                        ->update([
                            'totalQuantity' => $existing->totalQuantity + $qty, // add to existing quantity
                            'unit_price' => $price,
                            'total_price' => ($existing->totalQuantity + $qty) * $price,
                            'updated_at' => now(),
                        ]);
                } else {
                    // Insert new row
                    DB::table('purchase_items')->insert([
                        'biddingStoreid' => $storeId,
                        'itemid' => $itemID,
                        'totalQuantity' => $qty,
                        'unit_price' => $price,
                        'total_price' => $totalPrice,
                        'status' => 1,
                        'createdBy' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            // return redirect()->route('assign.items')->with('success', 'Items saved successfully.');
            return back()->with('success', 'Items saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save items: ' . $e->getMessage())->withInput();
        }
    }

    public function saveItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|exists:tblitems,itemID',

            'specification_id' => 'required|array|min:1',
            'specification_id.*' => 'required|exists:tblspecifications,specificationID',

            // 'quantity' => 'required|array|min:1',
            // 'quantity.*' => 'required|integer|min:0',

            // 'unit_price' => 'nullable|array',
            // 'unit_price.*' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($request->item_id as $index => $itemID) {

                $specID = $request->specification_id[$index];
                $qty = $request->quantity[$index];
                // $price = $request->unit_price[$index] ?? 0;
                // $totalPrice = $qty * $price;

                $existing = DB::table('items_in_stores')
                    ->where('itemid', $itemID)
                    ->where('specificationid', $specID)
                    ->first();

                if ($existing) {
                    DB::table('items_in_stores')
                        ->where('id', $existing->id)
                        ->update([
                            'remainingQuantity' => $existing->remainingQuantity + $qty,
                            // 'total_price' => $existing->total_price + $totalPrice,
                            'updated_at' => now(),
                            // 'status' => 1,
                        ]);
                } else {
                    DB::table('items_in_stores')->insert([
                        'itemid' => $itemID,
                        'specificationid' => $specID,
                        'remainingQuantity' => $qty,
                        // 'unit_price' => $price,
                        // 'total_price' => $totalPrice,
                        // 'status' => 1,
                        'created_by' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            // return redirect()->route('assign.items')->with('success', 'Items saved successfully.');
            return back()->with('msg', 'Items saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save items: ' . $e->getMessage())->withInput();
        }
    }







    public function listReceivedContracts()
    {
        $contracts = DB::table('purchase_items')
            ->join('tblcontract_bidding_store', 'purchase_items.biddingStoreid', '=', 'tblcontract_bidding_store.id')
            ->join('tblitems', 'purchase_items.itemId', '=', 'tblitems.itemID')
            ->join('tblspecifications', 'purchase_items.specificationId', '=', 'tblspecifications.specificationID')
            ->select(
                'purchase_items.biddingStoreid',
                'tblcontract_bidding_store.contractBiddingID',
                'tblitems.item as itemName',
                'tblspecifications.specification as specificationName',
                DB::raw('SUM(purchase_items.totalQuantity) as totalItems')
            )
            ->groupBy('purchase_items.biddingStoreId')
            ->get();


        return view('store.list_received_contracts', compact('contracts'));
    }


    public function viewItemsForContract_13_03_2026($biddingStoreid)
    {
        $items = DB::table('purchase_items')
            ->join('tblitems', 'purchase_items.itemid', '=', 'tblitems.itemID')
            ->join('tblspecifications', 'purchase_items.specificationid', '=', 'tblspecifications.specificationID')
            ->where('purchase_items.biddingStoreid', $biddingStoreid)
            ->select(
                'purchase_items.*',
                'tblitems.item as itemName',
                'tblspecifications.specification as specificationName'
            )
            ->get();


        $contract = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bidding', 'store.contractBiddingID', '=', 'bidding.contract_biddingID')
            ->join('tblcontractor_registration as contractor', 'bidding.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.id', $biddingStoreid)
            ->select(
                'store.*',
                'contractor.company_name'
            )
            ->first();

        // $contract = DB::table('tblcontract_bidding_store')
        //     ->where('id', $biddingStoreid)
        //     ->first();

        return view('procurement.store.view_received_items', compact('items', 'contract'));
    }





    public function viewItemsForContract($biddingStoreid)
    {
        // dd($biddingStoreid);
        $items = DB::table('purchase_items')
            ->join('tblitems', 'purchase_items.itemId', '=', 'tblitems.itemID')
            ->where('purchase_items.biddingStoreid', $biddingStoreid)
            ->select('purchase_items.*', 'tblitems.item as itemName')
            ->get();

        // Get all item IDs
        $itemIds = $items->pluck('itemId')->toArray(); // lowercase

        // Load all specifications for these items
        $specs = DB::table('tblspecifications')
            ->whereIn('itemID', $itemIds)
            ->select('itemID', 'specification')
            ->get()
            ->groupBy('itemID') // groupBy keeps original key (itemID)
            ->map(function ($group) {
                return $group->pluck('specification');
            });

        // Attach specifications to each item
        foreach ($items as $item) {
            // Convert lookup to string key to match tblspecifications.itemID
            $item->specifications = $specs[$item->itemId] ?? collect([]);
        }

        $contract = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bidding', 'store.contractBiddingID', '=', 'bidding.contract_biddingID')
            ->join('tblcontractor_registration as contractor', 'bidding.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.id', $biddingStoreid)
            ->select(
                'store.*',
                'contractor.company_name',
                'contractor.contractor_registrationID',
                'bidding.contractID',
                'bidding.contractorID',
            )
            ->first();

        return view('procurement.store.view_received_items', compact('items', 'contract'));
    }





    public function approveModal($id)
    {




        $item = DB::table('purchase_items')->where('id', $id)->first();


        $contract = DB::table('tblcontract_bidding_store as store')
            ->join('tblcontract_bidding as bidding', 'store.contractBiddingID', '=', 'bidding.contract_biddingID')
            ->join('tblcontractor_registration as contractor', 'bidding.contractorID', '=', 'contractor.contractor_registrationID')
            ->where('store.id', $item->biddingStoreId)
            ->select(
                'store.*',
                'contractor.company_name',
                'contractor.contractor_registrationID',
                'bidding.contractID',
                'bidding.contractorID',
            )
            ->first();



        return view('procurement.store.partial.approveModal', compact('item', 'contract'));
    }

    // public function createStoreCategory()
    // {
    //     $categories = DB::table('tblstore_item_category')
    //         ->where('status', 1)
    //         ->orderBy('id', 'DESC')
    //         ->get();

    //     return view('procurement.store.store_cat', compact('categories'));
    // }


    // In your controller method that loads the view (likely index or create method)
    public function createStoreCategory()
    {
        // Get users where user_unit = 62
       $users = DB::table('tblper')
        ->join('users', 'tblper.UserID', '=', 'users.id')
        ->where('tblper.departmentID', 62)
        ->select('users.id', 'users.name')
        ->orderBy('users.name')
        ->get();

        // Get existing categories
        $categories = DB::table('tblstore_item_category')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('procurement.store.store_cat', compact('categories', 'users'));
    }

    public function storeCat_17_03_2026(Request $request)
    {
        $request->validate([
            'storeItemCat' => 'required|string|max:255'
        ]);

        // Normalize input
        $category = trim($request->storeItemCat);

        // Check duplicate (case insensitive)
        $exists = DB::table('tblstore_item_category')
            ->whereRaw('LOWER(storeItemCat) = ?', [strtolower($category)])
            ->where('status', 1)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'This Store Category already exists.');
        }

        DB::table('tblstore_item_category')->insert([
            'storeItemCat' => $category,
            'assignedUser' => Auth::id(),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Store Category Added Successfully');
    }

    public function storeCat(Request $request)
    {
        $request->validate([
            'storeItemCat' => 'required|string|max:255',

        ]);

        // Normalize input
        $category = trim($request->storeItemCat);

        // Check duplicate (case insensitive)
        $exists = DB::table('tblstore_item_category')
            ->whereRaw('LOWER(storeItemCat) = ?', [strtolower($category)])
            ->where('status', 1)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'This Store Category already exists.');
        }

        DB::table('tblstore_item_category')->insert([
            'storeItemCat' => $category,
            'assignedUser' => $request->assignedUser ?? null, // Use the selected user from dropdown
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Store Category Added Successfully');
    }


    public function storeCatUpdateOLD(Request $request)
    {

        $request->validate([
            'storeItemCat' => 'required|string|max:255'
        ]);

        DB::table('tblstore_item_category')
            ->where('id', $request->id)
            ->update([
                'storeItemCat' => $request->storeItemCat,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Category Updated Successfully');
    }



    public function storeCatUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tblstore_item_category,id',
            'storeItemCat' => 'required|string|max:255',
            'assignedUser' => 'nullable|exists:users,id'
        ]);

        // Prevent duplicate (exclude current record)
        $exists = DB::table('tblstore_item_category')
            ->where('storeItemCat', $request->storeItemCat)
            ->where('id', '!=', $request->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Category already exists');
        }

        $updated = DB::table('tblstore_item_category')
            ->where('id', $request->id)
            ->update([
                'storeItemCat' => $request->storeItemCat,
                'assignedUser' => $request->assignedUser ?? null, // 👈 important
                'updated_at' => now()
            ]);

        return back()->with(
            $updated ? 'success' : 'info',
            $updated ? 'Category Updated Successfully' : 'No changes were made'
        );
    }

    public function storeCatDestroy($id)
    {
        // Check if any items are linked to this store category
        $hasItems = DB::table('tblitems')
            ->where('storeItemCatID', $id)
            ->where('status', 1)
            ->exists();

        if ($hasItems) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this category because it has items attached.'
            ]);
        }

        // Safe to delete
        DB::table('tblstore_item_category')
            ->where('id', $id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }

    /**
     * Show form to add item to store
     */
    public function addItemToStore()
    {
        // Get all active items
        $items = DB::table('tblitems')
            ->where('status', 1)
            ->orderBy('item', 'ASC')
            ->select('itemID', 'item')
            ->get();

        // Get all item IDs
        $itemIDs = $items->pluck('itemID')->toArray();

        // Get all specifications for these items and group by itemID
        $specs = DB::table('tblspecifications')
            ->whereIn('itemID', $itemIDs)
            ->select('itemID', 'specification')
            ->get()
            ->groupBy('itemID')
            ->map(function ($group) {
                return $group->pluck('specification');
            });

        // Attach specifications to each item
        foreach ($items as $item) {
            $item->specifications = $specs[$item->itemID] ?? collect([]);
        }

        return view('procurement.store.add-item', compact('items'));
    }

    /**
     * Get available quantity for an item
     */
    public function getAvailableQuantity($itemId)
    {
        try {
            // Calculate available quantity: sum(item_in) - sum(item_out)
            $totalIn = DB::table('items_in_stores')
                ->where('itemId', $itemId)
                ->sum('item_in') ?? 0;

            $totalOut = DB::table('items_in_stores')
                ->where('itemId', $itemId)
                ->sum('item_out') ?? 0;

            $availableQuantity = $totalIn - $totalOut;

            return response()->json([
                'success' => true,
                'available_quantity' => max(0, $availableQuantity) // Ensure non-negative
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'available_quantity' => 0
            ]);
        }
    }

    /**
     * Save item to store
     */
    public function saveItemToStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'itemId' => 'required|exists:tblitems,itemID',
            'item_in' => 'required|integer|min:1',
            'remark' => 'required|string|max:1000',
            'transaction_date' => 'required|date|before_or_equal:today',
        ], [
            'remark.required' => 'The remark field is required.',
            'transaction_date.before_or_equal' => 'The transaction date cannot be in the future.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::table('items_in_stores')->insert([
                'itemId' => $request->itemId,
                'item_in' => $request->item_in,
                'remark' => $request->remark,
                'transaction_date' => $request->transaction_date,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('store.add-item')
                ->with('success', 'Item added to store successfully.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to add item to store: ' . $e->getMessage());
        }
    }

    /**
     * Items Balance Report
     *
     * - Filters:
     *   - transaction_date (optional, defaults to today; report is inclusive <= selected date)
     *   - store category (optional via tblitems.storeItemCatID)
     * - Output:
     *   - Total Received = SUM(item_in)
     *   - Total Issue = SUM(item_out)
     *   - Current Balance = SUM(item_in - item_out)
     * - Items with no record in items_in_stores are returned with 0 balances.
     */
    public function itemsBalanceReport(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => ['nullable', 'date'],
            'category_id' => ['nullable', 'integer'],
        ]);

        $selectedDate = $validated['transaction_date'] ?? now()->toDateString();
        $categoryId = $validated['category_id'] ?? null;

        $categories = DB::table('tblstore_item_category')
            ->where('status', 1)
            ->orderBy('storeItemCat', 'ASC')
            ->get(['id', 'storeItemCat']);

        // Aggregates: sum(item_in) and sum(item_out) upto (inclusive) selectedDate
        $aggQuery = DB::table('items_in_stores')
            ->select(
                'itemId',
                DB::raw('SUM(item_in) as total_received'),
                DB::raw('SUM(item_out) as total_issue')
            )
            ->where('transaction_date', '<=', $selectedDate)
            ->groupBy('itemId');

        // Aggregate specifications per item to avoid duplicating balances when joining.
        $specsQuery = DB::table('tblspecifications')
            ->select(
                'itemID',
                DB::raw("GROUP_CONCAT(DISTINCT specification ORDER BY specification SEPARATOR ', ') as specifications")
            )
            ->groupBy('itemID');

        $itemsQuery = DB::table('tblitems as i')
            ->select(
                'i.itemID',
                'i.item',
                'c.storeItemCat as category',
                DB::raw('COALESCE(specs.specifications, \'\') as specifications'),
                DB::raw('COALESCE(agg.total_received, 0) as total_received'),
                DB::raw('COALESCE(agg.total_issue, 0) as total_issue'),
                DB::raw('(COALESCE(agg.total_received, 0) - COALESCE(agg.total_issue, 0)) as balance')
            )
            ->leftJoin('tblstore_item_category as c', 'c.id', '=', 'i.storeItemCatID')
            ->leftJoinSub($specsQuery, 'specs', function ($join) {
                $join->on('specs.itemID', '=', 'i.itemID');
            })
            ->leftJoinSub($aggQuery, 'agg', function ($join) {
                $join->on('agg.itemId', '=', 'i.itemID');
            })
            ->where('i.status', 1);

        if (!empty($categoryId)) {
            $itemsQuery->where('i.storeItemCatID', $categoryId);
        }

        $rows = $itemsQuery
            ->orderBy('c.storeItemCat', 'ASC')
            ->orderBy('i.item', 'ASC')
            ->get();

        return view('procurement.store.items-balance-report', [
            'rows' => $rows,
            'categories' => $categories,
            'selectedDate' => $selectedDate,
            'categoryId' => $categoryId,
        ]);
    }
}
