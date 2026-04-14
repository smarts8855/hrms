@extends('layouts.layout')
@section('pageTitle')
Staff control Variable
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        @if ($warning<>'')
	<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$warning}}</strong> 
	</div>
	@endif
	@if ($success<>'')
	<div class="alert alert-dismissible alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$success}}</strong> 
	</div>
	@endif
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
	<form method="post"  id="thisform1" name="thisform1">
		{{ csrf_field() }}
		<div class="box-body">
		<div class="row">
         <div class="col-md-4">
			<div class="form-group">
			  <label for="staffName">Court</label>
			  <select name="court" id="staf" class="form-control court" onchange="ReloadFormcourtdivision()" required>
				<option value=''>-Select court-</option>
				@foreach ($CourtList as $b)
				<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>
				@endforeach 
			  </select>
			</div>
		</div>

	<div class="col-md-4"  style="padding-right: 0px">
		<div class="form-group">
		  <label for="staffName">Division</label>
		  <select name="division" id="division" class="form-control" onchange="ReloadFormcourtdivision()" required>
			<option value=''>-Select division-</option>
			@foreach ($DivisionList as $b)
			<option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>
			@endforeach 
		  </select>
		</div>
	</div>
	<div class="col-md-4"  style="padding-right: 0px">
		<div class="form-group">
		  <label for="staffName">Select Staff Name</label>
		  <select name="staffName" id="staffName" class="form-control" onchange="ReloadForm()" required>
			<option value=''>-Select staff-</option>
			@foreach ($staffList as $b)
			<option value="{{$b->fileNo}}" {{ ($staffName) == $b->fileNo? "selected":"" }}>{{$b->fileNo}}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</option>
			@endforeach 
		  </select>
		  <input  type="hidden"  name="hiddenstaffName" value="{{$staffName}}" >
		</div>
	</div>
									

	</div>
	
	<hr/>

	
		<div class="row">
		 
			<div class="col-md-2">
				<div class="form-group">
				  <label for="fileNo">File No</label>
				  <input type="Text" name="fileNo" id="fileNo" class="form-control" readonly value="{{$cv->fileNo}}"/>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				  <label for="staffFullName">Staff Name</label>
				  <input type="Text" name="staffFullName" id="staffFullName" class="form-control" readonly value="{{$cv->surname}} {{$cv->first_name}}{{$cv->othernames}}"/>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
				  <label for="grade">Grade</label>
				  <input type="Text" name="grade" id="grade" class="form-control" readonly value="{{$cv->grade}}"/>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
				  <label for="step">Step</label>
				  <input type="Text" name="step" id="step" class="form-control" readonly value="{{$cv->step}}"/>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
				  <label for="type">Employee Type</label>
				  <input type="Text" name="type" id="type" class="form-control" readonly  value="{{$cv->employee_type}}" />
				</div>
			</div>
		</div>
		
		<hr/>
			
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="vehicle">Govt Vehicle</label>
										  <input type="Text" name="vehicle" id="vehicle" class="form-control" value="{{$vehicle}}" />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="nicnCoop">Cooperative</label>
										  <input type="Text" name="nicnCoop" id="nicnCoop" class="form-control" value="{{$nicnCoop}}" />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="motor">Motor Vehicle Adv</label>
										  <input type="Text" name="motor" id="motor" class="form-control" value="{{$motor}}" />
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="bicycle">Bicycle/Cycle Adv</label>
										  <input type="Text" name="bicycle" id="bicycle" class="form-control" value="{{$bicycle}}" />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="labour">CTLS Labour</label>
										  <input type="Text" name="labour" id="labour" class="form-control" value="{{$labour}}"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="fedsec">CTLS Fed. Sec</label>
										  <input type="Text" name="fedsec" id="fedsec" class="form-control" value="{{$fedsec}}"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="housingLoan">Federal Housing Loan</label>
										  <input type="Text" name="fedhouse" id="fedhouse" class="form-control" value="{{$fedhouse}}"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="hazard">Hazard</label>
										  <input type="Text" name="hazard" id="hazard" class="form-control" value="{{$hazard}}"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="duty">Call Duty</label>
										  <input type="Text" name="duty" id="duty" class="form-control" value="{{$duty}}"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="allowances">Shift Allowances</label>
										  <input type="Text" name="allowances" id="allowances" class="form-control" value="{{$allowances}}"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="phonecharges">Phone Charges</label>
										  <input type="Text" name="phonecharges" id="phonecharges" class="form-control" value="{{$phonecharges}}"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="assistant">Personal Assistant</label>
										  <input type="Text" name="assistant" id="assistant" class="form-control" value="{{$assistant}}"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="surcharge">Surcharge</label>
										  <input type="Text" name="surcharge" id="surcharge" class="form-control" value="{{$surcharge}}"/>
										</div>
									</div>
								</div>
								
							<div align="right" class="box-footer">
							   @if ($submittype=='1')
								<button class="btn btn-success" name="update" type="submit"> Update</button>
							   @else
							   	<button class="btn btn-success" name="add" type="submit">Submit</button>
							   @endif
								
						    </div>
				</div>
        	 
		</div>
		
	</form>
	
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}
	
	function  ReloadFormcourtdivision()
	{	
	document.getElementById('staffName').value='';
	document.getElementById('thisform1').submit();
	return;
	}
	
  	
  </script>
@endsection
