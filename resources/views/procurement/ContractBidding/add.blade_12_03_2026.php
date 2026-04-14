@extends('layouts_procurement.app')
@section('pageTitle', 'Add Bid')
@section('pageMenu', 'active')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default"> <!-- Bootstrap 3 card alternative -->

                <div class="panel-heading">
                    <h4 class="panel-title">Add Contract Bid</h4>
                </div>

                <div class="panel-body">
                    @include('Bank.layouts.messages')
                    <form method="post" action="{{ url('/add-bidding') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contract <span class="text-danger">*</span></label>
                                    <select class="form-control" name="contract">
                                        <option value="">Select...</option>
                                        @foreach ($contract as $list)
                                            <option value="{{ $list->contract_detailsID }}"
                                                @if ($list->contract_detailsID == session('contractSess')) selected @endif>
                                                {{ $list->contract_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contractor <span class="text-danger">*</span></label>
                                    <select class="form-control" name="contractor" id="contractorSelect">
                                        <option value="">Select...</option>
                                        @foreach ($contractor as $list)
                                            <option value="{{ $list->contractor_registrationID }}"
                                                @if ($list->contractor_registrationID == session('contractorSess')) selected @endif>
                                                {{ $list->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bid Amount <span class="text-danger">*</span></label>
                                    <input type="text" name="biddingAmount" class="form-control" id="biddingAmount"
                                        value="{{ session('amountSess') }}" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" max="{{ date('Y-m-d') }}"
                                        value="{{ session('dateSess') }}">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Remark <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="contractorRemark">{{ session('contractRemarkSess') }}</textarea>
                        </div>

                        <hr>

                        <!-- Uploaded Documents Table -->
                        <div id="uploadedDocsSection"></div>

                        <!-- Missing Documents Upload Section -->
                        <div id="missingDocsSection"></div>

                        <hr>

                        <div class="panel panel-warning" style="margin-top: 20px;">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-money"></i> Upload Financial Documents
                                </h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    @foreach ($requiredDocsFinancial as $item)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    {{ $item->bid_doc_description }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="hidden" name="docDescId[]" value="{{ $item->id }}">

                                                <input type="file" name="document[]" class="form-control" required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>


                        <div class="text-right" style="margin-top: 20px;">
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>

                    </form>
                </div><!-- panel-body -->

            </div><!-- panel -->
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .remove,
        .delete {
            margin-top: 30px;
            padding-top: 5px !important;
            padding-bottom: 0px !important;

            margin-bottom: 0px;
        }

        .fa-times {
            font-size: 30px;
            cursor: pointer;
        }

        .compulsory {
            color: red;
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
    {{-- <script src="{{ asset('assets/js/jquery.3.4.1.slim.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('msg'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
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
            }).then(() => {
                // Re-fetch documents for selected contractor
                $('#contractorSelect').trigger('change');
            });
        </script>
    @endif

    @if (session('err'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('err') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            }).then(() => {
                // Re-fetch documents for selected contractor
                $('#contractorSelect').trigger('change');
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $(document).on('click', '.bn', function() {
                //alert(0);
                $('.wraps').last().remove();
                var id = this.id;
                var deleteindex = id[1];

                // Remove <div> with id
                $("#" + deleteindex).remove();

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#biddingAmount").on('keyup', function(evt) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#add').click(function() {
                var total_element = $(".wraps").length;
                var lastid = $(".wraps:last").attr("id");
                //var split_id = lastid.split('_');
                var n = Number(lastid) + 1;
                //alert(nextindex);
                $('#inputWrap').append(
                    `<div class="wraps" id="'+n+'">
                        <div class="row">
                            <div class="col-md-12">
                                <a class="delete bn remove_bank_field_btn pull-right align-right" href="javascript::void()">Remove</a>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group dynFile">
                                    <label for="">Evaluating Document</label>
                                    <input type="file" name="document[]" class="form-control" id=''>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group dynInput">
                                    <label for="">Document Description</label>
                                    <input type="text" name="description[]" class="form-control" id='' >
                                </div>
                            </div>
                        </div>
                    </div>`
                );
            });
            //end click function

            $('.delete').last().click(function() {
                $('.wraps').last().remove();
            });

        });
    </script>



    <script>
        $(document).ready(function() {
            $('#contractorSelect').on('change', function() {

                var contractorId = $(this).val();
                var contractId = $('select[name="contract"]').val();

                if (!contractorId || !contractId) {
                    $('#uploadedDocsSection').html('');
                    $('#missingDocsSection').html('');
                    return;
                }

                $.ajax({
                    // url: '/contractor-documents/' + contractorId,
                    url: `/contractor-documents/${contractorId}/${contractId}`,
                    type: 'GET',
                    success: function(response) {

                        // console.log(response.uploaded);

                        // ===============================
                        // 1️⃣ Uploaded Documents Table
                        // ===============================
                        var uploadedHTML = '';

                        if (response.uploaded.length > 0) {

                            uploadedHTML += `
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <strong><i class="fa fa-check-circle"></i> Uploaded Technical Documents</strong>
                                    </div>
                                    <div class="panel-body table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Document Type</th>
                                                    <th>File</th>
                                                    <th width="120">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            `;

                            $.each(response.uploaded, function(index, doc) {
                                uploadedHTML += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${doc.bid_doc_description}</td>
                                        <td>${doc.doc_type}</td>
                                        <td>
                                            <a href="${doc.file_name}" target="_blank" class="btn btn-xs btn-info">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-xs btn-danger delete-doc-btn"
                                                data-id="${doc.contractor_documentID}">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            uploadedHTML += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;
                        }

                        $('#uploadedDocsSection').html(uploadedHTML);

                        // ===============================
                        // 2️⃣ Missing Documents Upload
                        // ===============================
                        var missingHTML = '';

                        if (response.missing.length > 0) {

                            missingHTML += `
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <strong><i class="fa fa-exclamation-circle"></i> Missing Technical Documents (Required)</strong>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                            `;

                            $.each(response.missing, function(index, doc) {
                                missingHTML += `
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>${doc.bid_doc_description}</label>
                                            <input type="hidden" name="docDescId[]" value="${doc.docId}">
                                            <input type="file" name="document[]" class="form-control missing-doc-input" required>
                                        </div>
                                    </div>
                                `;
                            });

                            missingHTML += `
                                        </div>
                                    </div>
                                </div>
                            `;
                        }

                        $('#missingDocsSection').html(missingHTML);
                    }
                });

            });
        });
    </script>


    <script>
        $(document).on('change', '.missing-doc-input', function() {

            var file = this.files[0];

            if (!file) return;

            var allowedExtensions = ["jpg", "gif", "png", "pdf", "doc", "docx"];
            var maxSize = 1000000000; // 1GB

            var fileName = file.name;
            var fileSize = file.size;
            var extension = fileName.split('.').pop().toLowerCase();

            // Remove old error
            $(this).next('.file-error').remove();

            // Check extension
            if ($.inArray(extension, allowedExtensions) === -1) {
                $(this).val('');
                $(this).after(
                    '<small class="text-danger file-error">Invalid file type. Allowed: JPG, GIF, PNG, PDF, DOC, DOCX</small>'
                );
                return;
            }

            // Check file size
            if (fileSize > maxSize) {
                $(this).val('');
                $(this).after('<small class="text-danger file-error">File size must not exceed 1GB.</small>');
                return;
            }

        });


        $('#contractorSelect').on('change', function() {

            var contractValue = $('select[name="contract"]').val();

            // 🚨 If contract not selected
            if (!contractValue) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Contract Required',
                    html: `
                Please select a <b>Contract</b> first before choosing a contractor.
                <br><br>
                This ensures documents are loaded correctly.
            `,
                    confirmButtonColor: '#3085d6'
                });

                // Reset contractor dropdown
                $(this).val('').trigger('change.select2'); // remove select2 part if not using it
                return;
            }

            // ✅ Continue normal logic here
        });
    </script>


    <script>
        $(document).on('click', '.delete-doc-btn', function() {

            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This document will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: '/delete-contractor-doc/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Document has been deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Reload document section
                            $('#contractorSelect').trigger('change');
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong.',
                            });
                        }
                    });

                }

            });

        });
    </script>


    <script>
        $(document).ready(function() {

            function formatMoneyInput(value) {
                if (!value) return '';
                // Remove any character that's not a digit or dot
                value = value.replace(/[^\d.]/g, '');
                // Allow only one dot
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts[1];
                }
                // Add commas to integer part
                let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                if (parts[1] !== undefined) {
                    return integerPart + '.' + parts[1];
                } else {
                    return integerPart;
                }
            }

            $('#biddingAmount').on('input', function() {
                let cursor = this.selectionStart;
                let oldLength = $(this).val().length;

                let formatted = formatMoneyInput($(this).val());
                $(this).val(formatted);

                let newLength = formatted.length;
                this.selectionEnd = cursor + (newLength - oldLength);
            });

            $('#biddingAmount').on('blur', function() {
                let val = $(this).val().replace(/,/g, '');
                if (val) {
                    let number = parseFloat(val).toFixed(2);
                    $(this).val(parseFloat(number).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                }
            });

        });
    </script>




@endsection
