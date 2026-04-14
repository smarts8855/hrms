<?php

namespace App\Http\Controllers\hr;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProcessVariationController extends Controller
{
    public function printDoc($id)
    {
        $data['staff'] = DB::table('tblper')->where('ID','=', $id)->first();
        $data['varTemp'] = DB::table('tblvariation_temp')->where('staffid','=', $id)->first();
        $data['comments'] = DB::table('tblvariation_comments')
        ->leftJoin('users','users.id','=','tblvariation_comments.sent_by')
        ->where('staffid','=', $id)
        ->where('reverse','=', 0)
        ->get();

        return view('hr.estab/printDoc',$data);
    }

    public function variationOrder($id, $year)
    {
      // $data['stages'] = DB::table('tblaction_stages')->where('userID','=',Auth::user()->id)->first();
      // if(empty($data['stages']))
      // {
      //   return back()->with('msg','You are not Permitted to view that page');
      // }
      //dd( $data['stages']);
        $staff = DB::table('tblvariation_temp')->where('ID','=', $id)->where('year_payment', $year)->first();
        // dd($staff);
        $data['staff'] = DB::table('tblper')
        ->join('tblvariation_temp','tblvariation_temp.staffid','=','tblper.ID')
        ->where('staffid','=', $staff->staffid)->first();
        $data['salary'] = DB::table('basicsalaryconsolidated')
        ->where('grade','=', $staff->new_grade)
        ->where('step','=', $staff->new_step)
        ->first();
         $data['oldsalary'] = DB::table('basicsalaryconsolidated')
        ->where('grade','=', $staff->old_grade)
        ->where('step','=', $staff->old_step)
        ->first();
        return view('hr.estab/variationOrder',$data);
    }

    public function storeArrears(Request $request)
    {
        $list= DB::table('tblvariation_temp')->where('staffid','=', $request['staff'])->first();
        /*DB::table('tblstaff_for_arrears')->insert(array(
                            'staffid'         => $list->ID,
                            'fileNo'          => $list->fileNo,
                            'courtID'         => $list->courtID,
                            'divisionID'      => $list->divisionID,
                            'arrears_type'    => 'increment',
                            'old_grade'       => $list->grade,
                            'old_step'        => $list->step,
                            'new_grade'       => $list->grade,
                            'new_step'        => $newStep,
                            'due_date'        => $list->appointment_date,
                            'approvedBy'      => Auth::user()->name,
                            'approvedDate'    => date('Y-m-d'),
                           ));

                           DB::table('tblper')->where('ID','=',$list->ID)->update(array(
                            'grade'       => $list->grade,
                            'step'        => $list->step,

                           ));*/
        DB::table('tblvariation_temp')->where('staffid','=',$request['staff'])->update(array(
                            'confirm'              => 1,

                           ));
         DB::table('tblvariation_comments')->where('staffid','=',$request['staff'])->where('payment_status','=',0)->update(array(
                            'payment_status'         => 1,

                           ));
    return response()->json('Successfully Approved for Payment');
    }

    public function variationRemark(Request $request)
    {

        $staffid   = $request['staffid'];
        $data      = DB::table('tblper')->where('ID','=',$staffid)->first();

        return response()->json($data);

    }

