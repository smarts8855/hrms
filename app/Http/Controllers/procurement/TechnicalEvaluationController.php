<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Procure;
use App\Models\Contract;
use App\Models\ProContract;
use App\Models\CommentDocs;
use App\Models\ProComment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Log;

class TechnicalEvaluationController extends Controller
{
    public function index()
    {
        $query = ProContract::orderByRaw('contract_detailsID DESC')->get();
        $contracts = ProContract::orderByRaw('contract_detailsID DESC')->get();
        foreach ($query as $contract) {
            $location = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->first();
            $bid = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->get();
            $contract->bids = count($bid);
            $activeBids = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->where('status', '>=', 1)->get();
            $contract->activeBids = count($activeBids);
            $disabledBids = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->where('status', '=', 0)->get();
            $contract->disabledBids = count($disabledBids);
            if ($location == null) {

                $contract->location = 1;
            } else {
                $contract->location = $location->current_location;
            }
        }

        return view('procurement.TechnicalEvaluation.contract')->with('datas', $query)->with('contracts', $contracts);
    }

    public function viewContract($contract_id)
    {

        $contract_id = decrypt($contract_id);
        $contract = DB::table('tblcontract_details')->where('contract_detailsID', $contract_id)->first();
        $new_file = DB::table('tblcomment_docs')->where('contractID', '=', $contract_id)->first();
        $checklist = DB::table('tblchecklist')->where('checklistID', '<>', 7)->get();
        //dd($new_file);

        $query = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
            ->join('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->select(
                'tblcontract_bidding.*',
                'tblcontract_details.contract_name',
                'tblcontract_details.contract_detailsID',
                'tblcontract_details.lot_number',
                'tblcontract_details.proposed_budget',
                'tblcontract_details.contract_detailsID',
                'tblcontract_details.status as contractStatus',
                'tblcontractor_registration.company_name'
            );
        $query = $query->where('tblcontract_bidding.contractID', $contract_id)->where('tblcontract_bidding.status', '>', 0)->get();
        foreach ($query as $value) {
            $files = DB::table('tblbid_required_docs')->where('doc_type', '=', 'Technical')
                ->join('tblcontractor_contract_bid_document', 'tblcontractor_contract_bid_document.bidDocID', '=', 'tblbid_required_docs.id')
                ->where('tblcontractor_contract_bid_document.biddingID', '=', $value->contract_biddingID)
                ->where('tblcontractor_contract_bid_document.contractorID', '=', $value->contractorID)
                ->where('tblcontractor_contract_bid_document.contractID', '=', $value->contractID)
                ->select(
                    'tblbid_required_docs.*',
                    'tblcontractor_contract_bid_document.id as contractor_bidding_documentID',
                    'tblcontractor_contract_bid_document.biddingID',
                    'tblcontractor_contract_bid_document.contractorID',
                    'tblcontractor_contract_bid_document.contractID',
                    'tblcontractor_contract_bid_document.bidDocID',
                    'tblcontractor_contract_bid_document.bidDocument',
                    'tblcontractor_contract_bid_document.updated_at',

                )
                ->orderBy('tblbid_required_docs.id')
                ->get();

            $value->documents = $files;
            //dd( $value->documents);
        }
        //return($query);
        $comments = DB::table('tblcontract_comment')->where('contractID', '=', $contract_id)->join('users', 'tblcontract_comment.created_by', '=', 'users.id')
            ->select('tblcontract_comment.*', 'users.name')->get();
        //dd($checklist);
        return view('procurement.TechnicalEvaluation.evaluation')->with('datas', $query)->with('comments', $comments)->with('files', $new_file)->with('contract', $contract)->with('checklist', $checklist);
    }

