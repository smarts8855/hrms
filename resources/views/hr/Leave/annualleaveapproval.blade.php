@extends('layouts.layout')
@section('pageTitle')
HOD Approval
@endsection

@section('content')
<div id="viewModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Comment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">
               <div class="table-responsive" id="commenttable" style="height:250px; overflow-x: hidden; overflow-y: auto;">

               </div>
            </div>
                <div class="modal-footer">
                    <!--<button type="submit" class="btn btn-primary btn-xs">Save</button>-->
                    <button type="button" id="btnclose" class="btn btn-success btn-xs" data-dismiss="modal">Close</button>
                </div>

                </form>
            </div>

          </div>
        </div>

    <div id="viewModalFinalAppr" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Comment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="table-responsive" id="commenttable2" style="height:250px; overflow-x: hidden; overflow-y: auto;">

               </div>
            </div>
                <div class="modal-footer">
                    <!--<button type="submit" class="btn btn-primary btn-xs">Save</button>-->
                    <button type="button" id="btnclose" class="btn btn-success btn-xs" data-dismiss="modal">Close</button>
                </div>

                </form>
            </div>

          </div>
        </div>

<div id="apprModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Approve Leave</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form" method="POST" action="{{ url('/recommend/leave') }}">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                     <textarea class="form-control" rows="3"  name="ApprovalComment" id="recommend" placeholder="Enter recommendation comment here..." required></textarea>
                    </div>
                    <input type="hidden" id="ids" name="id" value="">
                    <input type="hidden" id="userID" name="userID" value="">


                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success btn-xs">Yes</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>
    <div id="notifystaffModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Notify Staff</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form" method="POST" action="{{ route('notify-applicant') }}">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                     <textarea class="form-control" rows="3"  name="ApprovalComment" id="xrecommend" placeholder="Enter comment here..." required></textarea>
                    </div>
                    <input type="hidden" id="xids" name="id" value="">
                    <input type="hidden" id="xuserID" name="userID" value="">


                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success btn-xs">Send</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>

        <div id="notifyesadModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Revert</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form" method="POST" action="{{ route('notify-admin') }}">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                     <textarea class="form-control" rows="3"  name="ApprovalComment" id="esrecommend" placeholder="Enter comment here..." required></textarea>
                    </div>
                    <input type="hidden" id="esids" name="id" value="">
                    <input type="hidden" id="esuserID" name="userID" value="">


                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success btn-xs">Send</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>

<div id="rejectModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reject Leave</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form" method="POST" action="{{ url('/reject/leave') }}">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                       <textarea class="form-control" rows="3"  name="ReasonForRejection" id="reject" placeholder="State reason here..." required></textarea>
                    </div>

                    <input type="hidden" id="id2" name="id" value="">
                    <input type="hidden" id="userID2" name="userID" value="">


                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success btn-xs">Reject</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>

 <div id="cancelModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cancel Leave</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form" method="POST" action="{{ url('/cancel/leave') }}">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                      <textarea class="form-control" rows="3"  name="ReasonForCancellation" id="cancel" placeholder="State reason here..." required></textarea>
                    </div>

                    <input type="hidden" id="id3" name="id" value="">
                    <input type="hidden" id="userID3" name="userID" value="">


                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success btn-xs">Cancel Leave</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>


<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title"><strong>@yield('pageTitle')</strong> <span id='processing'></span></h3>
        </div>
        <div class="box-header with-border hidden-print">
          <h1 class="box-title"><i class="fa fa-user"></i> Welcome: <b style="border-radius: 25px;padding:6px;color:green">{{ $userdetail->surname }}, {{ $userdetail->first_name}} {{ $userdetail->othernames}} <span id='processing'></span></b></h1>
          <br>
          @php

            //use Carbon\Carbon;
            //$dt=Carbon::now();
            //$t=$dt->daysInMonth;
            //echo $t.'<br>';
            //$r=$dt->isWeekday();
            //echo $r.'<br>';
            //$rs=$dt->isWeekend();
            //echo $rs;
            //dd($rs);

          @endphp
        </div>
         @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Successful!</strong> {{ session('message') }}</div>
        @endif
        @if(session('error_message'))
        <div class="alert alert-error alert-dismissible" role="alert">
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


