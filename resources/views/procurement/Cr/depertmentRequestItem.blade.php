@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper(' List of Department Request Items') }}
    {{-- {{ strtoupper('List of Request Items') }} --}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card Style -->
            <div class="panel panel-default" style="border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

                <div class="panel-heading" style="padding: 15px; background: #f5f5f5; border-bottom: 1px solid #ddd;">
                    {{-- <h4 class="panel-title" style="margin: 0; font-weight: bold;">
                        @yield('pageTitle')
                        <span>{{ $items->first()->departmentName ?? 'N/A' }}</span>



                    </h4> --}}
                    <h4 class="panel-title" style="margin: 0; font-weight: bold;">
                        @yield('pageTitle')

                        <span class="label label-info" style="margin-left: 10px; font-size: 12px;">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            {{-- {{ $items->first()->departmentName ?? 'N/A' }} --}}
                            {{ $departmentName ?? 'N/A' }}
                        </span>
                    </h4>



                    <div style="float: right; margin-top: -20px; font-size: 12px;">
                        All fields with <span class="text-danger">*</span> are required.
                    </div>
                    <div style="clear: both;"></div>
                </div>

                <div class="panel-body">

                    @include('procurement.ShareView.operationCallBackAlert')

                    <!-- Search Form -->
                    <form method="GET" class="form-inline" style="margin-bottom: 15px;">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Search department, item or user">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                    @php
                        $isAdmin = in_array(Auth::user()->divisionID, [1, 15]);
                    @endphp

                    <table class="table table-bordered table-striped">
                        <thead style="background: #333; color: #fff;">
                            <tr>
                                <th>SN</th>
                                {{-- <th>Department</th> --}}
                                <th>Item</th>
                                <th>Request Quantity</th>
                                <th>Delivered Quantity</th>
                                <th>Status</th>

                                {{-- @if ($isAdmin)
                                    <th>Created By</th>
                                    <th colspan="2">Action</th>
                                @endif --}}
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($items as $key => $row)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    {{-- <td>{{ $row->departmentName }}</td> --}}
                                    <td>{{ $row->itemName }}</td>
                                    <td>{{ $row->quantity }}</td>
                                    <td>{{ $row->deliveredQuantity ?? 0 }}</td>

                                    <td style="width: 100px">
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

                                    {{-- @if ($isAdmin)
                                        <td>{{ $row->createdByName ?? 'N/A' }}</td>

                                        @if ($row->status == 0)
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#acceptModal{{ $row->id }}">
                                                    Accept
                                                </a>
                                            </td>

                                            <td>
                                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#rejectModal{{ $row->id }}">
                                                    Reject
                                                </a>
                                            </td>
                                        @else
                                            <td colspan="2" class="text-center text-muted">—</td>
                                        @endif
                                    @endif --}}
                                </tr>

                                <!-- Accept Modal -->
                                @if ($isAdmin && $row->status == 0)
                                    <div class="modal fade" id="acceptModal{{ $row->id }}">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('item-request.updateStatus') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $row->id }}">
                                                <input type="hidden" name="action" value="accept">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Confirm Accept</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure you want to accept this request?
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            Yes, Accept
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <!-- Reject Modal -->
                                @if ($isAdmin && $row->status == 0)
                                    <div class="modal fade" id="rejectModal{{ $row->id }}">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('item-request.updateStatus') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $row->id }}">
                                                <input type="hidden" name="action" value="reject">

                                                <div class="modal-content">
                                                    <div class="modal-header" style="background: #d9534f; color: #fff;">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Confirm Rejection</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure you want to reject this request?
                                                        This action cannot be undone.
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            Yes, Reject
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                @endif

                                @empty

                                    <tr>
                                        <td colspan="{{ $isAdmin ? 9 : 7 }}" class="text-center">
                                            No item requests found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div> <!-- panel-body -->
                </div> <!-- panel -->

            </div>
        </div>

        <!-- Pagination -->
        <div class="text-center" style="margin-top: 20px;">
            {{ $items->links() }}
        </div>
    @endsection

    @section('styles')
    @endsection

    @section('scripts')
    @endsection
