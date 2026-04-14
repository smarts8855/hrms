<?php

namespace App\Http\Controllers\funds;

use Illuminate\Http\Request;
use App\Http\Controllers\funds\function24Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Exports\CbnEpaymentExport;
use App\Exports\ConsolidatedCpoMandateBatchExport;
use App\Exports\ConsolidatedCpoCapitalMandateBatchExport;
use App\Exports\ConsolidatedCpoCapitalRegeneratedMandateBatchExport;
use App\Exports\ConsolidatedRegeneratedMandateSheet;
use Maatwebsite\Excel\Facades\Excel;

class CPOExportMandateController extends BasefunctionController
{
    private $instanceFunction24;

    public function __construct()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        $this->instanceFunction24 = new function24Controller;
    }

    public function index()
    {
        //
    }

    public function mandateConsolidatedExport(Request $request)
    {
        $ids = json_decode($request->ids);
        $batchContractType = DB::table('tblepayment')
            ->where('batch', $ids[0])
            ->select('contract_typeID')
            ->first();
        if ($batchContractType->contract_typeID == 4) {
            //export capital format
            return Excel::download(
                new ConsolidatedCpoCapitalMandateBatchExport($ids),
                'SCN_Capital_Mandate_Consolidated_Batches.xlsx'
            );
        } else {
            return Excel::download(
                new ConsolidatedCpoMandateBatchExport($ids),
                'SCN_Mandate_Consolidated_Batches.xlsx'
            );
        }
    }

    public function mandateRegenerateConsolidatedExport(Request $request)
    {
        //if capital go to capital format else go to recurrent format
        $batchContractType = DB::table('tblepayment_bank_paid')
            ->where('batch', $request->batchNo)
            ->select('contract_typeID')
            ->first();
        if ($batchContractType->contract_typeID == 4) {
            //export capital format for regenerated payment
            return Excel::download(
                new ConsolidatedCpoCapitalRegeneratedMandateBatchExport($request->batchNo),
                'SCN_Capital_Mandate_Consolidated_Batches.xlsx'
            );
        } else {
            //export reccurent format for regenerated
            return Excel::download(
                new ConsolidatedRegeneratedMandateSheet($request->batchNo),
                'SCN_Mandate_Consolidated_Batches.xlsx'
            );
        }
    }
}
