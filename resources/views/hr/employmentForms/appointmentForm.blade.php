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
		line-height: 38px;
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
	#tab tr
	{
		margin-bottom: 25px;

	}
	
</style>
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		 
		  <div class="box-body">
		        <div class="row">
		            <div class="col-md-12" ><!--1st col-->
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
						<div class="row" style="padding-left: 30px; padding-right: 30px;">
						<h4>(To be filled by an applicant under consideration for employment)</h4><br/>
						__________________________________________________________________________________


						</div><!-- end row-->


						<div class="row text-size" >

						<div class="col-md-12" style="padding-left: 20px; padding-right: 20px;">
						<p> An applicant seeking employement in the National Industrial Court, hereby give the follwing information about myself
						</p>
						<p>
						1. Full Names in capital letters _______________________________________________<br/>
						(SURNAME FIRST)
						</p>
						<p>
						2. RESIDENTIAL ADDRESS ___________________________________________________
						<br/>
						 
						</p>
						<p>
						3. Post to which appoinment is considered  _____________________________________ 
						</p>
						<p>
						4. Date of Birth if known  ____________________________________________________ <br> (Birth certificate to be produced if available)
						</p>
						<p>
						5. Place of Birth  ___________________________________________________________ 
						</p>
						<p>
						6.
							<ul class="list" style="list-style: lower-alpha;">
							<li>Home place _________________________________________________________</li>
							<li>L.G.A _______________________________________________________________</li>
							<li>State _______________________________________________________________</li>

							</ul>
						</p>
						<p>
						7. Next of Kin
						<ul class="list" style="list-style: none;">
					<li>(1) Name ___________________________________________________________</li>
						<li> Address _____________________________________________________________</li>
						<li> Ocuppation _________________________________________________________</li>
						<li> Relationship _________________________________________________________</li>

						</ul>
						<ul class="list" style="list-style: none;">
					<li>(2) Name __________________________________________________________</li>
						<li> Address ___________________________________________________________</li>
						<li> Occupation ________________________________________________________</li>
						<li> Relationship _______________________________________________________</li>

						</ul>

						</p>
						<p>
						8. Married/Single/Wdow/Divorced <br/>
						   (Delete which ever is inapplicable)
						</p>
						<p>
						9. Particulars of Wife/Husband
						   <ul style="list-style: none;">
						   <li>Date of Marriage ______________________________________________________</li>
						   <li>Name of Spouse ______________________________________________________</li>
						   <li>Date of Birth _________________________________________________________</li>


						   </ul>
						</p>
						<p>
						10. Partculars of children: <br/>
						<table style="width: 100%;">

						<tr>
						<td> Name </td>
						<td> Sex </td>
						<td> Date of Birth</td>
						</tr>
						<tr>
							<td width="60%">(1) _______________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%">(2) _______________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%">(3) _______________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%">(4) _______________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%">(5) _______________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
							
						</table>

						</p>

						<p>
						11. Education: <br/>
						<table style="width: 100%;">

						<tr>
						<td> Schools(s) Attended </td>
						<td> From </td>
						<td> To</td>
						</tr>
						<tr>
							<td width="60%"> _________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> _______________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
							
						</table>

						</p>

												<p>
						12. School Certificate Held: <br/>
						<table style="width: 100%;">

						
						<tr>
							<td width="60%"> _________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> _______________</td>
						</tr>
						<tr>
							<td width="60%"> __________________________________________</td>
							<td width="20%"> ______________</td>
							<td width="20%"> ________________</td>
						</tr>
							
						</table>

						</p>
						<p>
						13. Degrees and Professional Qualification <br>
						______________________________________________________________________________________________________________________<br/>
						______________________________________________________________________________________________________________________<br/>
						______________________________________________________________________________________________________________________<br/>
						</p>

						<p>
						14. Previous Employment(s)
						<br/>
						
						<span> (1) Employment ____________________________________________________________</span><br/>
						<span> (2) Appointment held ________________________________________________________</span><br/>
						<span> (3) Period of Employment ____________________________________________________</span> <br/>
						<span> (4) Have you ever been convicted of any criminal offence?  <br/>
						 If so, give particulars: ___________________________________________________________________________________________________<br/>_____________________________________________________________________________________________________________________<br/>______________________________________________________________________________________________________________________<br/>______________________________________________________________________________________________________________________
						</span>
						
						</p>
						<p>
						15. Have you ever suffered from any illness __________________________________________________________________________________<br/>
						If so give particulars _____________________________________________________________________________________________________
						</p>
						<p>
						16. Have you given an undertaking to anybody to repay money in advance from education?___________________________________________
						</p>
						<p>
						17. Are you a judgement debtor? ___________________________________________________________________________________________<br/>
						or  are there any write from debts outstanding against you? If so give particulars ____________________________________________________
						</p>
						<p>
						18. Officer employee's details of service in the forces (if applicable) <br/>
						_______________________________________________________________________________________________________________________<br/> _______________________________________________________________________________________________________________________<br/> _______________________________________________________________________________________________________________________
						</p>
						<p>
						a. Decoration: <br/>
						_______________________________________________________________________________________________________________________<br/>_______________________________________________________________________________________________________________________<br/>_______________________________________________________________________________________________________________________
						</p>
						<p>
						b. What is your religion? _____________________________________
						</p>
						<p>
						I hereby certify on honour that the information given over the above are true and correct to the best of my knowledge.
						</p>


						</div>

						</div><!-- end row-->

						<div class="row">

						<div class="col-md-12">
						<br/><br/>
						
						<table style="width: 100%;" id="tab">
							<tr>
							<td>___________________________<br/>
							<div style="margin-bottom: 25px">
							Signature
							</div>
							</td>
							<td>___________________________<br/>
							<div style="margin-bottom: 15px">
							Date
							</div>
							</td>
							</tr>

							<tr>
							<td>	___________________________<br/>
							<div style="margin-bottom: 25px">
							Witness of Signature
							</div>
							</td>
							<td>
							___________________________<br/>
							<div style="margin-bottom: 15px">
							Date
							</div>
							</td>
							</tr>

						</table>
						
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