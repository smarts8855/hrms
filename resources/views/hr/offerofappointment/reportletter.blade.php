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
	strong
	{
		font-weight:600;
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
		
	}
	.table, .table tr, .table tr td, #table 
	{
		border-top: none;
		border-color: none;
	}

</style>
 <div class="box box-default" style="border:none;">
    <div class="box-body box-profile" style="border:none;">
    	<div class="box-header with-border hidden-print" style="border:none;">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		 
		  <div class="box-body" style="border:none;">
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

                         <form method="post" action="{{url('/offerofappointment/addletter')}}">
                         {{ csrf_field() }}
                         @foreach($letter as $list)
						<div class="row">
						<table style="width: 100%" id="table">
						<tr>
						<td>
						<div class="col-md-3" style="padding: 28px;">
						<h6><span>Ref. No NICB/455/03/VOL. IV/</span> <span>{{$list->fileNo}}</span></h6>
							
							<div class="form-group">
							{{$list->address}}
							</div>
						</div>
						</td>
						<td>
						<div class="col-md-6 pull-right">
							
							<h6>{{date('d M, Y', strtotime($list->dateissued))}}</h6>
						</div>
						</td>
						</tr>
						</table>
						</div><!-- end row-->

						<div class="row">
						<div class="col-md-12">
							<h2 style="text-align: center">LETTER OF APPOINTMENT</h2>
						</div>
						</div>

						<div class="row">

						<div class="col-md-3">
						
						</div>

						</div><!-- end row-->

						<div class="row text-size" >

						<div class="col-md-12">
						<p> 
						<span>  With</span> reference to your acceptance on form Gen. 75 dated <strong>{{date('d M, Y', strtotime($list->acceptdate))}}</strong> of offer of provisional appointment as contained in our letter <strong>Ref. No. NICV/455/03/VOL. IV/ {{$list->fileNo}}</strong> dated <strong>{{date('d M, Y', strtotime($list->refdate))}}</strong>. I have the homour to inform you that you have been appointment with effect from <strong>{{date('d M, Y', strtotime($list->effectdate))}}</strong> as <strong>{{$list->position}}</strong> on total emolument of <strong>{{$list->emolument}}</strong> per annum on the conditions specified in the offer of appointment form Gen. 69.

						
						</p>
						</div>

						</div><!-- end row-->

						<div class="row">
								<div class="col-md-12">

								
									<div align="left" class="form-group">
										<br/><br/>

										<h5 style="text-align: center; font-weight:600">For: Chief Registrar</h5>
									</div>
								
								
								
										
								</div>
							</div><!-- end row-->

						</div>
						@endforeach
						</form>
						</div>
							
</div>
@endsection

