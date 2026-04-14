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
/* 
@media print {
  .print-voucher
  {
      display:none;
      
  }
  #vref
  {
      border:none;
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
  } */
</style>


<!--JOURNAL -->

<!--PAYMENT VOUCHER-->
<div class="box-body" id="main" style="background: #fff;"> 
<div style="margin: 0 10px;">
	<div class="row">
	<form action="/create/paying-in-form" method="POST">
			{{ csrf_field() }}
	 <div class="col-xs-12">
		<div class="box-body">
				<div align="center">
					<h4>
						<div class="make-bold">
							 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<h4 class="text-center">{{strtoupper('FEDERAL GOVERNMENT OF NIGERIA')}}</h4>
							
							<div><h4><b>{{strtoupper('PAYING-IN-FORM')}}</b></h4></div>
						
							<p><span class="pull-right"><big>
							{{-- <select class="type">
                                <option>ORIGINAL</option>
                                <option>DUPLICATE</option>
                                <option>TRIPLICATE</option>
                                <option>QUADRUPLICATE</option>
                                <option>QUINTUPLICATE</option>
                                <option>SEXTUPLICATE</option>
							</select> --}}
							</big></span></p><br/>
							<div class="clearfix"></div>
							<span class="pull-right"><small> Treasury F1 </small></span><br/>
                            <span class="pull-right"><small> (Revised)</small></span>
						</div>
					</h4>
					
				</div>
				
		</div>
	  </div>
	</div>
	<div class="row" style="margin-top: -3px;">
		<div style="font-weight: 100; padding-left:15px;">
			Departmental No. <b>NJC/PE/<input type="text" class="noborder" datePrepaid="{{date_format(date_create($personnelVoucher->approvalDate), "Y")}}" style="border:none; width:50px !important;" transid="{{$personnelVoucher->ID}}" id="vref" name="vref" value="@if($vRef) {{$vRef}} @elseif($transactionRef) {{$transactionRef}} @endif" />/{{date('Y', strtotime(trim($personnelVoucher->approvalDate)))}}</b>. Checked and passed for payment at <b>Abuja</b>
		</div>
	
	 	{{-- <div class="col-xs-3 sidetblock">
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
		 	
	 	</div> --}}

	 	<div class="col-xs-6 col-lg-8">
	 		<table class="table table-bordered text-center table-condensed" style="font-size: 10px">
	 			<tbody>
	 				<tr>
	 					<td colspan="4">Date Type 3</td>
	 					<td colspan="4">4 Source 6</td>
	 					<td colspan="12">7 &nbsp;&nbsp;  Voucher Number &nbsp; &nbsp;  14</td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">VO 1</td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="2"></td>
	 					
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td>2</td>
	 				
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 					<td colspan="2"></td>
	 				</tr>
	 				<tr>
	 					<td colspan="20">15 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Classification &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
	 				</tr>
	 				
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
	 					<td colspan="14"><b>&#8358;{{number_format(($personnelVoucher->contractValue), 2, '.', ',')}}</b></td>
	 				</tr>
	 				<tr>
	 					<td colspan="4">
                            
	 						6 Source 5 <br />  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	 					</td>
                        <td>49</td> 
	 					<td colspan="14"> 
                             Classification Code 
                        </td>
                        <td>60</td> 
	 				</tr>
	 				<tr style="font-weight: bold;">
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td></td>
	 					<td colspan="8"> {{substr($economicHead,0,4)}}  {{$personnelVoucher->economicCode}} </td>
	 				</tr>
	 			</tbody>
	 		</table>
	 	</div>
	 	<div class="col-xs-3 col-lg-4 input-sm">
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
	 				<td> {{substr($economicHead,0,4)}}  {{$personnelVoucher->economicCode}} </td>
	 			</tr>
	 			</table>
	 				
	 	</div>
	</div>

	<div style="margin-bottom: 2px;">
		<div style="text-decoration: none; border-bottom: 2px dotted #000;">
			<strong style="font-size: 18px;">To Sub-Accountant:</strong> &nbsp;&nbsp;&nbsp; <span class="input-lg">
			    {{$personnelVoucher->payee_address}}
			</span>
		</div>

	    <?php $amtpayable = $personnelVoucher->contractValue; ?>


        <div style="text-decoration: none; border-bottom: 2px dotted #000;">
			 <strong style="font-size: 18px;">Please receive the sum of:</strong> &nbsp;&nbsp;&nbsp; <span class="input-lg">
			     <span id="result"></span>
			</span>
		</div>

        <div style="text-decoration: none; border-bottom: 2px dotted #000; word-wrap: break-word;">
			<strong style="font-size: 18px;">Being:</strong> &nbsp;&nbsp;&nbsp; <span class="input-lg">
			    {{$personnelVoucher->ContractDescriptions}}
			</span>
		</div>
        
	
		{{-- <div style="text-decoration: none;border-bottom: 2px dotted #000;">
			Address: &nbsp;&nbsp;&nbsp; <span class="input-lg"><small>
			{{$personnelVoucher->payee_address}}
			</small></span>
		</div> --}}

        <div class="row payingFooter" style="margin-top:80px;">
            <div class="col-lg-5 footer1">
                {{-- <div style="text-decoration: none; border-bottom: 2px dotted #000;"> --}}
					<strong style="text-align:center;">.................................................20...................</strong>
                {{-- </div> --}}
            </div>
            <div class="col-lg-2"></div>

            <div class="col-lg-5 footer2">
                {{-- <div style="text-decoration: none; border-bottom: 2px dotted #000;"> --}}
					<strong style="text-align:center;">....................................................................................<br>
					 (Signature/Mark of Payer) </strong>
                {{-- </div> --}}
                
            </div>
        </div>

        <div class="row payingFooter2" style="margin-top:60px;">
            <div class="col-lg-7"></div>

            <div class="col-lg-5 footer3">
                {{-- <div style="text-decoration: none; border-bottom: 2px dotted #000;"> --}}
					<strong style="text-align:center;">.....................................................................................<br>
					Witness to Mark</strong>
                {{-- </div> --}}
                
            </div>
        </div>

	</div>


	<div class="row footer4">
		<div style="margin-top: 20px;"  class="vMainPage">
			Person making this payment is to be given a receipt from a book of numbered Receipt and to sign Counterfoil Book
	   
	   </div>
	</div>
	
	

	<div class="row">
	<div class="col-md-4 goBack">
        <div class="form-group">
            <label for=""></label>
            <div align="left">
				<a href="/create/paying-in-form" class="btn btn-warning">Go back</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 createVoucher">
        <div class="form-group">
            <label for=""></label>
            <div align="center">
				
                    <input type="hidden" name="cID" value="{{$personnelVoucher->ID}}">
                    <input type="hidden" name="fileno" value="{{$personnelVoucher->fileNo}}">
                    <input type="hidden" name="contracttype" value="{{$personnelVoucher->contract_Type}}">
                    <input type="hidden" name="cDesc" value="{{$personnelVoucher->ContractDescriptions}}">
                    <input type="hidden" name="cValue" value="{{$personnelVoucher->contractValue}}">
                    <input type="hidden" name="cBene" value="{{$personnelVoucher->beneficiary}}">
                    <input type="hidden" name="cName" value="{{$personnelVoucher->name}}"> 
                    <input type="hidden" name="eco_code" value="{{$personnelVoucher->eco_code}}">
                    <input type="hidden" name="awaitActBy" value="{{$personnelVoucher->awaitingActionby}}">
					<input type="hidden" name="payee_address" value="{{$personnelVoucher->payee_address}}">
					<?php $cIdExists = DB::table('tblpaymentTransaction')->where('contractID', $personnelVoucher->ID)->first();?>
					@if (!$cIdExists)
                    	<button type="submit" name="savePayin" class="btn btn-success">Process</button>
					@endif
                
            </div>
        </div>
    </div>
	</form>

	<div class="col-md-4 print-voucher">
        <div class="form-group">
            <label for=""></label>
            <div align="right">
				<a href="javascript:void(0)" class="btn btn-primary print-window">Print</a>
            </div>
        </div>
    </div>
	</div>

