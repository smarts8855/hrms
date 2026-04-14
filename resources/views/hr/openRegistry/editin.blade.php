@extends('layouts.layout')

@section('pageTitle')
  Personal File Registry
@endsection

<style type="text/css">
	table {
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
								{{ session('msg') }} 
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
					{{ csrf_field() }}

						<div class="col-md-12"><!--2nd col-->

							<!--
								<div align="right" style="margin-right: 10px;">
									<a href="#" title="Add New" class="btn btn-primary open-modal">
										<i class="fa fa-hand-o-down"></i> <b>Add New</b> 
									</a>
								</div>
							-->

							<div class="row">
						  <div class="col-md-12">
						    <!--<div class="box box-default">
						      <div class="box-header with-border hidden-print">
						        <h3 class="box-title">Search By First Name, Surname or File Number <span id='processing'></span></h3>
						      </div>
						      <form method="post" action="">
						        <div class="box-body">
						          <div class="form-group">
						            
						           <input id="autocomplete" name="q" class="form-control dos">
						           <input type="hidden" id="nameID"  name="nameID">
						          </div>
						        </div>

						      </form>
						    </div>-->
                                             <form method="post" action="">
                                             {{ csrf_field() }}
                                             <select name="fileid" id="fileid" class="form-control">
											<option value="0" selected="selected">Choose one</option>
											@foreach($profile as $prolist)

									                  <option value="{{$prolist->fileNo}}">{{$prolist->surname }}  {{$prolist->first_name}}</option>
									                  @endforeach
									                  
									                  
								                  </select>	
						            


											
								                  </form>
												
																  </div><!-- /.col -->
						</div><!-- /.row -->
						<form method="post" action="{{ url('/data/store/')}}">

						            {{ csrf_field() }}
						            


							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">File Number</label>
										<input type="text" name="fileno" id="fileno" class="form-control" readonly="readonly"/>
												  <input type="hidden" name="hiddenName" value="" />
										
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Name Of Staff</label>
										<input type="text" name="staffname" id="staffname" class="form-control" readonly="readonly"/>
									</div>
								</div>
							</div>	

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Designation</label>
										<input type="text" name="designation" id="designation" class="form-control" readonly="readonly" />
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Gender</label>
										<input type="text" name="gender" id="gender" class="form-control" readonly="readonly"readonly="readonly"/>
									</div>
								</div>
							</div>

							<div class="row">
							<div class="col-md-6">

							<label for="month">Select Division Or Registry</label>

							@php if($details != ''){ @endphp
											<select name="divreg" id="divreg" class="form-control">
											<option value="0" selected="selected">Choose one</option>
											@foreach($details as $lists)

									                  <option value="{{$lists->Name}}">{{$lists->Name}}</option>
									                  @endforeach
									                  
									                  
								                  </select>	
												
										@php }else{ @endphp
											<select name="maritalStatus" class="form-control">
									                  <option value="" selected="selected">Select</option>
									                  <option value="Single" {{ (old("maritalStatus") == "Single" ? "selected":"") }}>Single</option>
									                  <option value="Married" {{ (old("maritalStatus") == "Married" ? "selected":"") }}>Married</option>
									                  <option value="Widow" {{ (old("maritalStatus") == "Widow" ? "selected":"") }}>Widow</option>
									                  <option value="Widower" {{ (old("maritalStatus") == "Widower" ? "selected":"") }}>Widower</option>
								                  </select>
												  <input type="hidden" name="hiddenName" value="" /> 
										@php } @endphp
                            </div>


                            <div class="col-md-6">
									<div class="form-group">
										<label for="month">Date Open</label>
										<input type="text" name="dateopen" id="dateopen" class="form-control" />
									</div>
								</div>

							</div>

							<div class="row">
							<div class="col-md-12">
                                  <label for="month">Select Incoming or Outgoing</label>
                                  <br/>
                                  <label id="status"></label>
							
											<select name="inout" id="inout" class="form-control">
											<option value="0" selected="selected">Choose one</option>
											
									                  <option value="Incoming">Incoming</option>
									                  <option value="Outgoing">Outgoing</option>
									                 
									         </select>	
												
										
                            </div>


							</div>


							<div class="row" style="margin-top: 6px;">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Volume</label>
										<input type="text" name="volume" id="volume" class="form-control"  />
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Last Page Number</label>
										<input type="text" name="lastpage" id="lastpage" class="form-control"/>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Name Of Recepient</label>
										<input type="text" name="recipient" id="recipient" class="form-control" />
									</div>
								</div>	

								<div class="col-md-6" id="inhidden">
									<div class="form-group">
										<label for="month">Return Date</label>
										<input type="text" name="returndate" id="returndate" class="form-control"/>
									</div>
								</div>
							</div>

							<div class="row" id="outhidden">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Purpose Of Movement</label>
										<input type="text" name="purpose" id="purpose" class="form-control" />
									</div>
								</div>	

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Destination</label>
										<input type="text" name="destination" id="destination" class="form-control" />
									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="#" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>
								
								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i> 
										</button>
									</div>
								</div>
								
										
								</div>
							</div>

							</form>	
							<hr />

										</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  
		   
		  <form action="" method="post">
		  {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example"> 
			    <!-- Modal HTML -->
			    <div id="myModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="padding: 10px; border-radius: 6px;">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Add New Next of Kin</b></h4>
					                </div>
					                <div class="modal-body">
					                    <div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Name</label>
												<input type="text" name="fullName" class="form-control" />
											</div>
										</div>	

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Relationship</label>
												<input type="text" name="relationship" class="form-control"/>
											</div>
										</div>
									</div>	

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Address</label>
												<textarea name="address" class="form-control"></textarea>
											</div>
										</div>	

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Phone Number</label>
												<input type="text" name="phoneNumber" class="form-control" placeholder="Optional" />
											</div>
										</div>
									</div>	
					                </div>
					              </div>
					            </div>

			                <div class="modal-footer-not-use" align="right">
			                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Close</button>
			                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save</button>
			                </div>

			            </div>
			        </div>
			    </div>
			</div>
		  </form>
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
    //$("#autocomplete").autocomplete({
     // serviceUrl: murl + '/profile/searchUser',
     // minLength: 2,
      //onSelect: function (suggestion) {
   $("#fileid").on('change', function(){

//$('#nameID').val(suggestion.data);
var id = $(this).val();
//alert(id);
$.ajax({
  url: murl +'/data/searchUser/showAll',
  type: "post",
  data: {'nameID': id, '_token': $('input[name=_token]').val()},
  success: function(data){
    //$('#nextofkinHref').attr('href', ""+murl+"/update/next-of-kin/" + data[0].fileNo ); //next of kin url

    //fileNo = data[0].fileNo;
    $('#staffname').val(data[0].surname+', '+data[0].first_name);
    $('#fileno').val(data[0].fileNo);
    $('#designation').val(data[0].Designation);
   $('#gender').val(data[0].gender);
       
    
  }
});

$.ajax({
  url: murl +'/data/personalFileData',
  type: "post",
  data: {'fileno': id, '_token': $('input[name=_token]').val()},
  success: function(datas){
    //$('#nextofkinHref').attr('href', ""+murl+"/update/next-of-kin/" + data[0].fileNo ); //next of kin url

if(datas != "")
{
        $('#dateopen').val(datas[0].dateOpen);
        $('#divreg ').val(datas[0].division);
        //$('#inout').val(datas[0].in_out);
        $('#volume').val(datas[0].volumes);
        $('#lastpage').val(datas[0].lastPageNumber);
        $('#recipient').val(datas[0].nameOfRecepient);
        $('#returndate').val(datas[0].returnedDate);
        $('#purpose').val(datas[0].purposeOfMovement);
        $('#destination').val(datas[0].destination);
        $('#status').html("<span style=\"color:red;\">Note: The File is</span> " + datas[0].in_out);
       
  }     

       
    
  }
});

});
});
  //});
  $("#inhidden").hide();
 $("#outhidden").hide();
 $("#inout").on('change', function(e){
		var value = $(this).val();
		if(value =="Incoming")
		{
		$("#inhidden").show();
		$("#outhidden").hide();
	}
	if(value =="Outgoing")
		{
		$("#inhidden").hide();
		$("#outhidden").show();
	}


		});
		
</script>



@endsection