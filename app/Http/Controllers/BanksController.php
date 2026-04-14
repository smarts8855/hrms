<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Bank;

use Illuminate\Http\Request;


class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banks = Bank::all();
        return view('Bank.showcase')->with('banks', $banks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function avoidDuplicates($bank, $num)
    {
        $search = Bank::where('bank', $bank);
        if ($num == 0) {
            $search = Bank::where('bank', $bank)->get();
        } else {
            $search = $search->where('bankID', "<>", $num)->get();
        }
        if (count($search) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function checkSortCode($bank, $num)
    {
        $search = Bank::where('sort_code', $bank);
        if ($num == 0) {
            $search = Bank::where('sort_code', $bank)->get();
        } else {
            $search = $search->where('bankID', "<>", $num)->get();
        }
        if (count($search) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function checkBankCode($bank, $num)
    {
        $search = Bank::where('bank_code', $bank);
        if ($num == 0) {
            $search = Bank::where('bank_code', $bank)->get();
        } else {
            $search = $search->where('bankID', "<>", $num)->get();
        }
        if (count($search) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ensureBankUnused($bank)
    {
        $usedBank = DB::table('tblbank_details')->where('bankID', $bank)->get();
        if (count($usedBank) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'bank_name' => 'required',
            'sort_code' => 'required',
        ]);
        $bank = new Bank;
        $bank->bank = strtoupper($request->input('bank_name'));
        $value = $this->avoidDuplicates(strtoupper($request->input('bank_name')), 0);

        if ($value == true) {
            return redirect('banks')->with('error', $request->input('bank_name') . ' already exists');
        } else {
            $bank->bank_code = strtoupper($request->input('bank_code'));
            if ($request->input('bank_code') != "") {
                $bankValue = $this->checkBankCode(strtoupper($request->input('bank_code')), 0);
                if ($bankValue == true) {
                    return redirect('banks')->with('error', $request->input('bank_code') . ' Bank code already exists');
                }
            } else {
            }
            $bank->sort_code = $request->input('sort_code');
            $sortValue = $this->checkSortCode($request->input('sort_code'), 0);
            if ($sortValue == true) {
                return redirect('banks')->with('error', $request->input('sort_code') . ' Sort code already exists');
            } else {
                $bank->save();
                return redirect('banks')->with('success', 'Bank has been created');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $bank = Bank::where('bankID', $id)->first();
        //return($bank);
        return view('pages.editView')->with('bank', $bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            'bank_name' => 'required',
            'sort_code' => 'required',
        ]);
        $bank = Bank::where('bankID', $id)->first();
        $bank->bank = $request->input('bank_name');
        $value = $this->avoidDuplicates($request->input('bank_name'), $id);
        if ($value == true) {
            return redirect('banks')->with('error', $request->input('bank_name') . ' already exists');
        }
        $bank->bank_code = strtoupper($request->input('bank_code'));
        if ($request->input('bank_code') != "") {
            $bankValue = $this->checkBankCode(strtoupper($request->input('bank_code')), $id);
            if ($bankValue == true) {
                return redirect('banks')->with('error', $request->input('bank_code') . ' Bank code already exists');
            }
        } else {
        }


        $bank->sort_code = $request->input('sort_code');
        $sortValue = $this->checkSortCode($request->input('sort_code'), $id);
        if ($sortValue == true) {
            return redirect('banks')->with('error', $request->input('sort_code') . ' Sort code already exists');
        } else {
            $bank->save();
            return redirect('banks')->with('success', 'Bank has been updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $bank = Bank::find($id);
        $usedBank = $this->ensureBankUnused($id);
        if ($usedBank == true) {
            return redirect('banks')->with('error', 'This Bank is currently in use and cannot be deleted');
        }
        $bank->delete();
        return redirect('banks')->with('success', 'Bank deleted succesfully');
    }
}
