@extends('layouts_procurement.app')

@section('content')
    <div class="container" style="margin-right: 50px;">
        <div class="row" style="margin-right: 50px;">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Items Balance Report</h3>
                    </div>

                    <div class="panel-body">
                        <form method="GET" action="{{ route('reports.items_balance') }}">
                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="transaction_date">Transaction Date (Up To)</label>
                                        <input type="date" name="transaction_date" id="transaction_date"
                                            class="form-control" value="{{ $selectedDate ?? now()->toDateString() }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_id">Item Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">-- All Categories --</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ (string) ($categoryId ?? '') === (string) $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->storeItemCat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 24px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Generate Report
                                    </button>
                                    <a href="{{ route('reports.items_balance') }}" class="btn btn-default">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Item</th>
                                        <th>Category</th>
                                        <th>Total Received</th>
                                        <th>Total Issue</th>
                                        <th>Current Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rows as $row)
                                        <tr>
                                            <td>
                                                {{ $row->item }}@if (!empty($row->specifications))
                                                    - [{{ $row->specifications }}]
                                                @endif
                                            </td>
                                            <td>{{ $row->category ?? '—' }}</td>
                                            <td>{{ number_format((float) ($row->total_received ?? 0), 2) }}</td>
                                            <td>{{ number_format((float) ($row->total_issue ?? 0), 2) }}</td>
                                            <td>{{ number_format((float) ($row->balance ?? 0), 2) }}</td>
                                            <td>
                                                <a href="{{ route('bin.card', ['item_id' => $row->itemID]) }}"
                                                    class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No items found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
