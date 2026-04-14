@extends('layouts.layout')

@section('content')

  <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Attachment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="{{ url('/attachment') }}">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to delete this record?</b></label>
                    </div>
                    <input type="hidden" name="fileid" id="deleteid" name="deleteid" value="">
                    
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
    
 <div class="col-md-8 col-md-offset-2">
         <nav class="navbar navbar-default" style="background-image: linear-gradient(to right, #00a65a, white,#00a65a)">
	  	<div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    	<div class="navbar-header">
	      		
	      		<b class="navbar-brand" style="color:white">Search Staff</b>
	    	</div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="" id="" style="overflow-y:auto">
		      	<form class="navbar-form navbar-left">
		      		{{ csrf_field() }}
		        	<div class="input-group">
		          		<input type="text" id="search" name="search" class="form-control" style="width:700px;" placeholder="Staff Name" value="{{ old('search') }}">
		          		<span class="input-group-btn">
		          		<!--
	                  		<button type="submit" class="btn btn-default">
	                   		<span class="glyphicon glyphicon-search"></span>
	                   		</button>
	                   		-->
	                	</span>
		        	</div>
		      	</form>
		    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	<div id="getResult" class="panel panel-default" style="background-image: linear-gradient(to right, lightgreen, white);width:400px; height: 200px; overflow-y:auto; position:absolute; left:180px; top:55px; z-index:1; display:none;">
	<div id="getList"></div>
	</div>
	<hr>
	
          
          <hr />
</div>
	<div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr style="background-image: linear-gradient(to right, lightgreen, lightgreen)">
                            	 
                            
                            <!--<th >S/N</th>-->                          
                            <th >SurName</th>
                            <th >First Name</th>
                            <th >OtherNames</th>
                            <th >CV & Description</th>
                            <!--<th >Action</th>-->
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>
                     @php  $filepath="/staffattachments/" @endphp
                  
                    @foreach($VIEWRECORD as $list)
                        <tr>
                            
                           
                            <td>{{$list->surname}}</td>
                            <td>{{$list->first_name}}</td>
                            <td>{{$list->othernames}}</td>

                            <td>
                            @foreach($attachment as $att)   
                            
                                   @if ($att->staffID==$list->ID) 
                            
	                               <a href="{{ $filepath }}{{ $att->filepath }}"> {{ $att->filepath }}</a> &nbsp;[ <i style="color:green">{{ $att->filedesc }}</i> ]&nbsp;- <button class="btn-xs" onclick="deletefunc('{{ $att->id}}')">Delete</button><br>
	                           @else
	                               <!--<i style="color:red">{{'No attachments'}}</i>-->
	                               
	                           @endif
                            
                            @endforeach
                            </td>
                            <!--
                            <td>
                                <button class="btn btn-sm btn-primary" style="cursor: pointer;" 
                                onclick="editfunc('{{$list->ID }}')">Edit</button>

                                <button class="btn btn-sm btn-warning" style="cursor: pointer;" 
                                onclick="deletefunc('{{ $list->ID }}')">Delete</button>
                            </td>  
                            -->                              
                        </tr>
                    @endforeach
                 
                    </tbody>                    
                </table>
        
            </div>
@endsection
@section('scripts')
<script>
function deletefunc(x)
    {
        //$('#deleteid').val() = x;
       
        document.getElementById('deleteid').value = x;
        
        $("#DeleteModal").modal('show');
    }
</script>
<script type="text/javascript">


		$.ajaxSetup({
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('#search').keyup(function(){
			var search = $('#search').val();
			if(search==""){
				$('#getResult').css('display', 'none').hide();
			}
			else{
				var getQueries = "";
				$.get("{{ url('/') }}" + '/search/' + search,
					{search:search}, 
					function(data){
					if(data){
						$('#getResult').css('display', 'block');
					}else{
						$('#getResult').css('display', 'none')
					}
					if(search == ''){
					    $('#getResult').css('display', 'none').hide();
					}else{
					   $.each(data, function (index, value){
					        var id=value.ID;
						getQueries += '<ul style="margin-top:10px; list-style-type:none;">';
						getQueries += '<a href={{ url("attachment/")}}' +'/'+ value.ID + '>' + value.surname+ ' '+ value.first_name + ' ' + value.othernames + '</a>';
						getQueries += '</ul>';
					    });
    					    $('#getList').html(getQueries );
					}

				})
			}
		});
	
</script>

@stop