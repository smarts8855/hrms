@extends('layouts.layout')
@section('pageTitle')
Earning Deduction control
@endsection

@section('content')

<div id="editModal" class="modal fade">
 <div class="modal-dialog box box-default" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Earning/Deduction  </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    	<form method="post" action="" >
		{{ csrf_field() }}
		    <div class="modal-body">  
		        <div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-2 control-label">Designation</label>
		            <input type="text" class="col-sm-9 form-control" id="amount" name="amountedit">
		          
		          <input type="hidden" id="earningDeductionID" name="earningDeductionID" value="">
		          <input type="hidden" id="court" name="court" value="">
		          <input type="hidden" id="division" name="division" value="">
		          <input type="hidden" id="staffName" name="staffName" value="">
		          
		           
		        </div>
				<div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-2 control-label">Earning/Deduction</label>
		            
		           <select name="earningDeductionedit" id="earningDeduction" class="form-control" required>
					<option value=''>-Earning Deduction-</option>
					@foreach ($earningDeduction as $e)
					<option value="{{$e->ID}}" >{{$e->description}}</option>
					@endforeach 
				  </select>
				 
		           
		        </div>
				
				<div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-2 control-label">Remarks</label>
		          
				  <textarea class="form-control" type="text" name="remarkedit" id="remark"> </textarea>
									  
		         
		           
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

      
    <div id="delModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
			<div class="modal-content">
				<div class="modal-header">
					  <h4 class="modal-title">Delete Designation</h4>
					  
				</div>
		   		<form method="post" action="" >
				{{ csrf_field() }}
				<div class="modal-body">  
					<div class="form-group" style="margin: 0 10px;">
						
						<h4>Are you sure you want to delete this item?</h4>
						<input type="hidden" class="col-sm-9 form-control" id="delID" name="delID">
						<input type="hidden" id="courty" name="court" value="">
				        <input type="hidden" id="divisiony" name="division" value="">
				        <input type="hidden" id="staffNamey" name="staffName" value="">
					  
					   
					</div>
					<div class="modal-footer">
						<button type="submit" name="delete" class="btn btn-success">Save changes</button>
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
			 
	            		<div class="col-md-4">
	            		<label for="staffName">Court</label>
						  <select name="court" id="staf" class="form-control court" onchange="ReloadForm()" required>
							<option value=''>-Select court-</option>
							@foreach ($CourtList as $b)
							<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>
							@endforeach 
						  </select>
	            		</div>
	            		
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
						
						<div class="col-md-3"  style="padding-right: 0px">
							<div class="form-group">
							  <label for="staffName">Select Staff Name</label>
							  <select name="staffName" id="staffName" class="form-control" onchange="ReloadForm()" required>
								<option value=''>-Select staff-</option>
								@foreach ($staffList as $b)
								<option value="{{$b->fileNo}}" {{ ($staffName) == $b->fileNo? "selected":"" }}>{{$b->fileNo}}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</option>
								@endforeach 
							  </select>
							</div>
						</div>
						
	            		
			</div>
			<div class="row">
			<div class="col-md-2"  style="padding-right: 0px">
							<div class="form-group">
							  <label for="staffName">Earning Deduction</label>
							  <select name="earningDeduction" class="form-control">
								<option value=''>-Earning Deduction-</option>
								@foreach ($earningDeduction as $e)
								<option value="{{$e->ID}}">{{$e->description}}</option>
								@endforeach 
							  </select>
							</div>
						</div>
						<div class="col-md-2"  style="padding-right: 0px">
							<div class="form-group">
							  <label for="staffName">Amount</label>
								<input type="text" name="amount" id="" class="form-control" value="" >
							</div>
						</div>
						<div class="col-md-6"  style="padding-right: 0px">
							<div class="form-group">
							  <label for="staffName">Remark</label>
								<textarea type="text" name="remark" id="" class="form-control" value="" ></textarea>
							</div>
						</div>
	            		 
						<div class="col-md-2">
						<br>
							<button type="submit" class="btn btn-success" name="add">
								<i class="fa fa-btn fa-floppy-o"></i> Add New
							</button>						
						</div>

				</form>
			</div>
		<div class="table-responsive" style="font-size: 12px; padding:10px;">
			<table class="table table-bordered table-striped table-highlight" >
				<thead>
						<tr bgcolor="#c7c7c7">
							<th width="1%">S/N</th>	 
							<th >Name</th>
							<th >Deduction</th>
							<th >Amount</th>
							<th >Remark</th>
							<th >Action</th>
						</tr>
				</thead>
						@php $serialNum = 1; @endphp
			
						@foreach ($earningDeductionList as $b)
							<tr>
							<td>{{ $serialNum ++}} </td>
			    				<td>{{$b->first_name}} {{$b->surname}} {{$b->othernames}}</td>
			    				<td>{{$b->description}}</td>
			    				<td>{{$b->amount}}</td>
								<td>{{$b->Remarks}}</td>
								<td>
								<button type="button" class="btn btn-primary fa fa-edit" onclick="editfunc('{{$b->amount}}', '{{$b->earningDeductionID}}', '{{$b->E_id}}','{{$b->Remarks}}','{{$b->courtID}}','{{$b->divisionID}}','{{$b->fileNo}}')" class="" id="" > Edit</button>
				<button type="button" class="btn btn-warning fa fa-times" onclick="delfunc('{{$b->E_id}}','{{$b->courtID}}','{{$b->divisionID}}','{{$b->fileNo}}')"> Delete</button>
								</td>	
							</tr>
						@endforeach
						
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

background-color: #006600;

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
	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}
	
	function  ReloadFormcourtdivision()
	{	
	document.getElementById('staffName').value='';
	document.getElementById('thisform1').submit();
	return;
	}
	
	
	function editfunc(a,b,c,d,e,f,g)
	{
	$(document).ready(function(){
	$('#amount').val(a);
	$('#earningDeduction').val(b);
	$('#earningDeductionID').val(c);
	$('#remark').val(d);
	$('#court').val(e);
	$('#division').val(f);
	$('#staffName').val(g);
	$("#editModal").modal('show');
	});
	}
	
	function delfunc(a,b,c,d)
	{
	$(document).ready(function(){
	$('#delID').val(a);
	$('#courty').val(b);
	$('#divisiony').val(c);
	$('#staffNamey').val(d);
	$("#delModal").modal('show');
	});
	}
	
  	
  </script>
@endsection
