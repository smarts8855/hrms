							<form action="{{url('/staff-registration/employment-info')}}" method="POST">
        							{{csrf_field()}}
					               		<div class="tab-pane" role="tabpanel" id="step4">
					                        <div align="left" class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-ok"></i> <b> Registration Complete</b>
					                        	</h3>
					                    	</div>
					                    	<br />
					                        <p>
					                        	<div class="row">
					                        	<div class="col-md-8 col-md-offset-2">
					                        	<div class="row">
					                        		<div class="col-md-12">

					                        			<div class="row">
					                        				<div class="col-md-6">
					                        					<div class="panel panel-default">
																	<div class="panel-heading fieldset-preview"><b>STAFF PICTURE</b></div>
																		<div align="center" class="panel-body">
																			@if($getPreviewInfo != '')
														           				<img src="{{asset('passport/'.$getPreviewInfo->picture)}}" class="thombnail responsive" height="180" alt=" ">
														           			@else
														           				<img src="{{asset('passport/default.png')}}" class="thombnail responsive" height="180" alt=" ">
														           			@endif
														           			<hr />
														           			<div>
														           				<a href="{{url('/staff-registration/browse-picture')}}" class="btn btn-default btn-sm">Update Photography</a>
														           			</div>
																		<div class="clearfix"></div>
														            </div> 
																</div>
					                        				</div>
					                        				<div class="col-md-6">
					                        					<div class="panel panel-default">
																	<div class="panel-heading fieldset-preview"><b>STAFF FINGERPRINT</b></div>
																		<div align="center" class="panel-body">
														           			<img src="{{asset('fingerprint/default-fingerprint.png')}}" class="thombnail responsive" height="180">
														           			<hr />
														           			<div>
														           				<a href="{{url('#')}}" class="btn btn-default btn-sm">Update FingerPrint</a>
														           			</div>
																		<div class="clearfix"></div>
														            </div> 
																</div>
					                        				</div>
					                        			</div>

														<div class="panel panel-default">
															<div class="panel-heading fieldset-preview"><b>COURT INFORMATION</b></div>
																<div class="panel-body">
												           		<table class="table table-striped table-hover table-responsive table-condensed">
						                        					<tbody class="btn-lg">
							                        					<tr>
							                        						<td width="210"><b>FILE NO.: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->fileNo)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>COURT: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->court_name)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>DIVISION: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->division)}}</td>
							                        					</tr>
						                        					</tbody>
					                        					</table>
																<div class="clearfix"></div>
												            </div> 
														</div>

														<div class="panel panel-default">
															<div class="panel-heading fieldset-preview"><b>BASIC INFORMATION</b></div>
																<div class="panel-body">
												           		<table class="table table-striped table-hover table-responsive table-condensed">
						                        					<tbody class="btn-lg">
							                        					<tr>
							                        						<td width="210"><b>TITLE: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->title)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>SURNAME: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->surname)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>FIRST NAME: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->first_name)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>OTHER NAME: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->othernames)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>GENDER: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->gender)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>MARITAL STATUS: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->maritalstatus)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>DATE OF BIRTH: </b></td>
							                        						<td>{{strtoupper(date('d-m-Y', strtotime($getPreviewInfo->dob)))}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>PLACE OF BIRTH: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->placeofbirth)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td colspan="2">
							                        							 <a href="@if(Session::get('fileNo')) {{route('getBasicTab')}} @else # @endif" id="tab" title="Basic Info." class="pull-right">
							                        							 	<i class="glyphicon glyphicon-pencil"></i>
							                        							 </a>
							                        						</td>
							                        					</tr>
						                        					</tbody>
					                        					</table>
																<div class="clearfix"></div>
												            </div> 
														</div>

														<div class="panel panel-default">
															<div class="panel-heading fieldset-preview"><b>EMPLOYMENT INFORMATION</b></div>
																<div class="panel-body">
												           		<table class="table table-striped table-hover table-responsive table-condensed">
						                        					<tbody class="btn-lg">
						                        						<tr>
							                        						<td width="210"><b>EMPLOYEE TYPE: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->employmentType)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td width="210"><b>DEPARTMENT: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->department)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>GRADE:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$getPreviewInfo->grade}}</td>
							                        						<td><b>STEP: </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$getPreviewInfo->step}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>DESIGNATION: </b></td>
							                        						<td>@if($userDesignation) {{strtoupper($userDesignation->designation_name)}} @endif</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>PRESENT APPOINTMENT: </b></td>
							                        						<td>{{ date('d-m-Y', strtotime($getPreviewInfo->date_present_appointment)) }}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>FIRST APPOINTMENT: </b></td>
							                        						<td>{{ date('d-m-Y', strtotime($getPreviewInfo->appointment_date)) }}</td>
							                        					</tr>
							                        					<tr>
							                        						<td colspan="2">
							                        							 <a href="@if(Session::get('fileNo')) {{route('getEmploymentTab')}} @else # @endif" id="tab" title="Employment Info." class="pull-right">
							                        							 	<i class="glyphicon glyphicon-pencil"></i>
							                        							 </a>
							                        						</td>
							                        					</tr>
						                        					</tbody>
					                        					</table>
																<div class="clearfix"></div>
												            </div> 
														</div>

														<div class="panel panel-default">
															<div class="panel-heading fieldset-preview"><b>CONTACT INFORMATION</b></div>
																<div class="panel-body">
												           		<table class="table table-striped table-hover table-responsive table-condensed">
						                        					<tbody class="btn-lg">
							                        					<tr>
							                        						<td width="210"><b>EMAIL: </b></td>
							                        						<td>{{strtolower($getPreviewInfo->email)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>ALTERNATIVE EMAIL: </b></td>
							                        						<td>{{strtolower($getPreviewInfo->alternate_email)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>PHONE: </b></td>
							                        						<td>{{$getPreviewInfo->phone}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>ALTERNATIVE PHONE: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->alternate_phone)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td><b>PHYSICAL ADDRESS: </b></td>
							                        						<td>{{strtoupper($getPreviewInfo->home_address)}}</td>
							                        					</tr>
							                        					<tr>
							                        						<td colspan="2">
							                        							 <a href="@if(Session::get('fileNo')) {{route('getContactTab')}} @else # @endif" id="tab" title="Contact Info." class="pull-right">
							                        							 	<i class="glyphicon glyphicon-pencil"></i>
							                        							 </a>
							                        						</td>
							                        					</tr>
						                        					</tbody>
					                        					</table>
																<div class="clearfix"></div>
												            </div> 
														</div>

					                        		</div>
					                    		</div>
					                    		</div>
					                    		</div>
					                        </p>
					                        <hr />
					                         <div align="center">
						                        <ul class="list-inline">
						                            <li>
						                            	<a href="{{route('getEmploymentTab')}}" class="btn btn-default">Previous</a>
						                            </li>
						                            <li>
						                            	<a href="{{route('finalRegistration')}}" class="btn btn-primary btn-info-full">Submit</a>
						                            </li>
						                        </ul>
						                     </div>
					                    </div>
					          </form>