
<ul class="sidebar-menu">
        <li class="header">USER'S LINKS</li>
        <!--link--> 
        <!--if(Session::get('firstLogin') == 1)-->
          @php
            if(Session::get('UserType') == 'Technical')
            {
              $userModule = DB::table('assign_user_role')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
                ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
                //->where('assign_user_role.userID', '=', Auth::user()->id)
                ->whereRaw('module.moduleID = assign_module_role.moduleID')
                //->whereRaw('user_role.roleID = assign_user_role.roleID')
                ->distinct()
                ->select('module.modulename', 'module.moduleID', 'user_role.rolename')
               
                ->orderBy('module.module_rank', 'ASC')
                 ->orderBy('module.modulename', 'ASC')
                ->get();
            }else{
              $userModule = DB::table('assign_user_role')
                ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
                ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
                ->where('assign_user_role.userID', '=', Auth::user()->id)
                ->whereRaw('module.moduleID = assign_module_role.moduleID')
                ->whereRaw('user_role.roleID = assign_user_role.roleID')
                ->distinct() 
                ->select('module.modulename', 'module.moduleID', 'user_role.rolename')
                ->orderBy('module.module_rank', 'ASC')
                ->orderBy('module.modulename', 'ASC')
                ->get();
            }
          @endphp
          @if($userModule)
            @foreach($userModule as $module)
              @php
                if(Session::get('UserType') == 'Technical')
                {
                  $userLinks = DB::table('submodule')
                    ->join('module', 'module.moduleID', '=', 'submodule.moduleID')
                    ->where('submodule.moduleID', '=', $module->moduleID)
                    ->distinct()
                    ->orderBy('module.module_rank', 'Asc')
                    ->orderBy('submodule.sub_module_rank', 'Asc')
                    ->orderBy('submodule.submodulename', 'Asc')
                    ->get();
                }else{
                    $userLinks = DB::table('assign_user_role')
                    ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
                    ->join('assign_module_role', 'assign_module_role.roleID', '=', 'assign_user_role.roleID')
                    ->join('submodule', 'submodule.submoduleID', '=', 'assign_module_role.submoduleID')
                    ->join('module', 'module.moduleID', '=', 'assign_module_role.moduleID')
                    ->where('assign_user_role.userID', '=', Auth::user()->id)
                    ->where('submodule.moduleID', '=', $module->moduleID)
                    ->distinct()
                    ->orderBy('module.module_rank', 'Asc')
                    ->orderBy('submodule.sub_module_rank', 'Asc')
                    ->orderBy('submodule.submodulename', 'Asc')
                    ->get();
                }
              @endphp
              <li class="treeview" id="admin" >
                    <a data-target="#">    
                       <i class="fa fa-users text-aqua"></i> <span>{{$module->modulename}}</span>
                       <i class="fa fa-angle-left pull-right"></i>            
                    </a>
                  <ul class="treeview-menu">
                    @foreach($userLinks as $route)
                      <li><a href="{!! url($route->route) !!}"><i class="fa fa-circle-o"></i>{{ $route->submodulename }}</a></li>
                    @endforeach
                  </ul>
              </li> 
            @endforeach
          @endif
        <!--endif-->
       
      <!--//-->
      </ul>

      <!--

  
        -->