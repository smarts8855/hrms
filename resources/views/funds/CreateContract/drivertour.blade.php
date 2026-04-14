@extends('layouts.layout')
@section('pageTitle')
Driver Duty tour details for :{{$Vinfo->totalPayment}}: {{$Vinfo->paymentDescription}}
@endsection
@section('content')
<div id="editModal" class="modal fade">
     <form class="form-horizontal" role="form" method="post" action="">
    {{ csrf_field() }}
        <div class="modal-dialog box-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title"> Claim modification </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h5> You are about to modify the claim value, Do you still want to continue?</h5>
                <div class="form-group" style="margin: 5 10px;">
                    <div class="col-sm-12">
                    <input type="text" value=""  id="ename" class="form-control" readonly >
                    </div>
                    
                </div>
                
                <div class="form-group" style="margin: 5 10px;">
                    <div class="col-sm-12">
                    <label class="control-label">Amount</b></label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" value="" name="amount" id="eamount" class="form-control" > 
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="Submit" name="update" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="hidden" id="ebeneid" name="beneid" value="">
                </div>
            </div>
        </div>
    </div>
</form>
    </div> 
    <div id="deleteModal" class="modal fade">
     <form class="form-horizontal" role="form" method="post" action="">
    {{ csrf_field() }}
        <div class="modal-dialog box-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Record removal </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h5> You are about to delete this record, Do you still want to continue?</h5>
                <div class="form-group" style="margin: 5 10px;">
                    <div class="col-sm-12">
                    <input type="text" value=""  id="dname" class="form-control" readonly >
                    </div>
                    
                </div>
                
                <div class="form-group" style="margin: 5 10px;">
                    <div class="col-sm-12">
                    <label class="control-label">Amount</b></label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" value="" name="amount" id="damount" class="form-control" readonly> 
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="Submit" name="delete" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="hidden" id="dbeneid" name="beneid" value="">
                </div>
            </div>
        </div>
    </div>
</form>
    </div>
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
    @if(session('err'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Error!</strong> <br />
            {{ session('err') }}</div>                        
    @endif
    @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Success!</strong> <br />
            {{ session('err') }}</div>                        
    @endif
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
	<form method="post"  id="thisform1" name="thisform1">
		{{ csrf_field() }}
		<div class="box-body">
		    
			 <div class="row">
	            <div class="col-md-6">          
                <label class="control-label">Departure Place</label>
                <input type="text"  name="departure_place"  class="form-control"  value="{{$departure_place}}" placeholder="Departure Place">
            </div>
            <div class="col-md-6">          
                <label class="control-label">Arrival Place</label>
                <input type="text"  name="arrival_place"  class="form-control"  value="{{$arrival_place}}" placeholder="Arrival Place">
            </div>
                
			</div>
			<div class="row">
            <div class="col-md-8">          
                <label class="control-label">Nature of duty</label>
                <input type="text"  name="nature_of_duty"  class="form-control"  value="{{$nature_of_duty}}" placeholder="Nature of duty">
            </div>
                <div class="col-md-2">
            		<label>Ammount</label>
				        <input type="text"  name="amount"  class="form-control"  value="{{$amount}}" placeholder="Amount">
            		</div>
				<div class="col-md-2">
				<br>
					<button type="submit" class="btn btn-success" name="add">
						<i class="fa fa-btn fa-floppy-o"></i> Add
					</button>						
				</div>
			</div>
		</div>
	</form>
	<div class="table-responsive" style="font-size: 12px; padding:10px;">
		<table class="table table-bordered table-striped table-highlight" >
		<thead>
			<tr bgcolor="#c7c7c7">
                <th width="1%">S/N</th>	 
                <th >Departure Place </th>
                <th >Arrival Place </th>
                <th >Nature of duty</th>
                <th >Amount </th>
		        <th >Action</th>
	 		</tr>
		</thead>
		@php $serialNum = 1; $totalsum=0; @endphp
		@foreach ($Tourdetail as $b)
		@php $totalsum +=$b->amount; @endphp
			<tr>
			<td>{{ $serialNum ++}} </td>
				<td>{{$b->departure_place}}</td>
				<td>{{$b->arrival_place}}</td>
				<td>{{$b->nature_of_duty}}</td>
				<td>{{$b->amount}}</td>
				<td><!--<a href="javascript: Editvalue('{{$b->id}}','{{$b->departure_place}}','{{$b->arrival_place}}','{{$b->nature_of_duty}}','{{$b->amount}}')" class="btn alert-success">Edit</a>|-->
				<a href="javascript: DeleteRec('{{$b->id}}','{{$b->amount}}','{{$b->nature_of_duty}}')"class="btn alert-danger">Delete</a></td>
			</tr>
		@endforeach
			<tr>
				<td colspan=2>Total</td>
    			<td>{{$totalsum}}</td>
			</tr>
        </table>
    </div>
    <a href="/display/voucher/{{$vid}}" target="_blank" class="btn btn-info">View vourcher</a>
    </div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
  
  $('.select_picker').selectpicker({
  style: 'btn-default',
  size: 4
});
	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}
	function Editvalue(id,amt,name){
        document.getElementById('ebeneid').value = id;
        document.getElementById('eamount').value = amt;
        document.getElementById('ename').value = name;
        $("#editModal").modal('show');
    }
    function DeleteRec(id,amt,name){
        document.getElementById('dbeneid').value = id;
        document.getElementById('damount').value = amt;
        document.getElementById('dname').value = name;
        $("#deleteModal").modal('show');
    }
  </script>
@endsection
