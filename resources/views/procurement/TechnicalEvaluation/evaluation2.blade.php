@extends('layouts_procurement.app')
@section('pageTitle', 'Financial Bidding Evaluation')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('Bank.layouts.messages')
            </div>

            <div class="col-md-12">
                <div class="box-header with-border hidden-print">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="box-title"><b>Financial Bidding Evaluation</b></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 style="font-size: 14px; text-decoration: none;">
                                <i class="fa fa-list"></i> Total Bids: {{ isset($datas) ? count($datas) : 0 }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header with-border hidden-print text-center">
                            <hr>
                        </div>

                        @if (isset($contract) && $contract)
                            <!-- Contract Overview Card -->
                            <div class="card border-0 bg-white shadow-sm mb-4">
                                <div class="card-body text-center">
                                    <h3 class="card-title mb-3 fw-bold">
                                        Lot No: <span class="text-success">{{ $contract->lot_number }}</span><br>
                                        Contract Title: <span class="text-success">{{ $contract->contract_name }}</span><br>
                                        Amount: <span
                                            class="text-success">{{ number_format($contract->proposed_budget, 2) }}</span>
                                    </h3>
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <a href="{{ '/contracts-coments/' . base64_encode($contract->contract_detailsID) }}"
                                            target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa fa-eye mr-1"></i> View Minutes
                                        </a>
                                        <a href="{{ '/requalify-bids/' . encrypt($contract->contract_detailsID) }}"
                                            target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa fa-list mr-1"></i> Disqualified Bids
                                        </a>
                                        @if (isset($files) && $files != null)
                                            <a href="{{ asset('images/' . $files->file_name) }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-file mr-1"></i> Document Attached
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h4>Contract Not Found</h4>
                                <p>The requested contract could not be found.</p>
                            </div>
                        @endif

                        @if (isset($datas) && count($datas) > 0)
                            <!-- Bidding Evaluation Table -->
                            <div class="card border-0 bg-white shadow-sm mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fa fa-table mr-2"></i>Bidding Evaluation
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
                                                        <td>{{ date_format(date_create($data->date_submitted), 'jS M Y') }}
                                                        </td>
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
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
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
                                                                @if ($data->status == 0)
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm mb-1"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#requalify{{ $data->contract_biddingID }}">
                                                                        <i class="fa fa-check mr-1"></i> Requalify
                                                                    </button>
                                                                @else
                                                                    @if ($data->recommendation == 0)
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm mb-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#disqualify{{ $data->contract_biddingID }}">
                                                                            <i class="fa fa-times mr-1"></i> Disqualify
                                                                        </button>
                                                                    @endif
                                                                @endif

                                                                <!-- Requalify/Disqualify Modal -->
                                                                <div class="modal fade text-left d-print-none"
                                                                    id="{{ $data->status == 0 ? 'requalify' : 'disqualify' }}{{ $data->contract_biddingID }}"
                                                                    tabindex="-1"
                                                                    aria-labelledby="actionModalLabel{{ $data->contract_biddingID }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div
                                                                                class="modal-header {{ $data->status == 0 ? 'bg-success' : 'bg-danger' }}">
                                                                                <h5 class="modal-title text-white"
                                                                                    id="actionModalLabel{{ $data->contract_biddingID }}">
                                                                                    <i
                                                                                        class="fa {{ $data->status == 0 ? 'fa-check' : 'fa-times' }} mr-2"></i>{{ $data->company_name }}
                                                                                </h5>
                                                                                <button type="button"
                                                                                    class="close text-white"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-muted">
                                                                                    Please give a reason for your
                                                                                    {{ $data->status == 0 ? 'Requalification' : 'Disqualification' }}
                                                                                    of <br>
                                                                                    <strong>{{ $data->company_name }}'s
                                                                                        Contract</strong>
                                                                                </p>
                                                                                <form method="POST"
                                                                                    action="{{ $data->status == 0 ? '/procurement/bidding/requalify/' . $data->contract_biddingID : '/procurement/bidding/disqualify/' . $data->contract_biddingID }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            for="disqualifyComment{{ $data->contract_biddingID }}"
                                                                                            class="form-label text-muted">Reason</label>
                                                                                        <textarea name="disqualifyComment" class="form-control" id="disqualifyComment{{ $data->contract_biddingID }}"
                                                                                            rows="3" placeholder="Enter reason here..."></textarea>
                                                                                    </div>
                                                                                    <textarea style="display: none" name="comment" class="form-control"></textarea>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-outline-secondary"
                                                                                    data-bs-dismiss="modal">
                                                                                    <i class="fa fa-times mr-1"></i> Cancel
                                                                                </button>
                                                                                @if ($data->status == 0)
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">
                                                                                        <i class="fa fa-check mr-1"></i>
                                                                                        Requalify Contract
                                                                                    </button>
                                                                                @else
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger"
                                                                                        id="disqualifyButton{{ $data->contract_biddingID }}"
                                                                                        disabled>
                                                                                        <i class="fa fa-times mr-1"></i>
                                                                                        Disqualify Contract
                                                                                    </button>
                                                                                @endif
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if ($data->recommendation == 0)
                                                                    <button
                                                                        class="btn btn-sm btn-primary recommend_option mb-1"
                                                                        data-bs-toggle="modal"
                                                                        value="{{ $data->contract_biddingID }}"
                                                                        data-recommendation="{{ $data->recommendation }}"
                                                                        data-bs-target="#recommend{{ $data->contract_biddingID }}">
                                                                        <i class="fa fa-thumbs-up mr-1"></i> Recommend
                                                                    </button>
                                                                @endif

                                                                <!-- Recommend Modal -->
                                                                <div class="modal fade text-left d-print-none"
                                                                    id="recommend{{ $data->contract_biddingID }}"
                                                                    tabindex="-1"
                                                                    aria-labelledby="recommendModalLabel{{ $data->contract_biddingID }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-primary">
                                                                                <h5 class="modal-title text-white"
                                                                                    id="recommendModalLabel{{ $data->contract_biddingID }}">
                                                                                    <i
                                                                                        class="fa fa-thumbs-up mr-2"></i>{{ $data->company_name }}
                                                                                </h5>
                                                                                <button type="button"
                                                                                    class="close text-white"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-muted">
                                                                                    Please give a reason for your
                                                                                    Recommendation of <br>
                                                                                    <strong>{{ $data->company_name }}'s
                                                                                        Contract</strong>
                                                                                </p>
                                                                                <form method="POST"
                                                                                    action="{{ '/procurement/bidding/recommend/' . $data->contract_detailsID }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="biddingID"
                                                                                        value="{{ $data->contract_biddingID }}">
                                                                                    <div class="mb-3">
                                                                                        <textarea name="comment" class="form-control" placeholder="Reason for recommendation" rows="3"></textarea>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    <i class="fa fa-thumbs-up mr-1"></i>
                                                                                    Recommend Bid
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-outline-secondary"
                                                                                    data-bs-dismiss="modal">
                                                                                    <i class="fa fa-times mr-1"></i> Cancel
                                                                                </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
                                        <h4>No Active Bids Found</h4>
                                        <p>No current biddings available for evaluation.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
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
            let display = true;

            $('.other').on('change', function() {
                if (display) {
                    $('.other-field').css("visibility", "visible");
                    display = false;
                } else {
                    $('.other-field').css("visibility", "hidden");
                    display = true;
                }
            });

            $('.cancel').on('click', function() {
                $('.other-field').css("visibility", "hidden");
                display = true;
            });

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

            // Enable/disable disqualify buttons based on textarea input
            document.addEventListener("DOMContentLoaded", function() {
                const textareas = document.querySelectorAll('textarea[id^="disqualifyComment"]');

                textareas.forEach(textarea => {
                    const submitButton = document.getElementById('disqualifyButton' + textarea.id
                        .replace('disqualifyComment', ''));
                    if (submitButton) {
                        textarea.addEventListener('input', function() {
                            submitButton.disabled = textarea.value.trim() === "";
                        });
                    }
                });
            });
        });
    </script>
@endsection
