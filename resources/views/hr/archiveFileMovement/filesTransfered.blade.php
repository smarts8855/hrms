@extends('layouts.layout')

@section('pageTitle')
File Registry
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

						<h3 class="text-center" style="text-transform: uppercase;">All Files You Transferred </h3>

						</div><!-- /.col -->
						</div><!-- /.row -->
						<form method="post" action="{{ url('/archive-movement/confirmation')}}">
						    {{ csrf_field() }}

						    <div class="row">
						    <div class="col-md-12">
							<table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
							<tr>

							<th>File No.</th>
							<th>File Name</th>
							<th>Origin</th>
							<th>Destination</th>
							<th>Recipient</th>
                            <th>Volume</th>
                            <th>Last <br/> Page</th>
                            <th>Date Sent</th>
                            <th>Status</th>
							<th></th>
							<th></th>



							</tr>
							</thead>
							<tbody>
							@foreach($sent_files as $list)
							 @php
			                if($list->status ==0)
			                {
			                  $value = "Accept?";
			                }
			                elseif($list->status ==1)
			                {
			                  $value = "Accepted";
			                }
			                $destination = DB::table('tbldepartment')->where('id','=',$list->destination)->first();
			                $originDept = DB::table('tbldepartment')->where('id','=',$list->origin_dept)->first();
			                $user = DB::table('tblper')->where('UserID','=',$list->recipient)->first();

			                 $bulkIDencode = base64_encode($list->bulkID);
			                 	$allcomments = DB::table('tbltracking_comments')
							->join('users','users.id','=','tbltracking_comments.comment_by')
							->where('bulkID','=',$list->bulkID)->get();
			                @endphp

							<tr>
							<td>{{$list->fileNo}}</td>
							<td>{{$list->file_description}}</td>
							<td>{{$originDept->department}}</td>
							<td>{{$destination->department}}</td>
							<td>{{$user->surname ?? ''}} {{$user->first_name ?? ''}}</td>
							<td>{{$list->fileVolume}}</td>
							<td>{{$list->fileLastPage}}</td>
							<td>{{date('d-M-Y', strtotime(trim($list->date_transfered)))}}</td>
							<td>{{$list->status_description}} <br/> @if($list->status ==4)

							-
							@php
							$db = DB::table('tbltracking_comments')->where('fileNo','=',$list->fileNo)->first();


							@endphp
							<a href="javascript:void" id="{{$list->fileNo ?? ''}}" bulkID="{{$list->bulkID ?? ''}}" reason="{{$db->comment ?? ''}}" class="reason" > View Reason</a>
							@endif



							@if($list->status ==4)
							-

							<a href="javascript:void" id="{{$list->fileNo}}" class="agree" value ="cancel">Agree?</a>
							@endif
							</td>

							<td>
							@if($list->status ==4)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" fileID="{{$list->ID}}" class="btn btn-success resend btn-sm" value ="resend">Re-send</a>
							<a href="{{url('/archive-transfer/editfile/'.$bulkIDencode)}}" id="{{$list->fileNo}}" class="btn btn-success edit btn-sm" value ="edit">Edit</a>
							@endif
							</td>

							<td>

							@if($list->accepted_by ==0 && $list->status !=4)
							<a href="javascript:void" id="{{$list->fileNo}}" class="recall" value ="cancel">Recall</a>
							@endif
							</td>

							</tr>

								<div class="hiddenComment{{$list->bulkID}}" style="display:none;">
							    @if($allcomments != "")
							    @foreach($allcomments as $comm)
							     <div class="minutes">
                                    <p><span><b>Minutes By: {{$comm->name}}</span> | Date: {{date('d-M-Y', strtotime(trim($comm->updated_at)))}}</b></p>
                                    <p>{{$comm->comment}}</p>
                                </div>
							    @endforeach
							    @endif
							</div>

							@endforeach

							</tbody>
							</table>

						    </div>
						    </div>



							</form>

		        </div><!-- /.col -->
		    </div><!-- /.row -->


		  <form action="" method="post">
		  {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="reasonModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Reason for rejecting staff file</b></h4>
					                </div>
					                <div class="modal-body">

                                        <div id="reason">

                                        </div>


					                </div>
					              </div>
					            </div>

			                <div class="modal-footer-not-use" align="right">
			                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Close</button>

			                </div>

			            </div>
			        </div>
			    </div>
			</div>
		  </form>

		  <!-- Cancel or Agree Modal -->

		  <form action="{{url('/archive-transfer/cancel')}}" method="post">
		       {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="cancelModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="padding: 10px; border-radius: 6px;">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

					                </div>
					                <div class="modal-body">

					                <h4 class="modal-title"><b>Do you really want to perform this action ?</b></h4>
					                <input type="hidden" name="fileNo" id="fileNo"/>
									<input type="hidden" name="value" id="val" />

					                </div>
					              </div>
					            </div>

			                <div class="modal-footer-not-use" align="right">
			                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> No</button>
			                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Yes</button>
			                </div>

			            </div>
			        </div>
			    </div>
			</div>
		  </form>

		  <!-- // Cancel or agree modal -->


		   <!-- Re sent -->
		  <form action="{{url('file-tracking/resend')}}" method="post">
		       {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="resendModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Resend File</b></h4>
					                </div>
					                <div class="modal-body">
					                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="month">Reason for resending</label>
												<textarea name="comment" class="form-control"></textarea>
												<input type="hidden" name="fileNo" id="fileno" />
												<input type="hidden" name="fileID" id="fileID" />
												<input type="hidden" name="bulkID" id="bulkId" />
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
		 <!-- Resend Reason -->



	</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<style type="text/css">
    table tr td
    {
        font-size:13px !important;
    }
     table tr th
    {
        font-size:14px !important;
    }
</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>


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
  var value = $(this).attr('value');
  //alert(id);
   //var value = $(this).attr('value');
  // alert(id);
   $token = $("input[name='_token']").val();
   $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/archive-movement/confirmation') }}",

  type: "post",
  data: {'fileNo':id,'value':value},
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
  $(document).ready(function(){

$("table tr td .cancel").on('click',function(){
  //alert("ok");
 //var id=$(this).parent().parent().find("input:eq(0)").val();
  var id = $(this).attr('id');
  //var value = $(this).attr('value');
  //alert(id);
   //var value = $(this).attr('value');
  // alert(id);
   $token = $("input[name='_token']").val();
   $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/archive-transfer/cancel') }}",

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
  $(document).ready(function(){

$("table tr td .recall").on('click',function(){
  //alert("ok");
 //var id=$(this).parent().parent().find("input:eq(0)").val();
  var id = $(this).attr('id');
  //var value = $(this).attr('value');
  //alert(id);
   //var value = $(this).attr('value');
  // alert(id);
   $token = $("input[name='_token']").val();
   $.ajax({
  headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('/archive-transfer/recall') }}",

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

<script>
$(document).ready(function(){
	$('.resend').click(function(){
	    var id = $(this).attr('id');
       var fileID = $(this).attr('fileID');
       var bulkID = $(this).attr('tansferID');
       $("#fileno").val(id);
       $("#fileID").val(fileID);
       $("#bulkId").val(bulkID);
	   $('#resendModal').modal('show');
	});
});


    $(document).ready(function(){
	$('.reason').click(function(){
	    var reason = $(this).attr('reason');
	    var bulkID = $(this).attr('bulkID');
	    var reasons = $('.hiddenComment' + bulkID).html();
	    console.log(reasons);
       $("#reason").html(reasons);


		$('#reasonModal').modal('show');
	});
});

$(document).ready(function(){
	$('.agree').click(function(){
	   var id = $(this).attr('id');
       var value = $(this).attr('value');
       $("#fileNo").val(id);
       $("#val").val(value);
	   $('#cancelModal').modal('show');
	});
});
</script>


@endsection
