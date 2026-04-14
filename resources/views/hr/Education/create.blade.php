@extends('layouts.layout')

@section('pageTitle')
 Add Education
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b>
        		<big><b class="text-green"> - {{strtoupper($getStaff->surname." ".$getStaff->first_name." ".$getStaff->othernames)}}</b></big><span id='processing'></span>
        	</h3>
    	</div>
		  <form method="post" action="{{ url('/education/create') }}" enctype="multipart/form-data">
		  <div class="box-body">
		        <div class="row">

					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="fullName">Degrees & Professional Qualifications</label>
										@php if(($details != "")){ @endphp
											<select name="degreeQualification" class="form-control">
												<option>{{$details->degreequalification}}</option>
												@foreach($qualificationList as $qList)
												<option>{{$qList->qualification}}</option>
												@endforeach
											</select>
											<!--<input type="text" name="degreeQualification" class="form-control" value="{{$details->degreequalification}}"/>-->
										@php }else{ @endphp
											<select name="degreeQualification" class="form-control">
												<option></option>
												@foreach($qualificationList as $qList)
												<option>{{$qList->qualification}}</option>
												@endforeach
											</select>
											<!--<input type="text" name="degreeQualification" class="form-control" value="{{old('degreeQualification')}}" />-->
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
										<label for="month">School Attended</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="schoolAttended" class="form-control" value="{{$details->schoolattended}}"/>
										@php }else{ @endphp
											<input type="text" name="schoolAttended" class="form-control" value="{{old('schoolAttended')}}" />
										@php } @endphp
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="schoolFrom">School Attended From</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="schoolFrom2" id="schoolFrom2" class="form-control" value="{{date('d M, Y', strtotime($details->schoolfrom))}}" />
											<input type="hidden" name="schoolFrom" id="schoolFrom" value="{{$details->schoolfrom}}" />
										@php }else{ @endphp
											<input type="text" name="schoolFrom2" id="schoolFrom2" value="{{old('schoolFrom2')}}" class="form-control" />
												<input type="hidden" name="schoolFrom" id="schoolFrom" value="{{old('schoolFrom')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="schoolTo">School Attended To</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="schoolTo2" id="schoolTo2" class="form-control" value="{{date('d M, Y', strtotime($details->schoolto))}}" />
											<input type="hidden" name="schoolTo" id="schoolTo" value="{{$details->schoolto}}" />
										@php }else{ @endphp
											<input type="text" name="schoolTo2" id="schoolTo2" value="{{old('schoolTo2')}}" class="form-control" />
												<input type="hidden" name="schoolTo" id="schoolTo" value="{{old('schoolTo')}}" />
										@php } @endphp
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="certificateHeld">School Certificates Held</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="certificateHeld" class="form-control" value="{{$details->certificateheld}}"/>
										@php }else{ @endphp
											<input type="text" name="certificateHeld" class="form-control" value="{{old('certificateHeld')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="checkedEducation">Checked By</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="checkedEducation" value="{{$details->checkededucation}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="checkedEducation" class="form-control" value="{{old('checkedEducation')}}" />
										 @php } @endphp
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="document">Attach a Scanned Document (Optional)</label>
										<input type="file" name="document" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
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
								<th>Surname</th>
								<th>FileNo</th>
								<th>Degrees & Prof. Qualifications</th>
								<th>School Attended</th>
								<th>From</th>
								<th>To</th>
								<th>Certificates Held</th>
								<th>Checked By</th>
								<th>Doc.</th>
								<th>Edit</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@php if($educationList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($educationList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->surname}}</td>
								<td>{{$list->fileNo}}</td>
								<td>{{$list->degreequalification}}</td>
								<td>{{$list->schoolattended}}</td>
								<td>{{date('d-M-Y', strtotime($list->schoolfrom))}}</td>
								<td>{{date('d-M-Y', strtotime($list->schoolto))}}</td>
								<td>{{$list->certificateheld}}</td>
								<td>{{$list->checkededucation}}</td>
								<td>
								@php if($list->document != ""){ @endphp
									<a href="{{asset('document/'.$list->document)}}" target="_blank">
										<i class="fa fa-download"></i>
									</a>
								@php }else{ @endphp
										No File
								@php } @endphp
								</td>
								<td>
									<a href="{{url('/education/edit/'.$list->id)}}" title="Edit" class="btn btn-sm btn-success fa fa-edit"></a>
								</td>
								<td>
									<!--<a href="{{url('/education/remove/'.$list->id)}}" title="Remove" class="btn btn-sm btn-warning fa fa-trash"></a>-->
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
function  loadProfileDetail(staffid)
{
document.getElementById('fileNos').value = staffid;
document.forms["displayform"].submit();
return;

}
</script>
  {{-- <script type="text/javascript">

	$( function() {
	    $("#schoolFrom2").datepicker({
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
				$("#schoolFrom").val(dateFormatted);
        	},
		});
  	});

  	$( function() {
	    $("#schoolTo2").datepicker({
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
				$("#schoolTo").val(dateFormatted);
        	},
		});
  	});

</script> --}}

<script>
$(function () {
    $("#schoolFrom2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy", // visible field format
        onSelect: function (dateText, inst) {
            // Convert to YYYY-MM-DD for database
            const parts = dateText.split('-');
            const formatted = parts[2] + '-' + parts[1] + '-' + parts[0];
            $("#schoolFrom").val(formatted);
        }
    });

    $("#schoolTo2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090',
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy", // visible field format
        onSelect: function (dateText, inst) {
            const parts = dateText.split('-');
            const formatted = parts[2] + '-' + parts[1] + '-' + parts[0];
            $("#schoolTo").val(formatted);
        }
    });
});
</script>

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

<script>

@endsection
