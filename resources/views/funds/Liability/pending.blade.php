@extends('layouts.layout')
@section('pageTitle')
    Editable Vouchers
@endsection



@section('content')

    <div id="vim" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">All Minutes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12" id="z-space">

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



    <!--comment modal-->

    <div id="CommentModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Read the Minutes below</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-4 pull-left">Reason for decline</label>
                            </div>

                            <div class="col-sm-12">
                                <textarea name="reason-c" id="reason-c" readonly class="form-control"> </textarea>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="Submit" class="btn btn-success">Save</button>-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
    <!--end of comment modal-->


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
            </div>


            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @include('funds.Share.message')


                        <!-- /.row -->
                        <div class="row">
                            {{ csrf_field() }}


                            <!-- /.col -->
                        </div>


                        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                            <table id="res_tab" class="table table-bordered table-striped table-highlight">
                                <thead>
                                    <tr bgcolor="#c7c7c7">
                                        <th>S/N</th>
                                        <th>Action</th>
                                        <th>File No</th>
                                        <th>Total Amount</th>
                                        <th>Contract Description</th>
                                        <th>Payment Description</th>
                                        <th>Approval date</th>

                                    </tr>
                                </thead>
                                @php $i = 1; @endphp
                                <tbody>
                                    @if ($tablecontent)
                                        @foreach ($tablecontent as $list)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger btn-xs dropdown-toggle"
                                                            type="button" id="dropdownMenu1" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="true">
                                                            Action
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                                                            <li><a href="/display/comment/{{ $list->conID }}"
                                                                    target="_blank">View Minutes</a></li>
                                                            <li><a href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                            </li>
                                                            @if ($list->isrejected == 1)
                                                                <li>
                                                                    <a
                                                                        onclick="processVoucher('{{ $list->ID }}')">Process</a>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                @if ($list->companyID == 13)
                                                                    <a
                                                                        href="/create/staff-voucher/{{ $list->conID }}">Edit</a>
                                                                @else
                                                                    <a href="/voucher/edit/{{ $list->ID }}">Edit</a>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>{{ $list->FileNo }} <br> Voucher No.{{ $list->voucherFileNo ?? '' }}</td>
                                                <td>{{ number_format($list->totalPayment, 2) }}</td>
                                                <td>{{ $list->ContractDescriptions }}</td>
                                                <td>{{ $list->paymentDescription }}</td>
                                                <td>{{ $list->dateAward }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%">
                                                <center>No Voucher Raised</center>
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


            <!-- Modal HTML -->
            <div id="myModal" class="modal fade myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Return Voucher</h4>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="{{ url('/voucher/oc/send-back') }}" style="margin-top:10px;">
                                {{ csrf_field() }}
                                <input type="hidden" name="transid" id="setPaymentID" />

                                <div class="row">
                                    <!--<div class="col-md-12">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label for="month">Reason for rejecting</label>-->
                                    <!--        <textarea name="remark" class="form-control remark" required></textarea>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="col-md-12 refer">
                                        <div class="form-group">
                                            <label for="month">RETURN TO: <span
                                                    style="color:red; font-weight: bold;">Please, select section to return
                                                    voucher</span></label>
                                            <select name="attension" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="3">Audit</option>
                                                <option value="2">Checking</option>
                                                <option value="1">Expenditure Control</option>
                                                <option value="4">CPO</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div align="right">
                                    <input type="submit" class="btn btn-success proceed" name="submit"
                                        value="Send" />
                                </div>

                                <div id="desc">

                                </div>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>
            <!--///// end modal -->




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

                function comments(list) {
                    if (list == "") {
                        space = document.getElementById('z-space');
                        space.innerText = 'No reason found';
                    } else {

                        var a = JSON.parse(list);
                        //console.log(a);
                        space = document.getElementById('z-space');
                        space.innerHTML = '';
                        for (i = 0; i < a.length; i++) {
                            space.innerHTML += '<p><b id="vi">' + a[i].comment + '</b> - <small class="text-warning"> <i>' + a[i]
                                .name + ', posted ' + a[i].date_added + ' at ' + a[i].time + '</i></small></p><br>';

                        }
                        //$('#vim').modal('show');
                    }

                    $("#vim").modal('show');
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


                function editfunc(a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q) {
                    document.getElementById('contracttype').value = a;
                    document.getElementById('Company').value = b;
                    document.getElementById('pvno').value = c;
                    document.getElementById('payment').value = d;
                    document.getElementById('payment_desc').value = e;
                    document.getElementById('wht_val').value = f;
                    document.getElementById('wht_perc').value = g;
                    document.getElementById('vat_val').value = h;
                    document.getElementById('vat_perc').value = i;
                    document.getElementById('amtpayable').value = j;
                    document.getElementById('prepareby').value = k;
                    document.getElementById('liabilityby').value = l;
                    document.getElementById('allocationtype').value = m;
                    document.getElementById('economiccode').value = n;
                    document.getElementById('dateprepared').value = o;
                    document.getElementById('bbf').value = q;

                    document.getElementById('paymentTransID').value = p;
                    // document.getElementById('dateawd').value = g;
                    $("#editModal").modal('show')
                }

                function accept(a = "") {
                    var form = document.getElementById('editpartModal');
                    if (a != "") {
                        document.getElementById('paymentTransID').value = a
                    }

                    document.getElementById('reason').value = 1;
                    form.submit();
                    return false;
                }

                function decline(a = "") {
                    var form = document.getElementById('editpartModal');
                    if (a != "") {
                        document.getElementById('paymentTransID').value = a
                    }
                    document.getElementById('reason').value = 2;
                    form.submit();
                    return false;
                }

                function deletefunc(x) {
                    //$('#deleteid').val() = x;

                    document.getElementById('deleteid').value = x;
                    $("#DeleteModal").modal('show');
                }

                function restorefunc(x) {

                    document.getElementById('restoreid').value = x;
                    $("#RestoreModal").modal('show');
                }

                function getDivisions() {
                    document.getElementById('status').value = "";
                    if ($('#court').val() !== "") {
                        $('#form1').submit();
                    }
                }

                function getStaff() {
                    document.getElementById('status').value = "";
                    if ($('#division').val() !== "") {
                        $('#form1').submit();
                    }
                }

                function getTable() {
                    if ($('#status').val() !== "") {
                        $('#form1').submit();
                    }
                }

                function checkForm() {
                    var court = $('#court').val();
                    division = $('#division').val();
                    fileno = $('#fileNo').val();
                    fname = $('#fname').val();
                    oname = $('#oname').val();
                    sname = $('#sname').val();
                    desc = $('#cvdesc').val();
                    amount = $('#amount').val();
                    if (court == "") {
                        alert('You have empty fields!');
                    } else {
                        if (division == "") {
                            alert('You have empty fields');
                        } else {
                            if (fileno == "") {
                                alert('you have empty fields!');
                            } else {
                                if (fname == "") {
                                    alert('you have empty fields!');
                                } else {
                                    if (oname == "") {
                                        alert('you have empty fields');
                                    } else {
                                        if (sname == "") {
                                            alert('you have empty fields!');
                                        } else {
                                            if (desc == "") {
                                                alert('you have empty fields!');
                                            } else {
                                                if (amount == "") {
                                                    alert('you have empty fields!');
                                                } else {
                                                    $('#form1').submit();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return false;
                }
            </script>
            <script>
                function processVoucher(paymentTransaction = '') {
                    $("#setPaymentID").val(paymentTransaction);
                    $("#myModal").modal('show');
                    return false;
                }
            </script>
        @stop
