@if((DB::table('users')
    ->where('id', Auth::user()->id)
    ->where('user_type', '!=', '')
    ->where('user_type', '!=', 'Non-Technical')
    ->where('user_type', 'Technical')
    ->count()) > 0)
    <ul class="sidebar-menu">
        <li class="header">Admin Links </li>
        <!--link--> 
            <li class="treeview" id="admin" >
                  <a data-target="#">    
                     <i class="fa fa-gear text-aqua"></i> <span>Technical Role</span>
                     <i class="fa fa-angle-left pull-right"></i>            
                  </a>
                <ul class="treeview-menu">
                    <!--Role-->
                    
                    <!--<li><a href="{{url('/staff/designation/update')}}"><i class="fa fa-circle-o"></i> Staff Designation Update</a></li>-->
                     <li><a href="{{url('/company-profile')}}"><i class="fa fa-circle-o"></i> Company Profile</a></li>
                    <li><a href="{{route('CreateUserRole')}}"><i class="fa fa-circle-o"></i> Create User Role</a></li>
                    <li><a href="{{route('CreateModule')}}"><i class="fa fa-circle-o"></i> Create Module</a></li>
                    <li><a href="{{route('createSubModule')}}"><i class="fa fa-circle-o"></i> Create Sub-Module</a></li>
                    <li><a href="{{route('AssignModule')}}"><i class="fa fa-circle-o"></i> Assign Module To Role</a></li>
                    <li><a href="{{route('AssignUser')}}"><i class="fa fa-circle-o"></i> Assign User To Role</a></li>
                    <!--<li><a href="{{url('/profile/upload')}}"><i class="fa fa-circle-o"></i>Upload Staff Info</a></li>-->
                    <!--<li><a href="{{url('/login/details/select')}}"><i class="fa fa-circle-o"></i>Export Password</a></li>-->
                    
                    <!--Function-->
                    
                </ul>
            </li> 
      <!--//-->
    </ul>
  @endif

      <!--

  
        -->