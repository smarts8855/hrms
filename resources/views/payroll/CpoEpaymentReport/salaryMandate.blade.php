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

    {{-- <form method="post" action="{{ url("salaryMandateReport") }}" target="_blank">
        {{ csrf_field() }} --}}


    <form method="POST" action="{{ route('salaryMandateReport') }}" target="_blank">
        @csrf

        <div id="" class="box box-default" style="border: none;">
            <div class="box-body box-profile" style="margin:0 5px;">
                <h3 class="text-center" style="text-transform:uppercase">SALARY MANDATE REPORT</h3>
                <hr style="border: 2px solid green">

                <div style="margin: 0px  5%;">
                    <div class="form-group" style="margin-bottom: 10px;">
                        <div class="row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select a Year</label>
                                    <select name="year" id="section" class="form-control">
                                        <option value="">Select Year</option>
                                        @for ($i = 2025; $i <= 2040; $i++)
                                            <option value="{{ $i }}"
                                                @if (old('year') == $i) selected @endif>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Select a Month </label>
                                    <select name="month" id="section" class="form-control">
                                        <option value="">Select Month </option>
                                        <option value="JANUARY" @if (old('month') == 'JANUARY') selected @endif>
                                            January
                                        </option>
                                        <option value="FEBRUARY" @if (old('month') == 'FEBRUARY') selected @endif>
                                            February
                                        </option>
                                        <option value="MARCH" @if (old('month') == 'MARCH') selected @endif>
                                            March
                                        </option>
                                        <option value="APRIL" @if (old('month') == 'APRIL') selected @endif>
                                            April
                                        </option>
                                        <option value="MAY" @if (old('month') == 'MAY') selected @endif>
                                            May</option>
                                        <option value="JUNE" @if (old('month') == 'JUNE') selected @endif>
                                            June
                                        </option>
                                        <option value="JULY" @if (old('month') == 'JULY') selected @endif>
                                            July
                                        </option>
                                        <option value="AUGUST" @if (old('month') == 'AUGUST') selected @endif>
                                            August
                                        </option>
                                        <option value="SEPTEMBER" @if (old('month') == 'SEPTEMBER') selected @endif>
                                            September
                                        </option>
                                        <option value="OCTOBER" @if (old('month') == 'OCTOBER') selected @endif>October
                                        </option>
                                        <option value="NOVEMBER" @if (old('month') == 'NOVEMBER') selected @endif>
                                            November
                                        </option>
                                        <option value="DECEMBER" @if (old('month') == 'DECEMBER') selected @endif>
                                            December
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bankName">BANK NAME</label>
                                    <select name="bankName" id="bankName" class="form-control">
                                        <option value="">Select Bank</option>

                                    </select>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bank Group</label>
                                    <input type="text" name="bankGroup" id="bankGroup" class="form-control"
                                        value="{{ old('bankGroup') }}" />
                                </div>
                            </div> --}}

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="visibility: hidden">Display</label>
                                    <div>
                                        <button type="submit" class="btn btn-success btn-block w-100">Generate
                                            Mandate Letter</button>
                                    </div>

                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>


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
            const globalUser = ($('#globe').val())
            let prevDivision = $("#divisionGlob").val();
            console.log("pre div", prevDivision);
            $("#bankName").empty();
            $.ajax({
                url: murl + '/staff/bank/retreive',
                type: "post",
                data: {
                    'divisionID': prevDivision,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    // location.reload(true);
                    // console.log("my banks", data);
                    $('#bankName').append('<option value="" >' + 'Select Bank' + '</option>');
                    $.each(data, function(i, obj) {
                        // console.log(22222222, obj);
                        $('#bankName').append('<option value="' + obj.bank + '" >' + obj
                            .bankName + '</option>');

                    })
                }
            });

            if (globalUser) {
                $('.getDivision').change(function() {
                    let prevDivision = $("#divisionG").val();
                    // alert(prevDivision);
                    $("#bankName").empty();
                    $.ajax({
                        url: murl + '/staff/bank/retreive',
                        type: "post",
                        data: {
                            'divisionID': prevDivision,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            // location.reload(true);
                            console.log(data);
                            $('#bankName').append('<option value="" >' + 'Select Bank' +
                                '</option>');
                            $.each(data, function(i, obj) {
                                // console.log(22222222, obj);
                                $('#bankName').append('<option value="' + obj.bank +
                                    '" >' + obj
                                    .bankName + '</option>');

                            })
                        }
                    });
                })
            }

        })
    </script>
@endsection



@endsection
