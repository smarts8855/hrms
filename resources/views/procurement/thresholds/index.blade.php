@extends('layouts_procurement.app')

@section('pageTitle')
    {{ strtoupper('Threshold Management') }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="box-shadow:0 2px 8px rgba(0,0,0,0.1); border-radius:6px;">
            <div class="panel-heading clearfix" style="background-color:#f5f5f5; border-bottom:1px solid #ddd;">
                <h3 class="panel-title pull-left" style="padding-top:7px;">Threshold List</h3>
                <div class="pull-right">
                    <button type="button" class="btn btn-success btn-xs" id="btnAddThreshold">
                        <i class="fa fa-plus"></i> Add New Threshold
                    </button>
                    <span class="badge bg-info" style="margin-left:10px;">Total: {{ $thresholds->count() }} records</span>
                </div>
            </div>

            <div class="panel-body">
                <div align="right" style="margin-bottom:10px;">
                    <span class="text-muted">Click <i class="fa fa-edit"></i> to edit threshold values</span>
                </div>

                <hr />

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="thresholds-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contract Category</th>
                                <th>Role</th>
                                <th>Minimum (₦)</th>
                                <th>Maximum (₦)</th>
                                <th>Updated Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($thresholds as $threshold)
                            <tr id="threshold-row-{{ $threshold->id }}">
                                <td>{{ $threshold->id }}</td>
                                <td>
                                    <span class="label label-info">{{ $threshold->category_name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="label label-primary">{{ $threshold->role }}</span>
                                </td>
                                <td class="min-value">₦ {{ number_format($threshold->min, 0) }}</td>
                                <td class="max-value">₦ {{ number_format($threshold->max, 0) }}</td>
                                <td class="updated-at">{{ \Carbon\Carbon::parse($threshold->updated_at)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-xs btn-warning edit-threshold" 
                                            data-id="{{ $threshold->id }}"
                                            data-categoryid="{{ $threshold->contractCategoryID }}"
                                            data-role="{{ $threshold->role }}"
                                            data-min="{{ $threshold->min }}"
                                            data-max="{{ $threshold->max }}"
                                            title="Edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-xs btn-danger delete-threshold" 
                                            data-id="{{ $threshold->id }}"
                                            data-role="{{ $threshold->role }}"
                                            title="Delete">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-danger">No thresholds found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Threshold Modal -->
<div class="modal fade" id="thresholdModal" tabindex="-1" role="dialog" aria-labelledby="thresholdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="thresholdModalLabel">Add New Threshold</h4>
            </div>
            <form id="thresholdForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="method_field" value="POST">
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none;" id="formErrors"></div>
                    
                    <div class="form-group">
                        <label>Contract Category <span class="text-danger">*</span></label>
                        <select name="contractCategoryID" id="contractCategoryID" class="form-control" required>
                            <option value="">-- Select Contract Category --</option>
                            @foreach($contractCategories as $category)
                                <option value="{{ $category->contractCategoryID }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            <option value="CR">CR</option>
                            <option value="DTB">DTB</option>
                            <option value="FJTB">FJTB</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Minimum Value (₦) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">₦</span>
                            <input type="text" name="min_display" id="min_display" class="form-control" placeholder="0,000,000" required>
                            <input type="hidden" name="min" id="min">
                        </div>
                        <small class="text-muted">Format: 1,000,000 (commas added automatically)</small>
                    </div>

                    <div class="form-group">
                        <label>Maximum Value (₦) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">₦</span>
                            <input type="text" name="max_display" id="max_display" class="form-control" placeholder="0,000,000" required>
                            <input type="hidden" name="max" id="max">
                        </div>
                        <small class="text-muted">Format: 1,000,000 (commas added automatically)</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <small>Maximum value must be greater than minimum value</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fa fa-save"></i> Save Threshold
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Function to format number with commas
    function formatNumberWithCommas(number) {
        return new Intl.NumberFormat('en-NG', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // Function to remove commas and get raw number
    function removeCommas(value) {
        return value.replace(/,/g, '');
    }

    // Function to format input while typing
    function formatNumberInput(input) {
        let value = $(input).val();
        
        // Remove all non-digits
        let numericValue = value.replace(/[^\d]/g, '');
        
        // Store raw value in data attribute
        $(input).data('raw-value', numericValue);
        
        // Update hidden field if this is a display field
        let inputId = $(input).attr('id');
        if (inputId === 'min_display') {
            $('#min').val(numericValue);
        } else if (inputId === 'max_display') {
            $('#max').val(numericValue);
        }
        
        // Format with commas if there's a value
        if (numericValue) {
            let formattedValue = formatNumberWithCommas(parseInt(numericValue));
            $(input).val(formattedValue);
        } else {
            $(input).val('');
        }
    }

    // Add New Threshold button click
    $('#btnAddThreshold').on('click', function() {
        // Reset form
        $('#thresholdForm')[0].reset();
        $('#method_field').val('POST');
        $('#thresholdModalLabel').text('Add New Threshold');
        $('#btnSubmit').html('<i class="fa fa-save"></i> Save Threshold');
        
        // Clear hidden fields
        $('#min').val('');
        $('#max').val('');
        
        // Set form action for store - using the POST route
        var baseUrl = '{{ url("/threshold") }}';
        $('#thresholdForm').attr('action', baseUrl);
        
        // Hide previous errors
        $('#formErrors').hide().empty();
        
        // Show modal
        $('#thresholdModal').modal('show');
    });

    // Edit button click
    $('.edit-threshold').on('click', function() {
        var id = $(this).data('id');
        var categoryId = $(this).data('categoryid');
        var role = $(this).data('role');
        var min = $(this).data('min');
        var max = $(this).data('max');
        
        // Format numbers with commas for display
        var formattedMin = formatNumberWithCommas(min);
        var formattedMax = formatNumberWithCommas(max);
        
        // Set form values
        $('#contractCategoryID').val(categoryId);
        $('#role').val(role);
        $('#min_display').val(formattedMin);
        $('#max_display').val(formattedMax);
        $('#min').val(min);
        $('#max').val(max);
        
        // Set form method and action for update - using the PUT route
        $('#method_field').val('PUT');
        $('#thresholdModalLabel').text('Edit Threshold');
        $('#btnSubmit').html('<i class="fa fa-save"></i> Update Threshold');
        
        var baseUrl = '{{ url("/threshold") }}';
        $('#thresholdForm').attr('action', baseUrl + '/' + id);
        
        // Hide previous errors
        $('#formErrors').hide().empty();
        
        // Show modal
        $('#thresholdModal').modal('show');
    });

    // Delete button click
    $('.delete-threshold').on('click', function() {
        var id = $(this).data('id');
        var role = $(this).data('role');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete threshold for role: " + role,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url("/threshold") }}/' + id,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove row from table with fade effect
                            $('#threshold-row-' + id).fadeOut(500, function() {
                                $(this).remove();
                                
                                // Check if table is empty
                                if ($('#thresholds-table tbody tr').length === 0) {
                                    $('#thresholds-table tbody').html('<tr><td colspan="7" class="text-center text-danger">No thresholds found.</td></tr>');
                                }
                                
                                // Update total count badge
                                var totalCount = $('#thresholds-table tbody tr').length;
                                $('.badge.bg-info').text('Total: ' + totalCount + ' records');
                            });
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('Delete Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'An error occurred while deleting',
                        });
                    }
                });
            }
        });
    });
    
    // Format while typing in display fields
    $('#min_display, #max_display').on('input', function() {
        formatNumberInput(this);
    });

    // Handle paste event to ensure proper formatting
    $('#min_display, #max_display').on('paste', function(e) {
        e.preventDefault();
        let pasteData = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
        let numericValue = pasteData.replace(/[^\d]/g, '');
        
        if (numericValue) {
            $(this).val(formatNumberWithCommas(parseInt(numericValue)));
            
            // Update hidden field
            let inputId = $(this).attr('id');
            if (inputId === 'min_display') {
                $('#min').val(numericValue);
            } else if (inputId === 'max_display') {
                $('#max').val(numericValue);
            }
        }
    });

    // Handle blur event to ensure proper formatting
    $('#min_display, #max_display').on('blur', function() {
        let value = $(this).val();
        if (value) {
            let numericValue = removeCommas(value);
            if (numericValue) {
                $(this).val(formatNumberWithCommas(parseInt(numericValue)));
            }
        }
    });
    
    // Before form submission
    $('#thresholdForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var method = $('#method_field').val();
        
        console.log('Submitting to URL:', url);
        console.log('Method:', method);
        
        // Validate form
        if (!$('#contractCategoryID').val()) {
            $('#formErrors').html('<ul><li>Please select a contract category</li></ul>').show();
            return false;
        }
        
        if (!$('#role').val().trim()) {
            $('#formErrors').html('<ul><li>Please enter a role</li></ul>').show();
            return false;
        }
        
        // Get display values and ensure hidden fields are updated
        var minDisplay = $('#min_display').val();
        var maxDisplay = $('#max_display').val();
        
        if (!minDisplay || !maxDisplay) {
            $('#formErrors').html('<ul><li>Please enter both minimum and maximum values</li></ul>').show();
            return false;
        }
        
        // Remove commas to get raw numbers
        var minRaw = removeCommas(minDisplay);
        var maxRaw = removeCommas(maxDisplay);
        
        // Validate numbers
        if (isNaN(minRaw) || isNaN(maxRaw) || minRaw === '' || maxRaw === '') {
            $('#formErrors').html('<ul><li>Please enter valid numbers</li></ul>').show();
            return false;
        }
        
        minRaw = parseInt(minRaw);
        maxRaw = parseInt(maxRaw);
        
        if (minRaw >= maxRaw) {
            $('#formErrors').html('<ul><li>Maximum value must be greater than minimum value</li></ul>').show();
            return false;
        }
        
        // Update hidden fields with raw values
        $('#min').val(minRaw);
        $('#max').val(maxRaw);
        
        // Create form data with raw values
        var formData = new FormData(this);
        
        // Ensure we're sending the raw numeric values
        formData.set('min', minRaw);
        formData.set('max', maxRaw);
        formData.set('contractCategoryID', $('#contractCategoryID').val());
        formData.set('role', $('#role').val().trim());
        
        // Disable submit button
        $('#btnSubmit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    if (method === 'POST') {
                        // Add new row to table
                        var newRow = '<tr id="threshold-row-' + response.data.id + '">' +
                            '<td>' + response.data.id + '</td>' +
                            '<td><span class="label label-info">' + (response.data.category_name || 'N/A') + '</span></td>' +
                            '<td><span class="label label-primary">' + response.data.role + '</span></td>' +
                            '<td class="min-value">₦ ' + formatNumberWithCommas(response.data.min) + '</td>' +
                            '<td class="max-value">₦ ' + formatNumberWithCommas(response.data.max) + '</td>' +
                            '<td class="updated-at">' + new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + '</td>' +
                            '<td class="text-center">' +
                                '<button type="button" class="btn btn-xs btn-warning edit-threshold" data-id="' + response.data.id + '" data-categoryid="' + response.data.contractCategoryID + '" data-role="' + response.data.role + '" data-min="' + response.data.min + '" data-max="' + response.data.max + '" title="Edit"><i class="fa fa-edit"></i> Edit</button> ' +
                                '<button type="button" class="btn btn-xs btn-danger delete-threshold" data-id="' + response.data.id + '" data-role="' + response.data.role + '" title="Delete"><i class="fa fa-trash"></i> Delete</button>' +
                            '</td>' +
                        '</tr>';
                        
                        // Remove empty row message if exists
                        if ($('#thresholds-table tbody tr').length === 1 && $('#thresholds-table tbody tr td').attr('colspan') === '7') {
                            $('#thresholds-table tbody').html(newRow);
                        } else {
                            $('#thresholds-table tbody').append(newRow);
                        }
                        
                        // Update total count badge
                        var totalCount = $('#thresholds-table tbody tr').length;
                        $('.badge.bg-info').text('Total: ' + totalCount + ' records');
                    } else {
                        // Update the table row with new values
                        var row = $('#threshold-row-' + response.data.id);
                        
                        // Update category
                        row.find('td:eq(1)').html('<span class="label label-info">' + (response.data.category_name || 'N/A') + '</span>');
                        
                        // Update role
                        row.find('td:eq(2)').html('<span class="label label-primary">' + response.data.role + '</span>');
                        
                        // Update min and max values
                        row.find('.min-value').text('₦ ' + formatNumberWithCommas(response.data.min));
                        row.find('.max-value').text('₦ ' + formatNumberWithCommas(response.data.max));
                        
                        // Format date
                        if (response.data.updated_at) {
                            var updatedDate = new Date(response.data.updated_at);
                            var formattedDate = updatedDate.toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            }).replace(/ /g, ' ');
                            row.find('.updated-at').text(formattedDate);
                        }
                        
                        // Update data attributes for edit button
                        row.find('.edit-threshold')
                            .data('categoryid', response.data.contractCategoryID)
                            .data('role', response.data.role)
                            .data('min', response.data.min)
                            .data('max', response.data.max);
                    }
                    
                    // Close modal
                    $('#thresholdModal').modal('hide');
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Reattach event handlers to new buttons
                    attachEventHandlers();
                }
            },
            error: function(xhr) {
                console.log('Error response:', xhr);
                console.log('Response Text:', xhr.responseText);
                
                if (xhr.status === 422) {
                    // Validation errors
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<ul style="margin-bottom:0;">';
                    
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + (Array.isArray(value) ? value[0] : value) + '</li>';
                    });
                    
                    errorHtml += '</ul>';
                    
                    $('#formErrors').html(errorHtml).show();
                } else {
                    // Other errors
                    var errorMessage = 'An error occurred';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Route not found. Please check the URL.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error. Please check the logs.';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        footer: 'Check console for details'
                    });
                    
                    $('#formErrors').html('<ul><li>' + errorMessage + '</li></ul>').show();
                }
            },
            complete: function() {
                // Re-enable submit button
                $('#btnSubmit').prop('disabled', false).html('<i class="fa fa-save"></i> ' + (method === 'POST' ? 'Save Threshold' : 'Update Threshold'));
            }
        });
    });

    // Function to attach event handlers to dynamically added buttons
    function attachEventHandlers() {
        // Edit button handler
        $('.edit-threshold').off('click').on('click', function() {
            var id = $(this).data('id');
            var categoryId = $(this).data('categoryid');
            var role = $(this).data('role');
            var min = $(this).data('min');
            var max = $(this).data('max');
            
            // Format numbers with commas for display
            var formattedMin = formatNumberWithCommas(min);
            var formattedMax = formatNumberWithCommas(max);
            
            // Set form values
            $('#contractCategoryID').val(categoryId);
            $('#role').val(role);
            $('#min_display').val(formattedMin);
            $('#max_display').val(formattedMax);
            $('#min').val(min);
            $('#max').val(max);
            
            // Set form method and action for update
            $('#method_field').val('PUT');
            $('#thresholdModalLabel').text('Edit Threshold');
            $('#btnSubmit').html('<i class="fa fa-save"></i> Update Threshold');
            
            var baseUrl = '{{ url("/threshold") }}';
            $('#thresholdForm').attr('action', baseUrl + '/' + id);
            
            // Hide previous errors
            $('#formErrors').hide().empty();
            
            // Show modal
            $('#thresholdModal').modal('show');
        });
        
        // Delete button handler
        $('.delete-threshold').off('click').on('click', function() {
            var id = $(this).data('id');
            var role = $(this).data('role');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete threshold for role: " + role,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/threshold") }}/' + id,
                        data: {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#threshold-row-' + id).fadeOut(500, function() {
                                    $(this).remove();
                                    
                                    if ($('#thresholds-table tbody tr').length === 0) {
                                        $('#thresholds-table tbody').html('<tr><td colspan="7" class="text-center text-danger">No thresholds found.</td></tr>');
                                    }
                                    
                                    // Update total count badge
                                    var totalCount = $('#thresholds-table tbody tr').length;
                                    $('.badge.bg-info').text('Total: ' + totalCount + ' records');
                                });
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log('Delete Error:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'An error occurred while deleting',
                            });
                        }
                    });
                }
            });
        });
    }

    // Reset form when modal is closed
    $('#thresholdModal').on('hidden.bs.modal', function () {
        $('#thresholdForm')[0].reset();
        $('#formErrors').hide().empty();
        $('#min, #max').val('');
    });
});
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
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
    .label-primary {
        background-color: #337ab7;
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 3px;
        color: white;
        display: inline-block;
    }
    .label-info {
        background-color: #5bc0de;
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 3px;
        color: white;
        display: inline-block;
    }
    #formErrors {
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 15px;
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
    }
    #formErrors ul {
        padding-left: 20px;
        margin-bottom: 0;
    }
    .input-group-addon {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px 0 0 4px;
        padding: 6px 12px;
        font-weight: bold;
    }
    .modal-md {
        width: 500px;
    }
    .text-muted small {
        font-size: 11px;
        color: #999;
    }
    .btn-success.btn-xs {
        padding: 3px 8px;
        font-size: 12px;
        margin-right: 10px;
    }
    .btn-danger.btn-xs {
        margin-left: 5px;
    }
    .badge.bg-info {
        background-color: #5bc0de;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .panel-heading .pull-right {
        margin-top: -3px;
    }
</style>
@endsection