<div class="box-body">

<div class="table-responsive" style="font-size: 11px; padding:10px;">
<table class="table table-bordered table-striped table-highlight" id="mytable">
{{ csrf_field() }}
<thead>
<tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>
                <th >STAFF NAME</th>
                <th >YEAR</th>
                <th >START DATE</th>
                <th >END DATE</th>
		        <th >NO. OF DAYS</th>
		        <th >LEAVE TYPE</th>
		        <th >COMMENT</th>
                <th >HOD STATUS</th>
                <th >FINAL APPROVAL</th>
                <th >APPLICATION DATE</th>
                <th>APPROVE</th>
                <th>REJECT</th>
                <!--<th>Cancel</th>-->

</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($displaystaffdetail as $b)
				<tr>
				<td>{{ $serialNum ++}}</td>
    			<td>{{$b->name}}</td>
    			<td>{{$b->year}}</td>
    			<td>{{date('d-M-Y', strtotime($b->startdate))}}</td>
    				<td>{{date('d-M-Y', strtotime($b->endate))}}</td>
    			<td>{{$b->nod}}</td>
				<td>{{$b->leavetype}}</td>
				<td>@if ($b->comment==null) {{'No Comment'}} @else {{$b->comment}} @endif</td>
				<td>
				 @foreach($getleavestatus as $l)
				   @if($l->id==$b->hodstatus)

				      @if($l->status=="Pending")
				         @if($b->reapply==1)
				            <b><i style="color:blue"> {{ $l->status }}</i></b>
				            <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfuncHODES('{{$b->id}}')">view</a></i>
				         @elseif($b->reapply==0)
				            <b><i style="color:blue"> {{ $l->status }}</i></b>
				         @endif
				      @elseif($l->status=="Approved")
				      <b><i><a style="cursor: pointer;" onclick="viewfuncHODES('{{$b->id}}')"> {{ "Recommend for approval" }}</a></i>

				      </b>

				       @elseif($l->status=="Reject")
				      <b><i style="color:brown"> {{ $l->status }}</i>
				      &nbsp
                            <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfuncHODES('{{$b->id}}')">view</a></i>
				      </b>
				      @else
				      @endif

				   @else
				   @endif
				 @endforeach
				</td>
				<td>
				 @foreach($getleavestatus as $l)
				   @if($l->id==$b->finalapprstatus)

				      @if($l->status=="Pending")
				        @if($b->hodstatus==3)
				            <center>{{'--'}}</center>
				        @else
				            @if($b->reapply==1)
				               @if($b->finalapprcomment==null)
				                <b><i style="color:blue"> {{ 'waiting approval' }}</i></b>
				               @else
				                 <b><i style="color:blue"> {{ 'waiting approval' }}</i></b>
				                 <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfunc2('{{$b->id}}')">view</a></i>
				               @endif
				            @elseif($b->reapply==0)
				                <b><i style="color:blue"> {{ 'waiting approval' }}</i></b>
				            @endif
				        @endif
				      @elseif($l->status=="Approved")
				      <a style="cursor: pointer;" onclick="viewfunc2('{{$b->id}}')">{{ $l->status }}</a></i>
				      &nbsp


                             <!--<a class="btn btn-success btn-xs" style="cursor: pointer;"> Approved</a>-->
				      </b>
				      @elseif($l->status=="Reject")
				      <b><i><a style="cursor: pointer;color:red" onclick="viewfunc2('{{$b->id}}')">{{ 'Rejected' }}</a></i>

                            <p>&nbsp;</p>
                            @if($b->reapply_status==1)
                             <input type="checkbox" id="notify" class="form-check-input" value="{{$b->id}}" checked="true"><strong id="notifydiv">Staff Notified</strong>
                            @elseif($b->reapply_status==0)
                            <button class="btn btn-info btn-xs glyphicon glyphicon-edit" style="cursor: pointer;" onclick="notifystafffunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
                            <button class="btn btn-danger btn-xs glyphicon glyphicon-share-alt" style="cursor: pointer;" onclick="notifyesadminfunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
                            @endif
				      </b>
				      @else
				      @endif

				   @else
				   @endif
				 @endforeach
				</td>
				<td>{{$b->datetime}}</td>
			    <td>

				    @if($b->hodstatus==1)
			          <button class="btn btn-info btn-xs glyphicon glyphicon-ok" style="cursor: pointer;" onclick="apprfunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
			        @elseif($b->hodstatus==2)
			          <button class="btn btn-default btn-xs glyphicon glyphicon-ok" style="cursor: pointer;"></button>
			        @elseif($b->hodstatus==3)

			        @elseif($b->hodstatus==4)


			        @endif

               	</td>
               	<td>
               	    @if($b->hodstatus==1)
               	      <button class="btn btn-primary btn-xs glyphicon glyphicon-minus-sign" style="cursor: pointer;" onclick="rejectfunc('{{$b->id}}','{{$userdetail->UserID}}')"></button>
			        @elseif($b->hodstatus==2)

			        @elseif($b->hodstatus==3)

			        @elseif($b->hodstatus==4)

			        @endif
               	</td>

                    @if($b->hodstatus==1)
               	      <!--<button class="btn btn-danger btn-xs glyphicon glyphicon-stop" style="cursor: pointer;" onclick="cancelfunc('{{$b->id}}','{{$userdetail->UserID}}')"></button>-->
			        @elseif($b->hodstatus==2)

			        @elseif($b->hodstatus==3)

			        @elseif($b->hodstatus==4)

			        @endif



				</tr>
			@endforeach

 </table>
