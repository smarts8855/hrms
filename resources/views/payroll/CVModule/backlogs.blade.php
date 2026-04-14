@extends('layouts.layout')
@section('pageTitle')
Staff Backlog Update
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
                
     <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to delete this record?</b></label>
                    </div>
                    <input type="hidden" id="deleteid" name="id" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success" name="delete">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
    <div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="editpartModal" name="editpartModal"
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                        <label class=" control-label">Names</label>
                        <input type="text"   id="names" class="form-control" readonly> 
                    </div>
                    <div class="col-sm-12">
                    <label class="control-label">Month</label>
                    <select name="nmonth" class="form-control" required id="nmonth">
							<option Value="">-Select No of Months-</option>
							<?php
								for($i =0;$i<=12;$i++)
								{echo '<option value="'.$i.'">'.$i.'</option>';}
							?>
						</select>
                    </div>
                    <div class="col-sm-6">
                    <label class="control-label">Day</label>
                    <select name="nday" class="form-control" required id="nday">
							<option Value="">-Select No of Days-</option>
							<?php
								for($i =0;$i<=31;$i++)
								{echo '<option value="'.$i.'">'.$i.'</option>';}
							?>
						</select>
                    </div>
                    <div class="col-sm-6">
                    <label class="control-label">of month count</label>
                    <select name="ndaycount" class="form-control" required id="ndaycount">
							<option Value="">-Day in considered Month-</option>
							<?php
								for($i =28;$i<=31;$i++)
								{echo '<option value="'.$i.'">'.$i.'</option>';}
							?>
						</select>
                    </div>
                    <div class="col-sm-12">
                        <label class=" control-label">Remarks</label>
                            <input type="text"  name="remarks" id="remarks" class="form-control" placeholder="e.g 11000"> 
                    </div>
                    <input type="hidden" id="hidden-id" name="id" value="">
                    
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success" name="update">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
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
@if ($CourtInfo->divisionstatus==1 && Auth::user()->is_global==1)
      <div class="col-md-6">
              <div class="form-group">
                <label>Select Court</label>
               
                <select name="division" id="division" class="form-control" style="font-size: 13px;">
                 <option value="All">All Division</option>
                  {{-- @foreach($DivisionList as $b)                  
                  <option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>             
                  @endforeach --}}

                  @foreach($courtDivisions as $divisions)
                    <option value="{{$divisions->divisionID}}" @if(old('division') == $divisions->divisionID) @endif>{{$divisions->division}}</option>
                 @endforeach
                </select>
              </div>
            </div>
@else
<div class="col-md-6">
    <div class="form-group">
        {{-- <label>Court</label> --}}
            <input type="hidden" class="form-control" id="divisionName" name="divisionName" value="{{$curDivision->division}}" readonly>
    </div>
</div>
  <input type="hidden" id="division" name="division" value="{{Auth::user()->divisionID}}">
  <!--<input type="hidden" id="division" name="division" value="{{$CourtInfo->divisionid}}">-->
