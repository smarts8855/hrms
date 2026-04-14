@extends('layouts.layout')
@section('pageTitle')
Bank Setup
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
	            		
	            		
	            		
	            <div class="col-md-4">          
                <label class="control-label">Staff name</label>
                <select name="staffid" id="staffid" class="select_picker form-control" data-live-search="true" required onchange="ReloadForm()" >
                  <option value="">-Select-</option>
                  @php 
                  	if(old('staffid') != "")$staffid = old('staffid');
                  	if(old('accountno') != "")$accountno = old('accountno');
                  @endphp
                  @foreach($StaffInformation as $list)
                  <option  value="{{ $list->staffID }}" @if($staffid == $list->staffID) {{('selected')}} @endif>{{ $list->full_name }}({{$list->fileNo}}) </option>
                  @endforeach
                  </select>
          
            </div>
            <div class="col-md-4">          
                    <label class="control-label">Bank</label>
                    <select required class="form-control" id="bank"  name="bank" required>
                    <option value=""  >-select Account Type</option>
                    @foreach($banklist as $list)
                    <option value="{{$list->bankID}}" {{ ($bank == $list->bankID || $list->bankID == old('bank')) ? "selected":""}} >{{$list->bank}}</option>
                    @endforeach         
                    </select>
                </div>
                <div class="col-md-4">
	            		<label>Account Number</label>
					        <input type="text"  name="accountno"  class="form-control"  value="{{$accountno}}" placeholder="Input account number">
	            		</div>
				<div class="col-md-2">
				<br>
					<button type="submit" class="btn btn-success" name="update">
						<i class="fa fa-btn fa-floppy-o"></i> update
					</button>						
				</div>
			</div>
		<input id ="delcode" type="hidden"  name="delcode" >
		</div>
	</form>
	
	<div class="table-responsive" style="font-size: 12px; padding:10px;">
			<table class="table table-bordered table-striped table-highlight" >
			<thead>
			<tr bgcolor="#c7c7c7">
			                <th width="1%">S/N</th>	 
			                <th >Staff/Beneficiary names </th>
			                <th >Bank </th>
			                 <th >Account No </th>
					<!--<th >Action</th>-->
				 		</tr>
			</thead>
						@php $serialNum = 1; @endphp
			
						@foreach ($StaffInformation as $b)
							<tr>
							<td>{{ $serialNum ++}} </td>
			    				<td>{{$b->full_name}}({{$b->fileNo}})</td>
			    				<td>{{$b->bank}}</td>
			    				<td>{{$b->account_no}}</td>
								<!--<td><a href="javascript: DeletePromo('{{$b->bankID}}')">Delete</a></td>	-->
							</tr>
						@endforeach
						
			 </table>
		</div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  
  $('.select_picker').selectpicker({
  style: 'btn-default',
  size: 4
});
	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}
	
  	
  </script>
@endsection
