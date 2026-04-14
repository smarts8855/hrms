<div align="center">
    <h4 class="text-success text-center"> <b>TREASURY CASH BOOK</b> </h4>
</div>
<br />
<div class="row">
    <div align="center" class="col-md-4">
        <b>---------------------------------------------</b> <br />
        <small> <b>(Insert Department and Station)</b> </small>
    </div>
    <div align="center" class="col-md-3">
        <b>DATE .......... {{ strtoupper($getMonthAndYearFrom) }} ..........</b>
    </div>
    <div align="center" class="col-md-3">
        <b>DATE .......... {{ strtoupper($getMonthAndYearTo) }} ..........</b>
    </div>
    <div align="center" class="col-md-2">
        <b>TRY153A</b>
    </div>
</div>
<br />
<table class="table table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th>
                <div align="center"><b>Date</b></div>
            </th>
            <th>
                <div align="center"><b>No. of Voucher</b></div>
            </th>
            <th>
                <div align="center"><b>From Whom Received</b></div>
            </th>
            <th>
                <div align="center"><b>Description of Receipt</b></div>
            </th>
            <th>
                <div align="center"><b>NCOA</b></div>
            </th>
            <th>
                <div align="center"><b>No. of Treasury</b></div>
            </th>
            <th colspan="2">
                <div align="center"><b>TSA/BANK</b></div>
            </th>
            <th></th>
            <th>
                <div align="center"><b>Date</b></div>
            </th>
            <th>
                <div align="center"><b>No. of Voucher</b></div>
            </th>
            <th>
                <div align="center"><b>DVBN</b></div>
            </th>
            <th>
                <div align="center"><b>Beneficiary</b></div>
            </th>
            <th>
                <div align="center"><b>Description of Payment</b></div>
            </th>
            <th>
                <div align="center"><b>NCOA</b></div>
            </th>
            <th colspan="2">
                <div align="center"><b>TSA/BANK</b></div>
            </th>
        </tr>
    </thead>
    <tbody>
        @if (count($allPaymentRefund) < count($allPaymentMadeByCPO))

            @if (count($allPaymentMadeByCPO) > 0)
                @php $countKey = 1; @endphp
                @foreach ($allPaymentMadeByCPO as $paymentByCPO)
                    <tr>
                        @if ($countKey <= count($allPaymentRefund))
                            <td>{{ $date[$countKey] }}</td>
                            <td>{{ $number_of_voucher[$countKey] }}</td>
                            <td>{{ $from_whom_received[$countKey] }}</td>
                            <td width="200">{{ $des_of_receipt[$countKey] }}</td>
                            <td>{{ $economic_code_ncoa[$countKey] }}</td>
                            <td>{{ $number_of_treasury[$countKey] }}</td>
                            <td>{{ number_format($amount_tsa_bank[$countKey], 2, '.', ',') }}</td>
                            <td width="30"></td>
                        @else
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="30"></td>
                        @endif
                        @php $countKey++; @endphp
                        <td width="10"></td>

                        <td>{{ $paymentByCPO->date }}</td>
                        <td>{{ $paymentByCPO->transactionID }}</td>
                        <td width="80">&nbsp;</td>
                        <td width="200">
                            {{ $paymentByCPO->contractor }}
                        </td>
                        <td>
                            {{ substr($paymentByCPO->purpose, 0, 1000) }}
                        </td>
                        <td>
                            {{ ' - ' }}
                        </td>
                        <td>{{ number_format($paymentByCPO->amount, 2, '.', ',') }}</td>
                        <td width="30"></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="17">
                        <div class="text-danger text-center">
                            <big><b> No record found for this selected date !</b></big>
                        </div>
                    </td>
                </tr>
            @endif
        @else
            @if (count($allPaymentRefund) > 0)
                @php $countCPOKey = 1; @endphp
                @foreach ($allPaymentRefund as $listRefund)
                    <tr>
                        <td width="50"> {{ $listRefund->created_at }} </td>
                        <td width="50"> {{ $listRefund->number_of_voucher }} </td>
                        <td width="50"> {{ $listRefund->from_whom_received }} </td>
                        <td width="50"> {{ $listRefund->des_of_receipt }} </td>
                        <td width="50"> {{ $listRefund->economic_code_ncoa }} </td>
                        <td width="50"> {{ $listRefund->number_of_treasury }} </td>
                        <td width="50"> {{ number_format($listRefund->amount_tsa_bank, 2, '.', ',') }} </td>
                        <td width="30"> </td>

                        <td width="10"></td>

                        @if ($countCPOKey <= count($allPaymentMadeByCPO))
                            <td>{{ $dateCPO[$countCPOKey] }}</td>
                            <td>{{ $transactionID[$countCPOKey] }}</td>
                            <td>{{ $dVBN[$countCPOKey] }}</td>
                            <td width="200">{{ $payee[$countCPOKey] }}</td>
                            <td>{{ $description[$countCPOKey] }}</td>
                            <td>{{ $economicCode_NCOA[$countCPOKey] }}</td>
                            <td>{{ number_format($amount_CPO_bank[$countCPOKey], 2, '.', ',') }}</td>
                            <td width="30"></td>
                        @else
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="50"></td>
                            <td width="30"></td>
                        @endif
                        @php $countCPOKey++; @endphp

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="17">
                        <div class="text-danger text-center">
                            <b> No record found for this selected date !</b>
                        </div>
                    </td>
                </tr>
            @endif
        @endif
    </tbody>
</table>

<div align="center" class="hidden-print"><a href="{{ url('create-treasury-report') }}"
        class="btn btn-success hidden-print">Go Back</a> </div>
