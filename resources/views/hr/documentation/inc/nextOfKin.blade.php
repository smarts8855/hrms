<form action="{{url('/documentation-nextofkin')}}" method="POST">
		{{csrf_field()}}
			<div class="tab-pane" role="tabpanel" id="step3">
				<div class="col-md-offset-0">
					<h3 class="text-success text-center">
						<i class="glyphicon glyphicon-envelope"></i> <b>Next of Kin</b>
					</h3>
					<div align="right" style="margin-top: -35px;"> 
						Field with <span class="text-danger"><big>*</big></span> is important
					</div>
				</div>
				<br />
				<p>
				@php $i=1; @endphp
				@foreach($nextOfKins as $nextOfKin)
					<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="row">
							<div class="col-md-6">
									<div class="form-group">
									<label>Full Name <span class="text-danger"><big>*</big></span></label>
									
										<input type="text" name="fullName[{{$i}}]" id="fullName" class="form-control input-lg" value="{{$nextOfKin->fullname}}" required />
									
								</div>
							</div>
							
							<div class="col-md-6">
									<div class="form-group">
										<label>Phone Number <span class="text-danger"><big>*</big></span></label>
										
												<input type="number" name="phoneNumber[{{$i}}]" id="phoneNumber" class="form-control input-lg" value="{{$nextOfKin->phoneno}}" required/> 
										
										
									</div>
								</div>
							
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Resident Address</label>
									
										<textarea name="physicalAddress[{{$i}}]" id="physicalAddress" class="form-control input-lg">{{$nextOfKin->address}}</textarea>
									
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Relationship <span class="text-danger"><big>*</big></span></label>
									
										<select type="text" id="relationship" name="relationship[{{$i}}]"  class="formex form-control input-lg"  required>
											<option value="">Select</option>
											@foreach($relationship as $b)
												<option value="{{$b->relationship}}" {{ ($nextOfKin->relationship == $b->relationship || old("relationship") == $b->relationship )? "selected" :"" }}>{{$b->relationship}} </option>
													@endforeach
											</select>
									
									
								</div> 
							</div>
						</div><!--//row 2-->
					</div>
				</div>
				@php $i+=1; @endphp
				@endforeach
				</p>
				<hr />
				<div align="center">
					<ul class="list-inline">
						<li><a href="{{url('/documentation-marital-status')}}" class="btn btn-default">Previous</a></li>
						<li><button type="submit" class="btn btn-primary">Save and continue</button></li>
					</ul>
				</div>
			</div>
</form>