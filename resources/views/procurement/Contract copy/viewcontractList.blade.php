@extends('layouts.app')
@section('pageTitle', 'Contract List')
@section('content')

        <div class="row">
            <div class="col-md-12">
                 @include('ShareView.operationCallBackAlert')
                <div class="card">
                    <div class="card-body">
                        
                        <hr />

                        <div class="row">
                            <div align="left" class="form-group col-md-12">
                                <table id="datatable-buttonsxx" class="table-responsive table table-striped table-bordered dt-responsive nowrap"  width="900">
                                    <thead>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Lot No.</th>
                                            <td>{{  $item->lot_number  }}</td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Sublot No.</th>
                                            <td>{{  $item->sublot_number  }}</td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Contract Name</th>
                                            <td>{{ $item->contract_name }}</td>
                                        </tr>
                                        <tr valign="top">
                                            <th style="font-weight:bold;background-color:grey;color:#fff;">Description</th>
                                            <td> 
                                           
                                                {!! $item->contract_description !!} 
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Category</th>
                                            <td>{{ $item->category_name }}</td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Proposed Budget</th>
                                            <td align="left">{{ number_format($item->proposed_budget, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Approval Date</th>
                                            <td>{{ $item->approval_date ? date('jS M Y', strtotime($item->approval_date)) : ' - ' }}</td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Review Date</th>
                                            <td>{{ $item->review_date ? date('jS M Y', strtotime($item->review_date)) : ' - ' }}</td>
                                        </tr>
                                        <tr>
                                            <th style="font-weight:bold;background-color:grey;color:#fff">Time Frame</th>
                                            <td>{{ $item->proposed_time_frame ? date('jS M Y', strtotime($item->proposed_time_frame)) : ' - ' }}</td>
                                        </tr>
                                        
                                    </thead>
                                    
                                    
                                </table>
                                
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
    </div>
    

@endsection

@section('styles')
@endsection

@section('scripts')
@endsection
