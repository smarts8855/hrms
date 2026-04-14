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
                    <h4 class="panel-title text-uppercase">Search Reconcilation Records</h4>
                </div>
                <div class="panel-body">

                    <form method="post" action="{{ route('bank.credits') }}">
                        @csrf
                        <div class="col-md-5" style="padding: 2px;">
                            <label>Reconcilation Batch</label>
                            <select name="batch_number" id="batch_number" class="form-control">
                                <option value="">--Select Reconcilation Batch--</option>
                                @foreach ($mandateAccountsBatch as $batch)
                                    <option value="{{ $batch->batch_number }}"
                                        @if (session('batch_number') == $batch->batch_number) selected @endif>
                                        {{ $batch->batch_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5" style="padding: 2px;">
                            <label>Reconcilation Report Type</label>
                            <select name="reconcilation_type" id="reconcilation_type" class="form-control">
                                <option value="">--Select Reconcilation Report Type--</option>
                                <option value="777" @if (request('reconcilation_type') == '777') selected @endif>
                                    Bank Credit
                                </option>
                                <option value="888" @if (request('reconcilation_type') == '888') selected @endif>
                                    Bank Debit
                                </option>
                                <option value="999" @if (request('reconcilation_type') == '999') selected @endif>
                                    Unpresented Cheques
                                </option>

                                <option value="555" @if (request('reconcilation_type') == '555') selected @endif>
                                    Matched Transactions
                                </option>
                            </select>
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
                    <h4 class="panel-title text-uppercase">
                        @if (!empty($reconcilationType))
                            @if ($reconcilationType == 777)
                                Credit in Bank Not In Cash Book
                            @elseif ($reconcilationType == 888)
                                Debit in Bank Not In Cash Book
                            @elseif ($reconcilationType == 999)
                                Unpresented Mandate
                            @endif

                            @if (!empty($rFrom) && !empty($rTo))
                                | For the period: {{ $rFrom }} to {{ $rTo }}
                            @endif
                        @else
                            Reconciliation Records
                        @endif

                    </h4>

                </div>

                <div class="panel-body" id="printArea">
                    <div class="table-responsive">


                        {{-- <h4 class="mb-3">Matched Cash Book & Bank Statement</h4> --}}
                        @if ($reconcilationType == 555)
                            <table class="table table-bordered table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th colspan="6" class="text-center">Matched Cash Book & Bank Statement</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-center">Cash Book (SCN Records)</th>
                                        <th colspan="3" class="text-center">Bank Statement (Bank Records)</th>
                                    </tr>
                                    <tr class="table-secondary">
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>

                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bankCredits as $matchId => $pair)
                                        @php
                                            $cashbook = $pair->firstWhere('status', 1);
                                            $statement = $pair->firstWhere('status', 2);

                                            // Correct amount extraction
                                            $cashbookAmount = $cashbook
                                                ? ($cashbook->debit > 0
                                                    ? $cashbook->debit
                                                    : $cashbook->credit)
                                                : 0;
                                            $statementAmount = $statement
                                                ? ($statement->debit > 0
                                                    ? $statement->debit
                                                    : $statement->credit)
                                                : 0;
                                        @endphp

                                        <tr class="table-success">

                                            {{-- Cashbook side --}}
                                            <td>{{ $cashbook ? \Carbon\Carbon::parse($cashbook->transaction_date)->format('d-m-Y') : '' }}
                                            </td>
                                            <td>{{ $cashbook->description ?? '' }}</td>
                                            <td>{{ number_format($cashbookAmount, 2) }}</td>

                                            {{-- Bank Statement side --}}
                                            <td>{{ $statement ? \Carbon\Carbon::parse($statement->transaction_date)->format('d-m-Y') : '' }}
                                            </td>
                                            <td>{{ $statement->description ?? '' }}</td>
                                            <td>{{ number_format($statementAmount, 2) }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>

                                @php
                                    // Accurate totals
                                    $totalCashbook = $bankCredits
                                        ->flatten()
                                        ->filter(fn($r) => $r->status == 1)
                                        ->map(fn($r) => $r->debit > 0 ? $r->debit : $r->credit)
                                        ->sum();

                                    $totalStatement = $bankCredits
                                        ->flatten()
                                        ->filter(fn($r) => $r->status == 2)
                                        ->map(fn($r) => $r->debit > 0 ? $r->debit : $r->credit)
                                        ->sum();
                                @endphp

                                <tfoot class="table-warning font-weight-bold">
                                    <tr>
                                        <td colspan="2">TOTAL Cash Book</td>
                                        <td>{{ number_format($totalCashbook, 2) }}</td>

                                        <td colspan="2">TOTAL Bank Statement</td>
                                        <td>{{ number_format($totalStatement, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <table class="table table-bordered" style="margin-bottom: 50px;">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center">
                                            @if (!empty($reconcilationType))
                                                @if ($reconcilationType == 777)
                                                    Credit in Bank Not In Cash Book
                                                @elseif ($reconcilationType == 888)
                                                    Debit in Bank Not In Cash Book
                                                @elseif ($reconcilationType == 999)
                                                    Unpresented Mandate
                                                @endif

                                                @if (!empty($rFrom) && !empty($rTo))
                                                    | For the period: {{ $rFrom }} to {{ $rTo }}
                                                @endif
                                            @else
                                                Reconciliation Records
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Particulars</th>
                                        <th>Amount (₦)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $totalAmount = 0; @endphp

                                    @forelse ($bankCredits as $index => $credit)
                                        @php
                                            $amount = $credit->credit > 0 ? $credit->credit : $credit->debit;
                                            $totalAmount += $amount;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ formatDate($credit->transaction_date ?? $credit->created_at) }}</td>
                                            <td>{{ $credit->description }}</td>
                                            <td>{{ number_format($amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No records found.
                                            </td>
                                        </tr>
                                    @endforelse

                                    {{-- TOTAL ROW --}}
                                    <tr style="background-color: #d4edda; font-weight: bold;">
                                        <td colspan="3" class="text-end">Total:</td>
                                        <td>{{ number_format($totalAmount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Centered Print Button -->
                    <div class="text-center" style="margin-top: 15px;">
                        <button class="btn btn-success no-print" onclick="printDiv('printArea')">Print</button>
                    </div>
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



    <style>
        @media print {
            body {
                font-size: 12px;
            }

            .panel {
                border: none;
            }

            .panel-heading {
                display: block;
                text-align: center;
                font-weight: bold;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                page-break-inside: auto;
            }

            thead {
                display: table-header-group;
                /* repeat table header on each page */
            }

            tfoot {
                display: table-footer-group;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 5px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.js') }}"></script>


    {{-- Print Script --}}
    <script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
            location.reload(); // reload page to restore JS
        }
    </script>
@endsection
