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
</style>
 <div class="box box-default" style="border:none">
    <div class="box-body box-profile" style="border:none">
    	<div class="box-header with-border hidden-print" style="border:none">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		 
		  <div class="box-body" style="border:none">
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
								
						                     
						         <div class="clear"></div>
                          @foreach($accept as $acceptance)
                         <form method="post" action="{{url('/offerofappointment/add-acceptance')}}">
                         {{ csrf_field() }}
						<div class="row">
						
						
						<table style="width: 100%">

						<tr>
						<td>
						<div class="col-md-8">
						<p style="">
						<h6><strong>TO: The chief Rigistrar</h6>
						<h6><strong>National Indusrial Court Of Nigeria</strong></h6>
						<h6><strong>10 Port-Harcourt Crescent Area II Garki Abuja<</strong></h6>
						<h6></h6>
						</p>
						<p>I accept the offer of appointment in your letter No. <span> NICB/455/03/VOL. IV/</span> <span>{{$acceptance->fileNo}}</span></p>
						<p>Dated {{$acceptance->dateaccepted}} and append hereto the neccessary Medical Certificate, Aggreement and security declaration.

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
						I herby certify that Mr./Mrs/Miss: <span>{{$acceptance->certifier}}</span> has been Medical Examined and found physically fit for appointment to the government Service and that he/she shows evidence of successful vaccination.
						 
						</p>
						<p>
						<table style="width: 100%">
						<tr>
						<td>
							<div class="col-md-6"><h5>Date: <span>{{$acceptance->datecertified}}</span></h5></div>
							</td>
							<td>
							<div class="col-md-5 col-md-offset-1">
								<h5>{{$acceptance->medicalofficer}}<br/>
								Medical Officer
								</h5>
							</div>
							</td>
							</table>

						</p>
						
						</div>

						</div><!-- end row-->
						<hr/>

						<div class="row text-size">
						<div class="col-md-12">
							<h3 style="text-align: center;">AGREEMENT</h3>
						</div>
						<p>I <b>{{$acceptance->bearer}}</b> of {{$acceptance->address}} in consideration of my appointment to the office of {{$acceptance->position}} in N.I.C.N Department, do hereby agree that i will at no time demand my discharge from nor without the permission of Government, leave the service, untill a full month has elapsed from date of my giving written notice to the Head of the Department which i may be serving of my desire to leave, and agree to perform any duties in the Department which the head of Department may require me to perform. If against the tenor of this agreement i should leave the service before the expiration of one month from the date when i may have given notice as aforesiad, then i agree and bind myself to pay to the Government a sum of money equal to the full amount i may have recieved as salary for the month next preceeding that in which i may so leave.

						</p>
						
						<p>
							<div class="col-md-6">
							<h5><span>{{$acceptance->witness1}}</span><br/>
								Signature Of Witness<br/><br/>
								{{$acceptance->rank1}}
								<br/>
								Rank of Witness

								</h5></div>
							<div class="col-md-6">
								<h5 style="padding-top: 50px; text-align: right;">

								Sign on top of Stamp
								</h5>
							</div>

						</p>
						</div><!-- end row-->
						<hr/>

						<div class="row text-size" >
						
						<p>I <b>{{$acceptance->bearer}}</b>  do solemnly and sincerely promise that i will not directly or indirectly reveal, except to a person to whom it is in the interest of the Government to comunicate any article, note document or information which has been or shall be entrusted to me in confidence by any person holding the Office under the Nigeria Government or which i may obtain in the course of the work which i perform, and i will, further, during the continuance of this work exercise due care and diligence to prevent the knowlegdge of any such article, note or information being communicated to any personagainst the interest of the Government. I realize that failure on my part to keep those promises renders me liable to imprisonment under the official secrets ordinance 1941 and that the secrecy imposed imposed upon me by that ordinance will continue after i have left the government Service

						</p>
						
						<p>
							<div class="col-md-6">
							<h5>{{$acceptance->witness2}}<br/>
								Signature Of Signature<br/><br/>
								<br/>
								{{$acceptance->rank2}}
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



						
						</div>
						</form>
						@endforeach

						</div>

						</div>
							
</div>
@endsection



