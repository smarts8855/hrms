@extends('layouts.layout')

@section('content')
<div class="row">
               
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
@endsection
@section('scripts')
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