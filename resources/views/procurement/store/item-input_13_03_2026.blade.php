@extends('layouts_procurement.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Add items supplied by the {{ $contract->company_name }}</h3>
                    </div>

                    <div class="panel-body">
                        <form id="itemForm" action="{{ route('store.saveItemQty', $contract->id) }}" method="POST">
                            @csrf

                            <div id="itemRowsContainer">
                                <div class="row item-row" style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                                    <div class="col-md-2">
                                        <label>Select Item</label>
                                        <select name="item_id[]" class="form-control item-select" required>
                                            <option value="">-- Select Item --</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->itemID }}">{{ $item->item }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-5">
                                        <label>Specifications</label>
                                        <div class="specification-tags-container" style="border: 1px solid #ddd; padding: 10px; border-radius: 4px; background-color: #f9f9f9;">
                                            <div class="tags-wrapper">
                                                <!-- Tags will be dynamically inserted here -->
                                                <span class="text-muted">Select an item to view specifications</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity[]" value="0" class="form-control quantity" min="0" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Unit Price</label>
                                        <input type="text" name="unit_price[]" class="form-control unit-price text-right" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Total Price</label>
                                        <input type="text" name="total_price[]" class="form-control total-price text-right" readonly>
                                    </div>

                                    <div class="col-md-1" style="padding-top: 25px;">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">−</button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Items</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .spec-tag {
        display: inline-block;
        padding: 5px 10px;
        margin: 3px;
        background-color: #17a2b8;
        color: white;
        border-radius: 20px;
        font-size: 13px;
        border: 1px solid #138496;
        cursor: default; /* Changed to default cursor since not clickable */
    }
    
    .spec-tag.info {
        background-color: #17a2b8;
    }
    
    .spec-tag.warning {
        background-color: #ffc107;
        color: #212529;
        border-color: #d39e00;
    }
    
    .spec-tag.success {
        background-color: #28a745;
        border-color: #1e7e34;
    }
    
    .tags-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('itemForm');

        function formatNumberWithCommas(value) {
            const number = parseFloat(value.replace(/,/g, ''));
            if (isNaN(number)) return '';
            return number.toLocaleString('en-US', {
                minimumFractionDigits: 2
            });
        }

        function updateTotalPrice(row) {
            const qty = parseFloat(row.querySelector('.quantity').value.replace(/,/g, '')) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price').value.replace(/,/g, '')) || 0;
            const total = qty * unitPrice;
            row.querySelector('.total-price').value = total ? formatNumberWithCommas(total.toString()) : '';
        }

        function renderSpecificationTags(row, specifications) {
            const tagsWrapper = row.querySelector('.tags-wrapper');
            
            if (!specifications || specifications.length === 0) {
                tagsWrapper.innerHTML = '<span class="text-muted">No specifications found for this item</span>';
                return;
            }

            let tagsHtml = '';
            
            // Add some variety to tag colors based on index
            specifications.forEach((spec, index) => {
                let colorClass = 'spec-tag';
                // Alternate colors for visual variety
                if (index % 3 === 0) colorClass += ' info';
                else if (index % 3 === 1) colorClass += ' success';
                else colorClass += ' warning';
                
                tagsHtml += `<span class="${colorClass}">${spec.specification}</span>`;
            });
            
            tagsWrapper.innerHTML = tagsHtml;
        }

        window.addRow = function() {
            const container = document.getElementById('itemRowsContainer');
            const firstRow = container.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);

            // Clear values in new row
            newRow.querySelectorAll('input, select').forEach(el => {
                if (el.type !== 'hidden') {
                    el.value = '';
                }
            });
            
            // Clear tags
            const tagsWrapper = newRow.querySelector('.tags-wrapper');
            tagsWrapper.innerHTML = '<span class="text-muted">Select an item to view specifications</span>';
            
            container.appendChild(newRow);
        }

        window.removeRow = function(button) {
            const container = document.getElementById('itemRowsContainer');
            const row = button.closest('.item-row');
            if (container.querySelectorAll('.item-row').length > 1) {
                container.removeChild(row);
            }
        }

        // Auto update total
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                const row = e.target.closest('.item-row');
                updateTotalPrice(row);
            }
        });

        // Format unit price on blur
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('unit-price')) {
                e.target.value = formatNumberWithCommas(e.target.value);
            }
        }, true);

        // Clean commas before submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            form.querySelectorAll('.unit-price, .total-price').forEach(input => {
                input.value = input.value.replace(/,/g, '');
            });

            form.submit();
        });

        // Load and display specifications as tags when item is selected
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select')) {
                const row = e.target.closest('.item-row');
                const itemId = e.target.value;
                const tagsWrapper = row.querySelector('.tags-wrapper');

                if (!itemId) {
                    tagsWrapper.innerHTML = '<span class="text-muted">Select an item to view specifications</span>';
                    return;
                }

                // Show loading state
                tagsWrapper.innerHTML = '<div class="loading-spinner"></div> Loading specifications...';

                fetch(`/get-specs/${itemId}`)
                    .then(res => res.json())
                    .then(data => {
                        renderSpecificationTags(row, data);
                    })
                    .catch(error => {
                        console.error('Failed to load specifications', error);
                        tagsWrapper.innerHTML = '<span class="text-danger">Failed to load specifications</span>';
                    });
            }
        });
    });
</script>
@endsection