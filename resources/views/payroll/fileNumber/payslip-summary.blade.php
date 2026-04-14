@extends('layouts.loginlayout')
@section('pageTitle')
    Payslip - {{ $month }} {{ $year }}
@endsection
@section('content')
    <div class="box-body" style="background:#FFF;">

        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="background:#FFF;">
                <section style="background:#FFF;">

                    <div align="center">
                        <span class="banner">
                            <h2 style="font-weight: 700;color: green">{{ $courtName }}</h2>
                        </span>
                        <table class="table table-bordered table-condensed" align="right">
                            <tr>
                                <td colspan="4" style="border: 2px solid black !important">
                                    <div align="center"><strong>STAFF PAY SLIP</strong></div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" width="300" style="border: 2px solid black !important">
                                    @if ($reports->grade == 1 && $reports->step == 1)
                                        <div align="left">
                                    @else
                                        <div align="left">File No: <strong>{{ $reports->fileNo }} </strong>
                                    @endif
                                    {{-- @if ($reports->employee_type == 3) --}}
                                    @if ($reports->employee_type == 2)
                                        <span>Grade: <strong> CONSOLIDATED</strong> </span>
                                    @else
                                        @if ($reports->grade !== 1 && $reports->step !== 1)
                                            <span>Grade<strong> {{ $reports->staffGrade }} </strong> </span>
                                            <span>Step: <strong> {{ $reports->staffStep }} </strong> </span>
                                            <br />
                                        @endif
                                    @endif

                                    Full Name:
                                    <strong>{{ $reports->surname . ' ' . $reports->first_name . ' ' . $reports->othernames }}<br />
                                    </strong>Account No: <strong>
                                        {{ $reports->AccNo }} <br />
                                    </strong>Bank Name: <strong> {{ $bank->bank }}
                                    </strong><br />
                                    Date Printed: <strong> {{ Date('F d, Y') }} </strong><br />
                                    Month: <strong> {{ $reports->month }} </strong><br />
                                    Year: <strong> {{ $reports->year }} </strong><br />
                                </div>
                                </td>

                                <td colspan="2" width="200" align="right" valign="bottom" style="border: 2px solid black !important">
                                    <img src="{{ $reports->passport_url }}" width="200" height="200"/>
                                </td>
                            </tr>
                    </table>


                    @php
                        // Summing all other earnings aside from Basic Salary
                        $sumOfOtherEarn = 0;
                        if (!empty($other_earn)) {
                            foreach ($other_earn as $list) {
                                $sumOfOtherEarn += $list->amount;
                            }
                        }

                        // Calculate total earnings sum
                        $totalSum = ($reports->AEarn ?? 0) + ($reports->SOT ?? 0) + $sumOfOtherEarn + ($reports->PEC ?? 0);
                    @endphp

                    <table border="1"
                        style="width: 100%; border-collapse: collapse; text-align: left; border: 2px solid black;">
                        <thead>
                            <tr>
                                <th style="width: 40%; padding: 10px; border: 1px solid black;">EARNINGS</th>
                                <th style="width: 10%; padding: 10px; border: 1px solid black; text-align: center;">AMOUNT</th>
                                <th style="width: 40%; padding: 10px; border: 1px solid black;">DEDUCTIONS</th>
                                <th style="width: 10%; padding: 10px; border: 1px solid black; text-align: center;">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $earnings = [
                                    'BASIC SALARY' => $reports->Bs,
                                    // 'TOTAL ALLOWANCE' => $totalSum,
                                    'PECULIAR' => $reports->PEC,
                                    '40% PECULIAR FG' => $reports->PECFG,
                                ];
                                if ($reports->SOT != 0) {
                                    $earnings['SPECIAL OVERTIME'] = $reports->SOT;
                                }
                                if ($reports->AEarn != 0) {
                                    $earnings['AREARS EARNING'] = $reports->AEarn;
                                }
                                foreach ($other_earn as $list) {
                                    $earnings[strtoupper($list->description)] = $list->amount;
                                }

                                $deductions = [
                                    'TAX' => $reports->TAX,
                                    'NHF' => $reports->NHF,
                                ];
                                if ($reports->PEN != 0) {
                                    $deductions['PENSION'] = $reports->PEN;
                                }
                                if ($reports->UD != 0) {
                                    $deductions['UNION DUES'] = $reports->UD;
                                }
                                if ($reports->AD != 0) {
                                    $deductions['AREARS DEDUCTION'] = $reports->AD;
                                }
                                foreach ($other_deduct as $list) {
                                    $deductions[$list->description] = $list->amount;
                                }
                            @endphp

                            @php $maxRows = max(count($earnings), count($deductions)); @endphp

                            @for ($i = 0; $i < $maxRows; $i++)
                                <tr>
                                    <td style="padding: 8px; border: 1px solid black;">
                                        @php $earningKeys = array_keys($earnings); @endphp
                                        @if (isset($earningKeys[$i]))
                                            <strong>{{ $earningKeys[$i] }}</strong>
                                        @endif
                                    </td>
                                    <td style="text-align: center; padding: 8px; border: 1px solid black;">
                                        @if (isset($earningKeys[$i]))
                                            <strong>{{ number_format($earnings[$earningKeys[$i]], 2, '.', ',') }}</strong>
                                        @endif
                                    </td>
                                    <td style="padding: 8px; border: 1px solid black;">
                                        @php $deductionKeys = array_keys($deductions); @endphp
                                        @if (isset($deductionKeys[$i]))
                                            <strong>{{ $deductionKeys[$i] }}</strong>
                                        @endif
                                    </td>
                                    <td style="text-align: center; padding: 8px; border: 1px solid black;">
                                        @if (isset($deductionKeys[$i]))
                                            <strong>{{ number_format($deductions[$deductionKeys[$i]], 2, '.', ',') }}</strong>
                                        @endif
                                    </td>
                                </tr>
                            @endfor

                            <tr>
                                <td style="padding: 8px; text-align: right; border: 1px solid black;"><strong>TOTAL
                                        EARNING</strong></td>
                                <td style="padding: 8px; text-align: right; border: 1px solid black;">
                                    <strong>{{ number_format($reports->TEarn, 2, '.', ',') }}</strong></td>
                                <td style="padding: 8px; text-align: right; border: 1px solid black;"><strong>TOTAL
                                        DEDUCTION</strong></td>
                                <td style="padding: 8px; text-align: right; border: 1px solid black;">
                                    <strong>{{ number_format($reports->TD, 2, '.', ',') }}</strong></td>
                            </tr>
                            <tr>
                              <td style="padding: 8px; text-align: right; border: 1px solid black;"><strong>
                                NET EMOLUMENT FOR THE MONTH</strong></td>
                              <td style="padding: 8px; text-align: right; border: 1px solid black;">
                                  <strong>{{ number_format($reports->NetPay, 2, '.', ',') }}</strong></td>
                              
                          </tr>
                        </tbody>
                    </table>

            </div>
            <div class="col-md-12" style="padding-left:1px;">

            </div>
            <div class="col-md-12 hidden-print" style="margin-top:20px; margin-bottom: 40px; text-align: center;">
                <a href="javascript:0" onclick="window.print();return false;" class="btn btn-success" style="margin-right: 10px; padding: 10px 28px; font-size: 15px; font-weight: 600;">Print</a>
                <a href="{{ route('payslip.selection') }}" class="btn btn-primary" style="padding: 10px 28px; font-size: 15px; font-weight: 600;">Back</a>
            </div>
            </section>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
