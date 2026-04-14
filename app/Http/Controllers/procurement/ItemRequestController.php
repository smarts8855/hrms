<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ItemRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



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

        // $userDept = DB::table('tbldepartment')->where('id', $user->user_unit)->first();
        $userDept = null;

        if ($user->is_global != 1) {
            $userDept = DB::table('tblper as per')
                ->join('tbldepartment as dept', 'per.departmentID', '=', 'dept.id')
                ->where('UserID', $user->id)
                ->select(
                    'per.ID',
                    'per.departmentID',
                    'dept.department as department'
                )
                ->first();
        }

        // ✅ Filter tblitems by categoryID = 4
        $itemsList = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        return view('procurement.item_request.create', compact('items', 'units', 'itemsList', 'user', 'userDept'));
    }


    public function saveItemRequest(Request $request)
    {

        // dd(56789);
        $request->validate([
            'departmentId'   => 'required|integer',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'itemId'         => 'required|array|min:1',
            'itemId.*'       => 'required|integer|distinct',
            'quantity'       => 'required|array|min:1',
            'quantity.*'     => 'required|integer|min:1',
        ], [
            'departmentId.required' => 'Department is required.',
            'title.required'        => 'Title is required.',
            'itemId.required'       => 'At least one item is required.',
            'itemId.*.required'     => 'Please select an item.',
            'itemId.*.distinct'     => 'Duplicate items are not allowed.',
            'quantity.*.required'   => 'Please enter quantity.',
            'quantity.*.min'        => 'Quantity must be at least 1.',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            $crCode = 'CR-' . date('YmdHis') . rand(10, 99);
            $now = now();

            // save into department_requests
            $requestId = DB::table('department_requests')->insertGetId([
                'departmentId' => $request->departmentId,
                'created_by' => $user->id,
                'title'      => $request->title,
                'description' => $request->description,
                // 'cr_code'    => $crCode,
                'status'     => 0, // await approval
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // prepare item_requests rows
            $itemRows = [];

            foreach ($request->itemId as $index => $itemId) {
                $qty = isset($request->quantity[$index]) ? (int) $request->quantity[$index] : 0;

                if (empty($itemId) || $qty < 1) {
                    continue;
                }

                $itemRows[] = [
                    'requestId'         => $requestId,
                    'departmentId'      => $request->departmentId,
                    'itemId'            => $itemId,
                    'specificationId'   => null,
                    'quantity'          => $qty,
                    'deliveredQuantity' => 0,
                    'recommendedQty'    => 0,
                    'approvedQty'       => 0,
                    'status'            => 0,
                    'createdBy'         => $user->id,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
            }

            if (empty($itemRows)) {
                throw new \Exception('No valid item was provided.');
            }

            DB::table('item_requests')->insert($itemRows);

            DB::commit();

            return redirect()->back()->with('success', 'Item request submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to submit item request. ' . $e->getMessage());
        }
    }


    public function listItemRequests()
    {
        $user = Auth::user();


        $userUserDept = null;

        if ($user->is_global != 1) {
            $userUserDept = DB::table('tblper')->where('UserID', $user->id)->select('ID', 'departmentID')->first();
        }

        $requests = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('item_requests as ir', 'ir.requestId', '=', 'dr.id')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department',
                DB::raw('COUNT(ir.id) as total_items')
            )
            ->groupBy(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name'
            )
            ->when($user->is_global != 1 && $userUserDept, function ($query) use ($userUserDept) {
                $query->where('dr.departmentId', $userUserDept->departmentID);
            })
            ->orderBy('dr.id', 'desc')
            ->get();

        $itemsList = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        return view('procurement.item_request.index', compact('requests', 'itemsList'));
    }


    public function fetchRequestItems($id)
    {
        $requestData = DB::table('department_requests')
            ->where('id', $id)
            ->first();

        if (!$requestData) {
            return response()->json([
                'status' => false,
                'message' => 'Request not found.'
            ], 404);
        }

        $storeSummary = DB::table('items_in_stores')
            ->select(
                'itemId',
                DB::raw('COALESCE(SUM(item_in), 0) as total_item_in'),
                DB::raw('COALESCE(SUM(item_out), 0) as total_item_out'),
                DB::raw('(COALESCE(SUM(item_in), 0) - COALESCE(SUM(item_out), 0)) as quantity_in_store')
            )
            ->groupBy('itemId');

        $pendingRequestSummary = DB::table('item_requests as ir2')
            ->join('department_requests as dr', 'dr.id', '=', 'ir2.requestId')
            ->select(
                'ir2.itemId',
                DB::raw('COALESCE(SUM(ir2.recommendedQty), 0) as quantity_on_ground')
            )
            ->whereIn('dr.status', [2, 3])
            ->where('dr.id', '!=', $id)
            ->groupBy('ir2.itemId');

        $specSummary = DB::table('tblspecifications')
            ->select(
                'itemID',
                DB::raw("GROUP_CONCAT(DISTINCT specification ORDER BY specification SEPARATOR ', ') as specifications")
            )
            ->groupBy('itemID');

        $items = DB::table('item_requests as ir')
            ->leftJoin('tblitems as i', 'i.itemID', '=', 'ir.itemId')
            ->leftJoinSub($specSummary, 'spec', function ($join) {
                $join->on('spec.itemID', '=', 'ir.itemId');
            })
            ->leftJoinSub($storeSummary, 'store', function ($join) {
                $join->on('store.itemId', '=', 'ir.itemId');
            })
            ->leftJoinSub($pendingRequestSummary, 'pending', function ($join) {
                $join->on('pending.itemId', '=', 'ir.itemId');
            })
            ->select(
                'ir.id',
                'ir.requestId',
                'ir.departmentId',
                'ir.itemId',
                'ir.quantity',
                'ir.recommendedQty',
                'ir.approvedQty',
                'ir.deliveredQuantity',
                'ir.status',
                'i.item as item_name',
                'spec.specifications',
                DB::raw('COALESCE(store.quantity_in_store, 0) as quantity_in_store'),
                DB::raw('COALESCE(pending.quantity_on_ground, 0) as quantity_on_ground'),
                DB::raw('(COALESCE(store.quantity_in_store, 0) - COALESCE(pending.quantity_on_ground, 0)) as available_quantity')
            )
            ->where('ir.requestId', $id)
            ->orderBy('ir.id', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'request' => $requestData,
            'items' => $items
        ]);
    }



    public function addRequestItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|integer',
            'itemId' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ], [
            'request_id.required' => 'Request ID is required.',
            'itemId.required' => 'Please select an item.',
            'quantity.required' => 'Please enter quantity.',
            'quantity.min' => 'Quantity must be at least 1.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->first();

        if (!$requestData) {
            return response()->json([
                'status' => false,
                'message' => 'Request not found.'
            ], 404);
        }

        if ((int) $requestData->status !== 0) {
            return response()->json([
                'status' => false,
                'message' => 'Only pending requests can be modified.'
            ], 400);
        }

        $existing = DB::table('item_requests')
            ->where('requestId', $request->request_id)
            ->where('itemId', $request->itemId)
            ->exists();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'This item already exists in the request.'
            ], 400);
        }

        $firstItem = DB::table('item_requests')
            ->where('requestId', $request->request_id)
            ->first();

        if (!$firstItem) {
            return response()->json([
                'status' => false,
                'message' => 'Department could not be resolved for this request.'
            ], 400);
        }

        DB::table('item_requests')->insert([
            'requestId' => $request->request_id,
            'departmentId' => $firstItem->departmentId,
            'itemId' => $request->itemId,
            'specificationId' => null,
            'quantity' => $request->quantity,
            'deliveredQuantity' => 0,
            'recommendedQty' => 0,
            'approvedQty' => 0,
            'status' => 0,
            'createdBy' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Item added successfully.'
        ]);
    }

    public function updateRequestItemQuantity(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = DB::table('item_requests')
            ->where('id', $request->id)
            ->first();

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found.',
            ], 404);
        }

        $parentRequest = DB::table('department_requests')
            ->where('id', $item->requestId)
            ->first();

        if (!$parentRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Department request not found.',
            ], 404);
        }

        if ((int) $parentRequest->status !== 0) {
            return response()->json([
                'status' => false,
                'message' => 'Only pending requests can be updated.',
            ], 422);
        }

        DB::table('item_requests')
            ->where('id', $request->id)
            ->update([
                'quantity' => $request->quantity,
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Quantity updated successfully.',
        ]);
    }

    public function deleteRequestItem(Request $request)
    {
        $item = DB::table('item_requests')->where('id', $request->item_id)->first();


        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found.'
            ], 404);
        }

        $count = DB::table('item_requests')
            ->where('requestId', $item->requestId)
            ->count();

        if ($count <= 1) {
            return response()->json([
                'status' => false,
                'message' => 'At least one item is required.'
            ], 400);
        }

        DB::table('item_requests')->where('id', $request->item_id)->delete();

        $items = DB::table('item_requests as ir')
            ->leftJoin('tblitems as i', 'i.itemID', '=', 'ir.itemId')
            ->select(
                'ir.id',
                'ir.requestId',
                'ir.departmentId',
                'ir.itemId',
                'ir.quantity',
                'ir.status',
                'i.item as item_name'
            )
            ->where('ir.requestId', $item->requestId)
            ->orderBy('ir.id', 'asc')
            ->get();



        // $requestData = DB::table('department_requests')
        //     ->where('id', $id)
        //     ->first();

        return response()->json([
            'status' => true,
            'item' => $item,
            'items' => $items,
            'message' => 'Item removed successfully.'
        ]);
    }


    public function deleteRequest(Request $request)
    {
        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->first();

        if (!$requestData) {
            return response()->json([
                'status' => false,
                'message' => 'Request not found.'
            ], 404);
        }

        if ((int) $requestData->status !== 0) {
            return response()->json([
                'status' => false,
                'message' => 'Only pending requests can be deleted.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            DB::table('item_requests')
                ->where('requestId', $request->request_id)
                ->delete();

            DB::table('department_requests')
                ->where('id', $request->request_id)
                ->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Request deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Unable to delete request.'
            ], 500);
        }
    }


    public function approveItemRequest($id)
    {
        DB::beginTransaction();

        try {
            $requestData = DB::table('department_requests')->where('id', $id)->first();

            if (!$requestData) {
                return redirect()->back()->with('error', 'Request not found.');
            }

            if ((int) $requestData->status === 1) {
                return redirect()->back()->with('error', 'Request already approved.');
            }

            DB::table('department_requests')
                ->where('id', $id)
                ->update([
                    'status' => 1,
                    'updated_at' => now(),
                ]);

            DB::table('item_requests')
                ->where('requestId', $id)
                ->update([
                    'status' => 1,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()->back()->with('success', 'Request approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Approval failed. ' . $e->getMessage());
        }
    }



    public function submittedItemRequestList(Request $request)
    {
        $user = Auth::user();


        $userUserDept = null;

        if ($user->is_global != 1) {
            $userUserDept = DB::table('tblper')
                ->where('UserID', $user->id)
                ->select('ID', 'departmentID')
                ->first();
        }

        // Log::info($userUserDept);
        $requests = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->leftJoin('item_requests as ir', 'ir.requestId', '=', 'dr.id')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department',
                DB::raw('COUNT(ir.id) as total_items')
            )
            ->groupBy(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name'
            )
            ->whereIn('dr.status', [1, 2])
            ->when(($user->is_global != 1 && $userUserDept->departmentID != 28) && $userUserDept, function ($query) use ($userUserDept) {
                $query->where('dr.departmentId', $userUserDept->departmentID);
            })

            // super admin or department 28: filter by selected department
            ->when(
                ($user->is_global == 1 || ($userUserDept && $userUserDept->departmentID == 28)) && $request->filled('departmentId'),
                function ($query) use ($request) {
                    $query->where('dr.departmentId', $request->departmentId);
                }
            )
            ->orderBy('dr.status', 'asc')
            ->get();

        $itemsList = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        $units = DB::table('tbldepartment')->select('id', 'department')->get();


        return view('procurement.item_request.submitted_item_list', compact('requests', 'itemsList', 'userUserDept', 'units', 'user'));
    }



    public function viewSubmittedItemRequest($id)
    {
        $requestData = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department'
            )
            ->where('dr.id', $id)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        $storeSummary = DB::table('items_in_stores')
            ->select(
                'itemId',
                DB::raw('COALESCE(SUM(item_in), 0) as total_item_in'),
                DB::raw('COALESCE(SUM(item_out), 0) as total_item_out'),
                DB::raw('(COALESCE(SUM(item_in), 0) - COALESCE(SUM(item_out), 0)) as quantity_in_store')
            )
            ->groupBy('itemId');

        $pendingRequestSummary = DB::table('item_requests as ir2')
            ->join('department_requests as dr', 'dr.id', '=', 'ir2.requestId')
            ->select(
                'ir2.itemId',
                DB::raw('COALESCE(SUM(ir2.quantity), 0) as requested_quantity'),
                DB::raw('COALESCE(SUM(ir2.recommendedQty), 0) as recommended_quantity')
            )
            ->whereIn('dr.status', [2, 3]) // adjust to your non-issued statuses
            ->where('dr.id', '!=', $id)
            ->groupBy('ir2.itemId');

        $specSummary = DB::table('tblspecifications')
            ->select(
                'itemID',
                DB::raw("GROUP_CONCAT(DISTINCT specification ORDER BY specification SEPARATOR ', ') as specifications")
            )
            ->groupBy('itemID');

        $items = DB::table('item_requests as ir')
            ->leftJoin('tblitems as i', 'i.itemID', '=', 'ir.itemId')
            ->leftJoinSub($specSummary, 'spec', function ($join) {
                $join->on('spec.itemID', '=', 'ir.itemId');
            })
            ->leftJoinSub($storeSummary, 'store', function ($join) {
                $join->on('store.itemId', '=', 'ir.itemId');
            })
            ->leftJoinSub($pendingRequestSummary, 'pending', function ($join) {
                $join->on('pending.itemId', '=', 'ir.itemId');
            })
            ->select(
                'ir.id',
                'ir.requestId',
                'ir.departmentId',
                'ir.itemId',
                'ir.quantity',
                'ir.recommendedQty',
                'ir.approvedQty',
                'ir.deliveredQuantity',
                'ir.status',
                'i.item as item_name',
                'spec.specifications',
                DB::raw('COALESCE(store.quantity_in_store, 0) as quantity_in_store'),
                DB::raw('COALESCE(pending.recommended_quantity, 0) as recommended_quantity'),
                DB::raw('(COALESCE(store.quantity_in_store, 0) - COALESCE(pending.recommended_quantity, 0)) as available_quantity')
            )
            ->where('ir.requestId', $id)
            ->orderBy('ir.id', 'asc')
            ->get();
        return view('procurement.item_request.view_submitted_request', compact('requestData', 'items'));
    }


    public function recommendSubmittedItemRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|integer',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|integer',
            'recommendQty' => 'required|array|min:1',
            'recommendQty.*' => 'required|integer|min:0',
        ]);

        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::beginTransaction();

        try {
            foreach ($request->item_id as $index => $itemId) {
                $recommendQty = (int) ($request->recommendQty[$index] ?? 0);

                $itemRow = DB::table('item_requests')
                    ->where('id', $itemId)
                    ->where('requestId', $request->request_id)
                    ->first();

                if (!$itemRow) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'One of the request items was not found.');
                }

                if ($recommendQty > (int) $itemRow->quantity) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Recommended quantity cannot be greater than requested quantity');
                }

                // total quantity currently in store for this item
                $storeQty = DB::table('items_in_stores')
                    ->where('itemId', $itemRow->itemId)
                    ->selectRaw('COALESCE(SUM(item_in),0) - COALESCE(SUM(item_out),0) as quantity_in_store')
                    ->value('quantity_in_store');

                $storeQty = (int) $storeQty;

                // quantities already recommended on OTHER pending requests
                $pendingRecommendedQty = DB::table('item_requests as ir2')
                    ->join('department_requests as dr', 'dr.id', '=', 'ir2.requestId')
                    ->where('ir2.itemId', $itemRow->itemId)
                    ->where('ir2.requestId', '!=', $request->request_id) // exclude current request
                    ->whereIn('dr.status', [2, 3])
                    ->sum('ir2.recommendedQty');

                $pendingRecommendedQty = (int) $pendingRecommendedQty;

                $availableQty = $storeQty - $pendingRecommendedQty;

                if ($availableQty < 0) {
                    $availableQty = 0;
                }

                if ($recommendQty > $availableQty) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Recommended quantity cannot be greater than available stock. Store Qty: ' . $storeQty .
                                ', Pending Reserved Qty: ' . $pendingRecommendedQty .
                                ', Available Qty: ' . $availableQty . '.'
                        );
                }


                DB::table('item_requests')
                    ->where('id', $itemId)
                    ->where('requestId', $request->request_id)
                    ->update([
                        'recommendedQty' => $recommendQty,
                        'status' => 2,
                        'updated_at' => now(),
                    ]);
            }

            DB::table('department_requests')
                ->where('id', $request->request_id)
                ->update([
                    'status' => 2,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()
                ->route('submitted-item-request-view', $request->request_id)
                ->with('success', 'Request approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to approve request. ' . $e->getMessage());
        }
    }


    public function reopenSubmittedItemRequest(Request $request)
    {
        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::beginTransaction();

        try {
            DB::table('department_requests')
                ->where('id', $request->request_id)
                ->update([
                    'status' => 1,
                    'updated_at' => now(),
                ]);

            DB::table('item_requests')
                ->where('requestId', $request->request_id)
                ->update([
                    'status' => 1,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()
                ->route('submitted-item-request-view', $request->request_id)
                ->with('success', 'Request reopened successfully. You can now edit and update it.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Unable to reopen request. ' . $e->getMessage());
        }
    }


    public function recommendedItemRequestList(Request $request)
    {
        $user = Auth::user();

        $userUserDept = null;

        if ($user->is_global != 1) {
            $userUserDept = DB::table('tblper')
                ->where('UserID', $user->id)
                ->select('ID', 'departmentID')
                ->first();
        }

        // Log::info($userUserDept);
        $requests = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->leftJoin('item_requests as ir', 'ir.requestId', '=', 'dr.id')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department',
                DB::raw('COUNT(ir.id) as total_items')
            )
            ->groupBy(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name'
            )
            ->whereIn('dr.status', [2, 3])
            ->when(($user->is_global != 1 && $userUserDept->departmentID != 28) && $userUserDept, function ($query) use ($userUserDept) {
                $query->where('dr.departmentId', $userUserDept->departmentID);
            })

            // super admin or department 28: filter by selected department
            ->when(
                ($user->is_global == 1 || ($userUserDept && $userUserDept->departmentID == 28)) && $request->filled('departmentId'),
                function ($query) use ($request) {
                    $query->where('dr.departmentId', $request->departmentId);
                }
            )
            ->orderBy('dr.status', 'asc')
            ->get();

        $itemsList = DB::table('tblitems')
            ->where('categoryID', 4)
            ->select('itemID', 'item')
            ->get();

        $units = DB::table('tbldepartment')->select('id', 'department')->get();


        return view('procurement.item_request.recommend_item_list', compact('requests', 'itemsList', 'userUserDept', 'units', 'user'));
    }



    public function viewRecommendItemRequest($id)
    {
        $requestData = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department'
            )
            ->where('dr.id', $id)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        $storeSummary = DB::table('items_in_stores')
            ->select(
                'itemId',
                DB::raw('COALESCE(SUM(item_in), 0) as total_item_in'),
                DB::raw('COALESCE(SUM(item_out), 0) as total_item_out'),
                DB::raw('(COALESCE(SUM(item_in), 0) - COALESCE(SUM(item_out), 0)) as quantity_in_store')
            )
            ->groupBy('itemId');

        $pendingRequestSummary = DB::table('item_requests as ir2')
            ->join('department_requests as dr', 'dr.id', '=', 'ir2.requestId')
            ->select(
                'ir2.itemId',
                DB::raw('COALESCE(SUM(ir2.quantity), 0) as requested_quantity'),
                DB::raw('COALESCE(SUM(ir2.recommendedQty), 0) as recommended_quantity')
            )
            ->whereIn('dr.status', [2, 3]) // adjust to your non-issued statuses
            ->where('dr.id', '!=', $id)
            ->groupBy('ir2.itemId');

        $specSummary = DB::table('tblspecifications')
            ->select(
                'itemID',
                DB::raw("GROUP_CONCAT(DISTINCT specification ORDER BY specification SEPARATOR ', ') as specifications")
            )
            ->groupBy('itemID');

        $items = DB::table('item_requests as ir')
            ->leftJoin('tblitems as i', 'i.itemID', '=', 'ir.itemId')
            ->leftJoinSub($specSummary, 'spec', function ($join) {
                $join->on('spec.itemID', '=', 'ir.itemId');
            })
            ->leftJoinSub($storeSummary, 'store', function ($join) {
                $join->on('store.itemId', '=', 'ir.itemId');
            })
            ->leftJoinSub($pendingRequestSummary, 'pending', function ($join) {
                $join->on('pending.itemId', '=', 'ir.itemId');
            })
            ->select(
                'ir.id',
                'ir.requestId',
                'ir.departmentId',
                'ir.itemId',
                'ir.quantity',
                'ir.recommendedQty',
                'ir.approvedQty',
                'ir.deliveredQuantity',
                'ir.status',
                'i.item as item_name',
                'spec.specifications',
                DB::raw('COALESCE(store.quantity_in_store, 0) as quantity_in_store'),
                DB::raw('COALESCE(pending.recommended_quantity, 0) as recommended_quantity'),
                DB::raw('(COALESCE(store.quantity_in_store, 0) - COALESCE(pending.recommended_quantity, 0)) as available_quantity')
            )
            ->where('ir.requestId', $id)
            ->orderBy('ir.id', 'asc')
            ->get();

        Log::info($items);
        return view('procurement.item_request.view_recommend_request', compact('requestData', 'items'));
    }



    public function approveRecommendSubmittedItemRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|integer',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|integer',
            'approvedQty' => 'required|array|min:1',
            'approvedQty.*' => 'required|integer|min:0',
            'approval_code' => 'required|string|max:255',
        ]);

        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::beginTransaction();

        try {
            foreach ($request->item_id as $index => $itemId) {
                $approvedQty = (int) ($request->approvedQty[$index] ?? 0);

                $itemRow = DB::table('item_requests')
                    ->where('id', $itemId)
                    ->where('requestId', $request->request_id)
                    ->first();

                if (!$itemRow) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'One of the request items was not found.');
                }

                if ($approvedQty > (int) $itemRow->recommendedQty) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Approved quantity cannot be greater than store recommended quantity for item ID ' . $itemId . '.');
                }

                // total quantity currently in store for this item
                $storeQty = DB::table('items_in_stores')
                    ->where('itemId', $itemRow->itemId)
                    ->selectRaw('COALESCE(SUM(item_in),0) - COALESCE(SUM(item_out),0) as quantity_in_store')
                    ->value('quantity_in_store');

                $storeQty = (int) $storeQty;


                // quantities already recommended on OTHER pending requests
                $pendingRecommendedQty = DB::table('item_requests as ir2')
                    ->join('department_requests as dr', 'dr.id', '=', 'ir2.requestId')
                    ->where('ir2.itemId', $itemRow->itemId)
                    ->where('ir2.requestId', '!=', $request->request_id) // exclude current request
                    ->whereIn('dr.status', [2, 3])
                    ->sum('ir2.recommendedQty');

                $pendingRecommendedQty = (int) $pendingRecommendedQty;

                $availableQty = $storeQty - $pendingRecommendedQty;


                if ($availableQty < 0) {
                    $availableQty = 0;
                }

                if ($approvedQty > $availableQty) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Approved quantity cannot be greater than available stock. Store Qty: ' . $storeQty .
                                ', Pending Reserved Qty: ' . $pendingRecommendedQty .
                                ', Available Qty: ' . $availableQty . '.'
                        );
                }

                DB::table('item_requests')
                    ->where('id', $itemId)
                    ->where('requestId', $request->request_id)
                    ->update([
                        'approvedQty' => $approvedQty,
                        'status' => 3,
                        'updated_at' => now(),
                    ]);
            }

            DB::table('department_requests')
                ->where('id', $request->request_id)
                ->update([
                    'cr_code' => $request->approval_code,
                    'status' => 3,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()
                ->route('recommended-item-request-view', $request->request_id)
                ->with('success', 'Request approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to approve request. ' . $e->getMessage());
        }
    }



    public function reopenApproveedRecommendSubmittedItemRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|integer',
        ]);

        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Request not found.');
        }

        DB::beginTransaction();

        try {
            DB::table('department_requests')
                ->where('id', $request->request_id)
                ->update([
                    'status' => 2,
                    'updated_at' => now(),
                ]);

            DB::table('item_requests')
                ->where('requestId', $request->request_id)
                ->update([
                    'status' => 2,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()
                ->route('recommended-item-request-view', $request->request_id)
                ->with('success', 'Approval reopened successfully. You can now edit the approved quantities.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Unable to reopen request. ' . $e->getMessage());
        }
    }


    public function approvedItemRequestList(Request $request)
    {
        $user = Auth::user();

        $userUserDept = null;

        if ($user->is_global != 1) {
            $userUserDept = DB::table('tblper')
                ->where('UserID', $user->id)
                ->select('ID', 'departmentID')
                ->first();
        }

        $requests = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->leftJoin('item_requests as ir', 'ir.requestId', '=', 'dr.id')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department',
                DB::raw('COUNT(ir.id) as total_items'),
                DB::raw('SUM(ir.quantity) as total_requested_qty'),
                DB::raw('SUM(ir.recommendedQty) as total_recommended_qty'),
                DB::raw('SUM(ir.approvedQty) as total_approved_qty')
            )
            ->whereIn('dr.status',  [3, 4])
            ->when(
                $user->is_global != 1 && $userUserDept && $userUserDept->departmentID != 28,
                function ($query) use ($userUserDept) {
                    $query->where('dr.departmentId', $userUserDept->departmentID);
                }
            )
            ->when(
                ($user->is_global == 1 || ($userUserDept && $userUserDept->departmentID == 28)) && $request->filled('departmentId'),
                function ($query) use ($request) {
                    $query->where('dr.departmentId', $request->departmentId);
                }
            )
            ->groupBy(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name',
                'dept.department'
            )
            ->orderBy('dr.id', 'desc')
            ->get();

        $units = DB::table('tbldepartment')
            ->select('id', 'department')
            ->get();

        return view('procurement.item_request.approved_item_request_list', compact(
            'requests',
            'units',
            'user',
            'userUserDept'
        ));
    }


    public function viewApprovedItemRequest($id)
    {
        $user = Auth::user();

        $userUserDept = null;

        if ($user->is_global != 1) {
            $userUserDept = DB::table('tblper')
                ->where('UserID', $user->id)
                ->select('ID', 'departmentID')
                ->first();
        }

        $requestData = DB::table('department_requests as dr')
            ->leftJoin('users as u', 'u.id', '=', 'dr.created_by')
            ->leftJoin('tbldepartment as dept', 'dept.id', '=', 'dr.departmentId')
            ->select(
                'dr.id',
                'dr.title',
                'dr.description',
                'dr.cr_code',
                'dr.status',
                'dr.created_at',
                'u.name as created_by_name',
                'dept.department as department'
            )
            ->where('dr.id', $id)
            ->whereIn('dr.status', [3, 4])
            ->when(
                $user->is_global != 1 && $userUserDept && $userUserDept->departmentID != 28,
                function ($query) use ($userUserDept) {
                    $query->where('dr.departmentId', $userUserDept->departmentID);
                }
            )
            ->first();

        if (!$requestData) {
            return redirect()->route('approved-item-request-list')
                ->with('error', 'Approved request not found.');
        }

        $storeSummary = DB::table('items_in_stores')
            ->select(
                'itemId',
                DB::raw('COALESCE(SUM(item_in), 0) as total_item_in'),
                DB::raw('COALESCE(SUM(item_out), 0) as total_item_out'),
                DB::raw('(COALESCE(SUM(item_in), 0) - COALESCE(SUM(item_out), 0)) as quantity_in_store')
            )
            ->groupBy('itemId');

        $pendingRequestSummary = DB::table('item_requests as ir2')
            ->join('department_requests as dr', 'dr.id', '=', 'ir2.requestId')
            ->select(
                'ir2.itemId',
                DB::raw('COALESCE(SUM(ir2.quantity), 0) as requested_quantity'),
                DB::raw('COALESCE(SUM(ir2.recommendedQty), 0) as recommended_quantity')
            )
            ->whereIn('dr.status', [2, 3]) // adjust to your non-issued statuses
            ->where('dr.id', '!=', $id)
            ->groupBy('ir2.itemId');

        $specSummary = DB::table('tblspecifications')
            ->select(
                'itemID',
                DB::raw("GROUP_CONCAT(DISTINCT specification ORDER BY specification SEPARATOR ', ') as specifications")
            )
            ->groupBy('itemID');


        $items = DB::table('item_requests as ir')
            ->leftJoin('tblitems as i', 'i.itemID', '=', 'ir.itemId')
            ->leftJoinSub($specSummary, 'spec', function ($join) {
                $join->on('spec.itemID', '=', 'ir.itemId');
            })
            ->leftJoinSub($storeSummary, 'store', function ($join) {
                $join->on('store.itemId', '=', 'ir.itemId');
            })
            ->leftJoinSub($pendingRequestSummary, 'pending', function ($join) {
                $join->on('pending.itemId', '=', 'ir.itemId');
            })
            ->select(
                'ir.id',
                'ir.requestId',
                'ir.departmentId',
                'ir.itemId',
                'ir.quantity',
                'ir.recommendedQty',
                'ir.approvedQty',
                'ir.deliveredQuantity',
                'ir.status',
                'i.item as item_name',
                'spec.specifications',
                DB::raw('COALESCE(store.quantity_in_store, 0) as quantity_in_store'),
                DB::raw('COALESCE(pending.recommended_quantity, 0) as recommended_quantity'),
                DB::raw('(COALESCE(store.quantity_in_store, 0) - COALESCE(pending.recommended_quantity, 0)) as available_quantity')
            )
            ->where('ir.requestId', $id)
            ->orderBy('ir.id', 'asc')
            ->get();
        return view('procurement.item_request.view_approved_item_request', compact(
            'requestData',
            'items',
            'user',
            'userUserDept'
        ));
    }


    public function issueApprovedItemRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|integer',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|integer',
            'deliveredQty' => 'required|array|min:1',
            'deliveredQty.*' => 'required|integer|min:0',
        ]);

        $requestData = DB::table('department_requests')
            ->where('id', $request->request_id)
            ->where('status', 3)
            ->first();

        if (!$requestData) {
            return redirect()->back()->with('error', 'Approved request not found.');
        }


        try {
            DB::beginTransaction();

            // dd($request->all());
            $sivNo = generateSivAndSrvNo('siv');

            foreach ($request->item_id as $index => $itemRequestId) {
                $deliveredQty = (int) ($request->deliveredQty[$index] ?? 0);

                $itemRow = DB::table('item_requests')
                    ->where('id', $itemRequestId)
                    ->where('requestId', $request->request_id)
                    ->first();

                if (!$itemRow) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'One of the request items was not found.');
                }

                if ($deliveredQty > (int) $itemRow->approvedQty) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Delivered quantity cannot be greater than CR approved quantity');
                }

                DB::table('item_requests')
                    ->where('id', $itemRequestId)
                    ->where('requestId', $request->request_id)
                    ->update([
                        'deliveredQuantity' => $deliveredQty,
                        'status' => 4,
                        'updated_at' => now(),
                    ]);

                DB::table('items_in_stores')->insert([
                    'siv_no' => $sivNo,
                    'itemId' => $itemRow->itemId,
                    'requestId' => $request->request_id,
                    'dept_id' => $requestData->departmentId,
                    'contractID' => null,
                    'contractorID' => null,
                    'biddingStoreId' => null,
                    'purchaseItemId' => null,
                    'remainingQuantity' => 0,
                    'item_in' => 0,
                    'item_out' => $deliveredQty,
                    'remark' => $request->remark ? $request->remark : 'Issued to department request #' . $request->request_id,
                    'transaction_date' => date('Y-m-d'),
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('department_requests')
                ->where('id', $request->request_id)
                ->update([
                    'status' => 4,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()
                ->route('approved-item-request-view', $request->request_id)
                ->with('success', 'Item issuance completed successfully.');
        } catch (\Exception $e) {

            Log::info($e->getMessage());
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to complete issuance. ' . $e->getMessage());
        }
    }
}
