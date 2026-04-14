@extends('layouts.loginlayout')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading">Password reset</div>
                <div class="panel-body">
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
                    <form class="form-horizontal" role="form" method="POST" autocomplete="off">
                        {{ csrf_field() }}
			@if ($invalidtoken=='')
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label  class="col-md-2 control-label">New password</label>

                            <div class="col-md-6">
				<input type="password" lname="password"  class="form-control"   placeholder="enter password">
                            </div>				 
                        </div>

			 <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label  class="col-md-2 control-label">Confirm password</label>

                            <div class="col-md-6">
				<input type="password"  name="confirmpassword"  class="form-control"   placeholder="confirm password">
				
                            </div>
			</div>
                        <hr>
						
                        <div class="form-group">
                          	
							<div class="col-md-2">
							
								
							</div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-success" name="update">
                                    <i class="fa fa-btn fa-refresh"></i>Update</button>
							</div>
				
                        </div>
			@else
			
				<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>{{$invalidtoken}}</strong> 
				</div>
				 <a href="{{ url('/login') }}" class="text-center new-account">Login </a>
					
			@endif		
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
