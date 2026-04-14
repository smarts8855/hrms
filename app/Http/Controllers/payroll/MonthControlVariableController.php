<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Auth;

class MonthControlVariableController extends Controller
{
    public function monthControlVariable(Request $request)
    {
        $data['division'] = '';
        $data['year'] = '';
        $data['month'] = '';

        $data['activeMonth'] = DB::table('tblactivemonth')->first();

        $data['loggedDivision'] = '';
        $data['EorDSession'] = '';
        $data['monthControlVariables'] = [];
        $data['edses'] = '';
        $data['result'] = [];
        $data['selectedDiv'] = session('selected_division');

        $List = DB::table("tblsole_court")->where('courtid', '=', 9)->first();
        if ($List->divisionstatus == 1 && Auth::user()->is_global == 1) {
            // dd("yes global user");
            $data['division'] = DB::table('tbldivision')->get();

            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
            // if($data['EorDSession']){
            //     dd($data['EorDSession']);
            // }
        } else {
            // dd("not global user");
            $data['loggedDivision'] = $this->curDivision(Auth::user()->id);
            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
        }
        // dd($data);
        return view('payroll.monthcontrolvariable.monthcontrolvariable', $data);
    }

    public function monthControlVariableOLD2(Request $request)
    {
        $data['division'] = '';
        $data['year'] = '';
        $data['month'] = '';

        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        $data['loggedDivision'] = '';
        $data['EorDSession'] = '';
        $data['monthControlVariables'] = collect(); // ✅ safer than []
        $data['edses'] = '';
        $data['result'] = [];
        $data['selectedDiv'] = session('selected_division');

        $List = DB::table("tblsole_court")->where('courtid', '=', 9)->first();
        if ($List->divisionstatus == 1 && Auth::user()->is_global == 1) {
            $data['division'] = DB::table('tbldivision')->get();
            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
        } else {
            $data['loggedDivision'] = $this->curDivision(Auth::user()->id);
            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
        }

        // dd($data['loggedDivision']);


        return view('payroll.monthcontrolvariable.monthcontrolvariable', $data);
    }


    public function monthControlVariableOLD(Request $request)
    {
        $data['division'] = '';
        $data['year'] = '';
        $data['month'] = '';

        $data['activeMonth'] = DB::table('tblactivemonth')->first();

        $data['loggedDivision'] = '';
        $data['EorDSession'] = [];
        // $data['monthControlVariables'] = [];
        $data['monthControlVariables'] = collect(); // ✅ always a collection
        $data['edses'] = '';
        $data['result'] = [];
        $data['selectedDiv'] = session('selected_division');

        $List = DB::table("tblsole_court")->where('courtid', '=', 9)->first();

        if ($List->divisionstatus == 1 && Auth::user()->is_global == 1) {
            $data['division'] = DB::table('tbldivision')->get();

            $data['EorDSession'] = session('earnDeduction') ?? [];
            $data['edses'] = session('ed') ?? '';
            $data['selectedDiv'] = session('selected_division') ?? '';
        } else {
            $data['loggedDivision'] = $this->curDivision(Auth::user()->id);
            $data['EorDSession'] = session('earnDeduction') ?? [];
            $data['edses'] = session('ed') ?? '';
            $data['selectedDiv'] = session('selected_division') ?? '';
        }

        if (!is_array($data['monthControlVariables'])) {
            $data['monthControlVariables'] = [];
        }

        return view('payroll.monthcontrolvariable.monthcontrolvariable', $data);
    }


