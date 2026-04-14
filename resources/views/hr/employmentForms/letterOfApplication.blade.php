@extends('layouts.layout')

@section('pageTitle')
 
@endsection

@section('content')
<style type="text/css">
	.form-control
	{
		padding: 5px;
	}
	.form-control
	{
		padding: 5px;
		height: 20px;
	}
	.text-size
	{
		font-size: 17px;
		line-height: 28px;
	}
	.list
	{
		list-style: none;
		padding: 0px;
		margin:0px;
	}
	.list
	{
		
		margin: 10px 6px ;
	}
	.list li
	{
		
		margin-left: 25px;
	}
	#fileid
	{
		height: 34px;
	}

	.stylecontrol
	{
		border: none;
		font-weight:700; 
		outline: none;
	}
	.p-style
	{
		font-weight: 400;
		font-size: 17px;
	}
	.box-header.with-border
	{
		border: none;
	}
	.box-profile, .box-default, .box-body
	{
		border: none;
	}
	.phead h4
	{
		font-size: 16px;
		
	}
	#fileid
	{
		width:40%;
	}
	
</style>
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		 
		  <div class="box-body">
		        <div class="row">
		            <div class="col-md-12"><!--1st col-->
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
		                        <strong>Success!</strong> 
								{{ session('msg') }} 
						    </div>                        
		                @endif

		                @if(session('err'))
		                    <div class="alert alert-warning alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Not Allowed ! </strong> 
								{{ session('err') }}
						    </div>                        
		                @endif

		            </div>
					

						</div><!-- end row-->

						         <h3 style="text-align: center;">{{strtoupper('Letter of Application for Appointment')}} </h3>
            
						  <div class="clear"></div>

                         <form method="post" action="{{url('/offerofappointment/save')}}">
                         {{ csrf_field() }}
						<div class="row">
						<table style="width: 100%">
						<tr>
						<td>
						<div class="col-md-10">
							TO:<br/>
							____________________________________________<br/><br/>

							____________________________________________<br/><br/>

							____________________________________________<br/><br/>
							____________________________________________<br/><br/>
						</div>
						</td>
						<td>
						
						</td>
						</tr>
						</table>

						</div><!-- end row-->


						<div class="row text-size" >

						<div class="col-md-12">
						<p> I apply for appoinment in your department as _____________________________________
						</p>
						<p>
						2. I have produced for your examination:
						<br/>
						  (a) Recent certificate of character one of which satisfied the Government rule that an applicant who has not previously not previously been in employment must produce a certificate of character from the Head of the School or College he last attended and that one who has already been in other employment must produce a certificate of character from the last employer.	
						</p>
						<p>
						3. I declare That:
						<br/>
						  <ul class="list" style="list-style: lower-roman;">
							<li> I have never been convicted on a criminal charge</li>

							<li>I have never been dismissed from or resigned the service of any Government of a township, Local Government Council or Native Authority</li>
							<li>I have previously been employed as ____________________________ Under the ________________ Governmentr for the period and my employment terminated in the consequence of __________________________________________________________________________________________________________</li>

							<li>
								I have previously been employed in an approval voluntary Agency and my employment terminated in consequence of
							</li>
							<li>I am not under any obligation to serve any approved voluntary service</li>
							<li>I am at present date free from pecuniary embarrasment.</li>
							
						</ul>

							
						</p>
						</div>

						</div><!-- end row-->

						<div class="row">

						<div class="col-md-4">
						<br/><br/>
						
						<p> _______________________________ <br/> Signature <br/><br/>
						
						Date: ______________________________
									<br/>

						</p>

						</div>
						</div>


						<div class="row">
								<div class="col-md-12">

																
										
								</div>
							</div><!-- end row-->

						</div>
						</form>
						</div>
							
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script>


  <script type="text/javascript">
	

$( function() {

  $("#fileid").on('change', function(){

//$('#nameID').val(suggestion.data);
var id = $(this).val();
//alert(id);
$token = $("input[name='_token']").val();
$.ajax({
	headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/offerofappointment/getfileno') }}",

  type: "post",
  data: {'fileno': id},
  success: function(data){
    
    $('#fileno').val(data.fileNo);
    $('#address').val(data.employee_address);
    $('#date').val(data.dateissued);
    $('#dateoffer').val(data.dateofappointment);
    $('#returndate').val(data.returndate);
    $('#medofficer').val(data.medicalofficer);
    $('#salary').val(data.salary);
    $('#position').val(data.position);
    $('.fileno').val(data.fileNo);
    $('#for_registrar').val(data.for_registrar);

    
  }
});
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

    $( function() {
	    $("#dateoffer").datepicker({
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
				$("#dateoffer").val(dateFormatted);
        	},
		});

  } );

      $( function() {
	    $("#returndate").datepicker({
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
				$("#returndate").val(dateFormatted);
        	},
		});

  } );

</script>
@endsection