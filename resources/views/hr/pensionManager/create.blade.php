@extends('layouts.layout')

@section('pageTitle')
  Add Pension Manager
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
						    
                                            
						</div><!-- /.col -->
						</div><!-- /.row -->
						<form method="post" action="{{url('/pensionmanager/store')}}">

						            {{ csrf_field() }}
						            
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="month">Pension Manager</label>
										<input type="text" name="pensionManager" id="pensionmgr" class="form-control" value="{{$pensionManagerName}}" />
										<input type="hidden" name="pensionManagerID" value="{{$getEditID}}" />
									</div>
								</div>	

								
							</div>	

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
											ADD <i class="fa fa-save"></i> 
										</button>
									</div>
								</div>
								
										
								</div>
							</div>

							</form>	
							
					</div>
		        </div><!-- /.col -->
		    </div>
		    <hr /> 	
		    <div class="col-md-12">
					<table class="table table-striped table-condensed table-bordered">
						<thead>
							<th>S/N</th>
							<th>PENSION MANAGER (PFA)</th>
							<th>DATE ADDED</th>
				            <th></th>
						</thead>
						<tbody>
							@php 
				                $key = 1; 
				            @endphp
							@foreach($getAllPFA as $list)
							<tr> 
								<td>{{($getAllPFA->currentpage()-1) * $getAllPFA->perpage() + $key ++}}</td>
								<td>{{$list->pension_manager}}</td>
								<td>{{$list->created_at}}</td>
								<td><a href="{{url('pension-manager/edit/'.$list->ID )}}" class="btn btn-success"><i class="fa fa-edit"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div align="right">
				        Showing {{($getAllPFA->currentpage()-1)*$getAllPFA->perpage()+1}}
				           to {{$getAllPFA->currentpage()*$getAllPFA->perpage()}}
				           of  {{$getAllPFA->total()}} entries
				    </div>
				    <div class="hidden-print">{{ $getAllPFA->links() }}</div>
			</div>


		  
		   
		  
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
   $('#grade').val(data[0].grade);
   $('#level').val(data[0].level);
       
    
  }
});

/*$.ajax({
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
});*/

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