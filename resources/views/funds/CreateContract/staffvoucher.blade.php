@extends('layouts.layout')
@section('pageTitle')
    {{ strtoupper('create staff voucher') }}
@endsection
@section('content')








    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12"><!--1st col-->
                        @if ($warning != '')
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ $warning }}</strong>
                            </div>
                        @endif
                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span> </button>
                                <strong>Successful!</strong> {{ session('message') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ session('error') }}</strong>
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

                        <form class="form-horizontal" role="form" action="" method="post" id="form1"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <a class="btn btn-warning btn-sm" href="{{ URL::previous() }}">Back</a><br>
                            <div class="col-md-4">

                                <label class="control-label"><small>Total Approved Sum</small></label>
                                <input type="text" class="form-control" readonly id="totalamount"
                                    value="{{ number_format($contractValue, 2, '.', ',') }}">
                                <input type="hidden" name="contractid" value="{{ $contractid }}">
                            </div>
                            <div class="col-md-4">
                                <label class="control-label"><small>Unpaid Balance</small></label>
                                <input type="text" class="form-control" readonly id="totalamount"
                                    value="{{ number_format($amtpayable, 2, '.', ',') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">&nbsp&nbsp</label><br>

                                <a href="/display/comment/{{ $contractid }}" target="_blank" class="btn btn-info">View
                                    Comment</a>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">

                                    <div class="col-md-10">
                                        <label class="control-label">Claim description</label>
                                        <input type="text" value="{{ $claimdetails }}" readonly=""
                                            class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Voucher date</label>
                                        <input readonly type="text"
                                            value="{{ $todayDate ? $todayDate : old('todayDate') }}" readonly="readonly"
                                            name="todayDate" id="todayDate" class="form-control" placeholder="Select Date">

                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Economic code</label>
                                        <select name="economiccode" id="economiccode" class="select_picker form-control"
                                            data-live-search="true" required>
                                            <option value="">Select Economic Code</option>
                                            @php
                                                if (old('economiccode') !== '') {
                                                    $economiccode = old('economiccode');
                                                }
                                            @endphp

                                            @foreach ($econocodeList as $list)
                                                <option value="{{ $list->ID }}"
                                                    @if ($economiccode == $list->ID) {{ 'selected' }} @endif>
                                                    {{ $list->economicCode }}:
                                                    {{ $list->description }}-{{ $list->contractType }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-8">
                                        <label class="control-label">Payment Description</label>
                                        <textarea id="content" rows="2" cols="80" class="form-control" name="details" required> {{ $claimdetails }}</textarea>
                                    </div>


                                </div>
                            </div>


                            <!-- /.col -->
                    </div>
                    <!-- /.row -->


                    <div class="row">
                        <div class="col-md-12">

                            <table class="table table-striped table-condensed table-bordered ">
                                <thead style="background: #fdfdfd;">
                                    <tr class="input-lg">
                                        <th width="20" class="text-center">
                                            <div class="col-md-0 checkbox" style="margin:2px;">
                                                <label class="text-primary" for="check-all">
                                                    <input type="checkbox" class="checkitem" id="toggle"
                                                        value="select" onClick="toggle_all()" checked>Check all
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-center">Staff Name(s)</th>
                                        <th class="text-center"> Amount approved</th>
                                        <th class="text-center">Amount pending </th>
                                        <th class="text-center">Amount process </th>
                                        <th class="text-center">Remarks </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tamt = 0;
                                        $pamt = 0;
                                        $amt = 0;
                                    @endphp
                                    @foreach ($beneficiary as $list)
                                        <tr class="input-lg">
                                            <td> <input type="checkbox" id="checkbox{{ $list->selectedID }}"
                                                    @if ($list->amtpending == 0) disabled @else value="1" onClick="toggle_this('{{ $list->selectedID }}','{{ $list->amtpending }}')"  checked @endif>
                                            </td>
                                            <td>{{ $list->fileNo }}:{{ $list->surname }} {{ $list->first_name }}
                                                {{ $list->othernames }}</td>
                                            <td style="text-align: right;">{{ $list->staffamount }}</td>
                                            <td style="text-align: right;">{{ $list->amtpending }}</td>
                                            <td><input type="text" class="form-control"
                                                    id="amount{{ $list->selectedID }}"
                                                    name="amount{{ $list->selectedID }}" value="{{ $list->amtpending }}"
                                                    onkeyup='Subtotal()' style="width:200px;text-align: right;"
                                                    autocomplete="off"@if ($list->amtpending == 0) disabled @endif>
                                            </td>
                                            <td>{{ $list->remarks }}</td>
                                            @php
                                                $tamt += $list->staffamount;
                                                $pamt += $list->staffamount;
                                                $amt += $list->amtpending;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr class="input-lg">
                                        <td></td>
                                        <td>Total</td>
                                        <td style="text-align: right;">{{ $tamt }}</td>
                                        <td style="text-align: right;">{{ $amt }}</td>
                                        <td><input type="text" class="form-control" id="amt"
                                                value="{{ $amt }}" style="width:200px;text-align: right;"
                                                readonly></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            @if ($amt == 0)
                            @else<center><button class="btn btn-success" style="margin-bottom: 10px;" type= "submit"
                                        name= "continue" value="1">Continue</button></center>
                            @endif
                            <input type="hidden" name="finalsubmit" id="finalsubmit" value="">
                        </div>
                    </div><!-- /.col -->


                    <table class="table table-striped table-condensed table-bordered ">
                        <thead style="background: #fdfdfd;">
                            <tr class="input-lg">


                                <th class="text-center">Payment detail</th>
                                <th class="text-center">Benefeciary</th>
                                <th class="text-center">Total amount </th>
                                <th class="text-center">Economics code </th>
                                <th class="text-center">More actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tpamt = 0;
                            @endphp
                            @foreach ($voucherlist as $list)
                                <tr class="input-lg">
                                    <td>{{ $list->paymentDescription }}</td>
                                    <td>{{ $list->payment_beneficiary }}</td>
                                    <td style="text-align: right;">{{ $list->amtPayable }}</td>
                                    <td>{{ $list->economicCode }}:{{ $list->description }}</td>
                                    <td>
                                        <a href="/display/voucher/{{ $list->ID }}" target="_blank"
                                            class="btn btn-info">View details</a>
                                        {{-- @if ($list->is_advances != 3)
                                            <a href="/create/driver-tour/{{ $list->ID }}" class="btn btn-info">Is
                                                Driver Tour</a>
                                        @endif --}}
                                    </td>
                                    <td>
                                        @if ($list->status < 2)
                                            <a onclick="Del('{{ $list->ID }}')" class="btn btn-warning">Reverse</a>
                                        @endif
                                    </td>
                                    @php
                                        $tpamt += $list->amtPayable;
                                    @endphp
                                </tr>
                            @endforeach
                            <tr class="input-lg">
                                <td>Total</td>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;">{{ $tpamt }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($amt == 0)
                <center><a href="/display/voucher/{{ $list->ID }}/{{ $list->contractID }}" target="_blank"
                        class="btn btn-info">View all</a> </center>
            @endif
            <hr />
        </div>
        </form>
    </div>
    </div>


    </div>
    </div>
    </div>
    <div id="deleteindex" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"> Reverse voucher </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to reverse this voucher! Do you still want to continue?</h5>
                        <div class="form-group" style="margin: 0 10px;">
                            <input type="hidden" id="delid" name="vid">
                        </div>
                        <div class="modal-footer">
                            <button type="Submit" name="delete" class="btn btn-success">Continue</button>
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
            width: 10cm
        }

        .modal-header {

            background-color: #006600;

            color: #FFF;

        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script>
        ///////////////////////DATE///////////////////////////////// 
        $(function() {
            $("#todayDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });


        function toggle_this(id, amt) {

            var x = document.getElementById("checkbox" + id);
            if (x.value == 0) {
                x.value = 1;
                document.getElementById("amount" + id).value = amt;
            } else {
                x.value = 0;
                document.getElementById("amount" + id).value = 0;
            }
            Subtotal();
        }

        function toggle_all() {
            alert("Code to be done later");
        }

        function Subtotal() {
            var total = 0;
            @foreach ($beneficiary as $list)
                total += parseFloat(document.getElementById("amount{{ $list->selectedID }}").value);
            @endforeach
            document.getElementById("amt").value = total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return;
        }

        function Del(id) {
            document.getElementById("delid").value = id;
            $("#deleteindex").modal('show');
            return false;
        }

        $('.select_picker').selectpicker({
            style: 'btn-default',
            size: 4
        });
    </script>


@stop
