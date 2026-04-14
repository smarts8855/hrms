@extends('layouts_procurement.app')
@section('pageTitle', 'Contractor Details')
@section('content')


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-uppercase"><b>Contractor Details</b></h3>
        </div>

        <div class="panel-body">

            <div class="text-right" style="margin-bottom: 10px;">
                All fields with <span class="text-danger">*</span> are required.
            </div>

            <form id="contractor_form" class="custom-validation" method="POST"
                action="{{ route('postContractorRegistration') }}" enctype="multipart/form-data">

                @csrf

                <!-- Row 1 -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="contractorName" value="{{ old('contractorName') }}" required
                                class="form-control" placeholder="Company Name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            @php
                                $selectedCategories = old('contractCategory', []);
                            @endphp

                            <div class="form-group">
                                <label for="contractCategory">
                                    Select Contract Categories <span class="text-danger">*</span>
                                </label>

                                <select name="contractCategory[]" id="contractCategory" class="form-control" multiple>
                                    @foreach ($contractCategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array((string) $category->id, array_map('strval', $selectedCategories)) ? 'selected' : '' }}>
                                            {{ $category->category }}
                                        </option>
                                    @endforeach
                                </select>

                                <small class="text-danger font-weight-bold mt-2">
                                    You can select multiple contract categories.
                                </small>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State</label>
                            <select name="currentState" class="form-control">
                                <option value="">Select</option>
                                @if (isset($getState))
                                    @foreach ($getState as $item)
                                        @foreach ($getState as $item)
                                            <option value="{{ $item->stateID }}"
                                                {{ old('currentState') == $item->stateID ? 'selected' : '' }}>
                                                {{ $item->state_name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="form-control"
                                placeholder="City">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>TIN Number <span class="text-danger">*</span></label>
                            <input type="text" required name="tinNumber" value="{{ old('tinNumber') }}"
                                class="form-control" placeholder="TIN Number">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" required name="phoneNumber" value="{{ old('phoneNumber') }}"
                                class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="email" required name="emailAddress" value="{{ old('emailAddress') }}"
                                class="form-control" placeholder="Email Address">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact Person <span class="text-danger">*</span></label>
                            <input type="text" required name="contactPerson" value="{{ old('contactPerson') }}"
                                class="form-control" placeholder="Contact Person">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" class="form-control" id="name" name="accountNumber" placeholder=""
                                value="{{ old('accountNumber') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bank</label>
                            <select class="form-control" id="bank" name="bank">
                                <option value="">-select Bank-</option>
                                @foreach ($bankList as $list)
                                    <option value="{{ $list->bankID }}"
                                        {{ old('bank') == $list->bankID ? 'selected' : '' }}>
                                        {{ $list->bank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sort Code</label>
                            <input type="text" class="form-control" id="name" name="sortcode"
                                value="{{ old('sortcode') }}" placeholder="Optional">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="1" placeholder="Address">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    @if (isset($requiredDocs) && $requiredDocs->count() > 0)
                        <div class="col-md-12">
                            <hr>
                            <h4>Upload Documents (Optional)</h4>
                        </div>

                        <div class="col-md-12">
                            <div id="document_wrapper">

                                <div class="row document_row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Document Type</label>
                                            <select name="document_type[]"
                                                class="form-control text-uppercase document_type">
                                                <option value="">Select Document</option>
                                                @foreach ($requiredDocs as $doc)
                                                    <option value="{{ $doc->id }}">
                                                        [{{ $doc->doc_type }}] {{ $doc->bid_doc_description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Upload File</label>
                                            <input type="file" name="document[]" class="form-control file_input"
                                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-success add_more form-control"
                                                    style="background-color: green; text-white" disabled>
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="hidden" name="recordID"
                                value="{{ isset($editRecord) ? $editRecord->contractor_registrationID : '' }}">

                            @if (isset($editRecord))
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('cancelEditContractor') }}" style="margin: 5px;"
                                            class="btn btn-danger form-control">Cancel
                                            Edit</a>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success form-control"
                                            style="margin: 5px;">Update Now</button>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="reset" id="click_reset" class="btn btn-danger form-control"
                                            style="margin: 5px;">Clear
                                            All</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success form-control"
                                            style="margin: 5px;">Save</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Contractor List</b></h3>
        </div>

        <div class="panel-body">

            <div class="row">
                <div class="col-md-6"></div>

                <div class="col-md-6 text-right">
                    <h4 style="font-size: 13px;">
                        <a href="{{ url('contractor-report') }}" class="btn btn-info btn-sm"
                            style="margin-bottom: 10px;">
                            <i class="fa fa-eye"></i> View All Contractors
                        </a>

                    </h4>
                </div>
            </div>

            <hr>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>TIN</th>
                            <th>Phone</th>
                            <th>Contact Person</th>
                            <th>Documents</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($getAllContractor as $key => $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->contractor }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->emailAddress }}</td>
                                <td>{{ $item->TIN }}</td>
                                <td>{{ $item->phoneNo }}</td>
                                <td>{{ $item->procurementContactPerson }}</td>

                                <td>
                                    <button class="btn btn-xs btn-primary view-docs-btn"
                                        data-contractor-id="{{ $item->procurementContractorRegistrationId }}"
                                        data-contractor-name="{{ $item->contractor }}">
                                        <i class="fa fa-file-text-o"></i> Documents
                                        ({{ DB::table('tblcontractor_document')->where('contractorID', $item->procurementContractorRegistrationId)->count() }})
                                    </button>
                                </td>



                                <td>
                                    @if ($item->isFromProcurement)
                                        <span class="label label-success">
                                            {{ $item->status_name }}
                                        </span>
                                    @else
                                        <span class="label label-default">Funds</span>
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-primary btn-xs add-doc-btn"
                                        data-contractor-id="{{ $item->procurementContractorRegistrationId }}"
                                        data-contractor-name="{{ $item->contractor }}" style="margin: 5px;">
                                        <i class="fa fa-upload"></i> Add More Document
                                    </button>

                                    <button class="btn btn-info btn-xs update-contractor-btn"
                                        data-contractor-id="{{ $item->procurementContractorRegistrationId }}"
                                        data-contractor-name="{{ $item->contractor }}"
                                        data-company="{{ $item->contractor }}" data-address="{{ $item->address }}"
                                        data-state="{{ $item->current_stateID }}" data-city="{{ $item->city }}"
                                        data-tin="{{ $item->TIN }}" data-phone="{{ $item->phoneNo }}"
                                        data-email="{{ $item->emailAddress }}"
                                        data-contact="{{ $item->procurementContactPerson }}"
                                        data-account="{{ $item->accountNo ?? '' }}"
                                        data-bank="{{ $item->bankId ?? '' }}"
                                        data-sortcode="{{ $item->sortCode ?? '' }}">
                                        <i class="fa fa-pencil"></i> Update
                                    </button>


                                    @if ($item->isFromProcurement)
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                            style="margin: 5px;" data-target="#confirmToDelete{{ $key }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    @endif
                                </td>

                            </tr>

                            <div class="modal fade" id="confirmToDelete{{ $key }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-danger">
                                            <h4 class="modal-title text-white">
                                                <i class="fa fa-trash"></i> Delete Contractor
                                            </h4>
                                        </div>

                                        <div class="modal-body text-center text-danger">
                                            <h4>Are you sure you want to delete <b>{{ $item->contractor }}</b>?</h4>
                                            <p><strong>Email:</strong> {{ $item->emailAddress }}</p>
                                            <p><strong>TIN:</strong> {{ $item->TIN }}</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <a href="{{ route('deleteContractorRecord', ['id' => base64_encode($item->procurementContractorRegistrationId)]) }}"
                                                class="btn btn-danger">Yes, Delete</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($getAllContractor instanceof \Illuminate\Pagination\AbstractPaginator)
                <div>{{ $getAllContractor->links() }}</div>

                <div class="text-right">
                    Showing
                    {{ ($getAllContractor->currentPage() - 1) * $getAllContractor->perPage() + 1 }}
                    to
                    {{ $getAllContractor->currentPage() * $getAllContractor->perPage() }}
                    of
                    {{ $getAllContractor->total() }}
                    entries
                </div>
            @endif

        </div>


        <!-- Documents Modal (Single, outside loop) -->
        <div class="modal fade" id="docsModal" tabindex="-1" role="dialog" aria-labelledby="docsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white" id="docsModalLabel">
                            Documents for <span id="docsModalContractorName"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body" id="docsModalBody">
                        <p class="text-center text-muted">Loading documents...</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog"
            aria-labelledby="addDocumentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="addDocumentModalLabel">
                            Add Document for <span id="addDocContractorName"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form id="addDocumentForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="contractor_id" id="addDocContractorId">

                            <div class="form-group">
                                <label for="document_type">Document Type</label>
                                <select name="document_type" id="document_type" class="form-control">
                                    <option value="">-- Select Document Type --</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="document_file">Upload Document</label>
                                <input type="file" name="document_file" id="document_file" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload Document</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Update Contractor Modal -->
        <div class="modal fade" id="updateContractorModal" tabindex="-1" role="dialog"
            aria-labelledby="updateContractorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <h4 class="modal-title text-white" id="updateContractorModalLabel">
                            Update Contractor
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form method="POST" action="{{ route('contractor.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="contractor_id" id="updateContractorId">

                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company Name <span class="text-danger">*</span></label>
                                        <input type="text" name="contractorName" id="updateCompanyName" required
                                            class="form-control" placeholder="Company Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select name="currentState" id="updateState" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($getState as $state)
                                                <option value="{{ $state->stateID }}">{{ $state->state_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" id="updateCity" class="form-control"
                                            placeholder="City">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>TIN Number <span class="text-danger">*</span></label>
                                        <input type="text" name="tinNumber" id="updateTIN" required
                                            class="form-control" placeholder="TIN Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phoneNumber" id="updatePhone" required
                                            class="form-control" placeholder="Phone Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="emailAddress" id="updateEmail" required
                                            class="form-control" placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person <span class="text-danger">*</span></label>
                                        <input type="text" name="contactPerson" id="updateContactPerson" required
                                            class="form-control" placeholder="Contact Person">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input type="text" name="account" id="updateAccount" class="form-control"
                                            placeholder="Account Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bank</label>
                                        <select class="form-control" id="updateBank" name="bank">
                                            <option value="">-select Bank-</option>
                                            @foreach ($bankList as $list)
                                                <option value="{{ $list->bankID }}">{{ $list->bank }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sort Code</label>
                                        <input type="text" name="sortcode" id="updateSortCode" class="form-control"
                                            placeholder="Optional">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" id="updateAddress" class="form-control" rows="2" placeholder="Address"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Update Contractor
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>



    </div> --}}

@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>

    <style>
        /* Highlight selected items in the dropdown */
        .select2-container--bootstrap .select2-results__option[aria-selected="true"] {
            color: #c00;
            /* red text */
            background-color: #fee;
            /* light red background */
            font-weight: bold;
        }

        .select2-container--bootstrap .select2-results__option[aria-selected="true"]::after {
            content: " (already selected)";
            font-style: italic;
            color: #900;
        }
    </style>

    <style>
        .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
            background: #337ab7 !important;
            /* Bootstrap 3 primary */
            border: 1px solid #2e6da4 !important;
            color: #fff !important;
            padding: 2px 8px !important;
        }

        .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 6px !important;
        }

        .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #f5f5f5 !important;
        }
    </style>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    @if (session('message'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
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

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Please fix the following errors:',
                html: `
                <ul style="text-align:left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                showConfirmButton: true
            });
        </script>
    @endif



    <script>
        $(document).ready(function() {

            function refreshOptions() {

                let selectedValues = [];

                $('.document_type').each(function() {
                    let val = $(this).val();
                    if (val) {
                        selectedValues.push(val);
                    }
                });

                $('.document_type').each(function() {

                    let currentSelect = $(this);
                    let currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {

                        let optionValue = $(this).attr('value');

                        if (optionValue == "") return;

                        if (selectedValues.includes(optionValue) && optionValue != currentValue) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }

                    });

                });
            }

            // When selection changes
            $(document).on('change', '.document_type', function() {
                refreshOptions();
            });

            // When adding new row
            $(document).on('click', '.add_more', function() {
                setTimeout(function() {
                    refreshOptions();
                }, 100);
            });

            // When removing row
            $(document).on('click', '.remove_row', function() {
                $(this).closest('.document_row').remove();
                refreshOptions();
            });

        });
    </script>



    <script>
        $(document).ready(function() {

            const MAX_SIZE = 5 * 1024 * 1024; // 5MB

            // --------------------------------------------------
            // Enable / Disable Add Button Per Row
            // --------------------------------------------------
            function checkRowValidity(row) {

                let type = row.find('.document_type').val();
                let file = row.find('.file_input')[0].files.length;

                if (type && file > 0) {
                    row.find('.add_more').prop('disabled', false);
                } else {
                    row.find('.add_more').prop('disabled', true);
                }
            }

            // --------------------------------------------------
            // Prevent Duplicate Document Type
            // --------------------------------------------------
            function refreshOptions() {

                let selected = [];

                $('.document_type').each(function() {
                    if ($(this).val()) {
                        selected.push($(this).val());
                    }
                });

                $('.document_type').each(function() {

                    let current = $(this).val();

                    $(this).find('option').each(function() {

                        let val = $(this).val();
                        if (!val) return;

                        if (selected.includes(val) && val !== current) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }

                    });

                });
            }

            // --------------------------------------------------
            // File Size Validation
            // --------------------------------------------------
            $(document).on('change', '.file_input', function() {

                let file = this.files[0];

                if (file && file.size > MAX_SIZE) {
                    // alert("File size must not exceed 5MB.");
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'File size must not exceed 5MB.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal-popup',
                            title: 'swal-title'
                        },
                    });
                    $(this).val('');
                    return;
                }

                let row = $(this).closest('.document_row');
                checkRowValidity(row);
            });

            // --------------------------------------------------
            // Document Type Change
            // --------------------------------------------------
            $(document).on('change', '.document_type', function() {

                let row = $(this).closest('.document_row');
                checkRowValidity(row);
                refreshOptions();
            });

            // --------------------------------------------------
            // Add More
            // --------------------------------------------------
            $(document).on('click', '.add_more', function() {

                if ($(this).prop('disabled')) return;

                let newRow = `
                    <div class="row document_row mt-2">
                        <div class="col-md-5">
                            <div class="form-group">
                                <select name="document_type[]"
                                        class="form-control text-uppercase document_type">
                                    <option value="">Select Document</option>
                                    @foreach ($requiredDocs as $doc)
                                        <option value="{{ $doc->id }}">
                                            [{{ $doc->doc_type }}] {{ $doc->bid_doc_description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="file"
                                    name="document[]"
                                    class="form-control file_input"
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success add_more form-control"  style="background-color: green; text-white"
                                        disabled>
                                        +
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button"
                                        class="btn btn-danger remove_row form-control mt-1">
                                        -
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#document_wrapper').append(newRow);

                // Disable clicked button
                $(this).prop('disabled', true);

                refreshOptions();
            });

            // --------------------------------------------------
            // Remove Row
            // --------------------------------------------------
            $(document).on('click', '.remove_row', function() {

                // Prevent removing first row
                if ($('#document_wrapper .document_row').length === 1) {
                    return;
                }


                // Remove the clicked row
                $(this).closest('.document_row').remove();

                // Refresh document type options to prevent duplicates
                refreshOptions();

                // Recheck last remaining row for enabling its Add button
                let lastRow = $('#document_wrapper .document_row').last();
                if (lastRow.length) {
                    checkRowValidity(lastRow);
                }
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            $('.view-docs-btn').on('click', function() {
                var contractorId = $(this).data('contractor-id');
                var contractorName = $(this).data('contractor-name');

                // Set the contractor name in modal header
                $('#docsModalContractorName').text(contractorName);

                // Show loading text
                $('#docsModalBody').html('<p class="text-center text-muted">Loading documents...</p>');

                // Show the modal
                $('#docsModal').modal('show');

                // Fetch documents via AJAX
                $.ajax({
                    url: '/contractor/' + contractorId + '/documents',
                    type: 'GET',
                    success: function(data) {
                        if (data.length > 0) {
                            var html = `<table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>File</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            data.forEach(function(doc, index) {
                                html += `<tr>
                                    <td>${index + 1}</td>
                                    <td>${doc.file_description || 'Document'}</td>
                                    <td>
                                        <a href="${doc.file_url}" target="_blank" class="btn btn-sm btn-success">
                                            View / Download
                                        </a>
                                    </td>
                                    <td>
                                        <form method="POST" action="/contractor/document/${doc.contractor_documentID}" onsubmit="return confirm('Are you sure you want to delete this document?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>`;
                            });
                            html += '</tbody></table>';
                            $('#docsModalBody').html(html);
                        } else {
                            $('#docsModalBody').html(
                                '<p class="text-muted text-center">No documents uploaded yet.</p>'
                            );
                        }
                    },
                    error: function(err) {
                        $('#docsModalBody').html(
                            '<p class="text-danger text-center">Failed to load documents.</p>'
                        );
                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('.add-doc-btn').on('click', function() {
                var contractorId = $(this).data('contractor-id');
                var contractorName = $(this).data('contractor-name');

                // Set contractor info in modal
                $('#addDocContractorName').text(contractorName);
                $('#addDocContractorId').val(contractorId);

                // Reset the file input
                $('#document_file').val('');

                // Load remaining document types via AJAX
                $.ajax({
                    url: '/contractor/' + contractorId + '/remaining-doc-types',
                    type: 'GET',
                    success: function(data) {
                        var options = '<option value="">-- Select Document Type --</option>';
                        data.forEach(function(docType) {
                            options +=
                                `<option value="${docType.id}">[${docType.doc_type}] ${docType.bid_doc_description}</option>`;
                        });
                        $('#document_type').html(options);
                    },
                    error: function() {
                        alert('Failed to load document types.');
                    }
                });

                // Show modal
                $('#addDocumentModal').modal('show');
            });


            // Handle form submission via AJAX
            $('#addDocumentForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('contractor.addDocument') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#addDocumentModal').modal('hide');
                        // alert(response.message || 'Document uploaded successfully.');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message ||
                                'Document uploaded successfully.',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'swal-popup',
                                title: 'swal-title'
                            },
                            didClose: () => {
                                // Reload the page after toast disappears
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        let message = errors ? Object.values(errors).flat().join("\n") :
                            'Failed to upload document.';
                        alert(message);
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.update-contractor-btn').on('click', function() {
                $('#updateContractorId').val($(this).data('contractor-id'));
                $('#updateCompanyName').val($(this).data('company'));
                $('#updateAddress').val($(this).data('address'));
                $('#updateState').val($(this).data('state'));
                $('#updateCity').val($(this).data('city'));
                $('#updateTIN').val($(this).data('tin'));
                $('#updatePhone').val($(this).data('phone'));
                $('#updateEmail').val($(this).data('email'));
                $('#updateContactPerson').val($(this).data('contact'));
                $('#updateAccount').val($(this).data('account'));
                $('#updateBank').val($(this).data('bank'));
                $('#updateSortCode').val($(this).data('sortcode'));

                $('#updateContractorModal').modal('show');
            });
        });
    </script>





    <script>
        //add more field or remove field
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('#add_more_document_field'); //Add button selector
            var wrapper = $('.attach_more_field_row'); //Input field wrapper
            var fieldHTML =
                '<span><div id="remove_row" class="card-not"> <a href="#" class="remove_document_field_btn pull-right align-right">Remove</a>' +
                '<div class="card-body-not">' +
                '<div class="row">' +
                '<div class="form-group col-sm-3">' +
                '<label>Select File <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input type="file" name="document[]" required data-parsley-type="file"  class="form-control"/>' +
                '</div>' +
                '</div>' +
                '<div class="form-group col-sm-3">' +
                '<label>Document Description <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input name="description[]" required type="text" class="form-control" placeholder="File Description" />' +
                '</div>' +
                '</div>' +
                '<!--<div class="form-group col-md-1  mt-4">' +
                '<button type="button" id="remove_document_field" class="btn-sm btn btn-circle btn-warning align-center" style="margin-top:3px;"><i class="fa fa-minus"></i></button>' +
                '</div>-->' +
                '</div>' +
                '</div>' +
                '</div></span>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    $(wrapper).append(fieldHTML);
                } else {
                    alert('You cannot add more than 10 fields!');
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_document_field_btn', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        //end more field
    </script>

    <script>
        //add more field or remove field
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('#add_more_bank_field'); //Add button selector
            var wrapper2 = $('.attach_more_bank_field_row'); //Input field wrapper
            var fieldHTML =
                '<span><div class="card-not"><a href="#" class="remove_bank_field_btn pull-right align-right">Remove</a>' +
                '<div class="card-body-not">' +
                '<div class="row">' +
                '<input name="bankRecordID[]" type="text"  style="display:none;" />' +
                '<div class="form-group col-sm-3">' +
                '<label>Bank Name <span class="text-danger">*</span></label>' +
                '<div>' +
                '<select  name="bankName[]" required class="form-control">' +
                '<option value="">Select</option>' +
                '@if (isset($bankList) and $bankList)' +
                '@foreach ($bankList as $item)' +
                '<option value="{{ $item->bankID }}" {{ $item->bankID == old('bankName') ? 'selected' : '' }}>{{ $item->bank }}</option>' +
                '@endforeach' +
                '@endif' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<!--<div class="form-group col-sm-4">' +
                '<label>Account Name <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input name="accountName[]" type="text" required class="form-control" placeholder="Account Name" />' +
                '</div>' +
                '</div>-->' +
                '<div class="form-group col-sm-3">' +
                '<label>Account Number <span class="text-danger">*</span></label>' +
                '<div>' +
                '<input name="accountNumber[]" required maxlength="10" size="10" type="number" class="form-control" placeholder="Account No." />' +
                '</div>' +
                '</div>' +
                '<!--<div class="form-group col-sm-1  mt-4">' +
                '<button type="button" class="remove_bank_field_btn33 btn-sm btn btn-circle btn-warning align-center" style="margin-top:3px;"><i class="fa fa-minus"></i></button>' +
                '</div>-->' +
                '</div>' +
                '</div>' +
                '</div></span>';
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    $(wrapper2).append(fieldHTML);
                } else {
                    alert('You cannot add more than 10 fields!');
                }
            });

            //Once remove button is clicked
            $(wrapper2).on('click', '.remove_bank_field_btn', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        //end more field
    </script>

    <script>
        $(document).ready(function() {

            $('#contractCategory').select2({
                theme: 'bootstrap',
                placeholder: 'Select contract categories...',
                width: '100%'
            });

            // Prevent duplicate selection
            $('#contractCategory').on('select2:select', function(e) {
                var selectedVal = e.params.data.id;
                var currentVals = $(this).val() || [];

                var occurrences = currentVals.filter(function(v) {
                    return String(v) === String(selectedVal);
                }).length;

                if (occurrences > 1) {
                    var newVals = currentVals.filter(function(v) {
                        return String(v) !== String(selectedVal);
                    });

                    newVals.push(selectedVal);
                    $(this).val(newVals).trigger('change');

                    Swal.fire({
                        icon: 'info',
                        title: 'Already selected!',
                        text: 'This category is already selected.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            });

            // Form submit validation
            $('#contractForm').on('submit', function(e) {
                var selectedCategories = $('#contractCategory').val() || [];

                if (selectedCategories.length === 0) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Required!',
                        text: 'Please select at least one contract category before submitting.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });

                    $('#contractCategory').select2('open');
                }
            });
        });
    </script>

@endsection
