@extends('layouts.layout')
@section('pageTitle')
Leave Report
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
			 	<div class="col-lg-2">
	            		<label>Period</label>
				<select name="period" id="period" class="form-control" required onchange="ReloadForm()">
		                	<option value="" selected>Select</option>
		                	@foreach ($LeavePeriod as $b)
		                	<option value="{{$b->period }}" {{ ($period) == $b->period? "selected":"" }}>{{$b->period}}</option>
		                	@endforeach
		                </select>
	            		</div>
			 	<!--<div class="col-lg-2">
	            		<label>Court</label>
				<select name="court" id="court" class="form-control" onchange="ReloadForm()">
		                <option value="" selected>Select</option>
		                	@foreach ($courtList as $b)
		                	<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>
		                	@endforeach
		                </select>
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Division</label>
				<select name="division" id="division" class="form-control" onchange="ReloadForm()">
		                <option value="" selected>Select</option>
		                	@foreach ($Division as $b)
		                	<option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>
		                	@endforeach
		                </select>
	            		</div>-->
	            		<div class="col-lg-2">
	            		<label>Department</label>
				<select name="department" id="department" class="form-control" onchange="ReloadForm()">
		                <option value="" selected>Select</option>
		                	@foreach ($depatmentList as $b)
		                	<option value="{{$b->id}}" {{ ($department) == $b->id? "selected":"" }}>{{$b->department}}</option>
		                	@endforeach
		                </select>
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Status</label>
				<select name="status" id="status" class="form-control" onchange="ReloadForm()">
		                <option value="" selected>Select</option>
		                	@foreach ($LeaveStatus as $b)
		                	<option value="{{$b->status}}" {{ ($status) == $b->status? "selected":"" }}>{{$b->status}}</option>
		                	@endforeach
		                </select>
	            		</div>
	            	</div>




		<input id ="delcode" type="hidden"  name="delcode" >
		<input id ="leaveid" type="hidden"  name="leaveid" >

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
		        <th colspan='2' class='text-center'>Status</th>
</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($LeaveQuery as $b)
				<tr>
				<td><a href="javascript: View('{{$b->id}}')">{{ $serialNum ++}} </a></td>
				<td><a href="javascript:LeaveApproval('{{url("/leave/approval")}}','{{$b->id}}')">{{$b->principalStaff }}</a></td>
    				<td>{{$b->period}}</td>
    				<td>{{date_format(date_create($b->startDate), 'd-M-Y')}}</td>
    				<td>{{date_format(date_create($b->endDate), 'd-M-Y')}}</td>
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
	function  LeaveApproval(url,id)
	{
		document.getElementById("thisform").action = url;
		document.getElementById('leaveid').value=id;
		document.getElementById('thisform').submit();
		return;
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
