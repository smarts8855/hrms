@extends('layouts_procurement.app')
@section('pageTitle', 'Create Item Specification')
@section('pageMenu', 'active')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="panel-title pull-left" style="text-transform: uppercase; margin-top: 8px;">
            Create Item Specification
        </h4>
    </div>

    <div class="panel-body">
        <form class="custom-validation" action="{{ route('saveItemSpecification') }}" method="POST">
            @csrf
            @include('ShareView.operationCallBackAlert')

            @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Item <span class="text-danger">*</span></label>
                        <select name="item" class="form-control" required>
                            <option value="">Select Item</option>
                            @if (isset($getBudgetItem) && $getBudgetItem)
                                @foreach ($getBudgetItem as $key => $value)
                                    <option value="{{ $value->itemID }}"
                                        {{ $value->itemID == old('item') ? 'selected' : '' }}>
                                        {{ $value->item }} 
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Specification <span class="text-danger">*</span></th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" name="specification[]" placeholder="Enter specification" class="form-control" required>
                            </td>
                            <td>
                                <button type="button" name="add" id="add" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Add More
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block">Submit Form</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Table View - Grouped by Item -->
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left"><b>ITEM SPECIFICATION LIST</b></h3>
        <div class="pull-right" style="font-size: 14px;">
            <i class="fa fa-list"></i> Total Specifications: {{ $getTotalSpecifications ?? count($getList ?? []) }}
        </div>
    </div>

    <div class="panel-body">
        <hr>

        <div class="table-responsive">
            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px;">S/N</th>
                        <th style="width: 200px;">ITEM</th>
                        <th>SPECIFICATIONS</th>
                        <th style="width: 200px;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sn = 1; @endphp
                    @forelse($getGroupedList ?? [] as $itemName => $itemData)
                        @php $specCount = count($itemData['specifications']); @endphp
                        
                        @foreach($itemData['specifications'] as $index => $spec)
                        <tr>
                            @if($index == 0)
                                <td rowspan="{{ $specCount }}" style="vertical-align: middle; background-color: #f9f9f9;" class="font-weight-bold">
                                    {{ $sn++ }}
                                </td>
                                <td rowspan="{{ $specCount }}" style="vertical-align: middle; background-color: #f9f9f9;">
                                    <strong>{{ strtoupper($itemName) }}</strong>
                                    <span class="badge badge-info" style="margin-left: 5px; background-color: #17a2b8; color: white; padding: 3px 7px; border-radius: 10px;">
                                        {{ $specCount }}
                                    </span>
                                </td>
                            @endif
                            
                            <td>
                                <i class="fa fa-circle" style="font-size: 8px; color: #999; vertical-align: middle; margin-right: 8px;"></i> 
                                {{ $spec->specification }}
                            </td>
                            
                            @if($index == 0)
                                <td rowspan="{{ $specCount }}" style="vertical-align: middle; background-color: #f9f9f9;">
                                    <div class="btn-group-vertical btn-group-sm" style="width: 100%;">
                                        <button type="button" class="btn btn-info btn-sm" 
                                            onclick="funcedit('{{ $spec->specificationID }}','{{ $spec->itemID }}','{{ $spec->specification }}')"
                                            style="margin-bottom: 3px;">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        
                                        {{-- <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="funcdelete('{{ base64_encode($spec->specificationID) }}')"
                                            style="margin-bottom: 3px;">
                                            <i class="fa fa-trash"></i> Delete
                                        </button> --}}
                                        
                                        {{-- @if($specCount > 1)
                                        <button type="button" class="btn btn-primary btn-sm" 
                                            onclick="showAllSpecifications('{{ $itemName }}', {{ json_encode($itemData['specifications']) }})">
                                            <i class="fa fa-list"></i> View All ({{ $specCount }})
                                        </button>
                                        @endif --}}
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted" style="padding: 30px;">
                                <i class="fa fa-info-circle"></i> No specifications found. Please add some specifications.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Edit Modal - Enhanced for Multiple Specifications -->
