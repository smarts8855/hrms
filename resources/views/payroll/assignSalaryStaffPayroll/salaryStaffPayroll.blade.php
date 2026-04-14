@extends('layouts.layout')
@section('pageTitle')
    Payroll Report
@endsection
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div style="clear:both"></div>
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

    <div class="box-body" style="background:#FFF;">
        <div class="row">

            <h4 class="col-md-6" style="text-transform:uppercase">Payroll Report</h4>

            <form method="post" action="{{ url('con-payrollReport/create') }}" target="_blank">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Division</label>
                                    <select name="division" id="divisionG" class="form-control getDivision"
                                        style="font-size: 13px;">
                                        <option value="">Select Division</option>
                                        @foreach ($courtDivisions as $divisions)
                                            <option value="{{ $divisions->divisionID }}"
                                                @if (old('division') == $divisions->divisionID)  @endif>{{ $divisions->division }}
                                            </option>
                                        @endforeach
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
                                            @if (old('year') == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Select a Month </label>
                                <select name="month" id="section" class="form-control">
                                    <option value="">Select Month </option>
                                    <option value="JANUARY" @if (old('month') == 'JANUARY') selected @endif>January
                                    </option>
                                    <option value="FEBRUARY" @if (old('month') == 'FEBRUARY') selected @endif>February
                                    </option>
                                    <option value="MARCH" @if (old('month') == 'MARCH') selected @endif>March</option>
                                    <option value="APRIL" @if (old('month') == 'APRIL') selected @endif>April</option>
                                    <option value="MAY" @if (old('month') == 'MAY') selected @endif>May</option>
                                    <option value="JUNE" @if (old('month') == 'JUNE') selected @endif>June</option>
                                    <option value="JULY" @if (old('month') == 'JULY') selected @endif>July</option>
                                    <option value="AUGUST" @if (old('month') == 'AUGUST') selected @endif>August
                                    </option>
                                    <option value="SEPTEMBER" @if (old('month') == 'SEPTEMBER') selected @endif>September
                                    </option>
                                    <option value="OCTOBER" @if (old('month') == 'OCTOBER') selected @endif>October
                                    </option>
                                    <option value="NOVEMBER" @if (old('month') == 'NOVEMBER') selected @endif>November
                                    </option>
                                    <option value="DECEMBER" @if (old('month') == 'DECEMBER') selected @endif>December
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="bankName">BANK NAME</label>
                                <select name="bankName" id="bankName_" class="form-control">
                                    <option value="">Select Bank</option>
                                    @foreach ($allbanklist as $list)
                                        <option value="{{ $list->bankID }}" @if (old('bankName') == $list->bankID)  @endif>
                                            {{ $list->bank }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bankName">BANK NAME</label>
                                <select name="bankName" id="bankName" class="form-control" required>
                                    <option value="">Select Bank</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank Group</label>
                                <input type="text" name="bankGroup" id="bankGroup" class="form-control"
                                    value="{{ old('bankGroup') }}" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success pull-right">Generate Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div><!-- /.col -->
    </div><!-- /.row -->







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

    <script>
        $(document).ready(function() {

                $('.getDivision').change(function() {
                    let prevDivision = $("#divisionG").val();
                    console.log("div", prevDivision);
                    $("#bankName").empty();
                    $.ajax({
                        url: `bank-assigned-to-salary/${prevDivision}`,
                        type: "get",
                        data: {
                            'divisionID': prevDivision,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            console.log(data);
                            $('#bankName').append('<option value="" >' + 'Select Bank' +
                                '</option>');
                            $.each(data, function(i, obj) {
                                $('#bankName').append('<option value="' + obj.bankID +
                                    '" >' + obj
                                    .bank + '</option>');

                            })
                        }
                    });
                })

        })
      
    </script>
@endsection
