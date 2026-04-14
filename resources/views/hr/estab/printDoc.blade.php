<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		p
		{
			font-size: 20px;
			font-family: arial;
			line-height: 40px;
		}

		.list span
		{
			font-size: 23px;
			line-height: 33px;
		}
	</style>
</head>
<body>

	<div style="width: 90%; margin-right: auto; margin-left: auto;">

		<p>Director (Admin)</p><br><br>

		<p>Please <strong> {{$staff->surname}} {{$staff->first_name}} {{$staff->othernames}}</strong>
          is due for his/her Anual Increment with effect from  <strong>@if($staff !=''){{date("jS M, Y", strtotime($staff->incremental_date))}} @endif</strong>.
		</p>
		<p>You may wish to approve for further action.</p>

		<p style="float:right;">
			..................... <br/>
			Mrs Adenike Awe <br/>
			Principal Admin Officer
		</p>
		
	</div>

	<div style="clear: both;">

	<div class="comments" style="width:90%; margin-right: auto; margin-left: auto; margin-top: 25px; padding: 30px;">
		@foreach($comments as $list)

		<div class="list"> <span>By: </span> <strong style="font-size:18px;">{{$list->name}}</strong> <span style="font-size:14px;">On: {{date("jS M, Y", strtotime($list->updated_at))}}</span><br>
         <span>{{$list->comment}}</span>
		</div>

		@endforeach

	</div>

</body>
</html>