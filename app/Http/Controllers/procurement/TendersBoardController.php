<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;

class TendersBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function display()
    {
        $data['contract'] = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->where('tblcontract_details.status', '=', 1)
            ->where('tblcontract_bidding.current_location', '=', 3)
            ->groupBy('tblcontract_bidding.contractID')
            ->orderBy('contract_detailsID')->get();
        return view('procurement.TendersBoard.contracts', $data);
    }

    public function searchContract(Request $request)
    {
        $data['contract'] = DB::table('tblcontract_details')->where('contract_detailsID', '=', $request['contract'])->where('status', '=', 1)->get();
        return view('procurement.TendersBoard.contracts', $data);
    }

    public function previewBids($contractID)
    {
        //decode  oparameter
        $id = base64_decode($contractID);

        //Check if contract have been bidded for
        $check = DB::table('tblcontract_bidding')->where('tblcontract_bidding.contractID', '=', $id)->count();
        if ($check == 0) {
            return back();
        }
        $data['display'] = '';

        //display bidded contracts
        $data['display'] = DB::table('tblcontract_bidding')
            ->join('tblcontract_details', 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->where('tblcontract_bidding.contractID', '=', $id)
            //->where('tblcontract_bidding.current_location','=',$id)
            //->groupBy('tblcontract_bidding.contract_biddingID')
            ->get();

        $data['contract'] = DB::table('tblcontract_details')->where('contract_detailsID', '=', $id)->first();
        $data['ifApproved'] = DB::table('tblcontract_details')->where('status', '=', 3)->where('contract_detailsID', '=', $id)->count();

        $data['procurementAttachedments'] = DB::table('tblcomment_docs')->where('contractID', '=', $id)->get();

        $data['contractID'] = $id;

        return view('procurement.TendersBoard.previewBids', $data);
    }

    public function award(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',

        ]);

        $contractor = DB::table('tblcontractor_registration')->where('contractor_registrationID', '=', $request['contractorID'])->first();
        $comm = $request['comment'];
        $comment = "This Contract is awarded to $contractor->company_name: $comm";

        //save award comment
        DB::table('tblcontract_comment')->insert([
            'contractID' => $request['contractID'],
            'biddingID' => $request['bidid'],
            'comment_description' => $comment,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status'     => 1,
        ]);

        //save awarded contractor
        DB::table('tblcontract_award')->insert([
            'contractID' => $request['contractID'],
            'contractorID' => $request['contractorID'],
            'bidID' => $request['bidid'],
            //'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status'     => 1,
        ]);
        return back()->with('msg', 'Successfully Awarded');
    }

    public function reverse(Request $request)
    {
        $this->validate($request, [
            //'comment' => 'required',

        ]);

        //delete record from award table
        DB::table('tblcontract_award')->where('contractID', '=', $request['contractID'])->where('contractorID', '=', $request['contractorID'])->delete();
        return back()->with('msg', 'Successfully Awarded');
    }

    public function adjustAount(Request $request)
    {
        $amount = str_replace(",", "", $request['amount']);
        // update bidded amount
        DB::table('tblcontract_bidding')->where('contract_biddingID', '=', $request['bidid'])->update([
            'awarded_amount' => $amount,
        ]);
        return back()->with('msg', 'Amount Adjusted');
    }

    public function finalApproval(Request $request)
    {
        $this->validate($request, []);

        $count = DB::table('tblcontract_award')->where('contractID', '=', $request['contractId'])->count();

        if ($count == 0) {
            return back()->with('err', 'You Must first award the contract before approval. Thank you');
        }

        DB::table('tblcontract_bidding')->where('contractID', '=', $request['contractId'])->update([
            'status'     => 3,
        ]);

        DB::table('tblcontract_details')->where('contract_detailsID', '=', $request['contractId'])->update([
            'status'     => 3,
            'approval_date' => date('Y-m-d'),
        ]);
        $db = DB::table('tblcontract_award')->where('contractID', '=', $request['contractId'])->first();


        $ext = array("jpg", "gif", "png", "pdf", "doc", "docx");
        $file = $request->file('document');
        if ($file != '') {

            foreach ($file as $key => $val) {
                $extension = $val->getClientOriginalExtension();
                /* if($extension != 'jpg' || $extension != 'png' || $extension != 'gif' || $extension != 'pdf' || $extension != 'doc' || $extension != 'docx')*/
                if (!in_array($extension, $ext)) {
                    return back()->with('err', 'File not Allowed !. choose either an Image, pdf or Word document to upload');
                }

                $d = $val->getSize();
                if ($d > 1000000000) {
                    return back()->with('err', 'File too large');
                }

                if ($request['description'][$key] == '') {
                    return back()->with('err', 'Please, Type in the document description');
                }
            }

            DB::table('tblapproval')->insert([
                'bidding_id'     => $db->bidID,
                'status_id'      => 3,
                'updated_at'     => date('Y-m-d'),
                'created_at'     => date('Y-m-d'),
                'approval_date' => date('Y-m-d'),
            ]);

            $location = public_path('approvalDocuments');
            foreach ($file as $key => $val) {
                // dd($val);
                $filename = $val->getClientOriginalName();
                //dd($request['description'][$key]);
                DB::table('tblapproval_documents')->insert([
                    'bidID'     => $db->bidID,
                    'contractID' => $request['contractId'],
                    'filename' => $filename,
                    'file_description' => $request['description'][$key],
                    'approved_date' => date('Y-m-d'),
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ]);
                $move = $val->move($location, $filename);
            }
        }

        /*if($file != '')
            {
                $location = public_path('approvalDocuments');

                    //dd($val);
                     $filename = $file->getClientOriginalName();
                     //dd($request['description'][$key]);
                    DB::table('tblapproval_documents')->insert([
                    'biddID'     => $db->bidID,
                    'contractID' => $request['contractId'],
                    'filename'   => $filename,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    ]);
                    $move = $val->move($location,$filename);


            }*/
        return back()->with('msg', 'Successfully Approved');

        //return redirect('/view-bidded-contracts')->with('msg','Successfully Approved');
    }

    public function approvalReversal(Request $request)
    {
        DB::table('tblcontract_bidding')->where('contractID', '=', $request['contractId'])->update([
            'status'     => 1,
        ]);

        DB::table('tblcontract_details')->where('contract_detailsID', '=', $request['contractId'])->update([
            'status'     => 1,
            //'approval_date' => date('Y-m-d'),
        ]);
        return back()->with('msg', 'Successfully Reversed');
    }

    public function getDocs(Request $request)
    {
        $db = DB::table('tblcontractor_bidding_document')->where('biddingID', '=', $request['bidID'])->get();
        return response()->json($db);
    }

    public function approvalRejection(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',

        ]);
        DB::table('tblcontract_bidding')->where('contractID', '=', $request['contractId'])->update([
            'current_location'     => 1,
        ]);


        $commentID = DB::table('tblcontract_comment')->insertGetId([
            'contractID' => $request['contractID'],
            'biddingID'  => $request['bidid'],
            'comment_description' => $request['comment'],
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status'     => 1,
        ]);

        DB::table('tblcontract_details')->where('contract_detailsID', '=', $request['contractId'])->update([
            'status'     => 4,
            'reject_comment'     => $commentID,
            //'approval_date' => date('Y-m-d'),
        ]);
        return back()->with('msg', 'Successfully Reversed');
    }
}//end class
