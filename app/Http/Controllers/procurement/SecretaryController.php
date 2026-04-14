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


class SecretaryController extends Controller
{

    //function to view list of all the biddings
    public function viewContracts(Request $request)
    {
        //$request->session()->forget('bidding_id');
        //$request->session()->forget('contractor_id');
        $request->session()->forget('contract_id');


        $data['getContracts'] = DB::table('tblcontract_bidding')
            ->where('tblcontract_bidding.current_location', 2)
            ->leftjoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->groupby('tblcontract_bidding.contractID')
            ->orderby('tblcontract_bidding.contract_biddingID', 'desc')
            ->get();

        return view('procurement.SecretaryApproval.contract_list', $data);
    }

    //function to view list of all the biddings
    public function viewBiddings(Request $request, $id)
    {
        //->session()->forget('bidding_id');
        //$request->session()->forget('contractor_id');
        //$request->session()->forget('contract_id');

        $idx = base64_decode($id);

        $data['id'] = $idx;

        $data['getList'] = DB::table('tblcontract_bidding')
            ->where('tblcontract_bidding.contractID', $idx)
            ->where('tblcontract_bidding.current_location', 2)
            ->where('tblcontract_bidding.recommendation', 1)
            ->where('tblcontract_bidding.status', '<>', 0)
            ->leftjoin('tblcontract_details', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->get();

        return view('procurement.SecretaryApproval.view', $data);
    }

    //function to edit contract amount
    public function updateAmount(Request $request)
    {
        $amount =   $request->input('amount');
        //$sanitizeAmount = preg_replace("/[^0-9]/", "", $amount);//remove all special characters and letters from the numbers
        //$removeDigits = substr($sanitizeAmount,0,-2); //remove last two digits from the numbers

        $this->validate($request, [
            'amount' => 'required',
        ]);

        $id     =   $request->input('id');
        DB::table('tblcontract_bidding')->where('contract_biddingID', $id)->update(['awarded_amount' => str_replace(',', '', $amount)]);

        return back()->with('msg', 'Amount successfully edited');
    }

    //function to get approve contractors
    public function approveContractor(Request $request)
    {
        $contractID =   $request->input('contractID');
        $getRecord = DB::table('tblcontract_bidding')->where('contract_biddingID', $contractID)->first();
        //DB::table('tblapproval')->insert(['bidding_id'=>$getRecord->contract_biddingID,'contract_id'=>$getRecord->contractID,'status_id'=>3,'approval_date'=>date('Y-m-d')]);

        DB::table('tblcontract_bidding')->where('contract_biddingID', $contractID)->update(['status' => 3]);
        DB::table('tblcontract_details')->where('contract_detailsID', $getRecord->contract_biddingID)->update(['status' => 3]);
    }

    //remove contractor when uncheck box
    public function removeContractor(Request $request)
    {
        $contractID =   $request->input('contractID');
        $getRecord = DB::table('tblcontract_bidding')->where('contract_biddingID', $contractID)->first();

        DB::table('tblcontract_bidding')->where('contract_biddingID', $contractID)->update(['status' => 1]);
        DB::table('tblcontract_details')->where('contract_detailsID', $getRecord->contract_biddingID)->update(['status' => 1]);
    }

    //approve contract and pust back to procurement unit
    public function approve(Request $request)
    {
        $biddingID   =   $request->input('cid');
        //$date        =   $request->input('date');
        $comment     =   $request->input('comment');

        $this->validate($request, [
            // 'comment' =>'required',
            // 'date'   => 'date'
        ]);

        $getRecord = DB::table('tblcontract_bidding')->where('contractID', $biddingID)->first();
        DB::table('tblcontract_details')->where('contract_detailsID', $biddingID)->update(['approval_date' => date('Y-m-d'), 'status' => 3]);
        DB::table('tblcontract_comment')->insert(['contractID' => $biddingID, 'comment_description' => $comment, 'created_by' => Auth::user()->id, 'created_at' => date('Y-m-d')]);
        // DB::table('tblcontract_bidding')->where('contractID',$biddingID)->update(['current_location'=>1, 'status'=>3]);
        DB::table('tblcontract_bidding')->where('contract_biddingID', $request['contractorBiddingId'])->update(['current_location' => 1, 'status' => 3]);
        DB::table('tblapproval')->delete();

        //insert into contract_biding archive table
        $approvedbiddingArchive = DB::table('tblcontract_bidding_archive')->insert([
            'contract_biddingID' => $request['contractorBiddingId'],
            'contractID' => $biddingID,
            'current_location' => 2,
            'cba_status' => 1, //1 = accepted/aproved bidding
        ]);

        return redirect()->route('incoming-file')->with('msg', 'Successfully approved');
        $request->session()->forget('contractor_id');
    }

    //reject contract and pust back to procurement unit
    public function reject(Request $request)
    {
        $biddingID   =   $request->input('cid');
        $date        =   $request->input('date');
        $comment     =   $request->input('comment');

        $this->validate($request, [
            //'comment' =>'required',
            // 'date'   => 'date'
        ]);

        $getRecord = DB::table('tblcontract_bidding')->where('contractID', $biddingID)->first();

        $getID = DB::table('tblcontract_comment')->insertGetId(['contractID' => $biddingID, 'comment_description' => $comment, 'created_by' => Auth::user()->id, 'created_at' => date('Y-m-d')]);
        DB::table('tblcontract_details')->where('contract_detailsID', $biddingID)->update(['approval_date' => date('Y-m-d'), 'reject_comment' => $getID]);
        DB::table('tblcontract_bidding')->where('contractID', $biddingID)->update(['status' => 1, 'current_location' => 1]);
        DB::table('tblapproval')->delete();

        //insert into contract_biding archive table
        $approvedbiddingArchive = DB::table('tblcontract_bidding_archive')->insert([
            'contract_biddingID' => $request['contractorBiddingId'],
            'contractID' => $biddingID,
            'current_location' => 2,
            'cba_status' => 2, //2 = rejected bidding by account officer
        ]);

        return redirect()->route('incoming-file')->with('msg', 'Successfully rejected');
        $request->session()->forget('contractor_id');
    }

    //approve contract for individual contractor
    public function approveBidder(Request $request)
    {
        $biddingID   =   $request->input('cidx');
        $comment     =   $request->input('comment');
        $contractorID     =   $request->input('contractorID');

        $request->session()->put('bidding_id', $biddingID);
        $request->session()->put('contractor_id', $contractorID);

        $getRecord = DB::table('tblcontract_bidding')
            ->where('contract_biddingID', $biddingID)
            ->leftjoin('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->first();

        //$request->session()->put('bidding_id', $biddingID);
        //$request->session()->put('contractor_id', $contractorID);
        $request->session()->put('contract_id', $getRecord->contractID);

        $check = DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->where('status', 1)->exists();

        if ($check) {
            //dd($biddingID);
            DB::table('tblapproval')->where('bidding_id', $biddingID)->delete();
            DB::table('tblcontract_bidding')->where('contract_biddingID', $biddingID)->update(['status' => 1]);

            //$request->session()->forget('bidding_id');
            //$request->session()->forget('contractor_id');
            //$request->session()->forget('contract_id');

            $str = "Secretary reversal of contract for " . $getRecord->company_name . ': ' . $comment;

            return back()->with('msg', 'Successfully reversed');
            $request->session()->forget('contractor_id');
        } else {

            //$bidding        = $request->session()->get('bidding_id');
            //$contractor_id  = $request->session()->get('contractor_id');
            $contract_id    = $request->session()->get('contract_id');

            //dd($bidding);
            $str = "Secretary approval of contract for " . $getRecord->company_name . ': ' . $comment;
            DB::table('tblapproval')->insert(['bidding_id' => $getRecord->contract_biddingID, 'contract_id' => $getRecord->contractID, 'status_id' => 3, 'approval_date' => date('Y-m-d')]);

            return back()->with('msg', 'Successfully approved');
        }

        DB::table('tblcontract_comment')->insert(['biddingID' => $biddingID, 'contractID' => $getRecord->contractID, 'comment_description' => $str, 'created_by' => Auth::user()->id, 'created_at' => date('Y-m-d')]);
    }

    public function secretaryApprovedList(Request $request)
    {
        $query = DB::table('tblcontract_bidding_archive')
            ->where('tblcontract_bidding_archive.current_location', 2)
            ->leftJoin('tblcontract_details', 'tblcontract_bidding_archive.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->leftJoin('tblcontract_bidding', 'tblcontract_bidding_archive.contract_biddingID', '=', 'tblcontract_bidding.contract_biddingID')
            ->leftJoin('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->orderBy('tblcontract_bidding_archive.id', 'desc');

        if ($request->has('filter_status') && !empty($request->filter_status)) {
            $query->where('tblcontract_bidding_archive.cba_status', $request->filter_status);
        }

        $data['getContracts'] = $query->get();

        return view('procurement.SecretaryApproval.secretary_approved', $data);
    }
}//end class
