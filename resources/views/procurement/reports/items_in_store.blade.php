@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Items in Store Report') }}
@endsection
@section('pageMenu', 'active')
@section('content')




    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-primary">

                    <!-- Panel Heading -->
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left">
                            <i class="fa fa-boxes"></i> Items in Store Report
                        </h4>
                        <div class="pull-right">
                            <button class="btn btn-default btn-sm" data-toggle="collapse" data-target="#filters">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="collapse" id="filters">
                        <div class="panel-body" style="border-bottom: 1px solid #ddd;">
                            <form action="{{ route('reports.items_in_store') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label>Search</label>
                                            <input type="text" name="search" class="form-control"
                                                value="{{ request('search') }}" placeholder="Item or specification...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('reports.items_in_store') }}" class="btn btn-default btn-sm">
                                            <i class="fa fa-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Panel Body / Table -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="mainTable">
                                <thead style="background-color: #337ab7; color: #fff;">
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Specification</th>
                                        <th>Quantity</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $index => $item)
                                        <tr>
                                            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->specification ?? 'Standard' }}</td>
                                            <td class="{{ $item->remainingQuantity <= 0 ? 'text-danger' : '' }}">
                                                {{ $item->remainingQuantity ?? 0 }}
                                            </td>
                                            <td>{{ $item->last_updated }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No items found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted">
                                    Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of
                                    {{ $items->total() }} entries
                                </p>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $items->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Panel Footer -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{-- <button class="btn btn-success btn-sm" onclick="printReport()">
                                    <i class="fa fa-print"></i> Print Report
                                </button> --}}
                                <button class="btn btn-success btn-sm" onclick="printReport()">
                                    <i class="fa fa-print"></i> Print Report
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>








    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printableContent,
            #printableContent * {
                visibility: visible;
            }

            #printableContent {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 15px;
            }
        }
    </style>

    {{-- <script>
        function printReport() {
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write(`
            <html>
                <head>
                    <title>Items in Store Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                        th, td { border: 1px solid #000; padding: 5px; }
                        th { background-color: #f2f2f2; }
                        .text-danger { color: red; font-weight: bold; }
                        .report-title { text-align: center; margin-bottom: 20px; }
                        .report-date { text-align: center; font-size: 0.9em; margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    ${document.getElementById('printableContent').innerHTML}
                </body>
            </html>
        `);
            printWindow.document.close();

            // Wait for content to load before printing
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 1);
        }
    </script> --}}

    <script>
        function printReport() {
            var table = document.getElementById('mainTable');

            if (!table) {
                alert('Table not found!');
                return;
            }

            var content = table.outerHTML;

            var printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write(`
        <html>
            <head>
                <title>Items in Store Report</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    h2 { text-align: center; margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border: 1px solid #000; padding: 5px; }
                    th { background-color: #f2f2f2; }
                    .text-danger { color: red; font-weight: bold; }
                </style>
            </head>
            <body>
                <h2>Items in Store Report</h2>
                ${content}
            </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    </script>

@endsection
