@extends('layouts.layout')

@section('pageTitle')
 Add Record of Censures and Commendations
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> 
        		<big><b class="text-green"> - {{strtoupper($getStaff->surname." ".$getStaff->first_name." ".$getStaff->othernames)}}</b></big><span id='processing'></span>
        	</h3>
    	</div>
		  <form method="post" action="{{ url('/commendations/create') }}">
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
						<!---->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="date">Type of Leave</label>
										@php if(($details != "")){ @endphp
											<select name="typeOfLeave" class="form-control">
												<option>{{$details->typeleave}}</option>
												<option>Casual Leave</option>
												<option>Maternity Leave</option>
												<option>Quarantine Leave</option>
												<option>Study Leave or Sabbatical Leave</option>
												<option>Half Pay Leave</option>
												<option>Sick Leave or Medical Leave</option>
												<option>Earned Leave or Privilege Leave</option>
											</select>
										@php }else{ @endphp
											<select name="typeOfLeave" class="form-control">
												<option value=""></option>
												<option>Casual Leave</option>
												<option>Maternity Leave</option>
												<option>Quarantine Leave</option>
												<option>Study Leave or Sabbatical Leave</option>
												<option>Half Pay Leave</option>
												<option>Sick Leave or Medical Leave</option>
												<option>Earned Leave or Privilege Leave</option>
											</select>
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="leaveFrom">From</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="leaveFrom2" id="leaveFrom2" class="form-control" value="{{date('d M, Y', strtotime($details->leavefrom))}}" />
											<input type="hidden" name="leaveFrom" id="leaveFrom" value="{{$details->leavefrom}}" />
										@php }else{ @endphp
											<input type="text" name="leaveFrom2" id="leaveFrom2" class="form-control" 
											value="{{old('leaveFrom2')}}" />
											<input type="hidden" name="leaveFrom" id="leaveFrom" value="{{old('leaveFrom')}}" />
										@php } @endphp
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="leaveTo">To</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="leaveTo2" id="leaveTo2" class="form-control" value="{{date('d M, Y', strtotime($details->leaveto))}}" />
											<input type="hidden" name="leaveTo" id="leaveTo" value="{{$details->leaveto}}" />
										@php }else{ @endphp
											<input type="text" name="leaveTo2" id="leaveTo2" class="form-control" 
											value="{{old('leaveTo2')}}" />
											<input type="hidden" name="leaveTo" id="leaveTo" value="{{old('leaveTo')}}" />
										@php } @endphp
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="date">Date</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="commendationDate2" id="commendationDate2" class="form-control" value="{{date('d M, Y', strtotime($details->commendationdate))}}" />
											<input type="hidden" name="commendationDate" id="commendationDate" value="{{$details->commendationdate}}" />
										@php }else{ @endphp
											<input type="text" name="commendationDate2" id="commendationDate2" value="{{old('commendationDate2')}}" class="form-control" />
												<input type="hidden" name="commendationDate" id="commendationDate" value="{{old('commendationDate')}}" />
										@php } @endphp
									</div>
								</div>
							</div>

						<!---->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="summary">Summary</label> 
										@php if(($details != "")){ @endphp
											<textarea name="summary" class="form-control">{{$details->summary}}</textarea>
										@php }else{ @endphp
											<textarea name="summary" class="form-control">{{old('summary')}}</textarea>
										@php } @endphp

										<!--NOTE: THIS'S FOR EDITTING-->
										@php if(($details != "")){ @endphp
											<input type="hidden" name="id" value="{{$details->id}}"/>
										@php }else{ @endphp
											<input type="hidden" name="id" value=""/>
										@php } @endphp
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="compiledBy">Compiled By</label>
										@php if(($details != "")){ @endphp
											<input type="text" name="compiledBy" value="{{$details->checked_commendation}}" class="form-control" />
										 @php }else{ @endphp
										 	<input type="text" name="compiledBy" class="form-control" value="{{old('compiledBy')}}" />
										 @php } @endphp
									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="{{url('/profile/details/'.$getStaff->fileNo)}}" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>
								
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i> 
										</button>
									</div>
								</div>
								
										
								</div>
							</div>	
							<hr />

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Type of Leave</th>
								<th>From</th>
								<th>To</th>
								<th>No. Day</th>
								<th>Date</th>
								<th>Summary</th>
								<th>Compiled By</th>
								<th>Edit</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@php if($commendationList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($commendationList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->typeleave}}</td>
								<td>{{$list->leavefrom}}</td>
								<td>{{$list->leaveto}}</td>
								<td>{{$list->numberday}}</td>
								<td>{{date('d M, Y', strtotime($list->commendationdate))}}</td>
								<td>{{$list->summary}}</td>
								<td>{{$list->checked_commendation}}</td>
								<td><a href="{{url('/commendations/edit/'.$list->id)}}" title="Edit" class="btn btn-success fa fa-edit"></a>
								</td>
								<td>
									<!--<a href="{{url('/commendations/remove/'.$list->id)}}" title="Remove" class="btn btn-warning fa fa-trash"></a>-->
								</td>
							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="11" class="text-center">No censures and commendation details provided yet !</td>
								</tr>
						@php } @endphp

						</tbody>
					</table>
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>
		   
	</div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">

	$( function() {
	    $("#commendationDate2").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
				$("#commendationDate").val(dateFormatted);
        	},
		});
		$("#leaveFrom2").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
				$("#leaveFrom").val(dateFormatted);
        	},
		});
		$("#leaveTo2").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true, 
		    dateFormat: "dd MM, yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('yy-mm-d', theDate);
				$("#leaveTo").val(dateFormatted);
        	},
		});

  } );
</script>
@endsection