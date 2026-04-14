@extends('layouts.layout')

@section('pageTitle')
    File Movement
@endsection

<style type="text/css">
    .length {
        width: 80px;
    }

    .remove {
        padding-top: 12px;
        cursor: pointer;
    }
</style>

@section('content')

    <!-- view Files-->
    <div class="box box-default">
        <div class="box-body box-profile">

            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b><i class="fa fa-arrow-right"></i> <span id='processing'>
                        <strong><em>Track Location of files... </em></strong></h3>
            </div>

            <div class="row">
               

				<div class="col-md-12"><!--1st col-->
					@if (count($errors) > 0)
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
							<strong>Error!</strong>
							@foreach ($errors->all() as $error)
								<p>{{ $error }}</p>
							@endforeach
						</div>
					@endif

					@if(session('msg'))
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
								</button>
								<strong>Success!</strong>
								{{ session('msg') }}
							</div>
					@endif

					@if(session('err'))
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
							<strong>Not Allowed ! </strong>
							{{ session('err') }}
						</div>
					@endif

				</div>

                <form method="post" action="{{ url('/bulk-transfer/track') }}">
                    {{ csrf_field() }}
                    <div class="row" style="padding: 1px 12px; margin-bottom: 20px;">
                        <div class="col-md-12" style=" padding: 10px 15px;">

                            <div class="col-md-6" style="margin-bottom:10px;">
                                <!-- outer cover -->
                                <div class="card" style="border: 1px solid #888888; box-shadow: 5px 7px #888888;">
                                    <fieldset>
                                        <legend style="text-align: center;">Search by Date</legend>


                                        {{-- <h5 class="text-center">Search by Date</h5> --}}
                                        <div class="col-md-6" style="padding: 1px;">

                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="text" name="from" id="fromDate"
                                                    placeholder="Select Date" class="form-control"
                                                    value="{{ old('from') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6" style="font-size: 13px;">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="text" name="to" id="toDate"
                                                    placeholder="Select Date" class="form-control"
                                                    value="{{ old('to') }}">

                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                            </div><!-- ///outer cover -->


                            <div class="col-md-3" style="padding-left: 0px; margin-bottom:10px;">
                                <!-- outer cover -->
                                <div class="card" style="border: 1px solid #888888; box-shadow: 5px 7px #888888;">
                                    <fieldset>
                                        <legend style="text-align: center;">Search by Section</legend>

                                        <div class="col-md-12" style="font-size: 13px; padding: 0px;">
                                            <div class="form-group">
                                                <label>Section</label>
                                                <select name="section" id="dept" class="form-control"
                                                    style="font-size: 13px;">
                                                    <option value="">Select Section</option>
                                                    @foreach ($section as $list)
                                                        <option value="{{ $list->id }}">{{ $list->department }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <!--// outer cover -->

                            <div class="col-md-3" style="padding: 0px;">
                                <!-- outer cover -->
                                <div class="card" style="border: 1px solid #888888; box-shadow: 5px 7px #888888;">
                                    <fieldset>
                                        <legend style="text-align: center;">Search by File Number</legend>

                                        <div class="col-md-12" style="padding: 1px;font-size: 13px;font-weight: 100;">
                                            {{-- <div class="form-group">
                                                <label>File Number</label>
                                                <input type="text" name="staffNo" id="staffNo" class="form-control"
                                                    value="{{ old('staffNo') }}" style="font-size: 13px;" />
                                                <input type="hidden" name="fileNo" id="fileNo"
                                                    class="form-control input-lg" style="font-size: 13px;" />
                                            </div> --}}

                                                <div class="box-body">
                                                    <div class="form-group">
														<label>File Number</label>
                                                        <input id="autocomplete" name="q" class="form-control dos"
                                                            placeholder="File description/File No.">
                                                        <input type="hidden" id="nameID" name="nameID">
                                                    </div>
                                                </div>

                                        </div>
                                    </fieldset>
                                </div>


                            </div>
                            <!--/// outer cover -->


                        </div>

                        <div class="col-md-12">
                            <div class="form-group" style="padding-top: 26px; margin-top: 33px; text-align: center;">
                                {{-- <input type="submit" name="submit" id="fileNo" class="btn btn-default" value="Display" /> --}}
                                <button type="submit" name="submit" id="fileNo" class="btn btn-success">Search <i
                                        class="fa fa-search"></i> </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="box-header with-border hidden-print" style="text-align: center;">
                <h3 class="box-title"><b>Tracked Files</b> <span id='processing'></span></h3>
            </div>

            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                <thead>
                    <tr>

                        <th>FILE NO</th>
                        <th>NAME</th>
                        <th>FILE ORIGIN </th>
                        <th>LOCATION</th>
                        <th>RECIPIENT</th>
                        <th>VOLUME</th>
                        <th>DATE TRANSFERRED</th>
                        <th>LAST PAGE</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if ($transfered_files != '')
                        @foreach ($transfered_files as $list)
                            @php
                                $origin = DB::table('tbldepartment')
                                    ->where('id', '=', $list->origin_dept)
                                    ->first();
                                $user = DB::table('tblper')
                                    ->where('UserID', '=', $list->recipient)
                                    ->first();
                                $dest = DB::table('tbldepartment')
                                    ->where('id', '=', $list->destination)
                                    ->first();
                                $allcomments = DB::table('tbltracking_comments')
                                    ->join('users', 'users.id', '=', 'tbltracking_comments.comment_by')
                                    ->where('bulkID', '=', $list->bulkID)
                                    ->get();
                            @endphp
                            <tr>
                                <td>{{ $list->fileNo }} <input type="hidden" name="fileNo[]"
                                        value="{{ $list->fileNo }}">
                                </td>
                                <td>{{ $list->file_description }}</td>
                                <td>{{ $origin->department }}</td>
                                <td>{{ $dest->department }}</td>
                                <td>{{ $user->surname ?? '' }} {{ $user->first_name ?? '' }}</td>
                                <td>{{ $list->volume }}</td>
                                <td>{{ date('d-M-Y', strtotime($list->date_transfered)) }}</td>
                                <td>{{ $list->last_page }}</td>
                                {{-- <td>
                                    <a href="javascript:void" id="{{ $list->fileNo ?? '' }}"
                                        bulkID="{{ $list->bulkID ?? '' }}" reason="{{ $db->comment ?? '' }}"
                                        class="reason"> View Comment</a>
                                </td> --}}

                            </tr>
                            <div class="hiddenComment{{ $list->bulkID }}" style="display:none;">
                                @if ($allcomments != '')
                                    @foreach ($allcomments as $comm)
                                        <div class="minutes">
                                            <p><span><b>Minutes By: {{ $comm->name }}</span> | Date:
                                                {{ date('d-M-Y', strtotime(trim($comm->updated_at))) }}</b></p>
                                            <p>{{ $comm->comment }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @endif

                </tbody>
            </table>


        </div>
    </div>

    <!--// view Files -->

    <form action="" method="post">
        {{ csrf_field() }}
        <!-- Modal -->
        <div class="bs-example">
            <!-- Modal HTML -->
            <div id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content" style="padding: 10px; border-radius: 6px;">

                        <div class="box box-default">
                            <div class="box-body box-profile">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><b>Add New Next of Kin</b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="month">Full Name</label>
                                                <input type="text" name="fullName" id=""
                                                    class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="month">Relationship</label>
                                                <input type="text" name="relationship" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="month">Full Address</label>
                                                <textarea name="address" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="month">Phone Number</label>
                                                <input type="text" name="phoneNumber" class="form-control"
                                                    placeholder="Optional" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer-not-use" align="right">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                    class="fa fa-arrow-circle-left"></i> Close</button>
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    </div>

    <form action="" method="post">
        {{ csrf_field() }}
        <!-- Modal -->
        <div class="bs-example">
            <!-- Modal HTML -->
            <div id="reasonModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="box box-default">
                            <div class="box-body box-profile">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><b>Reason for rejecting staff file</b></h4>
                                </div>
                                <div class="modal-body">

                                    <div id="reason">

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="modal-footer-not-use" align="right">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                    class="fa fa-arrow-circle-left"></i> Close</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>


    <script type="text/javascript">
        $(function() {
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/profile/searchUser',
                minLength: 2,
                onSelect: function(suggestion) {

                    $('#nameID').val(suggestion.data);
                    var fileNo = suggestion.data;
                    //showAll();

                    //alert(fileNo);
                    $.ajax({

                        type: 'post',
                        url: murl + '/bulk-movement/get-staff',
                        data: {
                            'nameID': fileNo,
                            '_token': $('input[name=_token]').val()
                        },

                        success: function(datas) {
                            //console.log(datas);
                            $.each(datas, function(index, obj) {
                                console.log(obj.fileNo);
                                var tr = $("<tr></tr>");
                                tr.append("<td>" + obj.fileNo +
                                    " <input type='hidden' class='form-control length' style='width:80px;' name='fileNo[]' value='" +
                                    obj.fileNo + "'></td>");
                                tr.append("<td>" + obj.first_name + "</td>");
                                tr.append("<td>" + obj.surname + "</td>");
                                tr.append("<td>" + obj.othernames + "</td>");
                                tr.append("<td>" + obj.Designation + "</td>");
                                tr.append(
                                    "<td><input type='text' class='form-control length' style='width:80px;' name='volume[]'></td>"
                                );
                                tr.append(
                                    "<td><input type='text' class='form-control length' style='width:80px;' name='lastPage[]'></td>"
                                );
                                tr.append(
                                    "<td><i class='fa fa-close remove'></close></td>"
                                );
                                //tr.append("<td><select name='type' class='form-control'><option>Incoming</option><option>Outgoing</option></select></td>");
                                //tr.append("<td><input type='checkbox' name='check'></td>");

                                $("#servicedetail").append(tr);
                            });
                        }

                    });


                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#servicedetail").on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("table tr td .confirm").on('click', function() {
                //alert("ok");
                //var id=$(this).parent().parent().find("input:eq(0)").val();
                var id = $(this).attr('id');
                //alert(id);
                //var value = $(this).attr('value');
                // alert(id);
                $token = $("input[name='_token']").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $token
                    },
                    url: "{{ url('/bulk-movement/confirmation') }}",

                    type: "post",
                    data: {
                        'fileNo': id
                    },
                    success: function(data) {
                        alert(data);
                        $('#message').html(data);
                        location.reload(true);
                    }
                });

            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/bulk-movement/searchUser',
                minLength: 2,
                onSelect: function(suggestion) {

                    $('#nameID').val(suggestion.data);
                    var fileNo = suggestion.data;
                    //showAll();
                    var tableID = 'servicedetail';



                    //retrieve records from db
                    $.ajax({

                        type: 'post',
                        url: murl + '/bulk-movement/get-staff',
                        data: {
                            'nameID': fileNo,
                            '_token': $('input[name=_token]').val()
                        },

                        success: function(datas) {
                            // location.reload(true);
                            //console.log(datas);


                        }

                    });


                } // end on select

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#servicedetail").on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

        });

        $(document).ready(function() {
            $('.reason').click(function() {
                var reason = $(this).attr('reason');
                var bulkID = $(this).attr('bulkID');
                var reasons = $('.hiddenComment' + bulkID).html();
                console.log(reasons);
                $("#reason").html(reasons);


                $('#reasonModal').modal('show');
            });
        });
    </script>

    <script type="text/javascript">
        //select all checkboxes
        $("#select_all").change(function() { //"select all" change
            var status = this.checked; // "select all" checked status
            $('.checkbox').each(function() { //iterate all listed checkbox items
                this.checked = status; //change ".checkbox" checked status
            });
        });

        $('.checkbox').change(function() { //".checkbox" change
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (this.checked == false) { //if this item is unchecked
                $("#select_all")[0].checked = false; //change "select all" checked status to false
            }

            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $("#select_all")[0].checked = true; //change "select all" checked status to true
            }
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("#servicedetail").on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

        });



        (function() {
            $('#destination').change(function() {
                //$('#processing').text('Processing. Please wait...');
                $.ajax({
                    url: murl + '/bulk-movement/getUsers',
                    type: "post",
                    data: {
                        'sectionID': $('#destination').val(),
                        '_token': $('input[name=_token]').val()
                    },

                    success: function(data) {
                        $('#recipient').empty();
                        $('#recipient').append('<option value="">Select One</option>');
                        $.each(data, function(index, obj) {
                            $('#recipient').append('<option value="' + obj.id + '">' + obj
                                .name + '</option>');
                        });

                    }
                })
            });
        })();
    </script>

    <script type="text/javascript">
        $(function() {
            $("#toDate").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd-mm-yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
                    $("#toDate").val(dateFormatted);
                },
            });

        });

        $(function() {
            $("#fromDate").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd-mm-yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
                    $("#fromDate").val(dateFormatted);
                },
            });

        });
    </script>
@endsection
