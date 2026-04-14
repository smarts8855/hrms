@extends('layouts.layout')
@section('pageTitle')
    Successful Candidates
@endsection

@section('content')
    <!-- Page Header -->
    @include('hr.partials.page-header')
    <!-- End Page Header -->
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>


        @if (session('message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span> </button>
                <strong>Successful!</strong> {{ session('message') }}
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span> </button>
                <strong>Error!</strong> {{ session('error_message') }}
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

        <form method="post" action="">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">

                    <div class="col-lg-7">
                        <label>Search Staff:</label>
                        <select name="search" class="form-control searching" id="searching" required>
                            <option value="">Select</option>
                            @foreach ($newEmployees as $list)
                                <option value="{{ $list->candidateID }}">{{ $list->surname }} {{ $list->first_name }}
                                    {{ $list->othernames }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-lg-5" style="margin-top:22px;">
                        <button type="submit" class="btn btn-success" name="Save">
                            <i class="fa fa-btn fa-search"></i> Search
                        </button>
                    </div>

                </div>
            </div>
        </form>

        <div class="table-responsive" style="font-size: 12px; padding:10px;">
            <table class="table table-bordered table-striped table-highlight">
                <thead>
                    <tr bgcolor="#c7c7c7">
                        <th width="1%">S/N</th>
                        <th>FULLNAME</th>
                        <th>SEX</th>
                        <th>ADDRESS</th>
                        <th>STATE</th>
                        <th>LGA</th>
                        <th>CANDIDACY</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                @php $serialNum = 1; @endphp

                @foreach ($candidateDetails as $b)
                    <tr>
                        <td>{{ $serialNum++ }}</td>
                        <td>{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames }} <br>{{$b->email}}</td>
                        <td>{{ $b->sex }}</td>
                        <td>{{ $b->address }}</td>
                        <td>{{ $b->State }}</td>
                        <td>{{ $b->lga }}</td>
                        <td>{{ $b->candidate_source }}</td>
                        <td>
                            <a href="documentation/{{ $b->candidateID }}" target="_blank"><span class="btn btn-primary"> <i
                                        class="fa fa-file"></i> Staff Documentation</span></a>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>

    </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>

    <script type="text/javascript">
        function funcPush(x) {

            //alert('sss');
            var y = confirm('                              You are just about to submit to the HOD');
            if (y == true) {
                document.location = "push-to-hod/" + x;
            }

        }

        $(document).ready(function() {

            $("#leaveType").change(function(e) {

                var x = document.getElementById("divID");
                var z = document.getElementById('divIDs')
                var y = document.getElementById("divIDx");
                var t = document.getElementById("leave_type");
                var s = document.getElementById("leave_typex");

                var recordid = e.target.value;
                //alert(recordid);

                if (recordid == 4) {

                    $.get('check-roaster?id=' + recordid, function(data) {

                        if (data == true) {

                            x.style.display = "block";
                            y.style.display = "none";
                            t.style.display = "block";
                            s.style.display = "none";

                        } else {

                            x.style.display = "none";
                            z.style.display = "block";
                            y.style.display = "none";
                            t.style.display = "none";
                            s.style.display = "none";
                        }

                    });

                    document.getElementById("startdate").required = true;
                    document.getElementById("enddate").required = true;
                    document.getElementById("nokx").required = true;

                    document.getElementById("startdatex").required = false;
                    document.getElementById("enddatex").required = false;
                    document.getElementById("nok").required = false;

                } else if (recordid == 3) {

                    $.get('check-roaster?id=' + recordid, function(data) {

                        $('#tnod').empty();
                        $('#rnod').empty();
                        $('#dnod').empty();
                        $.each(data, function(index, obj) {
                            $('#tnod').append('<option value="">' + data.allowableDays +
                                '</option>');
                            $('#rnod').append('<option value="">' + data.daysRemaining +
                                '</option>');
                            $('#dnod').append('<option value="">' + data.daysConsumed +
                                '</option>');

                            document.getElementById("startdatex").required = true;
                            document.getElementById("enddatex").required = true;
                            document.getElementById("nok").required = true;

                            document.getElementById("startdate").required = false;
                            document.getElementById("enddate").required = false;
                            document.getElementById("nokx").required = false;

                        });
                    });

                    x.style.display = "none";
                    z.style.display = "none";
                    y.style.display = "block";
                    t.style.display = "block";
                    s.style.display = "none";

                } else if (recordid == 2) {

                    $.get('check-roaster?id=' + recordid, function(data) {

                        $('#tnod').empty();
                        $('#rnod').empty();
                        $('#dnod').empty();
                        $.each(data, function(index, obj) {
                            $('#tnod').append('<option value="">' + data.allowableDays +
                                '</option>');
                            $('#rnod').append('<option value="">' + data.daysRemaining +
                                '</option>');
                            $('#dnod').append('<option value="">' + data.daysConsumed +
                                '</option>');

                            document.getElementById("startdatex").required = true;
                            document.getElementById("enddatex").required = true;
                            document.getElementById("nok").required = true;

                            document.getElementById("startdate").required = false;
                            document.getElementById("enddate").required = false;
                            document.getElementById("nokx").required = false;

                        });
                    });

                    x.style.display = "none";
                    z.style.display = "none";
                    y.style.display = "block";
                    t.style.display = "block";
                    s.style.display = "none";

                } else if (recordid == 1) {

                    $.get('check-roaster?id=' + recordid, function(data) {

                        $('#tnod').empty();
                        $('#rnod').empty();
                        $('#dnod').empty();
                        $.each(data, function(index, obj) {
                            $('#tnod').append('<option value="">' + data.allowableDays +
                                '</option>');
                            $('#rnod').append('<option value="">' + data.daysRemaining +
                                '</option>');
                            $('#dnod').append('<option value="">' + data.daysConsumed +
                                '</option>');

                            document.getElementById("startdatex").required = true;
                            document.getElementById("enddatex").required = true;
                            document.getElementById("nok").required = true;

                            document.getElementById("startdate").required = false;
                            document.getElementById("enddate").required = false;
                            document.getElementById("nokx").required = false;

                        });
                    });

                    x.style.display = "none";
                    z.style.display = "none";
                    y.style.display = "block";
                    t.style.display = "block";
                    s.style.display = "none";

                }

            })
        });
        //});

        function ReloadForm() {
            //alert("ururu")	;
            document.getElementById('thisform').submit();
            return;
        }

        function ReloadFormx() {
            //alert("ururu")	;
            document.getElementById('thisformx').submit();
            return;
        }

        function DeletePromo(id) {
            var cmt = confirm('You are about to delete a record. Click OK to continue?');
            if (cmt == true) {
                document.getElementById('delcode').value = id;
                document.getElementById('thisform').submit();
                return;

            }

        }

        function View(id) {
            document.getElementById('viewid').value = id;
            document.getElementById('viewnewid').value = 1;
            document.getElementById('thisform').submit();
            return;



        }
        $(function() {
            $("#startdate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#enddate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#startdatex").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#enddatex").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#approvedate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#appointmentDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#incrementalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
            $("#firstArrivalDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.searching').select2();
        })
    </script>
@endsection
