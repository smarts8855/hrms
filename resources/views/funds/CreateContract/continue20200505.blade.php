@extends('layouts.layout')
@section('pageTitle')
   {{ strtoupper('create contractor voucher') }}
@endsection
@section('content')



    
    
    <div id="vim" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">All comments</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12" id="z-space">
                    
                    </div>
                </div>
            </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <a href="/display/comment/{{$contractID}}" target="_blank" class="btn btn-info">Print Comment</a>
                </div>
            
                
            </div>
            
          </div>
        </div>
 <div id="vattach" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">More Attachment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
            <div class="modal-body">   
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12" >
                    <div class="form-group">
            		         
		                <label class="control-label"><small>Attachment Caption</small></label>
		                <input type="text" class="form-control" name="attachcaption">
	            	
	            </div>
                    </div>
                <div class="col-sm-12"> 
                <div class="form-group">          
                    <label class="control-label">Attach file</label>
                    <input class="form-control" type="file" id="file" autocomplete="off" name="filex" >
                </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-info" name="attach">Attach</button>
                 <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
            </form>
                
            </div>
            
          </div>
        </div> 
 
<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
                    @if ($warning<>'')
                      <div class="alert alert-dismissible alert-danger">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>{{$warning}}</strong> 
                      </div>
                      @endif
                      @if ($success<>'')
                      <div class="alert alert-dismissible alert-success">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>{{$success}}</strong> 
                      </div>
                      @endif
                      @if ($error<>'')
                      <div class="alert alert-dismissible alert-danger">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>{{$error}}</strong> 
                      </div>
                      @endif
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
                
  <form class="form-horizontal" role="form" action="" method="post" id="form1" enctype="multipart/form-data">
        {{ csrf_field() }}
          <div class="col-md-4"> 
          	<a class="btn btn-warning btn-sm" href="{{ URL::previous() }}">Back</a><br>
              @php 
              $getBalance =  $getBalance; 
              $old =  old('totalamount');
              @endphp        
                <label class="control-label"><small>Enter Sum Total Amount if making part payment</small></label>
                <input type="text" class="form-control" readonly id="totalamount" value="{{number_format(($getBalance) ? $getBalance : $old)}}" name="totalamount" placeholder="Enter total amount (Optional)" >
                <input type="hidden" name="selectedid" value="{{ $selected }}">
                <input type="hidden" name="contracttype2" value="{{ $contr5 }}">
            </div>
            
            <div class="col-md-4">           
                <label class="control-label">&nbsp&nbsp</label><br>
                
                <button  class="btn btn-info btn-xs " onclick="return viewInstruct('{{$instructions}}','{{$instructions1}}')" >Read Instruction</button>
                @php
        		$path = base_path('../'). env('UPLOAD_PATH', '') .'/' . $sel_id.'.'.$file_ex;
    		@endphp

                @if($sel_id != "")                    
	    		@if(file_exists($path))
	                  <a class="btn btn-primary btn-xs " target="blank" href="/pro/file/{{$sel_id.'.'.$file_ex}}" >Download file</a>
	                @endif
                @endif
                @foreach ($fileattach as $b)
                <a class="btn btn-info " target="blank" href="/attachments/{{$b->filename}}" >Download {{$b->file_desc}}</a>
                @endforeach
                <button  class="btn btn-info " onclick="return MoreAttachment()" ><span>Add more</span></button>
            </div>
            
                  
                   <input type="hidden" name="selectedid" id="selectedid" value="{{($selectedid) ? $selectedid : old('selectedid')}}">
        <div class="col-md-12">
          <div class="form-group">

            <div class="col-md-4">          
                <label class="control-label">Contract type</label>
                <input type="text" id="contracttype1" name="contracttype1" value="{{$ecogrouptext}}" readonly=""  class="form-control">
            </div>


          <div class="col-md-4">          
                <label class="control-label">Allocation type {{session('alloc')}}</label>
                @if($economicCode_as != "")
                <input type="text"  class="form-control"  readonly value="{{ $alloc3 }}" >
                <input type="hidden" class="form-control" id="allocationtype1" name="allocationtype1" placeholder="" readonly value="{{$alloc5}}" >
                @else
                <select onchange="return getEconomics()" class="form-control" id="allocationtype1" name="allocationtype1" placeholder="" {{ ($economicCode_as == "") ? "" : "readonly" }}>
                  <option value="">Select Allocation</option>
                  @foreach($allocationlist as $list)
                    <option value="{{$list->ID}}" {{($list->ID == $alloc1 || $list->ID == old('allocationtype1')) ? "selected" : ""}}>{{$list->allocation}}</option>
                  @endforeach
                </select>
                @endif
            </div>


            <div class="col-md-4">          
                <label class="control-label">Economic code</label>
                @if($economicCode_as != "")
                  <input type="text"  class="form-control"  readonly value="{{ $econ3 }}" >
                  <input type="hidden" name="economicCode1" id="economicCode1" class="form-control"  readonly value="{{ $economicCode_as }}" >
                @else
                <select name="economicCode1" id="economicCode1" class="form-control" >
                  <option value="">Select Economic Code</option>
                  @php 
                  	if(old('economicCode1') !== ""){
                  		$caser = old('economicCode1');
                  	} elseif($economiccode1 !== ""){
				$caser = $economiccode1;
                  	}else {
                  		$caser = "";
                  	}
                  @endphp
                  
                  @foreach($ECONOMAIN as $list)
                  <option  value="{{ $list->ID }}" @if(old('economicCode1') == $list->ID) {{('selected')}} @endif>({{ $list->description }}) {{$list->economicCode}}</option>
                  @endforeach
                  </select>
                @endif
          
            </div>       
        </div>
            </div>

     
          <!-- /.col --> 
        </div>
        <!-- /.row -->


            <div class="row">
      <div class="col-md-12">

        <table class="table table-striped table-condensed table-bordered ">
          <thead style="background: #fdfdfd;">
            <tr class="input-lg">
                  <th width="100" rowspan="2" class="text-center">DATE</th>
                  <th width="600"  rowspan="2" class="text-center"> @if($companyidhid !=13)Contractor Detail @else Beneficiary  @endif</th>
                  <th width="200" class="text-center">DR. </th>
                  <th width="200" class="text-center">CR. </th>
                </tr>
                <tr class="input-lg">
                  <th width="140" class="text-center"> &#8358; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>k</b></th>
                  <th width="140" class="text-center"> &#8358; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>k</b> </th>
                </tr>
              </thead>
              <tbody>
                  <tr class="input-lg">
                <th><span class="hidden-print">{{date('d/m/Y')}}</span></th>
                <th>
                  <div class="row">
                      <div class="col-sm-12">
                        <input type="text" name="beneficiaryName" readonly id="beneficiaryName" class="form-control hidden-print " style="border:1px solid #333;" value="{{ ($contractor) ? $contractor : old('beneficiaryName')}}" placeholder="Beneficiary Name" >
                        <input type="hidden" name="companyid" value="{{($companyidhid)?$companyidhid:old('companyid')}}">
                      </div>
                  
                </div>
                </th>
                <th>
                @php
                	if(old('amount') == "" && $getBalanceas == ""){
                	$mone = $getBalance;
                	} 
                	
                	if(old('amount') != ""){
                	$mone = old('amount');
                	} 
                	
                	if($getBalanceas != ""){
                	$mone = $getBalanceas;
                	}
                	//dd($request['amount']);
                @endphp
                <span class="">
                  <input type="text" onchange="calc()" onkeyup="calc()"  name="amount" id="netAmount" class="form-control " autocomplete="off" placeholder="Gross Amount" value="{{$mone}}" >
                  <span id="errmsg" class="text-danger"></span>
                  </span>
                </th>
                <th></th>
                </tr>
                @if($companyidhid !=13)
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th>
                  <span class="hidden-print">
                    <select name="vatselect" id="vatselect" class="form-control hidden-print " style="border: none; width: 15%; float: left;"  value="{{old('vatselect')}}" >
                  
                  <option value="0" >N/A</option>
                  <option value="5" {{($vatpas == 5 || 5 == old('vatselect')) ? "selected" : ""}}>5%</option>
                  <option value="7.5" {{($vatpas == 7.5 || 7.5 == old('vatselect')) ? "selected" : ""}}>7.5%</option>
                  <option value="10" {{($vatpas == 10 || 10 == old('vatselect')) ? "selected" : ""}}>10%</option>
                  
                   </select> &nbsp; VAT Payable &#60; Cash Book &#62;  
                   </span> 
              </th>

                <th></th>
                <th><span class="hidden-print">
                  <input type="text" id="vat" value="{{($vatvas) ? $vatvas : old('vat')}}" name="vat" readonly class="form-control" style="border: none; background: white" ></span>
                </th>
                </tr>
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th> <span class="hidden-print"> 
                <select name="whtOrTax" id="WithholdingTax" class="form-control hidden-print" value="{{old('whtOrTax')}}"  style="border: none; width: 15%; float: left;" >
                <option value="0" selected="selected">N/A</option>
                  <option value="5" {{($whtpas == 5 || 5 == old('whtOrTax')) ? "selected" : ""}}>5%</option>
                   <option value="7.5" {{($whtpas == 7.5 || 7.5 == old('whtOrTax')) ? "selected" : ""}}>7.5%</option>
                  <option value="10" {{($whtpas == 10 || 10 == old('whtOrTax')) ? "selected" : ""}}>10%</option>
              </select> &nbsp; Withholding Tax Payable &#60; Cash Book &#62; </span> </th>
                <th></th>
                <th><span class="hidden-print">
                    <input type="text" id="tax" name="tax" value="{{($whtvas) ? $whtvas : old('tax')}}" class="form-control" style="border: none; background: #f9f9f9" >
                  </span>
                </th>
                </tr>
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th>
                  <span class="hidden-print">
                    <select name="stampduty" id="stampduty" class="form-control hidden-print " style="border: none; width: 15%; float: left;"  value="{{old('stampduty')}}" >
                  
                  <option value="0" >N/A</option>
                  <option value="1" {{($stampduty == 1 || 1 == old('stampduty')) ? "selected" : ""}}>1%</option>
                  
                   </select> &nbsp; Stamp Duty &#60; Cash Book &#62;  
                   </span> 
              </th>

                <th></th>
                <th><span class="hidden-print">
                  <input type="text" id="stampdutyval" value="{{($stampdutyval) ? $stampdutyval : old('stampdutyval')}}"  readonly class="form-control" style="border: none; background: white" ></span>
                </th>
                </tr>
                @else
                <input type="hidden" id="tax" name="tax" value="0">
                <input type="hidden" id="WithholdingTax" name="whtOrTax" value="0">
                <input type="hidden" id="vat" name="vat" value="0">
                <input type="hidden" id="vatselect" name="vatselect" value="0">
                <input type="hidden" id="stampduty" name="stampduty" value="0">
                <input type="hidden" id="stampdutyval" name="stampdutyval" value="0">
                @endif
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th><span class="hidden-print">Amount Payable to individual/contractor &#60; Cash Book &#62; </span> </th>
                <th></th> 
                <th><div class="hidden-print" id="grossAmount" style="border-bottom: 1px solid #000;">{{($amtpayble) ? $amtpayble : old('amtpayable')}}</div></th>
                </tr>
                <tr class="input-lg">
                <th></th>
                <th></th>
                <th></th>
                <th><span class="hidden-print" id="totalTaxVat"></span></th>
                <input type="hidden" name="amtpayable" value="{{($amtpayble) ? $amtpayble : old('amtpayable')}}" id="amtpayable">
                </tr>
              </tbody>
        </table>


      <table class="table table-striped table-condensed">
        <thead style="background: #fff;">
          @if($companyidhid !=13)
            <tr class="input-lg hidden-print">
                <th valign="center" width="100"><h4>VAT Payee: </h4></th>
                <th width="600">
                  <div class="row">
                  <div class="col-sm-12">
                    <select disabled name="vatPayeeID" class="form-control" id="vatPayeeID" onchange="return getAddrvat()" style="border: 1px thin #f9f9f9;" 
                    >
                    <option value="">select</option>
                          @foreach($vatwhttable as $list)
                              <option value="{{$list->ID}}" {{ ($list->ID == $vatpayeeas || $list->ID == old('vatPayeeID')) ? "selected" : "" }}>{{ $list->payee }}</option>
                          @endforeach
                    </select>
                  </div>
                  
                  </div>
                </th>
            </tr>
            
            <tr class="input-lg hidden-print">
                <th valign="center" width="100"><h4>WHT Payee: </h4></th>
                <th width="600">
                  <div class="row">
                    <div class="col-sm-12">
                      <select disabled name="whtPayeeID" id="whtPayeeID" class="form-control" onchange="return getAddrwht()" style="border: 1px thin #f9f9f9;"  >
                          <option value="">select</option>
                          @foreach($vatwhttable as $list)
                              <option value="{{$list->ID}}" {{ ($list->ID == $whtpayeeas || $list->ID == old('whtPayeeID')) ? "selected" : "" }}>{{ $list->payee }}</option>
                          @endforeach
                      </select>
                    </div>
                    
                  </div>
                </th>
            </tr>
            @else
                <input type="hidden" id="whtPayeeID" name="whtPayeeID" value="0">
                <input type="hidden" id="vatPayeeID" name="vatPayeeID" value="0">
             @endif
          <tr class="input-lg">
                <td valign="top" width="100"><h4>Narration:</h4></td>
                <th width="600">
                  <input type="hidden" name="paymentdesc" value="{{($paymentdesc) ? $paymentdesc: old('paymentdesc')}}">
                  <textarea name="narration"  class="form-control input-lg hidden-print" style="border: 1px thin #f9f9f9; height: 100px;">{{($narration) ? $narration : old('narration')}}</textarea>
                </th>
            </tr>
            
            <tr class="input-lg">
                <th valign="center" width="100"><h4>FILENO</h4></th>
                <th><input type="text" name="filenoas" class="form-control hidden-print" readonly style="border: 1px thin #f9f9f9;" value="{{ ($filenoas) ? $filenoas : old('fileno') }}" ></th>
            </tr>
            
            <tr class="input-lg">
                <th valign="center" width="100"><h4>Prepared By:</h4></th>
                <th><input type="text" name="preparedBy" readonly="readonly" class="form-control hidden-print" style="border: 1px thin #f9f9f9;" value="{{($currentuser)? $currentuser : old('preparedBy')}}" ></th>
            </tr>
            
             <tr class="input-lg">
                <th valign="center" width="100"><h4>Date: </h4></th>
                <th><span class="hidden-print">
                  <input readonly type="text" value="{{($todayDateas) ? $todayDateas : old('todayDate')}}" readonly="readonly" name="todayDate" id="todayDate" class="form-control col-lg-4"  placeholder="Select Date">
                </span></th>
            </tr>

            
            
          </thead>
      </table>
      <center><button class="btn btn-success" onclick="return submitVoucher()">Create Voucher</button></center>
      <input type="hidden" name="finalsubmit" id="finalsubmit" value="">
      </div>
    </div><!-- /.col -->
  </div>
            </div>
          
          <hr />
        </div>
       </form>
  </div>
