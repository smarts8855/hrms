@extends('layouts.layout')
@section('pageTitle')
Staff Transfer
@endsection

@section('content')


<div id="editModal" class="modal fade">
 <div class="modal-dialog box box-default" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Step </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    	<form method="post" action="" >
		{{ csrf_field() }}
		    <div class="modal-body">  
		        <div class="form-group" style="margin: 0 10px;">
		           
		          
		          <input type="hidden" id="fileNo" name="staffNameEdit" value="">
		          <input type="hidden" id="courty" name="courty" value="">
		          <input type="hidden" id="divisiony" name="divisiony" value="">
		          
		           
		        </div>
				<div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-2 control-label">Step</label>
		            
		           <select name="newStep" id="step" class="form-control" required>
					<option value=''> - Select Step</option>
					
					<option value="1" >1</option>
					<option value="1" >2</option>
					<option value="1" >3</option>
					<option value="1" >4</option>
					<option value="1" >5</option>
					<option value="1" >6</option>
					<option value="1" >7</option>
					<option value="1" >8</option>
					<option value="1" >9</option>
					<option value="1" >10</option>
					<option value="1" >11</option>
					<option value="1" >12</option>
					<option value="1" >13</option>
					<option value="1" >14</option>
					<option value="1" >15</option>
				  </select>
				 
		           
		        </div>
				
				<div class="form-group" style="margin: 0 10px;">
		            <label class="col-sm-4 control-label">Due Date</label>
					<input type="date" name="dueDate" id="date" class="form-control stylecontrol" value="">
		        </div>
		        <div class="modal-footer">
		            <button type="submit" name="edit" class="btn btn-success">Save changes</button>
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        </div>

		       
		    </div>
		</form>
      
  </div>
</div>
</div>


 <div id="insertModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
			<div class="modal-content">
				<div class="modal-header">
					  <h4 class="modal-title">Approve Increment</h4>
					  
				</div>
		   		<form method="post" action="" >
				{{ csrf_field() }}
				<div class="modal-body">  
					<div class="form-group" style="margin: 0 10px;">
						
						<h4>Are you sure you want to approve this item?</h4>
						<input type="hidden" id="courtn" name="courtn" value="">
				        <input type="hidden" id="divisionn" name="divisionn" value="">
				        <input type="hidden" id="staffNamey" name="staffNamey" value="">
					  
					   
					</div>
					<div class="modal-footer">
						<button type="submit" name="newinsert" class="btn btn-success">Save changes</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				 
					
				</div>
			</form>
	      
	          </div>
	    </div>
	</div>


