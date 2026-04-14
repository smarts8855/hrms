<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Judicial Integrated Personnel and Payroll Information System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    @yield('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
  
  <style type="text/css">
    table th {
      width: auto !important;
      
    }
    
    

@media print
{
.noprint {display:none;}
}

@media screen
{

}

  </style>
    <script> var murl = "{{ url('/')}}"; </script>




</head>
<body class="hold-transition skin-green sidebar-mini">
@include('dueForArrears._incrementAlert')
<div class="wrapper">

  <header class="main-header hidden-print">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">IPPIS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>IPPIS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
        
          <!-- Notifications: Staff that are due for increment per division -->
        @if(count($increment) > 0)
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <span class="label label-warning">              
              <div style="font-size: 12px;">{{ count($increment)}}</div>              
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header alert alert-warning">{{ count($increment) }} Staff(s) Due For Increment </li>
              <li>                
                <ul class="menu">
                  @foreach($increment as $list)
                  <li>
                    <a href="{{ url('/record-variation/view/increment') }}">
                      <i class="fa fa-user text-aqua"></i>
                       @include('layouts._alertIncrement')
                      <!--$this-><td class="hidden-print"></td> was include _alertIncrement--> 
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="footer"><a href="{{ url('/record-variation/view/increment') }}" class="text-success">View all</a></li>
            </ul>
          </li>
          @endif

          <!-- Notifications: New Staff Added to the system from Open Registry -->
          @if(count($NewStaff) > 0)
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="label label-warning">              
              <div style="font-size: 12px;">{{ count($NewStaff)}}</div>              
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header alert alert-warning">You have {{ count($NewStaff) }} New Staff(s)</li>
              <li>                
                <ul class="menu">
                  @foreach($NewStaff as $transfer)
                  <li>
                      <a href="{{ url('/personal-emolument/new-staff') }}">
                        <i class="fa fa-user text-aqua"></i>
                        {{$transfer->surname. ', '.$transfer->first_name .' ('. $transfer->division .') - ' . $transfer->fileNo }}
                      </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="footer"><a href="{{ url('/personal-emolument/new-staff') }}" class="text-success">View all</a></li>
            </ul>
          </li>
          @endif
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- The other dropdown notification goes here -->


          <!-- End of other dropdown notification -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="user">
           @if(Entrust::hasRole('admin') or Entrust::hasRole('tax staff') or Entrust::hasRole('audit staff') or Entrust::hasRole('cpo staff') or Entrust::hasRole('super admin') or Entrust::hasRole('salary collator') or Entrust::hasRole('nhf staff') )
            <a href="{{ url('division/changeDivision')}}">
            @else  <a href="">
            @endif
              <i class="fa fa-location-arrow"></i>
              <span>
              @if(!Auth::guest())
              {{ session::get('division') }} <span class="hidden-xs">Division</span>
              @endif
              </span>
            </a>
          </li>  


           <li class="user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span>{{ Session::get('courtName')}}</span> 
            </a>
          </li>  


          <li class="dropdown user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="hidden-xs">
              @if(!Auth::guest())
                {{ Auth::user()->name }}
              @endif
              </span>
            </a>
           <ul class="dropdown-menu dropdown-user">
                 <li><a href="{{url('/user/editAccount')}}"><i class="fa fa-circle-o"></i> Edit Account</a></li>
                 <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li> 
                  </li>
                <!--//-->
                 <!--<li role="separator" class="divider"></li>
                 <li><a href="{{url('/user-role/create')}}"><i class="fa fa-circle-o"></i> Create Role</a></li>
                 <li><a href="{{url('/module/create')}}"><i class="fa fa-circle-o"></i> Create Module</a></li>
                 <li><a href="{{url('/function/create')}}"><i class="fa fa-circle-o"></i> Create Function</a></li>
                 <li><a href="{{url('/sub-function/create')}}"><i class="fa fa-circle-o"></i> Create Sub Function</a></li>
                 <li><a href="{{url('/sub-module/create')}}"><i class="fa fa-circle-o"></i> Create Sub Module</a></li>
                 <li><a href="{{url('/assign-module/create')}}"><i class="fa fa-circle-o"></i> Assign Module To Role</a></li>
                 <li><a href="{{url('/user-assign/create')}}"><i class="fa fa-circle-o"></i> Assign User To Role</a></li>-->
                <!--//--> 
            </ul>
          </li>          
        </ul>
      </div>
    </nav>
  </header>
 
 	 <aside class="main-sidebar hidden-print">
	    <section class="sidebar">
	      <div class="user-panel">
	        <div class="pull-left image">
	          <img src="{{asset('Images/coat.jpg')}}" class="img-circle" alt="User Image">
	        </div>
	        <div class="pull-left info">
	          <p>@include('MasterRolePermission.layout.getUserRoleName')</p>
	          <a href="#"><i class="fa fa-circle text-success"></i>online</a>          
	        </div>
	      </div>
	      <!-- Dynamic User Route for user -->
	      @include('MasterRolePermission.layout.userRouteLink')
	      <!-- Technical Admin Route only -->
	      @include('MasterRolePermission.layout.adminRouteLink')
	    </section>
	  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">

        @yield('content')
    
    </section>
  </div>

    <!-- /.content -->
  
  <!-- /.content-wrapper -->
  <footer class="main-footer hidden-print">
    <div class="pull-right hidden-xs">
      <b>Designed by</b> <a href="http://mbrcomputers.net">MBR Computers</a>
    </div>
    <strong>Copyright &copy; <?php echo date('Y') ?> .</strong> All rights
    reserved.
  </footer>
  </div>
<!-- ./wrapper -->
<script src="{{ asset('assets/js/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
@yield('scripts')
<!-- <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script> -->
</body>
</html>