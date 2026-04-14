@extends('layouts.layout')
@section('pageTitle')
Add New Module
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
        <form method="post" action="{{ url('/module/add') }}" class="form-horizontal">
          {{ csrf_field() }} 
          
          <!--<div class="form-group">
                        <label for="section" class="col-md-3 control-label">Select Role</label>
                        <div class="col-md-9">
                          <select name="role" class="form-control" id="role">
                          <option value="">Select One</option>
                          @foreach($roles as $list)
                         
                            <option value=""></option>
                           
                            @endforeach
                          </select>
                        </div>
                      </div>-->
          
          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Module Name</label>
            <div class="col-md-9">
              <input id="moduleName" type="text" class="form-control" name="moduleName" value="{{ old('moduleName') }}" required>
            </div>
          </div>

          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Rank</label>
            <div class="col-md-9">
              <input id="rank" type="number" class="form-control" name="rank" value="{{ old('rank') }}" required>
            </div>
          </div>

          <div class="form-group">
            <label for="section" class="col-md-3 control-label">Module For</label>
            <div class="col-md-9">
              <select name="link_type" id="" class="form-control form-select" required>
                <option value="">Select...</option>
                <option value="HR">HR</option>
                <option value="FINANCE">FINANCE</option>
                <option value="PAYROLL">PAYROLL</option>
                <option value="PROCUREMENT">PROCUREMENT</option>
                <option value="STORE">STORE INVENTORY</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-success btn-sm pull-right">Add Module</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="page-wrapper" class="box box-default">
<div class="box-body">
  <h2 class="text-center">ALL MODULES</h2>
  <div class="row"> {{ csrf_field() }}
    <div class="col-md-12">
      <table class="table table-striped table-condensed table-bordered input-sm">
        <thead>
          <tr class="input-sm">
            <th>S/N</th>
            <th>MODULE NAME</th>
            <th>MODULE FOR</th>
            <th>RANK</th>
            {{-- <th>DATE CREATED</th> --}}
            <th></th>
          </tr>
        </thead>
        <tbody>
        
        @php $key = 1; @endphp
        @foreach($modules as $list)
        <tr>
          <td>{{($modules->currentpage()-1) * $modules->perpage() + $key ++}}</td>
          <td>{{strtoupper($list->modulename)}}</td>
          <td>{{strtoupper($list->link_type)}}</td>
          <td>{{strtoupper($list->module_rank)}}</td>
          {{-- <td>{{$list->created_at}}</td> --}}
          <td><a href="#" title="Edit" id="{{$list->moduleID}}" class="btn btn-success fa fa-edit edit"></a></td>
        </tr>
        @endforeach
        </tbody> 
      </table>
       <hr />
      <div align="right">
          Showing {{($modules->currentpage()-1)*$modules->perpage()+1}}
                  to {{$modules->currentpage()*$modules->perpage()}}
                  of  {{$modules->total()}} entries
      </div>
      <div class="hidden-print">{{ $modules->links() }}</div>
    </div>
  </div>
  <!-- /.col --> 
  
</div>


<!-- modal bootstrap -->
<form action="{{url('/module/update')}}" method="post">
{{ csrf_field() }} 
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Module</h4>
            </div>
            <div class="modal-body">
           
                    <div class="row" style="margin-bottom: 10px;">
                     <div class="form-group">
                        <label for="section" class="col-md-3 control-label">Module Name</label>
                        <div class="col-md-9">
                          <input id="module" type="text" class="form-control" name="name" required>
                          <input id="id" type="hidden" class="form-control" name="moduleID" required>
                        </div>
                      </div>
                    </div>
                      
                    <div class="row" style="margin-bottom: 10px;">
                     <div class="form-group">
                       <label for="section" class="col-md-3 control-label">Rank</label>
                        <div class="col-md-9">
                          <input id="ranks" type="number" class="form-control" name="rank" value="" required>
                          
                        </div>
                      </div>
                    </div>
                    
                    <div class="row" style="margin-bottom: 10px;">
                    <div class="form-group">
                      <label for="section" class="col-md-3 control-label">Module For</label>
                      <div class="col-md-9">
                        <select name="link_type" id="link_type" class="form-control form-select" required>
                          <option value="">Select...</option>
                          <option value="HR">HR</option>
                          <option value="FINANCE">FINANCE</option>
                          <option value="PAYROLL">PAYROLL</option>
                          <option value="PROCUREMENT">PROCUREMENT</option>
                        </select>
                      </div>
                    </div>
                    </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--// modal Bootstrap -->
</form>

@endsection 

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
@stop

@section('scripts')

<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>


<script type="text/javascript">
$(document).ready(function(){
 $('table tr td .edit').click(function(){
  var id = $(this).attr('id');
//alert(id);
$.ajax({
  url: murl +'/module/modify',
  type: "post",
  data: {'id': id, '_token': $('input[name=_token]').val()},
  success: function(data){
console.log(data.modulename);
   $('#module').val(data.modulename);
   $('#id').val(data.moduleID);
   $('#ranks').val(data.module_rank);
   $('#link_type').val(data.link_type);
  }
});

});
});
</script>

<script>

  $(document).ready(function(){
$('table tr td .edit').click(function()
{

$("#myModal").modal('show');
})

  });
</script>

@stop
