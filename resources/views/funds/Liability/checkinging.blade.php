@extends('layouts.layout')
@section('pageTitle')
Audit Raised Vourcher
@endsection



@section('content')
<div id="vim" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">All Minutes</h4>
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
                    <!--<button type="Submit" class="btn btn-success" id="putedit"></button>-->
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            
                
            </div>
            
          </div>
        </div>
        
<div id="editModal" class="modal fade">
        <div class="modal-dialog " role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h4 class="modal-title">Preview Voucher</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="editpartModal" name="editpartModal"
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">Contract Type:</label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" value="" name="contracttype" id="contracttype" readonly class=" form-control" > 
                    </div>
                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">Company</label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" value="" name="Company" readonly="" id="Company" readonly class="form-control" >
                    </div>
                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">PVNO</label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" value="" name="pvno" readonly="" id="pvno" readonly class="form-control" >
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">Payment</label>
                    </div>
                    <div class="col-sm-12">
                            <input type="text" readonly="" value="" name="payment" readonly="" id="payment"  class="form-control" >
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">Payment Description</label>
                    </div>

                    <div class="col-sm-12">
                            <textarea readonly=""  name="payment_desc" id="payment_desc"  class="form-control" > </textarea>
                    </div>


                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">WHT Values</label>
                    <label class="col-sm-4 pull-left">WHT Percentage</label>
                    </div>
                    
                    <div class="col-sm-6">
                            <input type="text" readonly="" value="" name="wht_val" id="wht_val" placeholder=""  class="form-control" > 
                    </div>
                    <div class="col-sm-6">
                            <input type="text" readonly="" value="" name="wht_perc" id="wht_perc" placeholder=""  class="form-control" > 
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">Vat Values</label>
                    <label class="col-sm-4 pull-left">Vat Percentage</label>
                    </div>
                    
                    <div class="col-sm-6">
                            <input type="text" readonly="" value="" name="vat_val" id="vat_val" placeholder=""  class="form-control" > 
                    </div>
                    <div class="col-sm-6">
                            <input type="text" readonly="" value="" name="vat_perc" id="vat_perc" placeholder=""  class="form-control" > 
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">VATPayee</label>
                    </div>
                    
                    <div class="col-sm-12">
                            <input type="text" readonly="" value="" name="vatpayee" id="vatpayee" autocomplete="off"  class="form-control" > 
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">WHTPayee</label>
                    </div>
                    
                    <div class="col-sm-12">
                            <input type="text" readonly="" value="" name="whtpayee" id="whtpayee" autocomplete="off"  class="form-control" > 
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> Amount Payable </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" readonly="" value="" name="amtpayable" id="amtpayable" autocomplete="off"  class="form-control" >  
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> Balance Brought Forward </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" value="" readonly="" name="bbf" id="bbf" autocomplete="off"  class="form-control" >  
                    </div>


                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> Prepared By </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" readonly="" value="" name="preparedby" id="prepareby" autocomplete="off"  class="form-control" >  
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> Liability By </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" readonly="" value="" name="liabilityby" id="liabilityby" autocomplete="off"  class="form-control" >  
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> allocationType </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" readonly="" value="" name="allocationtype" id="allocationtype" autocomplete="off"  class="form-control" >  
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> Economic Code </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" readonly="" value="" name="economiccode" id="economiccode" autocomplete="off"  class="form-control" >  
                    </div>

                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left"> Date Prepared </label>
                    </div>
                    
                    <div class="col-sm-12">
                             <input type="text" readonly="" value="" name="dateprepared" id="dateprepared" autocomplete="off"  class="form-control" >  
                    </div>
                 
                    <input type="hidden" id="paymentTransID" name="paymentTransID" value="">
                    <input type="hidden" name="reason" id="reason" value="">
                </div>

            </div>
                <div class="modal-footer">

                    <button type="Submit" onclick="return decline()" class="btn btn-sm btn-danger">Decline</button>
                    <button type="Submit" onclick="return accept()" class="btn btn-sm btn-success">Accept</button>
                    <button type="button" class="btn btn-sm  btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>

        <!--decline modal-->
        <div id="declineModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Decline Message</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="control-label"><b>Enter Reason for Decline</b></label>
                    </div>
                    <div class="col-sm-12">
                            <textarea  name="declinemess" id="declinemess"  class="form-control" > </textarea>
                    </div>
                    <input type="hidden"  id="chosen1" name="chosen1">
                    <input type="hidden" id="reason" name="reason" value="2">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
        
        <!--end of decline modal-->
        
        
        <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Variable</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to delete this record?</b></label>
                    </div>
                    <input type="hidden" id="deleteid" name="deleteid" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
        
        <div id="RestoreModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Restore Variable</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="deletevariableModal" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-9 control-label"><b>Are you sure you want to restore this record?</b></label>
                    </div>
                    <input type="hidden" id="restoreid" name="restoreid" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
    

