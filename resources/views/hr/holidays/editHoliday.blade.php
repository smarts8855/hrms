@extends('layouts.layout')

@section('pageTitle')
    CREATE HOLIDAY
@endsection

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>
		  <div class="box-body">
		        <div class="row">

		            @includeIf('Share.message')
                    <div id="success"></div>
				<div class="col-md-12"><!--2nd col-->
				   <form method="post" action="/edit-holiday/{{$holiday->id}}">
						@csrf @method('PUT')
							<div class="row">
                                <div class="col-md-2"></div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="description">Choose Date.</label>
										<input type="date" required name="edit_holiday" value="{{$holiday->holiday}}" class="form-control" />
									</div>
								</div>

                                <div class="col-md-4">
									<div class="form-group">
										<label for="title">Title</label>
										<input type="text" required name="edit_title" value="{{$holiday->title}}" class="form-control" />
									</div>
								</div>
                                <div class="col-md-2"></div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" id="addBtn" class="btn btn-success" type="submit">
											Update Holiday<i class="fa fa-save"></i> 
										</button>
									</div>
                                    <div align="left" class="form-group">
										<a href="/holidays"><button name="action" id="addBtn" class="btn btn-secondary" type="button">
											Go Back
										</button></a>
									</div>
								</div>
								</div>
							</div>
						</form>	
						
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		    
	</div>
</div>

@endsection

 