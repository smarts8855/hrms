<?php

namespace App\Http\Controllers\role_setup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;

class SubModuleController extends Controller
{


    public function __construct(Request $request)
    {
        //$currentPath = Route::getFacadeRoot()->current()->uri();
        //$this->checkUserRoute($currentPath);
        //$this->check = Session::get('access_allowed');
    } 



    public function create()
    {
        $data['submodules'] = DB::table('submodule')
              ->join('module','module.moduleID','=','submodule.moduleID')
              ->paginate(10);
        $data['modules']    = DB::table('module')->get();
        return view('role_setup/submodule/create',$data);
    }

    
    public function addSubModule(Request $request)
    {
        $this->validate($request, [
            'module'             => 'required|string',
            'route'              => 'required|string',
            ]);

        $module = $request['module'];
        $submodulename = $request['subModule'];
        $route = ltrim(rtrim($request['route'], "/"),  "/");
        $date          = date('Y-m-d H:i:s');
        DB::table('submodule')->insert(array( 
                'moduleID'              => $module,
                'submodulename'         => $submodulename,
                'route'                 => $route,
                'created_at'            => $date,
                ));
          return redirect('sub-module/create')->with('message','Sub Module Created Successfully');
    }

   
    public function displaySubModules()
    {
      $data['submodules'] = DB::table('submodule')
      ->join('module','module.moduleID','=','submodule.moduleID')
      ->get();
      return view('role_setup/submodule/viewsubmodules', $data);
    }

   
    public function editSubModule($id)
    {
         $data['edit']    = DB::table('submodule')->where('submoduleID','=', $id)->first();
         $data['modules'] = DB::table('module')->get();
         return view('role_setup/submodule/edit',$data);
    }

   
    public function updateSubModule(Request $request)
    {
        $module = $request['module']; 
        $submodulename = $request['subModule'];
        $submoduleID = $request['subModuleID'];
        $route = ltrim(rtrim($request['route'], "/"),  "/");
        DB::table('submodule')->where('submoduleID','=',$submoduleID)->update(array( 
                'moduleID'              => $module,
                'submodulename'         => $submodulename,
                'route'                => $route,
                ));
        return redirect('sub-module/edit/'.$submoduleID)->with('message','Sub Module Successfully Updated');
    }

    public function destroy($id)
    {
        //
    }
}
