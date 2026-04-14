@extends('layouts.layout')
@section('pageTitle')
    Paid Staff Search
@endsection
@section('content')

<div class="box-body" style="background:#FFF;">
    <div style="clear:both"></div>
    <div class="row">
        <div class="col-md-12">
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

            @if (session('err'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong>
                    {{ session('err') }}
                </div>
            @endif
        </div>
    </div>
</div>

<form method="post" action="{{ url('con-payrollReport/get-paid-staff') }}">
    {{ csrf_field() }}

    <div id="" class="box box-default" style="border: none;">
        <div class="box-body box-profile" style="margin:0 5px;">
            <h3 class="text-center" style="text-transform:uppercase">Search Paid Staff</h3>
            <hr style="border: 2px solid green">

            <div style="margin: 0px  5%;">
                <div class="form-group" style="margin-bottom: 10px;">
                    <div class="row">
                        <input type="hidden" id="globe" value="{{ Auth::user()->is_global }}">
                        
                        @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Court <span style="color:red">*</span></label>
                                    <select name="division" id="division" class="form-control" style="font-size: 13px;" required>
                                        <option value="">Select Court</option>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Court <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" value="{{ $curDivision->division }}" readonly>
                                    <input type="hidden" name="division" value="{{ Auth::user()->divisionID }}">
                                </div>
                            </div>
                        @endif

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select Year <span style="color:red">*</span></label>
                                <select name="year" id="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    @for ($i = 2025; $i <= 2040; $i++)
                                        <option value="{{ $i }}"
                                            @if (old('year') == $i) selected @endif>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select Month <span style="color:red">*</span></label>
                                <select name="month" id="month" class="form-control" required>
                                    <option value="">Select Month</option>
                                    <option value="JANUARY" @if (old('month') == 'JANUARY') selected @endif>January</option>
                                    <option value="FEBRUARY" @if (old('month') == 'FEBRUARY') selected @endif>February</option>
                                    <option value="MARCH" @if (old('month') == 'MARCH') selected @endif>March</option>
                                    <option value="APRIL" @if (old('month') == 'APRIL') selected @endif>April</option>
                                    <option value="MAY" @if (old('month') == 'MAY') selected @endif>May</option>
                                    <option value="JUNE" @if (old('month') == 'JUNE') selected @endif>June</option>
                                    <option value="JULY" @if (old('month') == 'JULY') selected @endif>July</option>
                                    <option value="AUGUST" @if (old('month') == 'AUGUST') selected @endif>August</option>
                                    <option value="SEPTEMBER" @if (old('month') == 'SEPTEMBER') selected @endif>September</option>
                                    <option value="OCTOBER" @if (old('month') == 'OCTOBER') selected @endif>October</option>
                                    <option value="NOVEMBER" @if (old('month') == 'NOVEMBER') selected @endif>November</option>
                                    <option value="DECEMBER" @if (old('month') == 'DECEMBER') selected @endif>December</option>
                                </select>
                            </div>
                        </div>

                       <!-- Independent Filters Section -->
<div class="col-md-3">
    <div class="form-group">
        <label>Employment Type</label>
        <select name="employment_type" id="employment_type" class="form-control">
            <option value="">All Employment Types</option>
            @foreach($employmentTypes as $type)
                <option value="{{ $type->id }}" 
                    @if (old('employment_type') == $type->id) selected @endif>
                    {{ $type->employmentType }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label>Grade Level</label>
        <select name="grade" id="grade" class="form-control">
            <option value="">All Grades</option>
            @for($g = 1; $g <= 17; $g++)
                <option value="{{ $g }}" 
                    @if (old('grade') == $g) selected @endif>
                    Grade Level {{ $g }}
                </option>
            @endfor
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label>Step</label>
        <select name="step" id="step" class="form-control">
            <option value="">All Steps</option>
            @for($s = 1; $s <= 10; $s++)
                <option value="{{ $s }}" 
                    @if (old('step') == $s) selected @endif>
                    Step {{ $s }}
                </option>
            @endfor
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        {{-- <label style="visibility: hidden">Search</label> --}}
        <div>
            <button type="submit" class="btn btn-success btn-block">
                <i class="fa fa-search"></i> Search Paid Staff
            </button>
        </div>
    </div>
</div>
<!-- End Independent Filters Section -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('styles')
<style>
    .form-group label {
        font-weight: 600;
        font-size: 13px;
    }
    .form-control {
        font-size: 13px;
    }
    .btn-block {
        margin-top: 23px;
    }
    @media (max-width: 768px) {
        .btn-block {
            margin-top: 0;
        }
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#court").on('change', function(e) {
            e.preventDefault();
            var id = $(this).val();
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
                }
            });
        });
    });
</script>
@endsection