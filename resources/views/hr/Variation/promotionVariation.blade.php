@extends('layouts.layout')

@section('pageTitle')
  	COMPUTE VARIATION
@endsection

@section('content')
 <div class="box box-default" style="border: none;">
    <div class="box-body box-profile">
    <form id="updateVariationForm" method="POST" action="{{url('/staff/variation/update')}}">
    {{ csrf_field() }}
    	<div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
          <span id="oldRank"  class="pull-right" style="color: red;">
          		Old-Grade:&nbsp;
          		<span id="oldGrade2">
          			@if($varR != ''){{$varR->grade}}@endif
          		</span>
          		&nbsp;|&nbsp;Old-Step:&nbsp;
          		<span id="oldStep2">
          			@if($varR != ''){{$varR->step}}@endif
          		</span>
          		<span id="oldStep2">&nbsp;|&nbsp; 
          			@if($varOldAmount != '') &#8358;{{ number_format((($varOldAmount->amount) * 12), 2, '.', ',') }}@endif /P.A
          		</span>
          </span>
          <span class="pull-right" style="margin-right: 30px;">
          	 <div style="float: left; width: 100%;">
          	 	<select name="getStaff" id="getStaff" class="form-control hidden-print">
          	 		<option value="" selected="selected">List of Staff due for increment/promotion</option>
          	 		@foreach($getStaffIncrement as $field)
          	 		<option value="{{$field->fileNo}}">
          	 			{{$field->surname .' '. $field->othernames .' '. $field->first_name .' (JIPPIS/P/'. $field->fileNo .')'}}
          	 		</option>
          	 		@endforeach
          	 	</select>
          	 </div>
          </span>
        </div>

        	<div class="col-md-12 hidden-print">
            @if(count($errors) > 0)
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
                        <strong>Input Error !<br></strong> {{ session('err') }}</div>                        
                  @endif
        	</div>

		  <p>
			<div class="row">
				<div class="col-xs-2"></div>
				<div class="col-xs-8">
					<div class="row" >
						<div align="right" class="col-xs-7">
							<h3 class="text-success"><strong>VARIATION ORDER NO.</strong></h3>
						</div>
						<div align="left" class="col-xs-3 hidden-print">
							<input type="text" name="variationOrderNo" id="variationOrderNo" class="form-control input-lg" 
							style="height: 40px; margin-top: 15px; border: none; text-align: left; font-weight: bold;" placeholder="-----------------">
						</div>
					</div>
				</div>
				<div class="col-xs-2"></div>
			</div>
		  </p>
		<p>
		<br />
			<div class="row">
				<div align="left" class="col-xs-6">
					<table > 
						<tr><td align="left">ADMINISTRATIVE/ESTABLISHMENT SECTION,</td></tr>
						<tr><td align="left">VARIATION CONTROL OFFICER,</td></tr>
						<tr>
							<td align="left">
								OFFICER IN CHARGE OF SALARIES.
								<span> 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<big><b>VARIATION ADVICE</b></big>
								</span> 
							</td>
						</tr>
					</table>
				</div>
				<div align="right" class="col-xs-6">
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
					Please find enumerated hereunder for neccessary action, list of variation for the week ended 
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="endedDate" id="endedDate" style="font-weight: bold; border: none; width: 10%;" placeholder="......................................" readonly> 
					<br />

					to be submitted not later than 
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="laterThan" id="laterThan" style="font-weight: bold; border: none; width: 10%;" placeholder=".............................................." readonly> &nbsp;&nbsp; day of the week of the Month.
				</div>
			</div>
		</p>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-responsive table-condensed table-striped table-bordered"> 
					<thead>            
						<tr>
							<td  align="center" width="200">NAME <br /> 1</td>
							<td  align="center">RANK <br /> 2</td>
							<td  align="center">FILE NO. <br /> 3</td>
							<td  align="center">NEW SALARY P.A <br /> 4</td>
							<td  align="center">AMOUNT OF VARIATION <br /> 5</td>
							<td  align="center">REASON FOR VARIATION <br /> 6</td>
							<td  align="center">EFFECTIVE DATE <br /> 7</td>
							<td  align="center">AUTHORITY GAZETTE <br > NOTIFICATION <br /> 8</td>
							<td  align="center">REMARK <br /> 9</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="left">
								<div id="name">
								@if($varR != '')
								   {{$varR->surname .' '. $varR->first_name .' '. $varR->othernames}}
								@endif
								</div>
							</td>

							<td align="left">
								<input type="text" name="rank" id="rank" class="form-control hidden-print" style="width: 90px; font-size: 12px;" value="@if($varR != ''){{$varR->section}}@endif" readonly>
							</td>


							<input type="hidden" name="newGrade" id="newGrade" value="@if($varR != ''){{$varR->gradealert}}@endif"> <!--new-->
							<input type="hidden" name="newStep" id="newStep" value="@if($varR != ''){{$varR->stepalert}}@endif">  <!--new-->
							<input type="hidden" name="oldGrade" id="oldGrade" value="@if($varR != ''){{$varR->grade}}@endif"> <!--old-->
							<input type="hidden" name="oldStep" id="oldStep" value="@if($varR != ''){{$varR->step}}@endif">  <!--old-->
							<input type="hidden" name="fileNumber" value="@if($varR != ''){{$varR->fileNo}}@endif">
							<!--new Salary-->
							<input type="hidden" name="newSalary" value="@if($varNewAmount != ''){{ (($varNewAmount->amount) * 12) }}@endif">
							<!--Amount of variation-->
							<input type="hidden" name="amount" value="{{ $amountOfVariation }}">


							<td align="left">
								<input type="text" name="fileNo" id="fileNo" class="form-control hidden-print" style="width: 90px; font-size: 12px;" readonly value="@if($varR != ''){{'JIPPIS/P/'.$varR->fileNo}}@endif">
							</td>

							<td align="left">
								<input type="text" name="newSalary2" id="newSalary2" placeholder="No comma" class="form-control hidden-print" style="width: 100px; font-size: 12px;" value="@if($varNewAmount != ''){{ number_format(((($varNewAmount->amount) * 12)), 2, '.', ',') }}@endif"> 
							</td>

							<td align="left"> 
								<input type="text" name="amount2" id="amount2" placeholder="No comma" class="form-control hidden-print" style="width: 90px; font-size: 12px;" value="{{ number_format(($amountOfVariation), 2, '.', ',') }}">
							</td>

							<td align="left">
								<select name="reasonForVariation" id="reasonForVariation" class="form-control hidden-print" style="width: 150px;">
										<option>@if($varR != ""){{$varR->variationreason}}@endif</option>
										<option>Increment</option>
										<option>Promotion</option>
										<option>Advancement</option>
										<option>Conversion</option>
										<option>Confirmation</option>
										<option>New Appointment</option>
								</select>
							</td>

							<td align="left"><input type="text" name="effectiveFrom" id="effectiveFrom" class="form-control hidden-print" readonly style="width: 90px; font-size: 12px;"></td>

							<td align="left"><input type="text" name="authority" id="authority" class="form-control hidden-print"></td>

							<td align="left">
								<input type="text" name="remark" id="remark" class="form-control hidden-print" style="width: 100px; font-size: 12px;" value="@if($varR != ''){{'GL: '. $varR->gradealert .'| STP: '. $varR->stepalert }}@endif">
							</td>
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
							<tr><td align="left">Date: &nbsp;&nbsp;&nbsp;{{date('d-m-Y')}}</td></tr>
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
							<tr><td align="left">Date Recorded: &nbsp;&nbsp;&nbsp;{{date('d-m-Y')}}</td></tr>
							<tr><td align="left">Action Taken: ........................................................</td></tr>
							<tr><td align="left">Signature: ..............................................................</td></tr>
						</table>
					</div>
				</div>
			</p>

		</div>
	</div>

		<!-- Modal Dialog for UPDATE RECORD-->
      	<div class="modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
      		<div class="modal-dialog">
      			<div class="modal-content">
      				<div class="modal-header">
      					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      					<h4 class="modal-title"> CONFIRM VARIATION !</h4>
      				</div>
      				<div class="modal-body">
      					<p>Are you sure you want to perform this operation? 
      					<br />
      					&nbsp; 	<b>Continue</b>  - this will save/update your record <br />
      					&nbsp; 	<b>Cancel</b> 	 - this will return you back to the same page 
      					</p>
      				</div>
      				<div class="modal-footer">
      					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      					<button type="submit" name="updateVariation" class="btn btn-info">
      						<i class="fa fa-save"></i> Continue
      					</button>
      				</div>
      			</div>
      		</div>
      	</div>
      	<!-- //Modal Dialog -->
		<hr />
		<div align="center" class="hidden-print">
			<div id="fileNoPrint"></div>
			<button type="button" data-toggle="modal" data-target="#confirmUpdate" class="btn btn-success pull-right"> <i class="fa fa-save"></i>
			Compute</button>
		</div>
	<br />
	</form>

	</div>
</div>

	<!--this is very important-->
	<form id="variationForm" method="post" action="{{url('/variation/findStaff')}}">
	{{ csrf_field() }}
		<input type="hidden" name="staffName" id="staffName">  <!--fileNo-->
	</form>
@stop

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  ///////////////////// 
  	(function () {
		$('#getStaff').change( function(){
			$('#staffName').val($('#getStaff').val()); 
			$('#variationForm').submit();
		});
	}) ();
///////////////////
$( function() {
    $("#endedDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $("#laterThan").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $("#effectiveFrom").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );

</script>
@stop