<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title"> @yield('pageTitle') <span id='processing'></span></h3>
    </div>

    <div class="col-md-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> 
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if ($error != "")
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> 
                            <p>{{ $error }}</p>
                    </div>
                @endif               
                @if ($success != "")
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ $success }}</div>                        
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}</div>                        
                @endif
            </div>


    <div class="box-body">
      <div class="row">
        <div class="col-md-12"><!--1st col--> 
          @include('Share.message')
        
        
        <div class="row">     
        {{ csrf_field() }}

                
          <!-- /.col --> 
            </div>

        
            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="res_tab" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>PVNO</th>
                            <th>Beneficiary</th>
                            <th>Contract/claim Description</th>
                            <th>Payment Naration</th>
                            <th>Total Amount</th>
                           <th> Date Awarded </th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    @php $i = 0; @endphp
                    <tbody>
                        @if($tablecontent)
                            @foreach($tablecontent as $list)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $list->PVNO }}</td>
                                    @if($list->voucherType== "1")
                                    <td>{{ $list->contractor}}</td>
                                    @else
                                    <td>{{ $list->beneficiary}}</td>
                                    @endif
                                    
                                    
                                    <td>{{ $list->ContractDescriptions }}</td>
                                    <td>{{ $list->paymentDescription }}</td>
                                    <td>{{ number_format($list->totalPayment) }}</td>
                                    <td>{{ $list->dateAward }}</td>
                                    <td>
                                    <div class="dropdown">
                                          <button class="btn btn-danger btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                            <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                                      @if($list->checkbyStatus == 0)
                                        
                                        <li><a onclick="accept('{{$list->ID}}')" >Accept</a></li>
                                        <li><a onclick="decline('{{$list->ID}}')" >Decline</a></li>
                                        
                                        @elseif($list->checkbyStatus == 2)
                                        <li><a onclick="accept('{{$list->ID}}')" >Accept</a></li>
                                        @endif
                                        <li><a href="/display/voucher/{{$list->ID}}" >Preview</a></li>
                                        <li><a onclick="comments('{{$list->comment}}')" >View Minutes</a></li>
                                        @php
	                                	$path = base_path('../'). env('UPLOAD_PATH', '') .'/' . $list->conID.'.'.$list->file_ex;
	                                @endphp
	                                
	                                @if(file_exists($path))
	                                	<li><a href="/pro/file/{{$list->conID.'.'.$list->file_ex}}" target="blank" >Download File</a></li>
	                                @endif
	                                <!--<li><a href="#">Separated link</a></li> -->
                                          </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                               <td colspan="100%">
                                   <center>No Voucher to check</center>
                               </td> 
                            </tr>
                        @endif
                   
                    </tbody>                    
                </table>
        	<br><br><br><br><br>
            </div>
            <input type="hidden" value="" id="co" name="court">
            <input type="hidden" value="" id="di" name="division">
            <input type="hidden" value="" name="status">
            <input type="hidden" value="" name="chosen" id="chosen">
            <input type="hidden" value="" id="type" name="type">
          
          <hr />
        </div>
       
  </div>
</div>



@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
@stop

@section('styles')
<style type="text/css">
    .modal-dialog {
width:13cm
}

.modal-header {

background-color: #006600;

color:#FFF;

}

#partStatus{
    width:2.5cm
}

</style>
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
$('#res_tab').DataTable();
    $( function(){
        $("#todayDate").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
      });

    $( function(){
        $("#dateawd").datepicker({changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}); 
      });

   $("#check-all").change(function(){
       $(".checkitem").prop("checked", $(this).prop("checked"))
   })
   $(".checkitem").change(function(){
       if($(this).prop("checked") == false){
           $("#check-all").prop("checked", false)
       }
       if($(".checkitem:checked").length == $(".checkitem").length){
           $("#check-all").prop("checked", true)
       }
   })

