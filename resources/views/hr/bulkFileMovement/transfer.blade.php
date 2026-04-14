@extends('layouts.layout')

@section('pageTitle')
    File Transfer
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
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--1st col-->
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
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button>
                                <strong>Not Allowed ! </strong>
                                {{ session('err') }}
                            </div>
                        @endif

                    </div>
                    {{ csrf_field() }}

                    <div class="col-md-12">
                        <!--2nd col-->
                        <div class="row">
                            <div class="col-md-12">

                                <h3 class="text-center" style="text-transform: uppercase;">Files Transferred to Officer</h3>

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <form method="post" action="{{ url('/bulk-transfer/post') }}">
                            {{ csrf_field() }}

                            @if ($count > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                                            <thead>
                                                <tr>

                                                    <th>FILE NO.</th>
                                                    <th>NAME</th>
                                                    <th>ORIGIN</th>
                                                    <th>VOLUME</th>
                                                    <th>LAST PAGE</th>
                                                    <th>DESTINATION</th>
                                                    <th>DATE SENT</th>
                                                    <th>STATUS</th>
                                                    <th>SELECT ALL <input type="checkbox" id="select_all"></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($acceptance_view as $list)
                                                    @php
                                                        if ($list->status == 0) {
                                                            $value = 'Accept?';
                                                        } elseif ($list->status == 1) {
                                                            $value = 'Accepted';
                                                        }
                                                        $originDept = DB::table('tbldepartment')
                                                            ->where('id', '=', $list->origin_dept)
                                                            ->first();
                                                    @endphp
                                                    @if ($list->recipient == $authUser)
                                                        <tr>
                                                            <td>{{ $list->fileNo }} <input type="hidden" name="fileNo[]"
                                                                    value="{{ $list->fileNo }}"></td>
                                                            <td>{{ $list->file_description }}</td>
                                                            <td>{{ $originDept->department }} <input type="hidden"
                                                                    name="id[]" value="{{ $list->bulkID }}"></td>
                                                            <td>{{ $list->volume_name }} <input type="hidden"
                                                                    name="volume[]" value="{{ $list->fileVolume }}"></td>
                                                            <td>{{ $list->fileLastPage }} <input type="hidden"
                                                                    name="lastPage[]"
                                                                    value="{{ $list->fileLastPage }}"</td>
                                                            <td>{{ $list->department }}</td>
                                                            <td>{{ date('d-M-Y', strtotime(trim($list->date_transfered))) }}
                                                            </td>
                                                            <td>{{ $list->status_description }}</td>
                                                            <td><input type="checkbox" name="checkname[]"
                                                                    value="{{ $list->fileNo }}" class="checkbox"></td>

                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <!-- form-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Destination</label>
                                        <select name="destination" id="destination" class="form-control select2">
                                            <option value="">Select One</option>
                                            @foreach ($department as $section)
                                                <option value="{{ $section->id }}">{{ $section->department }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 recipient">
                                    <div class="form-group">
                                        <label for="month">Name Of Recipient</label>
                                        <select name="recipient" id="recipient" class="form-control">

                                        </select>
                                    </div>
                                </div>

                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Purpose Of Movement</label>
                                <textarea name="purpose" id="purpose" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Return Date</label>
                                <input type="text" name="returnDate" id="returndate" class="form-control" />
                            </div>
                        </div>
                    </div>


                    <hr />
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-3">
                                <!--<div align="left" class="form-group">
              <label for="month">&nbsp;</label><br />
              <a href="#" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
             </div>-->
                            </div>

                            <div class="col-md-9">
                                <div align="right" class="form-group">
                                    <label for="month">&nbsp;</label><br />
                                    <button name="action" class="btn btn-success" type="submit">
                                        Transfer <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>


                    <!-- form -->
                @else
                    <h2 class="text-center" style="color:green;">No file available for Movement</h2>
                    @endif

                    </form>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- view Files-->

            <div class="box box-default">
                <div class="box-body box-profile">
                    <h3>All Returned Files</h3>
                    <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                        <thead>
                            <tr>

                                <th>FILE NO.</th>
                                <th>NAME</th>
                                <th>ORIGIN</th>
                                <th>VOLUME</th>
                                <th>LAST PAGE</th>
                                <th>TRANSFERRED DESTINATION</th>
                                <th>DATE TRANSFERRED</th>
                                <!--<th>Status</th>-->

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transfered_files as $list)
                                @php
                                    if ($list->status == 0) {
                                        $value = 'Accept?';
                                    } elseif ($list->status == 1) {
                                        $value = 'Accepted';
                                    }
                                    $originDept = DB::table('tbldepartment')
                                        ->where('id', '=', $list->origin_dept)
                                        ->first();
                                    $td = DB::table('tblbulk_file_movement')
                                        ->where('fileNo', '=', $list->fileNo)
                                        ->where('transfered_by', '=', $list->recipient)
                                        ->first();
                                    $transferDestination = DB::table('tbldepartment')
                                        ->where('id', '=', $td->destination)
                                        ->first();
                                @endphp
                                @if ($list->recipient == $authUser)
                                    <tr>
                                        <td>{{ $list->fileNo }} <input type="hidden" name="fileNo[]"
                                                value="{{ $list->fileNo }}"></td>
                                        <td>{{ $list->file_description }}</td>
                                        <td>{{ $originDept->department }} <input type="hidden" name="id[]"
                                                value="{{ $list->bulkID }}"></td>
                                        <td>{{ $list->volume_name }} <input type="hidden" name="volume[]"
                                                value="{{ $list->fileVolume }}"></td>
                                        <td>{{ $list->fileLastPage }} <input type="hidden" name="lastPage[]"
                                                value="{{ $list->fileLastPage }}"</td>
                                        <td>{{ $transferDestination->department }}</td>
                                        <td>{{ date('d-M-Y', strtotime(trim($list->date_transfered))) }}</td>
                                        <!--<td>{{ $list->status_description }}</td>-->

                                    </tr>
                                @elseif($list->recipient == 0 && $list->recipient == $recipientSection->UserID)
                                    <tr>
                                        <td>{{ $list->fileNo }} <input type="hidden" name="fileNo[]"
                                                value="{{ $list->fileNo }}"></td>
                                        <td>{{ $list->file_description }}</td>
                                        <td>{{ $originDept->department }} <input type="hidden" name="id[]"
                                                value="{{ $list->bulkID }}"></td>
                                        <td>{{ $list->volume_name }} <input type="hidden" name="volume[]"
                                                value="{{ $list->fileVolume }}"></td>
                                        <td>{{ $list->fileLastPage }} <input type="hidden" name="lastPage[]"
                                                value="{{ $list->fileLastPage }}"</td>
                                        <td>{{ $transferDestination->department }}</td>
                                        <td>{{ date('d-M-Y', strtotime(trim($list->date_transfered))) }}</td>
                                        <!--<td>{{ $list->status_description }}</td>-->

                                    </tr>
                                @endif
                            @endforeach

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
                                                        <input type="text" name="fullName" class="form-control" />
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
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i>
                                        Save</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <script>
        $('.select2').select2();
    </script>

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
                var dest = $(this).val();
                if (dest == 40) {
                    $('.recipient').hide();
                } else {
                    $('.recipient').show();
                }
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
                            $('#recipient').append('<option value="' + obj.UserID + '">' +
                                obj.surname + ' ' + obj.first_name + '</option>');
                        });

                    }
                })
            });
        })();
    </script>

    <script>
        $(function() {
            $("#returndate").datepicker({
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
                    $("#returndate").val(dateFormatted);
                },
            });


        });
    </script>
@endsection
