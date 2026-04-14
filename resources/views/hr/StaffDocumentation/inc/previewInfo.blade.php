<form action="{{url('/staff-documentation-preview')}}" method="POST">
	{{csrf_field()}}
		<div class="tab-pane" role="tabpanel" id="step4">
			<div align="left" class="col-md-offset-0">
				<h3 class="text-success text-center noprint">
					<i class="glyphicon glyphicon-ok"></i> <b> Documentation Complete</b>
				</h3>
			</div>
			<br />
			<p>
				<div class="row">
				<div class="col-md-8 col-md-offset-2">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading fieldset-preview"><b>BASIC INFORMATION</b></div>
								<div class="panel-body">
								<table class="table table-striped table-hover table-responsive table-condensed">
									<tbody class="btn-lg">
										<tr>
											<td width="210"><b>FILE NO.: </b></td>
											<td>{{$staffInfo->fileNo ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Name:</b></td>
											<td>{{$StaffNames ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Gender: </b></td>
											<td>{{$staffInfo->gender ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Date of Birth: </b></td>
											<td>{{ date('d-m-Y', strtotime($staffInfo->dob ?? ''))}}</td>
										</tr>
										
										<tr>
											<td width="210"><b>Employment Type: </b></td>
											<td>{{$empType->employmentType ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Grade Level:</b></td>
											<td>{{$staffInfo->grade ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Step: </b></td>
											<td>{{$staffInfo->step ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Department: </b></td>
											<td>{{$dept->department ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Designation: </b></td>
											<td>{{$design->designation ?? ''}}</td>
										</tr>
										<tr>
											<td><b>Date of Appointment: </b></td>
											<td>{{ date('d-m-Y', strtotime($staffInfo->appointment_date ?? '')) }}</td>
										</tr>
										<tr>
											<td><b>Date of First Appointment: </b></td>
											<td>{{date('d-m-Y', strtotime($staffInfo->date_present_appointment ?? ''))}}</td>
										</tr>
										<tr>
											<td colspan="2" class="noprint">
													<a  href="{{route('getBasicInfo')}}" class="pull-right">
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
										<td>{{$staffInfo->email ?? ''}}</td>
										</tr>
										<tr>
											<td><b>ALTERNATIVE EMAIL: </b></td>
											<td>{{$staffInfo->alternate_email ?? ''}}</td>
										</tr>
										<tr>
											<td><b>PHONE: </b></td>
											<td>{{$staffInfo->phone ?? ''}}</td>
										</tr>
										<tr>
											<td><b>ALTERNATIVE PHONE: </b></td>
											<td>{{$staffInfo->alternate_phone ?? ''}}</td>
										</tr>
										<tr>
											<td><b>PHYSICAL ADDRESS: </b></td>
											<td>{{$staffInfo->home_address ?? ''}}</td>
										</tr>
										<tr>
											<td colspan="2" class="noprint">
													<a  href="{{route('getContact')}}" class="pull-right">
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
									<div class="panel-heading fieldset-preview"><b>PLACE OF BIRTH</b></div>
										<div class="panel-body">
										<table class="table table-striped table-hover table-responsive table-condensed">
											<tbody class="btn-lg">
												<tr>
													<td width="210"><b>STATE OF ORIGIN: </b></td>
												<td>{{$UserState->State ?? ''}}</td>
												</tr>
											
												<tr>
													<td><b>L.G.A.: </b></td>
													<td>{{$UserLga->lga ?? ''}}</td>
												</tr>
												<tr>
													<td><b>ADDRESS: </b></td>
													<td>{{$staffInfo->placeofbirth ?? ''}}</td>
												</tr>
												
												
		
													<td colspan="2" class="noprint">
															<a  href="{{route('getPlaceOfBirth')}}" class="pull-right">
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
							<div class="panel-heading fieldset-preview"><b>MARITAL INFORMATION</b></div>
								<div class="panel-body">
								<table class="table table-striped table-hover table-responsive table-condensed">
									<tbody class="btn-lg">
										<tr>
											<td width="210"><b>MARITAL STATUS: </b></td>
										<td>{{$relationship}}</td>
										</tr>
										@if($relationship=='Married')
										<tr>
											<td><b>NAME OF SPOUSE: </b></td>
											<td>{{$maritalStatus->wifename ?? ''}}</td>
										</tr>
										<tr>
											<td><b>SPOUSE DATE OF BIRTH: </b></td>
											<td>{{ date('d-m-Y', strtotime($maritalStatus->wifedateofbirth ?? '')) }}</td>
										</tr>
										<tr>
											<td><b>DATE OF MARRIAGE: </b></td>
											<td>{{ date('d-m-Y', strtotime($maritalStatus->dateofmarriage ?? '')) }}</td>
										</tr>
										<tr>
											<td><b>SPOUSE ADDRESS: </b></td>
											<td>{{$maritalStatus->homeplace ?? ''}}</td>
										</tr>
										@endif
										<tr>

												<td colspan="2" class="noprint">
														<a  href="{{route('getMarital')}}" class="pull-right">
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
								<div class="panel-heading fieldset-preview"><b>NEXT OF KIN</b></div>
									<div class="panel-body">
									<table class="table table-striped table-hover table-responsive table-condensed">
										<tbody class="btn-lg">
											<tr>
												<td width="210"><b>FULL NAME: </b></td>
												<td>{{$nextOfKin->fullname ?? '' }}</td>
											</tr>
											<tr>
												<td width="210"><b>PHONE NAMBER: </b></td>
												<td>{{$nextOfKin->phoneno ?? '' }}</td>
											</tr>
											<tr>
												<td><b>RESIDENT ADDRESS:</b> </td>
												<td>{{$nextOfKin->address ?? ''}}</td>
											</tr>
											<tr>
												<td><b>RELATIONSHIP: </b></td>
												<td>{{$nextOfKin->relationship ?? ''}}</td>
											</tr>
											
											<tr>
												<td colspan="2" class="noprint">
														<a  href="{{route('getNextOfKin')}}" class="pull-right">
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
										<div class="panel-heading fieldset-preview"><b>Children</b></div>
											<div class="panel-body">
											<table class="table table-striped table-hover table-responsive table-condensed">
												<tbody class="btn-lg">
													@foreach($children as $child)
													<tr>
														<td width="210"><b>FULLNAME: </b></td>
														<td>{{$child->fullname ?? ''}}</td>
													</tr>
													<tr>
														<td width="210"><b>DATE OF BIRTH: </b></td>
														<td>{{ date('d-m-Y', strtotime($child->dateofbirth ?? '')) }}</td>
													</tr>
													<tr>
														<td><b>GENDER:</b> </td>
														<td>{{$child->gender ?? ''}}</td>
													</tr>
	
													<tr style="background-color:green">
    													<td></td>
    													<td></td>
												    </tr>
													
													<tr>
													@endforeach
														<td colspan="2" class="noprint">
																<a  href="{{route('getChildren')}}" class="pull-right">
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
									<div class="panel-heading fieldset-preview"><b>Previous Employment</b></div>
										<div class="panel-body">
										<table class="table table-striped table-hover table-responsive table-condensed">
											<tbody class="btn-lg">
												@foreach($prevEmployment as $emp)
												<tr>
													<td width="210"><b>EMPLOYER: </b></td>
													<td>{{$emp->previousSchudule ?? ''}}</td>
												</tr>
												<tr>
													<td width="210"><b>PREVIOUS PAY: </b></td>
													<td>{{ number_format($emp->totalPreviousPay,2) ?? ''}}</td>
												</tr>
												<tr>
													<td><b>PERIOD OF EMPLOYMENT:</b> </td>
													<td>{{ date('d-m-Y', strtotime($emp->fromDate)) ?? ''}} - {{ date('d-m-Y', strtotime($emp->toDate)) ?? ''}}</td>
												</tr>
                                                
                                                <tr>
													<td width="210"><b>FILES PAGES: </b></td>
													<td>{{$emp->filePageRef ?? ''}}</td>
												</tr>
												<tr>
													<td><b>CHECKED BY:</b> </td>
													<td>{{$emp->checkedby ?? ''}}</td>
												</tr>
												<tr style="background-color:green">
													<td></td>
													<td></td>
												</tr>
												<tr>
												@endforeach
													<td colspan="2" class="noprint">
															<a  href="{{route('getPrevEmployment')}}" class="pull-right">
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
									<div class="panel-heading fieldset-preview"><b>Document Attachment</b></div>
										<div class="panel-body">
										<table class="table table-striped table-hover table-responsive table-condensed">
											<tbody class="btn-lg">
											     @php $filepath="/staffattachments/" @endphp 
												@foreach($staffAttachment as $emp)
												
												<tr>
													<td width="210"><b>DOCUMENT: </b></td>
													<td><a href="{{ $filepath }}{{ $emp->filepath ??'' }}">{{$emp->filedesc ??''}}</a></td>
												</tr>
											    
											    <tr style="background-color:green">
													<td></td>
													<td></td>
												</tr>

												<tr>
												@endforeach
													<td colspan="2" class="noprint">
															<a  href="{{route('getAttachment')}}" class="pull-right">
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
									<div class="panel-heading fieldset-preview"><b>Account Information</b></div>
										<div class="panel-body">
										<table class="table table-striped table-hover table-responsive table-condensed">
											<tbody class="btn-lg">
												<tr>
													<td width="210"><b>BANK NAME: </b></td>
													<td>{{$UserBank->bank ?? ''}}</td>
												</tr>
												<tr>
													<td width="210"><b>ACCOUNT NAMBER: </b></td>
													<td>{{$staffInfo->AccNo ?? ''}}</td>
												</tr>
												
												<tr>
													<td colspan="2" class="noprint">
															<a  href="{{route('getAccount')}}" class="pull-right">
															<i class="glyphicon glyphicon-pencil"></i>
															</a>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="clearfix"></div>
									</div> 
								</div>

								

								

									<div class="panel panel-defaul">
											<div class="panel-heading fieldset-preview"><b>OTHER INFORMATION</b></div>
												<div class="panel-body">
												@if($otherInfo=="")
												
												@else
												<table class="table table-striped table-hover table-responsive table-condensed">
													<tbody class="btn-lg">
														
														<tr>
															<td width="500"><b>Have you ever been convicted for any crime before?: </b></td>
															<td>{{$otherInfo->qtn1 ?? ''}}</td>
														</tr>
														@if($otherInfo->qtn1=='yes')
														
															<tr>
																<td width="200"><b>Details: </b></td>
																<td>{{$otherInfo->qtn2 ?? ''}}</td>
															</tr>
														
														@endif
														<tr>
															<td width="500"><b>Have you suffered any illness?: </b></td>
															<td>{{$otherInfo->qtn3 ?? ''}}</td>
														</tr>
														@if($otherInfo->qtn3=='yes')
														
															<tr>
																<td width="200"><b>Details: </b></td>
																<td>{{$otherInfo->qtn4 ?? '' }}</td>
															</tr>
														
														@endif
														<tr>
															<td width="500"><b>Have you taken an undertaken to anybody to repay money advance from education, etc?</b> </td>
															<td>{{$otherInfo->qtn5 ?? ''}}</td>
														</tr>
														<tr >
															<td width="500"><b>Are you a judgement Debtor? or are there any write from debts outstanding against you?</b> </td>
															<td>{{$otherInfo->qtn6 ?? ''}}</td>
														</tr>
														@if($otherInfo->qtn6=='yes')
														
															<tr>
																<td width="200"><b>Details: </b></td>
																<td>{{$otherInfo->qtn7 ?? ''}}</td>
															</tr>
														
														@endif
														<tr>
															<td><b width="500">Official Employees details of services in the forces (if applicable): </b></td>
															<td>{{$otherInfo->qtn8 ?? ''}}</td>
														</tr>
														<tr>
															<td width="500"><b>Decoration: </b></td>
															<td>{{$otherInfo->qtn9 ?? ''}}</td>
														</tr>
														<tr>
															<td width="500"><b>What is your religion?: </b> </td>
															<td>{{$otherInfo->qtn10 ?? ''}}</td>
														</tr>
		
														<tr>
															<td></td>
														</tr>
														
														<tr>
														
															<td colspan="2" class="noprint">
																	<a  href="{{route('getOthers')}}" class="pull-right">
																	<i class="glyphicon glyphicon-pencil"></i>
																	</a>
															</td>
														</tr>
													</tbody>
												</table>
												@endif
												<div class="clearfix"></div>
											</div> 
										</div>
	

					</div>
				</div>
				</div>
				</div>
			</p>
			<hr />
				<div align="center" class="noprint">
				<ul class="list-inline">
					<li>
						<a href="{{url('/staff-documentation-others')}}" class="btn btn-default">Previous</a>
					</li>
					<li><a onclick="window.print();return false;" class="btn btn-default">Print</a></li>
					<li>
						<button type="submit" class="btn btn-primary btn-info-full">Submit</a>
					</li>
					
				</ul>
				</div>
		</div>
</form>