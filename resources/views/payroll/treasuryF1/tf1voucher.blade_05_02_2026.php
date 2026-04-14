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



<!--PAYMENT VOUCHER-->
<div class="box-body" id="main" style="background: #fff;">
<div style="margin: 0 10px;">
	<div class="row">
	 <div class="col-xs-12">
		<div class="box-body">
				<div class="row">
				    <div class="col-xs-10">
				        <div align="center">
							<h4><b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</b></h4>
							<h4><b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{strtoupper('PAYMENT VOUCHER')}}</b></h4>
							<h5 style="padding-bottom: 10px;"> <b> {{$selectedWorkingstate ? "CURRENT WORKING STATE ".$selectedWorkingstate->State : ''}} </b></h5>
						</div>
				    </div>
				    <div class="col-xs-2">
				        <p>
				            <span>
    				            <big>
        							<select class="type">
            							<option>ORIGINAL</option>
            							<option>DUPLICATE</option>
            							<option>TRIPLICATE</option>
            							<option>QUADRUPLICATE</option>
            							<option>QUINTUPLICATE</option>
            							<option>SEXTUPLICATE</option>
        							</select>
    							</big>
						    </span>
						</p><br/>
						<div class="clearfix"></div>
						<span class="pull-right">
							<small> Treasury F1</small>
						</span>
				    </div>
				</div>
				<div align="center" style="font-weight: 100">
					Deptal No <b>..NICN/P/............../.........</b> Checked and passed for payment of.......................
				</div>
		</div>
	  </div>
	</div>
	<div class="row">
	 	<div class="col-xs-2 sidetblock" style="top: 120px;">
	 		<div align="center" class="visible-print text-center">

			</div>
	 		<table style="font-size: 10px; margin-left: 4px;">
	 			<tr>
	 				<td><div class="vertical-text v-align-1">For Use in Payment of Advance</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-2">Certified the Advanced of</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-3">No.........................................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-4">Has been entered on TF 174 (A) (B) OR (C)</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-5">Deptal No:.................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-6">Signature:.................</div></td>
	 			</tr>
	 			<tr>
	 				<td><div class="vertical-text v-align-7">Name in Block Letters .................</div></td>
	 			</tr>
	 		</table>
	 	</div>

	 	<div class="col-xs-7" style="top: -6px;">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">Date Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="5">VO 1</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td colspan="2">R</td>
	 					<td colspan="2">E</td>
	 					<td colspan="2">X</td>
	 					<td colspan="2">I</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				<tr height="25">
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="8">27 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date &nbsp;&nbsp;&nbsp; 32 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	 					<td colspan="12">33 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;45</td>
	 				</tr>
	 				<tr>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td>&nbsp;</td>
	 					<td colspan="12" class="text-center"><b>&#8358;{{number_format(($totalSum), 2, '.', ',')}}</b></td>
	 					<td colspan="2">&nbsp;</td>
	 				</tr>
	 				<tr>
	 					<td colspan="3">
	 						<div class="row"><div class="col-md-12"> 4 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; 4 </div></div>
	 						<div class="row"><div class="col-md-12" align="center"> Source </div></div>
	 					<div class="row"><div class="col-md-12"> 6 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; 8 </div></div>
	 					</td>
	 					<td colspan="17">49 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 60</td>
	 				</tr>
	 				<tr height="25">
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					<td colspan="4"></td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 input-sm">
	 		<table class="table table-bordered input-sm" style="font-size: 9px">
	 			<tr>
	 				<td colspan="3"><div>Station &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$divisionName ? $divisionName : 'ABUJA'}}</div></td>
	 			</tr>
	 			<tr>
	 				<td>Head</td>
					<td>41</td>
	 				<td>031</td>
	 			</tr>
	 			<tr>
	 				<td>S/Head</td>
	 				<td>205</td>
	 			</tr>
	 			</table>

	 	</div>
	</div>

	<div style="margin-bottom: 8px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			Payee: &nbsp;&nbsp;&nbsp; <span class="input-lg">{{$reportTitle->desc}}</span><span>{{$selectedWorkingstate ? ucfirst($selectedWorkingstate->State)." (BIRS)" : ''}}</span>
		</div>
		<br/>
	   	<div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; <span class="input-lg"><small></small> {{$reportTitle->desc == 'PAYE' ? $selectedWorkingstate->State : optional($reportTitle)->address}} </span>
		</div>
	</div>

	<table class="table table-condensed table-bordered text-center input-sm">
		<thead>
			<tr class="input-lg">
				<th>Date</th>
				<th>Detailed Description of Service/Work</th>
				<th width="50">Rate</th>
				<th>&#8358;</th>
				<th>k</th>
			</tr>
		</thead>
		<tbody>
		    <!--@php $getKobo = substr(substr(($totalSum - (int) $totalSum), 2), 0, 2); @endphp-->
		    @php $getKobo = $totalSum - floor($totalSum); @endphp
			<tr>
				<td rowspan="3" width="90"> {{date("d-m-Y")}}</td>
				<td rowspan="2" width="700">
					<div align="left">
					    Being Payment to the above named Organisation being
                          <strong>{{$reportTitle -> desc}}</strong>
                          deduction made from the salary of
                          <Strong>{{$record -> fullname}}</strong>
                          {{ $getStatus }}
                          for the month of {{$month}} &nbsp;&nbsp; {{$selectedYear}}<br />

						<div>I certify that the expenditure was incured in the interest of Public Service.</div>
					</div>
				</td>
				<td rowspan="2"></td>
				<td width="150">
					<b><big>{{number_format(((int)$totalSum), 0)}}</big></b>
					<div class="close-account"></div>
				</td>

				<td width="50"> {{ $getKobo ? round($getKobo, 2) * 100 : '00' }} </td>
			</tr>
			<tr>
				<td><div class="linedia"></div></td>
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
				<td width="200">Total &#8358;</td>
				<td><big> {{number_format(((int)$totalSum), 0)}} </big></td>
				<td><big>{{ $getKobo ? round($getKobo, 2) * 100 : '00' }}</big></td>
			</tr>
			<tr>
				<td colspan="5">
					<div class="row">
						<div  align="left" class="col-xs-4">
							<div style="font-size: 16px; border:2px solid #ddd !important; padding: 0 2px;">
							    <h6>Payable at:.......................................<strong></strong></h6>
							    <h6>Signature:........................................<strong></strong></h6>
							    <h6>Name in Block Letters:..........................................<strong></strong></h6>
							    <h6>Station:.......................Date...............<strong></strong></h6>
							    <h6>Paying Officer's Signature:........................................<strong></strong></h6>
								<h6>Name in Block Letters:.............................................<strong></strong></h6>
								<div align="center">GW/SW</div>
								<div align="center"><big>Anthy. AIE NO. Etc</big></div>
							</div>
						</div>
						<div class="col-xs-8" style="font-size: 11px;">
							<span class="text-center">CERTIFICATE</span>

							<div align="left">
								I certify the above amount is correct, and was incurred under the Authority quoted, that the service have been duly performed; that the rate/price charge is
								according to regulations/contract is fair and reasonable; <br />
								that the amount of ......<b><span id="result2"></span></b>..... may be paid under the Classification quoted.
							</div><br />

							<div>......................................................................................</div>
							<div style=" font-style: italic;">Signature of Officer Contr. Expenditure</div>

							<br />

							<div>
								Place: <b style="text-decoration: underline;"> &nbsp;&nbsp; Abuja &nbsp;&nbsp; </b>
								&nbsp;&nbsp;&nbsp;&nbsp;
								Date: <b style="text-decoration: underline;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
								&nbsp;&nbsp;&nbsp;&nbsp;
								Designation: <b style="text-decoration: underline;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
							</div>

						    <br />

                        </div>
					</div>
					<div style="font-size: 12px;" align="center">
					    <br />
						Received from the Federal Government of Nigeria the sum of
						<span id="result2" style="font-size: 8px;"></span> in full settlement of the Account.
						<small> Date.................{{$selectedYear}}
    						&nbsp;&nbsp;&nbsp;
    						Signature..........
    						&nbsp;&nbsp;
    						Place.............
						</small>
					</div>
					<<br />
					<div align="center"> N &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; K  &nbsp;&nbsp;&nbsp;&nbsp; Date.......................20................. &nbsp;&nbsp;&nbsp;&nbsp;   Place.................</div>
				</td>
			</tr>
		</tbody>
	</table>

</div>
</div>



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
    var amount = "<?php echo number_format($totalSum, 2, '.', '') ; ?>";
    var money = amount.split('.');//



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