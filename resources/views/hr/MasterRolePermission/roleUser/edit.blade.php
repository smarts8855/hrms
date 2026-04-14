@extends('layouts.layout')
@section('pageTitle')
Update/Edit  Role
@endsection

@section('content')
<div id="page-wrapper" class="box box-default">
  <div class="container-fluid">
    <div class="col-md-12 text-success"><!--2nd col--> 
      <big><b>@yield('pageTitle')</b></big> </div>
    <br />
    <hr >
    <div class="row">
      <div class="col-md-12"> <br>
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach </div>
        @endif                       
        
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Success!</strong> {{ session('message') }}</div>
        @endif
        @if(session('error_message'))
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> {{ session('error_message') }}</div>
        @endif
        <form method="post" action="{{ url('/user-role/update') }}" class="form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Role Name</label>
            <div class="col-md-9">
              <input id="roleName" type="text" class="form-control" name="roleName" value="{{ $edit->rolename }}" required>
              <input id="roleID" type="hidden" class="form-control" name="roleID" value="{{ $edit->roleID }}" required>
            </div>
          </div>
          <div class="row">
              <div class="form-group">
                <div align="right" class="col-sm-6">
                  <button type="submit" class="btn btn-success btn-sm">Edit Role</button>
                </div>
                <div align="left" class="col-sm-6">
                  <a href="{{route('CreateUserRole')}}" type="submit" class="btn btn-default btn-sm">Cancel</a>
                </div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 