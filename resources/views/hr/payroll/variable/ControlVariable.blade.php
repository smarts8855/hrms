@extends('layouts.layout')

@section('pageTitle')
  Control Variable
@endsection

@section('content')
 
  <div class="box-body" style="background:#FFF;">
        <div class="row">
            <div class="col-md-12"><!---1st col-->
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

            </div>
			
             
				<div class="col-md-12"><!---2nd col-->
				<form method="post" action="{{ url('/variable/store') }}">
				
{{ csrf_field() }}
				         <div class="row">
				                 <div class="col-md-5">
										<div class="form-group">
										  <label for="staffName">Court</label>
										  <select name="court" id="staf" class="form-control court">

													<option>Select court</option>
													@foreach($court as $courts)
													@if($courts->id == session('court'))
													<option value="{{$courts->id}}" selected="selected">{{$courts->court_name}}</option>
													@else
													<option value="{{$courts->id}}">{{$courts->court_name}}</option>
													@endif
													@endforeach
										  </select>
										</div>
									</div>

									<div class="col-md-5"  style="padding-right: 0px">
										<div class="form-group">
										  <label for="staffName">Division</label>
										  <select name="division" id="division" class="form-control">
											@if(session('courtDivision') != '')
											@foreach($division as $div)
											@if($div->divisionID == session('courtDivision'))
											<option value="{{$div->divisionID}}" selected="selected">{{$div->division}}</option>
											@else
											<option value="{{$div->divisionID}}">{{$div->division}}</option>
											@endif
											@endforeach
											@endif
										  </select>
										</div>
									</div>

									<div class="col-md-2" style="padding-left: 0px; margin-top: 5px">
									<label for="staffName"></label>
										<div class="form-group">
										 <input type="submit" name="submit" value="Display" class="btn btn-success" >
										</div>
									</div>

							</div>
							
							<hr/>
                          
							
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="staffName">Select Staff Name</label>
										  <select name="staffName" id="staffName" class="form-control">
													<option>Select Staff Name</option>
													@foreach($staffList as $staffList)
													@if($staffList->fileNo == session('staffId'))
													<option value="{{$staffList->fileNo}}" selected="selected">{{$staffList->surname .' '. $staffList->first_name .' '. $staffList->othernames }}</option>
													@else
														<option value="{{$staffList->fileNo}}">{{$staffList->surname .' '. $staffList->first_name .' '. $staffList->othernames }}</option>
														@endif
													@endforeach
										  </select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="fileNo">File No</label>
										  <input type="Text" name="fileNo" id="fileNo" class="form-control" readonly value="@if($cv !=''){{$cv->fileNo}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="staffFullName">Staff Name</label>
										  <input type="Text" name="staffFullName" id="staffFullName" class="form-control" readonly value="@if($cv !=''){{$cv->surname}} {{$cv->first_name}}{{$cv->othernames}}@endif"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="grade">Grade</label>
										  <input type="Text" name="grade" id="grade" class="form-control" readonly value="@if($cv !=''){{$cv->grade}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="step">Step</label>
										  <input type="Text" name="step" id="step" class="form-control" readonly value="@if($cv !=''){{$cv->step}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="type">Employee Type</label>
										  <input type="Text" name="type" id="type" class="form-control" readonly  value="@if($cv !=''){{$cv->employee_type}}@endif" />
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="vehicle">Govt Vehicle</label>
										  <input type="Text" name="vehicle" id="vehicle" class="form-control" value="@if($cv !=''){{$cv->ugv}}@else{{old('vehicle')}}@endif" />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="nicnCoop">Cooperative</label>
										  <input type="Text" name="nicnCoop" id="nicnCoop" class="form-control" value="@if($cv !=''){{$cv->nicnCoop}}@else{{old('nicnCoop')}}@endif" />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="motor">Motor Vehicle Adv</label>
										  <input type="Text" name="motor" id="motor" class="form-control" value="@if($cv !=''){{$cv->motorAdv}}@else{{old('motor')}}@endif" />
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="bicycle">Bicycle/Cycle Adv</label>
										  <input type="Text" name="bicycle" id="bicycle" class="form-control" value="@if($cv !=''){{$cv->bicycleAdv}}@else{{old('bicycle')}}@endif" />
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="labour">CTLS Labour</label>
										  <input type="Text" name="labour" id="labour" class="form-control" value="@if($cv !=''){{$cv->ctlsLab}}@else{{old('labour')}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="fedsec">CTLS Fed. Sec</label>
										  <input type="Text" name="fedsec" id="fedsec" class="form-control" value="@if($cv !=''){{$cv->ctlsFed}}@else{{old('fedsec')}}@endif"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="housingLoan">Federal Housing Loan</label>
										  <input type="Text" name="fedhouse" id="fedhouse" class="form-control" value="@if($cv !=''){{$cv->fedHousing}}@else{{old('fedhouse')}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="hazard">Hazard</label>
										  <input type="Text" name="hazard" id="hazard" class="form-control" value="@if($cv !=''){{$cv->hazard}}@else{{old('hazard')}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="duty">Call Duty</label>
										  <input type="Text" name="duty" id="duty" class="form-control" value="@if($cv !=''){{$cv->callDuty}}@else{{old('duty')}}@endif"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="allowances">Shift Allowances</label>
										  <input type="Text" name="allowances" id="allowances" class="form-control" value="@if($cv !=''){{$cv->shiftAll}}@else{{old('allowances')}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="phonecharges">Phone Charges</label>
										  <input type="Text" name="phonecharges" id="phonecharges" class="form-control" value="@if($cv !=''){{$cv->phoneCharges}}@else{{old('phonecharges')}}@endif"/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
										  <label for="assistant">Personal Assistant</label>
										  <input type="Text" name="assistant" id="assistant" class="form-control" value="@if($cv !=''){{$cv->pa_deduct}}@else{{old('assistant')}}@endif"/>
										</div>
									</div>
								</div>
								
								<div class="row">
								  <div class="col-md-4">
										<div class="form-group">
										  <label for="surcharge">Surcharge</label>
										  <input type="Text" name="surcharge" id="surcharge" class="form-control" value="@if($cv !=''){{$cv->surcharge}}@else{{old('surcharge')}}@endif"/>
										</div>
									</div>
								</div>
								
							<div align="right" class="box-footer">
							   @permission('can-edit')
								<button class="btn btn-success" name="submit" type="submit"> Update</button>
							   @endpermission
								
						    </div>
				</div>
        </div><!-- /.col href="{{ url('/variable/view/') }}"-->
    </div><!-- /.row -->
  </form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
  	
