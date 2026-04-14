@extends('layouts.layout')

@section('pageTitle')
    Reconciliation
@endsection

@section('content')
    <div class="box-body">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> <br />
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> <br />
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !</strong> <br />
                            {{ session('err') }}
                        </div>
                    @endif
                </div>
            </div><!-- /row -->
        </div><!-- /div -->


        <!--search all vouchers-->
        <div class="row">
            <div class="panel panel-success" style="margin-top: 5px;">
                <div class="panel-heading">
                    <h4 class="panel-title">SEARCH E-PAYMENT REPORTS</h4>
                </div>
                <div class="panel-body">
                    {{-- <div class="col-md-12"> --}}
                    <form method="post" action="{{ url('/reconciliation-date-range') }}">
                        <div class="col-md-3" style="padding: 2px;">
                            {{ csrf_field() }}

                            <label>Date From</label>
                            <input type="text" name="dateFrom" class="form-control" id="dateFrom"
                                value="@if (session('reconciliation_from') != '') {{ session('reconciliation_from') }} @endif">
                        </div>
                        <div class="col-md-3" style="padding: 2px;">
                            <label>Date To</label>
                            <input type="text" name="dateTo" class="form-control" id="dateTo"
                                value="@if (session('reconciliation_to') == '') {{ date('Y-m-d') }}@else {{ session('reconciliation_to') }} @endif">
                        </div>


                        <div class="col-md-4" style="padding: 2px;">
                            <label>Bank</label>
                            <select name="bank_id" id="bank_id" class="form-control">
                                <option value="">--Select Bank--</option>
                                @foreach ($mandateAccounts as $account)
                                    <option value="{{ $account->id }}" @if (session('reconciliation_bank_id') == $account->id) selected @endif>

                                        {{ $account->bank ?? 'Central Bank of Nigeria' }} -
                                        {{ $account->account_no }}({{$account->contractType}})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2" style="padding: 2px; margin-top: 25px;">
                            <label></label>
                            <input type="submit" name="submit" class="btn btn-success" value="View">
                        </div>
                    </form>

                    {{-- </div> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-success" style="margin-top: 5px;">
                <div class="panel-heading">
                    <h4 class="panel-title text-center">E-PAYMENT REPORT</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ url('send-reconciliation-date-range-result') }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div style="margin-top: 5px;">
                                <strong>ATTACH BANK STATEMENT FROM
                                    {{ date('d-m-Y', strtotime(session('reconciliation_from'))) }} TO
                                    {{ date('d-m-Y', strtotime(session('reconciliation_to'))) }}</strong>
                                <div class="form-group">
                                    <label for="doc_url">Upload File <i style="color: red">*(PDF only...)*</i></label>
                                    <input type="file" name="doc_url" id="doc_url" class="form-control"
                                        value="{{ old('doc_url') }}" />
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="rFrom" class="form-control"
                            value="{{ session('reconciliation_from') }}">
                        <input type="hidden" name="rTo" class="form-control"
                            value="{{ session('reconciliation_to') }}">

                        <div class="col-md-4">
                            <div style="margin-top: 50px;">
                                {{-- <div class="col-md-4" style="padding: 2px; margin-top: 25px;">
                                <label></label> --}}
                                <button type="submit" class="btn btn-success" name="submit">Submit</button>
                            </div>
                        </div>
                </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tableData" style="margin-bottom: 50px;">

                        <tr class="tblborder">
                            <td class="tblborder">
                                <div align="center"><strong>S/N</strong></div>
                            </td>
                            <td class="tblborder">
                                <div align="center"><strong>BENEFICIARY</strong></div>
                                <div align="center"></div>
                                <div align="center"></div>
                            </td>
                            <td class="tblborder"><strong>BANK </strong></td>
                            <td class="tblborder">
                                <div align="center"><strong>ACC NUMBER</strong></div>
                            </td>
                            <td class="tblborder">
                                <div align="center"><strong>AMOUNT</strong> (&#8358;)</div>
                            </td>
                            {{-- <td class="tblborder"><strong>S/CODE</strong></td> --}}
                            <td class="tblborder"><strong>PURPOSE OF PAYMENT</strong></td>
                            <td class="tblborder"><strong>DATE</strong></td>
                        </tr>
                        <tbody>

                            @foreach ($mandate as $key => $md)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $md->contractor }}</td>
                                    <td>{{ $md->bank }}</td>
                                    <td>{{ $md->accountNo }}</td>
                                    <td style="text-align: right">{{ number_format($md->amount, 2) }}</td>
                                    {{-- <td>...</td> --}}
                                    <td>{{ $md->purpose }}</td>
                                    <td>{{ $md->date }}</td>
                                </tr>
                            @endforeach

                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!--Search all vouchers-->
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">

    <style type="text/css">
        .status {
            font-size: 15px;
            padding: 0px;
            height: 100%;

        }

        .textbox {
            border: 1px;
            background-color: #66FFBA;
            outline: 0;
            height: 25px;
            width: 275px;
        }

        $('.autocomplete-suggestions').css({
            color: 'red'
        });

        .autocomplete-suggestions {
            color: #66FFBA;
            height: 125px;
        }

        .table,
        tr,
        td {
            border: #9f9f9f solid 1px !important;
            font-size: 12px !important;
        }

        .table thead tr th {
            font-weight: 700;
            font-size: 17px;
            border: #9f9f9f solid 1px
        }
    </style>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'success',
                title: "{{ session('success') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: "{{ session('error') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif


    <script type="text/javascript">
        $(function() {
            $("#autocomplete").autocomplete({
                serviceUrl: murl + '/searchUser',
                minLength: 2,
                onSelect: function(suggestion) {
                    //alert('hello');
                    $('#nameID').val(suggestion.data);
                    //   alert(suggestion.data);


                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("table tr td .edit").click(function() {
                var batchNo = $(this).attr('id');
                $(".batch").val(batchNo);
                $("#batchNo").val(batchNo);

                $("#editModal").modal('show');

            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $(".pro").click(function() {
                var batch = $(this).attr('id');
                //alert(batch);

                $('#batchID').val(batch);
                $("#approveModal").modal('show');

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $(".reason").click(function() {

                var id = $(this).attr('val');
                var batch = $(this).attr('id');

                $.ajax({
                    // headers: {'X-CSRF-TOKEN': $token},
                    url: "{{ url('/rejection/reason') }}",

                    type: "post",
                    data: {
                        'batch': batch,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        //location.reload(true);
                        console.log(data.comment);
                        $('#reason').html(data.comment);
                    }
                });


                $("#rejectModal").modal('show');

            });

        });
    </script>

    <script type="text/javascript">
        $(function() {
            $("#dateTo").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd MM, yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                    $("#dateTo").val(dateFormatted);
                },
            });

        });

        $(function() {
            $("#dateFrom").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd MM, yy",
                //dateFormat: "D, MM d, yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                    $("#dateFrom").val(dateFormatted);
                },
            });

        });
    </script>
@endsection
