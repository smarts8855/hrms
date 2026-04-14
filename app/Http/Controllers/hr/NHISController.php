<?php

namespace App\Http\Controllers\hr;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NHISController extends ParentController
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function create()
    {
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }

        $data['nhis'] = DB::table('tblnhisbalances')->get();
        return view('hr.nhis.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'year' => 'required|numeric',
            'month' => 'required',
            'amount' => 'required|numeric',
            'purpose' => 'required',
        ]);

        //dd('ok');

        $data = DB::table('tblnhisbalances')->insert(
            [

                'year'                   => $request['year'],
                'month'                 => $request['month'],
                'amount'                   => $request['amount'],
                'purpose'                 => $request['purpose'],
                'updated_at'            => date('Y-m-d'),

            ]
        );

        return redirect()->back()->with('message', 'Successfully Added');
    }

    public function edit($id)
    {
        $data['CourtInfo'] = $this->CourtInfo();
        if ($data['CourtInfo']->courtstatus == 0) {
            $request['court'] = $data['CourtInfo']->courtid;
        }
        if ($data['CourtInfo']->divisionstatus == 0) {
            $request['division'] = $data['CourtInfo']->divisionid;
        }

        $data['nhis'] = DB::table('tblnhisbalances')->where('id', '=', $id)->first();
        $data['nhisBal'] = DB::table('tblnhisbalances')->get();
        return view('hr.nhis.edit', $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'year' => 'required|numeric',
            'month' => 'required',
            'amount' => 'required|numeric',
            'purpose' => 'required',
        ]);

        //dd('ok');

        $data = DB::table('tblnhisbalances')->where('id', '=', $request['id'])->update(
            [

                'year'                   => $request['year'],
                'month'                 => $request['month'],
                'amount'                   => $request['amount'],
                'purpose'                 => $request['purpose'],
                'updated_at'            => date('Y-m-d'),

            ]
        );

        // return redirect ('/nhis-balance/edit/'.$request['id'])->with('msg','Successfully Updated');
        return redirect()->back()->with('message', 'Successfully Updated');
    }
    public function createAccount()
    {
        $data['nhis'] = DB::table('tblnhis_account')->get();
        $data['nhisAcct'] = DB::table('tblnhis_account')->first();
        return view('hr.nhis.nhisAccount', $data);
    }
    public function storeAccount(Request $request)
    {
        $acct = $request['account'];
        $nhis = DB::table('tblnhis_account')->count();
        if ($nhis == 0) {
            DB::table('tblnhis_account')->insert(
                [

                    'accountNo'                   => $request['account'],
                    'updated_at'                => date('Y-m-d'),

                ]
            );
            return back()->with('msg', 'Successfully Saved');
        } else {
            DB::table('tblnhis_account')->where('id', '=', 1)->update(
                [

                    'accountNo'                   => $request['account'],
                    'updated_at'                => date('Y-m-d'),

                ]
            );
            return back()->with('msg', 'Successfully Updated');
        }
    }

    public function deduction()
    {
        return view('nhis.nhisDeduction');
    }
    public function viewDeduction(Request $request)
    {
        $percentages = DB::SELECT("SELECT * FROM `tbldeduction_percentage`")[0];
        $data['selectedMonth'] = $request['month'];
        $data['selectedYear'] = $request['year'];
        $data['nhisNew'] = round((DB::table('tblpayment_consolidated')->where('year', '=', $request['year'])->where('month', '=', $request['month'])->where('rank', '!=', 2)->sum('TEarn') -
            DB::table('tblpayment_consolidated')->where('year', '=', $request['year'])->where('month', '=', $request['month'])->where('rank', '!=', 2)->sum('PEC') -
            DB::table('tblpayment_consolidated')->where('year', '=', $request['year'])->where('month', '=', $request['month'])->where('rank', '!=', 2)->sum('SOT'))

            * $percentages->nhis * 0.01, 2);
        $data['nhis'] = DB::table('tblpayment_consolidated')->where('rank', '!=', 2)->where('year', '=', $request['year'])->where('month', '=', $request['month'])->orderBy('rank', 'DESC')->orderBy('grade', 'DESC')->orderBy('step', 'DESC')->get();
        return view('hr.nhis.nhisDeductionReport', $data);
    }
}
