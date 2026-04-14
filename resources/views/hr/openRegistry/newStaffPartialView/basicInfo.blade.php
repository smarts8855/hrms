							<form action="{{url('/staff-registration/basic-info')}}" method="POST">
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
					                        <p>
					                           <div class="row">
					                        	  <div class="col-md-8 col-md-offset-2">
					                        	  	<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
												                <label>Title</label>
												                <select name="title" id="title" class="form-control input-lg">
													                @if($fillUpForm != '')
												              			<option value="{{$fillUpForm->title}}" selected>{{$fillUpForm->title}}</option>
												              		@else
												              			<option value="" selected="selected">Select</option>
												              		@endif
												              		@foreach($getTitle as $title)
													                  <option value="{{$title->ID}}" {{ (old("title") == "MR." ? "selected":"") }}>{{$title->title}}</option>
													                @endforeach
												                </select>
										                	</div>
						                        		</div>
						                        		<div class="col-md-6">
						                        			<div class="form-group">
											                   <label>Surname <big class="text-danger">*</big></label>
											                   @if($fillUpForm != '')
											                   		<input type="text" name="surname" id="surname" class="form-control input-lg" value="{{$fillUpForm->surname}}" required />
												              	@else
												              		 <input type="text" name="surname" id="surname" class="form-control input-lg" value="{{ old('surname') }}" required />
												              	@endif
											                  
											               </div>
						                        		</div>
					                        		</div>
					                        	    <div class="row">
					                        	    	<div class="col-md-6">
						                        			<div class="form-group">
												                <label>First name <big class="text-danger">*</big></label>
												                @if($fillUpForm != '')
											                   		<input type="text" name="firstName" id="firstName" class="form-control input-lg" value="{{$fillUpForm->first_name}}" required />
												              	@else
												              		 <input type="text" name="firstName" id="firstName" class="form-control input-lg" value="{{ old('firstName') }}" required />
												              	@endif
											                </div> 
						                        		</div>
						                        		<div class="col-md-6">
						                        			<div class="form-group">
												              <label>Other Names</label>
												              	@if($fillUpForm != '')
											                   		<input type="text" name="otherNames" id="otherNames" class="form-control input-lg" value="{{$fillUpForm->othernames}}" />
												              	@else
												              		<input type="text" name="otherNames" id="otherNames" class="form-control input-lg" value="{{ old('otherNames') }}" />  
												              	@endif
												             
												            </div>
										                </div>
					                        	    </div>
					                        	</div><!--//row 2-->
					                        </div>
					                        	<div class="row">
					                        	  <div class="col-md-8 col-md-offset-2">
					                        		<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
												              <label>Gender <big class="text-danger">*</big></label>
												              <select name="gender" id="gender" class="form-control input-lg" required>
												               		@if($fillUpForm != '')
												              			<option value="{{$fillUpForm->gender}}" selected="selected">{{$fillUpForm->gender}}</option>
												              		@else
												              			<option value="" selected="selected">Select</option>
												              		@endif
												                  <option value="Male" {{ (old("gender") == "Male" ? "selected":"") }}>Male</option>
												                  <option value="Female" {{ (old("gender") == "Male" ? "selected":"") }}>Female</option>
												                </select>
												            </div> 
										                </div>
										                <div class="col-md-6">
						                        			<div class="form-group">
												              <label>Marital Status <big class="text-danger">*</big></label>
												              <select name="maritalStatus" id="maritalStatus" class="form-control input-lg" required>
												              		@if($fillUpForm != '')
												              			<option value="{{$fillUpForm->maritalstatus}}" selected="selected">{{$fillUpForm->maritalstatus}}</option>
												              		@else
												              			<option value="" selected="selected">Select</option>
												              		@endif
												                  
												                  <option value="Single" {{ (old("maritalStatus") == "Single" ? "selected":"") }}>Single</option>
												                  <option value="Married" {{ (old("maritalStatus") == "Married" ? "selected":"") }}>Married</option>
												                  <option value="Widowed" {{ (old("maritalStatus") == "Widowed" ? "selected":"") }}>Widowed</option>
												                   <option value="Divorced" {{ (old("maritalStatus") == "Divorced " ? "selected":"") }}>Divorced</option>
												                </select>
												            </div> 
										                </div>
					                        		</div>
					                        	</div>
					                        	<div class="row">
					                        		<div class="col-md-8 col-md-offset-2">
					                        			<div class="col-md-6">
						                        			<div class="form-group">
												              <label>Date of Birth <big class="text-danger">*</big></label>
												                @if($fillUpForm != '')
												                	<input type="text" readonly name="dob" id="getDateofBirth" class="form-control input-lg" value="{{ date('d-m-Y', strtotime($fillUpForm->dob)) }}" placeholder="Select" required /> 
												                	<input type="hidden" name="dateOfBirth" id="dateOfBirth" value="{{$fillUpForm->dob}}"> 
												              	@else
												              		<input type="text" readonly name="dob" id="getDateofBirth" class="form-control input-lg" value="{{ old('dob') }}" placeholder="Select" required /> 
												              		<input type="hidden" name="dateOfBirth" id="dateOfBirth"> 
												              	@endif
												              		
												            </div>
						                        		</div>
						                        		<div class="col-md-6">
						                        			<div class="form-group">
											                   <label>Place of Birth </label>
											                   @if($fillUpForm != '')
												                	<input type="text" name="placeOfBirth" id="placeOfBirth" class="form-control input-lg" value="{{$fillUpForm->placeofbirth}}"/> 
												              	@else
												              		<input type="text" name="placeOfBirth" id="placeOfBirth" class="form-control input-lg" value="{{ old('placeOfBirth') }}" />
												              	@endif
											               </div>
						                        		</div>
									            	</div>
									            </div>
					                        	</div><!--//row 3-->
					                        </p>
					                        <hr />
					                        <div align="center">
						                        <ul class="list-inline">
						                        	 <!--<li>
						                        	 	<a href="{{route('newStaff_court')}}" class="btn btn-default">Previous</a>
						                        	 </li>--><!--prev-step-->
						                            <li>
						                            	<button type="submit" class="btn btn-primary">Save and continue</button><!--next-step-->
						                            </li>
						                        </ul>
					                    	</div>
					                    </div>
					                   </form>