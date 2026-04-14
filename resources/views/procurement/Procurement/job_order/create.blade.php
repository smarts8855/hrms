@extends('layouts_procurement.app')
@section('pageTitle', 'Create Job Order')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Create Job Order</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('job-order.index') }}" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <div class="well well-sm" style="background-color: #00a65a; color: white;">
                    <h4 style="margin: 0;">JOB ORDER - {{ $jobOrderNumber }}</h4>
                </div>

                <form action="{{ route('job-order.store') }}" method="POST" id="jobOrderForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="job_order_no">Job Order No.</label>
                                <input type="text" class="form-control" id="job_order_no" 
                                       name="job_order_no" value="{{ old('job_order_no') }}" 
                                       placeholder="e.g., 10900">
                                <small class="text-muted">Original No: ______</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" 
                                       name="department" value="{{ old('department') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="station">Station</label>
                                <input type="text" class="form-control" id="station" 
                                       name="station" value="{{ old('station') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order_date">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="order_date" 
                                       name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Item Details</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="item_description">Please undertake to repair/supply/implement the under mentioned item/items <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="item_description" 
                                          name="item_description" rows="5" 
                                          placeholder="Describe the items to be repaired/supplied/implemented..."
                                          required>{{ old('item_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Cost Estimates</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estimated_cost">Estimated Cost (₦) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="estimated_cost" 
                                               name="estimated_cost" value="{{ old('estimated_cost', 0) }}" 
                                               min="0" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_in_words">Amount in Words</label>
                                        <input type="text" class="form-control" id="amount_in_words" 
                                               name="amount_in_words" value="{{ old('amount_in_words') }}" 
                                               placeholder="e.g., One Million Naira Only">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-save"></i> Create Job Order
                        </button>
                        <button type="reset" class="btn btn-default btn-lg">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Convert number to words (simple version)
        $('#estimated_cost').on('input', function() {
            let amount = $(this).val();
            if (amount && amount > 0) {
                // You can implement a more sophisticated number-to-words conversion here
                // For now, just show a placeholder
                $('#amount_in_words').val('_____ Naira _____ Kobo');
            }
        });

        // Form validation
        $('#jobOrderForm').on('submit', function(e) {
            if ($('#item_description').val().trim() === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please provide item description.'
                });
            }
        });
    });
</script>
@endsection