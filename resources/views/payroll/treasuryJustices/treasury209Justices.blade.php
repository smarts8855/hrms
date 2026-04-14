@extends('layouts.layout')

@section('pageTitle')
    Treasury 209 Justices
@endsection

@section('content')



    <form method="post" action="{{ url('/treasury209-justices/view') }}">

        <div class="panel panel-success">
            <div class="panel-heading">
                <h4 class="panel-title text-center">TREASURY 209 JUSTICES REPORT</h4>
            </div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <strong>Error!</strong>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <strong>Success!</strong> {{ session('msg') }}
                            </div>
                        @endif

                    </div>

                    {{ csrf_field() }}

                    <input type="hidden" name="codeID" id="codeID">

                    <!-- ROW 1 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Report Type</label>
                            <select name="reporttype" id="reporttype" required class="form-control"
                                onchange="check(this.value)">
                                <option>Select</option>
                                @foreach ($reporttype as $type)
                                    <option value="{{ $type->determinant }}"
                                        @if (old('reporttype') == $type->determinant) selected @endif>
                                        {{ strtoupper($type->addressName) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Division</label>
                            <select name="division" class="form-control">
                                <option value="">-All Division-</option>
                                @foreach ($allDivisions as $list)
                                    <option value="{{ $list->divisionID }}"
                                        @if (old('division') == $list->divisionID) selected @endif>
                                        {{ $list->division }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- ROW 2 -->
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

                    <!-- ROW 3 -->
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

                    <!-- ROW 4 -->
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

                    <!-- ROW 5 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank Group</label>
                            <input type="text" name="bankgroup" class="form-control" placeholder="Enter Bank Group">
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success" type="submit">
                            View Justices Treasury209 Report
                        </button>
                    </div>

                </div><!-- row -->

            </div><!-- panel-body -->
        </div><!-- panel -->

    </form>

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
