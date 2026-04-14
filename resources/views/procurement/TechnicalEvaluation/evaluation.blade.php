@extends('layouts_procurement.app')
@section('pageTitle', 'Technical Bid Evaluation')
@section('pageMenu', 'active')
@section('content')


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase"><b>
                    Technical Bid Evaluation</b></h3>
        </div>

        <div class="panel-body">
            @include('Bank.layouts.messages')
            @if (count($datas) > 0)
                <div class="text-center">
                    <h3 style="margin-left:14px; margin-bottom:30px; font-weight:bold">Lot No: <span
                            class="text-success">{{ $datas[0]->lot_number }}</span> <br> Contract Title: <span
                            class="text-success">{{ $datas[0]->contract_name }}</span><br>
                        {{-- Amount: <span class="text-success"> {{ number_format($datas[0]->proposed_budget, 2) }}</span></h3> --}}
                        <a href="{{ '/contracts-coments/' . base64_encode($datas[0]->contract_detailsID) }}"
                            target="_blank"><button class="btn btn-success btn-sm"
                                style="margin-left:14px; margin-top:5px; margin-bottom:50px">View
                                Minutes</button></a>
                        <a href="{{ '/requalify-bids/' . encrypt($datas[0]->contract_detailsID) }}" target="_blank"><button
                                class="btn btn-success btn-sm"
                                style="margin-left:14px; margin-top: 5px; margin-bottom:50px">Disqualified
                                Bids</button></a>
                </div>
                @if ($files == null)
                @else
                    <a href="{{ asset('images/' . $files->file_name) }}" target="_blank"><button
                            class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Document Attached</button></a>
                @endif

                <div class="row">
                    <div class="col-12" style="padding: 10px">
                        <div class="panel panel-default" style="border-radius:6px; box-shadow:0 0 5px rgba(0,0,0,0.1);">
                            <div class="panel-body">

                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Contractor</th>
                                            <th>Date Submitted</th>
                                            <th>Documents</th>
                                            <th class="text-center">Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <p style="display:none">{{ $counter = 0 }}</p>

                                        @foreach ($datas as $data)
                                            @php
                                                $counter = $counter + 1;

                                                $fileModalId = 'file' . $data->contract_biddingID;
                                                $requalifyModalId = 'requalify' . $data->contract_biddingID;
                                                $disqualifyModalId = 'disqualify' . $data->contract_biddingID;
                                                $recommendModalId = 'recommend' . $data->contract_biddingID;

                                                $canTechAction =
                                                    ($data->contractStatus == 1 || $data->contractStatus == 4) &&
                                                    ($data->current_location == 0 || $data->current_location == 1) &&
                                                    $data->tech_evaluation == 0;
                                            @endphp

                                            <tr data-stat="{{ $data->status }}"
                                                data-recommendation="{{ $data->recommendation }}">
                                                <td>{{ $counter }}</td>
                                                <td>{{ $data->company_name }}</td>
                                                <td>{{ date_format(date_create($data->date_submitted), 'jS M Y') }}</td>

                                                <td>
                                                    <span>{{ count($data->documents) }} document(s)</span> |

                                                    @if ($data->recommendation == 1)
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#{{ $fileModalId }}" style="color:white;">view
                                                            all</a>
                                                    @else
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#{{ $fileModalId }}">view all</a>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($data->tech_evaluation == 1)
                                                        <span class="glyphicon glyphicon-ok text-success"
                                                            aria-hidden="true"></span>
                                                        <span class="sr-only">Passed</span>
                                                    @else
                                                        <span class="glyphicon glyphicon-remove text-danger"
                                                            aria-hidden="true"></span>
                                                        <span class="sr-only">Not passed</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($canTechAction)
                                                        {{-- Requalify / Disqualify button --}}
                                                        @if ($data->status == 0)
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal" data-target="#{{ $requalifyModalId }}">
                                                                Requalify
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                style="margin-bottom:5px;" data-toggle="modal"
                                                                data-target="#{{ $disqualifyModalId }}">
                                                                Disqualify
                                                            </button>
                                                        @endif

                                                        {{-- Recommend button --}}
                                                        <button class="btn btn-sm btn-primary recommend_option"
                                                            data-toggle="modal" value="{{ $data->contract_biddingID }}"
                                                            data-recommendation="{{ $data->recommendation }}"
                                                            data-target="#{{ $recommendModalId }}"
                                                            style="margin-bottom:5px;">
                                                            Recommend
                                                        </button>
                                                    @else
                                                        {{-- Reverse --}}
                                                        <form
                                                            action="{{ url('/pro-procurement/bidding/tech-evaluate/recommend/reverse/' . $data->contractID) }}"
                                                            method="post" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" value="{{ $data->contract_biddingID }}"
                                                                name="biddingID">

                                                            @if ($data->recommendation == 0)
                                                                <button class="btn btn-primary btn-sm" type="submit">
                                                                    <span class="glyphicon glyphicon-repeat"></span> Reverse
                                                                </button>
                                                            @endif
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- ===================== MODALS (OUTSIDE <tr>) ===================== --}}

                                            {{-- Documents Modal --}}
                                            <div class="modal fade" id="{{ $fileModalId }}" tabindex="-1" role="dialog"
                                                aria-labelledby="{{ $fileModalId }}Label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="{{ $fileModalId }}Label">Bidding
                                                                Documents
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            @foreach ($data->documents as $key => $document)
                                                                <a href="{{ asset($document->bidDocument) }}"
                                                                    target="_blank">
                                                                    {{ $document->bid_doc_description }}
                                                                </a>
                                                                <br>

                                                                @if ($key + 1 != count($data->documents))
                                                                    <hr>
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Requalify / Disqualify Modal --}}
                                            @if ($canTechAction)
                                                @php $actionModalId = ($data->status == 0) ? $requalifyModalId : $disqualifyModalId; @endphp

                                                <div class="modal fade" id="{{ $actionModalId }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="{{ $actionModalId }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="{{ $actionModalId }}Label">
                                                                    {{ $data->company_name }}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                @if ($data->status == 0)
                                                                    <p style="color:grey;">
                                                                        Please give a reason for your Requalification of
                                                                        <br>
                                                                        {{ $data->company_name . 's Contract' }}
                                                                    </p>

                                                                    <form method="POST"
                                                                        action="{{ '/pro-procurement/bidding/tech-evaluate/requalify/' . $data->contract_biddingID }}">
                                                                    @else
                                                                        <p style="color:grey;">
                                                                            Please give a reason for your Disqualification
                                                                            of <br>
                                                                            {{ $data->company_name . 's Contract' }}
                                                                        </p>

                                                                        <form method="POST"
                                                                            action="{{ '/pro-procurement/bidding/tech-evaluate/disqualify/' . $data->contract_biddingID }}">
                                                                @endif

                                                                @csrf
                                                                @method('PUT')

                                                                <div class="form-group">
                                                                    <label
                                                                        for="disqualifyTechComment{{ $data->contract_biddingID }}"
                                                                        style="color:grey">
                                                                        Reason
                                                                    </label>

                                                                    <textarea name="disqualifyComment" class="form-control" id="disqualifyTechComment{{ $data->contract_biddingID }}"></textarea>
                                                                </div>

                                                                {{-- legacy hidden field; keep but make ID unique --}}
                                                                <textarea style="visibility:hidden" name="comment" id="other-field-{{ $data->contract_biddingID }}"
                                                                    class="form-control other-field" placeholder="reason"></textarea>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Cancel</button>

                                                                @if ($data->status == 0)
                                                                    <button type="submit" class="btn btn-success">
                                                                        Requalify Contract
                                                                    </button>
                                                                @else
                                                                    <button type="submit" class="btn btn-danger"
                                                                        id="disqualifyTechButton-{{ $data->contract_biddingID }}"
                                                                        disabled>
                                                                        Disqualify Contract
                                                                    </button>
                                                                @endif
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Recommend Modal --}}
                                                <div class="modal fade" id="{{ $recommendModalId }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="{{ $recommendModalId }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="{{ $recommendModalId }}Label">
                                                                    {{ $data->company_name }}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <p style="color:grey;">
                                                                    Please give a reason for your Recommendation of <br>
                                                                    {{ $data->company_name . 's Contract' }}
                                                                </p>

                                                                <form method="POST"
                                                                    action="{{ '/pro-procurement/bidding/tech-evaluate/recommend/' . $data->contract_detailsID }}">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <input type="hidden"
                                                                        value="{{ $data->contract_biddingID }}"
                                                                        name="biddingID">

                                                                    <div class="form-group">
                                                                        <textarea name="comment" id="recommend-comment-{{ $data->contract_biddingID }}" class="form-control"
                                                                            placeholder="reason"></textarea>
                                                                    </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Recommend
                                                                    Bid</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Cancel</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- ===================== END MODALS ===================== --}}
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


                @if ($datas[0]->current_location < 2 && $contract->status == 1)
                    <div class="row">


                        <button id="block" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#blocks">
                            <i class="fa fa-ban"></i> Cancel Bids
                        </button>

                        <div class="modal fade" id="secretary" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Move To Secretary</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:grey;">Please Add a comment</p>
                                        <form method="POST" action="/procurement/approve/{{ $datas[0]->contractID }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <textarea name="comment" class="form-control" placeholder="comment"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Documents:</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="description" class="form-control" placeholder="Document Description"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Move</button>
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="warning" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:grey;">You need to block bids before you can move</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="tenders" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Move To Tenders Board</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:grey;">Please give a reason for Moving To Tenders Board</p>
                                        <form method="POST" action="/procurement/to-tenders/{{ $datas[0]->contractID }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <textarea name="comment" class="form-control" placeholder="reason"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Documents:</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="description" class="form-control" placeholder="Document Description"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Move</button>
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="f_tenders" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Move To Federal Judiciary Tenders
                                            Board
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:grey;">Please give a reason for Moving To Federal Judiciary Tenders
                                            Board
                                        </p>
                                        <form method="POST"
                                            action="/procurement/to-f-tenders/{{ $datas[0]->contractID }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <textarea name="comment" class="form-control" placeholder="reason"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload Documents:</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="description" class="form-control" placeholder="Document Description"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Move</button>
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="blocks" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cancel Bids</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="color:grey;">Are you sure you would like to cancel contract</p>
                                        <form method="POST"
                                            action="/pro-procurement/tech-evaluate/to-block/{{ base64_encode($datas[0]->contractID) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label class="form-check-label" for="exampleCheck1"
                                                style="color:grey">Reason</label>
                                            <textarea name="cancelContractComment" class="form-control"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Continue</button>
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form method="POST" action="/procurement/approve/{{ $datas[0]->contractID }}">
                        @csrf

                        <button type="submit" id="to_secretary" class="btn btn-success" disabled>
                            @if ($datas[0]->current_location == 2)
                                Location : Secretary
                            @elseif($datas[0]->current_location == 3)
                                Location : Tender's Board
                            @elseif($datas[0]->current_location == 5)
                                Location : Federal Judiciary Tender's Board
                            @else
                                Location: Director Procurement
                            @endif

                        </button>
                    </form>


                @endif
            @else
                <h3 style="margin-left:14px; margin-bottom:30px; font-weight:bold">Lot No: <span
                        class="text-success">{{ $contract->lot_number }}</span> <br> Contract Title: <span
                        class="text-success">{{ $contract->contract_name }}</span><br>
                    {{-- Amount: <span class="text-success"> {{ number_format($contract->proposed_budget, 2) }}</span></h3> --}}
                    <a href="{{ '/contract-comments/' . encrypt($contract->contract_detailsID) }}"><button
                            class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:5px; margin-bottom:50px">View
                            Minutes</button></a>
                    <a href="{{ '/requalify-bids/' . encrypt($contract->contract_detailsID) }}"><button
                            class="btn btn-success btn-sm"
                            style="margin-left:14px; margin-top:5px; margin-bottom:50px">Disqualified
                            Bids</button></a>
                    @if ($files == null)
                    @else
                        <a href="{{ asset('images/' . $files->file_name) }}" target="_blank"><button
                                class="btn btn-success btn-sm"
                                style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Document
                                Attached</button></a>
                    @endif

                    <p>No Current Bids Found</p>
            @endif

        </div>
    </div>

