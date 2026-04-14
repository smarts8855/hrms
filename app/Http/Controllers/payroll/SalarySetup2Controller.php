<?php

namespace App\Http\Controllers\payroll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use DB;

class SalarySetupController extends Controller
{
   
    public function index()
    {
        //
    }

   
    public function create(Request $request)
    {
        $data['count'] = '';
        $data['verify'] = '';
        $data['courts'] = DB::table('tbl_court')->get();
         //$data['scale'] ='';
 $data['scale'] = DB::table('basicsalary')
             ->where('courtID','=',session('court'))
             ->where('grade','=',session('grade'))
             ->where('step','=',session('step'))
             ->where('employee_type','=',session('employeeType'))
             ->first(); 
        return view('payroll/salarySetup/createSalary',$data);
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