<div class="modal fade text-left d-print-none" id="editModalx" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">
                    <i class="fa fa-edit"></i> Edit Item Specifications
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('updateItemSpecification') }}" id="editForm">
                @csrf
                <div class="modal-body">
                    <!-- Store the item ID -->
                    <input type="hidden" name="item" id="editItemId">
                    
                    <div class="form-group">
                        <label>Item <span class="text-danger">*</span></label>
                        <select class="form-control" id="itemx" name="item_display" disabled>
                            <option value="">Select Item</option>
                            @foreach($getBudgetItem ?? [] as $list)
                                <option value="{{ $list->itemID }}">{{ $list->item }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Item cannot be changed during edit</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Specifications <span class="text-danger">*</span></label>
                        <div class="well well-sm" style="background-color: #f5f5f5; padding: 15px; border-radius: 4px;">
                            <table class="table table-bordered" id="editSpecTable">
                                <thead>
                                    <tr>
                                        <th>Specification</th>
                                        <th style="width: 100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="specificationsContainer">
                                    <!-- Specifications will be loaded here dynamically -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-success btn-sm" onclick="addSpecificationRow()">
                                                <i class="fa fa-plus"></i> Add Another Specification
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden template for new specification row -->
<template id="specificationRowTemplate">
    <tr>
        <td>
            <input type="text" name="specification[]" class="form-control" placeholder="Enter specification" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-spec" onclick="removeSpecificationRow(this)">
                <i class="fa fa-trash"></i> Remove
            </button>
        </td>
    </tr>
</template>

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
    .badge-info {
        background-color: #17a2b8;
        color: white;
        padding: 3px 7px;
        border-radius: 10px;
        font-size: 11px;
    }
    .btn-group-vertical > .btn {
        text-align: left;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .panel-info {
        border-color: #bce8f1;
    }
    .panel-info > .panel-heading {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
    }

    /* Additional styles for edit modal */
#editSpecTable input.form-control {
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 6px 12px;
}

#editSpecTable input.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

#editSpecTable .btn-danger {
    padding: 4px 8px;
}

.well-sm {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
}

