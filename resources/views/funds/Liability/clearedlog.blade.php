@extends('layouts.layout')
@section('pageTitle')
    Processed vouchers
@endsection



@section('content')


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
                        <strong>Warning!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
            </div>

            <form id="thisform1" name="thisform1" method="post">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-2">
                            <label class="control-label">Date From</label>
                            <input type="text" class="col-sm-9 form-control" value="{{ $fromdate }}" name="fromdate"
                                id="fromdate">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Date To</label>
                            <input type="text" class="col-sm-9 form-control" value="{{ $todate }}" name="todate"
                                id="todate">
                        </div>

                    </div>

                </div>

                <div class="col-md-12">
                    <div class="form-group">

                        <br>
                        <label class="control-label"></label>
                        <button type="submit" class="btn btn-success" name="add">
                            <i class="fab fa-btn fa-sistrix"></i> Search
                        </button>

                    </div>
                </div>
                {{ csrf_field() }}
            </form>
            <form class="form-horizontal" role="form" id="form1" method="post" action="">
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

                                            <th>Beneficiary</th>
                                            <th>Total Amount</th>
                                            <th>Contract/Claim Description</th>
                                            <th>Payment Description</th>
                                            <th>Vote Description</th>
                                            <th>Vote Balance</th>


                                        </tr>
                                    </thead>
                                    @php $i = 1; @endphp
                                    <tbody>
                                        @if ($tablecontent)
                                            @foreach ($tablecontent as $list)
                                                <tr
                                                    @if ($list->isrejected == 1) style="background-color: red; color:#FFF;" @endif>
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
                                                                <li><a target= "_blank"
                                                                        href="/display/voucher/{{ $list->ID }}">Preview</a>
                                                                </li>
                                                                <li><a href="/display/comment/{{ $list->conID }}"
                                                                        target="_blank">View Comment</a></li>
                                                                <li><a onclick="Switch_Code('{{ $list->ID }}')">Switch
                                                                        Vote</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>

                                                    @if ($list->voucherType == '1')
                                                        <td>{{ $list->contractor }}</td>
                                                    @else
                                                        <td>{{ $list->payment_beneficiary }}</td>
                                                    @endif
                                                    <td>{{ number_format($list->totalPayment, 2) }}</td>
                                                    <td>{{ $list->ContractDescriptions }}</td>
                                                    <td>{{ $list->paymentDescription }}</td>
                                                    <td>{{ $list->economicCode }}:{{ $list->voteinfo }}-{{ $list->contractType }}
                                                    </td>
                                                    <td>{{ number_format($list->votebal, 2) }}</td>




                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%">
                                                    <center>No Record</center>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <br><br><br><br><br><br>
                            </div>
                            <hr />
                        </div>

                    </div>
                </div>
                <input type="hidden" id="assvid" name="vid">
                <input type="hidden" id="as_user" name="as_user">
            </form>

            <div id="switchcode" class="modal fade">
                <form class="form-horizontal" role="form" method="post" action="">
                    {{ csrf_field() }}
                    <div class="modal-dialog box-default" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title"> Change Economics vote </h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 0 10px;">
                                    <div class="col-sm-12">
                                        <label class="control-label"><b>Select Economic code</b></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <select name="economiccode" id="economiccode" class="select_picker form-control"
                                            data-live-search="true" required>
                                            <option value="">Select Economic Code</option>
                                            @foreach ($econocodeList as $list)
                                                <option value="{{ $list->ID }}">{{ $list->economicCode }}:
                                                    {{ $list->description }}-{{ $list->contractType }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" id="switchid" name="vid">
                                </div>
                                <div class="modal-footer">
                                    <button type="Submit" name="switch" class="btn btn-success">Continue</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                function Switch_Code(a) {
                    document.getElementById('switchid').value = a;

                    $("#switchcode").modal('show');
                }

                $('.select_picker').selectpicker({
                    style: 'btn-default',
                    size: 4
                });
                $(function() {
                    $("#fromdate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                    $("#todate").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });
            </script>
        @stop
