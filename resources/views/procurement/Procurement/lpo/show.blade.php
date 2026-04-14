@extends('layouts_procurement.app')
@section('pageTitle', 'Local Purchase Order')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h3 class="panel-title"><b>Local Purchase Order: {{ $lpo->lpo_number }}</b></h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('lpo.index') }}" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('lpo.print', $lpo->lpo_id) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fa fa-print"></i> Print
                    </a>
                    @if($lpo->status == 'draft')
                        <a href="{{ route('lpo.edit', $lpo->lpo_id) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    @endif
                </div>
            </div>

            <div class="panel-body">
                @include('ShareView.operationCallBackAlert')

                <!-- LPO Header -->
                <div class="well well-sm text-center" style="background-color: #00a65a; color: white;">
                    <h2>LOCAL PURCHASE ORDER</h2>
                    <h4>LPO Number: {{ $lpo->lpo_number }}</h4>
                </div>

                <!-- Authority Section -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Authority for Local Purchase</h3>
                    </div>
                    <div class="panel-body">
                        <p>Please supply for the use of this Department: (Articles not supplied should be deleted and the form should be returned if no supply is made).</p>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Items to Purchase</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Unit Price (₦)</th>
                                        <th>Total (₦)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item['description'] }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td>{{ $item['unit'] ?? 'pcs' }}</td>
                                        <td class="text-right">₦{{ number_format($item['unit_price'], 2) }}</td>
                                        <td class="text-right">₦{{ number_format($item['total'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">GRAND TOTAL:</th>
                                        <th class="text-right">₦{{ number_format($lpo->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Signatures Section -->
                <div class="row">
                    <!-- Section A: HOD Signature -->
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Section A - Head of Department</h3>
                            </div>
                            <div class="panel-body">
                                <p><strong>I certify that the stores mentioned above have been received and have been applied to the purpose for which they were bought.</strong></p>
                                <hr>
                                <p><strong>Allocation Head:</strong> {{ $lpo->allocation_head ?? '________________' }}</p>
                                <p><strong>Sub-head:</strong> {{ $lpo->sub_head ?? '________________' }}</p>
                                <hr>
                                <p><strong>Head of Department:</strong> {{ $lpo->head_of_department_name ?? '________________' }}</p>
                                <p><strong>Date:</strong> {{ $lpo->hod_date ? date('d M, Y', strtotime($lpo->hod_date)) : '________________' }}</p>
                                
                                @if(!$lpo->head_of_department_name && $lpo->status == 'issued')
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#hodModal">
                                    <i class="fa fa-pencil"></i> Sign as HOD
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Section B: Store Keeper -->
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Section B - Store Keeper</h3>
                            </div>
                            <div class="panel-body">
                                <p><strong>TO THE STORE KEEPER:</strong> The Stores listed above should be taken on Charge in your stores ledger.</p>
                                <hr>
                                <p><strong>Head of Department:</strong> {{ $lpo->head_of_department_name ?? '________________' }}</p>
                                <hr>
                                <p><strong>Store Keeper:</strong> {{ $lpo->store_keeper_name ?? '________________' }}</p>
                                <p><strong>Date:</strong> {{ $lpo->store_keeper_date ? date('d M, Y', strtotime($lpo->store_keeper_date)) : '________________' }}</p>
                                
                                @if($lpo->head_of_department_name && !$lpo->store_keeper_name && $lpo->status == 'issued')
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#storeModal">
                                    <i class="fa fa-pencil"></i> Receive Goods
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Section C: Receiving Officer -->
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Section C - Receiving Officer</h3>
                            </div>
                            <div class="panel-body">
                                <p><strong>I certify that the above-mentioned stores have been received and taken on store-ware under SERV. NO.</strong></p>
                                <hr>
                                <p><strong>SERV. NO.:</strong> {{ $lpo->store_serv_no ?? '________________' }}</p>
                                <hr>
                                <p><strong>Receiving Officer:</strong> {{ $lpo->receiving_officer_name ?? '________________' }}</p>
                                <p><strong>Date:</strong> {{ $lpo->receiving_date ? date('d M, Y', strtotime($lpo->receiving_date)) : '________________' }}</p>
                                
                                <p class="text-muted"><small>Note: 1. Where (b) is applicable by should be deleted and free words. 2. Delete portion not applicable in (c).</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="text-center" style="margin-top: 20px;">
                    <span class="label label-{{ 
                        $lpo->status == 'draft' ? 'warning' : 
                        ($lpo->status == 'issued' ? 'info' : 
                        ($lpo->status == 'delivered' ? 'success' : 'danger')) 
                    }} label-lg" style="font-size: 16px; padding: 10px;">
                        Status: {{ strtoupper($lpo->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HOD Signature Modal -->
<div class="modal fade" id="hodModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('lpo.sign-hod', $lpo->lpo_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Head of Department Signature</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="hod_name">Your Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="hod_name" name="hod_name" required>
                    </div>
                    <div class="form-group">
                        <label for="allocation_head">Allocation Head</label>
                        <input type="text" class="form-control" id="allocation_head" name="allocation_head">
                    </div>
                    <div class="form-group">
                        <label for="sub_head">Sub-head</label>
                        <input type="text" class="form-control" id="sub_head" name="sub_head">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Signature</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Store Keeper Modal -->
<div class="modal fade" id="storeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('lpo.receive-goods', $lpo->lpo_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Receive Goods</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="store_keeper_name">Store Keeper Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="store_keeper_name" name="store_keeper_name" required>
                    </div>
                    <div class="form-group">
                        <label for="store_serv_no">SERV. No.</label>
                        <input type="text" class="form-control" id="store_serv_no" name="store_serv_no">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Confirm Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection