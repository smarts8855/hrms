@extends('layouts.layout')

<style type="text/css">
table, table tr th, table tr
{
  border: 1px solid #EEE;
}
</style>

@section('content')
<form method="post" action="" id="mainform" name="mainform" >

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
	<div class="row hidden-print">
		<h3 class="text-center">Staff Due For Variation</h3>
           @if ($CourtInfo->courtstatus==1)
        <div class="col-md-6">
            <div class="form-group">
            <label for="staffName">Court</label>
            <select name="court" id="court" class="form-control court">
               <option value="">Select court</option>
               @foreach($court as $courts)
               @if($courts->id == session('searchCourt'))
               <option value="{{$courts->id}}" selected="selected">{{$courts->court_name}}</option>
               @else
               <option value="{{$courts->id}}">{{$courts->court_name}}</option>
               @endif
               @endforeach
            </select>
            </div>
            </div>
          @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif

            @if ($CourtInfo->divisionstatus==1)
          <div class="col-md-6" >
            <div class="form-group">
            <label for="staffName">Division</label>
            <select name="division" id="division" class="form-control">
            	<option value="">Select</option>
            @if(session('searchCourt') != '')
            @foreach($division as $div)
            @if($div->divisionID == session('searchDivision'))
            <option value="{{$div->divisionID}}" selected="selected">{{$div->division}}</option>
            @else
            <option value="{{$div->divisionID}}">{{$div->division}}</option>
            @endif

            @endforeach
            @endif
            </select>
            </div>
            </div>
            @else
              <input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
            @endif
		<div class="col-md-3">
			<div class="form-group">
			  <label for="vehicle">Due Date</label>
			  <input type="Text" name="dueDate" id="dueDate" class="form-control" value="{{$dueDate}}" />
			</div>
		</div>
            <div class="col-md-3" >
            <div class="form-group">
            <label for="staffName">Process Year</label>
           
            <select name="year"  class="form-control">
            <option value="">Pending</option>
            <option value="All">All</option>
             @for($i=2010;$i<=2030;$i++)
                        <option value="{{$i}}" @if($year==$i) selected @endif>{{$i}}</option>
             @endfor
            </select>
          
            </div>
            </div>
            <div class="col-md-3" >
            <div class="form-group">
            <label for="staffName">Process Month</label>
            <select name="month" id="section" class="form-control">
                        <option value="">Pending </option>
                        <option value="All">All </option>
                        <option value="JANUARY" {{ ($month) == 'JANUARY' ? "selected":"" }}>January</option>  
                        <option value="FEBRUARY" {{ ($month) == 'FEBRUARY' ? "selected":"" }}>February</option>
                        <option value="MARCH" {{ ($month) == 'MARCH' ? "selected":"" }}>March</option>
                        <option value="APRIL" {{ ($month) == 'APRIL' ? "selected":"" }}>April</option>
                        <option value="MAY" {{ ($month) == 'MAY' ? "selected":"" }}>May</option>
                        <option value="JUNE" {{ ($month) == 'JUNE' ? "selected":"" }}>June</option>
                        <option value="JULY" {{ ($month) == 'JULY' ? "selected":"" }}>July</option>
                        <option value="AUGUST" {{ ($month) == 'AUGUST' ? "selected":"" }}>August</option>
                        <option value="SEPTEMBER" {{ ($month) == 'SEPTEMBER' ? "selected":"" }}>September</option>
                        <option value="OCTOBER" {{ ($month) == 'OCTOBER' ? "selected":"" }}>October</option>
                        <option value="NOVEMBER" {{ ($month) == 'NOVEMBER' ? "selected":"" }}>November</option>
                        <option value="DECEMBER" {{ ($month) == 'DECEMBER' ? "selected":"" }}>December</option>
 
                          </select>
            </div>
            </div>
            <div class="col-md-3" >
            <div class="form-group">
             <button type="submit" class="btn btn-success pull-right">Reload</button>
            </div>
            </div>


	</div>


	<hr>
	<div align="center"><strong></strong></div>
	<br />
	<table class="table table-hover table-striped table-responsive table-condensed">

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
        <th>Period Processed</th>
	</tr>
		</thead>
<?php $sn=0; ?>
		<tbody>
			@foreach ($due as $d)
<?php $sn+=1; ?>
			<tr>

	<td>{{$sn}}</td>
	<td>{{$d ->Fnumber}}</td>
        <td>{{$d->Names}}</td> 
        <td>{{$d -> arrears_type}}</td>
        <td>@if($d ->old_grade==0)NA @else {{$d -> old_grade}} @endif </td>
        <td>{{$d -> new_grade}}</td>
        <td>@if($d ->old_step==0)NA @else {{$d -> old_step}} @endif</td>
        <td>{{$d -> new_step}}</td>
        <td>{{$d -> due_date}}</td>
        <td>{{$d -> year_payment}} {{$d -> month_payment}}</td>
	<th>
		<div align="right">
			<a  onclick="return ConfirmDelete('{{$d->ID}}')" title="Remove" class="btn btn-danger deleteBankList" > <i class="fa fa-trash"></i> </a>
		</div>

	</th>

			</tr>

			@endforeach
		</tbody>

	</table>

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


