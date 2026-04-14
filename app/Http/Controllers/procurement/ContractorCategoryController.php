<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ContractorCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = DB::table('tblcontractor_category')
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        
        $getCategory = DB::table('tblcontractor_category')
                        ->orderBy('category', 'asc')
                        ->get();
        
        return view('procurement.Procurement.categories.index', compact('categories', 'getCategory'));
    }

    /**
     * Store categories (single or multiple).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|string|max:255|distinct',
        ], [
            'categories.required' => 'At least one category is required.',
            'categories.*.required' => 'Category field cannot be empty.',
            'categories.*.distinct' => 'Duplicate categories are not allowed in the same submission.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Please fix the validation errors.');
        }

        $now = now();
        $inserted = 0;
        $skipped = 0;
        $duplicates = [];

        foreach ($request->categories as $categoryName) {
            $categoryName = trim($categoryName);
            if (empty($categoryName)) {
                continue;
            }

            // Check if category already exists
            $exists = DB::table('tblcontractor_category')
                        ->where('category', $categoryName)
                        ->exists();

            if (!$exists) {
                DB::table('tblcontractor_category')->insert([
                    'category' => $categoryName,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                $inserted++;
            } else {
                $skipped++;
                $duplicates[] = $categoryName;
            }
        }

        if ($inserted > 0) {
            $message = "{$inserted} categor" . ($inserted > 1 ? 'ies' : 'y') . " created successfully.";
            if ($skipped > 0) {
                $message .= " {$skipped} categor" . ($skipped > 1 ? 'ies' : 'y') . " skipped (already exist): " . implode(', ', $duplicates);
            }
            return redirect()->route('categories.index')->with('message', $message);
        } else {
            return redirect()->route('categories.index')->with('error', 'No new categories were added. All categories already exist.');
        }
    }

    /**
     * Check for duplicate category
     */
    public function checkDuplicate(Request $request)
    {
        $category = trim($request->category);
        
        $exists = DB::table('tblcontractor_category')
                    ->where('category', $category)
                    ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    /**
     * Show the form for editing a category.
     */
    public function edit($id)
    {
        $category = DB::table('tblcontractor_category')
                      ->where('id', $id)
                      ->first();

        if (!$category) {
            return redirect()->route('categories.index')
                            ->with('error', 'Category not found.');
        }

        $categories = DB::table('tblcontractor_category')
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        
        $getCategory = DB::table('tblcontractor_category')
                        ->orderBy('category', 'asc')
                        ->get();

        return view('procurement.Procurement.categories.index', compact('category', 'categories', 'getCategory'));
    }

    /**
     * Update a category.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255|unique:tblcontractor_category,category,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Please fix the validation errors.');
        }

        $updated = DB::table('tblcontractor_category')
                     ->where('id', $id)
                     ->update([
                         'category' => trim($request->category),
                         'updated_at' => now()
                     ]);

        if ($updated) {
            return redirect()->route('categories.index')
                            ->with('message', 'Category updated successfully.');
        }

        return redirect()->route('categories.index')
                        ->with('error', 'Failed to update category.');
    }

    /**
     * Delete a category.
     */
    public function destroy($id)
    {
        // OPTION 1: If you're not sure about foreign key relationship, 
        // just delete without checking (simple approach)
        $deleted = DB::table('tblcontractor_category')
                     ->where('id', $id)
                     ->delete();

        if ($deleted) {
            return redirect()->route('categories.index')
                            ->with('message', 'Category deleted successfully.');
        }

        return redirect()->route('categories.index')
                        ->with('error', 'Failed to delete category.');

        /* 
        // OPTION 2: If you know the correct foreign key column name
        // Replace 'contractor_category_id' with the actual column name in your tblcontractor table
        
        $isUsed = DB::table('tblcontractor')
                    ->where('contractor_category_id', $id) // Change this column name
                    ->exists();

        if ($isUsed) {
            return redirect()->route('categories.index')
                            ->with('error', 'Cannot delete category because it is being used by contractors.');
        }

        $deleted = DB::table('tblcontractor_category')
                     ->where('id', $id)
                     ->delete();

        if ($deleted) {
            return redirect()->route('categories.index')
                            ->with('message', 'Category deleted successfully.');
        }

        return redirect()->route('categories.index')
                        ->with('error', 'Failed to delete category.');
        */
    }
}