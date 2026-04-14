<?php

namespace App\Http\Controllers\hr;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewProcessVariationController extends Controller
{

  public function saveRemark(Request $request)
  {
    // dd($request->all());

    $staffid   = $request['staffid'];
    $varTempID   = $request['varID'];

    $data      = DB::table('tblper')->where('ID', '=', $staffid)->first();

    $code = $request['staffCode'];

    $yr = date('Y', strtotime($data->incremental_date)) + 1;
    $mt = date('m', strtotime($data->incremental_date));
    $dy = date('d', strtotime($data->incremental_date));

    $dueDate = "$yr-$mt-$dy";
    //dd($dueDate);

    $y = date('Y');


    // $check = DB::table('tblvariation_temp')->where('staffid','=',$staffid)->where('treated','=',0)->where('year_payment','=',$y)->count();
    $check = DB::table('tblvariation_temp')->where('staffid', '=', $staffid)->where('incremental_stage', '>=', 0)->where('year_payment', '=', $y)->count();
    $year = date('Y');
    $newStep = $data->step + 1;
    if ($check == 0) {
      $id = DB::table('tblvariation_temp')->insertGetId(array(
        'staffid' => $staffid,
        'fileNo' => $data->fileNo,
        'courtID' => 9,
        'divisionID' => $data->divisionID,
        'arrears_type' => 'increment',
        'old_grade' => $data->grade,
        'old_step' => $data->step,
        'new_grade' => $request->newGrade,
        'new_step' => $request->newStep,
        // 'due_date' => date('Y-m-d', strtotime(trim($data->incremental_date))),
        'due_date' => date('Y-m-d', strtotime(trim($request->dueDate))),
        'year_payment'  => $year,
        //'approvedBy'             => Auth::user()->name,
        'newEmploymentType'      => $data->employee_type,
        'oldEmploymentType'      => $data->employee_type,
        //'approvedDate' => date('Y-m-d'),
        'incremental_stage'        => $request->incremental_stage,
        'processed_by'             => Auth::user()->id,
      ));


      DB::table('tblvariation_comments')->insert(array(
        'staffid'         => $staffid,
        'comment'         => $request['remark'],
        'sent_by'         => Auth::user()->id,
        'sent_to'         => $request->incremental_stage,
        // 'sentby_code'     => $stageVal,
        'year'            => $year,
        // 'present_stage'   => $nextstage,
        'variationID'     => $id,
        'updated_at'      => date('Y-m-d'),
      ));

      DB::table('tblper')->where('ID', '=', $staffid)->update(array(
        'increment_alert'         => 1,
      ));

      return back()->with('msg', 'Staff variation sent for further Approval');
    } else {
      //update
      $exisitingTemp = DB::table('tblvariation_temp')->where('staffid', '=', $staffid)
        ->where('old_grade', '=', $data->grade)
        ->where('old_step', '=', $data->step)
        ->where('year_payment', '=', $y)
        ->first();
      $id = DB::table('tblvariation_temp')->where('staffid', '=', $staffid)
        ->where('old_grade', '=', $data->grade)
        ->where('old_step', '=', $data->step)
        ->where('year_payment', '=', $y)->update([
          'staffid' => $staffid,
          'fileNo' => $data->fileNo,
          'courtID' => 9,
          'divisionID' => $data->divisionID,
          'arrears_type' => 'increment',
          'old_grade' => $data->grade,
          'old_step' => $data->step,
          'new_grade' => $request->newGrade,
          'new_step' => $request->newStep,
          // 'due_date' => date('Y-m-d', strtotime(trim($data->incremental_date))),
          'due_date' => date('Y-m-d', strtotime(trim($request->dueDate))),
          'year_payment'  => $year,
          'newEmploymentType'      => $data->employee_type,
          'oldEmploymentType'      => $data->employee_type,
          'incremental_stage'        => $request->incremental_stage,
          'is_rejected' => '',
          'processed_by'             => Auth::user()->id,
      ]);


      DB::table('tblvariation_comments')->insert(array(
        'staffid'         => $staffid,
        'comment'         => $request['remark'],
        'sent_by'         => Auth::user()->id,
        'sent_to'         => $request->incremental_stage,
        // 'sentby_code'     => $stageVal,
        'year'            => $year,
        // 'present_stage'   => $nextstage,
        'variationID'     => $exisitingTemp->ID,
        'updated_at'      => date('Y-m-d'),
      ));

      DB::table('tblper')->where('ID', '=', $staffid)->update(array(
        'increment_alert'         => 1,
      ));
      return back()->with('msg', 'Staff variation sent for further Approval');
    }
  }

