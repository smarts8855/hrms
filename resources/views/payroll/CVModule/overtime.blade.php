@extends('layouts.layout')
@section('pageTitle')
Override Special Overtime
@endsection

@section('content')
<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        
	@if (count($errors) > 0)
	                <div class="alert alert-danger alert-dismissible" role="alert">
		              	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		              		<span aria-hidden="true">&times;</span>
		                </button>
		                <strong>Error!</strong> 
		                @foreach ($errors->all() as $error)
		                    <p>{{ $error }}</p>
		                @endforeach
	                </div>
                @endif
                @if ($error != "")
	                <div class="alert alert-danger alert-dismissible" role="alert">
		              	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		              		<span aria-hidden="true">&times;</span>
		                </button>
		                <strong>Error!</strong> 
		                    <p>{{ $error }}</p>
	                </div>
                @endif
                          
                @if ($success != "")
                    <div class="alert alert-success alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                    	{{ $success }}</div>                        
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                    	{{ session('err') }}</div>                        
                @endif
	<form method="post"  id="mainform" name="mainform" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="box-body">
<div class="row">
	@if ($CourtInfo->courtstatus==1)
      <div class="col-md-6">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;" onchange="ReloadForm();">
                  <option value="">Select Court</option>
                  @foreach($CourtList as $b)                  
                  <option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>               
                  @endforeach
                </select>
                 
              </div>
            </div>
@else
<input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
 @endif     
@if ($CourtInfo->divisionstatus==1)
      <div class="col-md-6">
              <div class="form-group">
                <label>Select Division</label>
               
                <select name="division" id="division" class="form-control" style="font-size: 13px;">
                 <option value="All">All Division</option>
                  @foreach($DivisionList as $b)                  
                  <option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>             
                  @endforeach
                </select>
              </div>
            </div>
@else
<input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">
 @endif
</div>
       <div class="row">
			<div class="col-md-12"><!--2nd col-->
			<!-- /.row -->
				<div class="form-group">
					<div class="col-md-3">
						<input type="hidden" id="fileNo" name="fileNo" value="{{$fileNo}}"> 
						<label class="control-label">Staff Names Search</label>
						<input type="text" id="userSearch" autocomplete="off" list="enrolledUsers"  class="form-control"  onchange="StaffSearchReload()">
						<datalist id="enrolledUsers">
					  @foreach($courtstaff as $b)			  
						<option value="{{ $b->ID}}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}({{ $b->fileNo }})"></option>
					  @endforeach
					</datalist>	
					</div>                               
				</div>
			</div>
        </div>
		<div class="row">
			<div class="col-md-12"><!--2nd col-->
			<!-- /.row -->
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label">File Number</label>
						<input required type="text" value="{{ $staff->fileNo }}" name="sname" readonly="readonly" class="form-control" >   
					</div>
					<div class="col-md-3">
						<label class="control-label">Surname</label>
						<input required type="text" value="{{ $staff->surname }}" name="sname" readonly="readonly" class="form-control" >   
					</div> 
					<div class="col-md-3">          
						<label class="control-label">Firstname</label>
						<input required type="text" value="{{ $staff->first_name }}" readonly="readonly" name="fname"  class="form-control" >
					</div>
					
					<div class="col-md-3">
						<label class="control-label">Othername</label>
						<input require type="text" value="{{ $staff->othernames }}" name="oname" readonly="readonly" class="form-control" >   
					</div>
				</div>
			</div>
        </div>
		<div class="row">
			<div class="col-md-12"><!--2nd col-->
			<!-- /.row -->
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label">Gross </label>
						<input required type="text"  name="gross" class="form-control" >
					</div>
						<div class="col-md-3">
						<label class="control-label">Tax </label>
						<input required type="text"  name="tax" class="form-control" >
					</div>
					<div class="col-md-6">
						<label class="control-label">Remarks</label>
						<input required type="text"  name="remarks" class="form-control" >   
					</div> 
					<div class="col-md-2">
		                            <br>
		                            <button type="submit" class="btn btn-success" name="add" >
		                                <i class="fa fa-btn fa-floppy-o"></i> Add
		                            </button>
		                        </div>
				</div>
			</div>
        </div>
      <div class="row">
        <div class="col-md-12">
        
          <div class="form-group">
            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            	 
                            
                            <th >S/N</th>
                            <th >Staff No</th>
                            <th >Staff Name</th>
                            <th >Gross</th>
                            <th >Tax</th>
							<th >Remarks</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>
                   
                    @foreach($backloglist as $list)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->fn}}</td>
                            <td>{{$list->NAMES}}</td>
                            <td>{{$list->gross}}</td>
                            <td>{{$list->tax}}</td>
							<td>{{$list->remarks}}</td>
                            <td><button class="btn btn-sm btn-warning" style="cursor: pointer;" 
                                onclick="deletefunc('{{ $list->id }}'">Delete</button></td>
                                                             
                        </tr>
                    @endforeach
                    </tbody>                    
                </table>
        
            </div>
            
          </div>
          
        </div>
     
</div>

	            		
		</div>
			
		
		
	</form>
	
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
	function  ReloadForm()
	{
	//alert("ururu")	;	
	document.getElementById('thisform1').submit();
	return;
	}
	function  DeletePromo(id)
	{
		var cmt = confirm('You are about to delete a record. Click OK to continue?');
              if (cmt == true) {
					document.getElementById('delcode').value=id;
					document.getElementById('thisform1').submit();
					return;
 
              }
	
	}
function  Reload()
{	
	document.forms["mainform"].submit();
	return;
}
function  StaffSearchReload()
{	

	//document.getElementById('fileNo').value=document.getElementById('userSearch').value;
	//document.forms["mainform"].submit();
	var txv=document.getElementById('userSearch').value;
	var tx = txv.split(':');
	document.getElementById('fileNo').value=tx[0];
	document.forms["mainform"].submit();
	return;
	
}
  	
  </script>
@endsection
