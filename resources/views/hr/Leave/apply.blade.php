@extends('layouts.layout')
@section('pageTitle')
<strong>Leave Application</strong>
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>


            @if(session('message'))
	        <div class="alert alert-success alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
	          <strong>Successful!</strong> {{ session('message') }}</div>
	        @endif
	        @if(session('error_message'))
	        <div class="alert alert-danger alert-dismissible" role="alert">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
	          <strong>Error!</strong> {{ session('error_message') }}</div>
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

	<form method="post"  id="thisform" name="thisform" class="form-horizontal">
		{{ csrf_field() }}
		<div class="box-body">

			 <div class="form-group">
			    <div class="col-lg-12">
	            		<label>Leave Type</label>
				<select name="leaveType" id="leaveType" required class="form-control" onChange="checkRoaster()">
		                        <option value="" selected>-Select Type-</option>
		                	@foreach ($LeaveTypeList as $b)
						        <option value="{{$b->id}}" {{ ($leaveType) == $b->id? "selected":"" }}>{{$b->leaveType}}</option>
		                	@endforeach
		                </select>
	            		</div>
			 </div>

	 <div id="divID" style="display:none">
			 <div class="form-group">

			 	<div class="col-lg-4">
	            		<label>Staff Details</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$staffDetails->surname }}, {{$staffDetails->first_name }} {{$staffDetails->othernames }}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Total Allowable</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{ isset($noOfDays) ? $noOfDays->noOfDays : ''}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Remaining days</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{ isset($daysRemaining) ?  $daysRemaining : ''}}" disabled="">
	            		</div>
	            			<div class="col-lg-2">
	            		<label>Days Consumed</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{ isset($daysConsumed) ? $daysConsumed : ''}}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Period</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{ isset($period) ? $period : ''}}" disabled="">
	            		</div>
	            	</div>

	            	<div class="form-group">
			 	<div class="col-lg-4">
	            		<label>Start date</label>
				<input type="text" name="startdates" id="startdate" class="form-control startdateAnn" value=""  />
	            		</div>
	            		<div class="col-lg-4">
	            		<label>End date</label>
				<input type="text" name="enddates" id="enddate" class="form-control enddateAnn" value=""  />
	            		</div>
	            		<div class="col-lg-4">
	            		<label>No. Days</label>
				<select name="nod1" id="nodx" class="form-control" >
		                <option value="" selected>Select</option>
		                	@for ($i = 1; $i < 30; $i++)
		                	<option value="{{ $i }}" {{ ($nod) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>

	            	</div>

	            	<div class="form-group">
			 	<div class="col-lg-6">
	            		<label>Purpose</label>
				<textarea class="form-control" name="purposes" rows="3">{{$purpose}}</textarea>
	            		</div>
	            		<div class="col-lg-6">
	            		<label>Address during the leave</label>
				<textarea class="form-control" name="addresss" rows="3">{{$address}}</textarea>
	            		</div>

	            	</div>
	            	<div class="form-group">
				<div class="col-lg-12 col-lg-offset-0">

				<button type="submit" class="btn btn-success" name="Save">
						<i class="fa fa-btn fa-floppy-o"></i> Save
				</button>

				<!-- <button type="submit" class="btn btn-success" name="update">
					<i class="fa fa-btn fa-floppy-o"></i> Update
				</button>

				<button type="submit" class="btn btn-success" name="reset">
					<i class="fa fa-btn fa-newspaper-o"></i> Reset
				</button> -->
				</div>
			</div>

	</div>

	<div id="divIDs" style="display:none">
	    <h3>You're not eligible for this year annual leave</h3>
	</div>


	<div id="divIDx" style="display:none">
			 <div class="form-group">

			 	<div class="col-lg-4">
	            		<label>Staff Details</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$staffDetails->surname }}, {{$staffDetails->first_name }} {{$staffDetails->othernames }}" disabled="">
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Total Allowable</label>
				       	<select name="tnod" id="tnod" class="form-control" disabled="">

		                </select>
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Remaining days</label>
				       	<select name="rnod" id="rnod" class="form-control" disabled="">

		                </select>
	            		</div>
	            			<div class="col-lg-2">
	            		<label>Days Consumed</label>
				       	<select name="dnod" id="dnod" class="form-control" disabled="">

		                </select>
	            		</div>
	            		<div class="col-lg-2">
	            		<label>Period</label>
				<input class="form-control" id="disabledInput" type="text" placeholder="{{$period}}" disabled="">
	            		</div>
	            	</div>

	            	<div class="form-group">
			 	<div class="col-lg-4">
	            		<label>Start date</label>
				<input type="text" name="startdate" id="startdatex" class="form-control" value="{{$roasterCheck->startDate ?? ''}}"  />
	            		</div>
	            		<div class="col-lg-4">
	            		<label>End date</label>
				<input type="text" name="enddate" id="enddatex" class="form-control" value="{{$roasterCheck->endDate ?? ''}}"  />
	            		</div>
	            		<div class="col-lg-4">
	            		<label>No. Days</label>
				<select name="nod2" id="nod" class="form-control" >
		                <option value="" selected>Select</option>
		                	@for ($i = 1; $i <= 30; $i++)
		                	<option value="{{ $i }}" {{ ($nod) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		                </select>
	            		</div>

	            	</div>

	            	<div class="form-group">
			 	<div class="col-lg-6">
	            		<label>Purpose</label>
				<textarea class="form-control" name="purpose" rows="3">{{$purpose}}</textarea>
	            		</div>
	            		<div class="col-lg-6">
	            		<label>Address during the leave</label>
				<textarea class="form-control" name="address" rows="3">{{$address}}</textarea>
	            		</div>

	            	</div>
	            	<div class="form-group">
				<div class="col-lg-12 col-lg-offset-0">

				</div>
			</div>
			<input type="submit" name="Save2x"class="btn btn-success" >
			<!--<button type="submit" class="btn btn-success" name="Save2x">
						<i class="fa fa-btn fa-floppy-o"></i> Save
				</button>
			-->

				<!-- <button type="submit" class="btn btn-success" name="update">
					<i class="fa fa-btn fa-floppy-o"></i> Update
				</button>

				<button type="submit" class="btn btn-success" name="reset">
					<i class="fa fa-btn fa-newspaper-o"></i> Reset
				</button> -->
		</div>

	    </form>


<div class="table-responsive" style="font-size: 12px; padding:10px;">
<table class="table table-striped table-condensed table-bordered input-sm" >
<thead>
<tr>
                <th width="1%">S/N</th>
                <th >START DATE</th>
                <th >END DATE</th>
		        <th >NO. OF DAYS</th>
                <th >LEAVE TYPE</th>
                <th >PURPOSE</th>
                <th >ADDRESS</th>
		        <th >STATUS</th>
                <th >ACTION</th>
</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($LeaveHistory as $b)
				<tr>
				<td><a href="javascript: View('{{$b->id}}')">{{ $serialNum ++}} </a></td>

    				<!-- <td>{{$b->period}}</td> -->
                    <td>{{date('d-M-Y', strtotime($b->startDate))}}</td>
    				<td>{{date('d-M-Y', strtotime($b->endDate))}}</td>
    				<td>{{$b->noOfDays}}</td>
					<td>{{$b->leaveType}}</td>
					<td>{{$b->purpose}}</td>
					<td>{{$b->addressDuringLeave}}</td>
					<td>@if($b->approval_status == 0) <span class="badge badge-danger">Pending</span>
                        @elseif($b->approval_status == 1) <span class="badge badge-success">Approved</span>
                        @elseif($b->approval_status == 2) <span class="badge badge-info">Rejected</span>
                        @endif
                    </td>
                    <td>
                        @if($b->approval_stages_status == 0) <button class="btn btn-primary" onclick="funcPush('{{ $b->leaveID }}')">Push to HOD</button>
                        @elseif($b->approval_stages_status == 1) <span>Application submitted to HOD</span>
                        @endif

                    </td>

				</tr>
			@endforeach
 </table>
</div>

</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">

    function funcPush(x) {

        //alert('sss');
        var y = confirm('                              You are just about to submit to the HOD');
        if(y == true)
        {
            document.location="push-to-hod/"+x;
        }

    }

         $(document).ready(function(){

            $("#leaveType").change(function(e){

                var x = document.getElementById("divID");
                var z = document.getElementById('divIDs')
                var y = document.getElementById("divIDx");
                var t = document.getElementById("leave_type");
                var s = document.getElementById("leave_typex");

                var recordid = e.target.value;
                //alert(recordid);

                if(recordid == 4)
                {

                    $.get('check-roaster?id='+recordid, function(data){

                       if(data == true) {

                        x.style.display = "block";
                        y.style.display = "none";
                        t.style.display = "block";
                        s.style.display = "none";

                       }
                       else {

                            x.style.display = "none";
                            z.style.display = "block";
                            y.style.display = "none";
                            t.style.display = "none";
                            s.style.display = "none";
                       }

                    });

                        document.getElementById("startdate").required = true;
                        document.getElementById("enddate").required = true;
                        document.getElementById("nokx").required = true;

                        document.getElementById("startdatex").required = false;
                        document.getElementById("enddatex").required = false;
                        document.getElementById("nok").required = false;

                }
                else if(recordid == 3) {

                        $.get('check-roaster?id='+recordid, function(data){

                            $('#tnod').empty();
                            $('#rnod').empty();
                            $('#dnod').empty();
                            $.each(data, function(index, obj){
                                $('#tnod').append( '<option value="">'+data.allowableDays+'</option>' );
                                $('#rnod').append( '<option value="">'+data.daysRemaining+'</option>' );
                                $('#dnod').append( '<option value="">'+data.daysConsumed+'</option>' );

                                document.getElementById("startdatex").required = true;
                                document.getElementById("enddatex").required = true;
                                document.getElementById("nok").required = true;

                                document.getElementById("startdate").required = false;
                                document.getElementById("enddate").required = false;
                                document.getElementById("nokx").required = false;

                            });
                        });

                     x.style.display = "none";
                     z.style.display = "none";
                     y.style.display = "block";
                     t.style.display = "block";
                     s.style.display = "none";

                }
                else if(recordid == 2) {

                                           $.get('check-roaster?id='+recordid, function(data){

                                               $('#tnod').empty();
                                               $('#rnod').empty();
                                               $('#dnod').empty();
                                               $.each(data, function(index, obj){
                                                   $('#tnod').append( '<option value="">'+data.allowableDays+'</option>' );
                                                   $('#rnod').append( '<option value="">'+data.daysRemaining+'</option>' );
                                                   $('#dnod').append( '<option value="">'+data.daysConsumed+'</option>' );

                                                   document.getElementById("startdatex").required = true;
                                                   document.getElementById("enddatex").required = true;
                                                   document.getElementById("nok").required = true;

                                                   document.getElementById("startdate").required = false;
                                                   document.getElementById("enddate").required = false;
                                                   document.getElementById("nokx").required = false;

                                               });
                                           });

                                        x.style.display = "none";
                                        z.style.display = "none";
                                        y.style.display = "block";
                                        t.style.display = "block";
                                        s.style.display = "none";

                                   }
                                   else if(recordid == 1) {

                                           $.get('check-roaster?id='+recordid, function(data){

                                               $('#tnod').empty();
                                               $('#rnod').empty();
                                               $('#dnod').empty();
                                               $.each(data, function(index, obj){
                                                   $('#tnod').append( '<option value="">'+data.allowableDays+'</option>' );
                                                   $('#rnod').append( '<option value="">'+data.daysRemaining+'</option>' );
                                                   $('#dnod').append( '<option value="">'+data.daysConsumed+'</option>' );

                                                   document.getElementById("startdatex").required = true;
                                                   document.getElementById("enddatex").required = true;
                                                   document.getElementById("nok").required = true;

                                                   document.getElementById("startdate").required = false;
                                                   document.getElementById("enddate").required = false;
                                                   document.getElementById("nokx").required = false;

                                               });
                                           });

                                        x.style.display = "none";
                                        z.style.display = "none";
                                        y.style.display = "block";
                                        t.style.display = "block";
                                        s.style.display = "none";

                                   }

                })
            });
    //});

	function  ReloadForm()
	{
	//alert("ururu")	;
	document.getElementById('thisform').submit();
	return;
	}

	function  ReloadFormx()
	{
	//alert("ururu")	;
	document.getElementById('thisformx').submit();
	return;
	}

	function  DeletePromo(id)
	{
		var cmt = confirm('You are about to delete a record. Click OK to continue?');
              if (cmt == true) {
					document.getElementById('delcode').value=id;
					document.getElementById('thisform').submit();
					return;

              }

	}
	function  View(id)
	{
		document.getElementById('viewid').value=id;
		document.getElementById('viewnewid').value=1;
		document.getElementById('thisform').submit();
		return;



	}
  	$( function() {
    $( "#startdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#enddate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#startdatex" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#enddatex" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'dd-mm-yy'});
  } );
  </script>
  <script type="text/javascript">
  	$(document).ready(function(){
  		$('.enddateAnn').change(function(){
  			//alert('ok');
		var start = $('.startdateAnn').val();
		var end = $('.enddateAnn').val();
  		$.ajax({
        url: murl +'/cal-numofDays',
        type: "post",
        data: {'start':start, 'end':end, '_token': $('input[name=_token]').val()},
        success: function(data){
        console.log(data);
		$('#nodx').append('<option value=" '+ data +'" selected>'+ data +'</option>')
		  //alert(data);
		}
      });

  		});


      $('.startdateAnn').change(function(){
  			//alert('ok');
		var start = $('.startdateAnn').val();
		var end = $('.enddateAnn').val();
		if(end != '')
		{
  		$.ajax({
        url: murl +'/cal-numofDays',
        type: "post",
        data: {'start':start, 'end':end, '_token': $('input[name=_token]').val()},
        success: function(data){
        console.log(data);
		$('#nodx').append('<option value=" '+ data +'" selected>'+ data +'</option>')
		  //alert(data);
		}
      });
  	 }

  		});


  	});
  </script>
@endsection
