@extends('layouts.layout')
@section('pageTitle')
	Password reset
@endsection
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
                            <label for="username" class="col-md-2 control-label">Staff Id/email</label>

                            <div class="col-md-6">
				<input type="text" list="username" name="username"  class="form-control"  value="{{$username}}" placeholder="Select staff detail">
				<datalist id="username">
					@foreach ($staffList as $b)
					<option value="{{ $b->fileNo }}" >{{ $b->fileNo }}:{{ $b->surname }} {{ $b->first_name }}</option>
					
					@endforeach
				</datalist>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
							<div class="col-md-2">
                                <button type="submit" class="btn btn-success" name="find">
                                    <i class="fa fa-btn fa-search"></i> find
                                </button>
							</div>
								
                            
                        </div>

                        <hr>
						
                        <div class="form-group">
                          @if ($showreset)
							<div class="col-md-8">
								{{$error}}
								<input id ="userid" type="hidden"  name="userid" value="{{$userid}}">
							</div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-success" name="Reset">
                                    <i class="fa fa-btn fa-refresh"></i> Reset
                                </button>
							</div>
							@endif 
                        </div>
						
					
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
