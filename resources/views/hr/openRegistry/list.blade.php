@extends('layouts.layout')

@section('pageTitle')
   PERSONAL FILE REGISTRY
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

							<div class="row">
						  <div class="col-md-12">

							<hr />

					<table class="table table-striped table-hover table-bordered table-condensed">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Name Of <br> Staff</th>
								<th>File No.</th>
								<th>Gender</th>
								<th>Designation</th>
								<th>Date Open</th>
								<th>Division/ <br> Registry</th>
								<th>Incoming/<br>Outgoing</th>
								<th>Volume</th>
								<th>Last Page <br> Number</th>
								<th>Recipient Name</th>
								<th>Returned Date</th>
								<th>Purpose Of <br> Movement</th>
								<th>Destination</th>
								<th class="hidden-print"></th>
							</tr>
						</thead>
						<tbody>
						@php if($registry != ''){ @endphp
							@php $key = 1 @endphp
							@foreach($registry as $list)
							<tr class="input-sm">
								<td>{{($registry->currentpage()-1) * $registry->perpage() + $key ++}}</td>
								<td>{{$list->staffname}}</td>
								<td>{{$list->fileNo}}</td>
								<td>{{$list->gender}}</td>
								<td>{{$list->Designation}}</td>
                                <td>{{date_fomat(date_create($list->dateOpen), 'd-M-Y')}}</td>
								// <td>{{$list->dateOpen}}</td>
								<td>{{$list->division}}</td>
								<td>{{$list->in_out}}</td>
								<td>{{$list->volumes}}</td>
								<td>{{$list->lastPageNumber}}</td>
								<td>{{$list->nameOfRecepient}}</td>
								<td>{{$list->returnedDate}}</td>
								<td>{{$list->purposeOfMovement}}</td>
								<td>{{$list->destination}}</td>
								<td class="hidden-print">
								<a href="{{url('/openregistry/edit/'.$list->pfrID)}}" title="Edit" class="btn btn-sm btn-success fa fa-edit"></a>
								</td>
							</tr>
							@endforeach
						@php
						}else{ @endphp
								<tr>
								<td colspan="14" class="text-center">No Record Found !</td>
								</tr>
						@php } @endphp

						</tbody>
					</table>
					<div align="right">
			          Showing {{($registry->currentpage()-1)*$registry->perpage()+1}}
			                  to {{$registry->currentpage()*$registry->perpage()}}
			                  of  {{$registry->total()}} entries
			        </div>
					<div class="pagination hidden-print">
					{{ $registry->links() }}
					</div>
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
