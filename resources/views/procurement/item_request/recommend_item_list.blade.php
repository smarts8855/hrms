@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('STORE RECOMMENDATION REVIEW') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">@yield('pageTitle')</h4>
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

                    @if (($userUserDept && $userUserDept->departmentID == 28) || $user->is_global == 1)
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-12">
                                <form method="GET" action="{{ url()->current() }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="departmentId">Filter by Department</label>
                                            <select name="departmentId" class="form-control">
                                                <option value="">Select department</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ request('departmentId') == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->department }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3" style="margin-top: 25px;">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-filter"></i> Filter
                                            </button>

                                            <a href="{{ url()->current() }}" class="btn btn-default">
                                                <i class="fa fa-refresh"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                                <span class="label label-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d M Y h:i A', strtotime($row->created_at)) }}</td>
                                        <td>
                                            @if ($row->status == 2)
                                                <a href="{{ route('recommended-item-request-view', $row->id) }}"
                                                    class="btn btn-success btn-xs  btn-block">
                                                    <i class="fa fa-check-circle"></i> Review Recommendation
                                                </a>
                                            @else
                                                <button type="button"
                                                    class="btn btn-primary btn-xs open-request-modal btn-block"
                                                    style="margin-bottom: 5px;" data-id="{{ $row->id }}"
                                                    data-title="{{ $row->title }}" data-code="{{ $row->cr_code }}"
                                                    data-status="{{ $row->status }}">
                                                    <i class="fa fa-eye"></i>
                                                    View Item Approved
                                                </button>
                                            @endif

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
    </div>

    <div class="modal fade" id="requestItemsModal" tabindex="-1" role="dialog" aria-labelledby="requestItemsModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background: #f8f8f8;">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title" id="requestItemsModalLabel">
                        <i class="fa fa-list-alt text-primary"></i> Request Items Approved
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
                        <table class="table table-bordered table-hover" id="modal-items-table" style="margin-bottom: 10px;">
                            <thead style="background: #f5f5f5;">
                                <tr>
                                    {{-- <th style="width: 5%;">#</th> --}}
                                    <th style="width: 30%;">Item</th>
                                    <th style="width: 10%;">Store <br> Quantity</th>
                                    <th style="width: 10%;">Pending <br> Requests</th>
                                    <th style="width: 10%;">Available <br> Quantity</th>
                                    <th style="width: 10%;">Requested <br> Quantity (Dept)</th>
                                    <th style="width: 10%;">Recommended <br> Quantity (Store)</th>
                                    <th style="width: 15%;">Approved <br> Quantity</th>
                                    {{-- <th style="width: 20%;">Status</th> --}}
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
                    return '<span class="label label-danger">Rejected</span>';
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
                var colspan = isPending ? 8 : 7;

                var totalStoreQty = 0;
                var totalPendingQty = 0;
                var totalAvailableQty = 0;
                var totalRequestedQty = 0;
                var totalRecommendedQty = 0;

                if (isPending) {
                    $('#modal-action-th').show();
                } else {
                    $('#modal-action-th').hide();
                }

                if (!items.length) {
                    $('#modal-no-items').show();
                    html = '<tr><td colspan="' + colspan + '" class="text-center">No items found.</td></tr>';
                } else {
                    $('#modal-no-items').hide();

                    $.each(items, function(index, item) {
                        var storeQty = parseInt(item.quantity_in_store, 10) || 0;
                        var pendingQty = parseInt(item.quantity_on_ground, 10) || 0;
                        var availableQty = parseInt(item.available_quantity, 10) || 0;
                        var requestedQty = parseInt(item.quantity, 10) || 0;
                        var recommendedQty = parseInt(item.recommendedQty, 10) || 0;

                        totalStoreQty += storeQty;
                        totalPendingQty += pendingQty;
                        totalAvailableQty += availableQty;
                        totalRequestedQty += requestedQty;
                        totalRecommendedQty += recommendedQty;

                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';

                        html += '<td>';
                        html += '<strong>' + (item.item_name ? item.item_name : 'N/A') + '</strong>';
                        if (item.specifications) {
                            html += '<br><small>' + renderSpecifications(item.specifications) + '</small>';
                        }
                        html += '</td>';

                        html += '<td>' + storeQty + '</td>';
                        html += '<td>' + pendingQty + '</td>';
                        html += '<td>' + availableQty + '</td>';
                        html += '<td>' + requestedQty + '</td>';
                        html += '<td>' + recommendedQty + '</td>';

                        if (isPending) {
                            html += `
                    <td>
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

                    // html += '<tr style="background: #f9f9f9; font-weight: 600;">';
                    // html += '<td colspan="2" class="text-right">Grand Total</td>';
                    // html += '<td>' + totalStoreQty + '</td>';
                    // html += '<td>' + totalPendingQty + '</td>';
                    // html += '<td>' + totalAvailableQty + '</td>';
                    // html += '<td>' + totalRequestedQty + '</td>';
                    // html += '<td>' + totalRecommendedQty + '</td>';

                    // if (isPending) {
                    //     html += '<td></td>';
                    // }

                    // html += '</tr>';
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
        });
    </script>
@endsection
