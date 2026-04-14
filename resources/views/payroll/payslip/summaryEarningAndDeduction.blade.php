@extends('layouts.layout')
@section('content')
    <div class="box-body" style="background:#FFF;">

        <div class="col-md-12" style="background:#FFF;">
            <section style="background:#FFF;">

                <div align="center">
                    <span class="banner">
                        <h2 style="font-weight: 700;color: green">{{ $courtName }}</h2>
                    </span>
                    <table class="table table-bordered table-condensed" align="right">
                        <tr>
                            <td colspan="4" style="border: 2px solid black !important">
                                <!-- CHANGE: Add conditional check for employment_type -->
                                <div align="center">
                                    <strong style="font-style: ">
                                        @php
                                            // Determine payslip header based on employment_type
                                            if (isset($reports->employment_type)) {
                                                switch ($reports->employment_type) {
                                                    case 1:
                                                        echo 'Civil Servant Payslip for ' . ucfirst($selected_month ?? '');
                                                        break;
                                                    case 2:
                                                        echo 'Justice Payslip for ' . ucfirst($selected_month ?? '');
                                                        break;
                                                    case 6:
                                                        echo 'Chief Registrar Payslip for ' . ucfirst($selected_month ?? '');
                                                        break;
                                                    case 7:
                                                        echo 'Special Assistant Payslip for ' . ucfirst($selected_month ?? '');
                                                        break;
                                                    default:
                                                        echo 'Civil Servant Payslip for ' . ucfirst($selected_month ?? '');
                                                }
                                            } else {
                                                echo 'Civil Servant Payslip for ' . ucfirst($selected_month ?? '');
                                            }
                                        @endphp
                                    </strong>
                                </div>
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
                                    {{-- <span>Grade: <strong> CONSOLIDATED</strong> </span> --}}
                                @else
                                    <!-- CHANGE: Only show grade and step for employment_type 1 -->
                                    @if ($reports->grade !== 1 && $reports->step !== 1 && isset($reports->employment_type) && $reports->employment_type == 1)
                                        <span>Grade Level/Step:
                                            <strong> 
                                                GL{{ $reports->formattedGrade }}S{{ $reports->formattedStep }}
                                            </strong> 
                                        </span>
                                        <br />
                                    @endif
                                @endif

                                Full Name:
                                <strong>{{ $reports->surname . ' ' . $reports->first_name . ' ' . $reports->othernames }}<br />
                                </strong>
                                
                                <!-- ADD DEPARTMENT HERE -->
                                @if(isset($reports->department_name) && !empty($reports->department_name))
                                    Department: <strong>{{ $reports->department_name }}</strong><br />
                                @endif
                                
                                <!-- ADD RANK/DESIGNATION HERE - Now from tblper.designationID -->
                                @if(isset($reports->rank_name) && !empty($reports->rank_name))
                                    Rank: <strong>{{ $reports->rank_name }}</strong><br />
                                @elseif(isset($reports->Designation) && !empty($reports->Designation))
                                    Rank: <strong>{{ $reports->Designation }}</strong><br />
                                @endif

                                <!-- ADD EMPLOYMENT TYPE HERE -->
                                @if(isset($reports->employment_type_name) && !empty($reports->employment_type_name))
                                    Employment Type: <strong>{{ $reports->employment_type_name }}</strong><br />
                                @endif
                                
                                Account No: <strong>
                                    {{ $reports->AccNo }} <br />
                                </strong>Bank Name: <strong> {{ $bank->bank }}
                                </strong><br />
                                Date Printed: <strong> {{ Date('F d, Y') }} </strong><br />
                                Month: <strong> {{ $reports->month }} </strong><br />
                                Year: <strong> {{ $reports->year }} </strong><br />
                </div>
                </td>


                <td colspan="2" width="200" align="right" valign="bottom" style="border: 2px solid black !important">
                    <img src="{{ $reports->passport_url }}" width="150" />
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
                            $earnings = [];
                            if ($reports->Bs != 0) {
                                $earnings['CONSOLIDATED SALARY'] = $reports->Bs;
                            }
                            // 'TOTAL ALLOWANCE' => $totalSum,
                            if ($reports->PEC != 0) {
                                $earnings['PECULIAR'] = $reports->PEC;
                            }
                            if ($reports->PECFG != 0) {
                                $earnings['40% PECULIAR FG'] = $reports->PECFG;
                            }
                            if ($reports->SOT != 0) {
                                $earnings['SPECIAL OVERTIME'] = $reports->SOT;
                            }
                            if ($reports->AEarn != 0) {
                                $earnings['AREARS EARNING'] = $reports->AEarn;
                            }
                            foreach ($other_earn as $list) {
                                if ($list->amount != 0) {
                                    $earnings[strtoupper($list->description)] = $list->amount;
                                }
                            }

                            $deductions = [];
                            if ($reports->TAX != 0) {
                                $deductions['TAX'] = $reports->TAX;
                            }
                            if ($reports->NHF != 0) {
                                $deductions['NHF'] = $reports->NHF;
                            }
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
                                if ($list->amount != 0) {
                                    $deductions[$list->description] = $list->amount;
                                }
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
        <div class="col-md-2 hidden-print" style = "margin-top:20px;"><a href="javascript:0"
                onclick="window.print();return false;" class="btn btn-success">print</a></div>
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
    </style>
    <style type="text/css" media="print">
        .col-xs-6.text-left h3,
        .col-xs-6.text-right h3 {
            font-size: 16px;
        }

        .pr {
            padding: 0px;
        }

        .col-xs-5 {
            width: 48%;
        }

        .lt {
            margin-left: 2%;
        }

        .l .col-xs-6 {
            padding: 0px;
        }
    </style>
@endsection