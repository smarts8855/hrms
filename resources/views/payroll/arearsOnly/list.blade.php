@extends('layouts.layout')
@section('pageTitle')
Delete staff Arrears
@endsection
@section('content')
<div > 
  
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
        
        <form method="post" action="{{url('/arrears-only/list-staff')}}">
            {{ csrf_field() }}
            <div class="col-md-5">
              <div class="form-group">
                <label> Select a month </label>
                <select name="month" id="section" class="form-control" >
                  <option value="">Select Month </option>
                  <option value="JANUARY" >January</option>
                  <option value="FEBRUARY">February</option>
                  <option value="MARCH">March</option>
                  <option value="APRIL">April</option>
                  <option value="MAY">May</option>
                  <option value="JUNE">June</option>
                  <option value="JULY">July</option>
                  <option value="AUGUST">August</option>
                  <option value="SEPTEMBER">September</option>
                  <option value="OCTOBER">October</option>
                  <option value="NOVEMBER">November</option>
                  <option value="DECEMBER">December</option> 
                </select>                        
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
               <label >Select a Year</label>                       
               <select name="year" id="section" class="form-control">
                <option value="">Select Year</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2024">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option> 
                <option value="2040">2040</option>                  
              </select>
            </div>
          </div>
          
          
          <div class="col-md-2">
            <div class="form-group">
              <div >
                <button type="submit" class="btn btn-success btn-sm pull-right">Display</button>
              </div>
            </div>           
        </form>
        
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Staff Arrears List</h3>
              </div>
               <div>

               <table class="table table-striped table-condensed table-bordered">
          <thead>
            <th>S/N</th>
            <th>File Number</th>
            <th>Name</th>
            <th>Month</th>
            <th>Year</th>
            <th>Call Duty</th>
            <th>Division</th>
            <th>Delete</th>
          </thead>
          <tbody>
            @php $key = 1; @endphp
            {{-- @if($staffList > 0) --}}
            @foreach ($staffList as $user)
                  <tr>
                    <td>{{$key ++}}</td>
                    <td>{{ $user->fileNo }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->month }}</td>
                    <td>{{ $user->year }}</td>
                     <td>{{ $user->callDuty }}</td>
                    <td>{{ $user->division }}</td>
                    <td><a href="{{url('/arrears-only/delete-staff/'.$user->id)}}" onclick="return ConfirmDelete();" class="btn btn-danger">delete</a></td>
                  </tr>
              @endforeach
              {{-- @endif --}}
          </tbody>
          
        </table>
                
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

<script>
    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }
</script>   

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
          alert(data.bank);
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
