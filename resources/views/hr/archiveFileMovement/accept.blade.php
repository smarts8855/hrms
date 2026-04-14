@extends('layouts.layout')

@section('pageTitle')
  Files Transferred to Officer
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

						<h3 class="text-center" style="text-transform: uppercase;">Files Transferred to Officer</h3>

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
							<th>Name</th>
							<th>Origin</th>
							<th>Destination</th>
							<th>Recipient</th>
                            <th>Volume</th>
                            <th>Last Page</th>
                            <th>Date Sent</th>
                            <th>Status</th>
							<th></th>
							<th></th>
                            <th></th>
							</tr>
							</thead>
							<tbody>

							@foreach($acceptance_view as $list)
							@php
			                if($list->bulkStatus ==0)
			                {
			                  $value = "Accept?";
			                }
			                elseif($list->bulkStatus ==1)
			                {
			                  $value = "Accepted";
			                }
			                $origin = DB::table('tbldepartment')->where('id','=',$list->origin_dept)->first();
			                $destination = DB::table('tbldepartment')->where('id','=',$list->destination)->first();
			                $user = DB::table('tblper')->where('UserID','=',$list->recipient)->first();
			                if($userSection == '')
			                {
			                $userid = 0;
			                $dept = 0;
			                }
			                else
			                {
			                $userid = $userSection->UserID;
			                $dept = $userSection->department;
			                }
			                @endphp
							@if($list->recipient == $authUser)
							<tr>
							<td>{{$list->fileNo}}</td>
							<td>{{$list->file_description}}</td>
							<td>@if($origin != ''){{$origin->department}} @endif</td>
							<td>{{$destination->department}}</td>
							<td>{{$user->surname ?? ''}} {{$user->first_name ?? ''}}</td>
							<td>{{$list->fileVolume}}</td>
							<td>{{$list->fileLastPage}}</td>
							<td>{{date('d-M-Y', strtotime(trim($list->date_transfered)))}}</td>
							<td>{{$list->status_description}} <br/>
							@if($list->is_resent == 1)

							@php
							$db = DB::table('tbltracking_comments')->where('bulkID','=',$list->bulkID)->where('is_resent','=',1)->first();
							@endphp

							<a href="javascript:void" id="{{$list->bulkID ?? ''}}" reason="{{$db->comment ?? ''}}" class="reason" >View Reason</a>
							@endif
							</td>
							<td>
							@if($list->bulkStatus ==0)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" class="confirmx" value ="confirm">Accept?</a>

							@elseif($list->bulkStatus ==1)
							{{'Accepted.'}}

							@elseif($list->bulkStatus ==4)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" class="confirmx" value ="confirm">Accept?</a>
							@endif

							</td>
							<td>

							@if($list->bulkStatus ==0)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" fileID="{{$list->ID}}" class="reject" value ="reject">Reject?</a>

							@elseif($list->bulkStatus ==4)
							{{'Rejected.'}}

							@elseif($list->bulkStatus ==1)
							<i class="fa fa-check"></i>
							@endif

							</td>
                            <td>
								@if($list->status_description == "File Accepted")<a href="{{url('/view-documents/'.$list->fileID.'/'.$list->fileVolume)}}">View document</a>@endif
							 </td>
							</tr>


							@elseif($list->recipient == 0 && $list->file_destination_section == $dept && $userSection != '')
							<tr>
							<td>{{$list->fileNo}}</td>
							<td>{{$list->file_description}}</td>
							<td>@if($origin != ''){{$origin->department}} @endif</td>
							<td>{{$destination->department}}</td>
							<td>{{$user->surname ?? ''}} {{$user->first_name ?? ''}}</td>
							<td>{{$list->volume_name}}</td>
							<td>{{$list->fileLastPage}}</td>
							<td>{{date('d-M-Y', strtotime(trim($list->date_transfered)))}}</td>
							<td>{{$list->status_description}} @if($list->is_resent == 1)

							@php
							$db = DB::table('tbltracking_comments')->where('bulkID','=',$list->bulkID)->where('is_resent','=',1)->first();
							@endphp

							<a href="javascript:void" id="{{$list->bulkID ?? ''}}" reason="{{$db->comment ?? ''}}" class="reason" >Reason</a>
							@endif</td>
							<td>
							@if($list->bulkStatus ==0)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" class="confirmx" value ="confirm">Accept?</a>

							@elseif($list->bulkStatus ==1)
							{{'Accepted.'}}

							@elseif($list->bulkStatus ==4)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" class="confirmx" value ="confirm">Accept?</a>
							@endif

							</td>
							<td>

							@if($list->bulkStatus ==0)
							<a href="javascript:void" id="{{$list->fileNo}}" tansferID="{{$list->bulkID}}" fileID="{{$list->ID}}" class="reject" value ="reject">Reject?</a>

							@elseif($list->bulkStatus ==4)
							{{'Rejected.'}}

							@elseif($list->bulkStatus ==1)
							<i class="fa fa-check"></i>
							@endif

							</td>
							<td>
								@if($list->status_description == "File Accepted")
								 <a href="{{url('/view-documents/'.$list->fileID.'/'.$list->fileVolume)}}">View document</a>
								@endif
							</td>


							</tr>

							@endif
							@endforeach

							</tbody>
							</table>

						    </div>
						    </div>



							</form>

		        </div><!-- /.col -->
		    </div><!-- /.row -->


		  <form action="{{url('file-tracking/comment')}}" method="post">
		       {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="commentModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="padding: 10px; border-radius: 6px;">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Comments/Minutes</b></h4>
					                </div>
					                <div class="modal-body">
					                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="month">Reason for rejecting</label>
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

		  <!-- acceptance modal -->

		   <form action="{{url('/archive-movement/confirmation')}}" method="post">
		       {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="acceptModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

					                </div>
					                <div class="modal-body">

					                <h4 class="modal-title"><b>Do you really want to perform this action ?</b></h4>
					                <input type="hidden" name="fileNo" id="fileNo"/>
									<input type="hidden" name="value" id="val" />
									<input type="hidden" name="bulkID" id="bulkID" />
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

		  <!--// Acceptance Modal-->

		  <!-- Re sent -->
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
					                    <h4 class="modal-title"><b>Reason for Re-sending</b></h4>
					                </div>
					                <div class="modal-body">

                                        <p id="reason"></p>

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
		 <!-- Resend Reason -->

	</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

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

<script>

$(document).ready(function(){
	$('.reject').click(function(){
	    var id = $(this).attr('id');
       var fileID = $(this).attr('fileID');
       var bulkID = $(this).attr('tansferID');
       $("#fileno").val(id);
       $("#fileID").val(fileID);
       $("#bulkId").val(bulkID);
	   $('#commentModal').modal('show');
	});
});

$(document).ready(function(){
	$('.confirmx').click(function(){
	   var id = $(this).attr('id');
       var value = $(this).attr('value');
       var bulkID = $(this).attr('tansferID');
       $("#fileNo").val(id);
       $("#val").val(value);
       $("#bulkID").val(bulkID);
	   $('#acceptModal').modal('show');
	});
});

 $(document).ready(function(){
	$('.reason').click(function(){
	    var reason = $(this).attr('reason');

       $("#reason").html(reason);
		$('#reasonModal').modal('show');
	});
});
</script>

@endsection
