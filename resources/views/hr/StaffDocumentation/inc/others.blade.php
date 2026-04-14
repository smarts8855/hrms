<form action="{{url('/staff-documentation-others')}}" method="POST" id="othersForm">
{{csrf_field()}}
	<div class="tab-pane" role="tabpanel" id="step3">
		<div class="col-md-offset-0">
			<h3 class="text-success text-center">
				<i class="glyphicon glyphicon-envelope"></i> <b>Other information</b>
			</h3>
			<div align="right" style="margin-top: -35px;"> 
				Field with <span class="text-danger"><big>*</big></span> is important
			</div>
		</div>
		<br />
		<p>
			<div class="row">
				<div class="row col-md-offset-1">
					                        		
					<div class="col-md-12">
					<label>1. Have you ever been convicted for any crime before? <span class="text-danger"><big>*</big></span></label>
					@if($otherInfo == '')
					   <select class="form-control input-lg" onchange="givereason(this.id)" id="convict" name="convict" required>
							   <option value="" >select answer</option>
							   <option value="yes">Yes</option>
							   <option value="no">No</option>
					   </select>
					  @else
						  <select class="form-control input-lg" onchange="givereason(this.id)" id="convict" name="convict" required>
							   <option value="" >select answer</option>
							   <option {{ ( $otherInfo->qtn1 == 'yes' ? 'selected' : '') }} value="yes">Yes</option>
							   <option {{ ( $otherInfo->qtn1 == 'no'  ? 'selected' : '') }} value="no">No</option>
					   </select>
					  @endif
						
					</div>
					<div class="col-md-12" id="convict-reason" style="display: none">
					<label>2. Please state details?</label>
					@if($otherInfo == '')
						<textarea  class="form-control input-lg"  name="convict-reason"></textarea>
					@else
						<textarea  class="form-control input-lg"  name="convict-reason">{{ $otherInfo->qtn2 }}</textarea>
					@endif
					</div>

					<div class="col-md-12">
					<label>3. Have you suffered any illness?</label>
					@if($otherInfo == '')
					   <select class="form-control input-lg" onchange="givereason(this.id)" id="illness" name="illness" >	
					   		   <option value="">select answer</option>
							   <option value="yes">Yes</option>
							   <option value="no">No</option>
					   </select>
					 @else
						 <select class="form-control input-lg" onchange="givereason(this.id)" id="illness" name="illness" >   
						 	   <option value="">select answer</option>
							   <option {{ ( $otherInfo->qtn3 == 'yes' ? 'selected' : '') }} value="yes">Yes</option>
							   <option {{ ( $otherInfo->qtn3 == 'no' ? 'selected' : '') }} value="no">No</option>
					   </select>
					 @endif
					</div>

					<div class="col-md-12" id="illness-reason" style="display: none">
					<label>4. Please state details?</label>
					@if($otherInfo == "")
					  <textarea  class="form-control input-lg"  name="illness-reason"></textarea>
					@else
						<textarea  class="form-control input-lg"  name="illness-reason">{{ $otherInfo->qtn4 }}</textarea>
					@endif
					</div>

					<div class="col-md-12">
					<label>5. Have you taken an undertaken to anybody to repay money advance from education, etc?</label>
					@if($otherInfo == '')
					   <select class="form-control input-lg"  id="repay" name="repay" >
							   <option value="">select answer</option>
							   <option value="yes">Yes</option>
							   <option value="no">No</option>
					   </select>
					 @else
						 <select class="form-control input-lg"  id="repay" name="repay" >
							   <option value="">select answer</option>
							   <option {{ ( $otherInfo->qtn5 == 'yes' ? 'selected' : '') }}  value="yes">Yes</option>
							   <option {{ ( $otherInfo->qtn5 == 'no' ? 'selected' : '') }}  value="no">No</option>
					   </select>
					 @endif
					</div>
					
				</div><!--//row 1-->

				<div class="row col-md-offset-1">
					                        		
					<div class="col-md-12">
					<label>6. Are you a judgement Debtor? or are there any write from debts outstanding against you?</label>
					@if($otherInfo == '')
					   <select class="form-control input-lg"  id="jugdement" name="jugdement" onchange="givereason(this.id)" >
							   <option value="">select answer</option>
							   <option value="yes">Yes</option>
							   <option value="no">No</option>
					   </select>
					@else
					
						<select class="form-control input-lg"  id="jugdement" name="jugdement" onchange="givereason(this.id)" >
							   <option value="">select answer</option>
							   <option {{ ( $otherInfo->qtn6 == 'yes' ? 'selected' : '') }}  value="yes">Yes</option>
							   <option {{ ( $otherInfo->qtn6 == 'no' ? 'selected' : '') }}  value="no">No</option>
					   </select>
					@endif
				
					   <!---->
					</div>

					<div class="col-md-12" id="judgement-reason" style="display: none">
					<label>7. Please state details?</label>
					@if($otherInfo == '')
					  <textarea  class="form-control input-lg"  name="judgement-reason"></textarea>
					@else
					
						<textarea  class="form-control input-lg"  name="judgement-reason">{{ $otherInfo->qtn7 }}</textarea>
					@endif
					
					</div>

					<div class="col-md-12">
					<label>8. Official Employees details of services in the forces (if applicable)</label>
					@if($otherInfo == '')
					   <textarea  class="form-control input-lg" id="detail-in-force" name="detail-in-force"></textarea> 
					@else
					<textarea   class="form-control input-lg" id="detail-in-force" name="detail-in-force">{{ $otherInfo->qtn8 }}</textarea>
					@endif 
					 
					</div>
					<div class="col-md-12">
					<label>Decoration</label>
					@if($otherInfo == '')
					   <textarea  class="form-control input-lg" id="decoration" name="decoration"></textarea>
					@else
					
						<textarea  class="form-control input-lg" id="decoration" name="decoration">{{ $otherInfo->qtn9 }}</textarea>
					@endif
					
					</div>

					<div class="col-md-12">
					<label>9. What is your religion? <span class="text-danger"><big>*</big></span></label>
					@if($otherInfo != null)
					<select name="religion" id="changeReligion" name="religion" class="form-control input-lg" value="" required>
								  <option value="" selected>Select</option>
								  @foreach($religions as $faith)
								  <option value="{{$faith->Religion}}" {{$otherInfo->qtn10==$faith->Religion? "selected":""}}>{{$faith->Religion}}</option>
								  @endforeach
		              		</select>	
		           @else
		              		
					<select name="religion" id="changeReligion" name="religion" class="form-control input-lg" value="" required>
								  <option value="" selected>Select</option>
								  @foreach($religions as $faith)
								  <option value="{{$faith->Religion}}">{{$faith->Religion}}</option>
								  @endforeach
								  </select>
					@endif
					</div>

					<div class="col-md-12">
					@if($otherInfo == '')
					   <input type="checkbox" class="form-check-input "  id="agree" name="agree" >
					@else
					
						<input  type="checkbox" {{ ( $otherInfo->qtn11 == 'null' ? '' : 'checked') }} class="form-check-input "  id="agree" name="agree">
					@endif
					<label for="agree"> I hereby certify on honour that the information given over the above area are true and correct to the best of my knowledge <span class="text-danger"><big>*</big></span></label>
					
					
					</div>
				</div><!--//row 1-->
		</div>
		</p>
		<hr />
		<div align="center">
			<ul class="list-inline">
				<li><a href="{{url('/staff-documentation-account')}}" class="btn btn-default">Previous</a></li>
				<li><button type="submit" class="btn btn-primary">Save and continue</button></li>
				
			</ul>
		</div>
	</div>
	</form>