@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('APPROVED ITEM REQUESTS FOR ISSUANCE') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ strtoupper('CR APPROVED ITEM REQUESTS') }}</h4>
                </div>

                <div class="panel-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (($userUserDept && $userUserDept->departmentID == 28) || $user->is_global == 1)
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-12">
                                <form method="GET" action="{{ url()->current() }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Filter by Department</label>
                                            <select name="departmentId" class="form-control" onchange="this.form.submit()">
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
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Total Items</th>
                                    <th>Approved <br> Quantity (Dept)</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="label label-success">{{ $row->cr_code ?: 'N/A' }}</span>
                                        </td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->department ?: 'N/A' }}</td>
                                        <td>{{ $row->total_items }}</td>
                                        <td>{{ $row->total_approved_qty ?? 0 }}</td>
                                        {{-- <td>{{ $row->created_by_name ?: 'N/A' }}</td> --}}
                                        <td>{{ date('d M Y h:i A', strtotime($row->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('approved-item-request-view', $row->id) }}"
                                                class="btn btn-primary btn-xs">
                                                <i class="fa fa-eye"></i>
                                                {{ $row->status == 3 ? 'Review & Issue' : 'View' }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No record found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

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
@endsection
