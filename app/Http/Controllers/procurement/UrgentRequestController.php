<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Auth;

use Illuminate\Http\Request;


class UrgentRequestController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        // Fetch only item requests
        $query = DB::table('item_requests')
            ->join('tbldepartment', 'item_requests.departmentId', '=', 'tbldepartment.id')
            ->join('tblitems', 'item_requests.itemId', '=', 'tblitems.itemID')
            ->join('tblspecifications', 'item_requests.specificationId', '=', 'tblspecifications.specificationID')
            ->leftJoin('users', 'item_requests.createdBy', '=', 'users.id')
            ->select(
                'item_requests.*',
                'tbldepartment.department as departmentName',
                'tblitems.item as itemName',
                'tblspecifications.specification',
                'users.name as createdByName'
            );


        $items = $query->get();

        // Load only necessary dropdown data
        $units = DB::table('tbldepartment')->select('id', 'department')->get();

        $userDept = DB::table('tbldepartment')->where('id', $user->user_unit)->first();

        // ✅ Filter tblitems by categoryID = 4
        $itemsList = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        return view('procurement.Urgent_Request.index', compact('user', 'units', 'itemsList', 'user', 'userDept'));
    }




    public function saveAndDeliverRequest(Request $request)
    {
        $request->validate([
            'departmentId' => 'required|exists:tblunits,unitID',
            'itemId' => 'required|exists:tblitems,itemID',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $quantity = (int) $request->quantity;

        // Get total available balance
        $totalAvailable = DB::table('items_in_stores')
            ->where('itemId', $request->itemId)
            ->sum('remainingQuantity');

        if ($totalAvailable < $quantity) {
            return response()->json([
                'errors' => [
                    'quantity' => ["Insufficient stock. Only $totalAvailable available."]
                ]
            ], 422);
        }

        // Create the request (status = 3 for delivered)
        $requestId = DB::table('item_requests')->insertGetId([
            'departmentId' => $request->departmentId,
            'itemId' => $request->itemId,
            'quantity' => $quantity,
            'status' => 3, // Delivered
            'deliveredQuantity' => $quantity,
            'createdBy' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Deduct from FIFO stock
        $remaining = $quantity;
        $stores = DB::table('items_in_stores')
            ->where('itemId', $request->itemId)
            ->where('remainingQuantity', '>', 0)
            ->orderBy('id')
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

        return response()->json(['message' => 'Item requested and delivered successfully.']);
    }
}
