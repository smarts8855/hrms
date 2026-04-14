@extends('layouts.layout')
@section('pageTitle')
    CONTROL REPORT
@endsection

<style type="text/css">
    .form-control {
        font-size: 13px;

    }

    .col-md-12 {
        padding: 0px 5px;
    }

    .table tr td {
        font-size: 13px;
        padding: 13px;
        font-family: Verdana, Geneva, sans-serif;
    }

    .table tr th {
        padding: 15px;
        font-size: 13px;
        text-transform: uppercase;
        font-family: Verdana, Geneva, sans-serif;
        color: #262626;
        background: #eee;
    }

    .input-lg {
        padding: 5px !important;
    }
</style>

@section('content')


    <div class="box box-default" style="border-top: none;">
        <form action="{{ url('/manpower/view/central') }}" method="post">
            {{ csrf_field() }}
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
                <span class="pull-right" style="margin-right: 30px;">
                    <div style="float: left;">
                        <div class="wrap">

                        </div>
                    </div>
                </span>
        </form>

        <span class="hidden-print">

            </form>
    </div>

    <div style="margin: 10px 20px;">
        <div align="center">
            @include('layouts._companyInfoPartial')
        </div>

        <br />
        @if (session('err'))
            <div class="col-sm-12 alert alert-warning alert-dismissible hidden-print" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong>
                {{ session('err') }}
            </div>
        @endif

    </div>

    <div class="box-body">
        <div></div>
        <form method="post" action="{{ url('/control-reports') }}" class="hidden-print">
            {{ csrf_field() }}
            <div class="row" style="padding: 1px 12px; margin-bottom: 20px;">
                <div class="col-md-12" style="background: #eee; padding: 10px 15px">

                    {{-- Row Spacing --}}
                    <div class="col-md-2"></div>
                    @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                        <div class="col-md-3" style="font-size: 13px;">
                            <div class="form-group">
                                <label>Division</label>
                                <select name="division" id="division" class="form-control input-lg"
                                    style="font-size: 13px;" required>
                                    <option value="">Select Division</option>
                                    @foreach ($division as $d)
                                        @if (session('_division') && session('_division') == $d->divisionID)
                                            <option value="{{ $d->divisionID }}" selected>{{ $d->division }}</option>
                                        @else
                                            <option value="{{ $d->divisionID }}">{{ $d->division }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="col-md-3" style="font-size: 13px;">
                            <div class="form-group">
                                <label>Division</label>
                                <input type="text" readonly class="form-control input-lg"
                                    value="{{ $loggedDivision->division }}">
                            </div>
                        </div>
                        <input type="hidden" id="divison" name="division" value="{{ $loggedDivision->divisionID }}">
                    @endif

                    <div class="col-md-3" style="padding: 1px;font-size: 13px;">
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year" class="form-control input-lg" required>
                                <option value=""></option>
                                @for ($i = 2017; $i <= date('Y'); $i++)
                                    @if (session('_year') && session('_year') == $i)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>

                        </div>
                    </div>

                    <div class="col-md-2" style="padding: 1px;">
                        <div class="form-group" style="padding-top: 23px;">

                            <input type="submit" name="submit" id="fileNo" class="btn btn-default input-lg"
                                value="Display" />
                        </div>
                    </div>

                    <div class="col-md-2"></div>

                </div>
                @if (isset($staffs) && count($staffs) == 0)
                    <div align="center" style="color: red">No Staff found under that division</div>
                @endif
            </div>
        </form>

        <div class="row">
            {{ csrf_field() }}

            <div class="col-md-12">
                <table class="table table-striped table-condensed table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th width="250" class="">STAFF NO</th>
                            <th>CONTROL NO.</th>
                            <th>STAFF NAME</th>
                            <th>DESIGNATION</th>
                            <th>GRADE</th>
                            <th>DATE OF APPOINTMENT</th>
                            <th>PAYMENT BANK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $key = 1; @endphp
                        @if (isset($staffs) && count($staffs) != 0)
                            <h3 align="center" style="color: green">DIVISION: <span
                                    id="diviName">{{ $searchedDiviInfo->division }}</span></h3>
                            @foreach ($staffs as $s)
                                <tr>
                                    {{-- <td>{{ ($staffs->currentpage() - 1) * $staffs->perpage() + $key++ }}</td> --}}
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $s->fileNo }}</td>
                                    <td>{{ $s->control_no }}</td>
                                    <td>{{ $s->surname }} {{ $s->first_name }} {{ $s->othernames }}</td>
                                    <td>{{ $s->designation ? $s->designation : 'Not Stated' }}</td>
                                    <td>{{ $s->grade }}</td>
                                    <td>{{ $s->appointment_date }}</td>
                                    <td>{{ $s->bank }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>


            </div>
        </div>
        <!-- /.col
                    </div><!-- /.row -->
    </div>





@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>


@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@stop
