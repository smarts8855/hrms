@extends('layouts.layout')

@section('pageTitle')
  <h3 style="padding: 0px;">Details Of Service in The Force <strong>- </strong><span style="color:green;">{{$names->surname}} {{$names->first_name}}</span></h3>
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <form method="post" action="{{ url('/update/detailofservice/') }}">
		  <div class="box-body">
		        <div class="row">

					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->

							<!--
								<div align="right" style="margin-right: 10px;">
									<a href="#" title="Add New" class="btn btn-primary open-modal">
										<i class="fa fa-hand-o-down"></i> <b>Add New</b>
									</a>
								</div>
							-->

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Arm Of Service</label>
										@php if($doservice != ''){
											echo '<input type="text" name="armofservice" class="form-control" value="'.$doservice->armOfservice.'" />
												<input type="hidden" name="dosid" value="'.$doservice->dosid.'" />
												<input type="hidden" name="hiddenName" value="'.$doservice->armOfservice.'" />';
										}else{
											echo '<input type="text" name="armofservice" class="form-control" />
												  <input type="hidden" name="hiddenName" value="" />';

										}
										@endphp

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Service Number</label>
										@php if($doservice != ''){
											echo '<input type="text" name="servicenum" class="form-control" value="'.$doservice->serviceNumber.'"/>';
										}else{
											echo '<input type="text" name="servicenum" class="form-control" />';
										}
										@endphp

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Reason For Leaving</label>
										@php if($doservice != ''){
											echo '<textarea name="reason" class="form-control">'.$doservice->reasonForLeaving.'</textarea>';
										}else{
											echo '<textarea name="reason" class="form-control"></textarea>';
										}
										@endphp
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Last Unit</label>
										@php if($doservice != ''){
											echo '<input type="text" name="lastunit" class="form-control" value="'.$doservice->lastUnit.'" />';
										}else{
											echo '<input type="text" name="lastunit" class="form-control" placeholder="Optional" />';
										}
										@endphp
									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="javascript: loadProfileDetail('{{$staffid}}')" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>
								@php //if($doservice != ''){ @endphp
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i>
										</button>
									</div>
								</div>
								@php //} @endphp

								</div>
							</div>
							<hr />

					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Arm Of Service</th>

       <th>Service Number</th>
       <th>Last Unit</th>
       <th>Reason For Leaving</th>

							</tr>
						</thead>
						<tbody>
						@php if($dosList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($dosList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->armOfservice}}</td>
								<td>{{$list->serviceNumber}}</td>
								<td>{{$list->lastUnit}}</td>
								<td>{{$list->reasonForLeaving}}</td>
								<td><a href="{{url('/update/detailofservice/view/'.$list->dosid)}}" title="Edit" class="btn btn-success fa fa-edit"></a>
								</td>

							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="7" class="text-center">No setail of service in the force provided yet !</td>
								</tr>
						@php } @endphp

						</tbody>
					</table>
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>

		  <form action="{{url('/process/detailofservice/')}}" method="post">
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
												<input type="text" name="fullName" class="form-control" />
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
<form method="post" id="displayform" name="displayform"  action="{{url('/profile/details')}}">

    {{ csrf_field() }}

    <input type="hidden" id="fileNos" name="fileNo" >



</form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function  loadProfileDetail(staffid)
{
document.getElementById('fileNos').value = staffid;
document.forms["displayform"].submit();
return;

}
</script>
  <script type="text/javascript">
	//Modal popup
	$(document).ready(function(){
		$('.open-modal').click(function(){
			$('#myModal').modal('show');
		});
	});
</script>



@if (session('msg'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end', // top-end, top-start, bottom-end, etc.
    icon: 'success',
    title: '{{ session("msg") }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
</script>
@endif
@endsection
