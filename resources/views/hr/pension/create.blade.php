@extends('layouts.layout')

@section('pageTitle')
  CREATE STAFF PENSION
@endsection

<style type="text/css">
	.table {
        display: block;
        overflow-x: auto;
    }
</style>

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
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
		                       
						@if(session('msg'))
		                    <div class="alert alert-success alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Success!</strong>
								<p>{{ session('msg') }}</p> 
						    </div>                        
		                @endif

		                @if(session('err'))
		                    <div class="alert alert-warning alert-dismissible" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
		                        </button>
		                        <strong>Not Allowed ! </strong>
								<p>{{ session('err') }}</p>
						    </div>                        
		                @endif

		            </div>
					{{ csrf_field() }}
			
				<div class="col-md-12"><!--2nd col-->
					<div class="row">
						<div class="col-md-6">
                            <select name="fileid" id="fileid" class="form-control">
								<option value="0" selected="selected">Choose Staff</option>
								@foreach($staffList as $prolist)
									<option value="{{$prolist->fileNo}}">
										{{$prolist->surname .' '. $prolist->first_name .' '.$prolist->othernames .' - '.  'JIPPIS/P/' . $prolist->fileNo }}
									</option>
								@endforeach
							</select>				
						</div><!-- /.col -->

						<form method="post" action="{{ url('/pension/compute/batch')}}">
						{{ csrf_field() }}
							<div class="col-md-6" style="background: #f0f0f0; padding:5px;">
	                           <div class="col-md-4">
	                           		<select name="month"  class="form-control">
								        <option value=""> Select Month </option>
								        <option value="JANUARY">JANUARY</option>
								        <option value="FEBRUARY">FEBRUARY</option>
								        <option value="MARCH">MARCH</option>
								        <option value="APRIL">APRIL</option>
								        <option value="MAY">MAY</option>
								        <option value="JUNE">JUNE</option>
								        <option value="JULY">JULY</option>
								        <option value="AUGUST">AUGUST</option>
								        <option value="SEPTEMBER">SEPTEMBER</option>
								        <option value="OCTOBER">OCTOBER</option>
								        <option value="NOVEMBER">NOVEMBER</option>
								        <option value="DECEMBER">DECEMBER</option>
							         </select>
	                           </div>
	                           <div class="col-md-4">
	                           		<select name="year"  class="form-control">
	                                      <option value=""> Select Year </option>
	                                      @for($i = 2016; $i <= 2050; $i++)
	                                      <option>{{$i}}</option>
	                                      @endfor
	                                </select>
	                           </div>
	                           <div class="col-md-4">
	                           		<button class="btn btn-sm btn-success"><i class="fa fa--save"></i> Batch Compute</button>
	                           </div>		
							</div><!-- /.col -->
						</div><!-- /.row -->
					</form>

					<hr />
					<form method="post" action="{{ url('/pension/compute')}}">
					{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">File Number</label>
										<input type="text" name="getFileNo" id="getFileNo" class="form-control" readonly />
										<input type="hidden" name="fileNo" id="fileNo" />
										
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Name Of Staff</label>
										<input type="text" name="staffname" id="staffname" class="form-control" readonly/>
									</div>
								</div>
							</div>	

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Designation</label>
										<input type="text" name="designation" id="designation" class="form-control" readonly/>
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Appointment Date</label>
										<input type="text" name="appoint_date" id="appoint_date" class="form-control" readonly/>
									</div>
								</div>
							</div>

							<div class="row">
							
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Grade</label>
										<input type="text" name="grade" id="grade" class="form-control" readonly />
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Step</label>
										<input type="text" name="step" id="step" class="form-control" readonly/>
									</div>
								</div>
                            </div>

							<div class="row">
								<div class="col-md-6">
						              <div class="form-group">
						               <label >Select a Month</label>                       
						               <select name="month" id="section" class="form-control">
							                <option value=""></option>
							                <option value="JANUARY">JANUARY</option>
							                <option value="FEBRUARY">FEBRUARY</option>
							                <option value="MARCH">MARCH</option>
							                <option value="APRIL">APRIL</option>
							                <option value="MAY">MAY</option>
							                <option value="JUNE">JUNE</option>
							                <option value="JULY">JULY</option>
							                <option value="AUGUST">AUGUST</option>
							                <option value="SEPTEMBER">SEPTEMBER</option>
							                <option value="OCTOBER">OCTOBER</option>
							                <option value="NOVEMBER">NOVEMBER</option>
							                <option value="DECEMBER">DECEMBER</option>
						              </select>
						            </div>
						          </div>

						          <div class="col-md-6">
						              <div class="form-group">
						               <label >Select a Year</label>                       
						               <select name="year"  class="form-control">
	                                      <option value=""> Select Year </option>
	                                      @for($i = 2016; $i <= 2050; $i++)
	                                      <option>{{$i}}</option>
	                                      @endfor
	                                </select>
						            </div>
						          </div>
							</div>
						            

                            <div class="row" style="margin-top: 6px;">
                            	<div class="col-md-6">
									<div class="form-group">
										<label for="month">Employee Type</label>
										<input type="text" name="emptype" id="emptype" class="form-control" readonly/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label for="month">Pension Manager</label>
									<select name="penmgr" id="penmgr" class="form-control">
									<option value="">Select Pension Manager</option>
										@foreach($penmgr as $list)
											<option value="{{$list->ID}}">{{ $list->pension_manager }} </option>
									    @endforeach 
								    </select>	
								</div>
							</div>		
						</div>
						<div class="row">
							<div class="col-md-6">
									<div class="form-group">
										<label for="month">RSA NUMBER (PIN)</label>
										<input type="text" name="rsanumber" id="rsanumber" class="form-control" />
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">TOTAL BASIC, HOUSING &amp; TRANSPORT ALLOWANCE</label>
										<input type="text" name="basicAllowance" id="basicAllowance" class="form-control" />
									</div>
								</div>	
	
                            </div>
                            <div class="row">
                            	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Remarks</label>
										<textarea name="remark" id="remark" class="form-control"></textarea>
										
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="form-group col-md-6">
										<label for="month">Employee's Contribution (8%)</label>
										<input type="text" name="employeeContribution" id="employeepension" class="form-control" />
									</div>
									<div class="form-group col-md-6">
										<label for="month">Employer's Contribution (10%)</label>
										<input type="text" name="employerContribution" id="employerPension" class="form-control"/>
									</div>
								</div>	
                            </div>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-9">
										<div class="form-group">
											<label for=""></label>
											<div align="right">
												<input class="btn btn-success" name="submit" type="submit" value="Compute Staff Pension"/>
											</div>
										</div>
		              				</div>	
								</div>
							</div>
						</form>	
						<hr />
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  
		   
		  
	</div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/js/datepicker_scripts.js')}}"></script>
<script type="text/javascript">
  $(function() {
   $("#fileid").on('change', function(){
		var id = $(this).val();
		$.ajax({
			  url: murl +'/pension/displaynames',
			  type: "post",
			  data: {'nameID': id, '_token': $('input[name=_token]').val()},
			  success: function(data){
			    $('#staffname').val(data[0].surname+', '+data[0].first_name);
			    $('#getFileNo').val('JIPPIS/P/' + data[0].fileNo); 
			    $('#fileNo').val(data[0].fileNo);
			    $('#designation').val(data[0].Designation);
			    $('#appoint_date').val(data[0].appointment_date);
			    $('#grade').val(data[0].grade);
			    $('#step').val(data[0].step);
			    $('#emptype').val(data[0].employee_type); 
			  }
		});
		$.ajax({
			  url: murl +'/pension/getpension',
			  type: "post",
			  data: {'ID': id, '_token': $('input[name=_token]').val()},
			  success: function(result){
			   $('#employeepension').val(parseFloat(result[0].pension).toFixed(2)); 
			   $('#basicAllowance').val(parseFloat((result[0].pension) * 12.5).toFixed(2));
			   $('#employerPension').val(parseFloat((result[0].pension) * 1.25).toFixed(2));     
			  }
		});

	});
});
</script>
@stop