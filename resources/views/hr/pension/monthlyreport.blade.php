@extends('layouts.layout')
@section('pageTitle')
	{{strtoupper('Monthly Staff Pension Report')}}
@endsection

@section('content')
<div style="background: white;">
  <div class="col-md-12 hidden-print">
       <h5><b>@yield('pageTitle') <span id='processing'></span></b></h5>
       <hr />
  </div>
  
	<div>
    <div align="center" class="text-success"> 
        <h3><b>JIPPIS</b></h3>
        <h4><b>PENSION SUMMARY FOR {{$division}} DIVISION {{$month .', '. $year}}</b></h4>
        <h5><b>{{ strtoupper($nameOfPFA) }}</b></h5>
    </div>

    <p class="pull-right" style="margin-right: 30px;">Printed On: {{date_format(date_create(date('Y-m-d')), "dS l F, Y")}}.</p>
    <br/>

		<div class="row" style="margin: 0 10px;">
		<div class="col-md-12">
				<table class="table table-striped table-condensed table-bordered">
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
            <th>Employee (8%) &#8358;</th>
            <th>Employer (10%) &#8358;</th>
            <th>Total &#8358;</th>
            <th>REMARK</th>
					</thead>
					<tbody>
						@php 
                $key                          = 1; 
                $employee_8percent            = 0;
                $basicPlusAllowance           = 0;
                $employer_10percent           = 0; 
                $groundTotal                  = 0.0;
                $groundTotal_8_percent        = 0.0;
                $groundTotal_10_percent       = 0.0;
                $groundTotal_basic_allowances = 0.0;
            @endphp
						@foreach ($allReportOrmonthly as $user)
                @php
                    $employee_8percent  = $user->employee_pension;
                    $basicPlusAllowance = substr((($employee_8percent * 100)/ 8), 0, strpos((($employee_8percent * 100)/ 8), '.') + 12);
                    $employer_10percent = ($basicPlusAllowance * 0.1);
                @endphp
					     <tr> <!--($allReportOrmonthly->currentpage()-1) * $allReportOrmonthly->perpage() + $key ++-->
					        	<td>{{$key ++}}</td>
					       		<td>{{ 'JIPPIS/P/' . $user->fileNo }}</td>
					       		<td>{{ strtoupper($user->surname .' '. $user->first_name .' '. $user->othernames) }}</td>
					       		<td>{{ strtoupper($user->Designation) }}</td>
                    <td>{{ $user->appointment_date }}</td>
                    <td>{{ $user->incremental_date }}</td>
                    <td>{{ strtoupper('GL '.$user->grade .' STEP '. $user->step) }}</td>
                    <td>{{ strtoupper($user->rsanumber) }}</td>
                    <td>{{ number_format(($basicPlusAllowance), 2, '.', ',') }}</td>
                    <td>{{ number_format(($employee_8percent), 2, '.', ',') }}</td>
                    <td>{{ number_format(($employer_10percent), 2, '.', ',') }}</td>
                    <td>{{ number_format(($user->employee_pension + $employer_10percent), 2, '.', ',') }}</td>
                    <td>{{ $user->remark }}</td>
					     </tr>
                   @php
                      $groundTotal_basic_allowances += ($basicPlusAllowance);
                      $groundTotal_8_percent        += ($employee_8percent);
                      $groundTotal_10_percent       += ($employer_10percent);
                      $groundTotal                  += ($user->employee_pension + $employer_10percent)
                   @endphp
					    @endforeach
              <tr>
                  <td colspan="8" class="text-center text-uppercase"><b><big>GROUND TOTAL CONTRIBUTIONS: </big></b></td>
                  <td><b><big>&#8358;{{ number_format(($groundTotal_basic_allowances), 2, '.', ',')}}</big></b></td>
                  <td><b><big>&#8358;{{ number_format(($groundTotal_8_percent), 2, '.', ',')}}</big></b></td>
                  <td><b><big>&#8358;{{ number_format(($groundTotal_10_percent), 2, '.', ',')}}</big></b></td>
                  <td><b><big>&#8358;{{ number_format(($groundTotal), 2, '.', ',')}}</big></b></td>
                  <td></td>
              </tr>
					</tbody>
				</table>
				<div align="right">
            Total Record: {{count($allReportOrmonthly)}} entries         
        </div>
  
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