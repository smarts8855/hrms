@extends('layouts.layout')

@section('pageTitle')
STAFF REGISTRATION
@endsection

@section('content')
<div class="box box-default" style="background: white;">
 		<div class="box box-default" style="padding: 1px 20px;">
          <h3 class="box-title">
          	<b>@yield('pageTitle')</b>
          </h3>
          <div class="text-right" style="margin-top: -20px;">
          	<a href="{{route('newRegistration')}}" class="btn btn-success"><i class="glyphicon glyphicon-user"></i> New Registration</a>
          	</div>
        </div>
  	<div class="box-default">
  	<div class="box-body">
  		   <div class="row">
  		   	<div class="col-md-10 col-md-offset-1">
  		   	@include('Share.message')
  		   	</div>
  		   </div>
           <div class="row">
            <!--wizard-->
            <div class="col-md-12">
            	<form id="searchStaffUserID" method="post" action="{{url('/staff-registration/current-staff')}}">
            	{{csrf_field()}}
            	<div class="col-md-10 col-md-offset-1"><!--ongoing-reg-staff-div-->
            		<div class="col-md-3" style="padding: 5px 0; margin-left: -10px;">
		            	<select name="staffCourtPostByJson" class="form-control" id="staffCourtPostByJson" style="border: none;">
		            		@if($getAllcourt != "")
			            		@foreach($getAllcourt as $court)
			            			<option value="{{$court->id}}" {{ (Session::get('CourtID')) == $court->id ? 'selected' : ''}}>
			            				{{$court->court_name}}
			            			</option>
			            		@endforeach
		            		@endif
		            	</select>
	            	</div><!--//col-->
            		<div align="center" class="row" style="border: 1px solid #9f9f9f;">
            			<div class="col-md-1">
            				<h4 class="text-success" style="padding: 0;">
            				  	<big>
            				  		@if($tabPage == 1)
						                  <i class="glyphicon glyphicon-briefcase text-success"></i>
					                @elseif($tabPage == 2)
						               <i class="glyphicon glyphicon-user"></i>
						            @elseif($tabPage == 3)
						            	<i class="glyphicon glyphicon-folder-open"></i>
						            @elseif($tabPage == 4)
						                <i class="glyphicon glyphicon-envelope"></i>
						            @elseif($tabPage == 5)
						                <i class="glyphicon glyphicon-ok"></i>
						            @elseif($tabPage == "uploadPicture")
						                <i class="glyphicon glyphicon-user"></i>
						            @else
						            	<i class="fa fa-file"></i>
						            @endif
            				  	</big>
            				</h4>
            			</div><!--//col-->
            			<div class="col-md-5" style="padding: 5px 0;">
		            		<select name="staffName" class="form-control staffName" id="select-search" placeholder="Pick a staff..." style="border: none;">
		            		    <option value="000000">Start New Registration</option>
		            			@if($progressReg != "")
		            			    @if(session::get('userID'))
    			            			@foreach($progressReg as $staffList)
    			            				<option value="{{$staffList->UserID}}" {{ $staffList->UserID == (session::get('userID')) ? 'selected' : ''}}>
    			            					{{ strtoupper($staffList->fileNo .' - '. $staffList->surname .' '. $staffList->first_name .' - '. $staffList->fileNo . ' - '. $staffList->court_name) }}
    			            				</option>
    			            			@endforeach
			            			@else
			            			    <option value="" selected>Select Ongoing Staff</option>
			            			    @foreach($progressReg as $staffList)
    			            				<option value="{{$staffList->UserID}}">
    			            					{{ strtoupper($staffList->fileNo .' - '. $staffList->surname .' '. $staffList->first_name .' - '. $staffList->fileNo . ' - '. $staffList->court_name) }}
    			            				</option>
    			            			@endforeach
			            			@endif
		            			@endif
		            		</select>
	            		</div><!--//col-->
	            		<div align="center" class="col-md-2">
	            			<div> @if(Session::get('fileNo')) File No.: <br /> {{ Session::get('fileNo') }} @endif </div>
	            		</div><!--//col-->
	            		<div align="center" class="col-md-1 delete-ongoing-reg-staff" title="Delete this ongoing Staff record" >
	            			@if(Session::get('fileNo'))
		            			<a href="{{url('#')}}" data-toggle="modal" data-target="#delete-staff" title="Delete this ongoing Staff record">
		            				<i class="fa fa-trash fa-2x delete-icon" title="Delete this ongoing Staff record"></i>
		            			</a>
	            			@endif
	            		</div><!--//col-->
            		</div>
            	</div>
            	</form>
            	<br /><br />
            	<br/>
            	
            	

            	<div class="" style="padding-right: 10px;">
						<div class="row">
							<section>
					        <div class="wizard" style="background: none; padding-right: 10px;">
					        @if($tabPage != "uploadPicture")
					            <div class="wizard-inner">
					                <div class="connecting-line"></div>
					                <ul class="nav nav-tabs" role="tablist">

					                    <li role="presentation" class="{{$tabLevel1}}">
					                    	<!--if(Session::get('fileNo')) [[route('newStaff_court')]] else # endif-->
					                        <a href="#" id="tab" role="tab" title="Council Information">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-briefcase"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="{{$tabLevel2}}">
					                        <a href="@if(Session::get('fileNo')) {{route('getBasicTab')}} @else # @endif" id="tab" role="tab" title="Basic Info.">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-user"></i>
					                            </span>
					                        </a>
					                    </li>
					                    <li role="presentation" class="{{$tabLevel4}}">
					                        <a href="@if(Session::get('fileNo')) {{route('getEmploymentTab')}} @else # @endif" id="tab" role="tab" title="Employment Info.">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-folder-open"></i>
					                            </span>
					                        </a>
					                    </li>
					                    <li role="presentation" class="{{$tabLevel3}}">
					                        <a href="@if(Session::get('fileNo')) {{route('getContactTab')}} @else # @endif" id="tab" role="tab" title="Contact Info.">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-envelope"></i>
					                            </span>
					                        </a>
					                    </li>
					                    <li role="presentation" class="{{$tabLevel5}}">
					                        <a href="@if(Session::get('fileNo')) {{route('getPreviewTab')}} @else # @endif" id="tab" role="tab" title="Complete"><!--data-toggle="tab"-->
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>
					                </ul>
					            </div>
					          @endif

					            <div role="form">
					            	@if($tabPage == 1)
						                <!--include Court , array('paramName' => 'value')--> 
						                @include('openRegistry.newStaffPartialView.courtInfo')
					                @elseif($tabPage == 2)
						                <!--include basic-->
						                @include('openRegistry.newStaffPartialView.basicInfo')
						            @elseif($tabPage == 3 and (session::get('userID') != ''))
						               <!--include contact-->
						               @include('openRegistry.newStaffPartialView.employmentInfo')
						            @elseif($tabPage == 4 and (session::get('userID') != ''))
						                <!--include employment-->
						                @include('openRegistry.newStaffPartialView.contactInfo')
						            @elseif($tabPage == 5 and (session::get('userID') != ''))
						                <!--include preview-->
						                @include('openRegistry.newStaffPartialView.previewInfo')
						            @elseif($tabPage == "uploadPicture" and (session::get('userID') != ''))
						            	@include('openRegistry.newStaffPartialView.uploadImage')
						            @else
						            	 <!--include Court , array('paramName' => 'value')--> 
						                @include('openRegistry.newStaffPartialView.courtInfo')
						            @endif
					            </div><!--//Role-->
					        </div>
					    </section>
					   </div>
				</div>
        </div>
  </div>
  <br />
  <!--confirm Deletion-->
	<form id="saveSelectForm" method="post" action="{{url('/staff-registration/delete')}}">
		{{ csrf_field() }}
		<div class="modal fade" id="delete-staff" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="alert alert-warning" style="color: white;">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						    <div class="modal-title">
						    	<i class="glyphicon glyphicon-alert text-danger fa-2x"></i> 
						    	<big>YOU ARE ABOUT TO DELETE A STAFF !</big>
							</div>
						</div>
						<div class="modal-body col-sm-12" style="padding: 15px;">
						    <big>Are you sure you want to delete this Staff from ongoing registration record?</big>
						    <br />
						    <div class="text-success text-center">
						    	<big>
						    	@if($fillUpForm)
						    		{{$fillUpForm->court_name .' - '. $fillUpForm->title .' '. $fillUpForm->surname .' '.$fillUpForm->first_name .' '. $fillUpForm->othernames}}
						    	@endif
						    	</big>
						    </div>
						   
						    <p>NOTE:</p>
						    <p>YES: The system deletes this staff temporarily</p>
						    <p>Cancel: The system takes no action</p>
						</div>
					</div>
					<div class="modal-footer">
					    <button type="submit" name="replicateButton" class="btn btn-warning">
					     	Yes. Delete Now <i class="fa fa-trash"></i>
					    </button>
					  	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>		
		</div>
	</form>
	<form id="PostCourtID" method="post" action="{{url('/staff-registration/current-staff-by-court')}}">
    {{csrf_field()}}
    	<input type="hidden" name="staffCourt" id="staffCourt">
    </form>
	<!-- //end delete-->
