@extends('layouts.layout')

@section('pageTitle')
  	Excel Login Details
@endsection

@section('content')
<div class="box box-default" style="border: none;">
<div class="box-body box-profile" style="margin:0 5px;">
<div class="col-md-12 hidden-print"> @if (count($errors) > 0)
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <strong>Error!</strong> @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach </div>
  @endif                       
  
  @if(session('msg'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <strong>Success!</strong> {{ session('msg') }}</div>
  @endif
  @if(session('err'))
  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <strong>Operation Error !<br>
    </strong> {{ session('err') }}</div>
  @endif </div>
<p>
<h3 class="text-success text-center"> <strong>{{strtoupper('Upload Basic Profile')}}</strong> </h3>
</p>
<div class="row">
  <div class="col-sm-12">
    <div style="margin: 0px  5%;">
      <div class="form-group">
        <form id="form1" name="form1" method="post" action="{{url('/profile/save')}}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="file" name="upload">
          <input type="submit" name="submit" id="button" value="Submit" class="btn btn-success" style="margin-top: 10px;" />
        </form>
      </div>
      <!--//for update--> 
      
    </div>
  </div>
</div>
@stop

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts') 
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script> 
<script type="text/javascript">
  		var fileNo = $('#fileNo').val();
  		if(fileNo == ""){
			$('#saveUpdate').attr("disabled", true);
		}else{
			$('#saveUpdate').attr("disabled", false);
		}
  	(function () {
	$('#getStaff').change( function(){
    $('#processing').text('Processing. Please wait...');
		$.ajax({
			url: murl +'/personal-emolument/findStaff',
			type: "post",
			data: {'getStaff': $('#getStaff').val(), '_token': $('input[name=_token]').val()},
			success: function(data){
				$('#saveUpdate').attr("disabled", false);
		        $('#processing').text('');
		        $('#surname').val(data.surname);
		        $('#fileNo').val(data.fileNo);
		        $('#firstName').val(data.first_name);	
		        $('#otherNames').val(data.othernames); 
		        $('#grade').val(data.grade);
		        $('#division').val(data.division);
		        $('#bank').val(data.bank);
		        $('#branch').val(data.bank_branch);
		        $('#accountNo').val(data.AccNo);
		        $('#section').val(data.section);
		        $('#appointmentDate').val(data.appointment_date);
		        $('#incrementalDate').val(data.incremental_date);
		        $('#dateOfBirth').val(data.dob);
		        $('#residentialAddress').val(data.home_address);
		        $('#qurter').val(data.government_qtr);
		        $('#phoneNumber').val(data.phone);
		        $('#leaveAddress').val(data.leaveaddress);
			}
		})	
	});}) ();
//////////////////////////////////////////////////////// 
$( function() {
    $("#appointmentDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
    $("#incrementalDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $("#dateOfBirth").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
    $("#returnBefore").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $("#failureReturn").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );

  </script> 
@stop 