@extends('layouts.layout')

@section('pageTitle')
    Staff Due For Retirement
@endsection

@section('content')

    <div class="box-body">


        <div class="row" style="padding: 20px; margin-bottom:16px">
            <div class="col-md-12">
                <h4 class="text-uppercase">Add Staff For Retirement</h4>

                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('msg') }}
                    </div>
                @endif

                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> {{ session('err') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Bootstrap 3 Card (Panel) -->
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Retirement Update</h3>
                    </div>

                    <div class="panel-body">
                        <form method="post" id="mainform" name="mainform">
                            {{ csrf_field() }}

                            <!-- Court Section -->
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($CourtInfo->courtstatus == 1)
                                        <div class="form-group">
                                            <label for="staffName">Court</label>
                                            <select name="court" id="court" class="form-control court">
                                                <option>Select court</option>
                                                @foreach ($court as $courts)
                                                    <option value="{{ $courts->id }}"
                                                        @if ($courts->id == session('anycourt')) selected @endif>
                                                        {{ $courts->court_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" id="court" name="court"
                                            value="{{ $CourtInfo->courtid }}">
                                    @endif
                                </div>
                            </div>

                            <!-- Division & Staff -->
                            <div class="row">
                                @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="division">Division</label>
                                            <select name="division" id="division" class="form-control">
                                                <option value="">Select Division</option>
                                                @foreach ($courtDivisions as $div)
                                                    <option value="{{ $div->divisionID }}"
                                                        @if (old('division') == $div->divisionID) selected @endif>
                                                        {{ $div->division }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Division</label>
                                            <input type="text" class="form-control" id="divisionName" name="divisionName"
                                                value="{{ $curDivision->division }}" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" id="division" name="division"
                                        value="{{ Auth::user()->divisionID }}">
                                @endif

                                @if ($CourtInfo->courtstatus == 1)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staffName">Staff Name</label>
                                            <select name="staffName" id="staffName" class="form-control"
                                                onchange="setFileNo(this)">
                                                <option value="">Select Staff Name</option>
                                                @foreach ($staffList as $list)
                                                    <option value="{{ $list->fileNo }}">
                                                        {{ $list->surname }} {{ $list->first_name }}
                                                        {{ $list->othernames }}
                                                        - {{ $list->fileNo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="fileNo" id="fileNo">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Staff Names Search</label>
                                            <input type="text" id="userSearch" autocomplete="off" list="enrolledUsers"
                                                class="form-control" onchange="StaffSearchReload()">
                                            <datalist id="enrolledUsers" name="staff">
                                                @foreach ($staffData as $list)
                                                    <option value="{{ $list->fileNo }}">
                                                        {{ $list->fileNo }}: {{ $list->surname }} {{ $list->first_name }}
                                                        {{ $list->othernames }}
                                                    </option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- File No & Name -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fileNo">File No</label>
                                        <input type="text" name="fileNo" id="fileNo" class="form-control" readonly
                                            value="@if ($staff != '') {{ $staff->fileNo }} @endif" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            readonly
                                            value="@if ($staff != '') {{ $staff->surname }} {{ $staff->first_name }} {{ $staff->othernames }} @endif" />
                                    </div>
                                </div>
                            </div>

                            <!-- Employee Type & Grade -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employeeType">Employee Type</label>
                                        <input type="text" name="employeeType" id="employeeType" class="form-control"
                                            readonly
                                            value="@if ($staff != '') {{ $staff->employmentType }} @endif" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="oldGrade">Grade</label>
                                        <input type="text" name="oldGrade" id="oldGrade" class="form-control"
                                            readonly
                                            value="@if ($staff != '') {{ $staff->grade }} @endif" />
                                    </div>
                                </div>
                            </div>

                            <!-- Step & Retirement Date -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="oldStep">Step</label>
                                        <input type="text" name="oldStep" id="oldstep" class="form-control"
                                            readonly
                                            value="@if ($staff != '') {{ $staff->step }} @endif" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dueDate">Retirement Date</label>
                                        <input type="date" id="dueDate" name="dueDate" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-success" name="add" type="submit" form="mainform">Update</button>
                    </div>
                </div>
            </div>
        </div>





        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <!-- Bootstrap 3 Card Equivalent -->
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title" style="font-size: 18px; font-weight: bold;">
                            RETIRED STAFF'S
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive" style="font-size: 12px;">
                            <table class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th width="1%">S/N</th>
                                        <th>STAFF</th>
                                        <th>FILENO</th>
                                        <th>DIVISION</th>
                                        <th>GRADE</th>
                                        <th>STEP</th>
                                        <th>RETIREMENT DATE</th>
                                        <th>MONTH</th>
                                        <th>YEAR</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if ($staffForRetirementList && count($staffForRetirementList) > 0)
                                        @foreach ($staffForRetirementList as $key => $b)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }}</td>
                                                <td>{{ $b->fileNo }}</td>
                                                <td>{{ $b->division }}</td>
                                                <td>{{ $b->old_grade }}</td>
                                                <td>{{ $b->old_step }}</td>
                                                <td>{{ $b->due_date }}</td>
                                                <td>{{ $b->month_payment }}</td>
                                                <td>{{ $b->year_payment }}</td>
                                                <td>
                                                    @if (!$b->approvedBy)
                                                        <button class="btn btn-success btn-xs approveBtn"
                                                            data-id="{{ $b->ID }}">Approve</button>
                                                    @else
                                                        <span class="text-success">Approved</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center text-danger">
                                                No Records found...
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel-footer text-right">
                        <small>Showing Retired Staff List</small>
                    </div>
                </div>
            </div>
        </div>




    </div>




@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- ===================== Staff Search Script ========================= --}}
    <script>
        function StaffSearchReload() {
            let fileNo = document.getElementById('userSearch').value;
            if (!fileNo) return;

            $.ajax({
                url: '/get-staff-details/' + fileNo,
                method: 'GET',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    $('#fileNo').val(data.fileNo);
                    $('#name').val(data.name);
                    $('#employeeType').val(data.employeeType);
                    $('#oldGrade').val(data.grade);
                    $('#oldstep').val(data.step);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Could not fetch staff details. Please try again.');
                }
            });
        }

        function setFileNo(selectObj) {
            let fileNo = selectObj.value; // the value of the selected option
            $('#fileNo').val(fileNo); // set the hidden input
        }


        // Dropdown change
        $('#staffName').change(function() {
            let fileNo = $(this).val();
            if (!fileNo) return;

            $.ajax({
                url: '/get-staff-details/' + fileNo,
                method: 'GET',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    $('#fileNo').val(data.fileNo);
                    $('#name').val(data.name);
                    $('#employeeType').val(data.employeeType);
                    $('#oldGrade').val(data.grade);
                    $('#oldstep').val(data.step);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Could not fetch staff details. Please try again.');
                }
            });
        });
    </script>

    {{-- ===================== Approve Retirement Script ========================= --}}
    <script>
        $(document).ready(function() {
            $('.approveBtn').click(function() {
                let retirementId = $(this).data('id'); // lowercase
                let button = $(this);


                console.log('Retirement ID:', retirementId); // check browser console

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to approve this staff retirement?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/approve-retirement/' + retirementId,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Approved!', response.message, 'success');
                                    button.replaceWith(
                                        '<span class="text-success">Approved</span>'
                                    );
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                            console.log("0Error", xhr);
                                Swal.fire('Error!',
                                    'Could not approve. Please try again.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- ================ datepicker script ===================== -- --}}
    <script type="text/javascript">
        $(function() {
            $("#dateofBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            // $("#dueDate").datepicker({
            //     changeMonth: true,
            //     changeYear: true,
            //     dateFormat: 'yy-mm-dd'
            // });
            $("#incrementalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            // alert('danger')

            $('select[name="division"]').on('change', function() {
                var division_id = $(this).val();
                // alert(division_id)

                if (division_id) {
                    $.ajax({
                        url: "{{ url('/division/staff/ajax') }}/" + division_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {

                            var d = $('datalist[name="staff"]').html('');
                            $.each(data, function(key, value) {
                                $('datalist[name="staff"]').append(
                                    `<option value=${value.ID}>
                                ${value.fileNo} : ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`
                                );
                            });
                        }
                    });
                } else {
                    alert('danger')
                }

            }); // end sub category

        });
    </script>
    {{-- ///////////////////////////////////// --}}
@endsection
