<?php

namespace App\Http\Controllers\hr;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;
use DateTime;
use Auth;
use App\Http\Controllers\Controller;

class IncrementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = DB::table('promotion_alert_time')->first();
        $date = Carbon::now()->addDays(20);

        $now = Carbon::now();
        //dd($now);
        $data['getCentralList'] = DB::table('tblper')
        ->leftJoin('tblbanklist', 'tblbanklist.bankID', '=', 'tblper.bankID')
        ->where('tblper.incremental_date','>=',$now)
        ->where('tblper.incremental_date','<=',$date)
        ->where('tblper.staff_status', 1)
        ->where('tblper.employee_type', '!=', 2)
        ->where('tblper.employee_type', '!=', 3)
        ->where('tblper.increment_alert', '=', 0)
        ->orderBy('tblper.grade', 'DESC')
        ->orderBy('tblper.step', 'DESC')
        ->paginate(200);

        return view('hr.Variation.incrementNotification', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staffDocuments($fileNo)
    {
        $fileNum = str_replace('-','/',$fileNo);
        $fileID = DB::table('tblfiles')->where('fileNo','=',$fileNum)->value('ID');
        //dd($fileID);
        if($fileID != '')
        {
            $data['staff'] = DB::table('tblfiles')->where('fileNo','=',$fileNum)->first();
            $data['docs'] = DB::table('file_document')->where('fileID','=',$fileID)->get();
            return view('hr.Variation.staffDocuments',$data);
        }
        else
        {
            return back()->with('msg','Files not Available');
        }
       
    }
    
    public function newStaffVariation()
    {
        $data['getCentralList'] = DB::table('tblper')
        ->leftJoin('tblbanklist', 'tblbanklist.bankID', '=', 'tblper.bankID')
        ->where('tblper.progress_regID','=',17)
        ->orderBy('tblper.grade', 'DESC')
        ->orderBy('tblper.step', 'DESC')
        ->paginate(200);

        return view('hr.Variation.newStaffVariation', $data);
    }
    
    public function saveRemarkNewAppointment(Request $request)
    {
        
        
        $code = $request['staffCode'];


        $dueDate = $request->payDate;
        //dd($dueDate);
        $staffid = $request->staffid;
          $y = date('Y');
     $data      = DB::table('tblper')->where('ID','=',$staffid)->first();
       
        $nextstage = $request->stage;
       


      
          $check = DB::table('tblvariation_temp')->where('staffid','=',$staffid)->where('treated','=',0)->where('year_payment','=',$y)->count();
          //dd($check);
          $year = date('Y');
          $newStep = $data->step + 1;
          if($check == 0 )
            {
            $id = DB::table('tblvariation_temp')->insertGetId(array(
            'staffid' => $data->ID,
            'fileNo' => $data->fileNo,
            //'courtID' => $data->divisionID,
            'arrears_type' => 'New Appointment',
            
            'new_grade' => $data->grade,
            'new_step' => $data->step,
            'due_date' => date('Y-m-d', strtotime(trim($dueDate))),
            'year_payment'  => $year,
            //'approvedBy'             => Auth::user()->name,
            
            //'approvedDate' => date('Y-m-d'),
            'stage'        => $nextstage,
            'processed_by'             => Auth::user()->id,
             ));
          
dd($id);
         

        return back()->with('msg','Staff variation sent for further Approval');
      }
        
       
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    }
}
