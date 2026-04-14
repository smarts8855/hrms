@extends('layouts.layout')

@section('pageTitle')
 

@endsection

@section('content')
<style type="text/css">
	.form-control
	{
		padding: 5px;
	}
	.form-control
	{
		padding: 5px;
		height: 20px;
	}
	.text-size
	{
		font-size: 17px;
		line-height: 28px;
	}
	.text-size .col-md-12 p
	{
		font-size: 18px;
		line-height: 32px;
	}
	.list
	{
		list-style: none;
		padding: 0px;
		margin:0px;
	}
	.list
	{
		
		margin: 10px 6px ;
	}
	#fileid
	{
		height: 34px;
	}
	.addr p
	{
		text-align: right;

	}
	.addr
	{
		background: #000;
	}
	.stylecontrol
	{
		border: none;
		font-weight:700; 
	}
	.p-style
	{
		font-weight: 400;
		font-size: 17px;
	}
	.box-header.with-border
	{
		border: none;
	}
	.box-profile, .box-default, .box-body
	{
		border: none;
	}
	.phead h4
	{
		font-size: 16px;
		f
	}
</style>
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		 
		  <div class="box-body">
		        <div class="row">
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
		                       
						@if(session('msg'))
		                    <div class="alert alert-success alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Success!</strong> 
								{{ session('msg') }} 
						    </div>                        
		                @endif

		                @if(session('err'))
		                    <div class="alert alert-warning alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Not Allowed ! </strong> 
								{{ session('err') }}
						    </div>                        
		                @endif

		            </div>
					

						</div><!-- end row-->
						
								<div class="col-md-12">
								<form method="post" action="" class="hidden-print">
									{{ csrf_field() }}
									<label>Select Staff</label>
									<select name="fileid" id="fileid" class="form-control">
									<option value="0" selected="selected">Choose one</option>
									@foreach($perList as $prolist)

									<option value="{{$prolist->fileNo}}">{{$prolist->surname }}  {{$prolist->first_name}}</option>
									@endforeach


									</select>	
						           </form>
						                     
						         <div class="clear"></div>

                         <form method="post" action="{{url('/offerofappointment/add-acceptance')}}">
                         {{ csrf_field() }}
						<div class="row">
						
						
						<table style="width: 100%">

						<tr>
						<td>
						<div class="col-md-10">
						<p class="phead">
						<h4>TO: The chief Rigistrar</h4>
						<h4>National Indusrial Court Of Nigeria</h4>
						<h4>10 Port-Harcourt Crescent Area II Garki Abuja</h4>
						<h6></h6>
						</p>
						<p class="p-style">I accept the offer of appointment in your letter No. <span> NICB/455/03/VOL. IV/</span> <span><input type="text" name="fileno" id="fileno" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="____________________"></span></p>
						<p class="p-style">Dated <input type="text" name="dateaccept" id="dateaccept" class="form-control stylecontrol" style="width:30%; display: inline;" placeholder="_________________________________"> and append hereto the neccessary Medical Certificate, Aggreement and security declaration.

						</p>
						<hr/>
												
						</div>
						</td>
						
						</tr>
						
						
						</table>
						
						

						</div><!-- end row-->

						<div class="row">
						<div class="col-md-12">
							<h3 style="text-align: center;">MEDICAL CERTIFICATE</h3>
						</div>
						</div>

						<div class="row">

						<div class="col-md-3">
						
						</div>

						</div><!-- end row-->

						<div class="row text-size" >

						<div class="col-md-12">
						<p> 
						I herby certify that Mr./Mrs/Miss: <span><input type="text" name="certifier" id="certifier" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="_________________________"> has been Medical Examined and found physically fit for appointment to the government Service and that he/she shows evidence of successful vaccination.
						 
						</p>
						<p>
							<div class="col-md-6"><h5>Date: <span><input type="text" name="datecertify" id="datecertify" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="______________________________"></h5></div>
							<div class="col-md-6">
								<h5 style="text-align: right;"><span><input type="text" name="medofficer" id="medofficer" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="______________________________"><br/>
								Medical Officer
								</h5>
							</div>

						</p>
						
						</div>

						</div><!-- end row-->
						<hr/>

						<div class="row text-size">
						<div class="col-md-12">
							<h3 style="text-align: center;">AGREEMENT</h3>
						</div>
						<p>I <input type="text" name="bearer" id="bearer" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="______________________________________"> of <input type="text" name="address" id="address" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="________________________________________"> in consideration of my appointment to the office of <input type="text" name="position" id="position" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="_________________________________________"> in N.I.C.N Department, do hereby agree that i will at no time demand my discharge from nor without the permission of Government, leave the service, untill a full month has elapsed from date of my giving written notice to the Head of the Department which i may be serving of my desire to leave, and agree to perform any duties in the Department which the head of Department may require me to perform. If against the tenor of this agreement i should leave the service before the expiration of one month from the date when i may have given notice as aforesiad, then i agree and bind myself to pay to the Government a sum of money equal to the full amount i may have recieved as salary for the month next preceeding that in which i may so leave.

						</p>
						
						<p>
							<div class="col-md-5">
							<h5><span><input type="text" name="witness" id="witness" class="form-control stylecontrol" style="width:22%; display: inline;" placeholder="_________________________________"><br/>
								Signature Of Witness<br/><br/>
								<input type="text" name="rank1" id="rank1" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="___________________________________"><br/>
								Rank of Witness

								</h5>
								</div>
							<div class="col-md-5">
								<h5 style="text-align: right;">

								Sign on top of Stamp
								</h5>
							</div>

						</p>
						</div><!-- end row-->
						<hr/>

						<div class="row text-size" >
						
						<p>I <input type="text" name="bearer" id="bearer2" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="________________________________________">  do solemnly and sincerely promise that i will not directly or indirectly reveal, except to a person to whom it is in the interest of the Government to comunicate any article, note document or information which has been or shall be entrusted to me in confidence by any person holding the Office under the Nigeria Government or which i may obtain in the course of the work which i perform, and i will, further, during the continuance of this work exercise due care and diligence to prevent the knowlegdge of any such article, note or information being communicated to any personagainst the interest of the Government. I realize that failure on my part to keep those promises renders me liable to imprisonment under the official secrets ordinance 1941 and that the secrecy imposed imposed upon me by that ordinance will continue after i have left the government Service

						</p>
						
						<p>
							<div class="col-md-6">
							<h5><input type="text" name="witness2" id="witness2" class="form-control stylecontrol" style="width:28%; display: inline;" placeholder="______________________________"><br/>
								Signature Of Signature<br/><br/>
								<input type="text" name="rank2" id="rank2" class="form-control stylecontrol" style="width:28%; display: inline;"><br/>
								Rank of Witness

								</h5></div>
							<div class="col-md-6">
								<h5 style="padding-top: 50px; text-align: right;">

								Signature
								</h5>
							</div>
							<hr/>
							

						</p>

						</div><!--end row -->
						<h6 style="text-align: center;">The Medical Certificate is not required in the case of temporary appoinment</h6>

						<hr/>

						<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<input type="submit" name="print" class="btn btn-success hidden-print" value="Print">
									</div>
								</div>
								
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<input type="submit" name="add" class="btn btn-success hidden-print" value="Add">
										<input type="submit" name="update" class="btn btn-success hidden-print" value="Update">	
									</div>
								</div>
								
										
								</div>
							</div><!-- end row-->



						
						</div>
						</form>

						</div>

						</div>
							
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script>
  <script type="text/javascript">
	

