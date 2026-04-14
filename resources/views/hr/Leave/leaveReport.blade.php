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

  <div class="col-md-12">
      <form method="post" action="{{url('/leave-report/view')}}">
        @csrf
        <div class="col-md-10" style="padding-right: 0px;">
            <div class="form-group">

            <label>Search By Staff</label>
              <select name="staffID" id="staff" required class="form-control" >
              <option value="" selected>Select</option>
                @foreach($staff as $list)
                <option value="{{$list->ID}}">{{$list->surname}} {{$list->first_name}} {{$list->othernames}}</option>
                @endforeach
              </select>
            </div>
         </div>
         <div class="col-md-2" style="padding-left: 2px;">
            <div class="form-group">
                <label>&nbsp;</label><br/>
                <input type="submit" name="submit" class="btn btn-success" value="Search"/>
            </div>
         </div>
      </form>
  </div>

<div class="table-responsive" style="font-size: 14px; padding:10px;">
<table class="table table-striped" id="mytable">
<thead>
<tr>
                <th width="1%">S/N</th>
                <th >Staff Name</th>
                <th >Start Date</th>
                <th >End Date</th>
                <th >No. of Days</th>
                <th >Leave Type</th>
                <th >Resumption Date</th>
                <th>status</th>
                <th >Preview</th>
                <th >Memo</th>

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
    				<td>{{date('d-M-Y', strtotime($b->startDate))}}</td>
    				<td>{{date('d-M-Y', strtotime($b->endDate))}}</td>
    				<td>{{$b->noOfDays}}</td>
				    <td>{{$b->leaveType}}</td>
                    <td>{{$b->resumption_date}}</td>
                    <td>@if($b->approval_status == 1) Approved @elseif($b->approval_status == 2) Not Approved @endif</td>
				    <td><a href="{{url('leave-certificate/'.$b->leaveAppID)}}" target="_blank" class="btn btn-success btn-sm"> <i class="fa fa-eye"></i> Preview Leave</a></td>
                    <td>
                        <a href="{{url('print-memo/'.$b->staffID)}}" target="_blank" class="btn btn-success btn-sm"> <i class="fa fa-eye"></i> Preview Memo</a>
                    </td>

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


@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<style>
    .btn-outline-success
    {
        border: 1px solid green !important;
        color: green !important;
    }
</style>
@endsection

@section('scripts')

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/select2.min.js')}}"></script>

<script type="text/javascript">
    //select
    $(document).ready(function() {
        $('#staff').select2();
    });

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

</script>

@endsection
