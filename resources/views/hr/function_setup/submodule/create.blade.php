@extends('layouts.layout')
@section('pageTitle')
Add Sub Module
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
        <form method="post" action="{{ url('/sub-module/add') }}" class="form-horizontal">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Select Module</label>
            <div class="col-md-9">
              <select name="module" class="form-control">
                
                          @foreach($modules as $list)
                            
                <option value="{{$list->moduleID}}">{{$list->modulename}}</option>
                
                            @endforeach
                          
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Sub Module/Display Name</label>
            <div class="col-md-9">
              <input id="name" type="text" class="form-control" name="subModule" value="{{ old('name') }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Route (URL)</label>
            <div class="col-md-9">
              <input id="route" type="text" class="form-control" name="route" value="{{ old('route') }}" required placeholder="E.g: /create/new-staff">
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
  <h2 class="text-center">All Sub Module</h2>
  <div class="row"> {{ csrf_field() }}
    <div class="col-md-12">
      <table class="table table-striped table-condensed table-bordered input-sm">
        <thead>
          <tr class="input-sm">
            <th>S/N</th>
            <th>MODULE</th>
            <th>SUB MODULE</th>
            <th>URL (Route)</th>
            <th>DATE CREATED</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @php $key = 1; @endphp
        @foreach($submodules as $list)
        <tr>
          <td>{{($submodules->currentpage()-1) * $submodules->perpage() + $key ++}}</td>
          <td>{{strtoupper($list->modulename)}}</td>
          <td>{{strtoupper($list->submodulename)}}</td>
          <td>{{strtoupper($list->route)}}</td>
          <td>{{$list->created_at}}</td>
          <td><a href="{{url('/sub-module/edit/'.$list->submoduleID)}}" title="Edit" class="btn btn-success fa fa-edit"></a></td>
        </tr>
        @endforeach
        </tbody>
      </table>
      <hr />
      <div align="right">
          Showing {{($submodules->currentpage()-1)*$submodules->perpage()+1}}
                  to {{$submodules->currentpage()*$submodules->perpage()}}
                  of  {{$submodules->total()}} entries
      </div>
      <div class="hidden-print">{{ $submodules->links() }}</div>
    </div>
  </div>
  <!-- /.col --> 
</div>
@endsection 