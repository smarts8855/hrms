@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('List of Request Items') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">

                <!-- Panel Header -->
                <div class="panel-heading">
                    <h4 class="panel-title">@yield('pageTitle')</h4>
                </div>

                <!-- Panel Body -->
                <div class="panel-body">
                    {{--
                    <div class="text-right">
                        All fields with <span class="text-danger">*</span> are required.
                    </div> --}}

                    <hr>

                    <div>
                        @include('procurement.ShareView.operationCallBackAlert')
                    </div>

                    {{-- @php
                        $isAdmin = in_array(Auth::user()->user_role, [2, 13]);
                    @endphp --}}

                    <!-- TABLE -->
                    <table class="table table-bordered mt-2">
                        <thead style="background:#343a40;   color: #f3f3f3">
                            <tr>
                                <th>SN</th>
                                <th>Department</th>
                                <th>Item</th>
                                <th>Request Quantity</th>
                                <th>Delivered Quantity</th>
                                <th>Status</th>
                                {{-- @if ($isAdmin)
                                    <th>Created By</th>
                                    <th colspan="2">Action</th>
                                @endif --}}
                                <th>Created By</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($items as $key => $row)
                                <tr @if ($row->status == 3) class="bg-success text-white" @endif>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->departmentName }}</td>
                                    <td>{{ $row->itemName }}</td>
                                    <td>{{ $row->quantity }}</td>
                                    <td>{{ $row->deliveredQuantity ?? 0 }}</td>

                                    <td>
                                        @switch($row->status)
                                            @case(0)
                                                <span class="label label-warning">Pending</span>
                                            @break

                                            @case(1)
                                                <span class="label label-primary">Accepted</span>
                                            @break

                                            @case(2)
                                                <span class="label label-danger">Rejected</span>
                                            @break

                                            @case(3)
                                                <span class="label label-success">Delivered</span>
                                            @break
                                        @endswitch
                                    </td>


                                    <td>{{ $row->createdByName ?? 'N/A' }}</td>

                                    {{-- Pending --}}
                                    @if ($row->status == 0)
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#acceptModal{{ $row->id }}">
                                                Accept
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('item-request.updateStatus') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $row->id }}">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </td>

                                        {{-- Accepted --}}
                                    @elseif ($row->status == 1)
                                        <td colspan="2">
                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#deliverModal{{ $row->id }}">
                                                Approve & Deliver
                                            </button>
                                        </td>

                                        {{-- Delivered --}}
                                    @elseif ($row->status == 3)
                                        <td colspan="2" class="text-center text-success">
                                            ✔ Delivered
                                        </td>

                                        {{-- Default --}}
                                    @else
                                        <td colspan="2" class="text-center text-muted">—</td>
                                    @endif

                                </tr>

                                <!-- Accept Modal -->
                                @if ($row->status == 0)
                                    <div class="modal fade" id="acceptModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('item-request.updateStatus') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $row->id }}">
                                                <input type="hidden" name="action" value="accept">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Confirm Accept</h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure you want to accept this request?
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Yes, Accept</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <!-- Deliver Modal -->
                                @if ($row->status == 1)
                                    <div class="modal fade" id="deliverModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('item-request.updateStatus') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $row->id }}">
                                                <input type="hidden" name="action" value="deliver">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Deliver Item</h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <label>Requested Quantity:</label>
                                                        <input type="number" class="form-control" readonly
                                                            value="{{ $row->quantity }}">

                                                        <label class="mt-2">Remaining in Store:</label>
                                                        <input type="number" class="form-control" readonly
                                                            value="{{ $row->store_remainingQuantity ?? 0 }}">

                                                        <label class="mt-2">Deliver Quantity:</label>
                                                        <input type="number" name="availableQuantity" class="form-control"
                                                            required min="1">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Deliver</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No item requests found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Pagination -->
                <div class="text-center mt-3">
                    {{ $items->links() }}
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
            function submitDelivery(e, id) {
                e.preventDefault();

                const availableQty = document.getElementById('availableQuantity' + id).value;

                $.ajax({
                    url: "{{ route('item-request.updateStatus') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        action: 'deliver',
                        availableQuantity: availableQty
                    },
                    success: function(response) {
                        $('#deliverModal' + id).modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        </script>
    @endsection
