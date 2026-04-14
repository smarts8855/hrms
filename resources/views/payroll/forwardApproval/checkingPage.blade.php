@extends('layouts.layout')
@section('pageTitle')
    Pay Slip
@endsection
@section('content')
    <form method="post" action="{{ url('/checking-unit') }}">
        <div class="box-body" style="background:#FFF;">
            <div class="row">
                <div class="col-md-12">
                    <!--1st col-->
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong>
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong>
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="col-md-12">
                    <!--2nd col-->
                    <h4 class="" style="text-transform:uppercase">Checking</h4>
                    <div class="row">
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select a Year</label>
                                <select name="year" id="section" class="form-control input-sm">
                                    <option value="">Select Year </option>

                                    @for ($i = 2025; $i <= 2040; $i++)
                                        <option value="{{ $i }}"
                                            @if ($activeMonth !== '' && $activeMonth->year == $i) selected @elseif($year == $i) selected @endif>
                                            {{ $i }}</option>
                                    @endfor

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Select a month </label>
                                <select name="month" id="section" class="form-control input-sm">

                                    <option value="">Select Month </option>

                                    <option value="JANUARY"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'JANUARY') selected @elseif ($month == 'JANUARY') selected @endif>
                                        January</option>
                                    <option value="FEBRUARY"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'FEBRUARY') selected @elseif($month == 'FEBRUARY') selected @endif>
                                        February</option>
                                    <option value="MARCH"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'MARCH') selected @elseif ($month == 'MARCH') selected @endif>
                                        March</option>
                                    <option value="APRIL"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'APRIL') selected @elseif ($month == 'APRIL') selected @endif>
                                        April</option>
                                    <option value="MAY"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'MAY') selected @elseif ($month == 'MAY') selected @endif>
                                        May</option>
                                    <option value="JUNE"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'JUNE') selected @elseif ($month == 'JUNE') selected @endif>
                                        June</option>
                                    <option value="JULY"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'JULY') selected @elseif ($month == 'JULY') selected @endif>
                                        July</option>
                                    <option value="AUGUST"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'AUGUST') selected @elseif ($month == 'AUGUST') selected @endif>
                                        August</option>
                                    <option value="SEPTEMBER"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'SEPTEMBER') selected @elseif ($month == 'SEPTEMBER') selected @endif>
                                        September</option>
                                    <option value="OCTOBER"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'OCTOBER') selected @elseif ($month == 'OCTOBER') selected @endif>
                                        October</option>
                                    <option value="NOVEMBER"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'NOVEMBER') selected @elseif ($month == 'NOVEMBER') selected @endif>
                                        November</option>
                                    <option value="DECEMBER"
                                        @if ($activeMonth !== '' && $activeMonth->month == 'DECEMBER') selected @elseif ($month == 'DECEMBER') selected @endif>
                                        December</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sortcode"></label>
                            <div align="right">

                                <button class="btn btn-success pull-right" name="fetchRecords" type="submit">
                                    Display</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="table-responsive" style="font-size: 12px; padding:10px;">
                @if ($userInAssignSalaryStaff)
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>
                                <th>Division</th>
                                <th>Stage</th>
                                <th>Bank</th>
                                <th>Action</th>
                                <th>Decision</th>
                            </tr>
                        </thead>
                        @php $serialNum = 1; @endphp

                        @if (count($salary) > 0)
                            @foreach ($salary as $b)
                                <tr class="{{ $b->is_rejected == 1 ? 'alert alert-danger' : '' }}">
                                    <td>{{ $serialNum++ }} </td>
                                    <td>{{ $b->division }}</td>
                                    <td>{{ $b->description }}</td>
                                    <td>{{ $b->banklistName }}</td>
                                    <td><a
                                            href="javascript: ViewPayroll2('{{ $b->divisionID }}','{{ $b->year }}','{{ $b->month }}', '{{ $b->bankName }}')">View</a>
                                    </td>
                                    <td>
                                        @if ($b->vstage == 6)
                                            {{ 'Approved' }}
                                        @else
                                            {{ 'Awaiting approval' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-danger"> No Records found...</td>
                            </tr>
                        @endif

                    </table>
                @else
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                {{-- <th width="1%">S/N</th> --}}
                                {{-- <th>Division</th> --}}
                                <th>Stage</th>
                                <th>Action</th>
                                <th>Decision</th>
                            </tr>
                        </thead>
                        @php $serialNum = 1; @endphp

                        @if (count($salary) > 0)
                            @foreach ($salary as $b)
                                <tr class="{{ $b->is_rejected == 1 ? 'alert alert-danger' : '' }}">
                                    {{-- <td>{{ $serialNum++ }} </td> --}}
                                    {{-- <td>{{ $b->division }}</td> --}}
                                    <td>{{ $b->description }}</td>
                                    <td><a
                                            href="javascript: ViewPayroll('{{ $b->divisionID }}','{{ $b->year }}','{{ $b->month }}')">View</a>
                                    </td>
                                    <td>
                                        @if ($b->vstage == 6)
                                            {{ 'Approved' }}
                                        @else
                                            {{ 'Awaiting approval' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-danger"> No Records found...</td>
                            </tr>
                        @endif

                    </table>
                @endif
            </div>
        </div><!-- /.col -->

        @include('payroll.forwardApproval.assigned-staff', ['mode' => 'checking'])

    </form>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                </br>
            </div>
            <form method="post" action="{{ url('con-payrollReport/create') }}" id="id-payroll" target="_blank">
                {{ csrf_field() }}
                <input type="hidden" id="id-court" name="court" value="9">
                <input type="hidden" id="id-division" name="division" value="{{ Auth::user()->divisionID }}">
                <input type="hidden" name="year" id="id-year">
                <input type="hidden" name="month" id="id-month">
                <input type="hidden" name="bankName" id="id-bankName">
            </form>
        </div>
    </div>


@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        const Reload = (form) => document.forms[form].submit();

        const ViewPayroll = (division, year, month) => {
            document.getElementById('id-division').value = division;
            document.getElementById('id-year').value = year;
            document.getElementById('id-month').value = month;
            Reload('id-payroll');
        }

        const ViewPayroll2 = (division, year, month, bankName) => {
            document.getElementById('id-division').value = division;
            document.getElementById('id-year').value = year;
            document.getElementById('id-month').value = month;
            document.getElementById('id-bankName').value = bankName;
            Reload('id-payroll');
        }

         const ViewBankReport = (bankID) => {
            document.getElementById('id-bankName').value = bankID;
            document.getElementById('id-year').value = "{{ $year }}";
            document.getElementById('id-month').value = "{{ $month }}";
            Reload('id-payroll');
        }
    </script>
@endsection