$(document).ready(function()
{

	$('#staf').change( function(){
		var court = $(this).val();
		//alert(court);

		var div = "{{session('courtDivision')}}";

		$.ajax({
			url: murl +'/courts/retrieve',
			type: "post",
			//header: token,
			data: {'courtID': court, '_token': $('input[name=_token]').val()},
			success: function(data){
			$('#division').empty();
			 $.each(data, function(index, obj){
			 	//console.log(obj.division);
			 	/*if(obj.divisionID == div)
			 	{
			 		 $('#division').append( '<option value="'+obj.divisionID+'" selected = "selected">'+obj.division+'</option>' );
			 	}
			 	else
			 	{*/
                $('#division').append( '<option value="'+obj.divisionID+'">'+obj.division+'</option>' );
                //}
        
             });	
			}
		});	
		
	});
});
  	
</script>

  <script type="text/javascript">
  	(function () {
	$('#staffName').change( function(){
		$.ajax({
			url: murl +'/variable/setSession',
			type: "post",
			data: {'staffName': $('#staffName').val(), '_token': $('input[name=_token]').val()},
			success: function(data){
				location.reload(true);
					/*
					$('#staffFullName').val(data.surname + ' ' + data.first_name);
					$('#grade').val(data.grade);
					$('#step').val(data.step);
					$('#type').val(data.employee_type);
					$('#fileNo').val(data.fileNo);
					$('#fileId') . val(data.fileNo);
					$('#fileNo2').val(data.fileNo);
					$('#vehicle').val(data.ugv);
					$('#nicnCoop').val(data.nicnCoop);
					$('#motor').val(data.motorAdv);
					$('#fedsec').val(data.ctlsFed);
					$('#bicycle').val(data.bicycleAdv);
					$('#labour').val(data.ctlsLab);
					$('#fedhouse').val(data.fedHousing);
					$('#hazard').val(data.hazard);
					$('#duty').val(data.callDuty);
					$('#allowances').val(data.shiftAll);
					$('#phonecharges').val(data.phoneCharges);
					$('#assistant').val(data.pa_deduct);
					$('#surcharge').val(data.surcharge);
					*/
			}
		})	
	});}) ();

	$("#fileNo2").click(function() {
			var getvalue = $('#fileNo2').val();
			if(getvalue == '')
					$(location).attr('href','{{ url("/variable/create")}}');
			else
					$(location).attr('href','{{ url("/variable/view")}}/'+getvalue);
					
	});

</script>



@endsection