@extends('layouts.layout')
@section('pageTitle', 'Treasure Cash Book')
@section('content')


    <div class="box box-default">
        
        <div class="box-header with-border hidden-print">
          <h3 class="box-title"><b> @yield('pageTitle') </b>
          </h3>
        </div>
        
        <div class="">
          <div class="col-md-12 mt-2 mb-2 h4">
              @if (count($errors) > 0)
              <div class="text-left alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                @foreach ($errors->all() as $error)
                  {{ $error }}<br />
                @endforeach
              </div>
              @endif
    
              @if(session('message'))
              <div class="alert alert-success alert-dismissible" role="alert" style="background:#98FB98;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 {!! session('message') !!}
              </div>
              @endif
    
              @if(session('info'))
              <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 {!! session('info') !!}
              </div>
              @endif
    
              @if(session('error'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 {!! session('error') !!}
              </div>
              @endif
    
              @if(session('warning'))
              <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 {!! session('warning') !!}
              </div>
              @endif
          </div>
        </div>

    	<form method="post"  action="{{ (Route::has('processCashbook') ? Route('processCashbook') : '#') }}">
    	{{ csrf_field() }}
    		<div class="box-body">
    			 <div class="row">
    			 	 <div class="col-md-12 offset-md-3">
    			 
    	            	<div class="col-md-4">
    	            	    <label>Select Year <span class="text-danger"><b>*</b></span></label>
    	            	    <select name="accountYear" required class="form-control">
    	            	        <option value="">Select</option>
    	            	            @for($startYear = date('Y'); $startYear > 1994; $startYear --)
    	            	                <option>{{ $startYear }}</option>
    	            	            @endfor
    	            	    </select>
    	            	</div>
    	            	
    	            	<div class="col-md-4">
    	            	    <label>Select Account Type <span class="text-danger"><b>*</b></span></label>
    	            	    <select name="accountType" required class="form-control">
    	            	        <option value="">Select</option>
    	            	        @if(isset($getContractType) && $getContractType)
    	            	            @foreach($getContractType as $type)
    	            	                <option value="{{$type->ID}}">{{ $type->contractType }}</option>
    	            	            @endforeach
    	            	        @endif
    	            	    </select>
    	            	</div>
    	            	
    	            	<div class="col-md-4">
    	            	    <br />
    	            	    <button type="submit" class="btn btn-success" style="margin-top:6px;">View Report</button>
    	            	</div>
    	            </div>	
    			</div>
    		
            	<div class="clear-fix"></div>
            </div>
    	</form>

			
    	<div class="box-footer with-border hidden-print">
        
        </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
      
    </style>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
  	  
    </script>
@endsection
