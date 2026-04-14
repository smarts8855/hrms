@extends('layouts.layout')

@section('pageTitle')
    Reconciliation
@endsection

@section('content')
    <div class="box-body">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> <br />
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
                            <strong>Success!</strong> <br />
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !</strong> <br />
                            {{ session('err') }}
                        </div>
                    @endif
                </div>
            </div><!-- /row -->
        </div><!-- /div -->


        <!--search all vouchers-->
        <div class="row">
            <div class="panel panel-success" style="margin-top: 5px;">
                <div class="panel-heading">
                    <h4 class="panel-title text-uppercase">Search Bank Debit</h4>
                </div>
                <div class="panel-body">

                    <form method="post" action="{{ route('bank.debits') }}">
                        @csrf
                        <div class="col-md-5">
                            <label>From</label>
                            <input type="date" name="rFrom" class="form-control" value="{{ request('rFrom') }}">
                        </div>

                        <div class="col-md-5">
                            <label>To</label>
                            <input type="date" name="rTo" class="form-control" value="{{ request('rTo') }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary w-100 form-control">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="panel panel-success" style="margin-top: 5px;">
                <div class="panel-heading">
                    <h4 class="panel-title text-uppercase">Debit in Bank Not In Cash Book As At
                        @if ($rFrom ) @endif</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="tableData" style="margin-bottom: 50px;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($bankDebits->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No bank debits found.
                                    </td>
                                </tr>
                            @else
                                @php
                                    $totalDebit = 0;
                                @endphp
                                @foreach ($bankDebits as $index => $debit)
                                    @php
                                        $totalDebit += $debit->debit;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $debit->description }}</td>
                                        <td>{{ number_format($debit->debit, 2) }}</td>
                                    </tr>
                                @endforeach
                                {{-- TOTAL ROW --}}
                                <tr style="background-color: #d4edda; font-weight: bold;">
                                    <td colspan="2" class="text-end">Total:</td>
                                    <td>{{ number_format($totalDebit, 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

    <!--Search all vouchers-->
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">

    <style type="text/css">
        .status {
            font-size: 15px;
            padding: 0px;
            height: 100%;

        }

        .textbox {
            border: 1px;
            background-color: #66FFBA;
            outline: 0;
            height: 25px;
            width: 275px;
        }

        $('.autocomplete-suggestions').css({
            color: 'red'
        });

        .autocomplete-suggestions {
            color: #66FFBA;
            height: 125px;
        }

        .table,
        tr,
        td {
            border: #9f9f9f solid 1px !important;
            font-size: 12px !important;
        }

        .table thead tr th {
            font-weight: 700;
            font-size: 17px;
            border: #9f9f9f solid 1px
        }
    </style>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $("#dateTo").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd MM, yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                    $("#dateTo").val(dateFormatted);
                },
            });

        });

        $(function() {
            $("#dateFrom").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd MM, yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                    $("#dateFrom").val(dateFormatted);
                },
            });

        });
    </script>
@endsection