     public function saveRemark(Request $request)
    {

        $staffid   = $request['staffid'];
        $varTempID   = $request['varID'];

        $data      = DB::table('tblper')->where('ID','=',$staffid)->first();

        $stages = DB::table('tblaction_stages')->where('userID','=',Auth::user()->id)->first();
        //dd($stage);
        if(!empty($stage))
        {
            $data['stage'] = $stages->action_stageID;

        }
        if(empty($stages))
        {
            $stageVal = 0;
            $dept = 0;
        }
        else{
            $stageVal = $stages->action_stageID;
            $dept = $stages->departmentID;
        }

        $code = $request['staffCode'];

        $yr = date('Y', strtotime($data->incremental_date)) + 1;
        $mt = date('m', strtotime($data->incremental_date));
        $dy = date('d', strtotime($data->incremental_date));

        $dueDate = "$yr-$mt-$dy";
        //dd($dueDate);

        $y = date('Y');

        if($request->stage == 0)
        {
            $nextstage = 3;
        }
        elseif($request->stage == 3)
        {
            $nextstage = 7;
        }
        elseif($request->stage == 7)
        {
            $nextstage = 8;
        }
        elseif($request->stage == 8)
        {
            $nextstage = 9;
        }


          $check = DB::table('tblvariation_temp')->where('staffid','=',$staffid)->where('treated','=',0)->where('year_payment','=',$y)->count();
          $year = date('Y');
          $newStep = $data->step + 1;
          if($check == 0 )
            {
            $id = DB::table('tblvariation_temp')->insertGetId(array(
            'staffid' => $data->ID,
            'fileNo' => $data->fileNo,
            'courtID' => $data->divisionID,
            'arrears_type' => 'increment',
            'old_grade' => $data->grade,
            'old_step' => $data->step,
            'new_grade' => $data->grade,
            'new_step' => $newStep,
            'due_date' => date('Y-m-d', strtotime(trim($data->incremental_date))),
            'year_payment'  => $year,
            //'approvedBy'             => Auth::user()->name,
            'newEmploymentType'      => $data->employee_type,
            'oldEmploymentType'      => $data->employee_type,
            //'approvedDate' => date('Y-m-d'),
            'stage'        => $nextstage,
            'processed_by'             => Auth::user()->id,
             ));


         DB::table('tblvariation_comments')->insert(array(
                            'staffid'         => $staffid ,
                            'comment'         => $request['remark'],
                            'sent_by'         => Auth::user()->id,
                            'sent_to'         => 'DD',
                            'sentby_code'     => $stageVal,
                            'year'            => $year,
                            'present_stage'   => $nextstage,
                            'variationID'     => $id,
                            'updated_at'      => date('Y-m-d'),
                           ));

         DB::table('tblper')->where('ID','=',$staffid)->update(array(
                            'increment_alert'         => 1,

                           ));

        return back()->with('msg','Staff variation sent for further Approval');
      }
        elseif($stageVal == 3)
        {

          DB::table('tblvariation_temp')->where('staffid','=',$staffid)->where('ID','=',$varTempID)->update(array(

            //'approvedBy'             => Auth::user()->name,
            //'approval_status'        => 1,
            //'approvedDate' => date('Y-m-d'),
            'stage'        => $nextstage,
            'processed_by'             => Auth::user()->id,
             ));


              /*DB::table('tblvariation_comments')
             ->where('sent_to','=','PA')
             ->where('staffid','=',$staffid)
             ->where('payment_status','=',0)
             ->update(array(

                            'worked_on'       => 1,
                             ));
                             */
        /* DB::table('tblper')->where('ID','=',$staffid)->update(array(
                            'increment_alert'         => 2,

                           ));
                           */
          return back()->with('msg','Staff variation sent for further Processing');
        }

        else
        {
          DB::table('tblvariation_temp')->where('staffid','=',$staffid)->where('ID','=',$varTempID)->update(array(
            'stage'        => $nextstage,
            'processed_by'             => Auth::user()->id,
             ));
             DB::table('tblvariation_comments')->insert(array(
                            'staffid'         => $staffid ,
                            'comment'         => $request['remark'],
                            'sent_by'         => Auth::user()->id,
                            'sent_to'         => 'DD',
                            'sentby_code'     => 'AS',
                            'present_stage'   => $nextstage,
                            'variationID'     => $varTempID,
                            'updated_at'      => date('Y-m-d'),
                           ));



          return back()->with('msg','Staff variation sent for further Processing');
        }


    }

    public function push(Request $request)
    {
      $staffid   = $request['staffid'];
      $varTempID   = $request['varID'];
      $stage = DB::table('tblaction_stages')->where('userID','=',Auth::user()->id)->first();
        //dd($stage);
        $year = date('Y');
        if(!empty($stage))
        {
            $data['stage'] = $stage->action_stageID;

        }
        if(empty($stage))
        {
            $stageVal = 0;
            $dept = 0;
        }
        else{
            $stageVal = $stage->action_stageID;
            $dept = $stage->departmentID;
        }

        DB::table('tblvariation_temp')->where('staffid','=',$staffid)->where('ID','=',$varTempID)->update(array(

          'approvedBy'             => Auth::user()->id,
          'approval_status'        => 1,
          'approvedDate'           => date('Y-m-d'),
          'processed_by'           => Auth::user()->id,
          //'stage'        => $nextstage,
           ));

           DB::table('tblvariation_comments')->insert(array(
            'staffid'         => $staffid,
            'comment'         => $request['remark'],
            'sent_by'         => Auth::user()->id,
            'sent_to'         => 'DD',
            'year'            => $year,
            'sentby_code'     => 'PA',
            //'present_stage'   => $nextstage,
            'variationID'     => $varTempID,
            'updated_at'      => date('Y-m-d'),
           ));

           return back()->with('msg','Staff variation sent for further Processing');
    }