    public function RetrieveMonthlyControlVariableOLD(Request $request)
    {
        $data['division'] = '';
        $data['loggedDivision'] = '';
        $data['EorDSession'] = '';
        $data['monthControlVariables'] = [];
        $data['edses'] = '';
        $data['result'] = [];
        $data['selectedDiv'] = session('selected_division');

        $serialNo = "";
        $pageNO   = "";
        $pageNO   = $request->get('page');
        if (is_null($pageNO)) {
            $serialNo = 1;
        } elseif ($pageNO == 1) {
            $serialNo = 1;
        } else {
            $serialNo = (($pageNO - 1) * 10) + 1;
        }
        Session::put('serialNo', $serialNo);


        $List = DB::table("tblsole_court")->where('courtid', '=', 9)->first();
        if ($List->divisionstatus == 1 && Auth::user()->is_global == 1) {
            // dd("yes global user");
            $data['division'] = DB::table('tbldivision')->get();

            // $data['div'] = session('divisionID');
            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
            // if($data['EorDSession']){
            // dd($data['EorDSession']);
            // }
        } else {
            // dd("not global user");
            $data['loggedDivision'] = $this->curDivision(Auth::user()->id);
            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
        }
        // dd($request->all());
        $this->validate($request, [
            // 'division' => 'required',
            'controlvariable' => 'required',
            'earnordeduction' => 'required',
            'year' => 'required',
            'month' => 'required'
        ]);

        $data['divisions'] = $request['division'];
        $data['controlvariable'] = $request['controlvariable'];
        $data['earnordeduction'] = $request['earnordeduction'];

        $data['month'] = trim($request->input('month'));
        $data['year'] = trim($request->input('year'));
        $data['activeMonth'] = '';

        $data['division'] = DB::table('tbldivision')->get();

        $data['mydivision']  = DB::table('tblotherEarningDeduction')
            ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblotherEarningDeduction.divisionID')
            ->where('tblotherEarningDeduction.divisionID', $data['divisions'])
            ->first();
        if ($data['divisions'] != "") {
            $data['mydivision'] = $data['mydivision']->division;
        }

        if (auth::user()->is_global) {

            $data['monthControlVariables'] = DB::table('tblotherEarningDeduction')
                ->leftjoin('tblper', 'tblper.ID', '=', 'tblotherEarningDeduction.staffid')
                ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblotherEarningDeduction.divisionID')
                ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblotherEarningDeduction.CVID')
                ->where('tblotherEarningDeduction.divisionID', $data['divisions'] ? '=' : '<>', $data['divisions'])
                ->where('tblotherEarningDeduction.CVID', '=', $data['earnordeduction'])
                ->where('tblotherEarningDeduction.particularID', '=', $data['controlvariable'])
                ->where('tblotherEarningDeduction.year', '=', $data['year'])
                ->where('tblotherEarningDeduction.month', '=', $data['month'])
                ->orderBy('tblotherEarningDeduction.divisionID', 'ASC')
                // ->groupBY('tblotherEarningDeduction.divisionID')
                // ->groupBY('tblotherEarningDeduction.staffid')
                // ->select('*', 'tblper.surname', 'tblper.first_name', 'tblper.othernames', 'tbldivision.division', 'tblcvSetup.description', (DB::raw("SUM(tblotherEarningDeduction.amount) as total")))
                ->get();
            // dd($data['monthControlVariables']);
        } else {
            $data['monthControlVariables'] = DB::table('tblotherEarningDeduction')
                ->leftjoin('tblper', 'tblper.ID', '=', 'tblotherEarningDeduction.staffid')
                ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblotherEarningDeduction.divisionID')
                ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblotherEarningDeduction.CVID')
                ->where('tblotherEarningDeduction.divisionID', '=', auth::user()->divisionID)
                ->where('tblotherEarningDeduction.CVID', '=', $data['earnordeduction'])
                ->where('tblotherEarningDeduction.particularID', '=', $data['controlvariable'])
                ->where('tblotherEarningDeduction.year', '=', $data['year'])
                ->where('tblotherEarningDeduction.month', '=', $data['month'])
                ->orderBy('tblotherEarningDeduction.divisionID', 'ASC')
                // ->groupBY('tblotherEarningDeduction.staffid')
                // ->select('*', 'tblper.surname', 'tblper.first_name', 'tblper.othernames', 'tbldivision.division', 'tblcvSetup.description', (DB::raw("SUM(tblotherEarningDeduction.amount) as total")))
                ->get();
        }

        $totals = 0;
        // foreach ($data['monthControlVariables'] as $month_total) {
        //     $totals += $month_total->total;
        // }
        $data['grossTotal'] = number_format($totals, 2);

        $totalRows = DB::table('tblotherEarningDeduction')
            ->where('tblotherEarningDeduction.month',     '=', $data['month'])
            ->where('tblotherEarningDeduction.year',      '=', $data['year'])
            // ->where('tblotherEarningDeduction.bank', $bankID ? '=' : '<>', $bankID)
            ->where('tblotherEarningDeduction.divisionID', $data['divisions'] ? '=' : '<>', $data['divisions'])
            // ->where('tblotherEarningDeduction.courtID',  '=', $court)
            ->count();

        $max_row    = 10;
        $totalPages = ceil($totalRows / $max_row);
        if ($pageNO  == $totalPages) {
            Session::put('showTotal', "yes");
        } else {
            Session::put('showTotal', "");
        }
        // dd($data);
        return view('monthcontrolvariable.monthcontrolvariable', $data);
    }


