@extends('layouts.layout')
@section('pageTitle')
Cancelled Vouchers
@endsection
@section('content')
<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title"> @yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @include('Share.message')
        <!-- /.row -->
        
        <div class="row hidden-print">
            <form id="thisform1" name="thisform1" method="post" >
	<div class="col-md-12">
		<div class="form-group">
		
				<div class="col-md-5">
			<label>Current Location</label>
			<select name="location" id="location" class="form-control" onchange ="ReloadForm();">
			<option value="" selected>-All-</option>
			@foreach ($UnitLocation as $b)
			<option value="{{$b->id}}" {{$location == "$b->id"? "selected":"" }}>{{$b->unit}}</option>
			@endforeach 
			</select>
			</div>     
		</div>
		
		</div>
		
		<div class="col-md-12">
			<div class="form-group">

                <br>
                <label class="control-label"></label>
                <button type="submit" class="btn btn-success" name="add">
                    <i class="fab fa-btn fa-sistrix"></i> Search
                </button>         
            
			</div>
        </div>
        {{ csrf_field() }}
        </form>
	</div>
        <div class="row">     
        
          <!-- /.col --> 
        </div>

        
            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="res_tab" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>Action</th>
                            <th>Beneficiary</th>
                            <th>Total Amount</th>
                            <th>Contract Description</th>
                            <th>Payment Description</th>
                            <th>Progress Status</th>
                            <th>Location</th>
                            <th>Date Prepared</th>
                            
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>
                        @if($tablecontent)
                            @foreach($tablecontent as $list)
                               <tr @if($list->isrejected==1) style="background-color: red; color:#FFF;" @endif>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                      <div class="dropdown">
                                          <button class="btn btn-danger btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                            <span class="caret"></span>
                                          </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">                                   
                                        <li><a href="/display/voucher/{{$list->ID}}" >Preview</a></li>
                                        <li><a  href="/display/comment/{{$list->conID}}" target="_blank">View Minute</a></li>
                                        <li><a onclick="decline('{{$list->ID}}')" >Recall</a></li>
                                            </ul>
                                        </div>
                                        </td>
                                    
                                    @if($list->companyID<> "13")
                                    <td>{{ $list->contractor}}</td>
                                    @else
                                    <td>{{ $list->payment_beneficiary}}</td>
                                    @endif
                                    <td>{{ number_format($list->totalPayment,2) }}</td>
                                    <td>{{ $list->ContractDescriptions }}</td>
                                    <td>{{ $list->paymentDescription }}</td>
                                    <td>{{$list->statusdesc}}</td>
                                    <td>@if($list->vstage<1 &&$list->is_advances==1) Advances @else {{$list->unit}} @endif</td>
                                    <td>{{$list->datePrepared}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                               <td colspan="100%">
                                   <center>No Record</center>
                               </td> 
                            </tr>
                        @endif
                   
                    </tbody>                    
                </table>
        <br><br><br><br><br>
            </div>
            <input type="hidden" value="" id="co" name="court">
            <input type="hidden" value="" id="di" name="division">
            <input type="hidden" value="" name="status">
            <input type="hidden" value="" name="chosen" id="chosen">
            <input type="hidden" value="" id="type" name="type">
          
          <hr />
        </div>
       
  </div>
</div>
 <!--decline modal-->
        <div id="declineModal" class="modal fade">
            <form class="form-horizontal" role="form" method="post" action="">
    {{ csrf_field() }}
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Recall Voucher</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"> 
             <h5> You are about to recall this voucher from further processing! Do you still want to continue?</h5>
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="control-label"><b>Enter Reason for the action</b></label>
                    </div>
                    <div class="col-sm-12">
                            <textarea  name="comment"  class="form-control" required > </textarea>
                    </div>
                    <input type="hidden"  id="vdid" name="vid">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" name="decline" class="btn btn-success">Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                
            </div>
          </div>
          </form>
        </div>
        <!--end of decline modal-->


@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop

@section('styles')
<style type="text/css">
    .modal-dialog {
width:13cm
}

.modal-header {

background-color: #006600;

color:#FFF;

}

#partStatus{
    width:2.5cm
}

</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>

$( function(){
   $("#fromdate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
   $("#todate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'});
    });
    function  ReloadForm()
  { 
  document.getElementById('thisform1').submit();
  return;
  }

  $('#res_tab').DataTable( {
    "pageLength": 50
});
function decline(a){
        document.getElementById('vdid').value=a;
        $("#declineModal").modal('show')
        return false;
    }
</script>
@stop

