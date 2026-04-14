<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.layout')

@section('pageTitle')
    CREATE PUBLIC HOLIDAY
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <div class="box-body">
		        <div class="row">

		            @includeIf('hr.Share.message')
                    <div id="success"></div>
				<div class="col-md-12"><!--2nd col-->
				   <form method="" action="">
						@csrf
							<div class="row">
                                <div class="col-md-2"></div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="description">Choose Date.</label>
										<input type="date" required id="holiday" name="holiday" class="form-control" />
									</div>
								</div>

                                <div class="col-md-4">
									<div class="form-group">
										<label for="title">Title</label>
										<input type="text" required id="title" name="title" class="form-control" />
									</div>
								</div>
                                <div class="col-md-2"></div>
							</div>

							<div class="row">
								<div class="col-md-12">
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" id="addBtn" class="btn btn-success" type="button">
											Add Holiday<i class="fa fa-save"></i>
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

<!-- Edit holiday modall-->
<div class="modal" id="editHoliday">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Holiday</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="editHolidayID">
            <div class="form-group">
                <label for="description">Edit Date.</label>
                <input type="date" required id="edit_holiday" name="edit_holiday" class="form-control" />
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" required id="edit_title" name="edit_title" class="form-control" />
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="updateHoliday" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<!-- end Edit holiday modal-->

{{-- Delete warning modal --}}
  @include('hr.holidays.modals.warning')
{{-- End Modal --}}

<div class="row">
	<div class="col-md-12">
		<em class="text-danger"></em>
		<table class="table table-bordered table-striped" id="holidayTable" width="100%">
			<thead>
				<tr>
					<th>S/N</th>
					<th>DATE</th>
                    <th>TITLE</th>
					<th colspan="2" style="text-align: center">ACTION</th>
				</tr>
			</thead>
			<tbody class="docBody">

			</tbody>
		</table>

	</div>
</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" ></script>

<script type="text/javascript">
	$(document).ready(function () {

        function fetchHolidays()
        {
            $.ajax({
                type: "GET",
                url: "/fetch-holidays",
                dataType: "json",
                success: function (response) {
                    $('tbody').html('');
                    $.each(response.holidays, function (key, item) {
                         $('tbody').append(`<tr>
                            <td>${key + 1}</td>
                            <td>${   moment(item.holiday).format('DD-MM-YYYY')}</td>
                            <td>${item.title}</td>
                            <td>
                                <a href="/edit-holiday/${item.id}"><button type="button" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></button></a>
                            </td>
                            <td>
                                <button type="submit" id="delete" class="btn btn-danger btn-sm " holidayID="${item.id}" holidayName="${item.title}"><span class="fa fa-trash"></span>
                                </button>
                            </td>
                         </tr>`);
                    });
                }
            });
        }

        // <button type="button" value="${item.id}" id="edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editHoliday"><span class="fa fa-edit"></span></button>

        fetchHolidays();

        $('#addBtn').on('click', function(e){
            e.preventDefault()
            let data = {
                'holiday': $('#holiday').val(),
                'title': $('#title').val()
            }
            if(data.holiday == ''){
                alert('Please select date')
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "add-holiday",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.success == 400){

                    }else if(response.status == 409){
                        alert('Holiday Date already Exists')
                    }else{
                        $('#success').html('')
                        $('#success').addClass('alert alert-success')
                        $('#success').text(response.message)
                        $('#holiday').val('')
                        $('#title').val('')
                        setTimeout(() => {
                            $('#success').remove()
                        }, 2500);
                        fetchHolidays();
                    }
                }
            });
        });

        $(document).on('click', '#edit', function(e){
            e.preventDefault()

            let holidayID = $(this).val()

            $.ajax({
                type: "GET",
                url: `/edit-holiday/${holidayID}`,
                success: function (response) {
                    if(response.status == 404){

                    }else{
                        $('#edit_holiday').val(response.holiday.holiday)
                        $('#editHolidayID').val(response.holiday.id)
                        $('#edit_title').val(response.holiday.title)
                    }
                }
            });
        });

        $(document).on('click', '#updateHoliday', function(e){
            e.preventDefault()

            $(this).text("Updating holiday...")
            let id = $('#editHolidayID').val()
            let data = {
                'edit_holiday':$('#edit_holiday').val(),
                'edit_title':$('#edit_title').val()
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "PUT",
                url: `/edit-holiday/${id}`,
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 404){
                        alert(response.message)
                    }else{
                        $('#updateHoliday').text('Updated')
                        $('#editHoliday').hide()
                        location.reload()
                        fetchHolidays()
                    }
                }
            });
        })


        $(document).on("click", "#delete", function () {
            var holidayId = $(this).attr('holidayID');
            var holidayName = $(this).attr('holidayName');

            $(".holidayName").html(holidayName);
            $("#delID").val(holidayId);

            $('#delModal').modal('show');
        });

	});
</script>


