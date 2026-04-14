@extends('layouts.layout')

@section('pageTitle')
 Add Particular of Date of Birth and Wife's Details
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b>
        		<big><b class="text-green"> - {{strtoupper($getStaff->surname." ".$getStaff->first_name." ".$getStaff->othernames)}}</b></big><span id='processing'></span>
        	</h3>
    	</div>
		  <form method="post" action="{{ url('/process/particular') }}">
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

							@php if($details != ''){
							  echo '<input type ="hidden" name="hiddenName" value="'.$details->particularID.'" />';
							}else{
							  echo '<input type ="hidden" name="hiddenName" value="" />';
							}
							@endphp

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="wifeName">Wife's Name</label>
										@php if($details != ''){
											echo '<input type ="text" name="wifeName" class="form-control" value="'.$details->wifename.'" />';
										}else{
											echo '<input type ="text" name="wifeName" class="form-control"/>';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="dateOfMarriage">Date of Marriage</label>
										@php if($details != ''){
											echo '<input type="text" name="dateOfMarriage2" id="dateOfMarriage2" class="form-control" value="'.date('d-m-Y', strtotime($details->dateofmarriage)).'" />
											<input type="hidden" name="dateOfMarriage" id="dateOfMarriage" value="'.$details->dateofmarriage.'" />';
										}else{
											echo '<input type="text" name="dateOfMarriage2" id="dateOfMarriage2" class="form-control" />
											<input type="hidden" name="dateOfMarriage" id="dateOfMarriage" />';
										}
										@endphp
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="homePlace">Home Place Address</label>
										@php if($details != ''){
											echo '<input type="text" name="homePlace" class="form-control" value="'.$details->homeplace.'"/>';
										}else{
											echo '<input type="text" name="homePlace" class="form-control" />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="wifeDateOfBirth">Wife's Date of Birth</label>
										@php if($details != ''){
											echo '<input type="text" name="wifeDateOfBirth2" id="wifeDateOfBirth2" class="form-control" value="'.date('d-m-Y', strtotime($details->wifedateofbirth)).'" />
											<input type="hidden" name="wifeDateOfBirth" id="wifeDateOfBirth" value="'.$details->wifedateofbirth.'" />';
										}else{
											echo '<input type="text" name="wifeDateOfBirth2" id="wifeDateOfBirth2" class="form-control" />
											<input type="hidden" name="wifeDateOfBirth" id="wifeDateOfBirth" />';
										}
										@endphp
									</div>
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="checkedBy">Checked By</label>
										@php if($details != ''){
											echo '<input type="text" name="checkedBy" class="form-control" value="'.$details->checkedby1.'" />';
										}else{
											echo '<input type="text" name="checkedBy" class="form-control" />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="checkedBy2">Checked By</label>
										@php if($details != ''){
											echo '<input type="text" name="checkedBy2" class="form-control" value="'.$details->checkedby2.'" />';
										}else{
											echo '<input type="text" name="checkedBy2" class="form-control" />';
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
										<label for="month">&nbsp;</label><br />
										<a href="javascript: loadProfileDetail('{{$staffid}}')" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>

								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i>
										</button>
									</div>
								</div>


								</div>
							</div>
							<hr />

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Wife Name</th>
								<th>Home Place</th>
								<th>Date of Marriage</th>
								<th>Wife Date of Birth</th>
								<th>Checked By</th>
								<th>Checked By</th>
								<th>Edit</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@php if($KinList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($KinList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->wifename}}</td>
								<td>{{$list->homeplace}}</td>
								<td>{{date('d-m-Y', strtotime($list->dateofmarriage))}}</td>
								<td>{{date('d-m-Y', strtotime($list->wifedateofbirth))}}</td>
								<td>{{$list->checkedby1}}</td>
								<td>{{$list->checkedby2}}</td>
								<td><a href="{{url('/particular/edit/'.$list->particularID)}}" title="Edit" class="btn btn-success fa fa-edit"></a>
								</td>
								<td><!--<a href="{{url('/remove/particular/'.$list->fileNo)}}" title="Remove" class="btn btn-warning fa fa-trash"></a>-->
								</td>
							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="11" class="text-center">No record found!</td>
								</tr>
						@php } @endphp

						</tbody>
					</table>
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>

	</div>
</div>
<form method="post" id="displayform" name="displayform"  action="{{url('/profile/details')}}" >

                {{ csrf_field() }}

                <input type="hidden" id="fileNos" name="fileNo" >



</form>
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection
{{-- @section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
function  loadProfileDetail(staffid)
{
document.getElementById('fileNos').value = staffid;
document.forms["displayform"].submit();
return;

}
</script>
  <script type="text/javascript">

	$( function() {
	    $("#dateOfBirth2").datepicker({
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
				$("#dateOfBirth").val(dateFormatted);
        	},
		});
		$("#dateOfMarriage2").datepicker({
			changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#dateOfMarriage").val(dateFormatted);
        	},
		});

		$("#wifeDateOfBirth2").datepicker({
			changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#wifeDateOfBirth").val(dateFormatted);
        	},
		});

  } );
</script>
@endsection --}}

@section('scripts')
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function loadProfileDetail(staffid) {
    document.getElementById('fileNos').value = staffid;
    document.forms["displayform"].submit();
    return;
}

$(function() {
    // Helper: convert dd-mm-yy to yyyy-mm-dd
    function formatToYMD(dateText) {
        const parts = dateText.split('-'); // ["03", "11", "2025"]
        return `${parts[2]}-${parts[1]}-${parts[0]}`; // "2025-11-03"
    }

    $("#dateOfMarriage2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
        onSelect: function(dateText, inst){
            const formatted = formatToYMD(dateText);
            $("#dateOfMarriage").val(formatted);
        },
    });

    $("#wifeDateOfBirth2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
        onSelect: function(dateText, inst){
            const formatted = formatToYMD(dateText);
            $("#wifeDateOfBirth").val(formatted);
        },
    });

    $("#dateOfBirth2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
        onSelect: function(dateText, inst){
            const formatted = formatToYMD(dateText);
            $("#dateOfBirth").val(formatted);
        },
    });
});
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

