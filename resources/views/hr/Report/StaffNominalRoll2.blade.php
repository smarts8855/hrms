@extends('layouts.layout')
@section('pageTitle')
Nominal Roll Reports
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
	<form method="post"  id="thisform1" name="thisform1">
		{{ csrf_field() }}
		<div class="box-body">
			 <div class="row">
			 @if ($CourtInfo->courtstatus==1)
	            		<div class="col-md-4">
	            		<label>Court</label>
				<select name="court" id="court" class="form-control" onchange ="ReloadForm();" >
		                <option value="" selected>-All court-</option>
		                	@foreach ($CourtList as $b)
						<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}({{$b->courtAbbr}})</option>
		                	@endforeach 
		                </select>
	            		</div>
	            	@else
			<input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
			@endif 
			@if ($CourtInfo->divisionstatus==1) 
	            		<div class="col-md-4">
	            		<label>Division</label>
				<select name="division" id="division" class="form-control" >
		                <option value="" selected>-All division-</option>
		                	@foreach ($Divisions as $b)
						<option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>
		                	@endforeach 
		                </select>
	            		</div>
	            	@else
			<input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
			@endif
	            		          		
	            	</div>
	            	 <div class="row">
	            	 <div class="col-md-3">
	            		<label>Grade</label>
					<select name="grade" id="grade" class="form-control"  >
		                <option value="" selected>-All Grades-</option>
		                	@for ($i = 1; $i <=17; $i++)
		                	<option value="{{ $i }}" {{ ($grade) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>  
	            	 <div class="col-md-3">
	            		<label>Employment Type</label>
				<select name="employmenttype" id="employmenttype" class="form-control"  >
		                <option value="" selected>-All type-</option>
		                	@foreach ($EmployeeTypeList as $b)
						<option value="{{$b->id}}" {{ ($employmenttype) == $b->id? "selected":"" }}>{{$b->employmentType}}</option>
		                	@endforeach 
		                </select>
	            		</div>
	            		<div class="col-md-3">
	            		<label>Cadre</label>
				<select name="department" id="department" class="form-control"  >
		                <option value="" selected>-All department-</option>
		                	@foreach ($DepartmentList as $b)
						<option value="{{$b->id}}" {{ ($department) == $b->id? "selected":"" }}>{{$b->department}}</option>
		                	@endforeach 
		                </select>
	            		</div>
	     
	            		<div class="col-md-3">
	            		<label>Designation</label>
				<select name="designation" id="designation" class="form-control"  >
		                <option value="" selected>-All designition-</option>
		                	@foreach ($DesignationList as $b)
						<option value="{{$b->id}}" {{ ($designation) == $b->id? "selected":"" }}>{{$b->designation}}</option>
		                	@endforeach 
		                </select>
	            		</div>
	            		
	            	</div>
			 <div class="row">
			 	
	            		
	            		
	            		
	            		<div class="col-md-2">
	            		<label>Employment period from</label>
					<input type="text" name="fromdate" id="fromdate" class="form-control" value="{{$fromdate}}"  />
					
	            		</div>
	            		<div class="col-md-2">
	            		<label>To</label>
					
					<input type="text" name="todate" id="todate" class="form-control" value="{{$todate}}"  />
	            		</div>
	            		<div class="col-md-2">
	            		<label>Gender</label>
				<select name="gender" id="gender" class="form-control"  >
		                <option value="" selected>-All gender-</option>
		                	@foreach ($Gender as $b)
						<option value="{{$b->gender}}" {{ ($gender) == $b->gender? "selected":"" }}>{{$b->gender}}</option>
		                	@endforeach 
		                </select>
	            		</div>
	            		<div class="col-md-2">
	            		 <label>Sort Order</label>
				<select name="orderlist" id="orderlist" class="form-control"  >
		                <option value="" selected>-Select Order-</option>
		                	@foreach ($OrderList as $b)
						<option value="{{$b->field}}" {{ ($orderlist) == $b->field? "selected":"" }}>{{$b->fieldDescription}}</option>
		                	@endforeach 
		                </select>
	            		</div>
	            		<div class="col-md-4">
				<br>
					<button type="submit" class="btn btn-success col-md-3" onclick="return checkForm();" name="add">
						<i class="fa fa-btn fa-search-plus"></i> search
					</button>
					@if(!empty($QueryStaffReport))
					<b>
						@if(count($QueryStaffReport) == 0 || count($QueryStaffReport) < 1)
							<span class="text-center text-warning ">{{count($QueryStaffReport)}} Result </span>
						@else
							<span class="text-center text-success "> {{count($QueryStaffReport)}} Results </span>
						@endif
						</b>
					<span onclick="return myFunc()" class="btn btn-primary pull-right col-md-3" name="add">
						<i class="fa fa-print"></i> Print
					</span>
					@endif
										
				</div>
	            		</div>
	            		<div class="row">
	            		
	            		
	          
	            		
				
	            		
			</div>
		<input id ="delcode" type="hidden"  name="delcode" >
		<input id ="fieldstoview" type="hidden"  name="delcode" value="{{ json_encode($fieldstoview) }}">
		<div class="table-responsive" style="font-size: 12px; padding:10px;">
			<table class="table table-bordered table-striped table-highlight" id="tablr">
			<thead>
			<tr bgcolor="#c7c7c7">
			                <th width="1%">S/N</th>	 
			               
			                <th >Name in full</th>
			             
				                <th >Date of Birth</th>
				                <th >Gender</th>
				                <th >Marital Status</th>
				                <th >L.G.A</th>
				                <th >State of Origin</th>		                
				                <th >Date of Appointment</th>
				                <th >Rank</th>
				                <th >Date of Present Appointment</th>
				                <!---<th >Grade</th>
				                <th >Steps</th>
				                <th >Date of present appointment</th>-->
				               @if ($CourtInfo->divisionstatus==1)  <th >Division</th> @endif
				                <th >Qualifications</th>
			          
					
				 		</tr>
			</thead>
						@php $serialNum = 1; @endphp
						@foreach ($QueryStaffReport as $b)
							<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->StaffName}}</td>
							
								<td class="dob">{{$b->dob}}</td>
									    					
			    					<td class="gender">{{$b->gender}}</td>
			    				
			    					<td class="ms">{{$b->MStatus}}</td>
			    				
			    					<td class="lga">{{$b->LGA}}</td>
			    					    				
			    					<td class="soo">{{$b->State}}</td>
			    				
			    					<td class="doa">{{$b->appointment_date}}</td>
			    				
			    					<td class="rank">{{$b->designations}}</td>
			    				
			    					<td class="dopa">{{$b->date_present_appointment}}</td>
			    				
			    					@if ($CourtInfo->divisionstatus==1) <td class="div">{{$b->divisions}}</td> @endif
			    				
			    					<td class="qua">{{$b->qualifications }}</td>
			    				
			    				
								
							</tr>
						@endforeach
			
						
			 </table>
		</div>
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
	$(document).ready(function(){
		 $('#fields').multiselect({
		  nonSelectedText: 'Select fields to view',
		  enableFiltering: true,
		  enableCaseInsensitiveFiltering: true,
		  buttonWidth:'400px',
		  includeSelectAllOption: true,
		 });
	});
</script>
  <script type="text/javascript">
  	function checkForm(){
  		var fields = document.getElementById('fields').value;
  		var form = document.getElementById('thisform1');
  		if(fields == ''){
  			alert('Please select fields to view'); 
  			return false;
  		} else{
  			form.submit();
  		}
  		return false;
  	}
  	
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
  $( function() {
    $( "#todate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#fromdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );
  </script>
  <script>
  function myFunc(){
		var printme = document.getElementById('tablr');
		var wme = window.open("", "", "width=900,height=700");
		wme.document.write(printme.outerHTML);
		wme.document.close();
		wme.focus();
		wme.print();
		wme.close();
	}
	</script>
@endsection
