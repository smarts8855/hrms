@extends('layouts.layout')
@section('pageTitle')
    Nominal Roll Reports
@endsection

@section('content')
    <style>
        /* Overall table container */
        .table-container {
            background: #fff;
            border-radius: 0.75rem;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-top: 15px;
        }

        /* Table styling */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            font-size: 13px;
            text-align: center;
        }

        .custom-table thead th {

            background: linear-gradient(90deg, #449d44, #337a33);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            vertical-align: middle;
            padding: 10px;
            border: none;
        }

        .custom-table tbody td {
            padding: 8px 10px;
            vertical-align: middle;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f8f9fc;
        }

        .custom-table tbody tr:hover {
            background-color: #eaf1ff;
            transition: 0.2s ease-in-out;
        }

        .custom-table td:first-child {
            font-weight: 600;
            color: #495057;
        }

        /* Rounded top corners for thead */
        .custom-table thead tr:first-child th:first-child {
            border-top-left-radius: 0.75rem;
        }

        .custom-table thead tr:first-child th:last-child {
            border-top-right-radius: 0.75rem;
        }

        /* Highlight table border */
        .custom-table th,
        .custom-table td {
            border: 1px solid #dee2e6;
        }

        /* Print-friendly adjustments */
        /* @media print {
                                                                                body {
                                                                                    -webkit-print-color-adjust: exact !important;
                                                                                }

                                                                                .table-container {
                                                                                    box-shadow: none !important;
                                                                                    border: none !important;
                                                                                    padding: 0 !important;
                                                                                }

                                                                                .custom-table thead th {
                                                                                    background: #c7c7c7 !important;
                                                                                    color: #000 !important;
                                                                                }
                                                                            } */
        /* Print-friendly adjustments */
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }

            .custom-table thead th {
                background: linear-gradient(90deg, #449d44, #337a33) !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact !important;
            }

            .custom-table tbody tr:hover {
                background: transparent !important;
            }
        }
    </style>
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
                            <select name="court" id="court" class="form-control" onchange ="ReloadForm();">
                                <option value="" selected>-All courts-</option>
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
                                <option value="" selected>-All divisions-</option>
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
                <div class="card shadow-sm rounded-3 mb-3 "
                    style="border: 2px solid rgba(241, 238, 233, 0.696);padding:10px;margin-bottom:15px;">
                    <div class="card-body">
                        <div class="card-header"></div>
                        <div class="card-content ">
                            <div class="row mb-3" style="padding-bottom: 10px">
                                <div class="col-md-3 ">
                                    <label>Grade</label>
                                    <select name="grade" id="grade" class="form-control">
                                        <option value="" selected>-All Grades-</option>
                                        @for ($i = 1; $i <= 17; $i++)
                                            <option value="{{ $i }}" {{ $grade == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Employment Type</label>
                                    <select name="employmenttype" id="employmenttype" class="form-control">
                                        <option value="" selected>-All types-</option>
                                        @foreach ($EmployeeTypeList as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $employmenttype == $b->id ? 'selected' : '' }}>
                                                {{ $b->employmentType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Departments</label>
                                    <select name="department" id="department" class="form-control">
                                        <option value="" selected>-All departments-</option>
                                        @foreach ($DepartmentList as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $department == $b->id ? 'selected' : '' }}>
                                                {{ $b->department }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Designation</label>
                                    <select name="designation" id="designation" class="form-control"
                                        data-designation="{{ $designation }}">
                                        <option value="" selected>-All designitions-</option>
                                        @foreach ($DesignationList as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $designation == $b->id ? 'selected' : '' }}>
                                                {{ $b->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row">




                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="month">Employment From</label>
                                        <input type="text" name="fromdate" id="fromdate" class="form-control"
                                            value="{{ date_format(date_create($fromdate), 'd F Y') }}" />

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="todate">To</label>
                                        <input type="text" name="todate" id="todate" class="form-control"
                                            value="{{ date_format(date_create($todate), 'd F Y') }}" />

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" selected>-All genders-</option>
                                        @foreach ($Gender as $b)
                                            <option value="{{ $b->gender }}"
                                                {{ $gender == $b->gender ? 'selected' : '' }}>
                                                {{ $b->gender }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Sort Order</label>
                                    <select name="orderlist" id="orderlist" class="form-control">
                                        <option value="" selected>-Select Orders-</option>
                                        @foreach ($OrderList as $b)
                                            <option value="{{ $b->field }}"
                                                {{ $orderlist == $b->field ? 'selected' : '' }}>
                                                {{ $b->fieldDescription }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">

                                    <button type="submit" class="btn btn-success col-md-4" onclick="return checkForm();"
                                        name="add">
                                        <i class="fa fa-btn fa-search-plus"></i> search
                                    </button>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>









                <div class="row">






                </div>
                <input id ="delcode" type="hidden" name="delcode">
                <input id ="fieldstoview" type="hidden" name="delcode" value="{{ json_encode($fieldstoview) }}">



            </div>

        </form>



        <div class="row mt-3 mb-3" style="margin-right: 1px">
            <div class="col-md-3 text-end" style="float: right">
                <span onclick="return myFunc()" class="btn btn-primary px-3 py-2 shadow-sm"
                    style="width: 100px;float: right">
                    <i class="fa fa-print me-1"></i> Print
                </span>
            </div>
        </div>


        {{-- <div class="table-responsive" style="font-size: 12px; padding:10px;" id="tablr">



            <table class="table table-bordered table-striped table-highlight">
                <thead>
                    <tr bgcolor="#c7c7c7">
                        <th width="1%">S/N</th>

                        <th>NAME IN FULL</th>

                        <th>DATE OF BIRTH</th>
                        <th>GENDER</th>
                        <th>MARITAL STATUS</th>
                        <th>L.G.A</th>
                        <th>STATE OF ORIGIN</th>
                        <th>DATE OF APPOINTMENT</th>
                        <th>RANK</th>
                        <th>DATE OF PRESENT APPOINTMENT</th>
                        <!---<th >Grade</th>
                                                                                                                                                                                                                                                                                                <th >Steps</th>
                                                                                                                                                                                                                                                                                                <th >Date of present appointment</th>-->
                        @if ($CourtInfo->divisionstatus == 1)
                            <th>DIVISION</th>
                        @endif
                        <th>QUALIFICATIONS</th>


                    </tr>
                </thead>
                @php $serialNum = 1; @endphp
                @foreach ($QueryStaffReport as $b)
                    <tr>
                        <td>{{ $serialNum++ }} </td>
                        <td>{{ $b->StaffName }}</td>

                        <td class="dob">{{ date('d-m-Y', strtotime($b->dob)) }}</td>

                        <td class="gender">{{ $b->gender }}</td>

                        <td class="ms">{{ $b->MStatus }}</td>

                        <td class="lga">{{ $b->LGA }}</td>

                        <td class="soo">{{ $b->State }}</td>

                        <td class="doa">{{ date('d-m-Y', strtotime($b->appointment_date)) }}</td>

                        <td class="rank">{{ $b->designations }}</td>

                        <td class="dopa">{{ date('d-m-Y', strtotime($b->date_present_appointment)) }}</td>

                        @if ($CourtInfo->divisionstatus == 1)
                            <td class="div">{{ $b->divisions }}</td>
                        @endif

                        <td class="qua">{{ $b->qualifications }}</td>



                    </tr>
                @endforeach


            </table>
        </div> --}}

        <div class="table-container" id="tablr">
            <div class="table-responsive">




                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th width="1%">S/N</th>
                            <th>FILE NO</th>
                            <th>NAME IN FULL</th>


                            <th>GRADE</th>
                            <th>STEP</th>


                            <th>DATE OF BIRTH</th>
                            <th>GENDER</th>
                            <th>MARITAL STATUS</th>
                            <th>L.G.A</th>
                            <th>STATE OF ORIGIN</th>
                            <th>DATE OF APPOINTMENT</th>
                            <th>RANK</th>
                            <th>DATE OF PRESENT APPOINTMENT</th>
                            @if ($CourtInfo->divisionstatus == 1)
                                <th>DIVISION</th>
                            @endif
                            {{-- <th>QUALIFICATIONS</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $serialNum = 1; @endphp
                        @foreach ($QueryStaffReport as $b)
                            <tr>
                                <td>{{ $serialNum++ }}</td>
                                <td>{{ $b->fileNo }}</td>
                                <td class="text-start fw-semibold">{{ $b->StaffName }}</td>

                                @if ($b->employee_type != 6)
                                    <td>{{ $b->grade }}</td>
                                    <td>{{ $b->step }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif

                                <td>{{ date('d-m-Y', strtotime($b->dob)) }}</td>
                                <td>{{ $b->gender }}</td>
                                <td>{{ $b->maritalstatus }}</td>
                                <td>{{ $b->LGA }}</td>
                                <td>{{ $b->State }}</td>
                                <td>{{ date('d-m-Y', strtotime($b->appointment_date)) }}</td>
                                <td>{{ $b->designations }}</td>
                                <td>{{ date('d-m-Y', strtotime($b->date_present_appointment)) }}</td>
                                @if ($CourtInfo->divisionstatus == 1)
                                    <td>{{ $b->divisions }}</td>
                                @endif
                                {{-- <td>{{ $b->qualifications }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>



            </div>
        </div>



    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
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
    {{-- <script>
        function myFunc() {
            // var printme = document.getElementById('tablr');
            // var wme = window.open("", "", "width=900,height=700");
            // wme.document.write(printme.outerHTML);
            // wme.document.close();
            // wme.focus();
            // wme.print();
            // wme.close();
            window.print();
            return false;
        }
    </script> --}}

    {{-- <script>
        function myFunc() {
            // Get only the table section
            var printContents = document.getElementById('tableToPrint').outerHTML;

            // Open a clean popup window
            var w = window.open('', '', 'height=700,width=900');
            w.document.write(`
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `);
            w.document.close();
            w.focus();
            w.print();
            w.close();
            return false;
        }
    </script> --}}

    {{-- <script>
        function myFunc() {
            var printContents = document.getElementById('tablr').outerHTML; // print only your table
            var w = window.open('', '', 'height=800,width=1000');

            w.document.write(`
        <html>
        <head>
            <title>Nominal Roll Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 30px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #333; padding: 8px; text-align: left; font-size: 12px; }
                th { background-color: #f2f2f2; }
                h3 { text-align: center; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <h3>Nominal Roll Report</h3>
            ${printContents}
        </body>
        </html>
    `);

            w.document.close();

            // ✅ Wait for the new document to load before printing
            w.onload = function() {
                w.focus();
                w.print();
            };
        }
    </script> --}}

    {{-- <script>
        function myFunc() {
            // Hide everything except the table
            const table = document.getElementById('tablr').outerHTML;
            const originalContent = document.body.innerHTML;

            // Replace body with only the table content
            document.body.innerHTML = `
        <div style="margin: 30px; font-family: Arial, sans-serif;">
            <h3 style="text-align:center;">Nominal Roll Report</h3>
            ${table}
        </div>
    `;

            // Open print dialog on the same page
            window.print();

            // Restore original content after printing
            document.body.innerHTML = originalContent;
        }
    </script> --}}

    <script>
        function myFunc() {
            // Get table element
            const table = document.getElementById('tablr');
            if (!table) {
                window.print();
                return;
            }

            // Save the original HTML
            const originalContent = document.body.innerHTML;

            // Get all styles from the page
            let styles = '';
            for (const sheet of document.styleSheets) {
                try {
                    if (sheet.href) {
                        styles += `<link rel="stylesheet" href="${sheet.href}">`;
                    } else if (sheet.ownerNode && sheet.ownerNode.tagName === 'STYLE') {
                        styles += `<style>${sheet.ownerNode.innerHTML}</style>`;
                    }
                } catch (e) {
                    // ignore CORS-protected stylesheets
                }
            }

            // Replace the page content temporarily with the styled table
            document.body.innerHTML = `
        <html>
            <head>
                <title>Print Table</title>
                ${styles}
            </head>
            <body style="margin:30px; font-family: Arial, sans-serif;">
                <h3 style="text-align:center; margin-bottom:20px;">Nominal Roll Report</h3>
                ${table.outerHTML}
            </body>
        </html>
    `;

            // Trigger print on the same page
            window.print();

            // Restore original content after printing
            document.body.innerHTML = originalContent;
            window.location.reload(); // reinitialize scripts if necessary
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

                // ✅ Clear all form fields after successful search
                document.getElementById('thisform1').reset();

                // ✅ If you’re using custom datepickers, clear them manually
                document.getElementById('fromdate').value = '';
                document.getElementById('todate').value = '';

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

                    // ✅ Clear all form fields after successful search
                    document.getElementById('thisform1').reset();

                    // ✅ If you’re using custom datepickers, clear them manually
                    document.getElementById('fromdate').value = '';
                    document.getElementById('todate').value = '';

                },
            });
        })
    </script>

    {{-- <script>
        $(document).ready(function() {

            // 🔹 When department changes, fetch designations
            $('#department').on('change', function() {
                $.ajax({
                    url: "/report/get-designation",
                    type: "POST",
                    data: {
                        department: $(this).val(),
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#designation').empty();
                        $('#designation').append(
                            '<option value="" selected>-All designations-</option>');
                        $.each(response, function(i, d) {
                            $('#designation').append('<option value="' + d.id + '">' + d
                                .designation + '</option>');
                        });
                    }
                });
            });

            // 🔹 When the main search form is submitted
            $('#thisform1').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "/report/search-staff", // 🔸 replace this with your actual search route
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        // 🔸 handle your fetched data (example)
                        $('#tablr').html(response); // or however you display results

                        // ✅ Clear the form fields after successful search
                        document.getElementById('thisform1').reset();

                        // ✅ Clear date fields manually (if using datepicker)
                        document.getElementById('fromdate').value = '';
                        document.getElementById('todate').value = '';
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {

            // 🔹 Handle department change to load designations
            $('#department').on('change', function() {
                $.ajax({
                    url: "/report/get-designation",
                    type: "POST",
                    data: {
                        department: $(this).val(),
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#designation').empty();
                        $('#designation').append(
                            '<option value="" selected>-All designations-</option>');
                        $.each(response, function(i, d) {
                            $('#designation').append('<option value="' + d.id + '">' + d
                                .designation + '</option>');
                        });
                    }
                });
            });

            // 🔹 Handle form submission for search
            $('#thisform1').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "/report/search-staff", // ✅ Change to your actual route
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        // ✅ Render your search result area
                        $('#tablr').html(response);

                        // ✅ Reset form after data successfully fetched
                        setTimeout(() => {
                            $('#thisform1')[0].reset();

                            // ✅ If you use custom date pickers, clear manually
                            $('#fromdate').val('');
                            $('#todate').val('');

                            // ✅ Re-initialize selects (for Select2 or similar)
                            $('#court, #division, #grade, #employmenttype, #department, #designation, #gender, #orderlist')
                                .val('')
                                .trigger('change');
                        }, 500);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
@endsection
