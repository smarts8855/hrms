@extends('layouts.layout')

@section('pageTitle')
  Add/Update Classification Code
@endsection

@section('content')
  <form method="post" action="{{ url('/classcode/store') }}">
  <div class="box box-default">

  	 	<div class="col-md-12 text-success"><!--2nd col-->
            <big><b>@yield('pageTitle')</b></big>
        </div>
        <br />
        <hr >

        <div class="row" style="margin: 5px 10px;">
            <div class="col-md-12"><!--1st col-->
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
                       
				@if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> 
						{{ session('msg') }}
				    </div>                        
                @endif

            </div>
			{{ csrf_field() }}
            
				<input type="hidden" name="codeID" id="codeID">

				<div class="col-md-12"><!--2nd col-->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="staffname">Select Record To Edit</label>
								<select name="findRecord" id="findRecord" class="form-control">
									<option selected>Select</option>
									@foreach($classname as $classname)
										<option value="{{$classname->codeID}}">{{$classname->addressName}}</option>
									@endforeach
								</select>	  
							</div>
						</div>
									
						<div class="col-md-6">
							<div class="form-group">
								<label for="banknameID">Name</label>
								<input type="Text" name="name" placeholder="Enter Name" id="name" class="form-control">
							</div>
						</div>
					</div>
								
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="bankcode">Subhead</label>
								<input type="Text" name="subhead" placeholder="Enter Subhead" id="subhead" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="sortcode">Classification Code</label>
								<input type="Text" name="classification" placeholder="Enter Classification Code" id="classification" class="form-control">
							</div>
						</div>
					</div>			
					<div align="right" class="form-group">
						<button name="action" id="action" class="btn btn-success" type="submit">Add New</button>
					</div>
				</div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  	(function () {
	  $('#findRecord').change( function(){
		$.ajax({
			url: murl +'/classcode/findData',
			type: "post",
			data: {'findRecord': $('#findRecord').val(), '_token': $('input[name=_token]').val()},
			success: function(data){
					$('#name').val(data.addressName);
					$('#subhead').val(data.subhead);
					$('#classification').val(data.classcode);
					//$('#findRecord').val(data.codeID);
			}
		})	
	});}) ();

</script>
@endsection