@extends('layouts.layout')

@section('pageTitle')
    Set Active Month
@endsection


@section('content')
    <div class="box-body" style="background:#FFF;">



        {{-- <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Lock Active Month</h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-inline">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ auth()->user()->divisionID }}">

                    <div class="form-group">
                        <label for="year">Year:</label>
                        <select name="year" id="year" class="form-control" style="margin-right:10px;">
                            <option value="">Select Year</option>
                            @for ($i = 2010; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}"
                                    {{ old('year') == $i || (isset($year) && $year == $i) ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="month">Month:</label>
                        <select name="month" id="month" class="form-control" style="margin-right:10px;">
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

                    <button type="submit" name="process" class="btn btn-success">
                        <i class="fa fa-lock"></i> Lock
                    </button>
                </form>
            </div>
        </div> --}}

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Lock Active Month</h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-inline">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ auth()->user()->divisionID }}">

                    <div class="form-group" style="margin-right: 20px;">
                        <label for="year" style="margin-right: 5px;">Year:</label>
                        <select name="year" id="year" class="form-control" style="width: 400px;">
                            <option value="">Select Year</option>
                            @for ($i = 2025; $i < 2060; $i++)
                                <option value="{{ $i }}"
                                    {{ old('year') == $i || (isset($year) && $year == $i) ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group" style="margin-right: 20px;">
                        <label for="month" style="margin-right: 5px;">Month:</label>
                        <select name="month" id="month" class="form-control" style="width: 400px;">
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

                    <button type="submit" name="process" class="btn btn-success" style="width: 150px; font-weight: bold;">
                        <i class="fa fa-lock"></i> Lock
                    </button>
                </form>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                </br>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Current Active Month And Year</h3>
                    </div>
                    <!-- Place table here-->
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>

                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Status</th>


                                </tr>
                                <thead>
                                <tbody>
                                    @foreach ($activemonth as $active)
                                        <tr>
                                            <td>{{ $active->year }}</td>
                                            <td>{{ $active->month }}</td>
                                            @if ($active->salary_lock == 1)
                                                <td> <i class="fa fa-lock" style="color: #449d44"></i></td>
                                            @else
                                                <td> <i class="fa fa-unlock" style="color: #449d44;font-weight:200px "></i>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('message'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('message') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if (session('error_message'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error_message') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
@endsection