     public function reverseRemark(Request $request)
    {

        $staffid   = $request['staffid'];
        //dd($staffid );
        $varTempID   = $request['varID'];
        $data['stage'] = '';
        //$data      = DB::table('tblper')->where('ID','=',$staffid)->first();
        $staff = DB::table('tblvariation_approval_staff')
         ->where('user_id','=',Auth::user()->id)
         ->first();
         $stage = DB::table('tblaction_stages')->where('userID','=',Auth::user()->id)->first();
         $varStaff = DB::table('tblvariation_temp')->where('ID','=',$varTempID)->first();
        //dd($stage->action_stageID);
        $year = date('Y');
        if(!empty($stage))
        {

          $data['stage'] = $stage->action_stageID;
        }
        //$data['stages'] = $data;
        if(empty($stage))
        {
            $stageVal = 0;
            $dept = 0;
        }
        else{
            $stageVal = $stage->action_stageID;
            $dept = $stage->departmentID;

        }
//dd($staffid);
        if($stageVal == 3)
        {
          //dd($varTempID);
          if($varStaff->is_rejected ==1)
          {
            DB::table('tblvariation_temp')->where('ID','=',$varTempID)->update(array(
              'approval_status' => 0,
              'is_rejected' => 0,

               ));
               DB::table('tblvariation_comments')->where('variationID','=',$varTempID)->update(array(

                'rejected'        => 0,
                'updated_at'      => date('Y-m-d'),
               ));
               return back()->with('msg','Successfully Reverse');
          }
          elseif($varStaff->approval_status == 1)
          {
          DB::table('tblvariation_temp')->where('ID','=',$varTempID)->update(array(

            'approval_status' => 0,
            'is_rejected' => 0,

             ));
            // return response()->json('Successfully Reversed');
        return back()->with('msg','Successfully Reverse');
            }
        }




    }


    public function reject(Request $request)
    {

        $staffid   = $request['staffid'];
        $data      = DB::table('tblper')->where('ID','=',$staffid)->first();

        $code = $request['staffCode'];


             DB::table('tblvariation_comments')->insert(array(
                            'staffid'         => $staffid,
                            'comment'         => $request['remark'],
                            'sent_by'         => Auth::user()->id,
                            'sent_to'         => 'VO',
                            'sentby_code'     => 'PA',
                            'rejected'        => 1,
                            'updated_at'      => date('Y-m-d'),
                           ));

                           DB::table('tblvariation_temp')->where('staffid','=',$staffid)->update(array(
                            'approvedby'             => Auth::user()->id,
                            'is_rejected' => 1,
                            //'stage'        => 7,
                             ));
         return back()->with('msg','Rejected');
    }


    public function variationApproval()
    {
       $data['approver'] = DB::table('tblvariation_approval_staff')
         ->where('user_id','=',Auth::user()->id)
         ->first();
        // $code ='';
        $data['stage'] = '';
        $stage = DB::table('tblaction_stages')->where('userID','=',Auth::user()->id)->first();
        //dd($stage);
        if(!empty($stage))
        {
            $data['stage'] = $stage->action_stageID;

        }
        if(empty($stage))
        {
            $stageVal = 0;
            $dept = 0;
        }
        else{
            $stageVal = $stage->action_stageID;
            $dept = $stage->departmentID;
        }
        if($stageVal == 2)
            {
                $data['next'] = 'Registry';
            }

            elseif($stageVal == 2)
            {
                $data['next'] = 'Head of Department';
            }
            elseif($stageVal == 3)
            {
                $data['next'] = 'Variation';
            }

            elseif($stageVal == 7)
            {
                $data['next'] = 'Audit';
            }
            elseif($stageVal == 8)
            {
                $data['next'] = 'Head of Account';
            }


         $userId = Auth::user()->id;
         $data['variationList'] = DB::table('tblvariation_temp')
         ->join('tblper','tblper.ID','=','tblvariation_temp.staffid')
         //->join('tblvariation_comments','tblvariation_comments.staffid','=','tblvariation_temp.staffid')
         ->where('tblvariation_temp.stage','=',$stageVal)
         ->select('*','tblper.ID as staffID','tblvariation_temp.ID as varTempID')
         ->get();
         /*
         //old code
         if( $data['approver'] == '')
         {
          $code = '';
         }
         else
         {
          $code = $data['approver']->code;
         }

         $data['variationList'] = DB::Select("select * from tblvariation_comments join tblper on tblper.ID = tblvariation_comments.staffid where (sent_to = '$code' ) and payment_status =0 and (worked_on =0 or no_recall = 0) and reverse=0 group by tblvariation_comments.staffid");
End old code
         */
 //dd($data['variationList'] );

         return view('hr.estab.variationApproval',$data);

    }


