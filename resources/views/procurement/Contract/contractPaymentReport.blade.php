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
                    <h4 class="panel-title pull-left" style="padding-top:7px;"> Contract Payment Reports</h4>
                </div>

                <div class="panel-body">
                    {{-- <!-- Start Search --> --}}
                    <div class="well" style="background:#f9f9f9; border:1px solid #ddd; padding:15px;">

                        <form method="GET" action="{{ route('contract.payment.search') }}">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 mb-3 ">
                                    {{-- <input type="text" name="fileNo" class="form-control" placeholder="Enter File Number"> --}}
                                    <input type="text" id="fileNo" name="fileNo" class="form-control"
                                        placeholder="Enter File Number">


                                </div>
                                <div class="col-md-1"></div>

                                {{-- <div class="col-md-2 mb-3">
                                    <button type="submit" class="btn btn-primary">Search</button>

                                </div> --}}

                            </div>


                        </form>

                    </div>
                    {{-- <!-- End Search --> --}}

                    <hr />

                    <div class="table-responsive">



                        <table class="table table-bordered table-hover" style="background: #fff;">
                            <thead>
                                <tr style="background: #f1f1f1;">
                                    @if ($contract)
                                        <th colspan="3" class="text-left"
                                            style="font-size: 18px; padding: 15px; border: none;">
                                            Contract File No:
                                            <strong style="color:#333;">{{ $contract->fileNo }}</strong>
                                        </th>

                                        <th colspan="2" class="text-right"
                                            style="font-size: 18px; padding: 15px; border: none;">
                                            Contract Value:
                                            <strong
                                                style="color:#333;">&#8358;{{ number_format($contract->contractValue, 2) }}</strong>
                                        </th>
                                    @endif
                                </tr>

                                <tr style="background:#f9fafb; font-weight:bold;">
                                    <th width="60" class="text-center">S/N</th>
                                    <th class="text-center">Date Prepared</th>
                                    <th>Description</th>
                                    <th class="text-right">Amount Paid</th>
                                    <th class="text-right">Balance</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($contract)
                                    @foreach ($payments as $p)
                                        <tr style="vertical-align: middle;">
                                            <!-- Serial Number -->
                                            <td class="text-center" style="font-weight: 600;">
                                                {{ $loop->iteration }}
                                            </td>

                                            <!-- Date -->
                                            <td class="text-center text-success" style="font-weight: 600;">
                                                {{ formatDate($p->datePrepared) }}
                                            </td>

                                            <!-- Description -->
                                            <td style="max-width:350px; white-space:normal; line-height:1.4;">
                                                {{ $p->paymentDescription }}
                                            </td>

                                            <!-- Amount Paid -->
                                            <td class="text-right text-info" style="font-weight: 700;">
                                                <a href="{{ url('/display/voucher/' . $p->ID) }}" target="_blank"
                                                    style="text-decoration:none;">
                                                    &#8358;{{ number_format($p->totalPayment, 2) }}
                                                </a>
                                            </td>

                                            <!-- Balance -->
                                            <td class="text-right text-info" style="font-weight: 700;">
                                                &#8358;{{ number_format($contract->contractValue - $p->totalPayment, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center text-danger"
                                            style="padding:20px; font-size:16px;">
                                            No contract found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>



                    </div>


                </div>
            </div>
        </div>
    </div>



@endsection

@section('styles')
    <style>
        td a,
        td a:visited,
        td a:hover,
        td a:active {
            text-decoration: none !important;
            color: inherit;
            /* optional: keeps same text color */
        }
    </style>
    <style>
        td a {
            color: #0d6efd;
            /* Bootstrap primary color */
            font-weight: bold;
        }

        td a:hover {
            color: #084298;
            text-decoration: none;
        }
    </style>
@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            $("#fileNo").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('contract.payment.autocomplete') }}",
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },

                minLength: 1, // start suggesting after 1 character

                select: function(event, ui) {
                    // Set the selected value
                    $("#fileNo").val(ui.item.value);

                    // Auto-submit form
                    $(this).closest('form').submit();
                }
            });
        });
    </script>

    {{-- <script>
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
    </script> --}}
@endsection
