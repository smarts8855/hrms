@extends('layouts.layout')

@section('pageTitle')
 	Registry
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">

			<h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Close Volume.</em></strong> </span></h3>
    	</div>

		  <div class="box-body">
		        <div class="row">

		            @includeIf('Share.message')

				<div class="col-md-12"><!--2nd col-->
				   <form method="post" action="{{ url('/open-registry-close-volume')}}" enctype="multipart/form-data" >
						@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="month">File ID</label>
										<select name="fileID" id="fileID" required class="form-control">
											<option value="">Select File</option>
											@if(isset($files) && $files)
												@foreach($files as $listFile)
													<option value="{{$listFile->file_ID}}" {{ $listFile->file_ID == (isset($getFileIDSession) ? $getFileIDSession : old('fileID')) ? 'selected' : '' }}>{{$listFile->file_description}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="oldVolume">Old Volume</label>
										<select name="oldVolume" required readonly="readonly" class="form-control">
											<option value="">Select File</option>
											@if(isset($getVolume) && $getVolume)
												@foreach($getVolume as $listOld)
													<option value="{{$listOld->ID}}" {{ $listOld->ID == (isset($getOldVolume) && $getOldVolume ? $getOldVolume->volume : old('oldVolume')) ? 'selected' : '' }}>{{$listOld->volume_name}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="newVolume">New Volume</label>
										<select name="newVolume" required class="form-control">
											<option value="">Select File</option>
											@if(isset($getVolume) && $getVolume)
												@foreach($getVolume as $listNew)
													<option value="{{$listNew->ID}}" {{ $listNew->ID == (isset($getOldVolume) && ($getOldVolume) ? ($getOldVolume->volume + 1) : old('newVolume')) ? 'selected' : '' }} >{{$listNew->volume_name}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-10">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="button" data-toggle="modal" data-backdrop="false" data-target="#confirmToSubmit">
											Close Volume <i class="fa fa-save"></i>
										</button>
									</div>
								</div>
							</div>
							<!-- Modal to confirm -->
							<div class="modal fade text-left d-print-none" id="confirmToSubmit" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header bg-danger">
											<h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="text-success text-center"> <h4>Are you sure you want to close this volume</h4></div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
											<button type="submit" class="btn btn-success">Yes Close</button>
										</div>
									</div>
								</div>
							</div>
							<!--end Modal-->
						</form>
						<hr />
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->

		    <div class="row">
		        <div class="col-md-12">
					<h4 class="text-center"><strong> <u>LIST OF CLOSED VOLUMES</u> </strong></h4>
                    <p class="card-title-desc"></p>
		            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
								<tr>
									<th>FILE N0. / NAME</th>
									<th>OLD VOLUME</th>
									<th>NEW VOLUME</th>
									<th colspan="2">DATE</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($getCloseRecords) && $getCloseRecords)
								@foreach($getCloseRecords as $key=>$list)
									<tr>
										<td>{{$list->staff_name}}</td>
										<td>{{ DB::table('tblvolume')->where('ID', $list->old_volumeID)->value('volume_name') }}</td>
										<td>{{$list->volume_name}}</td>
										<td>{{date('d-M-Y', strtotime($list->created_at))}}</td>
									</tr>

									{{-- <!-- Modal to delete -->
									<div class="modal fade text-left d-print-none" id="confirmToSubmit{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-danger">
													<h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="text-success text-center"> <h4>Are you sure you want to delete this record? </h4></div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
													<a href="{{url('document-delete-file/'.$list->file_doc_ID)}}" class="btn btn-danger"> Delete </a>
												</div>
											</div>
										</div>
									</div>
									<!--end Modal--> --}}

								@endforeach
								@endif
							</tbody>
							</table>
						<div class="col-md-4">
							{{$getCloseRecords->links()}}
						</div>
		        </div>
		    </div>
	</div>
</div>
<form id="getVolumeForm" method="post" action="{{ url('/file-volume')}}" enctype="multipart/form-data" >
@csrf
	<input type="hidden" name="getFileID" id="getFileID" />
</form>

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $("#fileID").change(function() {
			$('#getFileID').val($('#fileID').val());
            $('#getVolumeForm').submit();
        });
    });//end document
</script>
@endsection

