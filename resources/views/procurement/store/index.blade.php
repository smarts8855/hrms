@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Store') }}
@endsection
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default"> <!-- Bootstrap 3 Panel -->
                <div class="panel-body">

                    {{-- @include('procurement.ShareView.operationCallBackAlert') --}}

                    <!-- Store Header -->
                    <div class="store-header">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1 class="text-white"><i class="fa fa-shopping-cart"></i> Incoming Goods </h1>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="datatable-buttonsx" class="table table-striped table-bordered"
                            style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Contract</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Contractor</th>
                                    <th>Lot No.</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            @php $n = ($biddings->currentPage() - 1) * $biddings->perPage() + 1; @endphp

                            <tbody>
                                @foreach ($biddings as $list)
                                    @php
                                        $statusLabel =
                                            $list->store_status == 1 ? 'label label-success' : 'label label-warning';
                                    @endphp

                                    <tr id="row-{{ $list->contract_biddingID }}">
                                        <td>{{ $n++ }}</td>
                                        <td><strong>{{ $list->contract_name }}</strong></td>
                                        {{-- <td>{{ Str::limit($list->contract_description, 50) }}</td> --}}
                                        <td>{{ $list->company_name }}</td>
                                        <td><span class="label label-default">{{ $list->lot_number }}</span></td>

                                        <td>
                                            <span class="{{ $statusLabel }}">
                                                {{ $list->store_status == 1 ? 'Accepted' : 'Pending' }}
                                            </span>
                                        </td>

                                        <td style="width: 130px">
                                            <span class="label label-info">{{ $list->assignedName }}</span>
                                        </td>

                                        <td class="text-centerr">
                                            <button class="btn btn-info btn-xs view-bidding-btn"
                                                data-id="{{ $list->contract_biddingID }}">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                            @if ($list->store_status == 1)
                                            <a href="store/items/{{$list->store_id}}" class="btn btn-info btn-xs">
                                                <i class="fa fa-plus"></i> Add Item
                                            </a>
                                            @endif

                                            @if ($list->store_status != 1)
                                                <button class="btn btn-primary btn-xs approve-btn"
                                                    data-id="{{ $list->contract_biddingID }}">
                                                    <i class="fa fa-check"></i> Accept
                                                </button>
                                            @elseif(!$list->assignedTo)
                                                <button class="btn btn-success btn-xs assign-user-btn"
                                                    data-bidding-id="{{ $list->contract_biddingID }}">
                                                    <i class="fa fa-user-plus"></i> Assign
                                                </button>
                                            @else
                                                <button class="btn btn-warning btn-xs change-user-btn"
                                                    data-bidding-id="{{ $list->contract_biddingID }}"
                                                    data-current-user="{{ $list->assignedTo }}">
                                                    <i class="fa fa-user"></i> Change User
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="text-right">
                        {{ $biddings->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end row -->



    <!-- Confirmation Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #337ab7; color: #fff;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title" id="approvalModalLabel">Acknowledge</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="text-center">Are you sure you want to acknowledge the approved contract sent to you ?</p>
                    <p class="text-center text-muted">This action cannot be undone.</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmApprove">
                        <i class="fa fa-check"></i> Confirm
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!-- User Assignment Modal -->
    <div class="modal fade" id="userAssignmentModal" tabindex="-1" role="dialog"
        aria-labelledby="userAssignmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #337ab7; color: #fff;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title" id="userAssignmentModalLabel">Assign User</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modalUserSelect">Select User</label>
                        <select class="form-control select2" id="modalUserSelect">
                            <option value="">Select a user...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}">
                                    {{ $user->Names }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmAssignUser">
                        <i class="fa fa-user-plus"></i> Assign User
                    </button>
                </div>

            </div>
        </div>
    </div>



    <!-- View Bidding Details Modal -->
    <div class="modal fade" id="viewBiddingModal" tabindex="-1" role="dialog" aria-labelledby="viewBiddingModalLabel">
        <div class="modal-dialog modal-lg" role="document"> <!-- BS3 compatible -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background: #337ab7; color: #fff;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                    <h4 class="modal-title" id="viewBiddingModalLabel">
                        <i class="fa fa-info-circle"></i> Bidding Details
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="font-size: 16px; font-weight: bold;">Contract Information</h4>
                            <hr>

                            <p><strong>Contract Name:</strong> <span id="view-contract-name"></span></p>
                            <p><strong>Lot Number:</strong> <span id="view-lot-number"></span></p>
                            <p><strong>Category:</strong> <span id="view-category-name"></span></p>
                            <p><strong>Description:</strong> <span id="view-contract-description"></span></p>
                        </div>

                        <div class="col-md-6">
                            <h4 style="font-size: 16px; font-weight: bold;">Contractor Information</h4>
                            <hr>

                            <p><strong>Company Name:</strong> <span id="view-company-name"></span></p>
                            <p><strong>Email:</strong> <span id="view-email-address"></span></p>
                            <p><strong>Phone:</strong> <span id="view-phone-number"></span></p>
                            <p><strong>Address:</strong> <span id="view-address"></span></p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span id="view-store-status" class="status-cell"></span></p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Assigned To:</strong> <span id="view-assigned-user"></span></p>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>


@endsection

<style>
    .store-header {
        background: #252b3b;
        /* background: linear-gradient(135deg, #444444 0%, #666666 100%); */
        /* background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); */
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    #viewBiddingModal .modal-header {
        background-color: #337ab7;
        color: #fff;
        border-bottom: 3px solid #2e6da4;
    }

    #viewBiddingModal h4 {
        margin-top: 0;
    }

    .status-cell .label {
        font-size: 12px;
    }

    #userAssignmentModal .modal-header {
        border-bottom: 3px solid #2e6da4;
        padding: 15px;
    }

    #userAssignmentModal .modal-title {
        font-weight: bold;
    }

    #userAssignmentModal .modal-footer .btn {
        min-width: 100px;
    }


    #approvalModal .modal-header {
        border-bottom: 3px solid #2e6da4;
        padding: 15px 15px;
    }

    #approvalModal .modal-title {
        font-weight: bold;
    }

    #approvalModal .modal-footer .btn {
        min-width: 100px;
    }



    .store-header h1 {
        font-weight: 700;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 2rem;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        border-top: 1px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-1px);
    }

    .status-cell {
        font-weight: 600;
    }

    .status-cell:before {
        content: "";
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .status-cell:contains("Approved"):before {
        background-color: #28a745;
    }

    .status-cell:contains("Pending"):before {
        background-color: #ffc107;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .pagination {
        justify-content: flex-end;
    }

    .page-item.active .page-link {
        background-color: #2575fc;
        border-color: #2575fc;
    }

    .page-link {
        color: #2575fc;
    }

    .modal-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border-radius: 0;
    }

    .modal-title {
        font-weight: 600;
    }

    hr {
        border-top: 2px solid rgba(0, 0, 0, 0.1);
        margin: 1.5rem 0;
    }

    .swal-popup {
        padding: 10px !important;
    }

    .swal-title {
        font-size: 13px !important;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 600px;
        }
    }
