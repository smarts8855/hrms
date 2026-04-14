@extends('layouts.layout')
@section('pageTitle')
Salary Setup
  
@endsection



@section('content')



<div class="box box-default">
<div id="editModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Particular</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="editpartModal" name="editpartModal"
                    role="form" method="POST" action="{{url('/control-variable/update')}}">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-2 control-label">Description</label>
                    </div>
                    <div class="col-sm-9">
                    <textarea rows="4" cols="50" id="descriptions" name="descriptions"></textarea>
                    </div>
                    <div class="col-sm-3">
                    <select class="form-control" id="partStatus" name="partStatus">  
                        <option value='0'>Inactive</option>
                        <option value='1'>Active</option>     
                    </select>
                    </div>
                    <input type="hidden" id="partid" name="partid" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
    
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
       
          @include('Share.message')
        
        <form class="form-horizontal" role="form" method="post"  id="mainform" name="mainform">
        {{ csrf_field() }}

          <!-- /.row -->
          
          <div class="form-group">
          @if ($CourtInfo->courtstatus==1)
		<div class="col-md-4">
			<label>Select Court</label>
	                <select name="court" id="court" class="form-control" onchange="Reload();">
	                  <option value="">Select Court</option>
	                  @foreach($CourtList as $b)                  
	                  <option value="{{$b->id}}" {{ ($court) == $b->id? "selected":"" }}>{{$b->court_name}}</option>               
	                  @endforeach
	                </select>
		</div>
	@else
	<input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
	 @endif 
		<div class="col-md-4">
			<label class="control-label">Employment Type</label>
			<select name="employeetype" id="employeetype" class="form-control" onchange="Reload();">
	                 <option value="">-Select Employmet Type-</option>
	                  @foreach($EmploymentTypeList as $b)                  
	                  <option value="{{$b->id}}" {{ ($employeetype) == $b->id? "selected":"" }}>{{$b->employmentType}}</option>             
	                  @endforeach
	                </select>
		</div>
		<div class="col-md-2">
			<label class="control-label">Grade</label>
			<select name="grade" id="grade" class="form-control" required onchange="Reload();">
			<option value="" selected>Select</option>
	                	@for ($i = 1; $i < 17; $i++)
	                	<option value="{{ $i }}" {{ ($grade) == $i ? "selected":"" }}>{{$i}}</option>
	                	@endfor
		           </select>
			
		</div>
		<div class="col-md-2">
			<label class="control-label">Step</label>
			<select name="step" id="step" class="form-control" required onchange="Reload();">
			<option value="" selected>Select</option>
	                	@for ($i = 1; $i < 15; $i++)
	                	<option value="{{ $i }}" {{ ($step) == $i ? "selected":"" }}>{{$i}}</option>
	                	@endfor
		           </select>
			
		</div>
        </div>
        <div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Basic</label>
				<input type="text" class="form-control" id="basic" name="basic" placeholder="" onkeyup="BasicChange()" value="{{$PayStructure->amount}}">
				<input type="hidden" id="hbasic" name="hbasic" value="{{$Rate['leave']}}">
			</div>
        </div>
		
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Leave Bonus({{$Rate['leave']}}% of basic)</label>
				<input type="text" class="form-control" id="leave" name="leave" placeholder="0" disabled value="{{$PayStructure->leave_bonus}}">
				<input type="hidden" id="hleave" name="hleave" value="{{$PayStructure->leave_bonus}}">
				<input type="hidden" id="r_leave" value="{{$Rate['leave']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Peculiar({{$Rate['peculiar']}}% of basic)</label>
				<input type="text" class="form-control" id="peculiar" name="peculiar" placeholder="0" disabled value="{{$PayStructure->peculiar}}">
				<input type="hidden" id="hpeculiar" name="hpeculiar" value="{{$PayStructure->peculiar}}">
				<input type="hidden"  id="r_peculiar" value="{{$Rate['peculiar']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Housing({{$Rate['housing']}}% of basic)</label>
				<input type="text" class="form-control" id="housing" name="housing" placeholder="0" disabled value="{{$PayStructure->housing}}">
				<input type="hidden" id="hhousing" name="hhousing" value=value="{{$PayStructure->housing}}">
				<input type="hidden" id="r_housing"  value="{{$Rate['housing']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Transport({{$Rate['transportation']}}% of basic)</label>
				<input type="text" class="form-control" id="transportation" name="transportation" placeholder="0" disabled value="{{$PayStructure->transport}}">
				<input type="hidden" id="htransportation" name="htransportation" value="{{$PayStructure->transport}}">
				<input type="hidden" id="r_transportation" value="{{$Rate['transportation']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Utility({{$Rate['utility']}}% of basic)</label>
				<input type="text" class="form-control" id="utility" name="utility" placeholder="0" disabled value="{{$PayStructure->utility}}">
				<input type="hidden" id="hutility" name="hutility" value="{{$PayStructure->utility}}">
				<input type="hidden" id="r_utility"  value="{{$Rate['utility']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Furniture({{$Rate['furniture']}}% of basic)</label>
				<input type="text" class="form-control" id="furniture" name="furniture" placeholder="0" disabled value="{{$PayStructure->furniture}}">
				<input type="hidden" id="hfurniture" name="hfurniture" value="{{$PayStructure->furniture}}">
				<input type="hidden" id="r_furniture"  value="{{$Rate['furniture']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Meal({{$Rate['meal']}}% of basic)</label>
				<input type="text" class="form-control" id="meal" name="meal" placeholder="0" disabled value="{{$PayStructure->meal}}">
				<input type="hidden" id="hmeal" name="hmeal" value="{{$PayStructure->meal}}">
				<input type="hidden" id="r_meal" value="{{$Rate['meal']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Driver({{$Rate['leave']}}% of basic)</label>
				<input type="text" class="form-control" id="driver" name="driver" placeholder="0" disabled value="{{$PayStructure->driver}}">
				<input type="hidden" id="hdriver" name="hdriver" value="{{$PayStructure->driver}}">
				<input type="hidden" id="r_driver" value="{{$Rate['leave']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Servant({{$Rate['servant']}}% of basic)</label>
				<input type="text" class="form-control" id="servant" name="servant" placeholder="0" disabled value="{{$PayStructure->servant}}">
				<input type="hidden" id="hservant" name="hservant" value="{{$PayStructure->servant}}">
				<input type="hidden" id="r_servant"  value="{{$Rate['servant']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Tax({{$Rate['tax']}}% of basic)</label>
				<input type="text" class="form-control" id="tax" name="tax" placeholder="0" disabled value="{{$PayStructure->tax}}">
				<input type="hidden" id="htax" name="htax" value="{{$PayStructure->tax}}">
				<input type="hidden" id="r_tax"  value="{{$Rate['tax']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Pension({{$Rate['pension']}}% of basic)</label>
				<input type="text" class="form-control" id="pension" name="pension" placeholder="0" disabled value="{{$PayStructure->pension}}">
				<input type="hidden" id="hpension" name="hpension" value="{{$PayStructure->pension}}">
				<input type="hidden" id="r_pension" value="{{$Rate['pension']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">NHF({{$Rate['nhf']}}% of basic)</label>
				<input type="text" class="form-control" id="nhf" name="nhf" placeholder="0" disabled value="{{$PayStructure->nhf}}">
				<input type="hidden" id="hnhf" name="hnhf" value="{{$PayStructure->nhf}}">
				<input type="hidden" id="r_nhf"  value="{{$Rate['nhf']}}">
			</div>
        </div>
		<div class="form-group">
			<div class="col-md-4">
				<label class="control-label">Union Due({{$Rate['union']}}% of basic)</label>
				<input type="text" class="form-control" id="union" name="union" placeholder="0" disabled value="{{$PayStructure->unionDues}}">
				<input type="hidden" id="hunion" name="hunion" value="{{$PayStructure->unionDues}}">
				<input type="hidden" id="r_union" value="{{$Rate['union']}}">
			</div>
        </div>
	<div class="form-group">
	<div class="col-md-4">
		<input class="btn btn-success" name="Save" type="submit" value="Save"/>
	</div>
        </div>
        
         <hr />
        

        </form>

            
          
          
        </div>
       
  </div>
