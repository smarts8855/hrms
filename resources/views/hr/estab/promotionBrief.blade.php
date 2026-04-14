@extends('layouts.layout')

@section('pageTitle')
  
@endsection
<style type="text/css">
  .details table tr td h4
  {
    font-weight: 700;
  }
</style>

@section('content')
<div class="box box-default" style="border:none">
  <div class="box-body box-profile" style="border:none">
    <div class="box-header" style="border:none">
      <h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col-->

          @if (count($errors) > 0)
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Error!</strong> @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach 
            </div>
          @endif
          
          @if(session('msg'))

          <div class="alert alert-success alert-dismissible" role="alert">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Success!</strong> {{ session('msg') }}

          </div>
          @endif
          
          @if(session('err'))
          <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <strong>Not Allowed ! </strong> {{ session('err') }}
          </div>
          @endif 

          </div>
        <div class="col-md-12" ><!--2nd col--> 
        <h2 style="text-align: center; color: #00a65a;">NATIONAL INDUSTRIAL COURT  </h2>
          <h3 style="text-align: center;"> BRIEF IN RESPECT OF CANDIDATE FOR PROMOTION </h3>
          <hr />
          <div class="details">

          <table width="100%">
          <tr><td><h4>NAME IN FULL</h4></td>
            <td>{{$list->surname}} {{$list->first_name}} {{$list->othernames}}</td>
          </tr>
          <tr>
            <td><h4>PROPOSED POST</h4></td>
            <td>@if(count(array($promotion))){{strtoupper($promotion->proposed_post)}}
            @elseif(count(array($convert))){{strtoupper($convert->proposed_post)}}
            @endif</td>
          </tr>
          <tr>
            <td><h4>PRESENT RANK</h4></td>
            <td>{{$list->Designation}} GL {{$list->grade}}</td>
          </tr>
          <tr>
            <td><h4>DATE OF BIRTH</h4></td>
            <td>{{$list->dob}}</td>
          </tr>
          <tr>
            <td><h4>HOME PLACE(TOWN/STATE)</h4></td>
            <td>{{$list->current_state}}</td>
          </tr>
          <tr>
            <td><h4>MARRIED/SINGLE</h4></td>
            <td>{{$list->maritalstatus}}</td>
          </tr>
          <tr>
            <td><h4>DATE OF FIRST APPOINTMENT</h4></td>
            <td>{{$list->appointment_date}}</td>
          </tr>
          <tr>
            <td><h4>DATE OF PRESENT APPOINTMENT</h4></td>
            <td>{{$list->date_present_appointment}}</td>
          </tr>
          <tr>
            <td><h4>DATE/EVIDENCE OF LAST PROMOTION</h4></td>
            <td></td>
          </tr>
          <tr>
            <td><h4>DATE EVIDENCE OF CONFIRMATION OF APPOINTMENT</h4></td>
            <td></td>
          </tr>

          </table>
          
          </div>
          <div class="schools" style="margin-top: 30px;">
          <h4>SCHOOLS COLLEGES ATTENDED WITH DATES</h4>

          <table class="table table-responsive table-condensed table-striped table-bordered" 
          style="/* for IE */filter:alpha(opacity=80);/* CSS3 standard */opacity:0.8;">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Name Of School</th>
              <th>Date Attended</th>
            </tr>
          </thead>
          <tbody>
          @php $sn =1; @endphp
          @foreach($educations as $list)   
          <tr>
            <td>{{$sn++}}</td>
            <td>{{$list->schoolattended}}</td>
            <td>{{$list->schoolfrom}} - {{$list->schoolto}}</td>  
          </tr>
          @endforeach
          </tbody>
          
        </table>

          </div>

          <!-- Education Qualification With Dates  -->

          <div class="schools">
          <h4>EDUCATION QUALIFICATION WITH DATES</h4>

          <table class="table table-responsive table-condensed table-striped table-bordered" 
          style="/* for IE */filter:alpha(opacity=80);/* CSS3 standard */opacity:0.8;">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Qualification</th>
              <th>Date Attended</th>
            </tr>
          </thead>
          <tbody>
          @php $sn =1; @endphp
          @foreach($educations as $list)   
          <tr>
            <td>{{$sn++}}</td>
            <td>{{$list->degreequalification}}</td>
            <td>{{$list->schoolfrom}} - {{$list->schoolto}}</td>  
          </tr>
          @endforeach
          </tbody>
          
        </table>

          </div>

          <!-- Education Qualification With Dates  -->

          <div class="schools">
          <h4>STATEMENT OF SERVICE/CAREER PROGRESSION</h4>

          <table class="table table-responsive table-condensed table-striped table-bordered" 
          style="/* for IE */filter:alpha(opacity=80);/* CSS3 standard */opacity:0.8;">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Position Held</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
          @php $sn =1; @endphp
          @foreach($records as $list)   
          <tr>
            <td>{{$sn++}}</td>
            <td>{{$list->detail}}</td>
            <td>{{$list->entryDate}}</td>  
          </tr>
          @endforeach
          </tbody>
          
        </table>

          </div>

          
        </div>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
  </div>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts') 
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script> 
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script> 
<script type="text/javascript">
	//Modal popup
	$(document).ready(function(){
		$('.open-modal').click(function(){
			$('#myModal').modal('show');
		});
	});

	  $( function() {
	    $("#date").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
				$("#date").val(dateFormatted);
        	},
		});

  } );
</script> 
@endsection