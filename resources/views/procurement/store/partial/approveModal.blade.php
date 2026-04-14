

@php
    $approvedQty = $item->approvedQuantity ?? 0;
    $pendingQty = $item->totalQuantity - $approvedQty;
    $isPending = $approvedQty > 0 && $pendingQty > 0;
@endphp

{{-- <div class="modal fade" id="approveModal{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="approveModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form action="{{ route('items.approve') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $item->id }}">
            <input type="hidden" name="item_id" value="{{ $item->itemId }}">
            <input type="hidden" name="specification_id" value="{{ $item->specificationId }}">
            <input type="hidden" name="contractorID" value="{{ $contract->contractorID ?? '' }}">
            <input type="hidden" name="contractID" value="{{ $contract->contractID ?? '' }}">
            <input type="hidden" name="biddingStoreId" value="{{ $item->biddingStoreId }}">
            <input type="hidden" name="max_quantity"
                value="{{ $pendingQty > 0 ? $pendingQty : $item->totalQuantity }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isPending ? 'Approve Remaining Quantity' : 'Approve Quantity' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>
                            Approved Quantity
                            @if ($pendingQty > 0)
                                <small class="text-muted">(Pending: {{ $pendingQty }})</small>
                            @endif
                        </label>
                        <input type="number" name="approved_quantity" class="form-control" min="1"
                            max="{{ $pendingQty > 0 ? $pendingQty : $item->totalQuantity }}" required
                            value="{{ old('id') == $item->id ? old('approved_quantity') : '' }}">
                    </div>

                    <div class="form-group mt-3">
                        <label for="comment">Comment (optional)</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Enter comment here...">{{ old('id') == $item->id ? old('comment') : '' }}</textarea>
                    </div>

                    <!-- ✅ NEW FIELD: Select Transaction Date -->
                    <div class="form-group mt-3">
                        <label for="transaction_date">Transaction Date</label>
                        <input type="date" name="transaction_date" class="form-control"
                            value="{{ old('transaction_date') }}" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        {{ $isPending ? 'Approve Remaining' : 'Approve' }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

<div class="modal fade" id="approveModal{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="approveModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md" role="document">

        <form action="{{ route('items.approve') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $item->id }}">
            <input type="hidden" name="item_id" value="{{ $item->itemId }}">
            <input type="hidden" name="specification_id" value="{{ $item->specificationId }}">
            <input type="hidden" name="contractorID" value="{{ $contract->contractorID ?? '' }}">
            <input type="hidden" name="contractID" value="{{ $contract->contractID ?? '' }}">
            <input type="hidden" name="biddingStoreId" value="{{ $item->biddingStoreId }}">
            <input type="hidden" name="max_quantity"
                value="{{ $pendingQty > 0 ? $pendingQty : $item->totalQuantity }}">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>

                    <h4 class="modal-title">
                        {{ $isPending ? 'Received Remaining Quantity' : 'Received Quantity' }}
                    </h4>
                </div>

                <div class="modal-body">

                    {{-- PANEL (Bootstrap 3 Card Equivalent) --}}
                    <div class="panel panel-primary">

                        <div class="panel-heading">
                            <strong>Received Details</strong>
                        </div>

                        <div class="panel-body">

                            <div class="form-group">
                                <label>
                                     Quantity
                                    @if ($pendingQty > 0)
                                        <small class="text-muted">(Pending: {{ $pendingQty }})</small>
                                    @endif
                                </label>

                                <input type="number"
                                    name="approved_quantity"
                                    class="form-control"
                                    min="1"
                                    max="{{ $pendingQty > 0 ? $pendingQty : $item->totalQuantity }}"
                                    required
                                    value="{{ old('id') == $item->id ? old('approved_quantity') : '' }}">
                            </div>

                            <div class="form-group">
                                <label>Comment (optional)</label>
                                <textarea name="comment"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Enter comment here...">{{ old('id') == $item->id ? old('comment') : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Transaction Date</label>
                                <input type="date"
                                    name="transaction_date"
                                    class="form-control"
                                    value="{{ old('transaction_date') }}"
                                    required>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">
                        {{ $isPending ? 'Receive Remaining' : 'Receive' }}
                    </button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>

                </div>

            </div>
        </form>

    </div>
</div>