@endsection

@section('styles')
    <style type="text/css">
        .table {
            border: 1px solid #000;
            font-size: 16px
        }

        .table thead>tr>th {
            border-bottom: none;
        }

        .table thead>tr>th,
        .table tbody>tr>th,
        .table tfoot>tr>th,
        .table thead>tr>td,
        .table tbody>tr>td,
        .table tfoot>tr>td {
            border: 1px solid #000;
        }

        .slip-wrapper {
            border: 1px solid black;
            padding: 15px;
            width: 100%;
            float: left;
        }

        .border {
            border: 1px solid black;
        }

        .tables {
            margin-top: 20px;
            border: none;
        }

        .tables tr td {
            padding: 15px 6px;
            border: none;
            margin-bottom: 10px;

        }

        /* Button Styles */
        .btn {
            padding: 10px 28px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            border-radius: 6px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
            border: none !important;
        }

        .btn-success {
            background-color: #28a745 !important;
            color: white !important;
        }

        .btn-success:hover {
            background-color: #218838 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-primary {
            background-color: #007bff !important;
            color: white !important;
        }

        .btn-primary:hover {
            background-color: #0069d9 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3);
        }

        /* Fix for footer overlap */
        body {
            min-height: 100vh;
            position: relative;
        }
        
        .box-body {
            min-height: calc(100vh - 100px);
            padding-bottom: 100px;
        }
        
        section {
            min-height: 100%;
            position: relative;
        }

        footer {
            position: static !important;
            margin-top: 50px;
        }

        .footer {
            position: static !important;
            margin-top: 50px;
        }

        @media print {
            .no-print, .hidden-print {
                display: none !important;
            }
            
            .box-body {
                min-height: auto !important;
                padding-bottom: 0 !important;
                height: auto !important;
            }
            
            body {
                min-height: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            section {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            table {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            .col-md-12 {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            /* Ensure everything fits on one page */
            html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            
            /* Remove any forced page breaks */
            .page-break {
                display: none;
            }
            
            /* Ensure proper scaling */
            @page {
                size: auto;
                margin: 10mm;
            }
        }

        @media (max-width: 768px) {
            .btn {
                padding: 8px 20px !important;
                font-size: 14px !important;
                display: block !important;
                width: 100%;
                margin-bottom: 8px;
            }
            
            .col-md-12.hidden-print {
                text-align: center !important;
            }
            
            .btn-success {
                margin-right: 0 !important;
            }
        }
    </style>
@endsection