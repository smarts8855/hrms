@extends('layouts.layout')
@section('pageTitle')
	{{strtoupper(' You can print your voucher here')}}
@endsection
@section('content')
<style type="text/css">
/*.table tr td .linedia {
    width: 400px;
    height: 27px;
    border-bottom: 1px solid #000;
    -webkit-transform:
        translateY(20px)
        translateX(5px)
        rotate(-12deg);
    position: absolute;
    
    
}*/

@media print {
  .print-voucher
  {
      display:none;
  }
}
.print-voucher
  {
      float:right;
      
  }
  .printWrap
  {
     float:right;
     margin-bottom:10px;
  }
</style>


<!--JOURNAL -->
	<div style="background: #FFFFFF; padding: 10px 30px;">
    <form method="post" action="{{url('/CR/voucher/contract/create')}}">
	{{ csrf_field() }}
    	<div class="printWrap">
		       <select class="type print-voucher">
		           <option value="">Select Voucher to print</option>
							<option value="rem">REMMITTANCE</option>
							<option value="main">MAIN VOUCHER</option>
							<option value="prem">PREMIUM CHARGE</option>
							<option value="tax">TAX</option>
							<option value="vat">VAT</option>
							<option value="stamp">STAMP DUTY</option>
							<option value="bene">BENEFICIARIES</option>
							<option value="all">Print All Vouchers</option>
							</select>
		   </div>
		<div align="center" id="rem" style="background: #FFF;">
		   
		<div style="float: right;width:100%; text-align:right"><b>ECONOMIC CODE: {{$list->Code}} {{$list->economicCode}} </b></div> 
		<br />
	

		<div align="center">
			<h3><b><span style="text-decoration: underline;">REMMITTANT</span></b></h3>
		</div>

		<div class="row" >
			<div class="col-xs-12">
				<table class="table table-striped table-condensed table-bordered ">
					<thead style="background: #fdfdfd;">
						<tr class="input-lg">
				        	<th width="100" rowspan="2" class="text-center">DATE</th>
				        	<th width="600" rowspan="2" class="text-center">DESCRIPTION</th>
				        	<th width="200" class="text-center">DR. </th>
				        	<th width="200" class="text-center">CR. </th>
				        </tr>
				        <tr class="input-lg">
				        	<th width="140" class="text-center"> &#8358; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>k</b></th>
				        	<th width="140" class="text-center"> &#8358; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>k</b></th>
				        </tr>
			        </thead>
			        <tbody>
	          			<tr class="input-lg">
	  						<th><div>{{date_format(date_create($list->datePrepared), "d-m-Y")}}</div></th>
	  						<th>
	  							<div class="row">
					        		<div class="col-xs-12">
					        			<div>
										<!--$payeeName-->
										{{ $list->paymentDescription }}
					        			</div>
					        		</div>
								</div>
	  						</th>
	  						<th>
	  							<span>
	  								<div align="center">{{number_format(($list->totalPayment), 2, '.', ',')}}</div>
	  							</span>
	  						</th>
	  						<th></th>
				        </tr>
				        @if($list->premiumcharge > 0)
				        <tr class="input-lg" >
	  						<th class="text-center"><span>&#10004;</span></th>
	  						<th> <span style="font-weight: 100;">{{$list->premiumpercentage}}% Premium Charge </span></th>
	  						<th></th>
	  						<th><div align="center">{{number_format(($list->premiumcharge), 2, '.', ',')}}</div></th>
				        </tr>
				        @endif
				        
				         @if($list->VATValue > 0)
				        <tr class="input-lg" >
	  						<th class="text-center"><span>&#10004;</span></th>
	  						<th> <span style="font-weight: 100;">{{$list->VAT}}% VAT Payable ( Cash Book ) </span></th>
	  						<th></th>
	  						<th><div align="center">{{number_format(($list->VATValue), 2, '.', ',')}}</div></th>
				        </tr>
				        @endif
				        
				        @if($list->WHTValue > 0)
				        <tr class="input-lg ">
	  						<th class="text-center"><span>&#10004;</span></th>
	  						<th style="font-weight: 100;">
	  							{{$list->WHT}}% Withholding Tax Payable ( Cash Book )
	  						</th>
	  						<th></th>
	  						<th><div align="center">{{number_format(($list->WHTValue), 2, '.', ',')}}</div></th>
				        </tr>
				        @endif
				        
				        @if($list->stampduty > 0)
				        <tr class="input-lg ">
	  						<th class="text-center"><span>&#10004;</span></th>
	  						<th style="font-weight: 100;">
	  							{{$list->stampduty}}% Stamp Duty
	  						</th>
	  						<th></th>
	  						<th><div align="center">{{number_format(($list->stampduty), 2, '.', ',')}}</div></th>
				        </tr>
				        @endif
				        
				        <tr class="input-lg">
	  						<th class="text-center"><span>&#10004;</span></th>
	  						<th>
	  							<span style="font-weight: 100;">
	  								@if($list->WHTValue == '' or $list->WHTValue == 0)
	  								 	Amount Payable (Overhead )  Cash Book 
	  								@else
	  									Amount Payable (Overhead )  Cash Book
	  								@endif

	  							</span> 
	  						</th>
	  						<th></th> 
	  						<th><div align="center">{{number_format(($list->amtPayable), 2, '.', ',')}}</div></th>
				        </tr>
				        
			        </tbody>
				</table>


			<table class="table table-striped table-condensed">
				<thead style="background: #fff;">
					<tr class="input-lg">
				        <td valign="top" width="100"><h4>Narration:</h4></td>
				        <th width="600">
				        	<div style="font-weight: 100;">
				        	{{$list->paymentDescription}}
				        	</div>
				        </th>
				    </tr>
				    <tr class="input-lg">
				        <th colspan="2"><h4>Prepared By</h4></th>
				    </tr>
				    <tr class="input-lg">
				        <th valign="center" width="100"><h4>Name:</h4></th>
				        <th>
				        	<div style="font-weight: 100;">{{$preparedBy->name}}</div>
				        </th>
				    </tr>
				     <tr class="input-lg">
				        <th valign="center" width="100"><h4>Date: </h4></th>
				        <th><span style="font-weight: 100;">{{date_format(date_create($list->datePrepared), "dS l F, Y")}}</span></th>
				    </tr>

			    </thead>
			</table>

			</div>
		</div><!-- /.col -->
		</div><!-- /.row -->
		<br /><br /><br />
 	 </form>
  </div>


