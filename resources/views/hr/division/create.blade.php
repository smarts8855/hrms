@extends('layouts.layout')

@section('pageTitle')
Set Active Month
@endsection


@section('content')
<form method="post" action="{{ url('/division/store') }}">
  {{ csrf_field() }}
  <div class="box box-default">
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
          <strong>Success!</strong> {{ session('message') }}</div>                        
          @endif
        </div>
        <!-- 1st column -->
        <div class="col-md-12">
         <div class="form-group">
          <label for="section" >Add New Division</label>
          <input id="" type="text" class="form-control" name="division" required placeholder="Enter Division Name">
        </div>
        <div class="form-group">
          <div class="">
            <button type="submit" class="btn btn-success btn-sm pull-right">Add Division</button>
          </div>
        </div>                      
        <!-- /.col -->
      </div>
      <!-- /.col -->
    </div>
    <div class="row" style="margin: 0 10px;">
      <div class="col-md-12">
      </br>
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">ALL DIVISIONS</h3>
        </div>
        <div class="panel-body">
         <table class="table table-striped table-responsive table-condensed">
          <thead>
            <tr>
              <th>Division Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($division as $divi)
              <tr>
                <td>{{$divi -> division}}</td>
                <th>
                  <div align="right">
                    <a href="{{url('/division/destroy/'.($divi->divisionID))}}" title="Remove" class="btn btn-danger deleteBankList" id="delete{{$divi->divisionID}}"> <i class="fa fa-trash"></i> </a>
                  </div>
                </th>
              </tr>              
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.row -->
</div>

</form>

@endsection