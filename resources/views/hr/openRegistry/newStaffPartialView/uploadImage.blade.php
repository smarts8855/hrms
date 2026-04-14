							

							<form action="{{url('/staff-registration/browse-picture')}}" enctype="multipart/form-data" method="POST">
        					{{csrf_field()}}   
					                <div class="tab-content">
					                	 <div class="tab-pane active" role="tabpanel" id="step1">
					                		<br />
					                        <div class="col-md-offset-0">
					                        	<h3 class="text-success text-center">
					                        		<i class="glyphicon glyphicon-user"></i> <b>Browse Picture</b>
					                        	</h3>
					                    	</div>
					                        <p>
					                        	<div class="row">
					                        		<div class="col-md-8 col-md-offset-2">
					                        			<div class="form-group">

											             <div class="panel panel-default">
															<div align="center" class="panel-heading fieldset-preview">
																<b>UPLOADING STAFF PICTURE</b>
															</div>
															<div align="center" class="panel-body">
																<div class="row">
																	<!--<div class="col-md-7">
																		<div style="border: 1px solid #999; padding: 10px; width: 220px; height: 180px;" id="animate-area">
																			<div id="my_camera" style="width: 100%; height: 160px; padding-right: 20px;">
																				<script src="{{asset('assets/webcam/webcam.js')}}"></script>
																			    <div id="my_camera" style="width:100px; height:140px;"></div>
																			    <div id="my_result"></div>
																			    <div id="my_resulturl"></div>
																			    <script language="JavaScript">
																			        Webcam.attach( '#my_camera' );
																			        function take_snapshot() {
																			            Webcam.snap( function(data_uri) {
																			                document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
																			                document.getElementById('my_resulturl').innerHTML = data_uri;
																			            } );
																			        }
																				</script>
																				{{-- <a href="javascript:void(take_snapshot())">Take Snapshot</a> --}}
																			</div>
																		</div>	
																		<span><small class="text-success">Your New Photo</small></span>		 		
														        	</div>-->
														        	<div class="col-md-5">
														        		<div>
														        			@if($fillUpForm != '' and session::get('userID') != '')
														           				<img src="{{asset('passport/'. $getFolderPath .'/'.$getPreviewInfo->picture)}}" class="thombnail responsive" height="180" alt=" ">
														           			@else
														           				<img src="{{asset('passport/default.png')}}" class="thombnail responsive" height="180" alt=" ">
														           			@endif
														        		</div>
														        		<!--<span><small class="text-success">Your Current Photo</small></span>-->
														        	</div>
														    	</div>
									        					<hr />
														        <div class="row">
																    <!--<div align="left" class="col-md-4">
																    	<div align="center" >
																	       <a href="javascript:void(take_snapshot())" class="btn btn-primary"><i class="fa fa-camera"></i> Take Snapshot</a>
																        </div>
																    </div>-->
																    <div class="col-md-12" align="center" >
																        <input type="file" name="photography" class="btn btn-default file">
																    </div>
																</div>
																<div class="clearfix"></div>
														    </div> 
														</div>
														
										          </div>
					                        	</div><!--//row 1-->
					                        </div>
					                        </p>
					                        <hr />
					                        <div align="center">
						                        <ul class="list-inline">
						                            <li>
						                            	<a href="{{route('getPreviewTab')}}" class="btn btn-default">
						                            		<i class="fa fa-user"></i> Back
						                            	</a>
						                            	<button type="submit" class="btn btn-primary">
						                            		<i class="fa fa-save"></i> Upload and Continue
						                            	</button>
						                            </li>
						                        </ul>
					                    	</div>
					                    </div>
					       </form>