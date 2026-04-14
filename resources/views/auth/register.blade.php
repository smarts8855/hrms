@extends('layouts.layout')
@section('pageTitle')
  Register New User
@endsection

@section('content')
  <form method="post" action="{{ url('/user/store') }}">
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
                                    <label for="userName">Email Address</label>
                                           <input type="Text" value="{{old('email_address')}}" name="email_address" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="userName">User Name</label>
                                          <input type="Text" value="{{old('userName')}}"  id="user_name" name="userName" class="form-control">
                                        </div>
                                    </div>
                                </div>
                  <div class="row">
                      <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                           <input type="Text" id="first_name" value="{{old('first_name')}}" name="first_name" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="last_name">Last Name</label>
                                          <input type="Text" value="{{old('last_name')}}" name="last_name" id="last_name" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                
                                
                                
                                
                                <div class="row">
        
                                  <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="role">Role</label>
                                          <select name="role_id" class="form-control">
                                          <option>Select a role</option>
                                            @foreach($roles as $role)
                                            <option value="{{$role->roleID}}">{{$role->rolename}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="division">Division</label>
                                        <select name="division" class="form-control">
                                        <option>Select Division</option>
                                          @foreach($divisions as $division)
                                          <option value="{{$division->divisionID}}">{{$division->division}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="global">Is Global User</label>
                                        <select name="isGlobal" class="form-control">
                                        {{-- <option>Select</option> --}}
                                          <option value="0">No</option>
                                          <option value="1">Yes</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="password">Password</label>
                                          <input type="password" name="password" class="form-control" value="" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="password">Confirm Password</label>
                                          <input type="password" name="cpassword" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-md-offset-6">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <div align="right">
                                                <button class="btn btn-success" type="submit"> Create User Account </button>
                                            </div>
                                    </div>
                            </div>
                      </div>
                </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
@endsection


@section('scripts')
<script>


$("#last_name , #first_name").bind('input', ()=>{
    
    var first_name = $("#first_name").val();
    var last_name = $("#last_name") .val();
    if( first_name !== " " && last_name !== " " ){
          //set the username field 
        //$("#user_name").val( first_name+'_'+last_name );
    }

  
})



</script>
@endsection