</div>
</div>
</div>
@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/assets-new-staff/css-form-wizard.css')}}">
<style>
	@keyframes animatedBackground {
	from { background-position: 0 0; }
	to { background-position: 100% 0; }
	}
	#animate-area{ 
	width: 560px; 
	height: 400px; 
	background-image: url('{{asset('assets/webcam/bg-clouds.png')}}');
	background-position: 0px 0px;
	background-repeat: repeat-x;

	animation: animatedBackground 40s linear infinite;
	}
</style>

<!--for search staff from select input -->

    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var country = ["Australia", "Bangladesh", "Denmark", "Hong Kong", "Indonesia", "Netherlands", "New Zealand", "South Africa"];
				$("#country").select2({
				  data: country
				});
			});
		</script>
	
	
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')	
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $('#select-search').select2();
    </script>

<!--WebCam Library-->
<script src="{{asset('assets/webcam/webcam.min.js')}}"></script>
<script src="{{asset('assets/webcam/webcam.js')}}"></script>
<script src="{{asset('assets/webcam/webcam.swf')}}"></script>
<!--end WebCam library-->

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/assets-new-staff/js-form-wizard.js')}}"></script>
<script src="{{asset('assets/assets-new-staff/js-process-form.js')}}"></script>

<script type="text/javascript">

  	$('#delete-staff').modal({
    	backdrop: 'static',
    	keyboard: false
	})
	$('#delete-staff').modal('hide');
	//

	$('#reset').click( function(){ 
		$('#fileNo').attr("readonly", true);
		$('#AddNew').attr("disabled", false);
		$('#Update').attr("disabled", true);
	}); 
	//

	$( function(){ 
	    $( "#dateofBirth-show" ).datepicker({changeMonth: true,changeYear: true, dateFormat: 'dd-m-yy'});
	    //$( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	   // $( "#firstAppointment" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
	});
	
	$( function() {
        $("#getDateofBirth").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2990', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true, 
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst){
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                var getDateofBirth = $.datepicker.formatDate('dd-mm-yy', theDate);
                var getDOB = $.datepicker.formatDate('yy-mm-dd', theDate);
                $("#getDateofBirth").val(getDateofBirth);
                $("#dateOfBirth").val(dateFormatted);
            },
        });
    });

	$( function() {
        $("#presentAppointment2").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true, 
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst){
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                var presentAppointment2 = $.datepicker.formatDate('dd-mm-yy', theDate);
                $("#presentAppointment").val(dateFormatted);
                $("#presentAppointment2").val(presentAppointment2);
            },
        });
  });

$( function() {
        $("#firstAppointment2").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:2090', // specifying a hard coded year range
            showOtherMonths: true,
            selectOtherMonths: true, 
            dateFormat: "dd MM, yy",
            //dateFormat: "D, MM d, yy",
            onSelect: function(dateText, inst){
                var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
                var firstAppointment2 = $.datepicker.formatDate('dd-mm-yy', theDate);
                $("#firstAppointment").val(dateFormatted);
                $("#firstAppointment2").val(firstAppointment2);
            },
        });
  } );

	//
 
</script>


@endsection
