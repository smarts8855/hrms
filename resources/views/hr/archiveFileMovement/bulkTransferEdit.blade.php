@extends('layouts.layout')

@section('pageTitle')
  Edit File To Re-send
@endsection

<style type="text/css">

    .length
    {
    	width: 80px;
    }
    .remove
    {
    	padding-top: 12px;
    	cursor: pointer;
    }
</style>

@section('content')
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
					{{ csrf_field() }}

				<div class="col-md-12"><!--2nd col-->
					<div class="row">
						<div class="col-md-12">

						</div><!-- /.col -->
						</div><!-- /.row -->
						<form method="post" action="{{ url('/archive-transfer/updatefile')}}">
						    {{ csrf_field() }}

						    <div class="row">
						    <div class="col-md-12">
							<table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
							<tr>
							<th class="duplifer-highlightdups">File No.</th>
							<th>File Name/Description</th>
                            <th>Volume</th>
                            <th>Last Page</th>
                            <th></th>
							</tr>
							</thead>
							<tbody>
							<tr>
							    <td>{{$file->fileNo}}</td>
							    <td>{{$file->file_description}}</td>
							    <td><input type="text" class="form-control length" style="width:80px;" name="volume" value="{{$file->fileVolume}}"></td>
							    <td><input type="text" class="form-control length" style="width:80px;" name="lastPage" value="{{$file->fileLastPage}}"></td>
							</tr>

							</tbody>
							</table>

						    </div>
						    </div>


							<div class="row">

								<input type="hidden" name="bulkID" value="{{$bulkID}}"/>
								<input type="hidden" name="fileNo" value="{{$file->fileNo}}"/>
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Destination <span class="text-danger"><b>*</b></span></label>
										<select name="destination" id="destination" class="form-control select2">
										<option value="">Select One</option>
										@foreach($department as $section)
										<option value="{{$section->id}}" @if($file->destination ==$section->id) selected @endif >{{$section->department}}</option>
										@endforeach

										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Name Of Recipient <span class="text-danger"><b>*</b></span></label>
										<select name="recipient" id="recipient" class="form-control">
										<option value="{{$recipient->UserID}}">{{$recipient->surname}} {{$recipient->first_name}} {{$recipient->othernames}}</option>
										</select>
									</div>
								</div>

							</div>

							<div class="row" id="outhidden">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Purpose Of Movement</label>
										<textarea name="purpose" id="purpose" class="form-control">{{$file->purpose}}</textarea>
									</div>
								</div>

								<div class="col-md-6" id="inhidden">
									<div class="form-group">
										<label for="month">Date of Transfer <span class="text-danger"><b>*</b></span></label>
										<input type="text" name="transferDate" id="transferdate" class="form-control" value="{{date('d-M-Y', strtotime(trim($file->date_transfered)))}}"/>
									</div>
								</div>
								<div class="col-md-6" id="inhidden">
									<div class="form-group">
										<label for="month">Expected Return Date <span class="text-danger"><b>*</b></span></label>
										<input type="text" name="returnDate" id="returndate" class="form-control" value="{{date('d-M-Y', strtotime(trim($file->return_date)))}}"/>
									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<!--<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="#" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>-->
								</div>

								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update <i class="fa fa-save"></i>
										</button>
									</div>
								</div>


								</div>
							</div>

							</form>
							<hr />


					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->


		  <form action="" method="post">
		  {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="myModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="padding: 10px; border-radius: 6px;">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Add New Next of Kin</b></h4>
					                </div>
					                <div class="modal-body">
					                    <div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Name</label>
												<input type="text" name="fullName" class="form-control" />
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Relationship</label>
												<input type="text" name="relationship" class="form-control"/>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Address</label>
												<textarea name="address" class="form-control"></textarea>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Phone Number</label>
												<input type="text" name="phoneNumber" class="form-control" placeholder="Optional" />
											</div>
										</div>
									</div>
					                </div>
					              </div>
					            </div>

			                <div class="modal-footer-not-use" align="right">
			                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Close</button>
			                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save</button>
			                </div>

			            </div>
			        </div>
			    </div>
			</div>
		  </form>
	</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
     <script>
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});
	</script>

