<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;

use Illuminate\Http\Request;

class ApproveItemRequestController extends Controller
{


    // public function index()
    // {
    //     $user = Auth::user();

    //     $storeSubquery = DB::table('items_in_stores')
    //         ->selectRaw('itemId, specificationId, SUM(remainingQuantity) as totalRemaining')
    //         ->groupBy('itemId', 'specificationId');

    //     // Main query
    //     $query = DB::table('item_requests')
    //         ->join('tblunits', 'item_requests.departmentId', '=', 'tblunits.unitID')
    //         ->join('tblitems', 'item_requests.itemId', '=', 'tblitems.itemID')
    //         ->join('tblspecifications', 'item_requests.specificationId', '=', 'tblspecifications.specificationID')
    //         ->leftJoinSub($storeSubquery, 'store_summary', function ($join) {
    //             $join->on('item_requests.itemId', '=', 'store_summary.itemId')
    //                  ->on('item_requests.specificationId', '=', 'store_summary.specificationId');
    //         })
    //         ->leftJoin('users', 'item_requests.createdBy', '=', 'users.id')
    //         ->select(
    //             'item_requests.*',
    //             'tblunits.unit as departmentName',
    //             'tblitems.item as itemName',
    //             'tblspecifications.specification as specificationName',
    //             'users.name as createdByName',
    //             'store_summary.totalRemaining as store_remainingQuantity'
    //         );

    //     $items = $query->get();

    //     return view('Approve_items.index', compact('items'));
    // }

    public function     index()
    {
        // $user = Auth::user();

        // Subquery for total remaining quantity per item
        $storeSubquery = DB::table('items_in_stores')
            ->selectRaw('itemId, SUM(remainingQuantity) as totalRemaining')
            ->groupBy('itemId');

        // Build the main query
        $query = DB::table('item_requests')
            ->join('tbldepartment', 'item_requests.departmentId', '=', 'tbldepartment.id')
            ->join('tblitems', 'item_requests.itemId', '=', 'tblitems.itemID')
            ->leftJoinSub($storeSubquery, 'store_summary', function ($join) {
                $join->on('item_requests.itemId', '=', 'store_summary.itemId');
            })
            ->leftJoin('users', 'item_requests.createdBy', '=', 'users.id')
            ->select(
                'item_requests.*',
                'tbldepartment.department as departmentName',
                'tblitems.item as itemName',
                'users.name as createdByName',
                'store_summary.totalRemaining as store_remainingQuantity'
            )// ✅ Exclude Pending
            ->orderByDesc('item_requests.id');

        // ✅ Restrict for non-admin users
        // if (!in_array($user->user_role, [2, 13, 17])) {
        //     $query->where('item_requests.createdBy', $user->id);
        // }

        // ✅ Enable pagination
        $items = $query->paginate(10); // Show 10 items per page


        return view('procurement.Approve_items.index', compact('items'));
    }

    // public function updateDelivered(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:item_requests,id',
    //         'action' => 'required|in:accept,reject,deliver',
    //         'availableQuantity' => 'nullable|integer|min:1',
    //     ]);

    //     $data = ['updated_at' => now()];

    //     // Handle ACCEPT
    //     if ($request->action === 'accept') {
    //         $data['status'] = 1;

    //     // Handle REJECT
    //     } elseif ($request->action === 'reject') {
    //         $data['status'] = 2;

    //     // Handle DELIVER
    //     } elseif ($request->action === 'deliver') {
    //         $itemRequest = DB::table('item_requests')->where('id', $request->id)->first();

    //         if (!$itemRequest) {
    //             return redirect()->back()
    //                 ->withInput()
    //                 ->withErrors(['general' => 'Item request not found.']);
    //         }

    //         if ($itemRequest->status != 1) {
    //             return redirect()->back()
    //                 ->withInput()
    //                 ->withErrors(['general' => 'Only accepted requests can be delivered.']);
    //         }

