@extends('layouts.layout')

<style type="text/css">
table, table tr th, table tr
{
  border: 1px solid #EEE;
}
</style>

@section('content')
<form method="post" action="{{url('/variation/list')}}" id="mainform" name="mainform" >

	<div class="box-body" style="background:#FFF;">
		<div class="row" style="background:#FFF;">
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

				@if(session('msg'))
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
					<strong>Success!</strong>
					{{ session('msg') }}
				</div>
				@endif
				@if(session('err'))
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
					<strong>Warning!</strong>
					{{ session('err') }}
				</div>
				@endif

			</div>
			{{ csrf_field() }}

			<div class="col-md-12">


			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->


<div class="box-body" style="background:#FFF;">

<div class="box-body">
	<h2>Staff Variation List</h2>

	<hr>
	<div align="center"><strong></strong></div>
	<br />
	<table class="table table-hover table-striped table-responsive">

		<thead>
	<tr>
	<th>SN</th>
	<th>File Number</th>
	<th>Staff Name</th>
        
        <th>Arrears Type</th>
        <th>Old Grade</th>
        <th>New Grade</th>
        <th>Old Step</th>
        <th>New Step</th>
        
        <th>Arrears Due Date</th>
        <th></th>
	</tr>
		</thead>
<?php $sn=0; ?>
		<tbody>
			@foreach ($variationList as $d)
<?php $sn+=1; ?>
			<tr>

	    <td>{{$sn}}</td>
	    <td>{{$d->fileNo}}</td>
        <td>{{$d->surname}} {{$d->first_name}} {{$d->othernames}}</td> 
        <td>{{$d->arrears_type}}</td>
        <td>@if($d->old_grade==0)NA @else {{$d->old_grade}} @endif </td>
        <td>{{$d->new_grade}}</td>
        <td>@if($d->old_step==0)NA @else {{$d->old_step}} @endif</td>
        <td>{{$d->new_step}}</td>
        <td>{{$d->due_date}}</td>
        
	<td>
		<div align="right">
			<input type="checkbox" name="confirm[]" value="{{$d->ID}}" @if($d->treated == 1) checked @endif/>
		</div>

	</td>

			</tr>

			@endforeach
		</tbody>

	</table>
<input type="submit" class="btn btn-success pull-right" value="Submit" />
</div>
</div>
<input type="hidden" id="delid" name="delid">
</form>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
function ConfirmDelete(id)
{

var cmt = confirm('You are about to delete a record. Click OK to continue?');
if (cmt == true) {
	document.getElementById('delid').value=id;
	document.getElementById('mainform').submit();
	return;
}
}

  $(document).ready(function(){

  $("#court").on('change',function(e){
  	 e.preventDefault();
    var id = $(this).val();
    var d = 'search_court';
  //alert(id);
    $token = $("input[name='_token']").val();
   $.ajax({
    headers: {'X-CSRF-TOKEN': $token},
    url: murl +'/division/session',

    type: "post",
    data: {'courtID':id,'val':d},
    success: function(data){
    location.reload(true);
    //console.log(data);
    }
  });

});
});

    $(document).ready(function(){
  	$('#division').change( function(){
      //alert('ok')
        var d = 'search_division';
  		$.ajax({
  			url: murl +'/division/session',
  			type: "post",
  			data: {'division': $('#division').val(),'val':d, '_token': $('input[name=_token]').val()},
  			success: function(data){
          console.log(data);
  				location.reload(true);
  				}
  		});
  	});});

 $( function() {
      $("#overdueDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#dueDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
      $("#incrementalDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    } ); 
</script>

 
@endsection