<script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/archive-movement/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {

$('#nameID').val(suggestion.data);
var fileNo = suggestion.data;
//showAll();
var tableID = 'servicedetail';



//retrieve records from db
$.ajax({

    type: 'post',
    url: murl +'/archive-movement/get-staff',
    data: {'nameID': fileNo, '_token': $('input[name=_token]').val()},

   success: function(datas){
   	location.reload(true);
   	//console.log(datas);

   /* $.each(datas, function(index, obj){
    	//console.log(obj.fileNo);
    	if(obj.fileNo  == 1)
    	{
    		alert('File Already Selected');
    	}
    	else
    	{
        var tr = $("<tr></tr>");
        tr.append("<td>"+ obj.fileNo +" <input type='hidden' class='form-control length' style='width:80px;' name='fileNo[]' value='"+ obj.fileNo +"'></td>");
        tr.append("<td>"+ obj.first_name +"</td>");
        tr.append("<td>"+ obj.surname +"</td>");
        tr.append("<td>"+ obj.othernames +"</td>");
        tr.append("<td>"+ obj.Designation +"</td>");
        tr.append("<td><input type='text' class='form-control length' style='width:80px;' name='volume[]'></td>");
        tr.append("<td><input type='text' class='form-control length' style='width:80px;' name='lastPage[]'></td>");
        tr.append("<td><i class='fa fa-close remove'></close></td>");
        //tr.append("<td><select name='type' class='form-control'><option>Incoming</option><option>Outgoing</option></select></td>");
        //tr.append("<td><input type='checkbox' name='check'></td>");

        $("#servicedetail").append(tr);
    }
    });*/

}

});


}// end on select






});
  });
</script>
<script type="text/javascript">
	$(document).ready(function(){

 $("#servicedetail").on('click','.remove',function(){
       //$(this).closest('tr').remove();
     });

 $("#servicedetail").on('click','.remove',function(){
   var fileNo = $(this).attr('id');

   $.ajax({
			url: murl +'/archive-transfer/delete-temp',
			type: "post",
			data: {'fileNo': fileNo, '_token': $('input[name=_token]').val()},

	        success: function(data){
		    location.reload(true);

			}
		})

 });

});



(function () {
	$('#destination').change( function(){
    //$('#processing').text('Processing. Please wait...');
    var g = $('#destination').val();
    //alert(g);
		$.ajax({
			url: murl +'/archive-movement/getUsers',
			type: "post",
			data: {'sectionID': g, '_token': $('input[name=_token]').val()},

	    success: function(data){
	        console.log(data)
		$('#recipient').empty();
		 $('#recipient').append( '<option value="">Select One</option>' );
        $.each(data, function(index, obj){
        $('#recipient').append( '<option value="'+obj.UserID+'">'+obj.surname+' '+obj.first_name+'</option>' );
        });

			}
		})
	});}) ();



$( function() {
	    $("#returndate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#returndate").val(dateFormatted);
        	},
		});


  } );

  $( function() {
	    $("#transferdate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#transferdate").val(dateFormatted);
        	},
		});
  });

</script>


<script type="text/javascript">
	$(document).ready(function()
    {
  // function displayResult() {
       //save selected records to DB
        //setInterval(function(){
  $token = $("input[name='_token']").val();
$.ajax({
 headers: {'X-CSRF-TOKEN': $token},
    type: 'get',
    url: murl +'/archive-transfer/get-temp',
    //data: {'_token': $('input[name=_token]').val()},

   success: function(datas){
   	console.log(datas);

    $.each(datas, function(index, obj){
    	console.log(obj.fileNo);
    	//alert('ok');
        var tr = $("<tr></tr>");
        tr.append("<td>"+ obj.fileNo +" <input type='hidden' class='form-control length fileNo'  style='width:80px;' name='fileNo[]' value='"+ obj.fileNo +"'></td>");
        tr.append("<td>"+ obj.file_description +"</td>");
        /*tr.append("<td>"+ obj.surname +"</td>");
        tr.append("<td>"+ obj.othernames +"</td>");
        tr.append("<td>"+ obj.Designation +"</td>");*/
        tr.append("<td><input type='text' class='form-control length' style='width:80px;' name='volume[]'></td>");
        tr.append("<td><input type='text' class='form-control length' style='width:80px;' name='lastPage[]'></td>");
        tr.append("<td><i class='fa fa-close remove' id='"+ obj.fileNo +"'></i></td>");
        //tr.append("<td><select name='type' class='form-control'><option>Incoming</option><option>Outgoing</option></select></td>");
        //tr.append("<td><input type='checkbox' name='check'></td>");

        $("#servicedetail").append(tr);

    });

    //$("#selectFile").html(datas);

}


});
//end retrieve result
// }, 2000);
//}//end function
//displayResult(); // To output when the page loads
//setInterval(displayResult, (2 * 1000)); // x * 1000 to get it in seconds

    });
</script>
@endsection
