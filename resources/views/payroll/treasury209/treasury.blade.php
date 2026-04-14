@extends('layouts.layout')

@section('pageTitle')
    Deductions Report(Treasury 209)
@endsection

@section('content')


    <div class="panel panel-success">
        <div class="panel-heading">
            <h4 class="panel-title" style="font-weight:bold;">
                TREASURY 209 REPORT
            </h4>
        </div>

        <div class="panel-body">

            <form method="post" action="{{ url('/treasury209/view') }}">
                {{ csrf_field() }}

                <input type="hidden" name="codeID" id="codeID">

                <div class="row">
                    <div class="col-md-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> {{ session('msg') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">

                    <!-- Report Type -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Report Type</label>
                            <select name="reporttype" id="reporttype" required class="form-control"
                                onchange="check(this.value)">
                                <option value="">Select</option>
                                @foreach ($reporttype as $type)
                                    <option value="{{ $type->determinant }}"
                                        @if (old('reporttype') == $type->determinant) selected @endif>
                                        {{ strtoupper($type->addressName) }}
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

                    <!-- Division Logic -->
                    @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Division</label>
                                <select name="division" id="division_" class="form-control">
                                    <option value="">Select Division</option>
                                    @foreach ($courtDivisions as $divisions)
                                        <option value="{{ $divisions->divisionID }}"
                                            @if (old('division') == $divisions->divisionID) selected @endif>
                                            {{ $divisions->division }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Division</label>
                                <input type="text" class="form-control" value="{{ $curDivision->division }}" readonly>
                            </div>
                        </div>
                        <input type="hidden" name="division" value="{{ Auth::user()->divisionID }}">
                    @endif
                </div>

                <div class="row">

                    <!-- Month -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Month</label>
                            <select name="month" class="form-control">
                                <option></option>
                                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                    <option value="{{ $m }}" @if (old('month') == $m) selected @endif>
                                        {{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Year -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Year</label>
                            <select name="year" class="form-control">
                                <option></option>
                                @for ($y = 2025; $y <= 2050; $y++)
                                    <option value="{{ $y }}" @if (old('year') == $y) selected @endif>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Current State -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Current Residential State</label>
                            <select name="currentState" class="form-control">
                                <option></option>
                                @foreach ($currentstate as $list)
                                    <option value="{{ $list->id }}" @if (old('currentState') == $list->id) selected @endif>
                                        {{ $list->state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Bank -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Bank</label>
                            <select name="bank" class="form-control">
                                <option></option>
                                @foreach ($bank as $bk)
                                    <option value="{{ $bk->bankID }}" @if (old('bank') == $bk->bankID) selected @endif>
                                        {{ $bk->bank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Bank Group -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank Group</label>
                            <input type="text" name="bankgroup" class="form-control" placeholder="Enter Bank Group">
                        </div>
                    </div>

                </div>

                <div class="form-group" align="right">
                    <button class="btn btn-success" type="submit">View Report</button>
                </div>

            </form>

        </div> <!-- panel-body -->
    </div> <!-- panel -->

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
