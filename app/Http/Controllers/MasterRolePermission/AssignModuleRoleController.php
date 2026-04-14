<?php

namespace App\Http\Controllers\MasterRolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssignModuleRoleController extends MasterRolePermissionController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        //$this->roleid = $request->session()->get('current_role');
    }

    public function create()
    {
        // dd(5555);
        //$data['submodules']    = $this->getAllSubModule(0);
        $data['roles']         = $this->getUserRole(100);

        // $data['assignroles']   = $this->getAllAssignModuleRole(10);
        $data['assignroles'] = DB::table('assign_module_role')
                ->orderBy('created_at', 'Asc')
                ->get();
        //$data['getrole']       = $this->getFindRole($this->roleid);
        $data['modules']       = $this->getAllModule(10);

        $data['submodules']    = DB::table('module')->where('status', 1)
            ->join('submodule', 'submodule.moduleID', '=', 'module.moduleID')
            ->selectRaw('submodule.moduleID as modID, module.moduleID as moduleID, module.link_type, submodule.submoduleID, module.modulename, submodule.submodulename')
            ->orderBy('moduleID')
            ->get();

        return view('MasterRolePermission/assignModule/assign', $data);
    }


    public function assignSubModule(Request $request)
    {
        $this->validate($request, [
            'role'          => 'required|numeric',
        ]);
        $roleID             = $request['role'];
        $subModuleID        = $request['arraysubModule'];
        $moduleID           = '';
        if ($subModuleID and ($subModuleID <> '')) {
            //insert assigned roles
            $this->getDeleteAssignModuleRole($roleID); //clear and assign afresh
            foreach ($subModuleID as $key => $subMID) {
                $subModuleIDNew          = $subMID; //$request['arraysubModule'][$key];
                $moduleID                = $this->getModuleIDFromSubModule($subModuleIDNew); //$request['arraymodule'][$key];
                $this->getAssignSubModuleRole($roleID, $subModuleIDNew, $moduleID);
            }
        } else {
            $this->getDeleteAssignModuleRole($roleID);
        }

        return redirect()->route('AssignModule')->with('message', 'Module Assigned Successfully');
    }


    public function displaySubModules()
    {
        $data['submodules'] = $this->getAllSubModule(20);
        return view('MasterRolePermission/subModule/viewsubmodules', $data);
    }


    public function sessionset(Request $request)
    {
        $roleid        = $request['role'];
        $getSession    = Session::put('current_role', $roleid);
        if ($getSession) {
            return response()->json("Successfully Set");
        } else {
            return response()->json("Not Set");
        }
    }
}
