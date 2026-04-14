<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use App\Http\Controllers\Controller;
use Session;
use File;
use Auth;
use DB;


class ConfirmCompletionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->getUploadPath = env('UPLOADPATHROOT', null) . 'PaymentRequestDocument/';
        $this->getDownloadPath = env('UPLOADPATHROOT', null) . 'PaymentRequestDocument/';
    }

    //function to view list of all the biddings
    public function ApproveContracts()
    {
        /*
        $n  = 9;
        $ar = array('10','20','20','10','10','30','50','10','20');
        $result = array();
        $result = array_unique($ar);
        $r = array();


            foreach($result as $key => $value)
            {
                 if(in_array($value,$ar))
                 {
                     $r[] = $value;
                     $num = count($r);
                     if($num>1)
                     {
                        $c[] =  $value;
                     }
                 }
            }

             dd($c);
             */

        //$idx = base64_decode($id);
        $data['units'] = DB::table('tblunits')->get();

        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('tblcontract_bidding.status', 3)
            ->where('is_award_letter', 1)
            ->leftjoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->select('*', 'tblcontract_bidding.project_completion as complete')
            ->orderby('tblcontract_bidding.project_completion', 'desc')
            ->get();

        return view('procurement.Procurement.confirm_payment', $data);
    }

    public function uploadPaymentRequest($biddingIDx = null)
    {
        $success  = 0;
        $data    = [];
        $biddingID = base64_decode($biddingIDx);

        //confirm
        if ($biddingID <> null && DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->first()) {
            //load confirm form
            try {
                $data['recordDetails'] = DB::table('tblcontract_bidding')->where('tblcontract_bidding.contract_biddingID', $biddingID)
                    ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
                    ->join('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
                    ->select('tblcontract_bidding.contract_biddingID as biddingID', 'tblcontractor_registration.company_name', 'tblcontract_details.contract_name')
                    ->first();
            } catch (\Throwable $e) {
            }
            return view('procurement.Procurement.upload_payment_request', $data);
        } else {
            return redirect()->back()->with('info', 'Record details not found');
        }
    }


    //approve contract and pust back to procurement unit
    public function push(Request $request)
    {
        $contractID  =   $request->input('cid');
        $contractor  =   $request->input('contractor');
        $unit        =   $request->input('unit');
        $comment     =   $request->input('comment');

        //dd($unit);
        $filename = "";

        if ($request->hasfile('images1')) {
            $this->validate($request, [

                'images1'           =>  'required|mimes:png,jpg,jpe,jpeg,pdf|max: 5000',
                'file_description'  =>  'required|string',

            ]);

            $file = $request->file('images1');
            $desc = $request->input('file_description');

            $filename = $file->getClientOriginalName();
            $file->move(public_path('PaymentRequestDocument'), $filename);

            DB::table('tblpayment_request_doc')->insert([
                'contractID'   => $contractID,
                'contractorID' => $contractor,
                'file_name'    => $filename,
                'file_description' => $desc,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ]);
        }


        DB::table('tblcontract_bidding')->where('contractID', $contractID)->where('contractorID', $contractor)->update(['role_unit_id' => $unit]);
        DB::table('tblcontract_comment')->insert(['contractID' => $contractID, 'comment_description' => $comment, 'created_by' => Auth::user()->id, 'created_at' => date('Y-m-d')]);

        return back()->with('msg', 'Successfully pushed to ', $unit);
    }

    public function uploadRequest(Request $request)
    {
        $this->validate($request, [
            'biddingID'         => 'required|numeric',
            'document.*'        => 'required|mimes:png,jpg,jpe,jpeg,pdf|max: 5000',
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
            return redirect()->route('confirm-completion')->with('message', 'Your file(s) was successfully uploaded.');
        } else {
            return redirect()->route('confirm-completion')->with('error', 'Sorry, your file(s) was not uploaded.');
        }
    }

    public function uploadAnyFile($file = null, $uploadCompletePathName = null, $maxFileSize = 10, $newExtension = null, $newRadFileName = true)
    {
        $data = new AnyFileUploadClass($file, $uploadCompletePathName, $maxFileSize, $newExtension, $newRadFileName);

        return $data->return();
    } //end function

    //create contract List
    public function viewContractList($id)
    {
        $decode_id = base64_decode($id);



        $data['item'] = DB::table('tblcontract_details')
            ->where('tblcontract_details.contract_detailsID', $decode_id)
            ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
            ->leftJoin('protblstatus', 'protblstatus.status_code', '=', 'tblcontract_details.status')
            ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
            ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
            ->select('tblcontract_details.*', 'status_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name')
            ->first();


        return view('procurement.Contract.viewcontractList', $data);
    }
}//end class