<div class="box box-default">
        <div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
        @if ($warning<>'')
	<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$warning}}</strong> 
	</div>
	@endif
	@if ($success<>'')
	<div class="alert alert-dismissible alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>{{$success}}</strong> 
	</div>
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
			 	 <div class="col-md-12"><!--2nd col-->
			 
	            		<div class="col-md-4">
	            		<label for="staffName">Court</label>
						  <select name="court" id="staf" class="form-control court" onchange="ReloadForm()" required>
							<option value=''>-Select court-</option>
							@foreach ($CourtList as $b)
							<option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>
							@endforeach 
						  </select>
	            		</div>
	            		
	            		<div class="col-md-4" >
							
							  <label for="staffName">Division</label>
							  <select name="division" id="division" class="form-control" onchange="ReloadForm()" required>
								<option value=''>-Select division-</option>
								@foreach ($DivisionList as $b)
								<option value="{{$b->divisionID}}" {{ ($division) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>
								@endforeach 
							  </select>
							
						</div>
						
						<div class="col-md-4" >
						
							  <label for="staffName">Select Staff Name</label>
							  <select name="staffName" id="staffName" class="form-control" onchange="ReloadForm()" required>
								<option value=''>-Select staff-</option>
								<option value=''>All</option>
								@foreach ($staffList as $b)
								<option value="{{$b->fileNo}}" {{ ($staffName) == $b->fileNo? "selected":"" }}>{{$b->fileNo}}:{{$b->surname}} {{$b->first_name}} {{$b->othernames}}</option>
								@endforeach 
							  </select>
						
						</div>
						
	            	</div>	
			</div>
		

			<div class="row">
				<div class="col-md-12" align="center"><h3>Staff Basic Information</h3></div>
                <div class="col-md-12"><!--2nd col-->
                <!-- /.row -->
                
                @foreach ($due as $d)
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Surname</label>
                            <input required type="text" value="{{ $d->surname }}" name="sname" readonly="readonly" class="form-control" >   
                        </div> 
                        <div class="col-md-4">          
                            <label class="control-label">Firstname</label>
                            <input required type="text" value="{{ $d->first_name }}" readonly="readonly" name="fname"  class="form-control" >
                        </div>
                        
                        <div class="col-md-4">
                            <label class="control-label">Othername</label>
                            <input require type="text" value="{{ $d->othernames }}" name="oname" readonly="readonly" class="form-control" >   
                        </div>
                        <input type="hidden" name="deptId" value="{{ $d->department }}">
                        <input type="hidden" name="eId" value="{{ $d->employee_type }}">
                       
                    </div>
                </div>
        	</div>

        	<div class="clear-fix"></div>

        	<div class="row">
                <div class="col-md-12"><!--2nd col-->
            	<!-- /.row -->
                    <div class="form-group">
                    	<div class="col-md-4">
							<div class="form-group">
							  <label for="staffName">New Division</label>
							  <select name="newDivision" id="newDivision" class="form-control" required>
								<option value=''>-Select division-</option>
								@foreach ($DivisionList as $b)
								<option value="{{$b->divisionID}}" {{ ($newDivision) == $b->divisionID? "selected":"" }}>{{$b->division}}</option>
								@endforeach 
							  </select>
							</div>
						</div>
                    	<div class="col-md-4">
			                <label>Department</label>
			                  <select name="department" id="department" class="form-control step" onchange="ReloadForm()" required>
			                  <option value="">Select Department</option>
			                  @foreach($DepartmentList as $dept)
                                <option  value="{{$dept->id}}"  {{ ($department) == $dept->id? "selected":"" }}>{{ $dept->department }}</option>
                            @endforeach
			                </select>
			              
			            </div>
			            <div class="col-md-4">
			                <label>Grade Level</label>
			                  <select name="grade" id="grade" class="form-control step" onchange="ReloadForm()" required>
			                  <option value="">Select New Grade</option>
			                  <option value="1" {{ ($grade) == "1"? "selected":"" }}>1</option>
			                  <option value="2" {{ ($grade) == "2"? "selected":"" }}>2</option>
			                  <option value="3" {{ ($grade) == "3"? "selected":"" }}>3</option>
			                  <option value="4" {{ ($grade) == "4"? "selected":"" }}>4</option>
			                  <option value="5" {{ ($grade) == "5"? "selected":"" }}>5</option>
			                  <option value="6" {{ ($grade) == "6"? "selected":"" }}>6</option>
			                  <option value="7" {{ ($grade) == "7"? "selected":"" }}>7</option>
			                  <option value="8" {{ ($grade) == "8"? "selected":"" }}>8</option>
			                  <option value="9" {{ ($grade) == "9"? "selected":"" }}>9</option>
			                  <option value="10" {{ ($grade) == "10"? "selected":"" }}>10</option>
			                  <option value="11" {{ ($grade) == "11"? "selected":"" }}>11</option>
			                  <option value="12" {{ ($grade) == "12"? "selected":"" }}>12</option>
			                  <option value="13" {{ ($grade) == "13"? "selected":"" }}>13</option>
			                  <option value="14" {{ ($grade) == "14"? "selected":"" }}>14</option>
			                  <option value="15" {{ ($grade) == "15"? "selected":"" }}>15</option>
			                  <option value="16" {{ ($grade) == "16"? "selected":"" }}>16</option>
			                  <option value="17" {{ ($grade) == "17"? "selected":"" }}>17</option>
			                </select>
			                <input type="hidden" name="fileNo" id="fileNo" class="form-control file-number" >
			            </div>
			           

                    </div>
                </div>
          		<!-- /.col -->
          		<div class="col-md-12"><!--2nd col-->
            	<!-- /.row -->
                    <div class="form-group">
                    	<div class="col-md-4">
			                <label>Step</label>
			                  <select name="newStep" id="newStep" class="form-control step" required>
			                  <option value="">Select New Step</option>
			                  <option value="1" {{ (old("grade") == "1" ? "selected":"") }}>1</option>
			                  <option value="2" {{ (old("grade") == "2" ? "selected":"") }}>2</option>
			                  <option value="3" {{ (old("grade") == "3" ? "selected":"") }}>3</option>
			                  <option value="4" {{ (old("grade") == "4" ? "selected":"") }}>4</option>
			                  <option value="5" {{ (old("grade") == "5" ? "selected":"") }}>5</option>
			                  <option value="6" {{ (old("grade") == "6" ? "selected":"") }}>6</option>
			                  <option value="7" {{ (old("grade") == "7" ? "selected":"") }}>7</option>
			                  <option value="8" {{ (old("grade") == "8" ? "selected":"") }}>8</option>
			                  <option value="9" {{ (old("grade") == "9" ? "selected":"") }}>9</option>
			                  <option value="10" {{ (old("grade") == "10" ? "selected":"") }}>10</option>
			                  <option value="11" {{ (old("grade") == "11" ? "selected":"") }}>11</option>
			                  <option value="12" {{ (old("grade") == "12" ? "selected":"") }}>12</option>
			                  <option value="13" {{ (old("grade") == "13" ? "selected":"") }}>13</option>
			                  <option value="14" {{ (old("grade") == "14" ? "selected":"") }}>14</option>
			                  <option value="15" {{ (old("grade") == "15" ? "selected":"") }}>15</option>
			                  <option value="16" {{ (old("grade") == "16" ? "selected":"") }}>16</option>
			                  <option value="17" {{ (old("grade") == "17" ? "selected":"") }}>17</option>
			                </select>
			                <input type="hidden" name="fileNo" id="fileNo" class="form-control file-number" >
			            </div>
			            <div class="col-md-4">
			                <label>Employee Type</label>
			                  <select name="employee_type" id="employee_type" class="form-control step" required>
			                  <option value="">Select Employment</option>
			                  @foreach($employee as $e)
                                <option  value="{{$e->id}}" {{ ($eID) == $e->id? "selected":"" }}>{{ $e->employmentType }}</option>
                            @endforeach
			                </select>
			                
			            </div>
                         
			            <div class="col-md-4">
                            <label class="control-label">Designation</label>
                            <input require type="text" value="{{$DesignationList}}" name="designation" readonly="readonly" class="form-control" required>   
                        </div>
			           

			             </div>
                </div>
          		<!-- /.col -->
          		<div class="col-md-12"><!--2nd col-->
            	<!-- /.row -->
                    <div class="form-group">

			            <div class="col-md-4">
			                <label>Effective Date</label>
			                <input type="date" name="effectiveDate" id="effectiveDate" class="form-control effectiveDate" required>

			            </div>

                      @endforeach
                        <div class="col-md-4">
                            <br>
                            <button type="submit" class="btn btn-success" name="add" >
                                <i class="fa fa-btn fa-floppy-o"></i> Add
                            </button>
                        </div>

                         </div>
                </div>
          		<!-- /.col -->
 
            </div>
		</form>

			
	<div class="box-footer with-border hidden-print">
          
        </div>
		
		
		</div>
	
</div>



@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<style type="text/css">
    .modal-dialog {
width:10cm
}

.modal-header {

background-color: #09b65f;

color:#FFF;

}


</style>

@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">

  	  function do_this(){

        var checkboxes = document.getElementsByName('checkbox[]');
        var button = document.getElementById('toggle');

        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
        }
    }

	function  ReloadForm()
	{	
	document.getElementById('thisform1').submit();
	return;
	}

	function  ReloadFor2()
	{	
	document.getElementById('form2').submit();
	return;
	}
	
	function  ReloadFormcourtdivision()
	{	
	document.getElementById('staffName').value='';
	document.getElementById('thisform1').submit();
	return;
	}
	
	
	function editfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#fileNo').val(a);
	$('#divisiony').val(b);
	$('#courty').val(c);
	$("#editModal").modal('show');
	});
	}

	function newfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#staffNamey').val(a);
	$('#courtn').val(b);
	$('#divisionn').val(b);
	$("#insertModal").modal('show');
	});
	}
	
	function delfunc(a,b,c)
	{
	$(document).ready(function(){
	$('#earningDeductionID').val(a);
	$('#depty').val(b);
	$('#courty').val(c);
	$("#delModal").modal('show');
	});
	}

	function approve(a = ''){
        if(a !== ''){
        document.getElementById('chosen').value = a;
           // alert(a);
        }
        courty = document.getElementById('courty').value;
        divisiony = document.getElementById('divisiony').value;
        fileNo = document.getElementById('fileNo').value;
        oldgrade = document.getElementById('oldgrade').value;
        oldstep = document.getElementById('oldstep').value;
        emptype = document.getElementById('emptype').value;
        duedate = document.getElementById('duedate').value;
        document.getElementById('courty').value = courty;
        document.getElementById('divisiony').value = divisiony;
        document.getElementById('fileNo').value = fileNo;
        document.getElementById('oldgrade').value = oldgrade;
        document.getElementById('oldstep').value = oldstep;
        document.getElementById('emptype').value = emptype;
        document.getElementById('duedate').value = duedate;
        document.getElementById('type').value = 1;
        document.getElementById('form2').submit();
       return false;
   	}
	
  	
  </script>
@endsection
