<?php

namespace App\Http\Controllers\funds;

use App\Helpers\FileUploadHelper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StaffOvertimeSetupController extends function24Controller
{
    public function __construct() {}

    public function staffOvertimeSetup(Request $request)
    {
        $data['setup'] = DB::table('overtime_template')->get();

        return view('funds/salaryPersonnel/overtimesetup', $data);
    }

    public function staffOvertimeSetupUpdate(Request $request)
    {
        $request->validate([
            "description" => "required|string|max:50",
            "hrs" => "required|numeric",
            "percentage" => "required|numeric",
            "months" => "required|numeric",
        ]);

        $description = ucfirst(strtolower(trim($request->description)));

        DB::table('overtime_template')->updateOrInsert(
            ['description' => $description],
            [
                'hrs' => $request->hrs,
                'percentage' => $request->percentage,
                'months' => $request->months,
            ]
        );

        return back()->with('msg', 'Saved successfully');
    }

    public function indexTrial()
    {
        $trials = DB::table('overtime_trial')->leftjoin('tblper', 'tblper.ID', 'overtime_trial.staffID')
        ->leftJoin('overtime_template', 'overtime_template.id', 'tblper.overtimeType')
        ->select('overtime_trial.*', 'tblper.surname', 'tblper.first_name', 'tblper.othernames', 'tblper.grade', 'tblper.step', 'overtime_template.hrs', 'overtime_template.description')
        ->orderBy('tblper.grade', 'desc')
        ->orderBy('tblper.step', 'desc')->get();

        $total = DB::table('overtime_trial')->sum('amount');

        return view('funds.salaryPersonnel.overtime_trial', [
            'trials' => $trials,
            'total' => $total
        ]);
    }

    public function runTrial(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100'
        ]);

        $title = $request->title;
        $randCode = rand(1000, 9999);

        DB::beginTransaction();

        try {

            // 🔥 CLEAR OLD DATA
            DB::table('overtime_trial')->delete();

            // ✅ GET ALL DATA (OPTIMIZED JOIN)
            $staffs = DB::table('tblper as p')
                ->join('basicsalaryconsolidated as b', function ($join) {
                    $join->on('b.grade', '=', 'p.grade')
                        ->on('b.step', '=', 'p.step')
                        ->where('b.employee_type', 1);
                })
                ->join('overtime_template as o', 'o.id', '=', 'p.overtimeType')
                ->where('p.employee_type', 1)
                ->where('p.grade', '<=', 14)
                ->where('p.staff_status', 1)
                ->select(
                    'p.ID',
                    'p.fileNo',
                    'b.amount as salary',
                    'o.hrs',
                    'o.months',
                    'o.percentage'
                )
                ->get();

            foreach ($staffs as $staff) {

                $amount = $staff->hrs * $staff->months * $staff->percentage * $staff->salary;

                DB::table('overtime_trial')->insert([
                    'claimID' => null,
                    'staffID' => $staff->ID,
                    'fileNo' => $staff->fileNo,
                    'overtimeDesc' => $title,
                    'amount' => $amount,
                    'uniqueCode' => $randCode,
                ]);
            }

            DB::commit();

            return redirect('/overtime-trial')->with('msg', 'Overtime trial executed successfully');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('err', 'Something went wrong');
        }
    }
}
