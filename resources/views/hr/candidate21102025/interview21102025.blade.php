@extends('layouts.layout')
@section('pageTitle')
    <strong>New Appointment</strong>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>Initiate Interview For New Candidate.</em></strong></span></h3>
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

        <form method="post" action="{{ route('saveInterview') }}" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">

                <div id="divIDx" style="margin-left:10px; margin-right:10px">
                    <div class="form-group">

                        <div class="row mb-3" style="margin-left: 10px">
                            <div class="col-lg-6">
                                <label>Title:</label>
                                <input class="form-control" name="title" id="title" type="text" value="" required>
                            </div>

                            <div class="col-lg-6">
                                <label>Date:</label>
                                <input class="form-control" name="date" id="date" type="date" value="" required
                                    placeholder="dd-mm-yyyy">
                            </div>
                            {{-- <div class="col-lg-3">
                                <label>Attach Memo:</label>
                                <input name="memo" class="form-control" id="memo" type="file">
                            </div> --}}
                        </div>

                        {{-- <div class="row" style="margin-top: 30px; margin-left: 10px;">
                            <div class="col-md-6 desc-clone">
                                <label>Document Description:</label>
                                <input class="form-control" name="description[]" id="sayo-increment description"
                                    type="text" value="" required>
                            </div>

                            <div class="col-md-6">
                                <label>Interview documents:</label>
                                <div class="input-group hdtuto control-group lst increment" id="sayo-increment">
                                    <input type="file" name="filenames[]" class="myfrm form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-success modal-sayo-add" type="button"><i
                                                class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                                    </div>
                                </div>
                                <div class="sayo-clone hide" id="sayo-clone">
                                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                        <input type="file" name="filenames[]" class="myfrm form-control">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger modal-sayo-remove" type="button"><i
                                                    class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> --}}


                        <div style="margin-top: 30px; margin-left: 15px;">
                            <div class="form-group fieldGroup">

                                <div class="col-md-6">
                                    <label>Document Description:</label>
                                    <input type="text" name="description[]" required class="form-control" />
                                </div>

                                <div class="col-md-6">
                                    <label>Interview Documents | Memo:</label>
                                    <div class="input-group">
                                        <input type="file" name="filenames[]" class="form-control" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success addMore"><span
                                                    class="fldemo glyphicon glyphicon glyphicon-plus"
                                                    aria-hidden="true"></span>
                                                Add</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-2" style="margin-top:22px;">
                            <button type="submit" class="btn btn-success" name="Save">
                                <i class="fa fa-btn fa-floppy-o"></i> Save
                            </button>
                        </div>

                    </div>

                </div>

        </form>

        <!-- copy of input fields group -->
        <div class="form-group fieldGroupCopy" style="display: none;">
            <div class="col-md-6">
                <label>Document Description:</label>
                <input type="text" name="description[]" class="form-control" />
            </div>

            <div class="col-md-6">
                <label>Interview Documents:</label>
                <div class="input-group">
                    <input type="file" name="filenames[]" class="form-control" />
                    <div class="input-group-btn">
                        <button class="btn btn-danger remove"><span
                                class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end copy  --}}

        <div class="table-responsive" style="font-size: 12px; padding:10px;">
            <table class="table table-bordered table-striped table-highlight table-responsive">
                <thead>
                    <tr bgcolor="#c7c7c7">
                        <th width="1%">S/N</th>
                        <th>TITLE</th>
                        <th>SCHEDULE DATE</th> {{-- new --}}
                        <th>STATUS</th>
                        <th>VIEW</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                @php $serialNum = 1; @endphp

                @foreach ($interviewDetails as $b)
                    <tr>
                        <td>{{ $serialNum++ }} </td>

                        <td>{{ $b->title }} </td>
                        <td>{{ date('d-M-Y', strtotime($b->date)) }}</td>
                        <td>
                            @if ($b->interview_status == 0)
                                <span class="badge badge-info"> Closed</span>
                            @elseif($b->interview_status == 1)
                                <span class="badge badge-success">In Progres</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('viewInterviewAndEdit', $b->interviewID) }}"
                                class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i> </a>
                        </td>
                        <td>
                            @if ($b->close_candidate == 0 && $b->interview_status == 1)

                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmEnable{{$b->interviewID}}"><i class="fa fa-btn fa-stop"></i> Enable Candidate  Entry</button>

                                <!-- Modal to disable -->
                                <div class="modal fade text-left d-print-none" id="confirmEnable{{$b->interviewID}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-success text-center"> <h4>Are you sure you want to Enable Candidate Entry For: {{$b->title}}? </h4></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                <a href="{{url('open-names-entering/'.$b->interviewID)}}" class="btn btn-info"> Enable </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end Modal-->

                            @elseif($b->close_candidate == 1 && $b->interview_status == 0)



                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmDisable{{$b->interviewID}}"><i class="fa fa-btn fa-stop"></i> Disable Candidate  Entry</button>

                                    <!-- Modal to disable -->
                                    <div class="modal fade text-left d-print-none" id="confirmDisable{{$b->interviewID}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-success text-center"> <h4>Are you sure you want to Disable Candidate Entry For: {{$b->title}}? </h4></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{url('close-names-entering/'.$b->interviewID)}}" class="btn btn-danger"> Disable </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->

                            @endif

                            @if ($b->interview_status == 1 && $b->close_candidate == 1)
                                <a href="add-candidates/{{ $b->interviewID }}"><span class="btn btn-success btn-sm"
                                    style="margin-bottom: 3px;"> <i class="fa fa-btn fa-plus"></i> Add
                                        Candidates</span></a>

                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmDisable{{$b->interviewID}}"><i class="fa fa-btn fa-stop"></i> Disable Candidate  Entry</button>

                                        <!-- Modal to disable -->
                                        <div class="modal fade text-left d-print-none" id="confirmDisable{{$b->interviewID}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-success text-center"> <h4>Are you sure you want to Disable Candidate Entry For: {{$b->title}}? </h4></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                        <a href="{{url('close-names-entering/'.$b->interviewID)}}" class="btn btn-danger"> Disable </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->

                            @endif

                                @if ($b->interview_status == 0 && $b->close_candidate == 0)

                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmOpen{{$b->interviewID}}"><i class="fa fa-btn fa-stop"></i> Open Interview</button>

                                    <!-- Modal to disable -->
                                    <div class="modal fade text-left d-print-none" id="confirmOpen{{$b->interviewID}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-success text-center"> <h4>Are you sure you want to Open: {{$b->title}}? </h4></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{url('open-interview/'.$b->interviewID)}}" class="btn btn-info"> Open </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->

                                    <a href="{{ route('candidates.interview', ['id' => $b->interviewID]) }}"
                                        class="btn btn-primary btn-sm" style="margin-bottom: 3px;">View Candidates</a>
                                @else
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmClose{{$b->interviewID}}"><i class="fa fa-btn fa-stop"></i> Close Interview</button>

                                    <!-- Modal to disable -->
                                    <div class="modal fade text-left d-print-none" id="confirmClose{{$b->interviewID}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-success text-center"> <h4>Are you sure you want to Close Interview: {{$b->title}}? </h4></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{url('close-interview/'.$b->interviewID)}}" class="btn btn-danger"> Close </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->

                                @endif

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

    <script>
        CKEDITOR.replace('editor');
    </script>

    {{-- for multiple images --}}
    <script type="text/javascript">
        $(document).ready(function() {

            //new input fields group add limit
            var maxGroup = 10;

            //add more fields group
            $(".addMore").click(function() {
                if ($('body').find('.fieldGroup').length < maxGroup) {
                    var fieldHTML = '<div class="form-group fieldGroup">' + $(".fieldGroupCopy").html() +
                        '</div>';
                    $('body').find('.fieldGroup:last').after(fieldHTML);
                } else {
                    alert('Maximum ' + maxGroup + ' groups are allowed.');
                }
            });

            //remove fields group
            $("body").on("click", ".remove", function() {
                $(this).parents(".fieldGroup").remove();
            });



            //datepickr JS
            $("#date").flatpickr({
                dateFormat: "d-m-Y",
            });

        });
    </script>
    {{-- end for multiple images --}}


    {{-- check if code below is still usefull and delete --}}
    {{-- <script type="text/javascript">
        function funcClose(x) {

            //alert('sss');
            var y = confirm('                              You are just about to close entering names');
            if (y == true) {
                document.location = "close-names-entering/" + x;
            }

        }

        function funcOpen(x) {

            //alert('sss');
            var y = confirm('                              You are just about to open entering names');
            if (y == true) {
                document.location = "open-names-entering/" + x;
            }

        }

        function funcPush(x) {

            //alert('sss');
            var y = confirm('                              You are just about to submit to the HOD');
            if (y == true) {
                document.location = "push-to-hod/" + x;
            }

        }

        function funcInterviewClose(x) {

            //alert('sss');
            var y = confirm('                              You are just about to close this interview');
            if (y == true) {
                document.location = "close-interview/" + x;
            }

        }

        function funcInterviewOpen(x) {

            //alert('sss');
            var y = confirm('                              You are just about to open this interview');
            if (y == true) {
                document.location = "open-interview/" + x;
            }

        }

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
    </script> --}}
@endsection
