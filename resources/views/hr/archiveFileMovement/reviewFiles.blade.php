@extends('layouts.layout')

@section('pageTitle')
  File Tracking
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

	 <!-- view Files-->
    <div class="box box-default">
    <div class="box-body box-profile">


    <div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>

    <table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
							<tr>
							
							<th>File No</th>
							<th>Name</th>
							
							<th>Edit</th>
							</tr>
							</thead>
							<tbody>
							@foreach($files as $list)
							
							<tr>
							<td>{{$list->fileNo}} <input type="hidden" name="fileNo[]" value="{{$list->fileNo}}"></td>
							<td>{{$list->file_description}}</td>
							
							<td><a href="{{url('/edit/file/'.$list->ID)}}" class="btn btn-success"> <i class="fa fa-edit"></a></td>
							
							</tr>
							
							@endforeach

							</tbody>
							</table>


    </div>
    </div>

             <!--// view Files -->		  
		   
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
												<input type="text" name="fullName" id="" class="form-control" />
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

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>


<script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/profile/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {

$('#nameID').val(suggestion.data);
var fileNo = suggestion.data;
//showAll();

//alert(fileNo);
$.ajax({

    type: 'post',
    url: murl +'/archive-movement/get-staff',
    data: {'nameID': fileNo, '_token': $('input[name=_token]').val()},

   success: function(datas){
   	//console.log(datas);
    $.each(datas, function(index, obj){
    	console.log(obj.fileNo);
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
    });
}

});


}
});
  });
</script>
<script type="text/javascript">
	$(document).ready(function(){

 $("#servicedetail").on('click','.remove',function(){
       $(this).closest('tr').remove();
     });

});

</script>

<script type="text/javascript">
  $(document).ready(function(){
  
$("table tr td .confirm").on('click',function(){
  //alert("ok");
 //var id=$(this).parent().parent().find("input:eq(0)").val();
  var id = $(this).attr('id');
  //alert(id);
   //var value = $(this).attr('value');
  // alert(id);
   $token = $("input[name='_token']").val();
   $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/archive-movement/confirmation') }}",

  type: "post",
  data: {'fileNo':id},
  success: function(data){
    alert(data);
    $('#message').html(data);
  location.reload(true);
  }
});

});
 });
</script>

<script type="text/javascript">
  $(function() {
    $("#autocomplete").autocomplete({
      serviceUrl: murl + '/profile/searchUser',
      minLength: 2,
      onSelect: function (suggestion) {

$('#nameID').val(suggestion.data);
var fileNo = suggestion.data;
//showAll();

//alert(fileNo);
$.ajax({

    type: 'post',
    url: murl +'/archive-movement/get-staff',
    data: {'nameID': fileNo, '_token': $('input[name=_token]').val()},

   success: function(datas){
   	//console.log(datas);
    $.each(datas, function(index, obj){
    	console.log(obj.fileNo);
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
    });
}

});


}
});
  });
</script>
<script type="text/javascript">
	$(document).ready(function(){

 $("#servicedetail").on('click','.remove',function(){
       $(this).closest('tr').remove();
     });

});

</script>

<script type="text/javascript">
	//select all checkboxes
$("#select_all").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){ 
        $("#select_all")[0].checked = true; //change "select all" checked status to true
    }
});


</script>


<script type="text/javascript">
	$(document).ready(function(){

 $("#servicedetail").on('click','.remove',function(){
       $(this).closest('tr').remove();
     });

});



(function () {
	$('#destination').change( function(){
    //$('#processing').text('Processing. Please wait...');
		$.ajax({
			url: murl +'/archive-movement/getUsers',
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
</script>

<script type="text/javascript">
 	$( function() {
	    $("#toDate").datepicker({
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
				$("#toDate").val(dateFormatted);
        	},
		});

  } );

 	$( function() {
	    $("#fromDate").datepicker({
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
				$("#fromDate").val(dateFormatted);
        	},
		});

  } );
 </script>


@endsection
 