function comments(list){
   if(list == ""){
   	space = document.getElementById('z-space'); 
   	space.innerText = 'No reason found';
   } else {
   	
       	var a = JSON.parse(list);
       	//console.log(a);
       	space = document.getElementById('z-space');
       	space.innerHTML = '';
       	for(i = 0; i < a.length; i++){
       		space.innerHTML += '<p><b id="vi">'+ a[i].comment +'</b> - <small class="text-warning"> <i>'+a[i].name+', posted '+ a[i].date_added+' at '+ a[i].time +'</i></small></p><br>';
       	
       }
       //$('#vim').modal('show');
   }
    
      $("#vim").modal('show');
      return false;
   }
   
   function approve(a = '')
   {
        if(a !== ''){
        document.getElementById('chosen').value = a;
           // alert(a);
        }
        co = document.getElementById('court').value;
        div = document.getElementById('division').value;
        document.getElementById('co').value = co;
        document.getElementById('di').value = div;
        document.getElementById('type').value = 1;
        document.getElementById('form2').submit();
       return false;
   }

   function reject(a = ''){
        if(a !== ''){
            document.getElementById('chosen').value = a;
            //alert(a);
        }
        co = document.getElementById('court').value;
        div = document.getElementById('division').value;
        document.getElementById('co').value = co;
        document.getElementById('di').value = div;
        document.getElementById('type').value = 2;
        document.getElementById('form2').submit();
       return false;
   }

   function delet(a = ''){
    if(confirm('Are you sure you want to delete this record!')){
        if(a !== ''){
            document.getElementById('chosen').value = a;
            //alert(a);
            }
            co = document.getElementById('court').value;
            div = document.getElementById('division').value;
            document.getElementById('co').value = co;
            document.getElementById('di').value = div;
            document.getElementById('type').value = 3;
            document.getElementById('form2').submit();
    }
       return false;
   }


    function editfunc(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q)
    {
        document.getElementById('contracttype').value = a;
        document.getElementById('Company').value = b;
        document.getElementById('pvno').value = c;
        document.getElementById('payment').value = d;
        document.getElementById('payment_desc').value = e;
        document.getElementById('wht_val').value = f;
        document.getElementById('wht_perc').value = g;
        document.getElementById('vat_val').value = h;
        document.getElementById('vat_perc').value = i;
        document.getElementById('amtpayable').value = j;
        document.getElementById('prepareby').value = k;
        document.getElementById('liabilityby').value = l;
        document.getElementById('allocationtype').value = m;
        document.getElementById('economiccode').value = n;
        document.getElementById('dateprepared').value = o;
        document.getElementById('bbf').value = q;

        document.getElementById('paymentTransID').value = p;
        // document.getElementById('dateawd').value = g;
        $("#editModal").modal('show')
    }

    function accept(a  = ""){
        var form = document.getElementById('editpartModal');
        if(a != ""){
            document.getElementById('paymentTransID').value = a
        }
 
        document.getElementById('reason').value = 1;
        form.submit();
        return false;
    }

    function decline(a  = ""){
        
        if(a != ""){
            document.getElementById('chosen1').value = a
        }
       
        $("#declineModal").modal('show')
        return false;
    }

    function deletefunc(x){
        //$('#deleteid').val() = x;
        
        document.getElementById('deleteid').value = x;
        $("#DeleteModal").modal('show');
    }

function restorefunc(x){
        
        document.getElementById('restoreid').value = x;
        $("#RestoreModal").modal('show');
    }
    
    function getDivisions()
    {
        document.getElementById('status').value = "";
        if($('#court').val() !== "")
        {
            $('#form1').submit();
        }
    }

    function getStaff()
    {
        document.getElementById('status').value = "";
        if($('#division').val() !== ""){
            $('#form1').submit();
        }
    }

    function getTable()
    {
        if($('#status' ).val() !== ""){
            $('#form1').submit();
        }
    }

    function checkForm()
    {
        var court = $('#court').val();
            division = $('#division').val();
            fileno = $('#fileNo').val();
            fname = $('#fname').val();
            oname = $('#oname').val();
            sname = $('#sname').val();
            desc = $('#cvdesc').val();
            amount = $('#amount').val();
            if(court == ""){
                alert('You have empty fields!');
            } else {
                if(division == ""){
                    alert('You have empty fields');
                } else {
                    if(fileno == ""){
                        alert('you have empty fields!');
                    } else {
                        if(fname == ""){
                            alert('you have empty fields!'); 
                        } else {
                            if(oname == ""){
                                alert('you have empty fields');
                            } else {
                                if(sname == ""){
                                    alert('you have empty fields!');
                                } else {
                                    if(desc == ""){
                                        alert('you have empty fields!');
                                    } else {
                                        if(amount == ""){
                                            alert('you have empty fields!');
                                        } else {
                                           $('#form1').submit();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return false;
    }
</script>
@stop

