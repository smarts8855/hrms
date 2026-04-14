@extends('layouts.layout')

@section('pageTitle')
    All Account Details
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Alert Messages -->
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show permanent-alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fas fa-exclamation-circle"></i> Error!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('msg'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show permanent-alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fas fa-check-circle"></i> Success!</strong>
                        {{ session('msg') }}
                    </div>
                </div>
            </div>
        @endif

        @if (session('err'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible fade show permanent-alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><i class="fas fa-exclamation-triangle"></i> Operation Error!</strong>
                        {{ session('err') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Add Account Form -->
        <div class="row" style="margin-bottom:20px;">
            <div class="col-md-12">
                <div class="panel panel-primary">

                    <!-- Header -->
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-plus-circle"></i> Add New Account
                        </h3>
                    </div>

                    <!-- Body -->
                    <div class="panel-body">

                        <form method="post" action="{{ url('/account/details') }}" id="accountForm">
                            {{ csrf_field() }}

                            <div class="row">
                                <!-- Bank -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Bank <span class="text-danger">*</span></strong></label>
                                        <select name="bank" id="bank" class="form-control select2" required>
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $list)
                                                <option value="{{ $list->bankID }}"
                                                    {{ old('bank') == $list->bankID ? 'selected' : '' }}>
                                                    {{ $list->bank }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="help-block">Multiple banks can be active</p>
                                    </div>
                                </div>

                                <!-- Account Number -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Account Number <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="accountNo" id="accountNo" class="form-control"
                                            placeholder="Enter account number" value="{{ old('accountNo') }}" required>
                                        <p class="help-block">Bank + Account Number must be unique</p>
                                    </div>
                                </div>

                                <!-- Contract Type -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Contract Type <span class="text-danger">*</span></strong></label>
                                        <select name="contractTypeID" id="contractTypeID" class="form-control select2"
                                            required>
                                            <option value="">Select Contract Type</option>
                                            @foreach ($contracttypes as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ old('contractTypeID') == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->contractType }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="help-block">Multiple contract types can be active</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Address <span class="text-danger">*</span></strong></label>
                                        <textarea name="address" id="address" class="form-control" rows="4" required>{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row" style="margin-top:20px;">
                                <div class="col-md-12 text-right">
                                    <button type="submit" id="saveBtn" class="btn btn-success btn-lg">
                                        <i class="fa fa-save"></i> Save Account
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <!-- Account List Table -->
        <div class="row">
            <div class="col-md-12">

                <!-- Bootstrap 3 Panel -->
                <div class="panel panel-info">

                    <!-- Panel Header -->
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-list"></i> All Account Details
                        </h3>
                    </div>

                    <!-- Panel Body -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="accountsTable">
                                <thead style="background:#f2f2f2; color:#333;">
                                    <tr>
                                        <th width="5%">SN</th>
                                        <th width="15%">Bank</th>
                                        <th width="15%">Account Number</th>
                                        <th width="15%">Contract Type</th>
                                        <th width="25%">Address</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $list)
                                        <tr class="{{ $list->status == 1 ? 'success' : 'danger' }}"
                                            id="row-{{ $list->id }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $list->bank }}</td>
                                            <td><code>{{ $list->account_no }}</code></td>
                                            <td>{{ $list->contractType }}</td>
                                            <td>{!! $list->address !!}</td>

                                            <!-- Status -->
                                            <td class="text-center">
                                                @if ($list->status == 1)
                                                    <span class="label label-success"
                                                        id="status-badge-{{ $list->id }}">
                                                        <i class="fa fa-check-circle"></i> Active
                                                    </span>
                                                @else
                                                    <span class="label label-danger"
                                                        id="status-badge-{{ $list->id }}">
                                                        <i class="fa fa-times-circle"></i> Inactive
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ url('/edit/account/' . $list->id) }}"
                                                        class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                        title="Edit Account">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    @if ($list->status == 1)
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm toggle-status-btn"
                                                            data-id="{{ $list->id }}" data-action="deactivate"
                                                            data-toggle="tooltip"
                                                            title="Click to deactivate this account">
                                                            <i class="fa fa-ban"></i> Deactivate
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-success btn-sm toggle-status-btn"
                                                            data-id="{{ $list->id }}" data-action="activate"
                                                            data-toggle="tooltip" title="Click to activate this account">
                                                            <i class="fa fa-check"></i> Activate
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Panel Footer for Empty List -->
                    @if ($accounts->isEmpty())
                        <div class="panel-footer text-center">
                            <div class="alert alert-info" style="margin:0;">
                                <i class="fa fa-info-circle"></i> No accounts found. Add your first account above.
                            </div>
                        </div>
                    @endif

                </div><!-- End Panel -->

            </div>
        </div>



    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1rem;
            border: none;
        }

        .card-header {
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .badge-pill {
            min-width: 80px;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }

        /* Address textarea with exact width matching the three fields above */
        .address-textarea {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            resize: vertical;
            /* Allow vertical resizing only */
        }

        /* Save Account button styling */
        .btn-success.btn-lg {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
        }

        .btn-success.btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-success.btn-lg:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
        }

        /* Button spacing */
        .btn-sm i {
            margin-right: 5px;
        }

        /* Alert styling - Make sure alerts are visible and permanent */
        .alert.permanent-alert {
            margin-top: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-out;
            padding: 16px 20px;
            position: relative;
            overflow: hidden;
            opacity: 1 !important;
            display: block !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .alert .close {
            padding: 0.75rem 1.25rem;
            color: inherit;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .alert .close:hover {
            opacity: 1;
        }

        /* Help text styling */
        .form-text.text-muted {
            font-size: 12px;
            margin-top: 5px;
        }

        /* Tooltip styling */
        .tooltip-inner {
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 12px;
            max-width: 200px;
        }

        .tooltip.bs-tooltip-top .arrow::before {
            border-top-color: #333;
        }

        .tooltip.bs-tooltip-bottom .arrow::before {
            border-bottom-color: #333;
        }

        .tooltip.bs-tooltip-left .arrow::before {
            border-left-color: #333;
        }

        .tooltip.bs-tooltip-right .arrow::before {
            border-right-color: #333;
        }

        /* Form alignment */
        .form-group.text-right {
            padding-right: 15px;
        }

        /* Validation error styling */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        /* For mobile view: ensure proper spacing */
        @media (max-width: 768px) {

            .col-md-4,
            .col-md-12 {
                width: 100%;
                margin-bottom: 1rem;
                padding-left: 0;
                padding-right: 0;
            }

            .card-header h3 {
                font-size: 1.2rem;
            }

            .btn-lg {
                padding: 10px 20px !important;
                font-size: 14px !important;
                width: 100%;
                margin-top: 10px;
            }

            .table-responsive {
                border: none;
            }

            .btn-group .btn {
                margin: 1px;
                padding: 0.25rem 0.5rem;
                font-size: 11px;
            }

            /* On mobile, show icon only to save space */
            .btn-sm i {
                margin-right: 0;
            }

            .btn-sm span:not(.sr-only) {
                display: none;
            }

            .btn-sm[data-toggle="tooltip"]:hover::after {
                content: attr(title);
                position: absolute;
                background: #333;
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1000;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
            }

            /* On mobile, fields should take full width */
            .form-control,
            .address-textarea {
                width: 100% !important;
            }

            /* Center align save button on mobile */
            .form-group.text-right {
                text-align: center !important;
                padding-right: 0;
            }

            /* Alerts on mobile */
            .alert.permanent-alert {
                margin: 10px;
                font-size: 14px;
                padding: 12px 16px;
            }
        }

        /* For desktop: calculate exact width to match three fields */
        @media (min-width: 768px) {
            .address-textarea {
                width: 100%;
                margin: 0;
            }

            .btn-sm {
                min-width: 90px;
            }

            /* Ensure save button has proper spacing */
            .form-group.text-right {
                padding-right: 15px;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Disable Bootstrap's default alert auto-dismiss completely
            $.fn.alert.Constructor.prototype.close = function(e) {
                // Only close if triggered by close button click
                if (e && $(e.target).hasClass('close')) {
                    var $element = $(this);
                    $element.removeClass('show');

                    if ($element.hasClass('fade')) {
                        $element.fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        $element.remove();
                    }

                    $element.trigger('closed.bs.alert');
                }
                return this;
            };

            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });

            // Initialize tooltips with custom options
            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover', // Show on hover
                placement: 'top', // Position above the button
                delay: {
                    show: 500,
                    hide: 100
                } // Slight delay for showing
            });

            // Real-time validation for bank + account number uniqueness
            let checkTimeout;
            $('#bank, #accountNo').on('input', function() {
                clearTimeout(checkTimeout);
                checkTimeout = setTimeout(function() {
                    checkBankAccountUniqueness();
                }, 500);
            });

            function checkBankAccountUniqueness() {
                const bankId = $('#bank').val();
                const accountNo = $('#accountNo').val().trim();

                if (bankId && accountNo) {
                    $.ajax({
                        url: '/check-bank-account-unique',
                        type: 'POST',
                        data: {
                            bankId: bankId,
                            accountNo: accountNo,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.exists) {
                                $('#accountNo').addClass('is-invalid');
                                $('#accountNo').after(
                                    '<div class="invalid-feedback">This bank account number already exists!</div>'
                                );
                            } else {
                                $('#accountNo').removeClass('is-invalid');
                                $('#accountNo').next('.invalid-feedback').remove();
                            }
                        }
                    });
                }
            }

            // Handle form submission with validation
            $('#accountForm').on('submit', function(e) {
                const saveBtn = $('#saveBtn');
                const btnIcon = saveBtn.find('i');
                const btnText = saveBtn.find('span:not(.sr-only)');
                const originalIcon = btnIcon.attr('class');
                const originalText = btnText.text();

                // Show loading state
                btnIcon.removeClass().addClass('fas fa-spinner fa-spin');
                btnText.text('Saving...');
                saveBtn.prop('disabled', true);

                // Remove any previous validation messages
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Validate required fields
                let isValid = true;
                const requiredFields = ['#bank', '#accountNo', '#contractTypeID', '#address'];

                requiredFields.forEach(field => {
                    const $field = $(field);
                    if (!$field.val().trim()) {
                        $field.addClass('is-invalid');
                        $field.after('<div class="invalid-feedback">This field is required.</div>');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    // Scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);

                    // Restore button state
                    btnIcon.removeClass().addClass(originalIcon);
                    btnText.text(originalText);
                    saveBtn.prop('disabled', false);
                    return false;
                }

                // If all validations pass, form will submit normally
                return true;
            });

            // Handle toggle status button clicks - SIMPLIFIED
            $('.toggle-status-btn').on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const id = button.data('id');
                const action = button.data('action');
                const status = action === 'activate' ? 1 : 0;
                const buttonIcon = button.find('i');
                const buttonText = button.find('span:not(.sr-only)');
                const originalIcon = buttonIcon.attr('class');
                const originalText = buttonText.text();

                // Change button appearance to show loading state
                buttonIcon.removeClass().addClass('fas fa-spinner fa-spin');
                buttonText.text('Processing...');
                button.prop('disabled', true);

                // Hide tooltip during processing
                button.tooltip('hide');

                // Show confirmation dialog with clearer message
                const confirmMessage = action === 'activate' ?
                    'Are you sure you want to ACTIVATE this account?\n\nMultiple accounts can be active at the same time.' :
                    'Are you sure you want to DEACTIVATE this account?';

                if (!confirm(confirmMessage)) {
                    // Restore original button state
                    buttonIcon.removeClass().addClass(originalIcon);
                    buttonText.text(originalText);
                    button.prop('disabled', false);
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: '/toggle/account/status/' + id,
                    type: 'POST',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success notification
                            showNotification(
                                action === 'activate' ?
                                '✅ Account activated successfully!' :
                                '⚠️ Account deactivated successfully!',
                                'success'
                            );

                            // Reload the page to get fresh data
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showNotification(response.message ||
                                'Error updating account status', 'danger');
                            // Restore original button state
                            buttonIcon.removeClass().addClass(originalIcon);
                            buttonText.text(originalText);
                            button.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An error occurred while updating account status';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                            .errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join(
                                '\n');
                        }

                        showNotification(errorMessage, 'danger');
                        // Restore original button state
                        buttonIcon.removeClass().addClass(originalIcon);
                        buttonText.text(originalText);
                        button.prop('disabled', false);
                    }
                });
            });

            // Notification function for AJAX actions - also permanent
            function showNotification(message, type) {
                // Remove existing AJAX notifications
                $('.custom-alert').remove();

                // Create notification
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

                const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show custom-alert permanent-alert"
                 role="alert"
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong><i class="fas ${iconClass}"></i></strong> ${message}
            </div>
        `;

                $('body').append(alertHtml);

                // Initialize close button for the new alert
                $('.custom-alert .close').on('click', function() {
                    $(this).closest('.alert').fadeOut(300, function() {
                        $(this).remove();
                    });
                });
            }

            // Clear form validation on field change
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });

            // Optional: Dynamically adjust textarea width to match the three fields
            function adjustTextareaWidth() {
                if ($(window).width() >= 768) {
                    // Calculate the width of three col-md-4 fields including their gutters
                    const containerWidth = $('.card-body').width();
                    // Each col-md-4 is 33.333% of the container
                    // But they have 15px padding on left and right (except first and last)
                    const threeFieldsWidth = containerWidth - 30; // Account for the gutters between fields
                    $('.address-textarea').width(threeFieldsWidth);
                }
            }

            // Adjust on load and resize
            $(window).on('load resize', adjustTextareaWidth);

            // Mobile-specific tooltip enhancement
            if ($(window).width() <= 768) {
                // On mobile, add touch event for better tooltip experience
                $('[data-toggle="tooltip"]').on('touchstart', function() {
                    $(this).tooltip('show');
                    setTimeout(() => {
                        $(this).tooltip('hide');
                    }, 3000);
                });
            }
        });
    </script>
@endsection
