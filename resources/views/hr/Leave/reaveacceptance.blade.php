@extends('layouts.layout')
@section('pageTitle')
Leave Releaving Acceptance
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        @if ($warning<>'')
	<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$warning}}</strong> 
	</div>
	@endif
	@if ($success<>'')
	<div class="alert alert-dismissible alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$success}}</strong> 
	</div>
	@endif
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
	<form method="post"  id="thisform" name="thisform" class="form-horizontal">
		{{ csrf_field() }}
		<div class="box-body">
			 
			 
			 <div class="form-group"> 
			 	<div class="col-lg-9">
	            		<label>Staff Details</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->principalStaff}}" disabled=""> 
	            		</div>
	            		
	            		<div class="col-lg-3">
	            		<label>Period</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->period}}" disabled=""> 
	            		</div>
	            	</div>
	            	<div class="form-group"> 
			 	<div class="col-lg-3">
	            		<label>Start date</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->startDate}}" disabled=""> 
	            		</div>
	            		<div class="col-lg-3">
	            		<label>End date</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->endDate}}" disabled=""> 
	            		</div>
	            		<div class="col-lg-3">
	            		<label>No. Days</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->noOfDays}}" disabled=""> 
	            		</div>
	            		<div class="col-lg-3">
	            		<label>Leave Type</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->LeavesType}}" disabled=""> 
	            		</div>
	            		
	            	</div>
	            	<div class="form-group"> 
			 	<div class="col-lg-6">
	            		<label>Purpose</label>
				<textarea class="form-control"  rows="3" disabled="">{{$AppliedLeave[0]->purpose}}</textarea>
	            		</div>
	            		<div class="col-lg-6">
	            		<label>Address during the leave</label>
				<textarea class="form-control"  rows="3" disabled="">{{$AppliedLeave[0]->addressDuringLeave}}</textarea>
	            		</div>
	            		
	            	</div>
	            	<div class="form-group"> 
			 	<div class="col-lg-12">
	            		<label>Commnent</label>
	            		@if ($AppliedLeave[0]->RstaffAction=='')
				<textarea class="form-control" name="remarks" rows="3" ></textarea>
				@else
				<textarea class="form-control" rows="3" disabled="">{{$AppliedLeave[0]->RStaffComment}}</textarea>
				@endif
	            		</div>
	            		
	            		
	            	</div>
	            	<div class="form-group">
				
				@if ($AppliedLeave[0]->RstaffAction=='')
				<div class="col-lg-4 col-lg-offset-0">
				<button type="submit" class="btn btn-success" name="accept">
						<i class="fa fa-btn fa-floppy-o"></i> Accept
				</button>	
				<button type="submit" class="btn btn-success" name="reject">
					<i class="fa fa-btn fa-newspaper-o"></i> Reject
				</button>
				</div>
				@else
				<div class="col-lg-3">
				<label>Acceptance Status</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->RstaffAction}}" disabled=""> 
				</div>
				<div class="col-lg-3">
				<label>Approval Status</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->status}}" disabled=""> 
				</div>
				@endif
				
				
			</div>
						
					
		<input id ="delcode" type="hidden"  name="delcode" >
		<input id ="leaveid" type="hidden"  name="leaveid" value={{$leaveid}} >
		

		
	</form>
	
</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
	function  ReloadForm()
	{
	//alert("ururu")	;	
	document.getElementById('thisform').submit();
	return;
	}
	function  DeletePromo(id)
	{
		var cmt = confirm('You are about to delete a record. Click OK to continue?');
              if (cmt == true) {
					document.getElementById('delcode').value=id;
					document.getElementById('thisform').submit();
					return;
 
              }
	
	}
	function  View(id)
	{
					document.getElementById('viewid').value=id;
					document.getElementById('thisform').submit();
					return;
 
              
	
	}
  	$( function() {
    $( "#startdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#enddate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );
  </script>
@endsection
