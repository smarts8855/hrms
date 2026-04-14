<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\FileUploadHelper;

class forwardApprovalController extends Controller
{
    public function checkingPageold(Request $request)
    {
        $data['salary'] = [];
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['month'] = '';
        $data['year'] = '';
        $user = Auth::user()->id;
        $data['userInAssignSalaryStaff'] = '';

        if (isset($_POST['fetchRecords'])) {
            $data['activeMonth'] = '';
            $data['month']             = trim($request->input('month'));
            $data['year']              = trim($request->input('year'));

            $data['userInAssignSalaryStaff'] = DB::table('assign_salary_staff')->where('user_id', $user)->first();
            //check if the user is on assign_salary_staff_table
            if ($data['userInAssignSalaryStaff']) {
                $assignedBanks = DB::table('assign_salary_staff')
                    ->where('user_id', $user)
                    ->pluck('bank_id');
                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblpayment_consolidated.bank')
                    ->where('tblpayment_consolidated.month', $data['month'])
                    ->where('tblpayment_consolidated.year', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.checking_view', 1)
                    ->whereIn('tblpayment_consolidated.bank', $assignedBanks)
                    ->groupBy('tbldivision.divisionID')
                    ->groupBy('tblpayment_consolidated.bank')
                    ->select(
                        'tbldivision.division',
                        'tblpayment_consolidated.year',
                        'tblpayment_consolidated.month',
                        'tblpayment_consolidated.vstage',
                        'tblpayment_consolidated.mandate_approval',
                        'tblpayment_consolidated.is_rejected',
                        'tblpayment_consolidated.divisionID',
                        'tblstages.description',
                        'tblbanklist.bank as banklistName',
                        'tblpayment_consolidated.bank as bankName',
                    )
                    ->get();
                return view('payroll.forwardApproval.checkingPage', $data);
            } else {
                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->where('tblpayment_consolidated.month',     '=', $data['month'])
                    ->where('tblpayment_consolidated.year',      '=', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.checking_view',      '=', 1)
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description')
                    ->groupBy('tbldivision.divisionID')
                    ->get();
                // dd($data);
                return view('payroll.forwardApproval.checkingPage', $data);
            }
        }
        // dd($data);
        return view('payroll.forwardApproval.checkingPage', $data);
    }


    public function checkingPage(Request $request)
    {
        $data['salary'] = [];
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['month'] = '';
        $data['year'] = '';
        $user = Auth::user()->id;
        $data['userInAssignSalaryStaff'] = '';
        $data['bankAssignments'] = collect();

        $assignedRole = DB::table('assign_user_role')
            ->where('userID', $user)
            ->value('roleID');

        // dd($user);
        $isHOD = ($assignedRole == 36);

        $data['isHOD'] = $isHOD;
        $data['user'] = Auth::user();

        if (isset($_POST['fetchRecords'])) {
            $data['activeMonth'] = '';
            $data['month']             = trim($request->input('month'));
            $data['year']              = trim($request->input('year'));

            $data['userInAssignSalaryStaff'] = DB::table('assign_salary_staff')->where('user_id', $user)->first();
            // dd($data['userInAssignSalaryStaff']);

            //check if the user is on assign_salary_staff_table
            if ($data['userInAssignSalaryStaff']) {
                $assignedBanks = DB::table('assign_salary_staff')
                    ->where('user_id', $user)
                    ->pluck('bank_id');

                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblpayment_consolidated.bank')
                    ->where('tblpayment_consolidated.month', $data['month'])
                    ->where('tblpayment_consolidated.year', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.checking_view', 1)
                    ->whereIn('tblpayment_consolidated.bank', $assignedBanks)
                    ->groupBy('tbldivision.divisionID')
                    ->groupBy('tblpayment_consolidated.bank')
                    ->select(
                        'tbldivision.division',
                        'tblpayment_consolidated.year',
                        'tblpayment_consolidated.month',
                        'tblpayment_consolidated.vstage',
                        'tblpayment_consolidated.mandate_approval',
                        'tblpayment_consolidated.is_rejected',
                        'tblpayment_consolidated.divisionID',
                        'tblstages.description',
                        'tblbanklist.bank as banklistName',
                        'tblpayment_consolidated.bank as bankName',
                    )
                    ->get();
                return view('payroll.forwardApproval.checkingPage', $data);
            } else {
                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->where('tblpayment_consolidated.month',     '=', $data['month'])
                    ->where('tblpayment_consolidated.year',      '=', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.checking_view',      '=', 1)
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description')
                    ->groupBy('tbldivision.divisionID')
                    ->get();


                $data['bankAssignments'] = DB::table('assign_salary_staff AS a')
                    ->join('users AS u', 'u.id', '=', 'a.user_id')
                    ->join('tbldivision AS d', 'd.divisionID', '=', 'a.division_id')
                    ->join('tblbanklist AS b', 'b.bankID', '=', 'a.bank_id')
                    ->where('role_id', 37)
                    ->select(
                        'a.user_id',
                        'u.name AS staffName',
                        'd.division AS divisionName',
                        'b.bank AS bankName',
                        'a.bank_id'
                    )
                    ->groupBy('a.id')
                    ->get()
                    ->map(function ($item) {

                        // total staff for assigned bank
                        $item->totalStaff = DB::table('tblpayment_consolidated')
                            ->where('bank', $item->bank_id)
                            ->where('month', request('month'))
                            ->where('year', request('year'))
                            ->where('tblpayment_consolidated.checking_view', 1)
                            ->count();

                        // how many have checked
                        $item->checkedStaff = DB::table('tblpayment_consolidated')
                            ->where('bank', $item->bank_id)
                            ->where('month', request('month'))
                            ->where('year', request('year'))
                            ->where('tblpayment_consolidated.checking_view', 1)
                            ->where('tblpayment_consolidated.checking_verified', 1)
                            ->count();

                        return $item;
                    });
                // Log::info(request('month'));
                // Log::info(request('year'));
                // dd($data);
                return view('payroll.forwardApproval.checkingPage', $data);
            }
        }
        // dd($data);
        return view('payroll.forwardApproval.checkingPage', $data);
    }

    public function auditPageold(Request $request)
    {
        $data['salary'] = [];
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['month'] = '';
        $data['year'] = '';
        $user = Auth::user()->id;
        $data['userInAssignSalaryStaff'] = '';

        if (isset($_POST['fetchRecords'])) {
            $data['activeMonth'] = '';
            $data['month']             = trim($request->input('month'));
            $data['year']              = trim($request->input('year'));
            $data['userInAssignSalaryStaff'] = DB::table('assign_salary_staff')->where('user_id', $user)->first();
            //check if the user is on assign_salary_staff_table
            if ($data['userInAssignSalaryStaff']) {
                $assignedBanks = DB::table('assign_salary_staff')
                    ->where('user_id', $user)
                    ->pluck('bank_id');
                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblpayment_consolidated.bank')
                    ->where('tblpayment_consolidated.month',     '=', $data['month'])
                    ->where('tblpayment_consolidated.year',      '=', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.audit_view', '=', 1)
                    ->whereIn('tblpayment_consolidated.bank', $assignedBanks)
                    ->groupBy('tbldivision.divisionID')
                    ->groupBy('tblpayment_consolidated.bank')
                    ->select(
                        'tbldivision.division',
                        'tblpayment_consolidated.year',
                        'tblpayment_consolidated.month',
                        'tblpayment_consolidated.vstage',
                        'tblpayment_consolidated.mandate_approval',
                        'tblpayment_consolidated.is_rejected',
                        'tblpayment_consolidated.divisionID',
                        'tblstages.description',
                        'tblbanklist.bank as banklistName',
                        'tblpayment_consolidated.bank as bankName',
                    )
                    ->get();
                // dd($data);
                return view('payroll.forwardApproval.auditPage', $data);
            } else {
                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->where('tblpayment_consolidated.month',     '=', $data['month'])
                    ->where('tblpayment_consolidated.year',      '=', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.audit_view', '=', 1)
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description')
                    ->groupBy('tbldivision.divisionID')
                    ->get();
                // dd($data);
                return view('payroll.forwardApproval.auditPage', $data);
            }
        }

        return view('payroll.forwardApproval.auditPage', $data);
    }


    public function auditPage(Request $request)
    {
        $data['salary'] = [];
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['month'] = '';
        $data['year'] = '';
        $user = Auth::user()->id;
        $data['userInAssignSalaryStaff'] = '';
        $data['bankAssignments'] = collect();
        $assignedRole = DB::table('assign_user_role')
            ->where('userID', $user)
            ->value('roleID');

        // dd($user);
        $isHOD = ($assignedRole == 34);

        $data['isHOD'] = $isHOD;
        $data['user'] = Auth::user();

        if (isset($_POST['fetchRecords'])) {
            $data['activeMonth'] = '';
            $data['month']             = trim($request->input('month'));
            $data['year']              = trim($request->input('year'));
            $data['userInAssignSalaryStaff'] = DB::table('assign_salary_staff')->where('user_id', $user)->first();
            //check if the user is on assign_salary_staff_table
            if ($data['userInAssignSalaryStaff']) {
                $assignedBanks = DB::table('assign_salary_staff')
                    ->where('user_id', $user)
                    ->pluck('bank_id');

                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblpayment_consolidated.bank')
                    ->where('tblpayment_consolidated.month',     '=', $data['month'])
                    ->where('tblpayment_consolidated.year',      '=', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.audit_view', '=', 1)
                    ->whereIn('tblpayment_consolidated.bank', $assignedBanks)
                    ->groupBy('tbldivision.divisionID')
                    ->groupBy('tblpayment_consolidated.bank')
                    ->select(
                        'tbldivision.division',
                        'tblpayment_consolidated.year',
                        'tblpayment_consolidated.month',
                        'tblpayment_consolidated.vstage',
                        'tblpayment_consolidated.mandate_approval',
                        'tblpayment_consolidated.is_rejected',
                        'tblpayment_consolidated.divisionID',
                        'tblstages.description',
                        'tblbanklist.bank as banklistName',
                        'tblpayment_consolidated.bank as bankName',
                    )
                    ->get();
                // dd($data);
                return view('payroll.forwardApproval.auditPage', $data);
            } else {
                $data['salary'] = DB::table('tblpayment_consolidated')
                    ->where('tblpayment_consolidated.month',     '=', $data['month'])
                    ->where('tblpayment_consolidated.year',      '=', $data['year'])
                    ->where('tblpayment_consolidated.rank', '!=', 2)
                    ->where('tblpayment_consolidated.audit_view', '=', 1)
                    ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                    ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                    ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description')
                    ->groupBy('tbldivision.divisionID')
                    ->get();

                $data['bankAssignments'] = DB::table('assign_salary_staff AS a')
                    ->join('users AS u', 'u.id', '=', 'a.user_id')
                    ->join('tbldivision AS d', 'd.divisionID', '=', 'a.division_id')
                    ->join('tblbanklist AS b', 'b.bankID', '=', 'a.bank_id')
                    ->where('role_id', 35)
                    ->select(
                        'a.user_id',
                        'u.name AS staffName',
                        'd.division AS divisionName',
                        'b.bank AS bankName',
                        'a.bank_id'
                    )
                    ->groupBy('a.id')
                    ->get()
                    ->map(function ($item) {

                        // total staff for assigned bank
                        $item->totalStaff = DB::table('tblpayment_consolidated')
                            ->where('bank', $item->bank_id)
                            ->where('month', request('month'))
                            ->where('year', request('year'))
                            ->where('tblpayment_consolidated.audit_view', 1)
                            ->count();

                        // how many have checked
                        $item->checkedStaff = DB::table('tblpayment_consolidated')
                            ->where('bank', $item->bank_id)
                            ->where('month', request('month'))
                            ->where('year', request('year'))
                            ->where('tblpayment_consolidated.audit_view', 1)
                            ->where('tblpayment_consolidated.audit_verified', 1)
                            ->count();

                        return $item;
                    });
                // Log::info(request('month'));
                // dd($data);
                return view('payroll.forwardApproval.auditPage', $data);
            }
        }

        return view('payroll.forwardApproval.auditPage', $data);
    }

    public function cpoPage(Request $request)
    {
        $data['salary'] = [];
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['month'] = '';
        $data['year'] = '';

        if (isset($_POST['fetchRecords'])) {
            $data['activeMonth'] = '';
            $data['month'] = trim($request->input('month'));
            $data['year'] = trim($request->input('year'));

            $data['salary'] = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month',     '=', $data['month'])
                ->where('tblpayment_consolidated.year',      '=', $data['year'])
                ->where('tblpayment_consolidated.rank', '!=', 2)
                ->where('tblpayment_consolidated.ca_view', '=', 1)
                ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description')
                ->groupBy('tbldivision.divisionID')
                ->get();
            //dd($data);
            return view('payroll.forwardApproval.cpoPage', $data);
        }

        return view('payroll.forwardApproval.cpoPage', $data);
    }

    public function salaryForwardReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];

        try {
            DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                // ->where('rank', '!=', 2)
                ->update([
                    //to checking which has vstage 3
                    'vstage' => 3,
                    'checking_view' => 1,
                    'is_rejected' => 0,
                    'salary_forwarded_at' => date('Y-m-d')
                ]);
            if ($data['comment'] != '') {
                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            //forward voucher to checking as well

            return redirect('/salary')->with('message', 'You have successfully forwarded to Checking unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/salary')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);

    }

    public function salaryDeclineReportOld(Request $request)
    {
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['declinedivisionID'];
        $data['comment'] = $request['declinecomment'];

        try {
            if ($data['comment'] != '') {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '!=', 2)
                    ->update([
                        //back to salary division with vstage of pending
                        'salary_lock' => 1,
                        'vstage' => 1,
                        'is_rejected' => 1
                    ]);

                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            } else {
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])->with('error', 'Please comment field is required!');
            }

            return redirect('/salary')->with('message', 'You have successfully declined record to division Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/salary')->with('error', 'Oops!.. An error occured');
        }
    }

    public function salaryDeclineReport(Request $request)
    {
        try {
            // Validate all inputs - attachment is OPTIONAL with 100KB max size
            $request->validate([
                'month' => 'required',
                'year' => 'required',
                'declinedivisionID' => 'required',
                'declinecomment' => 'required',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:100' // OPTIONAL - 100KB max
            ]);

            $userId = Auth::user()->id;
            $data['month'] = $request['month'];
            $data['year'] = $request['year'];
            $data['divisionID'] = $request['declinedivisionID'];
            $data['comment'] = $request['declinecomment'];

            // Check if comment is empty
            if (empty($data['comment'])) {
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])
                    ->with('error', 'Please comment field is required!');
            }

            // Start transaction
            DB::beginTransaction();
            
            // Update consolidated table
            DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->update([
                    'salary_lock' => 1,
                    'vstage' => 1,
                    'is_rejected' => 1
                ]);

            // Prepare comment data - WITHOUT attachment initially
            $commentData = [
                'courtID' => 9,
                'divisionID' => $data['divisionID'],
                'year' => $data['year'],
                'month' => $data['month'],
                'comment' => $data['comment'],
                'by_who' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle optional attachment - ONLY if file is uploaded
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                
                // Create folder structure
                $folder = 'salary-attachments/salary-decline/' . $data['year'] . '/' . $data['month'] . '/' . $data['divisionID'];
                
                // Generate filename
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
                $filename = time() . '_' . $cleanName . '.' . $extension;
                
                // Upload and get URL
                $fileUrl = FileUploadHelper::upload($file, $folder, $filename);
                
                // Add attachment to comment data ONLY if file was uploaded
                $commentData['attachment'] = $fileUrl;
            }

            // Insert comment (with or without attachment)
            DB::table('tblsalary_comments')->insert($commentData);
            
            // Commit transaction
            DB::commit();
            
            return redirect('/salary')->with('message', 'You have successfully declined record to division Thank you!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $th) {
            // Rollback transaction
            DB::rollBack();
            
            // Log the error
            Log::error('Salary Decline Error: ' . $th->getMessage());
            Log::error('File: ' . $th->getFile());
            Log::error('Line: ' . $th->getLine());
            
            return redirect('/salary')->with('error', 'Oops!.. An error occured');
        }
    }

    public function checkingForwardReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        // dd($request->all());
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];
        try {
            $verifyChecking = DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->where('checking_verified', '=', 0)
                ->first();

            if ($verifyChecking) {
                return redirect('/checking-unit')->with('error', 'Please you have not completed checking');
                // return back()->withInput([$data['divisionID'],$data['year'],$data['month']]);
            } else {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '!=', 2)
                    ->update([
                        //to audit which has vstage 4
                        'vstage' => 4,
                        'audit_view' => 1,
                        'is_rejected' => 0,
                        'checking_forwarded_at' => date('Y-m-d')
                    ]);

                //update paymentTransaction
                DB::table('tblpaymentTransaction')->where('month', $data['month'])->where('year', $data['year'])->update([
                    'checkbyStatus'         => 1,
                    'status'                   => 2,
                    'vstage'         => 3,
                    'isrejected'         => 0,
                    'dateCheck'             => date('Y-m-j'),
                    'checkBy'            => Auth::user()->id,
                    'is_need_more_doc' => 0
                ]);

                DB::table('tblcontractDetails')
                    ->where('month', $data['month'])->where('year', $data['year'])
                    ->update([
                        'paymentStatus' => 4
                    ]);
            }
            if ($data['comment'] != '') {
                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            return redirect('/checking-unit')->with('message', 'You have successfully forwarded to Audit unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function checkingDeclineReportOld(Request $request)
    {
        //update consolidated
        //update salary comment if any
        // dd($request->all());
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['declinedivisionID'];
        $data['comment'] = $request['declinecomment'];

        try {
            if ($data['comment'] != '') {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '!=', 2)
                    ->update([
                        //salary has vstage 2
                        'vstage' => 2,
                        'checking_view' => 0,
                        'is_rejected' => 1,
                        // 'checking_verified' => 0
                    ]);

                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            } else {
                // dd('not good');
                // return redirect('/checking-unit')->with('error', 'Please comment field is required!');
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])->with('error', 'Please comment field is required!');
            }
            return redirect('/checking-unit')->with('message', 'You have successfully declined to Salary unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/checking-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }


    public function checkingDeclineReport(Request $request)
    {
        try {
            // Validate all inputs - attachment is OPTIONAL (nullable)
            $request->validate([
                'month' => 'required',
                'year' => 'required',
                'declinedivisionID' => 'required',
                'declinecomment' => 'required',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:100' // OPTIONAL
            ]);

            $userId = Auth::user()->id;
            $data['month'] = $request['month'];
            $data['year'] = $request['year'];
            $data['divisionID'] = $request['declinedivisionID'];
            $data['comment'] = $request['declinecomment'];

            // Check if comment is empty
            if (empty($data['comment'])) {
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])
                    ->with('error', 'Please comment field is required!');
            }

            // Start transaction
            DB::beginTransaction();
            
            // Update consolidated table
            DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->update([
                    'vstage' => 2,
                    'checking_view' => 0,
                    'is_rejected' => 1,
                ]);

            // Prepare comment data
            $commentData = [
                'courtID' => 9,
                'divisionID' => $data['divisionID'],
                'year' => $data['year'],
                'month' => $data['month'],
                'comment' => $data['comment'],
                'by_who' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle optional attachment - ONLY if file is uploaded
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                
                // Create folder structure
                $folder = 'salary-attachments/checking-decline/' . $data['year'] . '/' . $data['month'] . '/' . $data['divisionID'];
                
                // Generate filename
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
                $filename = time() . '_' . $cleanName . '.' . $extension;
                
                // Upload and get URL
                $fileUrl = FileUploadHelper::upload($file, $folder, $filename);
                
                // Add attachment to comment data
                $commentData['attachment'] = $fileUrl;
            }

            // Insert comment
            DB::table('tblsalary_comments')->insert($commentData);
            
            // Commit transaction
            DB::commit();
            
            return redirect('/checking-unit')->with('message', 'You have successfully declined to Salary unit, Thank you!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $th) {
            // Rollback transaction
            DB::rollBack();
            
            // Log the error
            Log::error('Checking Decline Error: ' . $th->getMessage());
            
            return redirect('/checking-unit')->with('error', 'Oops!.. An error occured');
        }
    }


    public function checkingVerify(Request $request)
    {
        if ($request->checked == 0) {
            $verify = DB::table('tblpayment_consolidated')->where('staffid', '=', $request->staffId)
                ->where('month', '=', $request->month)
                ->where('year', '=', $request->yr)
                ->update([
                    'checking_verified' => 0
                ]);
        } else {
            $verify = DB::table('tblpayment_consolidated')->where('staffid', '=', $request->staffId)
                ->where('month', '=', $request->month)
                ->where('year', '=', $request->yr)
                ->update([
                    'checking_verified' => 1
                ]);
        }

        if ($verify) {
            return response()->json([
                'success' => true
            ], 200);
        }
    }

    public function auditForwardReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];

        try {
            $verifyAudit = DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->where('audit_verified', '=', 0)
                ->first();

            if ($verifyAudit) {
                return redirect('/audit-unit')->with('error', 'Please you have not completed auditing');
            } else {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '!=', 2)
                    ->update([
                        //forwad to cpo / ca which has stage of 5
                        'vstage' => 5,
                        'is_rejected' => 0,
                        'ca_view' => 1,
                        'audit_forwarded_at' => date('Y-m-d')
                    ]);

                //update paymentTransaction
                DB::table('tblpaymentTransaction')->where('month', $data['month'])->where('year', $data['year'])->update([
                    'auditStatus'         => 1,
                    'status'               => 2,
                    'vstage'             => 7,
                    'isrejected'         => 0,
                    'auditDate'         => date('Y-m-j'),
                    'auditedBy'            => Auth::user()->id,
                    'is_need_more_doc' => 0
                ]);

                DB::table('tblcontractDetails')
                    ->where('month', $data['month'])->where('year', $data['year'])
                    ->update([
                        'paymentStatus' => 4
                    ]);
            }
            if ($data['comment'] != '') {
                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            return redirect('/audit-unit')->with('message', 'You have successfully forwarded to the Cpo section, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/audit-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function auditDeclineReportOld(Request $request)
    {
        //update consolidated
        //update salary comment if any
        // dd($request->all());
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['declinedivisionID'];
        $data['comment'] = $request['declinecomment'];

        // Add validation for optional attachment
        $request->validate([
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            // 'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048'
        ]);

        try {
            if ($data['comment'] != '') {
                DB::beginTransaction();
                
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '!=', 2)
                    ->update([
                        //back to checking vstage 3
                        'vstage' => 3,
                        'audit_view' => 0,
                        'is_rejected' => 1,
                        // 'audit_verified' => 0
                    ]);

                // Prepare comment data
                $commentData = [
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ];

                // Handle optional attachment - store only the URL/path in string field
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    
                    // Create folder structure
                    $folder = 'salary-attachments/audit-decline/' . $data['year'] . '/' . $data['month'] . '/' . $data['divisionID'];
                    
                    // Generate filename
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
                    $filename = time() . '_' . $cleanName . '.' . $extension;
                    
                    // Upload and get URL
                    $fileUrl = FileUploadHelper::upload($file, $folder, $filename);
                    
                    // Store only the URL in attachment field (string)
                    $commentData['attachment'] = $fileUrl;
                }

                DB::table('tblsalary_comments')->insert($commentData);
                
                DB::commit();
                
                return redirect('/audit-unit')->with('message', 'You have successfully declined to Checking unit, Thank you!');
            } else {
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])->with('error', 'Please to decline, a comment is required!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Audit decline error: ' . $th->getMessage());
            return redirect('/audit-unit')->with('error', 'Oops!.. An error occured');
        }
    }

