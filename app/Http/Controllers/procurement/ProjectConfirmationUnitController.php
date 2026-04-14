<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use DB;


class ProjectConfirmationUnitController extends Controller
{
    private $contractRepoController;


    public function __construct()
    {
        $this->middleware('auth');
        $this->getUploadPath = env('UPLOADPATHROOT', null) . 'PaymentRequestDocument/';
        $this->getDownloadPath = env('UPLOADPATHROOT', null) . 'PaymentRequestDocument/';
    }


    //create contract Details
    public function contractList()
    {
        $allFile = [];
        $data    = [];

        try {
            $data['getContractDetails'] = $this->queryContractDetails(50); //($roleUnitID = 3, $pagination = 10)
            foreach ($data['getContractDetails'] as $key => $item) {
                $allFile[$key] = DB::table('tblpayment_request_doc')
                    ->where('contractID', $item->contract_detailsID)
                    ->where('contractorID', $item->contractor_registrationID)
                    ->orderBy('payment_requestID', 'Desc')
                    ->get();
            }

            $data['getAllFiles'] = $allFile;
        } catch (\Throwable $e) {
            $data['getContractCategory'] = [];
        }

        return view('procurement.projectConfirmationUnit.listContract', $data);
    }


    //create Item/Project Confirmation
    public function projectCompletionUploadFile($biddingID = null)
    {
        $success  = 0;
        $data    = [];

        //confirm
        if ($biddingID <> null && DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->first()) {
            //load confirm form
            try {
                $data['recordDetails'] = DB::table('tblcontract_bidding')->where('tblcontract_bidding.contract_biddingID', $biddingID)
                    ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
                    ->join('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
                    ->select('contract_detailsID', 'contractor_registrationID', 'awarded_amount', 'tblcontract_details.lot_number', 'tblcontract_details.proposed_budget', 'tblcontract_bidding.contract_biddingID as biddingID', 'tblcontractor_registration.company_name', 'tblcontract_details.contract_name')
                    ->first();
            } catch (\Throwable $e) {
            }

            //////////GET ALL ATTACHED FILES////////////
            try {
                $data['allFile'] = [];
                if ($data['recordDetails']) {
                    $data['allFile'] = DB::table('tblpayment_request_doc')
                        ->where('contractID', $data['recordDetails']->contract_detailsID)
                        ->where('contractorID', $data['recordDetails']->contractor_registrationID)
                        ->orderBy('payment_requestID', 'Desc')
                        ->get();
                }
            } catch (\Throwable $e) {
            }
            ///////

            return view('procurement.projectConfirmationUnit.confirmProject', $data);
        } else {
            return redirect()->back()->with('info', 'Record details not found');
        }
    }

    //Delete deleteProjectUploadFIle
    public function deleteProjectUploadFIle($fileID = null)
    {
        $success = 0;
        if ($fileID <> null) {
            $success = DB::table('tblpayment_request_doc')->where('payment_requestID', $fileID)->delete();
        }
        if ($success) {
            return redirect()->back()->with('message', 'Your record was removed successfully.');
        }
        return redirect()->back()->with('info', 'Sorry, we cannot remove this file now! Please try again.');
    }


    //Confirm Completion of project
    public function createConfirm($biddingID = null)
    {
        $success  = 0;
        $data    = [];
        $allFile  = [];
        //confirm
        if ($biddingID <> null && DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->first()) {

            //Check if file has been upload
            $cDetails = DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->select('contractID', 'contractorID')->first();
            $allFile = DB::table('tblpayment_request_doc')->where('contractID', $cDetails->contractID)->where('contractorID', $cDetails->contractorID)->get();
            if (count($allFile) > 0) {
                try {
                    $success = DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['project_completion' => 5]);
                    $data['recordDetails'] = DB::table('tblcontract_bidding')->where('tblcontract_bidding.contract_biddingID', $biddingID)
                        ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
                        ->join('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
                        ->select('tblcontract_bidding.contract_biddingID as biddingID', 'tblcontractor_registration.company_name', 'tblcontract_details.contract_name')
                        ->first();
                } catch (\Throwable $e) {
                }
            } else {
                return redirect()->back()->with('info', 'No file/evidence file uploaded to this contract yet!');
            }
            //return view('projectConfirmationUnit.confirmProject', $data);
            return redirect()->route('contractList')->with('message', 'Your confirmation was completed successfully.');
        } else {
            return redirect()->back()->with('info', 'Record details not found');
        }
    }



    //create Item/Project Confirmation
    public function confirmProcess(Request $request)
    {
        $this->validate($request, [
            'biddingID'         => 'required|numeric',
            'document.*'        => 'required|mimes:png,jpg,jpe,jpeg,pdf|max: 5000',
            //'description.*'     => 'required|string',
        ], ['biddingID' => 'record information']);

        $complete = 0;

        //try{
        $recordDetails = DB::table('tblcontract_bidding')->where('contract_biddingID', $request['biddingID'])->first();

        //Save document(s)
        if ($recordDetails && $request->hasFile('document')) {
            $descriptionArray = array();
            $getUploadDocumentPath = $this->getUploadPath;
            //get all description
            foreach ($request['description'] as $item) {
                $descriptionArray[] = $item;
            }

            foreach ($request['document'] as $keyDoc => $file) {
                $getArrayResponse = $this->uploadAnyFile($file, $getUploadDocumentPath);
                if ($getArrayResponse) {
                    if ($getArrayResponse['success']) {
                        $complete = DB::table('tblpayment_request_doc')->insertGetId([
                            'contractID'         => ($recordDetails ? $recordDetails->contractID : null),
                            'contractorID'       => ($recordDetails ? $recordDetails->contractorID : null),
                            'file_name'          => $getArrayResponse['newFileName'],
                            'file_description'   => $descriptionArray[$keyDoc],
                            'created_at'         => date('Y-m-d'),
                            'updated_at'         => date('Y-m-d'),
                            'created_by'         => (Auth::check() ? Auth::user()->id : null)
                        ]);
                    }
                }
            }
        }

        //}catch(\Throwable $e){}
        if ($complete) {
            //return redirect()->route('contractList')->with('message', 'Your file(s) was successfully uploaded.');
            return redirect()->back()->with('message', 'Your file(s) was successfully uploaded.');
        } else {
            return redirect()->route('contractList')->with('error', 'Sorry, your file(s) was not uploaded.');
        }
    }


    //Get Contract-bidding and contract detail
    public function queryContractDetails($pagenation = null)
    {
        $roleUnitID     = (Auth::check() ? Auth::user()->user_role : null);
        $unitID         = (Auth::check() ? Auth::user()->user_unit : null);
        $userType       = (Auth::check() ? Auth::user()->divisionID : null);

        try {
            if ($userType == 1) {
                //For Amdin
                return $setContractDetail = DB::table('tblcontract_bidding')
                    ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
                    ->leftJoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
                    ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                    ->leftJoin('protblstatus', 'protblstatus.statusID', '=', 'tblcontract_bidding.status')
                    ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                    ->where('tblcontract_bidding.status', 3)
                    ->where('tblcontract_bidding.role_unit_id', $roleUnitID)
                    ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                    ->select('tblcontract_details.*',  'awarded_amount', 'status_name', 'tblcontractor_registration.contractor_registrationID', 'tblcontract_bidding.project_completion as completionID', 'tblcontract_bidding.contract_biddingID as biddingID', 'tblcontractor_registration.company_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name')
                    ->paginate(100);
            } else {
                //Other Users
                if (is_numeric($pagenation)) {
                    return $setContractDetail = DB::table('tblcontract_bidding')
                        ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
                        ->leftJoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
                        ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                        ->leftJoin('tblstatus', 'tblstatus.statusID', '=', 'tblcontract_bidding.status')
                        ->join('tblcontract_category', 'tblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                        ->where('tblcontract_bidding.status', 3)
                        ->where('tblcontract_bidding.role_unit_id', $unitID)
                        ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                        ->select('tblcontract_details.*',  'awarded_amount', 'status_name', 'tblcontractor_registration.contractor_registrationID', 'tblcontract_bidding.project_completion as completionID', 'tblcontract_bidding.contract_biddingID as biddingID', 'tblcontractor_registration.company_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name')
                        ->paginate($pagenation);
                } else {
                    return $setContractDetail = DB::table('tblcontract_bidding')
                        ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
                        ->leftJoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
                        ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                        ->leftJoin('tblstatus', 'tblstatus.statusID', '=', 'tblcontract_bidding.status')
                        ->join('tblcontract_category', 'tblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                        ->where('tblcontract_bidding.status', 3)
                        ->where('tblcontract_bidding.role_unit_id', $unitID)
                        ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                        ->select('tblcontract_details.*', 'awarded_amount', 'status_name', 'tblcontractor_registration.contractor_registrationID', 'tblcontract_bidding.project_completion as completionID', 'tblcontract_bidding.contract_biddingID as biddingID', 'tblcontractor_registration.company_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name')
                        ->get();
                }
            }
        } catch (\Throwable $e) {
            return [];
        }
    } //fun


    //Reuseable Image File Upload Module
    public function uploadAnyFile($file = null, $uploadCompletePathName = null, $maxFileSize = 10, $newExtension = null, $newRadFileName = true)
    {
        $data = new AnyFileUploadClass($file, $uploadCompletePathName, $maxFileSize, $newExtension, $newRadFileName);

        return $data->return();
    } //end function







}//end class
