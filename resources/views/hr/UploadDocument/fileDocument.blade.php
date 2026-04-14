@extends('layouts.layout')

@section('pageTitle')
 	Registry
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>Upload Document.</em></strong></span></h3>
        </div>
		  <div class="box-body">
		        <div class="row">

		            @includeIf('Share.message')

				<div class="col-md-12"><!--2nd col-->
				   <form method="post" action="{{ url('/document-file-upload')}}" enctype="multipart/form-data" >
						@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="month">File ID/No.</label>
										<select name="fileID" id="userIDSelected" required class="form-control">
											<option value="">Select File</option>
											@if(isset($files) && $files)
												@foreach($files as $listFile)
													<option value="{{$listFile->file_ID}}"
														{{ (isset($userIDSelected) && $userIDSelected == $listFile->file_ID) ?  'selected' : '' }}>
														{{$listFile->fileNo}}
													</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="description">Document Description</label>
										<input type="text" name="description" class="form-control" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Select File</label>
										<input type="file" name="file" required class="form-control" />
									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Upload Document <i class="fa fa-save"></i>
										</button>
									</div>
								</div>
								</div>
							</div>
						</form>
						<hr />
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->

		    <div class="row">
		        <div class="col-md-12">
		            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
								<tr>
									<th>File No/Name</th>
									<th>FILE DOCUMENT DESCRIPTION</th>
									<th>VOLUME</th>
									<th>CATEGORY</th>
									<th colspan="3" style="text-align: center;">ACTION</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($getFileDocs) && $getFileDocs)
								@foreach($getFileDocs as $key=>$list)
									<tr>
										<td>{{$list->fileNo}}</td>
										<td>{{$list->document_description}}</td>
										<td>{{$list->volume_name}}</td>
										<td>{{$list->category}}</td>
										<td><a href="{{url('/edit-document/'.$list->file_doc_ID)}}"><button class="btn btn-primary"><i class="fa fa-edit"></i></button></a></td>
										<td>
											<button type="button" class="btn btn-danger" data-toggle="modal" data-backdrop="false" data-target="#confirmToSubmit{{$key}}"><i class="fa fa-trash"></i></button>
										</td>
										<td><a href="{{ (isset($docPath) ? $docPath . $list->document_part : '') }}" target="_blank" class="btn btn-success"> View <i class="fa fa-file"></a></td>
									</tr>

									<!-- Modal to delete -->
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
									<!--end Modal-->

								@endforeach
								@endif
							</tbody>
							</table>
		        </div>
		    </div>
	</div>
</div>
<form id="getUserFileForm" method="post" action="{{ url('/select-user-document-file-upload')}}" enctype="multipart/form-data" >
@csrf
	<input type="hidden" name="getUserID" id="getUserID" />
</form>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $("#userIDSelected").change(function() {
			$('#getUserID').val($('#userIDSelected').val());
            $('#getUserFileForm').submit();
        });
    });//end document
</script>
@endsection