    public function auditDeclineReport(Request $request)
    {
        try {
            // Validate all inputs - attachment is now OPTIONAL (nullable)
            $request->validate([
                'month' => 'required',
                'year' => 'required',
                'declinedivisionID' => 'required',
                'declinecomment' => 'required',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:100' // CHANGED TO OPTIONAL
            ]);

            $userId = Auth::user()->id;
            $data['month'] = $request['month'];
            $data['year'] = $request['year'];
            $data['divisionID'] = $request['declinedivisionID'];
            $data['comment'] = $request['declinecomment'];

            // Check if comment is empty
            if (empty($data['comment'])) {
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])
                    ->with('error', 'Please to decline, a comment is required!');
            }

            // Start transaction
            DB::beginTransaction();
            
            // Update consolidated table
            DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->update([
                    'vstage' => 3,
                    'audit_view' => 0,
                    'is_rejected' => 1,
                ]);

            // Prepare comment data - WITHOUT attachment initially
            $commentData = [
                'courtID' => 9,
                'divisionID' => $data['divisionID'],
                'year' => $data['year'],
                'month' => $data['month'],
                'comment' => $data['comment'],
                'by_who' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle optional attachment - ONLY if file is uploaded
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                
                // Create folder structure
                $folder = 'salary-attachments/audit-decline/' . $data['year'] . '/' . $data['month'] . '/' . $data['divisionID'];
                
                // Generate filename
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
                $filename = time() . '_' . $cleanName . '.' . $extension;
                
                // Upload and get URL
                $fileUrl = FileUploadHelper::upload($file, $folder, $filename);
                
                // Add attachment to comment data ONLY if file was uploaded
                $commentData['attachment'] = $fileUrl;
            }

