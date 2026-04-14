@extends('layouts_procurement.app')
@section('pageTitle', 'Local Purchase Orders')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Local Purchase Orders (LPO)</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('lpo.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Create New LPO
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <!-- Filter/Search Section -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('lpo.index') }}" method="GET" class="form-inline pull-right">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control input-sm" 
                                       placeholder="Search by LPO number or supplier..." value="{{ request('search') }}">
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
                                <th>LPO Number</th>
                                <th>Supplier Name</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $n = ($lpos->currentPage() - 1) * $lpos->perPage() + 1; @endphp
                            @forelse ($lpos as $lpo)
                                @php
                                    $items = json_decode($lpo->items, true);
                                    $itemCount = is_array($items) ? count($items) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>
                                        <strong>{{ $lpo->lpo_number }}</strong>
                                    </td>
                                    <td>{{ $lpo->supplier_name }}</td>
                                    <td>{{ date('d M, Y', strtotime($lpo->order_date)) }}</td>
                                    <td>{{ $lpo->delivery_date ? date('d M, Y', strtotime($lpo->delivery_date)) : 'N/A' }}</td>
                                    <td class="text-right">₦{{ number_format($lpo->total_amount, 2) }}</td>
                                    <td>
                                        @if($lpo->status == 'draft')
                                            <span class="label label-warning">Draft</span>
                                        @elseif($lpo->status == 'issued')
                                            <span class="label label-info">Issued</span>
                                        @elseif($lpo->status == 'delivered')
                                            <span class="label label-success">Delivered</span>
                                        @elseif($lpo->status == 'cancelled')
                                            <span class="label label-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{ route('lpo.show', $lpo->lpo_id) }}" 
                                               class="btn btn-info" title="View LPO">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($lpo->status == 'draft')
                                                <a href="{{ route('lpo.edit', $lpo->lpo_id) }}" 
                                                   class="btn btn-warning" title="Edit LPO">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('lpo.print', $lpo->lpo_id) }}" 
                                               target="_blank"
                                               class="btn btn-default" title="Print LPO">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @if($lpo->status == 'draft')
                                                <button type="button" 
                                                        class="btn btn-danger" 
                                                        title="Delete LPO"
                                                        onclick="deleteLPO({{ $lpo->lpo_id }})">
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
                                            <i class="fa fa-info-circle"></i> No LPOs found
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
                        {{ $lpos->links() }}
                    </div>
                </div>

            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col-md-12 -->
</div> <!-- row -->

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
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteLPO(lpoId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this LPO? This action cannot be undone.",
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
                form.action = `/procurement/lpo/${lpoId}`;
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