<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffCurrentStateController extends Controller
{
    public function index()
    {   
        $data['courtDivisions']  = DB::table('tbldivision')->get();
        $data['curDivision'] = $this->curDivision(Auth::user()->id);

        return view('staffCurrentState.index', $data);
    }

    public function retrieve(Request $request)
    {
        $data['activeMonth'] = DB::table('tblactivemonth')->first();
        // $this->validate($request, [
        //     'divisionID' => 'required'
        // ]);
        $data['division'] = $request['divisionID'];
        $data['staffs'] = DB::table('tblpayment_consolidated')
            ->leftjoin('tblcurrent_state', 'tblcurrent_state.id', '=', 'tblpayment_consolidated.current_state')
            ->orderBy('tblpayment_consolidated.name', 'ASC')
            ->where('month', '=', $data['activeMonth']->month)->where('year', '=', $data['activeMonth']->year)
            ->orderBy('tblpayment_consolidated.current_state', 'ASC')
            ->get();
        $data['states'] = DB::table('tblcurrent_state')->get();
        return view('staffCurrentState.retrieve', $data);
    }

    public function updateAddress(Request $request, $id)
    {
        // $data['activeMonth'] = DB::table('tblactivemonth')->first();
        try {
            $updatePaymentConsplidatedAddress = DB::table('tblpayment_consolidated')->where('staffid', '=', $id)
            // ->where('month', '=', $data['activeMonth']->month)->where('year', '=', $data['activeMonth']->year)
            ->update([
                'current_state' => $request['current_state']
            ]);

            $updatePerAddress = DB::table('tblper')->where('ID', '=', $id)->update([
                'current_state' => $request['current_state']
            ]);

            if($updatePerAddress && $updatePaymentConsplidatedAddress){
                return response()->json(['status' => 'success']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
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
}
