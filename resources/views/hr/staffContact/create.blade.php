@extends('layouts.layout')
@section('pageTitle')
Add New Staff
@endsection

@section('content')
   
   <div class="box box-default">
        <div class="box-header with-border hidden-print">
           <h3 class="box-title">@yield('pageTitle')</h3>
        </div>
        
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
           @else                     
               @foreach ($errors->all() as $error)
                       <p>{{ $error }}<strong>Error!</strong></p>
               @endforeach
          @endif
                     
                        
            @if(session('msg'))
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>                        
                <strong>Success!</strong> {{ session('msg') }}
                </div>                        
            @endif
            
         
            
        <form method="post" action="{{ url('staffContact/saved') }}"  id="form1">
                {{ csrf_field() }}
                <!--hidden field for updating record-->   
           

            <div class="box-body">
                <div class="row">          	 
                    <div class="col-md-6">                                      	
                        <label>Name</label>                       
                        	<input type="text" name="name" id="name" class="form-control input-lg" required/>

                        <label>Phone</label>
                        	<input type="text" name="phone" id="name" class="form-control input-lg" required/>                       
                    </div>           
                    <br>

                    	<button type="submit" name="button" class="btn btn-sm btn-info">Add New Contact</button>
                </div>
            </div>      	 		      	 	
        </form>
        
        <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
            <table id="mytable" class="table table-bordered table-striped table-highlight" >
                <thead>
                    <tr bgcolor="#c7c7c7">
                                                        
                        <th >S/N</th>
                        <th >Name</th>                            
                        <th >Phone</th>                          
                        <th >Edit</th>
                        <th> Delete</th> 
                    </tr>
                </thead>
                <body>
                    @php $serialNum =1; @endphp
                                                
                    @forelse($staff as $listStaff)
                        <tr class="input-lg">
                        <td>{{ $serialNum ++ }}</td>
                        <td>{{ $listStaff->Name }}</td>
                        <td>{{ $listStaff->phone }}</td>
                        <td><button class="btn-sm btn-info" data-toggle="modal" data-target="#exampleModalCenter{{$listStaff->id}}">Edit Contact</button></td>                       
                        <td><button class="btn-sm btn-danger"><a style="color:white; cursor: pointer;" href="{{url('staffContact/show-staff-delete/'.$listStaff->id)}}">Delete</a></button></td>                            
                        </tr>
                   
                </body>
                  <!--EDIT Modal -->
		<div class="modal fade" id="exampleModalCenter{{$listStaff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="form">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title" id="exampleModalLongTitle">Edit Contact</h4>
		        <form method="post" action="{{ url('staffContact/update') }}"  id="form1">
                		{{ csrf_field() }}
                		
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <input type="hidden" name="StaffRecordID" id="staffID" class="form-control input-lg" value="{{$listStaff->id}}"  />
		        <input type="text" name="name" id="name" class="form-control input-lg" value=" {{$listStaff->Name}}"  />
		        <br>
		        <input type="text" name="phone" id="name" class="form-control input-lg" value=" {{$listStaff->phone}}"  />
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		       </form>
		      </div>
		    </div>
		  </div>
		</div>
		 @empty
                        <td>No result found</td>                       	                          
                    @endforelse
            </table>        
        </div>
    </div>
    
@endsection

@section('styles')
@endsection