<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BiddingRequiredDocController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bidRequiredDocSetup()
    {
        $data['requiredDocs'] = DB::table('tblbid_required_docs')->get();
        return view('procurement.BidRequiredDocSetup.createRequiredDoc', $data);
    }

    public function saveBidRequiredDocSetup(Request $request)
    {
        $this->validate($request, [
            'docDesc' => 'required',
            'docType' => 'required'
        ]);

        $createDoc = DB::table('tblbid_required_docs')->insertGetId([
            'bid_doc_description' => $request['docDesc'],
            'doc_type' => $request['docType']
        ]);

        if($createDoc)
            return redirect()->back()->with('message', 'Your record was created successfully.');
        return redirect()->back()->with('error', 'Record could not be created.');
    }

    public function editBid($id)
    {
        
    }

    public function updateBidRequiredDocSetup(Request $request, $id)
    {
        $this->validate($request, [
            'docDesc' => 'required',
            'docType' => 'required'
        ]);

        $updateDoc = DB::table('tblbid_required_docs')->where('id', $id)->update([
            'bid_doc_description' => $request['docDesc'],
            'doc_type' => $request['docType']
        ]);

        if($updateDoc)
            return redirect()->back()->with('message', 'Your record was updated successfully.');
        return redirect()->back()->with('error', 'Record could not be updated.');
    }

    public function removeBidRequiredDocSetup(Request $request, $id)
    {
        $checkInUse = DB::table('tblcontractor_contract_bid_document')
            ->where('bidDocID', $id)
            ->first();
        if($checkInUse){
            return redirect()->back()->with('err', 'Already In use');
        }else{
            $delete = DB::table('tblbid_required_docs')
            ->where('id', $id)
            ->delete();
            if($delete){
                return redirect()->back()->with('message', 'Successfully deleted');
            }
        }


    }

}
