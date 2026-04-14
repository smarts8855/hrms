<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BinCardController extends Controller
{
    public function index(Request $request)
    {
        // Fetch items from tblitems for the dropdown
        $items = DB::table('tblitems')
            ->select('itemID', 'item')
            ->where('status', 1)
            ->orderBy('item')
            ->get();

        // Get selected item from request
        $selectedItemId = $request->input('item_id');
        $selectedItemName = $request->input('item_name');
        
        // Initialize entries array
        $entries = [];
        $runningBalance = 0;
        
        // Get the selected item name from database if we have ID but no name
        if ($selectedItemId && !$selectedItemName) {
            $item = DB::table('tblitems')
                ->where('itemID', $selectedItemId)
                ->first();
            $selectedItemName = $item ? $item->item : null;
        }
        
        // Get specifications for the selected item
        $specifications = [];
        $selectedItemSpecifications = '';
        
        if ($selectedItemId) {
            // Fetch all specifications for the selected item
            $specifications = DB::table('tblspecifications')
                ->where('itemID', $selectedItemId)
                ->pluck('specification')
                ->toArray();
            
            // Format specifications as comma-separated string
            if (!empty($specifications)) {
                $selectedItemSpecifications = ' (' . implode(', ', $specifications) . ')';
            }
        }
        
        // If an item is selected, fetch data from items_in_stores
        if ($selectedItemId) {
            // Fetch all transactions for the selected item with correct column names
            $transactions = DB::table('items_in_stores as iis')
                ->leftJoin('tblcontractor_registration as cr', 'iis.contractorID', '=', 'cr.contractor_registrationID')
                ->leftJoin('tblitems as i', 'iis.itemId', '=', 'i.itemID')
                ->leftJoin('tbldepartment as d', 'iis.dept_id', '=', 'd.id')
                ->leftJoin('tblspecifications as ts', 'iis.specificationId', '=', 'ts.specificationID')
                ->where('iis.itemId', $selectedItemId)
                ->orderBy('iis.transaction_date', 'asc') // Changed to order by transaction_date
                ->select(
                    'iis.*',
                    'cr.company_name',
                    'd.department as department_name',
                    'i.item as item_name',
                    'ts.specification'
                )
                ->get();
            
            // Calculate running balance and format entries
            foreach ($transactions as $trans) {
                $runningBalance += ($trans->item_in - $trans->item_out);
                
                // Determine movement display based on item_out value
                $movementDisplay = '';
                $movementType = '';
                
                if ($trans->item_out > 0) {
                    // If item_out has value, display department
                    $movementDisplay = $trans->department_name ?? 'Department';
                    $movementType = 'department';
                } else {
                    // Otherwise display contractor
                    $movementDisplay = $trans->company_name ?? 'N/A';
                    $movementType = 'contractor';
                }
                
                // Determine reference number based on transaction type
                $referenceNumber = '';
                if ($trans->item_in > 0 && $trans->srv_no) {
                    // This is a receipt (incoming) - use SRV No
                    $referenceNumber = $trans->srv_no;
                } elseif ($trans->item_out > 0 && $trans->siv_no) {
                    // This is an issue (outgoing) - use SIV No
                    $referenceNumber = $trans->siv_no;
                } else {
                    // Fallback to remark if no SRV/SIV
                    $referenceNumber = $trans->remark ?? 'N/A';
                }
                
                // Add specification to reference if available
                if ($trans->specification) {
                    $referenceNumber .= ' [' . $trans->specification . ']';
                }
                
                $entries[] = [
                    'date' => date('d/m/y', strtotime($trans->transaction_date)), 
                    'reference' => $referenceNumber,
                    'movement' => $movementDisplay,
                    'movement_type' => $movementType,
                    'received' => $trans->item_in,
                    'issued' => $trans->item_out,
                    'balance' => $runningBalance,
                    'signature' => '' // Empty signature field
                ];
            }
        }

        // Bin card metadata
        $binCardData = [
            'store' => '14 (Rev)',
            'product' => $selectedItemName ?? '',
            'product_with_specs' => ($selectedItemName ?? '') . $selectedItemSpecifications,
            'product_id' => $selectedItemId,
            'specifications' => $specifications,
            'entries' => $entries,
        ];

        return view('procurement.store.bin-card', compact('binCardData', 'items'));
    }

    public function getItems()
    {
        $items = DB::table('tblitems')
            ->select('itemID', 'item')
            ->where('status', 1)
            ->orderBy('item')
            ->get();
        
        return response()->json($items);
    }


    public function indexItemInStoreCategory(Request $request)
    {
        // Fetch store item categories for the dropdown
        $categories = DB::table('tblstore_item_category')
            ->select('id', 'storeItemCat')
            ->where('status', 1)
            ->orderBy('storeItemCat')
            ->get();

        // Get selected category from request
        $selectedCategoryId = $request->input('category_id');
        $selectedCategoryName = $request->input('category_name');
        
        // Initialize entries array
        $entries = [];
        $items = [];
        $runningBalance = 0;
        
        // Get the selected category name from database if we have ID but no name
        if ($selectedCategoryId && !$selectedCategoryName) {
            $category = DB::table('tblstore_item_category')
                ->where('id', $selectedCategoryId)
                ->first();
            $selectedCategoryName = $category ? $category->storeItemCat : null;
        }
        
        // If a category is selected, fetch items and their balances from items_in_stores
        if ($selectedCategoryId) {
            // First, get all items in this category
            $itemsInCategory = DB::table('tblitems')
                ->where('storeItemCatID', $selectedCategoryId)
                ->where('status', 1)
                ->pluck('itemID');
            
            if ($itemsInCategory->isNotEmpty()) {
                // Fetch all transactions for items in this category
                $transactions = DB::table('items_in_stores as iis')
                    ->leftJoin('tblcontractor_registration as cr', 'iis.contractorID', '=', 'cr.contractor_registrationID')
                    ->leftJoin('tblitems as i', 'iis.itemId', '=', 'i.itemID')
                    ->leftJoin('tbldepartment as d', 'iis.dept_id', '=', 'd.id')
                    ->whereIn('iis.itemId', $itemsInCategory)
                    ->orderBy('iis.itemId')
                    ->orderBy('iis.created_at', 'asc')
                    ->select(
                        'iis.*',
                        'cr.company_name',
                        'd.department as department_name',
                        'i.item as item_name',
                        'i.storeItemCatID'
                    )
                    ->get();
                
                // Group transactions by item and calculate running balance for each
                $groupedTransactions = $transactions->groupBy('itemId');
                
                foreach ($groupedTransactions as $itemId => $itemTransactions) {
                    $itemRunningBalance = 0;
                    $itemName = $itemTransactions->first()->item_name ?? 'Unknown Item';
                    
                    foreach ($itemTransactions as $trans) {
                        $itemRunningBalance += ($trans->item_in - $trans->item_out);
                        
                        // Determine movement display based on item_out value
                        $movementDisplay = '';
                        $movementType = '';
                        
                        if ($trans->item_out > 0) {
                            // If item_out has value, display department
                            $movementDisplay = $trans->department_name ?? 'Department';
                            $movementType = 'department';
                        } else {
                            // Otherwise display contractor
                            $movementDisplay = $trans->company_name ?? 'N/A';
                            $movementType = 'contractor';
                        }
                        
                        $entries[] = [
                            'item_name' => $itemName,
                            'item_id' => $itemId,
                            'date' => date('d/m/y', strtotime($trans->transaction_date)), 
                            'movement' => $movementDisplay,
                            'movement_type' => $movementType,
                            'received' => $trans->item_in,
                            'issued' => $trans->item_out,
                            'balance' => $itemRunningBalance,
                            'signature' => ''
                        ];
                    }
                    
                    // Also store the current balance for each item
                    $items[] = [
                        'item_id' => $itemId,
                        'item_name' => $itemName,
                        'current_balance' => $itemRunningBalance
                    ];
                }
            }
        }

        // Bin card metadata
        $binCardData = [
            'store' => '14 (Rev)',
            'category' => $selectedCategoryName ?? '',
            'category_id' => $selectedCategoryId,
            'unit_of_issue' => 'PCS',
            'ledger_folio' => 'LF-001',
            'pack' => '1',
            'minimum_stock' => '2',
            'dpl_pwo' => '2824 M 36',
            'entries' => $entries,
            'items' => $items,
            'footer' => '05/02/24 00.62.40 SD SAN'
        ];

        return view('procurement.store.item-in-store-category', compact('binCardData', 'categories'));
    }
}