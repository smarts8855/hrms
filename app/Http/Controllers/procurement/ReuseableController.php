<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\Controller;
use Session;
use File;
use Auth;
use DB;


class ReuseableController extends Controller
{
    public function fetchBiddingDocument($biddingID, $limit)
    {
        $data = DB::table('tblcontractor_bidding_document')
            ->where('biddingID', $biddingID)
            ->limit($limit)
            //->select(DB::raw('count(*) as document_count,file_name,file_description'))
            ->get();

        return $data;
    }

    public function fetchBiddingDocument2($contract_biddingID, $contractorID, $contractID)
    {
        $data = DB::table('tblbid_required_docs')
            ->join('tblcontractor_contract_bid_document', 'tblcontractor_contract_bid_document.bidDocID', '=', 'tblbid_required_docs.id')
            ->where('tblcontractor_contract_bid_document.biddingID', '=', $contract_biddingID)
            ->where('tblcontractor_contract_bid_document.contractorID', '=', $contractorID)
            ->where('tblcontractor_contract_bid_document.contractID', '=', $contractID)
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

        return $data;
    }

    public function getComments($contractID)
    {
        $data = DB::table('tblcontract_comment')
            ->where('tblcontract_comment.contractID', $contractID)
            ->leftjoin('users', 'tblcontract_comment.created_by', '=', 'users.id')
            ->leftjoin('tblcontract_details', 'tblcontract_comment.contract_commentID', '=', 'tblcontract_details.reject_comment')
            ->get();

        return $data;
    }
}//end class
