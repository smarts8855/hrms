@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Contracts with Received Items</h3>
        @if ($contracts->isEmpty())
            <p>No items received under any contract.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>Specification</th>
                        <th>Total Items Received</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($contracts as $contract)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $contract->itemName }}</td>
                            <td>{{ $contract->specificationName }}</td>
                            <td>{{ $contract->totalItems ?? '' }}</td>
                            <td>
                                <a href="{{ route('contracts.received-items.view', $contract->biddingStoreid) }}"
                                    class="btn btn-primary btn-sm">
                                    View Items
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
