@extends('layouts.layout')
@section('pageTitle')
Assign Module
@endsection
<style type="text/css">
  .check
  {
    padding: 10px;
  }

  input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1); /* IE */
  -moz-transform: scale(1); /* FF */
  -webkit-transform: scale(1); /* Safari and Chrome */
  -o-transform: scale(1); /* Opera */
  padding: 3px;
}

/* Might want to wrap a span around your checkbox text */
.checkboxtext
{
  /* Checkbox text */
  font-size: 110%;
  display: inline;
}
</style>
@section('content')
<div id="page-wrapper" class="box box-default">
<div class="container-fluid">
<div class="col-md-12 text-success"><!--2nd col--> 
  <big><b>@yield('pageTitle')</b></big> </div>
<br />
<hr >
<div class="row">
<div class="col-md-9">
<br>
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
<form method="post" action="{{ url('/assign-module/assign') }}" class="form-horizontal">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="section" class="col-md-3 control-label">Select Role</label>
    <div class="col-md-9">
      <select name="role" class="form-control" id="role">
        <option value="">Select One</option>
        
        @foreach($roles as $list)
            @if($list->roleID ==session('current_role'))
            <option value="{{$list->roleID}}" selected="selected">{{$list->rolename}}</option>
            @else
            <option value="{{$list->roleID}}">{{$list->rolename}}</option>
            @endif
        @endforeach
                          
      </select>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <div id="page-wrapper" class="box box-default">
  <div class="box-body">
  <div class="row">
    @php
        $current_module = ''; 
        $check ="";
    @endphp
    @foreach($submodules as $list)
      @if($list->moduleID != $current_module)
        <div class="col-md-9 col-md-offset-2" style="padding-left:0px; margin-top:8px;">
          <strong>Module: {{$list->modulename}}</strong>
        </div>
      @php $current_module = $list->moduleID; @endphp
      @endif
      <div class="form-group" style="margin:10px">
        <div style="clear: both;"></div>
        <div class="col-md-9 col-md-offset-2" style="margin-top: 8px">
            <input type="hidden" name="arraymodule[]" value="{{$list->moduleID}}"/>
            <input type="checkbox" name="arraysubModule[]"
              <?php 
                foreach($assignroles as $r)
                {
                  if($r->roleID == session('current_role') && $r->submoduleID == $list->submoduleID)
                  {
                    echo "checked";
                  }else
                  {
                    echo '';
                  }
                }
              ?> 
              value="{{$list->submoduleID}}" class="check">
          <span style="padding: 10px; font-weight: bold;">{{strtoupper($list->submodulename)}}</span> 
        </div>
      </div>
  @endforeach
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <button type="submit" class="btn btn-success btn-sm pull-right">ASSIGN</button>
    </div>
  </div>
</form>
</div>
</div>
</div>
@endsection

@section('scripts') 
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script> 
<!-- autocomplete js--> 
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script> 
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script> 
<script type="text/javascript">
  $(document).ready(function(){
  
$("#role").on('change',function(){
  //alert("ok");
 //var id=$(this).parent().parent().find("input:eq(0)").val();
  var id = $(this).val();
  
  //alert(id)

  $token = $("input[name='_token']").val();
 $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/role/setsession') }}",

  type: "post",
  data: {'role':id},
  success: function(data){
   // alert(data);
    //$('#message').html(data);
  location.reload(true);
  }
});

   

});
 });
</script> 
@stop 