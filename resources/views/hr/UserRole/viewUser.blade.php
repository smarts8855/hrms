@extends('layouts.layout')
@section('pageTitle')
View All users
@endsection
@section('content')
<div class="box box-default">

  <div class="col-md-12 text-success"><!--2nd col-->
      <big><b>@yield('pageTitle')</b></big>
  </div>
  <br />
  <hr >

  <div class="row" style="margin: 5px 10px;">
  <div class="col-md-12">
      
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
          <strong>Success!</strong> {{ session('message') }}
        </div>                        
        @endif
        @if(session('error_message'))
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Error!</strong> {{ session('error_message') }}
          </div>                        
        @endif


          <table class="table table-bordered table-hover">
            <tr>
              <th>Name</th>
              <th>User name</th>
              <th>Assigned Role</th>
              <th>Role Description</th>
              <th>Division</th>
              <th></th>
            </tr>
            @foreach ($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->username }}</td>
              <td>{{ $user->roleName }}</td>
              <td>{{ $user->description }}</td>
              <td>{{ $user->division }}</td>
              @if($user->roleid!=null)
              <td> <a href = "{{ url('/role/'.$user->roleid.'/user/'.$user->id) }}"> Remove Role </td>
              @else
              <td></td>
              @endif
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  @endsection