@extends('layouts.layout')

@section('pageTitle')
  	PERSONAL EMOLUMENT RECORDS
@endsection

@section('content')
 <div class="box box-default" style="border: none;">
    <div class="box-body box-profile" style="margin:0 5px;">
    <form class="form-horizontal" method="post" action="{{url('/staff/personal-emolument/update')}}">
    {{ csrf_field() }}
    	<div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span class="text-center" id='processing'></span></h3>
          <span class="pull-right" style="margin-right: 30px;">
          	 <div style="float: left; width: 100%;">
          	 	<select name="getStaff" id="getStaff" class="form-control hidden-print">
          	 		<option value="" selected="selected">Select a Staff</option>
          	 		@foreach($getNewOldStaff as $field)
          	 		<option value="{{$field->fileNo}}">
          	 			{{$field->surname .' '. $field->othernames .' '. $field->first_name .' ('. $field->fileNo .')'}}
          	 		</option>
          	 		@endforeach
          	 	</select>
          	 </div>
          </span>
        </div>

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
                        <strong>Operation Error !<br></strong> {{ session('err') }}</div>                        
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
				In order to comply with the Accountant-General's instruction and to maintain correct and comprehensive records of all officers in the Court, you are requested to complete this form and return it to the Salary Section before &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" name="returnBefore" id="returnBefore" style="border: none; font-weight: bold;" 
				placeholder="----E.g 25th November, 2017----">
			</div>
		</p>

		
		<div style="word-break: break-all;">
			<ol start="2">
				<li>
					Failure to return the form on time may give rise to omitting your name from 
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <input type="text" name="failureReturn" id="failureReturn" style="border: none; font-weight: bold;" 
				placeholder="----E.g 25th November, 2017----">  Salary Pay Roll
				</li>
				<li>
					Submit along with this form, one recent passport photograph.
				</li>
			</ol>
		</div>

		<div class="row">
			<div class="col-sm-12">

				<div style="margin: 0px  5%;">
					<div class="form-group">
					    <label class="control-label col-sm-2" for="fullName">Name:</label>
					    <div class="col-sm-10 row">
					    	<div class="col-sm-4">
					    		<input type="text" name="surname" id="surname" value="{{old('surname')}}" required class="form-control" placeholder="Surname" readonly>
					    	</div>
					    	<div class="col-sm-4">
					    		<input type="text" name="firstName" id="firstName" value="{{old('firstName')}}" required class="form-control" placeholder="First Name" readonly>
					    	</div>
					    	<div class="col-sm-4">
					    		<input type="text" name="otherNames" id="otherNames" value="{{old('otherNames')}}" class="form-control" placeholder="Other Names" readonly>
					    	</div>
					    </div>
					    <!--//for update-->
					    <div class="col-sm-4">
					    	<input type="hidden" name="fileNo" id="fileNo" value="{{old('fileNo')}}">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="division">Division:</label>
					    <div class="col-sm-10">
					    	<input type="text" name="division" id="division" value="{{old('division')}}" class="form-control" readonly>
					    	<!--<select name="division" id="division" class="form-control" required>
					    		<option value="">Select a Division</option>
					    		@foreach($getDivision as $div)
					    		<option value="{{$div->divisionID}}">{{$div->division}}</option>
					    		@endforeach
					    	</select>-->
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="grade">Rank/Grade Level:</label>
					    <div class="col-sm-10">
					    	<input type="number" name="grade" id="grade" value="{{old('grade')}}" class="form-control" required>
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="bank">Bank:</label>
					    <div class="col-sm-10">
					    	<select name="bank" id="bank" class="form-control" required>
					    		<option value="">Select a Bank</option>
					    		@foreach($getBank as $bank)
					    		<option value="{{$bank->bankID}}">{{$bank->bank}}</option>
					    		@endforeach
					    	</select>
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="branch"> Branch Address:</label>
					     <div class="col-sm-10">
					    	<input type="text" name="branch" id="branch" value="{{old('branch')}}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="accountNo">Account Number (10 Digits):</label>
					    <div class="col-sm-10">
					    	<input type="number" name="accountNo" id="accountNo" value="{{old('accountNo')}}" class="form-control" required>
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="section">Section:</label>
					    <div class="col-sm-10">
					    	<select name="section" id="section" class="form-control" required>
					    		<option value="">Select a Section</option>
					    		<option>ADMIN</option>
					    		<option>ACCOUNT</option>
					    		<option>BELIF</option>
					    		<option>JUDGES</option>
					    		<option>PRESIDING JUDGE</option>
					    		<option>LITIGATION</option>
					    		<option>RECORDS AND VERIATION</option>
					    		<option>MAINTENANCE</option>
					    		<option>TRANSPORT</option>
					    		<option>STORE</option>
					    		<option>VISITING JUDGES</option>
					    		<option>LIBRARY</option>
					    		<option>PERSONNEL</option>
					    		<option>FUNDS</option>
					    		<option>INTERNAL AUDIT</option>
					    		<option>PROTOCOL</option>
					    		<option>CR OFFICE</option>
					    		<option>SECURITY</option>
					    		<option>PRESIDENT CHAMBER</option>
					    		<option>CENTRAL PAY OFF</option>
					    		<option>REGISTRY</option>
					    		<option>PORTER</option>
					    		<option>RECONCILIATION</option>
					    		<option>CHECKING</option>
					    		<option>NHF</option>
					    		<option>OPEN REGISTRY</option>
					    		<option>C.P.O</option>
					    		<option>CLINIC</option>
					    		<option>ACR'S OFFICE</option>
					    		<option>TAX MATTERS</option>
					    		<option>WELFARE</option>
					    		<option>CLERICAL OFFICE</option>
					    		<option>MANPOWER</option>
					    		<option>ADR CENTRE</option>
					    		<option>DRIVER</option>
					    		<option>TYPING POOL</option>
					    		<option>DATA ROOM</option>
					    		<option>TRANING</option>
					    		<option>PENSION</option>
					    		<option>PLANNING RESEARCH</option>
					    		<option>OTHER CHARGES</option>
					    	</select>
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="appointmentDate">Date of Appointment:</label>
					    <div class="col-sm-10">
					    	<input type="text" name="appointmentDate" id="appointmentDate" required value="{{old('appointmentDate')}}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="incrementalDate">IncrementalDate:</label>
					    <div class="col-sm-10">
					    	<input type="text" name="incrementalDate" id="incrementalDate" value="{{old('incrementalDate')}}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="dateOfBirth">Date of Birth:</label>
					    <div class="col-sm-10">
					    	<input type="text" name="dateOfBirth" id="dateOfBirth" value="{{old('dateOfBirth')}}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="residentialAddress">Residential Address: ({{'1/1/'.date('Y')}})</label>
					    <div class="col-sm-10">
					    	<textarea name="residentialAddress" id="residentialAddress" class="form-control">{{old('residentialAddress')}}</textarea>
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="qurter">Government Quarter Occupied: (If Any)</label>
					    <div class="col-sm-10">
					    	<input type="text" name="qurter" id="qurter" value="{{old('qurter')}}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="phoneNumber">Phone Number:</label>
					    <div class="col-sm-10 hidden-print">
					    	<input type="number" name="phoneNumber" id="phoneNumber" value="{{old('phoneNumber')}}" class="form-control">
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-2" for="leaveAddress">Leave/Address:</label>
					    <div class="col-sm-10">
					    	<textarea name="leaveAddress" id="leaveAddress" class="form-control">{{old('leaveAddress')}}</textarea>
					    </div>
					</div>
					<div class="form-group">
						<input type="checkbox" name="certify" checked disabled>
					    <label for="certify">
					    	I certify that the particulars given above are correct to the best of my Knowledge.
					    </label>
					    	
					    
					</div>
				</div>
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

		<!-- Modal Dialog for UPDATE RECORD-->
      	<div class="modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
      		<div class="modal-dialog">
      			<div class="modal-content">
      				<div class="modal-header">
      					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      					<h4 class="modal-title">PERSONAL EMOLUMENT RECORDS FOR {{date('Y')}}</h4>
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
      					<input type="submit" name="button" class="btn btn-info" value="Continue" >
      				</div>
      			</div>
      		</div>
      	</div>
      	<!-- //Modal Dialog -->

		<div align="center" class="hidden-print"><hr />
			<button type="button" id="saveUpdate" data-toggle="modal" data-target="#confirmUpdate" class="btn btn-success"> <i class="fa fa-save"></i>
			Save/Update</button>
		</div>
	</form>
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