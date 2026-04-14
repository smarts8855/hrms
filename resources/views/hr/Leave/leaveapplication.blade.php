@extends('layouts.layout')
@section('pageTitle')
Leave Application
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
			 	<div class="col-lg-4">
	            		<label>Staff Details</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$staffDetails}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Total Allowable</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$totalAllowable}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Remaining days</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$dayRem}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Period</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$period}}" disabled="">
	            		</div>
	            	</div>
	            	@if ($RstaffAction=='')
	            	<div class="form-group">
			 	<div class="col-lg-2">
	            		<label>Start date</label>
				<input type="text" name="startdate" id="startdate" class="form-control" value="{{$startdate}}" required />
	            		</div>
	            		<div class="col-lg-2">
	            		<label>End date</label>
				<input type="text" name="enddate" id="enddate" class="form-control" value="{{$enddate}}" required />
	            		</div>
	            		<div class="col-lg-2">
	            		<label>No. Days</label>
				<select name="nod" id="nod" class="form-control" required>
		                <option value="" selected>Select</option>
		                	@for ($i = 1; $i < 100; $i++)
		                	<option value="{{ $i }}" {{ ($nod) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Leave Type</label>
				<select name="leaveType" id="leaveType" class="form-control" required>
		                <option value="" selected>-Select Type-</option>
		                	@foreach ($LeaveTypeList as $b)
						<option value="{{$b->id}}" {{ ($leaveType) == $b->id? "selected":"" }}>{{$b->leaveType}}</option>
		                	@endforeach
		                </select>
	            		</div>
	            		<div class="col-lg-4">
	            		<label>Releaving Staff</label>
				<select name="releavestaff" id="releavestaff" class="form-control" >
		                <option value="" selected>-Select Staff-</option>
		                	@foreach ($ReleaveStaff as $b)
						<option value="{{$b->ID}}" {{ ($releavestaff) == $b->ID? "selected":"" }}>
							{{$b->surname. " ".$b->first_name. " ".$b->othernames}}
						</option>
		                	@endforeach
		                </select>
	            		</div>
	            	</div>

	            	<div class="form-group">
			 	<div class="col-lg-6">
	            		<label>Purpose</label>
				<textarea class="form-control" name="purpose" rows="3">{{$purpose}}</textarea>
	            		</div>
	            		<div class="col-lg-6">
	            		<label>Address during the leave</label>
				<textarea class="form-control" name="address" rows="3">{{$address}}</textarea>
	            		</div>

	            	</div>
	            	<div class="form-group">
				<div class="col-lg-12 col-lg-offset-0">
				@if ($viewid=='')
				<button type="submit" class="btn btn-success" name="Save">
						<i class="fa fa-btn fa-floppy-o"></i> Save
					</button>
				@else
				<button type="submit" class="btn btn-success" name="update">
					<i class="fa fa-btn fa-floppy-o"></i> Update
				</button>
				@endif
				<button type="submit" class="btn btn-success" name="reset">
					<i class="fa fa-btn fa-newspaper-o"></i> Reset
				</button>
				</div>
			</div>
	            	@else
	            	<div class="form-group">
			 	<div class="col-lg-2">
	            		<label>Start date</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{date_format(date_create($AppliedLeave[0]->startDate), 'd-m-Y')}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>End date</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{date_format(date_create($AppliedLeave[0]->endDate), 'd-m-y')}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>No. Days</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->noOfDays}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Leave Type</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->LeavesType}}" disabled="">
	            		</div>
	            		<div class="col-lg-4">
	            		<label>Releaving Staff</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->releaveStaff }}" disabled="">
	            		</div>
	            	</div>

	            	<div class="form-group">
			 	<div class="col-lg-4">
	            		<label>Purpose</label>
				<textarea class="form-control" name="purpose" rows="2" disabled="">{{$AppliedLeave[0]->purpose}}</textarea>
	            		</div>
	            		<div class="col-lg-4">
	            		<label>Address during the leave</label>
				<textarea class="form-control" name="address" rows="2" disabled="">{{$AppliedLeave[0]->addressDuringLeave}}</textarea>
	            		</div>
	            		<div class="col-lg-4">
	            		<label>Acceptance Status</label>
				<textarea class="form-control" rows="2" disabled="">{{$AppliedLeave[0]->RstaffAction}}:{{$AppliedLeave[0]->RStaffComment}}</textarea>
	            		</div>

	            	</div>
	            	@if ($status=='Pending')
	            	<div class="form-group">
	            		<div class="col-lg-2">
	            		<label>Current status</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->status}}" disabled="">
	            		</div>
				<div class="col-lg-10">

				<button type="submit" class="btn btn-success" name="cancel">
					<i class="fa fa-btn fa-floppy-o"></i> Terminate
				</button>
				<button type="submit" class="btn btn-success" name="reset">
					<i class="fa fa-btn fa-newspaper-o"></i> Reset
				</button>
				</div>
			</div>
			@else
			<div class="form-group">
				<div class="col-lg-2">
	            		<label>Current status</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$AppliedLeave[0]->status}}" disabled="">
	            		</div>
				<div class="col-lg-10">
				<button type="submit" class="btn btn-success" name="reset">
					<i class="fa fa-btn fa-newspaper-o"></i> Reset
				</button>
				</div>
			</div>
	            	@endif
	            	@endif


		<input id ="delcode" type="hidden"  name="delcode" >
		<input id ="viewid" type="hidden"  name="viewid" value={{$viewid}} >
		<input id ="viewnewid" type="hidden"  name="viewnewid"  >

<div class="table-responsive" style="font-size: 12px; padding:10px;">
<table class="table table-bordered table-striped table-highlight" >
<thead>
<tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>
                <th >Period</th>
                <th >Start Date</th>
                <th >End Date</th>
		<th >No. Days</th>
                <th >Leave Type</th>
                <th >Releaving Staff</th>
                <th >R.Staff Action</th>
		<th >Status</th>
</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($LeaveHistory as $b)
				<tr>
				<td><a href="javascript: View('{{$b->id}}')">{{ $serialNum ++}} </a></td>
    				<td>{{$b->period}}</td>
    				<td>{{date_format(date_create($b->startDate), 'd-M-Y')}}</td>
    				<td>{{date_fomat(date_create($b->endDate), 'd-M-Y')}}</td>
    				<td>{{$b->noOfDays}}</td>
					<td>{{$b->LeavesType}}</td>
					<td>{{$b->Rstaff}}</td>
					<td>{{$b->RstaffAction}}</td>
					<td>{{$b->status}}</td>

				</tr>
			@endforeach

 </table>
</div>

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
		document.getElementById('viewnewid').value=1;
		document.getElementById('thisform').submit();
		return;



	}
  	$( function() {
    $( "#startdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#enddate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
  } );
  </script>
@endsection
