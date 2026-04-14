@extends('layouts_procurement.app')
@section('pageTitle', 'Financial Bidding Evaluation')
@section('pageMenu', 'active')
@section('content')
    {{-- @include('Bank.layouts.messages') --}}

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase"><b>
                    Financial Bidding Evaluation</b></h3>
        </div>
        <div class="panel-body">
            @if (count($datas) > 0)
                <div class="text-center">
                    <h3 style="margin-left:14px; margin-bottom:30px; font-weight:bold">Lot No: <span
                            class="text-success">{{ $datas[0]->lot_number }}</span> <br> Contract Title: <span
                            class="text-success">{{ $datas[0]->contract_name }}</span><br>
                        Amount: <span class="text-success"> {{ number_format($datas[0]->proposed_budget, 2) }}</span></h3>
                    <a href="{{ '/contracts-coments/' . base64_encode($datas[0]->contract_detailsID) }}"
                        target="_blank"><button class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:-20px; margin-bottom:50px">View
                            Minutes</button></a>
                    <a href="{{ '/requalify-bids/' . encrypt($datas[0]->contract_detailsID) }}" target="_blank"><button
                            class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Disqualified Bids</button></a>
                </div>
                @if ($files != null)
                    <a href="{{ asset('images/' . $files->file_name) }}" target="_blank"><button
                            class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Document Attached</button></a>
                @endif

                <div class="row">
                    <div class="col-12" style="padding: 10px">
                        <div class="panel panel-default" style="border-radius:6px; box-shadow:0 0 5px rgba(0,0,0,0.1);">
                            <div class="panel-body" style="padding: 12px">
                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
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
                                        @php $counter = 0; @endphp
                                        @foreach ($datas as $data)
                                            @php $counter++; @endphp
                                            <tr data-stat="{{ $data->status }}"
                                                data-recommendation="{{ $data->recommendation }}">
                                                <td>{{ $counter }}</td>
                                                <td>{{ $data->company_name }}</td>
                                                <td style="text-align:right">{{ number_format($data->bidding_amount, 2) }}
                                                </td>
                                                <td>{{ date_format(date_create($data->date_submitted), 'jS M Y') }}</td>
                                                <td>
                                                    <span>{{ count($data->documents) }} document(s) </span> |
                                                    <a href="#" data-target="#file{{ $data->contract_biddingID }}"
                                                        data-toggle="modal"
                                                        class="{{ $data->recommendation == 1 ? 'text-white' : '' }}">view
                                                        all</a>
                                                </td>
                                                <td>
                                                    @if (
                                                        ($data->contractStatus == 1 || $data->contractStatus == 4) &&
                                                            ($data->current_location == 0 || $data->current_location == 1))
                                                        @if ($data->status == 0)
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#requalify{{ $data->contract_biddingID }}">
                                                                <i class="fa fa-check"></i> Requalify
                                                            </button>
                                                        @else
                                                            @if ($data->recommendation == 0)
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    style="margin-bottom:5px;" data-toggle="modal"
                                                                    data-target="#disqualify{{ $data->contract_biddingID }}">
                                                                    <i class="fa fa-times"></i> Disqualify
                                                                </button>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if ($data->recommendation == 0 && $data->status > 0)
                                                        <button class="btn btn-sm btn-primary recommend_option"
                                                            style="margin-bottom:5px;" data-toggle="modal"
                                                            data-target="#recommend{{ $data->contract_biddingID }}">
                                                            <i class="fa fa-thumbs-up"></i> Recommend
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modals Section (outside the table) -->
                @foreach ($datas as $data)
                    <!-- Documents Modal -->
                    <div class="modal fade" id="file{{ $data->contract_biddingID }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Bidding Documents</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($data->documents as $key => $document)
                                        <a href="{{ asset($document->bidDocument) }}"
                                            target="_blank">{{ $document->bid_doc_description }}</a>
                                        @if ($key + 1 < count($data->documents))
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requalify Modal -->
                    @if ($data->status == 0)
                        <div class="modal fade" id="requalify{{ $data->contract_biddingID }}" tabindex="-1"
                            role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $data->company_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST"
                                        action="{{ '/pro-procurement/bidding/requalify/' . $data->contract_biddingID }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <p style="color:grey;">Please give a reason for your Requalification of<br>
                                                {{ $data->company_name }}'s Contract</p>
                                            <div class="form-group">
                                                <textarea name="disqualifyComment" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Requalify Contract</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Disqualify Modal -->
                    @if ($data->status > 0 && $data->recommendation == 0)
                        <div class="modal fade" id="disqualify{{ $data->contract_biddingID }}" tabindex="-1"
                            role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $data->company_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST"
                                        action="{{ '/pro-procurement/bidding/disqualify/' . $data->contract_biddingID }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <p style="color:grey;">Please give a reason for your Disqualification of<br>
                                                {{ $data->company_name }}'s Contract</p>
                                            <div class="form-group">
                                                <textarea name="disqualifyComment" class="form-control" id="disqualifyComment{{ $data->contract_biddingID }}"
                                                    required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger"
                                                id="disqualifyButton{{ $data->contract_biddingID }}">Disqualify
                                                Contract</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Recommend Modal -->
                    @if ($data->recommendation == 0 && $data->status > 0)
                        <div class="modal fade" id="recommend{{ $data->contract_biddingID }}" tabindex="-1"
                            role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $data->company_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST"
                                        action="{{ '/pro-procurement/bidding/recommend/' . $data->contract_detailsID }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <p style="color:grey;">Please give a reason for your Recommendation of<br>
                                                {{ $data->company_name }}'s Contract</p>
                                            <input type="hidden" name="biddingID"
                                                value="{{ $data->contract_biddingID }}">
                                            <div class="form-group">
                                                <textarea name="comment" class="form-control" placeholder="reason" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Recommend Bid</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                @php
                    $hasRecommended = false;
                    foreach ($datas as $data) {
                        if ($data->recommendation == 1) {
                            $hasRecommended = true;
                            break;
                        }
                    }
                @endphp

                @if ($current_location < 2 && $contract->status == 1 && $hasRecommended)
                    <div class="row">
                        <div style="margin-left:13px; margin-top:20px; margin-bottom:20px;">
                            @if (isset($threshold) && $threshold)
                                <div class="alert alert-info"
                                    style="margin-bottom:20px; padding:15px; background-color:#d9edf7; border-color:#bce8f1; color:#31708f;">
                                    <h5><i class="fa fa-info-circle"></i> Auto-Movement Based on Threshold</h5>
                                    <hr>
                                    <p><strong>Proposed Budget:</strong>
                                        ₦{{ number_format($contract->proposed_budget, 2) }}
                                    </p>
                                    <p><strong>Threshold Range:</strong> {{ $threshold->role }}
                                        (₦{{ number_format($threshold->min, 2) }} -
                                        ₦{{ number_format($threshold->max, 2) }})
                                    </p>

                                    @if ($threshold->role == 'CR')
                                        <div class="alert alert-success"
                                            style="margin-top:10px; margin-bottom:5px; background-color:#dff0d8; border-color:#d6e9c6; color:#3c763d;">
                                            <i class="fa fa-arrow-right"></i> <strong>This contract will be automatically
                                                moved
                                                to
                                                Chief Registrar (CR)</strong>
                                        </div>
                                    @elseif($threshold->role == 'DTB')
                                        <div class="alert alert-warning"
                                            style="margin-top:10px; margin-bottom:5px; background-color:#fcf8e3; border-color:#faebcc; color:#8a6d3b;">
                                            <i class="fa fa-arrow-right"></i> <strong>This contract will be automatically
                                                moved
                                                to
                                                Tenders Board (DTB)</strong>
                                        </div>
                                    @elseif($threshold->role == 'FJTB')
                                        <div class="alert alert-primary"
                                            style="margin-top:10px; margin-bottom:5px; background-color:#d9edf7; border-color:#bce8f1; color:#31708f;">
                                            <i class="fa fa-arrow-right"></i> <strong>This contract will be automatically
                                                moved
                                                to
                                                Federal Judiciary Tenders Board (FJTB)</strong>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <button id="block" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#blocks" style="border-radius:6px; margin-left:0;">
                                <i class="fa fa-ban"></i> Cancel Bids
                            </button>
                        </div>
                    </div>
                @else
                    @if (isset($datas[0]) && $datas[0])
                        <div class="row">
                            <div style="margin-left:13px; margin-top:20px;">
                                <button type="button" class="btn btn-success" disabled style="border-radius:6px;">
                                    <i class="fa fa-map-marker"></i>
                                    @if ($current_location == 2)
                                        Location : Chief Registrar
                                    @elseif($current_location == 3)
                                        Location : Tender's Board
                                    @elseif($current_location == 5)
                                        Location : Federal Judiciary Tender's Board
                                    @else
                                        Location: Director Procurement
                                    @endif
                                </button>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Cancel Bids Modal -->
                <div class="modal fade" id="blocks" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cancel Bids</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST"
                                action="{{ '/pro-procurement/to-block/' . base64_encode($datas[0]->contractID) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <p style="color:grey;">Are you sure you would like to cancel contract?</p>
                                    <div class="form-group">
                                        <label>Reason</label>
                                        <textarea name="cancelContractComment" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Continue</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <h3 style="margin-left:14px; margin-bottom:30px; font-weight:bold">
                    Lot No: <span class="text-success">{{ $contract->lot_number }}</span> <br>
                    Contract Title: <span class="text-success">{{ $contract->contract_name }}</span><br>
                    Amount: <span class="text-success"> {{ number_format($contract->proposed_budget, 2) }}</span>
                </h3>
                <a href="{{ '/contract-comments/' . encrypt($contract->contract_detailsID) }}"><button
                        class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">View
                        Minutes</button></a>
                <a href="{{ '/requalify-bids/' . encrypt($contract->contract_detailsID) }}"><button
                        class="btn btn-success btn-sm"
                        style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Disqualified
                        Bids</button></a>
                @if ($files != null)
                    <a href="{{ asset('images/' . $files->file_name) }}" target="_blank"><button
                            class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Document Attached</button></a>
                @endif

                <div class="row">
                    <div class="col-12" style="padding: 10px">
                        <div class="alert alert-warning" style="margin-left:13px;">
                            <p>No Current Biddings Found</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@section('styles')
    <style>
        .status {
            margin-bottom: 15px;
        }

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }

        .alert-primary {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #31708f;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .alert-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            color: #8a6d3b;
        }

        #block {
            margin-left: 0;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Highlight recommended rows
            $("tr[data-recommendation='1']").css({
                "background-color": "rgba(28,187,140,0.25)",
                "color": "black"
            });

            // Highlight disqualified rows
            $("tr[data-stat='0']").css({
                "background-color": "rgba(220,20,60,0.1)",
                "color": "black"
            });
        });

        @if (session('success'))
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
        @endif

        @if (session('error'))
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
        @endif
    </script>
@endsection
