@extends('layouts.layout')

@section('pageTitle')
  	PERSONAL EMOLUMENT RECORDS
@endsection

@section('content')
 <div class="box box-default" style="border: none;">
    <div class="box-body box-profile" style="margin:0 5px;">
    <form class="form-horizontal" id="account-info" method="post" action="{{url('/account-info/add')}}">
    {{ csrf_field() }}
    	
        	<div class="col-md-12 hidden-print">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Error!</strong> 
                  @foreach ($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
                  </div>
                  @endif                       
                        
                  @if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('msg') }}</div>                        
                  @endif
                  @if(session('err'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Operation Error !<br></strong> {{ session('err') }}</div>                        
                  @endif
        	</div>

		<p>
			<h2 class="text-success text-center">
				<strong>STAFF ACCOUNT INFORMATION</strong>
			</h2>
		</p>

		

		<div class="row">
			<div class="col-sm-12">
				
				<div style="margin: 0px  5%;">
					<div class="form-group" style="margin-bottom: 5%;">
					    
					    <div class="col-sm-12 row">
					    	<div class="col-sm-4">
					    		<label class="control-label">Court</label>
					    		<select class="form-control" name="court" id="court">
					    			<option value="">Select</option>
					    			@foreach($court as $courts)
					    			@if($courts->id == session('selected_court'))

					    			<option value="{{$courts->id}}" selected="selected">
					    			 	{{$courts->court_name}}
					    			 </option>

					    			@else
					    			 <option value="{{$courts->id}}">
					    			 	{{$courts->court_name}}
					    			 </option>
					    			 @endif
					    			@endforeach
					    		</select>
					    	</div>
					    	<div class="col-sm-4">
					    		<label class="control-label">Division</label>
					    		<select class="form-control" name="division" id="divisions">
					    			<option value=""> Select </option>
					    			@if($division !='')
					    			@foreach($division as $div)
                                    @if($div->divisionID == session('selected_division'))
					    			<option value="{{$div->divisionID}}" selected="selected">{{$div->division}}</option>
					    			@else
					    			<option value="{{$div->divisionID}}">{{$div->division}}</option>
					    			@endif
					    			@endforeach
					    			@endif
					    		</select>
					    	</div>
					    	<div class="col-sm-4">
					    		<label class="control-label">Staff Name</label>
					    		<input type="text" name="name" id="autocomplete"  value="{{old('name')}}" class="form-control" placeholder="">
					    	</div>
					    </div>
					    <!--//for update-->
					    <div class="col-sm-4">
					    	<input type="hidden" name="fileNo" id="fileNo" value="{{old('fileNo')}}">
					    </div>
					</div>

					<div class="form-group">
					    <label class="control-label col-sm-2" for="accountNo">Account Number (10 Digits):</label>
					    <div class="col-sm-10">
					    	<input type="number" name="accountNo" id="accountNo" value="{{old('accountNo')}}" class="form-control" required>
					    </div>
					</div>
					
					<div class="form-group">
					    <label class="control-label col-sm-2" for="grade">Bank</label>
					    <div class="col-sm-10">
					    	<select name="bank" class="form-control">
					    		<option value="">Select</option>
					    		@foreach($bankList as $banks)
					    		<option value="{{$banks->bankID}}">{{$banks->bank}}</option>
					    		@endforeach
					    	</select>
					    </div>
					</div>
					
					<div class="form-group">
					    <label class="control-label col-sm-2" for="branch"> Branch Address:</label>
					     <div class="col-sm-10">
					    	<input type="text" name="branch" id="branch" value="{{old('branch')}}" class="form-control">
					    </div>
					</div>
					
					<div class="form-group">
					    <label class="control-label col-sm-2" for="section">Bank Group</label>
					    <div class="col-sm-10">
					    	<select name="bankGroup" id="section" class="form-control" required>
					    		<option value="">Select a Group</option>
					    		
					    		@for($i=1; $i<=20; $i++)

					    		<option>{{$i}}</option>

					    		@endfor
					    	</select>
					    </div>
					</div>
					

		<div align="center" class="hidden-print"><hr />
			<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i>
			Save/Update</button>
		</div>
	</form>
</div>
</div>
@stop

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<style type="text/css">
	.autocomplete-suggestions{

	background-color:#eee!IMPORTANT;
	border: 1px solid #c3c3c3 !important;
	padding: 1px 5px !important;
	cursor: Pointer !important;
	overflow: scroll;

}
</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.js') }}" ></script>
  <script type="text/javascript">
  	
  	(function () {
	$('#court').change( function(){
		var court    = $(this).val();
		var check    = 'court';
    $('#processing').text('Processing. Please wait...');


		$.ajax({
			url: murl +'/account-info/court',
			type: "post",
			data: {'courtID': court,'check':check, '_token': $('input[name=_token]').val()},
			success: function(data){
				location.reload(true);
							}
		})	
	});}) ();









  </script>

  <script type="text/javascript">
  	$(document).ready(function()
{
	$('#divisions').change( function(){
		var division = $(this).val();
		var check     = 'division';
   

		$.ajax({
			url: murl +'/account-info/court',
			type: "post",
			data: {'divisionID': division,'check':check, '_token': $('input[name=_token]').val()},
			success: function(data){
				location.reload(true);
				//console.log(data);
							}
		});	
	});}) ;

  </script>

  <script type="text/javascript">
  $(function() {
      
      $("#autocomplete").autocomplete({
        serviceUrl: murl + '/account-info/get-staff',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            showAll();
        }
      });
  });
</script>

  
@stop