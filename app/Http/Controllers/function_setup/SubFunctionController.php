<?php

namespace App\Http\Controllers\function_setup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;

class SubFunctionController extends Controller
{


    public function __construct(Request $request)
    {
        //$currentPath = Route::getFacadeRoot()->current()->uri();
        //$this->checkUserRoute($currentPath);
        //$this->check = Session::get('access_allowed');
    } 



    public function create()
    {
         $ses = session('functionId');
        if($ses=='')
      {
        $data['subfunctions'] = DB::table('subfunction')
              ->join('function','function.functionID','=','subfunction.functionID')
              ->paginate(10);
      }
      else
      {
        $data['subfunctions'] = DB::table('subfunction')
              ->join('function','function.functionID','=','subfunction.functionID')
              ->where('subfunction.functionID','=',$ses)
              ->paginate(10);
       
      }
        $data['functions']    = DB::table('function')->get();
        return view('function_setup/subfunction/create',$data);
    }

    
    public function addSubFunction(Request $request)
    {
        $this->validate($request, [
            'function'             => 'required|string',
            'subFunction'          => 'required|string',
            'shortCode'            => 'required|string',
            ]);

        $function            = $request['function'];
        $subfunctionname     = $request['subFunction'];
        $subfunctionrank     = $request['rank'];
        $shortcode           = $request['shortCode'];

        //$route = ltrim(rtrim($request['route'], "/"),  "/");

        $code = DB::table('subfunction')->where('short_code','=',$shortcode)->count();
        if($code == 1)
        {
            return redirect('sub-function/create')->with('message','Short Code already exist. Please, try another one');
        }
        else
        {

        $date          = date('Y-m-d H:i:s');
        DB::table('subfunction')->insert(array( 
                'functionID'              => $function,
                'sub_function_name'       => $subfunctionname,
                'sub_function_rank'       => $subfunctionrank,
                'short_code'              => $shortcode,
                'created_at'              => $date,
                ));
          return redirect('sub-function/create')->with('message','Sub function Created Successfully');
      }
    }

   
    public function displaySubfunctions()
    {
      $data['subfunctions'] = DB::table('subfunction')
      ->join('function','function.functionID','=','subfunction.functionID')
      ->get();
      return view('role_setup/subfunction/viewsubfunctions', $data);
    }

   
    public function editSubFunction($id)
    {
         $data['edit']    = DB::table('subfunction')->where('subfunctionID','=', $id)->first();
         $data['functions'] = DB::table('function')->get();
         return view('function_setup/subfunction/edit',$data);
    }

   
    public function updateSubFunction(Request $request)
    {
       $this->validate($request, [
            'function'             => 'required|string',
            'subFunction'          => 'required|string',
            'shortCode'            => 'required|string',
            ]);
        $function          = $request['function']; 
        $subfunctionname   = $request['subFunction'];
        $subfunctionID     = $request['subFunctionID'];
        $rank              = $request['rank'];
        $shortcode         = $request['shortCode'];

         $code = DB::table('subfunction')->where('short_code','=',$shortcode)->count();
        if($code == 1)
        {
            return redirect('sub-function/create')->with('message','Short Code already exist. Please, try another one');
        }
        else
        {
        DB::table('subfunction')->where('subfunctionID','=',$subfunctionID)->update(array( 
                'functionID'                => $function,
                'sub_function_name'         => $subfunctionname,
                'sub_function_rank'         => $rank,
                'short_code'                => $shortcode,
                ));
        return redirect('sub-function/edit/'.$subfunctionID)->with('message','Sub function Successfully Updated');
        }
    }


    public function sessionset(Request $request)
    {
        
         $id = $request['function'];

         $ses    = Session::put('functionId', $id);
         if($ses)
         {
            return response()->json("Successfully Set");
         }
         else
         {
         return response()->json("Not Set");
         }

    }

    public function edit(Request $request)
    {
        $id = $request['id'];
         $edit = DB::table('subfunction')->where('subfunctionID','=', $id)->first();
         return response()->json($edit);
    }
   

    public function destroy($id)
    {
        //
    }
}
