<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DateTime;
use File;
use Illuminate\Support\Facades\DB;

class forPromotionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function forPromotionConfirmation()
    {
        $data['shortlisted'] = DB::table('tblstaffpromotion_shortlist')
            ->join('tblper', 'tblper.ID', '=', 'tblstaffpromotion_shortlist.staffid')
            ->join('tbldepartment', 'tbldepartment.id', '=', 'tblper.department')
            ->join('tblforpromotion', 'tblforpromotion.promotionID', '=', 'tblstaffpromotion_shortlist.id')
            ->where('tblstaffpromotion_shortlist.status', '=', 1)
            ->where('tblstaffpromotion_shortlist.progress_stage', '=', 1)
            ->where('tblstaffpromotion_shortlist.approval_status', '=', 3)
            // ->where('tblstaffpromotion_shortlist.tblstaffpromotion_shortlist', '=', 3)
            ->select(
                'tblstaffpromotion_shortlist.*',
                'tblper.*',
                'tblforpromotion.*',
                'tbldepartment.department as departmentName'
            )

            ->paginate(200);
        return view('hr.forPromotion.promotion-confirmation', $data);
    }


    public function forPromotion($id = null)
    {
        $numbers = DB::table('tblper')->leftjoin('tblstaffpromotion_shortlist', 'tblstaffpromotion_shortlist.staffid', '=', 'tblper.ID')
            ->leftjoin('tbldesignation', 'tblper.designation', '=', 'tbldesignation.id')
            ->where('tblper.ID', $id)
            ->select(
                'tblper.*',
                'tblstaffpromotion_shortlist.post_sought',
                'tblstaffpromotion_shortlist.id as promotionID',
                'tblstaffpromotion_shortlist.confirmed_promoted as confirmedPromoted',
                'tbldesignation.designation as designationName'
            )
            ->get();

        // dd($id);
        $designation =  DB::table('tbldesignation')->where('id', $numbers[0]->post_sought)->get();
        $promotionStatus = DB::table('tblforpromotion')->where('promotionID', $numbers[0]->promotionID)->get();
        if (count($promotionStatus) > 0) {
            $data['promotionStatus'] = $promotionStatus;
        }

        $data['postPost'] = $designation[0]->designation;
        $data['numbers'] = $numbers;
        return view('hr.forPromotion.promotion', $data);
    }

    public function viewPromotion($id)
    {
        if ($id == '') {
            $numbers = DB::table('tblper')->join('tblstaffpromotion_shortlist', 'tblstaffpromotion_shortlist.staffid', '=', 'tblper.ID')
                ->leftjoin('tbldesignation', 'tblper.designation', '=', 'tbldesignation.id')
                ->select('tblper.*', 'tblstaffpromotion_shortlist.post_sought', 'tblstaffpromotion_shortlist.id as promotionID', 'tbldesignation.designation as designationName', 'tblstaffpromotion_shortlist.staffid', 'tblstaffpromotion_shortlist.confirmed_promoted')
                ->get();
        } else {
            $numbers = DB::table('tblper')->join('tblstaffpromotion_shortlist', 'tblstaffpromotion_shortlist.staffid', '=', 'tblper.ID')
                ->leftjoin('tbldesignation', 'tblper.designation', '=', 'tbldesignation.id')
                ->where('tblstaffpromotion_shortlist.id', '=', $id)
                ->select('tblper.*', 'tblstaffpromotion_shortlist.post_sought', 'tblstaffpromotion_shortlist.id as promotionID', 'tbldesignation.designation as designationName', 'tblstaffpromotion_shortlist.staffid', 'tblstaffpromotion_shortlist.confirmed_promoted')
                ->get();
        }
        $count = 0;
        // dd($numbers);
        foreach ($numbers as $key => $number) {
            $designation =  DB::table('tbldesignation')->where('id', $number->post_sought)->get();
            $promotionStatus = DB::table('tblforpromotion')->where('promotionID', $number->promotionID)->get();
            if (count($promotionStatus) > 0) {
                $number->aper = $promotionStatus[0]->aper;
                $number->exam = $promotionStatus[0]->exam;
                $number->interview = $promotionStatus[0]->interview;
                $number->oral_interview = $promotionStatus[0]->oral_interview;
                $number->total = $promotionStatus[0]->total;
                $number->qualification = $promotionStatus[0]->qualification;
                $number->remark = $promotionStatus[0]->remark;
                $number->promoStatus = 1;
                $count = $count + 1;
            } else {
                $number->promoStatus = 0;
            }
            if (count($designation) > 0) {

                $number->postPost = $designation[0]->designation;
            } else {

                $number->postPost = "";
            }
        }

        //$designation =  DB::table('tbldesignation')->where('id',$numbers[0]->post_sought)->get();
        $promotionStatus = DB::table('tblforpromotion')->where('promotionID', $numbers[0]->promotionID)->get();
        $data['promotionStatus'] = $promotionStatus;
        $data['postPost'] = $designation[0]->designation;
        $data['numbers'] = $numbers;

        return view('hr.forPromotion.finalPromotion', $data);
    }

    public function savePromotion(Request $request)
    {

        $this->validate($request, [
            'aper' => 'required|max:255',
            'exam' => 'required|max:255',
            'id' => 'required|max:255',
            'interview' => 'required',
            'oralInterview' => 'required'

        ]);

        if ($request->aper > 20 || $request->aper < 0) {
            return back()->with('err', 'Aper score must not be above 20 or less than 0');
        } elseif ($request->exam > 50 || $request->exam < 0) {
            return back()->with('err', 'Exam score must not be between 0 - 50');
        } elseif ($request->interview > 20 || $request->interview < 0) {
            return back()->with('err', 'Interview score must not be greater than 20 and must not be less than 0');
        } elseif ($request->oralInterview > 10 || $request->oralInterview < 0) {
            return back()->with('err', 'Interview score must not be less than 0 or greater than 10');
        }

        $total = $request->aper + $request->exam + $request->interview + $request->oralInterview;
        DB::table('tblforpromotion')->insert(
            [
                'aper' => $request->aper,
                'exam' => $request->exam,
                'promotionID' => $request->id,
                'interview' => $request->interview,
                'oral_interview' => $request->oralInterview,
                'total' => $total
            ]
        );


        return back()->with('success', 'Added Successfully');
    }

    public function saveUpdatePromotion(Request $request)
    {

        $this->validate($request, [
            'aper' => 'required|max:255',
            'exam' => 'required|max:255',
            'id' => 'required|max:255',
            'interview' => 'required',
            'oralInterview' => 'required'

        ]);

        if ($request->aper > 20 || $request->aper < 0) {
            return back()->with('err', 'Aper score must not be above 20 or less than 0');
        } elseif ($request->exam > 50 || $request->exam < 0) {
            return back()->with('err', 'Exam score must not be between 0 - 50');
        } elseif ($request->interview > 20 || $request->interview < 0) {
            return back()->with('err', 'Interview score must not be greater than 20 and must not be less than 0');
        } elseif ($request->oralInterview > 10 || $request->oralInterview < 0) {
            return back()->with('err', 'Interview score must not be less than 0 or greater than 10');
        }

        $total = $request->aper + $request->exam + $request->interview + $request->oralInterview;
        DB::table('tblforpromotion')->where('ID', $request->promoid)->update(
            [
                'aper' => $request->aper,
                'exam' => $request->exam,
                'promotionID' => $request->id,
                'interview' => $request->interview,
                'oral_interview' => $request->oralInterview,
                'total' => $total
            ]
        );


        return back()->with('success', 'Updated Successfully');
    }

    public function saveViewPromotion(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|max:255',
            'qualification' => 'required|max:255',
            'remark' => 'required'

        ]);
        DB::table('tblforpromotion')->where('promotionID', $request->id)->update(
            [
                'qualification' => $request->qualification,
                'remark' => $request->remark,
                'status' => 1
            ]
        );


        return back()->with('success', "Generation Complete");
    }

    public function deleteTraining(Request $request)
    {
        //
        $this->validate($request, [
            'id'   => 'required'
        ]);
        DB::table('tbltraining')->where('ID', $request->id)->delete();
        return redirect()->route('showTraining')->with('success', 'Training Deleted successfully');
    }

    public function admin()
    {
        $trainings = DB::table('tbltraining')->get();
        $data['trainings'] = $trainings;
        return view('training.admin', $data);
    }
    public function secretary()
    {
        $trainings = DB::table('tbltraining')->get();
        $data['trainings'] = $trainings;
        return view('training.secretary', $data);
    }
    public function pushForApproval($id)
    {
        $trainings = DB::table('tbltraining')->where('ID', $id)->update([
            'status' => 2
        ]);
        return back()->with('success', 'Pushed To Secretary For Approval');
    }
    public function secretaryApproval($id)
    {
        $trainings = DB::table('tbltraining')->where('ID', $id)->update([
            'status' => 3
        ]);
        return back()->with('success', 'Approved');
    }

    public function selectStaffDepartment(Request $request, $id)
    {
        $departments = DB::table('tbldepartment')->get();
        $data['departments'] = $departments;
        $cTraining = DB::table('tbltraining')->where('ID', $id)->get();

        $data['currentTraining'] = $id;
        $data['trainingStatus'] = $cTraining[0]->status;
        $trainings = DB::table('tbltraining_staff')->leftjoin('tblper', 'tbltraining_staff.staffID', '=', 'tblper.ID')
            ->where('tbltraining_staff.trainingID', $id)
            ->select('tbltraining_staff.*', 'tblper.first_name', 'tblper.surname', 'tblper.othernames', 'tblper.grade')
            ->get();

        $data['trainings'] = $trainings;
        if ($request->department != null) {
            $staffs = DB::table('tblper')->leftjoin('tbldepartment', 'tblper.department', '=', 'tbldepartment.id')
                ->where('tblper.department', $request->department)->select('tblper.*', 'tbldepartment.department as departmentName')->get();
            foreach ($staffs as $staff) {
                $check = DB::table('tbltraining_staff')->where('staffID', $staff->ID)->where('trainingID', $id)->get();
                if (count($check) > 0) {
                    $staff->selected = 1;
                } else {
                    $staff->selected = 0;
                }
            }

            $data['staffs'] = $staffs;
        }
        return view('training.selectStaff', $data);
    }
    public function deSelectStaff(Request $request)
    {

        $this->validate($request, [
            'ID'   => 'required'
        ]);
        DB::table('tbltraining_staff')->where('ID', $request->ID)->delete();
        return back()->with('success', 'Staff Removed successfully');
    }
    public function selectStaff(Request $request)
    {
        $this->validate($request, [
            'trainingID'   => 'required',
            'staffID'   => 'required'
        ]);
        DB::table('tbltraining_staff')->insert([
            'staffID' => $request->staffID,
            'trainingID' => $request->trainingID,
            'staff_status' => 1,
        ]);
        return back()->with('success', 'Staff Added successfully');
    }
    public function concludeTraining(Request $request)
    {
        $this->validate($request, [
            'id'   => 'required',
            'comment' => 'required',
            'report' => 'required',
            'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $imageName = time() . '.' . $request->attachment->extension();


        $request->attachment->move('\\\DESKTOP-KOL7014\www\njchr\public\trainingAttachment\\', $imageName);
        DB::table('tbltraining')->where('ID', $request->id)->update([
            'status' => 4,
            'attendance_attachment' => $imageName,
            'Comment' => $request->comment,
            'Report' => $request->report
        ]);
        return back()->with('success', 'Training Concluded');
    }
    public function getStaff() {}
}