    public function disqualify(Request $request, $bidding_id)
    {
        $query = Procure::where('contract_biddingID', $bidding_id)->first();
        $this->validate($request, [
            'disqualifyComment' => 'required'
        ]);
        db::table('tbldisqualification_comment')
            ->insert([
                'biddingID' => $bidding_id,
                'contractID' => $query->contractID,
                // 'checklistID' => 7,
                'comment_description' => $request->disqualifyComment

            ]);

        $user = $user = auth()->user()->id;
        $user_name = db::table('users')->where('id', $user)->first();
        $contract = $query->contractID;
        $contractor_name = db::table('tblcontractor_registration')->where('contractor_registrationID', $query->contractorID)->first();
        // $comment = $request->comment;
        $query->status = 0;
        $query->recommendation = 0;
        $query->tech_evaluation = 0;
        $query->save();
        $addComment = new ProComment;
        $addComment->contractID = $contract;
        $addComment->biddingID = $bidding_id;
        $addComment->comment_description = $user_name->name . " disqualifed in Technical evaluation stage" . $contractor_name->company_name . "'s bid, " . $request->disqualifyComment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();
        return redirect('/pro-procurement/tech-evaluate/' . encrypt($contract))->with('success', "Disqualification made");;
    }

    public function recommend(Request $request, $contractID)
    {
        $biddingID = $request->biddingID;
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $comment = /* $rec_comment. */ " " . $request->comment;
        if ($comment == "") {
            $comment = /* $rec_comment. */ " " . $comment;
        }

        $user = $user = auth()->user()->id;
        $query = Procure::where('contract_biddingID', $request->biddingID)->first();
        $user_name = db::table('users')->where('id', $user)->first();
        $contractor_name = db::table('tblcontractor_registration')->where('contractor_registrationID', $query->contractorID)->first();
        $queryContract = Procure::where('contract_biddingID', $biddingID)->first();
        $queryContract->tech_evaluation = 1;
        $queryContract->save();

        $addComment = new ProComment;
        $addComment->contractID = $contractID;
        $addComment->biddingID = $biddingID;
        $addComment->comment_description = $user_name->name . " passed Technical evaluation stage" . $contractor_name->company_name . "'s bid, " . $comment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();
        return redirect('/pro-procurement/tech-evaluate/' . encrypt($contractID))->with('success', "Recommendation made");
    }

    public function reverseRecommend(Request $request, $contractID)
    {
        $biddingID = $request->biddingID;
        $user = $user = auth()->user()->id;
        $query = Procure::where('contract_biddingID', $request->biddingID)->first();
        $user_name = db::table('users')->where('id', $user)->first();
        $contractor_name = db::table('tblcontractor_registration')->where('contractor_registrationID', $query->contractorID)->first();
        $queryContract = Procure::where('contract_biddingID', $biddingID)->first();
        $queryContract->tech_evaluation = 0;
        $queryContract->recommendation = 0;
        $queryContract->save();

        $addComment = new ProComment;
        $addComment->contractID = $contractID;
        $addComment->biddingID = $biddingID;
        $addComment->comment_description = $user_name->name . " recommendation for " . $contractor_name->company_name . "'s bid was reversed on Technical evaluation stage ";
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();
        return redirect('/pro-procurement/tech-evaluate/' . encrypt($contractID))->with('success', "Recommendation Reversed");
    }

    public function blockTechnical(Request $request, $contract)
    {
        $contract = base64_decode($contract);
        $this->validate($request, [
            'cancelContractComment' => 'required'
        ]);
        //   $query = DB::table('tblcontract_details')->where('contract_detailsID',$contract)->update([
        //       'closed_bidding'=>1]);
        //       return redirect()->back();

        //disable contract, disable status is 2
        $query = DB::table('tblcontract_details')->where('contract_detailsID', $contract)->update([
            'status' => 2
        ]);
        $saveCancelComment =  DB::table('tblcancel_contract_comments')->insert([
            'contractID' => $contract,
            'comment_description' => "Canceled at Technical stage, reason: " . $request['cancelContractComment'],
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status' => 1

        ]);
        return redirect('/procurement-technical-evaluation')->with('success', "You have successfully cancelled contract");
    }
}
