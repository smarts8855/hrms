<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Support\Facades\DB;
use App\Models\Procure;
use App\Models\Contract;
use App\Http\Controllers\Controller;
use App\Models\CommentDocs;
use App\Models\ProComment;
use App\Models\ProContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProcurementEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
     */

    /* Function sends data to display all contracts */
    // public function contract()
    // {
    //     $query = ProContract::orderByRaw('contract_detailsID DESC')->where('status', '!=', 2)->get();
    //     $contracts = ProContract::orderByRaw('contract_detailsID DESC')->where('status', '!=', 2)->get();
    //     foreach ($query as $contract) {
    //         $location = db::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->first();
    //         $bid = db::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->get();
    //         $contract->bids = count($bid);
    //         $activeBids = db::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->where('status', '>=', 1)->get();
    //         $contract->activeBids = count($activeBids);
    //         $disabledBids = db::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->where('status', '=', 0)->get();
    //         $contract->disabledBids = count($disabledBids);
    //         if ($location == null) {

    //             $contract->location = 1;
    //         } else {
    //             $contract->location = $location->current_location;
    //         }
    //     }

    //     return view('procurement.Procurement.contract')->with('datas', $query)->with('contracts', $contracts);
    // }



    public function contract(): View
    {
        $contracts = ProContract::orderByRaw('contract_detailsID DESC')
            ->where('status', '!=', 2)
            ->get();

        foreach ($contracts as $contract) {
            $location = DB::table('tblcontract_bidding')
                ->where('contractID', $contract->contract_detailsID)
                ->first();

            $bid = DB::table('tblcontract_bidding')
                ->where('contractID', $contract->contract_detailsID)
                ->get();

            $contract->bids = count($bid);

            $activeBids = DB::table('tblcontract_bidding')
                ->where('contractID', $contract->contract_detailsID)
                ->where('status', '>=', 1)
                ->get();
            $contract->activeBids = count($activeBids);

            $disabledBids = DB::table('tblcontract_bidding')
                ->where('contractID', $contract->contract_detailsID)
                ->where('status', '=', 0)
                ->get();
            $contract->disabledBids = count($disabledBids);

            $contract->location = $location ? $location->current_location : 1;
        }

        return view('procurement.Procurement.contract')
            ->with('datas', $contracts)
            ->with('contracts', $contracts);
    }



    public function search(Request $request)
    {
        $query = ProContract::where('contract_detailsID', $request->contract)->get();
        $contracts = ProContract::orderByRaw('status DESC, contract_detailsID DESC')->get();
        foreach ($query as $contract) {
            $location = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->first();
            $bid = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->get();

            $activeBids = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->where('status', '>=', 1)->get();
            $contract->activeBids = count($activeBids);
            $contract->bids = count($bid);
            $disabledBids = DB::table('tblcontract_bidding')->where('contractID', $contract->contract_detailsID)->where('status', 0)->get();
            $contract->disabledBids = count($disabledBids);
            if ($location == null) {

                $contract->location = 1;
            } else {
                $contract->location = $location->current_location;
            }
        }
        return view('procurement.Procurement.contract')->with('datas', $query)->with('contracts', $contracts);
    }
    public function letters()
    {
        $query = DB::table('tblapproval')
            ->join('tblcontract_bidding', 'tblapproval.bidding_id', '=', 'tblcontract_bidding.contract_biddingID')
            ->join('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->select('tblapproval.*', 'tblcontractor_registration.company_name', 'tblcontract_bidding.date_submitted', 'tblcontract_bidding.awarded_amount', 'tblcontractor_registration.address')
            ->get();
        return view('procurement.Procurement.letters')->with('datas', $query);
    }
    public function award($approvalID)
    {
        $query = DB::table('tblapproval')
            ->where('approvalID', decrypt($approvalID))
            ->join('tblcontract_bidding', 'tblapproval.bidding_id', '=', 'tblcontract_bidding.contract_biddingID')
            ->join('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->select('tblapproval.*', 'tblcontractor_registration.company_name', 'tblcontract_bidding.date_submitted', 'tblcontract_bidding.awarded_amount', 'tblcontractor_registration.address')
            ->get();
        return view('procurement.Procurement.award')->with('datas', $query);
    }
    public function block(Request $request, $contract)
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
        $saveCancelComment =  DB::table('tblcontract_comment')->insert([
            'contractID' => $contract,
            'comment_description' => "Cancled at Financial stage, reason: " . $request['cancelContractComment'],
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status' => 1

        ]);
        return redirect('/procurement')->with('success', "You have successfully cancelled contract");
    }

    /* Function sends data of all biddings about a paticular contract*/
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
        $query = $query->where('tblcontract_bidding.contractID', $contract_id)->where('tblcontract_bidding.tech_evaluation', '=', 1)->where('tblcontract_bidding.status', '>', 0)->get();
        foreach ($query as $value) {
            $files = DB::table('tblbid_required_docs')->where('doc_type', '=', 'Financial')
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
                    'tblcontractor_contract_bid_document.updated_at'
                )
                ->orderBy('tblbid_required_docs.id')
                ->get();
            // $files = DB::table('tblcontractor_bidding_document')->where('biddingID',$value->contract_biddingID)->select('file_description','file_name')->get();

            $value->documents = $files;
            //dd($value->documents);
        }
        //return($query);
        $comments = DB::table('tblcontract_comment')->where('contractID', '=', $contract_id)->join('users', 'tblcontract_comment.created_by', '=', 'users.id')
            ->select('tblcontract_comment.*', 'users.name')->get();
        //   dd($query);
        return view('procurement.Procurement.evaluations')->with('datas', $query)->with('comments', $comments)->with('files', $new_file)->with('contract', $contract)->with('checklist', $checklist);
    }

    /* Function disqualifies a particular bid for a contract by setting the status to 0*/
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
                //   'checklistID' =>7,
                'comment_description' => $request->disqualifyComment

            ]);
        $user = $user = auth()->user()->id;
        $user_name = db::table('users')->where('id', $user)->first();
        $contract = $query->contractID;
        $contractor_name = db::table('tblcontractor_registration')->where('contractor_registrationID', $query->contractorID)->first();
        // $comment = $request->comment;
        $query->status = 0;
        $query->recommendation = 0;
        $query->save();
        $addComment = new ProComment;
        $addComment->contractID = $contract;
        $addComment->biddingID = $bidding_id;
        $addComment->comment_description = $user_name->name . " disqualifed in Financial evaluation stage" . $contractor_name->company_name . "'s bid, " . $request->disqualifyComment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();
        return redirect('/procurement/contract/' . encrypt($contract))->with('success', "Disqualification made");;
    }

    public function requalifyView($id)
    {
        $contract_id = decrypt($id);
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
        $query = $query->where('tblcontract_bidding.contractID', $contract_id)->where('tblcontract_bidding.status', '=', 0)->get();
        foreach ($query as $value) {
            $files = DB::table('tblbid_required_docs')
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
                    'tblcontractor_contract_bid_document.updated_at'
                )
                ->orderBy('tblbid_required_docs.id')
                ->get();
            // $files = DB::table('tblcontractor_bidding_document')->where('biddingID',$value->contract_biddingID)->select('file_description','file_name')->get();

            $value->documents = $files;
        }

        return view('procurement.Procurement.requalifyView')->with('datas', $query);
    }

    public function requalify(Request $request, $bidding_id)
    {
        $query = Procure::where('contract_biddingID', $bidding_id)->first();
        $user = $user = auth()->user()->id;
        $user_name = db::table('users')->where('id', $user)->first();
        $contract = $query->contractID;
        $contractor_name = db::table('tblcontractor_registration')->where('contractor_registrationID', $query->contractorID)->first();
        $comment = $request->comment;
        $query->status = 1;
        $query->recommendation = 0;
        $query->save();
        $addComment = new ProComment;
        $addComment->contractID = $contract;
        $addComment->biddingID = $bidding_id;
        $addComment->comment_description = $user_name->name . " requalifed " . $contractor_name->company_name . "'s bid, " . $comment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();
        // return redirect('/procurement/contract/'.encrypt($contract))->with('success',"requalification made");;
        return redirect()->back()->with('success', "requalification made");
    }

    public function renableContract(Request $request, $id)
    {
        $this->validate($request, [
            'enableContractComment' => 'required'
        ]);
        //enable contract, disable status is 1
        DB::table('tblcontract_details')->where('contract_detailsID', $id)->update([
            'status' => 1
        ]);
        DB::table('tblcontract_comment')->insert([
            'contractID' => $id,
            'comment_description' => "Contract Enabled, reason: " . $request['enableContractComment'] . " on " . date('Y-m-d'),
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'status' => 1

        ]);
        return redirect()->back()->with('success', "You have successfully Enabled this contract");
    }

    public function disabledContractList()
    {
        $data['disabled'] = DB::table('tblcontract_details')->where('status', 2)->get();
        // dd($data);
        return view('procurement.Procurement.disabledContracts', $data);
    }

    public function recommend(Request $request, $contractID)
    {
        /* if($request->other=="on" && $request->comment==null){
           return redirect('/procurement/contract/'.encrypt($contractID))->with('error',"Other Comment not described");
        }
        $checklist = count(DB::table('tblchecklist')->get());
        //dd($request->checklist0);
        //$query = Procure::where('contract_biddingID',$request->biddingID)->first();
        $rec_comment = "Contractor has";
        $valid=0;
        for($i=0;$i<$checklist-1;$i++){
            $check = 'checklist'.$i;
            if($request->$check!=null){

                $checks = DB::table('tblchecklist')->where('checklistID',$request->$check)->first();
                $rec_comment = $rec_comment." ".$checks->checklistName;


                //dd($checks);
               db::table('tblrecommendation_comment')
                ->insert(['biddingID' => $request->biddingID,
                          'contractID' =>$contractID,
                          'checklistID' =>$checks->checklistID,
                          'comment_description' =>$checks->checklistName

                    ]);
            }
            else{
            $valid = $valid + 1;

            if($valid==$checklist-1 && $request->other==null){

                 return redirect('/procurement/contract/'.encrypt($contractID))->with('error',"No reason given");
            };
            }
        }
                        if($request->other=="on"){
                    db::table('tblrecommendation_comment')
                ->insert(['biddingID' => $request->biddingID,
                          'contractID' =>$contractID,
                          'checklistID' =>7,
                          'comment_description' =>$request->comment

                    ]);
                } */
        $biddingID = $request->biddingID;
        $comment = /* $rec_comment. */ " " . $request->comment;
        if ($comment == "") {
            $comment = /* $rec_comment. */ " " . $comment;
        }
        $resetAll = Procure::where('contractID', $contractID);
        $resetAll = $resetAll->where('recommendation', 1)->first();
        if ($resetAll != null) {
            $resetAll->recommendation = 0;
            $resetAll->save();
        }
        $user = $user = auth()->user()->id;
        $query = Procure::where('contract_biddingID', $request->biddingID)->first();
        $user_name = db::table('users')->where('id', $user)->first();
        $contractor_name = db::table('tblcontractor_registration')->where('contractor_registrationID', $query->contractorID)->first();
        $queryContract = Procure::where('contract_biddingID', $biddingID)->first();
        $queryContract->recommendation = 1;
        $queryContract->save();

        $addComment = new ProComment;
        $addComment->contractID = $contractID;
        $addComment->biddingID = $biddingID;
        $addComment->comment_description = $user_name->name . " recommended in Financial evaluation stage" . $contractor_name->company_name . "'s bid, " . $comment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();
        return redirect('/pro-procurement/contract/' . encrypt($contractID))->with('success', "Recommendation made");
    }
    public function comments($id)
    {
        $id = decrypt($id);

        // Get contract details separately without joining bidding table
        $contract = DB::table('tblcontract_details')
            ->where('contract_detailsID', '=', $id)
            ->select('*')
            ->first(); // Use first() instead of get() to get single record

        // Get the comments
        $comments = DB::table('tblcontract_comment')
            ->where('contractID', '=', $id)
            ->join('users', 'tblcontract_comment.created_by', '=', 'users.id')
            ->select('tblcontract_comment.*', 'users.name')
            ->get();

        // If you need bidding information for some reason, get it separately
        $biddings = DB::table('tblcontract_bidding')
            ->where('contractID', '=', $id)
            ->join('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
            ->select('tblcontract_bidding.*', 'tblcontractor_registration.company_name')
            ->get();

        return view('procurement.Procurement.comments', compact('contract', 'comments', 'biddings'));
    }
    /* Function recommends a particular bid for a contract and disables any possible actions on the biddings */
    public function approve(Request $request, $contract_id)
    {
        $validatedData = $request->validate([
            'comment' => ['max:255'],
        ]);
        request()->validate([

            'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',

        ]);
        $user = $user = auth()->user()->id;
        $user_name = db::table('users')->where('id', $user)->first();
        $comment = $request->comment;
        if ($comment == "") {
            $comment = "No Comment";
        }

        $contract = $contract_id;
        //close further bidding while moving to secretary
        $query = DB::table('tblcontract_details')->where('contract_detailsID', $contract)->update([
            'closed_bidding' => 1
        ]);
        $query = ProContract::where('contract_detailsID', $contract)->first();
        $query->status = 1;
        $query->save();
        $addComment = new ProComment;
        $addComment->contractID = $contract_id;
        $addComment->comment_description = $user_name->name . " sent " . $query->contract_name . " contract to CR, " . $comment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();

        $sendBiddings = Procure::where('contractID', $contract)->update(['current_location' => 2]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $addCommentDocs = new CommentDocs;
            $addCommentDocs->contractID = $contract_id;
            $addCommentDocs->file_description = $request->description;
            $addCommentDocs->file_name = $name;
            $addCommentDocs->status = 1;
            $addCommentDocs->save();
        }

        return redirect('/pro-procurement')->with('success', 'Recommendation has Been made');
    }
    public function tenders(Request $request, $contract_id)
    {
        $validatedData = $request->validate([
            'comment' => ['max:255'],

        ]);

        request()->validate([

            'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',

        ]);
        $user = $user = auth()->user()->id;
        $user_name = db::table('users')->where('id', $user)->first();
        $comment = $request->comment;
        if ($comment == "") {
            $comment = "No Comment";
        }
        $contract = $contract_id;
        //close further bidding while moving to tender board
        $query = DB::table('tblcontract_details')->where('contract_detailsID', $contract)->update([
            'closed_bidding' => 1
        ]);
        $query = Contract::where('contract_detailsID', $contract)->first();
        $query->status = 1;
        $query->save();
        $addComment = new ProComment;
        $addComment->contractID = $contract_id;
        $addComment->comment_description = $user_name->name . " sent " . $query->contract_name . " contract to tender's board, " . $comment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();

        $sendBiddings = Procure::where('contractID', $contract)->update(['current_location' => 3]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $addCommentDocs = new CommentDocs;
            $addCommentDocs->contractID = $contract_id;
            $addCommentDocs->file_description = $request->description;
            $addCommentDocs->file_name = $name;
            $addCommentDocs->status = 1;
            $addCommentDocs->save();
        }


        return redirect('/pro-procurement')->with('success', 'Moved To Tenders Board');
    }

    public function ftenders(Request $request, $contract_id)
    {
        $validatedData = $request->validate([
            'comment' => ['max:255'],

        ]);

        request()->validate([

            'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',

        ]);
        $user = $user = auth()->user()->id;
        $user_name = db::table('users')->where('id', $user)->first();
        $comment = $request->comment;
        if ($comment == "") {
            $comment = "No Comment";
        }
        $contract = $contract_id;
        //close further bidding while moving to federal tender board
        $query = DB::table('tblcontract_details')->where('contract_detailsID', $contract)->update([
            'closed_bidding' => 1
        ]);
        $query = Contract::where('contract_detailsID', $contract)->first();
        $query->status = 1;
        $query->save();
        $addComment = new ProComment;
        $addComment->contractID = $contract_id;
        $addComment->comment_description = $user_name->name . " sent " . $query->contract_name . " contract to Federal Judicial Tender's board, " . $comment;
        $addComment->created_by = $user;
        $addComment->status = 1;
        $addComment->save();

        $sendBiddings = Procure::where('contractID', $contract)->update(['current_location' => 5]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $addCommentDocs = new CommentDocs;
            $addCommentDocs->contractID = $contract_id;
            $addCommentDocs->file_description = $request->description;
            $addCommentDocs->file_name = $name;
            $addCommentDocs->status = 1;
            $addCommentDocs->save();
        }


        return redirect('/pro-procurement')->with('success', 'Moved To Federal Judicial Tenders Board');
    }
}
