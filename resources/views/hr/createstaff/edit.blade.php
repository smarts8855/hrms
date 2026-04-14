@extends('layouts.layout')
@section('pageTitle')
Edit Staff
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
<form method="post" action="{{ url('staff/store') }}" id="form1">
	{{ csrf_field() }}
  <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> 
                             @foreach ($errors->all() as $error)
                                  <p>{{ $error }}</p>
                             @endforeach
                        </div>
                        @endif                       
                        
                        @if(session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('msg') }}</div>                        
                        @endif
            </div>

            <!-- 1st column -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Title</label>
                <select name="title" id="title" class="form-control">
                  <option value="{{$staffDetails->title}}" selected="selected">{{$staffDetails->title}}</option>
                  <option value="MR." {{ (old("title") == "MR." ? "selected":"") }}>Mr.</option>
                  <option value="MRS." {{ (old("title") == "MRS." ? "selected":"") }}>Mrs.</option>
                  <option value="MISS" {{ (old("title") == "MISS" ? "selected":"") }}>Miss</option>
                  <option value="HON. JUSTICE" {{ (old("title") == "HON. JUSTICE" ? "selected":"") }}>Hon. Justice</option>
                </select>
              </div>
              <div class="form-group">
                <label>First name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" value="{{$staffDetails->first_name}}" />
              </div>
              <div class="form-group">
                <label>Designation</label>
               <input type="text" name="designation" id="designation" class="form-control" value="{{$staffDetails->Designation}}" />              
              </div>
              <div class="form-group">
                <label>Bank name</label>
                <select name="bankID" id="bankID" class="form-control">
                <option value="{{$staffDetails->bankID}}" selected>{{$staffDetails->bank}}</option>
                	@foreach ($bankList as $b)
                	<option value="{{ $b->bankID }}" {{ (old("bankID") == $b->bankID ? "selected":"") }}>{{ $b->bank }}</option>
                	@endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Account Number</label>
                <input type="text" name="accountNo" id="accountNo" class="form-control" value="{{$staffDetails->AccNo}}" />
              </div>
              <div class="form-group">
                <label>Incremental Date</label>
                <input type="text" name="incrementalDate" id="incrementalDate" class="form-control" value="{{$staffDetails->incremental_date}}" />
              </div>
               <div class="form-group">
                <label>Gender</label>
               <select name="gender" id="gender" class="form-control">
                  <option>{{$staffDetails->gender}}</option>
                  <option value="MALE" {{ (old("gender") == "MALE" ? "selected":"") }}>Male</option>
                  <option value="FEMALE" {{ (old("gender") == "FEMALE" ? "selected":"") }}>Female</option>
                </select>
              </div>
               <div class="form-group">
                <label>Home Address</label>
                <textarea class="form-control" name="homeAddress" id="homeAddress">{{$staffDetails->home_address}}</textarea>
              </div>
              <div class="form-group">
                <label>Marital Status</label>
               <select name="maritalStatus" id="maritalStatus" class="form-control">
                  <option>{{$staffDetails->maritalstatus}}</option>
                  <option value="Single" {{ (old("maritalStatus") == "Single" ? "selected":"") }}>Single</option>
                  <option value="Married" {{ (old("maritalStatus") == "Married" ? "selected":"") }}>Married</option>
                  <option value="Widower" {{ (old("maritalStatus") == "Widower" ? "selected":"") }}>Widower</option>
                  <option value="Divorced" {{ (old("maritalStatus") == "Divorced" ? "selected":"") }}>Divorced</option>
                </select>
              </div>
              <div class="form-group">
                <label>Place of Birth</label>
                <input type="text" name="placeOfBirth" id="placeOfBirth" class="form-control" value="{{$staffDetails->placeofbirth}}" />
              </div>

              </div>
            <!-- /.col -->
            <!-- 2nd column -->
            <div class="col-md-4">
            <div class="form-group">
                <label>File Number</label>
               <input readonly type="text" class="form-control" id="fileNo" name="fileNo" value="{{$staffDetails->fileNo}}""> 
                <!---->
                <input type="hidden" name="updateValue" value="{{$staffDetails->ID}}"> 
                <input type="hidden" name="getRedirect" value="/profile/details/{{$staffDetails->fileNo}}">
               <!---->
              </div>
             <div class="form-group">
                <label>Surname</label>
               <input type="text" name="surname" id="surname" class="form-control" value="{{$staffDetails->surname}}" />
              </div>
              <div class="form-group">
                <label>Other Names</label>
                <input type="text" name="otherNames" id="otherNames" class="form-control" value="{{$staffDetails->othernames}}" />  
              </div>
              
              <div class="form-group">
                <label>Grade</label>
                <select name="grade" id="grade" class="form-control">
                  <option value="{{$staffDetails->grade}}">{{$staffDetails->grade}}</option>
                  <option value="1" {{ (old("grade") == "1" ? "selected":"") }}>1</option>
                  <option value="2" {{ (old("grade") == "2" ? "selected":"") }}>2</option>
                  <option value="3" {{ (old("grade") == "3" ? "selected":"") }}>3</option>
                  <option value="4" {{ (old("grade") == "4" ? "selected":"") }}>4</option>
                  <option value="5" {{ (old("grade") == "5" ? "selected":"") }}>5</option>
                  <option value="6" {{ (old("grade") == "6" ? "selected":"") }}>6</option>
                  <option value="7" {{ (old("grade") == "7" ? "selected":"") }}>7</option>
                  <option value="8" {{ (old("grade") == "8" ? "selected":"") }}>8</option>
                  <option value="9" {{ (old("grade") == "9" ? "selected":"") }}>9</option>
                  <option value="10" {{ (old("grade") == "10" ? "selected":"") }}>10</option>
                  <option value="11" {{ (old("grade") == "11" ? "selected":"") }}>11</option>
                  <option value="12" {{ (old("grade") == "12" ? "selected":"") }}>12</option>
                  <option value="13" {{ (old("grade") == "13" ? "selected":"") }}>13</option>
                  <option value="14" {{ (old("grade") == "14" ? "selected":"") }}>14</option>
                  <option value="15" {{ (old("grade") == "15" ? "selected":"") }}>15</option>
                  <option value="16" {{ (old("grade") == "16" ? "selected":"") }}>16</option>
                  <option value="17" {{ (old("grade") == "17" ? "selected":"") }}>17</option>
                </select>   
              </div>
              <div class="form-group">
                <label>Bank Group</label>
                <input type="text" name="bankGroup" id="bankGroup" class="form-control" value="{{$staffDetails->bankGroup}}" />
              </div>
              <div class="form-group">
                <label>Section</label>
                <input type="text" name="section" id="section" class="form-control" value="{{$staffDetails->section}}" />
              </div>
              <div class="form-group">
                <label>Date of Birth</label>
                <input type="text" name="dateofBirth" id="dateofBirth" class="form-control" value="{{$staffDetails->dob}}" />
              </div>
               <div class="form-group">
                  <label>State/Residential</label>
                  <select name="currentState" id="currentState" class="form-control">
                      <option value="{{$staffDetails->current_state}}" selected>{{$staffDetails->current_state}}</option>
                      @foreach ($StateList as $s)
                        <option value="{{ $s->State }}" {{ (old("currentState") == $s->State ? "selected":"") }}>{{ $s->State }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label>Nationality</label>
                  <select name="nationality" id="nationality" class="form-control">
                      <option value="{{$staffDetails->nationality}}" selected>{{$staffDetails->nationality}}</option>
                      <option value="{{ "Nigeria" }}" {{ (old("nationality") == "Nigeria"? "selected":"") }}>{{ "Nigeria" }}
                      </option>
                      <option value="{{ "Others" }}" {{ (old("nationality") == "Others"? "selected":"") }}>{{ "Others" }}
                      </option>
                  </select>
              </div>
              <div class="form-group">
                <label>NHF Number</label>
                <input type="text" name="dob" id="nhfNo" class="form-control" value="{{$staffDetails->nhfNo}}" />
              </div>
             
            </div>

            <!-- /.col -->
            <!-- 3rd column -->
            <div class="col-md-4">
              <div class="form-group">
               <img id="image" src="{{asset('passport/'.$fileNoImage)}}" height="208"  /> 
              </div>
              
              <div class="form-group">
                <label>Step</label>
                <select name="step" id="step" class="form-control">
                  <option value="{{$staffDetails->step}}">{{$staffDetails->step}}</option>
                  <option value="1" {{ (old("step") == "1" ? "selected":"") }}>1</option>
                  <option value="2" {{ (old("step") == "2" ? "selected":"") }}>2</option>
                  <option value="3" {{ (old("step") == "3" ? "selected":"") }}>3</option>
                  <option value="4" {{ (old("step") == "4" ? "selected":"") }}>4</option>
                  <option value="5" {{ (old("step") == "5" ? "selected":"") }}>5</option>
                  <option value="6" {{ (old("step") == "6" ? "selected":"") }}>6</option>
                  <option value="7" {{ (old("step") == "7" ? "selected":"") }}>7</option>
                  <option value="8" {{ (old("step") == "8" ? "selected":"") }}>8</option>
                  <option value="9" {{ (old("step") == "9" ? "selected":"") }}>9</option>
                  <option value="10" {{ (old("step") == "10" ? "selected":"") }}>10</option>
                  <option value="11" {{ (old("step") == "11" ? "selected":"") }}>11</option>
                  <option value="12" {{ (old("step") == "12" ? "selected":"") }}>12</option>
                  <option value="13" {{ (old("step") == "13" ? "selected":"") }}>13</option>
                  <option value="14" {{ (old("step") == "14" ? "selected":"") }}>14</option>
                  <option value="15" {{ (old("step") == "15" ? "selected":"") }}>15</option>
                </select>   
              </div>
              <div class="form-group">
                <label>Bank Branch</label>
                <input type="text" name="bankBranch" id="bankBranch" class="form-control" value="{{$staffDetails->bank_branch}}" />
              </div>
              <div class="form-group">
                <label>Appointment Date</label>
                <input type="text" name="appointmentDate" id="appointmentDate" class="form-control" value="{{$staffDetails->appointment_date}}" />
              </div>
              <div class="form-group">
                <label>Date of First Arrival</label>
                <input type="text" name="firstArrivalDate" id="firstArrivalDate" class="form-control" value="{{$staffDetails->firstarrival_date}}" />
              </div>
              <div class="form-group">
                <label>Employee Type</label>
                <select name="employeeType" id="employeeType" class="form-control select2">
                  <option value="{{$staffDetails->employee_type}}" selected="selected">{{$staffDetails->employee_type}}</option>
                  <option value="CR" {{ (old("employeeType") == "CR" ? "selected":"") }}>Chief Registrar</option>
                  <option value="JUDICIAL" {{ (old("employeeType") == "JUDICIAL" ? "selected":"") }}>Judicial</option>
                  <option value="HEALTH" {{ (old("employeeType") == "HEALTH" ? "selected":"") }}>Health</option>
                   <option value="MEDICAL" {{ (old("employeeType") == "MEDICAL" ? "selected":"") }}>Medical</option>
                </select>
              </div>
               <div class="form-group">
                <label>Government Quaters</label>
                <input type="text" name="governmentQuarters" id="governmentQuarters" class="form-control" value="{{$staffDetails->government_qtr}}"/>
              </div>
               <div class="form-group" style="padding-top:25px"> 
                 @permission('can-edit')
                  <input type="button" id="Update" class="btn btn-info" value=" Update Staff " data-toggle="modal" data-target="#confirmUpdate" data-title="Update Sfaff Record" data-message='Are you sure you want to Update this staff record? '>
                 @endpermission
                <a href="{{url('/profile/details/'.$staffDetails->fileNo)}}" name="cancel" class="btn btn-default">Cancel</a>
              </div>
            </div> <!-- end of col-md-4 -->

            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>

	<!-- Modal Dialog for UPDATE RECORD-->
	<div class="modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Update Staff Record!</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to Update this staff record? 
					<br />
					&nbsp; 	<b>Continue</b>  - this will update staff record <br />
					&nbsp; 	<b>Cancel</b> 	 - this will return you back to the same page 
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="submit" name="button" class="btn btn-info" value="Update staff" >
				</div>
			</div>
		</div>
	</div>
	<!-- //Modal Dialog -->

	</form>
  </div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
$( function() {
    $( "#dateofBirth" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );

  </script>
@endsection
