@extends('layouts_procurement.app')
@section('pageTitle', 'List of Contracts')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default"> <!-- Bootstrap 3 card replacement -->
                <div class="panel-heading">
                    @include('procurement.ShareView.operationCallBackAlert')
                </div>

                <div class="panel-body">



                    <!-- Search Panel (Bootstrap 3 style) -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Search Contracts</h4>
                        </div>

                        <div class="panel-body">
                            <div class="header-search col-md-12">
                                <div class="search-header-w">

                                    <!-- Mobile Search Icon -->
                                    <div class="btn btn-search-mobi visible-xs">
                                        <i class="fa fa-search"></i>
                                    </div>

                                    <div class="form_search col-md-offset-2">
                                        <form class="formSearch" action="{{ route('secretary-approved-list') }}"
                                            method="get">
                                            <div class="row">
                                                <!-- Status Filter -->
                                                <div class="col-md-10">
                                                    <select name="filter_status" class="form-control">
                                                        <option value="">Filter by status</option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Rejected</option>
                                                    </select>
                                                </div>

                                                <!-- Search Button -->
                                                <div class="col-md-10" style="margin-top:10px; text-align:right;">
                                                    <button class="btn btn-success" type="submit">
                                                        <span class="btnSearchText hidden-xs">Search</span>
                                                        <i class="fa fa-search visible-xs"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Dropdown Suggestion Box -->
                                            <div class="pl-3 pr-3"
                                                style="position:absolute; width:100%; overflow:hidden; max-height:500px;
                            border-radius:0 0 4px 4px; background:#ffffff;
                            box-shadow:0 4px 8px rgba(0,0,0,0.2), 0 6px 20px rgba(0,0,0,0.19);">

                                                {{-- <table id="tblSearchGet" class="table">
                                                    <tbody class="bg-light">
                                                        <tr></tr>
                                                    </tbody>
                                                </table> --}}

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- Table -->
                    <table class="table table-striped table-bordered table-responsive" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Lot No.</th>
                                <th>Contract Name</th>
                                <th>Proposed Amount</th>
                                <th>Contractor</th>
                                <th>Awarded Amount</th>
                                <th>Date Action Taken</th>
                                <th>Status</th>
                                <th>Minutes</th>
                            </tr>
                        </thead>

                        @php $n = 1; @endphp

                        <tbody>
                            @foreach ($getContracts as $list)
                                <?php $para = base64_encode($list->contract_detailsID); ?>
                                <tr class="{{ $list->cba_status == 2 ? 'bg-danger text-white' : '' }}">
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $list->lot_number }}</td>
                                    <td>{{ $list->contract_name }}</td>
                                    <td class="text-right">#{{ number_format($list->proposed_budget, 2) }}</td>
                                    <td>{{ $list->company_name }}</td>
                                    <td class="text-right">#{{ number_format($list->awarded_amount, 2) }}</td>
                                    <td>{{ $list->approval_date }}</td>
                                    <td>{{ $list->cba_status == 2 ? 'Rejected' : 'Approved' }}</td>

                                    <td>
                                        <a href="/contracts-coments/{{ $para }}"
                                            class="btn btn-success btn-sm text-white">
                                            View Minutes
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div> <!-- panel -->
        </div>
    </div>



@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

@endsection
