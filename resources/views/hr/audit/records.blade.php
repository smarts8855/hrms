@extends('layouts.layout')
@section('pageTitle')
 Staff Designation
@endsection

@section('content')
<div id="page-wrapper" class="box box-default">
  <div class="container-fluid">
    
    <hr >
    <div class="row">
      <div class="col-md-9"> <br>
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach </div>
        @endif                       
        
        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Successful!</strong> {{ session('message') }}</div>
        @endif
        @if(session('error_message'))
        <div class="alert alert-error alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
          <strong>Error!</strong> {{ session('error_message') }}</div>
        @endif
        
        <!-- council Members Salary -->
        @if(!empty($councilAssigned) )
        <h2 class="text-center">Council Members Salary For Auditing</h2>
  <div class="row">
     
    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
        
            <table class="table table-bordered">
              <thead>
                    <tr>
                        <th>Active Month</th>
                        <th>Year</th>
                        <th>Reports</th>
                        <th>Action</th>
                        
                    </tr>
              <thead>
              <tbody>
            
            @foreach($councilAssigned as $list)
              <tr>
             <td>{{$list->month}} </td>
             <td>{{$list->year}}  </td>
              <td>
                  
                  <span class="btn btn-success text-white"><a href="javascript: CouncilLoadPayroll($list->year,$list->month)" style="color:#FFF !important;">Council Payroll</a></span>
                  
                  <span class="btn btn-success text-white"><a href="javascript: CouncilLoadAnalysis($list->year,$list->month)" style="color:#FFF !important;">Council Analysis</a></span>
                  <span class="btn btn-success text-white"><a href="javascript: CouncilLoadBankSchedule($list->year,$list->month)" style="color:#FFF !important;">Bank Schedule</a></span>
                  
                
             </td>
             <td><span class="btn btn-success text-white confirm" month="{{$list->month}}" year="{{$list->year}}"><a href="javascript:void()" style="color:#FFF !important;"> Confirm Completion</a></span></td>
             
             @endforeach
             </tr>
              </tbody>
        </table>
       <hr />
       
      
      <div class="hidden-print"></div>
    </div>
    
    
  </div>
      @endif  
        <!-- End council Members Salary -->
       
      </div>
    </div>
  </div>
</div>
<div id="page-wrapper" class="box box-default">
<div class="box-body">
  <h2 class="text-center">Staff Salary For Auditing</h2>
  <div class="row">
     
    <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
        
                <table class="table table-bordered">
              <thead>
                    <tr>
                        <th>Active Month</th>
                        <th>Year</th>
                        <th>Reports</th>
                        <th>Action</th>
                        
                    </tr>
              <thead>
              <tbody>
            
            @foreach($assigned as $list)
              <tr>
             <td>{{$list->month}} </td>
             <td>{{$list->year}}  </td>
              <td>
                  
                  <span class="btn btn-success text-white"><a href="javascript: LoadReview($list->year,$list->month)" style="color:#FFF !important;">Payroll</a></span>
                  
                  
                  
                  <span class="btn btn-success text-white"><a href="javascript: LoadSummary($list->year,$list->month)"  style="color:#FFF !important;">Payroll Summary</a></span>
                  <span class="btn btn-success text-white"><a href="javascript: LoadAnalysis($list->year,$list->month)" style="color:#FFF !important;">Analysis</a></span>
                  <span class="btn btn-success text-white"><a href="javascript: LoadBankSchedule($list->year,$list->month)" style="color:#FFF !important;">Bank Schedule</a></span>
                  
                  <span class="btn btn-success text-white deducts"><a href="javascript: LoadReview2($list->year,$list->month)" style="color:#FFF !important;"> Deductions</a></span>
                
             </td>
             <td><span class="btn btn-success text-white confirm" month="{{$list->month}}" year="{{$list->year}}"><a href="javascript:void()" style="color:#FFF !important;"> Confirm Completion</a></span></td>
             
             @endforeach
             </tr>
              </tbody>
        </table>
       <hr />
       
      
      <div class="hidden-print"></div>
    </div>
    
    
  </div>
  <!-- /.col --> 
  
</div>


<!-- modal bootstrap -->
<form  method="post" action="{{url('/treasury209-view')}}" target="_blank">
{{ csrf_field() }} 
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Update Module</h4>
            </div>
            <div class="modal-body">
           
                    <div class="row" style="margin-bottom: 10px;">
                     	<div class="col-md-12">
							<div class="form-group">
								<label for="reporttype">Report Type</label>
								<select name="reporttype" id="reporttype" required="true" class="form-control" onchange="check(this.value)">
									<option>Select</option>
									@foreach($reporttype as $type)
									<option value="{{$type->determinant}}" @if (old('reporttype') == $type->determinant) {{ 'selected' }} @endif>{{$type->addressName}}</option>
									
									@endforeach
									<option value="18" @if (old('reporttype') == 18) {{ 'selected' }} @endif>Salary Advance</option>
									<option value="15" @if (old('reporttype') == 15) {{ 'selected' }} @endif>Cooperative Saving</option>
									<option value="16" @if (old('reporttype') == 16) {{ 'selected' }} @endif>Cooperative Loan Repayment</option>
									<option value="2" @if (old('reporttype') == 2) {{ 'selected' }} @endif>Housing Loan Refunds</option>
									<option value="coop" @if (old('reporttype') == 2) {{ 'selected' }} @endif>Cooperative</option>

									@foreach($cvSetup as $type)
									<!--<option value="{{$type->ID}}" @if (old('reporttype') == $type->ID) {{ 'selected' }} @endif>{{$type->description}}</option>-->
									@endforeach
								</select>   
							</div>
						</div>
                    </div>
                      
                    <div class="row">
                     <div class="col-md-12">
							<div class="form-group">
								<label for="bank">Select Current Residential State</label>
								<select name="currentState" class="form-control">
									<option selected></option>
									@foreach($currentstate as $list)
										<option @if (old('currentState') == $list->id) {{ 'selected' }} @endif value="{{$list->id}}">{{$list->state}}</option>
									@endforeach
								</select>
							</div>
						</div>
                    </div>    


            <div class="modal-footer">
                <input type="hidden" id="d-year" name="year" >   
                <input type="hidden" id="d-month" name="month" >
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>

