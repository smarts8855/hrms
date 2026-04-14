<form action="{{url('/staff-documentation-basic-info')}}" method="POST">
{{csrf_field()}}
<div class="tab-pane" role="tabpanel" id="step2">
	<div class="col-md-offset-0">
		<h3 class="text-success text-center">
			<i class="glyphicon glyphicon-user"></i> <b>Basic Information</b>
		</h3>
		<div align="right" style="margin-top: -35px;"> 
			Field with <span class="text-danger"><big>*</big></span> is important
		</div>
	</div>
	<br />
	
	</div>
	<div class="row col-md-offset-1">
				
			<div class="col-md-2">
			<label>File Number</label>
			@if($staffInfo != '')
			<input readonly type="text" class="form-control input-lg" id="fileNo" name="fileNo" value="{{$fileNo}}"> 
				<!---->
			@else
			<input readonly type="text" class="form-control input-lg" id="fileNo" name="fileNo" value="{{ old('fileNo') }}" placeholder="{{$fileNo}}"> 
			@endif
				<!---->
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Surname</label>
					@if($staffInfo != '')
					<input readonly type="text" name="surname" id="surname" class="form-control input-lg" value="{{$staffInfo->surname}}" required />
					@else
					<input readonly type="text" name="surname" id="surname" class="form-control input-lg" value="{{ old('surname') }}" required /> 
					@endif
				</div>
			</div>					
			<div class="col-md-3">
				<div class="form-group">
					<label>First name</label>
					@if($staffInfo != '')
					<input readonly type="text" name="firstName" id="firstName" class="form-control input-lg" value="{{$staffInfo->first_name }}" required />
					@else
					<input readonly type="text" name="firstName" id="firstName" class="form-control input-lg" value="{{ old('firstName') }}" required />
					@endif
				</div> 
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Other Names</label>
					@if($staffInfo != '' )
					<input readonly type="text" name="otherNames" id="otherNames" class="form-control input-lg" value="{{$staffInfo->othernames }}" />
					@else
					<input readonly type="text" name="otherNames" id="otherNames" class="form-control input-lg" value="{{ old('otherNames') }}" />
					@endif
				</div>

			</div>
		</div>

		<div class="row col-md-offset-1">
				<div class="col-md-2">
					<div class="form-group">
						<label>Title <span class="text-danger"><big>*</big></span></label>
						@if($staffInfo != '')
						<select name="title" id="title" class="form-control input-lg formex" required>
							<option value="">Select</option>
							<option value="MR." {{ ($staffInfo->title === 'MR.') ? "selected":"" }}>Mr.</option>
							<option value="MRS." {{ ($staffInfo->title === 'MRS.') ? "selected":"" }}>Mrs.</option>
							<option value="MISS" {{ ( $staffInfo->title === 'MISS') ? "selected":"" }}>Miss</option>
							<option value="HON. JUSTICE" {{ ($staffInfo->title === 'HON. JUSTICE') ? "selected":"" }}>Hon. Justice</option>
						</select>
						@else
						<select name="title"  id="title" class="form-control input-lg formex">
							<option value="" >Select</option>
							<option value="MR." {{ (old("title") == "MR.") ? "selected":"" }}>Mr.</option>
							<option value="MRS." {{ (old("title") == "MRS." ) ? "selected":"" }}>Mrs.</option>
							<option value="MISS" {{ (old("title") == "MISS") ? "selected":"" }}>Miss</option>
							<option value="HON. JUSTICE" {{ (old("title") == "HON. JUSTICE") ? "selected":"" }}>Hon. Justice</option>
						</select>
						@endif
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="form-group">
						<label>Gender <span class="text-danger"><big>*</big></span></label>
						@if($staffInfo != '')
						<select name="gender" id="gender" class="formex form-control input-lg" required>
							<option value="">Select</option>
							<option value="Male" {{  ($staffInfo->gender === 'Male' || $staffInfo->gender === 'MALE' || old("gender") === "Male" ) ? "selected":"" }}>Male</option>
							<option value="Female" {{ ($staffInfo->gender === 'Female' || $staffInfo->gender === 'FEMALE' || old("gender") === "Female") ? "selected":"" }}>Female</option>
						</select>
						@else
							<select name="gender" id="gender" class="formex form-control input-lg" required>
							<option value="" >Select</option>
							<option value="Male" {{ (old("gender") == "Male") ? "selected":"" }}>Male</option>
							<option value="Female" {{ (old("gender") == "Female" ) ? "selected":"" }}>Female</option>
						</select>
						@endif
					</div> 
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Date of Birth</label>
						@if($staffInfo != '')
						<input readonly="readonly" placeholder="Date of Birth" type="text" name="dateofBirth" id="dob" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($staffInfo->dob)) }}" />

						@else
						<input type="text" readonly="readonly" name="dateofBirth" id="dob2" placeholder="Date of Birth" class="form-control input-lg" value="{{ old('dateOfBirth') }}" />
						@endif 
					</div>
				</div>	
				
				<div class="col-md-3">
					<div class="form-group">
									<label>Place of Birth <span class="text-danger"><big>*</big></span></label>
									@if($staffInfo !=='')
										<select type="text" id="states" name="state"  class="formex form-control input-lg" required >
											<option value="">Select State</option>
											@foreach($StateList as $b)
												<option value="{{$b->StateID}}" {{ ($staffInfo->placeofbirth == $b->StateID || old("state") == $b->StateID )? "selected" :"" }}>{{$b->State}} </option>
											@endforeach
											</select>
									@else
									<select type="text" id="states" name="state" class="formex form-control input-lg"  required>
										
										<option value="">Select State</option>
											@foreach($StateList as $b)
										<option value="{{$b->StateID}}" {{ (old('state') == $b->StateID)? "selected":"" }}>{{$b->State}} </option>
											@endforeach
									</select>

										  
									  @endif
					</div>
				</div>	
			
			
			<p>
					                        
					                        	<div class="col-md-10">
					                        	<div class="row">
					                        		<div class="col-md-6">
					                        			<div class="form-group">
											              <label>Employment Type<span class="text-danger"><big>*</big></span></label>
										                    <select name="employmentType" id="employmentType" class="form-control input-lg" required>
										                    	@if(!empty($fillUpForm))
												              		<option value="{{$fillUpForm->id}}">{{$fillUpForm->employmentType}}</option>
												              	@else
												              		<option value="">Select Employment Type</option>
												              	@endif
												                @foreach($employmentType as  $type)
												                    <option value="{{$type->id}}" {{(old("employmentType") == "$type->id" ? "selected":"")}}>{{$type->employmentType}}</option>
											                    @endforeach
											                </select>
											            </div> 
					                        		</div>
					                        		<div class="col-md-6">
					                        			<div class="form-group row">
						                        			<div class="col-md-6">
													              <label>Grade Level <span class="text-danger"><big>*</big></span></label>
												                    <select name="grade" id="grade" class="form-control input-lg" required>
												                    	@if($fillUpForm != '')
														              		<option value="{{$fillUpForm->grade}}">{{$fillUpForm->grade}}</option>
														              	@else
														              		<option value="">Select Grade</option>
														              	@endif
														                @for($i = 1; $i <= 17; $i++)
														                    <option value="{{$i}}" {{(old("grade") == "$i" ? "selected":"")}}>{{$i}}</option>
													                    @endfor
													                </select>
												            	</div>
												        		<div class="col-md-6">
													              <label>Step <span class="text-danger"><big>*</big></span></label>
												                     <select name="step" id="step" class="form-control input-lg" required>
													                    @if($fillUpForm != '')
														              		<option value="{{$fillUpForm->step}}">{{$fillUpForm->step}}</option>
														              	@else
														              		<option value="">Select Step</option>
														              	@endif
													                    @for($i = 1; $i <= 15; $i++)
														                    <option value="{{$i}}" {{(old("step") == "$i" ? "selected":"")}}>{{$i}}</option>
													                    @endfor
												                    </select>
													            </div>
													    </div>
					                        		</div>
					                        	</div>
					                        	<div class="row">
					                        		<div class="col-md-6">
					                        			<div class="form-group">
											              <label>Department <span class="text-danger"><big>*</big></span></label>
											           
											              	<select name="department" id="department" class="form-control input-lg" required>
												              	 @if(!empty($fillUpForm))
													              	<option value="{{$fillUpForm->departmentID}}">{{$fillUpForm->department}}</option>
													             @else
													              	<option value="" selected="selected">Select Department</option>
												              	@endif
											                  
											                  	@if($departments != null)
												                  @foreach($departments as $div)
												                  <option value="{{$div->id}}" {{(old("department") == "$div->id" ? "selected":"") }}>
												                  	{{$div->department}}
												                  </option>
												                  @endforeach
											                  	@endif	                
											                </select>
											            </div>
					                        		</div>
					                        		<div class="col-md-6">
					                        			<div class="form-group">
											              <label>Designation</label>
											               <select class="form-control input-lg" id="designation" name="designation" required>
											                       @if(!empty($fillUpForm))
													              	<option value="{{$fillUpForm->departmentID}}">{{$fillUpForm->designation}}</option>
													             @else
													                <option value="">-No Record-</option>
												              	@endif
                                                                   
                                                                    @foreach($designation as $list)
                                                            			@if($list->id==old('designation'))
                                                            			  <option value="{{ $list->courtID}}" {{(old('designation') == $list->courtID) ? "selected" : ""}}>{{$list->designation}}</option>  
                                                            			@else
                                                            			@endif
                                                            				     		   
                                                            		@endforeach  
                                                                
                                		                	</select>  
											             	<span id='processing'></span>
											            </div>
									                </div>
					                        	</div>
					                        	<div class="row">
					                        		<div class="col-md-6">
					                        			 <div class="form-group">
											              <label>Date of Appointment <span class="text-danger"><big>*</big></span></label>
											              	@if($staffInfo != '')
													        	<input type="text" readonly name="presentAppointment2" id="presentAppointment1" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($staffInfo->date_present_appointment)) }}" required />
													        	<input type="hidden" name="presentAppointment" id="presentAppointment" value="{{$staffInfo->date_present_appointment}}">  
													      	@else
													          <input type="date" name="presentAppointment2" id="presentAppointment2" class="form-control input-lg" value="{{ old('presentAppointment2') }}" required /> 
													          <input type="hidden" name="presentAppointment" id="presentAppointment" value="{{ old('presentAppointment') }}"/>
													       	@endif  
											            </div>
					                        		</div>
					                        		<div class="col-md-6">
					                        			<div class="form-group">
											              <label>Date of first Appointment <span class="text-danger"><big>*</big></span></label>
											               @if($staffInfo != '')
													        	<input type="text" readonly name="firstAppointment2" id="firstAppointment1" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($staffInfo->appointment_date)) }}" required />
													        	<input type="hidden" name="firstAppointment" id="firstAppointment" value="{{$staffInfo->appointment_date}}"> 
													      	@else
													          	<input type="date" name="firstAppointment2" id="firstAppointment2" class="form-control input-lg" value="{{ old('firstAppointment2') }}" required />
													          	<input type="hidden" name="firstAppointment" id="firstAppointment" value="{{ old('firstAppointment') }}" />   
													       	@endif
											              
											            </div>
									                </div>
					                        	</div><!--//row 2-->
					                        </div>
					                    </div>
					                        </p>
	</p>
	<hr />
	<div align="center">
		<ul class="list-inline">
			
			<li>
				<button type="submit" class="btn btn-primary">Save and continue</button><!--next-step-->
			</li>
		</ul>
	</div>
</div>
</form>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

<script>

$(document).ready(function(){

    $("#department").change(function(e){
    
        //console.log(e);
        var dept_id = e.target.value;
       // var state_id = $(this).val();
        
        //alert(dept_id);
        //$token = $("input[name='_token']").val();
        //ajax
        $.get('get-designation?dept_id='+dept_id, function(data){
         $('#designation').empty();
        //console.log(data);
        //$('#lga').append( '<option value="">Select</option>' );
        $.each(data, function(index, obj){
        $('#designation').append( '<option value="'+obj.courtID+'">'+obj.designation+'</option>' );
        });
        
        
        })
    });
    

});
 

</script>

<script>

 $(document).ready(function () {
        $('input[id$=presentAppointment1]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });


 $(document).ready(function () {
        $('input[id$=presentAppointment2]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=firstAppointment1]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=firstAppointment2]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=dob]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
  $(document).ready(function () {
        $('input[id$=dob2]').datepicker({
            dateFormat: 'dd-mm-yy'			// Date Format "dd-mm-yy"
        });
  });
  
</script>
									   
													
	