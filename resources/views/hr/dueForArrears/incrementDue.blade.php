@extends('layouts.layout')
@section('pageTitle')
Increment Arrears
@endsection

@section('content')


<div id="editModal" class="modal fade">
 <div class="modal-dialog box box-default" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Step </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    	<form method="post" action="" >
		{{ csrf_field() }}
		    <div class="modal-body">  
		        <div class="form-group" style="margin: 0 10px;">
		           
		          
		          <input type="hidden" id="fileNo" name="staffNameEdit" value="">
		          <input type="hidden" id="courty" name="courty" value="">
		          <input type="hidden" id="divisiony" name="divisiony" value="">
		          
		           
		        </div>
				<div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-2 control-label">Step</label>
		            
		           <select name="newStep" id="step" class="form-control" required>
					<option value=''> - Select Step</option>
					
					<option value="1" >1</option>
					<option value="2" >2</option>
					<option value="3" >3</option>
					<option value="4" >4</option>
					<option value="5" >5</option>
					<option value="6" >6</option>
					<option value="7" >7</option>
					<option value="8" >8</option>
					<option value="9" >9</option>
					<option value="10" >10</option>
					<option value="11" >11</option>
					<option value="12" >12</option>
					<option value="13" >13</option>
					<option value="14" >14</option>
					<option value="15" >15</option>
				  </select>
				 
		           
		        </div>
				
				<div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-4 control-label">Due Date</label>
					<input type="date" name="dueDate" id="date" class="form-control stylecontrol" value="">
		        </div>
		        <div class="modal-footer">
		            <button type="submit" name="edit" class="btn btn-success">Save changes</button>
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        </div>

		       
		    </div>
		</form>
      
  </div>
</div>
</div>


 <div id="insertModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
			<div class="modal-content">
				<div class="modal-header">
					  <h4 class="modal-title">Approve Increment</h4>
					  
				</div>
		   		<form method="post" action="" >
				{{ csrf_field() }}
				<div class="modal-body">  
					<div class="form-group" style="margin: 0 10px;">
						
						<h4>Are you sure you want to approve this item?</h4>
						<input type="hidden" id="courtn" name="courtn" value="">
				        <input type="hidden" id="divisionn" name="divisionn" value="">
				        <input type="hidden" id="staffNamey" name="staffNamey" value="">
					  
					   
					</div>
					<div class="modal-footer">
						<button type="submit" name="newinsert" class="btn btn-success">Save changes</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				 
					
				</div>
			</form>
	      
	          </div>
	    </div>
	</div>


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
	            		<label for="staffName">Court</label>
						  <select name="court" id="staf" class="form-control court" onchange="ReloadForm()" required>
							<option value=''>-Select court-</option>
							@foreach ($CourtList as $b)
							<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>
							@endforeach 
						  </select>
	            		</div>
	            		@else
			            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
			          @endif
	            		@if ($CourtInfo->divisionstatus==1)
	            		<div class="col-md-4"  style="padding-right: 0px">
							<div class="form-group">
							  <label for="staffName">Division</label>
							  <select name="division" id="division" class="form-control" onchange="ReloadForm()" required>
								<option value=''>-Select division-</option>
								@foreach ($DivisionList as $b)
								<option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>
								@endforeach 
							  </select>
							</div>
						</div>
					@else
				              <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
				        @endif
						<div class="col-md-3"  style="padding-right: 0px">
							<div class="form-group">
							  <label for="staffName">Select Staff Name</label>
							  <select name="staffName" id="staffName" class="form-control" onchange="ReloadForm()" required>
								<option value=''>-Select staff-</option>
								<option value=''>All</option>
								@foreach ($staffList as $b)
								<option value="{{$b->fileNo}}" {{ ($staffName) == $b->fileNo? "selected":"" }}>{{$b->fileNo}}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</option>
								@endforeach 
							  </select>
							</div>
						</div>
						
	            		
			</div>
		</form>

		
		<div class="table-responsive" style="font-size: 12px; padding:10px;">
			<table class="table table-hover table-striped table-responsive ">
				<form method="post" id="form2" name="form2">
					{{ csrf_field() }}
					<div class="col-md-6"></div>
                    <div class="col-md-6 " >
			                  <div class="col-md-0 checkbox pull-right" style="margin:2px;">
			                  	<label class="text-primary" for="check-all">
			                  		<input  type="checkbox" class="checkitem" id="toggle" value="select" onClick="do_this()">CheckAll
			                  	</label>
			                  </div>
			                  
                    		  <div class="col-md-0 pull-right" style="margin:2px;" >
								<button  class="btn btn-success " type="submit" id="" value="" name="insert"> Approve <i class="fa fa-check"></i> </button>
							  </div>
			        </div>
					<thead>
						<tr>
							<th>File Number</th>
							<th>Staff Name</th>
					        <th>Grade</th>
					        <th>Step</th>
					        <th>Proposed Step</th> 
					        <th>Previous Due Date</th>
					        <th>Approve</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
					    @foreach ($due as $d)

						<tr>
							<td>{{$d->fileNo}}</td>
					        <td>{{$d->surname}} {{$d->first_name}} {{$d->othernames}}</td>
					        <td>{{$d->grade}}</td>
					        <td>{{$d->step}}</td>
					        <td>{{$d->step +1}}</td>
					        <td>{{$d->laststep_update}}</td>
					        <td>
					        	
								<button  class="btn btn-success " type="button" id="" value="" onclick="newfunc('{{$d->ID}}', '{{$d->courtID}}', '{{$d->divisionID}}')"> Approve <i class="fa fa-check"></i> </button>
								<button  class="btn btn-primary" type="button" onclick="editfunc('{{$d->fileNo}}','{{$d->divisionID}}','{{$d->courtID}}')"> Edit <i class="fa fa-edit"></i> </button> 
								<input type="checkbox" name="checkbox[]" id="fileNo" value="{{$d->fileNo}}">
								
								
					        </td>
							

						</tr>

			            <input type="hidden" value="{{$d->courtID}}" id="type" name="courty">
			            <input type="hidden" value="{{$d->divisionID}}" name="divisiony" id="chosen">

						@endforeach
					</tbody>
				</form>
			</table>
		</div>
		
		</div>
		
	
