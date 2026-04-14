@extends('layouts_procurement.app')
@section('pageTitle', 'Procurement')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">

            <!-- HEADER PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><b>Search Contracts</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px;">
                                <i class="fa fa-list"></i> Total Contracts: {{ $datas->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <form method="post" action="{{ route('pro-procurement.search') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Select Contract</label>
                                    <select name="contract" class="form-control select2" id="contract">
                                        <option value="">Select Contract</option>
                                        @foreach ($contracts as $list)
                                            <option value="{{ $list->contract_detailsID }}"
                                                @if ($list->contract_detailsID == session('contractSession')) selected @endif>
                                                {{ $list->contract_name . ' - ' . $list->lot_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa fa-search mr-1"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">

            <!-- HEADER PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><b>Procurement Contracts</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px;">
                                <i class="fa fa-list"></i> Total Contracts: {{ $datas->count() }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>LOT NUMBER</th>
                                    <th>CONTRACT NAME</th>
                                    <th>BUDGET</th>
                                    <th>CONTRACT STATUS</th>
                                    <th>STATUS</th>
                                    <th>BIDS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 0; @endphp
                                @foreach ($datas as $data)
                                    @php $counter++; @endphp
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td class="font-weight-bold">{{ $data->lot_number }}</td>
                                        <td class="font-weight-bold">{{ $data->contract_name }}</td>
                                        <td class="text-right font-weight-bold text-primary">
                                            {{ number_format($data->proposed_budget, 2) }}
                                        </td>
                                        <td>
                                            @if ($data->location == 1)
                                                <span class="label label-info">Procurement</span>
                                            @elseif($data->location == 4)
                                                <span class="label label-warning">Director</span>
                                            @elseif($data->location == 3)
                                                <span class="label label-warning">Tender's Board</span>
                                            @elseif($data->location == 5)
                                                <span class="label label-warning">Federal Judicial Tender's
                                                    Board</span>
                                            @else
                                                <span class="label label-default">Chief Registrar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->status == 4)
                                                <span class="label label-danger">Rejected</span>
                                                <button type="button" class="btn btn-link btn-xs p-0 rejection-button"
                                                    data-toggle="modal" data-reason="{{ $data->reject_comment }}"
                                                    data-target="#rejectionModal">
                                                    <small><em>View Reason</em></small>
                                                </button>
                                            @elseif($data->status == 1)
                                                <span class="label label-success">Active</span>
                                            @elseif($data->status == 3)
                                                <span class="label label-primary">Approved</span>
                                            @else
                                                <span class="label label-default">Disabled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="font-weight-bold">{{ $data->bids }}</span>
                                            (<span class="text-success">{{ $data->activeBids }}</span> /
                                            <span class="text-danger">{{ $data->disabledBids }}</span>)
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                                href="{{ '/pro-procurement/contract/' . encrypt($data->contract_detailsID) }}">
                                                <i class="fa fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($datas->count() == 0)
                            <div class="text-center" style="padding: 40px;">
                                <i class="fa fa-file-contract fa-3x text-muted mb-3"></i>
                                <h4>No Contracts Found</h4>
                                <p>No contracts available for procurement.</p>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- Rejection Comments Modal -->
    <div class="modal fade text-left d-print-none" id="rejectionModal" tabindex="-1" role="dialog"
        aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">
                        <i class="fa fa-comment"></i> Rejection Comments
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        <strong>Rejection Reason:</strong>
                    </div>
                    <p class="text-muted" id="reject-comment" style="font-size: 14px; line-height: 1.6;">
                        <!-- Rejection comment will be inserted here by JavaScript -->
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Close
                    </button>
                </div>
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

        .badge {
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 15px;
        }

        .btn-link {
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }

        .mt-4 {
            margin-top: 30px;
        }

        .label {
            font-size: 11px;
            font-weight: 500;
            border-radius: 3px;
            padding: 5px 8px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // Rejection comments modal
            $('.rejection-button').on('click', function() {
                var reason = $(this).attr('data-reason');
                $('#reject-comment').text(reason || 'No reason provided.');
            });
        });
    </script>
@endsection
