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

						        
						  <div class="clear"></div>

                         <form method="post" action="{{url('/offerofappointment/save')}}">
                         {{ csrf_field() }}
						<div class="row">
						
						<div class="addr" style="width: 60%; margin: auto; text-align: center;">
						<h3>NATIONAL INDUSTRIAL COURT</h3>
						<h4>31, LUGARD AVENUE</h4>
						<h4>KOYI, LAGOS</h4>
						</div>

						</div><!-- end row-->
						<div class="row">
						<h3 style="text-align: center;">REFEREE FORM</h3>
						
						</div>


						<div class="row text-size" >

						<div class="col-md-12">

						<p> I  _____________________________________ hereby recommend Mr/Mrs/Miss ___________________________________________ as fit and proper person to be offered employment in the Court and hereby undertake to be responsible to the Court for any illegal conduct by the above person leading to theft, damage or willfull destruction of court property.
						</p>
						</div>

						</div><!-- end row-->


						<div class="row text-size" >

						<div class="col-md-12">

						<p>
						<b>Names in full(Guarantor):</b> ___________________________________________________</b>
						</p>
						<p>
							<b>Rank:</b> _____________________________________________________________________
						</p>
						<p>
						<b>address(Office):</b> ____________________________________________________________
						</p>
						<p>
						 <b>(Residentials):</b>______________________________________________________________
						</p>

						<p>
						 <b>Tel.Landline:</b>_______________________________________________________________
						</p>
						<p>
						 <b>Mobile:</b>____________________________________________________________________
						</p>
						<p>
						 <b>Email Address:</b>______________________________________________________________
						</p>
						</div>

						</div><!-- end row-->

						<div class="row">

						<div class="col-md-4">
						<br/><br/>
						
						<p> _______________________________ <br/> Signature <br/><br/>
						
						Date: ______________________________
									<br/>

						</p>

						</div>
						</div>


						<div class="row">
								<div class="col-md-12">

																
										
								</div>
							</div><!-- end row-->

						</div>
						</form>
						</div>
							
</div>
@endsection