    public function RetrieveMonthlyControlVariable(Request $request)
    {
        $data['division'] = '';
        $data['loggedDivision'] = '';
        $data['EorDSession'] = '';
        // $data['monthControlVariables'] = [];
        $data['monthControlVariables'] = collect(); // at the very top

        $data['edses'] = '';
        $data['result'] = [];
        $data['selectedDiv'] = session('selected_division');

        \Log::info($request);

        $serialNo = "";
        $pageNO   = "";
        $pageNO   = $request->get('page');
        if (is_null($pageNO)) {
            $serialNo = 1;
        } elseif ($pageNO == 1) {
            $serialNo = 1;
        } else {
            $serialNo = (($pageNO - 1) * 10) + 1;
        }
        Session::put('serialNo', $serialNo);


        $List = DB::table("tblsole_court")->where('courtid', '=', 9)->first();
        if ($List->divisionstatus == 1 && Auth::user()->is_global == 1) {
            // dd("yes global user");
            $data['division'] = DB::table('tbldivision')->get();

            // $data['div'] = session('divisionID');
            $data['EorDSession'] = session('earnDeduction');
            // dd( $data['EorDSession']);
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
            // if($data['EorDSession']){
            // dd($data['EorDSession']);
            // }
        } else {
            // dd("not global user");
            $data['loggedDivision'] = $this->curDivision(Auth::user()->id);
            $data['EorDSession'] = session('earnDeduction');
            $data['edses'] = session('ed');
            $data['selectedDiv'] = session('selected_division');
        }
        // dd($request->all());
        $this->validate($request, [
            // 'division' => 'required',
            'controlvariable' => 'required',
            'earnordeduction' => 'required',
            'year' => 'required',
            'month' => 'required'
        ]);

        $data['divisions']          = $request['division'];
        $data['controlvariable']    = $request['controlvariable'];
        $data['earnordeduction']    = $request['earnordeduction'];

        $data['month']              = trim($request->input('month'));
        $data['year']               = trim($request->input('year'));
        $data['activeMonth']        = '';

        $data['division'] = DB::table('tbldivision')->get();

        $data['mydivision']  = DB::table('tblotherEarningDeduction')
            ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblotherEarningDeduction.divisionID')
            ->where('tblotherEarningDeduction.divisionID', $data['divisions'])
            ->first();

        if (!empty($data['mydivision']) && isset($data['mydivision']->division)) {
            $data['mydivision'] = $data['mydivision']->division;
        } else {
            $data['mydivision'] = ''; // or set it to null, if required
        }

        $data['mycontrolvariable']  = DB::table('tblotherEarningDeduction')
            ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblotherEarningDeduction.CVID')
            ->where('tblotherEarningDeduction.CVID', $data['earnordeduction'])
            ->first();


        // if (!empty($data['controlvariable']) && isset($data['controlvariable']->division)) {
        //     $data['mycontrolvariable'] = $data['mycontrolvariable']->description;
        // } else {
        //     $data['controlvariable'] = ''; // or set it to null, if required
        // }

        if (!empty($data['mycontrolvariable']) && isset($data['mycontrolvariable']->description)) {
            $data['mycontrolvariable'] = $data['mycontrolvariable']->description;
        } else {
            $data['mycontrolvariable'] = '';
        }


        // dd($data['mycontrolvariable']);

        if (auth::user()->is_global) {

            $data['monthControlVariables'] = DB::table('tblotherEarningDeduction')
                ->leftjoin('tblper', 'tblper.ID', '=', 'tblotherEarningDeduction.staffid')
                ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblotherEarningDeduction.divisionID')
                ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblotherEarningDeduction.CVID')
                ->where('tblotherEarningDeduction.divisionID', $data['divisions'] ? '=' : '<>', $data['divisions'])
                ->where('tblotherEarningDeduction.CVID', '=', $data['earnordeduction'])
                ->where('tblotherEarningDeduction.particularID', '=', $data['controlvariable'])
                ->where('tblotherEarningDeduction.year', '=', $data['year'])
                ->where('tblotherEarningDeduction.month', '=', $data['month'])
                ->orderBy('tblotherEarningDeduction.divisionID', 'ASC')
                // ->groupBY('tblotherEarningDeduction.divisionID')
                // ->groupBY('tblotherEarningDeduction.staffid')
                // ->select('*', 'tblper.surname', 'tblper.first_name', 'tblper.othernames', 'tbldivision.division', 'tblcvSetup.description', (DB::raw("SUM(tblotherEarningDeduction.amount) as total")))
                ->get();
            // dd($data['monthControlVariables']);
        } else {
            $data['monthControlVariables'] = DB::table('tblotherEarningDeduction')
                ->leftjoin('tblper', 'tblper.ID', '=', 'tblotherEarningDeduction.staffid')
                ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'tblotherEarningDeduction.divisionID')
                ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblotherEarningDeduction.CVID')
                ->where('tblotherEarningDeduction.divisionID', '=', auth::user()->divisionID)
                ->where('tblotherEarningDeduction.CVID', '=', $data['earnordeduction'])
                ->where('tblotherEarningDeduction.particularID', '=', $data['controlvariable'])
                ->where('tblotherEarningDeduction.year', '=', $data['year'])
                ->where('tblotherEarningDeduction.month', '=', $data['month'])
                ->orderBy('tblotherEarningDeduction.divisionID', 'ASC')
                // ->groupBY('tblotherEarningDeduction.staffid')
                // ->select('*', 'tblper.surname', 'tblper.first_name', 'tblper.othernames', 'tbldivision.division', 'tblcvSetup.description', (DB::raw("SUM(tblotherEarningDeduction.amount) as total")))
                ->get();
        }