            // Insert comment (with or without attachment)
            DB::table('tblsalary_comments')->insert($commentData);
            
            // Commit transaction
            DB::commit();
            
            return redirect('/audit-unit')->with('message', 'You have successfully declined to Checking unit, Thank you!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            // Log the error for debugging
            Log::error('Audit Decline Error: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile());
            Log::error('Line: ' . $e->getLine());
            
            // Check if it's the column missing error
            if (strpos($e->getMessage(), 'attachment') !== false && strpos($e->getMessage(), 'column') !== false) {
                return redirect('/audit-unit')->with('error', 'Database error: attachment column missing. Please run migration.');
            }
            
            return redirect('/audit-unit')->with('error', 'Oops!.. An error occurred: ' . $e->getMessage());
        }
    }

    public function auditVerify(Request $request)
    {
        if ($request->checked == 0) {
            $verify = DB::table('tblpayment_consolidated')->where('staffid', '=', $request->staffId)
                ->where('month', '=', $request->month)
                ->where('year', '=', $request->yr)
                ->update([
                    'audit_verified' => 0
                ]);
        } else {
            $verify = DB::table('tblpayment_consolidated')->where('staffid', '=', $request->staffId)
                ->where('month', '=', $request->month)
                ->where('year', '=', $request->yr)
                ->update([
                    'audit_verified' => 1
                ]);
        }
        if ($verify) {
            return response()->json([
                'success' => true
            ], 200);
        }
    }

