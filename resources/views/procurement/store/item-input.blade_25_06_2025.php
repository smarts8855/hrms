@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h1>Add items supplied by the {{ $contract->company_name }}</h1>
                                </div>
                            </div>
                            <hr>
                            <form action="{{ route('store.saveItemQty', $contract->id) }}" method="POST">
                                @csrf

                                <div id="itemRowsContainer">
                                    <div class="row mb-3 item-row">
                                        <div class="col-3">
                                            <label>Select Item</label>
                                            <select name="item_id[]" class="form-control item-select" required>
                                                <option value="">-- Select Item --</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->itemID }}">{{ $item->item }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label>Select Specification</label>
                                            <select name="specification_id[]" class="form-control specification-select"
                                                required>
                                                <option value="">-- Select Specification --</option>
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label>Quantity</label>
                                            <input type="number" name="quantity[]" value="0"
                                                class="form-control quantity" min="0" required>
                                        </div>

                                        <div class="col-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-success mx-1"
                                                onclick="addRow()">+</button>
                                            <button type="button" class="btn btn-danger mx-1"
                                                onclick="removeRow(this)">−</button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Submit Items</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection



@section('scripts')
    <script>
        function addRow() {
            const container = document.getElementById('itemRowsContainer');
            const firstRow = container.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('select, input').forEach(el => el.value = '');

            container.appendChild(newRow);
        }

        function removeRow(button) {
            const row = button.closest('.item-row');
            const container = document.getElementById('itemRowsContainer');
            if (container.querySelectorAll('.item-row').length > 1) {
                container.removeChild(row);
            }
        }

        // Dynamic spec loading
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('item-select')) {
                const itemSelect = e.target;
                const selectedItemId = itemSelect.value;

                const row = itemSelect.closest('.item-row');
                const specSelect = row.querySelector('.specification-select');

                if (!selectedItemId) {
                    specSelect.innerHTML = '<option value="">-- Select Specification --</option>';
                    return;
                }

                fetch(`/get-specs/${selectedItemId}`)
                    .then(response => response.json())
                    .then(data => {
                        specSelect.innerHTML = '<option value="">-- Select Specification --</option>';
                        data.forEach(spec => {
                            const option = document.createElement('option');
                            option.value = spec.specificationID;
                            option.text = spec.specification;
                            specSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading specifications:', error);
                    });
            }
        });
    </script>
    <script>
        function addRow() {
            const container = document.getElementById('itemRowsContainer');
            const firstRow = container.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);

            // Clear values
            newRow.querySelectorAll('select, input').forEach(el => el.value = '');

            container.appendChild(newRow);
        }

        function removeRow(button) {
            const row = button.closest('.item-row');
            const container = document.getElementById('itemRowsContainer');
            if (container.querySelectorAll('.item-row').length > 1) {
                container.removeChild(row);
            }
        }
    </script>
@endsection
