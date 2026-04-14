<?php

namespace App\Http\Controllers\hr;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use Session;
use DateTime;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StaffIncrementFunctionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    
    //Increment Alert
    public function incrementSearch(Request $request)
    {
        $lastIncrementDate  = $request['lastIncrementDate'];
        return redirect()->route('listStaffIncrement', ['id'=>$lastIncrementDate]);
    }
    
    
    public function showStaffDueForIncrement($getDate = null)
    {   
        $data = [];
        $data3['lastIncrementDate'] = $getDate;
        
        //Initial
        $letGetAll1stYearTableID            = [];
        $newDateDueForIncrement             = [];
        $incrementStatus                    = [];
        
        //Get date parameters to start...
         $getSearchDete  = ($getDate ? $getDate : date('Y-m-d', strtotime(date('Y').'-'.(date('m') +1).'-'. date('d')))); 
         $defaultYear      = ($getDate ? date('Y', strtotime($getDate)) : date('Y'));
         $defaultMonth      = ($getDate ? date('m', strtotime($getDate)) : date('m') );
         $getMonth          = ( $getDate ? $defaultMonth : $defaultMonth + 01);
         $defaultDay      = ($getDate ? date('d', strtotime($getDate)) : date('d') );
        
        //Get all staff
        try{
             $getStaffList = DB::table('tblper')
                ->leftJoin('tblbanklist', 'tblbanklist.bankID', '=', 'tblper.bankID')
                ->where('tblper.staff_status', 1)
                ->where('tblper.employee_type', '<>', 2)
                ->where('tblper.ID', '<>', 1)
                ->where('tblper.grade', '<>', 17)
                ->get();
        }catch(\Throwable $e){}
        
        if($getStaffList)
        {
            foreach($getStaffList as $key=>$item)
            {
                $getPresentAppointDateYear      = date('Y', strtotime($item->incremental_date ));
                $getPresentAppointDateMonth     = date('m', strtotime($item->incremental_date ));
                $getPresentAppointDateDay       = date('d', strtotime($item->incremental_date ));
                $appointmentDateYear            = date('Y', strtotime($item->appointment_date ));
                $getIfFirstYear                 = date('Y') - $appointmentDateYear;
                //$get1stYearIncrement            = ($getPresentAppointDateYear + 1);
                $newDateDueForIncrement[$item->ID] = $getPresentAppointDateDay .'-'. $getPresentAppointDateMonth .'-'. ($getPresentAppointDateYear + 1);
                
                if( ($getPresentAppointDateYear < $defaultYear) && $getPresentAppointDateMonth <= ($getMonth) && ($getPresentAppointDateDay <= $defaultDay ) )
                {
                    $letGetAll1stYearTableID[]  = $item->ID;
                    $incrementStatus[$item->ID] = ''; //$this->getNoMonth($item->incremental_date, $getSearchDete);
                    
                    if( $this->getNoMonth($item->incremental_date, $getSearchDete) >= 11 && ($this->getNoMonth($item->incremental_date, $getSearchDete) <=12) && ($getPresentAppointDateYear == $defaultYear -1) )
                    {
                        $incrementStatus[$item->ID] = "Due for increment";
                    }
                    
                }
            }
        }
        
        $data2['newDateDueForIncrement'] = $newDateDueForIncrement;
        $data['incrementStatus']        = $incrementStatus;
        
        try{
             $data['getCentralList'] = DB::table('tblper')->whereIn('ID', $letGetAll1stYearTableID)
                ->orderBy('tblper.grade', 'Desc')
                ->orderBy('tblper.step', 'Desc')
                ->paginate(50);
        }catch(\Throwable $e){}
       
        return view('hr.estab/incrementAlert', $data)->with($data2)->with($data3);
    }
    
    
    //Update User due for increment
    public function updateUserRecord($getPerID = null, $isUserDue = 1)
    {
        $sccess = 0;
        if($getPerID <> null && $isUserDue == 1)
        {
            try{
                $success = DB::table('tblper')->where('ID', $getPerID)->where('increment_alert', 0)->update([ 'increment_alert' => $isUserDue ]);
            }catch(\Throwable $e){}   
        }
        
        return $success;
    }
    
    
    public function getNoMonth($date1, $date2)
    {   
        $howeverManyMonths = 0;
         $date1 = $date1;
         $date2 = $date2;
         $d1=new DateTime($date2); 
         $d2=new DateTime($date1);                                  
         $Months = $d2->diff($d1); 
         $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
    
        return $howeverManyMonths;
    }

   

}