@endsection

@section('styles')
    <style>
        .status {
            margin-bottom: 15px;
        }

        #to_tenders {
            margin-left: 15px;
        }

        #block {
            margin-left: 15px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(function() {

            // 1) Toggle the "other-field" ONLY inside the same modal
            var display = true;

            $(document).on('change', '.other', function() {
                var $modal = $(this).closest('.modal');
                var $field = $modal.find('.other-field');

                if (display === true) {
                    $field.css("visibility", "visible");
                    display = false;
                } else {
                    $field.css("visibility", "hidden");
                    display = true;
                }
            });

            // When cancel is clicked, hide other-field only in that modal
            $(document).on('click', '.cancel', function() {
                var $modal = $(this).closest('.modal');
                $modal.find('.other-field').css("visibility", "hidden");
                display = true;
            });

            // Also when modal closes (X or outside click), reset its other-field
            $(document).on('hidden.bs.modal', '.modal', function() {
                $(this).find('.other-field').css("visibility", "hidden");
                display = true;
            });

            // 2) Row styling (same as your legacy)
            var recommended = $("tr[data-recommendation='1']");
            recommended.css("background-color", "rgba(28,187,140,0.25)");
            recommended.css("color", "white");

            var bidStatus = $("tr[data-stat='0']");
            bidStatus.css("background-color", "rgba(220,20,60,0.4)");
            bidStatus.css("color", "white");

            // 3) Enable/disable Disqualify button per modal (works for ALL rows)
            $(document).on('input', 'textarea[id^="disqualifyTechComment"]', function() {
                var id = this.id.replace('disqualifyTechComment', ''); // gets the biddingID suffix
                var $btn = $('#disqualifyTechButton-' + id);

                if ($(this).val().trim() !== "") {
                    $btn.prop('disabled', false);
                } else {
                    $btn.prop('disabled', true);
                }
            });

        });
    </script>

@endsection
