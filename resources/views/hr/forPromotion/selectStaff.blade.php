@extends('layouts.layout')
@section('pageTitle')
Select Staff For Training
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
     <div class="card">
                                    <div class="card-body">

                                        @if($trainingStatus!=4)
                                        <form class="row gy-2 gx-3 align-items-center" style="padding:30px;"method="GET" action="{{route('adminSelectDepartment',$currentTraining)}}" enctype="multipart/form-data">
                                        
                                            <div class="col-sm-6 mb-4">
                                                <label class="" for="autoSizingInput">Department</label>
                                                <select class="form-control" id="autoSizingInput"  name="department" value="{{old('department')}}">
                                                <option value="">-Select Department-</option>
                                                @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->department}}</option>
                                                @endforeach
                                                </select>
                                            </div>                                           
                                            <div class="col-sm-4 mb-4" style="margin-top:30px">
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </form>
                                    
                                        @else
                                        <h3 class="text-center">This training has been concluded</h3>
                                        @endif
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                    	        
                            <div class="row">
                                <div class="col-md-6">
                                <h4 style="margin-left:30px"><strong></strong></h4>
                                <p style="margin-left:30px" class="card-title-desc">View All Staff In Department</p>
                                 <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        
                                                        <th data-priority="1">Name</th>
                                                        <th data-priority="3">Department</th>
                                                        <th data-priority="3">level</th>

                                          
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($staffs))
                                                    @foreach($staffs as $key=>$staff)
                                                    <tr>
                                                        <th>{{$key + 1}}</th>
                                                        <td>{{$staff->surname.' '.$staff->othernames.' '.$staff->first_name}}</td>
                                                        <td>{{$staff->departmentName}}</td>
                                                        <td>{{$staff->grade}}</td>
                                                       
                                                        <td class="row align-items-center">
                                                            @if($staff->selected==0)
                                                            <form class="" method="POST" action="{{route('adminSelectStaff')}}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{$currentTraining}}" name="trainingID">
                                                                <input type="hidden" value="{{$staff->ID}}" name="staffID">
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                            @if($trainingStatus==4)
                                                            disabled
                                                            @endif
                                                            >Select</a></form>
                                                            @else
                                                             <button disabled class="btn btn-primary btn-sm">Selected</a>
                                                            @endif
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                   @endif
                                                    </tbody>
                                            </table>
                                            </div>


                                <div class="col-md-6">
                                <h4 style="margin-left:30px"><strong></strong></h4>
                                <p style="margin-left:30px" class="card-title-desc">View All Selected Staff</p>
    <table style="padding-left:30px" id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        
                                                        <th data-priority="1">Name</th>
                                                        <th data-priority="3">level</th>

                                          
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($trainings))
                                                    @foreach($trainings as $key=>$training)
                                                    <tr>
                                                        <th>{{$key + 1}}</th>
                                                        <td>{{$training->surname.' '.$training->othernames.' '.$training->first_name}}</td>
                                                        <td>{{$training->grade}}</td>
                                                       
                                                        <td class="row align-items-center">
                                                            <form class="" method="POST" action="{{route('adminDeSelectStaff')}}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{$training->ID}}" name="ID">
                                                                
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                             @if($trainingStatus==4)
                                                            disabled
                                                            @endif
                                                            >Remove</a></form>

                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                   @endif
                                                    </tbody>
                                            </table>
                                            <button type="submit"  data-toggle="modal" data-target="#delete"data-target="#delete" class="btn btn-success delete_module" 
                                                            data-id="{{$currentTraining}}"  @if($trainingStatus==4)
                                                            disabled
                                                            @endif>Conclude Training
                                                        
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
                                                             <form class="row gy-2 gx-3 align-items-center" method="POST" action="{{route('concludeTraining')}}" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                
                                                                <input type="hidden" name="id" id="delete_id">
                                                                  <div class="col-sm-4 mb-3">
                                                                        <label class="" for="autoSizingInput">Comment</label>
                                                                        <input type="text" class="form-control" id="comment" placeholder="Enter Comments" name="comment" value="{{old('comment')}}">
                                                                    </div>
                                                                  <div class="col-sm-6 mb-4">
                                                                        <label class="" for="autoSizingInput">Report</label>
                                                                        <textarea class="form-control" id="autoSizingInput" name="report" value="Report"></textarea>
                                                                    </div>                                           

                                                                    <div class="col-sm-6 mb-4">
                                                                        <label class="" for="autoSizingSelect">Attach Attendance sheet</label>
                                                                        <input type="file" class="form-control" id="autoSizingInput" placeholder="Enter" name="attachment" value="{{old('attachment')}}">

                                                                    </div>
                                                        </div>     
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Conclude</button>
                                                        
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