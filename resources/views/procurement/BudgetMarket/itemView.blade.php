@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Create Item') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">@yield('pageTitle')</h4>
                </div>

                <div class="panel-body">
                    <div class="text-right" style="margin-bottom:10px;">
                        All fields with <span class="text-danger">*</span> are required.
                    </div>

                    <form class="formFormatAmount" method="POST" action="{{ route('saveBudgetItem') }}" id="createItemForm">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Contract Category <span class="text-danger">*</span></label>
                                <select name="category" id="category"
                                    class="form-control @error('category') is-invalid @enderror" required>
                                    <option value="">Select</option>
                                    @if (isset($getCategory) && $getCategory)
                                        @foreach ($getCategory as $key => $value)
                                            <option value="{{ $value->categoryID }}"
                                                {{ $value->categoryID == old('category') ? 'selected' : '' }}>
                                                {{ $value->category }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="category-error" class="text-danger" style="display:none;"></div>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Store Iteam Category <span class="text-danger">*</span></label>
                                <select name="storeItemCatID" id="storeItemCatID"
                                    class="form-control @error('storeItemCatID') is-invalid @enderror" required>

                                    <option value="">Select</option>

                                    @if (isset($storeCategories) && $storeCategories)
                                        @foreach ($storeCategories as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $value->id == old('storeItemCatID') ? 'selected' : '' }}>
                                                {{ $value->storeItemCat }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                                @error('storeItemCatID')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="item-error" class="text-danger" style="display:none;"></div>
                                <div id="item-warning" class="text-warning" style="display:none;"></div>
                            </div>



                            <div class="form-group col-md-4">
                                <label>Item Name<span class="text-danger">*</span></label>
                                <input required type="text" name="budgetItem" id="budgetItem"
                                    value="{{ old('budgetItem') }}"
                                    class="form-control @error('budgetItem') is-invalid @enderror" placeholder="Item" />
                                @error('budgetItem')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="item-error" class="text-danger" style="display:none;"></div>
                                <div id="item-warning" class="text-warning" style="display:none;"></div>
                            </div>



                            <div class="form-group col-md-12">
                                <label>Specifications</label>
                                {{-- <table class="table table-bordered" id="table"> --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <tr>
                                            <th>Specification</th>
                                            <th width="120px">Action</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="specification[]"
                                                    placeholder="Enter specification" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" name="add" id="add"
                                                    class="btn btn-success btn-sm">
                                                    <i class="glyphicon glyphicon-plus"></i> Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                        <i class="glyphicon glyphicon-plus-sign"></i> Add Item
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
            <div class="panel panel-default" style="border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                <div class="panel-heading"
                    style="background:#f5f5f5; border-bottom:1px solid #ddd; border-top-left-radius:10px; border-top-right-radius:10px;">
                    <h4 class="panel-title" style="margin:0; font-weight:bold;">List of Item</h4>
                </div>

                <div class="panel-body">
                    <hr style="margin-top:10px; margin-bottom:20px;" />

                    <div class="row">
                        <div class="form-group col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead style="background:#f0f0f0; font-weight:bold;">
                                        <tr>
                                            <th >SN</th>
                                            <th>Category</th>
                                            <th>Budget Item</th>
                                            <th>Specification</th>
                                            {{-- <th style="width:250px;">Specification</th> --}}
                                            <th>Store Item Category</th>
                                            <th colspan="10">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($getBudgetItem) && is_iterable($getBudgetItem))
                                            @foreach ($getBudgetItem as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->category }}</td>
                                                    <td>{{ $value->item }}</td>
                                                    {{-- <td>
                                                    @if (isset($value->specifications) && count($value->specifications) > 0)
                                                        <button type="button" class="btn btn-sm btn-info view-specs"
                                                            data-specs='@json($value->specifications)'
                                                            data-item="{{ $value->item }}">
                                                            <i class="glyphicon glyphicon-eye-open"></i>
                                                            View Specs ({{ count($value->specifications) }})
                                                        </button>
                                                    @else
                                                        <span class="text-muted">No specifications</span>
                                                    @endif
                                                </td> --}}

                                                    <td>
                                                        @if (isset($value->specifications) && count($value->specifications) > 0)
                                                            <div class="spec-container">
                                                                @foreach ($value->specifications as $spec)
                                                                    <span class="badge badge-secondary"
                                                                        style="cursor:pointer; display:inline-block;"
                                                                        data-specs='@json([$spec])'
                                                                        data-item="{{ $value->item }}">
                                                                        <i class="glyphicon glyphicon-eye-open"></i>
                                                                        {{ $spec->specification }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="text-muted">No specifications</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $value->storeItemCat }}</td>
                                                    <td>
                                                        <a href="javascript:;" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target=".viewEditRecord{{ $key }}">
                                                            <i class="glyphicon glyphicon-edit"></i> Edit
                                                        </a>
                                                    </td>
                                                    {{-- <td>
                                                <a href="javascript:;" title="Delete Record"
                                                    class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target=".deleteItem{{ $key }}">
                                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                                </a>
                                            </td> --}}
                                                </tr>

                                                <!-- Delete Modal -->
                                                <div class="modal fade deleteItem{{ $key }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteItem{{ $key }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Confirm Delete</h4>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                <p class="text-primary">Delete this record:
                                                                    <strong>{{ $value->item }}</strong>
                                                                </p>
                                                                <p class="text-danger">Are you sure you want to delete this
                                                                    record?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <a href="{{ route('deleteItem', ['iID' => base64_encode($value->itemID)]) }}"
                                                                    class="btn btn-danger">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Modal -->
                                                <form method="POST" action="{{ route('saveBudgetItem') }}">
                                                    @csrf
                                                    <div class="modal fade viewEditRecord{{ $key }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="viewEditRecord{{ $key }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Edit Record:
                                                                        {{ $value->item }}
                                                                    </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Category <span
                                                                                class="text-danger">*</span></label>
                                                                        <select name="category"
                                                                            class="form-control @error('category') is-invalid @enderror"
                                                                            required>
                                                                            <option value="">Select</option>
                                                                            @if (isset($getCategory) && $getCategory)
                                                                                @foreach ($getCategory as $cat)
                                                                                    <option value="{{ $cat->categoryID }}"
                                                                                        {{ $cat->categoryID == $value->categoryID ? 'selected' : '' }}>
                                                                                        {{ $cat->category }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                        @error('category')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label>Store Item Category <span
                                                                                class="text-danger">*</span></label>

                                                                        <select name="storeItemCatID"
                                                                            class="form-control @error('storeItemCatID') is-invalid @enderror"
                                                                            required>

                                                                            <option value="">Select</option>

                                                                            @foreach ($storeCategories ?? [] as $storeCat)
                                                                                <option value="{{ $storeCat->id }}"
                                                                                    {{ $storeCat->id == $value->storeItemCatID ? 'selected' : '' }}>
                                                                                    {{ $storeCat->storeItemCat }}
                                                                                </option>
                                                                            @endforeach

                                                                        </select>

                                                                        @error('storeItemCatID')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Item Name <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" name="budgetItem"
                                                                            value="{{ old('budgetItem', $value->item) }}"
                                                                            class="form-control @error('budgetItem') is-invalid @enderror"
                                                                            required>
                                                                        <input type="hidden" name="recordID"
                                                                            value="{{ $value->itemID }}">
                                                                        @error('budgetItem')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <!-- Rest of your specifications section remains the same -->
                                                                    <div class="form-group">
                                                                        <label>Specifications</label>
                                                                        <div
                                                                            class="specifications-container-{{ $key }}">
                                                                            @if (isset($value->specifications) && count($value->specifications) > 0)
                                                                                @foreach ($value->specifications as $specIndex => $spec)
                                                                                    <div class="input-group spec-row"
                                                                                        style="margin-bottom: 10px;">
                                                                                        <input type="text"
                                                                                            name="specification[]"
                                                                                            value="{{ $spec->specification }}"
                                                                                            class="form-control"
                                                                                            placeholder="Enter specification">
                                                                                        <input type="hidden"
                                                                                            name="specificationID[]"
                                                                                            value="{{ $spec->specificationID }}">
                                                                                        <span class="input-group-btn">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger remove-spec"
                                                                                                style="margin-left: 5px;">
                                                                                                <i
                                                                                                    class="glyphicon glyphicon-minus"></i>
                                                                                                Remove
                                                                                            </button>
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif

                                                                            <!-- Always have at least one empty row for new specifications -->
                                                                            <div class="input-group spec-row"
                                                                                style="margin-bottom: 10px;">
                                                                                <input type="text"
                                                                                    name="specification[]"
                                                                                    class="form-control"
                                                                                    placeholder="Enter new specification">
                                                                                <input type="hidden"
                                                                                    name="specificationID[]"
                                                                                    value="new">
                                                                                <span class="input-group-btn">
                                                                                    <button type="button"
                                                                                        class="btn btn-info add-more-spec"
                                                                                        style="margin-left: 5px;">
                                                                                        <i
                                                                                            class="glyphicon glyphicon-plus"></i>
                                                                                        Add More
                                                                                    </button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-info">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div>
        </div>
    </div>

    <!-- Specification View Modal -->
    {{-- <div class="modal fade" id="specificationModal" tabindex="-1" role="dialog"
        aria-labelledby="specificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="specificationModalLabel">Specifications</h4>
                </div>
                <div class="modal-body" id="specificationContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

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

        .spec-row {
            transition: all 0.3s ease;
        }

        .spec-row:hover {
            background-color: #f9f9f9;
        }

        .view-specs {
            white-space: nowrap;
        }

        @media (min-width: 992px) {
            .modal-lg {
                width: 80%;
            }
        }

        .list-group-item {
            padding: 12px 15px;
            border: 1px solid #ddd;
            margin-bottom: -1px;
            background-color: #fff;
        }

        .list-group-item:first-child {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .list-group-item:last-child {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .duplicate-warning {
            border-color: #ffc107 !important;
            box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }

        .duplicate-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
        }

        .table {
            width: 100%;
        }

        .table th,
        .table td {
            vertical-align: top;
            word-break: break-word;
        }


        @media (max-width: 768px) {

            .panel-body {
                padding: 10px;
            }

            .btn {
                margin-bottom: 5px;
            }

            .badge {
                font-size: 10px;
            }

            .table th,
            .table td {
                font-size: 12px;
            }
        }

        .spec-container {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .spec-container .badge {
            white-space: normal;
            word-break: break-word;
        }

        .badge {
            display: inline-block;
            max-width: 220px;
            white-space: normal;
            word-break: break-word;
        }

        .badge {
            /* max-width: 250px; */
            white-space: normal;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/table2excel.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    @if (session('warning'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: '{{ session('warning') }}',
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

    <script>
        $(document).ready(function() {
            // Variable to track specification rows in add form
            var i = 0;

            // Add more specification fields in add form
            $('#add').click(function() {
                ++i;
                $('#table').append(
                    `<tr>
                        <td>
                            <input type="text" name="specification[]" placeholder="Enter specification" class="form-control" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-table-row">
                                <i class="glyphicon glyphicon-remove"></i> Remove
                            </button>
                        </td>
                    </tr>`);
            });

            $(document).on('click', '.remove-table-row', function() {
                $(this).parents('tr').remove();
            });

            // Format Amount while typing
            $("#formatAmountOnKeyPress").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });

            (function($, undefined) {
                "use strict";
                $(function() {
                    var $form = $(".formFormatAmount");
                    var $input = $form.find(".format-amount");
                    $input.on("keyup", function(event) {
                        var selection = window.getSelection().toString();
                        if (selection !== '') {
                            return;
                        }
                        if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                            return;
                        }
                        var $this = $(this);
                        var input = $this.val();
                        var input = input.replace(/[\D\s\._\-]+/g, "");
                        input = input ? parseInt(input, 10) : 0;
                        $this.val(function() {
                            return (input === 0) ? "" : input.toLocaleString("en-US");
                        });
                    });
                });
            })(jQuery);

            // Handle view specifications button click
            $('.view-specs').click(function(e) {
                e.preventDefault();

                var specs = $(this).data('specs');
                var itemName = $(this).data('item');

                if (!specs || specs.length === 0) {
                    Swal.fire({
                        title: 'Specifications for ' + itemName,
                        text: 'No specifications available for this item.',
                        icon: 'info',
                        confirmButtonText: 'Close'
                    });
                    return;
                }

                var content = '<div class="list-group" style="max-height: 400px; overflow-y: auto;">';

                specs.forEach(function(spec, index) {
                    if (spec && spec.specification) {
                        content += '<div class="list-group-item">' +
                            '<strong>' + (index + 1) + '.</strong> ' +
                            spec.specification +
                            '</div>';
                    }
                });
                content += '</div>';

                Swal.fire({
                    title: 'Specifications for ' + itemName,
                    html: content,
                    icon: 'info',
                    confirmButtonText: 'Close',
                    width: '600px',
                    padding: '20px',
                    customClass: {
                        popup: 'swal-popup'
                    }
                });
            });

            // Add more specification fields in edit modal
            $(document).on('click', '.add-more-spec', function() {
                var $container = $(this).closest('[class^="specifications-container-"]');

                var newField = `
                    <div class="input-group spec-row" style="margin-bottom: 10px;">
                        <input type="text" name="specification[]" class="form-control" placeholder="Enter new specification">
                        <input type="hidden" name="specificationID[]" value="new">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger remove-spec" style="margin-left: 5px;">
                                <i class="glyphicon glyphicon-minus"></i> Remove
                            </button>
                        </span>
                    </div>
                `;

                // Insert before the last row (which contains the Add More button)
                $(this).closest('.spec-row').before(newField);
            });

            // Remove specification field
            $(document).on('click', '.remove-spec', function() {
                var $row = $(this).closest('.spec-row');
                var $container = $row.closest('[class^="specifications-container-"]');
                var $allRows = $container.find('.spec-row');

                // Count only rows with remove buttons (excluding the one with Add More button)
                var $removableRows = $allRows.filter(function() {
                    return $(this).find('.remove-spec').length > 0 && !$(this).find(
                        '.add-more-spec').length;
                });

                // If this is the last removable row, just clear the input instead of removing
                if ($removableRows.length === 1) {
                    $row.find('input[type="text"]').val('');
                    Swal.fire({
                        title: 'Notice',
                        text: 'You must have at least one specification field. The input has been cleared.',
                        icon: 'info',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    $row.remove();
                }
            });

            // DUPLICATE CHECKING FUNCTIONALITY
            var duplicateCheckTimer;

            function checkDuplicate() {
                var itemName = $('#budgetItem').val();
                var categoryId = $('#category').val();
                var recordId = $('input[name="recordID"]').val(); // For edit mode

                // Clear previous messages
                $('#item-error').hide().empty();
                $('#item-warning').hide().empty();
                $('#budgetItem').removeClass('duplicate-error duplicate-warning');
                $('#category').removeClass('duplicate-error duplicate-warning');

                // Only check for new items (no record ID)
                if (itemName.length >= 2 && categoryId && !recordId) {
                    $.ajax({
                        url: '{{ route('checkDuplicateItem') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            item: itemName,
                            category: categoryId
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Exact duplicate in same category - block submission
                                $('#item-error').html('❌ Item "' + itemName +
                                    '" already exists in this category!').show();
                                $('#budgetItem').addClass('duplicate-error');
                                $('#category').addClass('duplicate-error');
                                $('#submitBtn').prop('disabled', true);
                            } else if (response.exists_in_other) {
                                // Item exists in another category - warning only
                                $('#item-warning').html('⚠️ Item "' + itemName +
                                        '" exists in another category. You can still create it here.')
                                    .show();
                                $('#budgetItem').addClass('duplicate-warning');
                                $('#submitBtn').prop('disabled', false);
                            } else {
                                // No duplicate - enable submission
                                $('#submitBtn').prop('disabled', false);
                            }
                        },
                        error: function() {
                            console.log('Duplicate check failed');
                        }
                    });
                } else {
                    $('#submitBtn').prop('disabled', false);
                }
            }

            // Trigger duplicate check on input change with debounce
            $('#budgetItem, #category').on('input change', function() {
                clearTimeout(duplicateCheckTimer);
                duplicateCheckTimer = setTimeout(checkDuplicate, 500);
            });

            // Prevent form submission if duplicate exists
            $('#createItemForm').submit(function(e) {
                if ($('#submitBtn').prop('disabled')) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Cannot Add Item',
                        text: 'This item already exists in the selected category. Please use a different name or category.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Debug: Log form submission data
            $('form[action*="saveBudgetItem"]').submit(function(e) {
                console.log('Form submitted to saveBudgetItem');
                console.log('Record ID:', $('input[name="recordID"]').val());
                console.log('Category:', $('select[name="category"]').val());
                console.log('Item:', $('input[name="budgetItem"]').val());

                var specs = [];
                var specIds = [];

                $('input[name="specification[]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        specs.push($(this).val());
                    }
                });

                $('input[name="specificationID[]"]').each(function() {
                    specIds.push($(this).val());
                });

                console.log('Specifications:', specs);
                console.log('Specification IDs:', specIds);
            });
        });
    </script>
@endsection
