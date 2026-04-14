@extends('layouts.layout')
@section('pageTitle')
    Nominal Roll Reports
@endsection

<style>
    /* Your existing styles remain the same */
    .fed-char {
        margin-top: 30px;
    }

    .fed-char tr th {
        color: #FFF;
        text-align: center;
        border: 1px solid #666;
        font-size: 14px;
    }

    .fed-char tbody tr td {
        text-align: center;
        border: 1px solid #666;
        font-size: 14px;
    }

    .fed-char .row2 th {
        font-size: 12px;
    }

    .table {
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    @media print {
        /* Hide non-printable elements */
        .hidden-print {
            display: none !important;
        }
        
        /* Force table to use full width */
        .table-responsive {
            width: 100% !important;
            overflow: visible !important;
        }
        
        .fed-char {
            width: 100% !important;
            max-width: 100% !important;
            font-size: 10px !important;
            margin-top: 10px !important;
        }
        
        .fed-char tr th,
        .fed-char tr td {
            font-size: 9px !important;
            padding: 3px !important;
            line-height: 1.2 !important;
        }
        
        .fed-char thead tr th {
            background: #333 !important;
            color: #FFF !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
        
        /* Ensure table doesn't break across pages */
        table {
            page-break-inside: auto !important;
        }
        
        tr {
            page-break-inside: avoid !important;
            page-break-after: auto !important;
        }
        
        thead {
            display: table-header-group !important;
        }
        
        tfoot {
            display: table-footer-group !important;
        }
        
        /* Adjust page margins */
        @page {
            margin: 0.5cm;
            size: landscape;
        }
        
        body {
            margin: 0 !important;
            padding: 10px !important;
        }
    }
</style>


<style type="text/css" media="print">
    .table thead tr th {
        color: #FFF !important;
    }

    .table thead tr th {
        color: #FFF !important;
    }

</style>


@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        @if ($warning != '')
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>{{ $warning }}</strong>
            </div>
        @endif
        @if ($success != '')
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>{{ $success }}</strong>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form method="post" id="thisform1" name="thisform1">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="row">
                    @if ($CourtInfo->courtstatus == 1)
                        <div class="col-md-4">
                            <label>Court</label>
                            <select name="court" id="court" class="form-control" onchange="ReloadForm();">
                                <option value="" selected>-All court-</option>
                                @foreach ($CourtList as $b)
                                    <option value="{{ $b->id }}" {{ $court == $b->id ? 'selected' : '' }}>
                                        {{ $b->court_name }}({{ $b->courtAbbr }})</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                    @endif
                    @if ($CourtInfo->divisionstatus == 1)
                        <div class="col-md-4">
                            <label>Division</label>
                            <select name="division" id="division" class="form-control">
                                <option value="" selected>-All division-</option>
                                @foreach ($Divisions as $b)
                                    <option value="{{ $b->divisionID }}"
                                        {{ $division == $b->divisionID ? 'selected' : '' }}>{{ $b->division }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">
                    @endif

                </div>

                <!-- Row 1: Grade Level, Employment Type, Departments -->
                <div class="row hidden-print">
                    <div class="col-md-4">
                        <label>Grade Level</label>
                        <select name="grade" id="grade" class="form-control">
                            <option value="" selected>-All Grades-</option>
                            @for ($i = 1; $i <= 17; $i++)
                                <option value="{{ $i }}" {{ $grade == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Employment Type</label>
                        <select name="employmenttype" id="employmenttype" class="form-control">
                            <option value="" selected>-All type-</option>
                            @foreach ($EmployeeTypeList as $b)
                                <option value="{{ $b->id }}" {{ $employmenttype == $b->id ? 'selected' : '' }}>
                                    {{ $b->employmentType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Departments</label>
                        <select name="department" id="department" class="form-control">
                            <option value="" selected>-All department-</option>
                            @foreach ($DepartmentList as $b)
                                <option value="{{ $b->id }}" {{ $department == $b->id ? 'selected' : '' }}>
                                    {{ $b->department }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Row 2: Designation, Employment From, To -->
                <div class="row hidden-print">
                    <div class="col-md-4">
                        <label>Designation</label>
                        <select name="designation" id="designation" class="form-control"
                            data-designation="{{ $designation }}">
                            <option value="" selected>-All designition-</option>
                            @foreach ($DesignationList as $b)
                                <option value="{{ $b->id }}" {{ $designation == $b->id ? 'selected' : '' }}>
                                    {{ $b->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="month">Employment From</label>
                            <input type="text" name="fromdate" id="fromdate" class="form-control"
                                value="{{ date_format(date_create($fromdate), 'd F Y') }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="todate">To</label>
                            <input type="text" name="todate" id="todate" class="form-control"
                                value="{{ date_format(date_create($todate), 'd F Y') }}" />
                        </div>
                    </div>
                </div>

                <!-- Row 3: Gender, Sort Order, Search and Print Buttons -->
                <div class="row hidden-print">
                    <div class="col-md-4">
                        <label>Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="" selected>-All gender-</option>
                            @foreach ($Gender as $b)
                                <option value="{{ $b->gender }}" {{ $gender == $b->gender ? 'selected' : '' }}>
                                    {{ $b->gender }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Sort Order</label>
                        <select name="orderlist" id="orderlist" class="form-control">
                            <option value="" selected>-Select Order-</option>
                            @foreach ($OrderList as $b)
                                <option value="{{ $b->field }}" {{ $orderlist == $b->field ? 'selected' : '' }}>
                                    {{ $b->fieldDescription }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-top: 25px;">
                            <button type="submit" class="btn btn-success" onclick="return checkForm();" name="add" style="width: 48%;">
                                <i class="fa fa-btn fa-search-plus"></i> Search
                            </button>
                            
                            @if (!empty($QueryStaffReport))
                                <span onclick="return myFunc()" class="btn btn-primary" name="add" style="width: 48%;">
                                    <i class="fa fa-print"></i> Print
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Results Count -->
                @if (!empty($QueryStaffReport))
                <div class="row hidden-print">
                    <div class="col-md-12">
                        <div style="text-align: center; margin-top: 10px;">
                            @if (count($QueryStaffReport) == 0 || count($QueryStaffReport) < 1)
                                <span class="text-center text-warning">{{ count($QueryStaffReport) }} Result</span>
                            @else
                                <span class="text-center text-success">{{ count($QueryStaffReport) }} Results</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <input id="delcode" type="hidden" name="delcode">
                <input id="fieldstoview" type="hidden" name="delcode" value="{{ json_encode($fieldstoview) }}">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">

                    <table class="table fed-char">
                        <thead>
                            <tr style=" border:1px solid #333">
                                <th colspan="17" align="center" style="color:#333;">SCN STAFF DISPOSITION LIST AS AT
                                    {{ date('Y-m-d') }}</th>
                            </tr>

                            <tr bgcolor="#FFF">
                                <th style="color:#000;" width="1%"></th>
                                <th style="color:#000;">EMPLOYEEE STATUS</th>
                                <th style="color:#000;">EMPLOYEEE NO. <br /> </th>

                                <th style="color:#000;">NAME</th>
                                <th style="color:#000;">NATIONALITY</th>
                                <th style="color:#000;">STATE OF <br /> ORIGIN</th>
                                <th style="color:#000;">L.G.A</th>
                                <th style="color:#000;">REGION</th>
                                <th style="color:#000;">DATE OF BIRTH</th>
                                <th style="color:#000;">DATE OF EMPLOYMENT</th>
                                <th style="color:#000;">DATE OF PRESENT APPOINTMENT</th>
                                <th style="color:#000;">GRADE LEVEL</th>

                                <th style="color:#000;">DESIGNATION</th>
                                <th>State of <br /> DEPLOYMENT</th>
                                <th style="color:#000;">SEX</th>
                                <th style="color:#000;">MARITAL <br /> STATUS</th>
                                <th style="color:#000;">PHYSICALLY <br /> CHALLENGED</th>
                            </tr>

                            <tr color="#000" class="row2">
                                <th style="color:#000;" width="1%">S/N</th>
                                <th style="color:#000;">P.T.A.G</th>
                                <th style="color:#000;">MMM/SSSSSS</th>

                                <th style="color:#000;">Name</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;">DD/MM/YYYY</th>
                                <th style="color:#000;">DD/MM/YYYY</th>

                                <th style="color:#000;">DD/MM/YYYY</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;"></th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;">Code</th>
                                <th style="color:#000;"></th>
                            </tr>

                        </thead>

                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="soo"></td>
                                <td class="lga"></td>
                                <td class="lga" </td>
                                <td class="dob"></td>
                                <td class="doa"></td>
                                <td class="dopa"></td>
                                <td class="dob"></td>
                                <td class="rank"></td>
                                <td class="rank"></td>
                                <td class="gender"></td>
                                <td class="ms" </td>
                                <td class="qua"></td>

                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="soo"></td>
                                <td class="lga"></td>
                                <td class="lga" </td>
                                <td class="dob"></td>
                                <td class="doa"></td>
                                <td class="dopa"></td>
                                <td class="dob"></td>
                                <td class="rank"></td>
                                <td class="rank"></td>
                                <td class="gender"></td>
                                <td class="ms" </td>
                                <td class="qua"></td>

                            </tr>
                            @php $serialNum = 1; @endphp
                            @foreach ($QueryStaffReport as $b)
                                <tr>
                                    <td>{{ $serialNum++ }} </td>
                                    <td></td>
                                    <td>{{ $b->fileNo }}</td>
                                    <td>{{ $b->StaffName }}</td>
                                    <td>NG</td>
                                    <td class="soo">{{ $b->State }}</td>
                                    <td class="lga">{{ $b->LGA }}</td>
                                    <td class="lga">{{ $b->gpz }}</td>
                                    <td class="dob"> {{ date('d-M-Y', strtotime($b->dob)) }}</td>
                                    <td class="doa">
                                        @if ($b->appointment_date == '0000-00-00')
                                        @else
                                            {{ date('d-M-Y', strtotime($b->appointment_date)) }}
                                        @endif
                                    </td>
                                    <td class="dopa">
                                        @if ($b->date_present_appointment == '0000-00-00')
                                        @else
                                            {{ date('d-M-Y', strtotime($b->date_present_appointment)) }}
                                        @endif
                                    </td>
                                    <td class="dob">
                                        @if ($b->employee_type == 3)
                                            Con @else{{ $b->grade }}
                                        @endif
                                    </td>
                                    <td class="rank">
                                        @if ($b->employee_type == 3)
                                            Council Secretary @else{{ $b->designations }}
                                        @endif
                                    </td>
                                    <td class="rank">{{ $b->divisions }}</td>
                                    <td class="gender">{{ $b->gender }}</td>
                                    <td class="ms">{{ $b->maritalstatus }}</td>
                                    <td class="qua">{{ $b->challengestatus }}</td>

                                </tr>
                            @endforeach
                        </tbody>

                        <tr bgcolor="#444">
                            <th width="1%">S/N</th>
                            <th>Employee Status</th>
                            <th>Emp No <br /> </th>

                            <th>Name</th>
                            <th>Nationality</th>
                            <th>State of <br /> Origin</th>
                            <th>L.G.A</th>
                            <th>Region</th>
                            <th>Date of Birth</th>
                            <th>Date of Employment</th>
                            <th>Date of Present Appointment</th>
                            <th>Grade</th>

                            <th>Designation</th>
                            <th>State of <br /> Deployment</th>
                            <th>Sex</th>
                            <th>Marital <br /> Status</th>
                            <th>Physically <br /> Challenged</th>
                        </tr>
                    </table>
                </div>
            </div>

        </form>

    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/datepicker_scripts.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#fields').multiselect({
                nonSelectedText: 'Select fields to view',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '400px',
                includeSelectAllOption: true,
            });
        });
    </script>
    <script type="text/javascript">
        $("#fromdate").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst) {
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
                $("#fromdate").val(dateFormatted);
            },
        });

        $("#todate").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst) {
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
                $("#todate").val(dateFormatted);
            },
        });
    </script>
    <script type="text/javascript">
        function checkForm() {
            var fields = document.getElementById('fields').value;
            var form = document.getElementById('thisform1');
            if (fields == '') {
                alert('Please select fields to view');
                return false;
            } else {
                form.submit();
            }
            return false;
        }

        function ReloadForm() {
            //alert("ururu")	;
            document.getElementById('thisform1').submit();
            return;
        }

        function DeletePromo(id) {
            var cmt = confirm('You are about to delete a record. Click OK to continue?');
            if (cmt == true) {
                document.getElementById('delcode').value = id;
                document.getElementById('thisform1').submit();
                return;

            }

        }
        $(function() {
            $("#todate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#fromdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#appointmentDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#incrementalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#firstArrivalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <script>
        function myFunc() {
            // Simply trigger print on the current page
            window.print();
        }
    </script>
    <script>
        $.ajax({
            url: "/report/get-designation",
            type: "POST",
            data: {
                department: $('#department').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {

                $.each(response, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#designation').append('<option value="' + d.id + '">' + d.designation +
                        '</option>');
                });
                $('#designation').val($('#designation').attr('data-designation'))

            },
        });


        $('#department').on('change', function() {
            $.ajax({
                url: "/report/get-designation",
                type: "POST",
                data: {
                    department: $(this).val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#designation').empty()
                    $('#designation').append('<option value="" selected>-All designition-</option>')
                    $.each(response, function(i, d) {
                        // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                        $('#designation').append('<option value="' + d.id + '">' + d
                            .designation + '</option>');
                    });

                },
            });
        })
    </script>
@endsection