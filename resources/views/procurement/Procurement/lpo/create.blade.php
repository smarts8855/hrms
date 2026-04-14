@extends('layouts_procurement.app')
@section('pageTitle', 'Create Local Purchase Order')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Create Local Purchase Order (LPO)</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('lpo.index') }}" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <form action="{{ route('lpo.store') }}" method="POST" id="lpoForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Supplier Information</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="supplier_name">Supplier Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="supplier_name" 
                                               name="supplier_name" 
                                               value="{{ old('supplier_name') }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="supplier_address">Supplier Address</label>
                                        <textarea class="form-control" 
                                                  id="supplier_address" 
                                                  name="supplier_address" 
                                                  rows="3">{{ old('supplier_address') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="contractor_id">Select Contractor (Optional)</label>
                                        <select class="form-control" id="contractor_id" name="contractor_id">
                                            <option value="">-- Select Contractor --</option>
                                            @foreach($contractors as $contractor)
                                                <option value="{{ $contractor->contractor_registrationID }}">
                                                    {{ $contractor->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Order Details</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="order_date">Order Date <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="order_date" 
                                               name="order_date" 
                                               value="{{ old('order_date', date('Y-m-d')) }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="delivery_date">Expected Delivery Date</label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="delivery_date" 
                                               name="delivery_date" 
                                               value="{{ old('delivery_date') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="contract_bidding_id">Link to Contract (Optional)</label>
                                        <select class="form-control" id="contract_bidding_id" name="contract_bidding_id">
                                            <option value="">-- Select Contract --</option>
                                            @foreach($contracts as $contract)
                                                <option value="{{ $contract->contract_biddingID }}">
                                                    {{ $contract->contract_name }} - {{ $contract->lot_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Items to Purchase</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Description</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Unit Price (₦)</th>
                                            <th>Total (₦)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <tr id="row1">
                                            <td>1</td>
                                            <td>
                                                <input type="text" 
                                                       name="items[0][description]" 
                                                       class="form-control" 
                                                       placeholder="Item description" 
                                                       required>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="items[0][quantity]" 
                                                       class="form-control quantity" 
                                                       min="1" 
                                                       value="1" 
                                                       required>
                                            </td>
                                            <td>
                                                <select name="items[0][unit]" class="form-control">
                                                    <option value="pcs">Pieces (pcs)</option>
                                                    <option value="dozen">Dozen</option>
                                                    <option value="kg">Kilogram (kg)</option>
                                                    <option value="liter">Liter</option>
                                                    <option value="meter">Meter</option>
                                                    <option value="box">Box</option>
                                                    <option value="set">Set</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="items[0][unit_price]" 
                                                       class="form-control unit-price" 
                                                       min="0" 
                                                       step="0.01" 
                                                       value="0" 
                                                       required>
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       class="form-control item-total" 
                                                       value="0.00" 
                                                       readonly>
                                            </td>
                                            <td>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm remove-row" 
                                                        style="display: none;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">Grand Total:</th>
                                            <th>
                                                <input type="text" 
                                                       id="grandTotal" 
                                                       class="form-control" 
                                                       value="0.00" 
                                                       readonly 
                                                       style="font-weight: bold; color: #28a745;">
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <button type="button" class="btn btn-success btn-sm" id="addRow">
                                <i class="fa fa-plus"></i> Add Item
                            </button>
                        </div>
                    </div>

                    <!-- Allocation Section (for HOD) -->
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">Allocation Information (For HOD Use)</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="allocation_head">Allocation Head</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="allocation_head" 
                                               name="allocation_head" 
                                               value="{{ old('allocation_head') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sub_head">Sub-head</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="sub_head" 
                                               name="sub_head" 
                                               value="{{ old('sub_head') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-save"></i> Create LPO
                        </button>
                        <button type="reset" class="btn btn-default btn-lg">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .table > thead > tr > th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    .remove-row {
        cursor: pointer;
    }
    #grandTotal {
        border: none;
        background: transparent;
        font-size: 16px;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let rowCount = 1;

        // Add new row
        $('#addRow').click(function() {
            const newRow = `
                <tr id="row${rowCount + 1}">
                    <td>${rowCount + 1}</td>
                    <td>
                        <input type="text" 
                               name="items[${rowCount}][description]" 
                               class="form-control" 
                               placeholder="Item description" 
                               required>
                    </td>
                    <td>
                        <input type="number" 
                               name="items[${rowCount}][quantity]" 
                               class="form-control quantity" 
                               min="1" 
                               value="1" 
                               required>
                    </td>
                    <td>
                        <select name="items[${rowCount}][unit]" class="form-control">
                            <option value="pcs">Pieces (pcs)</option>
                            <option value="dozen">Dozen</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="liter">Liter</option>
                            <option value="meter">Meter</option>
                            <option value="box">Box</option>
                            <option value="set">Set</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" 
                               name="items[${rowCount}][unit_price]" 
                               class="form-control unit-price" 
                               min="0" 
                               step="0.01" 
                               value="0" 
                               required>
                    </td>
                    <td>
                        <input type="text" 
                               class="form-control item-total" 
                               value="0.00" 
                               readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            $('#itemsBody').append(newRow);
            
            // Show remove button on first row if multiple rows exist
            if ($('#itemsBody tr').length > 1) {
                $('#row1 .remove-row').show();
            }
            
            rowCount++;
        });

        // Remove row
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            
            // Hide remove button on first row if only one row remains
            if ($('#itemsBody tr').length === 1) {
                $('#row1 .remove-row').hide();
            }
            
            // Renumber rows
            $('#itemsBody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
                $(this).attr('id', 'row' + (index + 1));
            });
            
            calculateGrandTotal();
        });

        // Calculate item total and grand total
        $(document).on('input', '.quantity, .unit-price', function() {
            const row = $(this).closest('tr');
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
            const itemTotal = quantity * unitPrice;
            
            row.find('.item-total').val(itemTotal.toFixed(2));
            
            calculateGrandTotal();
        });

        // Calculate grand total
        function calculateGrandTotal() {
            let grandTotal = 0;
            $('.item-total').each(function() {
                grandTotal += parseFloat($(this).val()) || 0;
            });
            $('#grandTotal').val(grandTotal.toFixed(2));
        }

        // Auto-populate supplier from contractor selection
        $('#contractor_id').change(function() {
            const contractorId = $(this).val();
            if (contractorId) {
                // Make AJAX call to get contractor details
                $.ajax({
                    url: '/procurement/contractor/' + contractorId,
                    type: 'GET',
                    success: function(data) {
                        $('#supplier_name').val(data.company_name);
                        $('#supplier_address').val(data.address);
                    }
                });
            }
        });
    });
</script>
@endsection