</div>








@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop
@section('styles')
<style type="text/css">
    .modal-dialog {
width:10cm
}

.modal-header {

background-color: #006600;

color:#FFF;

}

</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
$(document).ready(function(){
$('#allocationtype1').change(function()
{
var id = $this.val();
$.ajax({
  url: murl +'/session set',
  type: "post",
  data: {'nameID': id, '_token': $('input[name=_token]').val()},
  success: function(data){
    console.log(data);
        
  }
});
});
});
</script>
<script>
  
    function editfunc(a,b,c,d,e,f,g,h,i,j)
    {
    $(document).ready(function(){
        $('#contractor').val(a);
        $('#phone').val(b);
        $('#email').val(c);
        $('#address').val(d);
        $('#bank').val(e);
        $('#account').val(f);
        $('#sortcode').val(g);
        $('#tin').val(h);
        $('#C_id').val(i);
        $('#status').val(j);
        $("#editModal").modal('show');
     });
    }

    function delfunc(a)
  {
  $(document).ready(function(){
  $('#conID').val(a);
  $("#delModal").modal('show');
  });
  }

  function getEconomics(){
    
    var all = document.getElementById('allocationtype1').value;
    var con =  document.getElementById('contracttype1').value;
    var frm = document.getElementById('form1');

    if(all !== "" && con !== ""){
      return frm.submit();
    }
  }
  
  

  function getBalance(){
    var eco = document.getElementById('economicCode1').value;
    var frm = document.getElementById('form1');
    if(eco !== ""){
      return frm.submit();
    }
  }
 
  function viewInstruct(list,list1){
   space = document.getElementById('z-space');
    space.innerHTML = '';
       if(list1 !== ""){
        var a = JSON.parse(list1);
        space.innerHTML += 'Pre-payment Remarks <br>';
        for(i = 0; i < a.length; i++){
          space.innerHTML += '<p><b id="vi">'+ a[i].comment +'</b> - <small class="text-warning"> <i>'+a[i].name+', posted '+ a[i].date_added+' at '+ a[i].time +'</i></small></p><br>';
        }
       }
       if(list !== ""){
        var a = JSON.parse(list);
        space.innerHTML += '<br> payment Remarks <br>';
        for(i = 0; i < a.length; i++){
          space.innerHTML += '<p><b id="vi">'+ a[i].comment +'</b> - <small class="text-warning"> <i>'+a[i].name+', posted '+ a[i].date_added+' at '+ a[i].time +'</i></small></p><br>';
        }
       }
       $('#vim').modal('show');
       return false;
  }
  
  function setID(id){
      document.getElementById('selectedid').value = id;
      //var all = document.getElementById('allocationtype1').value;
      //var con =  document.getElementById('economicCode1').value;
      document.getElementById('finalsubmit').value = 'gettingstuff1';
      return document.getElementById('form1').submit();
      
  }

  function submitVoucher(){
      	//console.log(document.getElementById('form1'));
      	//return false;
       	document.getElementById('finalsubmit').value = 'complete';
      	return document.getElementById('form1').submit();
  }

  function getEconomics2(){
    var all = document.getElementById('secallocationtype').value;
    var con =  document.getElementById('contracttype1').value;
    var frm = document.getElementById('form1');
    if(all !== "" && con !== ""){
      return frm.submit();
    }
  } 
  
  function getAddrvat(){
      console.log(document.getElementById('vatPayeeID').value);
      return false;
  }
   
   
   function getAddrwht(){
      console.log(document.getElementById('whtPayeeID').value);
      return false;
  }
    
