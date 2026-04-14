<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu"> 
            
                <li class="menu-title">
                    Hey, {{ (Auth::check() ? Auth::user()->name : null) }} <br /> <b>Unit: {{ Session::get('roleName') }}</b> <hr />
                </li>
                
                <li class="menu-title">Menu</li>
                <!--Home-->
                <li>
                    <a href="{{ route('home') }}" class="waves-effect text-uppercase"> <i class="fa fa-home fa-2x"></i> Dashboard</a>
                </li> 
                
                @if(Auth::check())
                    @if(Session::get('userMenuModule'))
                        @foreach(Session::get('userMenuModule') as $key=>$module)
                            <li>
                                <a href="javascript:;" class="has-arrow waves-effect">
                                    <i class="{{ (isset($module) && $module ? $module->module_icon : '') }}"></i>
                                    <span class="text-uppercase">{{ (isset($module) && $module ? $module->module_name : '') }}</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    @foreach(Session::get('userMenu')[$key.$module->moduleID] as $subModule)
                                        <li><a href="{!! ($subModule->submodule_url =='#' or $subModule->submodule_url =='') ? 'javascript:;' : url($subModule->submodule_url) !!}"> <i class="{{ (isset($subModule) && $subModule ? $subModule->submodule_icon : '')}}"></i>  {{ (isset($subModule) && $subModule ? $subModule->submodule_name : '') }} </a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach 
                    @endif
                    @if(Auth::user()->user_type == 1)
                        <li>
                            <a href="javascript:;" class="has-arrow waves-effect">
                                <i class="ri-pages-line"></i>
                                <span class="text-uppercase">Admin Setup</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('createRole') }}"><i class="fa fa-gear"></i> Create Role</a></li>
                                <li><a href="{{ route('createModule') }}"><i class="fa fa-gear"></i> Create Module</a></li>
                                <li><a href="{{ route('createSubModule') }}"><i class="fa fa-gear"></i> Create Sub-Module</a></li>
                                <li><a href="{{ route('createSubmoduleAssignment') }}"><i class="fa fa-gear"></i> Assign Role To Permission</a></li>
                                <li><a href="{{ route('create-user-role') }}"><i class="fa fa-gear"></i> Create New User</a></li>
                            </ul>
                        </li>
                    @endif
                @endif
                
                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
