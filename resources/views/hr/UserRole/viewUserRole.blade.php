@extends('layouts.layout')
@section('pageTitle')
Role Details For :<strong> {{ $user_name->name}} </strong>
@endsection

@section('content')

  <div id="page-wrapper" class="box box-default">
            <div class="box-body">
             
              <div class="col-md-12 text-success"><!--2nd col-->
                  <big><b>@yield('pageTitle')</b></big>
              </div>
              <br />
              <hr >

                <div class="row">
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
                        <strong>Success!</strong> {{ session('message') }}</div>                        
                        @endif



                          @if(session('error_message'))
                        <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> {{ session('error_message') }}</div>                        
                        @endif


<table class="table table-hover">
              <tr>
                  <th>Role Name</th>
                  <th>Role Display Name</th>
                  <th>Role Description</th>
                  <th>Action</th>
                
            </tr>
        
                 @foreach ($user_role as $role)
                 
                 <tr>
                 <td>{{ $role->name }}</td>
                 <td>{{ $role->display_name }}</td>
                 <td>{{ $role->description }}</td>
                 <td> <a href = "{{ url('/role/'.$role->id.'/user/'.$user_name->id) }}"> Remove Role </td>
               </tr>
                 
                 @endforeach

             </table>


                    </div>
                    
                </div>
            </div>
        </div>
@endsection
        