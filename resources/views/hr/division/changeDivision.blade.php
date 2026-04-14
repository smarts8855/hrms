@extends('layouts.layout')
@section('pageTitle')
 Change Division
  
@endsection

@section('content')


  <form method="post" action="{{ url('/division/changeDivisionStore') }}">
  <div class="box box-default">
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
            


        @if(session('message'))
                  <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> 
                    {{ session('message') }}
                  </div>                        
                @endif

            </div>
      {{ csrf_field() }}
            
        <div class="col-md-12"><!--2nd col-->
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="division">Division</label>
                      <select name="division" id="division" class="form-control">
                      <option>Select Division</option>
                      @foreach($divisions as $division)
                        <option value="{{$division->divisionID}}">{{$division->division}}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div align="right">
                  <button class="btn btn-success pull-right" type="submit"> Change</button>
                </div>
                <br /> <br />
        </div>
        </div><!-- /.col -->
     </div><!-- /.row -->

  </form>
@endsection