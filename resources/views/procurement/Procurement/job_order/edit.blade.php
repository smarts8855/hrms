@extends('layouts_procurement.app')
@section('pageTitle', 'Edit Job Order')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Edit Job Order: {{ $jobOrder->job_order_number }}</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('job-order.show', $jobOrder->job_order_id) }}" class="btn btn-sm btn-info">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="{{ route('job-order.index') }}" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i> 
                    <strong>Note:</strong> You are editing a draft Job Order.
                </div>

                <form action="{{ route('job-order.update', $jobOrder->job_order_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="job_order_no">Job Order No.</label>
                                <input type="text" class="form-control" id="job_order_no" 
                                       name="job_order_no" value="{{ old('job_order_no', $jobOrder->job_order_no) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" 
                                       name="department" value="{{ old('department', $jobOrder->department) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="station">Station</label>
                                <input type="text" class="form-control" id="station" 
                                       name="station" value="{{ old('station', $jobOrder->station) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order_date">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="order_date" 
                                       name="order_date" value="{{ old('order_date', $jobOrder->order_date) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Item Details</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="item_description">Item Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="item_description" 
                                          name="item_description" rows="5" required>{{ old('item_description', $jobOrder->item_description) }}</textarea>
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
                                               name="estimated_cost" value="{{ old('estimated_cost', $jobOrder->estimated_cost) }}" 
                                               min="0" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_in_words">Amount in Words</label>
                                        <input type="text" class="form-control" id="amount_in_words" 
                                               name="amount_in_words" value="{{ old('amount_in_words', $jobOrder->amount_in_words) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-save"></i> Update Job Order
                        </button>
                        <a href="{{ route('job-order.show', $jobOrder->job_order_id) }}" class="btn btn-default btn-lg">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection