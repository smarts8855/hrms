@extends('layouts.layout')
@section('pageTitle')
Add New Function
@endsection

@section('content')
<div id="page-wrapper" class="box box-default">
  <div class="container-fluid">
    <div style="background: #fcfcfc">
    <div class="col-md-12 text-success"><!--2nd col--> 
      <big><b>@yield('pageTitle')</b></big> 
    </div>
    <div class="row">
        <div class="col-md-12"> <br>
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                  <strong>Error!</strong> 
                  @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                  @endforeach 
                </div>
            @endif                       
            @if(session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                  <strong>Success!</strong> {{ session('message') }}
                </div>
            @endif
            @if(session('error_message'))
                <div class="alert alert-error alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                  <strong>Error!</strong> {{ session('error_message') }}
                </div>
            @endif
        </div>
      </div>
    </div>
    <hr />

    <div class="row">
        <form method="post" action="{{ url('/user/role/function') }}" class="form-horizontal">
          {{ csrf_field() }}
          <div class="row col-md-offset-1">

            <div class="row">
              <div class="col-md-4 col-md-offset-3">
                <div align="left"><b>Function Name</b></div> 
                <div class="form-group">
                  <input type="text" name="functionName" class="form-control" required placeholder="Function Name">
                </div>
             </div>
           </div>

          <div class="row">
            <div class="col-md-4 col-md-offset-3"> 
               <div align="left"><b>Function Description</b></div> 
                <div class="form-group">
                  <textarea name="functionDescription" class="form-control" required placeholder="Description"></textarea>
                </div>
             </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-md-offset-2">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-success pull-right"> Add New Function <i class="fa fa-save"></i></button>
                </div>
              </div>
            </div>
        </div>

        </div><!--//row-->

        </form>
    </div>
</div>

<div class="container-fluid">
<div class="box box-default">
  <h3 class="text-center">Available Function</h3>
  <div class="row"> 
    <div class="col-md-12">
      <table class="table table-striped table-condensed table-bordered">
        <thead>
          <tr class="input-sm">
            <th>S/N</th>
            <th>Function Name</th>
            <th>Function Description</th>
            <th>DATE CREATED</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @php $key = 1; @endphp
        @foreach($allFunction as $list)
          <tr>
            <td>{{($allFunction->currentpage()-1) * $allFunction->perpage() + $key ++}}</td>
            <td>{{$list->function_name}}</td>
            <td>{{$list->function_description}}</td>
            <td>{{$list->create_at}}</td>
            <td><a href="{{url('#')}}" title="Edit" class="btn btn-success fa fa-edit"></a></td>
        </tr>
        @endforeach
        </tbody>
      </table>
      <hr />
      <div align="right">
          Showing {{($allFunction->currentpage()-1)*$allFunction->perpage()+1}}
          to {{$allFunction->currentpage()*$allFunction->perpage()}}
          of  {{$allFunction->total()}} entries
      </div>
      <div class="hidden-print">{{ $allFunction->links() }}</div>
    </div>
  </div>
  </div>
</div>
@endsection 