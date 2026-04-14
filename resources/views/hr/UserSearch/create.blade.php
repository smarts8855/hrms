@extends('layouts.layout')
@section('pageTitle')
Search staff profile
@endsection
@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
<div > 
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
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> {{ session('message') }}</div>                        
          @endif
        </div>
        <div class="col-md-12">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Search By First Name, Surname or File Number</h3>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <div style="background-color:#66FFBA">
                  <input id="autocomplete" name="q" class="form-control">
                </div>
                <input type="hidden" id="nameID"  name="nameID"></br>
                <!--<button type="submit" class="btn btn-success pull-right" >Search</button>-->
                <!--id="finder" -->
              </div>
            </div>
          </div>
          <div class="box-footer">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Staff Record Detail Page</h3>
              </div>
              <div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="File Number">File Number</label>
                      <input type="text" class="form-control" id="fileNo" disabled>
                    </div>
                    <div class="form-group">
                      <label for="Title">Title</label>
                      <input type="text" class="form-control" id="title" disabled>
                    </div>
                    <div class="form-group">
                      <label for="Surname">Surname</label>
                      <input type="text" class="form-control" id="surname" disabled>
                    </div>
                    <div class="form-group">
                      <label for="FirstName">First Name</label>
                      <input type="text" class="form-control" id="first_name" disabled>
                    </div>
                    <div class="form-group">
                      <label for="OtherNames">Other Names</label>
                      <input type="text" class="form-control" id="othernames" disabled>
                    </div>
                    <div class="form-group">
                      <label for="Designation">Designation</label>
                      <input type="text" class="form-control" id="Designation" disabled>
                    </div>
                    <div class="form-group">
                      <label for="Rank">Rank</label>
                      <input type="text" class="form-control" id="rank" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Gender">Gender</label>
                        <input type="text" class="form-control" id="gender" disabled>
                    </div>
                    <div class="form-group">
                        <label for="inputtext3">Division</label>
                        <input type="text" class="form-control" id="division" disabled>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- third column-->
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="Grade">Grade</label>
                      <input type="text" class="form-control" id="grade" disabled>
                    </div>
                    <div class="form-group">
                      <label for="Step">Step</label>
                      <input type="text" class="form-control" id="step" disabled>
                    </div>
                    <div class="form-group">
                      <label for="BankName">Bank Name</label>
                      <input type="text" class="form-control" id="bank" disabled>
                    </div>
                    <div class="form-group">
                      <label for="BankGroup">Bank Group</label>
                      <input type="text" class="form-control" id="bankGroup" disabled>
                    </div>
                    <div class="form-group">
                      <label for="bank_branch">Bank Branch</label>
                      <input type="text" class="form-control" id="bank_branch" disabled>
                    </div>
                    <div class="form-group">
                      <label for="AccountNumber">Account Number
                      </label>
                      <input type="text" class="form-control" id="AccNo" disabled>
                    </div>
                    <div class="form-group">
                      <label for="Section">Section</label>
                      <input type="text" class="form-control" id="section" disabled>
                    </div>
                    <div class="form-group">
                      <label for="AppointmentDate">Appointment Date</label>
                      <input type="text" class="form-control" id="appointment_date" disabled>
                    </div>
                    <div class="form-group">
                        <label for="inputtext3">State/Residential</label>
                        <input type="text" class="form-control" id="current_state" disabled>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <div class="col-md-4">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="image">&nbsp;</label>
                      <img id="image" src="{{asset('passport/0.png')}}" height="208"  /> 
                    </div>

                    <div class="form-group">
                      <label for="exampleInputtext1">Incremental Date</label>
                      <input type="text" class="form-control" id="incremental_date" disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputtext3">Date of Birth</label>
                      <input type="text" class="form-control" id="dob" disabled>
                    </div>
                    <div class="form-group">
                      <label for="HomeAddress">Home Address</label>
                      <input type="text" class="form-control" id="home_address" disabled></div>
                      <div class="form-group">
                        <label for="GovernmentQuater">Government Quater</label>
                        <input type="text" class="form-control" id="government_qtr" disabled>
                      </div>
                      <div class="form-group">
                        <label for="Employeetype">Employee type</label>
                        <input type="text" class="form-control" id="employee_type" disabled>
                      </div>
                       <div class="form-group">
                        <label for="Employeetype">NHF Number</label>
                        <input type="text" class="form-control" id="nhfNo" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>              
  </div>
</div>
</div>
</div>
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
@endsection
@section('styles')
<style> 
  .textbox { 
    border: 1px;
    background-color: #66FFBA; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 
  $('.autocomplete-suggestions').css({
    color: 'red'
  });

  .autocomplete-suggestions{
    color:#66FFBA;
  }
</style> 
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.js') }}" ></script>
<script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {
//alert('hello');
$('#nameID').val(suggestion.data);
//   alert(suggestion.data);
$.ajax({
  url: murl +'/searchUser/create',
  type: "post",
  data: {'nameID': $('#nameID').val(), '_token': $('input[name=_token]').val()},
  success: function(data){
    $('#fileNo').val(data.fileNo);
    $('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
    $('#surname').val(data.surname);
    $('#first_name').val(data.first_name);
    $('#othernames').val(data.othernames);
    $('#Designation').val(data.Designation);
    $('#rank').val(data.rank);
    $('#grade').val(data.grade);
    $('#step').val(data.step);
    $('#bankGroup').val(data.bankGroup);
    $('#bank_branch').val(data.bank_branch);
    $('#AccNo').val(data.AccNo);
    $('#section').val(data.section);
    $('#appointment_date').val(data.appointment_date);
    $('#dob').val(data.dob);
    $('#title').val(data.title);
    $('#home_address').val(data.home_address);
    $('#government_qtr').val(data.government_qtr);
    $('#employee_type').val(data.employee_type);
    $('#gender').val(data.gender);
    $('#bank').val(data.bank);      
    $('#division').val(data.division);
    $('#current_state').val(data.current_state);
    $('#incremental_date').val(data.incremental_date);
    $('#staff_status').val(data.staff_status);
    $('#nhfNo').val(data.nhfNo);
  }
})  

}
});
  });
</script>
<script type="text/javascript">
  (function () {
    $('#finder').click( function(){
      $.ajax({
        url: murl +'/searchUser/create',
        type: "post",
        data: {'nameID': $('#nameID').val(), '_token': $('input[name=_token]').val()},
        success: function(data){
          $('#fileNo').val(data.fileNo);
          $('#surname').val(data.surname);
          $('#first_name').val(data.first_name);
          $('#othernames').val(data.othernames);
          $('#Designation').val(data.Designation);
          $('#rank').val(data.rank);
          $('#grade').val(data.grade);
          $('#step').val(data.step);
          $('#bankGroup').val(data.bankGroup);
          $('#bank_branch').val(data.bank_branch);
          $('#AccNo').val(data.AccNo);
          $('#section').val(data.section);
          $('#appointment_date').val(data.appointment_date);
          $('#dob').val(data.dob);
          $('#title').val(data.title);
          $('#home_address').val(data.home_address);
          $('#government_qtr').val(data.government_qtr);
          $('#employee_type').val(data.employee_type);
          $('#gender').val(data.gender);
          $('#bank').val(data.bank);      
          $('#division').val(data.division);
          $('#current_state').val(data.current_state);
          $('#incremental_date').val(data.incremental_date);
          $('#staff_status').val(data.staff_status);
        }
      })  
    });}) ();
  </script>>
  @endsection
  @endsection
