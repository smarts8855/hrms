@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Disabled Contracts') }}
@endsection
@section('pageMenu', 'active')
@section('content')
    @include('procurement.Bank.layouts.messages')

    {{-- @if (count($disabled) > 0)
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Contract</th>
                                    <th>Lot No.</th>
                                    <th>Sublot No.</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>


                            <tbody>
                                <p style="display:none">{{ $counter = 0 }}</p>

                                @foreach ($disabled as $data)
                                    <tr>
                                        <td>{{ $counter = $counter + 1 }}</td>
                                        <td>{{ $data->contract_name }}</td>
                                        <td>{{ $data->lot_number }}</td>
                                        <td>{{ $data->sublot_number }}</td>
                                        <td>{{ $data->contract_description }}</td>
                                        <td>{{ number_format($data->proposed_budget, 2) }}</td>
                                        <td>{{ date_format(date_create($data->created_at), 'jS M Y') }}</td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target={{ '#enable' . $data->contract_detailsID }}>
                                                Enable Contract
                                            </button>

                                            <!-- Modal -->

                                            <div class="modal fade" id={{ 'enable' . $data->contract_detailsID }}
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ $data->lot_number }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <p style="color:grey;">Please give a reason to Enable contract:
                                                                {{ $data->contract_name . 's Contract' }}</p>
                                                            <form method="POST"
                                                                action={{ '/renable-contract/' . $data->contract_detailsID }}>
                                                                @csrf
                                                                <div class="form-group">
                                                                    <textarea name="enableContractComment" class="form-control" placeholder="reason"></textarea>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel</button>

                                                            <button type="submit" class="btn btn-success">Enable
                                                                Contract</button>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>

            </div> <!-- end col -->
        </div> <!-- end row -->
    @else
        <h2>No Canceled Contracts</h2>
    @endif --}}

    @if (count($disabled) > 0)
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Canceled Contracts</h4>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Contract</th>
                                    <th>Lot No.</th>
                                    <th>Sublot No.</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <p style="display:none;">{{ $counter = 0 }}</p>

                                @foreach ($disabled as $data)
                                    <tr>
                                        <td>{{ $counter = $counter + 1 }}</td>
                                        <td>{{ $data->contract_name }}</td>
                                        <td>{{ $data->lot_number }}</td>
                                        <td>{{ $data->sublot_number }}</td>
                                        <td>{{ $data->contract_description }}</td>
                                        <td>{{ number_format($data->proposed_budget, 2) }}</td>
                                        <td>{{ date_format(date_create($data->created_at), 'jS M Y') }}</td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="{{ '#enable' . $data->contract_detailsID }}">
                                                Enable Contract
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="{{ 'enable' . $data->contract_detailsID }}"
                                                tabindex="-1" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;
                                                            </button>
                                                            <h4 class="modal-title">
                                                                {{ $data->lot_number }}
                                                            </h4>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p style="color:grey;">
                                                                Please give a reason to enable:
                                                                <strong>{{ $data->contract_name }}'s Contract</strong>
                                                            </p>

                                                            <form method="POST"
                                                                action="/renable-contract/{{ $data->contract_detailsID }}">
                                                                @csrf

                                                                <div class="form-group">
                                                                    <textarea name="enableContractComment" class="form-control" placeholder="Reason" required></textarea>
                                                                </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                                Cancel
                                                            </button>

                                                            <button type="submit" class="btn btn-success">
                                                                Enable Contract
                                                            </button>

                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <!-- End Modal -->

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div> <!-- end col -->
        </div> <!-- end row -->
    @else
        <h3>No Canceled Contracts</h3>
    @endif






@endsection

@section('styles')
    <style>
        .status {
            margin-bottom: 15px;
        }

        #to_tenders {
            margin-left: 15px;
        }
    </style>
@endsection

@section('scripts')
@endsection
