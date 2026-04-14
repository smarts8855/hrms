@extends('layouts_procurement.app')
@section('pageTitle', 'Submit Needs')
@section('pageMenu', 'active')
@section('content')

<div class="box-body" style="background:#FFF;">
    <div class="row">
        <div class="col-md-12">

            <!-- Header -->
            <div class="card-panel">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 style="margin:0;"><b>Submit Needs Assessment</b></h3>
                        </div>

                        @if (isset($title) && $title->status == 1)
                            <div class="col-md-6 text-right">
                                <p class="mb-0">
                                    If you can't find item,
                                    <a href="#" id="openModalLink" style="text-decoration:none; color:red;">click
                                        here</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Department Section -->
            <div class="card-panel">
                <div class="card-body">
                    @if(isset($is_global) && $is_global == 1)
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-primary" style="font-weight:bold; margin:0;">
                                    <i class="fa fa-globe"></i>
                                    Department: Superadmin (Select Department Below)
                                </h4>
                            </div>
                        </div>
                    @else
                        <h4 class="text-primary" style="font-weight:bold; margin:0;">
                            <i class="fa fa-building"></i>
                            Department: 
                            @if($userUnit && isset($userUnit->department_name))
                                {{ $userUnit->department_name }}
                            @else
                                <span class="text-danger">No department assigned</span>
                            @endif
                        </h4>
                        @if(!$userUnit || !isset($userUnit->department_name))
                            <p class="text-muted mt-2">Please contact administrator to assign a department.</p>
                        @endif
                    @endif
                </div>
            </div>

            @if (isset($title) && $title->status == 1)

                <!-- CREATE NEEDS ENTRY CARD -->
                <div class="card-panel">
                    <div class="card-header" style="background:#337ab7; color:#FFF;">
                        <i class="fa fa-file-text"></i>
                        {{ $title->title }} for {{ date('d-m-Y', strtotime($title->date)) }}
                    </div>

                    <div class="card-body">
                        <h4 class="text-uppercase" style="margin-top:0;">Create Needs Entry</h4>

                        <form action="{{ route('saveNeedsAssessment') }}" method="POST" id="needsForm">
                            @csrf
                            <input type="hidden" name="titleID" id="titleID" value="{{ $id }}">
                            
                            @if(isset($is_global) && $is_global == 1)
                                <!-- Department dropdown inside form for global users -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_department">Select Department for Submission <span class="text-danger">*</span></label>
                                            <select class="form-control" id="form_department" name="department" required>
                                                <option value="">-- Select Department --</option>
                                                @foreach($departments ?? [] as $department)
                                                    <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>
                                                        {{ $department->department }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="department" value="{{ $userDepartmentId ?? '' }}">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categoryList as $list)
                                                <option value="{{ $list->categoryID }}"
                                                    {{ old('category') == $list->categoryID ? 'selected' : '' }}>
                                                    {{ $list->category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="item_container">
                                        <label id="item_label">Item <span class="text-danger">*</span></label>
                                        <select class="form-control" id="item" name="item" required>
                                            <option value="">Select Item</option>
                                            <!-- Items will be loaded dynamically based on category -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Specification Tags Container - ONLY SHOWN FOR NON-CATEGORY 5 -->
                            <div class="form-group" id="specification_container" style="display: none;">
                                <label>Specifications <span class="text-danger">*</span></label>
                                
                                <!-- Tags Container inside a form-control look-alike -->
                                <div id="specifications-tags-container" class="form-control" style="height: auto; min-height: 38px; padding: 5px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; cursor: not-allowed;">
                                    <div id="selected_specs_container" style="display: flex; flex-wrap: wrap; gap: 5px; min-height: 28px;">
                                        <!-- Selected specifications will appear here as disabled tags -->
                                        <span class="text-muted" id="no-spec-message" style="color: #999; font-style: italic; padding: 5px;">Select an item to view specifications</span>
                                    </div>
                                </div>
                                
                                <!-- Hidden input to store selected specification IDs (comma-separated) -->
                                <input type="hidden" name="specification_ids" id="specification_ids_hidden" value="">
                            </div>

                            <!-- Regular Description Field - ONLY SHOWN FOR CATEGORY 5 (Services) -->
                            <div class="form-group" id="description_container" style="display: none;">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter service description" id="description_field">{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="text" name="quantity" class="form-control"
                                            placeholder="Enter quantity" value="{{ old('quantity') }}" id="quantity_field">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Brief Justification</label>
                                        <textarea name="brief_justification" class="form-control" rows="2" placeholder="Enter justification">{{ old('brief_justification') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button class="btn btn-success" type="submit" id="submitBtn">
                                    <i class="fa fa-check"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- NEEDS LIST CARD -->
                <div class="card-panel">
                    <div class="card-header">
                        <b>Needs List</b>
                        @if(isset($is_global) && $is_global == 1)
                            <small class="pull-right text-muted">Showing all departments</small>
                        @endif
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-striped table-condensed table-bordered">
                            <thead class="text-gray-b">
                                <tr>
                                    <th style="width: 50px;">S/N</th>
                                    @if(isset($is_global) && $is_global == 1)
                                        <th>DEPARTMENT</th>
                                    @endif
                                    <th>CATEGORY</th>
                                    <th>ITEM</th>
                                    <th>DESCRIPTION/SPECIFICATIONS</th>
                                    <th>QUANTITY</th>
                                    <th>JUSTIFICATION</th>
                                    <th style="width: 100px;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $n=1; @endphp
                                @forelse ($getList as $list)
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        @if(isset($is_global) && $is_global == 1)
                                            <td><strong>{{ $list->department_name ?? 'N/A' }}</strong></td>
                                        @endif
                                        <td><strong>{{ $list->category }}</strong></td>
                                        <td>
                                            <strong>{{ $list->item ?? 'N/A' }}</strong>
                                            @if(isset($list->specifications) && is_array($list->specifications) && count($list->specifications) > 1)
                                                <span class="badge" style="background-color: #5bc0de; margin-left: 5px;">{{ count($list->specifications) }} specs</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($list->description) && !empty($list->description))
                                                {{ $list->description }}
                                            @elseif(isset($list->specifications) && is_array($list->specifications) && count($list->specifications) > 0)
                                                @foreach($list->specifications as $spec)
                                                    <span class="label label-info" style="margin-right: 5px; margin-bottom: 5px; display: inline-block;">
                                                        <i class="fa fa-tag"></i> {{ $spec }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No specifications</span>
                                            @endif
                                        </td>
                                        <td>{{ $list->quantity }}</td>
                                        <td>{{ $list->brief_justification }}</td>
                                        <td>
                                            @if(isset($list->categoryID) && $list->categoryID == 5)
                                                <!-- Services - single record edit -->
                                                <button class="btn btn-info btn-sm"
                                                    onclick="funcedit('{{ $list->needsID }}','{{ $list->categoryID }}','{{ $list->itemID ?? '' }}','{{ addslashes($list->description ?? '') }}','{{ addslashes($list->brief_justification) }}','{{ $list->quantity }}', '')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @else
                                                <!-- Items with specifications - group edit -->
                                                <button class="btn btn-info btn-sm"
                                                    onclick="funcedit('{{ $list->needsID }}','{{ $list->categoryID }}','{{ $list->itemID }}','','{{ addslashes($list->brief_justification) }}','{{ $list->quantity }}', '{{ isset($list->specification_ids) ? implode(',', $list->specification_ids) : '' }}')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endif

                                            {{-- <button class="btn btn-danger btn-sm"
                                                onclick="funcdelete('{{ base64_encode($list->needsID) }}')">
                                                <i class="fa fa-trash"></i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ (isset($is_global) && $is_global == 1) ? '8' : '7' }}" class="text-center">
                                            <div class="alert alert-warning mb-0">
                                                <i class="fa fa-exclamation-triangle"></i> 
                                                No needs found.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif(isset($title) && $title->status == 0)
                <!-- CLOSED MESSAGE CARD -->
                <div class="card-panel text-center">
                    <div class="card-body">
                        <img src="/images/folder.jpeg" width="200" class="mb-4">
                        <h4 class="text-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            Please contact Procurement Unit to open needs.
                        </h4>
                    </div>
                </div>
            @else
                <!-- NO TITLE FOUND CARD -->
                <div class="card-panel text-center">
                    <div class="card-body">
                        <img src="/images/folder.jpeg" width="200" class="mb-4">
                        <h4 class="text-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            No active needs title found.
                        </h4>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade text-left d-print-none" id="editModalx" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">
                    <i class="fa fa-edit"></i> Edit Needs Entry
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('updateNeedsAssessment') }}" id="editForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="idx">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="categoryx" name="category" required onchange="handleEditCategoryChange()" disabled>
                                    <option value="">Select Category</option>
                                    @foreach ($categoryList as $list)
                                        <option value="{{ $list->categoryID }}">{{ $list->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="item_containerx">
                                <label id="item_labelx">Item <span class="text-danger">*</span></label>
                                <select class="form-control" id="itemx" name="item" required onchange="handleEditItemChange(this.value)" disabled>
                                    <option value="">Select Item</option>
                                    <!-- Items will be loaded dynamically based on category -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Specification Container - ONLY SHOWN FOR NON-CATEGORY 5 -->
                    <div class="form-group" id="edit_specification_container" style="display: none;" disabled>
                        <label>Specifications <span class="text-danger">*</span></label>
                        
                        <!-- Tags Container inside a form-control look-alike -->
                        <div id="edit-specifications-tags-container" class="form-control" style="height: auto; min-height: 38px; padding: 5px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; cursor: not-allowed;">
                            <div id="edit_selected_specs_container" style="display: flex; flex-wrap: wrap; gap: 5px; min-height: 28px;">
                                <!-- Selected specifications will appear here as disabled tags -->
                            </div>
                        </div>
                        
                        <!-- Hidden input to store selected specification IDs (comma-separated) -->
                        <input type="hidden" name="edit_specification_ids" id="edit_specification_ids_hidden" value="">
                    </div>

                    <!-- Edit Description Field - ONLY SHOWN FOR CATEGORY 5 -->
                    <div class="form-group" id="edit_description_container" style="display: none;">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="descriptionx" cols="30" rows="3" class="form-control" placeholder="Enter service description"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control" name="quantity" id="quantityx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Brief Justification</label>
                                <textarea name="brief_justification" id="brief_justificationx" cols="30" rows="2" class="form-control"></textarea>
                            </div>
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

<!-- Add Item Modal -->
<div class="modal fade text-left d-print-none" id="myModal" tabindex="-1" role="dialog"
    aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">
                    <i class="fa fa-plus"></i> Add New Item
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="custom-validation" action="{{ route('saveNotification') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Item Name <span class="text-danger">*</span></label>
                        <input required type="text" name="item" value="" class="form-control"
                            placeholder="Enter Item Name" />
                    </div>
                    <div class="form-group">
                        <label>Reason <span class="text-danger">*</span></label>
                        <textarea name="reason" cols="" rows="3" class="form-control"
                            placeholder="Give reason why you want item to be added"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        /* Make Bootstrap 3 Panels Look Like Cards */
        .card-panel {
            border-radius: 6px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            border: 1px solid #ddd;
            margin-bottom: 25px;
            background: #fff;
        }

        .card-header {
            padding: 12px 15px;
            font-size: 16px;
            font-weight: bold;
            border-bottom: 1px solid #e5e5e5;
            background: #f7f7f7;
            border-radius: 6px 6px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.04);
        }

        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #007bff;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        /* Selected Specifications Tags - Disabled Style */
        .spec-tag {
            display: inline-flex;
            align-items: center;
            background-color: #6c757d; /* Gray color for disabled */
            color: white;
            padding: 5px 12px;
            margin: 3px;
            border-radius: 20px;
            font-size: 13px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: default; /* No pointer cursor */
            opacity: 0.9;
        }

        .spec-tag i {
            margin-right: 6px;
            font-size: 12px;
        }

        /* Container styling */
        #specifications-tags-container,
        #edit-specifications-tags-container {
            background-color: #f5f5f5;
            cursor: not-allowed;
            pointer-events: none; /* Prevents any interaction */
        }

        /* No border container for tags */
        #selected_specs_container, 
        #edit_selected_specs_container {
            min-height: 28px;
            padding: 0;
            background-color: transparent;
        }

        /* Remove any hover effects */
        .spec-tag:hover {
            background-color: #6c757d; /* Stay same color */
            transform: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .label-info {
            background-color: #17a2b8;
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: normal;
        }

        .text-muted {
            color: #6c757d;
            font-style: italic;
        }

        .fa-spinner {
            margin-right: 5px;
        }

        /* Style for disabled dropdown options (already added items) */
        select option:disabled {
            color: #999;
            font-style: italic;
            background-color: #f5f5f5;
        }
        
        select option.text-muted {
            color: #999 !important;
        }
        
        /* Duplicate warning badge */
        .duplicate-badge {
            background-color: #dc3545;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 3px;
            margin-left: 5px;
        }

        .badge {
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Store selected specifications (as objects with id and name)
        let selectedSpecifications = [];
        let availableSpecifications = [];

        // Edit mode variables
        let editSelectedSpecifications = [];
        let editAvailableSpecifications = [];
        let currentEditItemId = null;

        $(document).ready(function() {
            // Reset edit modal when closed
            $('#editModalx').on('hidden.bs.modal', function () {
                editSelectedSpecifications = [];
                editAvailableSpecifications = [];
                currentEditItemId = null;
                $('#edit_selected_specs_container').empty();
            });

            // Initialize any existing old values if form validation fails
            @if(old('category') && old('item'))
                var oldCategory = "{{ old('category') }}";
                var oldItem = "{{ old('item') }}";
                
                if(oldCategory && oldItem) {
                    $('#category').val(oldCategory).trigger('change');
                    
                    // Wait for items to load then set the item
                    setTimeout(function() {
                        $('#item').val(oldItem).trigger('change');
                    }, 500);
                }
            @endif
        });

        // ========== UNIQUENESS CHECK FUNCTIONS ==========

        // Function to check if item already exists for the selected department
        function checkItemExistsForDepartment(itemId, categoryId, departmentId, callback) {
            if (!departmentId) {
                callback(false);
                return;
            }
            
            $.ajax({
                url: '/check-item-exists-for-department',
                type: 'POST',
                data: {
                    item_id: itemId,
                    category_id: categoryId,
                    department_id: departmentId,
                    title_id: $('#titleID').val(),
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    callback(response.exists);
                },
                error: function() {
                    callback(false);
                }
            });
        }

        // Function to mark existing items in dropdown
        function markExistingItemsInDropdown(categoryId, departmentId) {
            if (!departmentId) return;
            
            $.ajax({
                url: '/get-existing-items-for-department',
                type: 'POST',
                data: {
                    category_id: categoryId,
                    department_id: departmentId,
                    title_id: $('#titleID').val(),
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(existingItemIds) {
                    $('#item option').each(function() {
                        var $option = $(this);
                        var itemId = $option.val();
                        
                        if (itemId && existingItemIds.includes(parseInt(itemId))) {
                            var originalText = $option.text().replace(' (Already Added)', '');
                            $option.addClass('text-muted').attr('disabled', true)
                                   .text(originalText + ' (Already Added)');
                        } else {
                            var originalText = $option.text().replace(' (Already Added)', '');
                            $option.removeClass('text-muted').removeAttr('disabled')
                                   .text(originalText);
                        }
                    });
                }
            });
        }

        // ========== CREATE MODE FUNCTIONS ==========

        // Function to load specifications based on selected item
        function loadSpecifications(itemId) {
            if (!itemId) {
                $('#specification_container').hide();
                $('#selected_specs_container').empty();
                $('#selected_specs_container').html('<span class="text-muted" id="no-spec-message" style="color: #999; font-style: italic; padding: 5px;">Select an item to view specifications</span>');
                selectedSpecifications = [];
                $('#specification_ids_hidden').val('');
                return;
            }

            // Check if category is 5 (services)
            var categoryId = $('#category').val();
            if (categoryId == 5) {
                return;
            }

            // Show loading state
            $('#specification_container').show();
            $('#selected_specs_container').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Loading specifications...</span>');

            // Make AJAX call to get specifications
            $.ajax({
                url: '/get-specifications-by-item/' + itemId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        // Item has specifications
                        availableSpecifications = data;
                        
                        // AUTOMATICALLY SELECT ALL SPECIFICATIONS (store both id and name)
                        selectedSpecifications = data.map(spec => ({
                            id: spec.specificationID,
                            name: spec.specification
                        }));
                        
                        // Update the display with disabled tags (no remove functionality)
                        updateSpecificationsDisplay();
                    } else {
                        // Item has no specifications - HIDE THE CONTAINER COMPLETELY (NO POPUP)
                        $('#specification_container').hide();
                        selectedSpecifications = [];
                        $('#specification_ids_hidden').val('');
                        
                        // NO POPUP SHOWN HERE
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading specifications:', error);
                    $('#specification_container').hide();
                    selectedSpecifications = [];
                    $('#specification_ids_hidden').val('');
                    
                    // Keep error popup for actual errors (connection issues, server errors)
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error loading specifications',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        }

        // Update specifications display (for create mode) - DISABLED TAGS, NO REMOVE FUNCTIONALITY
        function updateSpecificationsDisplay() {
            // Update tags container
            var tagsContainer = $('#selected_specs_container');
            tagsContainer.empty();
            
            if (selectedSpecifications.length > 0) {
                selectedSpecifications.forEach(function(spec) {
                    // Create disabled tag (no onclick, just display)
                    var tag = $('<span class="spec-tag" style="background-color: #6c757d; cursor: default;" title="Auto-loaded specification">' +
                               '<i class="fa fa-check-circle"></i> ' + spec.name + 
                               '</span>');
                    tagsContainer.append(tag);
                });
                
                // Make sure container is visible
                $('#specification_container').show();
                
                // Update hidden input with comma-separated IDs
                var specIds = selectedSpecifications.map(s => s.id).join(',');
                $('#specification_ids_hidden').val(specIds);
            } else {
                // Just hide the container, don't show any message
                $('#specification_container').hide();
                $('#specification_ids_hidden').val('');
            }
        }

        // ========== EDIT MODE FUNCTIONS ==========

        // Function to load items based on category in edit modal
        function loadItemsByCategory(categoryId, selectedItemId = null) {
            if (!categoryId) {
                $('#itemx').empty();
                $('#itemx').append('<option value="">Select Item</option>');
                return;
            }

            $.get('/get-item-from-category?category_id=' + categoryId, function(data) {
                $('#itemx').empty();
                $('#itemx').append('<option value="">Select Item</option>');
                $.each(data, function(index, obj) {
                    $('#itemx').append('<option value="' + obj.itemID + '">' + obj.item + '</option>');
                });
                
                // If there's a selected item, set it
                if (selectedItemId) {
                    $('#itemx').val(selectedItemId);
                    // Load specifications for this item
                    loadEditSpecifications(selectedItemId);
                    currentEditItemId = selectedItemId;
                }
            });
        }

        // Function to load specifications in edit modal
        function loadEditSpecifications(itemId) {
            if (!itemId) {
                $('#edit_specification_container').hide();
                $('#edit_selected_specs_container').empty();
                return;
            }

            // Get current category
            var categoryId = $('#categoryx').val();
            
            // Check if category is 5 (services)
            if (categoryId == 5) {
                return;
            }

            // Store current item ID
            currentEditItemId = itemId;

            // Show loading
            $('#edit_specification_container').show();
            $('#edit_selected_specs_container').html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Loading specifications...</span>');

            // Make AJAX call to get specifications
            $.ajax({
                url: '/get-specifications-by-item/' + itemId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        $('#edit_specification_container').show();
                        
                        // Store available specifications
                        editAvailableSpecifications = data;
                        
                        // Update the display with existing selections
                        updateEditSpecificationsDisplay();
                    } else {
                        // Item has no specifications in edit mode - hide container silently
                        $('#edit_specification_container').hide();
                    }
                },
                error: function() {
                    $('#edit_specification_container').hide();
                }
            });
        }

        // Handle item change in edit modal - NO WARNING POPUP
        function handleEditItemChange(itemId) {
            var categoryId = $('#categoryx').val();
            
            // Don't load specifications if category is services
            if (categoryId != 5 && itemId) {
                // Simply load specifications for the selected item without any warning
                loadEditSpecifications(itemId);
                currentEditItemId = itemId;
            }
        }

        // Update edit specifications display - DISABLED TAGS, NO REMOVE FUNCTIONALITY
        function updateEditSpecificationsDisplay() {
            var tagsContainer = $('#edit_selected_specs_container');
            tagsContainer.empty();
            
            if (editSelectedSpecifications.length > 0) {
                // Create an array to store specification IDs
                var specIds = [];
                
                editSelectedSpecifications.forEach(function(spec) {
                    // If spec is an object with id and name (from selection)
                    if (typeof spec === 'object' && spec.id) {
                        specIds.push(spec.id);
                        var tag = $('<span class="spec-tag" style="background-color: #6c757d; cursor: default;" title="Specification">' +
                                   '<i class="fa fa-check-circle"></i> ' + spec.name + 
                                   '</span>');
                        tagsContainer.append(tag);
                    } 
                    // If spec is just an ID (from the database)
                    else if (spec) {
                        specIds.push(spec);
                        // Find the specification name from availableSpecifications
                        var specObj = editAvailableSpecifications.find(s => s.specificationID == spec);
                        var specName = specObj ? specObj.specification : 'Specification ' + spec;
                        
                        var tag = $('<span class="spec-tag" style="background-color: #6c757d; cursor: default;" title="Specification">' +
                                   '<i class="fa fa-check-circle"></i> ' + specName + 
                                   '</span>');
                        tagsContainer.append(tag);
                    }
                });
                
                // Make sure container is visible
                $('#edit_specification_container').show();
                
                // Update hidden input with comma-separated IDs
                $('#edit_specification_ids_hidden').val(specIds.join(','));
            } else {
                // Just hide the container, don't show any message
                $('#edit_specification_container').hide();
                $('#edit_specification_ids_hidden').val('');
            }
        }

        // Handle category change in edit modal
        function handleEditCategoryChange() {
            var categoryId = $('#categoryx').val();
            var currentItemId = $('#itemx').val();
            
            if (categoryId == 5) {
                // Services category - show description, hide item and specifications
                $('#item_containerx').hide();
                $('#edit_specification_container').hide();
                $('#edit_description_container').show();
                
                // Clear edit specifications
                editSelectedSpecifications = [];
                updateEditSpecificationsDisplay();
                
                // Clear item dropdown
                $('#itemx').empty();
                $('#itemx').append('<option value="">Select Item</option>');
            } else {
                // Other categories - show item and specifications, hide description
                $('#item_containerx').show();
                $('#edit_description_container').hide();
                
                // Keep existing specifications (don't clear)
                // Just load items for this category
                loadItemsByCategory(categoryId, currentItemId);
            }
        }

        // Updated Edit function to handle both services and items with specifications
        function funcedit(id, categoryId, itemId, description, justification, quantity, specIds = '') {
            // Set form values
            $('#idx').val(id);
            $('#categoryx').val(categoryId).trigger('change');
            $('#descriptionx').val(description);
            $('#brief_justificationx').val(justification);
            $('#quantityx').val(quantity);
            
            // If category is services (5)
            if (categoryId == 5) {
                $('#item_containerx').hide();
                $('#edit_specification_container').hide();
                $('#edit_description_container').show();
                $('#edit_specification_ids_hidden').val('');
            } else {
                // For items with specifications
                $('#item_containerx').show();
                $('#edit_description_container').hide();
                
                // Parse specification IDs
                if (specIds && specIds.trim() !== '') {
                    editSelectedSpecifications = specIds.split(',').map(id => parseInt(id));
                } else {
                    editSelectedSpecifications = [];
                }
                
                // Load items for this category and set the selected item
                loadItemsByCategory(categoryId, itemId);
            }
            
            $('#editModalx').modal('show');
        }

        // ========== COMMON FUNCTIONS ==========

        // Category change handler for create mode
        $("#category").change(function(e) {
            var category_id = e.target.value;
            var department_id = $('#form_department').length ? $('#form_department').val() : '{{ $userDepartmentId ?? '' }}';

            if (category_id == 5) {
                // Services category - show description, hide item and specifications
                $('#item_container').hide();
                $('#specification_container').hide();
                $('#description_container').show();
                
                // Clear selected specifications
                selectedSpecifications = [];
                updateSpecificationsDisplay();
                
                // Make description required
                $('#description_field').prop('required', true);
                $('#item').prop('required', false);
            } else {
                // Other categories - show item and specifications, hide description
                $('#item_container').show();
                $('#description_container').hide();
                $('#specification_container').hide(); // Hide until item is selected
                
                // Clear selected specifications
                selectedSpecifications = [];
                updateSpecificationsDisplay();
                
                // Make item required, description not required
                $('#item').prop('required', true);
                $('#description_field').prop('required', false);
                
                // Load items for this category
                $.get('/get-item-from-category?category_id=' + category_id, function(data) {
                    $('#item').empty();
                    $('#item').append('<option value="">Select Item</option>');
                    $.each(data, function(index, obj) {
                        $('#item').append('<option value="' + obj.itemID + '">' + obj.item + '</option>');
                    });
                    
                    // Mark existing items if department is selected
                    if (department_id) {
                        markExistingItemsInDropdown(category_id, department_id);
                    }
                }).fail(function() {
                    console.error('Failed to load items');
                });
            }
        });

        // For global users, add department change handler
        @if(isset($is_global) && $is_global == 1)
        $("#form_department").change(function() {
            var department_id = $(this).val();
            var category_id = $('#category').val();
            
            if (category_id && category_id != 5 && department_id) {
                markExistingItemsInDropdown(category_id, department_id);
            }
            
            // Clear item selection when department changes
            $('#item').val('');
            $('#specification_container').hide();
            selectedSpecifications = [];
            $('#selected_specs_container').html('<span class="text-muted" style="color: #999; font-style: italic; padding: 5px;">Select an item to view specifications</span>');
            $('#specification_ids_hidden').val('');
        });
        @endif

        // Item change handler for create mode with uniqueness check
        $("#item").change(function(e) {
            var item_id = e.target.value;
            var category_id = $('#category').val();
            var department_id = $('#form_department').length ? $('#form_department').val() : '{{ $userDepartmentId ?? '' }}';
            
            if (!item_id) {
                $('#specification_container').hide();
                selectedSpecifications = [];
                $('#selected_specs_container').html('<span class="text-muted" style="color: #999; font-style: italic; padding: 5px;">Select an item to view specifications</span>');
                $('#specification_ids_hidden').val('');
                return;
            }
            
            // For global users, check department selection
            @if(isset($is_global) && $is_global == 1)
            if (!department_id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Department Required',
                    text: 'Please select a department first before choosing an item.'
                });
                $('#item').val('');
                return;
            }
            @endif
            
            // Check if item already exists for this department
            checkItemExistsForDepartment(item_id, category_id, department_id, function(exists) {
                if (exists) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Item',
                        text: 'This item has already been added for this department. Each department can only have one entry per item.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        $('#item').val('');
                        $('#specification_container').hide();
                        selectedSpecifications = [];
                        $('#selected_specs_container').html('<span class="text-muted" style="color: #999; font-style: italic; padding: 5px;">Select an item to view specifications</span>');
                        $('#specification_ids_hidden').val('');
                    });
                } else {
                    // Load specifications
                    loadSpecifications(item_id);
                }
            });
        });

        // Form submission validation for create mode
        $('#needsForm').on('submit', function(e) {
            var categoryId = $('#category').val();
            var departmentId = $('#form_department').length ? $('#form_department').val() : '{{ $userDepartmentId ?? '' }}';
            
            if (!categoryId) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select a category'
                });
                return false;
            }
            
            @if(isset($is_global) && $is_global == 1)
            if (!departmentId) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select a department'
                });
                return false;
            }
            @endif
            
            if (categoryId == 5) {
                // For services category, description is required
                var description = $('#description_field').val();
                if (!description || description.trim() === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please enter a description for services'
                    });
                    return false;
                }
            } else {
                // For other categories, item and specifications are required
                var itemId = $('#item').val();
                if (!itemId) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select an item'
                    });
                    return false;
                }
                
                // Check if item has specifications
                var specIds = $('#specification_ids_hidden').val();
                if (!specIds || specIds.trim() === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'This item has no specifications. Please select a different item.'
                    });
                    return false;
                }
                
                // Final duplicate check before submission
                var isDuplicate = false;
                $.ajax({
                    url: '/check-item-exists-for-department',
                    type: 'POST',
                    data: {
                        item_id: itemId,
                        category_id: categoryId,
                        department_id: departmentId,
                        title_id: $('#titleID').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    async: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.exists) {
                            isDuplicate = true;
                        }
                    }
                });
                
                if (isDuplicate) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Duplicate Item',
                        text: 'This item has already been added for this department. Each department can only have one entry per item.'
                    });
                    return false;
                }
            }
            
            // Show loading state on submit button
            $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);
        });

        // Form submission validation for edit mode
        $('#editForm').on('submit', function(e) {
            var categoryId = $('#categoryx').val();
            
            if (!categoryId) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select a category'
                });
                return false;
            }
            
            if (categoryId == 5) {
                // For services category, description is required
                var description = $('#descriptionx').val();
                if (!description || description.trim() === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please enter a description for services'
                    });
                    return false;
                }
            } else {
                // For other categories, item and specifications are required
                var itemId = $('#itemx').val();
                if (!itemId) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select an item'
                    });
                    return false;
                }
                
                // Check if there are specification IDs
                if (editSelectedSpecifications.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'No specifications selected for this item'
                    });
                    return false;
                }
            }
        });

        // Delete function
        function funcdelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This needs entry will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/delete-needs-assessment/" + id;
                }
            });
        }

        // Add click event listener to the "click here" link
        document.getElementById('openModalLink')?.addEventListener('click', function(event) {
            event.preventDefault();
            $('#myModal').modal('show');
        });

        // Number formatting
        $(document).ready(function() {
            $(".bidAmt").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });
            
            // Also format quantity field if needed
            $("#quantity_field, #quantityx").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/\D/g, "");
                });
            });
        });

        // Success/Error messages with SweetAlert toast
        @if (session('msg'))
            Swal.fire({
                toast: true,
                position: 'top-end',
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
                },
            });
        @endif
    </script>
@endsection