@extends('layouts.layout')
@section('pageTitle')
    {{ strtoupper(' You can print your voucher here') }}
@endsection
@section('content')

    <!--PAYMENT VOUCHER-->
    <div class="box-body" id="main" style="background: #fff;">
        <div style="margin: 0 10px;">
            <div class="row">
                <form action="/create/personnel-voucher" method="POST">
                    {{ csrf_field() }}
                    <div class="col-xs-12">
                        <div class="box-body">
                            <div align="center">
                                <h4>
                                    <div class="make-bold">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <h4 class="text-center">{{ strtoupper('FEDERAL GOVERNMENT OF NIGERIA') }}</h4>

                                        <div>
                                            <h4><b>{{ strtoupper('PAYMENT VOUCHER') }}</b></h4>
                                        </div>

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
                                        <div class="clearfix"></div>
                                        <span class="pull-right"><small> Treasury F1 </small></span><br />
                                    </div>
                                </h4>

                            </div>

                            <div align="center" style="font-weight: 100">
                                Departmental No. <b>SCN/PE/<input type="text" class="noborder"
                                        datePrepaid="{{ date_format(date_create($personnelVoucher->datePrepared), 'Y') }}"
                                        style="border:none; width:50px !important;" transid="{{ $personnelVoucher->ID }}"
                                        id="vref" name="vref"
                                        value="@if ($vRef) {{ $vRef }} @elseif($transactionRef) {{ $transactionRef }} @endif" />/{{ date('Y', strtotime(trim($personnelVoucher->datePrepared))) }}</b>.
                                Checked and passed for payment at <b>Abuja</b>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row" style="margin-top: -3px;">

                <div class="col-xs-3 sidetblock">
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
                                <td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;</td>
                                <td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="14">
                                    <b>&#8358;{{ number_format($personnelVoucher->totalPayment, 2, '.', ',') }}</b>
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
                                <td>1</td>
                                <td>0</td>
                                <td>0</td>
                                <td>1</td>
                                <td>0</td>
                                <td>0</td>
                                <td colspan="8"> {{ substr($economicHead, 0, 4) }}
                                    {{ $personnelVoucher->economicCode }}
                                </td>
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
                            <td>031</td>
                        </tr>
                        <tr>
                            <td>S/Head</td>
                            <td> {{ substr($economicHead, 0, 4) }} {{ $personnelVoucher->economicCode }} </td>
                        </tr>
                    </table>

                </div>
            </div>

            <div style="margin-bottom: 2px;">
                <div style="text-decoration: none; border-bottom: 2px dotted #000;">
                    Payee: &nbsp;&nbsp;&nbsp; <span class="input-lg">
                        {{ $personnelVoucher->payment_beneficiary }}
                    </span>
                </div>

                <div style="text-decoration: none;border-bottom: 2px dotted #000;">
                    Address: &nbsp;&nbsp;&nbsp; <span class="input-lg"><small>
                            {{-- {{$personnelVoucher->payee_address}} --}}
                            <input type="text" value="{{ $personnelVoucher->payee_address }}"
                                transid="{{ $personnelVoucher->ID }}" id="payeeAddress"
                                style="border:none; width:90% !important;">
                        </small></span>
                </div>
            </div>

            <table class="table table-condensed table-bordered text-center input-sm">
                <thead>
                    <tr class="input-lg">
                        <th>Date</th>
                        <th>Detailed Description of Service/Work</th>
                        <th>Rate</th>
                        <th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="3" width="150">
                            {{ $personnelVoucher->datePrepared }}
                            <div class="vertical-text vert-text">
                                <p> ENTER IN THE VOTEBOOK</p>
                                <p> <span>LINE_____</span><span>PAGE______</span></p>
                                <p> <span>SIGN_____</span><span>DATE______</span></p>
                            </div>
                        </td>
                        <td rowspan="2" width="650">
                            <div align="left">
                                <small>{{ $personnelVoucher->paymentDescription }}</small>
                                <div style="padding: 4px 0px">
                                    <b>SCN/  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; /  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; refers.</b>
                                </div>

                                <div style="" class="">
                                    <table class="input-sm ">

                                        <tr>
                                            <td style="border: none !important;" width="200">
                                                <div align="left">Amount Payable</div>
                                            </td>
                                            <td style="border: none !important;">
                                                <div style="border-bottom: 2px solid #000; border-top: 2px solid #000;">
                                                    &#8358;{{ number_format($personnelVoucher->totalPayment, 2, '.', ',') }}
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div>I certify that the expenditure was incured in the interest of Public Service.</div>
                            </div>

                        </td>
                        <td rowspan="2"></td>
                        <td height="20">
                            <big>{{ number_format($personnelVoucher->totalPayment, 2, '.', ',') }}</big>
                            <?php $amtpayable = $personnelVoucher->totalPayment; ?>
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
                        <td><b><big>{{ number_format($personnelVoucher->totalPayment, 2, '.', ',') }}</big></b></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="row">
                                <div align="left" class="col-xs-5">
                                    <div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
                                        <h6>Payable at: <strong>SCN</strong></h6>
                                        <h6>Initiated By: <strong></strong></h6>
                                        <h6>Prepared By: <strong>{{ $personnelVoucher->name }}</strong></h6>
                                        <h6>Passed By: <strong></strong></h6>
                                        <h6>Liability Taken By: <strong></strong></h6>
                                        <h6>Checked By: <strong></strong></h6>
                                        <h6>Audited By: <strong></strong> </h6>

                                        <h6>Station: <strong>ABUJA</strong></h6>

                                        <h6>Name: ------------------ </h6>

                                        <h6>1. ------------------ </h6>
                                        <h6>2. ------------------------</h6>

                                    </div>
                                </div>
                                <div class="col-xs-7" style="font-size: 11px;">
                                    <span class="text-center">CERTIFICATE</span>
                                    <div align="left">
                                        I certify the above amount is correct, and was incurred under the Authority quoted,
                                        that the service have been dully performed; that the rate/price charge is according
                                        to regulations/contract is fair and reasonable: <br />
                                        that the amount of <b><span id="result3"></span></b> may be paid under the
                                        Classification quote.
                                    </div>
                                    <div style="text-decoration: underline;">
                                        <b>&nbsp;&nbsp; For Chief Registrar &nbsp;&nbsp;</b>
                                    </div>
                                    <span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
                                    <div>
                                        Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja &nbsp;&nbsp;</b>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        Date: <b style="text-decoration: underline;">&nbsp;&nbsp;
                                            {{ $personnelVoucher->datePrepared }} &nbsp;&nbsp;</b>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.)
                                            &nbsp;&nbsp;</b>
                                    </div>
                                    <br />
                                    <div align="center">

                                        <span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GW/
                                            </b></span>
                                    </div>
                                    <span>Anthy AIE No., etc.</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top: -20px; font-size: 8px;" class="vMainPage">
                Received from the Federal Government of Nigeria the sum of <span id="result2"
                    style="font-size: 8px;"></span> in full settlement of the Account. <small>
                    Date.................{{ '$list->period' }}
                    &nbsp;&nbsp;&nbsp;
                    Signature..........
                    &nbsp;&nbsp;
                    Place.............</small>
            </div>


            <div class="row">
                {{-- <div class="col-md-4 goBack">
        <div class="form-group">
            <label for=""></label>
            <div align="left">
				<a href="/create/personnel-voucher" class="btn btn-warning">Go back</a>
            </div>
        </div>
    </div> --}}

                {{-- <div class="col-md-4 createVoucher">
        <div class="form-group">
            <label for=""></label>
            <div align="center">

                    <input type="hidden" name="cID" value="{{$personnelVoucher->ID}}">
                    <input type="hidden" name="fileno" value="{{$personnelVoucher->FileNo}}">
                    <input type="hidden" name="contracttype" value="{{$personnelVoucher->contract_Type}}">
                    <input type="hidden" name="cDesc" value="{{$personnelVoucher->ContractDescriptions}}">
                    <input type="hidden" name="cValue" value="{{$personnelVoucher->totalPayment}}">
                    <input type="hidden" name="cBene" value="{{$personnelVoucher->payment_beneficiary}}">
                    <input type="hidden" name="cName" value="{{$personnelVoucher->name}}">
                    <input type="hidden" name="eco_code" value="{{$personnelVoucher->eco_code}}">
                    <input type="hidden" name="awaitActBy" value="{{$personnelVoucher->awaitingActionby}}">
					<input type="hidden" name="payee_address" value="{{$personnelVoucher->payee_address}}">
					@php
					// $cIdExists = DB::table('tblpaymentTransaction')->where('contractID', $personnelVoucher->ID)->first();
					@endphp
					@if (!$cIdExists)
                    	<button type="submit" name="ssvoucher" class="btn btn-success">Process</button>
					@endif

            </div>
        </div>
    </div> --}}

                </form>

                <div class="print-voucher">
                    <div class="form-group">
                        <label for=""></label>
                        <div align="left">
                            <a href="javascript:void(0)" class="btn btn-primary print-window">Print</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!---////////////////////// End PAYMENT VOUCHER-->


    <!--- END VAT VOUCHER --->

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

        .tf {
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

        .make-bold h4 {
            font-weight: 700;
        }

        @media print {
            .print-voucher {
                display: none;
            }

            .goBack {
                display: none;
            }

            .createVoucher {
                display: none;
            }

            .vMainPage {
                page-break-inside: avoid;
            }

            #vref {
                border: none;
            }

            #payeeAddress {
                border: none;
            }
        }
    </style>

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#vref").blur(function() {
                var transactionID = $(this).attr('transid');
                var datePrepaid = $(this).attr('datePrepaid');
                var vref = $(this).val();
                //    alert(vref);
                $.ajax({
                    url: murl + '/update/vrefNo',
                    type: "post",
                    data: {
                        'transactionID': transactionID,
                        'vref': vref,
                        'datePrepaid': datePrepaid,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(datas) {
                        console.log(datas.previous);
                        console.log(datas);
                        if (datas.check > 0) {
                            $("#vref").css("border", "5px solid red");
                            $("#vref").val(datas.previous);
                        } else {
                            $(".vrefNo").html(datas.vref_no)
                        }


                    }
                });

            });

            //update payee address
            $("#payeeAddress").blur(function() {
                var transactionID = $(this).attr('transid');
                var payeeAddress = $(this).val();
                //    alert(payeeAddress);
                $.ajax({
                    url: murl + '/update/payeeAddress',
                    type: "post",
                    data: {
                        'transactionID': transactionID,
                        'payeeAddress': payeeAddress,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(datas) {
                        console.log(datas.msg);
                    }
                });

            });

        });
    </script>

    <!--Convert Number to word -->
    <script type="text/javascript">
        var amount = "";
        var amount = "<?php echo number_format($amtpayable, 2, '.', ''); ?>";
        var money = amount.split('.');

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
                document.getElementById('result3').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
                document.getElementById('result2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
            } else if ((instance2)) {
                document.getElementById('result').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
                document.getElementById('result3').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
                document.getElementById('result2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
            } else {
                document.getElementById('result').innerHTML = getWord;
                document.getElementById('result3').innerHTML = getWord;
                document.getElementById('result2').innerHTML = getWord;
            }
            //

        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.print-window').click(function() {
                window.print();
            });
        })
    </script>
@endsection
@endsection

@endsection
