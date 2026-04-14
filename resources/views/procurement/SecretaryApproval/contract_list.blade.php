@extends('layouts_procurement.app')
@section('pageTitle', 'List of Contracts')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <!-- Panel Heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Contracts List</h4>
                </div>

                <!-- Success / Error Alerts -->
                <div class="panel-body">
                    @include('procurement.ShareView.operationCallBackAlert')

                    <table class="table table-striped table-bordered table-responsive"
                        style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Lot No.</th>
                                <th>Contract Name</th>
                                <th>Contract Description</th>
                                <th>Proposed Amount</th>
                                <th>Minutes</th>
                                <th>Bidders</th>
                            </tr>
                        </thead>

                        @php $n = 1; @endphp

                        <tbody>
                            @foreach ($getContracts as $list)
                                <?php $para = base64_encode($list->contractID); ?>
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $list->lot_number }}</td>
                                    <td>{{ $list->contract_name }}</td>
                                    <td>{{ $list->contract_description }}</td>
                                    <td align="right">{{ number_format($list->proposed_budget, 2) }}</td>

                                    <td>
                                        <a href="/contracts-coments/{{ $para }}" class="btn btn-success btn-sm">
                                            View Minutes
                                        </a>
                                    </td>

                                    <td>
                                        <a href="view-list/{{ $para }}" target="_blank"
                                            style="cursor:pointer; font-style:italic; color:#00BC90;">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div><!-- panel-body -->
            </div><!-- panel -->
        </div>
    </div>



@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

@endsection
