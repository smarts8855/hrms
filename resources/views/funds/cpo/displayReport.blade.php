@extends('layouts.layout')

@section('pageTitle')
    All Transaction Details
@endsection

@section('content')
    <div class="box-body">

        <div class="box-body hidden-print">
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




        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    {{ $company->companyName }} <br>
                    <small>Vouchers</small>
                </h3>
            </div>

            <div class="panel-body">

                <!-- Table Section -->
                <div class="table-responsive">
                    <form action="{{ url('/cpo/report') }}" method="post">
                        {{ csrf_field() }}

                        <table id="myTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Beneficiary</th>
                                    <th>Contract Type</th>
                                    <th class="text-center">Total Amount <br>&#8358;</th>

                                    <th colspan="4" class="text-center">
                                        Tick the box(es) to Process Mandate
                                        <br>
                                        @foreach ($contractTypes as $ctype)
                                            <label style="margin-right:15px;">
                                                <input type="checkbox" class="contractTypeFilter"
                                                    value="{{ $ctype->ID }}">
                                                {{ $ctype->contractType }}
                                            </label>
                                        @endforeach
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($audited as $key => $list)
                                    @php
                                        $staff = DB::table('tblvoucherBeneficiary')
                                            ->where('voucherID', $list->transID)
                                            ->first();
                                        $comments = DB::table('tblcomments')
                                            ->where('affectedID', $list->contractID)
                                            ->where('is_cpo_comment', 1)
                                            ->first();
                                    @endphp

                                    <tr class="{{ $comments ? 'danger' : '' }}">
                                        <input type="hidden" name="id[]" value="{{ $list->transID }}" />

                                        <td>{{ ($audited->currentpage() - 1) * $audited->perpage() + ($key + 1) }}</td>

                                        <td>
                                            {{$list->voucherFileNo ?? ''}}<br>
                                            @if ($list->companyID == 13)
                                                {{-- {{ $list->payment_beneficiary }} --}}
                                                {{$list->claimBene}}<br>
                                            @else
                                                {{ $list->contractor }}<br>
                                            @endif
                                            @if($list->beneClaimID)
                                                <a href="{{ url("/voucher-beneficiary/confirm/$list->transID") }}"
                                                    class="btn btn-success btn-xs">Confirm Beneficiaries
                                                </a>
                                            @endif
                                        </td>

                                        <td>{{ $list->contractType }} <br> <i>{{ $list->assignedTo ?? 'Not Assigned' }}</i></td>

                                        <td>{{ number_format($list->totalPayment, 2) }}</td>

                                        <!-- Checkbox Col -->
                                        <td width="80" class="text-center">
                                            @if ($list->voucher_lock < 1)
                                                <input type="checkbox" name="checkname[]" class="rowCheck"
                                                    data-type="{{ $list->contractTypeID }}" value="{{ $list->transID }}">
                                            @endif
                                        </td>

                                        <!-- Preview Voucher -->
                                        <td class="text-center" width="120">
                                            <a href="{{ url("/display/voucher/$list->transID") }}"
                                                class="btn btn-success btn-xs">
                                                Preview Voucher
                                            </a>
                                        </td>

                                        <!-- Supporting Docs -->
                                        <td class="text-center">
                                            @if ($list->voucher_lock < 1)
                                                <a class="btn btn-danger btn-xs"
                                                    href="{{ url("/display/comment/$list->contractID") }}">
                                                    Supporting Documents
                                                </a>
                                            @else
                                                <span class="btn btn-danger btn-xs">Voucher Locked</span>
                                            @endif
                                        </td>

                                        <!-- Reject -->
                                        <td class="text-center">
                                            @if ($list->voucher_lock < 1)
                                                <a href="javascript:void(0)" class="btn btn-primary btn-xs reject"
                                                    id="{{ $list->transID }}">
                                                    Reject Voucher
                                                </a>
                                            @else
                                                <span class="btn btn-primary btn-xs">Voucher Locked</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <hr />

                                @if (isset($audited) && $audited)
                                    Showing
                                    {{ ($audited->currentpage() - 1) * $audited->perpage() + 1 }}
                                    to
                                    {{ $audited->currentpage() * $audited->perpage() }}
                                    of {{ $audited->total() }} entries

                                    <div class="hidden-print pull-left">
                                        {{ $audited->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($totalRows > 0)
                            <input type="submit" name="submit" value="Generate" class="btn btn-success pull-right" />
                        @endif

                    </form>
                </div>
            </div>
        </div>

        <!-- /.row -->
    </div>

    <!-- Modal HTML -->
    <div id="myModal" class="modal fade myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{ url('/cpo/reject') }}" style="margin-top:10px;">
                        {{ csrf_field() }}
                        <input type="hidden" value="" name="transid" class="btn btn-success id" />

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="month">Reason for rejecting</label>
                                    <textarea name="remark" class="form-control remark" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 refer">
                                <div class="form-group">
                                    <label for="month">RETURN TO: <span style="color:red; font-weight: bold;">Please,
                                            select section to return voucher</span></label>
                                    <select name="attension" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="3">Audit</option>
                                        <!--<option value="2">Checking</option>-->
                                        <!--<option value="1">Expenditure Control</option>-->
                                        <!--<option value="0">Other Charges</option>-->

                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success proceed" name="submit" value="Reject" />

                        <div id="desc">

                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!--///// end modal -->

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
        th,
        td {
            border: #9f9f9f solid 1px !important;
            font-size: 12px !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("table tr td .reject").click(function() {
                var id = $(this).attr('id');
                $(".id").val(id);

                $("#myModal").modal('show');

            });
        });
    </script>

    <script>
        $(document).ready(function() {

            // --- When selecting a contractType checkbox ---
            $(document).on("change", ".contractTypeFilter", function() {

                // If user checks one contract type filter
                if ($(this).is(":checked")) {
                    let selectedType = $(this).val();

                    // Disable all other contractType checkboxes
                    $(".contractTypeFilter").not(this).prop("checked", false).prop("disabled", true);

                    // Reset all row checkboxes
                    $(".rowCheck")
                        .prop("checked", false)
                        .prop("disabled", true); // Disable everything first

                    // Enable & check only matching rows
                    $('.rowCheck[data-type="' + selectedType + '"]')
                        .prop("disabled", false)
                        .prop("checked", true);

                } else {
                    // If unchecking the selected filter → reset fully
                    $(".contractTypeFilter").prop("disabled", false);
                    $(".rowCheck").prop("checked", false).prop("disabled", false);
                }
            });

        });
    </script>
@endsection
