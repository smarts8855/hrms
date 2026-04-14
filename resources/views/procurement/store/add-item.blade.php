@extends('layouts_procurement.app')

@section('content')
    <div class="container" style="margin-right: 50px;">
        <div class="row" style="margin-right: 50px;">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Add Item to Store</h3>
                    </div>

                    <div class="panel-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul style="margin-bottom: 0;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('store.save-item-to-store') }}" method="POST" id="addItemForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="itemId">Item <span class="text-danger">*</span></label>
                                        <select name="itemId" id="itemId" class="form-control" required
                                            style="width: 100%;">
                                            <option value="">-- Select Item --</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->itemID }}"
                                                    {{ old('itemId') == $item->itemID ? 'selected' : '' }}>
                                                    {{ $item->item }}@if ($item->specifications->isNotEmpty())
                                                        - [{{ $item->specifications->implode(', ') }}]
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('itemId')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="available_quantity">Available Quantity</label>
                                        <input type="number" name="available_quantity" id="available_quantity"
                                            class="form-control" value="0" readonly>
                                        <small class="text-muted">Auto-calculated</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="item_in">Quantity to Add <span class="text-danger">*</span></label>
                                        <input type="number" name="item_in" id="item_in" class="form-control"
                                            value="{{ old('item_in') }}" min="1" required>
                                        @error('item_in')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="transaction_date">Transaction Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="transaction_date" id="transaction_date"
                                            class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}"
                                            max="{{ date('Y-m-d') }}" required>
                                        @error('transaction_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark <span class="text-danger">*</span></label>
                                        <textarea name="remark" id="remark" class="form-control" rows="3" maxlength="1000"
                                            placeholder="Enter any remarks or notes about this transaction..." required>{{ old('remark') }}</textarea>
                                        <small class="text-muted">Maximum 1000 characters</small>
                                        @error('remark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Add Item to Store
                                    </button>
                                    <a href="{{ route('store') }}" class="btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Back to Store
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container--bootstrap .select2-selection {
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 34px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 on item dropdown
            $('#itemId').select2({
                placeholder: '-- Select Item --',
                allowClear: true,
                theme: 'bootstrap',
                width: '100%'
            });
            // Set today's date as default if not already set
            const transactionDateInput = document.getElementById('transaction_date');
            if (!transactionDateInput.value) {
                transactionDateInput.value = new Date().toISOString().split('T')[0];
            }

            // Get elements
            const itemSelect = document.getElementById('itemId');
            const availableQuantityInput = document.getElementById('available_quantity');
            const quantityInput = document.getElementById('item_in');

            // Function to fetch available quantity
            function fetchAvailableQuantity(itemId) {
                if (!itemId) {
                    availableQuantityInput.value = '0';
                    return;
                }

                // Show loading state
                availableQuantityInput.value = 'Loading...';

                // Fetch available quantity via AJAX
                const baseUrl = '{{ route('store.get-available-quantity', ['itemId' => 'PLACEHOLDER']) }}';
                fetch(baseUrl.replace('PLACEHOLDER', itemId), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            availableQuantityInput.value = data.available_quantity || 0;
                        } else {
                            availableQuantityInput.value = '0';
                            console.error('Error fetching available quantity:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        availableQuantityInput.value = '0';
                    });
            }

            // Listen for item selection change (works with Select2)
            $('#itemId').on('change', function() {
                const selectedItemId = $(this).val();
                fetchAvailableQuantity(selectedItemId);

                // Reset quantity input when item changes
                quantityInput.value = '';
            });

            // Fetch available quantity if item is pre-selected (from old input)
            const preSelectedItemId = $('#itemId').val();
            if (preSelectedItemId) {
                fetchAvailableQuantity(preSelectedItemId);
            }

            // Form validation
            const form = document.getElementById('addItemForm');
            form.addEventListener('submit', function(e) {
                const itemId = document.getElementById('itemId').value;
                const itemIn = document.getElementById('item_in').value;
                const transactionDate = document.getElementById('transaction_date').value;
                const remark = document.getElementById('remark').value.trim();

                if (!itemId || !itemIn || !transactionDate || !remark) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }

                if (parseInt(itemIn) < 1) {
                    e.preventDefault();
                    alert('Quantity must be at least 1.');
                    return false;
                }

                // Check if transaction date is in the future
                // Normalize both dates to midnight (00:00:00) for accurate comparison
                const selectedDate = new Date(transactionDate);
                selectedDate.setHours(0, 0, 0, 0);

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (selectedDate > today) {
                    e.preventDefault();
                    alert('Transaction date cannot be in the future.');
                    return false;
                }
            });
        });
    </script>
@endsection
