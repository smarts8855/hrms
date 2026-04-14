@extends('layouts_procurement.app')
@section('pageTitle', 'List of Bidding Contracts')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">

            <!-- HEADER PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><b>Bidding Contracts List</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px;">
                                <i class="fa fa-gavel"></i> Total Bids: {{ $display->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <!-- SEARCH FORM PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h5 class="panel-title mb-3">
                                <i class="fa fa-search mr-2"></i> Search Bids
                            </h5>
                            <form class="custom-validation" method="post" action="{{ url('/view-bidding') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Contract</label>
                                            <select name="contract" class="form-control select2" id="contract">
                                                <option value="">Select Contract</option>
                                                @foreach ($contract as $list)
                                                    <option value="{{ $list->contract_detailsID }}"
                                                        @if ($list->contract_detailsID == session('contractSession')) selected @endif>
                                                        {{ $list->contract_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">OR</span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Search By Contractor</label>
                                            <select name="contractor" class="form-control select2" id="contractor">
                                                <option value="">Select Contractor</option>
                                                @foreach ($contractor as $list)
                                                    <option value="{{ $list->contractor_registrationID }}"
                                                        @if ($list->contractor_registrationID == session('contractorSession')) selected @endif>
                                                        {{ $list->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <span class="text-muted">OR</span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Search by Status</label>
                                            <select name="status" class="form-control select2" id="status">
                                                <option value="">Select Status</option>
                                                @foreach ($status as $list)
                                                    <option value="{{ $list->statusID }}"
                                                        @if ($list->statusID == session('statusSession')) selected @endif>
                                                        {{ $list->status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-success btn-block">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- BIDS TABLE PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>LOT NUMBER</th>
                                            <th>CONTRACT</th>
                                            <th>CONTRACTOR</th>
                                            <th>BIDDING AMOUNT</th>
                                            <th>BIDDING DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $n=1; @endphp
                                        @foreach ($display as $list)
                                            @php
                                                $para = base64_encode($list->contract_biddingID);
                                            @endphp
                                            <tr>
                                                <td>{{ $n++ }}</td>
                                                <td class="font-weight-bold">{{ $list->lot_number }}</td>
                                                <td class="font-weight-bold">{{ $list->contract_name }}</td>
                                                <td class="font-weight-bold">{{ $list->company_name }}</td>
                                                <td class="text-right font-weight-bold text-primary">
                                                    {{ number_format($list->bidding_amount, 2) }}</td>
                                                <td>{{ date('jS M, Y', strtotime($list->date_submitted)) }}</td>
                                                <td>
                                                    <a href="{{ url('/edit/bid/' . $para) }}" class="btn btn-info btn-sm">
                                                        <i class="fa fa-edit mr-1"></i> Modify
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if ($display->count() == 0)
                                    <div class="text-center" style="padding: 40px;">
                                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                        <h4>No Bids Found</h4>
                                        <p>No bidding contracts match your search criteria.</p>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Edit Bid Modal -->
    <div class="modal fade text-left d-print-none bs-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="editBidModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">
                        <i class="fa fa-edit"></i> Edit Bid Information
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ url('/update-bidding') }}" class="custom-validation"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="bidID">
                                    <label>Contract <span class="text-danger">*</span></label>
                                    <select class="form-control" name="contract" id="contractModal" required>
                                        <option value="">Select Contract</option>
                                        @foreach ($contract as $list)
                                            <option value="{{ $list->contract_detailsID }}">{{ $list->contract_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contractor <span class="text-danger">*</span></label>
                                    <select class="form-control" name="contractor" id="contractorModal" required>
                                        <option value="">Select Contractor</option>
                                        @foreach ($contractor as $list)
                                            <option value="{{ $list->contractor_registrationID }}">
                                                {{ $list->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Contractor Remark <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="contractorRemark" id="contractorRemark" rows="3"
                                        placeholder="Enter contractor remarks" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bidding Amount <span class="text-danger">*</span></label>
                                    <input type="text" name="biddingAmount" class="form-control bidAmt"
                                        id="biddingAmount" placeholder="Enter bidding amount" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date Submitted <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" id="date"
                                        max="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check mr-1"></i> Update Bid
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ccc !important;
            border-radius: 6px !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #007bff;
        }

        .text-muted {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // Number formatting for bidding amount
            $(".bidAmt").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });

            // Edit button click handler
            $(".table tr td .editButton").click(function() {
                var id = $(this).attr('id');
                $('#bidID').val(id);

                $.ajax({
                    url: '{{ url('/fetch-bid') }}',
                    type: "post",
                    data: {
                        'bidID': id,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        $('#date').val(data.date_submitted);
                        $('#contractorRemark').val(data.contractor_remark);
                        $('#biddingAmount').val(data.bidding_amount);
                        $('#contractModal').append('<option value="' + data.contract_detailsID +
                            '" selected>' + data.contract_name + '</option>');
                        $('#contractorModal').append('<option value="' + data
                            .contractor_registrationID + '" selected>' + data.company_name +
                            '</option>');
                    }
                });

                $(".bs-example-modal-lg").modal('show');
            });

            // Fix for dropdown selection issue - REMOVE the clearing functionality
            // Allow all dropdowns to be selected independently
            // Remove these lines that were causing the issue:
            // $("#contractor").change(function() {
            //     $("#contract").val('').trigger('change');
            // });
            //
            // $("#contract").change(function() {
            //     $("#contractor").val('').trigger('change');
            // });

            // Instead, let all dropdowns work independently
            // No need to clear other dropdowns when one is selected
            console.log("Dropdowns are now independent - all can be selected");
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this bid?');
        }
    </script>
@endsection
