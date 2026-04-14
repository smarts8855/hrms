@extends('layouts.layout')
@section('pageTitle')
Account Type
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
	            		<label>Leger Category</label>
				<select name="category" id="category" class="form-control" required onchange="ReloadForm();">
		                <option value="" selected>-Select Ledger Category-</option>
		                	@foreach ($LedgerCategory as $b)
						<option value="{{$b->id}}" {{ ($category == $b->id)? "selected":"" }}>{{$b->category}}</option>
		                	@endforeach 
		                </select>
	            		</div>
						
	            		<div class="col-md-4">
	            		<label>Ledger Type</label>
					<input type="text"  name="type"  class="form-control"  value="{{$type}}" placeholder="Enter New">
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
			                <th >Ledger Type</th>
			                <th >Ledger Category</th>
					<th >Action</th>
				 		</tr>
			</thead>
						@php $serialNum = 1; @endphp
			
						@foreach ($LedgerType as $b)
							<tr>
							<td>{{ $serialNum ++}} </td>
			    				<td>{{$b->accounttype}}</td>
			    				<td>{{$b->Category}}</td>
								<td><a href="javascript: Delete('{{$b->id}}')">Delete</a></td>	
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
	function  ReloadForm()
	{	
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
  	
  </script>
@endsection
