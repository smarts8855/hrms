@extends('layouts.layout')

@section('pageTitle')
Set Active Month
@endsection


@section('content')


  <div class="box-body" style="background:#FFF;">
          

         <div class="row">
            <div class="col-md-12">
                
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
                        <strong>Success!</strong> {{ session('msg') }}</div>                        
                        @endif
                        
                        @if(session('err'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('err') }}</div>                        
                        @endif
                        
                        
                
                
                
</br>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Current Active Month And Year</h3>
  </div>
  <div class="panel-body"  style="padding:30px 10px">
 <table class="table table-bordered">
              <thead>
                    <tr>
                        <th>Active Month</th>
                        <th>Year</th>
                        <th>Next Action</th>
                        <th>View Minutes</th>
                        <th></th>
                        
                    </tr>
              <thead>
              <tbody>
            
              <tr>
             <td>{{$activemonth->month}} </td>
             <td>{{$activemonth->year}}  </td>
             <td>
                
                    @if($stage->vstage == $vstage)
                     <input type="button" name="submit" id="process" value="Process" class="btn btn-success process">
                     @else
                     SALARY LOCATION: <strong> {{$section}}</strong>
                     @endif
                     @if(($loggedStaff == 'AU' || $loggedStaff == 'CK') && $stage->vstage == $vstage)
                      <input type="button" name="submit" id="reject" value="Reject" class="btn btn-success reject">
                     @endif
                 
             </td>
             <td>
                 @if($view == 1)
                 <a href='{{url("/display/minutes/$activemonth->year/$activemonth->month")}}' target="_blank" class="btn btn-success btn-sm">View Minutes</a>
                 @endif
                 </td>
             @if($loggedStaff == 'SAL')
             
             <td>
                 <a href="javascript:void()" class="sal">Push to variation control</a>
            </td>
             @elseif($loggedStaff == 'VC')
                <td>
                 <a href="javascript:void()" class="sal">Push to Salary</a>
                </td>
             @else
             <td></td>
             @endif
             </tr>
         
              </tbody>
        </table>
       
  
  </div>
</div>
                    </div>
                    
