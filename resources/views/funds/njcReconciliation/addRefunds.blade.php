@extends('layouts.layout')
@section('pageTitle')
    Add New Refunds Entry
@endsection

@section('content')


    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add Refund</h3>
        </div>

        <form method="post" action="{{ route('PostCreateRefunds') }}">
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> {{ session('message') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. of Voucher</label>
                            <input type="text" name="numberOfVoucher" class="form-control input-lg">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>From Whom Received</label>
                            <input type="text" name="fromWhomReceived" class="form-control input-lg">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description of Receipt</label>
                            <input type="text" name="descriptionOfReceipt" class="form-control input-lg" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="refundsDate" readonly id="refundsDate" class="form-control input-lg"
                                placeholder="Select Date" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. of Treasury</label>
                            <input type="text" name="numberOfTreasury" class="form-control input-lg">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>TSA/Bank (Amount)</label>
                            <input type="text" name="tsaBank" class="form-control input-lg" placeholder="No comma"
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Account Type</label>
                            <select name="accountType" id="accountType" class="form-control input-lg">
                                <option value="">Select Account Type</option>
                                @forelse($contractType as $getType)
                                    <option value="{{ $getType->ID }}">{{ $getType->contractType }}</option>
                                @empty
                                    <option value="">Select Account Type</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Allocation Type</label>
                            <select name="allocationType" id="allocationType" class="form-control input-lg getAllocation">
                                <option value="">Select Allocation Type</option>
                                @forelse($allocationType as $getAllocation)
                                    <option value="{{ $getAllocation->ID }}">{{ $getAllocation->allocation }}</option>
                                @empty
                                    <option value="">Select Allocation Type</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NCOA (Economic Code)</label>
                            <select name="economicCode" id="economicCode" class="form-control input-lg">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>

            <div class="box-footer text-right">
                <button type="submit" class="btn btn-success btn-lg">Add Refunds</button>
            </div>

            {{ csrf_field() }}
        </form>
    </div>

@stop

@section('scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        $(function() {
            $("#refundsDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
        //Get economic Code
        $(document).ready(function() {
            $(".getAllocation").change(function() {
                $('#economicCode').empty().append('<option value="" selected>--Select--</option>');
                var accountType = $('#accountType').val();
                var allocationType = $('#allocationType').val();
                if (accountType === '') {
                    $('#accountType').css('borderColor', 'red');
                    alert('Please select Account Type!');
                    $('#accountType').focus();
                    return false;
                }
                if (allocationType === '') {
                    $('#allocationType').css('borderColor', 'red');
                    alert('Please select Allocation Type!');
                    $('#allocationType').focus();
                    return false;
                }
                $('#accountType').css('borderColor', 'grey');
                $('#allocationType').css('borderColor', 'grey');
                $.ajax({
                    url: murl + '/get-economic-code-for-refound',
                    type: "post",
                    data: {
                        'contractTypeID': accountType,
                        'allocationTypeID': allocationType,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        var opt = '';
                        for (var i = 0; i < data.length; i++) {
                            opt += '<option value="' + data[i].economicID + '">' + data[i]
                                .description + '</option>'; //+ ' - Bal.: ' + data[i].bal
                        }
                        $('#economicCode').append(opt);
                    },
                    error: function(jqXHR, status, err) {
                        alert('Sorry, error occurred! Refresh this page. ' + err);
                    }
                })
            });
        });
    </script>
@stop
