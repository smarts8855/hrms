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
                                                        <th data-priority="3">Date</th>
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
                                                        <td>{{$training->date}}</td>
                                                        <td><img width="100px" src="{{asset('/trainingAttachment/'.$training->attachment)}}"></td>
                                                        <td>
                                                            @if($training->status==1 || $training->status==3)
                                                            Admin
                                                            @else
                                                            Secretary
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($training->status==4)
                                                            Complete
                                                            @else
                                                            In Progress
                                                            @endif
                                                        </td>
                                                       
                                                        <td class="row align-items-center">
                                                             @if($training->status==2)
                                                            <a href="{{route('secretaryApprovalStage',$training->ID)}}">Approve</a>
                                                            
                                                            @else
                                                            View
                                                            
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