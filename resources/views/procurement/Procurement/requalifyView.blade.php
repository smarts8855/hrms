@extends('layouts_procurement.app')
@section('pageTitle', 'Bid Requalification')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('Bank.layouts.messages')
            </div>

            <div class="col-md-12">
                @if (count($datas) > 0)
                    <!-- Contract Overview Card -->
                    <div class="card border-0 bg-white shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-3 fw-bold">
                                Lot No: <span class="text-success">{{ $datas[0]->lot_number }}</span><br>
                                Contract Title: <span class="text-success">{{ $datas[0]->contract_name }}</span><br>
                                Amount: <span class="text-success">{{ number_format($datas[0]->proposed_budget, 2) }}</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Bidding Evaluation Table -->
                    <div class="card border-0 bg-white shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-table mr-2"></i>Disqualified Bids for Requalification
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-bordered">
                                    <thead class="text-gray-b">
                                        <tr>
                                            <th>SN</th>
                                            <th>Contractor</th>
                                            <th>Bid Amount</th>
                                            <th>Awarded Amount</th>
                                            <th>Date Submitted</th>
                                            <th>Documents</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $index => $data)
                                            <tr data-stat="{{ $data->status }}"
                                                data-recommendation="{{ $data->recommendation }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td class="font-weight-bold">{{ $data->company_name }}</td>
                                                <td class="text-right font-weight-bold text-primary">
                                                    {{ number_format($data->bidding_amount, 2) }}</td>
                                                <td class="text-right font-weight-bold text-success">
                                                    {{ number_format($data->awarded_amount, 2) }}</td>
                                                <td>{{ date_format(date_create($data->date_submitted), 'jS M Y') }}</td>
                                                <td>
                                                    <span class="font-weight-bold">{{ count($data->documents) }}
                                                        document(s)</span> |
                                                    <a href="#contract{{ $data->contract_biddingID }}"
                                                        data-bs-target="#file{{ $data->contract_biddingID }}"
                                                        data-bs-toggle="modal"
                                                        class="{{ $data->recommendation == 1 ? 'text-white' : '' }}">
                                                        view all
                                                    </a>
                                                </td>

                                                <!-- Documents Modal -->
                                                <div class="modal fade text-left d-print-none"
                                                    id="file{{ $data->contract_biddingID }}" tabindex="-1"
                                                    aria-labelledby="fileModalLabel{{ $data->contract_biddingID }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info">
                                                                <h5 class="modal-title text-white"
                                                                    id="fileModalLabel{{ $data->contract_biddingID }}">
                                                                    <i class="fa fa-file mr-2"></i>Bidding Documents
                                                                </h5>
                                                                <button type="button" class="close text-white"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (isset($data->documents) && count($data->documents) > 0)
                                                                    @foreach ($data->documents as $key => $document)
                                                                        <a href="{{ asset($document->bidDocument) }}"
                                                                            target="_blank"
                                                                            class="d-block mb-2 font-weight-bold">
                                                                            <i
                                                                                class="fa fa-file-pdf mr-2 text-danger"></i>{{ $document->bid_doc_description }}
                                                                        </a>
                                                                        @if ($key + 1 < count($data->documents))
                                                                            <hr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <p class="text-muted">No documents available</p>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="fa fa-times mr-1"></i> Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <td>
                                                    @if (
                                                        ($data->contractStatus == 1 || $data->contractStatus == 4) &&
                                                            ($data->current_location == 0 || $data->current_location == 1))
                                                        {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#requalify{{ $data->contract_biddingID }}">
                                                            <i class="fa fa-check mr-1"></i> Requalify
                                                        </button> --}}
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#requalify{{ $data->contract_biddingID }}">
                                                            <i class="fa fa-check mr-1"></i> Requalify
                                                        </button>

                                                        <!-- Requalify Modal -->
                                                        {{-- <div class="modal fade text-left d-print-none"
                                                            id="requalify{{ $data->contract_biddingID }}" tabindex="-1"
                                                            aria-labelledby="requalifyModalLabel{{ $data->contract_biddingID }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success">
                                                                        <h5 class="modal-title text-white"
                                                                            id="requalifyModalLabel{{ $data->contract_biddingID }}">
                                                                            <i
                                                                                class="fa fa-check mr-2"></i>{{ $data->company_name }}
                                                                        </h5>
                                                                        <button type="button" class="close text-white"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-muted">
                                                                            Please give a reason for your Requalification of
                                                                            <br>
                                                                            <strong>{{ $data->company_name }}'s
                                                                                Contract</strong>
                                                                        </p>
                                                                        <form method="POST"
                                                                            action="{{ '/procurement/bidding/requalify/' . $data->contract_biddingID }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    for="requalifyComment{{ $data->contract_biddingID }}"
                                                                                    class="form-label text-muted">Reason</label>
                                                                                <textarea name="comment" class="form-control" id="requalifyComment{{ $data->contract_biddingID }}" rows="3"
                                                                                    placeholder="Enter reason for requalification..."></textarea>
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="fa fa-times mr-1"></i> Cancel
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="fa fa-check mr-1"></i> Requalify
                                                                            Contract
                                                                        </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}

                                                        <div class="modal fade text-left d-print-none"
                                                            id="requalify{{ $data->contract_biddingID }}" tabindex="-1"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success">
                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal"><span>&times;</span></button>
                                                                        <h5 class="modal-title text-white">
                                                                            <i
                                                                                class="fa fa-check mr-2"></i>{{ $data->company_name }}
                                                                        </h5>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <p class="text-muted">
                                                                            Please give a reason for your Requalification of
                                                                            <br>
                                                                            <strong>{{ $data->company_name }}'s
                                                                                Contract</strong>
                                                                        </p>

                                                                        <form method="POST"
                                                                            action="{{ '/pro-procurement/bidding/requalify/' . $data->contract_biddingID }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="form-group">
                                                                                <label>Reason</label>
                                                                                <textarea name="comment" class="form-control" rows="3" placeholder="Enter reason..."></textarea>
                                                                            </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">
                                                                            <i class="fa fa-times mr-1"></i> Cancel
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="fa fa-check mr-1"></i> Requalify
                                                                            Contract
                                                                        </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end Requalify Modal -->
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Data Card -->
                    <div class="card border-0 bg-white shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="text-muted">
                                <i class="fa fa-file-contract fa-3x mb-3"></i>
                                <h4>No Disqualified Contracts</h4>
                                <p>There are currently no disqualified bids available for requalification.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .box-body {
            background: #FFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: #ffffff !important;
            border: 1px solid #dee2e6 !important;
        }

        .card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #dee2e6 !important;
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

        .modal-header {
            border-radius: 8px 8px 0 0;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Style rows based on status and recommendation
            const recommended = $("tr[data-recommendation='1']");
            $(recommended).css({
                "background-color": "rgba(28,187,140,0.25)",
                "color": "white"
            });

            const bidStatus = $("tr[data-stat='0']");
            $(bidStatus).css({
                "background-color": "rgba(220,20,60,0.4)",
                "color": "white"
            });

            // Disable buttons for recommended bids
            if (recommended.length == 0) {
                $('#to_secretary').prop('disabled', true);
                $('#to_tenders').prop('disabled', true);
            } else {
                const buttonRecommended = $("button[data-recommendation='1']");
                $(buttonRecommended).prop('disabled', true);
            }

            // Recommendation functionality
            let state = false;
            let mike;
            $('#to_secretary').prop('disabled', true);

            $('.recommend_option').click(function() {
                state = !state;
                $('.recommend_option').prop('disabled', state);
                mike = $(this).val();
                $('#to_secretary').prop('disabled', !state);
                $("#recommendedID").val($(this).val());
                $(this).prop('disabled', false);
            });
        });
    </script>
@endsection
