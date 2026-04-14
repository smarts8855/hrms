<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use App\Http\Requests;
use Session;
use DB;
use Auth;

class SubModuleController extends MasterRolePermissionController
{


    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }



    public function create()
    {
        $ses = session('moduleId');
        //$data['submodules'] = $this->getAllSubModule(10,$ses);

        if ($ses == '') {

            $data['submodules'] = DB::table('submodule')
                ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                ->orderBy('submodule.sub_module_rank', 'ASC')
                ->paginate(10);
        } else {
            $data['submodules'] = DB::table('submodule')
                ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                ->where('submodule.moduleID', '=', $ses)
                ->orderBy('submodule.sub_module_rank', 'ASC')
                ->paginate(10);
        }



        $data['modules']    = $this->getAllModule();
        return view('MasterRolePermission.subModule.create', $data);
    }


    public function addSubModule(Request $request)
    {
        $this->validate($request, [
            'subModule'     => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000|unique:submodule,submodulename',
            'route'         => 'required|string',
        ]);
        $moduleID           = trim($request['module']);
        $subModuleName      = trim($request['subModule']);
        $route              = ltrim(rtrim($request['route'], "/"),  "/");
        $addSubModule = $this->getCreateSubModule($moduleID, $subModuleName, $route);
        if (!$addSubModule) {
            return redirect()->route('createSubModule')->with('error_message', 'Sorry, we cannot add new submodule. Try again');
        }
        return redirect()->route('createSubModule')->with('message', 'Sub Module Created Successfully');
    }


    public function displaySubModules()
    {
        $data['submodules'] = $this->getAllSubModule(15);
        return view('MasterRolePermission.subModule.viewsubmodules', $data);
    }


    public function editSubModule($id)
    {
        $data['edit']    = $this->getFindSubModule($id);
        if ($data['edit']) {
            $data['modules'] = $this->getAllModule(0);
            return view('MasterRolePermission.subModule.edit', $data);
        } else {
            return redirect()->route('AllSubModule')->with('error_message', 'Sorry, Record not found');
        }
    }


    public function sessionset(Request $request)
    {

        $id = $request['module'];

        $ses    = Session::put('moduleId', $id);
        if ($ses) {
            return response()->json("Successfully Set");
        } else {
            return response()->json("Not Set");
        }
    }


    public function edit(Request $request)
    {
        $id = $request['id'];
        $edit = DB::table('submodule')->where('submoduleID', '=', $id)->first();
        return response()->json($edit);
    }


    public function updateSubModule(Request $request)
    {
        $this->validate($request, [
            'subModules'     => 'required|regex:/^[a-zA-Z0-9,.!?\-)\( ]*$/|max:1000',
            'modules'        => 'required|numeric',
            'subModuleID'   => 'required|numeric',
        ]);

        $moduleID       = $request['modules'];
        $submodulename  = $request['subModules'];
        $submoduleID    = $request['subModuleID'];
        $rank           = $request['ranks'];
        $route          = ltrim(rtrim($request['routes'], "/"),  "/");
        $getUpdateSubModule = $this->getUpdateSubModule($submoduleID, $moduleID, $submodulename, $route, $rank);

        return redirect()->route('createSubModule')->with('message', 'SubModule Successfully Updated');
    }


    //delete subModule
    public function deleteSubModule(Request $request)
    {
        $this->validate($request, [
            'subModuleName'   => 'required|numeric',
        ]);
        $subModuleID        = $request['subModuleName'];
        $deleteSubModule    = $this->getDeleteSubModule($subModuleID);
        if ($deleteSubModule) {
            return redirect()->route('AllSubModule')->with('message', 'Sub-module Successfully deleted');
        }
        return redirect()->route('AllSubModule')->with('error_message', 'sorry, we connot delete this sub-module');
    }
} //class