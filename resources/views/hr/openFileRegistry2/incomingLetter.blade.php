@extends('layouts.layout')

@section('pageTitle')
    Registry
@endsection
<style type="text/css">
    .table {

        overflow-x: auto;
    }
</style>
@section('content')
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>Mail.</em></strong></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--1st col-->
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Success!</strong> {{ session('msg') }}
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Not Allowed ! </strong> {{ session('err') }}
                            </div>
                        @endif
                    </div>
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <!--2nd col-->
                        @if ($userDepartment == 2)
                            <!-- /.row -->
                            <form method="post" action="{{ url('/open-file-registry/saveletter') }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="month">Name of Recipient</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ $loggedInUserName->first_name . ' ' . $loggedInUserName->surname }}"
                                                readonly />

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="month">Name Of Sender</label>
                                            <input type="text" name="sender" id="sender" class="form-control"
                                                value="{{ old('sender') }}" />
                                            <!--<label for="month">Division</label>
                                  <select name="division" id="division" class="form-control">
                                    <option value="">Select Division</option>
                                  @foreach ($division as $list)
    <option value="{{ $list->divisionID }}">{{ $list->division }}</option>
    @endforeach
                                  </select>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 6px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="month">Date Recieved</label>
                                            <input type="date" name="dateR" id="date" class="form-control"
                                                value="{{ old('date') }}" />

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="month">Time In</label>
                                            <input type="time" name="timeIn" id="timeIn" class="form-control"
                                                value="{{ old('timeIn') }}" />

                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <label for="month">Remind me in</label>
                                        <div class="input-group form-group">

                                            <input type="number" name="notification" id="notification"
                                                class=" form-control" value="{{ old('notification') }}" required />
                                            <span class="input-group-addon">Days</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="month">Subject Matter</label>
                                            <textarea class="form-control" name="detail" id="detail"> {{ old('detail') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="month">Organization Name</label>
                                            <textarea class="form-control" name="organization" id="organization"> {{ old('organization') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{-- <label for="month">Keep In View|Bring Up</label> --}}
                                            {{-- <input type="text" name="kiv" id="kiv" class="date form-control"
                                                value="{{ old('kiv') }}" /> --}}

                                            {{-- <label for="kiv">Keep In View</label> --}}
                                            {{-- kiv : keep in view --}}
                                            {{-- <input type="radio" name="kiv" id="kiv" value="0" required> --}}

                                            {{-- <label for="pending">Pending</label> --}}
                                            {{-- <input type="radio" name="kiv" id="pending" value="0" required> --}}

                                            {{-- <label for="bu">Bring Up</label> --}}
                                            {{-- bu : bring up --}}
                                            {{-- <input type="radio" name="kiv" id="bu" class="date" required> --}}

                                            <label for="mail_status">Mail Status</label>
                                            <select name="kiv" id="mail_status" class="form-control" required>
                                                <option selected disabled>Pick Status</option>
                                                <option value="Keep In View">Keep In View</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Bring Up">Bring Up</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                {{-- files accept plenty --}}
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="input-group hdtuto control-group lst increment" id="increment">
                                            <input type="file" name="filenames[]" class="myfrm ">
                                            <div class="input-group-btn">
                                                <button class="btn btn-success sayo-add" type="button"><i
                                                        class="fldemo glyphicon glyphicon-plus"></i>Add</button>
                                            </div>
                                        </div>
                                        <div class="clone hide">
                                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                                <input type="file" name="filenames[]" class="myfrm">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-danger sayo-remove" type="button"><i
                                                            class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div align="left" class="form-group">
                                                <label for="month">&nbsp;</label>
                                                <br />
                                                <a href="#" title="Back to profile" class="btn btn-warning"><i
                                                        class="fa fa-arrow-circle-left"></i> Back </a>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div align="right" class="form-group">
                                                <label for="month">&nbsp;</label>
                                                <br />
                                                <button name="action" class="btn btn-success" type="submit"> Add Mail
                                                    <i class="fa fa-save"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr />
                        @endif
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <table class="table table-striped table-condensed table-bordered">
                    <thead>
                        <th>S/N</th>
                        {{-- <th>FULL NAME</th> --}}
                        <th>SENT BY</th>
                        <th>DETAILS</th>
                        <th>DEPARTMENT MOVED</th>
                        <th>DATE RECIEVED</th>
                        <th>DATE SENT</th>
                        <!-- <th>Time Recieved</th>
                            <th>Time Sent</th> -->
                        <th>ORGANIZATION</th>
                        <th>STATUS</th>
                        <th></th>
                    </thead>
                    <tbody>

                        @php $key = 1; @endphp
                        @foreach ($details as $list)
                            <tr>
                                <td>{{ $key++ }}</td>
                                {{-- <td>{{ $list->fullname }}</td> --}}
                                <td>{{ $list->sender }}</td>
                                <td>{{ $list->details }}</td>
                                <td>{{ $list->departmentName }}</td>
                                <td>{{ date('d F, Y', strtotime($list->date_recieved)) }}</td>
                                <td>
                                    @if ($list->dateOut == null)
                                    @else
                                        {{ date('d F, Y', strtotime($list->dateOut)) }}
                                    @endif
                                </td>
                                <!-- <td>{{ date('h:i:sA', strtotime($list->timeIn)) }}</td>
                            <td>{{ date('h:i:sA', strtotime($list->timeOut)) }}</td> -->
                                <td>{{ $list->organization }}</td>
                                <td style="color: blue;">
                                    {{-- @if ($list->kiv_status === '0' || $list->kiv_status == null)
                                        <p class="blink text-danger">Please Treat!!!</p>
                                    @else
                                        {{ $list->kiv_status }}
                                    @endif --}}

                                    @if (date('d-M-Y', time()) >= $list->reminder_date)
                                        <p class="blink text-danger">Please Treat!!!</p>
                                    @else
                                        {{ $list->kiv_status }}
                                    @endif
                                </td>
                                <td>
                                    @if ($list->departmentID == $userDepartment)
                                        <a href="javascript:void()" class="edit" sender="{{ $list->sender }}"
                                            kiv="{{ $list->kiv }}" notification="{{ $list->notification }}"
                                            notification="{{ $list->notification }}" detail="{{ $list->details }}"
                                            recipientFirstname="{{ $loggedInUserName->first_name }}"
                                            recipientSurname="{{ $loggedInUserName->surname }}"
                                            recievedDate="{{ date('d-M-Y', strtotime(trim($list->date_recieved))) }}"
                                            id="{{ $list->Id }}"
                                            toDate="{{ date('d-M-Y', strtotime(trim($list->dateOut))) }}"
                                            timeIn="{{ date('H:i:s', strtotime(trim($list->timeIn))) }}"
                                            timeOut="{{ date('H:i:s', strtotime(trim($list->timeOut))) }}"
                                            organization="{{ $list->organization }}"
                                            attachments="{{ $list->attachments }}"
                                            kiv_status="{{ $list->kiv_status }}">Edit</a>

                                        |
                                        <a href="javascript:void()" data-toggle="modal" data-target="#moveModal"
                                            class="move" id="{{ $list->Id }}"
                                            timeOut="{{ date('H:i:s', strtotime(trim($list->timeOut))) }}"
                                            toDate="{{ date('d-M-Y', strtotime(trim($list->dateOut))) }}">Move | </a>


                                        <a href="javascript:void()" data-toggle="modal" data-target="#attachModal"
                                            class="attach" id="{{ $list->Id }}">Attach To File</a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="">{{ $details->links() }}</div>
            </div>
        </div>

    </div>
    </div>


    {{-- MODEL FOR MOVING --}}
    <form method="post" action="{{ url('/move/incoming-letter') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="moveModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Move To Unit</h4>
                        <p id="message"></p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id" id="itemIDs" />
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">Date Sent</label>
                                    <input type="text" name="dateOuts" id="dateOuted" class="form-control date"
                                        required />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">Time Out</label>
                                    <input type="time" name="timeOuts" id="timeOuts" class="form-control"
                                        required />

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">Department</label>
                                    <select class="form-control" name="departments" id="departments" required>
                                        <option value="0">Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">Designation</label>
                                    <select class="form-control" name="designation" id="designation" required>
                                        <option value="0">--Select Designation--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="moveRecipient">Select Recipient</label>
                                    <select name="moveRecipient" id="moveRecipient" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" name="comment" id="comment" required></textarea>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- MOVE MODEL ENDING --}}


    {{-- ATTACH TO FILE MODEL --}}
    <form method="post" action="{{ url('/attach/incoming-letter') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="attachModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Attach To Files</h4>
                        <p id="message"></p>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="month">File</label>
                                    <select class="form-control select2 col-md-12" name="file" id="fileD">
                                        <option value="">-- Select File --</option>
                                        @foreach ($files as $file)
                                            <option value="{{ $file->ID }}">{{ $file->file_description }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="month">Description</label>
                                    <input type="text" name="description" id="description" class="form-control">

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="comment">Attachment</label>
                                    <input type="file" class="form-control" name="attachment"
                                        id="attachment"></textarea>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Attach To Files</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- ATTACH TO FILE MODEL ENDING --}}



    <!-- Edit Model-->

    <form method="post" action="{{ url('/update/incoming-letter') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="editModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div style="width: 100%; height: 70%; overflow: scroll">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"></h4>
                            <p id="message"></p>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Names of Recipient</label>
                                        <input type="text" name="name" id="owner" class="form-control" readonly />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="month">Name Of Sender</label>
                                        <input type="text" name="sender" id="senders" class="form-control" />
                                        <input type="hidden" name="id" id="itemID" />
                                        <!--<label for="month">Division</label>
                                    <select name="division" id="division" class="form-control">
                                        <option value="">Select Division</option>
                                        @foreach ($division as $list)
                                        <option value="{{ $list->divisionID }}">{{ $list->division }}</option>
                                        @endforeach
                                    </select>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 6px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Date Recieved</label>
                                        <input type="text" name="date" id="dateRecieved" class="form-control date" />

                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Date Sent</label>
                                        <input type="text" name="dateOuts" id="dateOuteds" class="form-control date" />

                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Time In</label>
                                        <input type="time" name="timeIns" id="timeIns" class="form-control" />

                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Time Out</label>
                                        <input type="time" name="timeOuts" id="timeOutss" class="form-control" />

                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Remind me in</label>
                                        <input type="number" name="notification" id="notifications"
                                            class="date form-control" value="{{ old('notification') }}" />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Subject Matter</label>
                                        <textarea class="form-control" name="detail" id="details"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Organization</label>
                                        <textarea class="form-control" name="organizations" id="organizations"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mail_status">Mail Status</label>
                                        <select name="kiv" id="mail_status2" class="form-control" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                            </div>

                            <div class="row">
                                <div style="text-align: center;">**Attachments**</div>
                                    <div style="height: 95px" id="attachments">
                                        <h4>Attachment</h4>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- //// Edit Model ENDING-->
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .select2 {
            width: 30vw !important;
        }

        .blink {
            animation: blinker 0.6s linear infinite;
            /* color: #1c87c9; */
            font-size: 13px;
            font-weight: bold;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .input-group-btn {}

        #kiv {
            position: relative;
            z-index: 2;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/datepicker_scripts.js') }}"></script>

    <script>
        $(document).ready(function() {

            $("#departments").change(function() {
                var deptid = $(this).val();

                $('#designation').find('option').not(':first').remove();

                //Retriving data and populating the designation drop down
                $.ajax({
                    url: '/move/departments/' + deptid,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response.data != null) {
                            len = response.data.length;
                        }

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                var id = response.data[i].id;
                                var name = response.data[i].designation;


                                var option = "<option value='" + name + "' >" + name +
                                    "</option>";

                                $("#designation").append(option);
                            }
                        }
                    }
                });


                //Retriving data and populating the recipients drop down
                $.ajax({
                    type: "GET",
                    url: "/move/recipients/" + deptid,
                    dataType: "json",
                    success: function (response) {

                        $("#moveRecipient option").remove();  //clears the recipients drop down for new data

                        var len = 0;
                        if (response != null) {
                            len = response.length;
                        }

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                var id = response[i].id;
                                var firstname = response[i].first_name;
                                var surname = response[i].surname;
                                var othername = response[i].othernames;

                                var recipient = firstname + ' ' + surname + ' ' + othername;

                                var option = "<option value='" + response[i].ID + "' >" + recipient +
                                    "</option>";

                                $("#moveRecipient").append(option);
                            }
                        }

                    }
                });
            });

            // $("#designation").change(function () {
            //     var departmentId = $("#departments").val();
            //     var designationName = $(this).val();

            //     $.ajax({
            //             type: "GET",
            //             url: "/move/recipients/"  + designationName + "/" + departmentId,
            //             dataType: "JSON",
            //             success: function (response) {
            //                 console.log(response)
            //             },
            //             error: function (response) {
            //                 console.log(response)
            //             }
            //     });

            // });


        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('#searchName').attr("disabled", true);
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/open-file-registry/searchincoming',
                minLength: 2,
                onSelect: function(suggestion) {
                    $('#ownername').val(suggestion.data);
                    $('#searchName').attr("disabled", false);
                    //showAll();
                }
            });
        });
    </script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script type="text/javascript">
        $(function() {
            $(".date").datepicker({
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
                    $("#dte").val(dateFormatted);
                },
            });

        });
    </script>

    <script>
        $(document).ready(function() {


            $("table tr td .edit").click(function() {

                var sender = $(this).attr('sender');
                var attachments = JSON.parse($(this).attr('attachments'));

                var recieveddate = $(this).attr('recievedDate');
                var staffid = $(this).attr('staffid');
                var detail = $(this).attr('detail');

                var recipientFirstname = $(this).attr('recipientFirstname');
                var recipientSurname = $(this).attr('recipientSurname');
                var recipientFullname = recipientFirstname + ' ' + recipientSurname;

                var kiv = $(this).attr('kiv');
                var notifications = $(this).attr('notification');

                var owner = $(this).attr('owner');
                var id = $(this).attr('id');
                var organization = $(this).attr('organization');

                var timeOut = $(this).attr('timeOut');
                var timeIn = $(this).attr('timeIn');
                var dateOut = $(this).attr('toDate');

                var kiv_status = $(this).attr('kiv_status');

                $("#editModal").modal('show');

                $("#senders").val(sender);
                $("#owner").val(recipientFullname);
                $("#kivs").val(kiv);
                $("#notifications").val(notifications);
                $("#details").val(detail);
                $("#dateRecieved").val(recieveddate);
                var location = "{{ asset('/mailattachmentfiles/') }}";


                $('#attachments').empty();
                $("#timeOutss").val(timeOut);
                $("#timeIns").val(timeIn);
                $("#organizations").val(organization);
                $("#itemID").val(id);


                //******************* Mail Status Select Options For the Edit Model*****************\\

                if (kiv_status == 'Keep In View') {
                    var options = "<option  selected value='Keep In View' >Keep In View</option>" +
                        "<option value='Pending' >Pending</option>" +
                        "<option value='Bring Up' >Bring Up</option>";
                } else if (kiv_status == 'Pending') {
                    var options = "<option  selected value='Pending' >Pending</option>" +
                        "<option value='Keep In View' >Keep In View</option>" +
                        "<option value='Bring Up' >Bring Up</option>";
                } else if (kiv_status == 'Bring Up') {
                    var options = "<option  selected value='Bring Up' >Bring Up</option>" +
                        "<option value='Pending' >Pending</option>" +
                        "<option value='Keep In View' >Keep In View</option>";
                }

                if ($("#mail_status2 option").length == 0) {
                    $("#mail_status2").append(options);
                } else if ($("#mail_status2 option").length !== 0) {
                    $("#mail_status2 option").remove(); //emptying the edit mail status select options
                    $("#mail_status2").append(options); //appending option tag to the select tag
                }

                //**********************************************ENDING*******************************\\

                for (var i = 0; i <= attachments.length; i++) {
                    var numero = attachments[i].attachmentID

                    var removelocation = "{{ route('removeAttachment', '') }}"
                    removelocation = removelocation + "/" + numero

                    var fileExt = attachments[i].location.split('.').pop(); //getting the file extension

                    if(fileExt == 'pdf' || fileExt == 'txt' || fileExt == 'xslx' || fileExt == 'docx'){
                        $("#attachments").append("<div class='col-md-12'><iframe width='100%' src='" + location +
                        "/" + attachments[i].location + "'></iframe><a href='" + removelocation +
                        "'>Remove</a></div>");
                    } else {
                        $("#attachments").append("<div class='col-md-12'><img width='100%' src='" + location +
                        "/" + attachments[i].location + "'/><a href='" + removelocation +
                        "'>Remove</a></div>");
                    }

                };

            });


            $("table tr td .move").click(function() {
                var id = $(this).attr('id');


                var timeOut = $(this).attr('timeOut');
                var dateOut = $(this).attr('toDate');


                $("#timeOuts").val(timeOut);
                $("#itemIDs").val(id);


            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".sayo-add").click(function() {
                var lsthmtl = $(".clone").html();
                $("#increment").after(lsthmtl);
            });
            $("body").on("click", ".sayo-remove", function() {

                var father = $(this).closest(".hdtuto").remove()

            });

            $(".modal-sayo-add").click(function() {
                var lsthmtl = $(".sayo-clone").html();
                $("#sayo-increment").after(lsthmtl);
            });
            $("body").on("click", ".modal-sayo-remove", function() {
                console.log('here')
                $(this).closest(".hdtuto").remove();
            });
        });
    </script>
@endsection
