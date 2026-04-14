<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use Session;
use App\Http\Controllers\Controller;
use File;
use Auth;
use DB;


class PerformaceEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->getUploadPath = env('UPLOADPATHROOT', null) . 'PaymentRequestDocument/';
        $this->getDownloadPath = env('UPLOADPATHROOT', null) . 'PaymentRequestDocument/';
    }

    //function to view list of all the biddings
    public function viewList()
    {
        $data['getContracts'] = DB::table('tblcontract_details')
            ->where('tblcontract_details.status', 3)
            ->where('tblcontract_bidding.is_agreement', 1)
            ->leftjoin('tblcontract_bidding', 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
            ->groupby('tblcontract_bidding.contractID')
            ->get();

        return view('procurement.performanceEvaluation.view_contracts', $data);
    }
    //function to view list of all the biddings
    public function agreementlist($id)
    {
        $idx = base64_decode($id);
        $data['id'] = $idx;
        //dd($data['id']);
        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('tblcontract_bidding.status', 3)
            ->where('tblcontract_bidding.contractID', $idx)
            ->leftjoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->leftjoin('tblagreement_letter', 'tblcontract_bidding.contract_biddingID', '=', 'tblagreement_letter.bidding_id')
            ->select('*', 'tblcontract_bidding.project_completion as complete')
            ->orderby('tblcontract_bidding.is_agreement', 'asc')
            ->get();

        return view('procurement.performanceEvaluation.view', $data);
    }

    public function generateLetter($id)
    {

        $idx = base64_decode($id);
        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('tblcontract_bidding.contract_biddingID', $idx)
            ->leftjoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->leftjoin('tblagreement_letter', 'tblcontract_bidding.contract_biddingID', '=', 'tblagreement_letter.bidding_id')
            ->select('*', 'tblcontract_bidding.project_completion as complete')
            ->orderby('tblcontract_bidding.is_agreement', 'asc')
            ->first();

        return view('procurement.performanceEvaluation.generate_agreement_letter', $data);
    }

    //list award letters
    public function listAawardletter($id)
    {
        $bid = base64_decode($id);

        $data['getList'] = DB::table('tblaward_letter')
            ->where('tblaward_letter.bidding_id', $bid)
            ->leftjoin('tblcontract_bidding', 'tblaward_letter.bidding_id', '=', 'tblcontract_bidding.contract_biddingID')
            ->leftjoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->select('*', 'tblcontract_bidding.project_completion as complete')
            ->get();

        return view('procurement.performanceEvaluation.list_award_letter', $data);
    }

    public function viewAgreementletter($id)
    {

        $bid = base64_decode($id);
        //dd($bid);
        $data['getList'] = DB::table('tblagreement_letter')
            ->where('tblagreement_letter.bidding_id', $bid)
            ->first();

        $data['getDocExist'] = DB::table('tblagreement_documents')
            ->where('agreement_letter_id', $data['getList']->agreement_letterID)
            ->exists();

        $data['getDocList'] = DB::table('tblagreement_documents')
            ->where('agreement_letter_id', $data['getList']->agreement_letterID)
            ->get();

        return view('procurement.performanceEvaluation.view_agreement_letter', $data);
    }

    public function editAgreementletter($id)
    {

        $bid = base64_decode($id);
        //dd($bid);
        $data['getList'] = DB::table('tblagreement_letter')
            ->where('tblagreement_letter.bidding_id', $bid)
            ->first();

        $data['getDocExist'] = DB::table('tblagreement_documents')
            ->where('agreement_letter_id', $data['getList']->agreement_letterID)
            ->exists();

        $data['getDocList'] = DB::table('tblagreement_documents')
            ->where('agreement_letter_id', $data['getList']->agreement_letterID)
            ->get();

        return view('procurement.performanceEvaluation.edit_agreement_letter', $data);
    }

    //update award letter
    public function updateAgreementletter(Request $request)
    {
        $this->validate($request, [

            'date_award'         => 'date|required',
            'letter'             => 'required',
        ]);

        $biddingID          =   $request->input('cbid');
        $date               =   $request->input('date_award');
        $letter             =   $request->input('letter');

        DB::table('tblagreement_letter')->where('bidding_id', $biddingID)->update(['bidding_id' => $biddingID, 'agreement_letter' => $letter, 'date_issued' => $date]);

        //return redirect()->route('agreement_bidlist')->with('msg','Successfully updated!');
        return back()->with('msg', 'Successfully updated');
    }

    //update areement document
    public function updateAgreementdocument(Request $request)
    {

        $biddingID          =   $request->input('cbid');
        $document_description             =   $request->input('document_description');
        //dd($biddingID);
        $filename = "";

        if ($request->hasfile('agreement_letter')) {

            $this->validate($request, [

                'agreement_letter' => 'mimes:pdf,doc,docx,jpeg,jpg,gif,png,bmp|max:8300',
                'document_description' => 'string|required',
            ]);

            $file = $request->file('agreement_letter');

            $filename = $file->getClientOriginalName();
            $file->move(public_path('agreementDocument'), $filename);
        }
        DB::table('tblagreement_documents')->where('agreementID', $biddingID)->update(['document' => $filename, 'document_desc' => $document_description]);

        return back()->with('msg', 'Successfully updated');
    }

    //add agreement document
    public function addAgreementdocument(Request $request)
    {

        $biddingID                 =   $request->input('cbid');
        $document_description      =   $request->input('document_description');
        $filename = "";

        if ($request->hasfile('agreement_letter')) {

            $this->validate($request, [

                'agreement_letter' => 'mimes:pdf,doc,docx,jpeg,jpg,gif,png,bmp|max:8300',
                'document_description' => 'required',
            ]);

            $file = $request->file('agreement_letter');

            $filename = $file->getClientOriginalName();
            $file->move(public_path('agreementDocument'), $filename);
        }

        DB::table('tblagreement_documents')->insert(['agreement_letter_id' => $biddingID, 'document' => $filename, 'document_desc' => $document_description]);

        return back()->with('msg', 'Successfully added');
    }

    //delete agreement document
    public function removeAgreementdocument(Request $request)
    {

        $biddingID          =   $request->input('cbid');
        //dd($biddingID);
        DB::table('tblagreement_documents')->where('agreementID', $biddingID)->delete();

        return back()->with('msg', 'Successfully remove');
    }

    //type and save agreement letter
    public function generateAgreementletter(Request $request)
    {
        $this->validate($request, [
            'letter'        => 'required',
            'date_approval' => 'required|date'
        ]);

        $biddingID          =   $request->input('cbid');
        $approval_amt       =   $request->input('approval_amt');
        $date_approval      =   $request->input('date_approval');
        $letter             =   $request->input('letter');

        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('contract_biddingID', $biddingID)
            ->first();

        $isexists = DB::table('tblagreement_letter')
            ->where('bidding_id', $biddingID)
            ->exists();

        $filename = "";
        if ($isexists) {
            return redirect()->route('agreement_bidlist', ['id' => base64_encode($data['getList']->contractID)])->with('error', 'Cannot create! Agreement letter already created.');
        } else {

            if ($request->hasfile('images1')) {

                $this->validate($request, [
                    'letter' => 'string',
                ]);


                for ($i = 1; $i <= $request->input('image'); $i++) {

                    $this->validate($request, [
                        'description' . $i => 'required',
                        'images' . $i      => 'mimes:pdf,doc,docx,jpeg,jpg,gif,png,bmp|max:8300',

                    ]);
                }
                $getID = DB::table('tblagreement_letter')->insertGetId(['contract_id' => $data['getList']->contractID, 'bidding_id' => $biddingID, 'awarded_amt' => $approval_amt, 'date_issued' => $date_approval, 'agreement_letter' => $letter]);
                DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['is_agreement' => 2]);

                for ($i = 1; $i <= $request->input('image'); $i++) {

                    $file = $request->file('images' . $i);
                    $otherDoc = $request->input('description' . $i);

                    $originalname = $file->getClientOriginalName();
                    $name = $originalname;
                    $file->move(public_path('agreementDocument'), $name);

                    DB::table('tblagreement_documents')->insert(['agreement_letter_id' => $getID, 'document' => $name, 'document_desc' => $otherDoc]);
                }
            } else {
                DB::table('tblagreement_letter')->insertGetId(['contract_id' => $data['getList']->contractID, 'bidding_id' => $biddingID, 'awarded_amt' => $approval_amt, 'date_issued' => $date_approval, 'agreement_letter' => $letter]);
                DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['is_agreement' => 2]);
            }
        }

        return redirect()->route('agreement_bidlist', ['id' => base64_encode($data['getList']->contractID)])->with('msg', 'Successfully created');
    }

    public function pushAgreementletter($id)
    {
        $bid = base64_decode($id);
        //dd($bid);

        DB::table('tblagreement_letter')->where('bidding_id', $bid)->update(['is_okay' => 1]);

        return back()->with('msg', 'Successfully pushed');
    }
    public function viewBiddingdocument($id)
    {
        //dd('bb');
        $bid = base64_decode($id);

        $data['getList'] = DB::table('tblcontractor_bidding_document')
            ->where('biddingID', $bid)
            ->get();

        return view('procurement.performanceEvaluation.bidding_document', $data);
    }

    //reverse agreement letter
    public function reverseLetter(Request $request)
    {
        $this->validate($request, [

            //'comment'        => 'required',

        ]);

        $biddingID          =   $request->input('bid');
        $comment            =   $request->input('comment');

        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('contract_biddingID', $biddingID)
            ->first();
        if ($comment == null) {
            DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['is_agreement' => 1]);
            DB::table('tblagreement_letter')->where('bidding_id', $biddingID)->delete();
        } else {
            DB::table('tblcontract_comment')->insert(['contractID' => $data['getList']->contractID, 'biddingID' => $biddingID, 'comment_description' => "Performance Evaluation: " . $comment, 'created_by' => Auth::user()->id, 'created_at' => date('Y-m-d')]);
            DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['is_agreement' => 1, 'is_agreement_reverse' => 1]);
            DB::table('tblagreement_letter')->where('bidding_id', $biddingID)->delete();
        }
        return back()->with('msg', 'Successfully reversed');
    }

    //return agreement letter
    public function returnLetter(Request $request)
    {
        $this->validate($request, [

            //'comment'        => 'required',

        ]);

        $biddingID          =   $request->input('bid');
        $comment            =   $request->input('comment');

        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('contract_biddingID', $biddingID)
            ->first();
        if ($comment == null) {
            DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['is_agreement' => 0]);
        } else {
            DB::table('tblcontract_comment')->insert(['contractID' => $data['getList']->contractID, 'biddingID' => $biddingID, 'comment_description' => "Performance Evaluation: " . $comment, 'created_by' => Auth::user()->id, 'created_at' => date('Y-m-d')]);
            DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['is_agreement' => 0]);
        }
        return back()->with('msg', 'Successfully returned');
    }
}//end class
