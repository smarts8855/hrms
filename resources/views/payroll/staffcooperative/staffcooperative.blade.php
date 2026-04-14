@extends('layouts.layout')

@section('pageTitle')
    Staff Earning/Deduction
@endsection

@section('content')

    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <form class="form-horizontal" id="account-info" method="GET">
                {{ csrf_field() }}

                <div class="col-md-12 hidden-print">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !<br></strong> {{ session('err') }}
                        </div>
                    @endif
                </div>

                <p>
                <h2 class="text-success text-center no-print">
                    <strong>STAFF EARNING AND DEDUCTION</strong>
                </h2>
                </p>

                <div class="row no-print">
                    <div class="col-sm-12">
                        <div style="margin: 0px  5%;">
                            <div class="form-group" style="margin-bottom: 5%;">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-6">
                                        <label class="control-label">Control variable</label>
                                        <select class="form-control" name="controlvariable" id="controlvariable">
                                            <option value=""> --Select-- </option>
                                            <option value="1"
                                                {{ isset($EorDSession[0]) && $EorDSession[0]->particularID == 1 ? 'selected' : '' }}>
                                                Earning</option>
                                            <option value="2"
                                                {{ isset($EorDSession[0]) && $EorDSession[0]->particularID == 2 ? 'selected' : '' }}>
                                                Deduction</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">
                                            @if (!empty($EorDSession))
                                                @if ($EorDSession[0]->particularID == 1)
                                                    {{ 'Select Type of Earning' }}
                                                @else
                                                    {{ 'Select Type of Deduction' }}
                                                @endif
                                            @else
                                                Select Type
                                            @endif
                                        </label>
                                        <select class="form-control" name="earnordeduction" id="earnordeduction" required>
                                            <option value=""> --Select-- </option>
                                            @if (!empty($EorDSession))
                                                @foreach ($EorDSession as $ed)
                                                    <option value="{{ $ed->ID }}" 
                                                        {{ $ed->ID == $edses ? 'selected="selected"' : '' }}>
                                                        {{ $ed->description }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">Year</label>
                                        <select class="form-control" name="year" id="year">
                                            <option value=""> --Select Year-- </option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ $selected_year == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">Month</label>
                                        <select class="form-control" name="month" id="month">
                                            <option value=""> --Select Month-- </option>
                                            @foreach($months as $monthNum => $monthName)
                                                <option value="{{ $monthNum }}" {{ $selected_month == $monthNum ? 'selected' : '' }}>
                                                    {{ $monthName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div align="center" class="hidden-print">
                                <hr />
                                <button type="submit" name="staffCooperativeReport" class="btn btn-success">
                                    <i class="fa fa-save"></i> Generate Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($result) && count($result) > 0)
    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <div class="box">
                <!-- Display Selected Period -->
                <div class="alert alert-info text-center no-print">
                    <strong>Report Period: {{ $months[$selected_month] ?? '' }} {{ $selected_year }}</strong>
                </div>

                <!-- Screen View Table -->
                <table class="table table-bordered table-striped table-highlight no-print">
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>Name</th>
                            <th>File No</th>
                            <th>Particular</th>
                            <th>Amount</th>
                            <th>Target Amount</th>
                            <th>Target Balance</th>
                            <th>With limit</th>
                            <th>Period</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $i = 1;
                            $totalAmount = 0;
                        @endphp
                        @foreach ($result as $con)
                            @php 
                                $totalAmount += floatval($con->amount); 
                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $con->surname }} {{ $con->first_name }} {{ $con->othernames }}</td>
                                <td>{{ $con->fileNo ?? 'N/A' }}</td>
                                <td>{{ $con->description }}</td>
                                <td>₦{{ number_format($con->amount, 2, '.', ',') }}</td>
                                <td>
                                    @if(!is_null($con->targetAmount) && $con->targetAmount > 0 && $con->recycling==0)
                                        ₦{{ number_format(floatval($con->targetAmount), 2, '.', ',') }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <td>
                                    @if(!is_null($con->targetAmount) && $con->targetAmount > 0 && $con->recycling==0)
                                        ₦{{ number_format(floatval($con->targetAmount-$con->totaloffset), 2, '.', ',') }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <td>
                                    @if($con->recycling==1)
                                        No
                                    @else
                                        Yes
                                    @endif
                                </td>
                                <td>
                                    {{ $months[$selected_month] ?? '' }} {{ $selected_year }}
                                </td>
                            </tr>
                        @endforeach
                        
                        {{-- Total Row --}}
                        <tr style="font-weight: bold; background-color: #f5f5f5;">
                            <td colspan="4" style="text-align: right;">Total Amount:</td>
                            <td>₦{{ number_format($totalAmount, 2, '.', ',') }}</td>
                            <td colspan="4"></td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Print View (Hidden on screen, shown only when printing) -->
                <div class="print-view" style="display: none;">
                    <div class="print-header" style="text-align: center; margin-bottom: 20px;">
                        @if(isset($result[0]->description))
                            <h3 style="margin-top: 5px; margin-bottom: 20px;">
                                <strong>{{ $result[0]->description }}</strong>
                            </h3>
                        @endif
                        <h4 style="margin-bottom: 15px;">
                            Period: {{ $months[$selected_month] ?? '' }} {{ $selected_year }}
                        </h4>
                    </div>
                    
                    <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                        <thead>
                            <tr style="background-color: #c7c7c7;">
                                <th style="width: 5%; border: 1px solid #000; padding: 8px;">S/N</th>
                                <th style="width: 40%; border: 1px solid #000; padding: 8px;">Name</th>
                                <th style="width: 15%; border: 1px solid #000; padding: 8px;">File No</th>
                                <th style="width: 40%; border: 1px solid #000; padding: 8px;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $i = 1;
                                $printTotalAmount = 0;
                            @endphp
                            @foreach ($result as $con)
                                @php 
                                    $printTotalAmount += floatval($con->amount); 
                                @endphp
                                <tr>
                                    <td style="border: 1px solid #000; padding: 8px;">{{ $i++ }}</td>
                                    <td style="border: 1px solid #000; padding: 8px;">{{ $con->surname }} {{ $con->first_name }} {{ $con->othernames }}</td>
                                    <td style="border: 1px solid #000; padding: 8px;">{{ $con->fileNo ?? 'N/A' }}</td>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: right;">₦{{ number_format($con->amount, 2, '.', ',') }}</td>
                                </tr>
                            @endforeach
                            
                            {{-- Total Row for Print --}}
                            <tr style="font-weight: bold; background-color: #f5f5f5;">
                                <td colspan="3" style="border: 1px solid #000; padding: 8px; text-align: right;">Total Amount:</td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: right;">₦{{ number_format($printTotalAmount, 2, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <hr class="no-print" />
                <button class="btn btn-success print-window no-print">Print</button>
            </div>
        </div>
    </div>
    @elseif(isset($result))
    <div class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <div class="alert alert-warning text-center">
                No records found for {{ $months[$selected_month] ?? '' }} {{ $selected_year }}!
            </div>
        </div>
    </div>
    @endif

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <style type="text/css">
        .autocomplete-suggestions {
            background-color: #eee !important;
            border: 1px solid #c3c3c3 !important;
            padding: 1px 5px !important;
            cursor: Pointer !important;
            overflow: scroll;
        }
        
        /* Print-specific styles */
        @media print {
            /* Hide non-print elements */
            .no-print,
            .no-print * {
                display: none !important;
            }
            
            /* Show print elements */
            .print-view {
                display: block !important;
            }
            
            /* Reset body styles for printing */
            body {
                background: white !important;
                color: black !important;
                font-size: 12pt !important;
                margin: 0 !important;
                padding: 20px !important;
            }
            
            /* Box styling for print */
            .box {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .box-default {
                background: transparent !important;
            }
            
            /* Table styling for print */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 10pt !important;
                margin-bottom: 20px !important;
            }
            
            th, td {
                border: 1px solid #000 !important;
                padding: 6px !important;
            }
            
            th {
                background-color: #f2f2f2 !important;
                font-weight: bold !important;
            }
            
            /* Header styling */
            .print-header h2 {
                font-size: 16pt !important;
                margin-bottom: 10px !important;
            }
            
            .print-header h3 {
                font-size: 14pt !important;
                margin-bottom: 15px !important;
            }
            
            .print-header h4 {
                font-size: 12pt !important;
                margin-bottom: 15px !important;
            }
            
            .print-header p {
                font-size: 11pt !important;
                margin-bottom: 15px !important;
            }
            
            /* Ensure proper page breaks */
            tr {
                page-break-inside: avoid !important;
            }
            
            /* Remove any background colors that might not print well */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }
        
        /* Screen styles - hide print view */
        @media screen {
            .print-view {
                display: none;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.js') }}"></script>
    <script type="text/javascript">
        $('.print-window').click(function() {
            window.print();
        });

        $(document).ready(function() {
            $('#controlvariable').change(function() {
                var controlV = $(this).val();
                $.ajax({
                    url: murl + '/get-earnordeduction',
                    type: "GET",
                    data: {
                        'controlvariable': controlV,
                    },
                    success: function(data) {
                        location.reload(true);
                    }
                });
            });

            $('#earnordeduction').change(function() {
                var ed = $(this).val();
                $.ajax({
                    url: murl + '/get-current-ed',
                    type: "GET",
                    data: {
                        'ed': ed,
                    },
                    success: function(data) {
                        // Optional: You can add a success message here
                    }
                });
            });
        });
    </script>
@endsection