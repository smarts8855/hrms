@extends('layouts.layout')

@section('pageTitle')
  	VARIATION ADVICE
@endsection

@section('content')
 <div class="box box-default" style="border: none;">
    <div class="box-body box-profile">

    {{ csrf_field() }}
    	<div class="box-header with-border hidden-print">
          <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>
		  <p>
			<div class="row">
				<div class="col-xs-2"></div>
				<div class="col-xs-8">
					<h3 class="text-center"><strong>VARIATION ORDER NO.  </strong></h3>
				</div>
				<div class="col-xs-2"></div>
			</div>
		  </p>
		<p>
			<div class="row">
				<div align="left" class="col-xs-8">
					<table>
						<tr><td align="left">ADMINISTRATIVE SECTION,</td></tr>
						<tr><td align="left">VARIATION CONTROL OFFICER,</td></tr>
						<tr>
							<td align="left">
								OFFICER IN CHARGE OF SALARIES
								<span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									VARIATION ADVICE
								</span>
							</td>
						</tr>
					</table>
				</div>
				<div align="right" class="col-xs-4">
					<table >
						<tr><td align="right">T.F.220</td></tr>
						<tr><td align="right"></td></tr>
						<tr><td align="right"></td></tr>
					</table>
				</div>
			</div>
		</p>

		<p>
			<div class="row">
				<div align="left" class="col-xs-12">
					Please find enumerated hereunder for neccessary action, list of variation for the week ended    <br />
					to be submitted not later than  day of the week of the Month.
				</div>
			</div>
		</p>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-responsive table-condensed table-striped table-bordered">
					<thead>
						<tr>
							<td align="center" width="200">NAME <br /> 1</td>
							<td  align="center">RANK <br /> 2</td>
							<td  align="center">FILE NO. <br /> 3</td>
							<td align="center">NEW SALARY P.A <br /> 4</td>
							<td  align="center">AMOUNT OF VARIATION <br /> 5</td>
							<td  align="center">REASON FOR VARIATION <br /> 6</td>
							<td  align="center">EFFECTIVE DATE <br /> 7</td>
							<td  align="center">AUTHORITY GAZETTE <br > NOTIFICATION <br /> 8</td>
							<td  align="center">REMARK <br /> 9</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center">
								{{$staff->surname .' '. $staff->first_name .' '. $staff->othernames}}
							</td>
							<td align="left">
								{{$staff->rank}}
							</td>
							<td align="left">{{$staff->fileNo}}</td>

							<td align="left">{{ number_format(($salary->amount * 12), 2, '.', ',') }}</td>

							<td align="left">
								{{ number_format((($salary->amount - $oldsalary->amount) * 12), 2, '.', ',')}}
 							</td>

							<td align="left">{{$staff->arrears_type}}</td>

							<td align="left">{{date('d-m-Y', strtotime(trim( $staff->due_date)))}}</td>

							<td align="left"></td>

							<td align="left">{{$staff->arrears_type}}</td>
						</tr>
					</tbody>
				</table>

		<p>
			<div class="row">
				<div align="left" class="col-xs-4">
					<table >
						<tr><td align="left">Signature: ........................................................</td></tr>
						<tr><td align="left">For: Head of Personnel Administration</td></tr>
						<tr><td align="left">For: Secretary</td></tr>
						<tr><td align="left">Date: &nbsp;&nbsp;&nbsp;</td></tr>
					</table>
				</div>
				<div align="center" class="col-xs-4">
					<table>
						<tr><td align="left">Cc: Head of Accounts SCN, Abuja</td></tr>
						<tr><td align="left">Head of Internal Audit SCN, Abuja</td></tr>
						<tr><td align="left">Officer in Charge of Records, SCN, Abuja</td></tr>
					</table>
				</div>
				<div align="left" class="col-xs-4">
					<table >
						<tr><td align="left">Date Recorded: &nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td align="left">Action Taken: ........................................................</td></tr>
						<tr><td align="left">Signature: ..............................................................</td></tr>
					</table>
				</div>
			</div>
		</p>


		<div class="hidden-print text-center">
			<hr />
			<div id="{{$staff->staffid}}" class="staffid"></div>
			<a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-arrow-circle-0">Go Back</i></a>
			{{-- @if($stages->action_stageID == 9)
			@if( $staff->confirm == 1)
			<span>In Salary for payment
				@else
			<button class="btn btn-success" id="approve"> Approve For Payment </button>
			@endif
			@endif --}}
		</div>

	</div>
  </div>
</div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('#approve').click( function(){
      //alert($('.staffid').attr('id'))
      var s = 'staff';
      var id = $('.staffid').attr('id');
      $.ajax({
        url: murl +'/approve/arrears',
        type: "post",
        data: {'staff': id, '_token': $('input[name=_token]').val()},
        success: function(data){
          console.log(data);
          location.reload(true);
          //alert(data);
          }
      });
    });
});
</script>
@endsection
