						<form action="{{url('/staff-registration/contact-info')}}" method="POST">
        							{{csrf_field()}}
					                    <div class="tab-pane" role="tabpanel" id="step3">
					                        <div class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-envelope"></i> <b>Contact Address</b>
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
												              <label>Email <span class="text-danger"><big>*</big></span></label>
												              	@if($fillUpForm != '')
												              		<input type="email" name="email" id="email" class="form-control input-lg" value="{{$fillUpForm->email}}" required />
												              	@else
												              		<input type="email" name="email" id="email" class="form-control input-lg" value="{{ old('email') }}" required />  
												              	@endif
												            </div>
						                        		</div>
						                        		<div class="col-md-6">
						                        			 <div class="form-group">
												              <label>Alternate Email</label>
												              	@if($fillUpForm != '')
												              		<input type="email" name="alternateEmail" id="alternateEmail" class="form-control input-lg" value="{{$fillUpForm->alternate_email}}" />
												              	@else
												              		<input type="email" name="alternateEmail" id="alternateEmail" class="form-control input-lg" value="{{ old('alternateEmail') }}" />  
												              	@endif
												            </div>
						                        		</div>
						                        	</div>
						                        	<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
							                        		  <label>Phone Number <span class="text-danger"><big>*</big></span></label>
							                        		    @if($fillUpForm != '')
												              		<input type="number" name="phone" id="phone" class="form-control input-lg" value="{{$fillUpForm->phone}}" required/> 
												              	@else
												              		<input type="number" name="phone" id="phone" class="form-control input-lg" value="{{ old('phone') }}" required/> 
												              	@endif
												               
												            </div>
										                </div>
										                <div class="col-md-6">
										                	<div class="form-group">
						                        				<label>Alternative Phone Number</label>
						                        				 @if($fillUpForm != '')
												              		<input type="number" name="atternativePhone" id="atternativePhone" class="form-control input-lg" value="{{$fillUpForm->alternate_phone}}" /> 
												              	@else
												              		<input type="number" name="atternativePhone" id="atternativePhone" class="form-control input-lg" value="{{ old('atternativePhone') }}" /> 
												              	@endif
											              	</div> 
					                        			</div>
						                        	</div><!--//row 1-->
					                        		<div class="row">
						                        		<div class="col-md-6">
						                        			<div class="form-group">
							                        			<label>Present Address</label>
							                        			@if($fillUpForm != '')
												              		<textarea name="physicalAddress" id="physicalAddress" class="form-control input-lg">{{$fillUpForm->home_address}}</textarea>
												              	@else
												              		<textarea name="physicalAddress" id="physicalAddress" class="form-control input-lg">{{ old('physicalAddress') }}</textarea>
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
						                            <li><a href="{{route('getBasicTab')}}" class="btn btn-default">Previous</a></li>
						                            <li><button type="submit" class="btn btn-primary">Save and continue</button></li>
						                        </ul>
						                    </div>
					                    </div>
					        </form>