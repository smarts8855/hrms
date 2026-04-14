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

        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #000 !important;
                /* force border */
                padding: 5px;
            }

            .status-missing-in-excel {
                background-color: #d9534f !important;
                color: #fff !important;
            }

            .status-missing-in-db {
                background-color: #dff0d8 !important;
                color: #000 !important;
            }

            .status-grade-mismatch {
                background-color: #f0ad4e !important;
                color: #000 !important;
            }

            .status-match {
                background-color: #fff !important;
                color: #000 !important;
            }

            table,
            th,
            td {
                border: 1px solid #000 !important;
            }
        </style>



    </head>

    <body class="hold-transition skin-green sidebar-mini">

        <div class=""><!--wrapper-->

            <div class="">
                <section class="">
                    <div class="box box-default">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="panel panel-success">
                                        <div class="panel-body">
                                            <table class="table table-bordered">
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
                                                                'missing_in_excel'
                                                                    => 'background-color:red;color:white;',
                                                                'missing_in_db'
                                                                    => 'background-color:lightgreen;color:black;',
                                                                'grade_mismatch'
                                                                    => 'background-color:orange;color:black;',
                                                                default => '',
                                                            };
                                                        @endphp
                                                        <tr style="{{ $color }}"
                                                            class="status-{{ $row['status'] }}">
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
