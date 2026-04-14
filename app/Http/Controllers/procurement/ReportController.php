<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function itemsInStoreReport()
    {
        $items = DB::table('items_in_stores as iis')
            ->join('tblitems as i', 'iis.itemId', '=', 'i.itemID')
            ->leftJoin('tblspecifications as s', 'iis.specificationId', '=', 's.specificationID')
            ->select(
                'iis.id',
                'i.item as item_name',
                's.specification',
                'iis.remainingQuantity',
                'i.status as item_status',
                DB::raw("DATE_FORMAT(iis.updated_at, '%d/%m/%Y') as last_updated") // Removed time format
            )
            ->when(request('search'), function ($query, $search) {
                return $query->where('i.item', 'like', "%$search%")
                    ->orWhere('s.specification', 'like', "%$search%");
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('i.status', $status);
            })
            ->orderBy('i.item')
            ->orderBy('s.specification')
            ->paginate(15);

        return view('procurement.reports.items_in_store', compact('items'));
    }

    public function itemsSummaryReport()
    {
        $items = DB::table('items_in_stores as iis')
            ->join('tblitems as i', 'iis.itemId', '=', 'i.itemID')
            ->leftJoin('tblspecifications as s', 'iis.specificationId', '=', 's.specificationID')
            ->select(
                'i.item as item_name',
                DB::raw('GROUP_CONCAT(DISTINCT s.specification SEPARATOR ", ") as specifications'),
                DB::raw('SUM(iis.remainingQuantity) as total_quantity')
            )
            ->when(request('search'), function ($query, $search) {
                return $query->where('i.item', 'like', "%$search%")
                    ->orWhere('s.specification', 'like', "%$search%");
            })
            ->groupBy('i.item')
            ->orderBy('i.item')
            ->paginate(10);

        return view('procurement.reports.items_summary', compact('items'));
    }
}