@endif
</div>
       <div class="row">
			<div class="col-md-12"><!--2nd col-->
			<!-- /.row -->
				<div class="form-group">
					<div class="col-md-6">
						<input type="hidden" id="fileNo" name="fileNo" value="{{$fileNo}}"> 
						<label class="control-label">Staff Names Search</label>
						<input type="text" id="userSearch" autocomplete="off" list="enrolledUsers"  class="form-control"  onchange="StaffSearchReload()">
						<datalist id="enrolledUsers" name="staff">
					  @foreach($courtstaff as $b)			  
						<option value="{{ $b->ID}}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}({{ $b->fileNo }})"></option>
					  @endforeach
					</datalist>	
					</div>                               
				</div>
			</div>
        </div>
        <br>
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
        <br>
		<div class="row">
			<div class="col-md-12"><!--2nd col-->
			<!-- /.row -->
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label">Number of Months </label>
						<select name="nmonth" class="form-control" required>
							<option Value="">-Select No of Months-</option>
							<?php
								for($i =0;$i<=12;$i++)
								{echo '<option value="'.$i.'">'.$i.'</option>';}
							?>
						</select>  
					</div>
					<div class="col-md-2">
						<label class="control-label">Number of Days </label>
						<select name="nday" class="form-control" >
							<option Value="">-Select No of day-</option>
							<?php
								for($i =0;$i<=31;$i++)
								{echo '<option value="'.$i.'">'.$i.'</option>';}
							?>
						</select>  
					</div>
					<div class="col-md-2">
						<label class="control-label"> month Max </label>
						<select name="ndaycount" class="form-control" >
							<option Value="">-Select No of day-</option>
							<?php
								for($i =28;$i<=31;$i++)
								{echo '<option value="'.$i.'">'.$i.'</option>';}
							?>
						</select>  
					</div>
					<div class="col-md-4">
						<label class="control-label">Remarks</label>
						<input required type="text"  name="remarks" class="form-control" >   
					</div> 
					{{-- <div class="col-md-1">
		                            <br>
                            <button type="submit" class="btn btn-success" name="add" >
                                <i class="fa fa-btn fa-floppy-o"></i> Add
                            </button>
		              </div> --}}
				</div>
			</div>
        </div>
        <br>
        <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-3">
                        <button type="submit" class="btn btn-success" name="add" >
                            <i class="fa fa-btn fa-floppy-o"></i> Add
                        </button>
                    </div>
                </div>
        </div>
        </div>
        <br>
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
                            <th >No of Months</th>
                            <th >No of Days</th>
                            <th >Month day count</th>
                            <th >Process Period</th>
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
                            <td>{{$list->mcount}}</td>
                            <td>{{$list->dcount>0? $list->dcount:'NA'}}</td>
                            <td>{{$list->dcount>0? $list->of_particular_month:'NA'}}</td>
							<td>@if($list->month=='') Pending @else {{$list->month}} {{$list->year}}  @endif</td>
							<td>{{$list->remarks}}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" style="cursor: pointer;" 
                                onclick="editfunc('{{$list->id }}','{{$list->NAMES}}', '{{$list->dcount}}', '{{$list->mcount}}', '{{$list->remarks}}', '{{$list->of_particular_month}}')">Edit</button>
                                <button class="btn btn-sm btn-warning" style="cursor: pointer;" 
                                onclick="deletefunc('{{ $list->id }}')">Delete</button>
                            </td>
                                                             
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
 function editfunc(id,names,nd,nm,rm,mmax)
    {
        document.getElementById('hidden-id').value = id;
        document.getElementById('remarks').value = rm;
        document.getElementById('nday').value = nd;
        document.getElementById('nmonth').value = nm;
        document.getElementById('ndaycount').value = mmax;
        document.getElementById('names').value = names;
        $("#editModal").modal('show')
    }
    function deletefunc(id)
    {
        
        document.getElementById('deleteid').value = id;
        $("#DeleteModal").modal('show');
    }
  	
  </script>


{{-- ///////////////////////////////////// --}}

<script type="text/javascript">
    $(document).ready(function() {
    // alert('danger')

        $('select[name="division"]').on('change', function () {
            var division_id = $(this).val();
            // alert(division_id)
            
            if (division_id) {
                $.ajax({
                    url: "{{ url('/division/staff/ajax') }}/"+division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                    //    console.log(1111111111, data);
                        var d = $('datalist[name="staff"]').html('');
                        $.each(data, function(key, value){
                            $('datalist[name="staff"]').append(`<option value=${value.ID}> 
                                ${value.surname}  ${value.first_name}  ${value.othernames}  </option>`);
                        });
                    }
                });
            }else{
                alert('danger')
            }

        }); // end sub category

    });
</script>
{{-- ///////////////////////////////////// --}}
@endsection
