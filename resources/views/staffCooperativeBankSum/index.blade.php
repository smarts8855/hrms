@extends('layouts.layout')
@section('pageTitle')
    Staff Cooperative Bank Mandate Summary Analysis
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading bg-green">
                    <h4 class="panel-title">
                        <strong>STAFF COOPERATIVE SUMMARY BANK MANDATE ANALYSIS</strong>
                    </h4>
                </div>

                <div class="panel-body">
                    <form method="post" action="{{ url('staff/cooperative-bank-sum') }}">
                        @csrf

                        <div class="box-body" style="background:#FFF;">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--1st col-->
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Error!</strong>
                                            @foreach ($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (session('message'))
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Success!</strong>
                                            {{ session('message') }}
                                        </div>
                                    @endif

                                </div>
                                <div class="col-md-12">

                                    <div class="row">

                                        @if ($CourtInfo->courtstatus == 1)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Court</label>
                                                    <select name="court" id="court" class="form-control"
                                                        style="font-size: 13px;">
                                                        <option value="">Select Court</option>
                                                        @foreach ($courts as $court)
                                                            @if ($court->id == session('anycourt'))
                                                                <option value="{{ $court->id }}" selected="selected">
                                                                    {{ $court->court_name }}</option>
                                                            @else
                                                                <option value="{{ $court->id }}"
                                                                    @if (old('court') == $court->id) selected @endif>
                                                                    {{ $court->court_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" id="court" name="court"
                                                value="{{ $CourtInfo->courtid }}">
                                        @endif

                                        @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Court</label>
                                                    <select name="division" id="division_" class="form-control"
                                                        style="font-size: 13px;">
                                                        <option value="">Select Court</option>
                                                        @foreach ($courtDivisions as $divisions)
                                                            <option value="{{ $divisions->divisionID }}"
                                                                @if (old('division') == $divisions->divisionID)  @endif>
                                                                {{ $divisions->division }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Court</label>
                                                    <input type="text" class="form-control" id="divisionName"
                                                        name="divisionName" value="{{ $curDivision->division }}" readonly>
                                                </div>
                                            </div>
                                            <input type="hidden" id="division" name="division"
                                                value="{{ Auth::user()->divisionID }}">
                                            <!--<input type="hidden" id="division" name="division" value="{{ $CourtInfo->divisionid }}">-->
                                        @endif

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Select a Month </label>
                                                <select name="month" id="section" class="form-control">
                                                    <option value="">Select Month </option>
                                                    <option value="JANUARY"
                                                        @if (old('month') == 'JANUARY') selected @endif>
                                                        January
                                                    </option>
                                                    <option value="FEBRUARY"
                                                        @if (old('month') == 'FEBRUARY') selected @endif>
                                                        February
                                                    </option>
                                                    <option value="MARCH"
                                                        @if (old('month') == 'MARCH') selected @endif>
                                                        March</option>
                                                    <option value="APRIL"
                                                        @if (old('month') == 'APRIL') selected @endif>
                                                        April</option>
                                                    <option value="MAY"
                                                        @if (old('month') == 'MAY') selected @endif>
                                                        May</option>
                                                    <option value="JUNE"
                                                        @if (old('month') == 'JUNE') selected @endif>
                                                        June</option>
                                                    <option value="JULY"
                                                        @if (old('month') == 'JULY') selected @endif>
                                                        July</option>
                                                    <option value="AUGUST"
                                                        @if (old('month') == 'AUGUST') selected @endif>
                                                        August
                                                    </option>
                                                    <option value="SEPTEMBER"
                                                        @if (old('month') == 'SEPTEMBER') selected @endif>September
                                                    </option>
                                                    <option value="OCTOBER"
                                                        @if (old('month') == 'OCTOBER') selected @endif>
                                                        October
                                                    </option>
                                                    <option value="NOVEMBER"
                                                        @if (old('month') == 'NOVEMBER') selected @endif>November
                                                    </option>
                                                    <option value="DECEMBER"
                                                        @if (old('month') == 'DECEMBER') selected @endif>December
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select a Year</label>
                                                <select name="year" id="section" class="form-control">
                                                    <option value="">Select Year</option>
                                                    @for ($i = 2025; $i <= 2060; $i++)
                                                        <option value="{{ $i }}"
                                                            @if (old('year') == $i) selected @endif>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Bank</label>
                                                <select name="bank" id="section" class="form-control" required>
                                                    <option value="">Select Bank</option>
                                                    @foreach ($allbanklist as $bank)
                                                        <option value="{{ $bank->bankID }}"
                                                            @if (old('bank') == $bank->bankID) selected @endif>
                                                            {{ $bank->bank }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success pull-right">Display</button>
                                    </div>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </form>
                </div><!-- panel -->
            </div>
        </div>
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#court").on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();
                //alert(id);
                $token = $("input[name='_token']").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $token
                    },
                    url: murl + '/session/court',

                    type: "post",
                    data: {
                        'courtID': id
                    },
                    success: function(data) {
                        location.reload(true);
                        //console.log(data);
                    }
                });

            });
        });
    </script>
@endsection