  public function viewVariationComment(Request $request, $variationTempId, $year)
  {
    $data['variationList'] = DB::table('tblvariation_temp')
      ->join('tblper', 'tblper.ID', '=', 'tblvariation_temp.staffid')
      ->where('tblvariation_temp.ID', '=', $variationTempId)
      ->select(
        'tblper.ID as staffID',
        'tblper.fileNo',
        'tblper.surname',
        'tblper.first_name',
        'tblper.othernames',
        'tblvariation_temp.ID',
        'tblvariation_temp.old_grade',
        'tblvariation_temp.old_step',
        'tblvariation_temp.new_grade',
        'tblvariation_temp.new_step',
        'tblper.incremental_date',
        'tblvariation_temp.due_date',
        'tblvariation_temp.year_payment',
        'tblvariation_temp.createdAt',
      )
      ->first();
    $data['comments'] = DB::table('tblvariation_comments')
      ->where('variationID', $variationTempId)
      ->where('year', $year)
      ->leftjoin('users', 'users.id', 'tblvariation_comments.sent_by')
      ->leftjoin('tblper', 'tblper.ID', 'tblvariation_comments.staffid')
      ->select('tblvariation_comments.*', 'users.name', 'tblper.passport_url')
      ->get();
    return view('hr.estab.staffVariationComments', $data);
  }

  public function showStaffDueForIncrementDDA()
  {
    $data['variationList'] = DB::table('tblvariation_temp')
      ->join('tblper', 'tblper.ID', '=', 'tblvariation_temp.staffid')
      ->where('tblvariation_temp.incremental_stage', '=', 1)
      ->select(
        'tblper.ID as staffID',
        'tblper.fileNo',
        'tblper.surname',
        'tblper.first_name',
        'tblper.othernames',
        'tblvariation_temp.ID',
        'tblvariation_temp.old_grade',
        'tblvariation_temp.old_step',
        'tblvariation_temp.new_grade',
        'tblvariation_temp.new_step',
        'tblper.incremental_date',
        'tblvariation_temp.due_date',
        'tblvariation_temp.year_payment',
        'tblvariation_temp.is_rejected',
        'tblvariation_temp.createdAt',
      )
      ->get();

    return view('hr.estab.staffDueForIncDDA', $data);
  }

