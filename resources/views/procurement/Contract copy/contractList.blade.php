@extends('layouts.app')
@section('pageTitle', 'Contract List')
@section('content')

        <div class="row">
            <div class="col-md-12">
                 @include('ShareView.operationCallBackAlert')
                <div class="card">
                    <div class="card-body">
                        
                        {{-- <!--Start Search d-none d-lg-block--> --}}
                        <div class="header-search col-md-12 col-xl-12 col-lg-12">
                            <div class="search-header-w">
                                <div class="btn btn-search-mobi d-lg-none d-md-block" >
                                    <i class="fa fa-search"></i>
                                </div>
                                <div class="form_search offset-md-2">
                                    <form class="formSearch" action="{{(Route::has('searchContractReport') ? Route('searchContractReport') : '#' )}}" method="get">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input class="form-control" type="search" name="q" id="txtSearchJquery" placeholder="Enter keywords here... " autocomplete="on" />
                                            </div>
                                            <div class="col-md-5 mt-2">
                                                <label>Start Date</label>
                                                <input class="form-control" type="date" name="startDate" placeholder="Select Date" />
                                            </div>
                                            <div class="col-md-5 mt-2">
                                                <label>End Date</label>
                                                <input class="form-control" type="date" name="endDate" placeholder="Select Date" />
                                            </div>
                                            <div class="col-md-10 mt-2" align="right">
                                                <button class="btn btn-success" type="submit" >
                                                    <span class="btnSearchText d-none d-lg-block">Search</span>
                                                    <i class="fa fa-search d-lg-none"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="pl-3 pr-3" style="position: absolute; width:100%; overflow: hidden; max-height: 500px; border-radius: 0 0 4px 4px; background: #ffffff; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" >
                                            <table id="tblSearchGet">
                                                <tbody class="bg-light">
                                                    <tr></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <br />
                        {{-- <!--End Search --> --}}
                        
            
                        <h4 class="card-title">View All Contracts List</h4>
                        <hr />

                        <div class="row">
                            <div align="left" class="form-group mb-0 col-md-12">
                                <table id="" class="table-responsive table-hover table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>LOT</th>
                                            <th>SUBLOT</th>
                                            <th>Contract Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            {{-- <th>Approval Date</th>
                                            <th>Review Date</th>
                                            <th>Time Frame</th> --}}
                                            <!--<th>Updated On</th>-->
                                            <!--<th>Created By</th>-->
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($getContractDetails) && is_iterable($getContractDetails))
                                        @foreach($getContractDetails as $key=>$item)
                                        <tr>
                                            <td>{{ ($key + 1) }}</td>
                                            <td class="text-success"><b>{{ $item->lot_number }}</b></td> 
                                            <td class="text-success"><b>{{ $item->sublot_number }}</b></td> 
                                            <td class="text-dark"><b>{{ $item->contract_name }}</b></td>
                                            <td width="200">
                                                {{ ($item->contract_description ? substr($item->contract_description, 0, 100) : ' - ') }} 
                                                @if(strlen($item->contract_description) > 100)
                                                    ... <a href="javascript:;" class="text-info" data-toggle="modal" data-target=".viewMoreDescription{{$key}}">View more</a>
                                                @endif
                                            </td>
                                            <td>{{ $item->category_name }}</td>
                                            <td class="text-right text-info"><b>&#8358;{{ number_format($item->proposed_budget, 2) }} </b></td>
                                            {{-- <td>{{ $item->approval_date ? date('jS M Y', strtotime($item->approval_date)) : ' - ' }}</td>
                                            <td>{{ $item->review_date ? date('jS M Y', strtotime($item->review_date)) : ' - ' }}</td>
                                            <td>{{ $item->proposed_time_frame ? date('jS M Y', strtotime($item->proposed_time_frame)) : ' - ' }}</td> --}}
                                            <!--<td>{{ date('jS M Y', strtotime($item->updated_at)) }}</td>-->
                                            <!--<td>{{ $item->name }}</td>-->
                                            <td class="{!! (($item->status_name == "Disabled" || $item->status_name == "Rejected") ? 'text-danger' : 'text-success') !!}">{{ $item->status_name }}</td>
                                            
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
    <script>
        $(document).ready(function(){
            var table = $('#tblSearchGet'); //
           $("#txtSearchJquery").keyup(function()
           {
                var str =  $("#txtSearchJquery").val();
                    //$('#tblSearchGet').append("<tbody><tr style='background: #ffffff;'><td></td></tr></tbody>");
                if(str.length == 0) {
                    table.find("tbody tr").remove();
                    //$('#tblSearchGet').append("<tr><td align='center' class='text-danger'><b>No match found...</b></td></tr>");
                }else {
                    $.get( "{{ url('/search-contract-from-db-JSON/') }}" + '/' + str, function( data )
                    {
                        var table = $('#tblSearchGet'); //
                        table.find("tbody tr").remove();
                        if(data)
                        {
                            $.each(data, function (index, value)
                            {
                                table.append("<tbody><tr style='background: #ffffff;'><td class='p-3 h5 font-weight-bolder' align='left'><a href='{{url('/')}}/collection/" + value.category.replace(' ', '+') +"' class='text-left'>" + value.product_name +"</a></td></tr></tbody>");
                            });
                        }else{
                            table.find("tbody tr").remove();
                        }
                    });
               }
           });

        });
        /* //END LIVE SEARCH */
    </script>
@endsection
