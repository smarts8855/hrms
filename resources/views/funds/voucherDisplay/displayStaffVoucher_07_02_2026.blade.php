@extends('layouts.layout')
@section('pageTitle')
    {{ strtoupper(' You can print your voucher here') }}
@endsection
@section('content')

    <div style="background: #FFFFFF; padding: 10px 30px;">
        <form method="post" action="{{ url('/CR/voucher/contract/create') }}">
            {{ csrf_field() }}

            <div align="center" style="background: #FFF;">

                <div style="float: right;"><b>ECONOMIC CODE: {{ $list->Code }} {{ $list->economicCode }} </b></div>
                <br />


                <div align="center">
                    <h3><b><span style="text-decoration: underline;">OVERHEAD JOURNAL</span></b></h3>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-striped table-condensed table-bordered ">
                            <thead style="background: #fdfdfd;">
                                <tr class="input-lg">
                                    <th width="100" rowspan="2" class="text-center">DATE</th>
                                    <th width="600" rowspan="2" class="text-center">DESCRIPTION</th>
                                    <th width="200" class="text-center">DR. </th>
                                    <th width="200" class="text-center">CR. </th>
                                </tr>
                                <tr class="input-lg">
                                    <th width="140" class="text-center"> &#8358; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>k</b>
                                    </th>
                                    <th width="140" class="text-center"> &#8358; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>k</b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="input-lg">
                                    <th>
                                        <div>{{ date_format(date_create($list->datePrepared), 'd-m-Y') }}</div>
                                    </th>
                                    <th>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div>
                                                    {{ $list->paymentDescription }}
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <span>
                                            <div align="center">
                                                @if ($isClaim == '')
                                                    {{ number_format($list->totalPayment, 2, '.', ',') }}
                                                @else
                                                    {{ number_format($totalAmount, 2, '.', ',') }}
                                                @endif
                                            </div>
                                        </span>
                                    </th>
                                    <th></th>
                                </tr>
                                @if ($list->VATValue > 0)
                                    <tr class="input-lg">
                                        <th class="text-center"><span>&#10004;</span></th>
                                        <th> <span style="font-weight: 100;">{{ $list->VAT }}% VAT Payable ( Cash Book )
                                            </span></th>
                                        <th></th>
                                        <th>
                                            <div align="center">{{ number_format($list->VATValue, 2, '.', ',') }}</div>
                                        </th>
                                    </tr>
                                @endif
                                @if ($list->WHTValue > 0)
                                    <tr class="input-lg ">
                                        <th class="text-center"><span>&#10004;</span></th>
                                        <th style="font-weight: 100;">
                                            {{ $list->WHT }}% Withholding Tax Payable ( Cash Book )
                                        </th>
                                        <th></th>
                                        <th>
                                            <div align="center">{{ number_format($list->WHTValue, 2, '.', ',') }}</div>
                                        </th>
                                    </tr>
                                @endif
                                <tr class="input-lg">
                                    <th class="text-center"><span>&#10004;</span></th>
                                    <th>
                                        <span style="font-weight: 100;">
                                            @if ($list->WHTValue == '' or $list->WHTValue == 0)
                                                Amount Payable (Overhead ) Cash Book
                                            @else
                                                Amount Payable (Overhead ) Cash Book
                                            @endif

                                        </span>
                                    </th>
                                    <th></th>
                                    <th>
                                        <div align="center">
                                            @if ($isClaim == '')
                                                {{ number_format($list->totalPayment, 2, '.', ',') }}
                                            @else
                                                {{ number_format($totalAmount, 2, '.', ',') }}
                                            @endif
                                        </div>
                                    </th>
                                </tr>

                            </tbody>
                        </table>


                        <table class="table table-striped table-condensed">
                            <thead style="background: #fff;">
                                <tr class="input-lg">
                                    <td valign="top" width="100">
                                        <h4>Narration:</h4>
                                    </td>
                                    <th width="600">
                                        <div style="font-weight: 100;">
                                            {{ $list->paymentDescription }}
                                        </div>
                                    </th>
                                </tr>
                                <tr class="input-lg">
                                    <th colspan="2">
                                        <h4>Prepared By</h4>
                                    </th>
                                </tr>
                                <tr class="input-lg">
                                    <th valign="center" width="100">
                                        <h4>Name:</h4>
                                    </th>
                                    <th>
                                        <div style="font-weight: 100;">{{ $list->name }}</div>
                                    </th>
                                </tr>
                                <tr class="input-lg">
                                    <th valign="center" width="100">
                                        <h4>Date: </h4>
                                    </th>
                                    <th><span
                                            style="font-weight: 100;">{{ date_format(date_create($list->datePrepared), 'dS l F, Y') }}</span>
                                    </th>
                                </tr>

                            </thead>
                        </table>

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <br /><br /><br />
        </form>
    </div>

    @foreach ($trans as $list)
        <?php
        $count = DB::table('tblvoucherBeneficiary')->where('voucherID', '=', $list->transID)->count();

        $staff = DB::table('tblvoucherBeneficiary')->leftJoin('tblbanklist', 'tblbanklist.bankID', '=', 'tblvoucherBeneficiary.bankID')->where('voucherID', '=', $list->transID)->get();
        ?>

        <!--PAYMENT VOUCHER-->
        <div class="box-body" style="background: #fff;">
            <div style="margin: 0 10px;" id="report2">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box-body">
                            <div align="center">
                                <h4>
                                    <div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <b>{{ strtoupper('FEDERAL GOVERNMENT OF NIGERIA') }}</b>
                                        <p><span class="pull-right"><big>
                                                    <select class="type">
                                                        <option>ORIGINAL</option>
                                                        <option>DUPLICATE</option>
                                                        <option>TRIPLICATE</option>
                                                        <option>QUADRUPLICATE</option>
                                                        <option>QUINTUPLICATE</option>
                                                        <option>SEXTUPLICATE</option>
                                                    </select>
                                                </big></span></p><br />
                                        <span class="pull-right"><small>Treasury F1</small></span><br />
                                        <span class="pull-right hidden-print"><small><span style="color:green;">STATUS:
                                                </span>
                                                @if ($list->status == 6)
                                                    {{ PAID }}@else{{ $status->description }}
                                                @endif
                                            </small></span>
                                    </div>
                                </h4>
                                <div>
                                    <h4><b>{{ strtoupper('PAYMENT VOUCHER') }}</b></h4>
                                </div>
                            </div>

                            <div align="center" style="font-weight: 100">
                                Departmental No. <b>SCN/OC/<input type="text" class="noborder"
                                        style="border:none; width:40px !important;" transid="{{ $list->transID }}"
                                        id="vref"
                                        value="{{ $list->vref_no }}" />/{{ date('Y', strtotime(trim($list->datePrepared))) }}</b>.
                                Checked and passed for payment at <b>Abuja</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: -3px;">
                    <div class="col-xs-3">
                        <div align="center" class="visible-print text-center" style="margin-top: -15px">

                        </div>
                        <table style="font-size: 10px; margin-left: 4px; margin-top: -25px;">
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-1">For Use in Payment of Advance</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-2">Certified the Advance of</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-3">&#8358; ...........................</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-4">has been entered on TF 174 (A) (B) or (C)</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-5">Deptal No:.............................</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-6">Signature:.............................</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="vertical-text v-align-7">Name in Block Letters ................</div>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered text-center table-condensed" style="font-size: 10px">
                            <tbody>
                                <tr>
                                    <td colspan="4">Date Type 3</td>
                                    <td colspan="4">4 Source 6</td>
                                    <td colspan="12">7 &nbsp;&nbsp; Voucher Number &nbsp; &nbsp; 14</td>
                                </tr>
                                <tr>
                                    <td colspan="4">VO 1</td>
                                    <td>0</td>
                                    <td>9</td>
                                    <td colspan="2">1</td>
                                    <td>R</td>
                                    <td>E</td>
                                    <td>X</td>
                                    <td>1</td>
                                    <td colspan="2"></td>
                                    <td colspan="2"></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
                                </tr>

                                <tr>
                                    <td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"></td>
                                    <td colspan="14">
                                        <b>&#8358;{{ number_format($list->totalPayment, 2, '.', ',') }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        6 Source 8 <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td colspan="16"> Classification Code </td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td>0</td>
                                    <td>3</td>
                                    <td>1</td>
                                    <td>8</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>8</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>1</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td colspan="8">{{ $list->Code }} {{ $list->economicCode }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-3 input-sm">
                        <table class="table table-bordered input-sm" style="font-size: 9px">
                            <tr>
                                <td colspan="2">
                                    <div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abuja</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Head</td>
                                <td>{{ $list->Code }}</td>
                            </tr>
                            <tr>
                                <td>S/Head</td>
                                <td>{{ $list->Code }} {{ $list->economicCode }}</td>
                            </tr>
                        </table>

                    </div>
                </div>

                <div style="margin-bottom: 2px;">
                    <div style="text-decoration: none; border-bottom: 2px dotted #000;">
                        Payee: &nbsp;&nbsp;&nbsp; <span class="input-lg">
                            @if ($list->companyID == 13)
                                {{ $list->payment_beneficiary }}
                            @else
                                {{ $list->payment_beneficiary }}
                            @endif
                        </span>
                    </div>

                    <div style="text-decoration: none;border-bottom: 2px dotted #000;">
                        Address: &nbsp;&nbsp;&nbsp; <span class="input-lg"><small>
                                {{ $list->address }}
                            </small></span>
                    </div>
                </div>

                <table class="table table-condensed table-bordered text-center input-sm">
                    <thead>
                        <tr class="input-lg">
                            <th>Date</th>
                            <th>Detailed Description of Service/Works</th>
                            <th>Rate</th>
                            <th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="3" width="150">
                                {{ date_format(date_create($list->datePrepared), 'd-m-Y') }}
                                <div class="vertical-text vert-text">
                                    <p> ENTER IN THE VOTEBOOK</p>
                                    <p> <span>LINE_____</span><span>PAGE______</span></p>
                                    <p> <span>SIGN_____</span><span>DATE______</span></p>
                                </div>
                            </td>
                            <td rowspan="2" width="650">
                                <div align="left">
                                    <small>{{ $list->paymentDescription }}</small>

                                    <div style="padding: 4px 0px">
                                    </div>

                                    <div style="" class="">
                                        <table class="input-sm ">

                                            <tr>
                                                <td style="border: none !important;" width="200">
                                                    <div align="left">Amount Payable</div>
                                                </td>
                                                <td style="border: none !important;">
                                                    <div
                                                        style="border-bottom: 2px solid #000; border-top: 2px solid #000;">
                                                        &#8358;{{ number_format($list->amtPayable, 2, '.', ',') }}</div>
                                                </td>
                                            </tr>



                                        </table>
                                    </div>

                                    <div>I certify that the expenditure was incured in the interest of Public Service.</div>
                                    <div align="center">
                                        <b>
                                            @php
                                                $strArray = explode('and', $list->contractor);
                                                $payee = $strArray[0];
                                            @endphp
                                            @php

                                            @endphp
                                            @if ($list->contractType == 4)
                                                {{ 'Mr. Ahmed Gambo Saleh (Secretary)' }}
                                            @else
                                            @endif
                                        </b>
                                    </div>
                                </div>

                            </td>
                            <td rowspan="2"></td>
                            <td height="20">
                                <b><big>{{ number_format($list->totalPayment, 2, '.', ',') }}</big></b>
                                <?php $amtpayable = $list->amtPayable; ?>
                                <div class="close-account"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="linedia"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">Checked and Passed for
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span id="result"></span>
                                </div>
                                <br />
                            </td>
                            <td width="100">Total &#8358;</td>
                            <td><big>{{ number_format($list->amtPayable, 2, '.', ',') }}</big></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="row">
                                    <div align="left" class="col-xs-5">
                                        <div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
                                            <h6>Payable at: <strong>SCN</strong></h6>
                                            <h6>Signature: <strong></strong></h6>
                                            <h6>Name: <strong>
                                                    @if ($checkBy != '')
                                                        {{ $checkBy->name }}
                                                    @endif
                                                </strong></h6>
                                            <h6>Station ------------------ </h6>
                                            <h6>Paying Officer Signature: <strong>
                                                    @if ($approvedBy != '')
                                                        {{ $approvedBy->name }}
                                                    @endif
                                                </strong></h6>
                                            <h6>Name ------------------ </h6>

                                            <h6>1. ------------------ </h6>
                                            <h6>2. ------------------------</h6>

                                        </div>
                                    </div>
                                    <div class="col-xs-7" style="font-size: 11px;">
                                        <span class="text-center">CERTIFICATE</span>
                                        <div align="left">
                                            I certify the above amount is correct, and was incurred under the Authority
                                            quoted, that the service have been dully performed; that the rate/price charge
                                            is according to regulations/contract is fair and reasonable: <br />
                                            that the amount of <b><span id="result"></span></b> may be paid under the
                                            Classification quote.
                                        </div>
                                        <div style="text-decoration: underline;">
                                            <b>&nbsp;&nbsp; For Chief Registrar &nbsp;&nbsp;</b>
                                        </div>
                                        <span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
                                        <div>
                                            Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja
                                                &nbsp;&nbsp;</b>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            Date: <b style="text-decoration: underline;">&nbsp;&nbsp;
                                                {{ $list->datePrepared }} &nbsp;&nbsp;</b>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.)
                                                &nbsp;&nbsp;</b>
                                        </div>
                                        <br />
                                        <div align="center">
                                            <span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                                    GW/{{ $list->period }}</b></span>
                                        </div>
                                        <span>Anthy AIE No., etc.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top: -20px; font-size: 8px;">
                    Received from the Federal Government of Nigeria the sum of <span id="result2"
                        style="font-size: 8px;"></span> in full settlement of the Account. <small>
                        Date.................{{ $list->period }}
                        &nbsp;&nbsp;&nbsp;
                        Signature..........
                        &nbsp;&nbsp;
                        Place.............</small>
                </div>
            </div>
            <div class="box-body" style="display:; background: #fff;margin-top: 30px;" id="report3">
                <h3 class="text-center">BENEFICIARIES:{{ $discr }}</h3>
                <div class="col-md-12">
                    @if ($count > 0)
                        <table id="myTables" class="table table-bordered" cellpadding="10">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Beneficiary </th>
                                    <th class="text-center">Amount ( &#8358;)</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php $key = 1; @endphp
                                @foreach ($staff as $s)
                                    <tr>

                                        <td>{{ $key++ }}</td>
                                        <td>{{ $s->beneficiaryDetails }}</td>
                                        <td class="text-center">{{ number_format($s->amount, 2) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <hr class="hidden-print">
    <br /> <br />
    <!-- print and back buttons -->

    <div class="button-wrapper hidden-print" style="margin-bottom: 30px; margin-top:0px;">

        <div class="col-md-2">
            <a href="{{ URL::previous() }}" class="btn btn-success">Go Back</a>
        </div>
        <div class="col-md-2 col-md-offset-8">
            <a href="javascript:void(0)" class="btn btn-success print-window">Print</a>
        </div>

    </div>
    <!-- End print and back buttons -->



    <!--- END VAT VOUCHER --->


@stop


@section('styles')

    <style type="text/css">
        .table td {
            border: #030303 solid 1px !important;
            padding: 2px;
            font-size: 11px;
        }

        .table th {
            border: #030303 solid 1px !important;
        }



        .v-align-1 {
            margin-top: -150px;
            margin-left: -240px;
            width: 500px !important;
        }

        .v-align-2 {
            margin-top: -150px;
            margin-left: -220px;
            width: 500px !important;
        }

        .v-align-3 {
            margin-top: -150px;
            margin-left: -200px;
            width: 500px !important;
        }

        .v-align-4 {
            margin-top: -150px;
            margin-left: -180px;
            width: 500px !important;
        }

        .v-align-5 {
            margin-top: -150px;
            margin-left: -160px;
            width: 500px !important;
        }

        .v-align-6 {
            margin-top: -150px;
            margin-left: -140px;
            width: 500px !important;
        }

        .v-align-7 {
            margin-top: -520px margin-left: -120px;
            width: 200px !important;

        }

        .vertical-text {
            transform: rotate(270deg);
            transform-origin: left bottom 1;
            -moz-transform: rotate(270deg);
            -o-transform: rotate(270deg);
            -webkit-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
            -sand-transform: rotate(270deg);
        }

        .vert-text {
            margin-top: 40px;
            border: 1px solid #333;
        }

        .type {
            border: 0px;
            outline: 0px;
            text-align: right;
            float: right;
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
            text-overflow: '';
            padding-right: 0px;

        }

        @media print {
            .print-voucher {
                display: none;

            }

            #vref {
                border: none;
            }

            #report2 {
                page-break-before: always;
                page-break-inside: avoid;
            }

            #report3 {
                page-break-before: always;
            }
        }
    </style>
