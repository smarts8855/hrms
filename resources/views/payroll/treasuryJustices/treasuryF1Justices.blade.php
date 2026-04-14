@extends('layouts.layout')

@section('pageTitle')
    TreasuryF1 Justices
@endsection

@section('content')


    <div class="panel panel-success">
        <div class="panel-heading">
            <h4 class="panel-title" style="font-weight:bold;">TREASURY F1 JUSTICES REPORT</h4>
        </div>

        <div class="panel-body">
            <form method="post" action="{{ url('treasuryf1-justices/view') }}">
                {{ csrf_field() }}
                <input type="hidden" name="codeID" id="codeID">

                <div class="row">
                    <div class="col-md-12">
                        <!-- Errors -->
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Success -->
                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> {{ session('msg') }}
                            </div>
                        @endif

                        <!-- Other Error -->
                        @if (session('err'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error!</strong> {{ session('err') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- Division -->
                    <div class="col-md-6">
                        @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                            <div class="form-group">
                                <label>Select Division</label>
                                <select name="division" id="division_" class="form-control" style="font-size:13px;">
                                    <option value="">All</option>
                                    @foreach ($courtDivisions as $divisions)
                                        <option value="{{ $divisions->divisionID }}"
                                            @if (old('division') == $divisions->divisionID) selected @endif>
                                            {{ $divisions->division }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label>Division</label>
                                <input type="text" class="form-control" id="divisionName" name="divisionName"
                                    value="{{ $curDivision->division }}" readonly>
                            </div>
                            <input type="hidden" name="division" value="{{ Auth::user()->divisionID }}">
                        @endif
                    </div>

                    <!-- Report Type -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reporttype">Report Type</label>
                            <select name="reportType" id="reporttype" class="form-control" required
                                onchange="check(this.value)">
                                <option>Select</option>
                                @foreach ($reporttype as $type)
                                    <option value="{{ $type->determinant }}"
                                        @if (old('reporttype') == $type->determinant) selected @endif>
                                        {{ $type->addressName }}
                                    </option>
                                @endforeach
                                @foreach ($cvSetup as $type)
                                    <option value="{{ $type->ID }}" @if (old('reporttype') == $type->ID) selected @endif>
                                        {{ $type->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Year -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Select Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value=""></option>
                                @for ($y = 2025; $y <= 2050; $y++)
                                    <option value="{{ $y }}" @if (old('year') == $y) selected @endif>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Month -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="month">Select Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value=""></option>
                                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                    <option value="{{ $m }}" @if (old('month') == $m) selected @endif>
                                        {{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Bank -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank">Select Bank</label>
                            <select name="bank" id="bank" class="form-control">
                                <option value=""></option>
                                @foreach ($bank as $bk)
                                    <option value="{{ $bk->bankID }}" @if (old('bank') == $bk->bankID) selected @endif>
                                        {{ $bk->bank }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Bank Group -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bankgroup">Bank Group</label>
                            <input type="text" name="bankgroup" id="bankgroup" class="form-control"
                                placeholder="Enter Bank Group">
                        </div>
                    </div>

                    <!-- Current Working State -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="workingstate">Current Working State</label>
                            <select name="workingstate" id="workingstate" class="form-control">
                                <option value=""></option>
                                @foreach ($workingstate as $ws)
                                    <option value="{{ $ws->id }}">{{ $ws->State }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success">View Justices TreasuryF1 Report</button>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        (function() {
            $('#reporttype').change(function() {
                if ($('#reporttype').val() != 'TAX') {
                    $('#workingstatehide').hide();
                }
                if ($('#reporttype').val() == 'TAX') {
                    $('#workingstatehide').show();
                }
            });
        })();
    </script>
@endsection
