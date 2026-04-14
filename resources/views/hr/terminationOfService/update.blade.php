@extends('layouts.layout')

@section('pageTitle')
 <h2> Termination of Service <strong>- </strong><span style="color:green;">{{$names->surname}} {{$names->first_name}}</span></h2>
@endsection

<style type="text/css">
	table tbody tr td strong
	{
		font-size: 14px;
	}
	table tbody tr td span
	{
		font-size: 14px;
		padding-left: 10px;
	}
</style>

<style type="text/css">
	#resignation
	{

	}
</style>

@section('content')
 <div class="box box-default">
    <div class="box-body box-profile">
    	<div class="box-header with-border hidden-print">
        	<h3 class="box-title"><b>@yield('pageTitle')</b> <span id='processing'></span></h3>
    	</div>

		  <div class="box-body">
		        <div class="row">



						<div class="col-md-12"><!--2nd col-->

							<form method="post" action="{{ url('/update/termination/') }}">
							<div class="row">

							{{ csrf_field() }}
							<div class="col-md-6">
									<div class="form-group">
										<label for="month">Select Service</label>

										<select name="service" class="form-control" id="tertype">
										<option value="bytransfer">Please Choose One</option>
									        <option value="resignation">Resignation Or Invalidating</option>
									        <option value="bydeath">By Death</option>
									        <option value="bytransfer">By Transfer</option>
								        </select>

								        <input type="hidden" name="sessionuid" id="uid" value="{{ session('fileNo') }}" />

									</div>
								</div>
							</div>
							</form>

							<div id="resignation">
							<form method="post" action="{{ url('/update/termination/') }}">
							<div class="row">
							{{ csrf_field() }}
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Date Terminated</label>
										<input type="text" name="terminationdate" id="terminationdate" class="form-control" />
												  <input type="hidden" name="resignation" value="resignation" />


									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Pension or Contract</label>
										<input type="text" name="pencont" id="pencont" class="form-control" />

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Pension Amount</label>
										<input type="text" name="penamt" id="penamt" class="form-control" />


									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Per Anum From</label>
										<input type="text" name="peranum" id="peranum" class="form-control" />

									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Gratuity Amount</label>
										<input type="text" name="gratuity" id="gratuity" class="form-control" />

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Contract Gratuity</label>
										<input type="text" name="contractgratuity" id="contractgratuity" class="form-control" />

									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<!--<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="{{url('/profile/details/'.session('fileNo'))}}" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>-->

								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="resig" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i>
										</button>
									</div>
								</div>


								</div>

								</div>
								<!--/// by resignation -->
								</form>
							</div>



							<!-- termination of service by death -->
						<div class="row2" id="bydeath">
						<form method="post" action="{{ url('/modify/termination/') }}">
													<div class="row">
						{{ csrf_field() }}
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Date of Death</label>
										<input type="text" name="dateofdeath" id="dateofdeath" class="form-control" />
												  <input type="hidden" name="hiddenName" value="terminateby" />

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Gratuity Paid To Estate</label>
										<input type="text" name="gratuityestate" id="gratuityestate" class="form-control" />

									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Widow Pension</label>
										<input type="text" name="widowspension" id="widowspension" class="form-control" />
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Per Anum From</label>
										<input type="text" name="widperanum" id="widperanum" class="form-control" />

									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Orphans Pension</label>
										<input type="text" name="orphanpen" id="orphanpen" class="form-control" />
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Orphan Pension Per Anum From</label>
										<input type="text" name="orpanperanum" id="orpanperanum" class="form-control" />

									</div>
								</div>
							</div>

							<hr />
							<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="#" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>

								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="action" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i>
										</button>
									</div>
								</div>


								</div>


							</div>
							</form>
							</div>
								<!--// termiantion of service by death -->



								<!-- By Transfer -->


						<div class="row2" id="bytransfer">
						<form method="post" action="{{ url('/edit/termination/') }}">
													<div class="row">
						{{ csrf_field() }}
								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Date of Transfer</label>
										<input type="text" name="transferdate" id="transferdate" class="form-control" />
												  <input type="hidden" name="bytransfer" value="bytransfer" />

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Pension Or Contract</label>
										<input type="text" name="transpencon" id="transpencon" class="form-control" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
								<h4>Aggregate Service in Nigeria</h4>

								<div class="col-md-4" style="padding: 0px;">
									<div class="form-group">
										<label for="month">Years</label>
										<input type="text" name="years" id="years" class="form-control" />
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label for="month">Months</label>
										<input type="text" name="months" id="months" class="form-control" />
									</div>
								</div>

								<div class="col-md-4" style="padding: 0px;">
									<div class="form-group">
										<label for="month">Days</label>
										<input type="text" name="days" id="days" class="form-control" />
									</div>
								</div>

								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="month">Aggregate Salary In Nigeria</label>
										<input type="text" name="aggrsalary" id="aggrsalary" class="form-control" />

									</div>
								</div>
							</div>
							<hr />
						<div class="row">
								<div class="col-md-12">

								<div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp;</label><br />
										<a href="{{url('/profile/details/'.session('fileNo'))}}" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>

								<div class="col-md-9">
									<div align="right" class="form-group">
										<label for="month">&nbsp;</label><br />
										<button name="trans" class="btn btn-success" type="submit">
											Update/Add New <i class="fa fa-save"></i>
										</button>
									</div>
								</div>
								</div>
							</div>
							</form>
							</div>

					<!--//By Transfer -->
					<hr />
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>By Termination</th>
                                <th>By Transfer</th>
                                <th>By Death</th>
							</tr>
						</thead>
						<tbody>
						@php if($terminationList != ''){ @endphp
						<tr>
						<td>
							<p><span><strong>Date Of Termination :</strong></span><span>{{date('d-m-Y', strtotime($terminationList->dateTerminated))}}</span></p>
							<p><span><strong>Pension Amount :</strong></span><span>{{ number_format((float) $terminationList->pensionAmount, 2) }}</span></p>
							<p><span><strong>Pension Per Anum From :</strong></span><span>{{$terminationList->pensionperanumfrom}}</span></p>
							<p><span><strong>Pension/Contract :</strong></span><span>{{$terminationList->pension_contract_terminate}}</span></p>
							<p><span><strong>Gratuity :</strong></span><span>{{ number_format((float) $terminationList->gratuity, 2) }}</span></p>
							<p><span><strong>Contract Gratuity :</strong></span><span>{{ number_format((float) $terminationList->contractGratuity, 2) }}</span></p>
						</td>
						<td>
							<p><span><strong>Date Of Transfer :</strong></span><span>{{date('d-m-Y', strtotime($terminationList->dateOfTransfer))}}</span></p>
							<p><span><strong>Years :</strong></span><span>{{$terminationList->aggregateYears}}</span></p>
							<p><span><strong>Months :</strong></span><span>{{$terminationList->aggregateMonths}}</span></p>
							<p><span><strong>Days :</strong></span><span>{{$terminationList->aggregateDays}}</span></p>
							<p><span><strong>Pension/Contract :</strong></span><span>{{$terminationList->pension_contract_transfer}}</span></p>

							<p><span><strong>Salary :</strong></span><span>{{ number_format((float) $terminationList->aggregateSalary,2) }}</span></p>
						</td>
						<td>
							<p><span><strong>Date Of Death :</strong></span><span>{{date('d-m-Y', strtotime($terminationList->dateOfDeath))}}</span></p>
							<p><span><strong>Gratuity Paid To Estate :</strong></span><span>{{number_format($terminationList->gratuityPaidEstate,2)}}</span></p>
							<p><span><strong>Widows Pension :</strong></span><span>{{number_format($terminationList->widowsPension,2)}}</span></p>
							<p><span><strong>P.A From :</strong></span><span>{{date('d-m-Y', strtotime($terminationList->widowsPensionFrom))}}</span></p>
							<p><span><strong>Orphans Pension :</strong></span><span>{{date('d-m-Y', strtotime($terminationList->orphanPension))}}</span></p>

							<p><span><strong>Orphan Pension P.A From :</strong></span><span>{{date('d-m-Y', strtotime($terminationList->orphanPensionFrom))}}</span></p>
						</td>


						</tr>
						@php
						}else{ @endphp
						<tr>
								<td colspan="7" class="text-center">No details provided Yet !</td>
								</tr>
						@php } @endphp
						</tbody>
					</table>
					</div>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		  </form>
		  <div class="col-md-3">
									<div align="left" class="form-group">
										<label for="month">&nbsp; </label><br />
										<a href="javascript: loadProfileDetail('{{$staffid}}')" title="Back to profile" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back </a>
									</div>
								</div>

		  <form action="{{url('/process/detailofservice/')}}" method="post">
		  {{ csrf_field() }}
		  		<!-- Modal -->
				<div class="bs-example">
			    <!-- Modal HTML -->
			    <div id="myModal" class="modal fade">
			        <div class="modal-dialog">
			            <div class="modal-content" style="padding: 10px; border-radius: 6px;">

			                <div class="box box-default">
    							<div class="box-body box-profile">
					                <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                    <h4 class="modal-title"><b>Add New Next of Kin</b></h4>
					                </div>
					                <div class="modal-body">
					                    <div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Name</label>
												<input type="text" name="fullName" class="form-control" />
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Relationship</label>
												<input type="text" name="relationship" class="form-control"/>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Full Address</label>
												<textarea name="address" class="form-control"></textarea>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="month">Phone Number</label>
												<input type="text" name="phoneNumber" class="form-control" placeholder="Optional" />
											</div>
										</div>
									</div>
					                </div>
					              </div>
					            </div>

			                <div class="modal-footer-not-use" align="right">
			                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Close</button>
			                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save</button>
			                </div>

			            </div>
			        </div>
			    </div>
			</div>
		  </form>
	</div>
