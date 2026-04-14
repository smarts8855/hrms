<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laravel: Search using AJAX</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/css/app.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@include('staffAttachment.navbar')

<div id="getResult" class="panel panel-default" style="width:400px; height: 200px; overflow-y:auto; position:absolute; left:180px; top:55px; z-index:1; display:none;">
	<div id="getList"></div>
</div>
<div class="container">
	@yield('content')

</div>
<script type="text/javascript">
	$(document).ready(function(){
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
						getQueries += '<ul style="margin-top:10px; list-style-type:none;">';
						getQueries +=  '<a href="#">' + value.first_name + ' '+ value.surname + '</a>';
						getQueries +=  '</ul>';
					    });
    					    $('#getList').html(getQueries );
					}

				})
			}
		});
	});
</script>
</body>
</html>