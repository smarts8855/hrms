@extends('layouts.layout')
@section('pageTitle')
	{{strtoupper('ALL Staff Pension Records')}}
@endsection

@section('content')
<div class="box box-body" style="background: white; padding: 5px 20px 0 0;">
  <div class="col-md-12 hidden-print">
       <h5><b>@yield('pageTitle') <span id='processing'></span></b></h5>
       <hr />
  </div>

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
                <p>{{ session('msg') }}</p> 
          </div>                        
        @endif
        @if(session('err'))
          <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <strong>Not Allowed ! </strong>
              <p>{{ session('err') }}</p>
            </div>                        
        @endif
      </div>
  
  
	<div>
    <div align="center" class="text-success"> 
        <h3><b>JIPPIS</b></h3>
        <h4><b>PENSION SUMMARY FOR {{$division}} DIVISION</b></h4>
        <h5><b>{{ strtoupper($nameOfPFA) }}</b></h5>
    </div>

    <p class="pull-right" style="margin-right: 30px;">Printed On: {{date_format(date_create(date('Y-m-d')), "dS l F, Y")}}.</p>
    <br/>

		<div class="row" style="margin: 0 10px;">
		<div class="col-md-12">
				<table class="table table-striped table-condensed table-bordered input-sm">
					<thead>
						<th>S/N</th>
						<th>File No.</th>
						<th>NAME OF EMPLOYEE</th>
						<th>DESIGNATION</th>
            <th>DATE OF 1ST APPT.</th>
            <th>DATE OF PRESENT APPT.</th>
            <th>GL/STEP</th>
						<th>RSA NUMBER</th>
            <th><small> TOTAL BASIC, <br /> ALLOWANCES</small> &#8358;</th>
            <th>EMPLOYEE (8%) &#8358;</th>
            <th>EMPLOYER (10%) &#8358;</th>
            <th>TOTAL &#8358;</th>
            <th>PFA</th>
            <th>MONTH</th>
            <th>YEAR</th>
            <th>REMARK</th>
            <th colspan="2" class="hidden-print"></th>
					</thead>
					<tbody class="input-sm">
  						@php 
                  $key                = 1; 
                  $employee_8percent  = 0;
                  $basicPlusAllowance = 0;
                  $employer_10percent = 0; 
              @endphp
  						@foreach ($allReportOrmonthly as $user)
                @php
                      $employee_8percent  = $user->employee_pension;
                      $basicPlusAllowance = substr((($employee_8percent * 100)/ 8), 0, strpos((($employee_8percent * 100)/ 8), '.') + 12);
                      $employer_10percent = ($basicPlusAllowance * 0.1);
                      $getPFA = DB::table('tblpension_manager')->where('ID', '=', $user->pension_manager)->first();
                @endphp
					     <tr> 
					        	<td>{{($allReportOrmonthly->currentpage()-1) * $allReportOrmonthly->perpage() + $key ++}}</td>
					       		<td>{{ 'JIPPIS/P/' . $user->fileNo }}</td>
					       		<td>{{ strtoupper($user->surname .' '. $user->first_name .' '. $user->othernames) }}</td>
					       		<td>{{ strtoupper($user->Designation) }}</td>
                    <td>{{ $user->appointment_date }}</td>
                    <td>{{ $user->incremental_date }}</td>
                    <td>{{ strtoupper('GL '.$user->grade .' STEP '. $user->step) }}</td>
                    <td>
                        <a href="{{url('/pension/staff/edit/'.$user->penID)}}" data-toggle="modal" data-target="#edit{{$user->penID}}">{{ strtoupper($user->rsanumber) }}
                        </a>
                    </td>
                    <td>{{ number_format(($basicPlusAllowance), 2, '.', ',') }}</td>
                    <td>{{ number_format(($user->employee_pension), 2, '.', ',') }}</td>
                    <td>{{ number_format(($employer_10percent), 2, '.', ',') }}</td>
                    <td>{{ number_format(($user->employee_pension + $employer_10percent), 2, '.', ',') }}</td>
                    <td>
                        <a href="{{url('/pension/staff/edit/'.$user->penID)}}" data-toggle="modal" data-target="#edit{{$user->penID}}">@if($getPFA != ''){{ $getPFA->pension_manager }}@endif
                        </a>
                    </td>
                    <td>{{ $user->month }}</td>
                    <td>{{ $user->year }}</td>
                    <td>
                        <a href="{{url('/pension/staff/edit/'.$user->penID)}}" data-toggle="modal" data-target="#edit{{$user->penID}}">{{ $user->remark }} 
                        </a>
                    </td>
                    <td class="hidden-print">
                        <a href="{{url('/pension/staff/edit/'.$user->penID)}}" data-toggle="modal" data-target="#edit{{$user->penID}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                    </td>
                    <td class="hidden-print">
                        <a href="{{url('/pension/staff/edit/'.$user->penID)}}" data-toggle="modal" data-target="#delete{{$user->penID}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
					     </tr>


              <!-- Modal Dialog for CONFIRMATION-->
              <!--DELETE-->
              <form id="saveSelectForm" method="post" action="{{url('/pension/staff/delete')}}">
                {{ csrf_field() }}
                  <div class="modal fade" id="delete{{$user->penID}}" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background: red; color: white; border: 1px solid white;">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title"> DELETE PENSION DETAILS !</h4>
                        </div>

                        <div class="modal-body col-sm-12" style="padding: 10px;">
                          Are you sure you want to DELETE <b>{{ strtoupper($user->surname .' '. $user->first_name .' '. $user->othernames) }}'s </b> record?
                          <hr />
                          <!--<div align="center"><span class="blink-text" style="background: black; padding: 10px; font-size: 20px; border-radius: 100%"><b><big> ! </big></b></span>
                          </div>-->
                          <p><b>NOTE:</b></p>
                          <p>YES: The system deletes the staff pension details for a particular Month</p>
                          <p>Cancel: The system takes no action</p>
                          
                        </div>

                        <div class="modal-footer">
                          <button type="submit" name="deleteButton" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Yes. Delete Now 
                          </button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="pensionID" value="{{$user->penID}}">
                  </div>
              </form>
                  <!-- //DELETE Modal Dialog -->


                  <!-- Modal Dialog for CONFIRMATION-->
              <!--Edit-->
              <form id="saveSelectForm" method="post" action="{{url('/pension/staff/update')}}">
                {{ csrf_field() }}
                  <div class="modal fade" id="edit{{$user->penID}}" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background: green; color: white; border: 1px solid white;">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title"> UPDATE STAFF PENSION RECORD</h4>
                        </div>
                        <div>
                          <h5 class="text-center"><b><big>UPDATING <i class="text-success">{{ strtoupper($user->surname .' '. $user->first_name .' '. $user->othernames) }}</i> RECORD</big></b></h5>
                        </div>

                        <div align="center" class="col-sm-12">
                            <b><big>JIPPIS/P/{{$user->fileNo}}</big></b>
                            <input type="hidden" name="pensionID" value="{{$user->penID}}" />

                        </div>

                        <div class="modal-body col-sm-12" style="padding: 10px;">

                            <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="rsaNumber">RSA NUMBER (PIN)</label>
                                    <input type="text" name="rsaNumber" class="form-control" value="{{$user->rsanumber}}" />
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                  <label for="pensionManager">Pension Manager</label>
                                  <select name="pensionManager" id="penmgr" class="form-control">
                                      <option value="{{$user->pension_manager}}"></option>
                                      <option></option>
                                        @foreach($penmgr as $list)
                                          <option value="{{$list->ID}}">{{ $list->pension_manager }} </option>
                                        @endforeach 
                                  </select> 
                                </div>
                              </div>  
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="remark">Remarks</label>
                                  <textarea name="remark" id="remark" class="form-control">{{$user->remark}}</textarea>
                                </div>
                              </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                          <button type="submit" name="replicateButton" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Now
                          </button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="voucherID" value="">
                  </div>
              </form>
                  <!-- //Modal Dialog -->

					    @endforeach
					</tbody>
				</table>
				<div align="right">
            Showing {{($allReportOrmonthly->currentpage()-1)*$allReportOrmonthly->perpage()+1}}
                    to {{$allReportOrmonthly->currentpage()*$allReportOrmonthly->perpage()}}
                    of  {{$allReportOrmonthly->total()}} entries
        </div>
        <div class="hidden-print">{{ $allReportOrmonthly->links() }}</div>
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
  <div class="row hidden-print">
      <div class="col-md-12">
          <div class="col-md-3">
            <div align="left" class="form-group">
              <label for="month">&nbsp;</label><br />
              <a href="{{url('/pension/report')}}" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
            </div>
          </div>
      </div>
  </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<!-- autocomplete js-->
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script src="{{ asset('assets/js/my-hr.js') }}" type="text/javascript"></script>
 	<script type="text/javascript">
  $(function() {
      $('#searchName').attr("disabled", true);
      $("#autocomplete").autocomplete({
        serviceUrl: murl + '/data/searchUser',
        minLength: 2,
        onSelect: function (suggestion) {
            $('#fileNo').val(suggestion.data);
            $('#searchName').attr("disabled", false);
            //showAll();
        }
      });
  });
</script>
@endsection

@section('styles')
	<style type="text/css">
      .table, tr, th, td{
         border: #030303 solid 1px !important;
         font-size: 10px !important;
      }
  </style>
@stop 