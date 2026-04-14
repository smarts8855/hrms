@extends('layouts.layout')
@section('pageTitle')
    Staff Distribution
@endsection

@section('content')
<style>
    .page-header {
        background: #2c3e50;
        color: white;
        padding: 25px 0;
        margin-bottom: 30px;
        text-align: center;
    }
    .page-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
    }
    .report-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .report-header {
        background: #34495e;
        color: white;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    .table-container {
        padding: 0;
    }
    .zone-header {
        background: #ecf0f1;
        font-weight: 600;
        color: #2c3e50;
    }
    .state-row {
        background: #fafafa;
    }
    .state-row:hover {
        background: #f8f9fa;
    }
    .text-center {
        text-align: center;
    }
    .action-buttons {
        text-align: center;
        margin: 30px 0;
        padding: 20px;
    }
    .btn-primary {
        background: #3498db;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background: #2980b9;
    }
    
    /* Print Styles - Fixed */
    @media print {
        /* Hide navigation, headers, buttons etc. */
        .no-print,
        .page-header,
        .action-buttons,
        nav,
        header,
        footer {
            display: none !important;
        }
        
        /* Show only the main content */
        body {
            visibility: visible;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
        }
        
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
        }
        
        /* Make sure printable content is visible */
        .printable-area {
            display: block !important;
            visibility: visible !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .report-card {
            box-shadow: none !important;
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
            border-radius: 0 !important;
        }
        
        .report-header {
            background: #34495e !important;
            color: white !important;
            padding: 15px !important;
            margin-bottom: 10px !important;
        }
        
        .table-responsive {
            overflow: visible !important;
        }
        
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 12px !important;
        }
        
        th, td {
            border: 2px solid #000 !important; /* Thicker black borders */
            padding: 8px 10px !important;
        }
        
        thead th {
            background: #fff !important; /* Pure black background */
            color: #000 !important;
            font-weight: 900 !important; /* Extra bold */
            font-size: 14px !important; /* Larger font */
            text-align: center !important;
            -webkit-print-color-adjust: exact !important; /* Force colors in print */
            print-color-adjust: exact !important;
        }
        
        .zone-header {
            background: #f0f0f0 !important;
            font-weight: bold !important;
        }
        
        /* Page break handling */
        table { page-break-inside: auto; }
        tr    { page-break-inside: avoid; page-break-after: auto; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
        
        @page {
            margin: 0.5cm;
        }
    }
</style>

<div class="container-fluid">
  
    <div class="printable-area">
        <div class="report-card">
            <div class="report-header">
                <h4 class="mb-0">STAFF DISTRIBUTION BY ZONE</h4>
                <p class="mb-0 mt-2">Staff Distribution by Zones and Categories as at {{ date('d-M-Y') }}</p>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-dark" style="font-weight: 900; background: #000; color: white;">
                            <tr>
                                <th width="8%">S/N</th>
                                <th width="40%">ZONES / STATES</th>
                                <th width="26%" class="text-center">NO. OF STAFF</th>
                                <th width="26%" class="text-center">PERCENTAGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $key = 1 @endphp
                            @foreach ($zones as $zone)
                                @if($zone->gpz !== null && $zone->gpz !== '')
                                <tr class="zone-header">
                                    <td><strong>{{ $key++ }}</strong></td>
                                    <td><strong>{{ $zone->gpz }}</strong></td>
                                    <td class="text-center"><strong>{{ $zone->total }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($zone->percent, 2) }}%</strong></td>
                                </tr>

                                <?php 
                                $getStates = DB::table('tblstates')
                                    ->join('tblper', 'tblper.StateID', '=', 'tblstates.StateID')
                                    ->select('tblstates.State as S', DB::raw('count(tblper.StateID) as total'))
                                    ->where('gpz', $zone->gpz)
                                    ->groupBy('State')
                                    ->get();
                                ?>

                                @foreach ($getStates as $state)
                                <tr class="state-row">
                                    <td></td>
                                    <td style="padding-left: 30px;">{{ $state->S }}</td>
                                    <td class="text-center">{{ $state->total }}</td>
                                    <td class="text-center">
                                        @php
                                            $total = $allStaffs;
                                            $stateTotal = $state->total;
                                            $percent = ($stateTotal * 100) / $total;
                                        @endphp
                                        {{ number_format($percent, 2) }}%
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            @endforeach
                            
                            <!-- Total Row -->
                            <tr style="background: #2c3e50; color: white; font-weight: bold;">
                                <td colspan="2" class="text-end">TOTAL:</td>
                                <td class="text-center">{{ $allStaffs }}</td>
                                <td class="text-center">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="action-buttons no-print">
        <button type="button" class="btn btn-primary" onclick="window.print()">
            Print Report
        </button>
    </div>
</div>
@endsection