</div>

&nbsp;&nbsp;<button onclick="myFunction()">View Archives</button>

  <div id="showarchives" class="table-responsive" style="font-size: 11px; padding:10px;display:none;">
  <table class="table table-bordered table-striped table-highlight" id="mytable" >
{{ csrf_field() }}
<thead>
<tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>
                <th >Staff Name</th>
                <th >Year</th>
                <th >Start Date</th>
                <th >End Date</th>
		        <th >No. of Days</th>
		        <th >Leave Type</th>
		        <th >Comment</th>
                <th >HOD Status</th>
                <th >Final Approval</th>
                <th >Application Date</th>
                <th>Approve</th>
                <th>Reject</th>


</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($displaystaffdetail_All as $b)
				<tr>
				<td>{{ $serialNum ++}}</td>
    			<td>{{$b->name}}</td>
    			<td>{{$b->year}}</td>
    			<td>{{$b->startdate}}</td>
    			<td>{{$b->enddate}}</td>
    			<td>{{$b->nod}}</td>
				<td>{{$b->leavetype}}</td>
				<td>@if ($b->comment==null) {{'No Comment'}} @else {{$b->comment}} @endif</td>
				<td>
				 @foreach($getleavestatus as $l)
				   @if($l->id==$b->hodstatus)

				      @if($l->status=="Pending")
				         @if($b->reapply==1)
				            <b><i style="color:blue"> {{ $l->status }}</i></b>
				            <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfunc('{{$b->id}}')">view</a></i>
				         @elseif($b->reapply==0)
				            <b><i style="color:blue"> {{ $l->status }}</i></b>
				         @endif
				      @elseif($l->status=="Approved")
				      <b><i><a style="cursor: pointer;" onclick="viewfuncHODES('{{$b->id}}')"> {{ "Recommend for approval" }}</a></i>

				      </b>
				      @elseif($l->status=="Cancelled")
				      <b><i style="color:red"> {{ $l->status }}</i>
				      &nbsp
                            <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfunc('{{$b->id}}')">view</a></i>
				      </b>
				       @elseif($l->status=="Reject")
				      <b><i style="color:brown"> {{ $l->status }}</i>
				      &nbsp
                            <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfunc('{{$b->id}}')">view</a></i>
				      </b>
				      @else
				      @endif

				   @else
				   @endif
				 @endforeach
				</td>
				<td>
				 @foreach($getleavestatus as $l)
				   @if($l->id==$b->finalapprstatus)

				      @if($l->status=="Pending")
				        @if($b->hodstatus==3)
				            <center>{{'--'}}</center>
				        @else
				            @if($b->reapply==1)
				               @if($b->finalapprcomment==null)
				                <b><i style="color:blue"> {{ 'waiting approval' }}</i></b>
				               @else
				                 <b><i style="color:blue"> {{ 'waiting approval' }}</i></b>
				                 <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewfunc2('{{$b->id}}')">view</a></i>
				               @endif
				            @elseif($b->reapply==0)
				                <b><i style="color:blue"> {{ 'waiting approval' }}</i></b>
				            @endif
				        @endif
				      @elseif($l->status=="Approved")
				      <a style="cursor: pointer;" onclick="viewfunc2('{{$b->id}}')">{{ $l->status }}</a></i>
				      &nbsp


                             <!--<a class="btn btn-success btn-xs" style="cursor: pointer;"> Approved</a>-->
				      </b>
				      @elseif($l->status=="Cancelled")
				      <b><a style="cursor: pointer;" onclick="viewfunc2('{{$b->id}}')">{{ 'Cancelled' }}</a></i><br>
				      &nbsp

                            <br>
                            @if($b->reapply_status==1)
                             <input type="checkbox" id="notify" class="form-check-input" value="{{$b->id}}" checked="true"><strong id="notifydiv">Staff Notified</strong>
                            @elseif($b->reapply_status==0)
                            <button class="btn btn-info btn-xs glyphicon glyphicon-edit" style="cursor: pointer;" onclick="notifystafffunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
                            <button class="btn btn-danger btn-xs glyphicon glyphicon-share-alt" style="cursor: pointer;" onclick="notifyesadminfunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
                            @endif
				      </b>
				       @elseif($l->status=="Reject")
				      <b><i><a style="cursor: pointer;color:red" onclick="viewfunc2('{{$b->id}}')">{{ 'Rejected' }}</a></i>

                            <p>&nbsp;</p>
                            @if($b->reapply_status==1)
                             <input type="checkbox" id="notify" class="form-check-input" value="{{$b->id}}" checked="true"><strong id="notifydiv">Staff Notified</strong>
                            @elseif($b->reapply_status==0)
                            <button class="btn btn-info btn-xs glyphicon glyphicon-edit" style="cursor: pointer;" onclick="notifystafffunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
                            <button class="btn btn-danger btn-xs glyphicon glyphicon-share-alt" style="cursor: pointer;" onclick="notifyesadminfunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
                            @endif
				      </b>
				      @else
				      @endif

				   @else
				   @endif
				 @endforeach
				</td>
				<td>{{$b->datetime}}</td>
			    <td>

				    @if($b->hodstatus==1)
			          <button class="btn btn-info btn-xs glyphicon glyphicon-ok" style="cursor: pointer;" onclick="apprfunc('{{$b->id}}','{{ $userdetail->UserID }}')"></button>
			        @elseif($b->hodstatus==2)
			          <button class="btn btn-default btn-xs glyphicon glyphicon-ok" style="cursor: pointer;"></button>
			        @elseif($b->hodstatus==3)

			        @elseif($b->hodstatus==4)


			        @endif

               	</td>
               	<td>
               	    @if($b->hodstatus==1)
               	      <button class="btn btn-primary btn-xs glyphicon glyphicon-minus-sign" style="cursor: pointer;" onclick="rejectfunc('{{$b->id}}','{{$userdetail->UserID}}')"></button>
			        @elseif($b->hodstatus==2)

			        @elseif($b->hodstatus==3)

			        @elseif($b->hodstatus==4)

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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>

 $(document).ready(function() {
    $('#').DataTable();
  } );

  $(document).ready(function() {
      $('#mytable').DataTable( {
          dom: 'Bfrtip',
          //"pageLength": 1,
          buttons: [
              {
                  extend: 'print',
                  customize: function ( win ) {
                      $(win.document.body)
                          .css( 'font-size', '10pt' )
                          .prepend(
                              ''
                          );

                      $(win.document.body).find( 'table' )
                          .addClass( 'compact' )
                          .css( 'font-size', 'inherit' );
                  }
              }
          ]
      } );
  } );


function myFunction() {
  var x = document.getElementById("showarchives");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

</script>
  <script type="text/javascript">

  $(document).ready(function(){

    $("#notify").change(function(e){

        var appid = e.target.value;
        var n = confirm("Do you want to deactivate notifications?");

        if(n==true)
        {
            //alert(appid);
            $.get('/notify-staff?applicationid='+appid, function(data){

                document.getElementById("notifydiv").innerHTML='Notify Staff';

            });
        }
        else
        {
            //do nothing
            document.getElementById("notify").checked = true;
        }

    })

    $("#notify2").change(function(e){

        var appid = e.target.value;
        var n = confirm("Notify the staff?");

        if(n==true)
        {

            $.get('/notify-staffs?applicationid='+appid, function(data){

                 document.getElementById("notifydiv2").innerHTML='Staff Notified';
            });
        }
        else
        {
            //do nothing
            document.getElementById("notify2").checked = false;
        }

    })


    //sending message to staff after ES/ADMIN Cancle leave application
     $("#message2").change(function(e){

        var appid = e.target.value;
        var n = prompt("Enter message here:");

        if(n==true)
        {
            //alert(appid);
            $.get('/notify-staffs?applicationid='+appid, function(data){

                 document.getElementById("messagediv2").innerHTML='Message Already Sent!';
            });
        }
        else
        {
            //do nothing
            document.getElementById("message2").checked = false;
        }

    })

    $("#message").change(function(e){

        var appid = e.target.value;
        var n = prompt("Do you want to deactivate notifications?");

        if(n==true)
        {
            //alert(appid);
            $.get('/notify-staff?applicationid='+appid, function(data){

                document.getElementById("messagediv").innerHTML='Message Staff';

            });
        }
        else
        {
            //do nothing
            document.getElementById("message").checked = true;
        }

    })

 });

  function notifystafffunc(x,y)
    {
        document.getElementById('xids').value = x;
        document.getElementById('xuserID').value = y;

        $("#notifystaffModal").modal('show')
    }

    function notifyesadminfunc(x,y)
    {
        document.getElementById('esids').value = x;
        document.getElementById('esuserID').value = y;

        $("#notifyesadModal").modal('show')
    }

  function apprfunc(x,y)
    {
        document.getElementById('ids').value = x;
        document.getElementById('userID').value = y;

        $("#apprModal").modal('show')
    }

   function rejectfunc(x,y)
    {
        document.getElementById('id2').value = x;
        document.getElementById('userID2').value = y;

        $("#rejectModal").modal('show')
    }

    function cancelfunc(x,y)
    {
        document.getElementById('id3').value = x;
        document.getElementById('userID3').value = y;

        $("#cancelModal").modal('show')
    }

	function  ReloadForm()
	{
	//alert("ururu");
	document.getElementById('thisform').submit();
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
    $( "#startdate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#enddate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );
  </script>

  <script>
     function viewfunc(x)
   {

         //console.log(e);
        var appid = x;
        //alert(memberID);
        $.get('/comments/view?appID='+appid, function(data){
         var html = '';
              //html +='<tr bgcolor="#c7c7c7" align="center" style="font-size:22px;">';
		      //html +='<th align="center">Staff</th>';
		      ////html +='<th align="center">Comment</th>';
		      //html +='<th align="center">Datetime</th>';
		      //html +='</tr>';
          $.each(data,function(index,obj){

               html +='<div class="card" style="width:400px">';
                html +='<div class="card-body">';
                  html +='<h4 class="card-title" style="font-weight:bold">'+ obj.name + '</h4>';
                  html +='<p class="card-text" style="font-size:18px;">'+ obj.hodcomments + '</p>';
                  html +='<i class="card-text" style="font-size:12px;">'+'Date comment: '+ obj.datetime + '</i>';
                  html +='<hr>';
                html +='</div>';
              html +='</div>';
              $('#commenttable').html(html);
          });


         });
         $("#viewModal").modal('show')
   }

    function viewfuncHODES(x)
   {

         //console.log(e);
        var appid = x;
        //alert(memberID);
        $.get('/comments/view-hodes?appID='+appid, function(data){
         var html = '';
              //html +='<tr bgcolor="#c7c7c7" align="center" style="font-size:22px;">';
		      //html +='<th align="center">Staff</th>';
		      //html +='<th align="center">Comment</th>';
		      //html +='<th align="center">Datetime</th>';
		      //html +='</tr>';
          $.each(data,function(index,obj){

              html +='<div class="card" style="width:400px">';
                html +='<div class="card-body">';
                  html +='<h4 class="card-title" style="font-weight:bold">'+ obj.name + '</h4>';
                  html +='<p class="card-text" style="font-size:18px;">'+ obj.hodcomments + '</p>';
                  html +='<i class="card-text" style="font-size:12px;">'+'Date comment: '+ obj.datetime + '</i>';
                  html +='<hr>';
                html +='</div>';
              html +='</div>';


              //html +='<tr style="font-size:16px;border-style:solid;">';

                    //html +='<td align="center">'+ obj.name + '</td>';
              //
                    //html +='<td align="center">'+ obj.hodcomments + '</td>';

                    //html +='<td align="center">'+ obj.datetime + '</td>';

              //html +='</tr>';
              $('#commenttable').html(html);
          });


         });
         $("#viewModal").modal('show')
   }

   //procesing for final approval
   function viewfunc2(x)
   {

           //console.log(e);
        var appid = x;
        //alert(memberID);
        $.get('/comments/view-s?appID='+appid, function(data){
         var html = '';
              //html +='<tr bgcolor="#c7c7c7" align="center" style="font-size:22px;">';
		      //html +='<th align="center">Staff</th>';
		      //html +='<th align="center">Comment</th>';
		      //html +='<th align="center">Datetime</th>';
		      //html +='</tr>';
          $.each(data,function(index,obj){
              if(obj.status==1)
              {
              html +='<div class="card" style="width:400px">';
                html +='<div class="card-body">';
                  html +='<h4 class="card-title" style="font-weight:bold">'+ obj.name + '</h4>';
                  html +='<p class="card-text" style="font-size:18px;">'+ obj.admincomments + '</p>';
                  html +='<i class="card-text" style="font-size:12px;">'+'Date comment: '+ obj.datetime + '</i>';
                  html +='<hr>';
                html +='</div>';
              html +='</div>';
              }
              else if(obj.status==0)
              {
               html +='<div class="card" style="width:400px">';
                html +='<div class="card-body">';
                  html +='<h4 class="card-title" style="font-weight:bold">'+ obj.name + '</h4>';
                  html +='<p class="card-text" style="font-size:18px;">'+ obj.escomments + '</p>';
                  html +='<i class="card-text" style="font-size:12px;">'+'Date comment: '+ obj.datetime + '</i>';
                  html +='<hr>';
                html +='</div>';
              html +='</div>';
              }
              $('#commenttable2').html(html);
          });


         });
         $("#viewModalFinalAppr").modal('show')
   }

</script>
@endsection
