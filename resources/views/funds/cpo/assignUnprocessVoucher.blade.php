@extends('layouts.layout')
@section('pageTitle')
    Audit Raised Vourcher
@endsection



@section('content')
    <form class="form-horizontal" role="form" id="form1" method="post" action="">
        {{ csrf_field() }}
        <div id="vim" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">All Minutes</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12" id="z-space">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




        <div class="box box-default">
            <div class="box-body box-profile">
                <div class="box-header with-border hidden-print">
                    <h3 class="box-title"> Assign Unprocessed Vouchers <span id='processing'></span></h3>
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

                    @if ($success != '')
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> <br />
                            {{ $success }}
                        </div>
                    @endif

                </div>


                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12"><!--1st col-->
                            @include('funds.Share.message')


                            <div class="row">



                                <!-- /.col -->
                            </div>


                            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                                <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                    <thead>
                                        <tr bgcolor="#c7c7c7">
                                            <th>S/N</th>
                                            <!--<th>File No</th>-->
                                            <th>Beneficiary</th>
                                            <th>Contract/claim Description</th>
                                            <th>Payment Naration</th>
                                            <th>Total Amount</th>
                                            <!--<th>Economic Code</th>-->
                                            <!--<th> Prepared date </th>-->
                                            <!--<th> Date Awarded </th>-->
                                            <th>Action</th>
                                            <th>Designated Staff</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    @php $i = 0; @endphp
                                    <tbody>
                                        @if ($tablecontent)
                                            @foreach ($tablecontent as $list)
                                                <tr @if ($list->isrejected == 1) style="background-color: red; color:#FFF;" @endif
                                                    @if ($list->is_need_more_doc == 1) style="background-color: #FF7F50; color:#FFF;" @endif>
                                                    <td>{{ ++$i }}</td>
                                                    {{-- <!--<td>{{ $list->FileNo }}</td>--> --}}
                                                    @if ($list->voucherType == '1')
                                                        <td>{{ $list->contractor }}</td>
                                                    @else
                                                        <td>{{ $list->payment_beneficiary }}</td>
                                                    @endif
                                                    <td>{{ $list->ContractDescriptions }}</td>
                                                    <td>{{ $list->paymentDescription }}</td>
                                                    <td>{{ number_format($list->totalPayment, 2) }}</td>
                                                    <!--<td>{{ $list->economicCode }}:{{ $list->ecotext }}-{{ $list->contractType }}</td>-->
                                                    <!--<td>{{ $list->datePrepared }}</td>-->
                                                    <!--<td>{{ $list->dateAward }}</td>-->
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-danger btn-xs dropdown-toggle"
                                                                type="button" id="dropdownMenu1" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true">
                                                                Action
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                                <!--<li><a onclick="accept('{{ $list->ID }}')" >Process</a></li>-->
                                                                <li><a onclick="decline('{{ $list->ID }}')">Decline</a>
                                                                </li>
                                                                <li><a target ="_blank"
                                                                        href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                                </li>
                                                                <li><a href="/display/comment/{{ $list->conID }}"
                                                                        target="_blank">View Minutes</a></li>
                                                                <li><a onclick="documentQuery('{{ $list->ID }}')">Query
                                                                        Documents</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($list->voucher_lock < 1)
                                                            <select class="form-control" id="staff{{ $list->ID }}">
                                                                <option value="">-Select Staff-</option>
                                                                @foreach ($UnitStaff as $list2)
                                                                    <option value="{{ $list2->user_id }}"
                                                                        {{ $list->cpo_assign_userID == $list2->user_id ? 'selected' : '' }}>
                                                                        {{ $list2->Names }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <a href="javascript:void(0)" class="btn btn-default btn-xs"
                                                                tile="Please contact your admin.">Voucher Locked</a>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($list->voucher_lock < 1)
                                                            <a class="btn btn-xs btn-success" style="cursor: pointer;"
                                                                onclick="return AssignStaff('{{ $list->ID }}')">Assign</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%">
                                                    <center>No Voucher to be audited</center>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <br><br><br><br><br>
                            </div>


                            <hr />
                        </div>


                    </div>

                </div>


                <input type="hidden" id="assvid" name="vid">
                <input type="hidden" id="as_user" name="as_user">

    </form>


    <div id="approveindex" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"> Clearance Comfirmation </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to clear this voucher for further processing! Do you still want to continue?</h5>
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="control-label"><b>Enter comment if any(optional)</b></label>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="comment" class="form-control"> </textarea>
                            </div>
                            <input type="hidden" id="vaid" name="vid">
                        </div>
                        <div class="modal-footer">
                            <button type="Submit" name="process" class="btn btn-success">Continue</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--decline modal-->
    <div id="declineModal" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Clearance Rejection</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to reject this voucher for further processing! Do you still want to continue?
                        </h5>
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="control-label"><b>Enter Reason for Decline</b></label>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="comment" class="form-control" required> </textarea>
                            </div>
                            <input type="hidden" id="vdid" name="vid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="decline" class="btn btn-success">Continue</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!--end of decline modal-->

    <!--document query modal-->
    <div id="docModal" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Document Query</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to query this voucher Your request will be sent to other charges! Do you still
                            want to continue?</h5>
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="control-label"><b>Enter query details</b></label>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="comment" class="form-control" required> </textarea>
                            </div>
                            <input type="hidden" id="docid" name="vid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="moredocument" class="btn btn-success">Continue</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!--end of document query modal-->
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
            "pageLength": 50
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

        function comments(list, list1) {
            space = document.getElementById('z-space');
            space.innerHTML = '';
            if (list1 !== "") {
                var a = JSON.parse(list1);
                space.innerHTML += 'Pre-payment Remarks <br>';
                for (i = 0; i < a.length; i++) {
                    space.innerHTML += '<p><b id="vi">' + a[i].comment + '</b> - <small class="text-warning"> <i>' + a[i]
                        .name + ', posted ' + a[i].date_added + ' at ' + a[i].time + '</i></small></p><br>';
                }
            }
            if (list !== "") {
                var a = JSON.parse(list);
                space.innerHTML += '<br> payment Remarks <br>';
                for (i = 0; i < a.length; i++) {
                    space.innerHTML += '<p><b id="vi">' + a[i].comment + '</b> - <small class="text-warning"> <i>' + a[i]
                        .name + ', posted ' + a[i].date_added + ' at ' + a[i].time + '</i></small></p><br>';
                }
            }

            $("#vim").modal('show');
            return false;
        }

        function approve(a = '') { //alert("jsjsjs");
            $("#approveindex").modal('show');
            return false;
        }

        function reject(a = '') {

            return false;
        }

        function accept(a = "") {
            document.getElementById('vaid').value = a;
            $("#approveindex").modal('show');
        }

        function decline(a = "") {
            document.getElementById('vdid').value = a;
            $("#declineModal").modal('show')
            return false;
        }

        function documentQuery(a) {
            document.getElementById('docid').value = a;
            $("#docModal").modal('show')
            return false;
        }

        function AssignStaff(id) {
            //alert(id);
            document.getElementById('assvid').value = id;
            document.getElementById('as_user').value = document.getElementById("staff" + id).value;
            document.getElementById('form1').submit();
            // if(document.getElementById('as_user').value!== ""){
            //     document.getElementById('form1').submit();
            //  return ;
            // }
        }

        function restorefunc(x) {
            document.getElementById('restoreid').value = x;
            $("#RestoreModal").modal('show');
        }
    </script>
@stop