</div>



@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<style type="text/css">
    .modal-dialog {
width:10cm
}

.modal-header {

background-color: #09b65f;

color:#FFF;

}


</style>

@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">

  	  function do_this(){

        var checkboxes = document.getElementsByName('checkbox[]');
        var button = document.getElementById('toggle');

        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
        }
    }

	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}

	function  ReloadFor2()
	{	
	document.getElementById('form2').submit();
	return;
	}
	
	function  ReloadFormcourtdivision()
	{	
	document.getElementById('staffName').value='';
	document.getElementById('thisform1').submit();
	return;
	}
	
	
	function editfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#fileNo').val(a);
	$('#divisiony').val(b);
	$('#courty').val(c);
	$("#editModal").modal('show');
	});
	}

	function newfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#staffNamey').val(a);
	$('#courtn').val(b);
	$('#divisionn').val(b);
	$("#insertModal").modal('show');
	});
	}
	
	function delfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#earningDeductionID').val(a);
	$('#depty').val(b);
	$('#courty').val(c);
	$("#delModal").modal('show');
	});
	}

	function approve(a = ''){
        if(a !== ''){
        document.getElementById('chosen').value = a;
           // alert(a);
        }
        courty = document.getElementById('courty').value;
        divisiony = document.getElementById('divisiony').value;
        fileNo = document.getElementById('fileNo').value;
        oldgrade = document.getElementById('oldgrade').value;
        oldstep = document.getElementById('oldstep').value;
        emptype = document.getElementById('emptype').value;
        duedate = document.getElementById('duedate').value;
        document.getElementById('courty').value = courty;
        document.getElementById('divisiony').value = divisiony;
        document.getElementById('fileNo').value = fileNo;
        document.getElementById('oldgrade').value = oldgrade;
        document.getElementById('oldstep').value = oldstep;
        document.getElementById('emptype').value = emptype;
        document.getElementById('duedate').value = duedate;
        document.getElementById('type').value = 1;
        document.getElementById('form2').submit();
       return false;
   	}
	
  
  $( function() {
      $("#overdueDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#dueDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#incrementalDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    } );
  </script>
@endsection
