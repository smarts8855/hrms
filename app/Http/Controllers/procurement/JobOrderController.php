<?php
// app/Http/Controllers/JobOrderController.php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class JobOrderController extends Controller
{
    /**
     * Display a listing of job orders
     */
    public function index()
    {
        $jobOrders = DB::table('tbl_job_orders')
            ->leftJoin('users', 'tbl_job_orders.created_by', '=', 'users.id')
            ->select(
                'tbl_job_orders.*',
                'users.name as created_by_name'
            )
            ->orderBy('tbl_job_orders.created_at', 'desc')
            ->paginate(15);

        return view('procurement.Procurement.job_order.index', compact('jobOrders'));
    }

    /**
     * Show form to create new job order
     */
    public function create()
    {
        // Generate job order number
        $year = date('Y');
        $month = date('m');
        $lastJob = DB::table('tbl_job_orders')
            ->whereYear('created_at', $year)
            ->orderBy('job_order_id', 'desc')
            ->first();
        
        $sequence = $lastJob ? intval(substr($lastJob->job_order_number, -4)) + 1 : 1;
        $jobOrderNumber = 'JO/' . $year . '/' . $month . '/' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        return view('procurement.Procurement.job_order.create', compact('jobOrderNumber'));
    }

    /**
     * Store a new job order
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_order_no' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'station' => 'nullable|string|max:255',
            'order_date' => 'required|date',
            'item_description' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Generate job order number if not provided
            $jobOrderNumber = $request->job_order_number ?? $this->generateJobOrderNumber();

            $jobOrderId = DB::table('tbl_job_orders')->insertGetId([
                'job_order_number' => $jobOrderNumber,
                'job_order_no' => $request->job_order_no,
                'department' => $request->department,
                'station' => $request->station,
                'order_date' => $request->order_date,
                'item_description' => $request->item_description,
                'estimated_cost' => $request->estimated_cost,
                'amount_in_words' => $request->amount_in_words,
                'status' => 'draft',
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->route('job-order.show', $jobOrderId)
                ->with('success', 'Job Order created successfully. Number: ' . $jobOrderNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Job Order creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create Job Order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified job order
     */
    public function show($id)
    {
        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        $creator = DB::table('users')->where('id', $jobOrder->created_by)->first();

        return view('procurement.Procurement.job_order.show', compact('jobOrder', 'creator'));
    }

    /**
     * Show form to edit job order
     */
    public function edit($id)
    {
        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        if ($jobOrder->status != 'draft') {
            return redirect()->route('job-order.show', $id)->with('error', 'Only draft Job Orders can be edited');
        }

        return view('procurement.Procurement.job_order.edit', compact('jobOrder'));
    }

    /**
     * Update job order
     */
    public function update(Request $request, $id)
    {
        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        if ($jobOrder->status != 'draft') {
            return redirect()->back()->with('error', 'Only draft Job Orders can be updated');
        }

        $request->validate([
            'job_order_no' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'station' => 'nullable|string|max:255',
            'order_date' => 'required|date',
            'item_description' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string',
        ]);

        try {
            DB::table('tbl_job_orders')
                ->where('job_order_id', $id)
                ->update([
                    'job_order_no' => $request->job_order_no,
                    'department' => $request->department,
                    'station' => $request->station,
                    'order_date' => $request->order_date,
                    'item_description' => $request->item_description,
                    'estimated_cost' => $request->estimated_cost,
                    'amount_in_words' => $request->amount_in_words,
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);

            return redirect()->route('job-order.show', $id)
                ->with('success', 'Job Order updated successfully');

        } catch (\Exception $e) {
            Log::error('Job Order update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update Job Order: ' . $e->getMessage());
        }
    }

    /**
     * Issue job order (change from draft to issued)
     */
    public function issue($id)
    {
        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        if ($jobOrder->status != 'draft') {
            return redirect()->back()->with('error', 'Job Order can only be issued from draft status');
        }

        DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->update([
                'status' => 'issued',
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);

        return redirect()->route('job-order.show', $id)
            ->with('success', 'Job Order issued successfully');
    }

    /**
     * Complete job order (certify work done)
     */
    public function complete(Request $request, $id)
    {
        $request->validate([
            'certifying_officer' => 'required|string|max:255',
            'officer_rank' => 'required|string|max:255',
            'certifying_date' => 'required|date',
            'certified_amount' => 'required|numeric|min:0',
            'certified_amount_words' => 'nullable|string',
            'payment_head' => 'nullable|string|max:255',
            'payment_subhead' => 'nullable|string|max:255',
            'certification_text' => 'nullable|string',
        ]);

        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        if ($jobOrder->status != 'issued') {
            return redirect()->back()->with('error', 'Only issued Job Orders can be completed');
        }

        DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->update([
                'certifying_officer' => $request->certifying_officer,
                'officer_rank' => $request->officer_rank,
                'certifying_date' => $request->certifying_date,
                'certified_amount' => $request->certified_amount,
                'certified_amount_words' => $request->certified_amount_words,
                'payment_head' => $request->payment_head,
                'payment_subhead' => $request->payment_subhead,
                'certification_text' => $request->certification_text,
                'status' => 'completed',
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);

        return redirect()->route('job-order.show', $id)
            ->with('success', 'Job Order completed and certified successfully');
    }

    /**
     * Print job order
     */
    public function print($id)
    {
        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        return view('procurement.Procurement.job_order.print', compact('jobOrder'));
    }

    /**
     * Delete job order (only draft)
     */
    public function destroy($id)
    {
        $jobOrder = DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->first();

        if (!$jobOrder) {
            return redirect()->route('job-order.index')->with('error', 'Job Order not found');
        }

        if ($jobOrder->status != 'draft') {
            return redirect()->back()->with('error', 'Only draft Job Orders can be deleted');
        }

        DB::table('tbl_job_orders')
            ->where('job_order_id', $id)
            ->delete();

        return redirect()->route('job-order.index')
            ->with('success', 'Job Order deleted successfully');
    }

    /**
     * Generate job order number
     */
    private function generateJobOrderNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastJob = DB::table('tbl_job_orders')
            ->whereYear('created_at', $year)
            ->orderBy('job_order_id', 'desc')
            ->first();
        
        $sequence = $lastJob ? intval(substr($lastJob->job_order_number, -4)) + 1 : 1;
        return 'JO/' . $year . '/' . $month . '/' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}