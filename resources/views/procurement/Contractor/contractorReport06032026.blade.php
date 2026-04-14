@extends('layouts_procurement.app')
@section('pageTitle', 'Contractor Report')
@section('content')



    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><b>@yield('pageTitle')</b></h3>
        </div>

        <div class="panel-body">



            <div class="row">
                <div class="col-md-12">

                    <!-- Divider -->
                    <div class="text-center">
                        <hr>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>CONTRACTOR'S NAME</th>
                                    <th>ADDRESS</th>
                                    <th>EMAIL</th>
                                    <th>TIN</th>
                                    <th>TELEPHONE</th>
                                    <th>CONTACT PERSON</th>
                                    <th>STATE</th>
                                    <th>Documents</th>
                                    <th>STATUS</th>
                                    <th style="width:170px;">ACTIONS</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i = 1; @endphp

                                @if (isset($getAllContractor) && is_iterable($getAllContractor))
                                    @foreach ($getAllContractor as $key => $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->company_name }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->email_address }}</td>
                                            <td>{{ $item->tin_number }}</td>
                                            <td>{{ $item->phone_number }}</td>
                                            <td>{{ $item->contact_person }}</td>
                                            <td>{{ $item->state_name }}</td>
                                            <td>{{ $item->status_name }}</td>

                                            <td>
                                                <button class="btn btn-sm btn-primary view-docs-btn"
                                                    data-contractor-id="{{ $item->contractor_registrationID }}"
                                                    data-contractor-name="{{ $item->company_name }}">
                                                    Documents
                                                    ({{ DB::table('tblcontractor_document')->where('contractorID', $item->contractor_registrationID)->count() }})
                                                </button>
                                            </td>

                                            {{-- <td class="text-center" style="width: 130px;">

                                                <a href="{{ route('createContractorRegistration', ['id' => base64_encode($item->contractor_registrationID)]) }}"
                                                    class="btn btn-info btn-xs">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-backdrop="false"
                                                    data-target="#confirmToDelete{{ $key }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>

                                            </td> --}}

                                            <td>
                                                <!-- Buttons with spacing -->
                                                <button type="button" class="btn btn-primary btn-xs add-doc-btn"
                                                    data-contractor-id="{{ $item->contractor_registrationID }}"
                                                    data-contractor-name="{{ $item->company_name }}" style="margin: 5px;">
                                                    <i class="fa fa-upload"></i> Add More Document
                                                </button>

                                                <button class="btn btn-info btn-xs update-contractor-btn"
                                                    data-contractor-id="{{ $item->contractor_registrationID }}"
                                                    data-contractor-name="{{ $item->company_name }}"
                                                    data-company="{{ $item->company_name }}"
                                                    data-address="{{ $item->address }}"
                                                    data-state="{{ $item->current_stateID }}"
                                                    data-city="{{ $item->city }}" data-tin="{{ $item->tin_number }}"
                                                    data-phone="{{ $item->phone_number }}"
                                                    data-email="{{ $item->email_address }}"
                                                    data-contact="{{ $item->contact_person }}"
                                                    data-account="{{ $item->accountNo ?? '' }}"
                                                    data-bank="{{ $item->bankId ?? '' }}"
                                                    data-sortcode="{{ $item->sortCode ?? '' }}">
                                                    <i class="fa fa-pencil"></i> Update
                                                </button>



                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                    style="margin: 5px;" data-target="#confirmToDelete{{ $key }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="confirmToDelete{{ $key }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header bg-danger">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title text-white">
                                                            <i class="fa fa-trash"></i> Delete Contractor
                                                        </h4>
                                                    </div>

                                                    <div class="modal-body text-center text-danger">
                                                        <h4>Are you sure you want to delete
                                                            <b>{{ $item->company_name }}</b>?
                                                        </h4>
                                                        <p><strong>Email:</strong> {{ $item->email_address }}</p>
                                                        <p><strong>TIN:</strong> {{ $item->tin_number }}</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Cancel</button>
                                                        <a href="{{ route('deleteContractorRecord', ['id' => base64_encode($item->contractor_registrationID)]) }}"
                                                            class="btn btn-danger">
                                                            Yes, Delete
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No contractors found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($getAllContractor instanceof \Illuminate\Pagination\AbstractPaginator)
                        <div>
                            {{ $getAllContractor->links() }}
                        </div>

                        <div class="text-right">
                            Showing
                            {{ ($getAllContractor->currentpage() - 1) * $getAllContractor->perpage() + 1 }}
                            to
                            {{ $getAllContractor->currentpage() * $getAllContractor->perpage() }}
                            of
                            {{ $getAllContractor->total() }} entries
                        </div>
                    @endif

                </div>
            </div>
        </div>
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


    <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="addDocumentModalLabel"
        aria-hidden="true">
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
                            <input type="file" name="document_file" id="document_file" class="form-control" required>
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
                                    <input type="text" name="tinNumber" id="updateTIN" required class="form-control"
                                        placeholder="TIN Number">
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




@endsection

@section('styles')
    <style>
        .table-responsive {
            max-height: 800px;
            overflow: auto;
        }

        .text-gray-b {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }

        .btn-sm {
            margin: 2px;
        }

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    alert("File size must not exceed 5MB.");
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
                                            {{ $doc->bid_doc_description }}
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
                                `<option value="${docType.id}">${docType.bid_doc_description}</option>`;
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


@endsection