    public function variationApprovalPA()
    {
       $data['approver'] = DB::table('tblvariation_approval_staff')
         ->where('user_id','=',Auth::user()->id)
         ->first();
        // $code ='';
      $userId = Auth::user()->id;
         if( $data['approver'] == '')
         {
          $code = '';
         }
         else
         {
          $code = $data['approver']->code;
         }
         //dd($code);
          //$data['variationList'] = DB::table('tblvariation_comments')
         //->join('tblper','tblper.ID','=','tblvariation_comments.staffid')
          /*->where(function ($query) {
                $query->where('sent_to','=',$code)
                      ->orWhere('sent_by', '=', 'AS');
            })
         */
         //->where('payment_status','=',0)
         //->where('worked_on','=',0)

        // ->groupBy('tblvariation_comments.staffid')
         //->get();

         $data['variationList'] = DB::Select("select * from tblvariation_comments join tblper on tblper.ID = tblvariation_comments.staffid where (sent_to = '$code' ) and sent_by = '$userId' and payment_status =0 and (worked_on =0) group by tblvariation_comments.staffid");

         return view('hr.estab.variationApproval',$data);

    }

    public function variationApprovalDD()
    {
       $data['approver'] = DB::table('tblvariation_approval_staff')
         ->where('user_id','=',Auth::user()->id)
         ->first();
        // $code ='';
      $userId = Auth::user()->id;
         if( $data['approver'] == '')
         {
          $code = '';
         }
         else
         {
          $code = $data['approver']->code;
         }
         //dd($code);
          //$data['variationList'] = DB::table('tblvariation_comments')
         //->join('tblper','tblper.ID','=','tblvariation_comments.staffid')
          /*->where(function ($query) {
                $query->where('sent_to','=',$code)
                      ->orWhere('sent_by', '=', 'AS');
            })
         */
         //->where('payment_status','=',0)
         //->where('worked_on','=',0)

        // ->groupBy('tblvariation_comments.staffid')
         //->get();

         $data['variationList'] = DB::Select("select * from tblvariation_comments join tblper on tblper.ID = tblvariation_comments.staffid where (sent_to = '$code' ) and sent_by = '$userId' and payment_status =0 and (worked_on =0) group by tblvariation_comments.staffid");

         return view('hr.estab.variationApproval',$data);

    }

    public function variationApprovalAudit()
    {
       $data['approver'] = DB::table('tblvariation_approval_staff')
         ->where('user_id','=',Auth::user()->id)
         ->first();
        // $code ='';
      $userId = Auth::user()->id;
         if( $data['approver'] == '')
         {
          $code = '';
         }
         else
         {
          $code = $data['approver']->code;
         }
         //dd($code);
          //$data['variationList'] = DB::table('tblvariation_comments')
         //->join('tblper','tblper.ID','=','tblvariation_comments.staffid')
          /*->where(function ($query) {
                $query->where('sent_to','=',$code)
                      ->orWhere('sent_by', '=', 'AS');
            })
         */
         //->where('payment_status','=',0)
         //->where('worked_on','=',0)

        // ->groupBy('tblvariation_comments.staffid')
         //->get();

         $data['variationList'] = DB::Select("select * from tblvariation_comments join tblper on tblper.ID = tblvariation_comments.staffid where (sent_to = '$code' ) and sent_by = '$userId' and payment_status =0 and (worked_on =0) group by tblvariation_comments.staffid");

         return view('hr.estab.variationApproval',$data);

    }

