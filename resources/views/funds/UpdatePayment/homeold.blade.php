@extends('layouts.layout')
@section('pageTitle')
  Payment Update
@endsection

@section('content')
	
  <div class="box-body" style="background:#fff;">
        <div class="row">
            <div class="col-md-12"><!--1st col-->
                @if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			    </button>
			    <strong>Error!</strong> 
			    @foreach ($errors->all() as $error)
				<p>{{ $error }}</p>
			    @endforeach
			</div>
                @endif
                       
		@if(session('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> 
			{{ session('message') }}
		   </div>                        
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> 
			{{ session('error') }}
		   </div>                        
                @endif

            </div>
        </div>
	 
	 <div style="background-color: #f3f3f3; padding:10px; color: black;"> 
	 	<h4> <span class="text-left">Payment Update</span></h4>   <div class="text-right"> Field with <span class="text-danger">*</span> is required</div>  
	 </div>
	 <br /><br />
	 
	  <div class="col-md-12" style="background:#fff;"><!--2nd col-->
            <form method="post" action="{{ route('saveUpdatePayment') }}" enctype="multipart/form-data">
             {{ csrf_field() }}
             
        	<div class="row">
        	      
                     <div class="col-md-4">
            			<div class="form-group">
            			  <label for="contractType">Contract Type <span class="text-danger">*</span> </label>
            			    <select name="contractType" id="contractType" required  class="form-control">
            			    	<option value="{{ isset($edit) ? $edit->conID : '' }}">{{ isset($edit) ? $edit->contractType : 'Select' }}</option>
            			    	@forelse($contractType as $contracts)
            			    		<option value="{{$contracts->ID}}" {{ $contracts->ID == old('contractType') ? 'Selected' : ''}}>{{$contracts->contractType}}</option>
            			    	@empty
            			    	@endforelse
            			    </select>
            			</div>
                     </div><!-- /.col -->
                     <input type="hidden"  id="allocationType" name="allocationType" value='5'> 
                     <!--
                     <div class="col-md-4">
			<div class="form-group">
			  <label for="allocationType">Allocation Type <span class="text-danger">*</span> </label>
			    <select name="allocationType" id="allocationType" required  class="form-control">
			    	<option value="{{ isset($edit) ? $edit->allID : '' }}">{{ isset($edit) ? $edit->allocation : 'Select' }}</option>
			    	@forelse($allocationType as $allocations)
			    		<option value="{{$allocations->ID}}" {{ $allocations->ID == old('allocationType') ? 'Selected' : '' }}>{{$allocations->allocation}}</option>
			    	@empty
			    	@endforelse
			    </select>
			</div>
                     </div>
                     
                      -->
                     
                     <div class="col-md-4">
			<div class="form-group">
			  <label for="economicCode">Economic Code <span class="text-danger">*</span> </label>
			    <select name="economicCode" id="economicCode"  required  class="form-control">
			    	<option value="{{ isset($edit) ? $edit->ecoCodeID : '' }}">{{ isset($edit) ? $edit->description : '' }}</option>
			    </select>
			</div>
                     </div><!-- /.col -->
                 </div><!--row-->
                 
                 <div class="row">
                     <div class="col-md-4">
			<div class="form-group">
			  <label for="totalPaymnet">Total Payment<span class="text-danger">*</span> </label>
			    <input type="text" value="{{ isset($edit) ? $edit->totalPayment : old('totalPayment') }}" name="totalPaymnet" required class="form-control" placeholder="Enter Total Amount(No comma)">
			</div>
                     </div><!-- /.col -->
                     <div class="col-md-4">
			<div class="form-group">
			  <label for="paymentDescription">Payment Description</label>
			    <textarea name="paymentDescription" class="form-control" placeholder="Payment Description">{{ isset($edit) ? $edit->paymentDescription : old('paymentDescription') }}</textarea>
			</div>
                     </div><!-- /.col -->
                     <div class="col-md-4">
			<div class="form-group">
			  <label for="cutOffDate">Cut Off Date </label>
			    <input type="date" value="{{ isset($edit) ? $edit->datePrepared : old('cutOffDate') }}" name="cutOffDate" class="form-control" placeholder="Select Date">
			</div>
                     </div><!-- /.col -->
                 </div><!--row-->
                 
                
                 <div class="row">
                   <div align="center" class="col-md-12">
                   	<hr />
                   	@if(isset($edit))
                   	   <a href="{{ route('cancelUpdate')}}" class="btn btn-danger">Cancel Edit</a>
			    <input type="hidden" name="recordID" value="{{ isset($edit) ? $edit->recordID : ''}}" />
			    <input type="submit" name="submit" class="btn btn-success" value="Update" />
			@else
			    <input type="hidden" name="recordID" value="" />
			    <input type="submit" name="submit" class="btn btn-success" value="Submit" />
			@endif
                   </div>
                </div>
                <hr />
            </form>
          </div>
          
             <div align="center" class="col-md-12">
               <table class="table table-hover table-stripped table-responsive table-condensed"> 
                    <thead>
                       <tr style="background:#d9d9d9">
                            <th>SN</th>
                            <th>Budget Type </th>
                            <!--<th>Allocation Type</th>-->
                            <th>Economic Code </th>
                            <th>Total Payment</th>
                            <th>Payment Description</th>
                            <th>Cut-Off Date</th>
                            <th colspan="2"></th>
                       </tr>
                    </thead>
                    <tbody>
                        @php $tpay=0; @endphp
                     @forelse($record as $key=>$list)
                      @php $tpay +=$list->totalPayment; @endphp
                       <tr>
                         <td>{{ 1+$key ++ }}</td>
                         <td>{{ $list->contractType }}</td>
                         <!--<td>{{ $list->allocation }}</td>-->
                         <td>{{ $list->economicCode .' - '. $list->description }}</td>
                         <td>{{ number_format($list->totalPayment, 2) }}</td>
                         <td>{{ $list->paymentDescription }}</td>
                         <td>{{ $list->datePrepared}}</td>
                         <th><a href="{{ route('editRecord', ['ID'=>$list->recordID])}}" class="btn btn-info"><i class="fa fa-edit"></i></a></th>
                         <th><button type="button" data-toggle="modal" data-backdrop="false" data-target="#delete{{$list->recordID}}" class="btn btn-warning"><i class="fa fa-trash"></i></button></th>
                      </tr>
                      
                      <!-- DeleteModal -->
                                <div class="modal fade text-left" id="delete{{$list->recordID}}" tabindex="-1" role="dialog" 
                                aria-labelledby="myModalLabel12" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger white">
                                            <h4 class="modal-title" id="myModalLabel12"><i class="fa fa-trash"></i> Delete Record </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div align="center" class="modal-body">
                                                <div class="text-center">  {{ ('Delete '.$list->paymentDescription) }} </div>
                                                <h5><i class="fa fa-arrow-right"></i> {{ ('Are you sure you want to delete this record?')}} </h5>
                                            <p>
                                                <div class="text-danger text-center"> {{ ('You will not be able to recover this record again !')}} </div>
                                            </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                <a href="{{ route('removeRecord', ['ID'=>$list->recordID]) }}"  class="btn btn-outline-danger"> Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end Modal-->
                                
                                
                      @empty
                      @endforelse
                      <tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td>{{ number_format($tpay, 2) }}</td>
                         <td></td>
                         <td></td>
                         <th></th>
                         <th></th>
                      </tr>
                    </tbody>
                   </table>
               </div>
                              
  	

<div class="panel-body" style="background:#fff;">
  <table class="table table-responsive table-bordered">
             
        </table>

   </div>
@endsection

@section('scripts')
<script>
   $(document).ready(function() {
	
        //Function to get student names in a class
        function getEconomicCodes(contractTypeID, allocationTypeID)
        {
            if (contractTypeID != "" && allocationTypeID != ""){
                $.ajax({ 
                     url: '{{url("/")}}' +  '/getEconomicCodeJson/' + contractTypeID + '/' + allocationTypeID,
                     type: 'get',
                      //data: {'classID': classID, '_token': $('input[name=_token]').val()},
                     data: { format: 'json' },
                     dataType: 'json',
                     success: function(data) 
                     { 
                        $('#economicCode').empty();
                        $('#economicCode').append($('<option>').text(" Select Economic Code").attr('value',""));
                        $.each(data.ecoCode, function(model, list)
                        {
                       		$('#economicCode').append($('<option>').text(list.economicCode + ' - ' +list.description).attr('value', list.economicID));
                        });
                      },
                      error: function(error) 
                      {
                          alert("Please we are having issue get your economic codes. Check your network/refresh this page !!!");
                      }
                    });
 		}//endif
        };//end function
        
        //calling a function to get student names
        $('#allocationType').change(function() {
            var contractTypeID = $('#contractType').val();
            var allocationTypeID = $('#allocationType').val();
            if (contractTypeID == "")
            {
                alert('Please select contract type from the list!');
                $('#allocationType').focus()
                return false;
            }
            if (allocationTypeID == "")
            {
                alert('Please select allocation type from the list!');
                $('#allocationType').focus()
                return false;
            }
            getEconomicCodes(contractTypeID, allocationTypeID);
        });

    });
</script>

@endsection

