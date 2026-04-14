<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Session;
use File;
use Auth;
use DB;

//Budget Items, Category and market_ survey
//Route::get('create-item',               'BudgetItemController@create')->name('createBudgetItem');


class BudgetItemController extends Controller
{
    public function __construct() {}


    public function createItem_11_03_2026()
    {
        $data['getBudgetItem'] = [];
        try {
            $data['getCategory'] = DB::table('tblcategories')->get();

            // Retrieve items - USE CORRECT COLUMN NAME: itemID
            $items = DB::table('tblitems')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblitems.categoryID')
                ->where('tblitems.status', 1)
                ->orderBy('tblitems.itemID', 'desc')  // CHANGED: itemlD -> itemID
                ->select('tblitems.*', 'tblcategories.category')
                ->get();

            // Retrieve all specifications
            $specifications = DB::table('tblspecifications')->get();

            // Group specifications by itemID - USE CORRECT COLUMN NAME: itemID
            $groupedSpecs = [];
            foreach ($specifications as $spec) {
                $groupedSpecs[$spec->itemID][] = $spec;  // CHANGED: itemlD -> itemID
            }

            // Attach specifications to items
            foreach ($items as $item) {
                $item->specifications = $groupedSpecs[$item->itemID] ?? [];  // CHANGED: itemlD -> itemID
                $item->itemID = $item->itemID;  // Keep the ID accessible
            }

            $data['getBudgetItem'] = $items;
            $data['getSpecifications'] = $specifications;

        } catch (\Throwable $e) {
            \Log::error('Create item error: ' . $e->getMessage());
        }

        return view('procurement.BudgetMarket.itemView', $data);
    }


    public function createItem()
    {
        $data['getBudgetItem'] = [];
        try {

            // Normal Categories
            $data['getCategory'] = DB::table('tblcategories')->get();

            // Store Categories (NEW)
            $data['storeCategories'] = DB::table('tblstore_item_category')
                ->where('status', 1)
                ->get();

            // Retrieve items
            $items = DB::table('tblitems')
                ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblitems.categoryID')
                ->leftJoin('tblstore_item_category', 'tblstore_item_category.id', '=', 'tblitems.storeItemCatID')
                ->where('tblitems.status', 1)
                ->orderBy('tblitems.itemID', 'desc')
                ->select(
                    'tblitems.*',
                    'tblcategories.category',
                    'tblstore_item_category.storeItemCat'
                )
                ->get();

            // Retrieve all specifications
            $specifications = DB::table('tblspecifications')->get();

            // Group specifications by itemID
            $groupedSpecs = [];
            foreach ($specifications as $spec) {
                $groupedSpecs[$spec->itemID][] = $spec;
            }

            // Attach specifications to items
            foreach ($items as $item) {
                $item->specifications = $groupedSpecs[$item->itemID] ?? [];
                $item->itemID = $item->itemID;
            }

            $data['getBudgetItem'] = $items;
            $data['getSpecifications'] = $specifications;

        } catch (\Throwable $e) {
            \Log::error('Create item error: ' . $e->getMessage());
        }

        return view('procurement.BudgetMarket.itemView', $data);
    }
    //save item

