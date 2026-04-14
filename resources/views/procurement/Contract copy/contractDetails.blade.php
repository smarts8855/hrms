@extends('layouts.app')
@section('pageTitle', 'Contract Details')
@section('content')

    <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Create New Contract</h4>
                            <div align="right" > All fields with <span class="text-danger">*</span> are required.</div>
                            <hr />
                            <div>
                                @include('ShareView.operationCallBackAlert')
                            </div>
                            <form class="custom-validation formFormatAmount" method="POST" action="{{ route('postDetails') }}">
                                 @csrf
                                        <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label>Lot Number <span class="text-danger"> </span></label>
                                                    <div>
                                                        <input type="text" name="lotNumber" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->lot_number : old('lotNumber')) }}" autofocus class="form-control" placeholder="Lot Number"/>
                                                    </div>
                                                </div>
                                                 <div class="form-group col-md-3">
                                                    <label>Sublot Number <span class="text-danger"> </span></label>
                                                    <div>
                                                        <input type="text" name="sublotNumber" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->sublot_number : old('sublotNumber')) }}" autofocus class="form-control" placeholder="Sublot Number"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Procurement Type <span class="text-danger">*</span></label>
                                                    <select name="procurementType" class="form-control" required>
                                                        <option value=""> Select </option>
                                                        @if(isset($getProcurementType) && $getProcurementType)
                                                            @foreach($getProcurementType as $typeKey=>$item)
                                                                <option value="{{ $item->procurement_typeID }}" {{ ((isset($editRecord) && ($editRecord->procurement_typeID == $item->procurement_typeID)) || (old('procurementType') == $item->procurement_typeID) ? 'selected' : '') }}> {{ $item->type }} </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                             <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Contract Title <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="text" name="contractTitle" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->contract_name : old('contractTitle')) }}" required autofocus class="form-control" placeholder="Contract Title"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Contract Category <span class="text-danger">*</span></label>
                                                    <select name="contractCategory" class="form-control" required>
                                                        <option value=""> Select </option>
                                                        @if(isset($getContractCategory) && $getContractCategory)
                                                        @foreach($getContractCategory as $cKey=>$item)
                                                            <option value="{{ $item->contractCategoryID }}" {{ (isset($editRecord) && ($editRecord->contractCategoryID == $item->contractCategoryID)  || (old('contractCategory') == $item->contractCategoryID) ? 'selected' : '') }}> {{ $item->category_name }} </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Amount</label>
                                                    <div> {{--  format-amount --}}
                                                        <input type="text" id="formatAmountOnKeyPress" name="proposedAmount" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->proposed_budget : old('proposedAmount')) }}" data-parsley-type="text"  class="form-control" placeholder="Amount"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Bid Opening Date</label>
                                                    <div>
                                                        <input type="date" name="biddingDate" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->bidding_date : old('biddingDate')) }}" data-parsley-type="date"  class="form-control" placeholder="Select Date"/>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label>Date Advert Published</label>
                                                    <div>
                                                        <input type="date" name="advertDate" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->advert_date : old('advertDate')) }}" data-parsley-type="date"  class="form-control" placeholder="Select Date"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Approval Date</label>
                                                    <div>
                                                        <input type="date" name="approvalDate" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->submission_date : old('approvalDate')) }}" max="{{date('Y-m-d')}}" data-parsley-type="date"  class="form-control" placeholder="Approval Date"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Proposed Time Frame</label>
                                                    <div>
                                                        <input type="date" name="timeFrame" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->proposed_time_frame : old('timeFrame')) }}" min="{{date('Y-m-d')}}"  class="form-control" placeholder="Proposed Time Frame"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Contract Period</label>
                                                    <div>
                                                        <input type="text" name="contractPeriod" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->contract_period : old('contractPeriod')) }}" data-parsley-type="string"  class="form-control" placeholder="Enter in month"/>
                                                    </div>
                                                </div>
                                            </div> --}}


                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Contract Description <span class="text-danger">*</span></label>
                                                    <div>
                                                       <textarea required name="contractDescription" class="form-control" rows="5">{{ (isset($editRecord) && ($editRecord) ? $editRecord->contract_description : old('contractDescription')) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group mb-0 col-md-12">
                                                    <div align="right">
                                                        <input type="hidden" name="recordID" value="{{ (isset($editRecord) && ($editRecord) ? $editRecord->contract_detailsID : '') }}" />
                                                        @if(isset($editRecord) && ($editRecord))
                                                            <a href="{{ route('cancelEditContractDetails') }}" class="btn btn-secondary waves-effect">
                                                                Cancel Edit
                                                            </a>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                                Update Now
                                                            </button>
                                                        @else
                                                            <button type="reset" class="btn btn-secondary waves-effect">
                                                                Reset
                                                            </button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                                Submit
                                                            </button>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>


             <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <h4 class="card-title">Newly Created Contract</h4>

                            <a href="{{route('contractReport')}}" target="_blank"> <i class="fa fa-eye"></i> View all </a>
                        </div>
                        <hr />

                        <div class="row">
                            <div align="center" class="form-group mb-0 col-md-12">
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>LOT No.</th>
                                            <th>SUBLOT No.</th>
                                            <th>Contract Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th class="text-right">Amount</th>
                                            {{-- <th>Approval Date</th>
                                            <th>Time Frame</th> --}}
                                         <!--   <th>Created On</th>
                                            <!--<th>Updated On</th>-->
                                         <!--   <th>Created By</th> -->
                                            <th>Status</th>
                                            <th colspan="2">Action</th>
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
                                            <td>
                                                {{ ($item->contract_description ? substr($item->contract_description, 0, 100) : ' - ') }}
                                                @if(strlen($item->contract_description) > 100)
                                                    ... <a href="javascript:;" class="text-info" data-toggle="modal" data-target=".viewMoreDescription{{$key}}">View more</a>
                                                @endif

                                            </td>
                                            <td>{{ $item->category_name }}</td>
                                            <td class="text-right">&#8358;{{ number_format($item->proposed_budget, 2) }}</td>
                                            {{-- <td>{{ ($item->approval_date ? date('jS M Y', strtotime($item->approval_date)) : ' - ') }}</td>
                                            <td>{{ ($item->proposed_time_frame ? (date('jS M Y', strtotime($item->proposed_time_frame))) : ' - ') }}</td> --}}
                                         <!--   <td>{{ ($item->created_at ? date('jS M Y', strtotime($item->created_at))  : ' - ') }}</td>
                                            <!--<td>{{ ($item->updated_at ? date('jS M Y', strtotime($item->updated_at))  : ' - ') }}</td>-->
                                          <!--  <td>{{ $item->name }}</td> -->
                                            <td>{{ $item->status_name }}</td>
                                            <td>
                                                @if ($item->status_name != "Approved")
                                                    <a href="{{ route('editContractDetails', ['id'=> base64_encode($item->contract_detailsID) ]) }}" class="btn btn-sm btn-secondary waves-effect waves-light">Edit</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status_name != "Approved")
                                                    <a href="javascript:;" title="Delete Record" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".deleteCategory{{$key}}"><i class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
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
                            </div>

                            @if(($getContractDetails instanceof \Illuminate\Pagination\AbstractPaginator))
                                <div align="right" class="col-md-12"><hr />
                                    Showing {{($getContractDetails->currentpage()-1)*$getContractDetails->perpage()+1}}
                                        to {{$getContractDetails->currentpage()*$getContractDetails->perpage()}}
                                        of  {{$getContractDetails->total()}} entries
                                </div>
                                <div class="d-print-none">{{ $getContractDetails->links() }}</div>
                            @endif

                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
    </div>


@endsection

@section('styles')
@endsection

@section('scripts')
<!--Format Amount while typing-->
    <script>
        //Number Format
        $(document).ready(function () {
            $("#formatAmountOnKeyPress").on('keyup', function(evt){
                //if (evt.which != 110 ){//not a fullstop
                    //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                     $(this).val(function (index, value) {
                    return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });
                    //$(this).val(n.toLocaleString());
                //}
            });
        });

        (function($, undefined) {
            "use strict";
            // When ready.
            $(function() {
            var $form = $( ".formFormatAmount" );
            var $input = $form.find( ".format-amount" );
            $input.on( "keyup", function( event ) {
                // When user select text in the document, also abort.
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {
                    return;
                }
                // When the arrow keys are pressed, abort.
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
                }
                var $this = $( this );
                // Get the value.
                var input = $this.val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;
                $this.val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                });
            } );

            });
        })(jQuery);
    </script>

@endsection
