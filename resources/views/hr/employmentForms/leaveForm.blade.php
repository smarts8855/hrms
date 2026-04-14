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
	.list li
	{
		
		margin-left: 25px;
	}
	#fileid
	{
		height: 34px;
	}

	.stylecontrol
	{
		border: none;
		font-weight:700; 
		outline: none;
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
		
	}
	#fileid
	{
		width:40%;
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

						         <h2 style="text-align: center;">{{strtoupper('NATIONAL INDUSTIAL COURT OF NIGERIA')}} </h2>
						         <p> <h4 style="text-align: center;">{{strtoupper('LEAVE APPLICATION FORM')}} </h4></p>
            
						  <div class="clear"></div>

                         <form method="post" action="{{url('/offerofappointment/save')}}">
                         {{ csrf_field() }}
						<div class="row">
						<div class="col-md-12">
						<table style="width: 100%;">
							<tr>
								<td><p style="font-size: 20px;">DIVISION ______________________</p></td>
								<td><p style="text-align: right; font-size: 20px;">DATE ______________________</p></td>
							</tr>
						</table>
						</div>

						</div><!-- end row-->


						<div class="row text-size" >

						<div class="col-md-12">
						<p>(A) PERSONAL DATA:</p>
						<p>
						 1. Name of Staff ____________________________________________________________
						</p>
						<p>
						2. Designation/Grade Level:___________________________________________________
							
						</p>
						<p>
						3. Department/Section/Unit: __________________________________________________
						
						</p>
						<p>
						4. Type of leave applied for ____________________________________________________
						</p>
						<p>
						5. No. of days applied for ______________________________________________________
						</p>
						<p>

						6. Date of Commencement ____________________________________________________

						</p>
						<p>
						7. Date of Resumption from leave ______________________________________________
						</p>
						<p>
						8. Leave address _____________________________________________________________<br/>___________________________________________________________________________
						</p>
						<p>
						9. Telephone No ____________________________________________________________
						</p>
						<p>
						10. Signature Of Applicant ____________________________________________________
						</p>
						</div>

						<div class="col-md-12">
						<p>(B) FOR OFFICIAL USE ONLY:</p>
						<p>
						 1. Confirmation of Leave entitlement by record unit _________________________________
						</p>
						<p>
						2. Date of commencement of last leave: __________________________________________	
						</p>
						<p>
						3. Date of resumption of last leave: ______________________________________________
						
						</p>
						<p>
						4. Type of previous leave approved ______________________________________________
						</p>
						<p>
						5. Signature of Head of Unit/Section _____________________________________________
						</p>
						<p>

						6. Signature of Head of Division ________________________________________________

						</p>
						<p>
						7. Signature of Head of Administration __________________________________________
						</p>
						
						</div>


						<div class="col-md-12">
						<p>(C) APPROVED BY THE CHIEF REGISTRAR:</p>
						<p>
						 leave approved/not Approved _________________________________________________
						</p>
						<p>
						 Signature/Date:_____________________________________________________________
							
						</p>
						</div>


						</div><!-- end row-->

						


						<div class="row">
								<div class="col-md-12">

																
										
								</div>
							</div><!-- end row-->

						</div>
						</form>
						</div>
							
</div>

@endsection
