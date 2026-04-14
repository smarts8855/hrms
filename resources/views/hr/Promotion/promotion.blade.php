@extends('layouts.layout')
@section('pageTitle')
Add Staff Promotion
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
	<form method="post"  id="thisform1" name="thisform1">
		{{ csrf_field() }}
		<div class="box-body">
			 <div class="row">
	            		<div class="col-md-2">
	            		<label>Staff id</label>
				<input type="text" list="staffid" name="staffid"  class="form-control"  value="{{$staffid}}" placeholder="Select staff detail" onchange="ReloadForm()" required>
						<datalist id="staffid">
							@foreach ($staffList as $b)
							<option value="{{ $b->fileNo }}" >{{ $b->fileNo }}:{{ $b->surname }} {{ $b->first_name }}</</option>
							@endforeach
						</datalist>
	            		</div>

	            		<div class="col-md-2">
	            		<label>Previous Grade</label>
						<select name="prevgrade" id="prevgrade" class="form-control" required>
		                <option value="" selected>Select Grade</option>
		                	@for ($i = 1; $i < 17; $i++)
								<option value="{{$i}}" {{ ($prevgrade) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>

	            		<div class="col-md-1">
	            		<label>Prev Step</label>
						<select name="prevstep" id="prevstep" class="form-control" required>
		                <option value="" selected>Select Step</option>
		                	@for ($i = 1; $i < 15; $i++)
		                	<option value="{{ $i }}" {{ ($prevstep) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>

	            		<div class="col-md-2">
	            		<label>New Grade</label>
						<select name="newgrade" id="newgrade" class="form-control" required>
		                <option value="" selected>Select Grade</option>
		                	@for ($i = 1; $i < 17; $i++)
		                	<option value="{{ $i }}" {{ ($newgrade) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>

	            		<div class="col-md-1">
	            		<label>New Step</label>
	            		<select name="newstep" id="newstep" class="form-control" required>
		                <option value="" selected>Select Step</option>
		                	@for ($i = 1; $i < 15; $i++)
		                	<option value="{{ $i }}" {{ ($newstep) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>

	            		<div class="col-md-2">
	            		<label>Approved Date</label>
	            		<input type="text" name="approvedate" id="approvedate" class="form-control" value="{{$approvedate}}" required />
	            		</div>
						<div class="col-md-2">
						<br>
							<button type="submit" class="btn btn-success" name="add">
								<i class="fa fa-btn fa-floppy-o"></i> Add
							</button>
						</div>

			</div>
		</div>
		<input id ="delcode" type="hidden"  name="delcode" >
		<div class="table-responsive" style="font-size: 12px; padding:10px;">
<table class="table table-bordered table-striped table-highlight" >
<thead>
<tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>
                <th >Staff details</th>
                <th >Previous Grade</th>
                <th >Previous Step</th>
				<th >New Grade</th>
                <th >New Step</th>
                 <th >Approved Date</th>
				 <th >Action</th>
	 		</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($staffPromotion as $b)
				<tr>
				    <td>{{ $serialNum ++}} </td>
    				<td>{{$b->staffid}}-{{$b->StaffName}}</td>
    				<td>{{$b->prevgrade}}</td>
    				<td>{{$b->prevstep}}</td>
    				<td>{{$b->newgrade}}</td>
					<td>{{$b->newstep}}</td>
                    <td>{{date('d-m-Y', strtotime($b->promodate))}}</td>
					{{-- <td>{{$b->promodate}}</td> --}}
					<td><a href="javascript: DeletePromo('{{$b->promoid}}')">Delete</a></td>
				</tr>
			@endforeach

 </table>
</div>
	</form>

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
	document.getElementById('thisform1').submit();
	return;
	}
	function  DeletePromo(id)
	{
		var cmt = confirm('You are about to delete a record. Click OK to continue?');
              if (cmt == true) {
					document.getElementById('delcode').value=id;
					document.getElementById('thisform1').submit();
					return;

              }

	}
  	(function () {
	$('#staffList').change( function(){
    $('#processing').text('Processing. Please wait...');
		$.ajax({
			url: murl +'/json/staff/search',
			type: "post",
			data: {'staffList': $('#staffList').val(), '_token': $('input[name=_token]').val()},
			success: function(data){
				//$('#fileNo').attr("readonly", false);
				$('#AddNew').attr("disabled", true);
				$('#Update').attr("disabled", false);
		        $('#processing').text('');
		        $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
		        $('#surname').val(data.surname);
		        $('#fileNo').val(data.fileNo);
		        $('#ID').val(data.ID);
		        $('#oldFileNo').val(data.fileNo);
		        $('#title').val(data.title);
		        $('#firstName').val(data.first_name);
		        $('#otherNames').val(data.othernames);
		        $('#designation').val(data.Designation);
		        $('#grade').val(data.grade);
		        $('#step').val(data.step);
		        $('#bankID').val(data.bankID);
		        $('#bankGroup').val(data.bankGroup);
		        $('#bankBranch').val(data.bank_branch);
		        $('#accountNo').val(data.AccNo);
		        $('#section').val(data.section);
		        $('#appointmentDate').val(data.appointment_date);
		        $('#incrementalDate').val(data.incremental_date);
		        $('#dateofBirth').val(data.dob);
		        $('#employeeType').val(data.employee_type);
		        $('#gender').val(data.gender);
		        $('#currentState').val(data.current_state);
		        $('#governmentQuarters').val(data.government_qtr);
		        $('#homeAddress').val(data.home_address);
		        $('#nhfNo').val(data.nhfNo);
			}
		})
	});}) ();

	$('#reset').click( function(){
		$('#fileNo').attr("readonly", true);
		$('#AddNew').attr("disabled", false);
		$('#Update').attr("disabled", true);
	});
////////////////////////////////////////////////////////
$( function() {
    $( "#dateofBirth" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );

  </script>
@endsection

