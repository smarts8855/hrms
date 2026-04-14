@extends('layouts.layout')
@section('pageTitle')
Voucher Clearance 
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
        


	<!--decline modal-->
	<div id="DeclineModal" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Enter Reason for Declining the voucher</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" id="declineModalForm" 
                    role="form" method="POST" action="">
                    {{ csrf_field() }}
            <div class="modal-body">  
                <div class="form-group" style="margin: 0 10px;">
                    <div class="col-sm-12">
                    <label class="col-sm-4 pull-left">Reason for Decline</label>
                    </div>

                    <div class="col-sm-12">
                            <textarea  name="decliner" id="decliner"  class="form-control" > </textarea>
                    </div>
                    <input type="hidden" id="declineid" name="declineid" value="">
                </div>
            </div>
                <div class="modal-footer">
                    <button type="Submit" class="btn btn-success">Save Action</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                </div>
            
                </form>
            </div>
            
          </div>
        </div>
        <!--end of decline modal-->

        
       
    

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
        
       
        <!-- /.row -->
        <div class="row">     
        {{ csrf_field() }}

                
          <!-- /.col --> 
            </div>

        
            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table id="res_tab" class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                            <th>S/N</th>
                            <th>Action</th>
                           
                            <th>Beneficiary</th>
                            <th>Total Amount</th>
                            <th>Contract/Claim Description</th>
                            <th>Payment Description</th>
                            <th>Vote Description</th>
                            <th>Vote Balance</th>
                            <th>Uncleared Liability</th>
                          </tr>
                    </thead>
                    @php $i = 1; @endphp
                    <tbody>
                        @if($tablecontent)
                            @foreach($tablecontent as $list)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                    <div class="dropdown">
                                          <button class="btn btn-danger btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                            <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                          	<li><a href="/display/voucher/{{$list->ID}}" >Preview</a></li>                                  
	                                        <li><a onclick="accept('{{$list->ID}}')" href="#">Process</a></li>
	                                        <li><a href="/display/comment/{{$list->conID}}" target="_blank">View Minutes</a></li>
	                                        <li><a onclick="decline('{{$list->ID}}')" href="#">Decline</a></li>
                                        @php
		                                $path = base_path('../'). env('UPLOAD_PATH', '') .'/' . $list->ID.'.'.$list->file_ex;
		                             @endphp
		                                
		                                @if(file_exists($path))
		                                	<li><a href="/pro/file/{{$list->ID.'.'.$list->file_ex}}" target="blank" >Download File</a></li>
		                                @endif
                                         </ul>
                                        </div>
                                        </td>
                                   
                                    @if($list->voucherType== "1")
                                    <td>{{ $list->contractor}}</td>
                                    @else
                                    <td>{{ $list->beneficiary}}</td>
                                    @endif
                                    <td>{{ number_format($list->totalPayment) }}</td>                                   
                                    <td>{{ $list->ContractDescriptions }}</td>
                                    <td>{{ $list->paymentDescription }}</td>
                                    <td>{{$list->voteinfo }}</td>
                                    <td>{{ number_format($list->votebal) }}</td>
                                     <td>{{ number_format($list->OutstandingLiability) }}</td>
                                    
                                    
                                </tr>
                            @endforeach
                        @else
                            <tr>
                               <td colspan="100%">
                                   <center>No Liabilities</center>
                               </td> 
                            </tr>
                        @endif
                   
                    </tbody>                    
                </table>
        	<br><br><br><br><br><br>
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


    function editfunc(a,b,c,d,e,f,g,h,i,z,y,j,k,l,m,n,o,p,q)
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
        document.getElementById('vatpayee').value = z;
        document.getElementById('whtpayee').value = y;

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
        var form = document.getElementById('declineModalForm');
        
        
        document.getElementById('declineid').value = a
        
        
        $("#DeclineModal").modal('show');        
        return false;
    }

    function deletefunc(x){
        //$('#deleteid').val() = x;
        
        document.getElementById('deleteid').value = x;
        $("#DeleteModal").modal('show');
    }
    
    function vc(list,list1){
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
    
      $("#vim").modal('show');
      return false;
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

