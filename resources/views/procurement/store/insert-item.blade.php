@extends('layouts_procurement.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">Add items </h3>
                    </div>

                    <div class="panel-body">

                        <form id="itemForm" action="{{ route('store.saveItem') }}" method="POST">
                            @csrf

                            <div id="itemRowsContainer">

                                <div class="row item-row" style="margin-bottom: 15px;">

                                    <div class="col-md-3">
                                        <label>Select Item</label>
                                        <select name="item_id[]" class="form-control item-select" required>
                                            <option value="">-- Select Item --</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->itemID }}">{{ $item->item }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Specification</label>
                                        <select name="specification_id[]" class="form-control specification-select"
                                            required>
                                            <option value="">-- Select Specification --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity[]" value="0" class="form-control quantity"
                                            min="0" required>
                                    </div>

                                    {{-- <div class="col-md-2">
                                        <label>Unit Price</label>
                                        <input type="text" name="unit_price[]"
                                            class="form-control unit-price text-right">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Total Price</label>
                                        <input type="text" name="total_price[]"
                                            class="form-control total-price text-right" readonly>
                                    </div> --}}

                                    <div class="col-md-3" style="padding-top: 24px;">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="removeRow(this)">−</button>
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

            window.addRow = function() {
                const container = document.getElementById('itemRowsContainer');
                const firstRow = container.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true);

                newRow.querySelectorAll('input, select').forEach(el => el.value = '');
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
                e.preventDefault(); // stop submission temporarily

                form.querySelectorAll('.unit-price, .total-price').forEach(input => {
                    input.value = input.value.replace(/,/g, '');
                });

                form.submit(); // submit after cleaning
            });

            // Load specifications dynamically
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('item-select')) {
                    const row = e.target.closest('.item-row');
                    const itemId = e.target.value;
                    const specSelect = row.querySelector('.specification-select');

                    if (!itemId) {
                        specSelect.innerHTML = '<option value="">-- Select Specification --</option>';
                        return;
                    }

                    fetch(`/get-specs/${itemId}`)
                        .then(res => res.json())
                        .then(data => {
                            specSelect.innerHTML =
                                '<option value="">-- Select Specification --</option>';
                            data.forEach(spec => {
                                const option = document.createElement('option');
                                option.value = spec.specificationID;
                                option.text = spec.specification;
                                specSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Failed to load specifications', error);
                        });
                }
            });
        });
    </script>
    @if (session('msg'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('msg') }}',
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
@endsection
