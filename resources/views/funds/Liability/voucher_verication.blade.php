@extends('layouts.layout')
@section('pageTitle')
    Voucher verification Pre-clearance
@endsection

@section('content')
    <!--decline modal-->
    <div id="clearModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Voucher Verification Minute</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group" style="margin: 0 10px;">
                            <h4 class="modal-title">You are about to drop comment for the head of other charges. Do you
                                really want to continue?</h4>
                            <div class="col-sm-12">
                                <label class="control-label"><b>Enter remark (optional)</b></label>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="remark" class="form-control"> </textarea>
                            </div>
                            <input type="hidden" id="clearid" name="clearid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" name="clear"class="btn btn-success">Save and continue</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <!--end of decline modal-->



    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title"> @yield('pageTitle') <span id='processing'></span></h3>
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
                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ session('msg') }}
                    </div>
                @endif
            </div>


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('funds.Share.message')


                        <div class="row">
                            {{ csrf_field() }}


                            <!-- /.col -->
                        </div>


                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th>S/N</th>
                                        <th>PVNO</th>
                                        <th>Beneficiary</th>
                                        <th>Contract/claim Description</th>
                                        <th>Payment Naration</th>
                                        <th>Total Amount</th>
                                        <th>Vote Descriptions</th>
                                        <th> Date Awarded </th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                @php $i = 0; @endphp
                                <tbody>
                                    @if ($tablecontent)
                                        @foreach ($tablecontent as $list)
                                            <tr
                                                @if ($list->isrejected == 1) style="background-color: red; color:#FFF;" @endif>
                                                <td>{{ ++$i }}</td>
                                                <td> SCN/OC/{{ $list->vref_no }}/{{ $list->period }}</td>
                                                @if ($list->voucherType == '1')
                                                    <td>{{ $list->contractor }}</td>
                                                @else
                                                    <td>{{ $list->payment_beneficiary }}</td>
                                                @endif


                                                <td>{{ $list->ContractDescriptions }}</td>
                                                <td>{{ $list->paymentDescription }}</td>
                                                <td>{{ number_format($list->totalPayment, 2) }}</td>
                                                <td>{{ $list->economicCode }}:{{ $list->ecotext }}-{{ $list->contractType }}
                                                </td>
                                                <td>{{ $list->dateAward }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger btn-xs dropdown-toggle" type="button"
                                                            id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            Action
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a onclick="accept('{{ $list->ID }}')">Drop Comment</a>
                                                            </li>
                                                            <li><a href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                            </li>
                                                            <li><a href="/display/comment/{{ $list->conID }}"
                                                                    target="_blank">View Minutes</a></li>
                                                            <li>
                                                                @if ($list->companyID == 13)
                                                                    <a
                                                                        href="/create/staff-voucher/{{ $list->conID }}">Edit</a>
                                                                @else<a
                                                                        href="/voucher/edit/{{ $list->ID }}">Edit</a>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%">
                                                <center>No Voucher to check</center>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                            <br><br><br><br><br>
                        </div>
                        <input type="hidden" value="" id="co" name="court">
                        <input type="hidden" value="" id="di" name="division">
                        <input type="hidden" value="" name="status">
                        <input type="hidden" value="" name="chosen" id="chosen">
                        <input type="hidden" value="" id="type" name="type">

                        <hr />
                    </div>

                </div>
            </div>
            <form id="thisform1" name="thisform1" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="" name="reason" id="reason22">
                <input type="hidden" value="" id="paymentTransID" name="paymentTransID">
            </form>


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
                $('#res_tab').DataTable();
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



                function accept(a) {
                    document.getElementById('clearid').value = a
                    //return;
                    $("#clearModal").modal('show')
                }

                function decline(a = "") {

                    if (a != "") {
                        document.getElementById('chosen1').value = a
                    }

                    $("#declineModal").modal('show')
                    return false;
                }
            </script>
        @stop