</div>
</div>


@endsection

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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script>
    
 function  TextBoxState()
{	
var p=document.getElementById("particulars").value;

  if(p=="2"){
    document.getElementById('accounthead').setAttribute('disabled', 'disabled');
	document.getElementById('allocationtype').setAttribute('disabled', 'disabled');
	document.getElementById('economiccode').setAttribute('disabled', 'disabled');
  }
  if(p=="1"){
    document.getElementById('accounthead').removeAttribute('disabled'); 
	document.getElementById('allocationtype').removeAttribute('disabled'); 
	document.getElementById('economiccode').removeAttribute('disabled'); 
  }
return;
}

function  BasicChange()
{	
var b=document.getElementById("basic").value;

  document.getElementById("leave").value=(document.getElementById("r_leave").value)*b*0.01;
  document.getElementById("peculiar").value=(document.getElementById("r_peculiar").value)*b*0.01;
  document.getElementById("housing").value=(document.getElementById("r_housing").value)*b*0.01;
  document.getElementById("transportation").value=(document.getElementById("r_transportation").value)*b*0.01;
  document.getElementById("utility").value=(document.getElementById("r_utility").value)*b*0.01;
  document.getElementById("furniture").value=(document.getElementById("r_furniture").value)*b*0.01;
  document.getElementById("meal").value=(document.getElementById("r_meal").value)*b*0.01;
  document.getElementById("driver").value=(document.getElementById("r_driver").value)*b*0.01;
  document.getElementById("servant").value=(document.getElementById("r_servant").value)*b*0.01;
  document.getElementById("tax").value=(document.getElementById("r_tax").value)*b*0.01;
  document.getElementById("pension").value=(document.getElementById("r_pension").value)*b*0.01;
  document.getElementById("nhf").value=(document.getElementById("r_nhf").value)*b*0.001;
  document.getElementById("union").value=(document.getElementById("r_union").value)*b*0.01;
  
  document.getElementById("hleave").value=(document.getElementById("r_leave").value)*b*0.01;
  document.getElementById("hpeculiar").value=(document.getElementById("r_peculiar").value)*b*0.01;
  document.getElementById("hhousing").value=(document.getElementById("r_housing").value)*b*0.01;
  document.getElementById("htransportation").value=(document.getElementById("r_transportation").value)*b*0.01;
  document.getElementById("hutility").value=(document.getElementById("r_utility").value)*b*0.01;
  document.getElementById("hfurniture").value=(document.getElementById("r_furniture").value)*b*0.01;
  document.getElementById("hmeal").value=(document.getElementById("r_meal").value)*b*0.01;
  document.getElementById("hdriver").value=(document.getElementById("r_driver").value)*b*0.01;
  document.getElementById("hservant").value=(document.getElementById("r_servant").value)*b*0.01;
  document.getElementById("htax").value=(document.getElementById("r_tax").value)*b*0.01;
  document.getElementById("hpension").value=(document.getElementById("r_pension").value)*b*0.01;
  document.getElementById("hnhf").value=(document.getElementById("r_nhf").value)*b*0.001;
  document.getElementById("hunion").value=(document.getElementById("r_union").value)*b*0.01;
  
return;
}  
function  Reload()
{	
document.forms["mainform"].submit();

return;
}    
</script>
@stop