    public function cpoApproveReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];

        DB::beginTransaction();
        try {
            DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->update([
                    //to approve
                    'is_rejected' => 0,
                    'vstage' => 6,
                    'cpo_approval_date' => date('Y-m-d')
                ]);
            $batch1 = $this->NewBatchNo();
            //take all staff and justices to epayment
            $voucher = DB::table('tblpaymentTransaction')->where('month', '=', $data['month'])->where('year', '=', $data['year'])->first();
            //get all from payment_consolidated for month and year and vstage 6
            $staff = DB::table('tblpayment_consolidated')
                // ->where('salary_lock', '=', 1)
                // ->where('vstage', '=', 6)
                ->leftjoin('tblbanklist', 'tblbanklist.bankID', 'tblpayment_consolidated.bank')
                ->where('month', '=', $data['month'])->where('year', '=', $data['year'])
                ->select(
                    'tblpayment_consolidated.name',
                    'tblpayment_consolidated.NetPay',
                    'tblpayment_consolidated.AccNo',
                    'tblbanklist.bank'
                )
                ->get();
                $totals = DB::table('tblpayment_consolidated')
                    ->where('month', $data['month'])
                    ->where('year', $data['year'])
                    ->selectRaw('
                        SUM(IFNULL(TAX,0)) as total_tax,
                        SUM(IFNULL(NHF,0)) as total_nhf,
                        SUM(IFNULL(PEN,0)) as total_pen,
                        SUM(IFNULL(UD,0)) as total_ud
                    ')
                    ->first();
                $deductions = [
                    [
                        'name'   => 'TAX DEDUCTION',
                        'amount' => $totals->total_tax,
                    ],
                    [
                        'name'   => 'NHF DEDUCTION',
                        'amount' => $totals->total_nhf,
                    ],
                    [
                        'name'   => 'PENSION DEDUCTION',
                        'amount' => $totals->total_pen,
                    ],
                    [
                        'name'   => 'UNION DUES DEDUCTION',
                        'amount' => $totals->total_ud,
                    ],
                ];

                $njcAcct = DB::table('tblmandate_address_account')
                    ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblmandate_address_account.bankId')
                    ->where('tblmandate_address_account.contractTypeID', '=', $voucher->contractTypeID)
                    ->where('tblmandate_address_account.status', '=', 1)
                    ->first();

                foreach ($deductions as $deduction) {

                    // Skip zero or empty deductions
                    if ($deduction['amount'] <= 0) {
                        continue;
                    }

                    DB::table('tblepayment')->insert([
                        'transactionID'   => $voucher->ID,
                        'contractor'      => $deduction['name'],
                        'amount'          => $deduction['amount'],
                        'accountNo'       => $deduction['name'].""."0234",
                        'bank'            => "TEST BANK",
                        'date'            => date('Y-m-d'),
                        'batch'           => $batch1,
                        'purpose'         => $voucher->paymentDescription,
                        'adjusted_batch'  => $batch1,
                        'NJCAccount'      => $njcAcct->id,
                        'contract_typeID' => $voucher->contractTypeID,
                    ]);
                }

                //foreach of them, insert into epayment table
                foreach ($staff as $list) {
                    DB::table('tblepayment')
                        ->insert(array(
                            'transactionID'   => $voucher->ID,
                            'contractor'      => $list->name,
                            'amount'          => $list->NetPay,
                            'accountNo'       => $list->AccNo,
                            'bank'            => $list->bank,
                            'date'            => date('Y-m-d'),
                            'batch'           => $batch1,
                            'purpose'        => $voucher->paymentDescription,
                            // 'remark'         => $list->remarks,
                            'adjusted_batch'             => $batch1,
                            'NJCAccount'      => $njcAcct->id,
                            'contract_typeID' => $voucher->contractTypeID,
                        ));
                }

            //update transaction table
            DB::table('tblpaymentTransaction')->where('month', '=', $data['month'])->where('year', '=', $data['year'])->update(array(
                'dateTakingLiability' => date('Y-m-d'),
                'pay_confirmation'   => 1,
                'status'  => 6,
                'confirm_for_mandate' => 1,
            ));

            if ($data['comment'] != '') {
                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            DB::commit();
            return redirect('/cpo-unit')->with('message', 'You have successfully Approved, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
             DB::rollBack();
            return redirect('/cpo-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function NewBatchNo()
    {

        $myData = DB::Select("SELECT max(`batch`) as BTN FROM `tblepayment`");
        //return $myData[0]->BTN;
        if ($myData[0]->BTN == '') {
            return 'BTN00000001';
        }

        $BTN1 = $myData[0]->BTN;
        $arr = explode("BTN", $BTN1);

        $newcode = $arr[1] + 1;
        while (strlen($newcode) < 8) {
            $newcode = "0" . $newcode;
        }
        return 'BTN' . $newcode;
    }

    public function cpoDeclineReportOld(Request $request)
    {
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['declinedivisionID'];
        $data['comment'] = $request['declinecomment'];

        try {
            if ($data['comment'] != '') {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '!=', 2)
                    ->update([
                        //back to audit vstage 4
                        'vstage' => 4,
                        'ca_view' => 0,
                        'is_rejected' => 1
                    ]);


                DB::table('tblsalary_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            } else {
                // return redirect('/cpo-unit')->with('error', 'Please to decine, a comment is required');
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])->with('error', 'Please comment field is required!');
            }
            return redirect('/cpo-unit')->with('message', 'You have successfully declined to Audit unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/cpo-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function cpoDeclineReport(Request $request)
    {
        try {
            // Validate all inputs - attachment is OPTIONAL with 100KB max size
            $request->validate([
                'month' => 'required',
                'year' => 'required',
                'declinedivisionID' => 'required',
                'declinecomment' => 'required',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:100' // OPTIONAL - 100KB max
            ]);

            $userId = Auth::user()->id;
            $data['month'] = $request['month'];
            $data['year'] = $request['year'];
            $data['divisionID'] = $request['declinedivisionID'];
            $data['comment'] = $request['declinecomment'];

            // Check if comment is empty
            if (empty($data['comment'])) {
                return redirect('con-payrollReport/create/' . $data['divisionID'] . '/' . $data['year'] . '/' . $data['month'])
                    ->with('error', 'Please comment field is required!');
            }

            // Start transaction
            DB::beginTransaction();
            
            // Update consolidated table
            DB::table('tblpayment_consolidated')
                ->where('divisionID', '=', $data['divisionID'])
                ->where('year', '=', $data['year'])
                ->where('month', '=', $data['month'])
                ->where('rank', '!=', 2)
                ->update([
                    'vstage' => 4,
                    'ca_view' => 0,
                    'is_rejected' => 1
                ]);

            // Prepare comment data - WITHOUT attachment initially
            $commentData = [
                'courtID' => 9,
                'divisionID' => $data['divisionID'],
                'year' => $data['year'],
                'month' => $data['month'],
                'comment' => $data['comment'],
                'by_who' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle optional attachment - ONLY if file is uploaded
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $file = $request->file('attachment');
                
                // Create folder structure
                $folder = 'salary-attachments/cpo-decline/' . $data['year'] . '/' . $data['month'] . '/' . $data['divisionID'];
                
                // Generate filename
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
                $filename = time() . '_' . $cleanName . '.' . $extension;
                
                // Upload and get URL
                $fileUrl = FileUploadHelper::upload($file, $folder, $filename);
                
                // Add attachment to comment data ONLY if file was uploaded
                $commentData['attachment'] = $fileUrl;
            }

            // Insert comment (with or without attachment)
            DB::table('tblsalary_comments')->insert($commentData);
            
            // Commit transaction
            DB::commit();
            
            return redirect('/cpo-unit')->with('message', 'You have successfully declined to Audit unit, Thank you!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $th) {
            // Rollback transaction
            DB::rollBack();
            
            // Log the error
            Log::error('CPO Decline Error: ' . $th->getMessage());
            Log::error('File: ' . $th->getFile());
            Log::error('Line: ' . $th->getLine());
            
            return redirect('/cpo-unit')->with('error', 'Oops!.. An error occured');
        }
    }
}
