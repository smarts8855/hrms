@extends('layouts.layout')
@section('pageTitle')
Salary Revalidation
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
        <div class="col-md-12">
        
          <div class="form-group">
            <label for=""></label>
            
            <div align="right">
              <input class="btn btn-success" name="Compute" type="submit" value="Revalidate Salary Chart"/>
              
            </div>
            
          </div>
          
        </div>
     
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
	
  	
  </script>
@endsection
