@extends('layouts.layout')

@section('pageTitle')
  Tour And Leave Record <strong>- </strong><span style="color:green;">{{$names->surname}} {{$names->first_name}}</span>
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <form method="post" action="{{ url('/update/tour-leave-record/') }}">
		  <div class="box-body">
		        <div class="row">

					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->

							<!--
								<div align="right" style="margin-right: 10px;">
									<a href="#" title="Add New" class="btn btn-primary open-modal">
										<i class="fa fa-hand-o-down"></i> <b>Add New</b>
									</a>
								</div>
							-->

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Date Tour Started</label>
										@php if($tour != ''){
											echo '<input type="text" name="tourstartdate" id="tourstartdate" class="form-control" value="'.$tour->dateTourStarted.'" />
												<input type="hidden" name="tourLeaveID" value="'.$tour->tourLeaveID.'" />
												<input type="hidden" name="hiddenName" value="'.$tour->dateTourStarted.'" />';
										}else{
											echo '<input type="text" name="tourstartdate" id="tourstartdate" class="form-control" />
												  <input type="hidden" name="hiddenName" value="" />';

										}
										@endphp

									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Gezette Notice Number(Tour)</label>
										@php if($tour!= ''){
											echo '<input type="text" name="tourgazette" class="form-control" value="'.$tour->tourGezetteNumber.'"/>';
										}else{
											echo '<input type="text" name="tourgazette" class="form-control" />';
										}
										@endphp

									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Length Of Tour</label>
										@php if($tour != ''){
											echo '<input type="text" name="tourlength" class="form-control" value="'.$tour->lengthOfTour.'"/>';
										}else{
											echo '<input type="text" name="tourlength" class="form-control" />';
										}
										@endphp
									</div>
								</div>


							</div>

							<div class="row">
							<div class="col-md-4">
									<div class="form-group">
										<label for="month">Date Due For Leave</label>
										@php if($tour != ''){
											echo '<input type="text" name="leaveduedate" id="leaveduedate" class="form-control" value="'.$tour->leaveDueDate.'" placeholder="Optional" />';
										}else{
											echo '<input type="text" name="leaveduedate" id="leaveduedate" class="form-control" />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Date Departed Leave</label>
										@php if($tour != ''){
											echo '<input type="text" name="leavedepartdate" id="leavedepartdate" class="form-control" value="'.$tour->leaveDepartDate.'"/>';
										}else{
											echo '<input type="text" name="leavedepartdate" id="leavedepartdate" class="form-control" />';
										}
										@endphp
									</div>
								</div>


								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Leave Gezzete Number</label>
										@php if($tour != ''){
											echo '<input type="text" name="leavegezettenum" class="form-control" value="'.$tour->leaveGezetteNumber.'"/>';
										}else{
											echo '<input type="text" name="leavegezettenum" class="form-control" />';
										}
										@endphp
									</div>
								</div>
							</div>

							<div class="row">
							<div class="col-md-4">
									<div class="form-group">
										<label for="month">Date Due To Return From Leave</label>
										@php if($tour != ''){
											echo '<input type="text" name="leavereturndate" id="leavereturndate" class="form-control" value="'.$tour->leaveReturnDate.'" />';
										}else{
											echo '<input type="text" name="leavereturndate" id="leavereturndate" class="form-control" />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Date Extension Granted</label>
										@php if($tour != ''){
											echo '<input type="text" name="dateextgranted" id="dateextgranted" class="form-control" value="'.$tour->dateExtensionGranted.'" />';
										}else{
											echo '<input type="text" name="dateextgranted" id="dateextgranted" class="form-control" />';
										}
										@endphp
									</div>
								</div>


								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Salary Rule For Extension</label>
										@php if($tour != ''){
											echo '<input type="text" name="salaryrule" class="form-control" value="'.$tour->salaryRuleForExt.'"/>';
										}else{
											echo '<input type="text" name="salaryrule" class="form-control" />';
										}
										@endphp
									</div>
								</div>


								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Date Resumed Duty</label>
										@php if($tour != ''){
											echo '<input type="text" name="dateresume" id="dateresume" class="form-control" value="'.$tour->dateResumedDuty.'" />';
										}else{
											echo '<input type="text" name="dateresume" id="dateresume" class="form-control" />';
										}
										@endphp
									</div>
								</div>

							</div>

							<div class="row">
							<div class="col-md-6" style="padding: 0px;">
							<h4>Passage by Sea Or Air</h4>
							<div class="col-md-6">
									<div class="form-group">
										<label for="month">To UK</label>
										@php if($tour != ''){
											echo '<input type="text" name="touk" class="form-control" value="'.$tour->toUK.'" />';
										}else{
											echo '<input type="text" name="touk" class="form-control" />';
										}
										@endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">From UK</label>
										@php if($tour != ''){
											echo '<input type="text" name="fromuk" class="form-control" value="'.$tour->fromUK.'" />';
										}else{
											echo '<input type="text" name="fromuk" class="form-control" />';
										}
										@endphp
									</div>
								</div>
							</div>

							<div class="col-md-6" style="padding: 0px;">
							<h4>Resident</h4>
							<div class="col-md-6">
									<div class="form-group">
										<label for="month">Months</label>
										@php if($tour != ''){
											echo '<input type="text" name="residentmonths" class="form-control" value="'.$tour->residentMonths.'" />';
										}else{
											echo '<input type="text" name="residentmonths" class="form-control" />';
										}
										@endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Days</label>
										@php if($tour != ''){
											echo '<input type="text" name="residentdays" class="form-control" value="'.$tour->residentDays.'" />';
										}else{
											echo '<input type="text" name="residentdays" class="form-control" />';
										}
										@endphp
									</div>
								</div>
							</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="javascript: loadProfileDetail('{{$staffid}}')" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>

								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New Tour/Leave <i class="fa fa-save"></i>
										</button>
									</div>
								</div>
								</div>

							    <hr />

                            <div class="table-responsive" style="width:100%">
							<table class="table table-hover table-bordered">
								<thead>
								<tr>
									<th>S/N</th>
									<th>Date Tour Started</th>
									<th>Tour Gazzete Notice Number</th>
									<th>Length Of Tour</th>
									<th>Date Due For Leave</th>
									<th>Date Departed On Leave</th>
									<th>Leave Gezzette Notice Number</th>
									<th>Date For Leave Return</th>
									<th>Date Extension Granted To</th>
									<th>Salary Rule for Extension</th>
									<th>Date Resumed Duty</th>
									<th colspan="2">Passage by Sea or Air</th>
									<th colspan="2">Resident</th>
									<th colspan="2">Leave</th>
									<th></th>
								</tr>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>To UK</th>
									<th>From UK</th>
									<th>Months</th>
									<th>Days</th>
									<th>Months</th>
									<th>Days</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
								@php if($tourleaveList != ''){ @endphp
									@php $key = 1 @endphp
									@foreach($tourleaveList as $list)
									<tr>
										<td>{{$key ++}}</td>
										<td>{{date('d-M-Y', strtotime($list->dateTourStarted))}}</td>
										<td>{{$list->tourGezetteNumber}}</td>
										<td>{{$list->lengthOfTour}}</td>
										<td>{{date('d-M-Y', strtotime($list->leaveDueDate))}}</td>
										<td>{{date('d-M-Y', strtotime($list->leaveDepartDate))}}</td>
										<td>{{$list->leaveGezetteNumber}}</td>
										<td>{{date('d-M-Y', strtotime($list->leaveReturnDate))}}</td>
										<td>{{date('d-M-Y', strtotime($list->dateExtensionGranted))}}</td>
										<td>{{date('d-M-Y', strtotime($list->salaryRuleForExt))}}</td>
										<td>{{date('d-M-Y', strtotime($list->dateResumedDuty))}}</td>
										<td>{{$list->toUK}}</td>
										<td>{{$list->fromUK}}</td>
										<td>{{$list->residentMonths}}</td>
										<td>{{$list->residentDays}}</td>
										<td>{{$list->leaveMonths}}</td>
										<td>{{$list->leaveDays}}</td>
										
									</tr>
									@endforeach
									@php
										}else{ @endphp
										<tr>
											<td colspan="18" class="text-center">No Tour and Leave details provided yet !</td>
										</tr>
									@php } @endphp
								</tbody>
							</table>
							</div>
							</div>

					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>
	</div>
</div>
<form method="post" id="displayform" name="displayform"  action="{{url('/profile/details')}}">

                {{ csrf_field() }}

                <input type="hidden" id="fileNos" name="fileNo" >



</form>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection


@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/datepicker_customised.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function  loadProfileDetail(staffid)
{
document.getElementById('fileNos').value = staffid;
document.forms["displayform"].submit();
return;

}
</script>
  <script>
		$( function() {
	    $("#tourstartdate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
				$("#tourstartdate").val(dateFormatted);
        	},
		});

		  } );

		$( function() {
			    $("#leaveduedate").datepicker({
			    	changeMonth: true,
			    	changeYear: true,
			    	yearRange: '1910:2090', // specifying a hard coded year range
				    showOtherMonths: true,
				    selectOtherMonths: true,
				    dateFormat: "dd MM, yy",
				    //dateFormat: "D, MM d, yy",
				    onSelect: function(dateText, inst){
				    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
						var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
						$("#leaveduedate").val(dateFormatted);
		        	},
				});

		  } );

		$( function() {
			    $("#leavedepartdate").datepicker({
			    	changeMonth: true,
			    	changeYear: true,
			    	yearRange: '1910:2090', // specifying a hard coded year range
				    showOtherMonths: true,
				    selectOtherMonths: true,
				    dateFormat: "dd MM, yy",
				    //dateFormat: "D, MM d, yy",
				    onSelect: function(dateText, inst){
				    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
						var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
						$("#leavedepartdate").val(dateFormatted);
		        	},
				});

		  } );

		$( function() {
			    $("#leavereturndate").datepicker({
			    	changeMonth: true,
			    	changeYear: true,
			    	yearRange: '1910:2090', // specifying a hard coded year range
				    showOtherMonths: true,
				    selectOtherMonths: true,
				    dateFormat: "dd MM, yy",
				    //dateFormat: "D, MM d, yy",
				    onSelect: function(dateText, inst){
				    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
						var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
						$("#leavereturndate").val(dateFormatted);
		        	},
				});

		  } );

		$( function() {
			    $("#dateresume").datepicker({
			    	changeMonth: true,
			    	changeYear: true,
			    	yearRange: '1910:2090', // specifying a hard coded year range
				    showOtherMonths: true,
				    selectOtherMonths: true,
				    dateFormat: "dd MM, yy",
				    //dateFormat: "D, MM d, yy",
				    onSelect: function(dateText, inst){
				    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
						var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
						$("#dateresume").val(dateFormatted);
		        	},
				});

		  } );

		$( function() {
			    $("#dateextgranted").datepicker({
			    	changeMonth: true,
			    	changeYear: true,
			    	yearRange: '1910:2090', // specifying a hard coded year range
				    showOtherMonths: true,
				    selectOtherMonths: true,
				    dateFormat: "dd MM, yy",
				    //dateFormat: "D, MM d, yy",
				    onSelect: function(dateText, inst){
				    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
						var dateFormatted = $.datepicker.formatDate('d MM yy', theDate);
						$("#dateextgranted").val(dateFormatted);
		        	},
				});

		  } );

</script>


@if (session('msg'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end', // top-end, top-start, bottom-end, etc.
    icon: 'success',
    title: '{{ session("msg") }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
</script>
@endif
@endsection