<!--PAYMENT VOUCHER-->
<div class="box-body" id="main" style="background: #fff;"> 
<div style="margin: 0 10px;">
	<div class="row">
	 <div class="col-xs-12">
		<div class="box-body">
				<div align="center">
					<h4>
						<div>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</b>
							<p><span class="pull-right"><big>
							<select class="type">
							<option>ORIGINAL</option>
							<option>DUPLICATE</option>
							<option>TRIPLICATE</option>
							<option>QUADRUPLICATE</option>
							<option>QUINTUPLICATE</option>
							<option>SEXTUPLICATE</option>
							</select>
							</big></span></p><br/>
							<span class="pull-right"><small>Treasury F1</small></span><br/>
                                                        <span class="pull-right hidden-print"><small><span  style="color:green;">STATUS: </span>@if($list->status == 6){{PAID}}@else{{$status->description}}@endif</small></span>
						</div>
					</h4>
					<div><h4><b>{{strtoupper('PAYMENT VOUCHER')}}</b></h4></div>
				</div>
				
				<div align="center" style="font-weight: 100">
					Departmental No. <b>NJC/OC/{{$list->vref_no}}/{{date('Y')}}</b>. Checked and passed for payment at <b>Abuja</b>
				</div>
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">
	 	<div class="col-xs-3">
	 		<div align="center" class="visible-print text-center" style="margin-top: -15px" >
				 	
			</div>
	 		<table style="font-size: 10px; margin-left: 4px; margin-top: -25px;">
	 			<tr>
	 				<td><div class="vertical-text v-align-1">For Use in Payment of Advance</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-2">Certified the Advance of</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-3">&#8358; ...........................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-4">has been entered on TF 174 (A) (B) or (C)</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-5">Deptal No:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-6">Signature:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-7">Name in Block Letters ................</div></td>
	 			</tr>
	 		</table>
		 	
	 	</div>
	 	<div class="col-xs-6">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">Date Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">VO 1</td>
	 					<td>0</td>
	 					<td>9</td>
	 					<td colspan="2">1</td>
	 					<td>R</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				<!--<tr>
	 					<td height="25"></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td>
	 					<td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td colspan="2"></td> <td></td>
	 				</tr>-->
	 				<tr>
	 					<td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;</td>
	 					<td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
	 				</tr>
	 				<tr>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td colspan="14"><b>&#8358;{{number_format(($list->totalPayment), 2, '.', ',')}}</b></td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">
	 						6 Source 8 <br />  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	 					</td>
	 					<td colspan="16"> Classification Code </td>
	 				</tr>
	 				<tr style="font-weight: bold;">
	 					<td>0</td>
	 					<td>3</td>
	 					<td>1</td>
	 					<td>8</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td colspan="8">{{substr($list->Code,0,4)}} {{ $list->economicCode}}</td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 input-sm">
	 		<table class="table table-bordered input-sm" style="font-size: 9px">
	 			<tr>
	 				<td colspan="2"><div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abuja</div></td>
	 			</tr>
	 			<tr>
	 				<td>Head</td>
	 				<td>031</td>
	 			</tr>
	 			<tr>
	 				<td>S/Head</td>
	 				<td>{{substr($list->Code,0,4)}}  {{$list->economicCode}}</td>
	 			</tr>
	 			</table>
	 				
	 	</div>
	</div>

	<div style="margin-bottom: 2px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			Payee: &nbsp;&nbsp;&nbsp; <span class="input-lg">
			@if($list->companyID == 13)
			{{$list->payment_beneficiary}}
			@else
				{{$list->contractor}} 
				@endif
			</span>
		</div>
	
		<div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; <span class="input-lg"><small>
			{{$list->address}}
			</small></span>
		</div>
	</div>

	<table class="table table-condensed table-bordered text-center input-sm">
		<thead>
			<tr class="input-lg">
				<th >Date</th>
				<th>Detailed Description of Service/Work</th>
				<th>Rate</th>
				<th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3" width="150"> 
				{{date_format(date_create($list->datePrepared), "d-m-Y")}}
				<div class="vertical-text vert-text"><p> ENTER IN THE VOTEBOOK</p><p> <span>LINE_____</span><span>PAGE______</span></p><p> <span>SIGN_____</span><span>DATE______</span></p></div>
				 </td>
				<td rowspan="2" width="650">
					<div align="left">
						<small>{{$list->paymentDescription}}</small>
						
						<div style="padding: 4px 0px">
							<!--<b>NJC/  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; /  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; refers.</b>-->
						</div>
						
						<div style="" class="">
						<table class="input-sm ">
						    @if($list->companyID != 13)
                           @if($contractAmount != $list->totalPayment)
                            <tr>
								<td width="200" style="border: none !important;"><div align="left">@if($contractAmount == $bbf){{ 'Total Contract Amount' }} @elseif($contractAmount > $bbf) {{'Balance Brought Forward'}} @endif</div></td>
								<td style="border: none !important;"><div align="right">&#8358;{{number_format(($bbf), 2, '.', ',')}}</div></td>
							</tr>
							@endif
							 @if($list->premiumcharge >0)
                            <tr>
								<td width="200" style="border: none !important;"><div align="left">Total Amount(Premium Charge Inclusive)</div></td>
								<td style="border: none !important;"><div align="right">&#8358;{{number_format($list->totalPayment, 2, '.', ',')}}</div></td>
							</tr>
							@endif
							
							@if($list->premiumcharge > 0)
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Less {{$list->premiumpercentage}}% Premium Charge</div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom: 2px solid #000;"> &#8358;{{number_format(($list->premiumcharge), 2, '.', ',')}}</div></td> 
							</tr>
							@endif
				
                            @if($list->premiumcharge > 0)
							<tr>
								<td width="200" style="border: none !important;"><div align="left">Amount(VAT Inclusive)</div></td>
								<td style="border: none !important;"><div align="right">&#8358;{{number_format(($list->totalPayment - $list->premiumcharge), 2, '.', ',')}}</div></td>
							</tr>
							@else
							<tr>
								<td width="200" style="border: none !important;"><div align="left">Amount(VAT Inclusive)</div></td>
								<td style="border: none !important;"><div align="right">&#8358;{{number_format(($list->totalPayment), 2, '.', ',')}}</div></td>
							</tr>
							
							@endif
							@if($list->VAT > 0)
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Less {{$list->VAT}}% VAT Payable</div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom: 2px solid #000;"> &#8358; @if($list->VATValue==0) {{$list->VATValue}} @else{{number_format(($list->VATValue), 2, '.', ',')}}@endif</div></td> 
							</tr>
							@endif
							 @if($list->premiumcharge > 0)
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Gross Amount</div></td>
								<td style="border: none !important;"><div align="right">&#8358;{{number_format((($list->totalPayment - $list->premiumcharge) - ($list->VATValue)), 2, '.', ',')}}</div></td>
							</tr>
							@else
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Gross Amount</div></td>
								<td style="border: none !important;"><div align="right">&#8358;{{number_format((($list->totalPayment) - ($list->VATValue)), 2, '.', ',')}}</div></td>
							</tr>
							@endif
							@if($list->WHT > 0)
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Less {{$list->WHT}}% W/H Tax</div></td>
								<td style="border: none !important;"><div align="right">&#8358; @if($list->WHTValue==0) {{$list->WHTValue}} @else{{number_format(($list->WHTValue), 2, '.', ',')}} @endif</div></td>
							</tr>
							@endif
							
							@if($list->stampduty > 0)
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Less {{$list->stampdutypercentage}}% Stamp Duty</div></td>
								<td style="border: none !important;"><div align="right">&#8358; @if($list->stampduty==0) {{$list->stampduty}} @else{{number_format(($list->stampduty), 2, '.', ',')}} @endif</div></td>
							</tr>
							@endif
							
							@endif
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Amount Payable</div></td>
								<td style="border: none !important;">
									<div style="border-bottom: 2px solid #000; border-top: 2px solid #000;">&#8358;{{number_format(($list->amtPayable), 2, '.', ',')}}</div>
								</td>
							</tr>
							@php $balance1 = $bbf - $list->totalPayment;  @endphp
							
							@if($list->companyID != 13)
                           @if($balance1 > 0)
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Balance</div></td>
								<td style="border: none !important;">
									<div style="border-bottom: 2px solid #000; border-top: 2px solid #000;">&#8358;{{number_format(($balance1), 2, '.', ',')}}</div>
								</td>
							</tr>
							@endif
							@endif

						</table>
						</div>
						
						<div>I certify that the expenditure was incured in the interest of Public Service.</div>
						<div align="center">
							<b>
							@php
								$strArray = explode('and', $list->contractor);
								$payee = $strArray[0];
							@endphp
							@php
								
							@endphp 
							@if($list->contractType == 4)
								{{'Mr. Ahmed Gambo Saleh (Secretary)'}}
							@else
							
							@endif
							</b>
						</div>
					</div>

				</td>
				<td rowspan="2"></td>
				<td height="20">
					<b><big>{{number_format(($list->totalPayment), 2, '.', ',')}}</big></b>
					<?php $amtpayable = $list->amtPayable; ?>
					<div class="close-account"></div>
				</td>
			</tr>
			<tr>
				<td><div class="linedia"></div></td>
			</tr>
			<tr>
				<td>
					<div align="left">Checked and Passed for 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span id="result"></span>
					</div>
					<br />
				</td>
				<td width="100">Total &#8358;</td>
				<td><big>{{number_format(($list->amtPayable), 2, '.', ',')}}</big></td>
			</tr>	
			<tr>
				<td colspan="5">
					<div class="row">
						<div  align="left" class="col-xs-5">
							<div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
							    <h6>Payable at: <strong>NJC</strong></h6>
							    <h6>Initiated By: <strong>@if($approvedBy !=''){{$approvedBy->name}} @endif</strong></h6>
							    <h6>Prepared By: <strong>@if($preparedBy !=''){{$preparedBy->name}}@endif</strong></h6>
							    <h6>Passed By: <strong></strong></h6>
							    <h6>Liability Taken By: <strong>@if($libilityBy !=''){{$libilityBy->name}}@endif</strong></h6>
								<h6>Checked By: <strong>@if($checkBy !=''){{$checkBy->name}} @endif</strong></h6>
								<h6>Audited By:    <strong> @if($auditedBy != '') {{$auditedBy->name}} @endif </strong> </h6>
								
								<h6>Station:    <strong>ABUJA</strong></h6>
								
								<h6>Name:    ------------------ </h6>

								<h6>1. ------------------ </h6>
								<h6>2. ------------------------</h6>
								
							</div>
						</div>		
						<div class="col-xs-7" style="font-size: 11px;">
							<span class="text-center">CERTIFICATE</span>
							<div align="left">
								I certify the above amount is correct, and was incurred under the Authority quoted, that the service have been dully performed; that the rate/price charge is according to regulations/contract is fair and reasonable: <br />
								that the amount of <b><span id="result"></span></b> may be paid under the Classification quote.
							</div>
							<div style="text-decoration: underline;">
								<b>&nbsp;&nbsp; For Executive Secretary &nbsp;&nbsp;</b>
							</div>
							<span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
							<div>
								Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Date: <b style="text-decoration: underline;">&nbsp;&nbsp; {{$list->datePrepared}} &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.) &nbsp;&nbsp;</b>
							</div>
							<br />
							<div align="center">
									<span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GW/{{$list->period}}</b></span>
							</div>
							<span>Anthy AIE No., etc.</span>
						</div>
					</div>
				</td>
			</tr>	
		</tbody>
	</table>
	<div style="margin-top: -20px; font-size: 8px;">
		Received from the Federal Government of Nigeria the sum of <span id="result2" style="font-size: 8px;"></span> in full settlement of the Account. <small> Date.................{{$list->period}}
		&nbsp;&nbsp;&nbsp;
		Signature..........
		&nbsp;&nbsp;
		Place.............</small>
	</div>