</div>
          <!-- /.row -->
        </div>

  
  <!-- Modal Dialog for UPDATE RECORD-->
   <form method="post" action="{{ url('/approval-process') }}">
       {{ csrf_field() }}
      	<div class="comModal modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
      		<div class="modal-dialog">
      			<div class="modal-content">
      				<div class="modal-header">
      					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      					<h4 class="modal-title">Payroll Clearing Minutes</h4>
      				</div>
      				
      				<div class="modal-body">
      					<p>
      					<div class="form-group" style="margin-bottom:30px;">
					    <label class="control-label col-sm-2" for="grade">Minute</label>
					    <div class="col-sm-10">
					    	<textarea name="minute" class="form-control"></textarea>
					    	<input type="hidden" name="activeMonth" value="{{$activemonth->month}}">
					    	<input type="hidden" name="activeYear" value="{{$activemonth->year}}">
					    </div>
					</div>
					<br/>
					
					<div class="form-group" style="margin-bottom:20px;margin-top:20px;">
					  <label class="control-label col-sm-2" for="grade">Salary to Process: </label>
					<div class="col-sm-10">
					<select name="salaryType" class="form-control">
                     <option value="">Process All</option>
                      @if($ifPushToVCStaff == 0)
                      <option value="staff">Staff Salary</option>
                      @endif
                      
                      @if($ifPushToVCCouncil == 0)
                      <option value="council">Council Members Salary</option>
                      @endif
                    </select>
                    </div>
					</div>
					<div class="clearfix"></div>
					
					<br/>
					 @if($loggedStaff == 'AU')
					 <input type="hidden" name="pushTo" value="DR">
					 @else
					<div class="form-group">
					    <label class="control-label col-sm-2" for="grade">Refer To: </label>
					<div class="col-sm-10">
					<select name="pushTo" class="form-control">
                     <option value="">Select One</option>
                     <option value="DR">Director Finance</option>
                     <option value="CA">Chief Accountant</option>
                     <option value="CK">Checking</option>
                     <option value="AU">Audit</option>
                     @if($loggedStaff == 'CA' || $loggedStaff == 'DR')
                     <option value="ES">Executive Secretary</option>
                     <option value="10">Payment Approval</option>
                     @endif
                    </select>
                    </div>
					</div>
					@endif
					
      				</div>
      				<div class="clearfix"></div>
      				<div class="modal-footer">
      					<input type="submit" name="button" class="btn btn-info" value="Submit" >
      				</div>
      			</div>
      		</div>
      	</div>
      </form>
      	<!-- //Modal Dialog -->
      	
      	
      	<!-- Modal Dialog for Variation control Push-->
   <form method="post" action="{{ url('/process-to-variation') }}">
       {{ csrf_field() }}
      	<div class="salModal modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
      		<div class="modal-dialog">
      			<div class="modal-content">
      				<div class="modal-header">
      					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      					<h4 class="modal-title">Payroll Clearing Minutes</h4>
      				</div>
      				
      				<div class="modal-body">
      					<p>
      				<div class="form-group" style="margin-bottom:30px !important;">
					    <label class="control-label col-sm-2" for="grade">Minute</label>
					    <div class="col-sm-10">
					    	<textarea name="minute" class="form-control"></textarea>
					    	<input type="hidden" name="activeMonth" value="{{$activemonth->month}}">
					    	<input type="hidden" name="activeYear" value="{{$activemonth->year}}">
					    </div>
					</div>
					
					<br/>
					
					<div class="form-group" style="margin-bottom:20px;margin-top:20px;">
					  <label class="control-label col-sm-2" for="grade">Salary to Process: </label>
					<div class="col-sm-10">
					<select name="salaryType" class="form-control">
                     <option value="">Process All</option>
                      @if($ifPushToVCStaff == 0)
                      <option value="staff">Staff Salary</option>
                      @endif
                      
                      @if($ifPushToVCCouncil == 0)
                      <option value="council">Council Members Salary</option>
                      @endif
                    </select>
                    </div>
					</div>
					
					<br/>
					<div class="clearfix"></div>
					<div class="form-group" style="margin-bottom:20px;">
					  <label class="control-label col-sm-2" for="grade">Refer To: </label>
					<div class="col-sm-10">
					<select name="pushTo" class="form-control">
                     <option value="">Select One</option>
                     @if($loggedStaff == 'SAL')
                     <option value="VC">Variation Control</option>
                     @elseif($loggedStaff == 'VC')
                      <option value="SAL">Salary</option>
                     @endif
                    </select>
                    </div>
					</div>
					
      				</div>
      				<div class="clearfix"></div>
      				<div class="modal-footer">
      					<input type="submit" name="button" class="btn btn-info" value="Submit" >
      				</div>
      			</div>
      		</div>
      	</div>
      </form>
      	<!-- //Modal Dialog -->
      	
      	<!-- Modal Dialog for Reject-->
   <form method="post" action="{{ url('/rejection') }}">
       {{ csrf_field() }}
      	<div class="rejectModal modal fade" id="confirmUpdate" role="dialog" aria-hidden="true">
      		<div class="modal-dialog">
      			<div class="modal-content">
      				<div class="modal-header">
      					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      					<h4 class="modal-title">Payroll Clearing Minutes</h4>
      				</div>
      				
      				<div class="modal-body">
      					<p>
      					<div class="form-group" style="margin-bottom:30px;">
					    <label class="control-label col-sm-2" for="grade">Minute</label>
					    <div class="col-sm-10">
					    	<textarea name="minute" class="form-control"></textarea>
					    	<input type="hidden" name="activeMonth" value="{{$activemonth->month}}">
					    	<input type="hidden" name="activeYear" value="{{$activemonth->year}}">
					    </div>
					</div>
					<br/>
					<!--<div class="form-group" style="margin-bottom:20px;margin-top:20px;">
					  <label class="control-label col-sm-2" for="grade">Salary to Reject: </label>
					<div class="col-sm-10">
					<select name="salaryType" class="form-control">
                     <option value="">Process All</option>
                      @if($ifPushToVCStaff == 0)
                      <option value="staff">Staff Salary</option>
                      @endif
                      
                      @if($ifPushToVCCouncil == 0)
                      <option value="council">Council Members Salary</option>
                      @endif
                    </select>
                    </div>
					</div>-->
					<br/>
					 
					 <input type="hidden" name="pushTo" value="SAL">
					
      				</div>
      				<div class="clearfix"></div>
      				<div class="modal-footer">
      					<input type="submit" name="button" class="btn btn-info" value="Submit" >
      				</div>
      			</div>
      		</div>
      	</div>
      </form>
      	<!-- //Modal Dialog -->
      	
      		
 
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
 $(document).ready(function(){
  
    $("table tr td .process").click(function()
    {

        $(".comModal").modal('show');
        
    });
        
    $("table tr td .sal").click(function()
    {
        $(".salModal").modal('show');
    });
    
    $("table tr td .reject").click(function()
    {
        $(".rejectModal").modal('show');
    });
        
 });
</script>

@endsection
