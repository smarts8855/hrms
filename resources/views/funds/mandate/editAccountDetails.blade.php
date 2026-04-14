@extends('layouts.layout')

@section('pageTitle')
    Edit Account Details
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

        <!-- Edit Account Form -->


        <div class="row mb-4">
            <div class="col-md-12">
                <div class="panel panel-primary">

                    <!-- Panel Header -->
                    <div class="panel-heading">
                        <h3 class="panel-title text-uppercase">
                            <i class="fa fa-edit"></i> Edit Account Details
                        </h3>
                    </div>

                    <!-- Panel Body -->
                    <div class="panel-body">
                        <form method="post" action="{{ url('/update/account/' . $account->id) }}" id="editAccountForm">
                            {{ csrf_field() }}

                            <div class="row">
                                <!-- Bank -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bank" class="control-label">Bank <span
                                                class="text-danger">*</span></label>
                                        <select name="bank" id="bank" class="form-control select2" required>
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $list)
                                                <option value="{{ $list->bankID }}"
                                                    {{ $account->bankId == $list->bankID ? 'selected' : '' }}>
                                                    {{ $list->bank }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="help-block">Multiple banks can be active</small>
                                    </div>
                                </div>

                                <!-- Account Number -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="accountNo" class="control-label">Account Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="accountNo" id="accountNo" class="form-control"
                                            placeholder="Enter account number" value="{{ $account->account_no }}" required>
                                        <small class="help-block">Bank + Account Number must be unique</small>
                                    </div>
                                </div>

                                <!-- Contract Type -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contractTypeID" class="control-label">Contract Type <span
                                                class="text-danger">*</span></label>
                                        <select name="contractTypeID" id="contractTypeID" class="form-control select2"
                                            required>
                                            <option value="">Select Contract Type</option>
                                            @foreach ($contracttypes as $list)
                                                <option value="{{ $list->ID }}"
                                                    {{ $account->contractTypeID == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->contractType }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="help-block">Multiple contract types can be active</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address" class="control-label">Address <span
                                                class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" id="address" rows="6" placeholder="Enter full address" required>{{ $account->address }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ url('/account/details') }}" class="btn btn-default btn-lg">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg" id="updateBtn">
                                        <i class="fa fa-save"></i> Update Account
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
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
            min-height: 150px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .address-textarea:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .address-textarea::placeholder {
            color: #6c757d;
            opacity: 0.7;
        }

        /* Update Account button styling */
        .btn-success.btn-lg {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
        }

        .btn-secondary.btn-lg {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(108, 117, 125, 0.2);
        }

        .btn-success.btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-secondary.btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(108, 117, 125, 0.3);
        }

        .btn-success.btn-lg:active,
        .btn-secondary.btn-lg:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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

            .btn-secondary.btn-lg {
                margin-bottom: 10px;
            }

            /* On mobile, fields should take full width */
            .form-control,
            .address-textarea {
                width: 100% !important;
            }

            /* Center align buttons on mobile */
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

            /* Smaller textarea on mobile */
            .address-textarea {
                height: 120px;
                font-size: 14px;
            }
        }

        /* For desktop: calculate exact width to match three fields */
        @media (min-width: 768px) {
            .address-textarea {
                width: 100%;
                margin: 0;
            }

            /* Ensure save button has proper spacing */
            .form-group.text-right {
                padding-right: 15px;
            }
        }
    </style>
@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

            // Real-time validation for bank + account number uniqueness (excluding current record)
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
                const recordId = {{ $account->id }};

                if (bankId && accountNo) {
                    $.ajax({
                        url: '/check-bank-account-unique-edit',
                        type: 'POST',
                        data: {
                            bankId: bankId,
                            accountNo: accountNo,
                            recordId: recordId,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.exists) {
                                $('#accountNo').addClass('is-invalid');
                                $('#accountNo').after(
                                    '<div class="invalid-feedback">This bank account number already exists with another record!</div>'
                                );
                            } else {
                                $('#accountNo').removeClass('is-invalid');
                                $('#accountNo').next('.invalid-feedback').remove();
                            }
                        },
                        error: function() {
                            // Silently fail - validation will happen on server side too
                        }
                    });
                }
            }

            // Handle form submission with validation
            $('#editAccountForm').on('submit', function(e) {
                const updateBtn = $('#updateBtn');
                const btnIcon = updateBtn.find('i');
                const btnText = updateBtn.find('span:not(.sr-only)');
                const originalIcon = btnIcon.attr('class');
                const originalText = btnText.text();

                // Show loading state
                btnIcon.removeClass().addClass('fas fa-spinner fa-spin');
                btnText.text('Updating...');
                updateBtn.prop('disabled', true);

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
                    updateBtn.prop('disabled', false);
                    return false;
                }

                // If all validations pass, form will submit normally
                return true;
            });

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

            // Auto-resize textarea based on content
            function autoResizeTextarea(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            }

            // Apply auto-resize to address textarea
            const addressTextarea = document.getElementById('address');
            if (addressTextarea) {
                addressTextarea.addEventListener('input', function() {
                    autoResizeTextarea(this);
                });

                // Initial resize
                autoResizeTextarea(addressTextarea);
            }

            // Notification function for AJAX actions
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
        });
    </script>
@endsection
