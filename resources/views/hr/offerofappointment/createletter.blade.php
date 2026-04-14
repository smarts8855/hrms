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
	.text-size .col-md-12 p
	{
		font-size: 18px;
		line-height: 32px;
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
 <div class="box box-default" style="border:none;">
    <div class="box-body box-profile" style="border:none;">
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
						

						                     <!-- <form method="post" action="" class="hidden-print">
                                             {{ csrf_field() }}
                                             <label>Select Eployee</label>
                                             <select name="fileid" id="fileid" class="form-control">
											<option value="0" selected="selected">Choose one</option>
											@foreach($perList as $prolist)

									                  <option value="{{$prolist->fileNo}}">{{$prolist->surname }}  {{$prolist->first_name}}</option>
									                  @endforeach
									                  
									                  
								                  </select>	
						            		 </form>
						            		

						            		 <div class="clear"></div>
						            		}
						            		}
						            		-->

                         <form method="post" action="{{url('/offerofappointment/addletter')}}">
                         {{ csrf_field() }}
						<div class="row">
						<table style="width: 100%">
						<tr>
						<td>
						<div class="col-md-5">
						<h6><span>Ref. No NICB/455/03/VOL. IV/</span> <span><input type="text" name="fileno" id="fileno" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="_________________________"></span></h6>
							
							<div class="form-group">
							
							<textarea name="address" id="address" class="form-control stylecontrol" style="overflow:hidden; height: 90px;" placeholder="______________________________________________________________________________________________________________________________________________________________________________"></textarea>
							</div>
						</div>
						</td>
						<td>
						<div class="col-md-6 col-md-offset-1 ">
							
							<h6><input type="text" name="dateissued" id="dateissued" class="form-control stylecontrol" style="width:90%; display: inline;" placeholder="___________________________________________"></h6>
						</div>

						</div><!-- end row-->
						</td>
						</tr>
						</table>

						<div class="row">
						<div class="col-md-12">
							<h2 style="text-align: center">LETTER OF APPOINTMENT</h2>
						</div>
						</div>

						<div class="row">

						<div class="col-md-3">
						
						</div>

						</div><!-- end row-->

						<div class="row text-size" >

						<div class="col-md-12">
						<p> 
						With reference to your acceptance on form Gen. 75 dated <input type="text" name="acceptdate" id="acceptdate" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="____________________________"> of offer of provisional appointment as contained in our letter <strong>Ref. No. NICV/455/03/VOL. IV/ <input type="text" name="file" id="file" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="____________________"></strong> dated <input type="text" name="offerdate" id="dateoffer" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="___________________">. I have the honour to inform you that you have been appointment with effect from <input type="text" name="effectdate" id="effectdate" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="_______________"> as <input type="text" name="position" id="position" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="___________________"> on total emolument of <input type="text" name="emolument" id="emolument" class="form-control stylecontrol" style="width:20%; display: inline;" placeholder="________________________"> per annum on the conditions specified in the offer of appointment form Gen. 69.

						
						</p>
						</div>

						</div><!-- end row-->

						<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<!--<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<input type="submit" name="print" class="btn btn-success hidden-print" value="Print">
									</div>-->
								</div>
								
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<input type="submit" name="add" class="btn btn-success hidden-print" value="Add">
										<!--<input type="submit" name="update" class="btn btn-success hidden-print" value="Update">-->	
									</div>
								</div>
								
										
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
  url: "{{ url('/offerofappointment/letterfileno') }}",

  type: "post",
  data: {'fileno': id},
  success: function(data){
    
    $('#fileno').val(data.fileNo);
    $('#address').val(data.address);
    $('#dateissued').val(data.dateissued);
    $('#acceptdate').val(data.acceptdate);
    $('#dateoffer').val(data.refdate);
    $('#effectdate').val(data.effectdate);
    $('#position').val(data.position);
    $('#file').val(data.fileNo);
    $('#emolument').val(data.emolument);

    
  }
});
});
});

  $( function() {
	    $("#dateissued").datepicker({
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
				$("#dateissued").val(dateFormatted);
        	},
		});

  } );

    $( function() {
	    $("#acceptdate").datepicker({
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
				$("#acceptdate").val(dateFormatted);
        	},
		});

  } );

      $( function() {
	    $("#effectdate").datepicker({
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
				$("#effectdate").val(dateFormatted);
        	},
		});

  } );
$( function() {
	    $("#refdate").datepicker({
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
				$("#refdate").val(dateFormatted);
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
</script>
@endsection