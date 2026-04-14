@extends('layouts.layout')

@section('content')

<div style="margin: 20px">

    <h3 class="text-center"><b>OVERTIME TRIAL</b></h3>

    {{-- ALERTS --}}
    @if(session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    @if(session('err'))
        <div class="alert alert-danger">{{ session('err') }}</div>
    @endif

    {{-- ================= FORM ================= --}}
    <div class="panel panel-default">
        <div class="panel-heading"><b>Run Overtime Trial</b></div>

        <div class="panel-body">
            <form method="POST" action="{{ url('/overtime-trial-run') }}">
                @csrf

                <div class="row">

                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-3" style="margin-top:25px">
                        <button class="btn btn-primary">Run Trial</button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    {{-- ================= SUMMARY ================= --}}
    @if(count($trials) > 0)

        <div class="panel panel-info">
            <div class="panel-body">

                <h4>
                    <b>Title:</b> {{ $trials[0]->overtimeDesc }}, <b>Total Amount:</b> ₦{{ number_format($total, 2) }}
                </h4>

                <div class="text-align-right" style="margin-top:5px">
                    <a href="/create/personnel-voucher/{{$trials[0]->uniqueCode}}" class="btn btn-primary">Initiate Claim</a>
                </div>

            </div>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="panel panel-default">
            <div class="panel-heading"><b>Trial Result</b></div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>File No</th>
                            <th>GL/S</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($trials as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->surname }} {{$row->first_name}} {{$row->othernames ?? $row->othernames}}</td>
                                <td>{{ $row->fileNo }}</td>
                                <td>GL-{{$row->grade}}/S-{{$row->step}}</td>
                                <td>{{$row->description}}/{{$row->hrs}}hrs</td>
                                <td>{{ number_format($row->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    @endif

</div>

@endsection