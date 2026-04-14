@extends('layouts.layout')

@section('pageTitle')
    Staff Due For Arrears
@endsection

@section('content')

    <div class="box-body">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
                <h4 class="" style="text-transform:uppercase">Add staff For Arrears</h4>
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

                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong>
                        {{ session('msg') }}
                    </div>
                @endif

                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong>
                        {{ session('err') }}
                    </div>
                @endif

            </div>


            <div class="col-md-12"><!---2nd col-->
                <form method="post" style="margin-top:10px; padding-top:20px;" id="mainform" name="mainform"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if ($CourtInfo->courtstatus == 1)
                        <div class="col-md-4"style="padding-top:20px;">
                            <div class="form-group">
                                <label for="staffName">Court</label>
                                <select name="court" id="court" class="form-control court">

                                    <option>Select court</option>
                                    @foreach ($court as $courts)
                                        @if ($courts->id == session('anycourt'))
                                            <option value="{{ $courts->id }}" selected="selected">
                                                {{ $courts->court_name }}</option>
                                        @else
                                            <option value="{{ $courts->id }}">{{ $courts->court_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                    @endif

                    @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                        <div class="col-md-4" style="padding-top:20px;">
                            <div class="form-group">
                                <label for="staffName">Division</label>
                                <select name="division" id="division" class="form-control">
                                    <option value="">Select Division</option>
                                    @foreach ($courtDivisions as $div)
                                        <option value="{{ $div->divisionID }}"
                                            @if ($selectedDiv == $div->divisionID) selected @endif>
                                            {{ $div->division }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4" style="padding-top:20px;">
                            <div class="form-group">
                                <label>Division</label>
                                <input type="text" class="form-control" id="divisionName" name="divisionName"
                                    value="{{ $curDivision->division }}" readonly>
                            </div>
                        </div>
                        <input type="hidden" id="division" name="division" value="{{ Auth::user()->divisionID }}">
                    @endif

                    @if ($CourtInfo->courtstatus == 1)
                        <div class="col-md-4" style="padding-top:20px;">
                            <div class="form-group">
                                {{-- <label for="staffName">Select Staff Name</label> --}}
                                <select name="staffName" id="staffName" class="form-control">
                                    <option>Select Staff Name</option>
                                    @foreach ($staffList as $list)
                                        @if ($list->ID == session('staffsession'))
                                            <option value="{{ $list->ID }}" selected>
                                                {{ $list->first_name }} {{ $list->surname }} {{ $list->othernames }}
                                            </option>
                                        @else
                                            <option value="{{ $list->ID }}">
                                                {{ $list->surname }} {{ $list->first_name }} {{ $list->othernames }} -
                                                {{ $list->fileNo }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4" style="padding-top:20px;">
                            <div class="form-group">

                                <input type="hidden" id="fileNo" name="fileNo"
                                    value="@if ($staff != '') {{ $staff->ID }} @endif" />
                                <label class="control-label">Staff Names Search</label>
                                <input type="text" id="userSearch" autocomplete="off" list="enrolledUsers"
                                    class="form-control" onchange="StaffSearchReload()">

                                <datalist id="enrolledUsers" name="staff">
                                    @foreach ($staffData as $list)
                                        <option value="{{ $list->ID }}">
                                            {{ $list->fileNo }}:{{ $list->surname }} {{ $list->first_name }}
                                            {{ $list->othernames }}
                                        </option>
                                    @endforeach
                                </datalist>

                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fileNo">File No</label>
                            <input type="Text" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->fileNo }} @endif" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fileNo">Name</label>
                            <input type="Text" name="name" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->surname }} {{ $staff->first_name }} {{ $staff->othernames }} @endif" />
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="staffFullName">Employee Type</label>
                            <input type="Text" name="employeeType" id="employeeType" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->employmentType }} @endif" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="grade">Employee Type (New)</label>

                            <input type="Text" name="newEmployeeType" id="employeeType" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->employmentType }} @endif" />
                            {{-- <input type="hidden" name="newEmpType" id="empType" class="form-control"
                                value="@if ($staff != '') {{ $staff->employee_type }} @endif" /> --}}
                            <input type="hidden" name="newEmpType" id="newEmpType" class="form-control" readonly
                                value="{{ isset($staff) ? trim($staff->employee_type) : '' }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="step">Old Grade</label>
                            {{-- <input type="Text" name="oldGrade" id="oldGrade" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->grade }} @endif" /> --}}
                            <input type="Text" name="oldGrade" id="oldGrade" class="form-control" readonly
                                value="{{ isset($staff) ? trim($staff->grade) : '' }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">New Grade</label>
                            <select name='newGrade' class="form-control">
                                <option value=""></option>
                                @for ($i = 1; $i <= 17; $i++)
                                    <option value="{{ $i }}"
                                        @if (old('newGrade') == $i) selected @endif>{{ $i }}</option>
                                @endfor

                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="step">Old Step</label>
                            {{-- <input type="Text" name="oldStep" id="oldstep" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->step }} @endif" /> --}}
                            <input type="Text" name="oldStep" id="oldStep" class="form-control" readonly
                                value="{{ isset($staff) ? trim($staff->step) : '' }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="step">New Step</label>
                            <select name='newStep' class="form-control">
                                <option value=""></option>
                                @for ($i = 1; $i <= 17; $i++)
                                    <option value="{{ $i }}"
                                        @if (old('newStep') == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="staffBank">Bank</label>
                            <input type="Text" name="staffBank" id="staffBank" class="form-control" readonly
                                value="@if ($staff != '') {{ $staff->bank }} @endif" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vehicle">Arrears Type</label>
                            <select name='arrearsType' class="form-control">
                                <option value="">Select</option>
                                <option value="increment">increment</option>
                                <option value="advancement">advancement</option>
                                <option value="newAppointment">New Appointment</option>
                                <option value="contractAppointment">Contract Appointment</option>
                                <option value="Promotion">Promotion</option>
                                <option value="advancement">Conversion</option>
                                <option value="restoration">Restoration</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vehicle">Due Date</label>
                            <input type="Text" name="dueDate" id="dueDate" class="form-control"
                                value="{{ old('dueDate') }}" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="doc_url">Upload File <i style="color: red">(optional)</i></label>
                            <input type="file" name="doc_url" id="doc_url" class="form-control"
                                value="{{ old('doc_url') }}" />
                        </div>
                    </div>


                    <div align="right" class="box-footer" style="padding-top:40px;">
                        <button class="btn btn-success" name="add" type="submit"> Update</button>
                    </div>
            </div>
        </div><!-- /.col href="{{ url('/variable/view/') }}"-->
    </div><!-- /.row -->
    </form>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        function StaffSearchReload() {
            document.getElementById('fileNo').value = document.getElementById('userSearch').value;
            document.forms["mainform"].submit();
            return;
        }
    </script>

    <script type="text/javascript">
        $(function() {
            $("#dateofBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $("#dueDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
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
