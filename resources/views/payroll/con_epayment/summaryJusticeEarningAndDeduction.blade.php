@extends('layouts.layout')
@section('content')




    <div class="payroll-container">

        <h3 class="title-header">{{ $courtName }}</h3>

        <p><strong>MONTH ENDING:</strong> {{ $month }} {{ $year }}</p>

        <div class="sub-title">Summary of Payroll Earning and Deduction by Bank (JUSTICE)</div>

        <h4 class="section-title">{{ $bankName }}</h4>
        <h4 class="section-title">Earnings / Allowances</h4>

        <table>
            <thead>
                <tr>
                    <th>Pay Classifications</th>
                    <th style="text-align:right">Total Amount</th>
                </tr>
            </thead>
            <tbody>

                @if ($sumBs > 0)
                    <tr>
                        <td>CONSOLIDATED SALARY</td>
                        <td align="right">{{ number_format($sumBs, 2) }}</td>
                    </tr>
                @endif

                @if ($sumPecfg > 0)
                    <tr>
                        <td>FED GOVT PECULIAR ALLOWANCE</td>
                        <td align="right">{{ number_format($sumPecfg, 2) }}</td>
                    </tr>
                @endif

                @if ($arrears > 0)
                    <tr>
                        <td>ARREARS</td>
                        <td align="right">{{ number_format($arrears, 2) }}</td>
                    </tr>
                @endif


                @if ($sumPec > 0)
                    <tr>
                        <td>JUSUN PECULIAR ALLOWANCE</td>
                        <td align="right">{{ number_format($sumPec, 2) }}</td>
                    </tr>
                @endif



                {{-- DYNAMIC EARNINGS --}}
                @foreach ($dynamicEarnings as $row)
                    @if ($row['amount'] > 0)
                        <tr>
                            <td>{{ strtoupper($row['description']) }}</td>
                            <td align="right">{{ number_format($row['amount'], 2) }}</td>
                        </tr>
                    @endif
                @endforeach

                <tr class="total-row">
                    <td>Total for Earnings / Allowances</td>
                    <td align="right">{{ number_format($totalEarnings, 2) }}</td>
                </tr>
            </tbody>
        </table>


        <h4 class="section-title">Deductions</h4>

        <table>
            <thead>
                <tr>
                    <th>Pay Classifications</th>
                    <th style="text-align:right">Total Amount</th>
                </tr>
            </thead>

            <tbody>



                @foreach ($dynamicDeductions as $row)
                    @if ($row['amount'] > 0)
                        <tr>
                           <td>{{ strtoupper($row['description']) }}</td>
                            <td align="right">{{ number_format($row['amount'], 2) }}</td>
                        </tr>
                    @endif
                @endforeach

                @if ($nhf > 0)
                    <tr>
                        <td>NATIONAL HOUSING FUND</td>
                        <td align="right">{{ number_format($nhf, 2) }}</td>
                    </tr>
                @endif

                @if ($pen > 0)
                    <tr>
                        <td>PENSION CONTRIBUTION</td>
                        <td align="right">{{ number_format($pen, 2) }}</td>
                    </tr>
                @endif



                @if ($tax > 0)
                    <tr>
                        <td>TAX (PAYEE)</td>
                        <td align="right">{{ number_format($tax, 2) }}</td>
                    </tr>
                @endif


                @if ($ud > 0)
                    <tr>
                        <td>UNION DUES</td>
                        <td align="right">{{ number_format($ud, 2) }}</td>
                    </tr>
                @endif


                <tr class="total-row">
                    <td>Total Deductions</td>
                    <td align="right">{{ number_format($totalDeductions, 2) }}</td>
                </tr>

                <tr class="net-row">
                    <td>NET EMOLUMENT</td>
                    <td align="right">{{ number_format($netEmolument, 2) }}</td>
                </tr>

            </tbody>
        </table>


        <div class="hidden-print" style="margin-top:20px;">
            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-success">Print</a>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
@endsection

@section('styles')
    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }

            body {
                font-size: 12px !important;
            }

            table thead th {
                background-color: #333 !important;
                color: #fff !important;
                padding: 6px !important;
                /* text-align: left !important; */
                font-size: 14px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                display: table-cell !important;
            }

            .sub-title {
                background-color: #333 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .net-row td {
                font-weight: bold !important;
                background: #333 !important;
                color: #fff !important;
                font-size: 15px !important;
                border: none !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            table {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .box-body {
                padding: 0 !important;
                margin: 0 !important;
            }
        }





        .payroll-container {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .title-header {
            text-align: center;
            font-weight: 800;
            font-size: 20px;
            margin-bottom: 7px;
        }

        .sub-title {
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            padding: 10px;
            background: #444;
            color: #fff;
        }

        .section-title {
            font-weight: 700;
            font-size: 16px;
            margin-top: 16px;
            margin-bottom: 7px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        table th {
            background: #444;
            color: #fff;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }

        table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }

        .total-row td {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        .net-row td {
            font-weight: bold;
            background: #444;
            color: #fff;
            font-size: 15px;
            border: none;
        }
    </style>
@endsection
