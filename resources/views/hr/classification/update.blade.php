@extends('layouts.layout')
@section('pageTitle')
  Add/Update Classification Code <a href="{{url('/classcode/create')}}" title="Add New"><div align="right">Add New</div></a>	
@endsection

@section('content')
  <form method="post" action="{{ url('/storeupdate') }}">
  <div class="box-body">

  	<div class="col-md-12 text-success"><!--2nd col-->
            <big><b>@yield('pageTitle')</b></big>
        </div>
        <br />
        <hr >


        <div class="row" style="margin: 5px 10px;">
            <div class="col-md-12"><!---1st col-->
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
            
				<div class="col-md-12"><!---2nd col-->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="staffname">Select Record To Edit</label>
								<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" class="form-control">
									<option selected>Select</option>
									@foreach($classname as $classname)
										<option value="{{url('loadupdate/'.($classname->codeID))}}">{{$classname->name}}</option>
									@endforeach
								</select>	  
							</div>
						</div>
						@foreach($editvalue as $editvalue)
						@endforeach
						<input type="hidden" name="codeid" value="{{$editvalue -> codeID}}">
						<div class="col-md-6">
							<div class="form-group">
								<label for="banknameID">Name</label>
								<input type="Text" name="name" placeholder="Enter Name" id="" value="{{$editvalue -> name}}" class="form-control">
							</div>
						</div>
					</div>
								
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="bankcode">Subhead</label>
								<input type="Text" name="subhead" placeholder="Enter Subhead" id="" value="{{$editvalue -> subhead}}" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="sortcode">Classification Code</label>
								<input type="Text" name="classification" placeholder="Enter Classification Code" id="" value="{{$editvalue -> classcode}}" class="form-control">
							</div>
						</div>
					</div>			
					<div align="right" class="form-group">
						<button name="action" class="btn btn-success" type="submit"> Update</button>
					</div>
				</div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
@endsection