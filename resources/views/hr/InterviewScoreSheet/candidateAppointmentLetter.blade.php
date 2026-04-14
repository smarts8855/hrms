@extends('layouts.layout')

@section('pageTitle')
New Appointment
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>Candidate Appointment Letter.</em></strong></span></h3>
        </div>
		  <div class="box-body">
		        <div class="row">

		            @includeIf('Share.message')

				<div class="col-md-12"><!--2nd col-->
				   <form method="post" action="{{ url('/interview-score-sheet')}}" enctype="multipart/form-data" >
						@csrf
                        	<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="interviewName">SELECT INTERVIEW NAME</label>
										<select name="interviewName" id="interviewName" required class="form-control">
											<option value="">Select</option>
											@if(isset($getInterviewName) && $getInterviewName)
												@foreach($getInterviewName as $listInterview)
													<option value="{{$listInterview->interviewID}}" {{ $listInterview->interviewID == (isset($getInterviewID) ? $getInterviewID : old('interviewName')) ? 'selected' : '' }}>{{$listInterview->title}}</option>
												@endforeach
											@endif
										</select>
									</div>
									<br />
									<br />
								</div>
                        	</div>

						</form>
						<hr />
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->


		    <div class="row">
		        <div class="col-md-12">
                    <form method="post" action="{{ url('/interview-approval-candidate')}}" enctype="multipart/form-data" >
					@csrf
		            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
								<tr>
									<th>S/N</th>
									<th>CANDIDATE</th>
                                    <th>APPROVED BY</th>
                                    <th>APPROVAL DATE</th>
                                    {{-- <th>APPOINTMENT LETTER</th> --}}
                                    <th>START DOCUMENTATION</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($getRecords) && $getRecords)
								@foreach($getRecords as $key=>$list)
									<tr>
										<td>{{ ($key + 1)}}</td>
                                        <td>{{$list->surname .' '. $list->first_name .' '. $list->othernames }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ date('d-M-Y', strtotime($list->approval_date)) }}</td>
                                        {{-- <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-backdrop="false" data-target="#viewEmploymentLetter{{$key}}">Offer of Apppointment Letter</button>
                                        </td> --}}
                                        <td>
                                            @if($list->registry_status == 1)
                                                <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-backdrop="false" data-target="#confirmPushToRegistry{{$key}}">Forwarded To registry</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-backdrop="false" data-target="#confirmPushToRegistry{{$key}}">Forward To Registry</button>
                                            @endif
                                        </td>
									</tr>

                                    <!-- Modal to delete -->
									<div class="modal fade text-left d-print-none" id="viewEmploymentLetter{{$key}}" tabindex="-1" role="dialog" aria-labelledby="viewEmploymentLetter{{$key}}" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-success">
													<h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
														<div class="text-success text-center"> <h4>Are you sure you want to view employment letter for <br /> <b>{{$list->surname .' '. $list->first_name .' '. $list->othernames }}</b>? </h4></div>
														<br />
													</div>
												</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-outline-info" data-dismiss="modal"> No. Cancel </button>
                                                    <a href="{{Route::has('offerAppointmentLetter') ? Route('offerAppointmentLetter', ['candidateID'=>$list->candidateID]) : 'javascript' }}" target="_blank" class="btn btn-success"> Generate Employment Letter </a>
												</div>
											</div>
										</div>
									</div>
							        <!--end Modal-->

                                    <!-- Modal to push -->
									<div class="modal fade text-left d-print-none" id="confirmPushToRegistry{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmPushToRegistry{{$key}}" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-success">
													<h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
                                                        <div align="center">
                                                            <b>{{$list->surname .' '. $list->first_name .' '. $list->othernames }}</b>
                                                        </div>
                                                        <br />
														<div class="text-success text-center"> <h4>Are you sure you want to Forward this candidate to registry? </h4></div>

													</div>
												</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{url('push-candidate-to-registry/'. $list->candidateID)}}" class="btn btn-success"> Forward Now </a>
												</div>
											</div>
										</div>
									</div>
							<!--end Modal-->

								@endforeach
								@endif
							</tbody>
                            </table>
                        </form>
		        </div>
		    </div>
	</div>
</div>
<form id="getCandidateForm" method="post" action="{{ url('/get-candidate-for-interview')}}" enctype="multipart/form-data" >
@csrf
	<input type="hidden" name="inverviewName" id="inverviewName" />
</form>

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $("#interviewName").change(function() {
			$('#inverviewName').val($('#interviewName').val());
            $('#getCandidateForm').submit();
        });
    });//end document
</script>
@endsection

