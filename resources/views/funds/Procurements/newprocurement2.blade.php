@extends('layouts.layout')
@section('pageTitle')
    Unapprove Staff claim
@endsection



@section('content')

    <div id="editModal" class="modal fade">
        <div class="modal-dialog " role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editpartModal" name="editpartModal" role="form" method="POST"
                    action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class=" control-label">File No:</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" value="" name="file_no" id="file_no" readonly
                                    class="form-control">
                                <input type="hidden" value="" name="id" id="eid">
                            </div>

                            <div class="col-sm-12">
                                <label class="control-label">Beneficiary</label>
                            </div>

                            <div class="col-sm-12">
                                <textarea name="bene" id="bene" class="form-control"> </textarea>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Claim Description</label>
                            </div>

                            <div class="col-sm-12">
                                <textarea name="contr_desc" id="contr_desc" class="form-control"> </textarea>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Total Claim</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" value="" name="contr_val" id="contr_val" placeholder=""
                                    class="form-control" readonly>
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Upload project file</label>
                            </div>

                            <div class="col-sm-12">
                                <input type="file" value="" name="filex" autocomplete="off" class="form-control">
                            </div>

                            <div class="col-sm-12">
                                <label class=" control-label">Reassing to</label>
                            </div>

                            <div class="col-sm-12">
                                <select name="actionby" id="actionbyid" class="form-control">
                                    @foreach ($officers as $list)
                                        <option value="{{ $list->code }}">{{ $list->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="edit-hidden" name="edit-hidden" value="">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


    <!--reason modal-->
    <div id="reasonModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reason for rejection</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="control-label"><i id="msg-reason"></i></label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <!--<button type="Submit" class="btn btn-success" id="putedit"></button>-->
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end of reason-->

    <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to delete this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="deleteid" name="deleteid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div id="RestoreModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Restore Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to restore this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="restoreid" name="restoreid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div id="attachModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">File Attachment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action=""
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <input type="hidden" class="form-control" id="cid" name="id">
                            <div class="col-sm-12">

                                <label class="control-label">
                                    <h5>File Description</h5>
                                </label>
                                <input required class="form-control" autocomplete="off" name="attachment_description">

                            </div>
                            <div class="col-sm-12">

                                <label class="control-label">Attach File:</label>
                                <input type="file" name="filename" class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="btn-attachment">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>

            <div class="col-md-12">
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
                @if ($error != '')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        <p>{{ $error }}</p>
                    </div>
                @endif
                @if ($success != '')
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ $success }}
                    </div>
                @endif
                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
            </div>


            <div class="box-body box-primary">
                <div class="box-body">
                    @include('funds.Share.message')

                    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                        <table id="res_tab" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>File No</th>
                                    <th>Beneficiary</th>
                                    <th>Contract Description</th>
                                    <th>Contract Value</th>
                                    <th>Created BY</th>
                                    <th>Approved Status</th>
                                    <th>Next officer</th>
                                    <!--<th>Approved Date</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @php $i = 1; @endphp
                            <tbody>

                                @foreach ($procurementlist as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->fileNo }}</td>
                                        <td>{{ $list->beneficiary }}</td>
                                        <td>{{ $list->ContractDescriptions }}</td>

                                        @php $list->contractValue = $list->contractValue; @endphp
                                        <td>&#8358; {{ number_format($list->contractValue, 2) }}</td>

                                        <td>{{ $list->name }}</td>
                                        <td>
                                            @if ($list->approvalStatus == 1)
                                                <b><span class="text-success">Approved</span></b>
                                            @elseif($list->approvalStatus == 2)
                                                <b><span class="text-warning">Rejected</span></b>
                                            @else
                                                <b><span class="text-danger">Pending</span></b>
                                            @endif
                                        </td>
                                        <td>{{ $list->awaitingActionby }}</td>
                                        <!--<td>{{ $list->approvalDate }} </td>-->
                                        <td>
                                            @if ($list->approvalStatus == 0)
                                                <button
                                                    onclick="return editfunc('{{ $list->ID }}', '{{ $list->fileNo }}', '{{ $list->contract_Type }}','{{ $list->ContractDescriptions }}','{{ $list->contractValue }}','{{ $list->companyID }}','{{ $list->dateAward }}','{{ $list->awaitingActionby }}','{{ $list->beneficiary }}')"
                                                    class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                                <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                    class="btn btn-success btn-xs">View</a>
                                                <button onclick="return deletefunc('{{ $list->ID }}')"
                                                    class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i>
                                                </button>
                                            @elseif($list->approvalStatus == 2)
                                                <button
                                                    onclick="return editfunc('{{ $list->ID }}', '{{ $list->fileNo }}', '{{ $list->contract_Type }}','{{ $list->ContractDescriptions }}','{{ $list->contractValue }}','{{ $list->companyID }}','{{ $list->dateAward }}'),'{{ $list->awaitingActionby }}','{{ $list->beneficiary }}')"
                                                    class="btn btn-success btn-xs"><i class="fa fa-edit "></i></button>
                                                <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                    class="btn btn-success btn-xs">View</a>
                                            @else
                                                <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                    class="btn btn-success btn-xs">View</a>
                                            @endif
                                            <!--<button onclick="return addattachment('{{ $list->ID }}')" class="btn btn-danger btn-xs" > Attach... </button>-->


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <input type="hidden" value="" id="co" name="court">
                    <input type="hidden" value="" id="di" name="division">
                    <input type="hidden" value="" name="status">
                    <input type="hidden" value="" name="chosen" id="chosen">
                    <input type="hidden" value="" id="type" name="type">
                </div>
            </div>



        @endsection
        @section('styles')
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
        @stop

        @section('styles')
            <style type="text/css">
                .modal-dialog {
                    width: 13cm
                }

                .modal-header {

                    background-color: #006600;

                    color: #FFF;

                }

                #partStatus {
                    width: 2.5cm
                }
            </style>
        @endsection

        @section('scripts')
            <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
            <script>
                $('#res_tab').DataTable({
                    "iDisplayLength": 100
                });

                $("#contractvalue").blur(function(evt) {

                    if (evt.which != 190) { //not a fullstop
                        var n = parseFloat($(this).val().replace(/\,/g, ''), 10);
                        $(this).val(n.toLocaleString());
                        //$(this).val(n.toLocaleString());
                    }

                });

                $(function() {
                    $("#todayDate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });

                $(function() {
                    $("#dateawd").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });

                $("#check-all").change(function() {
                    $(".checkitem").prop("checked", $(this).prop("checked"))
                })
                $(".checkitem").change(function() {
                    if ($(this).prop("checked") == false) {
                        $("#check-all").prop("checked", false)
                    }
                    if ($(".checkitem:checked").length == $(".checkitem").length) {
                        $("#check-all").prop("checked", true)
                    }
                })

                function approve(a = '') {
                    if (a !== '') {
                        document.getElementById('chosen').value = a;
                        // alert(a);
                    }
                    co = document.getElementById('court').value;
                    div = document.getElementById('division').value;
                    document.getElementById('co').value = co;
                    document.getElementById('di').value = div;
                    document.getElementById('type').value = 1;
                    document.getElementById('form2').submit();
                    return false;
                }

                function reject(a = '') {
                    if (a !== '') {
                        document.getElementById('chosen').value = a;
                        //alert(a);
                    }
                    co = document.getElementById('court').value;
                    div = document.getElementById('division').value;
                    document.getElementById('co').value = co;
                    document.getElementById('di').value = div;
                    document.getElementById('type').value = 2;
                    document.getElementById('form2').submit();
                    return false;
                }

                function viewReason(reason, a, b, c, d, e, f, g) {
                    //document.getElementById('putedit').setAttribute("onclick", "editfunc('"a"','"b"','"c"','"d"','"e"','"f"','"g"')");
                    document.getElementById('msg-reason').innerText = reason;

                    $("#reasonModal").modal('show')

                }

                function delet(a = '') {
                    if (confirm('Are you sure you want to delete this record!')) {
                        if (a !== '') {
                            document.getElementById('chosen').value = a;
                            //alert(a);
                        }
                        co = document.getElementById('court').value;
                        div = document.getElementById('division').value;
                        document.getElementById('co').value = co;
                        document.getElementById('di').value = div;
                        document.getElementById('type').value = 3;
                        document.getElementById('form2').submit();
                    }
                    return false;
                }


                function editfunc(a, b, c, d, e, f, g, h, i) {
                    $("#reasonModal").modal('hide');
                    document.getElementById('file_no').value = b;
                    document.getElementById('eid').value = a;
                    document.getElementById('bene').value = i;
                    document.getElementById('contr_desc').value = d;
                    document.getElementById('contr_val').value = e;
                    document.getElementById('edit-hidden').value = 1;
                    document.getElementById('actionbyid').value = h;
                    $("#editModal").modal('show')
                }

                function deletefunc(x) {
                    //$('#deleteid').val() = x;

                    document.getElementById('deleteid').value = x;
                    $("#DeleteModal").modal('show');
                }

                function addattachment(x) {
                    document.getElementById('cid').value = x;
                    $("#attachModal").modal('show');
                }
            </script>
        @stop