#bulkActions {
    margin-top: 15px;
    padding: 10px;
    background-color: #d9edf7;
    border: 1px solid #bce8f1;
    border-radius: 4px;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    // Store current item ID
    let currentItemId = null;
    let currentItemName = '';
    
    // Edit function - Updated to load multiple specifications
    function funcedit(specificationId, itemId, specification) {
        // Store the item ID
        currentItemId = itemId;
        
        // Set the item ID in hidden field
        document.getElementById('editItemId').value = itemId;
        
        // Set the display select to show the correct item
        const itemSelect = document.getElementById('itemx');
        for(let i = 0; i < itemSelect.options.length; i++) {
            if(itemSelect.options[i].value == itemId) {
                itemSelect.options[i].selected = true;
                currentItemName = itemSelect.options[i].text;
                break;
            }
        }
        
        // Clear previous specifications
        $('#specificationsContainer').empty();
        
        // Load all specifications for this item
        loadItemSpecifications(itemId);
        
        // Show the modal
        $("#editModalx").modal('show');
    }
    
    // Load all specifications for an item
    function loadItemSpecifications(itemId) {
        // Clear container
        $('#specificationsContainer').empty();
        
        // Get specifications from the table data
        let foundSpecs = false;
        
        @foreach($getGroupedList ?? [] as $itemName => $itemData)
            if ("{{ $itemData['itemID'] }}" == itemId) {
                foundSpecs = true;
                @foreach($itemData['specifications'] as $spec)
                    addSpecificationRowWithValue('{{ $spec->specification }}');
                @endforeach
            }
        @endforeach
        
        // If no specifications found, add one empty row
        if (!foundSpecs) {
            addSpecificationRow();
        }
    }
    
    // Add a new empty specification row
    function addSpecificationRow() {
        const template = document.getElementById('specificationRowTemplate');
        const clone = template.content.cloneNode(true);
        document.getElementById('specificationsContainer').appendChild(clone);
    }
    
    // Add a specification row with a value
    function addSpecificationRowWithValue(value) {
        const template = document.getElementById('specificationRowTemplate');
        const clone = template.content.cloneNode(true);
        const input = clone.querySelector('input');
        input.value = value;
        document.getElementById('specificationsContainer').appendChild(clone);
    }
    
    // Remove a specification row
    function removeSpecificationRow(button) {
        Swal.fire({
            title: 'Remove this specification?',
            text: "This specification will be removed from the list",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(button).closest('tr').remove();
                
                // Show message if all specifications are removed
                if ($('#specificationsContainer tr').length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Specifications',
                        text: 'All specifications removed. Add at least one specification to save.',
                        timer: 2000
                    });
                }
            }
        });
    }
    
    // Remove all specifications
    function removeAllSpecifications() {
        Swal.fire({
            title: 'Remove all specifications?',
            text: "This will remove all specifications for " + currentItemName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove all'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#specificationsContainer').empty();
                // Add one empty row as default (optional)
                // addSpecificationRow();
            }
        });
    }
    
    // Form submission validation
    $('#editForm').on('submit', function(e) {
        const specRows = $('#specificationsContainer tr').length;
        
        if (specRows === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please add at least one specification'
            });
            return false;
        }
        
        // Check if any specification is empty
        let hasEmpty = false;
        let emptyCount = 0;
        
        $('#specificationsContainer input[name="specification[]"]').each(function() {
            if (!$(this).val().trim()) {
                hasEmpty = true;
                emptyCount++;
                $(this).css('border-color', '#dc3545');
            } else {
                $(this).css('border-color', '');
            }
        });
        
        if (hasEmpty) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: 'Please fill in all specification fields.<br>' + 
                      '<strong>' + emptyCount + ' empty field(s) found</strong>'
            });
            return false;
        }
        
        // Show loading state
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
    
    // Reset form when modal is closed
    $('#editModalx').on('hidden.bs.modal', function() {
        $('#specificationsContainer').empty();
        currentItemId = null;
        currentItemName = '';
    });
    
    // Initialize with one row if modal is opened with no data
    $('#editModalx').on('show.bs.modal', function() {
        if ($('#specificationsContainer tr').length === 0) {
            addSpecificationRow();
        }
    });
    
    // Optional: Add a "Remove All" button
    function addBulkActionsButton() {
        if ($('#specificationsContainer tr').length > 1 && !$('#bulkRemoveBtn').length) {
            const bulkBtn = $('<button>', {
                type: 'button',
                id: 'bulkRemoveBtn',
                class: 'btn btn-warning btn-sm ml-2',
                onclick: 'removeAllSpecifications()',
                html: '<i class="fa fa-trash"></i> Remove All'
            });
            $('.modal-footer').prepend(bulkBtn);
        } else if ($('#specificationsContainer tr').length <= 1) {
            $('#bulkRemoveBtn').remove();
        }
    }
    
    // Monitor row changes to update bulk button
    function observeSpecChanges() {
        const observer = new MutationObserver(function(mutations) {
            addBulkActionsButton();
        });
        
        const container = document.getElementById('specificationsContainer');
        if (container) {
            observer.observe(container, { childList: true, subtree: true });
        }
    }
    
    // Call this when document is ready
    $(document).ready(function() {
        observeSpecChanges();
    });
    
    // Rest of your existing functions (delete, showAllSpecifications, etc.)
    function funcdelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This specification will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete-specification/' + id;
            }
        });
    }

    function showAllSpecifications(itemName, specifications) {
        let specList = '';
        specifications.forEach((spec, index) => {
            specList += `${index + 1}. ${spec.specification}\n`;
        });
        
        Swal.fire({
            title: itemName + ' - All Specifications',
            html: '<pre style="text-align: left; background: #f5f5f5; padding: 10px; border-radius: 5px;">' + specList.replace(/\n/g, '<br>') + '</pre>',
            icon: 'info',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6',
            width: '600px'
        });
    }

    // Add more specifications in create form
    var i = 0;
    $('#add').click(function() {
        ++i;
        $('#table tbody').append(
            `<tr>
                <td>
                    <input type="text" name="specification[]" placeholder="Enter specification" class="form-control" required />
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-table-row">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </td>
            </tr>`
        );
    });

    $(document).on('click', '.remove-table-row', function() {
        $(this).parents('tr').remove();
    });

    // Success/Error messages with SweetAlert toast
    @if (session('msg') || session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('msg') ?? session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal-popup',
                title: 'swal-title'
            }
        });
    @endif

    @if (session('error'))
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
            }
        });
    @endif
</script>


@endsection