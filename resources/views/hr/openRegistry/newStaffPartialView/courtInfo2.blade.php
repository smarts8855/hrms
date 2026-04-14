							<form action="{{url('/staff-registration/court')}}" method="POST">
        					{{csrf_field()}}
					                <div class="tab-content">
					                	 <div class="tab-pane active" role="tabpanel" id="step1">
					                        <div class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-briefcase"></i> <b>Court Information</b>
					                        	</h3>
					                        	<div align="right" style="margin-top: -35px;"> 
					                        		Field with <span class="text-danger"><big>*</big></span> is important
					                        	</div>
					                    	</div>
					                    	<br />
					                        <p>
					                        	<div class="row">
					                        		<div class="col-md-5 col-md-offset-3">
					                        			<div class="form-group">
											              <label><big>Court <big class="text-danger">*</big></big></label>
											              <select name="courtName" id="getcourt" class="form-control input-lg" required>
											              	@if($fillUpForm != '')
											              		<option value="{{$fillUpForm->courtID}}" selected="selected">{{$fillUpForm->court_name}}</option>
											              	@endif
											                  <option value="@if($getCourtDetails != "") {{$getCourtDetails->id}} @endif" selected="selected">
											                  	@if($getCourtDetails != "") {{$getCourtDetails->court_name}} @else Select Court @endif
											                  </option>
											                  @if($getcourts != null)
											                  @foreach($getcourts as $div)
											                  <option value="{{$div->id}}">{{$div->court_name}}</option>
											                  @endforeach
											                  @endif
											               </select>
											            </div> 
					                        			<div class="form-group">
											              <label><big>Division <big class="text-danger">*</big></big></label>
											               <select name="division" id="division" class="form-control input-lg" required>
											               	@if($fillUpForm != '')
											              		<option value="{{$fillUpForm->divisionID}}" selected="selected">{{$fillUpForm->division}}</option>
											              	@endif
											                  <option value="@if($getDivisionDetails != "") {{$getDivisionDetails->divisionID}} @endif" selected="selected">@if($getDivisionDetails != "") {{$getDivisionDetails->division}} @else Select Division @endif</option>
											                </select>
											            </div> 
										          </div>
					                        	</div><!--//row 1-->
					                        </p>
					                        <hr />
					                        <div align="center">
						                        <ul class="list-inline">
						                            <li>
						                            	<button type="submit" class="btn btn-primary">Continue</button><!-- next-step-->
						                            </li>
						                        </ul>
					                    	</div>
					                    </div>
					         </form>