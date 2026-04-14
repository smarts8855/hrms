<!DOCTYPE html>
<html>

<head>
    <?php $url = $_SERVER['HTTP_HOST']; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Human Resource Management System</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    {{-- Select2 link --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Datepickr .js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @yield('extraLinks')

    <style type="text/css">

        table th {
            width: auto !important;

        }

        @media print {
            .noprint {
                display: none;
            }
        }

        @media screen {}

    </style>
    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>

    <script>
        var murl = "{{ url('/') }}";
    </script>




</head>

<?php
    use App\Http\Controllers\Controller;
?>

<body class="hold-transition skin-green sidebar-mini" onload="lookup();">
    @include('dueForArrears._incrementAlert')
    <div class="wrapper">

        <header class="main-header hidden-print">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b></b></span>
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


                        <!-- Notifications: New Staff Added to the system from Open Registry -->

                        <!-- Tasks: style can be found in dropdown.less -->
                        <!-- The other dropdown notification goes here -->


                        <!-- End of other dropdown notification -->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="user">

                            <span>
                                @if (!Auth::guest())
                                    {{ session::get('division') }}
                                @endif
                            </span>
                            </a>
                        </li>

                        <li class="dropdown" id="markasread" >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="dropdown"
                                aria-expanded="false">
                                <strong>Notifications </strong>
                                <span class="badge" style="background-color:rgb(225, 38, 38)">{{ count(auth()->user()->unreadNotifications) }}</span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>

                                    @forelse (auth()->user()->unreadNotifications->take(5) as $notification)

                                        @include(
                                            'layouts.partials.notification.' .
                                                Str::snake(class_basename($notification->type))
                                        )
                                        @empty
                                            <a href="#">No unread notification</a>
                                    @endforelse

                                    <a href="{{route('notifications')}}" style="color:blue">view all notifications</a>
                                </li>

                            </ul>
                        </li>


                        <li class="user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span>{{ Session::get('courtName') }}</span>
                            </a>
                        </li>

                        {{-- <li class="user">
                            @php $user = Auth::user()->id; @endphp
                            <a href="{{ url('/check-nominated-training/' . $user) }}">
                                <span class="badge badge-secondary">Training:
                                    {{ Controller::getNominated() ?? 0 }}
                                </span>
                            </a>
                        </li> --}}

                        <li class="dropdown user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <span class="hidden-xs">
                                    @if (!Auth::guest())
                                        {{ Auth::user()->name }}
                                    @endif
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="{{ url('/user/editAccount') }}"><i class="fa fa-circle-o"></i> Edit
                                        Account</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                                </li>
                        </li>
                        <!--//-->
                        <!--<li role="separator" class="divider"></li>
                 <li><a href="{{ url('/user-role/create') }}"><i class="fa fa-circle-o"></i> Create Role</a></li>
                 <li><a href="{{ url('/module/create') }}"><i class="fa fa-circle-o"></i> Create Module</a></li>
                 <li><a href="{{ url('/function/create') }}"><i class="fa fa-circle-o"></i> Create Function</a></li>
                 <li><a href="{{ url('/sub-function/create') }}"><i class="fa fa-circle-o"></i> Create Sub Function</a></li>
                 <li><a href="{{ url('/sub-module/create') }}"><i class="fa fa-circle-o"></i> Create Sub Module</a></li>
                 <li><a href="{{ url('/assign-module/create') }}"><i class="fa fa-circle-o"></i> Assign Module To Role</a></li>
                 <li><a href="{{ url('/user-assign/create') }}"><i class="fa fa-circle-o"></i> Assign User To Role</a></li>-->
                        <!--//-->
                    </ul>

                    </li>

                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar hidden-print">
            <section class="sidebar">
                <div class="user-panel" style="color: white;">
                    <div class="pull-left image" style="padding-right: 10px;">
                        <!--<img src="http://njc.gov.ng/webFiles/images/njc-logo2.jpg" class="img-circle" alt="User Image">-->
                    </div>

                    <br><br>
                    <div class="">
                        {{-- removed these clases .pull-left .info --}}
                        <p>
                            @include( 'MasterRolePermission.layout.getUserRoleName' )
                            <a href="#"><i class="fa fa-circle text-success"></i> online</a>
                        </p>

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
            <strong>Copyright &copy; <?php echo date('Y'); ?> .</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
    <script src="{{ asset('assets/js/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" integrity="sha512-x/vqovXY/Q4b+rNjgiheBsA/vbWA3IVvsS8lkQSX1gQ4ggSJx38oI2vREZXpTzhAv6tNUaX81E7QBBzkpDQayA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $('#input-tags2').selectize({
            plugins: ['restore_on_backspace'],
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        });


    </script>
    {{-- Datepickr.js --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    @yield('scripts')
    <!-- <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script> -->


    @stack('select2')
</body>

</html>
