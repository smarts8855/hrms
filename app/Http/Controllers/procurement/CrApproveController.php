<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class CrApproveController extends Controller
{

    public function index(Request $request)
    {
        // $user = Auth::user();
        $search = $request->input('search');

        // Subquery to get remaining quantity
        $storeSubquery = DB::table('items_in_stores')
            ->selectRaw('itemId, SUM(remainingQuantity) as totalRemaining')
            ->groupBy('itemId');

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
            )
            ->whereIn('item_requests.status', [0, 1, 3])
            ->orderByDesc('item_requests.id');

        // Optional: Only show own records if on CR table
        // if (!in_array($user->user_role, [15])) {
        //     $query->where('item_requests.createdBy', $user->id);
        // }

        // $query->when($user->user_role != 15, function ($q) {
        //     $q->whereRaw('1 = 0');
        // });

        // Filter by search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tbldepartment.department', 'like', "%$search%")
                    ->orWhere('tblitems.item', 'like', "%$search%")
                    ->orWhere('users.name', 'like', "%$search%");
            });
        }

        $items = $query->paginate(10)->appends(['search' => $search]); // Keep search term in pagination links

        return view('procurement.Cr.index', compact('items', 'search'));
    }



    public function requestItemsByDepertment(Request $request)
    {
        $user = Auth::user();

        // Allow only CR (role 15)
        // if ($user->user_role != 15) {
        //     abort(403, 'Unauthorized access');
        // }

        $departmentName = DB::table('tbldepartment')
            ->where('id', $user->user_unit)
            ->value('department');

        $search = $request->input('search');

        $storeSubquery = DB::table('items_in_stores')
            ->selectRaw('itemId, SUM(remainingQuantity) as totalRemaining')
            ->groupBy('itemId');

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
            )
            ->whereIn('item_requests.status', [0, 1, 3])
            ->where('item_requests.departmentId', $user->user_unit)
            ->orderByDesc('item_requests.id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tbldepartment.department', 'like', "%$search%")
                    ->orWhere('tblitems.item', 'like', "%$search%")
                    ->orWhere('users.name', 'like', "%$search%");
            });
        }

        $items = $query->paginate(10)->appends(['search' => $search]);

        return view('procurement.Cr.depertmentRequestItem', compact('items', 'search', 'departmentName'));
    }
}
