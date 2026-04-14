<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterRolePermissionController extends Controller
{

    //=====ROLE AND PERMISSION==//

    //GET ROLE & PERMISSION AUDIT LOG
    public function getRolePermissionAuditLog($operation)
    {
        $ipAddress      = Request::ip();
        $url            = Request::fullUrl();
        $computerName   = gethostname();
        $hostName       = $_SERVER['HTTP_HOST'];
        $operation      = $operation;
        DB::table('role_permission_audit_log')
            ->insert(array(
                'userID'            => $this->getUserID(),
                'operation'         => $hostName,
                'ipaddress'         => $operation,
                'url'               => $ipAddress,
                'computername'      => $url,
                'hostname'          => $computerName,
                'created_at'        => $this->getDate(),
            ));
        return;
    }


    //get current user that Logged In
    public function getUserID()
    {
        $userID  = Auth::user()->id;
        return $userID;
    }


    // Get All User 
    public function getAllUser($paginate)
    {
        if (($paginate <> '' && $paginate > 0)) {
            $getModule = DB::table('users')
                // ->where('user_type', '=', 'Non-Technical')
                ->where('user_type', '<>', '')
                ->where('user_type', '<>', 'TECHNICAL')
                ->orderBy('name', 'DESC')
                //->orderBy('id', 'DESC')
                ->paginate($paginate);
        } else {
            $getModule = DB::table('users')
                //->where('user_type', '=', 'Non-Technical')
                ->where('user_type', '<>', '')
                ->where('user_type', '<>', 'TECHNICAL')
                ->orderBy('name', 'DESC')
                //->orderBy('id', 'DESC')
                ->get();
        }
        return $getModule;
    }



    public function getCreateTechnicalUser($fullName, $userName, $password)
    {

        $addTechnicalUser = DB::table('users')
            ->insert(array(
                'user_type'        => 'Technical',
                'name'             => $fullName,
                'username'         => $userName,
                'password'         => bcrypt($password),
                'created_at'       => date('Y-m-d'),
                'updated_at'       => date('Y-m-d'),
            ));
        $operation = 'New Technical user was created';
        $this->getRolePermissionAuditLog($operation);
        return $addTechnicalUser;
    }

    public function createStaffUser($fullName, $userName, $password)
    {

        $addTechnicalUser = DB::table('users')
            ->insertGetId(array(
                'user_type'        => 'NONTECHNICAL',
                'name'             => $fullName,
                'username'         => $userName,
                'password'         => bcrypt($password),
                'created_at'       => date('Y-m-d'),
                'updated_at'       => date('Y-m-d'),
            ));
        DB::table('users')
            ->insertGetId(array(
                'user_type'        => 'NONTECHNICAL',
                'name'             => $fullName,
                'username'         => $userName,
                'password'         => bcrypt($password),
                'created_at'       => date('Y-m-d'),
                'updated_at'       => date('Y-m-d'),
            ));
        $operation = "New staff login created $fullName user name:$userName";
        $this->getRolePermissionAuditLog($operation);
        return $addTechnicalUser;
    }


    //get current user that Logged In
    public function getDate()
    {
        $date = date('Y-m-d');
        return $date;
    }


    //==> MODULE

    // create new module
    public function getCreateModule($modulename, $rank, $link_type)
    {
        $addModule = DB::table('module')
            ->insert(array(
                'modulename'         => $modulename,
                'module_rank'         => $rank,
                'created_at'         => $this->getDate(),
                'link_type'         => $link_type,
            ));
        $operation = 'New Module was created with Module name: ' . $modulename;
        $this->getRolePermissionAuditLog($operation);
        return $addModule;
    }

    // Show all module 
    public function getAllModuleOLD($paginate)
    {
        if (($paginate <> '' or $paginate > 0)) {
            $getModule = DB::table('module')
                ->orderBy('module_rank', 'ASC')
                ->paginate($paginate);
        } else {
            $getModule = DB::table('module')
                ->orderBy('module_rank', 'ASC')
                ->get();
        }
        return $getModule;
    }


    public function getAllModule($paginate = null)
    {
        try {
            // Check if $paginate is provided and is a valid positive number
            // if (is_numeric($paginate) && $paginate > 0) {
            if (($paginate <> '') && $paginate > 0) {
                // Paginate the results if $paginate is a positive number
                $getModule = DB::table('module')
                    ->orderBy('module_rank', 'ASC')
                    ->paginate($paginate);
            } else {
                // dd("here 2");
                // Return all results if $paginate is not provided or is invalid
                $getModule = DB::table('module')
                    ->orderBy('module_rank', 'ASC')
                    ->get();
            }

            return $getModule;
        } catch (\Exception $e) {
            // Log the exception and return an error message
            \Log::error('Error fetching modules: ' . $e->getMessage());

            // You can also return a custom error response if needed
            return response()->json(['error' => 'Unable to fetch modules at this time.'], 500);
        }
    }



    // Find Module to Edit
    public function getFindModule($moduleID)
    {
        if (DB::table('module')->where('moduleID', '=', $moduleID)->first()) {
            $getFindModule = DB::table('module')->where('moduleID', '=', $moduleID)->first();
            return $getFindModule;
        } else {
            return $getFindModule = '';
        }
    }

    // Update/Edit Module
    public function getUpdateModule($moduleID, $modulename, $rank, $link_type)
    {
        $getUpdateModule = DB::table('module')
            ->where('moduleID', '=', $moduleID)
            ->update(array(
                'modulename'    => $modulename,
                'module_rank'    => $rank,
                'link_type'    => $link_type,
            ));
        $operation = 'Module was updated with module ID: ' . $moduleID;
        $this->getRolePermissionAuditLog($operation);
        return $getUpdateModule;
    }


    //==> SUB-MODULE

    // create new Submodule
    public function getCreateSubModule($moduleID, $subModuleName, $route)
    {
        $addSubModule = DB::table('submodule')
            ->insert(array(
                'moduleID'           => $moduleID,
                'submodulename'      => $subModuleName,
                'route'              => $route,
                'created_at'         => $this->getDate(),
            ));
        $operation = 'New Sub-Module was created with Submodule: ' . $subModuleName;
        $this->getRolePermissionAuditLog($operation);
        return $addSubModule;
    }

    // Show all submodule 
    public function getAllSubModuleOLD($paginate = null)
    {
        if (($paginate <> '' or $paginate > 0)) {
            $getModule = DB::table('submodule')
                ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                ->orderBy('submodule.sub_module_rank', 'ASC')
                ->paginate($paginate);
        } else {
            $getModule = DB::table('submodule')
                ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                ->orderBy('submodule.sub_module_rank', 'ASC')
                ->get();
        }
        return $getModule;
    }
    public function getAllSubModule($paginate = null)
    {
        if (!is_null($paginate) && $paginate > 0) {
            $getModule = DB::table('submodule')
                ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                ->orderBy('submodule.sub_module_rank', 'ASC')
                ->paginate($paginate);
        } else {
            $getModule = DB::table('submodule')
                ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                ->orderBy('submodule.sub_module_rank', 'ASC')
                ->get();
        }
        return $getModule;
    }


    // Find subModule to Edit
    public function getFindSubModule($submoduleID)
    {
        $getFindSubModule = DB::table('submodule')->where('submoduleID', '=', $submoduleID)->first();
        return $getFindSubModule;
    }

    // Update/Edit SubModule
    public function getUpdateSubModule($submoduleID, $moduleID, $submodulename, $route)
    {
        $getUpdateSubModule = DB::table('submodule')
            ->where('submoduleID', $submoduleID)
            ->update(array(
                'moduleID'      => $moduleID,
                'submodulename' => $submodulename,
                'route'         => $route,
            ));
        $operation = 'Sub-module was updated with ID: ' . $submoduleID;
        $this->getRolePermissionAuditLog($operation);
        return $getUpdateSubModule;
    }


    //Delete Submodule
    public function getDeleteSubModule($submoduleID)
    {
        $deleteSubModule = '';
        if (DB::table('submodule')->where('submoduleID', '=', $submoduleID)->first()) {
            $deleteSubModule = DB::table('submodule')->where('submoduleID', '=', $submoduleID)->delete();
            DB::table('assign_module_role')->where('submoduleID', '=', $submoduleID)->delete();
        } else {
            $deleteSubModule = '';
        }
        return $deleteSubModule;
    }



    //==> USER ROLE

    // Get User Role
    public function getUserRole($paginate)
    {
        if (($paginate <> '') && ($paginate > 0)) {
            $getUserRole = DB::table('user_role')
                //->where('active', 1) // Pls be carrful to use this
                ->orderBy('rolename', 'Asc')
                ->paginate($paginate);
        } else {
            $getUserRole = DB::table('user_role')
                //->where('active', 1) // Pls be carrful to use this
                ->orderBy('rolename', 'Asc')
                ->get();
        }
        return $getUserRole;
    }

    public function getUserRoleOLD($paginate = null)
    {
        if (!is_null($paginate) && $paginate > 0) {
            $getUserRole = DB::table('user_role')
                ->orderBy('rolename', 'Asc')
                ->paginate($paginate);
        } else {
            $getUserRole = DB::table('user_role')
                ->orderBy('rolename', 'Asc')
                ->get();
        }

        return $getUserRole;
    }

    // create new Role
    public function getCreateRole($rolename)
    {
        $addRole = DB::table('user_role')
            ->insert(array(
                'rolename'         => $rolename,
                'created_at'       => $this->getDate(),
            ));
        $operation = 'New Role was created with Role name: ' . $rolename;
        $this->getRolePermissionAuditLog($operation);
        return $addRole;
    }

    // find Role to Edit
    public function getFindRole($roleID)
    {
        if (DB::table('user_role')->where('roleID', $roleID)->first()) {
            $getFindRole = DB::table('user_role')->where('roleID', $roleID)->first();
            return $getFindRole;
        } else {
            return $getFindRole = '';
        }
    }

    // Update/Edit Role
    public function getUpdateRole($roleID, $rolename)
    {
        $getUpdateRole = DB::table('user_role')
            ->where('roleID', $roleID)
            ->update(array(
                'rolename'   => $rolename,
            ));
        $operation = 'Role was updated with RoleID: ' . $roleID;
        $this->getRolePermissionAuditLog($operation);
        return $getUpdateRole;
    }



    //==> ASSIGN MODULE ROLE

    // Get All Assign Module Role
    public function getAllAssignModuleRole($paginate)
    {
        if (($paginate <> '') or ($paginate > 0)) {
            $assignModuleRole = DB::table('assign_module_role')
                ->orderBy('created_at', 'Asc')
                ->paginate($paginate);
        } else {
            $assignModuleRole = DB::table('assign_module_role')
                ->orderBy('created_at', 'Asc')
                ->get();
        }
        return $assignModuleRole;
    }


    // get Total AssignModuleRole
    public function getTotalAssignModuleRole($roleID, $subModuleIDs)
    {
        $totalAssignModuleRole = DB::table('assign_module_role')
            ->where('roleID', $roleID)
            ->where('submoduleID', $subModuleIDs)
            ->count();
        return $totalAssignModuleRole;
    }

    // get Delete AssignModuleRole
    public function getDeleteAssignModuleRole($roleID)
    {
        if ($roleID) {
            $getDelete = DB::table('assign_module_role')->where('roleID', $roleID)->delete();
            $operation = 'A role assigned to module was deleted with RoleID: ' . $roleID;
            $this->getRolePermissionAuditLog($operation);
        } else {
            $getDelete = '';
        }
        return $getDelete;
    }


    // get ModuleID from SubModule
    public function getModuleIDFromSubModule($subModuleID)
    {
        if (($subModuleID <> '') and (DB::table('submodule')->where('subModuleID', $subModuleID)->first())) {
            $getModuleID = DB::table('submodule')
                ->where('subModuleID', $subModuleID)
                ->select('moduleID')
                ->first();
            return $getModuleID->moduleID;
        } else {
            return $getModuleID = 0;
        }
    }


    // Assign subModule Role
    public function getAssignSubModuleRole($roleID, $subModuleIDs, $moduleID)
    {

        $getAssignSubModuleRole = DB::table('assign_module_role')
            ->insert(array(
                'roleID'                => $roleID,
                'submoduleID'           => $subModuleIDs,
                'moduleID'              => $moduleID,
                'created_at'            => $this->getDate(),
            ));

        $operation = 'Submodule was assigned to module RoleID, SubModuleIDs, ModuleID: ' . $roleID . ', ' . $subModuleIDs . ', ' . $moduleID . ' respectively';
        $this->getRolePermissionAuditLog($operation);
        return $getAssignSubModuleRole;
    }


    //==> ASSIGN USER ROLE

    //get All assign user role
    public function getAllAssignUserRole($paginate)
    {
        if (($paginate <> '' && $paginate > 0)) {
            $allAssignUserRole = DB::table('assign_user_role')
                ->join('users', 'users.id', '=', 'assign_user_role.userID')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->paginate($paginate);
        } else {
            $allAssignUserRole = DB::table('assign_user_role')
                ->join('users', 'users.id', '=', 'assign_user_role.userID')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->get();
        }
        return $allAssignUserRole;
    }


    //find assign user role
    public function getFindAllAssignUserRole($userID, $paginate)
    {
        if (($paginate <> '' or $paginate > 0)) {
            $findAllAssignUserRole = DB::table('assign_user_role')
                ->join('users', 'users.id', '=', 'assign_user_role.userID')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->where('assign_user_role.userID', '=', $userID)
                ->paginate($paginate);
        } else {
            $findAllAssignUserRole = DB::table('assign_user_role')
                ->join('users', 'users.id', '=', 'assign_user_role.userID')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->where('assign_user_role.userID', '=', $userID)
                ->get();
        }
        return $findAllAssignUserRole;
    }


    // find user in assign user role
    public function getFindAssignUserRole($userID)
    {
        $findAssignUserRole = DB::table('assign_user_role')->where('userID', $userID)->first();
        return $findAssignUserRole;
    }


    // find assign role to edit
    public function getFindAssignRole($assignuserID)
    {
        $findAssignRole = DB::table('assign_user_role')->where('assignuserID', $assignuserID)->first();
        return $findAssignRole;
    }


    //Get : Assign user to Role
    public function getAssignUserRole($userID, $roleID)
    {

        if ($this->getFindAssignUserRole($userID)) {
            $userAssigned = DB::table('assign_user_role')
                ->where('userID', '=', $userID)
                ->update(array(
                    'userID'                => $userID,
                    'roleID'                => $roleID,
                    'created_at'            => $this->getDate(),
                ));
        } else {
            $userAssigned = DB::table('assign_user_role')->insert(array(
                'userID'                => $userID,
                'roleID'                => $roleID,
                'created_at'            => $this->getDate(),
            ));
        }
        Session::forget('userModule');
        $userModule = DB::table('assign_user_role')
            ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
            ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
            ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
            ->where('assign_user_role.userID', '=', $this->getUserID())
            ->whereRaw('module.moduleID = assign_module_role.moduleID')
            ->whereRaw('user_role.roleID = assign_user_role.roleID')
            ->distinct()
            ->select('module.modulename', 'module.moduleID', 'user_role.rolename')
            ->get();
        Session::put('userModule', $userModule);
        $operation = 'User was assigned to role with UserID, RoleID: ' . $userID . ', ' . $roleID . ' respectively';
        $this->getRolePermissionAuditLog($operation);
        return $userAssigned;
    }



    //==> ROLE FUNCTION

    //get All Function
    public function getAllFunction($paginate)
    {
        if (($paginate <> '' or $paginate > 0)) {
            $allFunction = DB::table('role_function')->paginate($paginate);
        } else {
            $allFunction = DB::table('role_function')->get();
        }
        return $allFunction;
    }


    // Add New Function
    public function getAddFunction($functionName, $functionDescription)
    {
        $getRoleFunctiom = DB::table('role_function')->insert(array(
            'function_name'         => $functionName,
            'function_description'  => $functionDescription,
            'create_at'             => $this->getDate(),
        ));
        $operation = 'New Function was added with Function Name: ' . $functionName;
        $this->getRolePermissionAuditLog($operation);
        return $getRoleFunctiom;
    }


    public function getInitialiseUserRoleRoute($userID)
    {
        Session::forget('userLinks');
        Session::forget('roleName');
        Session::forget('userModule');
        //DYNAMIC ROLE
        $getRoleName = DB::table('assign_user_role')
            ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
            ->where('assign_user_role.userID', '=', $this->getUserID())
            ->whereRaw('user_role.roleID = assign_user_role.roleID')
            ->select('user_role.roleID', 'user_role.rolename')
            ->first();
        if ($getRoleName) {
            Session::put('roleName', $getRoleName->rolename);
        } else {
            Session::put('roleName', '');
        }
        //
        $userLinks  = array();
        $userModule = DB::table('assign_user_role')
            ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
            ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
            ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
            ->where('assign_user_role.userID', '=', $this->getUserID())
            ->whereRaw('module.moduleID = assign_module_role.moduleID')
            ->whereRaw('user_role.roleID = assign_user_role.roleID')
            ->distinct()
            ->select('module.modulename', 'module.moduleID', 'user_role.rolename')
            ->get();
        Session::put('userModule', $userModule);
        foreach ($userModule as $module) {
            $userLinks = DB::table('assign_user_role')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
                ->join('submodule', 'submodule.submoduleID', '=', 'assign_module_role.submoduleID')
                ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
                ->where('assign_user_role.userID', '=', $this->getUserID())
                ->where('submodule.moduleID', '=', $module->moduleID)
                ->distinct()
                ->orderBy('submodule.submoduleID', 'Asc')
                ->get();
            //
        }
        Session::put('userLinks', $userLinks);
        //
    }


    //=====END ROLE AND PERMISSION===//


} //end class