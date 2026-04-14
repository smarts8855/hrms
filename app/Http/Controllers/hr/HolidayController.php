<?php

namespace App\Http\Controllers\hr;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->userID = (Auth::check() ? Auth::user()->id : null);
        // $this->staffID = DB::table('tblper')->where('UserID', $this->userID)->value('ID');
    }

    public function index(){
        return view('hr.holidays.createHoliday');
    }

    public function fetchHolidays()
    {
        $holidays = DB::table('holidays')->orderBy('id', 'desc')->get();
        return response()->json([
            'holidays' => $holidays
        ]);
    }

    public function store(Request $request)
    {
        $is_success = null;
        $status = 401;
        $message = 'Not successful!';

        $getHolidays = DB::table('holidays')->where('holiday', $request->holiday)->exists();

        $validator = Validator::make($request->all(), [
            'holiday' => 'required|date',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }elseif($getHolidays){
            return response()->json([
                'status' => 409
            ]);
        }else{
            $is_success = DB::table('holidays')->insert(array([
                'holiday'   => $request->holiday,
                'title'     => $request->title,
                'year'      => date('Y', strtotime($request->holiday))
            ]));
            if($is_success){
                $status = 200;
                $message = 'Holiday has been added';
            }
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }
    }

    public function edit($id){
        $holiday = DB::table('holidays')->find($id);
        return view('hr.holidays.editHoliday', compact('holiday'));

        // if($holiday){
        //     return response()->json([
        //         'status' => 200,
        //         'holiday' => $holiday
        //     ]);
        // }else{
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'Not found'
        //     ]);
        // }
    }

    public function update(Request $request, $id){
        $holiday = DB::table('holidays')->find($id);
        if($holiday){
            DB::table('holidays')->where(['id' => $id])->update([
                'holiday' => $request->edit_holiday,
                'title' => $request->edit_title,
                'year' =>   date('Y', strtotime($request->edit_holiday))
            ]);
            // return response()->json([
            //     'status' => 200,
            //     'message' => 'Updated'
            // ]);
            return redirect('/holidays')->with('message', 'Holiday has been updated');
        }else{
            return back()->with('message', 'Could not be updated');
            // return response()->json([
            //     'status' => 404,
            //     'message' => 'Holiday not found'
            // ]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $deleteHoliday = DB::table('holidays')->where('id', $id)->delete();
        if($deleteHoliday){
            return back()->with('message', 'You have Deleted Holiday');
        }
    }
}