</div>
</div>
<!---////////////////////// End PAYMENT VOUCHER-->


<!--- END VAT VOUCHER --->

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

@media print {
  .print-voucher
  {
      display:none;   
  }
  .goBack{
	display:none;
  }
  .createVoucher{
	display:none;
  }
  .payingFooter{
	float: left;
	width: 100%;
  }
  .footer1{
	float: left;
	width: 50%;
  }
  .footer2{
	float: left;
	width: 50%;
	text-align:center;
  }
  .payingFooter2{
	width: 100%;
	float: left;
  }
  .footer3{
	float: right;
	width: 50%;
	text-align:center;
  }
  .footer4{
	margin-top: 30px;
	width: 100%;
	float: left;
  }
  .vMainPage{
	page-break-inside: avoid;
  }
  #vref
  {
      border:none;
  }
}

</style>

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>

<script>
	$(document).ready(function()
	{
	$( "#vref" ).blur(function() {
		var transactionID = $(this).attr('transid');
		var datePrepaid = $(this).attr('datePrepaid');
		var vref = $(this).val();
	//    alert(vref);
		$.ajax({
	  url: murl +'/update/vrefNo',
	  type: "post",
	  data: {'transactionID':transactionID, 'vref': vref,'datePrepaid':datePrepaid, _token:'{{csrf_token()}}'},
	   
	  success: function(datas){
		 console.log(datas.previous); 
		  console.log(datas); 
	   if(datas.check > 0)
	   {
		   $("#vref").css("border", "5px solid red");
		   $("#vref").val(datas.previous);
	   }
	   else
	   {
	   $(".vrefNo").html(datas.vref_no)
		}
		
	  
	  }
	});
	 
	});
	});
	</script>

<!--Convert Number to word --> 
<script type="text/javascript"> 
	var amount = "";
    var amount = "<?php echo number_format($amtpayable, 2, '.', '') ; ?>";
    var money = amount.split('.');

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
				 document.getElementById('result3').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 	document.getElementById('result2').innerHTML = getWord.replace(parternRule1, ' HUNDRED NAIRA ');
			 }else if((instance2))
			 {
			 	document.getElementById('result').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
				 document.getElementById('result3').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 	document.getElementById('result2').innerHTML = getWord.replace(parternRule2, ' HUNDRED THOUSAND NAIRA ');
			 }else
			 {
			  	document.getElementById('result').innerHTML = getWord;
				  document.getElementById('result3').innerHTML = getWord;
			  	document.getElementById('result2').innerHTML = getWord;
			 }
		//           
    
    }

</script>

<script type="text/javascript">

$(document).ready(function() {
    $('.print-window').click(function() {
        window.print();
    });
})
</script>
@endsection
@endsection

@endsection