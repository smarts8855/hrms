@extends('layouts.layout')

@section('pageTitle')
  Picture Viewer
@endsection

@section('content')
  
  <div class="box-body">
  <div class="panel panel-success" style="margin: 0 15px;">
	   <div class="panel-heading">
		   <h3 class="panel-title">Upload Staff Picture</h3>
	  </div>
	  <div class="panel-body">
	    <form method="post" action="{{ url('/pictureViewer/create') }}" enctype="multipart/form-data">
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
                       
				@if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> 
						{{ session('msg') }}
				    </div>                        
                @endif

				<!-- New Error Alert-->
				@if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> 
						{{ session('err') }}
				    </div>                        
                @endif


            </div>
			{{ csrf_field() }}
            
			<!-- 1st column -->
            <div class="col-md-4">
              <div class="form-group">
				 <label for="staff">Select Staff Name</label>
				 <select name="staffName" id="staffName" class="form-control">
					<option></option>
					@foreach($staffList as $staff)
					<option value="{{$staff -> fileNo}}">
						{{$staff -> surname . ' ' . $staff -> first_name . ' ' . $staff -> othernames}}
					</option>
					@endforeach
				</select>
              </div>
              <div class="form-group">
			  		<label for="photo">Select File</label>
					<div class="form-control">
			  			<input type="file" name="photo" id="photo" />
					</div>
              </div>

						
        </div>
            <!-- /.col -->
            <!-- 2nd column -->
            <div class="col-md-4">
				<div class="form-group">
					<label for="file">File Number</label>
					<input type="text" name="fileNo" id="fileNo" readonly class="form-control" />
				</div>
             <div class="form-group">
                <label for="name">Staff Full Name</label>
				<input type="text" name="name" id="name" readonly class="form-control" />
              </div>
              
         </div>

            <!-- /.col -->
            <!-- 3rd column -->
            <div class="col-md-4">
                <div class="form-group">
			  	   <label for="month">&nbsp;</label><br />
                   <img id="image" src="{{asset('passport/0.png')}}" height="180"  /> 
                </div>
            </div> 
            <div class="form-group" style="margin-left:20px;"> 
				<input name="action" id="action" class="btn btn-success" data-toggle="modal" data-target="#confirmActionModal" type="button" value="Update Staff Record" />
                <!--<input type="reset" class="btn btn-info" name="reset" value="clear form">-->
            </div>
		</div>
	  </div>
	</div>
<!--fonfirm div-->
	<div class="modal fade" id="confirmActionModal" 
		tabindex="-1" role="dialog" 
		aria-labelledby="confirmActionModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" 
						data-dismiss="modal" 
						aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" 
						id="confirmActionModalLabel">Please confirm file upload action!</h4>
				</div>
				<div align="center" class="modal-body">
						<p>
							If picture of the same name is found on this server, it will be overrided by the new uploaded picture!
							<br />
							<b><span id="fav-title"><span id="staffModelName">You have not selected any name</span></span></b> 
							<br />
							<b><strong><div align="center" class="text-success">Will you like to upload new/override existing picture ?</div></strong></b>
						</p>
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="pull-right">
							<input name="action" id="action" class="btn btn-primary" type="submit" value="Yes" />
						</span>
				</div>
		 </div>
	  </div>
</div>
<!--//-->

</form>

	<br />
	<form method="post" action="{{ url('/pictureViewer/report') }}">
	{{ csrf_field() }}
		 <div class="panel panel-success" style="margin: 0 15px;">
			 <div class="panel-heading">
				<h3 class="panel-title">View Staff Picture</h3>
			</div>
		    <div class="panel-body">
				 <div class="row">
				  <div class="col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<label for="bank">Bank</label>
							<select name="bank" id="bank" class="form-control">
								<option></option>
								@foreach($bankList as $bank)
								<option value="{{$bank -> bankID}}">
									{{ $bank -> bank }}
								</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="bankGroup">Bank Group</label>
							<input type="text" name="bankGroup" id="bankGroup" class="form-control" />
						</div>
					</div>
				

				 <div class="form-group" style="margin-left:20px;"> 
				    <label for="picture">&nbsp;</label>
					<input type="submit" name="display" id="display" class="btn btn-success" value="Display Picture" />
                   	<input type="submit" name="missing" id="missing" class="btn btn-success" value="Missing Picture">
                </div>
			 </div>
		   </div>
		</div>
	</div>
	</form>

             <!--end of col-md-4 -->
            <!-- /.col -->
       </div><!-- /.row -->
    </div><!-- /body -->

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
	(function () {
	  $('#staffName').change( function(){
		$.ajax({
			url: murl +'/pictureViewer/findStaff',
			type: "post",
			data: {'staffName': $('#staffName').val(), '_token': $('input[name=_token]').val()},
			success: function(data){
					$('#image').attr('src', murl+'/passport/'+data.fileNo+'.jpg');
					$('#name').val(data.surname + ' ' + data.first_name + ' ' + data.othernames);
					$('#staffModelName').html('Staff Name: ' + data.surname + ' ' + data.first_name + ' ' + data.othernames);
					$('#fileNo').val(data.fileNo);
			}
		})	
	});}) ();
</script>
@endsection