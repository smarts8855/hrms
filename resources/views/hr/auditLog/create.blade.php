@extends('layouts.layout')
@section('pageTitle')
Audit Log
@endsection
@section('content')
<div class="box box-default">
  <form method="post" action="{{ url('/auditLog/create') }}">
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
      <div class="col-md-12">
        <div class="form-group">
        <label for="userName">User</label>
        
        <select name="userName" id="userName" class="form-control">
          <option value=""> First Select a Division  </option>

        </select>

        </div>
      </div>
      </div>
  
      <div class="row">
      <div class="col-md-12">
        <div class="form-group">
      <label>Start Date</label>
      <input type="text" name="startDate" id="startDate" class="form-control" value="{{old('startDate')}}" />
    </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
      <label>End Date</label>
      <input type="text" name="endDate" id="endDate" class="form-control" value="{{old('endDate')}}" />
    </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
        <label for="sortcode"></label>
        <div align="right">
          <button class="btn btn-success pull-right" type="submit"> Display</button>
        </div><br /><br />
        </div>
      </div>
      </div>
    </div>
  </div><!-- /.col -->

</form>

<div class="box box-default">
<div class="row" style="margin:  0px 10px;">
    <div class="col-md-12">
    </br>

<div class="panel panel-success">
<div class="panel-heading">
<h3 class="panel-title">Search audit log by query</h3>
</div>
<div class="row">
    <div class="col-md-12">
<div class="panel-body">

<form method="post" action="{{ url('/auditLog/query') }}">
  {{ csrf_field() }}
<div>
  <div class="row">
    <div class="col-md-12"><!--1st col-->
        <div class="form-group">
            <label></label>
            <textarea required class="form-control" name="query" id="query">{{old('query')}}</textarea>
        </div>
    </div>
  </div>
  <div >
    <div class="form-group">
      <label for="sortcode"></label>
        <div align="right">
          <button class="btn btn-success pull-right" type="submit"> Display</button>
        </div>
        </div>
      </div>
   </div>
  </div>
</form>
</div><!-- /.row -->

</div>
</div>
        </div>
        
  <!-- /.row -->
  </div>


</div>


@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection


@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
(function () {
$('#division').change( function(){
$.ajax({

    url: murl +'/auditLog/finduser',
type: "post",
data: {'division': $('#division').val(), '_token': $('input[name=_token]').val()},
success: function(json){
var $el = $("#userName");
        $el.empty(); // remove old options
        $el.append($("<option></option>")
            .attr("value", '').text('Please Select a User'));
      $.each(json, function(index, value) {
          $el.append('<option value="' + value.data+'">' + value.value + '</option>');

        });                           
}
})  
});}) ();

$( function() {
$( "#startDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
$( "#endDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
} );
</script>
@endsection


