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
							<option value="prem">TRAVEL DETAIL</option>

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
	  						<th><div align="center">{{number_format(($list->totalPayment), 2, '.', ',')}}</div></th>
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
						<div class="make-bold">
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<h4 class="text-center">{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</h4>
							@if($list->contractTypeID == 4)
							<div><h4 class="text-center">{{strtoupper('CAPITAL EXPENDITURE PAYMENT VOUCHER')}}</h4></div>
							<div><h4 class="text-center">{{strtoupper('CAPITAL BUDGET ONLY')}}</h4></div>
							@else
							<div><h4><b>{{strtoupper('PAYMENT VOUCHER')}}</b></h4></div>
							@endif
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
							<div class="clearfix"></div>
							<span class="pull-right"><small>

							Treasury F5


							</small></span><br/>
                            <span class="pull-right hidden-print"><small><span  style="color:green;">STATUS: </span>@if($list->status == 6){{PAID}}@else{{$status->description}}@endif</small></span>
						</div>
					</h4>

				</div>

				<div align="center" style="font-weight: 100">
					Departmental No. <b>FHC/OC/{{$list->vref_no}}/{{date('Y')}}</b>. <b></b>
				</div>
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">

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
	 					@if($list->contractTypeID == 4)
	 					<td>C</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					@else
	 					<td>R</td>
	 					<td>E</td>
	 					<td>X</td>
	 					<td>1</td>
	 					@endif
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




	<div class="coll-md-12" style="margin-bottom: 2px; margin-top:30px;">
	    <table style="width:100%">
	        <tr style="margin-bottom:30px;">
	            <td style="width:65%;">
	                <div style="width:28%; float:left;">
			Allowances of Mr/Mrs/Miss:
			</div>
			<div style="width:70%; float:left; border-bottom: 1px dotted #444;" >
			{{ $beneficiary->beneficiaryDetails }}
			&nbsp;&nbsp;
		</div>
	            </td>
	            <td style="width:35%;">
	       <div class="" style="width:35%; float:left;">
			For the month of :
			</div>
			<div style="text-decoration: none; border-bottom: 1px dotted #444; width:65%; float:left;">
			    {{\Carbon\Carbon::parse($list->datePrepared)->format('F Y')}}
			 &nbsp;&nbsp;
			</div>

	            </td>
	        </tr>

	    </table>
	    <table style="width:100%; margin-top:30px;">

	        <tr>
	            <td style="width:50%;"><div class="">
		<div style="text-decoration: none; border-bottom: 1px dotted #444;" class="">
		&nbsp;
		</div>
		<p class="text-center">Financial Authority</p>
		</div></td>
	            <td>

	                <div  class="">
		<div style="text-decoration: none; border-bottom: 1px dotted #444;padding-left:10px; margin-left:20px;">
			Signed: &nbsp;&nbsp;&nbsp;
		</div>
		<p class="text-center">Head of Dept. or Departmental Senior Officer </p>
	    </div>

	            </td>
	        </tr>

	    </table>


	</div>
	<hr style="border:2px solid #333;"/>

    <h2 class="text-center" style="font-size:18px; font-weight:700">TRAVELLING ALLOWANCE CERTIFICATE</h2>

    <div style="font-size:15px; line-height:34px;">
        I CERTIFY on honour (a) That the above claim is correct and that i actually travelled on Government duty for the periods dated <br/>
        (a) That the amount of my claim does not exceed the rates authorised for my grade <br/>
        (b) That during this period for which travelling allowance is now claimed. I did not stay as the guest of another Government Officer.
    </div>

    <table style="width:100%">
        <tr>
            <td style="width:15%;">
            <div class="" style="width:22%; float:left;">
			 Rank
			</div>
			<div style="text-decoration: none; border-bottom: 1px dotted #444; width:78%; float:left;">
			&nbsp;&nbsp;
			</div>
            </td>
            <td style="width:35%;padding-left:20px;">
            <div class="" style="width:30%; float:left;">
			 Rate of Salary
			</div>
			<div style="text-decoration: none; border-bottom: 1px dotted #444; width:70%; float:left;">
			&nbsp;&nbsp;
			</div>
            </td>
            <td style="width:46%; padding-left:3%">
               <div class="">
                   &nbsp;&nbsp;
		<div style="text-decoration: none; border-bottom: 1px dotted #444;" class="">
		&nbsp;
		</div>
		<p class="text-center">Signature of Officer claiming Allowances</p>
		</div>
            </td>
        </tr>
    </table>
    <hr style="border:2px solid #333;"/>

<div style="margin-bottom:20px; font-size:16px;">
    Received this <strong>{{\Carbon\Carbon::parse($list->datePrepared)->format('d')}}</strong> day of <strong>{{\Carbon\Carbon::parse($list->datePrepared)->format('F Y')}}</strong> the sum of <span id="wordsAmount"></span> in settlement of the above claim
</div>
<div class="col-md-6 pull-right">
    <div style="text-decoration: none; border-bottom: 1px dotted #444;"></div>
    <p class="text-center">Signature of Claimant</p>
</div>



</div>
</div>
<!---////////////////////// End PAYMENT VOUCHER-->

<!-- --------  Details of travelling ------------->

<div class="col-md-12" id="prem" style="background:#FFF;">
    <h1 class="text-center" style="font-size:20px; font-weight:700;">DETAILS OF TRAVELLING FOR THE MONTH</h1>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Departure Place</th>
                <th>Arrival Place</th>
                <th>Nature of Duty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
            $k = 1;
            $sumValue = 0;
            @endphp
            @foreach($details as $l)
            <tr>
            <td>{{$k++}}</td>
            <td>{{$l->departure_place}}</td>
            <td>{{$l->arrival_place}}</td>
            <td>{{$l->nature_of_duty}}</td>
            <td><?php $sumValue +=$l->amount; ?>{{number_format($l->amount,2)}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>TOTAL</strong></td>
                <td><strong>{{number_format($sumValue,2)}}</strong></td>
            </tr>
        </tbody>
    </table>
</div>


<!---///////////// End details of traveling -------->


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
.tf
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
.make-bold h4
{
    font-weight:700;
}
.left-col
{
    width:32%;
    float:left;
}
.right-col
{
    width:60%;
    float:left;
}
  </style>
@stop

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/js/newNumberToWords.js') }}"></script>
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
<<!--Convert Number to word -->
<script type="text/javascript">
    var amount = "";
    var amount = "<?php echo number_format($sumValue, 2, '.', '') ; ?>";
    var money = amount.split('.');//

    //VAT
    var amountVAT = "";
    var amountVAT = "<?php ?>";
    var moneyVAT = amountVAT.split('.');

    //TAX
    var amountTAX = "";
    var amountTAX = "<?php   ?>";
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
			 	document.getElementById('wordsAmount').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 	document.getElementById('result2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 }else if((instance2))
			 {
			 	document.getElementById('wordsAmount').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 	document.getElementById('result2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 }else
			 {
			  	document.getElementById('wordsAmount').innerHTML = getWord;
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
