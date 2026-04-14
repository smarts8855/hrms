@extends('layouts.layout')
@section('pageTitle')
  Annual Leave Application

@endsection

@section('content')


<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title"><strong>@yield('pageTitle')</strong> <span id='processing'></span></h3>
        </div>

        <div class="box-header with-border hidden-print">

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

<div class="table-responsive" style="font-size: 14px; padding:10px;">
<table class="table table-striped" id="mytable">
<thead>
<tr>
                <th width="1%">S/N</th>
                <th >STAFF NAME</th>
                <th >GRADE</th>
                <th >START DATE</th>
                <th >END DATE</th>
                <th >NO. OF DAYS</th>
                <th >LEAVE TYPE</th>
                <th >PREVIEW</th>
                @if($stage != 5)
                <th >ACTION</th>
                @endif
                <th></th>

</tr>
</thead>
			@php $serialNum = 1; @endphp
      @if(!empty($leave))


			@foreach ($leave as $b)
      @php
         $staffGrade = DB::table('tblper')->where('ID',"=",$b->staffID)->value('grade');

      @endphp
				<tr>
			    	<td>{{ $serialNum ++}}</td>
    				<td>{{$b->surname}}, {{$b->first_name}} {{$b->othernames}}</td>
            <td> {{$b->grade}}</td>
    				<td>{{date('d-M-Y', strtotime($b->startDate))}}</td>
    				<td>{{date('d-M-Y', strtotime($b->endDate))}}</td>
    				<td>{{$b->noOfDays}}</td>
				    <td>{{$b->leaveType}}</td>
				    <td><a href="{{url('leave-certificate/'.$b->leaveAppID)}}" target="_blank" class="btn btn-success btn-sm"> <i class="fa fa-eye"></i> Preview</a></td>
            @if($stage != 5)
            <td>
              @if($staffGrade < 7 && ($stage ==3 || $stage ==4))
              @if($b->approval_status == 0)
              <a href="javascript:void()" class="btn btn-success btn-sm approve" stage="{{$stage}}" leaveID="{{$b->leaveAppID}}"> <i class="fa fa-eye"></i> Approve </a>
              <a href="javascript:void()" class="btn btn-danger btn-sm reject" stage="{{$stage}}" leaveID="{{$b->leaveAppID}}"> <i class="fa fa-eye"></i> Disapprove </a>
              @elseif($b->approval_status == 1)
              <strong class="text-success">Leave Approved</strong>
              <a href="javascript:void()" class="btn btn-danger btn-sm reverse" stage="{{$stage}}" leaveID="{{$b->leaveAppID}}"> <i class="fa fa-eye"></i> Reverse </a>
              @elseif($b->approval_status == 2)
              <strong class="text-success">Leave Not Approved</strong>
              <a href="javascript:void()" class="btn btn-danger btn-sm reverse" stage="{{$stage}}" leaveID="{{$b->leaveAppID}}"> <i class="fa fa-eye"></i> Reverse </a>
              @endif
              @endif

              <a href="javascript:void()" class="btn btn-success btn-sm nextstage" stage="{{$stage}}" leaveID="{{$b->leaveAppID}}"> <i class="fa fa-move"></i> Move to {{$next}}</a>


            </td>
            @endif
            <td>@if($stage == 5)
              <a href="{{url('/create-memo/'.$b->staffID)}}" target="_blank" class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i> Generate Memo</a>
              <a href="{{url('print-memo/'.$b->staffID)}}" target="_blank" class="btn btn-success btn-sm"> <i class="fa fa-eye"></i> Preview Memo</a>
              <a href="javascript:void()" class="btn btn-success btn-sm sendMemo" style="margin-top:1rem;" staffid="{{$b->staffID}}" leaveID="{{$b->leaveAppID}}"> <i class="fa fa-eye"></i>Send Memo</a>
              @endif</td>
				</tr>
			@endforeach
      @else
      <tr>
        <td colspan="8" class="text-center"> No Leave Application Found </td>
      </tr>
      @endif

 </table>
</div>



</div>

<!-- Modal HTML -->
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          </div>
          <form method="post" action="{{url('/leave-approval')}}">
          <div class="modal-body">


              @csrf
              <div class="row">
              <div class="col-md-12">
               <div class="form-group">
               <label>Comment <big class="text-danger">*</big></label>
               <textarea name="comment" class="form-control input-lg"></textarea>
               <input type="hidden" name="stage" value="{{$stage}}" />
               <input type="hidden" name="leaveID" id="leaveID"/>
               <input type="hidden" name="status" value="approve"/>
               </div>
              </div>

              </div>


          </div>
          <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Approve"/>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          </div>
        </form>
      </div>
  </div>
