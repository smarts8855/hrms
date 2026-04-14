<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;

class LiabilityTakingController extends Controller
{
    public function approvedContracts()
    {
        $data['display'] = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->join('tblaward_letter', 'tblaward_letter.bidding_id', '=', 'tblcontract_bidding.contract_biddingID')
            ->where('tblaward_letter.location_unit', '=', 2)
            ->where('tblcontract_bidding.status', '=', 3)
            ->where('tblcontract_details.liability_status', '=', 0)
            ->get();
        //$dd = base64_decode('MzY=');
        //dd($dd);
        return view('procurement.libilityTaking.list', $data);
    }
    public function moveToFinanceDirector(Request $request)
    {
        $contractor = $request['contractorID'];
        $bidid = $request['bidID'];
        $db =  DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->where('tblcontract_bidding.contractorID', '=', $contractor)->where('tblcontractor_registration.contractor_registrationID', '=', $contractor)
            ->where('tblcontract_bidding.contract_biddingID', '=', $bidid)->first();
        DB::connection('mysql2')->table('tblcontractDetails_liability')->insert([
            'fileNo'                                 => $db->lot_number,
            'procurement_contractID'                 => $db->contract_detailsID,
            'contract_type'                          => $db->procurement_typeID,
            'ContractDescriptions'                   => $db->contract_description,
            'contractValue'                          => $db->awarded_amount,
            'companyID'                              => $db->contractorID,
            'dateAward'                              => $db->approval_date,


        ]);

        DB::table('tblcontract_details')->where('contract_detailsID', '=', $db->contract_detailsID)->update([
            'liability_status'                                 => 1,



        ]);

        return back()->with('msg', 'Successfully Transfered to Account for Liability Taking');
    }
}
