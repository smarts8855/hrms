<?php

namespace App\Http\Controllers\funds;

use Illuminate\Http\Request;
//use Illuminate\Http\Support\Facade\View;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;

class EconomicHeadController extends ParentController
{
    public function index()
    {
        $data = [
            'error'          => '',
            'warning'        => '',
            'success'        => '',
            'allocationType' => '',
            'economicGroup'  => '',
            'economicHead'   => '',
            'code'           => '',
            'AllocationType' => $this->GetAllocationType(),
            'EconomicGroup'  => $this->GetEconomicGroup(),
            'EconomicHead'   => $this->getEconomicHead(),
        ];

        Log::info($data['EconomicHead']);
        return view('funds.economicHead.economicHead', $data);
    }
    public function store(Request $request)
    {
        $economicGroup = trim($request->input('economicGroup'));
        $economicHead  = trim($request->input('economicHead'));
        $code          = trim($request->input('code'));
        $status        = trim($request->input('status'));
        $id            = trim($request->input('EcoID'));
        $EcoCode       = trim($request->input('EcoCode'));

        // ✅ Add New Record
        if ($request->has('add')) {
            $confirm  = $this->getStatus($economicGroup, $economicHead);
            $confirm2 = $this->getDescription($economicHead);

            if ($confirm || $confirm2) {
                return redirect()->route('funds.economicHead.create')
                    ->with('warning', 'Sorry! Item already exists, duplicate items are not allowed.');
            }

            FacadesDB::insert(
                "INSERT INTO `tbleconomicHead`(`contractTypeID`, `economicHead`, `Code`) VALUES (?, ?, ?)",
                [$economicGroup, $economicHead, $code]
            );

            return redirect()->route('funds.economicHead.create')
                ->with('success', 'Economic Head successfully added.');
        }

        // ✅ Edit Record
        if ($request->has('edit')) {
            FacadesDB::table('tbleconomicHead')
                ->where('ID', $id)
                ->update([
                    'economicHead' => $economicHead,
                    'Code'         => $EcoCode,
                    'Status'       => $status,
                ]);

            return redirect()->route('funds.economicHead.create')
                ->with('success', 'Economic Head successfully updated.');
        }

        // ✅ Delete Record
        if ($request->has('delete')) {
            FacadesDB::table('tbleconomicHead')->where('ID', $id)->delete();

            return redirect()->route('funds.economicHead.create')
                ->with('success', 'Economic Head successfully deleted.');
        }

        return redirect()->route('funds.economicHead.create')->with('error', 'No valid action selected.');
    }



    public function destroy($id)
    {
        FacadesDB::table('tbleconomicHead')->where('ID', $id)->delete();

        return redirect()->route('funds.economicHead.create')
            ->with('success', 'Economic Head deleted successfully!');
    }

    /********** THIS FUNCTION GETS ALL BANKS TO BE DISPLAYED ON THE LAYOUT ***************/

    public function GetAllocationType()
    {

        $bank = DB::table('tblallocation_type')->select('*')->get(); //Select all banks form database
        return $bank;
    }

    public function GetEconomicGroup()
    {

        $bank = DB::table('tblcontractType')
            ->select('*')
            ->get(); //Select all banks form database
        return $bank;
    }

    public function GetEconomicCode($allocationID, $contractGroupID, $economicHead)
    {

        $bank = DB::table('tbleconomicCode')
            ->select('*')
            ->where('allocationID', $allocationID)
            ->where('contractGroupID', $contractGroupID)
            ->where('economicHeadID', $economicHead)
            ->get(); //Select all banks form database
        return $bank;
    }


    public function checkStatus($id)
    {


        $confir = DB::Select("SELECT * FROM `tblbudget` WHERE `b_id`='$id' AND `AllocationStatus`='1'");
        if (($confir)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getStatus($contractTypeID, $economicHead)
    {


        $confir = DB::Select("SELECT * FROM `tbleconomicHead` WHERE `contractTypeID`='$contractTypeID' AND `economicHead`='$economicHead'");
        if (($confir)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getDescription($economicHead)
    {


        $confir = DB::Select("SELECT * FROM `tbleconomicHead` WHERE  `economicHead`='$economicHead'");
        if (($confir)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public function getEconomicHead()
    {
        $list = DB::table('tblcontractType')
            ->join('tbleconomicHead', 'tbleconomicHead.contractTypeID', '=', 'tblcontractType.ID')
            ->select(
                'tbleconomicHead.ID as HeadID',
                'tbleconomicHead.contractTypeID',
                'tbleconomicHead.economicHead',
                'tbleconomicHead.Code',
                'tbleconomicHead.Status',
                'tblcontractType.contractType'
            )
            ->orderBy('tbleconomicHead.ID')
            ->paginate(50);

        return $list;
    }
}
