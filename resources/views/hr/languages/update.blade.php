@extends('layouts.layout')

@section('pageTitle')
 <h2>Languages <strong> - </strong><span style="color:green;">{{$names->surname}} {{$names->first_name}}</span></h2>
@endsection

<style type="text/css">
	.table, .table thead th, .table tbody td
	{
		border:1px solid #ccc;
	}
	.table thead th strong
	{
		text-align: center;
	}
</style>

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <form method="post" action="{{ url('/update/languages/') }}">
		  <div class="box-body">
		        <div class="row">

					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Language</label>
										@php if($languages != ''){
											echo '<select class="form-control" name="lang" aria-label="Default select example">
                                                      <option selected disabled>Choose...</option>';
                                                    foreach($allLangData as $data){
                                                      if ($data->languageID == $languages->language){
                                                        echo '<option value = "'.$data->languageID.'" selected>'.$data->language_name.'</option>';
                                                      }else{
                                                        echo '<option value = "'.$data->languageID.'">'.$data->language_name.'</option>';
                                                    }
                                                        }
                                                        echo '</select>
												<input type="hidden" name="langid" value="'.$languages->langid.'" />
												<input type="hidden" name="hiddenName" value="'.$languages->language.'" />';
										}else{
											echo '<select class="form-control" name="lang" aria-label="Default select example">
                                                      <option selected disabled>Choose...</option>';
                                                      foreach($allLangData as $data){
                                                      echo '<option value = "'.$data->languageID.'">'.$data->language_name.'</option>';
                                                        }
                                                        echo '</select>
												  <input type="hidden" name="hiddenName" value="" />';

										}
										@endphp

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Checked By</label>
										@php if($languages != ''){
											echo '<input type="text" name="checkedby" class="form-control" value="'.$languages->checkedby.'"/>';
										}else{
											echo '<input type="text" name="checkedby" class="form-control" />';
										}
										@endphp

									</div>
								</div>

								</div>
								<div class="row">

								<h3 style="padding-left: 10px;">Degree Of Fluency</h3>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Spoken</label>
										@php if($languages != ''){
											echo '<select class="form-control" name="spoken" aria-label="Default select example">
                                                      <option selected disabled>Choose...</option>';
                                                      foreach($allFluencyData as $data){
                                                      if ($data->fluencyID == $languages->spoken){
                                                        echo '<option value = "'.$data->fluencyID.'" selected>'.$data->fluency_title.'</option>';
                                                      }else{
                                                        echo '<option value = "'.$data->fluencyID.'">'.$data->fluency_title.'</option>';
                                                    }
                                            }
                                            echo '</select>
												  ';
										}else{
											echo '<select class="form-control" name="spoken" aria-label="Default select example">
                                                      <option selected disabled>Choose...</option>';
                                                      foreach($allFluencyData as $data){
                                                      echo '<option value = "'.$data->fluencyID.'">'.$data->fluency_title.'</option>';
                                                        }
                                                        echo '</select>
												  ';
										}
										@endphp

									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Written</label>
										@php if($languages != ''){

											echo '<select class="form-control" name="written" aria-label="Default select example">
                                                      <option selected disabled>Choose...</option>';
                                                      foreach($allFluencyData as $data){
                                                      if ($data->fluencyID == $languages->written){
                                                        echo '<option value = "'.$data->fluencyID.'" selected>'.$data->fluency_title.'</option>';
                                                      }else{
                                                        echo '<option value = "'.$data->fluencyID.'">'.$data->fluency_title.'</option>';
                                                    }
                                                        }
                                                        echo '</select>
												  ';
										}else{
											echo '<select class="form-control" name="written" aria-label="Default select example">
                                                      <option selected disabled>Choose...</option>';
                                                      foreach($allFluencyData as $data){
                                                      echo '<option value = "'.$data->fluencyID.'">'.$data->fluency_title.'</option>';
                                                        }
                                                        echo '</select>
												  ';
										}
										@endphp

									</div>
								</div>


								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Exam/Qualified</label>
										@php if($languages != ''){
											echo '<input type="text" name="exam_qualified" class="form-control" value="'.$languages->exam_qualified.'" />';
										}else{
											echo '<input type="text" name="exam_qualified" class="form-control" />';
										}
										@endphp
									</div>
								</div>

							</div>

							<div class="row">


							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="{{url('/profile/details/'.session('fileNo'))}}" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
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
								<th>Language</th>
								<th colspan="3" valign="top" style="text-align:center;">Degree Of Fluency</th>
								<th>Checked By</th>
								
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th>Spoken</th>
								<th>Written</th>
								<th>Exams/Qualified</th>

							</tr>
						</thead>
						<tbody>
						@php if($langList != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($langList as $list)
							<tr>
								<td>{{$key ++}}</td>
								<td>{{$list->language_name}}</td>
								<td>{{$list->spoken_title}}</td>
								<td>{{$list->written_title}}</td>
								<td>{{$list->exam_qualified}}</td>
								<td>{{$list->checkedby}}</td>

							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="7" class="text-center">No Language Entered yet !</td>
								</tr>
						@php } @endphp

						</tbody>
					</table>
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>

		  <form action="{{url('/process/languages/')}}" method="post">
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
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