</div>
<!--///// end modal -->

<!-- Disapprove Modal HTML -->
<div id="rejectModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          </div>
          <form method="post" action="{{url('/leave-approval')}}">
          <div class="modal-body">


              @csrf
              <div class="row">
              <div class="col-md-12">
               <div class="form-group">
               <label>Reason for disapproving <big class="text-danger">*</big></label>
               <textarea name="comment" class="form-control input-lg"></textarea>
               <input type="hidden" name="stage" value="{{$stage}}" />
               <input type="hidden" name="leaveID" id="leave"/>
               <input type="hidden" name="status" value="reject"/>
               </div>
              </div>

              </div>


          </div>
          <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Disapprove"/>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          </div>
        </form>
      </div>
  </div>
</div>
<!--///// end Disapprove modal -->

<!-- Move to Next Stage Modal HTML -->
<div id="nextStageModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          </div>
          <form method="post" action="{{url('/move-to-nextstage')}}">
          <div class="modal-body">


              @csrf
              <div class="row">
              <div class="col-md-12">
               <div class="form-group">
               <label class="text-center text-warning"> You want to move this leave application to {{$next}} ! are you sure? </label> <br><br><br>
               <label class="text-center"> Comment <span class="text-danger">*</span></label>

               <textarea name="comment" class="form-control input-lg" required></textarea>

               <input type="hidden" name="stage" value="{{$stage}}" />
               <input type="hidden" name="leaveID" id="leave_id"/>

               </div>
              </div>

              </div>


          </div>
          <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Yes"/>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

          </div>
        </form>
      </div>
  </div>
</div>
<!--///// end Move to Next Stage modal -->

<!-- Reverse Modal HTML -->
<div id="reverseModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          </div>
          <form method="post" action="{{url('/reverse-decision')}}">
          <div class="modal-body">


              @csrf
              <div class="row">
              <div class="col-md-12">
               <div class="form-group">
               <label class="text-center"> Do you want to reverse this process </label>

               <input type="hidden" name="stage" value="{{$stage}}" />
               <input type="hidden" name="leaveID" id="leave_idr"/>

               </div>
              </div>

              </div>


          </div>
          <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Yes"/>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

          </div>
        </form>
      </div>
  </div>
</div>
<!--///// end Reverse modal -->

<!-- Send memo Modal HTML -->
<div id="sendMemoModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h1>Send Memo to Staff and Registry</h1>
          </div>
          <form method="post" action="{{url('/send-memo')}}">
          <div class="modal-body">


              @csrf
              <div class="row">
              <div class="col-md-12">
               <div class="form-group">
               <label class="text-center text-danger"> Comment (*)</label>
               <textarea name="comment" class="form-control input-lg" required></textarea>
               <input type="hidden" name="stage" value="{{$stage}}" />
               <input type="hidden" name="leaveID" id="leave_ids"/>
               <input type="hidden" name="staffid" id="staffid"/>
               </div>
              </div>

              </div>


          </div>
          <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
              <button type="button" class="btn btn-default" data-dismiss="modal">close</button>

          </div>
        </form>
      </div>
  </div>
</div>
<!--///// end send memo modal -->
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">

@endsection

@section('scripts')

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
	//Modal popup
	$(document).ready(function(){
		$('.approve').click(function(){
      var leave = $(this).attr('leaveID');
      $('#leaveID').val(leave);
			$('#myModal').modal('show');
		});
	});

  //reject
  $(document).ready(function(){
		$('.reject').click(function(){
      var leave = $(this).attr('leaveID');
      $('#leave').val(leave);
			$('#rejectModal').modal('show');
		});
	});
  // next stage
  $(document).ready(function(){
		$('.nextstage').click(function(){
      var leave = $(this).attr('leaveID');
      $('#leave_id').val(leave);
			$('#nextStageModal').modal('show');
		});
	});

  // reverse
  $(document).ready(function(){
		$('.reverse').click(function(){
      var leave = $(this).attr('leaveID');
      $('#leave_idr').val(leave);
			$('#reverseModal').modal('show');
		});
	});

  // remo
  $(document).ready(function(){
		$('.sendMemo').click(function(){
      var leave = $(this).attr('leaveID');
      var staffid = $(this).attr('staffid');
      $('#leave_ids').val(leave);
      $('#staffid').val(staffid);
			$('#sendMemoModal').modal('show');
		});
	});

</script>

@endsection
