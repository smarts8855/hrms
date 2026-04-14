@extends('layouts.layout')

@section('pageTitle')

Add Sub Function

@endsection



@section('content')

<div id="page-wrapper" class="box box-default">

  <div class="container-fluid">

    <div class="col-md-12 text-success"><!--2nd col--> 

      <big><b>@yield('pageTitle')</b></big> </div>

    <br />

    <hr >

    <div class="row">

      <div class="col-md-9"> <br>

        @if (count($errors) > 0)

        <div class="alert alert-danger alert-dismissible" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>

          <strong>Error!</strong> @foreach ($errors->all() as $error)

          <p>{{ $error }}</p>

          @endforeach </div>

        @endif                       

        

        @if(session('message'))

        <div class="alert alert-success alert-dismissible" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>

          <strong>Success!</strong> {{ session('message') }}</div>

        @endif

        @if(session('error_message'))

        <div class="alert alert-error alert-dismissible" role="alert">

          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>

          <strong>Error!</strong> {{ session('error_message') }}</div>

        @endif

        <form method="post" action="{{ url('/sub-function/add') }}" class="form-horizontal">

          {{ csrf_field() }}

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Select Function</label>

            <div class="col-md-9">

              <select name="function" class="form-control">

                

                @foreach($functions as $list)

                <option value="{{$list->functionID}}">{{$list->function_name}}</option>

                @endforeach

                          

              </select>

            </div>

          </div>

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">Sub Function/Display Name</label>

            <div class="col-md-9">

              <input id="name" type="text" class="form-control" name="subFunction" value="{{ old('name') }}" required>

            </div>

          </div>

          <div class="form-group">

            <label for="section" class="col-md-3 control-label">RANK</label>

            <div class="col-md-9">

              <input id="route" type="text" class="form-control" name="rank" required >

            </div>

          </div>

          <div class="form-group">

            <div class="col-sm-offset-3 col-sm-9">

              <button type="submit" class="btn btn-success btn-sm pull-right">Add</button>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<div id="page-wrapper" class="box box-default">

<div class="box-body">

  <h2 class="text-center">All Sub Function</h2>

  <div class="row"> {{ csrf_field() }}

    <div class="col-md-12">

      <table class="table table-striped table-condensed table-bordered input-sm">

        <thead>

          <tr class="input-sm">

            <th>S/N</th>

            <th>FUNCTION</th>

            <th>SUB FUNCTION</th>

            <th>DATE CREATED</th>

            <th></th>

          </tr>

        </thead>

        <tbody>

        @php $key = 1; @endphp

        @foreach($subfunctions as $list)

        <tr>

          <td>{{($subfunctions->currentpage()-1) * $subfunctions->perpage() + $key ++}}</td>

          <td>{{strtoupper($list->function_name)}}</td>

          <td>{{strtoupper($list->sub_function_name)}}</td>

          <td>{{$list->created_at}}</td>

          <td><a href="{{url('/sub-function/edit/'.$list->subfunctionID)}}" title="Edit" class="btn btn-success fa fa-edit"></a></td>

        </tr>

        @endforeach

        </tbody>

      </table>

      <hr />

      <div align="right">

          Showing {{($subfunctions->currentpage()-1)*$subfunctions->perpage()+1}}

                  to {{$subfunctions->currentpage()*$subfunctions->perpage()}}

                  of  {{$subfunctions->total()}} entries

      </div>

      <div class="hidden-print">{{ $subfunctions->links() }}</div>

    </div>

  </div>

  <!-- /.col --> 

</div>

@endsection 