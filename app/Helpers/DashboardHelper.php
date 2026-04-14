<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardHelper
{
    /**
     * Get the authenticated user's role ID
     */
    public static function getUserRoleID()
    {
        $userID = Auth::id();
        
        if (!$userID) {
            return null;
        }
        
        // Get role from assign_user_role table
        $assignedRole = DB::table('assign_user_role')
            ->where('userID', $userID)
            ->select('roleID')
            ->first();
            
        return $assignedRole ? $assignedRole->roleID : null;
    }
    
    /**
     * Get the authenticated user's role name
     */
    public static function getUserRoleName()
    {
        $roleID = self::getUserRoleID();
        
        if (!$roleID) {
            return null;
        }
        
        $role = DB::table('user_role')
            ->where('roleID', $roleID)
            ->select('rolename')
            ->first();
            
        return $role ? $role->rolename : null;
    }
    
    /**
     * Get all widgets assigned to the authenticated user's role
     */
    public static function getUserWidgets()
    {
        $roleID = self::getUserRoleID();
        
        if (!$roleID) {
            return [];
        }
        
        return DB::table('role_widget')
            ->join('widget', 'role_widget.widget_id', '=', 'widget.id')
            ->where('role_widget.role_id', $roleID)
            ->pluck('widget.name')
            ->toArray();
    }
    
    /**
     * Check if the authenticated user has access to a specific widget
     */
    public static function hasWidget($widgetName)
    {
        $widgets = self::getUserWidgets();
        return in_array($widgetName, $widgets);
    }
    
    /**
     * Check if the authenticated user has any widgets assigned
     */
    public static function hasAnyWidget()
    {
        $widgets = self::getUserWidgets();
        return !empty($widgets);
    }
    
    /**
     * Get user's assigned modules (from your existing system)
     */
    public static function getUserModules()
    {
        $userID = Auth::id();
        
        if (!$userID) {
            return [];
        }
        
        // This is from your existing session system
        if (Session::has('userModule')) {
            return Session::get('userModule');
        }
        
        // If not in session, fetch from database
        $modules = DB::table('assign_user_role')
            ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
            ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
            ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
            ->where('assign_user_role.userID', '=', $userID)
            ->distinct()
            ->select('module.modulename', 'module.moduleID', 'user_role.rolename')
            ->get();
            
        return $modules;
    }
}