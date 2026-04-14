@extends('layouts.layout')
@section('pageTitle')
Training
@endsection
@section('content')
<div class="box box-default" style="padding-bottom:30px">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
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
                    	        
             
                                <h4 style="margin-left:30px"><strong>Trainings</strong></h4>
                                <p style="margin-left:30px" class="card-title-desc">View All Trainings</p>
                                 <table style="padding-left:30px; margin-bottom:150px" id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        
                                                        <th data-priority="1">Name</th>
                                                        
                                                        <th data-priority="3">Attachment</th>
                                                        <th data-priority="3">Location</th>
                                                        <th data-priority="3">Status</th>
                                          
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($trainings))
                                                    @foreach($trainings as $key=>$training)
                                                    <tr>
                                                        <th>{{$key + 1}}</th>
                                                        <td>{{$training->title}}</td>
                                                        
                                                       <td><a target="__blank" href="{{asset('/trainingAttachment/'.$training->attachment)}}">Preview</a></td>
                                                        <td>
                                                            @if($training->status!=2)
                                                            Admin
                                                            @else
                                                            Secretary
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($training->status==6)
                                                            Complete
                                                            @else
                                                            In Progress
                                                            @endif
                                                        </td>
                                                       
                                                        <td class="row align-items-center">
                                                            @if($userDet[0]->stage==13)
                                                                    @if($training->status==1)
                                                                    
                                                                    <a href="#" data-toggle="modal" class="text-primary module" data-toggle="modal" data-target="#edit" data-id = "{{$training->ID}}">Push To Secretary</a>
                                                                    @else
                                                                    
                                                                    @if($training->status==2)
                                                                    <p>Pending Approval</p>
                                                                    @else

                                                                        @if($training->status>=4)
                                                                        <p>Submitted To AD Admin</p>
                                                                        @else
                                                                        <a href="#" data-toggle="modal" class="text-warning push_module" data-toggle="modal" data-target="#push" data-id = "{{$training->ID}}">Push To AD</a>
                                                                        @endif
                                                                    
                                                                    @endif
                                                                    
                                                                    @endif
                                                            @else
                                                            
                                                            @if($userDet[0]->stage==12)

                                                            @if($training->status==5)
                                                            <a href="{{route('adminSelectDepartment',$training->ID)}}" class="text-warning" data-id = "{{$training->ID}}">Select Department</a>
                                                            @else
                                                            <p>View Training</p>
                                                            @endif

                                                           @endif
                                                           
                                                           @else
                                                             @if($training->status==4)
                                                             <a href="#" data-toggle="modal" class="text-warning push_training" data-toggle="modal" data-target="#push_training" data-id = "{{$training->ID}}">Push To Training Unit</a>
                                                            @else
                                                            <p>In Training Unit</p>
                                                            @endif
                                                            @endif
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                   @endif
                                                    </tbody>
</table>


  
                                               


</div>
</div>
</div>

  <!-- Push Modal -->
    <div id="push" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Post to admin</h5>
                                                            
                                                        </div>
                                                       
                                                       
                                                        <div class="modal-body">
                                                             <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{route('trainingDirectorApproval')}}">
                                                                {{ csrf_field() }}
                                                                <p style="margin-left:14px">Are you sure you would like to Push this Training ? </p>
                                                                <input type="hidden" name="id" id="push_id">
                                                                <div class="col-sm-10 mb-4">
                                                                    <label class="" for="autoSizingInput">Comment</label>
                                                                    <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment" name="comment" value="{{old('comment')}}">
                                                                </div>  
                                                                
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success waves-effect waves-light">Push</button>
                                                        
                                                        </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

    <!-- End Push Modal -->

      <!-- Push Modal -->
    <div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Post to Secretary</h5>
                                                            
                                                        </div>
                                                       
                                                       
                                                        <div class="modal-body">
                                                             <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{route('secretaryApproval')}}">
                                                                {{ csrf_field() }}
                                                                <p style="margin-left:14px">Are you sure you would like to Push this Training ? </p>
                                                                <input type="hidden" name="id" id="edit_id">
                                                                <div class="col-sm-10 mb-4">
                                                                    <label class="" for="autoSizingInput">Comment</label>
                                                                    <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment" name="comment" value="{{old('comment')}}">
                                                                </div>  
                                                                
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success waves-effect waves-light">Push</button>
                                                        
                                                        </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

    <!-- End Push Modal -->

      <!-- Push Modal -->
    <div id="push_training" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Push to Training Unit</h5>
                                                            
                                                        </div>
                                                       
                                                       
                                                        <div class="modal-body">
                                                             <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{route('pushTrainingUnit')}}">
                                                                {{ csrf_field() }}
                                                                <p style="margin-left:14px">Are you sure you would like to Push this Training ? </p>
                                                                <input type="hidden" name="id" id="training_id">
                                                                <div class="col-sm-10 mb-4">
                                                                    <label class="" for="autoSizingInput">Comment</label>
                                                                    <input type="text" class="form-control" id="autoSizingInput" placeholder="Enter Comment" name="comment" value="{{old('comment')}}">
                                                                </div>  
                                                                
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success waves-effect waves-light">Push</button>
                                                        
                                                        </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

    <!-- End Push Modal -->

   
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
                 $('.push_module').on('click',function(){
            var id = $(this).attr('data-id');
            $('#push_id').val(id);
            
           
        })

            $('.push_training').on('click',function(){
            var id = $(this).attr('data-id');
            
            $('#training_id').val(id);
            
           
        })

            $('.module').on('click',function(){
            var id = $(this).attr('data-id');
            
            $('#edit_id').val(id);
            
           
        })
        
    </script>
    @endsection