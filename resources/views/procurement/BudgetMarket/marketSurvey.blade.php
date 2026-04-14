@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Create Market Survey') }}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius:6px;">
            <div class="panel-heading" style="background-color:#f5f5f5; border-bottom:1px solid #ddd;">
                <h3 class="panel-title">@yield('pageTitle')</h3>
            </div>

            <div class="panel-body">
                <div align="right" style="margin-bottom:10px;">
                    All fields with <span class="text-danger">*</span> are required.
                </div>

                <hr />

                <form class="formFormatAmount" method="POST" action="{{ route('saveBudgetSurvey') }}" id="mainSurveyForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Category <span class="text-danger">*</span></label>
                            <select name="budgetCategory" id="cat-id" class="form-control" required>
                                <option value="">Select</option>
                                @foreach ($getCategory as $list)
                                    <option value="{{ $list->categoryID }}">{{ $list->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Item <span class="text-danger">*</span></label>
                            <select id="item-id" name="budgetItem" class="form-control" required>
                                <option value="">Select</option>
                                @foreach ($getBudgetItem as $list)
                                    <option value="{{ $list->itemID }}">{{ $list->item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="specifications">Specification <span class="text-danger">*</span></label>
                            <div id="specifications-container" class="form-control" style="height: auto; min-height: 38px; padding: 5px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
                                <div id="selected-specs" class="selected-specs" style="display: flex; flex-wrap: wrap; gap: 5px;">
                                    <!-- Specifications will be displayed here as tags -->
                                </div>
                            </div>
                            <input type="hidden" name="specifications[]" id="specifications-input" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Market Price <span class="text-danger">*</span></label>
                            <input required type="text" name="marketPrice" id="marketPrice"
                                value="{{ old('marketPrice') }}" class="form-control" placeholder="Price" />
                        </div>

                        <div class="form-group col-md-6">
                            <label>Contract Price <span class="text-danger">*</span></label>
                            <input required type="text" name="budgetPrice" id="budgetPrice"
                                value="{{ old('budgetPrice') }}" class="form-control" placeholder="Price" />
                        </div>

                        <div class="form-group col-md-6">
                            <label>Survey Date <span class="text-danger">*</span></label>
                            <input type="text" id="surveyDate" name="surveyDate" data-parsley-type="date" required
                                class="form-control surveyDate" placeholder="Select Date" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 text-right">
                            <button class="btn btn-primary" id="submitBtn">
                                <i class="fa fa-save"></i> Save Survey
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius:6px;">
            <div class="panel-heading" style="background-color:#f8f8f8; border-bottom:1px solid #ddd;">
                <h3 class="panel-title" style="font-weight:bold;">List of Surveys</h3>
            </div>

            <div class="panel-body">
                <hr style="margin-top:10px; margin-bottom:20px;">

                <div class="row">
                    <div align="center" class="form-group col-md-12">
                        <table class="table table-hover table-bordered table-responsive" id="exportTable">
                            <thead style="background-color:#f5f5f5; font-weight:bold;">
                                <tr>
                                    <th>SN</th>
                                    <th>Item</th>
                                    <th>Specifications</th>
                                    <th>Category</th>
                                    <th class="text-right">Contract Price</th>
                                    <th class="text-right">Market Price</th>
                                    <th>Survey Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($getBudgetMarketSurvey) && !empty($getBudgetMarketSurvey))
                                    @php 
                                        $sn = 1; 
                                        $uniqueItems = []; // Track unique items to avoid duplicates
                                    @endphp
                                    
                                    @foreach ($getBudgetMarketSurvey as $itemId => $itemGroup)
                                        @php
                                            // Check if this item already exists in the unique items array
                                            if (in_array($itemGroup['item_name'], $uniqueItems)) {
                                                continue; // Skip duplicate items
                                            }
                                            
                                            // Add to unique items array
                                            $uniqueItems[] = $itemGroup['item_name'];
                                            
                                            // Get unique specifications and remove duplicates
                                            $uniqueSpecs = array_unique($itemGroup['specifications']);
                                            $specCount = count($uniqueSpecs);
                                            
                                            // Use the first price and date (assuming each unique item has one entry)
                                            $price = !empty($itemGroup['prices']) ? $itemGroup['prices'][0] : 0;
                                            $marketPrice = !empty($itemGroup['marketPrices']) ? $itemGroup['marketPrices'][0] : 0;
                                            $surveyDate = !empty($itemGroup['survey_dates']) ? $itemGroup['survey_dates'][0] : null;
                                            
                                            // Get the first market ID for this item
                                            $marketId = !empty($itemGroup['market_ids']) ? $itemGroup['market_ids'][0] : null;
                                        @endphp
                                        
                                        <tr class="text-left" id="item-row-{{ $itemId }}">
                                            <td>{{ $sn }}</td>
                                            <td>
                                                <strong>{{ $itemGroup['item_name'] }}</strong>
                                                @if ($specCount > 1)
                                                    <span class="badge" style="margin-left: 5px; background-color: #5bc0de; color: white;">{{ $specCount }} specs</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="specifications-container">
                                                    @foreach($uniqueSpecs as $spec)
                                                        <span class="spec-item" style="background-color: #337ab7; color: white; padding: 2px 8px; border-radius: 4px; margin: 2px; display: inline-block; font-size: 12px;">
                                                            <i class="fa fa-circle" style="font-size: 8px; vertical-align: middle; margin-right: 5px; color: rgba(255,255,255,0.8);"></i>
                                                            {{ $spec }}
                                                        </span>
                                                        @if(!$loop->last)
                                                            <span class="spec-separator" style="color: #999; margin: 0 2px;"></span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>{{ $itemGroup['category'] }}</td>
                                            <td class="text-right">{{ number_format($price, 2) }}</td>
                                            <td class="text-right">{{ number_format($marketPrice, 2) }}</td>
                                            <td>{{ $surveyDate ? date('jS M Y', strtotime($surveyDate)) : 'N/A' }}</td>
                                            <td>
                                                <div class="btn-group-vertical btn-group-xs" role="group">
                                                    <a href="javascript:;" class="btn btn-info btn-xs" data-toggle="modal"
                                                        data-target=".viewEditItem{{ $itemId }}" title="Edit Survey">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="{{ route('singleSurveyArchive', $marketId) }}"
                                                        title="View History" class="btn btn-default btn-xs"
                                                        target="__blank">
                                                        <i class="fa fa-archive"></i> Archive
                                                    </a>
                                                    {{-- <a href="javascript:;" title="Delete" class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target=".deleteItem{{ $itemId }}">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @php $sn++; @endphp
                                        
                                        <!-- Edit Modal for Item -->
                                        <div class="modal fade viewEditItem{{ $itemId }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewEditItem{{ $itemId }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span>&times;</span></button>
                                                        <h4 class="modal-title">Edit Survey for {{ $itemGroup['item_name'] }}</h4>
                                                    </div>
                                                    <form method="POST" action="{{ route('saveBudgetSurvey') }}" class="formFormatAmount" id="editForm{{ $itemId }}">
                                                        @csrf
                                                        <input type="hidden" name="recordID" value="{{ $marketId }}">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label>Item</label>
                                                                    <input type="text" class="form-control" value="{{ $itemGroup['item_name'] }}" readonly>
                                                                    <input type="hidden" name="budgetItem" value="{{ $itemId }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-12">
                                                                    <label>Category</label>
                                                                    <input type="text" class="form-control" value="{{ $itemGroup['category'] }}" readonly>
                                                                    <input type="hidden" name="budgetCategory" value="{{ $itemGroup['category_id'] }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-12">
                                                                    <label>Specifications</label>
                                                                    <div class="well well-sm" style="background-color: #f9f9f9; margin-bottom: 0; max-height: 200px; overflow-y: auto;">
                                                                        @foreach($uniqueSpecs as $spec)
                                                                            <div style="padding: 5px 0;">
                                                                                <span style="background-color: #337ab7; color: white; padding: 2px 8px; border-radius: 4px; margin: 2px; display: inline-block; font-size: 12px;">
                                                                                    <i class="fa fa-circle" style="font-size: 8px; color: rgba(255,255,255,0.8); margin-right: 5px;"></i>
                                                                                    {{ $spec }}
                                                                                </span>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group col-md-6">
                                                                    <label>Contract Price <span class="text-danger">*</span></label>
                                                                    <input type="text" name="budgetPrice" class="form-control format-amount" 
                                                                        value="{{ number_format($price, 2) }}" required>
                                                                </div>
                                                                
                                                                <div class="form-group col-md-6">
                                                                    <label>Market Price <span class="text-danger">*</span></label>
                                                                    <input type="text" name="marketPrice" class="form-control format-amount" 
                                                                        value="{{ number_format($marketPrice, 2) }}" required>
                                                                </div>
                                                                
                                                                <div class="form-group col-md-12">
                                                                    <label>Survey Date <span class="text-danger">*</span></label>
                                                                    <input type="text" name="surveyDate" class="form-control surveyDate" 
                                                                        value="{{ $surveyDate ? date('d/m/Y', strtotime($surveyDate)) : '' }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Survey</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Modal for Item -->
                                        <div class="modal fade deleteItem{{ $itemId }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteItem{{ $itemId }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span>&times;</span></button>
                                                        <h4 class="modal-title">Confirm Delete!</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-primary">Delete survey for: <strong>{{ $itemGroup['item_name'] }}</strong></p>
                                                        <p class="text-danger">Specifications to delete:</p>
                                                        <ul class="list-group" style="max-height: 200px; overflow-y: auto;">
                                                            @foreach($uniqueSpecs as $spec)
                                                                <li class="list-group-item">
                                                                    <span style="background-color: #337ab7; color: white; padding: 2px 8px; border-radius: 4px; margin: 2px; display: inline-block; font-size: 12px;">
                                                                        <i class="fa fa-circle" style="font-size: 8px; color: rgba(255,255,255,0.8); margin-right: 5px;"></i>
                                                                        {{ $spec }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <p class="text-warning"><i class="fa fa-exclamation-triangle"></i> Are you sure you want to delete this record?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <a href="{{ route('deleteMSurvey', ['msID' => base64_encode($marketId)]) }}" 
                                                           class="btn btn-danger">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No survey records found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                    </div>

                    <div class="form-group col-md-12 text-center" style="margin-top:20px;">
                        <a href="{{ route('generate-pdf') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-download"></i> Export to PDF
                        </a>
                        <a href="{{ route('exportBudgetSurvey') }}" class="btn btn-info btn-sm">
                            <i class="fa fa-download"></i> Export to Excel
                        </a>
                        <a href="{{ route('budgetSurveyArchive') }}" class="btn btn-default btn-sm"
                            target="__blank">
                            <i class="fa fa-archive"></i> All Archive
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <style>
        /* Table styles */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }

        /* Specifications tags styles */
        .selected-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            min-height: 30px;
        }

        .spec-tag {
            background-color: #337ab7;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            margin: 2px;
            display: inline-block;
            font-size: 13px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }

        .spec-tag i {
            font-size: 8px;
            color: rgba(255,255,255,0.8);
            margin-right: 5px;
        }

        #specifications-container {
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        #specifications-container:focus-within {
            border-color: #66afe9;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, 0.6);
        }

        #no-spec-message {
            color: #999;
            font-style: italic;
            padding: 5px;
        }

        /* Loading indicator */
        .spec-loading {
            color: #666;
            font-style: italic;
            padding: 5px;
        }

        .spec-loading i {
            margin-right: 5px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Styles for specifications display in the table */
        .specifications-container {
            display: inline;
            line-height: 2.2;
        }
        
        .spec-item {
            background-color: #337ab7;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            margin: 2px;
            display: inline-block;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .spec-item:hover {
            background-color: #286090;
            cursor: default;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .spec-item i {
            color: rgba(255,255,255,0.8);
        }
        
        .spec-separator {
            color: #999;
            margin: 0 2px;
        }
        
        .badge {
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 10px;
            color: white;
        }
        
        .btn-group-vertical.btn-group-xs {
            display: inline-flex;
            flex-direction: column;
        }
        
        .btn-group-vertical.btn-group-xs .btn {
            border-radius: 3px;
            margin-bottom: 2px;
        }
        
        .spec-edit-container {
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        
        .input-group-addon {
            background-color: #f5f5f5;
        }
        
        .list-group-item {
            padding: 8px 15px;
            border: none;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
        
        @media screen and (max-width: 767px) {
            .spec-item {
                display: inline-block;
                white-space: normal;
                margin: 3px;
            }
            
            .btn-group-vertical.btn-group-xs {
                width: 100%;
            }
            
            .btn-group-vertical.btn-group-xs .btn {
                width: 100%;
            }
        }

        /* Table styling */
        .table > tbody > tr > td {
            vertical-align: middle;
        }
        
        .table-hover > tbody > tr:hover {
            background-color: #f5f5f5;
        }
        
        td:nth-child(3) {
            max-width: 400px;
        }
        
        .btn-group .btn-sm {
            margin: 0 2px;
        }
        
        /* Edit Modal Styles */
        .modal-md {
            width: 600px;
        }
        
        .well-sm {
            min-height: 20px;
            padding: 15px;
            margin-bottom: 0;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        }
        
        .well-sm div {
            margin: 5px 0;
        }
        
        .well-sm div:first-child {
            margin-top: 0;
        }
        
        .well-sm div:last-child {
            margin-bottom: 0;
        }
        
        input[readonly] {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }
        
        input[readonly]:focus {
            border-color: #ddd;
            box-shadow: none;
        }
        
        /* Custom tag style for specifications */
        .spec-tag {
            background-color: #337ab7;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            margin: 2px;
            display: inline-block;
            font-size: 12px;
        }
        
        .spec-tag i {
            color: rgba(255,255,255,0.8);
            margin-right: 5px;
        }

        /* Text muted style */
        .text-muted {
            color: #999;
            font-size: 11px;
            margin-top: 5px;
            display: block;
        }

        /* Label styles */
        .label {
            margin-right: 5px;
            padding: 5px 8px;
            font-size: 12px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- autocomplete js-->
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/table2excel.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Store all specifications for reference
            let allSpecifications = @json($getSpecification);
            
            $('#cat-id').change(function() {
                var cid = $(this).val();
                if (cid) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('/get-items-by-category') }}/" + cid,
                        success: function(res) {
                            if (res) {
                                $("#item-id").empty().append('<option value="">Select Item</option>');
                                $.each(res, function(index, item) {
                                    $("#item-id").append('<option value="' + index + '">' + item + '</option>');
                                });
                                
                                // Clear specifications when category changes
                                clearSpecifications();
                            }
                        }
                    });
                } else {
                    $("#item-id").empty().append('<option value="">Select Item</option>');
                    clearSpecifications();
                }
            });

            $('#item-id').change(function() {
                var itemId = $(this).val();
                
                if (itemId) {
                    // Show loading state
                    showSpecLoading();
                    
                    $.ajax({
                        type: "get",
                        url: "{{ url('/get-specification-by-item') }}/" + itemId,
                        success: function(res) {
                            console.log("Response:", res);
                            if (res && res.specifications) {
                                displaySpecificationsAsTags(res.specifications);
                            } else {
                                clearSpecifications();
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'info',
                                    title: 'No specifications found for this item',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching specifications:", error);
                            clearSpecifications();
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
                } else {
                    clearSpecifications();
                }
            });
            
            // Function to show loading indicator
            function showSpecLoading() {
                var container = $('#selected-specs');
                container.empty();
                container.append('<span class="spec-loading"><i class="fa fa-spinner fa-spin"></i> Loading specifications...</span>');
                $('#no-spec-message').hide();
            }
            
            // Function to display specifications as tags
            function displaySpecificationsAsTags(specifications) {
                var container = $('#selected-specs');
                container.empty();
                
                if (specifications && specifications.length > 0) {
                    // Hide the "no spec" message
                    $('#no-spec-message').hide();
                    
                    // Create an array to store specification IDs
                    var specIds = [];
                    
                    // Create tags for each specification
                    $.each(specifications, function(index, spec) {
                        specIds.push(spec.specificationID);
                        
                        var tag = $('<span>', {
                            class: 'spec-tag',
                            css: {
                                'background-color': '#337ab7',
                                'color': 'white',
                                'padding': '5px 10px',
                                'border-radius': '4px',
                                'margin': '2px',
                                'display': 'inline-block',
                                'font-size': '13px',
                                'cursor': 'default'
                            }
                        }).html('<i class="fa fa-circle" style="font-size: 8px; vertical-align: middle; margin-right: 5px; color: rgba(255,255,255,0.8);"></i> ' + spec.specification);
                        
                        container.append(tag);
                    });
                    
                    // Update the hidden input with specification IDs (comma-separated)
                    $('#specifications-input').val(specIds.join(','));
                    
                    // Show count of specifications
                    // container.append('<small class="text-muted" style="margin-left: 5px;">(' + specIds.length + ' specifications)</small>');
                } else {
                    clearSpecifications();
                }
            }
            
            // Function to clear specifications
            function clearSpecifications() {
                var container = $('#selected-specs');
                container.empty();
                $('#no-spec-message').show().appendTo(container);
                $('#specifications-input').val('');
            }
            
            // Form submission validation
            $('#mainSurveyForm').on('submit', function(e) {
                var specIds = $('#specifications-input').val();
                if (!specIds || specIds.trim() === '') {
                    e.preventDefault();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Please select an item with specifications',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return false;
                }
                
                // Remove any existing specifications inputs and add new ones
                $(this).find('input[name="specifications[]"]').remove();
                
                // Convert comma-separated string back to array for form submission
                var specArray = specIds.split(',');
                $.each(specArray, function(index, value) {
                    if (value.trim() !== '') {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'specifications[]',
                            value: value.trim()
                        }).appendTo('#mainSurveyForm');
                    }
                });
                
                // Show loading state on button
                $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);
            });
            
            // Date picker
            var currentDate = new Date();
            $('.surveyDate').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                endDate: "currentDate",
                maxDate: currentDate
            }).on('changeDate', function(ev) {
                $(this).datepicker('hide');
            });
            
            $('.surveyDate').keyup(function() {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9^-]/g, '');
                }
            });
            
            // Number Format
            $("#budgetPrice, #marketPrice, .format-amount").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });
            
            // Export functionality
            $('#exportAllBtn').click(function() {
                window.location.href = '{{ route('generate-pdf') }}';
            });
        });
    </script>

    @if (session('message'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('message') }}',
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