</div>
</div>
<!---////////////////////// End PAYMENT VOUCHER-->


<!--PREMIUM VOUCHER PAYMENT-->
@if($list->premiumcharge > 0)
<div class="box-body" id="prem" style="display:; background: #fff;">

<hr  class="hidden-print">

<div style="margin: 0 10px;">
	<div class="row">
	 <div class="col-xs-12">
		<div class="box-body">
				<div align="center">
					<h4>
						<div>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</b>
                                                        <p><span class="pull-right"><big>
							<select class="type">
							<option>ORIGINAL</option>
							<option>DUPLICATE</option>
							<option>TRIPLICATE</option>
							
							</select>
							</big></span></p><br/>
							<span class="pull-right"><small>Treasury F1</small></span>
						</div>
					</h4>
					<div><h4><b>{{strtoupper('PAYMENT VOUCHER')}}</b></h4></div>
				</div>
				
				<div align="center" style="font-weight: 100">
					Departmental No. <b>NJC/{{$list->economicCode}}/{{$list->vref_no}}/{{date('Y')}}</b>. Checked and passed for payment at <b>Abuja</b>
				</div>
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">
	 	<div class="col-xs-3">

	 		<div align="center" class="visible-print text-center" style="margin-top: -15px" >
				 	
			</div>
	 		<table style="font-size: 10px; margin-top: -25px;">
	 			<tr>
	 				<td><div class="vertical-text v-align-1">For Use in Payment of Advance</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-2">Certified the Advance of</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-3">&#8358; ...........................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-4">has been entered on TF 174 (A) (B) or (C)</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-5">Deptal No:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-6">Signature:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-7">Name in Block Letters ................</div></td>
	 			</tr>
	 		</table>
		 	
	 	</div>
	 	<div class="col-xs-6">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">1 Data Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">VO 1</td>
	 					<td>0</td>
	 					<td>9</td>
	 					<td colspan="2">1</td>
	 					<td>R</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				<!--<tr>
	 					<td height="25"></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td>
	 					<td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td colspan="2"></td> <td></td>
	 				</tr>-->
	 				<tr>
	 					<td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;</td>
	 					<td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
	 				</tr>
	 				<tr>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td colspan="14"><b>&#8358;{{number_format(($list->WHTValue), 2, '.', ',')}}</b></td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">
	 						4 Source 4 <br /> 6 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8
	 					</td>
	 					<td colspan="16">49 Classification Code 60</td>
	 				</tr>
	 				<tr style="font-weight: bold;">
	 					<td>0</td>
	 					<td>3</td>
	 					<td>1</td>
	 					<td>8</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td colspan="8">{{'NJC/'.$list->economicCode}}</td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 input-sm">
	 		<table class="table table-bordered input-sm" style="font-size: 10px">
	 			<tr>
	 				<td colspan="2"><div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abuja</div></td>
	 			</tr>
	 			<tr>
	 				<td>Head</td>
	 				<td>18008</td>
	 			</tr>
	 			<tr>
	 				<td>S/Head</td>
	 				<td>{{'NJC/'.$list->economicCode}}</td>
	 			</tr>
	 		</table>
	 		
	 	</div>
	</div>

	<div style="margin-bottom: 2px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			Payee: &nbsp;&nbsp;&nbsp; Premium Charge<span class="input-lg"> </span>
		</div>
	
		<div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; Premium Charge<span class="input-lg"><small></small></span>
		</div>
	</div>

	<table class="table table-condensed table-bordered text-center input-sm">
		<thead>
			<tr class="input-lg">
				<th>Date</th>
				<th>Detailed Description of Service/Work</th>
				<th>Rate</th>
				<th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3"> {{date_format(date_create($list->datePrepared), "d-m-Y")}} </td>
				<td rowspan="2" width="650">
					<div align="left">
						Being {{$list->premiumpercentage}}% of {{number_format($list->totalPayment,2)}} Premium Charge on P.V. NO. NJC/{{$list->economicCode}}/ {{$list->vref_no}} /{{date('Y')}} from
						<b>
							@if($list->contractor != ''){{$list->contractor}} @endif
							@if($list->contractor == ''){{$list->payee}} @endif
						</b>  
							@php
								//$strArray = explode('Vide', $list->description);
								//$newDscription = $strArray[0];
								$newDscription   = $list->paymentDescription;
							@endphp 
						 	@if(stripos($newDscription, 'Being Balance payment to the above named company') !== false)
						 		{{str_ireplace('Being Balance payment to the above named company', " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Balance payment to the above named')) !== false)
							 		{{str_ireplace("Being Balance payment to the above named", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment to the above named company') !== false)
							 		{{str_ireplace("Being part payment to the above named company", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Part Payment') !== false)
							 		{{str_ireplace("Being Part Payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being further part payment to the above named company') !== false)
							 		{{str_ireplace("Being further part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being further part payment') !== false)
							 		{{str_ireplace("Being further part payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being payment to the above named Company') !== false)
							 		{{str_ireplace("Being payment to the above named Company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment to the above named company') !== false)
							 		{{str_ireplace("Being payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment') !== false)
							 		{{str_ireplace("Being payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment Recommended') !== false) Being Balance Payment
									{{str_ireplace("Being part payment Recommended", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment recommended') !== false) 
							 		{{str_ireplace("Being part payment recommended", " ", $newDscription)}} 
							 @elseif(stripos($newDscription, 'Being Balance Payment') !== false) 
							 		{{str_ireplace("Being Balance Payment", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment to the above named company') !== false) 
							 		{{str_ireplace("Being additional part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment') !== false) 
							 		{{str_ireplace("Being additional part payment", " ", $newDscription)}}
							 @else
							 		{{$newDscription}}
							 @endif
							
					
						
						<table class="input-sm">
							
							<!--<tr>
							    <td style="border: none !important;" width="200"><div align="left">Total Amount(Premium Charge Inclusive) </div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom:2px solid #000;"> &#8358;{{number_format(($list->totalPayment), 2, '.', ',')}}</div>
								</td>
							</tr>-->
							<tr>
							    <td style="border: none !important;" width="200"><div align="left">Less {{$list->premiumpercentage}}% Premium Charge</div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom:2px solid #000;"> &#8358;{{number_format(($list->premiumcharge), 2, '.', ',')}}</div>
								</td>
							</tr>
							
							
							
							
						</table>
						
						<!--<div>I certify that the expenditure was incured in the interest of Public Service.</div>
						<div align="center"><b> (Executive Secretary)</b></div>-->
					</div>

				</td>
				<td rowspan="2"></td>
				<td height="20">
					<b><big>{{number_format(($list->premiumcharge), 2, '.', ',')}}</big></b>
					<div class="close-account"></div>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td>
					<div align="left">Checked and Passed for 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span id ="resultTAX"></span>
					</div>
					<br />
				</td>
				<td width="100">Total &#8358;</td>
				<td><big>{{number_format(($list->premiumcharge), 2, '.', ',')}}</big></td>
			</tr>	
			<tr>
				<td colspan="5">
					<div class="row">
						<div  align="left" class="col-xs-4">
							<div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
								<h6>Payable at: <strong>NJC</strong></h6>
								<h6>Initiated By: <strong>@if($approvedBy !=''){{$approvedBy->name}} @endif</strong></h6>
							    <h6>Prepared By: <strong>@if($preparedBy !=''){{$preparedBy->name}}@endif</strong></h6>
							    <h6>Passed By: <strong></strong></h6>
							    <h6>Liability Taken By: <strong>@if($libilityBy !=''){{$libilityBy->name}}@endif</strong></h6>
								<h6>Checked By: <strong>@if($checkBy !=''){{$checkBy->name}} @endif</strong></h6>
								<h6>Audited By:    <strong> @if($auditedBy != '') {{$auditedBy->name}} @endif </strong></h6>
							    <h6>Station:    <strong>ABUJA</strong></h6>
								
								<h6>Other Approval    ------------------ </h6>

								<h6>1. ------------------ </h6>
								<h6>2. ------------------------</h6>
								
							</div>
						</div>		
						<div class="col-xs-8" style="font-size: 11px;">
							<span class="text-center">CERTIFICATE</span>
							<div align="left">
								I certify the above amount is correct, and was incurred under the Authority quoted, that the service have been dully performed; that the rate/price charge is according to regulations/contract is fair and reasonable: <br />
								that the amount of <b><span id="resultTAX"></span></b> may be paid under the Classification quote.
							</div>
							<div style="text-decoration: underline;">
								<b>&nbsp;&nbsp; For Executive Secretary &nbsp;&nbsp;</b>
							</div>
							<span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
							<div>
								Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Date: <b style="text-decoration: underline;">&nbsp;&nbsp; {{$list->datePrepared}} &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.) &nbsp;&nbsp;</b>
							</div>
							<br />
							<div align="center">
									<span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GW/{{$list->period}}</b></span>
							</div>
							<span>Anthy AIE No., etc.</span>
						</div>
					</div>
				</td>
			</tr>	
		</tbody>
	</table>
	<div style="margin-top: -20px; font-size: 8px;">
		Received from the Federal Government of Nigeria the sum of <span id="resultTAX2" style="font-size: 8px;"></span> in full settlement of the Account.
		 <small> Date.................{{$list->period}}
		&nbsp;&nbsp;&nbsp;
		Signature..........
		&nbsp;&nbsp;
		Place.............</small>
	</div>
	<br />
</div>
</div>
@endif

<br />

<!----////// End Premium Voucher  ---->


<!--WHITHOLDING TAX ON VOUCHER PAYMENT-->
@if($list->WHTValue > 0)
<div class="box-body" id="tax" style="display:; background: #fff;">

<hr  class="hidden-print">

<div style="margin: 0 10px;">
	<div class="row">
	 <div class="col-xs-12">
		<div class="box-body">
				<div align="center">
					<h4>
						<div>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</b>
                                                        <p><span class="pull-right"><big>
							<select class="type">
							<option>ORIGINAL</option>
							<option>DUPLICATE</option>
							<option>TRIPLICATE</option>
							
							</select>
							</big></span></p><br/>
							<span class="pull-right"><small>Treasury F1</small></span>
						</div>
					</h4>
					<div><h4><b>{{strtoupper('PAYMENT VOUCHER')}}</b></h4></div>
				</div>
				
				<div align="center" style="font-weight: 100">
					Departmental No. <b>NJC/{{$list->economicCode}}/{{$list->vref_no}}/{{date('Y')}}</b>. Checked and passed for payment at <b>Abuja</b>
				</div>
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">
	 	<div class="col-xs-3">

	 		<div align="center" class="visible-print text-center" style="margin-top: -15px" >
				 	
			</div>
	 		<table style="font-size: 10px; margin-top: -25px;">
	 			<tr>
	 				<td><div class="vertical-text v-align-1">For Use in Payment of Advance</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-2">Certified the Advance of</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-3">&#8358; ...........................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-4">has been entered on TF 174 (A) (B) or (C)</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-5">Deptal No:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-6">Signature:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-7">Name in Block Letters ................</div></td>
	 			</tr>
	 		</table>
		 	
	 	</div>
	 	<div class="col-xs-6">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">1 Data Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">VO 1</td>
	 					<td>0</td>
	 					<td>9</td>
	 					<td colspan="2">1</td>
	 					<td>R</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				<!--<tr>
	 					<td height="25"></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td>
	 					<td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td colspan="2"></td> <td></td>
	 				</tr>-->
	 				<tr>
	 					<td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;</td>
	 					<td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
	 				</tr>
	 				<tr>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td colspan="14"><b>&#8358;{{number_format(($list->WHTValue), 2, '.', ',')}}</b></td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">
	 						4 Source 4 <br /> 6 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8
	 					</td>
	 					<td colspan="16">49 Classification Code 60</td>
	 				</tr>
	 				<tr style="font-weight: bold;">
	 					<td>0</td>
	 					<td>3</td>
	 					<td>1</td>
	 					<td>8</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td colspan="8">{{'NJC/'.$list->economicCode}}</td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 input-sm">
	 		<table class="table table-bordered input-sm" style="font-size: 10px">
	 			<tr>
	 				<td colspan="2"><div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abuja</div></td>
	 			</tr>
	 			<tr>
	 				<td>Head</td>
	 				<td>18008</td>
	 			</tr>
	 			<tr>
	 				<td>S/Head</td>
	 				<td>{{'NJC/'.$list->economicCode}}</td>
	 			</tr>
	 		</table>
	 		
	 	</div>
	</div>

	<div style="margin-bottom: 2px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			Payee: &nbsp;&nbsp;&nbsp; @if($whtpayee != '') {{$whtpayee->payee}} @endif<span class="input-lg"> </span>
		</div>
	
		<div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; @if($whtpayee != '') {{$whtpayee->address}} @endif<span class="input-lg"><small></small></span>
		</div>
	</div>

	<table class="table table-condensed table-bordered text-center input-sm">
		<thead>
			<tr class="input-lg">
				<th>Date</th>
				<th>Detailed Description of Service/Work</th>
				<th>Rate</th>
				<th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
			</tr>
		</thead>
		<tbody>
		    @php
		    if($list->premiumcharge > 0)
		    {
		    $totalPayment = $list->totalPayment - $list->premiumcharge;
		    }
		    else
		    {
		    $totalPayment = $list->totalPayment ;
		    }
		    
		    @endphp
			<tr>
				<td rowspan="3"> {{date_format(date_create($list->datePrepared), "d-m-Y")}} </td>
				<td rowspan="2" width="650">
					<div align="left">
						Being {{$list->WHT}}% of {{number_format($totalPayment,2)}} W/H TAX deduction on P.V. NO. NJC/{{$list->economicCode}}/ {{$list->vref_no}} /{{date('Y')}} from
						<b>
							@if($list->contractor != ''){{$list->contractor}} @endif
							@if($list->contractor == ''){{$list->payee}} @endif
						</b>  
							@php
								//$strArray = explode('Vide', $list->description);
								//$newDscription = $strArray[0];
								$newDscription   = $list->paymentDescription;
							@endphp 
						 	@if(stripos($newDscription, 'Being Balance payment to the above named company') !== false)
						 		{{str_ireplace('Being Balance payment to the above named company', " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Balance payment to the above named')) !== false)
							 		{{str_ireplace("Being Balance payment to the above named", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment to the above named company') !== false)
							 		{{str_ireplace("Being part payment to the above named company", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Part Payment') !== false)
							 		{{str_ireplace("Being Part Payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being further part payment to the above named company') !== false)
							 		{{str_ireplace("Being further part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being further part payment') !== false)
							 		{{str_ireplace("Being further part payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being payment to the above named Company') !== false)
							 		{{str_ireplace("Being payment to the above named Company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment to the above named company') !== false)
							 		{{str_ireplace("Being payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment') !== false)
							 		{{str_ireplace("Being payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment Recommended') !== false) Being Balance Payment
									{{str_ireplace("Being part payment Recommended", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment recommended') !== false) 
							 		{{str_ireplace("Being part payment recommended", " ", $newDscription)}} 
							 @elseif(stripos($newDscription, 'Being Balance Payment') !== false) 
							 		{{str_ireplace("Being Balance Payment", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment to the above named company') !== false) 
							 		{{str_ireplace("Being additional part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment') !== false) 
							 		{{str_ireplace("Being additional part payment", " ", $newDscription)}}
							 @else
							 		{{$newDscription}}
							 @endif
							
					
						
						<table class="input-sm">
							
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Less {{$list->WHT}}% WHT Payable</div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom:2px solid #000;"> &#8358;{{number_format(($list->WHTValue), 2, '.', ',')}}</div>
								</td>
							</tr>
							
							
							
							
						</table>
						
						<!--<div>I certify that the expenditure was incured in the interest of Public Service.</div>
						<div align="center"><b> (Executive Secretary)</b></div>-->
					</div>

				</td>
				<td rowspan="2"></td>
				<td height="20">
					<b><big>{{number_format(($list->WHTValue), 2, '.', ',')}}</big></b>
					<div class="close-account"></div>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td>
					<div align="left">Checked and Passed for 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span id ="resultTAX"></span>
					</div>
					<br />
				</td>
				<td width="100">Total &#8358;</td>
				<td><big>{{number_format(($list->WHTValue), 2, '.', ',')}}</big></td>
			</tr>	
			<tr>
				<td colspan="5">
					<div class="row">
						<div  align="left" class="col-xs-4">
							<div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
							    <h6>Payable at: <strong>NJC</strong></h6>
								<h6>Initiated By: <strong>@if($approvedBy !=''){{$approvedBy->name}} @endif</strong></h6>
							    <h6>Prepared By: <strong>@if($preparedBy !=''){{$preparedBy->name}}@endif</strong></h6>
							    <h6>Passed By: <strong></strong></h6>
							    <h6>Liability Taken By: <strong>@if($libilityBy !=''){{$libilityBy->name}}@endif</strong></h6>
								<h6>Checked By: <strong>@if($checkBy !=''){{$checkBy->name}} @endif</strong></h6>
								<h6>Audited By:   <strong>@if($auditedBy != '') {{$auditedBy->name}} </strong> @endif </h6>
							    <h6>Station:    <strong>ABUJA</strong></h6>
								<h6>Other Approval    ------------------ </h6>

								<h6>1. ------------------ </h6>
								<h6>2. ------------------------</h6>
								
							</div>
						</div>		
						<div class="col-xs-8" style="font-size: 11px;">
							<span class="text-center">CERTIFICATE</span>
							<div align="left">
								I certify the above amount is correct, and was incurred under the Authority quoted, that the service have been dully performed; that the rate/price charge is according to regulations/contract is fair and reasonable: <br />
								that the amount of <b><span id="resultTAX"></span></b> may be paid under the Classification quote.
							</div>
							<div style="text-decoration: underline;">
								<b>&nbsp;&nbsp; For Executive Secretary &nbsp;&nbsp;</b>
							</div>
							<span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
							<div>
								Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Date: <b style="text-decoration: underline;">&nbsp;&nbsp; {{$list->datePrepared}} &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.) &nbsp;&nbsp;</b>
							</div>
							<br />
							<div align="center">
									<span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GW/{{$list->period}}</b></span>
							</div>
							<span>Anthy AIE No., etc.</span>
						</div>
					</div>
				</td>
			</tr>	
		</tbody>
	</table>
	<div style="margin-top: -20px; font-size: 8px;">
		Received from the Federal Government of Nigeria the sum of <span id="resultTAX2" style="font-size: 8px;"></span> in full settlement of the Account.
		 <small> Date.................{{$list->period}}
		&nbsp;&nbsp;&nbsp;
		Signature..........
		&nbsp;&nbsp;
		Place.............</small>
	</div>
	<br />
</div>
</div>
@endif

<br />



<!----////// End WithHolding Tax Voucher  ---->





<!--- START VAT VOUCHER -->

 @if($list->VATValue >0)
<!--VAT ON VAOUCHER PAYMENT-->
<div class="box-body" id="vat" style="display:; background: #fff;">

<hr class="hidden-print">

<div style="margin: 0 30px;">
	<div class="row">
	 <div class="col-xs-12">
		<div class="box-body">
				<div align="center">
					<h4>
						<div>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</b>
<p><span class="pull-right"><big>
							<select class="type">
							<option>ORIGINAL</option>
							<option>DUPLICATE</option>
							<option>TRIPLICATE</option>
							
							</select>
							</big></span></p><br/>
							<span class="pull-right"><small>Treasury F1</small></span>
						</div>
					</h4>
					<div><h4><b>{{strtoupper('PAYMENT VOUCHER')}}</b></h4></div>
				</div>
				
				<div align="center" style="font-weight: 100">
					Departmental No. <b>{{'NJC/'.$list->economicCode}}/{{$list->vref_no}}/{{date('Y')}}</b>. Checked and passed for payment at <b>Abuja</b>
				</div>
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">
	 	<div class="col-xs-3">

	 		<div align="center" class="visible-print text-center" style="margin-top: -15px" >
				 	
			</div>
	 		<table style="font-size: 10px; margin-top: -25px;">
	 			<tr>
	 				<td><div class="vertical-text v-align-1">For Use in Payment of Advance</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-2">Certified the Advance of</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-3">&#8358; ...........................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-4">has been entered on TF 174 (A) (B) or (C)</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-5">Deptal No:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-6">Signature:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-7">Name in Block Letters ................</div></td>
	 			</tr>
	 		</table>
		 	
	 	</div>
	 	<div class="col-xs-6">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">1 Data Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">VO 1</td>
	 					<td>0</td>
	 					<td>9</td>
	 					<td colspan="2">1</td>
	 					<td>R</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				<!--<tr>
	 					<td height="25"></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td>
	 					<td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td colspan="2"></td> <td></td>
	 				</tr>-->
	 				<tr>
	 					<td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;</td>
	 					<td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
	 				</tr>
	 				<tr>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td colspan="14"><b>&#8358;{{number_format(($list->VATValue), 2, '.', ',')}}</b></td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">
	 						4 Source 4 <br /> 6 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8
	 					</td>
	 					<td colspan="16">49 Classification Code 60</td>
	 				</tr>
	 				<tr style="font-weight: bold;">
	 					<td>0</td>
	 					<td>3</td>
	 					<td>1</td>
	 					<td>8</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td colspan="8">{{'NJC/'.$list->economicCode}}</td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 input-sm">
	 		<table class="table table-bordered input-sm" style="font-size: 9px">
	 			<tr>
	 				<td colspan="2"><div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abuja</div></td>
	 			</tr>
	 			<tr>
	 				<td>Head</td>
	 				<td>18008</td>
	 			</tr>
	 			<tr>
	 				<td>S/Head</td>
	 				<td>{{'NJC/'.$list->economicCode}}</td>
	 			</tr>
	 		</table>
	 		
	 	</div>
	</div>

	<div style="margin-bottom: 2px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			Payee: &nbsp;&nbsp;&nbsp; @if($vatpayee != '') {{$vatpayee->payee}} @endif<span class="input-lg"> </span>
		</div>
	
		<div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; @if($vatpayee != '') {{$vatpayee->address}} @endif<span class="input-lg"><small></small></span>
		</div>
	</div>

	<table class="table table-condensed table-bordered text-center input-sm">
		<thead>
			<tr class="input-lg">
				<th>Date</th>
				<th>Detailed Description of Service/Work</th>
				<th>Rate</th>
				<th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3"> {{$list->datePrepared }}</td>
				<td rowspan="2" width="650">
					<div align="left">
						Being {{$list->VAT}}% of {{number_format($totalPayment,2)}} VAT payable on P.V. NO. NJC/{{$list->economicCode}} /{{$list->vref_no}} /{{date('Y')}} by 
						<b>
							@if($list->contractor != ''){{$list->contractor}} @endif
							@if($list->contractor == ''){{$vatpayee->payee}} @endif
						</b>  
							@php
								//$strArray = explode('Vide', $list->description);
								//$newDscription = $strArray[0];
								$newDscription = $list->paymentDescription;
							@endphp
							@if(stripos($newDscription, 'Being Balance payment to the above named company') !== false)
						 		    {{str_ireplace('Being Balance payment to the above named company', " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Balance payment to the above named')) !== false)
							 		{{str_ireplace("Being Balance payment to the above named", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment to the above named company') !== false)
							 		{{str_ireplace("Being part payment to the above named company", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Part Payment') !== false)
							 		{{str_ireplace("Being Part Payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being further part payment to the above named company') !== false)
							 		{{str_ireplace("Being further part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being further part payment') !== false)
							 		{{str_ireplace("Being further part payment", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment to the above named Company') !== false)
							 		{{str_ireplace("Being payment to the above named Company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment to the above named company') !== false)
							 		{{str_ireplace("Being payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment') !== false)
							 		{{str_ireplace("Being payment", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being part payment Recommended') !== false) Being Balance Payment
									{{str_ireplace("Being part payment Recommended", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being part payment recommended') !== false) 
							 		{{str_ireplace("Being part payment recommended", " ", $newDscription)}} 
							@elseif(stripos($newDscription, 'Being Balance Payment') !== false) 
							 		{{str_ireplace("Being Balance Payment", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment to the above named company') !== false) 
							 		{{str_ireplace("Being additional part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment') !== false) 
							 		{{str_ireplace("Being additional part payment", " ", $newDscription)}}
							@else
							 		{{$newDscription}}
							@endif
						
						
						
						<table class="input-sm">
							
							<tr>
								<td style="border: none !important;" width="200"><div align="left">{{$list->VAT}}% VAT Payable</div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom:2px solid #000;"> &#8358;{{number_format(($list->VATValue), 2, '.', ',')}}</div></td>
							</tr>
							
						</table>
						
						<!--<div>I certify that the expenditure was incured in the interest of Public Service.</div>
						<div align="center"><b>Mr. Gambo Saleh (Executive Secretary)</b></div>-->
					</div>

				</td>
				<td rowspan="2"></td>
				<td height="20">
					<b><big>{{number_format(($list->VATValue), 2, '.', ',')}}</big></b>
					<div class="close-account"></div>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td>
					<div align="left">Checked and Passed for 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span id="resultVAT"></span>
					</div>
					<br />
				</td>
				<td width="100">Total &#8358;</td>
				<td><big>{{number_format(($list->VATValue), 2, '.', ',')}}</big></td>
			</tr>	
			<tr>
				<td colspan="5">
					<div class="row">
						<div  align="left" class="col-xs-4">
							<div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
							    <h6>Payable at: <strong>NJC</strong></h6>
								<h6>Initiated By: <strong>@if($approvedBy !=''){{$approvedBy->name}} @endif</strong></h6>
							    <h6>Prepared By: <strong>@if($preparedBy !=''){{$preparedBy->name}}@endif</strong></h6>
							    <h6>Passed By: <strong></strong></h6>
							    <h6>Liability Taken By: <strong>@if($libilityBy !=''){{$libilityBy->name}}@endif</strong></h6>
								<h6>Checked By: <strong>@if($checkBy !=''){{$checkBy->name}} @endif</strong></h6>
								<h6>Audited By:    <strong> @if($auditedBy != '') {{$auditedBy->name}} @endif </strong> </h6>
							    <h6>Station:    <strong>ABUJA</strong></h6>
								<h6>Other Approval    ------------------ </h6>
								<h6>1. ------------------ </h6>
								<h6>2. ------------------------</h6>
							</div>
						</div>		
						<div class="col-xs-8" style="font-size: 11px;">
							<span class="text-center">CERTIFICATE</span>
							<div align="left">
								I certify the above amount is correct, and was incurred under the Authority quoted, that the service have been dully performed; that the rate/price charge is according to regulations/contract is fair and reasonable: <br />
								that the amount of <b><span id="resultVAT"></span></b> may be paid under the Classification quote.
							</div>
							<div style="text-decoration: underline;">
								<b>&nbsp;&nbsp; For Executive  &nbsp;&nbsp;</b>
							</div>
							<span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
							<div>
								Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Date: <b style="text-decoration: underline;">&nbsp;&nbsp; {{$list->datePrepared}} &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.) &nbsp;&nbsp;</b>
							</div>
							<br />
							<div align="center">
									<span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GW/{{$list->period}}</b></span>
							</div>
							<span>Anthy AIE No., etc.</span>
						</div>
					</div>
				</td>
			</tr>	
		</tbody>
	</table>
	<div style="margin-top: -20px; font-size: 8px;">
		Received from the Federal Government of Nigeria the sum of <span id="resultVAT2" style="font-size: 8px;"></span> in full settlement of the Account.
		 <small> Date.................{{$list->period}}
		&nbsp;&nbsp;&nbsp;
		Signature..........
		&nbsp;&nbsp;
		Place.............</small>
	</div>
</div>




</div>


@endif

<!-- End vat voucher -->





<!--Stamp Duty VAOUCHER PAYMENT-->
@if($list->stampduty > 0)
<div class="box-body" id="stamp" style="display:; background: #fff;">

<hr  class="hidden-print">

<div style="margin: 0 30px;">
	<div class="row">
	 <div class="col-xs-12">
		<div class="box-body">
				<div align="center">
					<h4>
						<div>
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</b>
                                                        <p><span class="pull-right"><big>
							<select class="type">
							<option>ORIGINAL</option>
							<option>DUPLICATE</option>
							<option>TRIPLICATE</option>
							
							</select>
							</big></span></p><br/>
							<span class="pull-right"><small>Treasury F1</small></span>
						</div>
					</h4>
					<div><h4><b>{{strtoupper('PAYMENT VOUCHER')}}</b></h4></div>
				</div>
				
				<div align="center" style="font-weight: 100">
					Departmental No. <b>NJC/{{$list->economicCode}}/{{$list->vref_no}}/{{date('Y')}}</b>. Checked and passed for payment at <b>Abuja</b>
				</div>
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">
	 	<div class="col-xs-3">

	 		<div align="center" class="visible-print text-center" style="margin-top: -15px" >
				 	
			</div>
	 		<table style="font-size: 10px; margin-top: -25px;">
	 			<tr>
	 				<td><div class="vertical-text v-align-1">For Use in Payment of Advance</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-2">Certified the Advance of</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-3">&#8358; ...........................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-4">has been entered on TF 174 (A) (B) or (C)</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-5">Deptal No:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-6">Signature:.............................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-7">Name in Block Letters ................</div></td>
	 			</tr>
	 		</table>
		 	
	 	</div>
	 	<div class="col-xs-6">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">1 Data Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">VO 1</td>
	 					<td>0</td>
	 					<td>9</td>
	 					<td colspan="2">1</td>
	 					<td>R</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				<!--<tr>
	 					<td height="25"></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td>
	 					<td></td> <td colspan="2"></td> <td></td> <td colspan="2"></td> <td colspan="2"></td> <td></td>
	 				</tr>-->
	 				<tr>
	 					<td colspan="8">27 &nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;</td>
	 					<td colspan="12">33 &nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
	 				</tr>
	 				<tr>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td colspan="14"><b>&#8358;{{number_format(($list->stampduty), 2, '.', ',')}}</b></td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">
	 						4 Source 4 <br /> 6 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8
	 					</td>
	 					<td colspan="16">49 Classification Code 60</td>
	 				</tr>
	 				<tr style="font-weight: bold;">
	 					<td>0</td>
	 					<td>3</td>
	 					<td>1</td>
	 					<td>8</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td>1</td>
	 					<td>0</td>
	 					<td>0</td>
	 					<td colspan="8">{{'NJC/'.$list->economicCode}}</td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 input-sm">
	 		<table class="table table-bordered input-sm" style="font-size: 10px">
	 			<tr>
	 				<td colspan="2"><div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abuja</div></td>
	 			</tr>
	 			<tr>
	 				<td>Head</td>
	 				<td>18008</td>
	 			</tr>
	 			<tr>
	 				<td>S/Head</td>
	 				<td>{{'NJC/'.$list->economicCode}}</td>
	 			</tr>
	 		</table>
	 		
	 	</div>
	</div>

	<div style="margin-bottom: 2px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			Payee: &nbsp;&nbsp;&nbsp; FIRS Stamp Duty<span class="input-lg"> </span>
		</div>
	
		<div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; FIRS Stamp Duty, Abuja<span class="input-lg"><small></small></span>
		</div>
	</div>

	<table class="table table-condensed table-bordered text-center input-sm">
		<thead>
			<tr class="input-lg">
				<th>Date</th>
				<th>Detailed Description of Service/Work</th>
				<th>Rate</th>
				<th>&#8358;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;k</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3"> {{date_format(date_create($list->datePrepared), "d-m-Y")}} </td>
				<td rowspan="2" width="650">
					<div align="left">
						Being {{$list->stampdutypercentage}}% of {{number_format($totalPayment,2)}} Stamp Duty deduction on P.V. NO. NJC/{{$list->economicCode}}/ {{$list->vref_no}} /{{date('Y')}} from
						<b>
							@if($list->contractor != ''){{$list->contractor}} @endif
							@if($list->contractor == ''){{$list->payee}} @endif
						</b>  
							@php
								//$strArray = explode('Vide', $list->description);
								//$newDscription = $strArray[0];
								$newDscription   = $list->paymentDescription;
							@endphp 
						 	@if(stripos($newDscription, 'Being Balance payment to the above named company') !== false)
						 		{{str_ireplace('Being Balance payment to the above named company', " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Balance payment to the above named')) !== false)
							 		{{str_ireplace("Being Balance payment to the above named", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment to the above named company') !== false)
							 		{{str_ireplace("Being part payment to the above named company", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being Part Payment') !== false)
							 		{{str_ireplace("Being Part Payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being further part payment to the above named company') !== false)
							 		{{str_ireplace("Being further part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being further part payment') !== false)
							 		{{str_ireplace("Being further part payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being payment to the above named Company') !== false)
							 		{{str_ireplace("Being payment to the above named Company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment to the above named company') !== false)
							 		{{str_ireplace("Being payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being payment') !== false)
							 		{{str_ireplace("Being payment", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment Recommended') !== false) Being Balance Payment
									{{str_ireplace("Being part payment Recommended", " ", $newDscription)}}
							 @elseif(stripos($newDscription, 'Being part payment recommended') !== false) 
							 		{{str_ireplace("Being part payment recommended", " ", $newDscription)}} 
							 @elseif(stripos($newDscription, 'Being Balance Payment') !== false) 
							 		{{str_ireplace("Being Balance Payment", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment to the above named company') !== false) 
							 		{{str_ireplace("Being additional part payment to the above named company", " ", $newDscription)}}
							@elseif(stripos($newDscription, 'Being additional part payment') !== false) 
							 		{{str_ireplace("Being additional part payment", " ", $newDscription)}}
							 @else
							 		{{$newDscription}}
							 @endif
							
					
						
						<table class="input-sm">
							
							<tr>
								<td style="border: none !important;" width="200"><div align="left">Less {{$list->stampdutypercentage}}% Payable</div></td>
								<td style="border: none !important;"><div align="right" style="border-bottom:2px solid #000;"> &#8358;{{number_format(($list->stampduty), 2, '.', ',')}}</div>
								</td>
							</tr>
							
							
							
							
						</table>
						
						<!--<div>I certify that the expenditure was incured in the interest of Public Service.</div>
						<div align="center"><b> (Executive Secretary)</b></div>-->
					</div>

				</td>
				<td rowspan="2"></td>
				<td height="20">
					<b><big>{{number_format(($list->stampduty), 2, '.', ',')}}</big></b>
					<div class="close-account"></div>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td>
					<div align="left">Checked and Passed for 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span id ="resultTAX"></span>
					</div>
					<br />
				</td>
				<td width="100">Total &#8358;</td>
				<td><big>{{number_format(($list->stampduty), 2, '.', ',')}}</big></td>
			</tr>	
			<tr>
				<td colspan="5">
					<div class="row">
						<div  align="left" class="col-xs-4">
							<div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
							    <h6>Payable at: <strong>NJC</strong></h6>
								<h6>Initiated By: <strong>@if($approvedBy !=''){{$approvedBy->name}} @endif</strong></h6>
							    <h6>Prepared By: <strong>@if($preparedBy !=''){{$preparedBy->name}}@endif</strong></h6>
							    <h6>Passed By: <strong></strong></h6>
							    <h6>Liability Taken By: <strong>@if($libilityBy !=''){{$libilityBy->name}}@endif</strong></h6>
								<h6>Checked By: <strong>@if($checkBy !=''){{$checkBy->name}} @endif</strong></h6>
								<h6>Audited By:   <strong> @if($auditedBy != '') {{$auditedBy->name}} @endif </strong> </h6>
							    <h6>Station:    <strong>ABUJA</strong></h6>
								<h6>Other Approval    ------------------ </h6>

								<h6>1. ------------------ </h6>
								<h6>2. ------------------------</h6>
								
							</div>
						</div>		
						<div class="col-xs-8" style="font-size: 11px;">
							<span class="text-center">CERTIFICATE</span>
							<div align="left">
								I certify the above amount is correct, and was incurred under the Authority quoted, that the service have been dully performed; that the rate/price charge is according to regulations/contract is fair and reasonable: <br />
								that the amount of <b><span id="resultTAX"></span></b> may be paid under the Classification quote.
							</div>
							<div style="text-decoration: underline;">
								<b>&nbsp;&nbsp; For Executive Secretary &nbsp;&nbsp;</b>
							</div>
							<span style=" font-style: italic;">Signature of Officer Contr. Expenditure</span>
							<div>
								Place: <b style="text-decoration: underline;">&nbsp;&nbsp; Abuja &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Date: <b style="text-decoration: underline;">&nbsp;&nbsp; {{$list->datePrepared}} &nbsp;&nbsp;</b> 
								&nbsp;&nbsp;&nbsp;&nbsp;
								Designation: <b style="text-decoration: underline;">&nbsp;&nbsp; D. (Accts.) &nbsp;&nbsp;</b>
							</div>
							<br />
							<div align="center">
									<span><b>GW/SW &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; GW/{{$list->period}}</b></span>
							</div>
							<span>Anthy AIE No., etc.</span>
						</div>
					</div>
				</td>
			</tr>	
		</tbody>
	</table>
	<div style="margin-top: -20px; font-size: 8px;">
		Received from the Federal Government of Nigeria the sum of <span id="resultTAX2" style="font-size: 8px;"></span> in full settlement of the Account.
		 <small> Date.................{{$list->period}}
		&nbsp;&nbsp;&nbsp;
		Signature..........
		&nbsp;&nbsp;
		Place.............</small>
	</div>
	<br />
</div>
</div>

<br />

@endif

<!----////// End Stamp Duty Voucher  ---->







	@if($count > 0)
<div class="box-body" id="bene" style=" background: #fff;margin-top: 30px;" >
    <h3 class="text-center">BENEFICIARIES:{{$discr}}</h3>
<div class="col-md-12">


<table id="myTables" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Beneficiary </th>
              <th class="text-center">Amount ( &#8358;)</th>
              
             
            </tr>
          </thead>
          <tbody>
            @php $key = 1; $totalAmt = 0; @endphp
         @foreach($staff as $s)
          <tr>
            
            <td>{{$key++}}</td>
            @if($s->remarks != '')
            <td>{{$s->beneficiaryDetails}} ({{$s->remarks}}) </td>
            @else
            <td>{{$s->beneficiaryDetails}} </td>
            @endif
            <td class="" align="right"><?php $totalAmt += $s->amount; ?>{{number_format($s->amount,2)}}</td>
            
           
          </tr>

         @endforeach
          <tr>
              <td> <strong>TOTAL</strong></td>
              <td colspan="2" align="right"> <strong> {{number_format($totalAmt,2)}} </strong></td>
          </tr>
          </tbody>
        </table>

   </div>
 </div>
 @endif
<hr class="hidden-print">
<br />	<br />


<!-- print and back buttons -->

<div class="button-wrapper hidden-print" style="margin-bottom: 30px; margin-top:0px;">

	<div class="col-md-2">
		<a href="{{ URL::previous() }}" class="btn btn-success">Go Back</a>
	</div>
	<div class="col-md-2 col-md-offset-8">
		<a href="javascript:void(0)" class="btn btn-success print-window">Print</a>
	</div>

</div>
<!-- End print and back buttons -->



<!--- END VAT VOUCHER --->


@stop


@section('styles')

  <style type="text/css">
  	.table td{
    border: #030303 solid 1px !important;
    padding: 2px;
    font-size: 11px;
	}
	.table th{
    border: #030303 solid 1px !important;
	}



.v-align-1 {
    margin-top: -150px;
    margin-left: -240px;
    width: 500px!important;
}
.v-align-2 {
    margin-top: -150px;
    margin-left: -220px;
    width: 500px !important;
}
.v-align-3 {
    margin-top: -150px;
    margin-left: -200px;
    width: 500px !important;
}
.v-align-4 {
    margin-top: -150px;
    margin-left: -180px;
    width: 500px !important;
}
.v-align-5 {
    margin-top: -150px;
    margin-left: -160px;
    width: 500px !important;
}
.v-align-6 {
    margin-top: -150px;
    margin-left: -140px;
    width: 500px !important;
}
.v-align-7 {
    margin-top: -520px margin-left: -120px;
    width: 200px !important;

}

.vertical-text {
    transform: rotate(270deg);
    transform-origin: left bottom 1;
    -moz-transform: rotate(270deg);
    -o-transform: rotate(270deg);
    -webkit-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    -sand-transform: rotate(270deg);
}
.vert-text 
{ 
 margin-top:40px;
 border:1px solid #333;
}
.type
{
border:0px;
  outline:0px;
  text-align:right;
  float:right;
  -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
    padding-right:0px;
    
}
  </style>
@stop

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
  <script type="text/javascript">


  	$('.print-window').click(function() {
    window.print();
    });

  	//Remove record
	$(document).ready(function() {
	  	$(".removeRow").click(function () {
	  		var id = this.id;
	  		var result = confirm('Are you sure you want to delete the seleted record ?');
	  		if (result) {
		  		$.ajax({
					url: murl +'/staff-list/voucher/delete/JSON',
					type: "post",
					data: {'staffIdList': id, '_token': $('input[name=_token]').val()},
					success: function(data){
						location.reload();
					}
				})
	  		}
		});   
	 });
	// END REMOVE

	//EDIT STAFF BANK DETAILS BY CPO
	$(document).ready(function() {
	  	$(".editBankDetailsButton").click(function () {
	  		var id 		 		= this.id;
	  		var bankName 		= $('#bankName'+id).val();
	  		var accountNumber 	= $('#accountNumber'+id).val();
	  		var sortCode 		= $('#sortCode'+id).val();
	  		var staffAmount 	= $('#staffAmount'+id).val();
	  		if(result){
		  		$.ajax({
					url: murl + '/recurrent/update/bank-details-JSON',
					type: "post",
					data: {'id': id, 'bankName': bankName, 'accountNumber': accountNumber, 'sortCode': sortCode, 'staffAmount': staffAmount, '_token': $('input[name=_token]').val()},
					success: function(data){
						location.reload();
					}
				})
	  		}
		});   
	 });
	//CPO

	//SELECT/DESELECT ALL CHECKBOX
	$(document).ready(function () {
        $('#globalCheckbox').click(function(){
            if($(this).prop("checked")) {
                $(".checkBox").prop("checked", true);
            } else {
                $(".checkBox").prop("checked", false);
            }                
        });
    });

</script>
<!--Convert Number to word --> 
<script type="text/javascript"> 
    var amount = "";
    var amount = "<?php echo number_format($amtpayable, 2, '.', '') ; ?>";
    var money = amount.split('.');//
    
    //VAT
    var amountVAT = "";
    var amountVAT = "<?php echo number_format($list->VATValue, 2, '.', '') ;  ?>";
    var moneyVAT = amountVAT.split('.');

    //TAX
    var amountTAX = "";
    var amountTAX = "<?php echo number_format($list->WHTValue, 2, '.', '') ;  ?>";
    var moneyTAX = amountTAX.split('.');

    function lookup()
    {
    	//Main Voucher
       	var words;
        var naira = money[0];
        var kobo = money[1];            
        var word1 = toWords(naira)+"naira";
        var word2 = ", "+toWords(kobo)+" kobo";
        if(kobo != "00")
            words = word1 + word2;
        else
            words = word1;
        //
        	 var getWord = words.toUpperCase();
			 var parternRule1 = /HUNDRED AND NAIRA/ig;
			 var parternRule2 = /HUNDRED AND THOUSAND NAIRA/ig;
			 var instance1 = parternRule1.test(getWord);
			 var instance2 = parternRule2.test(getWord);
			 if((instance1))
			 {
			 	document.getElementById('result').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 	document.getElementById('result2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 }else if((instance2))
			 {
			 	document.getElementById('result').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 	document.getElementById('result2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 }else
			 {
			  	document.getElementById('result').innerHTML = getWord;
			  	document.getElementById('result2').innerHTML = getWord;
			 }
		//        
        
        //VAT
        var wordVATs;
        var naira = moneyVAT[0];
        var kobo = moneyVAT[1];            
        var word1 = toWords(naira)+"naira";
        var word2 = ", "+toWords(kobo)+" kobo";
        if(kobo != "00")
            wordVATs = word1 + word2;
        else
            wordVATs = word1;
         //
        	 var getWord = wordVATs.toUpperCase();
			 var parternRule1 = /HUNDRED AND NAIRA/ig;
			 var parternRule2 = /HUNDRED AND THOUSAND NAIRA/ig;
			 var instance1 = parternRule1.test(getWord);
			 var instance2 = parternRule2.test(getWord);
			 if((instance1))
			 {
			 	document.getElementById('resultVAT').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 	document.getElementById('resultVAT2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 }else if((instance2))
			 {
			 	document.getElementById('resultVAT').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 	document.getElementById('resultVAT2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 }else
			 {
			  	document.getElementById('resultVAT').innerHTML = getWord;
			  	document.getElementById('resultVAT2').innerHTML = getWord;
			 }
		//     

        //TAX
        var wordTAXs;
        var naira = moneyTAX[0];
        var kobo = moneyTAX[1];            
        var word1 = toWords(naira)+"naira";
        var word2 = ", "+toWords(kobo)+" kobo";
        if(kobo != "00")
            wordTAXs = word1 + word2;
        else
            wordTAXs = word1;
        //
        	 var getWord = wordTAXs.toUpperCase();
			 var parternRule1 = /HUNDRED AND NAIRA/ig;
			 var parternRule2 = /HUNDRED AND THOUSAND NAIRA/ig;
			 var instance1 = parternRule1.test(getWord);
			 var instance2 = parternRule2.test(getWord);
			 if((instance1))
			 {
			 	document.getElementById('resultTAX').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 	document.getElementById('resultTAX2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 }else if((instance2))
			 {
			 	document.getElementById('resultTAX').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 	document.getElementById('resultTAX2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 }else
			 {
			  	document.getElementById('resultTAX').innerHTML = getWord;
			  	document.getElementById('resultTAX2').innerHTML = getWord;
			 }
		//     
    
    }
</script>

<script>
    $(document).ready(function () {
        $('.print-voucher').change(function(){
            if($(this).val() == 'rem') {
                $("#main, #tax, #vat, #stamp, #bene, #prem").hide();
                $("#rem").show();
            } else if($(this).val() == 'main') {
                $("#rem, #tax, #vat, #stamp, #bene, #prem").hide();
                $("#main").show();
            }   
            else if($(this).val() == 'tax') {
                $("#rem, #main, #vat, #stamp, #bene, #prem").hide();
                $("#tax").show();
            } 
            else if($(this).val() == 'vat') {
                $("#rem, #main, #tax, #stamp, #bene, #prem").hide();
                $("#vat").show();
            } 
            else if($(this).val() == 'stamp') {
                $("#rem, #main, #tax, #vat, #bene, #prem").hide();
                $("#stamp").show();
            } 
            
             else if($(this).val() == 'bene') {
                $("#rem, #main, #tax, #vat, #stamp, #prem").hide();
                $("#bene").show();
            } 
            else if($(this).val() == 'prem') {
                $("#rem, #main, #tax, #vat, #stamp, #bene").hide();
                $("#prem").show();
            } 
             
            else if($(this).val() == 'all') {
                $("#rem, #main, #tax, #vat,#all, #prem").show();
            }
            else if($(this).val() == '') {
                $("#rem, #main, #tax, #vat,#all").show();
            }
        });
    });
</script>
@stop