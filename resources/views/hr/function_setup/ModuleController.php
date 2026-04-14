<?php

namespace App\Http\Controllers\role_setup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;

class ModuleController extends Controller
{
   public function create()
    {
        $data['roles']          = DB::table('user_role')->get();
        $data['modules']        = DB::table('module')->paginate(15);
        return view('role_setup/module/create',$data);
    }

    
    public function addModule(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string',
            ]);

        $modulename             = $request['name'];
        $date                   = date('Y-m-d');
        DB::table('module')->insert(array( 
        'modulename'            => $modulename,
        'created_at'            => $date,
        ));
        return redirect('module/create')->with('message','Module Created Successfully');
    }

   
    public function displayModules()
    {
      $data['modules'] = DB::table('module')->get();
      return view('role_setup/module/viewmodules', $data);
    }

   
    public function editModule($id)
    {
         $data['edit'] = DB::table('module')->where('moduleID','=', $id)->first();
         return view('role_setup/module/edit',$data);
    }

   
    public function updateModule(Request $request)
    {
        $modulename             = $request['name'];
        $moduleID               = $request['moduleID'];
        DB::table('module')->where('moduleID','=',$moduleID)->update(array( 
        'modulename'            => $modulename,

        ));
        return redirect('module/edit/'.$moduleID)->with('message','Module Successfully Updated');
    }

    
}
