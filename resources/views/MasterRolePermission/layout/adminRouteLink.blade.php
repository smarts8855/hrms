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
                     <i class="fa fa-gear text-aqua"></i> <span> ROLE MANAGEMENT</span>
                     <i class="fa fa-angle-left pull-right"></i>            
                  </a>
                <ul class="treeview-menu">
                    <!--Role-->
                    
                    {{-- <li><a href="{{url('/staff/designation/update')}}"><i class="fa fa-circle-o"></i> Staff Designation Update</a></li>
                     <li><a href="{{url('/company-profile')}}"><i class="fa fa-circle-o"></i> Company Profile</a></li> --}}
                    <li><a href="{{route('CreateUserRole')}}"><i class="fa fa-circle-o"></i> Create User Role</a></li>
                    <li><a href="{{route('AllRole')}}"><i class="fa fa-circle-o"></i> View All Role</a></li>
                    <li><a href="{{route('CreateModule')}}"><i class="fa fa-circle-o"></i> Create Module</a></li>
                    <li><a href="{{route('AllModule')}}"><i class="fa fa-circle-o"></i> View All Module</a></li>
                    <li><a href="{{route('createSubModule')}}"><i class="fa fa-circle-o"></i> Create Sub-Module</a></li>
                    <li><a href="{{route('AllSubModule')}}"><i class="fa fa-circle-o"></i> View All Sub-Module</a></li>
                    <li><a href="{{route('AssignModule')}}"><i class="fa fa-circle-o"></i> Assign Module To Role</a></li>
                    {{-- <li><a href="{{route('ViewAssignSubModule')}}"><i class="fa fa-circle-o"></i> View All Assigned Sub-Module</a></li> --}}

                    <li><a href="{{route('AssignUser')}}"><i class="fa fa-circle-o"></i> Assign User To Role</a></li>
                    <li><a href="{{route('role-widget.form')}}"><i class="fa fa-circle-o"></i> Assign Dashboard Widgets</a></li>
                    {{-- <li><a href="{{route('createTechnicalUser')}}"><i class="fa fa-circle-o"></i> Create Technical User</a></li>
                    <li><a href="{{url('/profile/upload')}}"><i class="fa fa-circle-o"></i>Upload Staff Info</a></li>
                    <li><a href="{{url('/login/details/select')}}"><i class="fa fa-circle-o"></i>Export Password</a></li>
                   
                    <li><a href="{{route('techDocument')}}"><i class="fa fa-circle-o"></i> Project Documentation </a></li> --}}
                    {{-- <li><a href="{{route('createCategory')}}"><i class="fa fa-circle-o"></i> Create Category </a></li> --}}
                    
                    <!--Function-->
                    
                </ul>
            </li> 
      <!--//-->
    </ul>
  @endif

      <!--

  
        -->