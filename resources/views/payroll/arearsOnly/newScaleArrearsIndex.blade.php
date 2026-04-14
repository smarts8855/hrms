@extends('layouts.layout')
@section('pageTitle')
Compute New Scale Arrears
@endsection

@section('content')
<form method="post" action="{{ url('/newscale/arrears') }}">

  <div class="box-body">
    <div class="row">
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
        @if(session('err'))
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> 
          {{ session('err') }}
        </div>                        
        @endif

      </div>
      {{ csrf_field() }}

      <div class="col-md-4 col-md-offset-4"><!--2nd col-->
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="month">Month</label>
              <input type="Text" name="month" class="form-control" value="{{ session('activeMonth') }}" readonly>
            </div>
          </div><div class="col-md-4">
          <div class="form-group">
            <label for="year">Year</label>
            <input type="Text" name="year" class="form-control" value="{{ session('activeYear') }}" readonly>
          </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
              <label for="month">Number of months</label>
              <input type="Text" name="totalMonths" class="form-control" >
            </div>
          </div>

      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for=""></label>
            <div align="right">
              <input class="btn btn-success" name="btn" type="submit" value="Compute"/>
              <!--<input class="btn btn-success" name="btn" type="submit" value="Re-Compute" />-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->
</form>
@endsection
