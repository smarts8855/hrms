@extends('layouts.layout')
@section('pageTitle')
Assign Permissions To  Roles
@endsection
@section('content')
  <div id="page-wrapper" class="box box-default">
            <div class="container-fluid">

              <div class="col-md-12 text-success"><!--2nd col-->
                <big><b>@yield('pageTitle')</b></big>
            </div>
            <br />
            <hr >
            
                <div class="row">
                    <div class="col-md-9">
                   <br>
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
                        
                        @if(session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('message') }}</div>                        
                        @endif

                          @if(session('error_message'))
                        <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> {{ session('error_message') }}</div>                        
                        @endif

            <form method="post" action="{{ url('/permission/permRole') }}" class="form-horizontal">
            {{ csrf_field() }}
             <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Role</label>
                        <div class="col-md-9">
                          <select name="role" id="section" class="form-control input-sm">
                            <option value="">Select a Role </option>

                         @foreach($role_name as $role_name)
                                  <option value="{{$role_name->id}}">{{$role_name->name}}</option>
                                @endforeach
                          </select>
                        </div>


                      </div>
                        <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Permission </label>
                        <div class="col-md-9">
                          <select name="permission" id="section" class="form-control input-sm">
                            <option value="">Select a Permission </option>
                             @foreach($perm_name as $perm_name)

                               <option value="{{$perm_name->id}}">{{$perm_name->name}}</option>
                                @endforeach
                          </select>
                        </div>
                      </div>



                      
                     
                     


                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                          <button type="submit" class="btn btn-success btn-sm pull-right">Assign Role</button>
                        </div>
                      </div>                      
                        


                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
@endsection
        