@stop

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
    <script type="text/javascript">
        $('.print-window').click(function() {
            window.print();
        });

        //Remove record
        $(document).ready(function() {
            $(".removeRow").click(function() {
                var id = this.id;
                var result = confirm('Are you sure you want to delete the seleted record ?');
                if (result) {
                    $.ajax({
                        url: murl + '/staff-list/voucher/delete/JSON',
                        type: "post",
                        data: {
                            'staffIdList': id,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            location.reload();
                        }
                    })
                }
            });
        });
        // END REMOVE

        //EDIT STAFF BANK DETAILS BY CPO
        $(document).ready(function() {
            $(".editBankDetailsButton").click(function() {
                var id = this.id;
                var bankName = $('#bankName' + id).val();
                var accountNumber = $('#accountNumber' + id).val();
                var sortCode = $('#sortCode' + id).val();
                var staffAmount = $('#staffAmount' + id).val();
                if (result) {
                    $.ajax({
                        url: murl + '/recurrent/update/bank-details-JSON',
                        type: "post",
                        data: {
                            'id': id,
                            'bankName': bankName,
                            'accountNumber': accountNumber,
                            'sortCode': sortCode,
                            'staffAmount': staffAmount,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            location.reload();
                        }
                    })
                }
            });
        });
        //CPO

        //SELECT/DESELECT ALL CHECKBOX
        $(document).ready(function() {
            $('#globalCheckbox').click(function() {
                if ($(this).prop("checked")) {
                    $(".checkBox").prop("checked", true);
                } else {
                    $(".checkBox").prop("checked", false);
                }
            });
        });
    </script>
    <!--Convert Number to word -->
    <script type="text/javascript">
        var amount = "";
        var amount = "<?php echo number_format($amtpayable, 2, '.', ''); ?>";
        var money = amount.split('.'); //

        //VAT
        var amountVAT = "";
        var amountVAT = "<?php echo number_format($list->VATValue, 2, '.', ''); ?>";
        var moneyVAT = amountVAT.split('.');

        //TAX
        var amountTAX = "";
        var amountTAX = "<?php echo number_format($list->WHTValue, 2, '.', ''); ?>";
        var moneyTAX = amountTAX.split('.');

        function lookup() {
            //Main Voucher
            var words;
            var naira = money[0];
            var kobo = money[1];
            var word1 = toWords(naira) + "naira";
            var word2 = ", " + toWords(kobo) + " kobo";
            if (kobo != "00")
                words = word1 + word2;
            else
                words = word1;
            //
            var getWord = words.toUpperCase();
            var parternRule1 = /HUNDRED AND NAIRA/ig;
            var parternRule2 = /HUNDRED AND THOUSAND NAIRA/ig;
            var instance1 = parternRule1.test(getWord);
            var instance2 = parternRule2.test(getWord);
            if ((instance1)) {
                document.getElementById('result').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
                document.getElementById('result2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
            } else if ((instance2)) {
                document.getElementById('result').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
                document.getElementById('result2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
            } else {
                document.getElementById('result').innerHTML = getWord;
                document.getElementById('result2').innerHTML = getWord;
            }
            //

            //VAT
            var wordVATs;
            var naira = moneyVAT[0];
            var kobo = moneyVAT[1];
            var word1 = toWords(naira) + "naira";
            var word2 = ", " + toWords(kobo) + " kobo";
            if (kobo != "00")
                wordVATs = word1 + word2;
            else
                wordVATs = word1;
            //
            var getWord = wordVATs.toUpperCase();
            var parternRule1 = /HUNDRED AND NAIRA/ig;
            var parternRule2 = /HUNDRED AND THOUSAND NAIRA/ig;
            var instance1 = parternRule1.test(getWord);
            var instance2 = parternRule2.test(getWord);
            if ((instance1)) {
                document.getElementById('resultVAT').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
                document.getElementById('resultVAT2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
            } else if ((instance2)) {
                document.getElementById('resultVAT').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
                document.getElementById('resultVAT2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
            } else {
                document.getElementById('resultVAT').innerHTML = getWord;
                document.getElementById('resultVAT2').innerHTML = getWord;
            }
            //

            //TAX
            var wordTAXs;
            var naira = moneyTAX[0];
            var kobo = moneyTAX[1];
            var word1 = toWords(naira) + "naira";
            var word2 = ", " + toWords(kobo) + " kobo";
            if (kobo != "00")
                wordTAXs = word1 + word2;
            else
                wordTAXs = word1;
            //
            var getWord = wordTAXs.toUpperCase();
            var parternRule1 = /HUNDRED AND NAIRA/ig;
            var parternRule2 = /HUNDRED AND THOUSAND NAIRA/ig;
            var instance1 = parternRule1.test(getWord);
            var instance2 = parternRule2.test(getWord);
            if ((instance1)) {
                document.getElementById('resultTAX').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
                document.getElementById('resultTAX2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
            } else if ((instance2)) {
                document.getElementById('resultTAX').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
                document.getElementById('resultTAX2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
            } else {
                document.getElementById('resultTAX').innerHTML = getWord;
                document.getElementById('resultTAX2').innerHTML = getWord;
            }
            //

        }
    </script>

    <script>
        $(document).ready(function() {
            $("#vref").blur(function() {
                var transactionID = $(this).attr('transid');
                var vref = $(this).val();
                // alert(batch);
                $.ajax({
                    url: murl + '/update/vrefNo',
                    type: "post",
                    data: {
                        'transactionID': transactionID,
                        'vref': vref,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(datas) {
                        console.log(datas.previous);
                        if (datas.check > 0) {
                            $("#vref").css("border", "5px solid red");
                            $("#vref").val(datas.previous);
                        } else {
                            $(".vrefNo").html(datas.vref_no)
                        }


                    }
                });

            });
        });
    </script>

@stop
