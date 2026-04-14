@extends('layouts.layout')


@section('pageTitle')
  <h3 style="padding: 0px;">Record Of Emolument <strong>- </strong><span style="color:green;">{{$names->surname}} {{$names->first_name}}</span></h3>
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <form method="post" action="{{ url('/update/recordofemolument/') }}">

		   {{ csrf_field() }}
		  <div class="box-body">
		        <div class="row">



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
										<label for="month">Date Of Entry</label>

										<select name="entrydate" id="date" class="form-control">
										<option></option>
										@if($emolument != '')
										@foreach($entryList as $dlists)

										@if($emolument->entryDateMade ==$dlists->recID)
										<option value="{{$dlists->recID}}" selected="selected">{{$dlists->entryDate}}</option>
										@else
										<option value="{{$dlists->recID}}">{{$dlists->entryDate}}</option>
										@endif
										@endforeach
										@else
										@foreach($entryList as $dlists)
										<option value="{{$dlists->recID}}">{{$dlists->entryDate}}</option>
										@endforeach
										@endif
										</select>


									</div>
								</div>



								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Detail</label>
										@php if($emolument != ''){
											echo '<textarea name="detail" class="form-control" id="detail" readonly>'.$emolument->detail.'</textarea>
												<input type="hidden" name="emolid" value="'.$emolument->emolumentID.'" />
												<input type="hidden" name="hiddenName" value="'.$emolument->salaryScale.'" />';
										}else{
											echo '<textarea name="detail" id="detail" class="form-control" readonly></textarea>
												  <input type="hidden" name="hiddenName" value="" />';

										}
										@endphp

									</div>
								</div>


							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Basic Salary P.A</label>
										@php if($emolument != ''){
											echo '<input type="text" name="basicsalarypa" id="basicsalarypa" class="form-control" value="'.$emolument->basicSalaryPA.'" />';
										}else{
											echo '<input type="text" name="basicsalarypa" id="basicsalarypa" class="form-control"  />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Inducement Pay P.A</label>
										@php if($emolument != ''){
											echo '<input type="text" name="inducement" id="inducement" class="form-control" value="'.$emolument->inducementPayPA.'" />';
										}else{
											echo '<input type="text" name="inducement" id="inducement" class="form-control"  />';
										}
										@endphp
									</div>
								</div>
							</div>


							<div class="row">

								<div class="col-md-6">

									<div class="form-group">
										<label for="month">Increment Month/Year</label>
										@php if($emolument != ''){
											echo '<input type="text" name="month_year" id="month_year" class="form-control" value="'.$emolument->month.'" />';
										}else{
											echo '<input type="text" name="month_year" id="month_year" class="form-control"  />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Salary Scale</label>
										@php if($emolument != ''){
											echo '<input type="text" name="salaryscale" id="salaryscale" class="form-control" value="'.$emolument->salaryScale.'" />
												';
										}else{
											echo '<input type="text" name="salaryscale" id="salaryscale" class="form-control" />
												  ';

										}
										@endphp

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Date Paid From</label>
										@php if($emolument != ''){
											echo '<input type="text" name="datepaidfrom" id="datepaidfrom" class="form-control" value="'.$emolument->datePaidFrom.'" />';
										}else{
											echo '<input type="text" name="datepaidfrom" id="datepaidfrom" class="form-control"  />';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Authority</label>
										@php if($emolument != ''){
											echo '<input type="text" name="authority" id="authority" class="form-control" value="'.$emolument->authority.'" />';
										}else{
											echo '<input type="text" name="authority" id="authority" class="form-control"  />';
										}
										@endphp
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Signature</label>
										@php if($emolument != ''){
											echo '<input type="text" name="signature" id="signature" class="form-control" value="'.$emolument->signature.'" />';
										}else{
											echo '<input type="text" name="signature" id="signature" class="form-control"  />';
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
								<th>Date Entry Made</th>

						       <th>Salary Scale</th>
						       <th>Basic Salary P.A</th>
						       <th>Inducement P.A</th>
						       <th>Date Paid From</th>
						       <th colspan="2">Increment Date</th>
						       <th>Authority</th>
						       <th>Signature</th>


							</tr>
							<tr>
								<th></th>
								<th></th>

						       <th></th>
						       <th></th>
						       <th></th>
						       <th></th>
						       <th >Month</th>
						       <th >Year</th>
						       <th></th>
						       <th></th>


							</tr>
						</thead>
						<tbody>
						@php if($emolumentList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($emolumentList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->entryDate}}</td>
								<td>{{number_format($list->salaryScale,2)}}</td>
								<td>{{number_format($list->basicSalaryPA,2)}}</td>
								<td>{{number_format($list->inducementPayPA,2)}}</td>
								<td>{{$list->datePaidFrom}}</td>
								<td>{{$list->month}}</td>
								<td>{{$list->year}}</td>
								<td>{{$list->authority}}</td>
								<td>{{$list->signature}}</td>


							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="7" class="text-center">No Record provided yet !</td>
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
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script>
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

$( function() {

  $("#date").on('change', function(){

//$('#nameID').val(suggestion.data);
var id = $(this).val();
//alert(id);
$token = $("input[name='_token']").val();
$.ajax({
	headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/update/recordofemolument/getdetail') }}",

  type: "post",
  data: {'entrydate': id},
  success: function(data){
    //$('#nextofkinHref').attr('href', ""+murl+"/update/next-of-kin/" + data[0].fileNo ); //next of kin url

    //fileNo = data[0].fileNo;
    //$('#staffname').val(data[0].surname+', '+data[0].first_name);
    //console.log(data);
    $('#detail').val(data.detail);

    //$('#designation').val(data[0].Designation);
   //$('#gender').val(data[0].gender);


  }
});
});
});

  $( function() {
	    $("#date").datepicker({
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
				$("#date").val(dateFormatted);
        	},
		});

  } );

    $( function() {
	    $("#month_year").datepicker({
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
				$("#month_year").val(dateFormatted);
        	},
		});

  } );


   $( function() {
	    $("#datepaidfrom").datepicker({
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
				$("#datepaidfrom").val(dateFormatted);
        	},
		});

  } );


	//Modal popup
	$(document).ready(function(){
		$('.open-modal').click(function(){
			$('#myModal').modal('show');
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
