@extends('layouts.layout')

@section('pageTitle')
    Set Active Month
@endsection


@section('content')








    {{-- <div class="panel panel-success">
        <div class="panel-heading" style="background-color: #f5f5f5; color: #333;">
            <h3 class="panel-title">
                <i class="fa fa-calendar"></i> Set Active Month
            </h3>
        </div>

        <div class="panel-body">
            <form method="post" action="{{ url('/activeMonth/create1') }}" class="form-inline" role="form">
                {{ csrf_field() }}

                @if ($CourtInfo->courtstatus == 1)
                    <div class="form-group" style="margin-right:10px;">
                        <label for="court">Court</label>
                        <select name="court" id="court" class="form-control input-sm" required>
                            <option value="">Select Court</option>
                            @foreach ($courts as $court)
                                @if ($court->id == session('anycourt'))
                                    <option value="{{ $court->id }}" selected>{{ $court->court_name }}</option>
                                @else
                                    <option value="{{ $court->id }}" @if (old('court') == $court->id) selected @endif>
                                        {{ $court->court_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                @endif

                <div class="form-group" style="margin-right:10px; width:30%">
                    <label for="year">Year</label>
                    <select name="year" id="year" class="form-control input-md" style="width: 100%" required>
                        <option value="">Select Year</option>
                        @for ($i = 2010; $i <= 2040; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group" style="margin-right:10px; width:30%">
                    <label for="month">Month</label>
                    <select name="month" id="month" class="form-control input-md" style="width: 100%" required>
                        <option value="">Select Month</option>
                        <option value="JANUARY">January</option>
                        <option value="FEBRUARY">February</option>
                        <option value="MARCH">March</option>
                        <option value="APRIL">April</option>
                        <option value="MAY">May</option>
                        <option value="JUNE">June</option>
                        <option value="JULY">July</option>
                        <option value="AUGUST">August</option>
                        <option value="SEPTEMBER">September</option>
                        <option value="OCTOBER">October</option>
                        <option value="NOVEMBER">November</option>
                        <option value="DECEMBER">December</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-success btn-md">
                    <i class="fa fa-check"></i> Set Active Month
                </button>

            </form>
        </div>
    </div> --}}

    <div class="panel panel-success">
        <div class="panel-heading" style="background-color:#f5f5f5; color:#333;">
            <h3 class="panel-title"><i class="fa fa-calendar"></i> Set Active Month</h3>
        </div>

        <div class="panel-body">
            <form method="post" action="{{ url('/activeMonth/create1') }}" class="form-inline text-center" role="form"
                style="display: flex; align-items: flex-end; justify-content: center; flex-wrap: wrap; gap: 15px;">
                {{ csrf_field() }}

                @if ($CourtInfo->courtstatus == 1)
                    <div class="form-group" style="width: 15%;">
                        <label for="court" class="control-label">Court</label>
                        <select name="court" id="court" class="form-control input-md" style="width: 100%;" required>
                            <option value="">Select Court</option>
                            @foreach ($courts as $court)
                                @if ($court->id == session('anycourt'))
                                    <option value="{{ $court->id }}" selected>{{ $court->court_name }}</option>
                                @else
                                    <option value="{{ $court->id }}" @if (old('court') == $court->id) selected @endif>
                                        {{ $court->court_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" id="court" name="court" value="{{ $CourtInfo->courtid }}">
                @endif

                <div class="form-group" style="width: 30%;">
                    <label for="year" class="control-label">Year</label>
                    <select name="year" id="year" class="form-control input-md" style="width: 100%;" required>
                        <option value="">Select Year</option>
                        @for ($i = 2025; $i <= 2040; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group" style="width: 30%;">
                    <label for="month" class="control-label">Month</label>
                    <select name="month" id="month" class="form-control input-md" style="width: 100%;" required>
                        <option value="">Select Month</option>
                        <option value="JANUARY">January</option>
                        <option value="FEBRUARY">February</option>
                        <option value="MARCH">March</option>
                        <option value="APRIL">April</option>
                        <option value="MAY">May</option>
                        <option value="JUNE">June</option>
                        <option value="JULY">July</option>
                        <option value="AUGUST">August</option>
                        <option value="SEPTEMBER">September</option>
                        <option value="OCTOBER">October</option>
                        <option value="NOVEMBER">November</option>
                        <option value="DECEMBER">December</option>
                    </select>
                </div>

                <div class="form-group" style="margin-top: 23px;">
                    <button type="submit" class="btn btn-success btn-md">
                        <i class="fa fa-check"></i> Set Active Month
                    </button>
                </div>
            </form>
        </div>



    </div>


    <!-- Current Active Month Section -->
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color:#e9ecef; color:#333;">
            <h3 class="panel-title"><i class="fa fa-clock-o"></i> Current Active Month and Year</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Active Month</th>
                        <th>Year</th>
                        <th>Court</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activemonth as $active)
                        <tr>
                            <td>{{ $active->month }}</td>
                            <td>{{ $active->year }}</td>
                            <td>{{ $active->court_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('message'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('message') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#f0f9eb',
                    color: '#2e7d32',
                    customClass: {
                        popup: 'animated fadeInDown'
                    }
                });
            });
        </script>
    @endif
@endsection
