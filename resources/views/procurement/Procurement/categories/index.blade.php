@extends('layouts_procurement.app')

@section('pageTitle')
    {{ strtoupper('Manage Contractor Categories') }}
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

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('categories.store') }}" id="categoryForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Categories <span class="text-danger">*</span></label>
                            <table class="table table-bordered" id="category-table">
                                <tr>
                                    <th>Category Name</th>
                                    <th width="120px">Action</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" 
                                               name="categories[]" 
                                               class="form-control category-input" 
                                               placeholder="Enter category name"
                                               data-row="1">
                                        <div class="text-danger category-error" id="error-1" style="display:none;"></div>
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add"
                                                class="btn btn-success btn-sm">
                                            <i class="glyphicon glyphicon-plus"></i> Add More
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-warning" id="duplicate-warning" style="display:none;"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                <i class="glyphicon glyphicon-plus-sign"></i> Add Categories
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
                <h4 class="panel-title" style="margin:0; font-weight:bold;">List of Contractor Categories</h4>
            </div>

            <div class="panel-body">
                <hr style="margin-top:10px; margin-bottom:20px;" />

                <div class="row">
                    <div class="form-group mb-0 col-md-12">
                        <table class="table table-hover table-bordered table-responsive">
                            <thead style="background:#f0f0f0; font-weight:bold;">
                                <tr>
                                    <th>SN</th>
                                    <th>Category Name</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($categories) && $categories->count() > 0)
                                    @foreach ($categories as $key => $value)
                                        <tr>
                                            <td>{{ $categories->firstItem() + $key }}</td>
                                            <td>{{ $value->category }}</td>
                                            <td>
                                                <a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target=".viewEditRecord{{ $key }}">
                                                    <i class="glyphicon glyphicon-edit"></i> Edit
                                                </a>
                                            </td>
                                            <td>
                                                <a href="javascript:;" title="Delete Record"
                                                    class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target=".deleteCategory{{ $key }}">
                                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade deleteCategory{{ $key }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteCategory{{ $key }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Confirm Delete</h4>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <p class="text-primary">Delete this record:
                                                            <strong>{{ $value->category }}</strong>
                                                        </p>
                                                        <p class="text-danger">Are you sure you want to delete this
                                                            record?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Cancel</button>
                                                        <a href="{{ route('categories.destroy', $value->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <form method="POST" action="{{ route('categories.update', $value->id) }}">
                                            @csrf
                                            <div class="modal fade viewEditRecord{{ $key }}" tabindex="-1"
                                                role="dialog" aria-labelledby="viewEditRecord{{ $key }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Edit Category: {{ $value->category }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Category Name <span class="text-danger">*</span></label>
                                                                <input type="text" name="category"
                                                                    value="{{ old('category', $value->category) }}"
                                                                    class="form-control @error('category') is-invalid @enderror" 
                                                                    placeholder="Enter category name"
                                                                    required>
                                                                @error('category')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
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
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No categories found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div class="text-center">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel -->
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
        .category-row {
            transition: all 0.3s ease;
        }
        .category-row:hover {
            background-color: #f9f9f9;
        }
        .duplicate-warning {
            border-color: #ffc107 !important;
            box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
        }
        .duplicate-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
        }
        .pagination {
            margin: 0;
        }
        .pagination > li > a,
        .pagination > li > span {
            padding: 5px 10px;
        }
    </style>
@endsection

@section('scripts')
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
            // Variable to track category rows
            var rowCount = 1;
            
            // Add more category fields
            $('#add').click(function() {
                rowCount++;
                $('#category-table').append(
                    `<tr class="category-row">
                        <td>
                            <input type="text" name="categories[]" 
                                   class="form-control category-input" 
                                   placeholder="Enter category name"
                                   data-row="${rowCount}">
                            <div class="text-danger category-error" id="error-${rowCount}" style="display:none;"></div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-table-row">
                                <i class="glyphicon glyphicon-remove"></i> Remove
                            </button>
                        </td>
                    </tr>`);
            });

            // Remove category row
            $(document).on('click', '.remove-table-row', function() {
                // Don't remove if it's the last row
                if ($('#category-table tr').length > 2) { // 2 because of header + first row
                    $(this).parents('tr').remove();
                    updateRowNumbers();
                } else {
                    Swal.fire({
                        title: 'Cannot Remove',
                        text: 'You must have at least one category field.',
                        icon: 'warning',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });

            // Function to update row numbers (not needed for functionality, but for reference)
            function updateRowNumbers() {
                // This function can be empty or used for any row-specific logic
            }

            // DUPLICATE CHECKING FUNCTIONALITY
            var duplicateCheckTimer;
            
            function checkDuplicate(input, rowNum) {
                var categoryName = $(input).val();
                var $errorDiv = $('#error-' + rowNum);
                var $warningDiv = $('#duplicate-warning');
                
                // Clear previous messages for this row
                $errorDiv.hide().empty();
                $(input).removeClass('duplicate-error duplicate-warning');
                
                if (categoryName.length >= 2) {
                    $.ajax({
                        url: '{{ route("categories.checkDuplicate") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            category: categoryName
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Category already exists - show error
                                $errorDiv.html('❌ Category "' + categoryName + '" already exists!').show();
                                $(input).addClass('duplicate-error');
                                $('#submitBtn').prop('disabled', true);
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
            $(document).on('input', '.category-input', function() {
                var rowNum = $(this).data('row');
                var $this = $(this);
                
                clearTimeout(duplicateCheckTimer);
                duplicateCheckTimer = setTimeout(function() {
                    checkDuplicate($this, rowNum);
                }, 500);
            });
            
            // Prevent form submission if duplicate exists
            $('#categoryForm').submit(function(e) {
                var hasError = false;
                
                $('.category-input').each(function() {
                    if ($(this).hasClass('duplicate-error')) {
                        hasError = true;
                    }
                });
                
                if (hasError) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Cannot Add Categories',
                        text: 'Some categories already exist. Please remove or use different names.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    // Check if any fields are empty
                    var emptyFields = 0;
                    $('.category-input').each(function() {
                        if ($(this).val().trim() === '') {
                            emptyFields++;
                        }
                    });
                    
                    if (emptyFields > 0) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Empty Fields',
                            text: 'Please fill in all category fields or remove empty rows.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });

            // Debug: Log form submission data
            $('#categoryForm').submit(function(e) {
                console.log('Form submitted to add categories');
                
                var categories = [];
                $('input[name="categories[]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        categories.push($(this).val());
                    }
                });
                
                console.log('Categories to add:', categories);
            });
        });
    </script>
@endsection