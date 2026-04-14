@extends('layouts.layout')
@section('pageTitle')
    Paid Staff Results
@endsection
@section('content')

<div class="box-body" style="background:#FFF;">
    <div style="clear:both"></div>
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="box box-default" style="border: none;">
    <div class="box-body box-profile" style="margin:0 5px;">
        <h3 class="text-center" style="text-transform:uppercase">
            Paid Staff List - {{ $searchParams['month'] }} {{ $searchParams['year'] }}
        </h3>
        <hr style="border: 2px solid green">

        <!-- Search Summary -->
        <div class="row" style="margin-bottom: 15px; background: #f9f9f9; padding: 10px; border-radius: 4px;">
            <div class="col-md-12">
                <strong>Applied Filters:</strong> 
                @if(empty(array_filter([
                    $searchParams['employment_type'] ?? '', 
                    $searchParams['grade'] ?? '', 
                    $searchParams['step'] ?? '',
                    $searchParams['fileNo'] ?? ''
                ])))
                    <span class="label label-default">No additional filters applied</span>
                @else
                    @if(!empty($searchParams['employment_type']))
                        @php
                            $empType = DB::table('tblemployment_type')->where('id', $searchParams['employment_type'])->first();
                        @endphp
                        <span class="label label-info">Employment Type: {{ $empType->employmentType ?? 'N/A' }}</span>
                    @endif
                    
                    @if(!empty($searchParams['grade']))
                        <span class="label label-info">Grade: {{ $searchParams['grade'] }}</span>
                    @endif
                    
                    @if(!empty($searchParams['step']))
                        <span class="label label-info">Step: {{ $searchParams['step'] }}</span>
                    @endif
                    
                    @if(!empty($searchParams['fileNo']))
                        <span class="label label-info">File No: {{ $searchParams['fileNo'] }}</span>
                    @endif
                @endif
            </div>
        </div>

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <a href="{{ url('con-payrollReport/paid-staff-search') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> New Search
                </a>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fa fa-print"></i> Print
                </button>
                <button onclick="exportToExcel()" class="btn btn-success">
                    <i class="fa fa-file-excel-o"></i> Export to Excel
                </button>
            </div>
        </div>

        @if($paidStaff->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="resultsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>File No</th>
                            <th>Staff Name</th>
                            <th>Employment Type</th>
                            <th>Grade</th>
                            <th>Step</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paidStaff as $index => $staff)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $staff->fileNo }}</td>
                                <td>
                                    {{ $staff->surname }} {{ $staff->first_name }} {{ $staff->othernames }}
                                </td>
                                <td>
                                    @php
                                        $empType = DB::table('tblemployment_type')
                                            ->where('id', $staff->employment_type)
                                            ->first();
                                    @endphp
                                    {{ $empType->employmentType ?? 'N/A' }}
                                </td>
                                <td>{{ $staff->grade }}</td>
                                <td>{{ $staff->step }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-6">
                    <strong>Total Staff Paid: {{ $paidStaff->count() }}</strong>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-default" onclick="$('#filterSummary').toggle()">
                        <i class="fa fa-filter"></i> Show/Hide Applied Filters
                    </button>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center">
                <strong>No paid staff found for the selected criteria</strong>
            </div>
        @endif
    </div>
</div>

@endsection

@section('styles')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .table {
        font-size: 12px;
    }
    .table th {
        background-color: #f4f4f4;
        /* text-align: center; */
        vertical-align: middle;
    }
    .table td {
        /* text-align: center; */
        vertical-align: middle;
    }
    .label-info {
        background-color: #5bc0de;
        margin-right: 5px;
        margin-bottom: 5px;
        padding: 5px 10px;
        font-size: 12px;
        display: inline-block;
    }
    .label-default {
        background-color: #999;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
    }
    @media print {
        .btn, .alert, .box-header, .row:first-child {
            display: none !important;
        }
        table {
            font-size: 10px;
        }
        .label-info, .label-default {
            display: none;
        }
    }
</style>
@endsection

@section('scripts')
<script>
function exportToExcel() {
    var table = document.getElementById('resultsTable');
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html);
    var link = document.createElement('a');
    link.download = 'paid_staff_{{ $searchParams['month'] }}_{{ $searchParams['year'] }}.xls';
    link.href = url;
    link.click();
}
</script>
@endsection