    public function saveItem1(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
            'budgetItem' => 'required|max:220',
        ]);

        try {
            DB::beginTransaction();
            
            $recordID = $request->input('recordID');

            if ($recordID) {
                // UPDATE existing item
                DB::table('tblitems')
                    ->where('itemID', $recordID)
                    ->update([
                        'categoryID' => $request->input('category'),
                        'item' => $request->input('budgetItem'),
                        'updated_at' => now()
                    ]);
                
                // Get all submitted specifications and their IDs
                $specifications = $request->input('specification', []);
                $specificationIds = $request->input('specificationID', []);
                
                // Get existing specification IDs for this item from database
                $existingSpecs = DB::table('tblspecifications')
                    ->where('itemID', $recordID)
                    ->pluck('specificationID')
                    ->toArray();
                
                $processedIds = [];
                
                // Process each specification
                foreach ($specifications as $index => $spec) {
                    if (!empty(trim($spec))) {
                        $specId = $specificationIds[$index] ?? 'new';
                        
                        if ($specId !== 'new' && is_numeric($specId)) {
                            // Update existing specification
                            DB::table('tblspecifications')
                                ->where('specificationID', $specId)
                                ->update([
                                    'specification' => trim($spec),
                                    'updated_at' => now()
                                ]);
                            $processedIds[] = $specId;
                        } else {
                            // Insert new specification
                            $newSpecId = DB::table('tblspecifications')->insertGetId([
                                'itemID' => $recordID,
                                'specification' => trim($spec),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                            $processedIds[] = $newSpecId;
                        }
                    }
                }
                
                // Delete specifications that were removed (exist in DB but not in processedIds)
                $specsToDelete = array_diff($existingSpecs, $processedIds);
                if (!empty($specsToDelete)) {
                    DB::table('tblspecifications')
                        ->whereIn('specificationID', $specsToDelete)
                        ->delete();
                }
                
                DB::commit();
                return redirect()->back()->with('message', 'Your record was updated successfully.');
                
            } else {
                // CREATE new item
                $recordID = DB::table('tblitems')->insertGetId([
                    'categoryID' => $request->input('category'),
                    'item' => $request->input('budgetItem'),
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Insert specifications for new item
                if ($recordID && $request->has('specification')) {
                    foreach ($request->input('specification') as $spec) {
                        if (!empty(trim($spec))) {
                            DB::table('tblspecifications')->insert([
                                'itemID' => $recordID,
                                'specification' => trim($spec),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }
                
                DB::commit();
                return redirect()->back()->with('message', 'Your record was created successfully.');
            }
            
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Save item error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Sorry, we cannot save your record now. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function saveItem_11_03_2026(Request $request)
    {
        $recordID = $request->input('recordID');
        
        // Define validation rules
        if ($recordID) {
            // For update - unique per category except current record
            $rules = [
                'category' => 'required',
                'budgetItem' => [
                    'required',
                    'max:220',
                    Rule::unique('tblitems', 'item')
                        ->where(function ($query) use ($request) {
                            return $query->where('categoryID', $request->category);
                        })
                        ->ignore($recordID, 'itemID')
                ]
            ];
        } else {
            // For create - unique per category
            $rules = [
                'category' => 'required',
                'budgetItem' => [
                    'required',
                    'max:220',
                    Rule::unique('tblitems', 'item')
                        ->where(function ($query) use ($request) {
                            return $query->where('categoryID', $request->category);
                        })
                ]
            ];
        }
        
        // Custom error messages
        $messages = [
            'budgetItem.unique' => 'The item name ":input" already exists in this category. Please use edit to add additional specification.',
            'budgetItem.required' => 'The item name is required.',
            'budgetItem.max' => 'The item name must not exceed 220 characters.',
            'category.required' => 'Please select a category.',
        ];
        
        // Validate the request
        $this->validate($request, $rules, $messages);

        try {
            DB::beginTransaction();
            
            $categoryID = $request->input('category');
            $itemName = trim($request->input('budgetItem'));

            if ($recordID) {
                // UPDATE existing item
                DB::table('tblitems')
                    ->where('itemID', $recordID)
                    ->update([
                        'categoryID' => $categoryID,
                        'item' => $itemName,
                        'updated_at' => now()
                    ]);
                
                // Handle specifications (same as before)
                $specifications = $request->input('specification', []);
                $specificationIds = $request->input('specificationID', []);
                
                $existingSpecs = DB::table('tblspecifications')
                    ->where('itemID', $recordID)
                    ->pluck('specificationID')
                    ->toArray();
                
                $processedIds = [];
                
                foreach ($specifications as $index => $spec) {
                    if (!empty(trim($spec))) {
                        $specId = $specificationIds[$index] ?? 'new';
                        
                        if ($specId !== 'new' && is_numeric($specId)) {
                            DB::table('tblspecifications')
                                ->where('specificationID', $specId)
                                ->update([
                                    'specification' => trim($spec),
                                    'updated_at' => now()
                                ]);
                            $processedIds[] = $specId;
                        } else {
                            $newSpecId = DB::table('tblspecifications')->insertGetId([
                                'itemID' => $recordID,
                                'specification' => trim($spec),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                            $processedIds[] = $newSpecId;
                        }
                    }
                }
                
                $specsToDelete = array_diff($existingSpecs, $processedIds);
                if (!empty($specsToDelete)) {
                    DB::table('tblspecifications')
                        ->whereIn('specificationID', $specsToDelete)
                        ->delete();
                }
                
                DB::commit();
                return redirect()->back()->with('message', 'Your record was updated successfully.');
                
            } else {
                // CREATE new item
                $recordID = DB::table('tblitems')->insertGetId([
                    'categoryID' => $categoryID,
                    'item' => $itemName,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Insert specifications
                if ($recordID && $request->has('specification')) {
                    foreach ($request->input('specification') as $spec) {
                        if (!empty(trim($spec))) {
                            DB::table('tblspecifications')->insert([
                                'itemID' => $recordID,
                                'specification' => trim($spec),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }
                
                DB::commit();
                return redirect()->back()->with('message', 'Your record was created successfully.');
            }
            
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Save item error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, we cannot save your record now. Please try again. Error: ' . $e->getMessage());
        }
    }



    public function saveItem(Request $request)
    {
        $recordID = $request->input('recordID');

        // Define validation rules
        if ($recordID) {
            // For update
            $rules = [
                'category' => 'required',
                'storeItemCatID' => 'required',
                'budgetItem' => [
                    'required',
                    'max:220',
                    Rule::unique('tblitems', 'item')
                        ->where(function ($query) use ($request) {
                            return $query->where('categoryID', $request->category);
                        })
                        ->ignore($recordID, 'itemID')
                ]
            ];
        } else {
            // For create
            $rules = [
                'category' => 'required',
                'storeItemCatID' => 'required',
                'budgetItem' => [
                    'required',
                    'max:220',
                    Rule::unique('tblitems', 'item')
                        ->where(function ($query) use ($request) {
                            return $query->where('categoryID', $request->category);
                        })
                ]
            ];
        }

        // Custom error messages
        $messages = [
            'budgetItem.unique' => 'The item name ":input" already exists in this category. Please use edit to add additional specification.',
            'budgetItem.required' => 'The item name is required.',
            'budgetItem.max' => 'The item name must not exceed 220 characters.',
            'category.required' => 'Please select a category.',
            'storeItemCatID.required' => 'Please select a store category.'
        ];

        $this->validate($request, $rules, $messages);

        try {

            DB::beginTransaction();

            $categoryID = $request->input('category');
            $storeItemCatID = $request->input('storeItemCatID');
            $itemName = trim($request->input('budgetItem'));

            if ($recordID) {

                // UPDATE ITEM
                DB::table('tblitems')
                    ->where('itemID', $recordID)
                    ->update([
                        'categoryID' => $categoryID,
                        'storeItemCatID' => $storeItemCatID,
                        'item' => $itemName,
                        'updated_at' => now()
                    ]);

                // Handle specifications
                $specifications = $request->input('specification', []);
                $specificationIds = $request->input('specificationID', []);

                $existingSpecs = DB::table('tblspecifications')
                    ->where('itemID', $recordID)
                    ->pluck('specificationID')
                    ->toArray();

                $processedIds = [];

                foreach ($specifications as $index => $spec) {

                    if (!empty(trim($spec))) {

                        $specId = $specificationIds[$index] ?? 'new';

                        if ($specId !== 'new' && is_numeric($specId)) {

                            DB::table('tblspecifications')
                                ->where('specificationID', $specId)
                                ->update([
                                    'specification' => trim($spec),
                                    'updated_at' => now()
                                ]);

                            $processedIds[] = $specId;

                        } else {

                            $newSpecId = DB::table('tblspecifications')->insertGetId([
                                'itemID' => $recordID,
                                'specification' => trim($spec),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);

                            $processedIds[] = $newSpecId;
                        }
                    }
                }

                // Delete removed specs
                $specsToDelete = array_diff($existingSpecs, $processedIds);

                if (!empty($specsToDelete)) {
                    DB::table('tblspecifications')
                        ->whereIn('specificationID', $specsToDelete)
                        ->delete();
                }

                DB::commit();

                return redirect()->back()->with('message', 'Your record was updated successfully.');

            } else {

                // CREATE NEW ITEM
                $recordID = DB::table('tblitems')->insertGetId([
                    'categoryID' => $categoryID,
                    'storeItemCatID' => $storeItemCatID,
                    'item' => $itemName,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Insert specifications
                if ($recordID && $request->has('specification')) {

                    foreach ($request->input('specification') as $spec) {

                        if (!empty(trim($spec))) {

                            DB::table('tblspecifications')->insert([
                                'itemID' => $recordID,
                                'specification' => trim($spec),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }

                DB::commit();

                return redirect()->back()->with('message', 'Your record was created successfully.');
            }

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error('Save item error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, we cannot save your record now. Please try again.');
        }
    }

    public function itemSpecification()
    {
        $data['getBudgetItem'] = DB::table('tblitems')->get();
        
        // Get all specifications with item details
        $specifications = DB::table('tblspecifications')
            ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblspecifications.itemID')
            ->orderBy('tblitems.item')
            ->orderBy('tblspecifications.specification')
            ->get();
        
        // Group specifications by item
        $groupedList = [];
        foreach ($specifications as $spec) {
            $itemName = $spec->item;
            if (!isset($groupedList[$itemName])) {
                $groupedList[$itemName] = [
                    'itemID' => $spec->itemID,
                    'item' => $itemName,
                    'specifications' => []
                ];
            }
            $groupedList[$itemName]['specifications'][] = $spec;
        }
        
        $data['getGroupedList'] = $groupedList;
        $data['getTotalSpecifications'] = count($specifications);
        
        //dd($data['getGroupedList']);
        return view('procurement.BudgetMarket.add-item-specifcation', $data);
    }

    public function saveItemSpecification(Request $request)
    {
        //dd($request->all());
        
        // Correct validation rules
        $this->validate($request, [
            'item' => 'required|exists:tblitems,itemID', // Check if item exists in tblitems table
            'specification' => 'required|array|min:1',
            'specification.*' => 'required|string|max:220'
        ]);

        try {
            $recordID = $request->input('recordID');
            $itemID = $request->input('item');
            $specifications = $request->input('specification');
            
            if ($recordID) {
                // Update existing specification
                $success = DB::table('tblspecifications')
                    ->where('specificationID', $recordID)
                    ->update([
                        'itemID' => $itemID,
                        'specification' => $specifications[0] // Get first specification for update
                    ]);
                    
                if ($success) {
                    return redirect()->back()->with('message', 'Your record was updated successfully.');
                }
            } else {
                // Create new specifications
                $successCount = 0;
                foreach ($specifications as $item) {
                    if (!empty($item)) {
                        $inserted = DB::table('tblspecifications')->insert([
                            'itemID' => $itemID,
                            'specification' => $item,
                        ]);
                        if ($inserted) {
                            $successCount++;
                        }
                    }
                }
                
                if ($successCount > 0) {
                    return redirect()->back()->with('message', $successCount . ' specification(s) were created successfully.');
                }
            }
        } catch (\Throwable $e) {
            // Log the error for debugging
            \Log::error('Error in saveItemSpecification: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'Sorry, we cannot create your record now. Please try again.');
    }

    public function updateItemSpecification(Request $request)
{
    try {
        $itemID = $request->input('item');
        $specifications = $request->input('specification'); // This is an array
        $specificationIds = $request->input('specification_id', []); // Optional: if you want to track which ones to update vs delete
        
        // Begin transaction
        DB::beginTransaction();
        
        // Delete ALL existing specifications for this item
        DB::table('tblspecifications')
            ->where('itemID', $itemID)
            ->delete();
        
        // Insert all the new specifications from the form
        foreach ($specifications as $spec) {
            if (!empty(trim($spec))) {
                DB::table('tblspecifications')->insert([
                    'itemID' => $itemID,
                    'specification' => trim($spec),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
        DB::commit();
        
        return back()->with('msg', 'Specifications updated successfully');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error updating specifications: ' . $e->getMessage());
    }
}

    public function deleteItemSpecification($id)
    {
        //dd($id);
        if (DB::table('tblmarket_survey')->where('specificationID', base64_decode($id))->exists()) {
            return back()->with('error', 'Cannot delete. Record is in used!');
        }
        DB::table('tblspecifications')->where('specificationID', base64_decode($id))->delete();

        return back()->with('msg', 'Successfully deleted!');
    }

    //Delete category
    public function deleteItem($itemID = null)
    {
        $itemID = base64_decode($itemID);
        if ($itemID && !DB::table('tblmarket_survey')->where('items', $itemID)->first()) {
            $success = null;
            try {
                $success = DB::table('tblspecifications')->where('itemID', $itemID)->delete();
            } catch (\Throwable $e) {
            }
            if ($success) {
                return redirect()->back()->with('message', 'Your record was deleted successfully.');
            }
        }
        return redirect()->back()->with('error', 'Sorry, we are unable to delete your record/ record is in used. Please try again.');
    }

    //create item page
    public function getAllNeeds()
    {
        $data['getBudgetItem'] = [];
        try {
            $data['getBudgetItem'] =  DB::table('tblitems')->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblitems.categoryID')->where('tblitems.status', 1)->orderby('itemID', 'desc')->get();
            $data['getCategory'] =  DB::table('tblcategories')->get();
        } catch (\Throwable $e) {
        }

        return view('procurement.BudgetMarket.itemView', $data);
    }

    // Add this new function to get specifications for an item
    public function getItemSpecifications($itemID)
    {
        $specifications = DB::table('tblspecifications')
            ->where('itemID', $itemID)
            ->get();
        
        return response()->json($specifications);
    }

    public function checkDuplicate(Request $request)
    {
        $exists = DB::table('tblitems')
            ->where('item', trim($request->item))
            ->where('categoryID', $request->category)
            ->where('status', 1)
            ->exists();
        
        return response()->json(['exists' => $exists]);
    }
}//end class
