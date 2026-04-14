@extends('layouts.layout')

@section('pageTitle')
    Voucher Parameters List
@endsection

@section('styles')
<style>
    .section-card {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
        background: #fff;
        border-radius: 4px;
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 16px;
        color: #2c3e50;
    }

    .table th, .table td {
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3>Voucher Parameters List</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach($sections as $sectionName => $sectionRows)
            <div class="section-card">
                <div class="section-title">{{ $sectionName }}</div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Grade</th>
                            {{-- <th>Step</th> --}}
                            {{-- <th>Employee Type</th> --}}
                            {{-- <th>HR Employment Type</th> --}}
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sectionRows as $row)
                            <tr>
                                <td>{{ $row->gradelevel }}</td>
                                {{-- <td>{{ $row->step ?? '-' }}</td> --}}
                                {{-- <td>{{ $row->employee_type }}</td> --}}
                                {{-- <td>{{ $row->hr_employment_type ?? '-' }}</td> --}}
                                <td>{{ number_format($row->totalamount) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach

    </div>
</div>

@endsection
