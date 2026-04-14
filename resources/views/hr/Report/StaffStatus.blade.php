@extends('layouts.layout')
@section('pageTitle')
Staff Status Reports
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        @if ($warning<>'')
	<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$warning}}</strong> 
	</div>
	@endif
	@if ($success<>'')
	<div class="alert alert-dismissible alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$success}}</strong> 
	</div>
	@endif
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
	<form method="post"  id="thisform1" name="thisform1">
		{{ csrf_field() }}
		<div class="box-body">
	            	 <div class="row" style="margin-left:1px;">
	            	 <div class="col-md-3">
	            		<label>Staff Status</label>
					<select name="status" id="status" class="form-control"  >
		                <option value="" selected>-All-</option>
		                	@foreach ($status as $staffStatus)
		                	<option value="{{ $staffStatus->id }}" {{ ($statusx) == $staffStatus->id? "selected":"" }}>{{$staffStatus->status}}</option>
		                	@endforeach
		                </select>
	            		</div>  
	            		
	            		 <div class="col-md-5" style="margin-top:25px;">
	            		    <button type="submit" class="btn btn-success col-md-3" onclick="return checkForm();" name="add">
						        <i class="fa fa-btn fa-search-plus"></i> search
					        </button>
	            		 </div>
	            		 
	            		 <div class="col-md-6" style="margin-top:25px;">
	            		    <span onclick="return myFunc()" class="btn btn-primary pull-right col-md-3" name="add">
        						<i class="fa fa-print"></i> Print
        					</span>
	            		 </div>
	            
	            	</div>
		
	            	
		<input id ="delcode" type="hidden"  name="delcode" >
		
		
		<div class="table-responsive" style="font-size: 12px; padding:10px;">
		
		
		
			<table class="table table-bordered table-striped table-highlight" id="tablr">
			<thead>
			<tr bgcolor="#c7c7c7">
			                <th width="1%">S/N</th>	 
			               
			                <th >NAME IN FULL</th>
			             
				                <th >DATE OF BIRTH</th>
				                <th >GENDER</th>
				                <th >MARITAL  STATUS</th>
				                <th >L.G.A</th>
				                <th >STATE OF ORIGIN</th>		                
				                <th >DATE OF APPOINTMENT</th>
				                <th >RANK</th>
				                <th >DATE OF PRESENT APPOINTMENT</th>
				                <!---<th >Grade</th>
				                <th >Steps</th>
				                <th >Date of present appointment</th>-->
				               @if ($CourtInfo->divisionstatus==1)  <th >Division</th> @endif
				                <!--<th >Qualifications</th>-->
			          
					
				 		</tr>
			</thead>
						@php $serialNum = 1; @endphp
						@foreach ($QueryStaffReport as $b)
							<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</td>
							
								<td class="dob">{{ date("d-m-Y", strtotime($b->dob))}}</td>
									    					
			    					<td class="gender">{{$b->gender}}</td>
			    				
			    					<td class="ms">{{$b->maritalstatus}}</td>
			    				
			    					<td class="lga">{{$b->lga}}</td>
			    					    				
			    					<td class="soo">{{$b->State}}</td>
			    				
			    					<td class="doa">{{date("d-m-Y", strtotime($b->appointment_date))}}</td>
			    				
			    					<td class="rank">{{$b->designation}}</td>
			    				
			    					<td class="dopa">{{date("d-m-Y", strtotime($b->date_present_appointment))}}</td>
			    				
			    					@if ($CourtInfo->divisionstatus==1) <td class="div">{{$b->divisions}}</td> @endif
			    				
			    					<!--<td class="qua">}</td>-->
			    				
			    				
								
							</tr>
						@endforeach
			
						
			 </table>
		</div>
		</div>
		
	</form>
	
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		 $('#fields').multiselect({
		  nonSelectedText: 'Select fields to view',
		  enableFiltering: true,
		  enableCaseInsensitiveFiltering: true,
		  buttonWidth:'400px',
		  includeSelectAllOption: true,
		 });
	});
</script>
<script type="text/javascript">
  
      $("#fromdate").datepicker({
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
        $("#fromdate").val(dateFormatted);
          },
    });

     $("#todate").datepicker({
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
        $("#todate").val(dateFormatted);
          },
    });

</script>
  <script type="text/javascript">
  	function checkForm(){
  		var fields = document.getElementById('fields').value;
  		var form = document.getElementById('thisform1');
  		if(fields == ''){
  			alert('Please select fields to view'); 
  			return false;
  		} else{
  			form.submit();
  		}
  		return false;
  	}
  	
	function  ReloadForm()
	{
	//alert("ururu")	;	
	document.getElementById('thisform1').submit();
	return;
	}
	
	function  DeletePromo(id)
	{
		var cmt = confirm('You are about to delete a record. Click OK to continue?');
              if (cmt == true) {
					document.getElementById('delcode').value=id;
					document.getElementById('thisform1').submit();
					return;
 
              }
	
	}
  $( function() {
    $( "#todate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#fromdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );
  </script>
  <script>
  function myFunc(){
		var printme = document.getElementById('tablr');
		var wme = window.open("", "", "width=900,height=700");
		wme.document.write(printme.outerHTML);
		wme.document.close();
		wme.focus();
		wme.print();
		wme.close();
	}
	</script>
<script>
        
        $.ajax({
        url: "/report/get-designation",
        type:"POST",
        data:{
          department:$('#department').val(),
          "_token": "{{ csrf_token() }}"
        },
        success:function(response){
                    
                 $.each(response, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#designation').append('<option value="' + d.id + '">' + d.designation + '</option>');
                });
                $('#designation').val($('#designation').attr('data-designation'))
               
        },
       });

    
    $('#department').on('change',function(){
        $.ajax({
        url: "/report/get-designation",
        type:"POST",
        data:{
          department:$(this).val(),
          "_token": "{{ csrf_token() }}"
        },
        success:function(response){
                 $('#designation').empty()
                  $('#designation').append('<option value="" selected>-All designition-</option>')
                 $.each(response, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#designation').append('<option value="' + d.id + '">' + d.designation + '</option>');
                });
               
        },
       });
    })
</script>
@endsection
