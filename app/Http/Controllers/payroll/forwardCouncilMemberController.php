<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class forwardCouncilMemberController extends Controller
{
    public function checkingCouncilPage(Request $request)
    {
        $data['salary'] = [];
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['courtDivisions']  = DB::table('tbldivision')->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);
        $data['month'] = ''; 
        $data['year'] = '';

        return view('payroll.forwardCouncilMembers.checkingCouncilPage', $data);
    }

    public function curDivision($userId)
    {
        $currentDivision = DB::table("users")
            ->join('tbldivision', 'tbldivision.divisionID', '=', 'users.divisionID')
            ->where('users.id', '=', $userId)
            ->select('tbldivision.division', 'tbldivision.divisionID')
            ->first();
        return $currentDivision;
    }

    public function CourtInfo()
    {
        $List = DB::Select("SELECT * FROM `tblsole_court`");
        return $List[0];
    }

    public function auditCouncilPage(Request $request)
    {
        $data['salary'] = [];
                $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['courtDivisions']  = DB::table('tbldivision')->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);
        $data['month'] = '';
        $data['year'] = '';

        return view('payroll.forwardCouncilMembers.auditCouncilPage', $data);
    }

    public function cpoCouncilPage(Request $request)
    {
        $data['salary'] = [];
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['courtDivisions']  = DB::table('tbldivision')->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);
        $data['month'] = '';
        $data['year'] = '';

        return view('payroll.forwardCouncilMembers.cpoCouncilPage', $data);
    }

    public function councilPayrollLocation(Request $request)
    {
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['salary'] = DB::table('tblpayment_consolidated')
            ->where('tblpayment_consolidated.year', '=', $data['year'])
            ->where('tblpayment_consolidated.month', '=', $data['month'])
            ->where('tblpayment_consolidated.rank', '=', 2)
            ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
            ->select('tblpayment_consolidated.year', 'tblpayment_consolidated.month', 
            'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected',
            'tblpayment_consolidated.divisionID', 'tblstages.description')
            ->groupBy('tblpayment_consolidated.rank')
            ->get();

        return view('payroll.forwardCouncilMembers.councilPayrollLocation', $data);
    }

    public function salaryForwardCouncilReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];

        try {
            if ($data['divisionID']) {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->update([
                        //to checking which has vstage 3
                        'vstage' => 3,
                        'checking_view' => 1,
                        'is_rejected' => 0,
                        'salary_forwarded_at' => date('Y-m-d')
                    ]);
            } else {
                DB::table('tblpayment_consolidated')
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->update([
                        //to checking which has vstage 3
                        'vstage' => 3,
                        'checking_view' => 1,
                        'is_rejected' => 0,
                        'salary_forwarded_at' => date('Y-m-d')
                    ]);
            }

            if ($data['comment'] != '') {
                DB::table('tblsalary_council_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            return redirect('/council-members/payroll-vc')->with('message', 'You have successfully forwarded to Checking unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/council-members/payroll-vc')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);

    }

    public function checkingForwardCouncilReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];
        try {
            if ($data['divisionID'] !== '') {

                $verifyChecking = DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->where('checking_verified', '=', 0)
                    ->first();

                if ($verifyChecking) {
                    return redirect('/council-checking-unit')->with('error', 'Please you have not completed checking');
                    // return back()->withInput([$data['divisionID'],$data['year'],$data['month']]);
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('divisionID', '=', $data['divisionID'])
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //to audit which has vstage 4
                            'vstage' => 4,
                            'audit_view' => 1,
                            'is_rejected' => 0,
                            'checking_forwarded_at' => date('Y-m-d')
                        ]);
                }
            } else {
                $verifyChecking = DB::table('tblpayment_consolidated')
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->where('checking_verified', '=', 0)
                    ->first();

                if ($verifyChecking) {
                    return redirect('/council-checking-unit')->with('error', 'Please you have not completed checking');
                    // return back()->withInput([$data['divisionID'],$data['year'],$data['month']]);
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //to audit which has vstage 4
                            'vstage' => 4,
                            'audit_view' => 1,
                            'is_rejected' => 0,
                            'checking_forwarded_at' => date('Y-m-d')
                        ]);
                }
            }
            if ($data['comment'] != '') {
                DB::table('tblsalary_council_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'] ?? '',
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            return redirect('/council-checking-unit')->with('message', 'You have successfully forwarded to Audit unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function checkingDeclineCouncilReport(Request $request)
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
                if ($data['divisionID'] !== '') {
                    DB::table('tblpayment_consolidated')
                        ->where('divisionID', '=', $data['divisionID'])
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //here vstage should be 0 so salary can see push to checking button
                            'vstage' => 0,
                            'checking_view' => 0,
                            'is_rejected' => 1,
                        ]);

                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => $data['divisionID'],
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //here vstage should be 0 so salary can see push to checking button
                            'vstage' => 0,
                            'checking_view' => 0,
                            'is_rejected' => 1,
                        ]);

                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => '',
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                }
            } else {
                // dd('not good');
                return redirect('/council-checking-unit')->with('error', 'Please comment field is required!');
            }
            return redirect('/council-checking-unit')->with('message', 'You have successfully declined to Salary unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/council-checking-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function auditForwardCouncilReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];

        try {
            if ($data['divisionID'] !== '') {
                $verifyAudit = DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->where('audit_verified', '=', 0)
                    ->first();

                if ($verifyAudit) {
                    return redirect('/council-audit-unit')->with('error', 'Please you have not completed auditing');
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('divisionID', '=', $data['divisionID'])
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //forwad to cpo / ca which has stage of 5
                            'vstage' => 5,
                            'is_rejected' => 0,
                            'ca_view' => 1,
                            'audit_forwarded_at' => date('Y-m-d')
                        ]);
                }
            } else {
                $verifyAudit = DB::table('tblpayment_consolidated')
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->where('audit_verified', '=', 0)
                    ->first();

                if ($verifyAudit) {
                    return redirect('/council-audit-unit')->with('error', 'Please you have not completed auditing');
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //forwad to cpo / ca which has stage of 5
                            'vstage' => 5,
                            'is_rejected' => 0,
                            'ca_view' => 1,
                            'audit_forwarded_at' => date('Y-m-d')
                        ]);
                }
            }

            if ($data['comment'] != '') {
                DB::table('tblsalary_council_comments')->insert([
                    'courtID' => 9,
                    'divisionID' => $data['divisionID'] ?? '',
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'comment' => $data['comment'],
                    'by_who' => $userId,
                    'updated_at' => date('Y-m-d:H:i:s')
                ]);
            }
            return redirect('/council-audit-unit')->with('message', 'You have successfully forwarded to the Cpo section, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/council-audit-unit')->with('error', 'Oops!.. An error occured');
        }
    }

    public function auditDeclineCouncilReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['declinedivisionID'];
        $data['comment'] = $request['declinecomment'];

        try {
            if ($data['comment'] != '') {
                if ($data['divisionID'] !== '') {
                    DB::table('tblpayment_consolidated')
                        ->where('divisionID', '=', $data['divisionID'])
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //back to checking vstage 3
                            'vstage' => 3,
                            'audit_view' => 0,
                            'is_rejected' => 1,
                        ]);

                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => $data['divisionID'],
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //back to checking vstage 3
                            'vstage' => 3,
                            'audit_view' => 0,
                            'is_rejected' => 1,
                        ]);

                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => '',
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                }
            } else {
                return redirect('/council-audit-unit')->with('error', 'Please to decline, a comment is required');
                // return redirect('/council-members/payroll-vc/'.$data['divisionID'].'/'.$data['year'].'/'.$data['month'])->with('error', 'Please to decline, a comment is required!');
            }
            return redirect('/council-audit-unit')->with('message', 'You have successfully declined to Checking unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/council-audit-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }

    public function cpoApproveCouncilReport(Request $request)
    {
        //update consolidated
        //update salary comment if any
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['divisionID'];
        $data['comment'] = $request['comment'];

        try {
            if ($data['divisionID'] !== '') {
                DB::table('tblpayment_consolidated')
                    ->where('divisionID', '=', $data['divisionID'])
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->update([
                        //to approve
                        'is_rejected' => 0,
                        'vstage' => 6,
                        'cpo_approval_date' => date('Y-m-d')
                    ]);
                if ($data['comment'] != '') {
                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => $data['divisionID'],
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                }
                return redirect('/council-cpo-unit')->with('message', 'You have successfully Approved, Thank you!');
            } else {
                DB::table('tblpayment_consolidated')
                    ->where('year', '=', $data['year'])
                    ->where('month', '=', $data['month'])
                    ->where('rank', '=', 2)
                    ->update([
                        //to approve
                        'is_rejected' => 0,
                        'vstage' => 6,
                        'cpo_approval_date' => date('Y-m-d')
                    ]);
                if ($data['comment'] != '') {
                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => '',
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                }
                return redirect('/council-cpo-unit')->with('message', 'You have successfully Approved, Thank you!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/council-cpo-unit')->with('error', 'Oops!.. An error occured');
        }
    }

    public function cpoDeclineCouncilReport(Request $request)
    {
        $userId = Auth::user()->id;
        $data['month'] = $request['month'];
        $data['year'] = $request['year'];
        $data['divisionID'] = $request['declinedivisionID'];
        $data['comment'] = $request['declinecomment'];

        try {
            if ($data['comment'] != '') {
                if ($data['divisionID'] !== '') {
                    DB::table('tblpayment_consolidated')
                        ->where('divisionID', '=', $data['divisionID'])
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //back to audit vstage 4
                            'vstage' => 4,
                            'ca_view' => 0,
                            'is_rejected' => 1
                        ]);


                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => $data['divisionID'],
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                } else {
                    DB::table('tblpayment_consolidated')
                        ->where('year', '=', $data['year'])
                        ->where('month', '=', $data['month'])
                        ->where('rank', '=', 2)
                        ->update([
                            //back to audit vstage 4
                            'vstage' => 4,
                            'ca_view' => 0,
                            'is_rejected' => 1
                        ]);


                    DB::table('tblsalary_council_comments')->insert([
                        'courtID' => 9,
                        'divisionID' => '',
                        'year' => $data['year'],
                        'month' => $data['month'],
                        'comment' => $data['comment'],
                        'by_who' => $userId,
                        'updated_at' => date('Y-m-d:H:i:s')
                    ]);
                }
            } else {
                return redirect('/council-cpo-unit')->with('error', 'Please to decine, a comment is required');
                // return redirect('con-payrollReport/create/'.$data['divisionID'].'/'.$data['year'].'/'.$data['month'])->with('error', 'Please comment field is required!');
            }
            return redirect('/council-cpo-unit')->with('message', 'You have successfully declined to Audit unit, Thank you!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/council-cpo-unit')->with('error', 'Oops!.. An error occured');
        }

        // dd($allData);
    }
    
    //view comments on council payroll
    public function payrollCouncilComments($year, $month)
    {
        $data['month'] = $month;
        $data['year'] = $year;
        $data['allcomments'] = DB::table('tblsalary_council_comments')
            ->leftjoin('users', 'users.id', '=', 'tblsalary_council_comments.by_who')
            ->where('tblsalary_council_comments.year', '=', $year)
            ->where('tblsalary_council_comments.month', $month)
            ->orderBy('tblsalary_council_comments.ID', 'DESC')
            ->select('users.name', 'tblsalary_council_comments.comment', 'tblsalary_council_comments.updated_at')
            ->get();
        
        return view ('payroll.forwardCouncilMembers.councilPayrollComments', $data);
    }

    public function checkingCouncilVerify(Request $request)
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

    public function auditCouncilVerify(Request $request)
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
}
