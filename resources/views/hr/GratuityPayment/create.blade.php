@extends('layouts.layout')

@section('pageTitle')
Add Record of Gratuity Payments
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b>
        		<big><b class="text-green"> - {{strtoupper($getStaff->surname." ".$getStaff->first_name." ".$getStaff->othernames)}}</b></big><span id='processing'></span>
        	</h3>
    	</div>
		  <form method="post" action="{{ url('/gratuity/create') }}" enctype="multipart/form-data">
		  <div class="box-body">
		        <div class="row">

					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->
									@php if(($details != "")){ @endphp
											<input type="hidden" name="id" value="{{$details->id}}"/>
									@php }else{ @endphp
											<input type="hidden" name="id" value="" />
									@php } @endphp


							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="dateOfPayment">Date of Payment</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="dateOfPayment2" id="dateOfPayment2" class="form-control" value="{{date('d-m-Y', strtotime($details->dateofpayment))}}" />
											<input type="hidden" name="dateOfPayment" id="dateOfPayment" value="{{$details->dateofpayment}}" />
										@php }else{ @endphp
											<input type="text" name="dateOfPayment2" id="dateOfPayment2" value="{{old('dateOfPayment')}}" class="form-control" />
												<input type="hidden" name="dateOfPayment" id="dateOfPayment" value="{{old('dateOfPayment')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="rateOfGratuity">Rate of Gratuity per Annum</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="rateOfGratuity" class="form-control" value="{{$details->rateofgratuity}}"/>
										@php }else{ @endphp
											<input type="text" name="rateOfGratuity" class="form-control" value="{{old('rateOfGratuity')}}" />
										@php } @endphp
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="periodFrom">Period Covered From</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="periodFrom2" id="periodFrom2" class="form-control" value="{{date('d-m-Y', strtotime($details->periodfrom))}}" />
											<input type="hidden" name="periodFrom" id="periodFrom" value="{{$details->periodfrom}}" />
										@php }else{ @endphp
											<input type="text" name="periodFrom2" id="periodFrom2" value="{{old('periodFrom2')}}" class="form-control" />
												<input type="hidden" name="periodFrom" id="periodFrom" value="{{old('schoolFrom')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="periodTo">Period Covered To</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="periodTo2" id="periodTo2" class="form-control" value="{{date('d-m-Y', strtotime($details->periodto))}}" />
											<input type="hidden" name="periodTo" id="periodTo" value="{{$details->periodto}}" />
										@php }else{ @endphp
											<input type="text" name="periodTo2" id="periodTo2" value="{{old('periodTo2')}}" class="form-control" />
												<input type="hidden" name="periodTo" id="periodTo" value="{{old('periodTo')}}" />
										@php } @endphp
									</div>
								</div>
							</div>

							<!--<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="periodYear">Period Covered In Year</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="periodYear" class="form-control" value="{{$details->periodyear}}"/>
										@php }else{ @endphp
											<input type="text" name="periodYear" class="form-control" value="{{old('periodYear')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="periodMonth">Period Month</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="periodMonth" value="{{$details->periodmonth}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="periodMonth" class="form-control" value="{{old('periodMonth')}}" />
										 @php } @endphp
									</div>
								</div>
							</div>-->

							<div class="row">
								<!--<div class="col-md-6">
									<div class="form-group">
										<label for="periodDay">Period Day</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="periodDay" value="{{$details->periodday}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="periodDay" class="form-control" value="{{old('periodDay')}}" />
										 @php } @endphp
									</div>
								</div>-->
								<div class="col-md-6">
									<div class="form-group">
										<label for="amountPaid">Amount Paid</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="amountPaid" value="{{$details->amountpaid}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="amountPaid" class="form-control" value="{{old('amountPaid')}}" />
										 @php } @endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="pageRef">File Page Reference</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="pageRef" value="{{$details->pageref}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="pageRef" class="form-control" value="{{old('pageRef')}}" />
										 @php } @endphp
									</div>
								</div>

							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="gratuityCheckedBy">Checked By</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="gratuityCheckedBy" value="{{$details->gratuitycheckedby}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="gratuityCheckedBy" class="form-control" value="{{old('gratuityCheckedBy')}}" />
										 @php } @endphp
									</div>
								</div>

								<div class="col-md-6"></div>

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

					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th  rowspan="2">S/N</th>
								<th  rowspan="2">Date of <br/> Payment</th>
								<th  colspan="5" class="text-center">Period Covered</th>
								<th  rowspan="2">Rate of <br/> Gratuity p.a</th>
								<th  rowspan="2">Amount <br/> Paid</th>
								<th  rowspan="2">File <br/> Page Ref.</th>
								<th  rowspan="2">Checked <br/> By</th>
								<th  rowspan="2"></th>
								<th  rowspan="2"></th>
							</tr>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>Yrs</th>
								<th>Month</th>
								<th>Days</th>
							</tr>
						</thead>
						<tbody>
						@php if($gratuityList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($gratuityList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{date('d-m-Y', strtotime($list->dateofpayment))}}</td>
								<td>{{date('d-m-Y', strtotime($list->periodfrom))}}</td>
								<td>{{date('d-m-Y', strtotime($list->periodto))}}</td>
								<td>{{$list->periodyear}}</td>
								<td>{{$list->periodmonth}}</td>
								<td>{{$list->periodday}}</td>
								<td>{{number_format($list->rateofgratuity,2)}}</td>
								<td>{{number_format($list->amountpaid,2)}}</td>
								<td>{{$list->pageref}}</td>
								<td>{{$list->gratuitycheckedby}}</td>
								<td>
									<a href="{{url('/gratuity/edit/'.$list->id)}}" title="Edit" class="btn btn-sm btn-success fa fa-edit"></a>
								</td>
								<td>
									<!--<a href="{{url('/gratuity/remove/'.$list->id)}}" title="Remove" class="btn btn-sm btn-warning fa fa-trash"></a>-->
								</td>
							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="11" class="text-center">No details provided yet !</td>
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
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function loadProfileDetail(staffid) {
    document.getElementById('fileNos').value = staffid;
    document.forms["displayform"].submit();
    return;
}

$(function () {
    // Date of Payment
    $("#dateOfPayment2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
        onSelect: function (dateText, inst) {
            const [day, month, year] = dateText.split("-");
            const mysqlDate = `${year}-${month}-${day}`; // <-- MySQL format
            $("#dateOfPayment").val(mysqlDate);
        },
    });

    // Period From
    $("#periodFrom2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
        onSelect: function (dateText, inst) {
            const [day, month, year] = dateText.split("-");
            const mysqlDate = `${year}-${month}-${day}`;
            $("#periodFrom").val(mysqlDate);
        },
    });

    // Period To
    $("#periodTo2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
        onSelect: function (dateText, inst) {
            const [day, month, year] = dateText.split("-");
            const mysqlDate = `${year}-${month}-${day}`;
            $("#periodTo").val(mysqlDate);
        },
    });
});

$(document).ready(function () {
    // When page loads, ensure hidden inputs are in MySQL format if visible date exists
    function syncDateFields(visibleId, hiddenId) {
        const dateText = $(visibleId).val();
        if (dateText && dateText.includes('-')) {
            const parts = dateText.split('-');
            if (parts.length === 3) {
                const [day, month, year] = parts;
                $(hiddenId).val(`${year}-${month}-${day}`);
            }
        }
    }

    syncDateFields('#dateOfPayment2', '#dateOfPayment');
    syncDateFields('#periodFrom2', '#periodFrom');
    syncDateFields('#periodTo2', '#periodTo');
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
