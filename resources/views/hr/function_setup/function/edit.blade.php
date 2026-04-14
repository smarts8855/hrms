@extends('layouts.layout')

@section('pageTitle')

Edit Function 

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

            <form method="post" action="{{ url('/function/update') }}" class="form-horizontal">

            {{ csrf_field() }}

                      <div class="form-group">

                        <label for="section" class="col-md-3 control-label">Function Name</label>
                        <div class="col-md-9">
                          <input id="name" type="text" class="form-control" name="name" value="{{ $edit->function_name }}" required>
                          <input id="name" type="hidden" class="form-control" name="functionID" value="{{ $edit->functionID }}" required>
                        </div>

                      </div> 


                       <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Function Rank</label>
                        <div class="col-md-9">
                          <input id="name" type="text" class="form-control" name="rank" value="{{ $edit->function_rank }}" required>
                        </div>
                      </div> 

                      

                      <div class="row">

                        <div class="col-sm-6"></div>

                        <div class="col-sm-3">

                         <div class="form-group">

                            <div class="col-sm-9 pull-right">

                              <button type="submit" class="btn btn-success btn-sm">Edit Function</button>

                            </div>

                          </div>

                        </div>



                          <div class="col-sm-3"> 

                          <div class="form-group">

                            <div class="col-sm-offset-3 col-sm-9">

                              <a href="{{url('module/create')}}" class="btn btn-default btn-sm pull-right">Cancel</a>

                            </div>

                          </div>

                          </div>                      

                     </div>



                       </form>

                    </div>

                    

                </div>

            </div>

        </div>

@endsection

        