</script>

    </script>
    <script>
///////////////////////DATE///////////////////////////////// 
  $( function(){
      $("#todayDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
    });
  ///////////////////////DATE/////////////////

    //$('#netAmount').focus(); 

    $('#companyGetLookUp').change( function() 
  {
    $('#beneficiaryName').val($('#companyGetLookUp').val());
  });
  

  
  vt = document.getElementById("vatPayeeID");
  wh = document.getElementById("whtPayeeID");
  
  if($("#vatselect").val() !== "0"){
  	vt.disabled = false;
  }
  
  if($("#WithholdingTax").val() !== "0"){
  	wh.disabled = false;
  }
  
  if($("#vatselect").val() == "0"){
  	vt.disabled = true;
  	vt.value = "";
  }
  
  if($("#WithholdingTax").val() == "0"){
  	wh.disabled = true;
  	wh.value = "";
  }
  
 
  
  $("#vatselect ,#WithholdingTax,#stampduty").change( function() {
  
  vt = document.getElementById("vatPayeeID");
  wh = document.getElementById("whtPayeeID");
  
  if($("#vatselect").val() !== "0"){
  	vt.disabled = false;
  }
  
  if($("#WithholdingTax").val() !== "0"){
  	wh.disabled = false;
  }
  
  if($("#vatselect").val() == "0"){
  	vt.disabled = true;
  	vt.value = "";
  }
  
  if($("#WithholdingTax").val() == "0"){
  	wh.disabled = true;
  	wh.value = "";
  }


  var amount = $("#netAmount").val();
  if( amount ==""){
  
  //alert error when amount is empty , vat and tax not applicable to zero amount 
  alert("amount cant be empty");
  $("#netAmount").focus();
  }else{
    var vat_rate = $("#vatselect").val();
    var tax_rate = $("#WithholdingTax").val();
    var demo= Number(vat_rate)+100;
    var vat = (vat_rate /demo) * amount;
    var mockval=amount-vat;
    var tax = ( tax_rate / 100 ) * mockval;
    vat=vat.toFixed(2);
    $("#vat").val(vat); 
    tax=tax.toFixed(2); 
    $("#tax").val(tax);
    
    var stampduty = $("#stampduty").val();
    var stampdutyval = ( stampduty / 100 ) * mockval;
    stampdutyval=stampdutyval.toFixed(2);
    $("#stampdutyval").val(stampdutyval);
    
    var netpay = Number( amount) - ( Number ( vat ) + Number( tax) + Number( stampdutyval)) ;
    
    netpay=netpay.toFixed(2); 
    $("#amtpayable").val(netpay);
    $("#grossAmount").html( netpay);
  
  }
  
  })

function calc(){
    var amount = $("#netAmount").val();
  if( amount ==""){
  
  //alert error when amount is empty , vat and tax not applicable to zero amount 
  alert("amount cant be empty");
  $("#netAmount").focus();
         
  }
  else{
   var vat_rate = $("#vatselect").val();
    var tax_rate = $("#WithholdingTax").val();
    var demo= Number(vat_rate)+100;
    var vat = (vat_rate /demo) * amount;
    var mockval=amount-vat;
    var tax = ( tax_rate / 100 ) * mockval;
    vat=vat.toFixed(2);
    $("#vat").val(vat); 
    tax=tax.toFixed(2); 
    $("#tax").val(tax);
    var stampduty = $("#stampduty").val();
    var stampdutyval = ( stampduty / 100 ) * mockval;
    stampdutyval=stampdutyval.toFixed(2);
    $("#stampdutyval").val(stampdutyval);
    var netpay = Number( amount) - ( Number ( vat ) + Number( tax) + Number( stampdutyval)) ;
    netpay=netpay.toFixed(2); 
    $("#amtpayable").val(netpay);
    $("#grossAmount").html( netpay);
}
  function showF(){
    document.getElementById('second-form').style.display = 'block';
    document.getElementById('show-btn').style.visibility = 'hidden';
    document.getElementById('hide-btn').style.visibility = 'visible';
}
  
}
  function hideF(){
    document.getElementById('second-form').style.display = 'none';
    document.getElementById('hide-btn').style.visibility = 'hidden';
    document.getElementById('show-btn').style.visibility = 'visible';
  }  
  </script>


@stop