    public function rejectReason(Request $request)
    {
        $approver = DB::table('tblvariation_approval_staff')
         ->where('user_id','=',Auth::user()->id)
         ->first();
        $staffid   = $request['staffid'];
        $data      = DB::table('tblvariation_comments')
         ->join('tblper','tblper.ID','=','tblvariation_comments.staffid')
        ->where('variation','=',$staffid)
        ->where('rejected','=',1)
        ->where('sent_to','=',$approver->code)
        ///->select('comment')
        ->first();

        return response()->json($data);
    }

    public function promotionArrearsEntry()
    {
    $data['CourtInfo']=$this->CourtInfo();
      if($data['CourtInfo']->courtstatus==0){$request['court']=$data['CourtInfo']->courtid;}
      if($data['CourtInfo']->divisionstatus==0){$request['division']=$data['CourtInfo']->divisionid;}

      $staffses = session('staff_id');

     $data['staffData'] = DB::table('tblper')->where('courtID','=',$data['CourtInfo']->courtid)->orderBy('surname')->get();
     $data['staff'] = DB::table('tblper')
        ->join('tblemployment_type','tblemployment_type.id','=','tblper.employee_type')
        ->where('tblper.ID','=', $staffses)
        ->first();
        //dd($data['staff']);
      return view('hr.estab.promotionArrearsEntry',$data);
    }

     public function createSes(Request $request)
    {

        $staffid   = $request['staff'];
        $request->session()->flash('staff_id',$staffid);
        //Session::put('judge_id',$request['id']);

        return response()->json('set');

    }

    public function saveEntry(Request $request)
    {
        //dd('ok');
         $insert = DB::table('tblvariation_temp')->insert(array(
       'staffid'                => $request['fileNo'],
       'newEmploymentType'      => $request['newEmpType'],
       'oldEmploymentType'      => $request['newEmpType'],
       'courtID'                => $request['court'],
       'old_grade'              => $request['oldGrade'],
       'old_step'               => $request['oldStep'],
       'new_grade'              => $request['newGrade'],
       'new_step'               => $request['newStep'],
       'due_date'               => $request['dueDate'],
       'divisionID'             => $request['division'],
       'arrears_type'           => $request['arrearsType'],

       'payment_status'         => 0,
      ));

      /* DB::table('tblper')->where('staffid','=',$request['fileNo'])->update(array(
       'grade_new'              => $request['newGrade'],
       'step_new'               => $request['newStep'],
      ));
      */

     /* $staff = $this->getOneStaff($request['fileNo']);
      if($staff != '')
      {
      $this->addLog("Variation added for $staff->surname $staff->first_name $staff->othernames with File Number $staff->fileNo");
      }*/
      if($insert)
      {
        return redirect('/admin/promotion-arrears/entry')->with('msg','Successfully Entered');
      }
      else {
        return redirect('/admin/promotion-arrears/entry')->with('err','Record could not be saved');
      }

    }
    public function variationList()
    {
        $data['variationList'] = DB::table('tblvariation_temp')
        ->join('tblper','tblper.ID','=','tblvariation_temp.staffid')
        ->where('tblvariation_temp.treated','=',0)->get();
        return view('hr.estab.variationList',$data);
    }
    public function saveVariation(Request $request)
    {
        $con = $request['confirm'];
        foreach($con as $key => $value)
        {
         $data =  DB::table('tblvariation_temp')->where('staffid','=',$request['confirm'][$key])->first();

        DB::table('tblstaff_for_arrears2')->insert(array(
       'staffid'                => $data->staffid,
       'newEmploymentType'      => $data->newEmploymentType,
       'oldEmploymentType'      => $data->oldEmploymentType,
       'courtID'                => $data->courtID,
       'old_grade'              => $data->old_grade,
       'old_step'               => $data->old_step,
       'new_grade'              => $data->new_grade,
       'new_step'               => $data->new_step,
       'due_date'               => $data->due_date,
       'divisionID'             => $data->divisionID,
       'arrears_type'           => $data->arrears_type,
       'payment_status'         => 0,
      ));

       DB::table('tblvariation_temp')->where('staffid','=',$request['confirm'][$key])->update(array(
       'treated'         => 1,
      ));

     /* DB::table('tblper')->where('staffid','=',$request['confirm'][$key])->update(array(
       'grade'              => $data->new_grade,
       'step'               => $data->new_step,
      ));
      */
        }

        return back()->with('msg','Successful');
    }

    public function approveArrears(Requests $request)
    {

    return response()->json('Successfully Approved for Payment');

    }

}
