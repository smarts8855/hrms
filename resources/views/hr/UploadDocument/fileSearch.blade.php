<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.layout')

@section('pageTitle')
Registry
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i>  <span id='processing'><strong><em>Search File.</em></strong></span></h3>
        </div>
		  <div class="box-body">
		        <div class="row">

		            @includeIf('Share.message')

					<div class="alert alert-success"><span></span></div>

				<div class="col-md-12"><!--2nd col-->
				   <form method="get" action="">
						@csrf
							<div class="row">
                                <div class="col-md-2"></div>
								<div class="col-md-8">
									<div class="form-group">
										{{-- <label for="description">FILE ID/NO.</label>
										<input type="text" id="fileNo" name="fileNo" class="form-control" /> --}}


                                        <label for="fileNo">FILE ID/No.</label>
                                        <select  id="fileNo" name="fileNo" class="select2" style="width: 75%">
                                            <option selected disabled>Select the File ID/No.</option>
                                            @foreach ($fileData as $file)
                                                <option value="{{$file->fileNo}}">{{$file->fileNo}}</option>
                                            @endforeach
                                        </select>

                                    </div>

								</div>
								<div class="col-md-2"></div>
							</div>

							<div class="row">
								<div class="col-md-12">
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" id="searchBtn" class="btn btn-success" type="button">
											Search<i class="fa fa-save"></i>
										</button>
									</div>
								</div>
								</div>
							</div>
						</form>

					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->

	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="text-msg"></div>
		<table class="table table-bordered table-striped" id="servicedetail" width="100%">
			<thead>
				<tr>
					{{-- <th>S/N</th> --}}
					<th>FILE NO/NAME</th>
					<th>FILE DOCUMENT DESCRIPTION</th>
					<th>VOLUME</th>
					<th>CATEGORY</th>
					<th colspan="2" style="text-align: center">ACTION</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>

	</div>
</div>

<!--delete file doc -->
<div class="modal fade" id="deleteFileDocumentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remove File Document</h5>
            </div>
            <div class="modal-body">

               <input type="hidden" id="delete_fileDocument_id">
               <h4>Are you sure you want to delete this file document ?</h4>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete_file_doc">Yes Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- end delete file doc modal-->

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
	$(document).ready(function () {

		$('.alert-success').hide()
        $('.select2').select2({
            width: 'resolve' // need to override the changed default
        });

		$('#searchBtn').on('click', function(e){
			e.preventDefault()

			let fileNo = $('#fileNo').val();
			if(!fileNo){
				alert('Please provide file ID/No.')
			}

			$.ajax({
				type: "GET",
				url: `search-file/${fileNo}`,
				dataType: "json",
				success: function (response) {

					let len = 0;
                        if (response.data != null) {
                            len = response.data.length;
                        }

                        if (len > 0) {
							$('tbody').html('');
							$.each(response.data, function (index, item) {
								$('tbody').append(`<tr>
									<td>${item.fileNo}</td>
									<td>${item.document_description}</td>
									<td>${item.documentVolumeID}</td>
									<td>${item.category}</td>
									<td><a href="/edit-file/${item.fileID}"><button class="btn btn-primary">Edit</button></a></td>
								</tr>`)

                                // <td><button type="button" value="${item.fileID}" class="delete_fileDocument btn btn-danger btn-sm">Delete</button></td>
							});

						}else{
							$('.text-msg').html('');
							$('.text-msg').addClass('alert alert-warning').text(`No Documents Found For ${fileNo}`)
							setTimeout(() => {
								$('.text-msg').remove()
							}, 3000);
						}
				},
                error: function(response) {
                    console.log(response);
                }
			});
			// $('#fileNo').val('')
			// $("#servicedetail").load(location.href+" #servicedetail>*","");
			// <td><form action="/remove-document/${item.documentID}" method="post">
            //                             @csrf @method('DELETE')
            //                                 <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
            //                             </form>
            //                         </td>
		});

		$(document).on('click', '.delete_fileDocument', function(e){
            e.preventDefault(e)
            let docID = $(this).val(); //using $(this) because of the value attr associated with the button
            // console.log(student_id);
            $('#delete_fileDocument_id').val(docID)
            jQuery('#deleteFileDocumentModal').modal('show')

        });

		$(document).on('click', '.delete_file_doc', function(e){
            e.preventDefault();
            let docID = $('#delete_fileDocument_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: `/delete-file/${docID}`,
                success: function (response) {
                    // console.log('good');
					$('.alert-success').text(response.message)
					$('#deleteFileDocumentModal').modal('hide')
					location.reload()
                },
                error: function (response) {
                    console.log(response)
                }
            });
        });

	});
</script>


