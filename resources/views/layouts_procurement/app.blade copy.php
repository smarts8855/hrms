<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle', 'Welcome To Procurement Application')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Welcome To Procurement Application" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="#">
    <!-- jquery.vectormap css -->
    <link href="{{ asset('procurement/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('procurement/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('procurement/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />  

    <!-- Responsive datatable examples -->
    <link href="{{ asset('procurement/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{ asset('procurement/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('procurement/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('procurement/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ asset('procurement/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('procurement/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('procurement/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('procurement/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('procurement/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Summernote css -->
    <link href="{{ asset('procurement/assets/libs/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('procurement/assets/css/jquery-ui.min.css') }}">

    <script>
        var murl = "{{ url('/') }}";
    </script>

    <style>
        .header-title {
            background: #ffffff;
            padding: 15px;
            color: #ffffff;
            text-shadow: 1px 1px 3px #333;
            margin: 10px 0;
            font-size: 26px;
            font-family: bolder;

        }

        #sidebar-menu ul li a {
            font-size: 12px !important;

        }

        #sidebar-menu ul li ul.sub-menu li a {
            padding-left: 2rem !important;
        }
    </style>

    <!--Language Translation-->
    <!--<div id="google_translate_element"></div>-->
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    <script src="/translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <!--//Translation-->

    @yield('styles')
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== Header Start ========== -->
        {{-- @include('ShareView.header') --}}
        <!-- Header End -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('ShareView.menu')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 text-uppercase">@yield('pageTitle')</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="{{ url('home') }}">Home</a>
                                            {{-- <a href="{{ route('home') }}">Home</a> --}}
                                        </li>
                                        <li class="breadcrumb-item active">@yield('pageTitle')</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr />
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    {{-- @yield('content') --}}

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->

              

                <div id="inactivity_warning" class="modal hide fade" data-backdrop="static" style="top:30%">
                    <div class="modal-header">
                        <button type="button" class="close inactivity_ok" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row-fluid">
                            <div id="custom_alert_message" class="span12">
                                You will be logged out in 5 minutes due to inactivity. Please save your credit
                                application if you have not already done so.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0)" class="btn inactivity_ok" data-dismiss="modal"
                                aria-hidden="true">O.K</a>
                        </div>
                    </div>
                </div>


            </div>
            <!-- End Page-content -->

            {{-- <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ date('Y') }} © Procurement Application.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Developed By <a href="#"></a> <i
                                    class="fa fa-desktop"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </footer> --}}
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('procurement/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/metismenu/metisMenu.min.js') }}"></script>


    <!-- Required datatable js -->
    <script src="{{ asset('procurement/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('procurement/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script> --}}


    <!--Table-->
    <!-- Buttons examples -->
    <script src="{{ asset('procurement/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('procurement/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('procurement/assets/js/pages/datatables.init.js') }}"></script>
    <!--//table-->

    <!--Text Editor-->
    <!-- Summernote js -->
    <script src="{{ asset('procurement/assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <!--tinymce js-->
    <script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('procurement/assets/js/pages/form-editor.init.js') }}"></script>
    <!--//Text Editor-->

    <!--form validation-->
    <script src="{{ asset('procurement/assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/js/pages/form-validation.init.js') }}"></script>
    <!--//form validation-->
    <!-- Sweet Alerts js -->
    <script src="{{ asset('procurement/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Sweet alert init js-->
    <script src="{{ asset('procurement/assets/js/pages/sweet-alerts.init.js') }}"></script>
    <!-- Session timeout js -->
    <!--<script src="{{ asset('procurement/assets/libs/%40curiosityx/bootstrap-session-timeout/index.js') }}"></script> -->
        <!-- Session timeout js --> 
    <!--<script src="{{ asset('procurement/assets/js/pages/session-timeout.init.js') }}"></script>-->
    <script src="{{ asset('procurement/assets/js/app2.js') }}"></script>

    
    <script src="{{ asset('procurement/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('procurement/assets/js/custom.js') }}"></script>
    <!-- jquery step -->
    @yield('scripts')


</body>

</html>
