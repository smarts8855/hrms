@extends('layouts.layout')
@section('pageTitle')
Generate Memo
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

	<form method="post" action="{{ route('saveMemo') }}"  class="form-horizontal">
		{{ csrf_field() }}
		<div class="box-body">

			 <!-- <div class="form-group">
			    <div class="col-lg-12">
	            		<label>Leave Type</label>
				<select name="leaveType" id="leaveType" required class="form-control" onChange="checkRoaster()">
		                        <option value="" selected>-Select Type-</option>
		                	@foreach ($LeaveTypeList as $b)
						        <option value="{{$b->id}}" {{ ($leaveType) == $b->id? "selected":"" }}>{{$b->leaveType}}</option>
		                	@endforeach
		                </select>
	            </div>
			 </div> -->

	    <div id="divIDx">
			 <div class="form-group">

                        <div class="col-lg-3">
                        <label>To:</label>
                        <input class="form-control" name="leaveType" id="disabledInput" type="hidden" value="{{ $staffDetails->leaveType}}">
                        <input class="form-control" name="staffID" id="disabledInput" type="hidden" value="{{ $staffDetails->pID}}">
                        <input class="form-control"  id="disabledInput" type="text"  value="{{ $staffDetails->surname }} {{ $staffDetails->first_name }}{{ $staffDetails->othernames }}" readonly>
	            		</div>
	            		<div class="col-lg-3">
	            		<label>From:</label>
                        <input class="form-control" name="from" id="disabledInput" type="text" placeholder="" required>
	            		</div>
	            		<div class="col-lg-4">
	            		<label>Subject:</label>
                        <input class="form-control" name="subject" id="disabledInput" type="text" placeholder="" required>
	            		</div>

                        <div class="col-lg-2">
	            		<label>Date</label>
				        <input type="date" name="memo_date"  class="form-control" required/>
	            		</div>

	            	</div>


	            	<div class="form-group">
			 	        <div class="col-lg-12">
	            		<label>Content</label>
				        <textarea class="form-control" id="editor" name="content" rows="3" required></textarea>
	            		</div>

	            	    </div>
	            	<div class="form-group">
				<div class="col-lg-12 col-lg-offset-0">

				</div>
			</div>

			<button type="submit" class="btn btn-success" name="Save">
					<i class="fa fa-btn fa-floppy-o"></i> Save
			</button>
		</div>

	    </form>

<div class="table-responsive" style="font-size: 12px; padding:10px;">
<table class="table table-bordered table-striped table-highlight" >
<thead>
<tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>
                <th >To</th>
                <th >From</th>
                <th >Subject</th>
                <th >Leave Type</th>
                <th >Date</th>
                <th >Action</th>
</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($LeaveHistory as $b)
				<tr>
				<td><a href="javascript: View('{{$b->id}}')">{{ $serialNum ++}} </a></td>

    				<td>{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</td>
    				<td>{{$b->subjectFrom}}</td>
    				<td>{{$b->subject}}</td>
    				<td>{{$b->leaveType}}</td>
                    <td>{{date('d-M-Y', strtotime($b->mdate))}}</td>

                    <td>
                        <a href="../print-memo/{{$b->staffID}}" target="_blank"><span class="btn btn-primary">Print Memo</span></a>
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
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>

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
@endsection
