@extends('layouts_procurement.app')
@section('pageTitle', 'Job Orders')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Job Orders</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('job-order.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Create New Job Order
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <!-- Filter/Search Section -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('job-order.index') }}" method="GET" class="form-inline pull-right">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control input-sm" 
                                       placeholder="Search by JO number or department..." value="{{ request('search') }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>JO Number</th>
                                <th>Department</th>
                                <th>Station</th>
                                <th>Order Date</th>
                                <th>Estimated Cost</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $n = ($jobOrders->currentPage() - 1) * $jobOrders->perPage() + 1; @endphp
                            @forelse ($jobOrders as $job)
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>
                                        <strong>{{ $job->job_order_number }}</strong>
                                        @if($job->job_order_no)
                                            <br><small>No: {{ $job->job_order_no }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $job->department ?? 'N/A' }}</td>
                                    <td>{{ $job->station ?? 'N/A' }}</td>
                                    <td>{{ date('d M, Y', strtotime($job->order_date)) }}</td>
                                    <td class="text-right">₦{{ number_format($job->estimated_cost, 2) }}</td>
                                    <td>
                                        @if($job->status == 'draft')
                                            <span class="label label-warning">Draft</span>
                                        @elseif($job->status == 'issued')
                                            <span class="label label-info">Issued</span>
                                        @elseif($job->status == 'completed')
                                            <span class="label label-success">Completed</span>
                                        @elseif($job->status == 'cancelled')
                                            <span class="label label-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{ route('job-order.show', $job->job_order_id) }}" 
                                               class="btn btn-info" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($job->status == 'draft')
                                                <a href="{{ route('job-order.edit', $job->job_order_id) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('job-order.print', $job->job_order_id) }}" 
                                               target="_blank"
                                               class="btn btn-default" title="Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @if($job->status == 'draft')
                                                <button type="button" 
                                                        class="btn btn-danger" 
                                                        title="Delete"
                                                        onclick="deleteJobOrder({{ $job->job_order_id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="alert alert-info mb-0">
                                            <i class="fa fa-info-circle"></i> No Job Orders found
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $jobOrders->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .label {
        font-size: 11px;
        padding: 5px 8px;
    }
    .btn-group-xs > .btn {
        padding: 3px 8px;
        font-size: 11px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteJobOrder(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this Job Order? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/procurement/job-order/${id}`;
                form.style.display = 'none';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection