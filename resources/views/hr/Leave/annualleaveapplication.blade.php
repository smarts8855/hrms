@extends('layouts.layout')
@section('pageTitle')
  Annual Leave Application

@endsection

@section('content')
<div id="viewReply" class="modal fade">
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

<div id="reapplyModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <p class="modal-title">Reapply Leave</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" action="{{ url('/annual/leave/reapply') }}" method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">



	            	        <div class="col-lg-3">
	            	        <input class="form-control" name="UserLeaveID" id="user_id" type="hidden">
	            	        <input class="form-control" name="deptID" id="deptID" type="hidden" value="{{$userdetail->department}}">
	            	        <input class="form-control" name="userID" id="userID" type="hidden" value="{{$userdetail->UserID}}">
	            	        <input class="form-control" name="leaveType" id="leaveType" type="hidden" value="{{$leaveType->id}}">
	            	        <input class="form-control" name="grade" id="grade" type="hidden" value="{{$userdetail->grade}}">
	            	        @foreach($getdept as $d)

	            	          @if($userdetail->department==$d->id)
	            	              <input class="form-control" name="hodID" id="hodID" type="hidden" value="{{$d->head}}">
	            	          @else
	            	          @endif

	            	        @endforeach
	            		<label>Year</label>
	            		@php

	            		 $currently_selected = date('Y');
				  // Year to start available options at
				  $earliest_year = 2017;
				  // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
				  $latest_year = date('Y');

				  echo'<select class="form-control" name="year" id="yeare" required >';
				   echo'<option value="" selected>'.'SELECT'.'</option>';
				  // Loops over each int[year] from current year, back to the $earliest_year [1950]
				  foreach ( range( $latest_year, $earliest_year ) as $i ) {
				    // Prints the option with the next year in range.
				    echo'<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
				  }
				  echo'</select>';

	            		@endphp

	            		</div>

			 	<div class="col-lg-3">
	            		<label>Start date</label>
				<input type="text" name="startdate" id="startdate" class="form-control" value="{{ old('startdate') }}" autocomplete="off" required />
	            		</div>
	            		<div class="col-lg-3">
	            		<label>End date</label>
				<input type="text" name="enddate" id="enddate" class="form-control" value="{{ old('enddate') }}" autocomplete="off" required />
	            		</div>
	            		<div class="col-lg-3">
	            		<label>No. of Days</label>
				<select name="nod" id="node" class="form-control" required>
		                <option value="" selected>SELECT</option>
		                	@for ($i = 1; $i <= 30; $i++)
		                	   <option value="{{ $i }}" {{ ($nod) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		        </select>
	            		</div>

	            <div class="col-lg-12 col-lg-offset-0">

    				<label for="comment">Comment(Optional):</label>
                    <textarea class="form-control" rows="3" id="commente" name="comment">&nbsp;</textarea>
				</div>

	            	</div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-xs">Apply</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Cancel</button>
                </div>

                </form>
            </div>

        </div>
</div>

<div id="reeditModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <p class="modal-title">Edit Leave</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" action="{{ url('/annual/leave/edit') }}" method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">



	            	        <div class="col-lg-3">
	            	        <input class="form-control" name="UserLeaveID" id="user_ids" type="hidden">
	            	        <input class="form-control" name="deptID" id="deptID" type="hidden" value="{{$userdetail->department}}">
	            	        <input class="form-control" name="userID" id="userID" type="hidden" value="{{$userdetail->UserID}}">
	            	        <input class="form-control" name="leaveType" id="leaveType" type="hidden" value="{{$leaveType->id}}">
	            	        <input class="form-control" name="grade" id="grade" type="hidden" value="{{$userdetail->grade}}">
	            	        @foreach($getdept as $d)

	            	          @if($userdetail->department==$d->id)
	            	              <input class="form-control" name="hodID" id="hodID" type="hidden" value="{{$d->head}}">
	            	          @else
	            	          @endif

	            	        @endforeach
	            		<label>Year</label>
	            		@php

	            		 $currently_selected = date('Y');
				  // Year to start available options at
				  $earliest_year = 2017;
				  // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
				  $latest_year = date('Y');

				  echo'<select class="form-control" name="year" id="yeares" required >';
				   echo'<option value="" selected>'.'SELECT'.'</option>';
				  // Loops over each int[year] from current year, back to the $earliest_year [1950]
				  foreach ( range( $latest_year, $earliest_year ) as $i ) {
				    // Prints the option with the next year in range.
				    echo'<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
				  }
				  echo'</select>';

	            		@endphp

	            		</div>

			 	<div class="col-lg-3">
	            		<label>Start date</label>
				<input type="text" name="startdate" id="startdatea" class="form-control" value="{{ old('startdate') }}" autocomplete="off" required />
	            		</div>
	            		<div class="col-lg-3">
	            		<label>End date</label>
				<input type="text" name="enddate" id="enddatea" class="form-control" value="{{ old('enddate') }}" autocomplete="off" required />
	            		</div>
	            		<div class="col-lg-3">
	            		<label>No. of Days</label>
				<select name="nod" id="nodes" class="form-control" required>
		                <option value="" selected>SELECT</option>
		                	@for ($i = 1; $i <= 30; $i++)
		                	   <option value="{{ $i }}" {{ ($nod) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		        </select>
	            		</div>

	            <div class="col-lg-12 col-lg-offset-0">

    				<label for="comment">Comment(Optional):</label>
                    <textarea class="form-control" rows="3" id="commentes" name="comment">&nbsp;</textarea>
				</div>

	            	</div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-xs">Apply</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Cancel</button>
                </div>

                </form>
            </div>

        </div>
</div>

<div id="removeModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <p class="modal-title">Delete Application</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" action="{{ url('remove/application') }}" method="post"  role="form">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                     <center><p>Are you sure?</p></center>

                    </div>
                    <input type="hidden" id="removeid" name="id" value="">


                </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-xs">Yes</button>
                    <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">No</button>
                </div>

                </form>
            </div>

          </div>
        </div>
<div id="viewModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Comment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal"
                    role="form">
                    {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group" style="margin: 0 10px;">

                    <div class="col-sm-12">
                     <center><h5 id="comment"></h5></center>

                    </div>
                    <input type="hidden" id="id" name="id" value="">


                </div>
            </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-success btn-xs" data-dismiss="modal">Close</button>
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
          <h1 class="box-title"><i class="fa fa-user"></i>Welcome: <b style="border-radius: 25px;padding:6px;color:green">{{ $userdetail->surname }}, {{ $userdetail->first_name}} {{ $userdetail->othernames}}</b></h1>. You are entitled to:  <b style="background-image: linear-gradient(to right, green, black);border-radius: 100px;font-size:16px;color:white; padding:6px;">{{ $leavedays->noOfDays }}</b>&nbsp; days annual leave. You have: <b style="background-image: linear-gradient(to right, green, black);border-radius: 100px;font-size:16px;color:yellow; padding:6px;">{{ $leavedays->noOfDays-$sumleave }}</b>&nbsp; days left.
          <br>
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
	<form method="post" id="form1" name="form1" class="form-horizontal">
		{{ csrf_field() }}
		<div class="box-body">

	            	<div class="form-group">



	            	        <div class="col-lg-3">
	            	        <input class="form-control" name="deptID" id="deptID" type="hidden" value="{{$userdetail->department}}">
	            	        <input class="form-control" name="userID" id="userID" type="hidden" value="{{$userdetail->UserID}}">
	            	        <input class="form-control" name="leaveType" id="leaveType" type="hidden" value="{{$leaveType->id}}">
	            	        <input class="form-control" name="grade" id="grade" type="hidden" value="{{$userdetail->grade}}">
	            	        @foreach($getdept as $d)

	            	          @if($userdetail->department==$d->id)
	            	              <input class="form-control" name="hodID" id="hodID" type="hidden" value="{{$d->head}}">
	            	          @else
	            	          @endif

	            	        @endforeach
	            		<label>Year</label>
	            		@php

	            		 $currently_selected = date('Y');
				  // Year to start available options at
				  $earliest_year = 2017;
				  // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
				  $latest_year = date('Y');

				  echo'<select class="form-control" name="Year" required >';
				   echo'<option value="" selected>'.'SELECT'.'</option>';
				  // Loops over each int[year] from current year, back to the $earliest_year [1950]
				  foreach ( range( $latest_year, $earliest_year ) as $i ) {
				    // Prints the option with the next year in range.
				    echo'<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
				  }
				  echo'</select>';

	            		@endphp

	            		</div>

			 	<div class="col-lg-3">
	            		<label>Start date</label>
				<input type="text" name="StartDate" id="startdate2" class="form-control" value="@if($startdate!=""){{ $startdate }}@endif" autocomplete="off" required />
	            		</div>
	            		<div class="col-lg-3">
	            		<label>End date</label>
				<input type="text" name="EndDate" id="enddate2" class="form-control" value="{{ old('EndDate') }}" autocomplete="off" required />
	            		</div>
	            		<div class="col-lg-3">
	            		<label>No. of Days</label>
				<select name="NumberOfDays" id="nod" class="form-control" required>
		                <option value="" selected>SELECT</option>
		                	@for ($i = 1; $i <= 30; $i++)
		                	   <option value="{{ $i }}" {{ ($nod) == $i ? "selected":"" }}>{{$i}}</option>
		                	@endfor
		        </select>
	            		</div>


	            	</div>


	        <div class="form-group">

	            <div class="col-lg-12 col-lg-offset-0">

				<label for="comment">Comment(Optional):</label>
                <textarea class="form-control" rows="3" id="usercomment" name="comment">&nbsp;{{ old('comment') }}</textarea>
				</div>

				<div class="col-lg-12 col-lg-offset-0">
				<br>
				<button type="submit" class="btn btn-success" name="apply">
				   <i class="fa fa-btn fa-floppy-o"></i> Apply
				</button>

				<!--<button type="submit" class="btn btn-success" name="update">
					<i class="fa fa-btn fa-floppy-o"></i> Update
				</button>-->

				<!--<button type="submit" class="btn btn-success" name="reset">
					<i class="fa fa-btn fa-newspaper-o"></i> Reset
				</button>-->
				</div>
			</div>

	</form>
<div class="table-responsive" style="font-size: 11px; padding:10px;">
<table class="table table-bordered table-striped table-highlight" id="mytable">
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
                <th >Action</th>

</tr>
</thead>
			@php $serialNum = 1; @endphp

			@foreach ($displaydetail as $b)
				<tr>
				<td>{{ $serialNum ++}}</td>
    				<td>{{$b->surname}}, {{$b->first_name}} {{$b->othernames}}</td>
    				<td>{{$b->year}}</td>
    				<td>{{date('d-M-Y', strtotime($b->startDate))}}</td>
    				<td>{{date('d-M-Y', strtotime($b->endDate))}}</td>
    				<td>{{$b->nod}}</td>
				    <td>{{$b->leavetype}}</td>
					<td>@if ($b->comment==null) {{'No Comment'}} @else {{$b->comment}} @endif</td>
				<td>
				 @foreach($getleavestatus as $l)
				   @if($l->id==$b->hodstatus)

				      @if($l->status=="Pending")
    				        @if($b->reapply==1)
    				            <b><i style="color:blue"> {{ $l->status }}</i></b>
    				            <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewReply('{{$b->id}}')">view</a></i>
    				         @elseif($b->reapply==0)
    				            <b><i style="color:blue"> {{ $l->status }}</i></b>
    				         @endif
				      @elseif($l->status=="Approved")
				      <b><i><a style="cursor: pointer;" onclick="viewReply('{{$b->id}}')"> {{ 'Recommend for approval' }}</a>

                                        </i></b>
				      @elseif($l->status=="Cancelled")
				      	      <b><i><a style="cursor: pointer;color:red" onclick="viewReply('{{$b->id}}')"> {{ $l->status }}</a></b>

				       @elseif($l->status=="Reject")

                                      <b><i style="color:brown"> {{ $l->status }}</i>
				                      &nbsp
                                      <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="viewReply('{{$b->id}}')">view</a></i>
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
				            <b><i> {{ 'waiting approval' }}</i></b>
				        @endif

				      @elseif($l->status=="Approved")
				      <b><i></i>
					  &nbsp
                            @if($b->hodreply==1)
    				         <a class="btn btn-success btn-xs" style="cursor: pointer;"> Approved</a>
    				        @endif
				      </b>
				      @elseif($l->status=="Cancelled")
				      <b><i> </i>
				      &nbsp
                            @if($b->hodreply==1)
    				         <a class="btn btn-danger btn-xs" style="cursor: pointer;"> Cancelled</a>
    				        @endif
				      </b>
				       @elseif($l->status=="Reject")
				      <b><i> </i>
				      &nbsp
                            @if($b->hodreply==1)
    				         <!--<a class="btn btn-danger btn-xs" style="cursor: pointer;"> Reject</a>-->
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

				   @if($b->statusid==1)

    				    @if($b->reapply==1)

                        @elseif($b->reapply==0)
                         <a class="btn btn-danger btn-xs" style="cursor: pointer;" onclick="removefunc('{{$b->id}}')"><i class="glyphicon glyphicon-remove"></i></a>
    				     <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="reeditfunc('{{$b->id}}','{{$b->year}}','{{$b->startdate}}','{{$b->enddate}}','{{$b->nod}}','{{$b->comment}}')"><i class="glyphicon glyphicon-edit"></i></a>

                        @endif
                    @elseif($b->statusid==2)

				            @if($b->hodreply==1)
    				         <a class="btn btn-success btn-xs" style="cursor: pointer;"> Approved</a>

    				        @endif

				   @elseif($b->statusid==3)
    				     @if($b->reapply_status==0)

    				     @elseif($b->reapply_status==1)

				        @if($b->hodreply==1)
				         <!--<a class="btn btn-danger btn-xs" style="cursor: pointer;" onclick="viewReply('{{$b->id}}')"><i class="fa fa-envelope"></i> read hod reply</a>-->
				         <a class="btn btn-danger btn-xs" style="cursor: pointer;"> Cancelled</a>
				        @endif
				     @endif

				   @elseif($b->statusid==4)

				        @if($b->reapply_status==0)

				        @elseif($b->reapply_status==1)
				        <a class="btn btn-success btn-xs" style="cursor: pointer;" onclick="reapplyfunc('{{$b->id}}','{{$b->year}}','{{$b->startdate}}','{{$b->enddate}}','{{$b->nod}}','{{$b->comment}}')"><i class="glyphicon glyphicon-edit"></i> Re-apply</a>
				        @if($b->hodreply==1)
				         <a class="btn btn-danger btn-xs" style="cursor: pointer;" onclick="viewReply('{{$b->id}}')"><i class="fa fa-envelope"></i> read hod reply</a>

				        @endif
				     @endif

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
function viewReply(x)
   {

         //console.log(e);
        var appid = x;
        //alert(appid);
        $.get('/reply/view?appID='+appid, function(data){
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
              $('#commenttable').html(html);
          });


         });
         $("#viewReply").modal('show')
   }


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


</script>
  <script type="text/javascript">


   function reapplyfunc(v,w,x,y,z,i)
    {
        document.getElementById('user_id').value = v;
        document.getElementById('yeare').value = w;
        document.getElementById('startdate').value = x;
        document.getElementById('enddate').value = y;
        document.getElementById('node').value = z;
        document.getElementById('commente').value = i;


        $("#reapplyModal").modal('show')
    }

    function reeditfunc(v,w,x,y,z,i)
    {
        document.getElementById('user_ids').value = v;
        document.getElementById('yeares').value = w;
        document.getElementById('startdatea').value = x;
        document.getElementById('enddatea').value = y;
        document.getElementById('nodes').value = z;
        document.getElementById('commentes').value = i;

        $("#reeditModal").modal('show')
    }

   function removefunc(x)
    {
        document.getElementById('removeid').value = x;

        $("#removeModal").modal('show')
    }


    function viewfunc(x,y)
    {
         document.getElementById('id').value = x;
         document.getElementById('comment').innerHTML = y;

        $("#viewModal").modal('show')
    }

	function  ReloadForm()
	{
	//alert("ururu")	;
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
    $( "#startdatea" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#startdate2" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#enddate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#enddatea" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#enddate2" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#approvedate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#appointmentDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#incrementalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    $( "#firstArrivalDate" ).datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
  } );
  </script>
  <script>
       $(document).ready(function(){

    $("#select1").change(function(e){

        //var recordid = e.target.value;
        //alert(recordid);

        //var x = document.getElementById("hidediv");

        $.get('/get-leavedays', function(data){
        //$('#divs2').empty();
        console.log(data);
        if(recordid==1)
        {
            $('#ok').append( '<i class="glyphicon glyphicon-ok" style="color:green" ></i>' );
            x.style.display = "none";
            $('#oks').empty();
        }
        else if(recordid==0)
        {
            $('#oks').append( '<i class="glyphicon glyphicon-remove" ></i>' );
            x.style.display = "none";
            $('#ok').empty();

        }
        //$.each(data, function(index, obj){
        //$('#divs2').append( '<option value="'+obj.id+'">'+obj.divname+'</option>' );
        });

        })
    })
  </script>
@endsection
