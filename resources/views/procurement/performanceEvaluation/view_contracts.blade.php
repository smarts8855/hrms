@extends('layouts_procurement.app')
@section('pageTitle', 'Agreement Letters')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">

                <div class="panel-heading" style="background:#fff; border-bottom:1px solid #ddd;">
                    <h4 class="panel-title" style="margin:0; padding:8px 0; font-weight:bold;">
                        @yield('pageTitle')
                    </h4>
                </div>

                <div class="panel-body">
                    @include('procurement.ShareView.operationCallBackAlert')

                    <table id="datatable-buttonsx" class="table table-striped table-bordered table-responsive"
                        style="width:100%;">

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
                                <?php $para = base64_encode($list->contract_detailsID); ?>

                                @if ($list->is_agreement != 0)
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $list->lot_number }}</td>
                                        <td>{{ $list->contract_name }}</td>
                                        <td>{{ $list->contract_description }}</td>
                                        <td class="text-right">{{ number_format($list->proposed_budget, 2) }}</td>

                                        <td>
                                            <a href="/contracts-coments/{{ $para }}" target="_blank"
                                                class="btn btn-success btn-sm">View Minutes</a>
                                        </td>

                                        <td>
                                            <a href="agreement-letter/{{ $para }}" target="_blank"
                                                style="cursor:pointer; font-style:italic; color:green;">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>



@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

@endsection