        $totals = 0;
        // foreach ($data['monthControlVariables'] as $month_total) {
        //     $totals += $month_total->total;
        // }
        $data['grossTotal'] = number_format($totals, 2);

        $totalRows = DB::table('tblotherEarningDeduction')
            ->where('tblotherEarningDeduction.month',     '=', $data['month'])
            ->where('tblotherEarningDeduction.year',      '=', $data['year'])
            // ->where('tblotherEarningDeduction.bank', $bankID ? '=' : '<>', $bankID)
            ->where('tblotherEarningDeduction.divisionID', $data['divisions'] ? '=' : '<>', $data['divisions'])
            // ->where('tblotherEarningDeduction.courtID',  '=', $court)
            ->count();

        $max_row    = 10;
        $totalPages = ceil($totalRows / $max_row);
        if ($pageNO  == $totalPages) {
            Session::put('showTotal', "yes");
        } else {
            Session::put('showTotal', "");
        }



        // dd($data);
        // \Log::info($data);

        return view('payroll.monthcontrolvariable.monthcontrolvariable', $data);
    }


    public function curDivision($userId)
    {
        $currentDivision = DB::table("users")
            ->join('tbldivision', 'tbldivision.divisionID', '=', 'users.divisionID')
            ->where('users.id', '=', $userId)
            ->select('tbldivision.division', 'tbldivision.divisionID')
            ->first();
        return $currentDivision;
    }

    public function courtSession(Request $request)
    {
        $court = $request['courtID'];
        $division = $request['divisionID'];
        $check = $request['check'];
        if ($check == 'court') {
            $ses    = Session::put('selected_court', $court);
            return response()->json("Successfully Set");
        } elseif ($check == 'division') {
            $ses    = Session::put('selected_division', $division);
            return response()->json("Successfully Set");
        } else {
            return response()->json("Not Set");
        }
    }

    public function getEarnOrDeduction(Request $request)
    {
        $data['earnOrDeduction'] = $request['controlvariable'];
        $data['allEarnOrDeduction'] = DB::table('tblcvSetup')->where('particularID', '=', $data['earnOrDeduction'])
            ->where('status', '=', 1)
            ->select('tblcvSetup.ID', 'tblcvSetup.particularID', 'tblcvSetup.description')
            ->get();

        if ($data['allEarnOrDeduction']) {
            $ses = Session::put('earnDeduction', $data['allEarnOrDeduction']);
        }
    }

    public function setCurED(Request $request)
    {
        $data['ed'] = $request['ed'];
        Session::put('ed', $data['ed']);
        return response()->json($data['ed']);
    }
}
