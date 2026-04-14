<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Co mpatible" content="IE=edge">
        <?php $url = $_SERVER['HTTP_HOST']; ?>
        <title> SCN-GRP </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/_all-skins.min.css') }}">
        @yield('styles')
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
            var murl = "{{ url('/') }}";
        </script>

        <style>
            @media print {

                form,
                .no-print {
                    display: none !important;
                }
            }
        </style>

    </head>

    <body class="hold-transition skin-green sidebar-mini">

        <div class=""><!--wrapper-->
            <header class="main-header">
                <nav class="navbar navbar-static-top" style="background: #0B610B">
                    <div align="center" style="color: #fff; font-size: 26px; padding: 10px;">
                        <b> Government Resource Planning</b>
                        <div style="font-size: 18px;">
                            <h2>SCN-GRP</h2>
                        </div>
                        <!--<img src="{{ asset('Images/coat.jpg') }}" height="45" align="left" style="border-radius: 4px;">-->
                    </div>
                </nav>
            </header>

            <div class="">
                <section class="">
                    <div class="box box-default">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="panel panel-success">
                                        <div class="panel-heading no-print">Compare CR Excel, File Number and Grade with Database
                                            with</div>
                                        <div class="panel-body">
                                            <form action="/cr-excel-check" method="POST" enctype="multipart/form-data"
                                                class="no-print">
                                                @csrf

                                                <div class="form-group">
                                                    <input type="file" name="file" required class="form-control">
                                                </div>

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-sign-in"></i> Upload
                                                </button>
                                            </form>

                                            <hr class="no-print">

                                            <div class="mb-3 no-print">
                                                <button class="btn btn-primary" onclick="window.print()">Print
                                                    Results</button>
                                            </div>


                                            <h4>Database (Salary Excel) Records Missing in CR Excel</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>File Number</th>
                                                        <th>Name</th>
                                                        <th>Database Grade</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($missingInExcel as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $row['file_number'] }}</td>
                                                            <td>{{ $row['name'] }}</td>
                                                            <td>{{ $row['db_grade'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>


                                            <h4>CR Excel Records Missing in Database (Salary Excel)</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>File Number</th>
                                                        <th>Excel Grade</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($missingInDb as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $row['file_number'] }}</td>
                                                            <td>{{ $row['excel_grade'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>


                                            <h4>Grade Mismatch: (Database (Salary Excel) Grade VS CR Excel Grade)</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>File Number</th>
                                                        <th>Name</th>
                                                        <th>Database (Salary Excel) Grade</th>
                                                        <th>CR Excel Grade</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($gradeMismatchDbVsExcel as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $row['file_number'] }}</td>
                                                            <td>{{ $row['name'] }}</td>
                                                            <td>{{ $row['db_grade'] }}</td>
                                                            <td>{{ $row['excel_grade'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </body>

</html>
