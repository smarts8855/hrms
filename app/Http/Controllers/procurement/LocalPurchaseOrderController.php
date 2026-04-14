<?php
// app/Http/Controllers/LocalPurchaseOrderController.php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LocalPurchaseOrderController extends Controller
{
    /**
     * Display a listing of LPOs
     */
    public function index()
    {
        $lpos = DB::table('tbl_local_purchase_orders')
            ->leftJoin('tblcontractor_registration', 'tbl_local_purchase_orders.contractor_id', '=', 'tblcontractor_registration.contractor_registrationID')
            ->leftJoin('users', 'tbl_local_purchase_orders.created_by', '=', 'users.id')
            ->select(
                'tbl_local_purchase_orders.*',
                'tblcontractor_registration.company_name as supplier_company',
                'users.name as created_by_name'
            )
            ->orderBy('tbl_local_purchase_orders.created_at', 'desc')
            ->paginate(15);

        return view('procurement.Procurement.lpo.index', compact('lpos'));
    }

    /**
     * Show form to create new LPO
     */
    public function create()
    {
        // Get active contractors for dropdown
        $contractors = DB::table('tblcontractor_registration')
            ->where('status', 1)
            ->select('contractor_registrationID', 'company_name', 'email_address', 'address')
            ->get();

        // Get contracts with awarded amounts
        $contracts = DB::table('tblcontract_bidding')
            ->leftJoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->where('tblcontract_bidding.status', 3)
            ->where('tblcontract_bidding.awarded_amount', '>', 0)
            ->select(
                'tblcontract_bidding.contract_biddingID',
                'tblcontract_details.contract_name',
                'tblcontract_details.lot_number',
                'tblcontract_bidding.awarded_amount'
            )
            ->get();

        return view('procurement.Procurement.lpo.create', compact('contractors', 'contracts'));
    }

    /**
     * Store a new LPO
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'nullable|string',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after:order_date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.unit' => 'nullable|string',
            'allocation_head' => 'nullable|string',
            'sub_head' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Generate LPO number
            $year = date('Y');
            $month = date('m');
            $lastLpo = DB::table('tbl_local_purchase_orders')
                ->whereYear('created_at', $year)
                ->orderBy('lpo_id', 'desc')
                ->first();
            
            $sequence = $lastLpo ? intval(substr($lastLpo->lpo_number, -4)) + 1 : 1;
            $lpoNumber = 'LPO/' . $year . '/' . $month . '/' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            // Calculate total
            $totalAmount = 0;
            $items = [];
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $totalAmount += $itemTotal;
                $items[] = [
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'unit_price' => $item['unit_price'],
                    'total' => $itemTotal
                ];
            }

            // Insert LPO
            $lpoId = DB::table('tbl_local_purchase_orders')->insertGetId([
                'lpo_number' => $lpoNumber,
                'contract_bidding_id' => $request->contract_bidding_id,
                'contractor_id' => $request->contractor_id,
                'supplier_name' => $request->supplier_name,
                'supplier_address' => $request->supplier_address,
                'order_date' => $request->order_date,
                'delivery_date' => $request->delivery_date,
                'items' => json_encode($items),
                'total_amount' => $totalAmount,
                'allocation_head' => $request->allocation_head,
                'sub_head' => $request->sub_head,
                'status' => 'draft',
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // If using separate items table
            if ($request->has('use_separate_items') && $request->use_separate_items) {
                foreach ($items as $item) {
                    DB::table('tbl_lpo_items')->insert([
                        'lpo_id' => $lpoId,
                        'item_description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit' => $item['unit'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['total'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('lpo.show', $lpoId)
                ->with('success', 'Local Purchase Order created successfully. LPO Number: ' . $lpoNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('LPO creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create LPO: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified LPO
     */
    public function show($id)
    {
        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        // Decode items if stored as JSON
        $items = json_decode($lpo->items, true);

        // Get creator info
        $creator = DB::table('users')->where('id', $lpo->created_by)->first();

        return view('procurement.Procurement.lpo.show', compact('lpo', 'items', 'creator'));
    }

    /**
     * Show form to edit LPO
     */
    public function edit($id)
    {
        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        // Only allow editing if status is draft
        if ($lpo->status != 'draft') {
            return redirect()->route('lpo.show', $id)->with('error', 'Only draft LPOs can be edited');
        }

        // Decode items
        $lpo->items = is_string($lpo->items) ? json_decode($lpo->items, true) : $lpo->items;

        // Get contractors for dropdown
        $contractors = DB::table('tblcontractor_registration')
            ->where('status', 1)
            ->select('contractor_registrationID', 'company_name', 'email_address', 'address')
            ->get();

        // Get contracts for dropdown (optional)
        $contracts = DB::table('tblcontract_bidding')
            ->leftJoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->where('tblcontract_bidding.status', 3)
            ->where('tblcontract_bidding.awarded_amount', '>', 0)
            ->select(
                'tblcontract_bidding.contract_biddingID',
                'tblcontract_details.contract_name',
                'tblcontract_details.lot_number',
                'tblcontract_bidding.awarded_amount'
            )
            ->get();

        return view('procurement.Procurement.lpo.edit', compact('lpo', 'contractors', 'contracts'));
    }

    /**
     * Update LPO
     */
    public function update(Request $request, $id)
    {
        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        if ($lpo->status != 'draft') {
            return redirect()->back()->with('error', 'Only draft LPOs can be updated');
        }

        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'nullable|string',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after:order_date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $items = [];
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $totalAmount += $itemTotal;
                $items[] = [
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'unit_price' => $item['unit_price'],
                    'total' => $itemTotal
                ];
            }

            DB::table('tbl_local_purchase_orders')
                ->where('lpo_id', $id)
                ->update([
                    'supplier_name' => $request->supplier_name,
                    'supplier_address' => $request->supplier_address,
                    'order_date' => $request->order_date,
                    'delivery_date' => $request->delivery_date,
                    'items' => json_encode($items),
                    'total_amount' => $totalAmount,
                    'allocation_head' => $request->allocation_head,
                    'sub_head' => $request->sub_head,
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);

            DB::commit();

            return redirect()->route('lpo.show', $id)
                ->with('success', 'LPO updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('LPO update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update LPO: ' . $e->getMessage());
        }
    }

    /**
     * Issue LPO (change status from draft to issued)
     */
    public function issue($id)
    {
        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        if ($lpo->status != 'draft') {
            return redirect()->back()->with('error', 'LPO can only be issued from draft status');
        }

        DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->update([
                'status' => 'issued',
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);

        return redirect()->route('lpo.show', $id)
            ->with('success', 'LPO issued successfully');
    }

    /**
     * Sign LPO (Head of Department)
     */
    public function signHOD(Request $request, $id)
    {
        $request->validate([
            'hod_name' => 'required|string|max:255',
            'allocation_head' => 'nullable|string',
            'sub_head' => 'nullable|string',
        ]);

        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->update([
                'head_of_department_name' => $request->hod_name,
                'hod_date' => now(),
                'allocation_head' => $request->allocation_head,
                'sub_head' => $request->sub_head,
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);

        return redirect()->route('lpo.show', $id)
            ->with('success', 'HOD signature added successfully');
    }

    /**
     * Receive goods (Store Keeper)
     */
    public function receiveGoods(Request $request, $id)
    {
        $request->validate([
            'store_keeper_name' => 'required|string|max:255',
            'store_serv_no' => 'nullable|string',
        ]);

        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->update([
                'store_keeper_name' => $request->store_keeper_name,
                'store_keeper_date' => now(),
                'store_serv_no' => $request->store_serv_no,
                'status' => 'delivered',
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);

        return redirect()->route('lpo.show', $id)
            ->with('success', 'Goods received and recorded successfully');
    }

    /**
     * Print LPO
     */
    public function print($id)
    {
        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        $items = json_decode($lpo->items, true);

        return view('procurement.Procurement.lpo.print', compact('lpo', 'items'));
    }

    /**
     * Delete LPO (only draft)
     */
    public function destroy($id)
    {
        $lpo = DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->first();

        if (!$lpo) {
            return redirect()->route('lpo.index')->with('error', 'LPO not found');
        }

        if ($lpo->status != 'draft') {
            return redirect()->back()->with('error', 'Only draft LPOs can be deleted');
        }

        DB::table('tbl_local_purchase_orders')
            ->where('lpo_id', $id)
            ->delete();

        return redirect()->route('lpo.index')
            ->with('success', 'LPO deleted successfully');
    }
}