@extends('layouts.layout')
@section('pageTitle')
   {{ strtoupper('Edit voucher') }}
@endsection
@section('content')


 <div id="vim" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Comments</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12" id="z-space">
                    
                    </div>
                </div>
            </div>
            </form>
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
                       @if ($error <> '')
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
                
    
  
        <form class="form-horizontal" role="form" id="form1" method="post" action="">
        {{ csrf_field() }}

        <div class="col-md-12"><!--2nd col-->
                   <input type="hidden" name="selectedid" id="selectedid" value="{{$selectedid}}">
				   <input type="hidden" name="retainrecord" id="retainrecord">
        <div class="col-md-12"><!--2nd col-->
          <!-- /.row -->
          <div class="form-group">

            <div class="col-md-3">          
                <label class="control-label">Account Head</label>
                <input type="text" id="contracttype1" name="contracttype1" value="{{$staticcontr->contractType}}" readonly=""  class="form-control">
            </div>


          <div class="col-md-3">          
                <label class="control-label">Allocation type</label>
                <select onchange="return getEconomics()" class="form-control" id="allocationtype" name="allocationtype" placeholder="" >
                  <option value="">Select Allocation</option>
                  @foreach($allocationlist as $list)
                    <option value="{{$list->ID}}" {{($list->ID == $allocationtype) ? "selected" : ""}}>{{$list->allocation}}</option>
                  @endforeach
                </select>
            </div>


            <div class="col-md-6">          
                <label class="control-label">Economic code</label>
                <select name="economicCode" id="economicCode" class="form-control"   >
              <option value="">Select Economic Code</option>
              @foreach($econocode as $list)
            <option  value="{{ $list->ID }}" {{($list->ID == $economicCode) ? "selected" : ""}}>({{$list->description }}) {{$list->economicCode}}</option>
              @endforeach
          </select>
            </div>       
            
        </div>
            </div>

          

            <div class="col-md-12" >
          <div class="form-group">
            

            

            <div class="col-md-2">           
                <label class="control-label"><small>Balance before</small></label>
                <input type="text" class="form-control" readonly value="{{$BB}}">
            </div>
            
            <div class="col-md-10">           
                <label class="control-label">&nbsp&nbsp</label><br>
                <button  class="btn btn-info " onclick="return viewInstruct('{{$reasons}}')" ><span>View Comment</span></button>
                 @foreach ($fileattach as $b)
                 
                <a class="btn btn-info " target="blank" href="/attachments/{{$b->filename}}" >Download {{$b->file_desc}}</a>
                @endforeach
                <button  class="btn btn-info " onclick="return MoreAttachment()" ><span>Add more</span></button>
            </div>          
           
        </div>
            </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->


  <div align="center">
    <h3><b><div>{{strtoupper('VOUCHER ENTRY')}}</div></b></h3>
  </div>
        

            <div class="row">
      <div class="col-md-12">

        <table class="table table-striped table-condensed table-bordered ">
          <thead style="background: #fdfdfd;">
            <tr class="input-lg">
                  <th width="100" rowspan="2" class="text-center">Date</th>
                  <th width="600" rowspan="2" class="text-center"> @if($companyid !=13)Contractor Detail @else Beneficiary  @endif</th>
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
                        <input type="text"  readonly id="beneficiaryName" class="form-control hidden-print " style="border:1px solid #333;" value="{{ $contractor }}" placeholder="Beneficiary Name" >
                        <input type="hidden" name="companyid" value="{{$companyid}}">
                      </div>
                      
                  <br /><br />
                  
                  
                </div>
                </th>
                <th>
                <span class="hidden-print">
                  <input type="text" onchange="calc()" onkeyup="calc()"  name="amount" id="netAmount" class="form-control " autocomplete="off" placeholder="Gross Amount" value="{{$amount}}" >
                  <span id="errmsg" class="text-danger"></span>
                  </span>
                </th>
                <th></th>
                </tr>
                 @if($companyid !=13)
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th>
                  <span class="hidden-print">
                    <select name="vatselect" id="vatselect" class="form-control hidden-print " style="border: none; width: 15%; float: left;"  value="{{old('vatselect')}}" >

                <option value="0" {{ ($vatselect== 0) ? "selected" : "" }}>0</option>
                <option value="1" {{ ($vatselect== 1) ? "selected" : "" }}>1%</option>
                <option value="2" {{ ($vatselect== 2) ? "selected" : "" }}>2%</option>
                <option value="3" {{ ($vatselect== 3) ? "selected" : "" }}>3%</option>
                <option value="4" {{ ($vatselect== 4) ? "selected" : "" }}>4%</option>
                <option value="5" {{ ($vatselect== 5) ? "selected" : "" }}>5%</option>
                <option value="10" {{ ($vatselect== 10) ? "selected" : "" }}>10%</option>
                <option value="15" {{ ($vatselect== 15) ? "selected" : "" }}>15%</option>
                <option value="20" {{ ($vatselect== 20) ? "selected" : "" }}>20%</option>
                  
                   </select> &nbsp; VAT Payable &#60; Cash Book &#62;  
                   </span> 
              </th>

                <!-- <span class="hidden-print">5% VAT Payable &#60; Cash Book &#62; </span></th>-->
                <th></th>
                <th><span class="hidden-print">
                  <input type="text" id="vat" value="{{$vat}}" name="vat" readonly class="form-control" style="border: none; background: white" ></span>
                </th>
                </tr>
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th> <span class="hidden-print"> 
                <select name="whtOrTax" id="WithholdingTax" class="form-control hidden-print" value="{{old('whtOrTax')}}"  style="border: none; width: 15%; float: left;" >
                <option value="0" {{ ($whtOrTax== 0) ? "selected" : "" }}>0</option>
                <option value="1" {{ ($whtOrTax== 1) ? "selected" : "" }}>1%</option>
                <option value="2" {{ ($whtOrTax== 2) ? "selected" : "" }}>2%</option>
                <option value="3" {{ ($whtOrTax== 3) ? "selected" : "" }}>3%</option>
                <option value="4" {{ ($whtOrTax== 4) ? "selected" : "" }}>4%</option>
                <option value="5" {{ ($whtOrTax== 5) ? "selected" : "" }}>5%</option>
                <option value="10" {{ ($whtOrTax== 10) ? "selected" : "" }}>10%</option>
                <option value="15" {{ ($whtOrTax== 15) ? "selected" : "" }}>15%</option>
                <option value="20" {{ ($whtOrTax== 20) ? "selected" : "" }}>20%</option>
              </select> &nbsp; Withholding Tax Payable &#60; Cash Book &#62; </span> </th>
                <th></th>
                <th><span class="hidden-print">
                    <input type="text" id="tax" name="wht" value="{{$wht}}" class="form-control" style="border: none; background: #f9f9f9" >
                  </span>
                </th>
                </tr>
                @else
                <input type="hidden" id="tax" name="tax" value="0">
                <input type="hidden" id="WithholdingTax" name="whtOrTax" value="0">
                <input type="hidden" id="vat" name="vat" value="0">
                <input type="hidden" id="vatselect" name="vatselect" value="0">
                @endif
                <tr class="input-lg">
                <th class="text-center"><span class="hidden-print">&#10004;</span></th>
                <th><span class="hidden-print">Amount Payable to individual/contractor &#60; Cash Book &#62; </span> </th>
                <th></th> 
                <th><div class="hidden-print" id="grossAmount" style="border-bottom: 1px solid #000;">{{$amtpayable}}</div></th>
                </tr>
                <tr class="input-lg">
                <th></th>
                <th></th>
                <th></th>
                <th><span class="hidden-print" id="totalTaxVat"></span></th>
                <input type="hidden" name="amtpayable" value="{{ $amtpayable}}" id="amtpayable">
                </tr>
              </tbody>
        </table>


      <table class="table table-striped table-condensed">
        <thead style="background: #fff;">
            @if($companyid !=13)
            <tr class="input-lg hidden-print">
                <th valign="center" width="100"><h4>VAT Payee: </h4></th>
                <th>
                  <div class="row">
                  <div class="col-sm-12">
                    <select disabled id="vatPayeeID" name="vatPayeeID" class="form-control" style="border: 1px thin #f9f9f9;" 
                    >
                    <option value="">select</option>
                          @foreach($vatwhttable as $list)
                              <option value="{{$list->ID}}" {{ ($list->ID === $vatPayeeID) ? "selected" : "" }}>{{ $list->payee }}</option>
                          @endforeach
                    </select>
                  </div>
                  
                  </div>
                </th>
            </tr>

            <tr class="input-lg hidden-print">
                <th valign="center" width="100"><h4>WHT Payee: </h4></th>
                <th>
                  <div class="row">
                    <div class="col-sm-12">
                      <select disabled id="whtPayeeID" name="whtPayeeID" class="form-control" style="border: 1px thin #f9f9f9;"  >
                          <option value="">select</option>
                          @foreach($vatwhttable as $list)
                              <option value="{{$list->ID}}" {{ ($list->ID === $whtPayeeID) ? "selected" : "" }}>{{ $list->payee }}</option>
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
                  <input type="hidden" name="narration" value="{{$narration}}">
                  <textarea name="narration"  class="form-control input-lg hidden-print" style="border: 1px thin #f9f9f9; height: 100px;">{{$narration}}</textarea>
                </th>
            </tr>
           
            <tr class="input-lg">
                <th valign="center" width="100"><h4>FileNo</h4></th>
                <th><input type="text" name="fileno" readonly class="form-control hidden-print" style="border: 1px thin #f9f9f9;" value="{{$fileno}}" ></th>
            </tr>
            
             <tr class="input-lg">
                <th valign="center" width="100"><h4>Voucher Date: </h4></th>
                <th><span class="hidden-print">
                  <input type="text" value="{{$todayDate}}" readonly="readonly" name="todayDate" id="todayDate" class="form-control col-lg-4"  placeholder="Select Date">
                </span></th>
            </tr>

                        
          </thead>
      </table>
      <center><button class="btn btn-success" onclick="return submitVoucher()">Save Changes</button></center>
      <input type="hidden" name="finalsubmit" id="finalsubmit" value="">
      </div>
    </div><!-- /.col -->
  </div>
            </div>
          
          <hr />
        </div>
       
  </div>
