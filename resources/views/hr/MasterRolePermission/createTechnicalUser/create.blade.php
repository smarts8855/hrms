@extends('layouts.layout')
@section('pageTitle')
  Create Technical User
@endsection

@section('content')
  <form method="post" action="{{ url('/technical/create') }}">
    {{ csrf_field() }}
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
            
            <div class="col-md-12"><!--2nd col-->
                  <div class="row">
                      <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userName">Full name</label>
                                           <input type="Text" name="fullName" class="form-control" value="{{old('fullName')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="userName">User Name</label>
                                          <input type="Text" name="userName" class="form-control" value="{{old('userName')}}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="password">Password</label>
                                          <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="password_confirmation">Confirm Password</label>
                                          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-6">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <div align="right">
                                                <button class="btn btn-success" type="submit"> Create User</button>
                                            </div>
                                    </div>
                            </div>
                      </div>
                </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
@endsection
