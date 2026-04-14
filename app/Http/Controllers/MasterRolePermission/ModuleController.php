<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ModuleController extends MasterRolePermissionController
{

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }


   public function create()
    {
        $data['roles']          = $this->getUserRole(0);
        $data['modules']        = $this->getAllModule(50); 
        return view('MasterRolePermission/module/create',$data);
    }

    
    public function addModule(Request $request)
    {
        $this->validate($request, [
            'moduleName' => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000|unique:module,modulename',
        ]);
        $moduleName             = trim($request['moduleName']);
        $rank             = trim($request['rank']);
        $link_type = trim($request['link_type']);
        $addModule = $this->getCreateModule($moduleName,$rank, $link_type);
        if(!$addModule)
        {
            return redirect()->route('CreateModule')->with('error_message','Sorry, error occur during adding new module. Try again');  
        }
        return redirect()->route('CreateModule')->with('message','Module Created Successfully');
       
    }

   
    public function displayModules()
    {
      $data['modules'] = $this->getAllModule(0);
      return view('MasterRolePermission/module/viewmodules', $data);
    }

   
    public function editModule($id)
    {
        $data['edit'] = $this->getFindModule(trim($id));
        if($data['edit'])
        {
            return view('MasterRolePermission/module/edit', $data);
        }else{
            return redirect('module/viewmodules');
        }   
    }

    public function edit(Request $request)
    {
        $id = $request['id'];
         $edit = DB::table('module')->where('moduleID','=', $id)->first();
         return response()->json($edit);
    }

    public function updateModule(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000',
            'moduleID'          => 'required|numeric',
        ]);
        $modulename             = trim($request['name']);
        $moduleID               = trim($request['moduleID']);
        $rank                   = trim($request['rank']);
        $link_type = trim($request['link_type']);
        $getUpdateModule        = $this->getUpdateModule($moduleID, $modulename, $rank, $link_type);
        if($getUpdateModule)
        {
            return redirect()->route('CreateModule')->with('message','Module Successfully Updated');
        }else{
             return redirect()->route('CreateModule')->with('error_message','Sorry, we cannot update this module');
        }
        
    }

    
}
