@extends('layouts.layout')
@section('pageTitle')
<strong>TRAINING</strong>
@endsection
@section('content')
<div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title"><b>@yield('pageTitle')</b> <i class="fa fa-arrow-right"></i> <span id='processing'> <strong><em>Staff's selected for training batch.</em></strong> </span></h3>
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
		                       
				@if(session('success'))
		                    <div class="alert alert-success alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Success!</strong> 
					{{ session('success') }} 
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
    {{-- <h2 style="margin-left:30px;">Batch: </h2> --}}

                    	        
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center"><strong> <u>ALL SELECTED STAFF FOR {{strtoupper($batch->title)}}</u> </strong></h4>
                                    <p class="card-title-desc"></p>
                                 <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        
                                                        <th data-priority="1">Name</th>
                                                        <th data-priority="3">Department</th>
                                                        <th data-priority="3">level</th>

                                          
                                                        
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($trainings))
                                                    <p style="display:none">{{$count=0}}</p>
                                                    @foreach($trainings as $key=>$staff)
                                                    
                                                     <p style="display:none">{{$count=$count+1}}</p>
                                                    <tr>
                                                        <th>{{$count}}</th>
                                                        <td>{{$staff->surname.' '.$staff->othernames.' '.$staff->first_name}}</td>
                                                        <td>{{$staff->departmentName}}</td>
                                                        <td>{{$staff->grade}}</td>
                                                       
                                                        
                                                    </tr>
                                                    
                                                   
                                                    @endforeach
                                                   @endif
                                                    </tbody>
                                            </table>
                                            </div>


  
                                            <button type="submit"  data-toggle="modal" style="margin-left:28px;" data-target="#delete"data-target="#delete" class="btn btn-success delete_module" 
                                                            data-id="{{$trainings[0]->batchID}}"
                                                        >Reverse Nomination 
                                            </button>
                                            </div>


  
                                               


</div></div>
</div>
    <!-- Edit Modal -->
    <div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Update Trainings</h5>
                                                            
                                                        </div>
                                                        <div class="modal-body">
                            <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{route('editTraining')}}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="id" name="id">
                                            <div class="col-sm-4 mb-3">
                                                <label class="" for="autoSizingInput">Training Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                                            </div>

                                            <div class="col-sm-5 mb-3">
                                                <label class="" for="autoSizingSelect">Date</label>
                                                <input type="date" class="form-control" id="date" name="date" value="{{old('date')}}">

                                            </div>
                                             <div class="col-sm-5 mb-3">
                                                <label class="" for="autoSizingSelect">Attachment</label>
                                                <input type="file" class="form-control" id="attachment" name="attachment" value="{{old('attachment')}}">

                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                                        </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
    <!-- End Edit Modal -->

<!-- Delete Modal -->
    <div id="delete" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Conclude Training</h5>
                                                            
                                                        </div>
                                                       
                                                       
                                                        <div class="modal-body">
                                                             <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{route('reverseConcludeTraining')}}" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                
                                                                <input type="hidden" name="id" id="delete_id">
                                                                <p style="margin-left:14px;">Are you sure you would like to reverse the conclusion</p>
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning waves-effect waves-light">Reverse</button>
                                                        
                                                        </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

    <!-- End Delete Modal -->

   
     @endsection
    @section('scripts')
    <script type='text/javascript'>
        $('.module').on('click',function(){
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var date = $(this).attr('data-date');
            
           
           
            $('#name').val(name);
            $('#id').val(id);
            $('#date').val(date);
           
           
      
            
           
        })

        $('.delete_module').on('click',function(){
            var id = $(this).attr('data-id');
            
            $('#delete_id').val(id);
            
           
        })
        
    </script>
    @endsection