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
	<form method="post"  id="thisform1" name="thisform1" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="box-body">
			 <div class="row">
			 
	            		<div class="col-md-3">
	            		<label>Short Code</label>
					<input type="text"  name="shortcode"  class="form-control"  value="{{$shortcode}}" placeholder="short code">
	            		</div>
	            		
	            		<div class="col-md-9">
	            		<label>Organisation Name</label>
					<input type="text"  name="organisationname"  class="form-control"  value="{{$organisationname}}" placeholder="Organisation full name">
	            		</div>
	            		 
				
	            		
			</div>
			<div class="row">
			 
	            		<div class="col-md-3">
	            		<label>Phone Number</label>
					<input type="text"  name="phoneno"  class="form-control"  value="{{$phoneno}}" placeholder="Phone Number">
	            		</div>
	            		
	            		<div class="col-md-9">
	            		<label>Email Address</label>
					<input type="text"  name="email"  class="form-control"  value="{{$email}}" placeholder="Organisation email">
	            		</div>
	            		 
				
	            		
			</div>
			<div class="row">
			 
	            		<div class="col-md-12">
	            		<label>Organisation Address</label>
				<textarea class="form-control" name="address" rows="3" placeholder="Contact address of the company">{{$address}}</textarea>
	            		</div>
	            		
	            		
	            		
			</div>
			<div class="row">
			 
	            		<div class="col-md-12">
	            		<label  > Company Logo</label>
				 <img  src="{{$imgpath}}" width="100%" height="100%" />
	            		</div>
	            		</div>
	            		<div class="row">
	            		<div class="col-md-9">
	            		<input type="file" name="logo"/>
				<input type="submit" value="Upload" name="Upload" style="width:50px;height:15px;font-size:12px;margin:1px;padding: 1px;background:none;">
	            		</div>
	            		 
				<div class="col-md-2">
				<br>
					<button type="submit" class="btn btn-success" name="update">
						<i class="fa fa-btn fa-floppy-o"></i> Update
					</button>						
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
  	
  </script>
@endsection
