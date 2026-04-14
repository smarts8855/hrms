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
    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>All files transfered by me... </em></strong></h3>
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
                                
                                <em id="#recallSuccess"></em>
                           
                                <h3 class="text-center" style="text-transform: uppercase;">All Files You Transferred </h3>

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <form method="post" action="{{ url('/bulk-movement/confirmation') }}">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-striped" id="servicedetail" width="100%">
                                        <thead>
                                            <tr>

                                                <th>FILE NO.</th>
                                                <th>FILE NAME</th>
                                                <th>ORIGIN</th>
                                                <th>LOCATION</th>
                                                <th>RECIPIENT</th>
                                                <th>VOLUME</th>
                                                <th>LAST<br /> PAGE</th>
                                                <th>DATE SENT</th>
                                                <th>STATUS</th>
                                                <th></th>
                                                <th></th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sent_files as $key => $list)
                                                @php
                                                    if ($list->bulkStatus == 0) {
                                                        $value = 'Accept?';
                                                    } elseif ($list->bulkStatus == 1) {
                                                        $value = 'Accepted';
                                                    }
                                                    $destination = DB::table('tbldepartment')
                                                        ->where('id', '=', $list->destination)
                                                        ->first();
                                                    $originDept = DB::table('tbldepartment')
                                                        ->where('id', '=', $list->origin_dept)
                                                        ->first();
                                                    $user = DB::table('tblper')
                                                        ->where('UserID', '=', $list->recipient)
                                                        ->first();
                                                    $rejectedByUser = DB::table('tblper')
                                                        ->where('UserID', '=', $list->transfered_by)
                                                        ->first();
                                                    $bulkIDencode = base64_encode($list->bulkID);
                                                    $allcomments = DB::table('tbltracking_comments')
                                                        ->join('users', 'users.id', '=', 'tbltracking_comments.comment_by')
                                                        ->where('bulkID', '=', $list->bulkID)
                                                        ->select('*', 'tbltracking_comments.updated_at as commentUpdatedAt')
                                                        ->orderBy('tbltracking_comments.id', 'DESC')
                                                        ->first();
                                                @endphp

                                                <tr>
                                                    <td>{{ $list->fileNo }}</td>
                                                    <td>{{ $list->file_description }}</td>
                                                    <td>{{ $originDept->department }}</td>
                                                    <td>{{ $destination->department }}</td>

                                                    @if($list->bulkStatus == 4)
                                                        <td>{{ $rejectedByUser->surname ?? '' }} {{ $rejectedByUser->first_name ?? '' }}</td>
                                                    @else
                                                        <td>{{ $user->surname ?? '' }} {{ $user->first_name ?? '' }}</td>
                                                    @endif
                                                    
                                                    <td>{{ $list->fileVolume }}</td>
                                                    <td>{{ $list->fileLastPage }}</td>
                                                    <td>{{ date('d-M-Y', strtotime(trim($list->date_transfered))) }}</td>
                                                    <td>
                                                        @if ($list->bulkStatus == 4)
                                                            <em class="text-danger"> <strong>{{ $list->status_description }} <br /></strong> </em>
                                                            @elseif ($list->bulkStatus == 1)
                                                            <em class="text-success"> <strong>{{ $list->status_description }} <br /></strong> </em>
                                                        @endif
                                                        
                                                        @if ($list->bulkStatus == 4)
                                                            
                                                            @php
                                                                $db = DB::table('tbltracking_comments')
                                                                    ->where('fileNo', '=', $list->fileNo)
                                                                    ->first();
                                                                
                                                            @endphp
                                                            <em><a href="javascript:void" id="{{ $list->fileNo ?? '' }}"
                                                                bulkID="{{ $list->bulkID ?? '' }}"
                                                                reason="{{ $db->comment ?? '' }}" style="color: purple;" class="reason"> <strong> View
                                                                Reason</strong> </a></em>
                                                        @endif



                                                        {{-- @if ($list->bulkStatus == 4)
                                                            ---

                                                            <a href="javascript:void" id="{{ $list->fileNo }}"
                                                                class="agree" value="cancel">Agree?</a>
                                                        @endif --}}
                                                    </td>

                                                    <div class="row">
                                                    <td>
                                                    
                                                        @if ($list->bulkStatus == 4)
                                                            {{-- <a href="" id="{{ $list->fileNo }}"
                                                                tansferID="{{ $list->bulkID }}"
                                                                fileID="{{ $list->ID }}"
                                                                class="btn btn-success resend btn-sm"
                                                                value="resend">Re-send</a> --}}
                                                                
                                                               <a href="{{ url('/bulk-transfer/editfile/' . $bulkIDencode) }}"
                                                                id="{{ $list->fileNo }}"
                                                                class="btn btn-success edit btn-sm" style="margin-top: 5px;" value="edit">Re-send</a>
                                                        @endif
                                                        
                                                    </td>
                                                    </div>

                                                    <td>

                                                        {{-- @if ($list->accepted_by == 0 && $list->bulkStatus != 4)
                                                            <button class="btn btn-warning" type="button"> <a href="javascript:void/{{ $list->fileNo }}"
                                                                id="{{ $list->fileNo }}" style="color: white;" class="recall"
                                                                value="cancel">Recall</a> </button>
                                                        @endif --}}

                                                        @if ($list->bulkStatus != 4 && $list->bulkStatus != 1)
                                                         {{-- <a href="javascript:void/{{ $list->fileNo }}"
                                                            id="{{ $list->fileNo }}" style="color: white;" class="btn btn-warning recall"
                                                            value="cancel">Recall</a>  --}}
                                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-backdrop="false" data-target="#confirmToDelete{{$key}}">Recall</button>

                                                                <!-- Modal to delete -->
                                                                <div class="modal fade text-left" id="confirmToDelete{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-danger">
                                                                                <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="text-success text-center"> <h4>Are you sure you want to recall {{ $list->fileNo }} ?</h4></div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                                                <a href="javascript:void/{{ $list->fileNo }}" id="{{ $list->fileNo }}" class="btn btn-danger recall"> Yes! </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--end Modal-->
                                                        @endif

                                                    </td>

                                                </tr>

                                                <div class="hiddenComment{{ $list->bulkID }}" style="display:none;">
                                                    @if ($allcomments != '')
                                                        {{-- @foreach ($allcomments as $comm) --}}
                                                            <div class="minutes">
                                                                <p><span><b>Minutes By: {{ $allcomments->name }}</span> | Date:
                                                                    {{ date('Y-M-d', strtotime(trim($allcomments->commentUpdatedAt))) }}</b>
                                                                </p>
                                                                <p>{{ $allcomments->comment }}</p>
                                                            </div>
                                                        {{-- @endforeach --}}
                                                    @endif
                                                </div>
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>



                        </form>

						<div>
							{{$sent_files->links()}}
						</div>

                    </div><!-- /.col -->
                </div><!-- /.row -->

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

                <!-- Cancel or Agree Modal -->

                <form action="{{ url('/bulk-transfer/cancel') }}" method="post">
                    {{ csrf_field() }}
                    <!-- Modal -->
                    <div class="bs-example">
                        <!-- Modal HTML -->
                        <div id="cancelModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content" style="padding: 10px; border-radius: 6px;">

                                    <div class="box box-default">
                                        <div class="box-body box-profile">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>

                                            </div>
                                            <div class="modal-body">

                                                <h4 class="modal-title"><b>Do you really want to perform this action ?</b>
                                                </h4>
                                                <input type="hidden" name="fileNo" id="fileNo" />
                                                <input type="hidden" name="value" id="val" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer-not-use" align="right">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                                class="fa fa-arrow-circle-left"></i> No</button>
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i>
                                            Yes</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- // Cancel or agree modal -->


                <!-- Re sent -->
                <form action="{{ url('file-tracking/bulk/resend') }}" method="post">
                    {{ csrf_field() }}
                    <!-- Modal -->
                    <div class="bs-example">
                        <!-- Modal HTML -->
                        <div id="resendModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content" style="">

                                    <div class="box box-default">
                                        <div class="box-body box-profile">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                                <h4 class="modal-title"><b>Resend File</b></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="month">Reason for resending</label>
                                                            <textarea name="comment" class="form-control"></textarea>
                                                            <input type="hidden" name="fileNo" id="fileno" />
                                                            <input type="hidden" name="fileID" id="fileID" />
                                                            <input type="hidden" name="bulkID" id="bulkId" />
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
                <!-- Resend Reason -->



            </div>
        </div>
    @endsection

    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
        <style type="text/css">
            table tr td {
                font-size: 13px !important;
            }

            table tr th {
                font-size: 14px !important;
            }
        </style>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
        <!-- autocomplete js-->
        <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>


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
                    var value = $(this).attr('value');
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
                            'fileNo': id,
                            'value': value
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
            $(document).ready(function() {
                $("table tr td .cancel").on('click', function() {
                    //alert("ok");
                    //var id=$(this).parent().parent().find("input:eq(0)").val();
                    var id = $(this).attr('id');
                    //var value = $(this).attr('value');
                    //alert(id);
                    //var value = $(this).attr('value');
                    // alert(id);
                    $token = $("input[name='_token']").val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $token
                        },
                        url: "{{ url('/bulk-transfer/cancel') }}",

                        type: "post",
                        data: {
                            'fileNo': id
                        },
                        success: function(data) {
                            $('#recallSuccess').text("You have successfully recalled file");
                          
                        }
                    });

                });
            });
        </script>


        <script type="text/javascript">
            $(document).ready(function() {

                $("table tr td .recall").on('click', function() {
                    //alert("ok");
                    //var id=$(this).parent().parent().find("input:eq(0)").val();
                    var id = $(this).attr('id');
                    //var value = $(this).attr('value');
                    //alert(id);
                    //var value = $(this).attr('value');
                    // alert(id);
                    $token = $("input[name='_token']").val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $token
                        },
                        url: "{{ url('/bulk-transfer/recall') }}",

                        type: "post",
                        data: {
                            'fileNo': id
                        },
                        success: function(data) {
                            $('#message').html(data);
                            location.reload(true);
                        }
                    });

                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.resend').click(function() {
                    var id = $(this).attr('id');
                    var fileID = $(this).attr('fileID');
                    var bulkID = $(this).attr('tansferID');
                    $("#fileno").val(id);
                    $("#fileID").val(fileID);
                    $("#bulkId").val(bulkID);
                    $('#resendModal').modal('show');
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

            $(document).ready(function() {
                $('.agree').click(function() {
                    var id = $(this).attr('id');
                    var value = $(this).attr('value');
                    $("#fileNo").val(id);
                    $("#val").val(value);
                    $('#cancelModal').modal('show');
                });
            });
        </script>
    @endsection
