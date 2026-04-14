@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('View Approved Item Request') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title text-uppercase">View Approved Item Request</h4>
                </div>

                <div class="panel-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div style="border: 1px solid #e5e5e5; background: #fff; padding: 12px 15px; margin-bottom: 15px;">
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
                                    <span style="margin: 0 10px; color: #ccc;">|</span>
                                    <span><strong>Code:</strong> {{ $requestData->cr_code ?: 'N/A' }}</span>

                                    {{-- @if (!empty($requestData->description))
                                        <br>
                                        <span><strong>Description:</strong> {{ $requestData->description }}</span>
                                    @endif --}}
                                </div>
                            </div>

                            <div class="col-md-3 text-right">
                                <span class="label label-success" style="font-size: 11px; padding: 6px 10px;">
                                    CR Approved
                                </span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('issue-approved-item-request') }}" id="issueApprovedRequestForm">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $requestData->id }}">
                        <input type="hidden" name="remark" id="issue-remark">

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
                                        <th>Approved <br> Quantity (CR)</th>
                                        <th>Delivered <br> Quantity (Dept)</th>
                                        {{-- <th>Balance</th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $totalRequestedQty = 0;
                                        $totalRecommendedQty = 0;
                                        $totalApprovedQty = 0;
                                        $totalDeliveredQty = 0;
                                        $totalBalanceQty = 0;
                                    @endphp

                                    @forelse ($items as $key => $item)
                                        @php
                                            $deliveredValue = old(
                                                'deliveredQty.' . $key,
                                                isset($item->deliveredQuantity) && $item->deliveredQuantity !== 0
                                                    ? $item->deliveredQuantity
                                                    : $item->approvedQty ?? 0,
                                            );

                                            $requestedQty = (int) $item->quantity;
                                            $recommendedQty = (int) ($item->recommendedQty ?? 0);
                                            $approvedQty = (int) ($item->approvedQty ?? 0);
                                            $balanceQty = $approvedQty - (int) $deliveredValue;

                                            $totalRequestedQty += $requestedQty;
                                            $totalRecommendedQty += $recommendedQty;
                                            $totalApprovedQty += $approvedQty;
                                            $totalDeliveredQty += (int) $deliveredValue;
                                            $totalBalanceQty += $balanceQty;
                                        @endphp

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="item-name-text">{{ $item->item_name ?: 'N/A' }}</span>

                                                @if (!empty($item->specifications))
                                                    <div class="item-specs-wrap" style="margin-top:4px;">
                                                        @foreach (explode(',', $item->specifications) as $spec)
                                                            <span class="label label-success item-spec-label"
                                                                style="display:inline-block; margin:2px 4px 2px 0;">
                                                                {{ strtoupper(trim($spec)) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">No specification</span>
                                                @endif
                                                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                            </td>
                                            <td>{{ $item->quantity_in_store }}</td>
                                            <td>{{ $item->recommended_quantity }}</td>
                                            <td>{{ $item->available_quantity }}</td>
                                            <td>{{ $requestedQty }}</td>
                                            <td>{{ $recommendedQty }}</td>
                                            <td class="approved-qty-cell">{{ $approvedQty }}</td>
                                            <td style="width: 180px;">
                                                @if ($requestData->status == 3)
                                                    <input type="number" name="deliveredQty[]"
                                                        class="form-control row-delivered-qty delivered-qty-input"
                                                        min="0" max="{{ $approvedQty }}"
                                                        value="{{ $deliveredValue }}" required>
                                                @else
                                                    <input type="number" class="form-control row-delivered-qty"
                                                        value="{{ $item->deliveredQuantity ?? 0 }}" readonly>
                                                @endif
                                            </td>
                                            {{-- <td class="balance-cell">{{ $balanceQty }}</td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                @if ($items->count() > 0)
                                    <tfoot style="display: none;">
                                        <tr style="background: #f9f9f9; font-weight: 600;">
                                            <td colspan="2" class="text-right">Grand Total</td>
                                            <td>{{ $totalRequestedQty }}</td>
                                            <td>{{ $totalRecommendedQty }}</td>
                                            <td id="total-approved-qty">{{ $totalApprovedQty }}</td>
                                            <td id="total-delivered-qty">
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $totalDeliveredQty }}">
                                            </td>
                                            <td id="total-balance-qty">{{ $totalBalanceQty }}</td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('approved-item-request-list') }}" class="btn btn-danger btn-xs">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            @if ($requestData->status == 3)
                                <button type="button" class="btn btn-primary btn-xs" id="issue-request-btn">
                                    <i class="fa fa-truck"></i> Submit Issuance
                                </button>
                            @endif
                        </div>
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
            function calculateDeliveredTotal() {
                var totalDelivered = 0;
                var totalBalance = 0;

                $('tbody tr').each(function() {
                    var deliveredInput = $(this).find('.row-delivered-qty');
                    var approvedText = $(this).find('.approved-qty-cell').text();

                    if (deliveredInput.length) {
                        var delivered = parseInt(deliveredInput.val(), 10) || 0;
                        var approved = parseInt(approvedText, 10) || 0;
                        var balance = approved - delivered;

                        if (balance < 0) {
                            balance = 0;
                        }

                        $(this).find('.balance-cell').text(balance);

                        totalDelivered += delivered;
                        totalBalance += balance;
                    }
                });

                $('#total-delivered-qty').find('input').val(totalDelivered);
                $('#total-balance-qty').text(totalBalance);
            }

            $(document).on('input keyup change', '.delivered-qty-input', function() {
                var max = parseInt($(this).attr('max'), 10);
                var value = parseInt($(this).val(), 10);

                if (!isNaN(max) && !isNaN(value) && value > max) {
                    $(this).val(max);
                }

                if (!isNaN(value) && value < 0) {
                    $(this).val(0);
                }

                calculateDeliveredTotal();
            });

            $('#issue-request-btn').on('click', function() {
                var previewRows = '';
                var totalDelivered = 0;
                var hasItemsToIssue = false;

                $('tbody tr').each(function(index) {
                    var itemName = $.trim($(this).find('.item-name-text').text());
                    var specsHtml = '';

                    $(this).find('.item-spec-label').each(function() {
                        specsHtml +=
                            '<span class="label label-success" style="display:inline-block; margin:2px 4px 2px 0;">' +
                            $.trim($(this).text()) + '</span> ';
                    });

                    var approvedQty = parseInt($.trim($(this).find('.approved-qty-cell').text()),
                        10) || 0;
                    var deliveredInput = $(this).find('.row-delivered-qty');

                    if (deliveredInput.length) {
                        var deliveredQty = parseInt(deliveredInput.val(), 10) || 0;
                        var balanceQty = approvedQty - deliveredQty;

                        if (balanceQty < 0) {
                            balanceQty = 0;
                        }

                        if (deliveredQty > 0) {
                            hasItemsToIssue = true;
                        }

                        totalDelivered += deliveredQty;

                        previewRows += `
                            <tr>
                                <td style="padding:6px; border:1px solid #ddd;">${index + 1}</td>
                                <td style="padding:6px; border:1px solid #ddd;">
                                    <div style="margin-bottom:4px;">${itemName || 'N/A'}</div>
                                    <div>${specsHtml}</div>
                                </td>
                                <td style="padding:6px; border:1px solid #ddd; text-align:center;">${approvedQty}</td>
                                <td style="padding:6px; border:1px solid #ddd; text-align:center;">${deliveredQty}</td>
                            </tr>
                        `;
                    }
                });

                if (!hasItemsToIssue) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No quantity entered',
                        text: 'Enter at least one delivered quantity before submitting.'
                    });
                    return;
                }

                var previewTable = `
                    <div style="text-align:left; max-height:350px; overflow-y:auto;">
                        <p style="margin-bottom:10px;">
                            Please confirm the items and quantities to issue.
                        </p>

                        <table style="width:100%; border-collapse:collapse; font-size:12px;">
                            <thead>
                                <tr style="background:#f5f5f5;">
                                    <th style="padding:6px; border:1px solid #ddd;">S/N</th>
                                    <th style="padding:6px; border:1px solid #ddd;">Item</th>
                                    <th style="padding:6px; border:1px solid #ddd;">Approved</th>
                                    <th style="padding:6px; border:1px solid #ddd;">To Issue</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${previewRows}
                            </tbody>
                        </table>

                        <div style="margin-top:10px;">
                            <label for="swal-issue-remark" style="display:block; margin-bottom:6px; font-weight:600;">
                                Remark
                            </label>
                            <textarea id="swal-issue-remark"
                                class="swal2-textarea"
                                placeholder="Enter remark here..."
                                style="display:block; width:100%; min-height:100px; margin:0;"></textarea>
                        </div>
                    </div>
                `;

                Swal.fire({
                    title: 'Submit issuance?',
                    html: previewTable,
                    width: 900,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it',
                    cancelButtonText: 'Cancel',
                    preConfirm: function() {
                        var remark = $.trim($('#swal-issue-remark').val());

                        // if (!remark) {
                        //     Swal.showValidationMessage('Remark is required');
                        //     return false;
                        // }

                        $('#issue-remark').val(remark);
                        return true;
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#issueApprovedRequestForm').submit();
                    }
                });
            });

            calculateDeliveredTotal();
        });
    </script>
@endsection
