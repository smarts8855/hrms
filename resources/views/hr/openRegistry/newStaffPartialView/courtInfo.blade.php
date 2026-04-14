							<form action="{{url('/staff-registration/court')}}" method="POST">
        					{{csrf_field()}}
					                <div class="tab-content">
					                	 <div class="tab-pane active" role="tabpanel" id="step1">
					                        <div class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-briefcase"></i> <b>Council Information</b>
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
											              <label><big>Council <big class="text-danger">*</big></big></label>
											              <select name="courtName" id="getcourt" class="form-control input-lg" required>
											                  @if($getcourts != null)
    											                  @foreach($getcourts as $div)
    											                    <option value="{{$div->id}}" {{ ($div == isset($fillUpForm) && $fillUpForm ? $fillUpForm->courtID : '') ? 'selected' : '' }} >{{$div->court_name}}</option>
    											                  @endforeach
											                  @endif
											               </select>
											            </div> 
											            <input type="hidden" value="15" id="division" name="division" />
											           <!--
					                        			<div class="form-group">
											              <label><big>Location <big class="text-danger">*</big></big></label>
											               <select name="division-old" id="division-old" class="form-control input-lg" required>
											                   <option value="15">Select Council</option>
											               	@if($fillUpForm != '')
											              		<option value="{{$fillUpForm->divisionID}}">{{$fillUpForm->division}}</option>
											              	@endif
											                  <option value="@if($getDivisionDetails != "") {{$getDivisionDetails->divisionID}} @endif" selected="selected">@if($getDivisionDetails != "") {{$getDivisionDetails->division}} @else Select Location @endif</option>
											                </select>
											            </div> -->
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