@extends('layouts.layout')

@section('pageTitle')
  	PERSONAL EMOLUMENT RECORDS
@endsection

@section('content')
 <div class="box box-default" style="border: none;">
    <div class="box-body box-profile" style="margin:0 5px;">
    <form class="form-horizontal" method="post" action="{{url('/staff/emolument/update')}}">
    {{ csrf_field() }}

        	<div class="col-md-12 hidden-print">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Error!</strong> 
                  @foreach ($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
                  </div>
                  @endif                       
                        
                  @if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('msg') }}</div>                        
                  @endif
                  @if(session('err'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Staff Not Available for this Division! <br></strong> {{ session('err') }}</div>                        
                  @endif
        	</div>

		<p>
			<div class="row">
				<div align="left" class="col-xs-6">
					<table > 
						<tr><td align="left">TO ALL OFFICER, </td></tr>
						<tr><td align="left"><br /> National Industrial Court</td></tr>
					</table>
				</div>
				<div align="right" class="col-xs-6">
					<table > 
						<tr>
							<td>
								<img src="{{asset('Images/default.png')}}" height="100">
							</td>
						</tr>
					</table>
				</div>
			</div>
		</p>

		<p>
			<h4 class="text-success text-center">
				<strong>PERSONAL EMOLUMENT RECORDS FOR {{date('Y')}}</strong>
			</h4>
		</p>

		<p>
			<div style="word-break: break-all;">
				In order to comply with the Accountant-General's instruction and to maintain correct and comprehensive records of all officers in the Court, you are requested to complete this form and return it to the Salary Section before {{date('D M, Y', strtotime($getEmolumentReport->returnbefore))}}. 
			</div>
		</p>

		
		<div style="word-break: break-all;">
			<ol start="2">
				<li>
					Failure to return the form on time may give rise to omitting your name from 
					{{date('D M, Y', strtotime($getEmolumentReport->failurereturn))}}  Salary Pay Roll.
				</li>
				<li>
					Submit along with this form, one recent passport photograph.
				</li>
			</ol>
		</div>

		<div class="row">
			<div class="col-sm-12">

			<table class="table table-responsive table-striped">
				<tbody>
					<tr>
						<td>Name:</td><td>{{$getEmolumentReport->surname .' '. $getEmolumentReport->first_name .' '. $getEmolumentReport->othernames}}</td>
					</tr>
					<tr>
						<td>Division:</td><td>{{$getEmolumentReport->division}}</td>
					</tr>
					<tr>
						<td>Rank/Grade Level:</td><td>{{$getEmolumentReport->grade}}</td>
					</tr>
					<tr>
						<td>Bank:</td><td>{{$getEmolumentReport->bank}}</td>
					</tr>
					<tr>
						<td>Branch Address:</td><td>{{$getEmolumentReport->bank_branch}}</td>
					</tr>
					<tr>
						<td>Account NUmber (10 Digits):</td><td>{{$getEmolumentReport->AccNo}}</td>
					</tr>
					<tr>
						<td>Section:</td><td>{{$getEmolumentReport->section}}</td>
					</tr>
					<tr>
						<td>Date of First Appointment:</td><td>{{date('D M, Y', strtotime($getEmolumentReport->appointment_date))}}</td>
					</tr>
					<tr>
						<td>Incremental Date:</td><td>{{date('D M, Y', strtotime($getEmolumentReport->incremental_date))}}</td>
					</tr>
					<tr>
						<td>Date of Birth:</td><td>{{date('D M, Y', strtotime($getEmolumentReport->dob))}}</td>
					</tr>
					<tr>
						<td>Residential Address as at 1/1/{{date('Y')}}:</td><td>{{$getEmolumentReport->home_address}}</td>
					</tr>
					<tr>
						<td>Government Quarters:</td><td>{{$getEmolumentReport->government_qtr}}</td>
					</tr>
					<tr>
						<td>Phone Number:</td><td>{{$getEmolumentReport->phone}}</td>
					</tr>
					<tr>
						<td>Leave/Address:</td><td>{{$getEmolumentReport->leaveaddress}}</td>
					</tr>
				</tbody>
			</table>

				<hr />
				<p>
					<div class="row" align="center">
						<div class="col-sm-12">
							<div align="left" class="col-xs-6">
								<table > 
									<tr><td align="left">Certified By: <span style="font-style: italic;">Chief Registrar</span></td></tr>
									<tr><td align="left">National Industrial Court</td></tr>
									<tr><td align="left">Abuja Headquater</td></tr>
								</table>
							</div>
							
							<div class="col-xs-6 pull-right">
								<table > 
									<tr><td align="right">&nbsp;</td></tr>
									<tr><td align="right"> ........................................................</ </td></tr>
									<tr><td align="center">Signature</td></tr>
								</table>
							</div>
						</div>
					</div>
				</p>

			</div>
		</div>
	</form>
</div>
</div>
@stop