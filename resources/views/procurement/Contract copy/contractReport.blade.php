@extends('layouts.app')
@section('pageTitle', 'Contract Report')
@section('content')

        <div class="row">
            <div class="col-md-12">
                 @include('ShareView.operationCallBackAlert')
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">View All Contracts</h4>
                        <hr />

                        <div class="row">
                            <div align="left" class="form-group mb-0 col-md-12">
                                <table id="" class="table-responsive table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>LOT</th>
                                            <th>SUBLOT</th>
                                            <th>Contract Name</th>
                                            <th>Category</th>
                                            <th>Proposed Budget</th>
                                            <th>Description</th>
                                            <th>Approval Date</th>
                                            <th>Review Date</th>
                                            <th>Time Frame</th>
                                            <th>Contractor</th>
                                            <!--<th>Created By</th>-->
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($getContractDetails) && is_iterable($getContractDetails))
                                        @foreach($getContractDetails as $key=>$item)
                                        <tr>
                                            <td>{{ ($key + 1) }}</td>
                                            <td>{{ $item->lot_number }}</td>
                                            <td>{{ $item->sublot_number }}</td>
                                            <td>{{ $item->contract_name }}</td>
                                            <td>{{ $item->category_name }}</td>
                                            <td>{{ number_format($item->proposed_budget, 2) }}</td>
                                            <td width="200">
                                                {{ ($item->contract_description ? substr($item->contract_description, 0, 100) : ' - ') }} 
                                                @if(strlen($item->contract_description) > 100)
                                                    ... <a href="javascript:;" class="text-info" data-toggle="modal" data-target=".viewMoreDescription{{$key}}">View more</a>
                                                @endif
                                            </td>
                                             <td>{{ $item->approval_date ? date('jS M Y', strtotime($item->approval_date)) : ' - ' }}</td>
                                            <td>{{ $item->review_date ? date('jS M Y', strtotime($item->review_date)) : ' - ' }}</td>
                                            <td>{{ $item->proposed_time_frame ? date('jS M Y', strtotime($item->proposed_time_frame)) : ' - ' }}</td>
                                            <!--<td>{{ $item->name }}</td>-->
                                            <td>{{ $item->status_name }}</td>
                                            <td>{{$item->contractor}}</td>
                                            
                                        </tr> 
                                        
                                                <!--  Modal View More -->
                                                <div class="modal fade viewMoreDescription{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xs">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">View More</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-left">{{ $item->contract_name}}</div>
                                                                <hr />
                                                                <p class="text-left">{{ $item->contract_description }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                
                                                <!--  Modal deletion -->
                                                <div class="modal fade deleteCategory{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xs">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">Confirm!</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-primary">Delete: {{ $item->contract_name . ' - ' .$item->category_name }}</p>
                                                                <p class="text-danger">Are you sure you want to delete this record?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                                                <a href="{{ route('deleteContractDetails', ['id'=> base64_encode($item->contract_detailsID) ]) }}" class="btn btn-warning waves-effect waves-light">Delete</a>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if(isset($getContractDetails) && is_iterable($getContractDetails))
                                    <div align="right" class="col-md-12"><hr />
                                        Showing {{($getContractDetails->currentpage()-1)*$getContractDetails->perpage()+1}}
                                            to {{$getContractDetails->currentpage()*$getContractDetails->perpage()}}
                                            of  {{$getContractDetails->total()}} entries
                                    </div>
                                    <div class="d-print-none text-right">{{ $getContractDetails->links() }}</div>
                                @endif
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
