@extends('layouts_procurement.app')
@section('pageTitle', 'Contract List')
@section('content')



    <div class="row">
        <div class="col-md-12">

            @include('procurement.ShareView.operationCallBackAlert')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Contract Details</h4>
                </div>

                <div class="panel-body">

                    <table class="table table-bordered table-striped" style="width:100%;">
                        <tbody>

                            <tr>
                                <th style="width:30%; background:#555; color:#fff;">Lot No.</th>
                                <td>{{ $item->lot_number }}</td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Sublot No.</th>
                                <td>{{ $item->sublot_number }}</td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Contract Name</th>
                                <td>{{ $item->contract_name }}</td>
                            </tr>

                            <tr valign="top">
                                <th style="background:#555; color:#fff;">Description</th>
                                <td>{!! $item->contract_description !!}</td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Category</th>
                                <td>{{ $item->category_name }}</td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Proposed Budget</th>
                                <td>{{ number_format($item->proposed_budget, 2) }}</td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Approval Date</th>
                                <td>{{ $item->approval_date ? date('jS M Y', strtotime($item->approval_date)) : ' - ' }}
                                </td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Review Date</th>
                                <td>{{ $item->review_date ? date('jS M Y', strtotime($item->review_date)) : ' - ' }}</td>
                            </tr>

                            <tr>
                                <th style="background:#555; color:#fff;">Time Frame</th>
                                <td>{{ $item->proposed_time_frame ? date('jS M Y', strtotime($item->proposed_time_frame)) : ' - ' }}
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>



@endsection

@section('styles')
@endsection

@section('scripts')
@endsection
