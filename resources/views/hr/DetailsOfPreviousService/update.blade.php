@extends('layouts.layout')

@section('pageTitle')
  <h3 style="padding:0px;">Update Details Of Previous Public Service <strong>- </strong><span style="color:green;">{{$names->surname}} {{$names->first_name}}</span></h3>
@endsection

<style type="text/css">
	.table, .table thead th, .table tbody td
	{
		border:1px solid #ccc;
	}
	.table thead th strong
	{
		text-align: center;
	}
</style>

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <form method="post" action="{{ url('/update/detailofprevservice/') }}">
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
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Previous Schudule Employer</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="previousemployers" class="form-control" value="'.$doppservice->previousSchudule.'" />
												<input type="hidden" name="doppsid" value="'.$doppservice->doppsid.'" />
												<input type="hidden" name="hiddenName" value="'.$doppservice->previousSchudule.'" />';
										}else{
											echo '<input type="text" name="previousemployers" class="form-control" />
												  <input type="hidden" name="hiddenName" value="" />';

										}
										@endphp

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">File Page Ref</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="filepage" class="form-control" value="'.$doppservice->filePageRef.'"  />';
										}else{
											echo '<input type="text" name="filepage" class="form-control" />';
										}
										@endphp
									</div>
								</div>
							</div>

							<div class="row">
							<div class="col-md-6">
							<h3>Dates</h3>

							<div class="col-md-6" style="padding-left: 0px;">
									<div class="form-group">
										<label for="month">From Date</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="fromdate" class="form-control" id="fromdate" value="'.$doppservice->fromDate.'"/>';
										}else{
											echo '<input type="text" name="fromdate" class="form-control" id="fromdate" />';
										}
										@endphp

									</div>
								</div>

								<div class="col-md-6" style="padding-right: 0px;">
									<div class="form-group">
										<label for="month">To Date</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="todate" class="form-control" id="todate" value="'.$doppservice->toDate.'"/>';
										}else{
											echo '<input type="text" name="todate" class="form-control" id="todate" />';
										}
										@endphp
									</div>
								</div>


								</div>
								<div class="col-md-6">

								<h3>Total Previous Service</h3>
                            <div class="col-md-4" style="padding-left: 0px;">
									<div class="form-group">
										<label for="month">Years</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="years" class="form-control" value="'.$doppservice->years.'" />';
										}else{
											echo '<input type="text" name="years" class="form-control"  />';
										}
										@endphp
									</div>
								</div>
							<div class="col-md-4">
									<div class="form-group">
										<label for="month">Months</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="months" class="form-control" value="'.$doppservice->months.'"  />';
										}else{
											echo '<input type="text" name="months" class="form-control" />';
										}
										@endphp
									</div>
								</div>


							<div class="col-md-4" style="padding-right: 0px;">
									<div class="form-group">
										<label for="month">Days</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="days" class="form-control" value="'.$doppservice->days.'" />';
										}else{
											echo '<input type="text" name="days" class="form-control" />';
										}
										@endphp
									</div>
								</div>




								</div>


							</div>


                            <div class="row">


							<div class="col-md-6">
									<div class="form-group">
										<label for="month">Checked By</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="checkedby" class="form-control" value="'.$doppservice->checkedby.'" placeholder="Optional" />';
										}else{
											echo '<input type="text" name="checkedby" class="form-control" />';
										}
										@endphp
									</div>
								</div>


                            <div class="col-md-6">
									<div class="form-group">
										<label for="month">Total Previous Pay</label>
										@php if($doppservice != ''){
											echo '<input type="text" name="prevpay" class="form-control" value="'.$doppservice->totalPreviousPay.'"/>';
										}else{
											echo '<input type="text" name="prevpay" class="form-control" />';
										}
										@endphp
									</div>
								</div>

							</div>


							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp; </label><br />
										<a href="javascript: loadProfileDetail('{{$staffid}}')" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>
								@php //if($doservice != ''){ @endphp
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i>
										</button>
									</div>
								</div>
								@php //} @endphp

								</div>
							</div>
							<hr />

					  <table class="table table-striped table-hover table-responsive">
						<thead>
						<tr>
						<th>S/N</th>
						<th>Previous Employers</th>
                        <th colspan="2" valign="top" style="text-align:center;">Dates</th>
                        <th colspan="4" align="center" valign="top" style="text-align:center;">Total Previous Service</th>


						<th>File Page Ref</th>
						<th>Checked By</th>

						<th></th>



						</tr>
						<tr>
						<th></th>
						<th></th>

						<th width="75" align="center" valign="middle">From</th>
						<th width="96" align="center" valign="middle">To Date</th>

						<th width="75" align="center" valign="middle">Years</th>
						<th width="96" align="center" valign="middle">Months</th>
						<th width="75" align="center" valign="middle">Days</th>
						<th width="96" align="center" valign="middle">Total Previous Pay</th>
						<th></th>
						<th></th>
						<th></th>



						</tr>
						</thead>
						<tbody>
						@php if($doppList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($doppList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->previousSchudule}}</td>
								<td>{{date('d-m-Y', strtotime($list->fromDate))}}</td>
								<td>{{date('d-m-Y', strtotime($list->toDate))}}</td>
								<td>{{$list->years}}</td>
								<td>{{$list->months}}</td>
								<td>{{$list->days}}</td>
								<td>{{number_format($list->totalPreviousPay,2)}}</td>
								<td>{{$list->filePageRef}}</td>
								<td>{{$list->checkedby}}</td>

								

							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="11" class="text-center">No Details of Previous Public Service Available Yet !</td>
								</tr>
						@php } @endphp

						</tbody>
					</table>
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>

		  <form action="{{url('/process/detailofprevservice/')}}" method="post">
		  {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="myModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="padding: 10px; border-radius: 6px;">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Add New Next of Kin</b></h4>
					                </div>
					                <div class="modal-body">
					                    <div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Name</label>
												<input type="text" name="fullName" class="form-control" />
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Relationship</label>
												<input type="text" name="relationship" class="form-control"/>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Address</label>
												<textarea name="address" class="form-control"></textarea>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Phone Number</label>
												<input type="text" name="phoneNumber" class="form-control" placeholder="Optional" />
											</div>
										</div>
									</div>
					                </div>
					              </div>
					            </div>

			                <div class="modal-footer-not-use" align="right">
			                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Close</button>
			                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save</button>
			                </div>

			            </div>
			        </div>
			    </div>
			</div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function  loadProfileDetail(staffid)
{
document.getElementById('fileNos').value = staffid;
document.forms["displayform"].submit();
return;

}
</script>

  <script type="text/javascript">
	//Modal popup
	$(document).ready(function(){
		$('.open-modal').click(function(){
			$('#myModal').modal('show');
		});
	});


	$( function() {
	    $("#todate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#todate").val(dateFormatted);
        	},
		});

  } );

	$( function() {
	    $("#fromdate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#fromdate").val(dateFormatted);
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
