@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('SUBMITTED ITEM REQUESTS') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">View Item Request</h4>
                </div>

                <div class="panel-body">

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div style="border: 2px solid #e5e5e5; background: #fff; padding: 12px 15px; margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-9">
                                <div style="font-size: 16px; font-weight: 600; color: #2f4050; margin-bottom: 6px;">
                                    <i class="fa fa-file-text-o text-primary" style="margin-right: 6px;"></i>
                                    {{ $requestData->title }}
                                </div>

                                <div style="font-size: 12px; color: #777; line-height: 1.6;">
                                    <span><strong>Department:</strong> {{ $requestData->department ?: 'N/A' }}</span>
                                    <span style="margin: 0 10px; color: #ccc;">|</span>
                                    <span><strong>Requested By:</strong> {{ $requestData->created_by_name ?: 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-3 text-right">
                                @if ($requestData->status == 0)
                                    <span class="label label-warning"
                                        style="font-size: 11px; padding: 6px 10px;">Pending</span>
                                @elseif ($requestData->status == 1)
                                    <span class="label label-success"
                                        style="font-size: 11px; padding: 6px 10px;">Approved</span>
                                @elseif ($requestData->status == 2)
                                    <span class="label label-success"
                                        style="font-size: 11px; padding: 6px 10px;">Recommend</span>
                                @elseif ($requestData->status == 3)
                                    <span class="label label-success" style="font-size: 11px; padding: 6px 10px;">CR
                                        Approved</span>
                                @else
                                    <span class="label label-danger"
                                        style="font-size: 11px; padding: 6px 10px;">Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('submitted-item-request-recommend') }}" id="recommendRequestForm">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $requestData->id }}">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Item</th>
                                        <th>Store <br> Quantity</th>
                                        <th>Pending <br> Requests</th>
                                        <th>Available <br> Quantity</th>
                                        <th>Requested <br> Quantity (Dept)</th>
                                        <th>Recommended <br> Quantity (Store)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $totalRequestedQty = 0;
                                        $totalRecommededQty = 0;
                                    @endphp

                                    @forelse ($items as $key => $item)
                                        @php
                                            $recommendValue = old(
                                                'recommendQty.' . $key,
                                                isset($item->recommendedQty) && $item->recommendedQty !== 0
                                                    ? $item->recommendedQty
                                                    : $item->quantity,
                                            );

                                            $totalRequestedQty += (int) $item->quantity;
                                            $totalRecommededQty += (int) $recommendValue;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $item->item_name ?: 'N/A' }}

                                                @if (!empty($item->specifications))
                                                    <br>
                                                    @foreach (explode(',', $item->specifications) as $spec)
                                                        <span class="label label-success"
                                                            style="display:inline-block; margin:2px 4px 2px 0;">
                                                            {{ strtoupper(trim($spec)) }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No specification</span>
                                                @endif
                                                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                            </td>
                                            <td>{{ $item->quantity_in_store }}</td>
                                            <td>{{ $item->recommended_quantity }}</td>
                                            <td>{{ $item->available_quantity }}</td>
                                            <td class="requested-qty-cell">{{ $item->quantity }}</td>
                                            <td style="width: 180px;">
                                                @if ($requestData->status == 1)
                                                    <input type="number" name="recommendQty[]"
                                                        class="form-control row-recommend-qty recommend-qty-input"
                                                        min="0" max="{{ $item->quantity }}"
                                                        value="{{ $recommendValue }}" required>
                                                @else
                                                    <input type="number" class="form-control row-recommend-qty"
                                                        value="{{ $item->recommendedQty ?? 0 }}" readonly>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                @if ($items->count() > 0)
                                    <tfoot style="display: none;">
                                        <tr style="background: #f9f9f9; font-weight: 600;">
                                            <td colspan="2" class="text-right">Total</td>
                                            <td id="total-requested-qty">{{ $totalRequestedQty }}</td>
                                            <td id="total-recommended-qty">
                                                <input type="text" class="form-control" disabled readonly
                                                    value="{{ $totalRecommededQty }}">
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('submitted-item-request-list') }}" class="btn btn-danger btn-xs">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            @if ($requestData->status == 1)
                                <button type="button" class="btn btn-success btn-xs" id="recommend-request-btn">
                                    <i class="fa fa-check"></i> Recommend For CR Approval
                                </button>
                            @elseif ($requestData->status == 2)
                                <button type="button" class="btn btn-primary btn-xs" id="reopen-request-btn">
                                    <i class="fa fa-pencil"></i> Edit / Reopen
                                </button>
                            @endif
                        </div>
                    </form>

                    <form method="POST" action="{{ route('submitted-item-request-reopen') }}" id="reopenRequestForm"
                        style="display:none;">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $requestData->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif


    <script>
        $(document).ready(function() {
            function calculateApprovedTotal() {
                var total = 0;

                $('.row-recommend-qty').each(function() {
                    var value = parseInt($(this).val(), 10);
                    if (!isNaN(value)) {
                        total += value;
                    }
                });

                $('#total-recommended-qty').find('input').val(total);
            }

            $(document).on('input keyup change', '.recommend-qty-input', function() {
                var max = parseInt($(this).attr('max'), 10);
                var value = parseInt($(this).val(), 10);

                if (!isNaN(max) && !isNaN(value) && value > max) {
                    $(this).val(max);
                }

                if (!isNaN(value) && value < 0) {
                    $(this).val(0);
                }

                calculateApprovedTotal();
            });

            calculateApprovedTotal();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#recommend-request-btn').on('click', function() {
                Swal.fire({
                    title: 'Approve request?',
                    text: 'Are you sure you want to recommend this request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, recommend it',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#recommendRequestForm').submit();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#reopen-request-btn').on('click', function() {
                Swal.fire({
                    title: 'Reopen request?',
                    text: 'This will allow you to edit the recommended quantities again.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, reopen it',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#reopenRequestForm').submit();
                    }
                });
            });
        });
    </script>
@endsection