  public function fowardStaffDueForInctoDA(Request $request)
  {
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->variationID)->update(['incremental_stage' => $request->incremental_stage]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->staffid,
      'comment'         => $request['remark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => $request->incremental_stage,
      'year'            => $year,
      'variationID'     => $request->variationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation sent to Director Admin for further Approval');
  }

  public function declineStaffDueForIncByDDA(Request $request)
  {
    // dd($request->all());
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->declinevariationID)->update(['incremental_stage' => 0]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->declinestaffid,
      'comment'         => $request['declineremark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => 0,
      'year'            => $year,
      'variationID'     => $request->declinevariationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation rejected');
  }

  public function showStaffDueForIncrementDA()
  {
    $data['variationList'] = DB::table('tblvariation_temp')
      ->join('tblper', 'tblper.ID', '=', 'tblvariation_temp.staffid')
      ->where('tblvariation_temp.incremental_stage', '=', 2)
      ->select(
        'tblper.ID as staffID',
        'tblper.fileNo',
        'tblper.surname',
        'tblper.first_name',
        'tblper.othernames',
        'tblvariation_temp.ID',
        'tblvariation_temp.old_grade',
        'tblvariation_temp.old_step',
        'tblvariation_temp.new_grade',
        'tblvariation_temp.new_step',
        'tblper.incremental_date',
        'tblvariation_temp.due_date',
        'tblvariation_temp.year_payment',
        'tblvariation_temp.is_rejected',
        'tblvariation_temp.createdAt',
      )
      ->get();

    return view('hr.estab.staffDueForIncDA', $data);
  }

  public function declineStaffDueForIncByDA(Request $request)
  {
    // dd($request->all());
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->declinevariationID)->update([
      'incremental_stage' => $request->incremental_stage,
      'is_rejected' => 1
    ]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->declinestaffid,
      'comment'         => $request['declineremark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => $request->incremental_stage,
      'year'            => $year,
      'variationID'     => $request->declinevariationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation rejected');
  }

  public function approveStaffIncrementToAudit(Request $request)
  {
    // dd($request->all());
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->variationID)->update(['incremental_stage' => $request->incremental_stage]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->staffid,
      'comment'         => $request['remark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => $request->incremental_stage,
      'year'            => $year,
      'variationID'     => $request->variationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation sent to Audit for processings');
  }

  public function declineStaffIncrementFromAudit(Request $request)
  {
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->declinevariationID)->update([
      'incremental_stage' => $request->incremental_stage,
      'is_rejected' => 1
    ]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->declinestaffid,
      'comment'         => $request['declineremark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => $request->incremental_stage,
      'year'            => $year,
      'variationID'     => $request->declinevariationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation rejected');
  }

  public function showStaffDueForIncrementAudit()
  {
    $data['variationList'] = DB::table('tblvariation_temp')
      ->join('tblper', 'tblper.ID', '=', 'tblvariation_temp.staffid')
      ->where('tblvariation_temp.incremental_stage', '=', 3)
      ->select(
        'tblper.ID as staffID',
        'tblper.fileNo',
        'tblper.surname',
        'tblper.first_name',
        'tblper.othernames',
        'tblvariation_temp.ID',
        'tblvariation_temp.old_grade',
        'tblvariation_temp.old_step',
        'tblvariation_temp.new_grade',
        'tblvariation_temp.new_step',
        'tblper.incremental_date',
        'tblvariation_temp.due_date',
        'tblvariation_temp.year_payment',
        'tblvariation_temp.is_rejected',
        'tblvariation_temp.createdAt',
      )
      ->get();

    return view('hr.estab.staffDueForIncAuditApproval', $data);
  }

  public function approveStaffIncrementToSalary(Request $request)
  {
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->variationID)->update(['incremental_stage' => $request->incremental_stage]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->staffid,
      'comment'         => $request['remark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => $request->incremental_stage,
      'year'            => $year,
      'variationID'     => $request->variationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation sent to Salary for processings');
  }

  public function showStaffDueForIncrementSalary()
  {
    $data['variationList'] = DB::table('tblvariation_temp')
      ->join('tblper', 'tblper.ID', '=', 'tblvariation_temp.staffid')
      ->where('tblvariation_temp.incremental_stage', '=', 4)
      ->select(
        'tblper.ID as staffID',
        'tblper.fileNo',
        'tblper.surname',
        'tblper.first_name',
        'tblper.othernames',
        'tblvariation_temp.ID',
        'tblvariation_temp.old_grade',
        'tblvariation_temp.old_step',
        'tblvariation_temp.new_grade',
        'tblvariation_temp.new_step',
        'tblper.incremental_date',
        'tblvariation_temp.due_date',
        'tblvariation_temp.year_payment',
        'tblvariation_temp.createdAt',
      )
      ->get();

    return view('hr.estab.staffDueForIncSalaryApproval', $data);
  }

  public function declineStaffIncrementFromSalary(Request $request)
  {
    $year = date('Y');
    DB::table('tblvariation_temp')->where('ID', $request->declinevariationID)->update([
      'incremental_stage' => $request->incremental_stage,
      'is_rejected' => 1
    ]);
    DB::table('tblvariation_comments')->insert(array(
      'staffid'         => $request->declinestaffid,
      'comment'         => $request['declineremark'],
      'sent_by'         => Auth::user()->id,
      'sent_to'         => $request->incremental_stage,
      'year'            => $year,
      'variationID'     => $request->declinevariationID,
      'updated_at'      => date('Y-m-d'),
    ));
    return back()->with('msg', 'Staff variation declined');
  }

}
