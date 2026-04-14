<?php 
    use Illuminate\Support\Facades\DB;
?> 
@extends('layouts.layout')

@section('pageTitle')
 	Registry
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Move file to Archive</em></strong> </span></h3>
    	</div>
		  <div class="box-body">
		        <div class="row">
		            @includeIf('Share.message')
				</div><!-- /.row -->

		    <div class="row">
		        <div class="col-md-12">
                    <h4 class="text-center"><strong> <u>CLOSED VOLUMES TO MOVE TO ARCHIVE</u> </strong></h4>
                    <p class="card-title-desc"></p>
					@csrf
		            <table class="table table-bordered table-striped" id="servicedetail" width="100%">
							<thead>
								<tr>
									<th>S/N</th>
									<th>FILE NO.</th>
									<th>DESCRIPTION</th>
                                    <th>VOLUME NO.</th>
                                    <th>COACH NO.</th>
                                    <th>ACTION</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($archives) && $archives)
								@foreach($archives as $key=>$list)
                                
                                    @if(!DB::table('tblarchives')->where(['fileID'=> $list->fileID, 'old_volumeID' => $list->old_volumeID])->exists())
									<tr>
										<td>{{ ($key + 1)}}</td>
                                        
                                        <td>{{$list->fileNo}}</td>
                                        <td>{{$list->file_description }}</td>
                                        <td>{{$list->volume_name }}</td>
                                        
                                        <form  method="post" action="{{ url('/push-archives')}}" enctype="multipart/form-data" >
                                        <td>
                                            @csrf
                                            <input type="hidden" name="fileID" value="{{ $list->fileID }}" />
                                            <input type="hidden" name="volume_number" value="{{ $list->old_volumeID }}" />
                                            <input type="text" style="width:150px;" class="form-control" name="shelve_number" value="" placeholder="Enter Coach No"/>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-backdrop="false" data-target="#confirmToSubmit{{$key}}"> Forward to Archives </button>

                                            <!-- Modal to confirm -->
                                            <div class="modal fade text-left d-print-none" id="confirmToSubmit{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit{{$key}}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-success text-center"> <h4>Are you sure you want to forward volume to archives</h4></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                            <button type="submit" class="btn btn-success">Yes Forward</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end Modal-->
                                        </td>
                                        </form>
                                        
                                        
									</tr>
                                    @endif
								@endforeach
								@endif
							</tbody>
							</table>

                            <!-- Modal to delete -->
									<div class="modal fade text-left d-print-none" id="confirmPush" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header bg-success">
													<h4 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="text-success text-center"> <h4>Are you sure you want to push this record(s)? </h4></div>
                                                    <textarea name="getComment" class="form-control" placeholder="Comment (Optional)"></textarea>
												    <input type="hidden" name="getInterviewID" value="{{ isset($getInterviewID) ? $getInterviewID : '' }}" />
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <button type="submit" class="btn btn-success"> Push Now </button>
												</div>
											</div>
										</div>
									</div>
							<!--end Modal-->
                       
		        </div>
		    </div>
	</div>
</div>

@endsection

@section('scripts')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
    <script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
   
@endsection

