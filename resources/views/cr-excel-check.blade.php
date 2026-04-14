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

        <style>
            @media print {

                /* Force browsers to print background colors */
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                /* Hide all form & buttons */
                form,
                .no-print,
                button,
                input {
                    display: none !important;
                }

                /* Ensure background colors on TR and TD */
                tr[style],
                td[style] {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                /* Improve table visibility */
                table,
                tr,
                td,
                th {
                    border: 1px solid #000 !important;
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
                                        <div class="panel-heading no-print">Compare CR Excel, File Number and Grade with
                                            Database
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

                                                @if (session('merged_table'))
                                                    <form action="{{ route('export.pdf') }}" method="POST"
                                                        class="no-print mt-2">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Download
                                                            PDF</button>
                                                    </form>
                                                @endif

                                            </div>


                                            <h4>Database (Salary Excel) Records Missing in CR Excel</h4>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>File Number</th>
                                                        <th>Name</th>
                                                        <th>Database (Salary) Grade</th>
                                                        <th>CR Excel Grade</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($merged as $row)
                                                        @php
                                                            $color = match ($row['status']) {
                                                                'missing_in_excel' => 'background:red;color:white;',
                                                                'missing_in_db' => 'background:lightgreen;',
                                                                'grade_mismatch' => 'background:orange;',
                                                                default => '',
                                                            };
                                                        @endphp

                                                        <tr style="{{ $color }}">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $row['file_no'] }}</td>
                                                            <td>{{ $row['name'] }}</td>
                                                            <td>{{ $row['db_grade'] }}</td>
                                                            <td>{{ $row['excel_grade'] }}</td>
                                                            <td>
                                                                @switch($row['status'])
                                                                    @case('missing_in_excel')
                                                                        Present in Salary but NOT in CR Excel
                                                                    @break

                                                                    @case('missing_in_db')
                                                                        Present in CR Excel but NOT in Salary
                                                                    @break

                                                                    @case('grade_mismatch')
                                                                        Grade Mismatch (Salary VS CR Excel)
                                                                    @break

                                                                    @default
                                                                        Matched Record
                                                                @endswitch
                                                            </td>

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
