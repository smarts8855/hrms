<form action="{{url('/staff-documentation-placeofbirth')}}" method="POST">
		{{csrf_field()}}
			<div class="tab-pane" role="tabpanel" id="step3">
				<div class="col-md-offset-0">
					<h3 class="text-success text-center">
						<i class="glyphicon glyphicon-envelope"></i> <b>State of Origin</b>
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
									<label>State of Origin <span class="text-danger"><big>*</big></span></label>
									@if($staffInfo !=='')
										<select type="text" id="states" name="state"  class="formex form-control input-lg" required >
											<option value="">Select State</option>
											@foreach($StateList as $b)
												<option value="{{$b->StateID}}" {{ ($staffInfo->stateID == $b->StateID || old("state") == $b->StateID )? "selected" :"" }}>{{$b->State}} </option>
													@endforeach
											</select>
									@else
									<select type="text" id="states" name="state" class="formex form-control input-lg"  required>
										<option value="">Select State</option>
										<option value="">Select State</option>
											@foreach($StateList as $b)
										<option value="{{$b->StateID}}" {{ (old('state') == $b->StateID)? "selected":"" }}>{{$b->State}} </option>
													@endforeach
									</select>

										  
									  @endif
								  </div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
								  <label>L.G.A <span class="text-danger"><big>*</big></span></label>
									   @if($staffInfo !== '')
								  <select type="text" id="lga"  name="lga"  class="form-control input-lg formex" required>
									
									@foreach($Lga as $l)
									  	<option value="{{$l->lgaId}}" {{ ($staffInfo->lgaID == $l->lgaId || old("lga") == $l->lgaId )? "selected" :"" }}>{{$l->lga}} </option>
									  	@endforeach
									</select>
									@else
									<select type="text" id="lga"  name="lga"  class="form-control input-lg formex" >
									
								   
									</select>
									@endif
								</div>

							</div>
						
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Address <span class="text-danger"><big>*</big></span></label></label>
									@if($staffInfo !== '')
								<textarea name="address" id="address" class="form-control input-lg" required>{{$staffInfo->placeofbirth}}</textarea>
									@else
										<textarea name="address" id="address" class="form-control input-lg" required>{{ old('address') }}</textarea>
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
						<li><a href="{{url('/staff-documentation-contact')}}" class="btn btn-default">Previous</a></li>
						<li><button type="submit" class="btn btn-primary">Save and continue</button></li>
					</ul>
				</div>
			</div>
</form>