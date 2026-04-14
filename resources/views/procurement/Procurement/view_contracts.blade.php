@extends('layouts_procurement.app')
@section('pageTitle', 'Award Letters')
@section('pageMenu', 'active')
@section('content')




    <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12">
                @include('ShareView.operationCallBackAlert')
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            <h3 class="panel-title"><b>Award Letters</b></h3>
                        </div>
                        <div class="pull-right">
                            <h4 style="font-size: 14px;">
                                <i class="fa fa-trophy"></i> Total Contracts: {{ $getContracts->count() }}
                            </h4>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>LOT NO.</th>
                                        <th>REF. NO.</th>
                                        <th>CONTRACT NAME</th>
                                        <th>CONTRACT DESCRIPTION</th>
                                        <th>PROPOSED AMOUNT</th>
                                        <th>MINUTES</th>
                                        <th>BIDDERS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n=1; @endphp
                                    @foreach ($getContracts as $key => $list)
                                        @php $para = base64_encode($list->contractID); @endphp
                                        <tr>
                                            <td>{{ $n++ }}</td>
                                            <td class="font-weight-bold">{{ $list->lot_number }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{-- {{ $list->reference_number ?? 'N/A' }} --}}
                                                    {{ $list->reference_number }}/{{ date('Y') }}
                                                </span>
                                            </td>
                                            <td class="font-weight-bold">{{ $list->contract_name }}</td>
                                            <td>
                                                {{ $list->contract_description ? substr($list->contract_description, 0, 100) : ' - ' }}
                                                @if (strlen($list->contract_description) > 100)
                                                    ... <button type="button" class="btn btn-link btn-xs p-0 text-info"
                                                        data-toggle="modal"
                                                        data-target=".viewMoreDescription{{ $key }}">
                                                        View more
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-right text-primary font-weight-bold">
                                                {{ number_format($list->proposed_budget, 2) }}</td>
                                            <td>
                                                <a href="/contracts-coments/{{ $para }}"
                                                    class="btn btn-info btn-xs">
                                                    <i class="fa fa-file-alt mr-1"></i> View Minutes
                                                </a>
                                            </td>
                                            <td>
                                                <a href="award-letter/{{ $para }}" target="_blank"
                                                    class="btn btn-success btn-xs">
                                                    <i class="fa fa-users mr-1"></i> View Bidders
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- View More Description Modal -->
                                        <div class="modal fade text-left d-print-none viewMoreDescription{{ $key }}"
                                            tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <h4 class="modal-title text-white">
                                                            <i class="fa fa-file-text mr-2"></i> Contract Description
                                                        </h4>
                                                        <button type="button" class="close text-white" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <h5 class="text-primary">
                                                                    <i class="fa fa-briefcase mr-2"></i>
                                                                    {{ $list->contract_name }}
                                                                </h5>
                                                                <p style="line-height: 1.8; font-size: 14px;">
                                                                    {{ $list->contract_description }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <div class="text-muted">
                                                                    <i class="fa fa-hashtag mr-2"></i>
                                                                    <strong>Lot Number:</strong> {{ $list->lot_number }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <div class="text-muted">
                                                                    <i class="fa fa-money-bill mr-2"></i>
                                                                    <strong>Budget:</strong>
                                                                    {{ number_format($list->proposed_budget, 2) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            <i class="fa fa-times mr-1"></i> Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($getContracts->count() == 0)
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fa fa-trophy fa-3x mb-3"></i>
                                    <h4>No Contracts Available</h4>
                                    <p>There are no contracts available for award letters at this time.</p>
                                </div>
                            </div>
                        @endif

                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </div>
        </div>
    </div>


@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
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

        .btn-link {
            text-decoration: none;
            padding: 0;
            border: none;
            background: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .card-text {
            white-space: pre-line;
            word-wrap: break-word;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        // Additional JavaScript can be added here if needed
        $(document).ready(function() {
            // Any initialization code can go here
        });
    </script>
@endsection
