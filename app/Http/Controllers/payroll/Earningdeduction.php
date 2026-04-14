<?php

namespace App\Http\Controllers\payroll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use DB;

class Earningdeduction extends Controller
{
   
    public function index()
    {
        //
    }
    
    
    Public function DivisionList1 ($court){
		$DepartmentList= DB::Select("SELECT *,
		(SELECT `court_name`  FROM `tbl_court` WHERE `tbl_court`.`id`=`tbldivision`.`courtID`) as court_names 
		FROM `tbldivision` WHERE `tbldivision`.`courtID`='$court'");
		return $DepartmentList;
	}
	
    Public function DivisionStaffList($court,$division){
	$myData= DB::table('tblper')
            ->join('tbldivision', 'tbldivision.divisionID', '=', 'tblper.divisionID')
            ->select('fileNo', 'surname', 'first_name', 'othernames')
            ->where('tblper.divisionID','=', $division)
            ->where('tblper.courtID', $court)
            ->orderBy('surname', 'Asc')->get();
            return $myData;
	}



	Public function ConfirmDeduction($staffName,$earningDeduction){
		$confir= DB::Select("SELECT * FROM `tblstaffEarningDeduction` WHERE `fileNo`='$staffName' and `earningDeductionID`='$earningDeduction'");
		if(($confir))
		   {
			   return true;
		   }
		   else
		   {
			return false;
		   }
	}
   
 

public function GetEarning($staffName){
        # code...

        $getEarning = DB::table('tblstaffEarningDeduction')
                     ->join('tblearningDeductions','tblearningDeductions.ID','=','tblstaffEarningDeduction.earningDeductionID')
                     ->join('tblper','tblper.fileNo','=','tblstaffEarningDeduction.fileNo')

                     ->where('tblstaffEarningDeduction.fileNo','=',$staffName)
                     ->select ('*', 'tblstaffEarningDeduction.ID as E_id ')
                     ->get();

        return $getEarning;
    }
   

public function checkStatus($delID){
    	# code...

    	$check = DB::Select("SELECT * FROM `tblstaffEarningDeduction` WHERE `ID`='$delID' AND `status` !='0' ");

    	if(($check))
		   {
			   return true;
		   }
		   else
		   {
			return false;
		   }
    }
   


	public function Show(Request $request)
    {
    
    	$data['error'] = "";
        $data['warning'] = "";
        $data['success'] = "";
        
        $court= trim($request['court']);
	   	$data['court'] = $court; 
		$division= trim($request['division']);
	   	$data['division'] = $division;
	   	$staffName= trim($request['staffName']);
	   	$data['staffName'] = $staffName;
	   	$amount= trim($request['amount']);
	   	$data['amount'] = $amount;
	   	$earningDeduction= trim($request['earningDeduction']);
	   	$data['earningDeduction'] = $earningDeduction;
	   	$remark= trim($request['remark']);
	   	$data['remark'] = $remark;
	   	// Edit Variables
	   	
        $data['courts'] = DB::table('tbl_court')->get();
         	//$data['scale'] ='';
		$data['CourtList'] = DB::table('tbl_court')->select('id', 'court_name')->get();
		$data['earningDeductionList'] = $this->GetEarning($staffName);
		$data['DivisionList'] = $this->DivisionList1($court);
		$data['staffList'] = $this->DivisionStaffList($court,$division);
		$data['earningDeduction'] = DB::table('tblearningDeductions')->get();
	
	 
	
	
			if ( isset( $_POST['add'] ) ) {
				$this->validate($request, [
				'division'      	=> 'required'
				,'court'      	   	=> 'required'
				,'staffName'      	   	=> 'required'
				,'earningDeduction'      	   	=> 'required'
				,'amount'      	   	=> 'required'

				
				]);
				

				
				 
					DB::insert("INSERT INTO `tblstaffEarningDeduction` ( `courtID`, `divisionID`, `fileNo`, `earningDeductionID`, `amount`,`remarks`) VALUES ('$court','$division','$staffName','$earningDeduction','$amount', '$remark')");
					$data['earningDeductionList'] = $this->GetEarning($staffName);
					
					$data['success'] = "Earning deduction successfully added";
					
					return view('payroll.deduction.deduction', $data);
			} 
		 
			 if ( isset( $_POST['edit'] ) ) {
				 
                $amountedit = trim($request['amountedit']);    
                $earningDeductionID = trim($request['earningDeductionID']);
                $earningDeductionedit = trim($request['earningDeductionedit']);
                $remarkedit = trim($request['remarkedit']);
				
				$editCheck = $this->checkStatus($earningDeductionID);

				if ($editCheck  == true){

					$data['earningDeductionList'] = $this->GetEarning($staffName);
					$data['warning'] = "Earning deduction can't be edited";
					
					return view('payroll.deduction.deduction', $data);

				} else{
					
				DB::table('tblstaffEarningDeduction')->where('ID',$earningDeductionID)->update(['amount' => $amountedit, 'earningDeductionID' => $earningDeductionedit, 'Remarks' => $remarkedit]);
				$data['earningDeductionList'] = $this->GetEarning($staffName);
				$data['success'] = "Earning deduction was edited successfully";
				
				return view('payroll.deduction.deduction', $data);

				}
			 }


			 if ( isset( $_POST['delete'] ) ) {
				
				$delID = trim($request['delID']);
   
 				$confirmCheck = $this->checkStatus($delID);

 				if ($confirmCheck == true){

 						$data['warning'] = "Earning deduction can't be deleted";
		                $data['earningDeductionList'] = $this->GetEarning($staffName);
						
						return view('payroll.deduction.deduction', $data);

 				} else {
   
					DB::table('tblstaffEarningDeduction')->where('ID', $delID)->delete();
					$data['success'] = "Earning deduction was deleted successfully";
	                $data['earningDeductionList'] = $this->GetEarning($staffName);
					
					return view('payroll.deduction.deduction', $data);

				}

			 }
	
        return view('payroll.deduction.deduction',$data);
    }
    
 
 

    public function display(Request $request)
    {

        $data['courts'] = DB::table('tbl_court')->get();
        $btn                   = $request['submit'];
        $court                 = $request['court'];
        $grade                 = $request['grade'];
        $step                  = $request['step'];
        $empType               = $request['employeeType'];

        Session::put('court', $court);
        Session::put('step', $step);
        Session::put('employeeType', $empType);
        Session::put('grade', $grade);

        $data['count'] = DB::table('basicsalary')
             ->where('courtID','=',$court)
             ->where('grade','=',$grade)
             ->where('step','=',$step)
             ->where('employee_type','=',$empType)
             ->count(); 
             //dd($data['count']);

             if($data['count'] == 0)
             {
                //$data['verify'] = 'add_new';
               Session::put('verify', 'add_new');
             } 
             elseif($data['count'] > 0)
             {
                //$data['verify'] = 'update';
                 Session::put('verify', 'update');
             }


             //dd($data['verify']);
        
         if($btn == 'Display')
         {
             $data['scale'] = DB::table('basicsalary')
             ->where('courtID','=',$court)
             ->where('grade','=',$grade)
             ->where('step','=',$step)
             ->where('employee_type','=',$empType)
             ->first();

             //dd($data['scale']);

             return view('payroll/salarySetup/createSalary',$data);
         }
    }


    public function save(Request $request)
    {
        
         $this->validate($request, [
            'basic'         => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'leaveBonus'      => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'peculiar'         => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'hoiusing'      => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'transport'     => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'utility'       => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'furniture'     => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'meal'      => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'driver'        => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'pension'       => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'nhf'           => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'tax'       => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'unionDues'     => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
            'servant'       => 'regex:/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/',
        ]);
       
        $basic                    = $request['basic'];
        $leaveBonus               = $request['leaveBonus'];
        $peculiar                 = $request['peculiar'];
        $housing                  = $request['housing'];
        $transport                = $request['transport'];

        $utility                  = $request['utility'];
        $furniture                = $request['furniture'];
        $meal                     = $request['meal'];
        $driver                   = $request['driver'];
        $tax                      = $request['tax'];
        $pension                  = $request['pension'];
        $nhf                      = $request['nhf'];
        $union                    = $request['unionDues'];
        $servant                  = $request['servant'];

        $id                       = $request['id'];
        $employeeType             =  $request->session()->get('employeeType');
        $grade                    =  $request->session()->get('grade');
        $step                     =  $request->session()->get('step');
        $court                    =  $request->session()->get('court');
        $date                     = date('Y-m-d');

        //dd( $court);

        if($id != '')
       {
       DB::table('basicsalary')->where('ID', $id)->update(array(  
         'amount'             => $basic, 
        'employee_type'      => $employeeType,
        'courtID'            => $court,
        'grade'              => $grade,
        'step'               => $step, 
        'tax'                => $tax, 
        'servant'            => $servant,
        'meal'               => $meal, 
        'driver'             => $driver, 
        'housing'            => $housing, 
        'transport'          => $transport, 
        'utility'            => $utility, 
        'furniture'          => $furniture, 
        'peculiar'           => $peculiar, 
        'leave_bonus'        => $leaveBonus, 
        'pension'            => $pension, 
        'nhf'                => $nhf, 
        'unionDues'          => $step, 
        'date'               => $date,
       ));

        return redirect('/salary/create')->with('msg','updated Successfully');

       }
       elseif($id == '')
       {
        $insert = DB::table('basicsalary')->insert(array(  
        'amount'             => $basic, 
        'employee_type'      => $employeeType,
        'courtID'            => $court,
        'grade'              => $grade,
        'step'               => $step, 
        'tax'                => $tax, 
        'servant'            => $servant,
        'meal'               => $meal, 
        'driver'             => $driver, 
        'housing'            => $housing, 
        'transport'          => $transport, 
        'utility'            => $utility, 
        'furniture'          => $furniture, 
        'peculiar'           => $peculiar, 
        'leave_bonus'        => $leaveBonus, 
        'pension'            => $pension, 
        'nhf'                => $nhf, 
        'unionDues'          => $step, 
        'date'               => $date,
       ));
        if($insert)
       {
        Session::put('verify', 'update');
       }
        return redirect('/salary/create')->with('msg','Added Successfully');
       }
    }
    
    
    public function updateEarning(Request $request){
   	$data['error'] = "";
	   $data['warning'] = "";
	    $data['success'] = "";
	$CourtID = trim($request['CourtID']);    
	$department = trim($request['DeptID']);
	Session::put('DepartmentID', $department);
	Session::put('CourtID', $CourtID);
   	$designation = trim($request['designation']);
        $PostID = trim($request['PostID']);
        
        DB::table('tbldesignation')->where('id',$PostID)->update(['designation' => $designation]);
        //$data['success'] = "$designation section successfully Updated";
        //$data['DesignationList'] = $this->DesignationList2($department);
	//$data['DeptList'] = $this->DeptList2();
	//return view('basicparameter.designation', $data);
	return redirect('basic/designation')->with('message',' successfully updated');;
   }
   
    public function deleteEarning(Request $request){
   
   $postID = trim($request['PostID']);
   
   $department = trim($request['depty']);
   $court = trim($request['courty']);
   Session::put('CourtID', $court);
	
   
   	DB::table('tbldesignation')->where('id', $postID)->delete();
   	
        return redirect('basic/designation')->with('message','Post successfully deleted');
   
   }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
