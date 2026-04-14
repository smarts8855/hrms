@extends('layouts.layout')

@section('pageTitle')
    Staff Due For Arrears
@endsection

@section('content')

    <div class="box-body">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
                <h4 class="" style="text-transform:uppercase">Add staff Overdue Arrears</h4>
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
                    <input type="hidden" id="delid" name="delid">
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
                                    {{-- @if (session('anycourt') != '') --}}
                                    @foreach ($courtDivisions as $div)
                                        {{-- @if ($div->divisionID == session('divsession')) --}}
                                        {{-- <option value="{{$div->divisionID}}" selected="selected">{{$div->division}}</option> --}}
                                        <option value="{{ $div->divisionID }}" @if (old('division') == $div->divisionID)  @endif>
                                            {{ $div->division }}
                                        </option>
                                        {{-- @else
                                        <option value="{{$div->divisionID}}">{{$div->division}}</option>
                                    @endif --}}
                                    @endforeach
                                    {{-- @endif --}}
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
                        <!--<input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">-->
                    @endif

                    @if ($CourtInfo->courtstatus == 1)
                        <div class="col-md-4" style="padding-top:20px;">
                            <div class="form-group">
                                <label for="staffName">Select Staff Name</label>
                                <select name="staffName" id="staffName" class="form-control">
                                    <option>Select Staff Name</option>
                                    @foreach ($staffList as $list)
                                        @if ($list->ID == session('staffsession'))
                                            <option value="{{ $list->ID }}" selected>{{ $list->first_name }}
                                                {{ $list->surname }} {{ $list->othernames }}</option>
                                        @else
                                            <option value="{{ $list->ID }}"> {{ $list->surname }}
                                                {{ $list->first_name }} {{ $list->othernames }} - {{ $list->fileNo }}
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
                                        <option value="{{ $list->ID }}">{{ $list->fileNo }}:{{ $list->surname }}
                                            {{ $list->first_name }} {{ $list->othernames }}</option>
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
                            <input type="hidden" name="newEmpType" id="empType" class="form-control"
                                value="{{ isset($staff) ? trim($staff->employee_type) : '' }}" />
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
                            <label for="step">Old Grade</label>
                            <select name='oldGrade' class="form-control">
                                <option value=""></option>
                                @for ($i = 1; $i <= 17; $i++)
                                    <option value="{{ $i }}"
                                        @if (old('oldGrade') == $i) selected @endif>{{ $i }}</option>
                                @endfor

                            </select>
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
                            <select name='oldStep' class="form-control">
                                <option value=""></option>
                                @for ($i = 1; $i <= 17; $i++)
                                    <option value="{{ $i }}"
                                        @if (old('oldStep') == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
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
                            <label for="vehicle">Arrears Type</label>
                            <select name='arrearsType' class="form-control">
                                <option value="">Select</option>
                                <option value="increment">increment</option>
                                <option value="advancement">advancement</option>
                                <option value="newAppointment">New Appointment</option>
                                <option value="advancement">Promotion</option>
                                <option value="advancement">Conversion</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vehicle">Due Date</label>
                            <input type="Text" name="dueDate" id="dueDate" class="form-control"
                                value="{{ old('dueDate') }}" readonly />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vehicle">OverDue Date</label>
                            <input type="Text" name="overdueDate" id="overdueDate" class="form-control"
                                value="{{ old('overdueDate') }}" readonly />
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
    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr bgcolor="#c7c7c7">
                    <th>S/N</th>
                    <th>Arrear Type</th>
                    <th>Old Grade</th>
                    <th>Old Step</th>
                    <th>New Grade</th>
                    <th>New Step</th>
                    <th>Due Date</th>
                    <th>Overdue Date</th>
                    <th>Period Process</th>

                    <th>Document</th>
                    <th>Action</th>
                </tr>
            </thead>
            @php $i = 1; @endphp
            <tbody>

                @foreach ($StaffOverdueArrear as $list)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $list->arrears_type }}</td>
                        <td>{{ $list->old_grade }}</td>
                        <td>{{ $list->old_step }}</td>
                        <td>{{ $list->new_grade }}</td>
                        <td>{{ $list->new_step }}</td>
                        <td>{{ $list->due_date }}</td>
                        <td>{{ $list->overdueDate }}</td>
                        <td>{{ $list->month_payment }} {{ $list->year_payment }}</td>

                        <td>
                            @if ($list->doc_url)
                                <a class="btn btn-info" href="{{ asset($list->doc_url) }}" target="_blank">View</a>
                            @endif
                        </td>

                        <td>
                            <div align="right">
                                <a onclick="return ConfirmDelete('{{ $list->ID }}')" title="Remove"
                                    class="btn btn-danger deleteBankList"> <i class="fa fa-trash"></i> </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        function ConfirmDelete(id) {

            var cmt = confirm('You are about to delete a record. Click OK to continue?');
            if (cmt == true) {
                document.getElementById('delid').value = id;
                document.getElementById('mainform').submit();
                return;
            }
        }



        function StaffSearchReload() {
            document.getElementById('fileNo').value = document.getElementById('userSearch').value;
            document.forms["mainform"].submit();
            //alert("jdjdjdeedd");
            return;
        }
    </script>

    <script type="text/javascript">
        $(function() {
            $("#overdueDate").datepicker({
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

            }); //

        });
    </script>
    {{-- ///////////////////////////////////// --}}
@endsection
