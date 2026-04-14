<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ThresholdController extends Controller
{
    /**
     * Display a listing of the thresholds.
     */
    public function index()
    {
        // Fetch all thresholds with contract category information
        $thresholds = DB::table('threshold')
            ->leftJoin('protblcontract_category', 'threshold.contractCategoryID', '=', 'protblcontract_category.contractCategoryID')
            ->select(
                'threshold.*',
                'protblcontract_category.category_name',
                'protblcontract_category.contractCategoryID as category_id'
            )
            ->orderBy('threshold.id')
            ->get();
        
        // Fetch all contract categories for the dropdown
        $contractCategories = DB::table('protblcontract_category')
            ->where('status', 1) // Only active categories
            ->orderBy('category_name')
            ->get();
        
        return view('procurement.thresholds.index', compact('thresholds', 'contractCategories'));
    }

    /**
     * Get threshold data for editing (AJAX request for modal)
     */
    public function edit($id)
    {
        // Fetch threshold by ID with contract category
        $threshold = DB::table('threshold')
            ->where('id', $id)
            ->first();
        
        // Check if threshold exists
        if (!$threshold) {
            return response()->json([
                'success' => false,
                'message' => 'Threshold not found!'
            ], 404);
        }
        
        // Fetch contract category name
        $category = DB::table('protblcontract_category')
            ->where('contractCategoryID', $threshold->contractCategoryID)
            ->first();
        
        // Add category name to the response
        $threshold->category_name = $category ? $category->category_name : null;
        
        return response()->json([
            'success' => true,
            'data' => $threshold
        ]);
    }

    /**
     * Update the specified threshold in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'contractCategoryID' => 'required|integer|exists:protblcontract_category,contractCategoryID',
            'role' => 'required|string|max:255',
            'min' => 'required|integer|min:0',
            'max' => 'required|integer|min:0',
        ]);

        // Check if min is less than max
        if ($request->min >= $request->max) {
            return response()->json([
                'success' => false,
                'errors' => ['max' => 'The maximum value must be greater than the minimum value.']
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if threshold exists
        $exists = DB::table('threshold')
            ->where('id', $id)
            ->exists();
            
        if (!$exists) {
            return response()->json([
                'success' => false,
                'message' => 'Threshold not found!'
            ], 404);
        }

        // Update the threshold
        DB::table('threshold')
            ->where('id', $id)
            ->update([
                'contractCategoryID' => $request->contractCategoryID,
                'role' => $request->role,
                'min' => $request->min,
                'max' => $request->max,
                'updated_at' => now()
            ]);

        // Fetch the updated record with category
        $updatedThreshold = DB::table('threshold')
            ->leftJoin('protblcontract_category', 'threshold.contractCategoryID', '=', 'protblcontract_category.contractCategoryID')
            ->select(
                'threshold.*',
                'protblcontract_category.category_name'
            )
            ->where('threshold.id', $id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Threshold updated successfully!',
            'data' => $updatedThreshold
        ]);
    }

    /**
     * Remove the specified threshold from storage.
     */
    public function destroy($id)
    {
        // Check if threshold exists
        $exists = DB::table('threshold')
            ->where('id', $id)
            ->exists();
            
        if (!$exists) {
            return response()->json([
                'success' => false,
                'message' => 'Threshold not found!'
            ], 404);
        }

        // Delete threshold
        DB::table('threshold')
            ->where('id', $id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Threshold deleted successfully!'
        ]);
    }

    /**
     * Store a newly created threshold in storage.
     */
    public function store1(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'contractCategoryID' => 'required|integer|exists:protblcontract_category,contractCategoryID',
            'role' => 'required|string|max:255',
            'min' => 'required|integer|min:0',
            'max' => 'required|integer|min:0',
        ]);

        // Check if min is less than max
        if ($request->min >= $request->max) {
            return response()->json([
                'success' => false,
                'errors' => ['max' => 'The maximum value must be greater than the minimum value.']
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if threshold with same category and role already exists
        $exists = DB::table('threshold')
            ->where('contractCategoryID', $request->contractCategoryID)
            ->where('role', $request->role)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'errors' => ['role' => 'A threshold with this role already exists for the selected category.']
            ], 422);
        }

        // Insert new threshold
        $id = DB::table('threshold')->insertGetId([
            'contractCategoryID' => $request->contractCategoryID,
            'role' => $request->role,
            'min' => $request->min,
            'max' => $request->max,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Fetch the created record with category
        $newThreshold = DB::table('threshold')
            ->leftJoin('protblcontract_category', 'threshold.contractCategoryID', '=', 'protblcontract_category.contractCategoryID')
            ->select(
                'threshold.*',
                'protblcontract_category.category_name'
            )
            ->where('threshold.id', $id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Threshold created successfully!',
            'data' => $newThreshold
        ]);
    }

    /**
 * Store a newly created threshold in storage.
 */
public function store(Request $request)
{
    try {
        // Log the incoming request data
        \Log::info('Store threshold request:', $request->all());

        // Validate input
        $validator = Validator::make($request->all(), [
            'contractCategoryID' => 'required|integer',
            'role' => 'required|string|max:255',
            'min' => 'required|integer|min:0',
            'max' => 'required|integer|min:0',
        ]);

        // Check if min is less than max
        if ($request->min >= $request->max) {
            return response()->json([
                'success' => false,
                'errors' => ['max' => 'The maximum value must be greater than the minimum value.']
            ], 422);
        }

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if threshold with same category and role already exists
        $exists = DB::table('threshold')
            ->where('contractCategoryID', $request->contractCategoryID)
            ->where('role', $request->role)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'errors' => ['role' => 'A threshold with this role already exists for the selected category.']
            ], 422);
        }

        // Insert new threshold
        $id = DB::table('threshold')->insertGetId([
            'contractCategoryID' => $request->contractCategoryID,
            'role' => $request->role,
            'min' => $request->min,
            'max' => $request->max,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        \Log::info('Threshold created with ID: ' . $id);

        // Fetch the created record
        $newThreshold = DB::table('threshold')
            ->where('id', $id)
            ->first();

        // Try to get category name
        try {
            $category = DB::table('protblcontract_category')
                ->where('contractCategoryID', $newThreshold->contractCategoryID)
                ->first();
            $newThreshold->category_name = $category ? $category->category_name : null;
        } catch (\Exception $e) {
            \Log::error('Error fetching category: ' . $e->getMessage());
            $newThreshold->category_name = null;
        }

        return response()->json([
            'success' => true,
            'message' => 'Threshold created successfully!',
            'data' => $newThreshold
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in store method: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}
}