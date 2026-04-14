@extends('layouts.layout')

@section('pageTitle')
 Add Particular of Children
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b>
        		<big><b class="text-green"> - {{strtoupper($getStaff->surname." ".$getStaff->first_name." ".$getStaff->othernames)}}</b></big><span id='processing'></span>
        	</h3>
    	</div>
		  <form method="post" action="{{ url('/children/create') }}">
		  <div class="box-body">
		        <div class="row">
		            
					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="fullName">Full Name</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="fullName" class="form-control" value="{{$details->fullname}}"/>
										@php }else{ @endphp
											<input type="text" name="fullName" class="form-control" value="{{old('fullName')}}" />
										@php } @endphp

										<!--NOTE: THIS'S FOR EDITTING-->
										@php if(($details != "")){ @endphp
											<input type="hidden" name="id" value="{{$details->id}}"/>
										@php }else{ @endphp
											<input type="hidden" name="id" value=""/>
										@php } @endphp

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Gender</label>
										@php if(($details != "")){ @endphp
										<select name="gender" class="form-control">
									        <option value="{{$details->gender}}">{{$details->gender}}</option>
									        <option value="Male" {{ (old("gender") == "Male" ? "selected":"") }}>Male</option>
									        <option value="Female" {{ (old("gender") == "Female" ? "selected":"") }}>Female</option>
								        </select>
								        @php }else{ @endphp
								        <select name="gender" class="form-control">
									        <option value=""></option>
									        <option value="Male" {{ (old("gender") == "Male" ? "selected":"") }}>Male</option>
									        <option value="Female" {{ (old("gender") == "Female" ? "selected":"") }}>Female</option>
								        </select>
								        @php } @endphp
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="dateOfBirth">Date of Birth</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="dateOfBirth2" id="dateOfBirth2" class="form-control" value="{{date('d M, Y', strtotime($details->dateofbirth))}}" />
											<input type="hidden" name="dateOfBirth" id="dateOfBirth" value="{{$details->dateofbirth}}" />
										@php }else{ @endphp
											<input type="text" name="dateOfBirth2" id="dateOfBirth2" value="{{old('dateOfBirth2')}}" class="form-control" />
												<input type="hidden" name="dateOfBirth" id="dateOfBirth" value="{{old('dateOfBirth')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="checkedChildrenParticulars">Checked By</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="checkedChildrenParticulars" value="{{$details->checked_children_particulars}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="checkedChildrenParticulars" class="form-control" value="{{old('checkedChildrenParticulars')}}" />
										 @php } @endphp
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
								<th>Full Name</th>
								<th>Gender</th>
								<th>Date of Birth</th>
								<th>Checked By</th>
								<th>Edit</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@php if($childrenList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($childrenList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->fullname}}</td>
								<td>{{$list->gender}}</td>
								<td>{{date('d-M-Y', strtotime($list->dateofbirth))}}</td>
								<td>{{$list->checked_children_particulars}}</td>
								<td><a href="{{url('/children/edit/'.$list->id)}}" title="Edit" class="btn btn-success fa fa-edit"></a>
								</td>
								<td><!--<a href="{{url('/children/remove/'.$list->id)}}" title="Remove" class="btn btn-warning fa fa-trash"></a>-->
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
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ✅ Toast for success after redirect
@if(session('msg'))
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '{{ session('msg') }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
@endif
</script>
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
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
				$("#dateOfBirth").val(dateFormatted);
        	},
		});

  } );
</script>
@endsection
