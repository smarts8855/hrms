@extends('layouts.layout')
@section('pageTitle')
Designation set-up
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
			 
	            		<div class="col-md-2">
	            		<label>Court</label>
	            			<select name="court" id="staf" class="form-control court" onchange="ReloadFormcourtdivision()" required>
								<option value=''>-Select court-</option>
								@foreach ($CourtList as $b)
								<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>
								@endforeach 
							  </select>
	            		</div>
	            		
	            		<div class="col-md-2">
	            		<label>Department</label>
							
							</select>
							  <select name="department" id="department" class="form-control department" onchange="ReloadForm()" required>
								<option value=''>-Select Department-</option>
								@foreach ($DepartmentList as $a)
								<option value="{{$a->id}}" {{ ($department) == $a->id? "selected":"" }}>{{$a->department}}</option>
								@endforeach 
							  </select>
	            		</div>
						<div class="col-md-2">
	            		<label>Grade Level</label>
						<select name="level" class="form-control" required>
							<option Value="">Select Grade Level</option>
							<?php
								for($i =1;$i<=17;$i++)
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}

							?>
						</select>
	            		</div>
						<div class="col-md-4">
	            		<label>Post</label>
					<input type="text"  name="designation"  class="form-control"  value="" placeholder="Input Post">
	            		</div>
	            		 
				<div class="col-md-2">
				<br>
					<button type="submit" class="btn btn-success" name="add">
						<i class="fa fa-btn fa-floppy-o"></i> Add New
					</button>						
				</div>
	            		
			</div>
		<input id ="delcode" type="hidden"  name="delcode" >
		<div class="table-responsive" style="font-size: 12px; padding:10px;">
			<table class="table table-bordered table-striped table-highlight" >
			<thead>
			<tr bgcolor="#c7c7c7">
			                <th width="1%">S/N</th>	 
			                @if ($showcourt)<th >Court</th>@endif
			                <th >Department</th>
					<th >Grade Level</th>
					<th >Designation</th>
					<th >Action</th>
				 		</tr>
			</thead>
						@php $serialNum = 1; @endphp
			
						@foreach ($DesignationList as $b)
							<tr>
							<td>{{ $serialNum ++}} </td>
			    				<td>{{$b->court_name}}</td>
								<td>{{$b->department}}</td>
								<td>{{$b->grade}}</td>
			    				<td>{{$b->designation}}</td>
			    				
								<td>
									<button type="button" class="btn btn-primary fa fa-edit" onclick="editfunc('{{$b->designation}}', '{{$b->id}}', '{{$b->courtID}}', '{{$b->departmentID}}')" class="" id="" > Edit</button>
							
								<button type="button" class="btn btn-warning fa fa-times" onclick="delfunc('{{$b->id}}', '{{$b->departmentID}}', '{{$b->courtID}}')
                                "> Delete</button>
								</td>	
							</tr>
							

						@endforeach
						
			 </table>
		</div>
		</div>
		
	</form>
	
</div>

<div id="editModal" class="modal fade">
 <div class="modal-dialog box box-default" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Designation  </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form class="form-horizontal" id="editLgaModal" name="editLgaModal"
            role="form" method="POST" action="{{url('basic/designation/edit')}}">
            {{ csrf_field() }}
    <div class="modal-body">  
        <div class="form-group" style="margin: 0 10px;">
            <label class="col-sm-2 control-label">Designation</label>
            <input type="text" class="col-sm-9 form-control" id="designation" name="designation">
           
          <input type="hidden" id="DeptID" name="DeptID" value="">
            <input type="hidden" id="court" name="CourtID" value="">
            <input type="hidden" id="id" name="PostID" value="">
           
        </div>
        <div class="modal-footer">
            <button type="Submit" class="btn btn-success">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
     
        </form>
    </div>
      
          </div>
        </div>
      </div>
      
      
    <div id="delModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Delete Designation</h4>
	      
	    </div>
	    <form class="form-horizontal" id="editLgaModal" name="editLgaModal"
	            role="form" method="POST" action="{{url('basic/designation/delete')}}">
	            {{ csrf_field() }}
	    <div class="modal-body">  
	        <div class="form-group" style="margin: 0 10px;">
	            
	            <h4>Are you sure you want to delete this item?</h4>
	            <input type="hidden" class="col-sm-9 form-control" id="postID" name="PostID">
	               <input type="hidden" id="depty" name="depty" value="">
	               <input type="hidden" id="courty" name="courty" value="">
	          
	           
	        </div>
	        <div class="modal-footer">
	            <button type="Submit" class="btn btn-success">Save changes</button>
	            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        </div>
	     
	        </form>
	    </div>
	      
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

background-color: #006600;

color:#FFF;

}


</style>

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}
	
	function  ReloadFormcourtdivision()
	{	
	document.getElementById('department').value='';
	document.getElementById('thisform1').submit();
	return;
	}
	
	function editfunc(a,b,c,d)
	{
	$(document).ready(function(){
	$('#designation').val(a);
	$('#id').val(b);
	$('#court').val(c);
	$('#DepID').val(d);
	$("#editModal").modal('show');
	});
	}
	
	function delfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#postID').val(a);
	$('#depty').val(b);
	$('#courty').val(c);
	$("#delModal").modal('show');
	});
	}
  	
	
  	
  </script>
@endsection
