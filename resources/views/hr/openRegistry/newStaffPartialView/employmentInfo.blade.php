							<form action="{{url('/staff-registration/employment-info')}}" method="POST">
        							{{csrf_field()}}
					               		<div class="tab-pane" role="tabpanel" id="step4">
					                        <div class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-folder-open"></i> <b> Employment Information</b>
					                        	</h3>
					                        	<div align="right" style="margin-top: -35px;"> 
					                        		Field with <span class="text-danger"><big>*</big></span> is important
					                        	</div>
					                    	</div>
					                    	<br />
					                        <p>
					                        	<div class="row">
					                        	<div class="col-md-8 col-md-offset-2">
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
												              	 @if($fillUpForm != '')
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
											               @if($fillUpForm != '')
													            <input type="text" name="designation" id="designation"  class="form-control input-lg" placeholder="Designation" value="{{$getDesignation}}" readonly>
													        @else
													           <input type="text" name="designation" class="form-control input-lg" placeholder="Designation" id="designation" readonly>
													       @endif  
											             	<span id='processing'></span>
											            </div>
									                </div>
					                        	</div>
					                        	<div class="row">
					                        		<div class="col-md-6">
					                        			 <div class="form-group">
											              <label>Date of Appointment <span class="text-danger"><big>*</big></span></label>
											              	@if($fillUpForm != '')
													        	<input type="text" readonly name="presentAppointment2" id="presentAppointment2" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($fillUpForm->date_present_appointment)) }}" required />
													        	<input type="hidden" name="presentAppointment" id="presentAppointment" value="{{$fillUpForm->date_present_appointment}}">  
													      	@else
													          <input type="text" readonly name="presentAppointment2" id="presentAppointment2" class="form-control input-lg" value="{{ old('presentAppointment2') }}" required /> 
													          <input type="hidden" name="presentAppointment" id="presentAppointment" value="{{ old('presentAppointment') }}"/>
													       	@endif  
											            </div>
					                        		</div>
					                        		<div class="col-md-6">
					                        			<div class="form-group">
											              <label>Date of first Appointment <span class="text-danger"><big>*</big></span></label>
											               @if($fillUpForm != '')
													        	<input type="text" readonly name="firstAppointment2" id="firstAppointment2" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($fillUpForm->appointment_date)) }}" required />
													        	<input type="hidden" name="firstAppointment" id="firstAppointment" value="{{$fillUpForm->appointment_date}}"> 
													      	@else
													          	<input type="text" readonly name="firstAppointment2" id="firstAppointment2" class="form-control input-lg" value="{{ old('firstAppointment2') }}" required />
													          	<input type="hidden" name="firstAppointment" id="firstAppointment" value="{{ old('firstAppointment') }}" />   
													       	@endif
											              
											            </div>
									                </div>
					                        	</div><!--//row 2-->
					                        </div>
					                    </div>
					                        </p>
					                        <hr />
					                         <div align="center">
						                        <ul class="list-inline">
						                            <li>
						                            	<a href="{{route('getContactTab')}}" class="btn btn-default">Previous</a>
						                            </li>
						                            <li>
						                            	<button type="submit" class="btn btn-primary btn-info-full">Save and continue</button>
						                            </li>
						                        </ul>
						                     </div>
					                    </div>
					          </form>