@extends('layouts.layout')

@section('pageTitle')
 	Edit File Registry
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

		            @includeIf('Share.message')

				<div class="col-md-12"><!--2nd col-->

				   <form method="post" action="{{ url('/update-file')}}">
						@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">File No. / Name</label>
										<input type="text" name="fileName" id="filename" class="form-control" value="{{ isset($editRecord) && $editRecord ? $editRecord->fileNo : '' }}"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">File Category</label>
										<select name="fileCategory" class="form-control">
											<option value="">Select File</option>
											@if(isset($getCategory) && $getCategory)
												@foreach($getCategory as $listCat)
													<option value="{{$listCat->Id}}" {{ $listCat->Id == (isset($editRecord) && $editRecord ? $editRecord->file_category : '') ? 'selected' : '' }}>{{$listCat->category}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>

							<div class="row" id="outhidden">

								<div class="col-md-6">
									<div class="form-group">
									<label for="month">Volume</label>
									<select name="volume" id="volume" class="form-control">
										<option value="">Select</option>
										@if(isset($getVolume) && $getVolume)
											@foreach($getVolume as $listVol)
												<option value="{{$listVol->ID}}" {{ $listVol->ID == (isset($editRecord) && $editRecord ? $editRecord->volume : '') ? 'selected' : ''}}>{{$listVol->volume_name}}</option>
											@endforeach
										@endif
									</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="month">File Description</label>
									<input type="text" name="description" id="description" class="form-control" value="{{ (isset($editRecord) && $editRecord ? $editRecord->file_description : '') }}"/>
									</div>
								</div>
							</div>

							<div class="row" id="outhidden">
								<div class="col-md-6">
									<label for="shelfNo">Shelf number</label>
                                    <input type="number" name="shelfNo" id="shelfNo" class="form-control"
                                            value="{{ (isset($editRecord) && $editRecord ? $editRecord->shelfNo : '') }}"/>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6">
										<div align="right" class="form-group">
											<label for="month">&nbsp;</label><br />
											<a href="{{url('created-files')}}" class="btn btn-primary">
												Go Back <i class="fa fa-refresh"></i>
											</a>
										</div>
									</div>
										<div class="col-md-6">
										<div align="left" class="form-group">
											<label for="month">&nbsp;</label><br />
											<input type="hidden" name="recordID" class="form-control" value="{{ (isset($editRecord) && $editRecord ? $editRecord->file_ID : '') }}"/>
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

	</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>


     <script>
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});
	</script>

<script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/bulk-movement/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {

$('#nameID').val(suggestion.data);
var fileNo = suggestion.data;
//showAll();
var tableID = 'servicedetail';



//retrieve records from db
$.ajax({

    type: 'post',
    url: murl +'/bulk-movement/get-staff',
    data: {'nameID': fileNo, '_token': $('input[name=_token]').val()},

   success: function(datas){
   	location.reload(true);

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
			url: murl +'/bulk-transfer/delete-temp',
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
		$.ajax({
			url: murl +'/bulk-movement/getUsers',
			type: "post",
			data: {'sectionID': $('#destination').val(), '_token': $('input[name=_token]').val()},

	    success: function(data){
		$('#recipient').empty();
		 $('#recipient').append( '<option value="">Select One</option>' );
        $.each(data, function(index, obj){
        $('#recipient').append( '<option value="'+obj.id+'">'+obj.name+'</option>' );
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
    url: murl +'/bulk-transfer/get-temp',
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

    });
</script>
@endsection