$( function() {

  $("#fileid").on('change', function(){

//$('#nameID').val(suggestion.data);
var id = $(this).val();
//alert(id);
$token = $("input[name='_token']").val();
$.ajax({
	headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/offerofappointment/getdata') }}",

  type: "post",
  data: {'fileno': id},
  success: function(data){
    
    $('#fileno').val(data.fileNo);
    $('#medofficer').val(data.medicalofficer);
    $('#dateaccept').val(data.dateaccepted);
    $('#datecertify').val(data.datecertified);
    $('#bearer').val(data.bearer);
    $('#bearer2').val(data.bearer);
    $('#witness').val(data.witness1);
    $('#witness2').val(data.witness2);
    $('#rank1').val(data.rank1);
    $('#rank2').val(data.rank2);
   $('#certifier').val(data.certifier);
   $('#position').val(data.position);
   $('#address').val(data.address);


    
  }
});
});
});

  $( function() {
	    $("#datecertify").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
				$("#datecertify").val(dateFormatted);
        	},
		});

  } );

    $( function() {
	    $("#dateaccept").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
				$("#dateaccept").val(dateFormatted);
        	},
		});

  } );

      $( function() {
	    $("#effectdate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
				$("#effectdate").val(dateFormatted);
        	},
		});

  } );
$( function() {
	    $("#refdate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
				$("#refdate").val(dateFormatted);
        	},
		});

  } );
</script>
@endsection