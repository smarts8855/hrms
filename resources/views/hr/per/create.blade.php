@extends('layouts.layout')

@section('pageTitle')
  Add/Update Staff Record
@endsection

@section('content')
  <form method="post" action="{{ url('per/store') }}" id="form1">
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
                <label>Select staff to edit</label>
                <select name="staffList" id="staffList" class="form-control">
                <option value="" selected>Select staff to edit</option>
                	 @foreach ($staffList as $staff)
                  <option value="{{ $staff->fileNo }}" {{ (old("staffList") == $staff->fileNo ? "selected":"") }}>
                  {{ $staff->surname." ".$staff->first_name." ".$staff->othernames }}</option>
                  @endforeach
                </select><input type="hidden" name="oldFileNo" id="oldFileNo" value="{{ old('oldFileNo') }}">
              </div>
              <div class="form-group">
                <label>Title</label>
                <select name="title" id="title" class="form-control">
                  <option value="Select Title" selected="selected">Select Title</option>
                  <option value="MR." {{ (old("title") == "MR." ? "selected":"") }}>Mr.</option>
                  <option value="MRS." {{ (old("title") == "MRS." ? "selected":"") }}>Mrs.</option>
                  <option value="MISS" {{ (old("title") == "MISS" ? "selected":"") }}>Miss</option>
                  <option value="HON. JUSTICE" {{ (old("title") == "HON. JUSTICE" ? "selected":"") }}>Hon. Justice</option>
                </select>
              </div>
              <div class="form-group">
                <label>First name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" value="{{ old('firstName') }}" />
              </div>
              <div class="form-group">
                <label>Designation</label>
               <input type="text" name="designation" id="designation" class="form-control" value="{{ old('designation') }}" />              
              </div>
              <div class="form-group">
                <label>Bank name</label>
                <select name="bankID" id="bankID" class="form-control">
                <option value="" selected>Select bank</option>
                	@foreach ($bankList as $b)
                	<option value="{{ $b->bankID }}" {{ (old("bankID") == $b->bankID ? "selected":"") }}>{{ $b->bank }}</option>
                	@endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Account Number</label>
                <input type="text" name="accountNo" id="accountNo" class="form-control" value="{{old('accountNo')}}" />
              </div>
              <div class="form-group">
                <label>Incremental Date</label>
                <input type="text" name="incrementalDate" id="incrementalDate" class="form-control" value="{{old('incrementalDate')}}" />
              </div>
               <div class="form-group">
                <label>Gender</label>
               <select name="gender" id="gender" class="form-control">
                  <option>Select Gender</option>
                  <option value="MALE" {{ (old("gender") == "MALE" ? "selected":"") }}>Male</option>
                  <option value="FEMALE" {{ (old("gender") == "FEMALE" ? "selected":"") }}>Female</option>
                </select>
              </div>
               <div class="form-group">
                <label>Home Address</label>
                <textarea class="form-control" name="homeAddress" id="homeAddress">{{old('homeAddress')}}</textarea>
              </div>


              </div>
            <!-- /.col -->
            <!-- 2nd column -->
            <div class="col-md-4">
            <div class="form-group">
                <label>File Number</label>
               <input type="text" class="form-control" id="fileNo" name="fileNo" value="{{ old('fileNo') }}">
              </div>
             <div class="form-group">
                <label>Surname</label>
               <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname') }}" />
              </div>
              <div class="form-group">
                <label>Other Names</label>
                <input type="text" name="otherNames" id="otherNames" class="form-control" value="{{ old('otherNames') }}" />  
              </div>
              
              <div class="form-group">
                <label>Grade</label>
                <select name="grade" id="grade" class="form-control">
                  <option value="">Staff Grade</option>
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
                <input type="text" name="bankGroup" id="bankGroup" class="form-control" value="{{old('bankGroup')}}" />
              </div>
              <div class="form-group">
                <label>Section</label>
                <input type="text" name="section" id="section" class="form-control" value="{{old('section')}}" />
              </div>
              <div class="form-group">
                <label>Date of Birth</label>
                <input type="text" name="dateofBirth" id="dateofBirth" class="form-control" 
                value="{{old('dateofBirth')}}" />
              </div>
               <div class="form-group">
                <label>State/Residential</label>
                <select name="currentState" id="currentState" class="form-control">
                <option value="" selected>Select State/Residential</option>
                  @foreach ($StateList as $s)
                  <option value="{{ $s->State }}" {{ (old("currentState") == $s->State ? "selected":"") }}>{{ $s->State }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>NHF Number</label>
                <input type="text" name="dob" id="nhfNo" class="form-control" readonly value="{{old('nhfNo')}}" />
              </div>
             
            </div>

            <!-- /.col -->
            <!-- 3rd column -->
            <div class="col-md-4">
              <div class="form-group">
               <img id="image" src="{{asset('passport/0.png')}}" height="208"  /> 
              </div>
              
              <div class="form-group">
                <label>Step</label>
                <select name="step" id="step" class="form-control">
                  <option value="">Staff Step</option>
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
                <input type="text" name="bankBranch" id="bankBranch" class="form-control" value="{{old('bankBranch')}}" />
              </div>
              <div class="form-group">
                <label>Appointment Date</label>
                <input type="text" name="appointmentDate" id="appointmentDate" class="form-control" value="{{old('appointmentDate')}}" />
              </div>
              <div class="form-group">
                <label>Employee Type</label>
                <select name="employeeType" id="employeeType" class="form-control select2">
                  <option value="" selected="selected">Select type</option>
                  <option value="CR" {{ (old("employeeType") == "CR" ? "selected":"") }}>Chief Registrar</option>
                  <option value="JUDICIAL" {{ (old("employeeType") == "JUDICIAL" ? "selected":"") }}>Judicial</option>
                  <option value="HEALTH" {{ (old("employeeType") == "HEALTH" ? "selected":"") }}>Health</option>
                   <option value="MEDICAL" {{ (old("employeeType") == "MEDICAL" ? "selected":"") }}>Medical</option>
                </select>
              </div>
               <div class="form-group">
                <label>Government Quaters</label>
                <input type="text" name="governmentQuarters" id="governmentQuarters" class="form-control" value="{{old('governmentQuarters')}}"/>
              </div>
               <div class="form-group" style="padding-top:25px"> 
                 @permission('can-edit')
                  <input type="submit" name="button" class="btn btn-success" value="Add new staff">
                  <input type="submit" name="button" class="btn btn-success" value="Update staff">
                 @endpermission
                <input type="reset" class="btn btn-info" name="reset" value="clear form">
              </div>
            </div> <!-- end of col-md-4 -->

            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
  </form>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  	(function () {
	$('#staffList').change( function(){
    $('#processing').text('Processing. Please wait...');
		$.ajax({
			url: murl +'/per/findStaff',
			type: "post",
			data: {'staffList': $('#staffList').val(), '_token': $('input[name=_token]').val()},
			success: function(data){
        $('#processing').text('');
        $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
        $('#surname').val(data.surname);
        $('#fileNo').val(data.fileNo);
        $('#oldFileNo').val(data.fileNo);
        $('#title').val(data.title);
        $('#firstName').val(data.first_name);	
        $('#otherNames').val(data.othernames);
        $('#designation').val(data.Designation);
        $('#grade').val(data.grade);
        $('#step').val(data.step);
        $('#bankID').val(data.bankID);
        $('#bankGroup').val(data.bankGroup);
        $('#bankBranch').val(data.bank_branch);
        $('#accountNo').val(data.AccNo);
        $('#section').val(data.section);
        $('#appointmentDate').val(data.appointment_date);
        $('#incrementalDate').val(data.incremental_date);
        $('#dateofBirth').val(data.dob);
        $('#employeeType').val(data.employee_type);
        $('#gender').val(data.gender);
        $('#currentState').val(data.current_state);
        $('#governmentQuarters').val(data.government_qtr);
        $('#homeAddress').val(data.home_address);
        $('#nhfNo').val(data.nhfNo);
			}
		})	
	});}) ();
////////////////////////////////////////////////////////
$( function() {
    $("#dateofBirth").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $("#appointmentDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $("#incrementalDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );

  </script>
@endsection