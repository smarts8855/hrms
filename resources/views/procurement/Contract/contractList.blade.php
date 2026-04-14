@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Contract List') }}
@endsection
@section('content')


    <div class="row">
        <div class="col-md-12">
            @include('procurement.ShareView.operationCallBackAlert')

            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top:7px;">View All Contracts List</h4>
                </div>

                <div class="panel-body">
                    {{-- <!-- Start Search --> --}}
                    <div class="well" style="background:#f9f9f9; border:1px solid #ddd; padding:15px;">
                        <form class="formSearch"
                            action="{{ Route::has('searchContractReport') ? Route('searchContractReport') : '#' }}"
                            method="get">


                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8 mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="form-control" type="search" name="q" id="txtSearchJquery"
                                                placeholder="Enter keywords here..." autocomplete="on" />
                                        </div>
                                    </div>

                                    <!-- Added margin-top for spacing between keyword input and date fields -->
                                    <div class="row" style="margin-top: 15px;">
                                        <div class="col-md-6">
                                            <label>Start Date</label>
                                            <input class="form-control" type="date" name="startDate"
                                                placeholder="Select Date" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>End Date</label>
                                            <input class="form-control" type="date" name="endDate"
                                                placeholder="Select Date" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-right" style="margin-top: 15px;">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>


                            <div class="pl-3 pr-3"
                                style="position:absolute;width:100%;overflow:hidden;max-height:500px;border-radius:0 0 4px 4px;background:#ffffff;box-shadow:0 4px 8px rgba(0,0,0,0.2),0 6px 20px rgba(0,0,0,0.19);display:none;"
                                id="searchResults">
                                <table id="tblSearchGet" class="table table-bordered table-condensed">
                                    <tbody class="bg-light">
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    {{-- <!-- End Search --> --}}

                    <hr />

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>LOT</th>
                                    <th>SUBLOT</th>
                                    <th>REFERENCE No.</th>
                                    <th>Contract Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th class="text-right">Amount</th>
                                    <th>Status</th>
                                    <th>Close Bidding Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($getContractDetails) && is_iterable($getContractDetails))
                                    @foreach ($getContractDetails as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="text-success"><b>{{ $item->lot_number }}</b></td>
                                            <td class="text-success"><b>{{ $item->sublot_number }}</b></td>
                                            <td class="text-success"><b>{{ $item->reference_number ?? 'N/A' }}</b></td>
                                            <td class="text-dark"><b>{{ $item->contract_name }}</b></td>
                                            <td width="200">
                                                {{ $item->contract_description ? substr($item->contract_description, 0, 100) : ' - ' }}
                                                @if (strlen($item->contract_description) > 100)
                                                    ... <a href="javascript:;" class="text-info" data-toggle="modal"
                                                        data-target=".viewMoreDescription{{ $key }}">View
                                                        more</a>
                                                @endif
                                            </td>
                                            <td>{{ $item->category_name }}</td>
                                            <td class="text-right text-info">
                                                <b>&#8358;{{ number_format($item->proposed_budget, 2) }}</b>
                                            </td>
                                            <td class="{!! $item->status_name == 'Disabled' || $item->status_name == 'Rejected' ? 'text-danger' : 'text-success' !!}">
                                                {{ $item->status_name }}
                                            </td>
                                            <td>
                                                @if ($item->close_bidding_date)
                                                    {{ \Carbon\Carbon::parse($item->close_bidding_date)->format('d M Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Modal View More -->
                                        <div class="modal fade viewMoreDescription{{ $key }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewMoreLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="viewMoreLabel">View More</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <strong>{{ $item->contract_name }}</strong>
                                                        <hr />
                                                        <p>{{ $item->contract_description }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Delete -->
                                        <div class="modal fade deleteCategory{{ $key }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="deleteLabel">Confirm Delete</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-primary">
                                                            Delete:
                                                            {{ $item->contract_name . ' - ' . $item->category_name }}
                                                        </p>
                                                        <p class="text-danger">Are you sure you want to delete this record?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Cancel</button>
                                                        <a href="{{ route('deleteContractDetails', ['id' => base64_encode($item->contract_detailsID)]) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center text-danger">No contract found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if (isset($getContractDetails) && is_iterable($getContractDetails))
                        <div class="col-md-12 text-right">
                            <hr />
                            Showing {{ ($getContractDetails->currentpage() - 1) * $getContractDetails->perpage() + 1 }}
                            to {{ $getContractDetails->currentpage() * $getContractDetails->perpage() }}
                            of {{ $getContractDetails->total() }} entries
                        </div>
                        <div class="text-right">
                            {{ $getContractDetails->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection

@section('styles')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#tblSearchGet'); //
            $("#txtSearchJquery").keyup(function() {
                var str = $("#txtSearchJquery").val();
                //$('#tblSearchGet').append("<tbody><tr style='background: #ffffff;'><td></td></tr></tbody>");
                if (str.length == 0) {
                    table.find("tbody tr").remove();
                    //$('#tblSearchGet').append("<tr><td align='center' class='text-danger'><b>No match found...</b></td></tr>");
                } else {
                    $.get("{{ url('/search-contract-from-db-JSON/') }}" + '/' + str, function(data) {
                        var table = $('#tblSearchGet'); //
                        table.find("tbody tr").remove();
                        if (data) {
                            $.each(data, function(index, value) {
                                table.append(
                                    "<tbody><tr style='background: #ffffff;'><td class='p-3 h5 font-weight-bolder' align='left'><a href='{{ url('/') }}/collection/" +
                                    value.category.replace(' ', '+') +
                                    "' class='text-left'>" + value.product_name +
                                    "</a></td></tr></tbody>");
                            });
                        } else {
                            table.find("tbody tr").remove();
                        }
                    });
                }
            });

        });
        /* //END LIVE SEARCH */
    </script>
@endsection