<!--// modal Bootstrap -->
</form>

<!-- confirm modal bootstrap -->
<form  method="post" action="{{url('/audit/confirmation')}}">
{{ csrf_field() }} 
<div id="confirmModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
           
                   <h3>Have you actualy completed salary Auditing</h3>

                <input type="hidden" id="c-year" name="year" >   
                <input type="hidden" id="c-month" name="month" >
                
                <div class="row">
                     <div class="col-md-12">
							<div class="form-group">
								<label for="bank">Comment</label>
								<textarea name="comment" class="form-control"></textarea>
							</div>
						</div>
                    </div>
            <div class="modal-footer">
                
                
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                <button type="submit" id="button" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>
</div>

<!--// Confirm modal Bootstrap -->
</form>


<form method="post" id="payrollform" name="payrollform"  action="{{url('/main-payroll/report')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="p-year" name="year" >   
                <input type="hidden" id="p-month" name="month" >   
                   

</form>

<form method="post" id="summaryform" name="summaryform"  action="{{url('/payroll-summary')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="s-year" name="year" >   
                <input type="hidden" id="s-month" name="month" >   
                   

</form>
<form method="post" id="analysisform" name="analysisform"  action="{{url('/payroll-analysis')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="a-year" name="year" >   
                <input type="hidden" id="a-month" name="month" >   
                   

</form>
<form method="post" id="bankscheduleform" name="bankscheduleform"  action="{{url('/bankshedule/view')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="b-year" name="year" >   
                <input type="hidden" id="b-month" name="month" >   
                   

</form>

<!-- council Members -->

<form method="post" id="cmpform" name="cmpform"  action="{{url('/council-members/payroll')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="cmp-year" name="year" >   
                <input type="hidden" id="cmp-month" name="month" >   
                   

</form>
<form method="post" id="cmbform" name="cmbform"  action="{{url('/council-member/bank-schedule')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="cmb-year" name="year" >   
                <input type="hidden" id="cmb-month" name="month" >   
                   

</form>

<form method="post" id="cmaform" name="cmaform"  action="{{url('council-members/analysis')}}" target="_blank">

                {{ csrf_field() }}

                <input type="hidden" id="cma-year" name="year" >   
                <input type="hidden" id="cma-month" name="month" >   
                   

</form>


<!-- // Council Members -->
@endsection 

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<style type "text/css">
<!--
/* @group Blink */
.blink {
	-webkit-animation: blink .75s linear infinite;
	-moz-animation: blink .75s linear infinite;
	-ms-animation: blink .75s linear infinite;
	-o-animation: blink .75s linear infinite;
	 animation: blink .75s linear infinite;
	 color:red;
}
@-webkit-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-moz-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-ms-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@-o-keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
@keyframes blink {
	0% { opacity: 1; }
	50% { opacity: 1; }
	50.01% { opacity: 0; }
	100% { opacity: 0; }
}
/* @end */
-->
</style>
@stop

@section('scripts')

<script>
    $(document).ready(function(){
  
    $(".deducts").click(function(){
        $("#myModal").modal('show');
    });
});
</script>

<script>
function  LoadReview(year,month)

{

                document.getElementById('p-year').value = year; 
                document.getElementById('p-month').value = month;

                document.forms["payrollform"].submit();

                return;

}
function  LoadReview2(year,month)

{

                document.getElementById('d-year').value = year; 
                document.getElementById('d-month').value = month;
                 $("#myModal").modal('show');

                return;

}
function  LoadSummary(year,month)

{

                document.getElementById('s-year').value = year; 
                document.getElementById('s-month').value = month;
                document.forms["summaryform"].submit();

                return;

}

function  LoadAnalysis(year,month)

{

                document.getElementById('a-year').value = year; 
                document.getElementById('a-month').value = month;
                document.forms["analysisform"].submit();

                return;

}

function  LoadBankSchedule(year,month)

{

                document.getElementById('b-year').value = year; 
                document.getElementById('b-month').value = month;
                document.forms["bankscheduleform"].submit();

                return;

}
</script>

<script>
    $(document).ready(function(){
  
    $(".confirm").click(function(){
        var year = $(this).attr('year');
        var month = $(this).attr('month');
        $('#c-year').val(year);
        $('#c-month').val(month);
        $("#confirmModal").modal('show');
    });
});
</script>

<script>
    function  CouncilLoadBankSchedule(year,month)

{

                document.getElementById('cmb-year').value = year; 
                document.getElementById('cmb-month').value = month;
                document.forms["cmbform"].submit();

                return;

}
function  CouncilLoadPayroll(year,month)

{

                document.getElementById('cmp-year').value = year; 
                document.getElementById('cmp-month').value = month;
                document.forms["cmpform"].submit();

                return;

}
function  CouncilLoadAnalysis(year,month)

{

                document.getElementById('cma-year').value = year; 
                document.getElementById('cma-month').value = month;
                document.forms["cmaform"].submit();

                return;

}
</script>

@stop