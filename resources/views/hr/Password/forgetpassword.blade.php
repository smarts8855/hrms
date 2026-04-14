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

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Staff Id/email</label>

                            <div class="col-md-8">
<div class="input-group">
                                <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            
			<span class="input-group-btn">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-refresh"></i> Reset
                                </button>
                            </span>
                        </div>
<a href="login" class="text-center new-account">Login </a> </div>

        
						
                        <div class="form-group">
<div class="col-md-2">
         
</div>
<div class="col-md-6">
                           
</div>
                        </div>
						
					
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
