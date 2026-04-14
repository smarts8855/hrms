@extends('layouts.layout')

@section('pageTitle')
  Documents
@endsection

<style type="text/css">
	
    .length
    {
    	width: 80px;
    }
    .remove
    {
    	padding-top: 12px;
    	cursor: pointer;
    }
</style>

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  
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
					
						<form method="post" action="{{ url('/bulk-movement/save')}}">
						    {{ csrf_field() }}

						    <div class="row">
						    <div class="col-md-12">
							<table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
							<tr>
							<th class="duplifer-highlightdups">S/N.</th>
							<th>Document Description</th>
                            <th>Preview</th>
                            
                            
							</tr>
							</thead>
							<tbody>
                                @php
                                  $k = 1;  
                                @endphp
                            @foreach($documents as $list)
							<tr>
                                <td>{{$k++}}</td>
                                <td>{{$list->document_description}}</td>
                                <td><a href="{{asset('documentUpload/documents/'.$list->document_part)}}" target="_blank"><i class="fa fa-file"></i></a></td>
                            </tr>
                            @endforeach

							</tbody>
							</table>

						    </div>
						    </div>
														


							<hr />
							

							</form>	
							<hr />

					
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  
		   
		  <form action="" method="post">
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

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-duplifer.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
<script>
$(document).ready(function () {
    $(".find-duplicates").duplifer();
});
</script>





@endsection
 