@extends('layouts_procurement.app')
@section('pageTitle', 'Financial Bidding Evaluation')
@section('pageMenu', 'active')
@section('content')

    <div class="box-body" style="background:#FFF;">
        <div class="row">
            {{-- <div class="col-md-12">
                @include('Bank.layouts.messages')
            </div> --}}

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

                        <!-- Contract Overview Card - ALWAYS SHOW THIS ONLY ONCE -->
                        @if (isset($contract) && $contract)
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

                                                        <td><strong>{{ $data->company_name }}</strong></td>

                                                        <td class="text-center text-primary">
                                                            <strong>{{ number_format($data->bidding_amount, 2) }}</strong>
                                                        </td>

                                                        <td>{{ date_format(date_create($data->date_submitted), 'jS M Y') }}
                                                        </td>

                                                        <td>
                                                            <strong>{{ count($data->documents) }} document(s)</strong> |
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#file{{ $data->contract_biddingID }}">
                                                                view all
                                                            </a>
                                                        </td>

                                                        <!-- Documents Modal -->
                                                        <div class="modal fade" id="file{{ $data->contract_biddingID }}"
                                                            tabindex="-1" role="dialog">

                                                            <div class="modal-dialog">
                                                                <div class="modal-content">

                                                                    <div class="modal-header"
                                                                        style="background:#5bc0de; color:#fff;">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                        <h4 class="modal-title">
                                                                            <i class="fa fa-file"></i> Bidding Documents
                                                                        </h4>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        @if (count($data->documents) > 0)
                                                                            @foreach ($data->documents as $key => $document)
                                                                                <a href="{{ asset($document->bidDocument) }}"
                                                                                    target="_blank" class="block">
                                                                                    <i
                                                                                        class="fa fa-file-pdf-o text-danger"></i>
                                                                                    {{ $document->bid_doc_description }}
                                                                                </a>
                                                                                @if ($key + 1 < count($data->documents))
                                                                                    <hr>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <p>No documents available</p>
                                                                        @endif
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- End Documents Modal -->


                                                        <!-- ACTION BUTTONS -->
                                                        <td>


                                                            @if (
                                                                ($data->contractStatus == 1 || $data->contractStatus == 4) &&
                                                                    ($data->current_location == 0 || $data->current_location == 1))
                                                                {{-- Requalify --}}
                                                                @if ($data->status == 0)
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#requalify{{ $data->contract_biddingID }}">
                                                                        <i class="fa fa-check"></i> Requalify
                                                                    </button>
                                                                @else
                                                                    {{-- Disqualify --}}
                                                                    @if ($data->recommendation == 0)
                                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-target="#disqualify{{ $data->contract_biddingID }}">
                                                                            <i class="fa fa-times"></i> Disqualify
                                                                        </button>
                                                                    @endif
                                                                @endif


                                                                <!-- Requalify / Disqualify Modal -->
                                                                <div class="modal fade"
                                                                    id="{{ $data->status == 0 ? 'requalify' : 'disqualify' }}{{ $data->contract_biddingID }}"
                                                                    tabindex="-1" role="dialog">

                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">

                                                                            <div
                                                                                class="modal-header {{ $data->status == 0 ? 'bg-success' : 'bg-danger' }}">
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal">
                                                                                    <span>&times;</span>
                                                                                </button>
                                                                                <h4 class="modal-title">
                                                                                    <i
                                                                                        class="fa {{ $data->status == 0 ? 'fa-check' : 'fa-times' }}"></i>
                                                                                    {{ $data->company_name }}
                                                                                </h4>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <p>
                                                                                    Please give a reason for
                                                                                    <strong>
                                                                                        {{ $data->status == 0 ? 'Requalification' : 'Disqualification' }}
                                                                                        of {{ $data->company_name }}
                                                                                    </strong>
                                                                                </p>

                                                                                <form method="POST"
                                                                                    action="{{ $data->status == 0
                                                                                        ? '/procurement/bidding/requalify/' . $data->contract_biddingID
                                                                                        : '/procurement/bidding/disqualify/' . $data->contract_biddingID }}">
                                                                                    @csrf
                                                                                    @method('PUT')

                                                                                    <textarea name="disqualifyComment" class="form-control" rows="3" placeholder="Enter reason here..."></textarea>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">
                                                                                    Cancel
                                                                                </button>

                                                                                @if ($data->status == 0)
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">
                                                                                        <i class="fa fa-check"></i>
                                                                                        Requalify Contract
                                                                                    </button>
                                                                                @else
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">
                                                                                        <i class="fa fa-times"></i>
                                                                                        Disqualify Contract
                                                                                    </button>
                                                                                @endif
                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!-- END Requalify/Disqualify -->


                                                                {{-- Recommend --}}
                                                                @if ($data->recommendation == 0)
                                                                    <button class="btn btn-primary btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#recommend{{ $data->contract_biddingID }}">
                                                                        <i class="fa fa-thumbs-up"></i> Recommend
                                                                    </button>
                                                                @endif

                                                                <!-- Recommend Modal -->
                                                                <div class="modal fade"
                                                                    id="recommend{{ $data->contract_biddingID }}"
                                                                    tabindex="-1" role="dialog">

                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">

                                                                            <div class="modal-header bg-primary">
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal">
                                                                                    <span>&times;</span>
                                                                                </button>
                                                                                <h4 class="modal-title">
                                                                                    <i class="fa fa-thumbs-up"></i>
                                                                                    {{ $data->company_name }}
                                                                                </h4>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <p>
                                                                                    Please give a reason for recommending
                                                                                    <strong>{{ $data->company_name }}</strong>
                                                                                </p>

                                                                                <form method="POST"
                                                                                    action="/pro-procurement/bidding/recommend/{{ $data->contract_detailsID }}">
                                                                                    @csrf
                                                                                    @method('PUT')

                                                                                    <input type="hidden" name="biddingID"
                                                                                        value="{{ $data->contract_biddingID }}">

                                                                                    <textarea name="comment" class="form-control" rows="3" placeholder="Reason for recommendation"></textarea>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="submit"
                                                                                    class="btn btn-success">
                                                                                    <i class="fa fa-thumbs-up"></i>
                                                                                    Recommend Bid
                                                                                </button>

                                                                                <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">
                                                                                    Cancel
                                                                                </button>
                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!-- END Recommend -->
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
                            <!-- No Data Card - SIMPLIFIED VERSION WITHOUT DUPLICATE CONTRACT INFO -->
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
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
            });
        </script>
    @endif



@endsection
