@extends('layouts.layout')

@section('pageTitle')
  	VARIATION ADVICE
@endsection

@section('content')
 <div class="box box-default" style="border: none;">
    <div class="box-body box-profile">
  
    {{ csrf_field() }}
    	<div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
		  <p>
			<div class="row">
				<div class="col-xs-2"></div>
				<div class="col-xs-8">
					<h3 class="text-center"><strong>VARIATION ORDER NO.  {{$getNewOldStaff->variationorderno}}</strong></h3>
				</div>
				<div class="col-xs-2"></div>
			</div>
		  </p>
		<p>
			<div class="row">
				<div align="left" class="col-xs-8">
					<table> 
						<tr><td align="left">ADMINISTRATIVE/ESTABLISHMENT SECTION,</td></tr>
						<tr><td align="left">VARIATION CONTROL OFFICER,</td></tr>
						<tr>
							<td align="left">
								OFFICER IN CHARGE OF SALARIES 
								<span> 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									VARIATION ADVICE
								</span> 
							</td>
						</tr>
					</table>
				</div>
				<div align="right" class="col-xs-4">
					<table > 
						<tr><td align="right">T.F.220</td></tr>
						<tr><td align="right"></td></tr>
						<tr><td align="right"></td></tr>
					</table>
				</div>
			</div>
		</p>

		<p>
			<div class="row">
				<div align="left" class="col-xs-12">
					Please find enumerated hereunder for neccessary action, list of variation for the week ended   {{$getNewOldStaff->endeddate}} <br />
					to be submitted not later than {{$getNewOldStaff->laterthan}} day of the week of the Month.
				</div>
			</div>
		</p>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-responsive table-condensed table-striped table-bordered"> 
					<thead>            
						<tr>
							<td align="center" width="200">NAME <br /> 1</td>
							<td  align="center">RANK <br /> 2</td>
							<td  align="center">FILE NO. <br /> 3</td>
							<td align="center">NEW SALARY P.A <br /> 4</td>
							<td  align="center">AMOUNT OF VARIATION <br /> 5</td>
							<td  align="center">REASON FOR VARIATION <br /> 6</td>
							<td  align="center">EFFECTIVE DATE <br /> 7</td>
							<td  align="center">AUTHORITY GAZETTE <br > NOTIFICATION <br /> 8</td>
							<td  align="center">REMARK <br /> 9</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center">
								{{$getNewOldStaff->surname .' '. $getNewOldStaff->first_name .' '. $getNewOldStaff->othernames}}
							</td>
							<td align="left">
								{{$getNewOldStaff->rank}}
							</td>
							<td align="left">{{'JIPPIS/P/'.$getNewOldStaff->fileNo}}</td>

							<td align="left">{{ number_format(($getNewOldStaff->newsalary), 2, '.', ',') }}</td>

							<td align="left">
								{{ number_format(($getNewOldStaff->amount), 2, '.', ',')}}
 							</td>

							<td align="left">{{$getNewOldStaff->reason}}</td>

							<td align="left">{{$getNewOldStaff->effectivedate}}</td>

							<td align="left">{{$getNewOldStaff->authority}}</td>

							<td align="left">{{$getNewOldStaff->remark}}</td>
						</tr>
					</tbody>
				</table>

		<p>
			<div class="row">
				<div align="left" class="col-xs-4">
					<table > 
						<tr><td align="left">Signature: ........................................................</td></tr>
						<tr><td align="left">For: Head of Personnel Administration</td></tr>
						<tr><td align="left">For: Chief Registrar</td></tr>
						<tr><td align="left">Date: &nbsp;&nbsp;&nbsp;{{$getNewOldStaff->laterthan}}</td></tr>
					</table>
				</div>
				<div align="center" class="col-xs-4">
					<table> 
						<tr><td align="left">Cc: Head of Accounts JIPPIS, Abuja</td></tr>
						<tr><td align="left">Head of Internal Audit JIPPIS, Abuja</td></tr>
						<tr><td align="left">Officer in Charge of Records, JIPPIS, Abuja</td></tr>
					</table>
				</div>
				<div align="left" class="col-xs-4">
					<table > 
						<tr><td align="left">Date Recorded: &nbsp;&nbsp;&nbsp;{{$getNewOldStaff->v_created_at}}</td></tr>
						<tr><td align="left">Action Taken: ........................................................</td></tr>
						<tr><td align="left">Signature: ..............................................................</td></tr>
					</table>
				</div>
			</div>
		</p>
		<div class="hidden-print text-center">
			<hr />
			<a href="{{url('/staff/variation/view')}}" class="btn btn-warning"><i class="fa fa-arrow-circle-0"> Back to list</i></a>
		</div>
	</div>
  </div>
</div>
</div>
@stop