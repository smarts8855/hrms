<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SCN-GRP</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Bootstrap 3 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/_all-skins.min.css') }}">

        <style>
            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                form,
                .no-print,
                button,
                input {
                    display: none !important;
                }

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

        <div>
            <header class="main-header">
                <nav class="navbar navbar-static-top" style="background: #0B610B">
                    <div align="center" style="color: #fff; font-size: 26px; padding: 10px;">
                        <b>Government Resource Planning</b>
                        <div style="font-size: 18px;">
                            <h2>SCN-GRP</h2>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="container">
                <h3>Staff Documents</h3>

                {{-- EDUCATION --}}
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        Education
                        <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                            data-target="#educationModal">
                            Add Education
                        </button>
                    </div>
                    <div class="panel-body">
                        @if ($educations->count())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>School</th>
                                        <th>Certificate</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($educations as $edu)
                                        <tr>
                                            <td>{{ $edu->category }}</td>
                                            <td>{{ $edu->schoolattended }}</td>
                                            <td>
                                                @if ($edu->document)
                                                    <a href="{{ $edu->document }}" target="_blank">View</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($edu->checkededucation)
                                                    <span class="label label-success">Verified</span>
                                                @else
                                                    <span class="label label-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No education records found.</p>
                        @endif
                    </div>
                </div>

                {{-- ATTACHMENTS --}}
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        Attachments
                        <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                            data-target="#attachmentModal">
                            Add Attachment
                        </button>
                    </div>
                    <div class="panel-body">
                        @if ($attachments->count())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attachments as $att)
                                        <tr>
                                            <td>{{ $att->filedesc }}</td>
                                            <td><a href="{{ $att->filepath }}" target="_blank">View</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No attachments uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Education Modal --}}
            @include('staff.partials.education-modal')



            {{-- Attachment Modal --}}
                                    @include('staff.partials.attachment-form')

            
        </div>

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    </body>

</html>
