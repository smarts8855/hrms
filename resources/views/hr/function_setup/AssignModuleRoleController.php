<?php

namespace App\Http\Controllers\role_setup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use session;

class AssignModuleRoleController extends Controller
{
     public function __construct(Request $request)
    {   
        $this->roleid = $request->session()->get('current_role');
    }

    public function create()
    {
        $data['submodules']    = DB::table('module')
        ->join('submodule','submodule.moduleID','=','module.moduleID')
        ->get();
        $data['roles']         = DB::table('user_role')->get();
        $data['assignroles']   = DB::table('assign_module_role')->get();
        $data['getrole']       = DB::table('user_role')->where('roleID','=',$this->roleid)->first();
        $data['modules']       = DB::table('module')->get();
        return view('role_setup/assignModule/assign',$data);
    }

    
    public function assignSubModule(Request $request)
    {
        $this->validate($request, [
            'role'                   => 'required|numeric',
            ]);

           $roleID                   = $request['role'];
           $ID                       = $request['subModule'];
           $date                     = date('Y-m-d H:i:s');
         
         //insert assigned roles
        foreach ($ID as $key => $ID) 
        {
            $IDs                     = $request['subModule'][$key];
            $moduleID                = $request['modu'][$key];

            $data = DB::table('assign_module_role')->where('roleID','=',$roleID)->where('submoduleID','=',$IDs)->count();
           if($data >= 1)  
           {
            DB::table('assign_module_role')->where('roleID', $roleID)->delete();
                
            DB::table('assign_module_role')->insert(array( 
            'roleID'                => $roleID,
            'submoduleID'           => $IDs,
            'moduleID'              => $moduleID,
            'created_at'            => $date,
             ));
            //}
           }
           else
           {
             DB::table('assign_module_role')->insert(array( 
            'roleID'                => $roleID,
            'submoduleID'           => $IDs,
            'moduleID'              => $moduleID,
            'created_at'            => $date,
             ));
           }
           
        }
        return redirect('assign-module/create')->with('message','Module Assigned Successfully');

    }

   public function sessionset(Request $request)
    {
         $roleid = $request['role'];
         $ses    = Session::put('current_role', $roleid);
         if($ses)
         {
            return response()->json("Successfully Set");
         }
         else
         {
         return response()->json("Not Set");
         }

    }


    
}