</div>

<form method="post" id="displayform" name="displayform"  action="{{url('/profile/details')}}">

                {{ csrf_field() }}

                <input type="hidden" id="fileNos" name="fileNo" >



</form>
@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection



@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>
<script src="{{asset('assets/js/datepicker_customised.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function  loadProfileDetail(staffid)
{
document.getElementById('fileNos').value = staffid;
document.forms["displayform"].submit();
return;

}
</script>

  <script type="text/javascript">
	//Modal popup
	$(document).ready(function(){
		$('.open-modal').click(function(){
			$('#myModal').modal('show');
		});
	});
</script>

<script type="text/javascript">
	(function () {
	//$(document).ready(function(){

		$("#resignation").hide();
		$("#bydeath").hide();
		$("#bytransfer").hide();
	$("#tertype").on('change', function(e){
		var value = $(this).val();
		if(value =="resignation")
		{
		$("#resignation").show();
			$("#bydeath").hide();
			$("#bytransfer").hide();

        termination1();
		}
	   if(value =="bydeath")
		{
			$("#bydeath").show();
			$("#resignation").hide();
			$("#bytransfer").hide();
			termination2();
		}
		else if(value =="bytransfer")
		{
		    $("#bytransfer").show();
			$("#bydeath").hide();
			$("#resignation").hide();
			termination3();
		}

	});

})();

 $( function() {
	    $("#transferdate").datepicker({
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: '1910:2090', // specifying a hard coded year range
		    showOtherMonths: true,
		    selectOtherMonths: true,
		    dateFormat: "dd-mm-yy",
		    //dateFormat: "D, MM d, yy",
		    onSelect: function(dateText, inst){
		    	var theDate = new Date(Date.parse($(this).datepicker('getDate')));
				var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
				$("#transferdate").val(dateFormatted);
        	},
		});

  } );

</script>



@if (session('msg'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end', // top-end, top-start, bottom-end, etc.
    icon: 'success',
    title: '{{ session("msg") }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
</script>
@endif
@endsection
