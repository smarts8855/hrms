@extends('layouts.layout')
@section('pageTitle')
 Add New Permission
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

            <form method="post" action="{{ url('/permission/create') }}" class="form-horizontal">
            {{ csrf_field() }}
                        <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Permision Name </label>
                        <div class="col-md-9">
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="category" class="col-md-3 control-label">Display Name <small>(optional)</small></label>
                        <div class="col-md-9">
                           <input id="display_name" type="text" class="form-control input-sm" name="display_name" >                      
                        </div>
                      </div> 
                      
                      <div class="form-group">
                        <label for="category" class="col-md-3 control-label">Role Description  <small>(optional)</small></label>
                        <div class="col-md-9">
                           <input id="description" type="text" class="form-control input-sm" name="description" >                      
                        </div>
                      </div> 


                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                          <button type="submit" class="btn btn-success btn-sm pull-right"> Add Permission</button>
                        </div>
                      </div>                      
                        


                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

@endsection

@section('scripts')
 
@endsection