<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\payroll\functions22Controller;

class StaffControlVariableController extends functions22Controller
{
    public function index(Request $request)
    {
        // dd("stop");
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }


        $data['courtDivisions']  = DB::table('tbldivision')
            ->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);

        $data['courtList']          = $this->getCourts();
        $data['courtdivision']  = [];
        $data['getedj']         = [];
        $data['fileNo']         = ($request['fileNo']) ? $request['fileNo'] : $request['fileNofordelete'];
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['courtstaff']     = [];
        $data['hiddenlimit']        = ($request['hiddenlimit']) ? $request['hiddenlimit'] : 0;
        $data['hiddenrecycle']        = ($request['hiddenrecycle']) ? $request['hiddenrecycle'] : 0;;
        $data['cvtype']        = $request['cvtype'];
        $data['cvdesc']         = $this->getCV($data['cvtype']);

        $data['amount']         = $request['amount'];
        $data['tamount']         = $request['tamount'];

        $data['staff'] = $this->getStaffInfo($request['fileNo']);
        $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);


        if (Auth::user()->is_global == 1) {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.staff_status', '=', 1)
                ->orderBy('surname', 'Asc')
                ->get();
        } else {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.divisionID', '=', $data['curDivision']->divisionID)
                ->where('tblper.staff_status', '=', 1)
                ->orderBy('surname', 'Asc')
                ->get();
        }

        // dd($data['staff']->fileNo);

        $data['staffLastNetEmolument'] = DB::table('tblpayment_consolidated')
            ->where('tblpayment_consolidated.fileNo', '=', $data['staff']->fileNo)
            ->orderBy('ID', 'DESC') // Order by 'ID' in descending order to get the latest record
            ->first(); // Get the first record from the ordered result

        if ($data['court'] !== null) {

            $data['courtdivision'] = $this->getCourtDivision($data['court']);

            if ($request['division'] !== null) {
                // dd($request->all());
                if (!empty($request['fileNofordelete'])) {

                    if ($request['deleteid'] !== null) {
                        if ($this->deleteControlVariable($request['deleteid'])) {

                            $data['success'] = 'Staff Control Variable Deleted!';
                        } else {

                            $data['error'] = 'Oops! Staff Control variable not deleted!';
                        }
                    } elseif ($request['edit-hidden'] !== null) {
                        //get initial staffcv
                        $initialCv = DB::table('tblstaffCV')->where('ID', $request['edit-hidden'])->first();
                        $existingCvTemp = DB::table('tblstaffcvtemp')->where('tblstaffcvId', $request['edit-hidden'])->first();

                        if ($existingCvTemp) {
                            DB::table('tblstaffcvtemp')->where('tblstaffcvId', $request['edit-hidden'])->update([
                                'newAmount' => $request['amount-edit'],
                                'remark' => $request['remarks'] ? $request['remarks'] : $existingCvTemp->remark,
                                'requestedBy' => Auth::user()->id,
                                'approvedBy' => " ",
                                'approvalStatus' =>  " ",
                                'created_at' => date('Y-m-d')
                            ]);
                        } else {
                            DB::table('tblstaffcvtemp')->insert([
                                'tblstaffcvId' => $initialCv->ID,
                                'divisionId' => $initialCv->divisionID,
                                'staffId' => $initialCv->staffid,
                                'fileNo' => $initialCv->fileNo,
                                'cvtype' => $initialCv->cvtype,
                                'cvId' => $initialCv->cvID,
                                'oldAmount' => $initialCv->amount,
                                'newAmount' => $request['amount-edit'],
                                'targetAmount' => $initialCv->targetAmount,
                                'remark' => $request['remarks'],
                                'status' => $initialCv->status,
                                'recycling' => $initialCv->recycling,
                                'requestedBy' => Auth::user()->id,
                                'created_at' => date('Y-m-d')
                            ]);
                        }
                    }

                    $data['staff'] = $this->getStaffInfo($request['fileNofordelete']);

                    $data['staffLastNetEmolument'] = DB::table('tblpayment_consolidated')
                        ->where('tblpayment_consolidated.fileNo', '=', $data['staff']->fileNo)
                        ->orderBy('ID', 'DESC') // Order by 'ID' in descending order to get the latest record
                        ->first(); // Get the first record from the ordered result
                    $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);
                }
            }



            if (isset($_POST['add'])) {
                if ((!empty($request['amount']) && is_numeric($request['amount'])) && !empty($request['cvdesc']) && !empty($request['fileNo'])) {

                    //submit this control variable
                    $court = $data['court'];
                    $division = $request['division'];
                    $fileno = $request['fileNo'];
                    $cvid = $request['cvdesc'];
                    $amount = $request['amount'];
                    $tamount = $request['tamount'];
                    $hiddenrecycle = $request['hiddenrecycle'];
                    $hiddenlimit = $request['hiddenlimit'];
                    if ($this->checker($court, $division, $fileno)) {

                        //check if the cvID already exists in the DB
                        // $count = DB::table('tblstaffCV')->where('cvID', $cvid)->where('staffid', $fileno)->count();
                        // if($count > 0){
                        //     $data['error'] = 'You cannot add more of such Control variable, you can only update!';
                        // } else {
                        $cvtype = $data['cvtype'];
                        if (DB::insert("INSERT INTO tblstaffCV (`courtID`, `divisionID`, `staffid`, `cvID`, `amount`, `targetAmount`, `cvtype`,`recycling`)
                            VALUES ('$court', '$division', '$fileno', '$cvid', '$amount', '$tamount', '$cvtype', '$hiddenlimit')")) {
                            // Store a piece of data in the session...
                            $data['success'] = 'Staff Control Variable was added successfully!';


                            $data['hiddenlimit']  = 0;
                            $data['hiddenrecycle'] = 0;
                            $data['amount']         = '';
                            $data['tamount']        = '';
                            $data['tablecontent']   = $this->getTableContent($request['fileNo'], $data['court'], $request['division']);
                        } else {
                            $data['error'] = 'Oops! something went wrong, Please try again later!';
                        }
                        // }
                    } else {
                        $data['error'] = 'Please refresh this page';
                    }
                } else {
                    $data['error'] = 'Enter a valid input';
                }
            }
        }

        $data['EarningDeductionType']         = $this->EarningDeductionType();
        // dd($data['EarningDeductionType']);
        return view('payroll.CVModule.cvmodule', $data);
    }
    public function indexHead(Request $request)
    {
        // dd("stop");
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }


        $data['courtDivisions']  = DB::table('tbldivision')
            ->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);

        $data['courtList']          = $this->getCourts();
        $data['courtdivision']  = [];
        $data['getedj']         = [];
        $data['fileNo']         = ($request['fileNo']) ? $request['fileNo'] : $request['fileNofordelete'];
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['courtstaff']     = [];
        $data['hiddenlimit']        = ($request['hiddenlimit']) ? $request['hiddenlimit'] : 0;
        $data['hiddenrecycle']        = ($request['hiddenrecycle']) ? $request['hiddenrecycle'] : 0;;
        $data['cvtype']        = $request['cvtype'];
        $data['cvdesc']         = $this->getCVHEAD($data['cvtype']);

        $data['amount']         = $request['amount'];
        $data['tamount']         = $request['tamount'];

        $data['staff'] = $this->getStaffInfo($request['fileNo']);
        $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);


        if (Auth::user()->is_global == 1) {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.staff_status', '=', 1)
                ->orderBy('surname', 'Asc')
                ->get();
        } else {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.divisionID', '=', $data['curDivision']->divisionID)
                ->where('tblper.staff_status', '=', 1)
                ->orderBy('surname', 'Asc')
                ->get();
        }

        // dd($data['staff']->fileNo);

        $data['staffLastNetEmolument'] = DB::table('tblpayment_consolidated')
            ->where('tblpayment_consolidated.fileNo', '=', $data['staff']->fileNo)
            ->orderBy('ID', 'DESC') // Order by 'ID' in descending order to get the latest record
            ->first(); // Get the first record from the ordered result

        if ($data['court'] !== null) {

            $data['courtdivision'] = $this->getCourtDivision($data['court']);

            if ($request['division'] !== null) {
                // dd($request->all());
                if (!empty($request['fileNofordelete'])) {

                    if ($request['deleteid'] !== null) {
                        if ($this->deleteControlVariable($request['deleteid'])) {

                            $data['success'] = 'Staff Control Variable Deleted!';
                        } else {

                            $data['error'] = 'Oops! Staff Control variable not deleted!';
                        }
                    } elseif ($request['edit-hidden'] !== null) {
                        //get initial staffcv
                        $initialCv = DB::table('tblstaffCV')->where('ID', $request['edit-hidden'])->first();
                        $existingCvTemp = DB::table('tblstaffcvtemp')->where('tblstaffcvId', $request['edit-hidden'])->first();

                        if ($existingCvTemp) {
                            DB::table('tblstaffcvtemp')->where('tblstaffcvId', $request['edit-hidden'])->update([
                                'newAmount' => $request['amount-edit'],
                                'remark' => $request['remarks'] ? $request['remarks'] : $existingCvTemp->remark,
                                'requestedBy' => Auth::user()->id,
                                'approvedBy' => " ",
                                'approvalStatus' =>  " ",
                                'created_at' => date('Y-m-d')
                            ]);
                        } else {
                            DB::table('tblstaffcvtemp')->insert([
                                'tblstaffcvId' => $initialCv->ID,
                                'divisionId' => $initialCv->divisionID,
                                'staffId' => $initialCv->staffid,
                                'fileNo' => $initialCv->fileNo,
                                'cvtype' => $initialCv->cvtype,
                                'cvId' => $initialCv->cvID,
                                'oldAmount' => $initialCv->amount,
                                'newAmount' => $request['amount-edit'],
                                'targetAmount' => $initialCv->targetAmount,
                                'remark' => $request['remarks'],
                                'status' => $initialCv->status,
                                'recycling' => $initialCv->recycling,
                                'requestedBy' => Auth::user()->id,
                                'created_at' => date('Y-m-d')
                            ]);
                        }
                    }

                    $data['staff'] = $this->getStaffInfo($request['fileNofordelete']);

                    $data['staffLastNetEmolument'] = DB::table('tblpayment_consolidated')
                        ->where('tblpayment_consolidated.fileNo', '=', $data['staff']->fileNo)
                        ->orderBy('ID', 'DESC') // Order by 'ID' in descending order to get the latest record
                        ->first(); // Get the first record from the ordered result
                    $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);
                }
            }



            if (isset($_POST['add'])) {
                if ((!empty($request['amount']) && is_numeric($request['amount'])) && !empty($request['cvdesc']) && !empty($request['fileNo'])) {

                    //submit this control variable
                    $court = $data['court'];
                    $division = $request['division'];
                    $fileno = $request['fileNo'];
                    $cvid = $request['cvdesc'];
                    $amount = $request['amount'];
                    $tamount = $request['tamount'];
                    $hiddenrecycle = $request['hiddenrecycle'];
                    $hiddenlimit = $request['hiddenlimit'];
                    if ($this->checker($court, $division, $fileno)) {

                        //check if the cvID already exists in the DB
                        // $count = DB::table('tblstaffCV')->where('cvID', $cvid)->where('staffid', $fileno)->count();
                        // if($count > 0){
                        //     $data['error'] = 'You cannot add more of such Control variable, you can only update!';
                        // } else {
                        $cvtype = $data['cvtype'];
                        if (DB::insert("INSERT INTO tblstaffCV (`courtID`, `divisionID`, `staffid`, `cvID`, `amount`, `targetAmount`, `cvtype`,`recycling`)
                            VALUES ('$court', '$division', '$fileno', '$cvid', '$amount', '$tamount', '$cvtype', '$hiddenlimit')")) {
                            // Store a piece of data in the session...
                            $data['success'] = 'Staff Control Variable was added successfully!';


                            $data['hiddenlimit']  = 0;
                            $data['hiddenrecycle'] = 0;
                            $data['amount']         = '';
                            $data['tamount']        = '';
                            $data['tablecontent']   = $this->getTableContent($request['fileNo'], $data['court'], $request['division']);
                        } else {
                            $data['error'] = 'Oops! something went wrong, Please try again later!';
                        }
                        // }
                    } else {
                        $data['error'] = 'Please refresh this page';
                    }
                } else {
                    $data['error'] = 'Enter a valid input';
                }
            }
        }

        $data['EarningDeductionType']         = $this->EarningDeductionType();
        // dd($data['EarningDeductionType']);
        return view('payroll.CVModule.cvmoduleHead', $data);
    }

    public function indexHeadOffice(Request $request)
    {
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }


        $data['courtDivisions']  = DB::table('tbldivision')
            //  ->where('courtID', '=', $courtSessionId)
            ->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);
        // dd($data['curDivision'] );

        $data['courtList']          = $this->getCourts();
        $data['courtdivision']  = [];
        $data['getedj']         = [];
        $data['fileNo']         = ($request['fileNo']) ? $request['fileNo'] : $request['fileNofordelete'];
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['courtstaff']     = [];
        $data['hiddenlimit']        = ($request['hiddenlimit']) ? $request['hiddenlimit'] : 0;
        $data['hiddenrecycle']        = ($request['hiddenrecycle']) ? $request['hiddenrecycle'] : 0;;
        $data['cvtype']        = $request['cvtype'];
        $data['cvdesc']         = $this->getCV($data['cvtype']);

        $data['amount']         = $request['amount'];
        $data['tamount']         = $request['tamount'];

        $data['staff'] = $this->getStaffInfo($request['fileNo']);
        $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);



        // $data['courtstaff'] = $this->getStaffinDivision( $request['division'] );

        if (Auth::user()->is_global == 1) {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->orderBy('surname', 'Asc')
                ->get();
        } else {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.divisionID', '=', $data['curDivision']->divisionID)
                ->orderBy('surname', 'Asc')
                ->get();
        }

        // dd($data['courtstaff']);

        if ($data['court'] !== null) {

            $data['courtdivision'] = $this->getCourtDivision($data['court']);
            if ($request['division'] !== null) {

                if (!empty($request['fileNofordelete'])) {
                    if ($request['deleteid'] !== null) {
                        if ($this->deleteControlVariable($request['deleteid'])) {

                            $data['success'] = 'Staff Control Variable Deleted!';
                        } else {

                            $data['error'] = 'Oops! Staff Control variable not deleted!';
                        }
                    } elseif ($request['edit-hidden'] !== null) {
                        //get initial staffcv
                        $initialCv = DB::table('tblstaffCV')->where('ID', $request['edit-hidden'])->first();
                        $existingCvTemp = DB::table('tblstaffcvtemp')->where('tblstaffcvId', $request['edit-hidden'])->first();
                        if ($existingCvTemp) {
                            DB::table('tblstaffcvtemp')->where('tblstaffcvId', $request['edit-hidden'])->update([
                                'newAmount' => $request['amount-edit'],
                                'remark' => $request['remarks'] ? $request['remarks'] : $existingCvTemp->remark,
                                'requestedBy' => Auth::user()->id,
                                'created_at' => date('Y-m-d')
                            ]);
                        } else {
                            DB::table('tblstaffcvtemp')->insert([
                                'tblstaffcvId' => $initialCv->ID,
                                'divisionId' => $initialCv->divisionID,
                                'staffId' => $initialCv->staffid,
                                'fileNo' => $initialCv->fileNo,
                                'cvtype' => $initialCv->cvtype,
                                'cvId' => $initialCv->cvID,
                                'oldAmount' => $initialCv->amount,
                                'newAmount' => $request['amount-edit'],
                                'targetAmount' => $initialCv->targetAmount,
                                'remark' => $request['remarks'],
                                'status' => $initialCv->status,
                                'recycling' => $initialCv->recycling,
                                'requestedBy' => Auth::user()->id,
                                'created_at' => date('Y-m-d')
                            ]);
                        }
                    }
                    $data['staff'] = $this->getStaffInfo($request['fileNofordelete']);
                    $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);
                }
            }

            if (isset($_POST['add'])) {
                if ((!empty($request['amount']) && is_numeric($request['amount'])) && !empty($request['cvdesc']) && !empty($request['fileNo'])) {

                    //submit this control variable
                    $court = $data['court'];
                    $division = $request['division'];
                    $fileno = $request['fileNo'];
                    $cvid = $request['cvdesc'];
                    $amount = $request['amount'];
                    $tamount = $request['tamount'];
                    $hiddenrecycle = $request['hiddenrecycle'];
                    $hiddenlimit = $request['hiddenlimit'];
                    if ($this->checker($court, $division, $fileno)) {

                        //check if the cvID already exists in the DB
                        // $count = DB::table('tblstaffCV')->where('cvID', $cvid)->where('staffid', $fileno)->count();
                        // if($count > 0){
                        //     $data['error'] = 'You cannot add more of such Control variable, you can only update!';
                        // } else {
                        $cvtype = $data['cvtype'];
                        if (DB::insert("INSERT INTO tblstaffCV (`courtID`, `divisionID`, `staffid`, `cvID`, `amount`, `targetAmount`, `cvtype`,`recycling`)
                            VALUES ('$court', '$division', '$fileno', '$cvid', '$amount', '$tamount', '$cvtype', '$hiddenlimit')")) {
                            // Store a piece of data in the session...
                            $data['success'] = 'Staff Control Variable was added successfully!';


                            $data['hiddenlimit']  = 0;
                            $data['hiddenrecycle'] = 0;
                            $data['amount']         = '';
                            $data['tamount']        = '';
                            $data['tablecontent']   = $this->getTableContent($request['fileNo'], $data['court'], $request['division']);
                        } else {
                            $data['error'] = 'Oops! something went wrong, Please try again later!';
                        }
                        // }
                    } else {
                        $data['error'] = 'Please refresh this page';
                    }
                } else {
                    $data['error'] = 'Enter a valid input';
                }
            }
        }
        $data['EarningDeductionType']         = $this->EarningDeductionType();
        return view('payroll.CVModule.cvmoduleHeadOffice', $data);
    }

    public function approval(Request $request)
    {
        if ($request->deleteid) {
            DB::table('tblstaffcvtemp')->where('id', '=', $request->deleteid)->delete();
        }

        if ($request->editStaffCv) {
            DB::table('tblstaffcvtemp')->where('tblstaffcvId', '=', $request['editStaffCv'])->update([
                'approvedBy' => Auth::user()->id,
                'approvalStatus' => 1
            ]);
            $this->editControlVariable($request['editStaffCv'], $request['amount'], $request['remark']);
        }

        $data['pending'] = DB::table('tblstaffcvtemp')->where('approvalStatus', '=', null)->count();

        $data['staffCvTemp'] = DB::table('tblstaffcvtemp')
            ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblstaffcvtemp.cvId')
            ->leftjoin('tblper', 'tblper.ID', '=', 'tblstaffcvtemp.staffId')
            ->leftjoin('users as requester', 'requester.id', '=', 'tblstaffcvtemp.requestedBy')
            ->leftjoin('users as approval', 'approval.id', '=', 'tblstaffcvtemp.approvedBy')
            ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblstaffcvtemp.divisionId')
            ->select('tblstaffcvtemp.*', 'tblcvSetup.description', 'tblper.surname', 'tblper.first_name', 'tblper.othernames', 'tbldivision.division',  'approval.name as approvalName',  'requester.name as requesterName')
            ->orderBy('tblstaffcvtemp.approvalStatus', 'ASC')
            // ->get();
            ->paginate(50);
        return view('payroll.CVModule.approval', $data);
    }

    public function backlogindex(Request $request)
    {
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }
        $data['fileNo']         = ($request['fileNo']);
        $data['courtList']          = $this->getCourts();
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['courtstaff']     = [];

        $data['courtDivisions']  = DB::table('tbldivision')
            //  ->where('courtID', '=', $courtSessionId)
            ->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);

        if (isset($_POST['add'])) {
            $this->validate($request, [
                'fileNo'      => 'required|string',
                'nmonth'      => 'required|string',
                'remarks'      => 'required|string'
            ]);
            DB::table('tblbacklog')->insert([
                'staffid' => $request->input('fileNo'),
                'remarks' => $request->input('remarks'),
                'mcount' => $request->input('nmonth') != '' ? $request->input('nmonth') : 0,
                'dcount' => $request->input('nday') != '' ? $request->input('nday') : 0,
                'of_particular_month' => $request->input('ndaycount') != '' ? $request->input('ndaycount') : 30,
            ]);
            //$staff = $this->getOneStaff($request['fileNo']);
            //$this->addLog("Backlog added for $staff->surname $staff->first_name $staff->othernames with File Number $staff->fileNo ");
            return back()->with('message', 'Successfully added.');
        }

        if (isset($_POST['update'])) {
            $this->validate($request, [
                'nmonth'      => 'required|string',
                'remarks'      => 'required|string'
            ]);
            DB::table('tblbacklog')->where('id', $request->input('id'))->update([
                'remarks' => $request->input('remarks'),
                'mcount' => $request->input('nmonth') != '' ? $request->input('nmonth') : 0,
                'dcount' => $request->input('nday') != '' ? $request->input('nday') : 0,
                'of_particular_month' => $request->input('ndaycount') != '' ? $request->input('ndaycount') : 30,
            ]);
            //$staff = $this->getOneStaff($request['fileNo']);
            //$this->addLog("Backlog added for $staff->surname $staff->first_name $staff->othernames with File Number $staff->fileNo ");
            return back()->with('message', 'Successfully added.');
        }

        if (isset($_POST['delete'])) {
            $this->validate($request, [
                'id'      => 'required|string',
            ]);
            $id = $request->input('id');
            // dd($data['courtstaff']);
            DB::delete("DELETE FROM `tblbacklog` WHERE `id`='$id'");
            return back()->with('message', 'Successfully removed. Kindly recompute to correct the payroll report');
        }

        $data['staff'] = $this->getStaffInfo($request['fileNo']);
        // $data['courtstaff'] = $this->getStaffinDivision( $data['court'], $request['division'] );
        $data['backloglist'] = $this->StaffBackloglist();

        if (Auth::user()->is_global == 1) {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                // ->where('tblper.divisionID', '=', $data['curDivision']->divisionID)
                //->where('courtID','=', $data['CourtInfo']->courtid)
                ->orderBy('surname', 'Asc')
                ->get();
        } else {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.divisionID', '=', $data['curDivision']->divisionID)
                ->orderBy('surname', 'Asc')
                ->get();
        }

        // dd( $data['courtstaff'] );
        return view('payroll.CVModule.backlogs', $data);
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

    public function ActiveControlVariable(Request $request)
    {
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }
        $data['fileNo']         = ($request['fileNo']);
        $data['courtList']          = $this->getCourts();
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['cv'] = $request['cv'];
        $data['cvtype']        = $request['cvtype'];
        $data['cvdesc']         = $this->getCV($data['cvtype']);
        $data['EarningDeductionType']         = $this->EarningDeductionType();
        $data['staffCVList'] = $this->StaffCVlist($data['cv']);
        return view('CVModule.staffcvlist', $data);
    }
    public function overrideOvertime(Request $request)
    {
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }
        $data['fileNo']         = ($request['fileNo']);
        $data['courtList']          = $this->getCourts();
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['courtstaff']     = [];

        // dd($data['courtstaff']);

        if (isset($_POST['add'])) {
            $this->validate($request, [
                'fileNo'      => 'required|string',
                'gross'      => 'required|numeric|between:0,9999999999999999.99',
                'tax'      => 'required|numeric|between:0,9999999999999999.99',
                'remarks'      => 'required|string'
            ]);
            if (DB::table('tblspecial_overtime_overide')->where('staffid', $request->input('fileNo'))->first()) {
                DB::table('tblspecial_overtime_overide')->where('staffid', $request->input('fileNo'))->update(array(
                    'gross'    => $request->input('gross'),
                    'tax'    => $request->input('tax'),
                    'remarks'        => $request->input('remarks'),
                ));
            } else {
                DB::table('tblspecial_overtime_overide')->insert([
                    'staffid' => $request->input('fileNo'),
                    'gross' => $request->input('gross'),
                    'tax' => $request->input('tax'),
                    'remarks' => $request->input('remarks'),
                ]);
            }
            $staff = $this->getOneStaff($request['fileNo']);
            //$this->addLog("update special overrime for $staff->surname $staff->first_name $staff->othernames with File Number $staff->fileNo ");
            return back()->with('message', 'Successfully added.');
        }
        $data['staff'] = $this->getStaffInfo($request['fileNo']);
        $data['courtstaff'] = $this->getStaffinDivision($data['court'], $request['division']);
        $data['backloglist'] = $this->StaffOvertimeSpecial();
        return view('CVModule.overtime', $data);
    }

    public function additionalAllowance(Request $request)
    {
        $data['success'] = "";
        $data['error']   = "";
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }


        $data['courtDivisions']  = DB::table('tbldivision')
            //  ->where('courtID', '=', $courtSessionId)
            ->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);
        // dd($data['curDivision'] );

        $data['courtList']          = $this->getCourts();
        $data['courtdivision']  = [];
        $data['getedj']         = [];
        $data['fileNo']         = ($request['fileNo']) ? $request['fileNo'] : $request['fileNofordelete'];
        $data['court']          = $request['court'];
        $data['division']       = $request['division'];
        $data['courtstaff']     = [];
        $data['hiddenlimit']        = ($request['hiddenlimit']) ? $request['hiddenlimit'] : 0;
        $data['hiddenrecycle']        = ($request['hiddenrecycle']) ? $request['hiddenrecycle'] : 0;;
        $data['cvtype']        = $request['cvtype'];
        $data['cvdesc']         = $this->getCV($data['cvtype']);

        $data['amount']         = $request['amount'];
        $data['tamount']         = $request['tamount'];

        $data['staff'] = $this->getStaffInfo($request['fileNo']);
        $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);



        // $data['courtstaff'] = $this->getStaffinDivision( $request['division'] );

        if (Auth::user()->is_global == 1) {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->orderBy('surname', 'Asc')
                ->get();
        } else {
            # code...
            $data['courtstaff'] = DB::table('tblper')
                ->where('tblper.divisionID', '=', $data['curDivision']->divisionID)
                ->orderBy('surname', 'Asc')
                ->get();
        }

        // dd($data['courtstaff']);

        if ($data['court'] !== null) {

            $data['courtdivision'] = $this->getCourtDivision($data['court']);
            if ($request['division'] !== null) {



                if (!empty($request['fileNofordelete'])) {
                    if ($request['deleteid'] !== null) {
                        if ($this->deleteControlVariable($request['deleteid'])) {

                            $data['success'] = 'Staff Control Variable Deleted!';
                        } else {

                            $data['error'] = 'Oops! Staff Control variable not deleted!';
                        }
                    } elseif ($request['edit-hidden'] !== null) {
                        $this->editControlVariable($request['edit-hidden'], $request['amount-edit'], $request['remarks']);
                    }
                    $data['staff'] = $this->getStaffInfo($request['fileNofordelete']);
                    $data['tablecontent']   = $this->getTableContent($data['fileNo'], $data['court'], $request['division']);
                }
            }

            if (isset($_POST['add'])) {
                if ((!empty($request['amount']) && is_numeric($request['amount'])) && !empty($request['cvdesc']) && !empty($request['fileNo'])) {

                    //submit this control variable
                    $court = $data['court'];
                    $division = $request['division'];
                    $fileno = $request['fileNo'];
                    $cvid = $request['cvdesc'];
                    $amount = $request['amount'];
                    $tamount = $request['tamount'];
                    $hiddenrecycle = $request['hiddenrecycle'];
                    $hiddenlimit = $request['hiddenlimit'];
                    if ($this->checker($court, $division, $fileno)) {

                        //check if the cvID already exists in the DB
                        // $count = DB::table('tblstaffCV')->where('cvID', $cvid)->where('staffid', $fileno)->count();
                        // if($count > 0){
                        //     $data['error'] = 'You cannot add more of such Control variable, you can only update!';
                        // } else {
                        $cvtype = $data['cvtype'];
                        if (DB::insert("INSERT INTO tblstaffCV (`courtID`, `divisionID`, `staffid`, `cvID`, `amount`, `targetAmount`, `cvtype`,`recycling`)
                            VALUES ('$court', '$division', '$fileno', '$cvid', '$amount', '$tamount', '$cvtype', '$hiddenlimit')")) {
                            // Store a piece of data in the session...
                            $data['success'] = 'Staff Control Variable was added successfully!';


                            $data['hiddenlimit']  = 0;
                            $data['hiddenrecycle'] = 0;
                            $data['amount']         = '';
                            $data['tamount']        = '';
                            $data['tablecontent']   = $this->getTableContent($request['fileNo'], $data['court'], $request['division']);
                        } else {
                            $data['error'] = 'Oops! something went wrong, Please try again later!';
                        }
                        // }
                    } else {
                        $data['error'] = 'Please refresh this page';
                    }
                } else {
                    $data['error'] = 'Enter a valid input';
                }
            }
        }
        $data['EarningDeductionType']  = DB::table('tblcvSetup')
            ->where('tblcvSetup.particularID', '=', 2)
            ->get();
        $data['tablecontent'] = DB::table('tbladditional_allowance')
            ->join('tblcvSetup', 'tblcvSetup.ID', '=', 'tbladditional_allowance.earning_ID')
            ->get();
        return view('payroll.allowance.additionalAllowance', $data);
    }
    public function saveadditionalAllowance(Request $request)
    {
        $this->validate($request, [

            // 'staffID'      => 'required|numeric',
            'deductionID'      => 'required|numeric',
            'amount'      => 'required|numeric',
            'date'      => 'required|date',
            'remark'      => 'required|string'
        ]);
        DB::table('tbladditional_allowance')->insert([
            'name' => $request->input('name'),
            // 'divisionID' => $request->input('division'),
            'earning_ID' => $request->input('deductionID'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'remark' => $request->input('remark'),
        ]);

        // return redirect('addition-allowance')->with('message', 'allowance added');
        return redirect()->back()->with('success', 'Other allowance saved successfully!');
    }
    public function editadditionalAllowance(Request $request)
    {
        $this->validate($request, [

            // 'staffID'      => 'required|numeric',
            'deductionID'      => 'required|numeric',
            'amount'      => 'required|numeric',
            'date'      => 'required|date',
            'remark'      => 'required|string'
        ]);
        $id = $request->input('id');
        DB::table('tbladditional_allowance')->where('id', '=', $id)->update([
            'name' => $request->input('name'),
            // 'divisionID' => $request->input('division'),
            'earning_ID' => $request->input('deductionID'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'remark' => $request->input('remark'),
        ]);

        // return redirect('/addition-allowance')->with('message', 'allowance updated');
        return redirect()->back()->with('success', 'allowance updated successfully!');
    }
    public function deleteadditionalAllowance(Request $request)
    {

        $id = $request->input('id');
        DB::table('tbladditional_allowance')->where('id', '=', $id)->delete();

        // return redirect('/addition-allowance')->with('message', 'allowance deleted');
        return redirect()->back()->with('success', 'allowance deleted successfully!');
    }


    public function allocation(Request $request)
    {
        $data['division'] = DB::table('tbldivision')->get();

        $data['allocation'] = DB::table('tblallocation')
            ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblallocation.division')
            ->orderBy('tblallocation.id', 'desc') // show newest first
            ->get();

        return view('payroll.allowance.allocation', $data);
    }

    public function saveallocation(Request $request)
    {
        $this->validate($request, [
            'year'      => 'required',
            'amount'      => 'required|numeric',
            'date'      => 'required|date',
            'month'      => 'required',
            'division'  => 'required'
        ]);
        DB::table('tblallocation')->insert([
            'year' => $request->input('year'),
            'month' => $request->input('month'),
            'date' => $request->input('date'),
            'amount' => $request->input('amount'),
            'division' => $request->input('division'),

        ]);


        return redirect()->back()->with('saved', 'Allocation created successfully!');
    }

    public function updateallocation(Request $request)
    {
        $this->validate($request, [
            'year'      => 'required',
            'amount'      => 'required|numeric',
            'date'      => 'required|date',
            'month'      => 'required',
            'division'  => 'required'
        ]);
        $id = $request->input('id');
        DB::table('tblallocation')->where('id', '=', $id)->update([
            'year' => $request->input('year'),
            'month' => $request->input('month'),
            'date' => $request->input('date'),
            'amount' => $request->input('amount'),
            'division' => $request->input('division'),

        ]);


        return redirect()->back()->with('success', 'Allocation updated successfully!');
    }
    public function deleteallocation(Request $request)
    {

        $id = $request->input('id');
        DB::table('tblallocation')->where('id', '=', $id)->delete();


        return redirect()->back()->with('deleted', 'Allocation deleted successfully!');
    }

    public function staff(Request $request)
    {

        $user = Auth::user()->divisionID;
        $data['staff'] = [];

        if (Auth::user()->is_global == 1) {
            # code...
            $data['division'] = DB::table('tbldivision')
                ->get();
        } else {
            # code...
            $data['staffdivision'] = DB::table('tbldivision')
                ->where('tbldivision.divisionID', '=', $user)
                ->get();
        }
        if (isset($_POST['add'])) {
            if (Auth::user()->is_global == 1) {
                $data['staff'] = '';
                if ($request['division'] != '') {
                    $data['staff'] = DB::table('tblstaffCV')
                        ->join('tblper', 'tblper.ID', '=', 'tblstaffCV.staffid')
                        ->join('tblCVsetup', 'tblCVsetup.ID', '=', 'tblstaffCV.cvID')
                        ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblstaffCV.divisionID')
                        ->where('tblstaffCV.divisionID', '=', $request['division'])
                        ->where('tblCVsetup.status', '=', 0)
                        ->get();
                } else {
                    $data['staff'] = DB::table('tblstaffCV')
                        ->join('tblper', 'tblper.ID', '=', 'tblstaffCV.staffid')
                        ->join('tblCVsetup', 'tblCVsetup.ID', '=', 'tblstaffCV.cvID')
                        ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblstaffCV.divisionID')
                        // ->where('tblstaffcv.divisionID', '=', $request['division'])
                        ->where('tblCVsetup.status', '=', 0)
                        ->get();
                }
            } else {
                $data['staff'] = DB::table('tblstaffCV')
                    ->join('tblper', 'tblper.ID', '=', 'tblstaffCV.staffid')
                    ->join('tblCVsetup', 'tblCVsetup.ID', '=', 'tblstaffCV.cvID')
                    ->where('tblstaffCV.divisionID', '=', $user)
                    ->where('tblCVsetup.status', '=', 0)
                    ->get();
            }
        }

        return view('payroll.controlVariable.staff', $data);
    }
}
