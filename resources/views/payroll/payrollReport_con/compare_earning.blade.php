@extends('layouts.layout')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
    integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">
@section('pageTitle')
    Payroll Monthly Comparison
@endsection
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div style = "clear:both"></div>
        <div class="row">
            <div class="col-md-12"><!--1st col-->
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
                        <strong>Success!</strong>
                        {{ session('err') }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="box-body" style="background:#FFF;">
        <div class="row">

            <h4 class="col-md-6" style="text-transform:uppercase">Monthly Earning Comparison</h4>



            <div class="col-md-12" style="margin-top: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-weight: bold; font-size: 15px;">
                        Generate Report
                    </div>
                    <div class="panel-body">
                        <form method="post" class="no-print">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-md-12">
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
                                                                {{ $court->court_name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $court->id }}"
                                                                @if (old('court') == $court->id) selected @endif>
                                                                {{ $court->court_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" id="court" name="court"
                                            value="{{ $CourtInfo->courtid }}">
                                    @endif
                                    <input type="hidden" id="globe" name=""
                                        value="{{ Auth::user()->is_global }}">
                                </div>

                                <div class="col-md-12">
                                    @if ($CourtInfo->divisionstatus == 1 && Auth::user()->is_global == 1)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Division</label>
                                                <select name="division" id="divisionG" class="form-control getDivision"
                                                    style="font-size: 13px;">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Division</label>
                                                <input type="text" class="form-control" id="divisionName"
                                                    name="divisionName" value="{{ $curDivision->division }}" readonly>
                                            </div>
                                        </div>
                                        <input type="hidden" id="divisionGlob" name="division"
                                            value="{{ Auth::user()->divisionID }}">
                                    @endif

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bankName">BANK NAME</label>
                                            <select name="bankName" id="bankName" class="form-control">
                                                <option value="">Select Bank</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Period1 Year</label>
                                            <select name="year1" id="section" class="form-control">
                                                <option value="">Select Year</option>
                                                @for ($i = 2011; $i <= 2025; $i++)
                                                    <option value="{{ $i }}"
                                                        @if (old('year1') == $i || $year1 == $i) selected @endif>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Period 1 Month</label>
                                            <select name="month1" id="section" class="form-control">
                                                <option value="">Select Month</option>
                                                @foreach (['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $m)
                                                    <option value="{{ $m }}"
                                                        @if (old('month1') == $m || $month1 == $m) selected @endif>
                                                        {{ ucfirst(strtolower($m)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Period 2 Year</label>
                                            <select name="year2" id="section" class="form-control">
                                                <option value="">Select Year</option>
                                                @for ($i = 2011; $i <= 2025; $i++)
                                                    <option value="{{ $i }}"
                                                        @if (old('year2') == $i || $year2 == $i) selected @endif>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Period 2 Month</label>
                                            <select name="month2" id="section" class="form-control">
                                                <option value="">Select Month</option>
                                                @foreach (['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'] as $m)
                                                    <option value="{{ $m }}"
                                                        @if (old('month2') == $m || $month2 == $m) selected @endif>
                                                        {{ ucfirst(strtolower($m)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success">Generate Report</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            {{-- <div class="table-responsive" style="font-size: 11px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>Staff Name</th>
                            <th>Banks</th>
                            <th>{{ $year1 }} {{ $month1 }}</th>
                            <th> {{ $year2 }} {{ $month2 }}</th>
                            <th>Variation</th>
                            <th>Remark</th>

                        </tr>
                    </thead>

                    <tbody>

                        @php $i=1; @endphp
                        @php $tnet1=0; @endphp
                        @php $tnet2=0; @endphp
                        @php $tdiff=0; @endphp
                        @foreach ($record as $list)
                            @php $url="/con-pecard/getCard/".$list['staffid']."/".$list['year']; @endphp
                            <tr>
                                <td>{{ $i++ }} </td>
                                <td> <a class="hidden-print" target ="_blank"
                                        href="{{ url($url) }}">{{ $list['Names'] }}</a></td>
                                <td> {{ $list['Banks'] }}</td>
                                <td> {{ number_format($list['net1'], 2, '.', ',') }}</td>
                                <td> {{ number_format($list['net2'], 2, '.', ',') }}</td>
                                <td> {{ number_format($list['diff'], 2, '.', ',') }}</td>
                                <td>
                                    <span id="remarkIndex{{ $i }}"
                                        style="font-weight: bold">{{ isset($getStaffRemark) ? $getStaffRemark[$list['StaffID']] : '' }}</span>
                                    <a href="javascript::void()" class="remarkBtn no-print"
                                        staffName="{{ $list['Names'] }}" staffId="{{ $list['StaffID'] }}"
                                        year1="{{ $year1 }}" year2="{{ $year2 }}"
                                        month1="{{ $month1 }}" month2="{{ $month2 }}"
                                        remarkIndexRef="{{ $i }}" data-toggle="modal"
                                        data-target="#remarkModal" month="" year="">
                                        <i class="bi bi-pen text-success"></i>
                                    </a>
                                </td>
                            </tr>
                            @php $tnet1+=$list['net1']; @endphp
                            @php $tnet2+=$list['net2']; @endphp
                            @php $tdiff+=$list['diff']; @endphp
                        @endforeach
                        <tr>
                            <td><b>Total </b></td>
                            <td> </td>
                            <td> </td>
                            <td> <b>{{ number_format($tnet1, 2, '.', ',') }}</b></td>
                            <td><b> {{ number_format($tnet2, 2, '.', ',') }}</b></td>
                            <td><b> {{ number_format($tdiff, 2, '.', ',') }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}

            <div class="table-responsive" style="font-size: 11px; padding:10px;">
                <table id="mytable" class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>Staff Name</th>
                            <th>Banks</th>
                            <th>{{ $year1 }} {{ $month1 }}</th>
                            <th>{{ $year2 }} {{ $month2 }}</th>
                            <th>Variation</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                            $tnet1 = $tnet2 = $tdiff = 0;
                        @endphp

                        @foreach ($record as $list)
                            @php
                                $url = '/con-pecard/getCard/' . $list['staffid'] . '/' . $list['year'];
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>
                                    <a class="hidden-print" target="_blank" href="{{ url($url) }}">
                                        {{ $list['Names'] }}
                                    </a>
                                </td>
                                <td>{{ $list['Banks'] }}</td>
                                <td>{{ number_format($list['net1'], 2, '.', ',') }}</td>
                                <td>{{ number_format($list['net2'], 2, '.', ',') }}</td>
                                <td>{{ number_format($list['diff'], 2, '.', ',') }}</td>
                                <td>
                                    <span id="remarkIndex{{ $i }}" style="font-weight: bold">
                                        {{ $getStaffRemark[$list['staffid']] ?? '' }}
                                    </span>
                                    <a href="javascript:void(0)" class="remarkBtn no-print"
                                        staffName="{{ $list['Names'] }}" staffId="{{ $list['staffid'] }}"
                                        year1="{{ $year1 }}" year2="{{ $year2 }}"
                                        month1="{{ $month1 }}" month2="{{ $month2 }}"
                                        remarkIndexRef="{{ $i }}" data-toggle="modal"
                                        data-target="#remarkModal">
                                        <i class="bi bi-pen text-success"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $tnet1 += $list['net1'];
                                $tnet2 += $list['net2'];
                                $tdiff += $list['diff'];
                                $i++;
                            @endphp
                        @endforeach

                        <tr>
                            <td><b>Total</b></td>
                            <td colspan="2"></td>
                            <td><b>{{ number_format($tnet1, 2, '.', ',') }}</b></td>
                            <td><b>{{ number_format($tnet2, 2, '.', ',') }}</b></td>
                            <td><b>{{ number_format($tdiff, 2, '.', ',') }}</b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>



            {{-- Remark Model --}}
            <div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: green">
                            <h4 class="modal-title" id="exampleModalLabel">Earning Comparism Remark for: <span
                                    id="staffModel" style="color: white"></span> <span id="yearModel"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="remarkForm">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <textarea class="form-control" name="remark" id="remarkValue" cols="30" rows="5"
                                    placeholder="Enter remark....."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save/Update Remark</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Remark Model END --}}

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

            //initiating variables
            let staffName;
            let staffID;
            let month1;
            let month2;
            let year1;
            let year2;
            let remarkIndex;

            //when then remark pen is clicked
            $(".remarkBtn").click(function(e) {
                e.preventDefault();

                //defaultly setting the remark form value to empty
                $("#remarkValue").val("");

                //getting the attribute value on the edit button
                staffName = $(this).attr('staffName');
                staffID = $(this).attr('staffId');
                month1 = $(this).attr('month1');
                month2 = $(this).attr('month2');
                year1 = $(this).attr('year1');
                year2 = $(this).attr('year2');
                remarkIndex = $(this).attr('remarkIndexRef');

                //populates some tags on the remark model
                $("#staffModel").html(staffName);

                //get the current remark and pass it as the value for the modal form
                var remarkMade = $(`#remarkIndex${remarkIndex}`).html();
                if (remarkMade != " " && remarkMade != null) {
                    $("#remarkValue").val(remarkMade);
                }

            });

            //when the remark form is submitted
            $("#remarkForm").submit(function(e) {
                e.preventDefault();

                const remark = $("#remarkValue").val();
                var _token = $("input[name='_token']").val();

                $.ajax({
                    type: "post",
                    url: "/con-payrollReport/compare-earning/remark",
                    data: {
                        _token: _token,
                        month1: month1,
                        year1: year1,
                        month2: month2,
                        year2: year2,
                        staffName: staffName,
                        staffID: staffID,
                        remark: remark
                    },
                    dataType: "json",
                    success: function(response) {
                        //appending data to the remark column
                        $(`#remarkIndex${remarkIndex}`).html(response.remark);

                        // close modal
                        $('#remarkModal').modal('hide')
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });

            });

        });
    </script>


    <script>
        $(document).ready(function() {
            const globalUser = ($('#globe').val())
            let prevDivision = $("#divisionGlob").val();
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
                    console.log("my banks", data);
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
                            // console.log(data);
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
        // (function() {

        // })();
    </script>
@endsection