</style>

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                width: '100%',
                placeholder: "Select a user...",
                allowClear: true
            });

            let currentBiddingId = null;
            let currentUserId = null;

            // Approve button click
            $('.approve-btn').click(function() {
                currentBiddingId = $(this).data('id');
                $('#approvalModal').modal('show');
            });

            // Confirm approval
            $('#confirmApprove').click(function() {
                if (currentBiddingId) {
                    $.ajax({
                        url: '{{ route('bidding.approve') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: currentBiddingId
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Approval failed: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON?.message || 'An error occurred');
                        }
                    });
                    $('#approvalModal').modal('hide');
                }
            });

            // Assign/Change User button click
            $(document).on('click', '.assign-user-btn, .change-user-btn', function() {
                currentBiddingId = $(this).data('bidding-id');
                currentUserId = $(this).data('current-user') || null;

                // Reset and show modal
                $('#modalUserSelect').val(currentUserId || '').trigger('change');
                $('#userAssignmentModal').modal('show');

                // Update modal title based on action
                if ($(this).hasClass('change-user-btn')) {
                    $('#userAssignmentModalLabel').html(
                        '<i class="fas fa-user-edit mr-2 text-white"></i><span class="text-white">Change Assigned User</span>'
                    );
                    $('#confirmAssignUser').html('<i class="fas fa-save mr-1"></i> Save Changes');
                } else {
                    $('#userAssignmentModalLabel').html(
                        '<i class="fas fa-user-plus mr-2"></i><span class="text-white">Assign User</span>'
                    );
                    $('#confirmAssignUser').html(
                        '<i class="fas fa-user-plus mr-1"></i> <span class="text-white">Assign User</span>'
                    );
                }
            });

            // Confirm user assignment
            $('#confirmAssignUser').click(function() {
                let userId = $('#modalUserSelect').val();

                if (userId) {
                    $.ajax({
                        url: '{{ route('bidding.assign.user') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            bidding_id: currentBiddingId,
                            user_id: userId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Success - reload page to show changes
                                location.reload();
                            } else {
                                alert('Assignment failed: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON?.message || 'An error occurred');
                        },
                        complete: function() {
                            // Clean up
                            $('#userAssignmentModal').modal('hide');
                            $('#modalUserSelect').val('').trigger('change');
                            currentBiddingId = null;
                            currentUserId = null;
                        }
                    });
                } else {
                    alert('Please select a user');
                }
            });

            // Reset modal when closed
            $('#userAssignmentModal').on('hidden.bs.modal', function() {
                $('#modalUserSelect').val('').trigger('change');
                currentBiddingId = null;
                currentUserId = null;
            });
        });


        // View button click
        $(document).on('click', '.view-bidding-btn', function() {
            let biddingId = $(this).data('id');

            $.ajax({
                url: '{{ route('bidding.view', ':id') }}'.replace(':id', biddingId),
                method: 'GET',
                success: function(response) {
                    // Clear previous content
                    $('#view-contract-name').text('');
                    $('#view-lot-number').text('');
                    $('#view-category-name').text('');
                    $('#view-contract-description').text('');
                    $('#view-proposed-budget').text('');
                    $('#view-company-name').text('');
                    $('#view-email-address').text('');
                    $('#view-phone-number').text('');
                    $('#view-address').text('');
                    $('#view-bidding-amount').text('');
                    $('#view-awarded-amount').text('');
                    $('#view-store-status').text('');
                    $('#view-assigned-user').text('');

                    // Populate modal with bidding details
                    $('#view-contract-name').text(response.contract_name || 'N/A');
                    $('#view-lot-number').text(response.lot_number || 'N/A');
                    $('#view-category-name').text(response.category_name || 'N/A');
                    $('#view-contract-description').text(response.contract_description || 'N/A');
                    $('#view-proposed-budget').text(response.proposed_budget ? '₦' + Number(response
                        .proposed_budget).toLocaleString() : 'N/A');
                    $('#view-company-name').text(response.company_name || 'N/A');
                    $('#view-email-address').text(response.email_address || 'N/A');
                    $('#view-phone-number').text(response.phone_number || 'N/A');
                    $('#view-address').text(response.address || 'N/A');
                    $('#view-bidding-amount').text(response.bidding_amount ? '₦' + Number(response
                        .bidding_amount).toLocaleString() : 'N/A');
                    $('#view-awarded-amount').text(response.awarded_amount ? '₦' + Number(response
                        .awarded_amount).toLocaleString() : 'Not awarded');
                    $('#view-store-status')
                        .text(response.store_status == 1 ? 'Approved' : 'Pending')
                        .removeClass('text-success text-warning')
                        .addClass(response.store_status == 1 ? 'text-success' : 'text-warning')
                        .prepend('<i class="fas ' + (response.store_status == 1 ? 'fa-check-circle' :
                            'fa-clock') + ' mr-1"></i>');
                    $('#view-assigned-user').text(response.assigned_user_name || 'Not assigned');

                    $('#viewBiddingModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.error ||
                        'An error occurred while fetching bidding details'));
                }
            });
        });

        // Reset view modal when closed
        $('#viewBiddingModal').on('hidden.bs.modal', function() {
            $('#view-contract-name').text('');
            $('#view-lot-number').text('');
            $('#view-category-name').text('');
            $('#view-contract-description').text('');
            $('#view-proposed-budget').text('');
            $('#view-company-name').text('');
            $('#view-email-address').text('');
            $('#view-phone-number').text('');
            $('#view-address').text('');
            $('#view-bidding-amount').text('');
            $('#view-awarded-amount').text('');
            $('#view-store-status').text('').removeClass('text-success text-warning');
            $('#view-assigned-user').text('');
        });
    </script>
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






@endsection
