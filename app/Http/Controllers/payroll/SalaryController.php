<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Event;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends ParentController
{

    public function salary()
    {
        $data['salary'] = [];
        $data['month'] = '';
        $data['year'] = '';
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        return view('payroll.conpayroll.consalary.salary', $data);
    }
    public function RetrieveSalary(Request $request)
    {
        $data['month'] = trim($request->input('month'));
        $data['year'] = trim($request->input('year'));
        $data['activeMonth'] = '';
        if (Auth::user()->is_global) {
            $data['salary'] = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month',     '=', $data['month'])
                ->where('tblpayment_consolidated.year',      '=', $data['year'])
                ->where('tblpayment_consolidated.rank', '!=', 2)
                ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description', 'tblstages.id')
                ->groupBy('tbldivision.divisionID')
                ->get();
        } else {
            $data['salary'] = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month',     '=', $data['month'])
                ->where('tblpayment_consolidated.year',      '=', $data['year'])
                ->where('tblpayment_consolidated.rank', '!=', 2)
                ->where('tblpayment_consolidated.divisionID',      '=', auth::user()->divisionID)
                ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblpayment_consolidated.divisionID')
                ->join('tblstages', 'tblstages.id', '=', 'tblpayment_consolidated.vstage')
                ->select('tbldivision.division', 'tblpayment_consolidated.year', 'tblpayment_consolidated.month', 'tblpayment_consolidated.vstage', 'tblpayment_consolidated.mandate_approval', 'tblpayment_consolidated.is_rejected', 'tblpayment_consolidated.divisionID', 'tblstages.description', 'tblstages.id')
                ->groupBy('tbldivision.divisionID')
                ->get();
        }

        return view('payroll.conpayroll.consalary.salary', $data);
    }

    public function SalaryDetails($id)
    {
        $data['salary'] = DB::table('tblpayment_consolidated')
            ->where('divisionID', '=', $id)
            ->where('tblpayment_consolidated.rank', '!=', 2)
            ->orderby('tblpayment_consolidated.grade', 'DESC')
            ->paginate(20);
        return view('payroll.conpayroll.consalary.divisionSalary', $data);
    }

    public function submitSalary(Request $request)
    {
        try {
            $submitSalary = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month',     '=', $request->month)
                ->where('tblpayment_consolidated.year',      '=', $request->year)
                ->where('tblpayment_consolidated.divisionID',      '=', $request->division)
                // ->where('tblpayment_consolidated.rank', '!=', 2)
                ->update([
                    'vstage' => 2,
                    'is_rejected' => 0,
                    'salary_submitted_at' => date('Y-m-d')
                ]);

            //generate salary voucher
            // economic code 257
            //salary sum
            $economic_codeStaff = 368;
            $economic_codeJustice = 370;
            $data['sumx'] = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month', '=', $request->month)
                ->where('tblpayment_consolidated.year',  '=', $request->year)
                ->where('tblpayment_consolidated.rank', '!=', 2)
                ->sum('gross');

            $data['sumStaffPension'] = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month', '=', $request->month)
                ->where('tblpayment_consolidated.year',  '=', $request->year)
                ->where('tblpayment_consolidated.rank', '!=', 2)
                ->sum('PEN');

            $data['sumAmount2'] = $data['sumx'] - $data['sumStaffPension'];

            $data['sumj'] = DB::table('tblpayment_consolidated')
                ->where('tblpayment_consolidated.month', '=', $request->month)
                ->where('tblpayment_consolidated.year',  '=', $request->year)
                ->where('tblpayment_consolidated.rank', '=', 2)
                ->sum('gross');

            $date = date('Y-m-d');

            $data['sumAmount'] = $data['sumAmount2'] + $data['sumj'];

            $beneficiaryx = DB::table('tblpayment_consolidated')->where('rank', '!=', 2)->where('month', $request->month)->where('year', $request->year)->value('name');
            $beneficiaryj = DB::table('tblpayment_consolidated')->where('rank', 2)->where('month', $request->month)->where('year', $request->year)->value('name');
            $count_beneficiary = DB::table('tblpayment_consolidated')
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->where('tblpayment_consolidated.rank', '!=', 2)
                ->count();

            $count_beneficiaryJustice = DB::table('tblpayment_consolidated')
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->where('tblpayment_consolidated.rank', '=', 2)
                ->count();

            $is_salary = 2;
            $payment = 'Salary';
            $beneficiary = $beneficiaryx . ' and ' . ($count_beneficiary - 1) . ' others.';
            $description = 'Being ' . $payment . ' for the month of ' . $request->month . ', ' . $request->year;
            // First day of the month.

            $beneficiaryJustice = $beneficiaryj . ' and ' . ($count_beneficiaryJustice - 1) . ' others.';
            $descriptionJustice = 'Being Justice ' . $payment . ' for the month of ' . $request->month . ', ' . $request->year;
            // First day of the month.

            $firstday = date('Y-m-01', strtotime($date));

            $check_contracts = DB::table('tblcontractDetails')->where('month', $request->month)->where('year', $request->year)->where('economicVoult', $economic_codeStaff)->where('is_salary', '=', $is_salary)->exists();
            $check_trans = DB::table('tblpaymentTransaction')->where('month', $request->month)->where('year', $request->year)->where('economicCodeID', $economic_codeStaff)->where('is_salary', '=', $is_salary)->exists();

            $check_contractsJustice = DB::table('tblcontractDetails')->where('month', $request->month)->where('year', $request->year)->where('economicVoult', $economic_codeJustice)->where('is_salary', '=', $is_salary)->exists();
            $check_transJustice = DB::table('tblpaymentTransaction')->where('month', $request->month)->where('year', $request->year)->where('economicCodeID', $economic_codeJustice)->where('is_salary', '=', $is_salary)->exists();

            if ($check_contracts && $check_trans) {
                //update
                DB::table('tblcontractDetails')->where('month', $request->month)
                    ->where('year', $request->year)
                    ->where('economicVoult', $economic_codeStaff)
                    ->where('is_salary', '=', $is_salary)
                    ->update([
                        'economicVoult' => $economic_codeStaff,
                        'contractValue' => $data['sumAmount'],
                        // 'companyID' => 1,
                        'dateAward' => $firstday,
                        'contract_Type' => 6,
                        'ContractDescriptions' => $description,
                        'beneficiary' => $beneficiary,
                        'datecreated' => date('F j, Y', strtotime($date)),
                        'approvedBy' => Auth::user()->name,
                        'createdby' => Auth::user()->id,
                        'is_advances' => 3,
                        'approvalStatus' => 1,
                        'openclose' => 1,
                        'paymentStatus' => 0,
                        'voucherType' => 2,
                        'period' => $request->year,
                        // 'isfrom_procurement' => 0,
                        'is_salary' => $is_salary,
                        'month' => $request->month,
                        'year' => $request->year,
                    ]);

                DB::table('tblpaymentTransaction')->where('month', $request->month)
                    ->where('year', $request->year)
                    ->where('economicCodeID', $economic_codeStaff)
                    ->where('is_salary', '=', $is_salary)
                    ->update([
                        'contractTypeID' => 6,
                        // 'companyID' => 1,
                        'totalPayment' => $data['sumAmount'],
                        'paymentDescription' => $description,
                        'amtPayable' => $data['sumAmount'],
                        'preparedBy' => Auth::user()->id,
                        'allocationType' => 5,
                        'economicCodeID' => $economic_codeStaff,
                        'status' => 0,
                        'is_advances' => 3,
                        'datePrepared' => $date,
                        'vstage' => 2,
                        'accept_voucher_status' => 1,
                        'is_salary' => $is_salary,
                        'month' => $request->month,
                        'year' => $request->year,
                        'period' => $request->year,
                        'payment_beneficiary' => $beneficiary
                    ]);
            } else {
                //insert
                $contract_id = DB::table('tblcontractDetails')->insertGetId([
                    'economicVoult' => $economic_codeStaff,
                    'contractValue' => $data['sumAmount'],
                    // 'companyID' => 1,
                    'dateAward' => $firstday,
                    'contract_Type' => 6,
                    'ContractDescriptions' => $description,
                    'beneficiary' => $beneficiary,
                    'datecreated' => date('F j, Y', strtotime($date)),
                    'approvedBy' => Auth::user()->name,
                    'createdby' => Auth::user()->id,
                    'is_advances' => 3,
                    'approvalStatus' => 1,
                    'openclose' => 1,
                    'paymentStatus' => 0,
                    'voucherType' => 2,
                    'period' => $request->year,
                    // 'isfrom_procurement' => 0,
                    'is_salary' => $is_salary,
                    'month' => $request->month,
                    'year' => $request->year,
                ]);

                DB::table('tblpaymentTransaction')->insert([
                    'contractTypeID' => 6,
                    'contractID' => $contract_id,
                    // 'companyID' => 1,
                    'totalPayment' => $data['sumAmount'],
                    'paymentDescription' => $description,
                    'amtPayable' => $data['sumAmount'],
                    'preparedBy' => Auth::user()->id,
                    'allocationType' => 5,
                    'economicCodeID' => $economic_codeStaff,
                    'status' => 0,
                    'is_advances' => 3,
                    'datePrepared' => $date,
                    'vstage' => 2,
                    'accept_voucher_status' => 1,
                    'is_salary' => $is_salary,
                    'month' => $request->month,
                    'year' => $request->year,
                    'period' => $request->year,
                    'payment_beneficiary' => $beneficiary
                ]);
            }

            if ($check_contractsJustice && $check_transJustice) {
                //update
                DB::table('tblcontractDetails')->where('month', $request->month)
                    ->where('year', $request->year)
                    ->where('economicVoult', $economic_codeJustice)
                    ->where('is_salary', '=', $is_salary)
                    ->update([
                        'economicVoult' => $economic_codeJustice,
                        'contractValue' => $data['sumj'],
                        // 'companyID' => 1,
                        'dateAward' => $firstday,
                        'contract_Type' => 6,
                        'ContractDescriptions' => $descriptionJustice,
                        'beneficiary' => $beneficiaryJustice,
                        'datecreated' => date('F j, Y', strtotime($date)),
                        'approvedBy' => Auth::user()->name,
                        'createdby' => Auth::user()->id,
                        'is_advances' => 3,
                        'approvalStatus' => 1,
                        'openclose' => 1,
                        'paymentStatus' => 0,
                        'voucherType' => 2,
                        'period' => $request->year,
                        // 'isfrom_procurement' => 0,
                        'is_salary' => $is_salary,
                        'month' => $request->month,
                        'year' => $request->year,
                    ]);

                DB::table('tblpaymentTransaction')->where('month', $request->month)
                    ->where('year', $request->year)
                    ->where('economicCodeID', $economic_codeJustice)
                    ->where('is_salary', '=', $is_salary)
                    ->update([
                        'contractTypeID' => 6,
                        // 'companyID' => 1,
                        'totalPayment' => $data['sumj'],
                        'paymentDescription' => $descriptionJustice,
                        'amtPayable' => $data['sumj'],
                        'preparedBy' => Auth::user()->id,
                        'allocationType' => 5,
                        'economicCodeID' => $economic_codeJustice,
                        'status' => 0,
                        'is_advances' => 3,
                        'datePrepared' => $date,
                        'vstage' => 2,
                        'accept_voucher_status' => 1,
                        'is_salary' => $is_salary,
                        'month' => $request->month,
                        'year' => $request->year,
                        'period' => $request->year,
                        'payment_beneficiary' => $beneficiaryJustice
                    ]);
            } else {
                //insert
                $contract_id = DB::table('tblcontractDetails')->insertGetId([
                    'economicVoult' => $economic_codeJustice,
                    'contractValue' => $data['sumj'],
                    // 'companyID' => 1,
                    'dateAward' => $firstday,
                    'contract_Type' => 6,
                    'ContractDescriptions' => $descriptionJustice,
                    'beneficiary' => $beneficiaryJustice,
                    'datecreated' => date('F j, Y', strtotime($date)),
                    'approvedBy' => Auth::user()->name,
                    'createdby' => Auth::user()->id,
                    'is_advances' => 3,
                    'approvalStatus' => 1,
                    'openclose' => 1,
                    'paymentStatus' => 0,
                    'voucherType' => 2,
                    'period' => $request->year,
                    // 'isfrom_procurement' => 0,
                    'is_salary' => $is_salary,
                    'month' => $request->month,
                    'year' => $request->year,
                ]);

                DB::table('tblpaymentTransaction')->insert([
                    'contractTypeID' => 6,
                    'contractID' => $contract_id,
                    // 'companyID' => 1,
                    'totalPayment' => $data['sumj'],
                    'paymentDescription' => $descriptionJustice,
                    'amtPayable' => $data['sumj'],
                    'preparedBy' => Auth::user()->id,
                    'allocationType' => 5,
                    'economicCodeID' => $economic_codeJustice,
                    'status' => 0,
                    'is_advances' => 3,
                    'datePrepared' => $date,
                    'vstage' => 2,
                    'accept_voucher_status' => 1,
                    'is_salary' => $is_salary,
                    'month' => $request->month,
                    'year' => $request->year,
                    'period' => $request->year,
                    'payment_beneficiary' => $beneficiaryJustice
                ]);
            }

           

            return redirect(url('/salary'))->with('message', 'You have successfully submitted salary');
        } catch (\Throwable $th) {
            throw $th;
        }
    }




   
}
