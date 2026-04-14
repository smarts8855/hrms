@extends('layouts.layout')

@section('pageTitle')
    All Voucher Beneficiaries
@endsection

@section('content')
    <div class="box-body">

        <div class="box-body hidden-print">
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




        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    CONFIRM BENEFICIARIES
                    <br>

                </h3>
                <p class="text-center">{{ $beneficiaries[0]->paymentDescription }}</p>
                <p class="text-center">Amount Payable: &#8358;{{ number_format($beneficiaries[0]->amtPayable, 2) }}</p>
            </div>

            <div class="panel-body">

                <!-- Table Section -->
                <div class="table-responsive">
                    <form action="{{ url('/submit-voucher-beneficiary/confirm') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="transID" value="{{ $beneficiaries[0]->transID ?? '' }}">

                        <table id="myTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>File No</th>
                                    <th>Beneficiary</th>
                                    <th>Bank</th>
                                    <th>Account No</th>
                                    <th class="text-right">Total Amount <br>&#8358;</th>

                                    <th class="text-center">
                                        Check All
                                        <br>
                                        <label>
                                            <input type="checkbox" class="beneFilter" value="">
                                        </label>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($beneficiaries as $key => $list)
                                    @php
                                        $sum += $list->amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $list->fileNo }}</td>
                                        <td>{{ $list->beneficiaryDetails }}</td>
                                        <td>{{ $list->bank }}</td>
                                        <td>{{ $list->accountNo }}</td>
                                        <td class="text-right">{{ number_format($list->amount) }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" name="checkname[]" class="rowCheck" value="{{ $list->vBeneID }}" {{ $list->isChecked ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right"><strong>{{ number_format($sum) }}</strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="submit" name="submit" value="Confirm" class="btn btn-success pull-right" />

                    </form>
                </div>
            </div>
        </div>
        {{-- <div>
            <a href="/cpo/report" class="btn btn-danger"> <span class="fa fa-arrow-back"></span> Back</a>
        </div> --}}

        <!-- /.row -->
    </div>

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
        th,
        td {
            border: #9f9f9f solid 1px !important;
            font-size: 12px !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            const $beneFilter = $('.beneFilter');
            // const $rowChecks = $('.rowCheck:not(:disabled)');
            const $rowChecks = $('.rowCheck');

            $beneFilter.change(function(){
                $rowChecks.prop('checked', this.checked);
            });

            $rowChecks.change(function(){
                const allChecked = $rowChecks.length === $rowChecks.filter(':checked').length;
                $beneFilter.prop('checked', allChecked);
            });

            // Initial check
            const initialAllChecked = $rowChecks.length === $rowChecks.filter(':checked').length;
            $beneFilter.prop('checked', initialAllChecked);
        });
    </script>
@endsection