    //         if (!$request->filled('availableQuantity')) {
    //             return redirect()->back()
    //                 ->withInput()
    //                 ->withErrors(['availableQuantity' => 'Delivery quantity is required.']);
    //         }

    //         $deliverQty = (int) $request->availableQuantity;

    //         if ($deliverQty > $itemRequest->quantity) {
    //             return redirect()->back()
    //                 ->withInput()
    //                 ->withErrors(['availableQuantity' => 'Deliver quantity must not exceed requested quantity (' . $itemRequest->quantity . ').']);
    //         }

    //         // Check available store balance
    //         $store = DB::table('items_in_stores')
    //             ->where('itemId', $itemRequest->itemId)
    //             ->where('specificationId', $itemRequest->specificationId)
    //             ->first();

    //         $storeBalance = $store ? $store->remainingQuantity : 0;

    //         if (!$store || $storeBalance < $deliverQty) {
    //             return redirect()->back()
    //                 ->withInput()
    //                 ->withErrors(['availableQuantity' => "Not enough items in store. Remaining: $storeBalance"]);
    //         }

    //         // Update store balance
    //         DB::table('items_in_stores')
    //             ->where('id', $store->id)
    //             ->update([
    //                 'remainingQuantity' => $storeBalance - $deliverQty,
    //                 'updated_at' => now()
    //             ]);

    //         // Mark as delivered
    //         $data['status'] = 3;
    //         $data['deliveredQuantity'] = $deliverQty;
    //     }

    //     DB::table('item_requests')->where('id', $request->id)->update($data);

    //     return redirect()->back()->with('success', 'Item request updated successfully.');
    // }

    public function updateDelivered(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:item_requests,id',
            'action' => 'required|in:accept,reject,deliver',
            'availableQuantity' => 'nullable|integer|min:1',
        ]);

        $data = ['updated_at' => now()];

        // Fetch the item request
        $itemRequest = DB::table('item_requests')->where('id', $request->id)->first();
        if (!$itemRequest) {
            return back()->withErrors(['general' => 'Item request not found.']);
        }

        if ($request->action === 'accept') {
            $data['status'] = 1;
        } elseif ($request->action === 'reject') {
            $data['status'] = 2;
        } elseif ($request->action === 'deliver') {

            // Make sure it's accepted before delivery
            if ($itemRequest->status != 1) {
                return back()->withErrors(['general' => 'Only accepted requests can be delivered.']);
            }

            if (!$request->filled('availableQuantity')) {
                return back()->withErrors(['availableQuantity' => 'Delivery quantity is required.']);
            }

            $deliverQty = (int) $request->availableQuantity;

            if ($deliverQty > $itemRequest->quantity) {
                return back()->withErrors(['availableQuantity' => 'Deliver quantity cannot exceed request quantity (' . $itemRequest->quantity . ').']);
            }

            // Get total available balance for item
            $totalAvailable = DB::table('items_in_stores')
                ->where('itemId', $itemRequest->itemId)
                ->sum('remainingQuantity');

            if ($totalAvailable < $deliverQty) {
                return back()->withErrors(['availableQuantity' => "Insufficient stock. Only $totalAvailable available."]);
            }

            // Reduce quantity from the first available row
            $remaining = $deliverQty;

            $stores = DB::table('items_in_stores')
                ->where('itemId', $itemRequest->itemId)
                ->where('remainingQuantity', '>', 0)
                ->orderBy('id') // FIFO
                ->get();

            foreach ($stores as $store) {
                if ($remaining <= 0) break;

                $deduct = min($store->remainingQuantity, $remaining);

                DB::table('items_in_stores')
                    ->where('id', $store->id)
                    ->update([
                        'remainingQuantity' => $store->remainingQuantity - $deduct,
                        'updated_at' => now(),
                    ]);

                $remaining -= $deduct;
            }

            // Mark request as delivered
            $data['status'] = 3;
            $data['deliveredQuantity'] = $deliverQty;
        }

        DB::table('item_requests')->where('id', $request->id)->update($data);

        return back()->with('success', 'Request successfully updated.');
    }
}