</div>
</form>



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
function viewInstruct(list){
    if(list !== ""){
       	var a = JSON.parse(list);
       	//console.log(a);
       	space = document.getElementById('z-space');
       	space.innerHTML = '';
       	for(i = 0; i < a.length; i++){
       		space.innerHTML += '<p><b id="vi">'+ a[i].comment +'</b> - <small class="text-warning"> <i>'+a[i].name+', posted '+ a[i].date_added+' at '+ a[i].time +'</i></small></p><br>';
       	}
       }
       $('#vim').modal('show');
       return false;
  }
  function MoreAttachment(){
    
       $('#vattach').modal('show');
       return false;
  }
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
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

  

  function getBalance(){
    var eco = document.getElementById('economicCode1').value;
    var frm = document.getElementById('form1');
    if(eco !== ""){
      return frm.submit();
    }
  }

  function setID(id){
      document.getElementById('selectedid').value = id;
      var all = document.getElementById('allocationtype1').value;
      var con =  document.getElementById('economicCode1').value;
      if(all != "" && con != "") {
          return document.getElementById('form1').submit();
      } else{
          alert('Please choose your allocation type and economic code before selecting contract!');
      }
      return false;
  }

  function submitVoucher(){
      document.getElementById('finalsubmit').value = 'complete-edit';
	  document.getElementById('retainrecord').value = '1';
      return document.getElementById('form1').submit();
  }

  function getEconomics(){
    var frm = document.getElementById('form1');
	document.getElementById('retainrecord').value = '1';
      return frm.submit();
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
  
 
  
   $("#vatselect ,#WithholdingTax").change( function() {
  
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
         
  }
  else{

        var vat_rate = $("#vatselect").val();
  var tax_rate = $("#WithholdingTax").val();

  console.log( 'vat rate', vat_rate );
        console.log( 'tax rate', tax_rate );
  var demo= Number(vat_rate)+100;
  var vat = (vat_rate /demo) * amount;
  var mockval=amount-vat;
  //calculate tax value
   var tax = ( tax_rate / 100 ) * mockval;
  
  vat=vat.toFixed(2);
  $("#vat").val(vat); 
   
  //display the tax to the user 
  tax=tax.toFixed(2);
  $("#tax").val(tax);
        
         //calculate net payable 
          var netpay = Number( amount) - ( Number ( vat ) + Number( tax) ) ;
            $("#grossAmount").html( netpay);
            $("#amtpayable").val(netpay);
  
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

  console.log( 'vat rate', vat_rate );
        console.log( 'tax rate', tax_rate );
  var demo= Number(vat_rate)+100;
  var vat = (vat_rate /demo) * amount;
  var mockval=amount-vat;
  //calculate tax value
   var tax = ( tax_rate / 100 ) * mockval;
  
  vat=vat.toFixed(2);
  $("#vat").val(vat);
  
  //display the tax to the user 
  tax=tax.toFixed(2);
  $("#tax").val(tax);
  //$("#netAmount").val(amount);
        
         //calculate net payable 
          var netpay = Number( amount) - ( Number ( vat ) + Number( tax) ) ;
            $("#grossAmount").html( netpay);
            $("#amtpayable").val(netpay);
  
  
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
