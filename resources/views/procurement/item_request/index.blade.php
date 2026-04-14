@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Request Items') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">@yield('pageTitle')</h4>
                    {{-- <div class="clearfix">
                        <div class="pull-right">
                            All fields with <span class="text-danger">*</span> are required.
                        </div>
                    </div> --}}
                </div>

                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom: 0; padding-left: 18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>CR Code</th>
                                    <th>Department</th>
                                    <th>Title</th>
                                    <th>Requested By</th>
                                    <th>Total Items</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th width="220">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="label label-success">{{ $row->cr_code ?: 'N/A' }}</span>
                                        </td>
                                        <td>{{ $row->department ?: 'N/A' }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">{{ $row->title }}</td>
                                        <td>{{ $row->created_by_name ?: 'N/A' }}</td>
                                        <td>{{ $row->total_items }}</td>
                                        <td>
                                            @if ($row->status == 0)
                                                <span class="label label-warning">Pending</span>
                                            @elseif ($row->status == 1)
                                                <span class="label label-primary">Approved</span>
                                            @elseif ($row->status == 2)
                                                <span class="label label-success">Recommend</span>
                                            @elseif ($row->status == 3)
                                                <span class="label label-success">CR Approved</span>
                                            @else
                                                <span class="label label-success">Issued</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d M Y h:i A', strtotime($row->created_at)) }}</td>
                                        <td>
                                            <div style="min-width: 120px;">
                                                <button type="button"
                                                    class="btn btn-primary btn-xs open-request-modal btn-block"
                                                    style="margin-bottom: 5px;" data-id="{{ $row->id }}"
                                                    data-title="{{ $row->title }}" data-code="{{ $row->cr_code }}"
                                                    data-status="{{ $row->status }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $row->status == 0 ? 'View/Approve' : 'View' }}
                                                </button>

                                                @if ($row->status == 0)
                                                    <button type="button"
                                                        class="btn btn-success btn-xs open-add-item-modal btn-block"
                                                        style="margin-bottom: 5px;" data-id="{{ $row->id }}"
                                                        data-title="{{ $row->title }}">
                                                        <i class="fa fa-plus"></i> Add More Item
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-danger btn-xs delete-request-btn btn-block"
                                                        data-id="{{ $row->id }}" data-title="{{ $row->title }}">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No record found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="requestItemsModal" tabindex="-1" role="dialog"
            aria-labelledby="requestItemsModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header" style="background: #f8f8f8;">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                        <h4 class="modal-title" id="requestItemsModalLabel">
                            <i class="fa fa-list-alt text-primary"></i> Request Items
                        </h4>
                    </div>

                    <div class="modal-body">

                        {{-- Request Summary --}}
                        <div class="alert alert-info" style="margin-bottom: 15px; padding: 15px;">
                            <div class="row">
                                <div class="col-md-9">
                                    <table style="margin: 0;">
                                        <tr>
                                            <td style="vertical-align: middle; padding-right: 10px;">
                                                <i class="fa fa-info-circle" style="font-size: 22px; color: #31708f;"></i>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <h4 id="modal-request-title" style="margin: 0; font-weight: 600;"></h4>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-3 text-right">
                                    <span id="modal-request-status-badge"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Top actions --}}
                        <div class="clearfix" style="margin-bottom: 12px;">
                            <div class="pull-left">
                                <h4 style="margin: 5px 0 0 0; font-size: 15px;">
                                    <i class="fa fa-cubes text-muted"></i> Requested Item List
                                </h4>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="modal-items-table"
                                style="margin-bottom: 10px;">
                                <thead style="background: #f5f5f5;">
                                    <tr>
                                        {{-- <th style="width: 5%;">#</th> --}}
                                        <th style="width: 60%;">Item</th>
                                        <th style="width: 15%;">Requested <br> Quantity</th>
                                        <th style="width: 15%;" id="modal-delivered-th">Delivered <br>Quantity</th>
                                        <th style="width: 20%;">Status</th>
                                        <th style="width: 20%;" id="modal-action-th">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-items-body">
                                    <tr>
                                        <td colspan="5" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="modal-no-items" class="alert alert-warning" style="display:none; margin-bottom: 0;">
                            <i class="fa fa-warning"></i> No items found for this request.
                        </div>
                    </div>

                    <div class="modal-footer" style="background: #fcfcfc;">
                        <form id="modal-approve-form" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success" id="modal-approve-btn">
                                <i class="fa fa-check"></i> Approve Request
                            </button>
                        </form>

                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header" style="background: #f8f8f8;">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                        <h4 class="modal-title" id="addItemModalLabel">
                            <i class="fa fa-plus-circle text-primary"></i> Add More Item
                        </h4>
                    </div>

                    <form id="addItemForm">
                        @csrf
                        <input type="hidden" name="request_id" id="add-item-request-id">

                        <div class="modal-body">

                            <div class="alert alert-info" style="margin-bottom: 15px; padding: 12px 15px;">
                                <table style="margin: 0; width: 100%;">
                                    <tr>
                                        <td style="vertical-align: middle; width: 30px;">
                                            <i class="fa fa-info-circle" style="font-size: 20px; color: #31708f;"></i>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <h4 id="add-item-request-title" style="margin: 0; font-weight: 600;"></h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group">
                                <label>Item <span class="text-danger">*</span></label>
                                <select name="itemId" id="modal-item-id" class="form-control" required>
                                    <option value="">Select item</option>
                                    @foreach ($itemsList as $item)
                                        <option value="{{ $item->itemID }}">{{ $item->item }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="modal-item-quantity" class="form-control"
                                    min="1" placeholder="Enter quantity" required>
                            </div>

                            <div id="add-item-modal-error" class="alert alert-danger"
                                style="display:none; margin-bottom: 0;"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Item
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-times"></i> Close
                            </button>
                        </div>
                    </form>

                </div>
            </div>
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
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('success') }}',
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
            var currentRequestId = null;
            var currentDepartmentId = null;
            var currentStatus = 0;

            function renderStatusBadge(status) {
                if (parseInt(status) === 0) {
                    return '<span class="label label-warning">Pending</span>';
                } else if (parseInt(status) === 1) {
                    return '<span class="label label-primary">Approved</span>';
                } else if (parseInt(status) === 2) {
                    return '<span class="label label-success">Store Recommend</span>';
                } else if (parseInt(status) === 3) {
                    return '<span class="label label-success">CR Approved</span>';
                } else {
                    return '<span class="label label-success">Issued</span>';
                }
            }

            function renderSpecifications(specifications) {
                if (!specifications) {
                    return '<span class="text-muted">No specification</span>';
                }

                var specs = specifications.split(',');

                var html = '';
                $.each(specs, function(index, spec) {
                    var cleanSpec = $.trim(spec).toUpperCase();
                    if (cleanSpec !== '') {
                        html +=
                            '<span class="label label-success" style="display:inline-block; margin:2px 4px 2px 0;">' +
                            cleanSpec + '</span> ';
                    }
                });

                return html;
            }


            function renderItemRows(items, requestStatus) {
                var html = '';
                var isPending = parseInt(requestStatus) === 0;
                var isDelivered = parseInt(requestStatus) === 4;
                var colspan = isPending ? 4 : 3;


                if (isPending) {
                    $('#modal-action-th').show();
                } else {
                    $('#modal-action-th').hide();
                }

                if (isDelivered) {
                    $('#modal-delivered-th').show();
                } else {
                    $('#modal-delivered-th').hide();
                }

                if (!items.length) {
                    $('#modal-no-items').show();
                    html = '<tr><td colspan="' + colspan + '" class="text-center">No items found.</td></tr>';
                } else {
                    $('#modal-no-items').hide();

                    $.each(items, function(index, item) {
                        html += '<tr>';
                        html += '<td>';
                        html += '<strong>' + (item.item_name ? item.item_name : 'N/A') + '</strong>';
                        if (item.specifications) {
                            html += '<br><small>' + renderSpecifications(item.specifications) + '</small>';
                        }
                        html += '</td>';

                        if (isPending) {
                            html += `
                            <td>
                                <input type="number"
                                    class="form-control input-sm update-qty-input"
                                    value="${item.quantity}"
                                    min="1"
                                    data-id="${item.id}"
                                    style="max-width: 120px;">
                            </td>
                        `;
                        } else {
                            html += '<td>' + item.quantity + '</td>';
                        }

                        if (isDelivered) {
                            html += '<td>' + item.deliveredQuantity + '</td>';
                        }
                        html += '<td>' + renderStatusBadge(item.status) + '</td>';

                        if (isPending) {
                            html += `
                            <td>
                                <button type="button"
                                    class="btn btn-primary btn-xs update-qty-btn"
                                    data-id="${item.id}">
                                    <i class="fa fa-save"></i> Update
                                </button>

                                <button type="button"
                                    class="btn btn-danger btn-xs remove-item-btn"
                                    data-id="${item.id}">
                                    <i class="fa fa-trash"></i> Remove
                                </button>
                            </td>
                        `;
                        }

                        html += '</tr>';
                    });
                }

                $('#modal-items-body').html(html);
            }

            function loadRequestItems(requestId) {
                $('#modal-items-body').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

                $.get("{{ url('/item-request/items') }}/" + requestId, function(response) {
                    if (response.status) {
                        currentRequestId = response.request.id;
                        currentDepartmentId = response.items.length ? response.items[0].departmentId : null;
                        currentStatus = response.request.status;

                        $('#modal-request-title').text(response.request.title || 'N/A');
                        $('#modal-request-status-badge').html(renderStatusBadge(response.request.status));
                        $('#modal-approve-form').attr('action', "{{ url('/item-request/approve') }}/" +
                            response.request.id);

                        if (parseInt(response.request.status) === 0) {
                            $('#modal-approve-btn').show();
                        } else {
                            $('#modal-approve-btn').hide();
                        }

                        renderItemRows(response.items, response.request.status);
                        $('#requestItemsModal').modal('show');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }).fail(function() {
                    Swal.fire('Error', 'Unable to load request items.', 'error');
                });
            }

            $(document).on('click', '.open-request-modal', function() {
                var requestId = $(this).data('id');
                loadRequestItems(requestId);
            });


            $(document).on('click', '.remove-item-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var itemId = $(this).data('id');

                Swal.fire({
                    title: 'Remove item?',
                    text: 'This item will be removed from the request.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete-request-item') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                item_id: itemId
                            },
                            success: function(response) {
                                if (response.status) {
                                    loadRequestItems(response.item.requestId);

                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 2500
                                    });
                                } else {
                                    Swal.fire('Error', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                var message = 'Unable to remove item.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire('Error', message, 'error');
                            }
                        });
                    }
                });

                return false;
            });


            $(document).on('click', '.update-qty-btn', function() {
                var id = $(this).data('id');
                var quantity = $('.update-qty-input[data-id="' + id + '"]').val();

                if (!quantity || parseInt(quantity) < 1) {
                    // alert('Please enter a valid quantity.');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please enter a valid quantity.'
                    });
                    return;
                }

                $.ajax({
                    url: '/item-request/item/update-quantity',
                    type: 'POST',
                    data: {
                        id: id,
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // alert('Quantity updated successfully');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: "Quantity updated successfully",
                            showConfirmButton: false,
                            timer: 2500
                        });
                    },
                    error: function() {
                        // alert('Failed to update quantity');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update quantity.'
                        });
                    }
                });
            });
        });
    </script>




    <script>
        $(document).ready(function() {

            function resetModalItemOptions() {
                $('#modal-item-id option').each(function() {
                    var originalText = $(this).attr('data-original-text');
                    if (originalText) {
                        $(this).text(originalText);
                    }

                    $(this).prop('disabled', false).css({
                        'color': '',
                        'background-color': ''
                    });
                });

                $('#modal-item-id').val('');
            }

            function disableExistingItems(items) {
                resetModalItemOptions();

                $.each(items, function(index, item) {
                    if (item.itemId) {
                        var option = $('#modal-item-id option[value="' + item.itemId + '"]');

                        if (!option.attr('data-original-text')) {
                            option.attr('data-original-text', option.text());
                        }

                        option
                            .prop('disabled', true)
                            .text(option.attr('data-original-text') + ' (Already Added)')
                            .css({
                                'color': '#d9534f',
                                'background-color': '#fdf2f2'
                            });
                    }
                });
            }

            $(document).on('click', '.open-add-item-modal', function() {
                var requestId = $(this).data('id');
                var title = $(this).data('title');

                $('#add-item-request-id').val(requestId);
                $('#add-item-request-title').text(title);
                $('#modal-item-quantity').val('');
                $('#add-item-modal-error').hide().text('');

                $.ajax({
                    url: "{{ url('/item-request/items') }}/" + requestId,
                    type: "GET",
                    success: function(response) {
                        if (response.status) {
                            disableExistingItems(response.items);
                            $('#addItemModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message ||
                                    'Unable to load request items.'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to load request items.'
                        });
                    }
                });
            });

            $('#addItemModal').on('hidden.bs.modal', function() {
                resetModalItemOptions();
                $('#modal-item-quantity').val('');
                $('#add-item-modal-error').hide().text('');
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $('#addItemForm').on('submit', function(e) {
                e.preventDefault();

                $('#add-item-modal-error').hide().text('');

                var submitBtn = $(this).find('button[type="submit"]');
                var originalBtnHtml = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

                $.ajax({
                    url: "{{ route('add-request-item') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#addItemModal').modal('hide');

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true
                            });

                            // refresh page so total item count updates
                            location.reload();
                        } else {
                            $('#add-item-modal-error').show().text(response.message);
                        }
                    },
                    error: function(xhr) {
                        var message = 'Unable to add item.';

                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;
                                var firstKey = Object.keys(errors)[0];
                                if (firstKey && errors[firstKey].length > 0) {
                                    message = errors[firstKey][0];
                                }
                            }
                        }

                        $('#add-item-modal-error').show().text(message);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalBtnHtml);
                    }
                });
            });

        });
    </script>

    <script>
        $(document).on('click', '.delete-request-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var requestId = $(this).data('id');
            var title = $(this).data('title');
            var button = $(this);
            var row = button.closest('tr');

            Swal.fire({
                title: 'Delete request?',
                text: 'This will remove "' + title + '" and all items under it.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-item-request') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            request_id: requestId
                        },
                        success: function(response) {
                            if (response.status) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                });

                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            var message = 'Unable to delete request.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire('Error', message, 'error');
                        }
                    });
                }
            });

            return false;
        });
    </script>
@endsection
