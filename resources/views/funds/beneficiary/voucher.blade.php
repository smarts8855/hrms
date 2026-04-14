@extends('layouts.layout')
@section('pageTitle')
   Voucher Beneficiary 
@endsection
@section('content')

@php $grossAmount = 0.0; @endphp
@foreach ($beneficaries as $t)
  @php
      $grossAmount += ($t->amount);
  @endphp
@endforeach

<div id="editModal" class="modal fade">
 <div class="modal-dialog box box-default" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Details  </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form class="form-horizontal" id="editBModal" name="editBModal"
            role="form" method="POST" action="{{url('beneficiary/voucher')}}">
            {{ csrf_field() }}
    <div class="modal-body">  
        <div class="form-group" style="margin: 0 12px;">
            <label class="control-label">Voucher</label>
             <select class="form-control" id="voucher" name="voucher"  required="">
                   <option value=""  > Choose One</option>     
                  @foreach($vouchers as $v)
                  <option value="{{$v->ID}}" {{ ($voucher) == $v->ID? "selected":"" }} >{{$v->paymentDescription}}</option>
                  @endforeach
                </select>
        </div>

        <div class="form-group" style="margin: 0 12px;">
            <label class="control-label">Beneficiary</label>
            <input type="text" class="col-sm-9 form-control" id="beneficiary" name="beneficiary" >
          
          
           
        </div>

        <div class="form-group" style="margin: 0 12px;">
            <label class="control-label">Amount (&#x20A6)</label>
            <input type="text" class="col-sm-9 form-control" id="amount" name="amount" >
          
          <input type="hidden" class="col-sm-9 form-control" id="total" name="total" >
           
        </div>

        
            
          

      <div class="form-group" style="margin: 0 12px;">
            <label class="control-label">Bank </label>
           <select class="form-control" id="bank" name="bank" required="">
                   <option value=" "  >Choose One</option>     
                  @foreach($banks as $b)
                  <option value="{{$b->bankID}}" {{ ((string)$bank) == (string)$b->bankID? "selected":"" }} >{{$b->bank}}</option>
                  @endforeach
                </select>
        </div>

        <div class="form-group" style="margin: 0 12px;">
            <label class="control-label">Account</label>
            <input type="text" class="col-sm-9 form-control" id="account" name="account" >
            <input type="hidden" class="col-sm-9 form-control" id="id" name="id">
        
        </div>
  
       
        <div class="modal-footer">
            <button type="Submit" name="edit" class="btn btn-success">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
     
        </form>
    </div>
      
          </div>
        </div>
      </div>
      
      
    <div id="delModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete</h4>
        
      </div>
      <form class="form-horizontal" id="editLgaModal" name="editLgaModal"
              role="form" method="POST" action="{{url('beneficiary/voucher')}}">
              {{ csrf_field() }}
      <div class="modal-body">  
          <div class="form-group" style="margin: 0 10px;">
              
              <h4>Are you sure you want to delete this item?</h4>
              <input type="hidden" class="col-sm-9 form-control" id="delID" name="id">
              <input type="hidden" class="col-sm-9 form-control" id="voucherID" name="voucher">
            
             
          </div>
          <div class="modal-footer">
              <button type="Submit" name="delete" class="btn btn-success">Continue ?</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
       
          </form>
      </div>
        
            </div>
          </div>
        </div>


<div class="box box-default">
  <div class="box-body box-profile">
    <div class="box-header with-border hidden-print">
      <h3 class="box-title">@yield('pageTitle') for: @foreach ($vouch as $v) {{$v->disc}} ({{$v->bene}})| Amount: ₦{{$v->totalPayment}}  Raised Date:{{$v->datePrepared}} @endforeach<span id='processing'></span></h3>
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
        
        <form class="form-horizontal" role="form" id="thisform1" name="thisform1" method="post" action="{{url('beneficiary/voucher')}}">
        {{ csrf_field() }}

        <div class="col-md-12"><!--2nd col-->
          <!-- /.row -->
          <div class="form-group">
            

            <div class="col-md-12">          
                <label class="control-label">Voucher</label>
                <select class="form-control" id="voucher" name="voucher" onchange="ReloadForm()"  required="">
                   <option value=""  > Choose One</option>     
                  @foreach($vouchers as $v)
                  <option value="{{$v->ID}}" {{ ($voucher) == $v->ID? "selected":"" }} >{{$v->disc}} ({{$v->bene}}) </option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-2">          
                <label class="control-label">Beneficiary</label>
                <input type="text" class="form-control" id="beneficiary" value="{{$beneficiary}}" name="beneficiary" placeholder="" required="">
               
            </div>

             <div class="col-md-2">
                <label class="control-label">Amount (&#x20A6)</label>
                <input type="text" class="form-control" id="amount" value="{{$amount}}" name="amount" placeholder="" required="">
                <input type="hidden" class="form-control" id="total" name="total" value="{{$grossAmount}}">

            </div>

            <div class="col-md-2">          
                <label class="control-label">Bank</label>
                <select class="form-control" id="bank" name="bank" required="">
                   <option value=""  >Choose One</option>     
                  @foreach($banks as $b)
                  <option value="{{$b->bankID}}" {{ ((string)$bank) == (string)$b->bankID? "selected":"" }}>{{$b->bank}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-2">          
                <label class="control-label">Account No</label>
               <input type="text" class="form-control" id="account" value="{{$account}}" name="account" placeholder="" required="">
            </div>

            
            
           
            


            <div class="col-md-2">
                <br>
                <label class="control-label"></label>
                <button type="submit" class="btn btn-success" name="add">
                    <i class="fa fa-btn fa-floppy-o"></i> Add
                </button>         
            </div>
        </div>
            </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->

        </form>

            <div class="table-responsive col-md-12" style="font-size: 12px; padding:10px;">
                <table class="table table-bordered table-striped table-highlight" >
                    <thead>
                        <tr bgcolor="#c7c7c7">
                               
                            
                            <th >S/N</th>
                            <th > Beneficiary</th>
                            <th > Bank</th>
                            <th > Account Number</th>
                            <th > Amount</th>
                            <th > Voucher</th>

                            <th > Action</th>   
                        </tr>
                    </thead>
                    @php $i=1;@endphp
                   
                       
                        @foreach ($beneficaries as $con)

                        <tr>
                        <td>{{$i++}}</td>
                        <td>{{$con->beneficiaryDetails}}</td>
                        <td>{{$con->bank}}</td>
                        <td>{{$con->accountNo}}</td>
                        <td>&#x20A6 {{$con->amount}} </td>
                        <td>{{$con->voucherID}}</td>
                        
                        <td>
                            <button type="button" class="btn btn-primary fa fa-edit" onclick="editfunc('{{$con->beneficiaryDetails}}', '{{$con->bankID}}', '{{$con->accountNo}}', '{{$con->amount}}', '{{$con->voucherID}}', '{{$con->ID}}','{{$grossAmount}}')" class="" id=""> Edit</button>
                            <button type="button" class="btn btn-danger fa fa-times" onclick="delfunc('{{$con->ID}}', '{{$con->voucherID}}')"></button>
                        </td>
                            
                        @endforeach
                    </tr>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th>Total</th>
                            <td>₦  {{number_format($grossAmount)}}</td>
                                  
                            <td ></td> 

                            <td></td> 
                         </tr>
                    </tfoot>
                </table>
                  <div >
                   <div class="hidden-print">{{ $beneficaries->links() }}</div>
                  Showing {{($beneficaries->currentpage()-1)*$beneficaries->perpage()+1}}
                          to {{$beneficaries->currentpage()*$beneficaries->perpage()}}
                          of  {{$beneficaries->total()}} entries
                </div>
            </div>
          
          <hr />
        </div>
       
  </div>
</div>




@endsection

@section('styles')
<style type="text/css">
    .modal-dialog {
width:15cm
}

.modal-header {

background-color: #20b56d;

color:#FFF;

}

</style>
@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>


  function  ReloadForm()
  { 
  document.getElementById('thisform1').submit();
  return;
  }

  function  ReloadForm2()
  { 
  document.getElementById('editBModal').submit();
  return;
  }

    function editfunc(a,b,c,d,e,f,g)
    {
    $(document).ready(function(){
        $('#beneficiary').val(a);
        $('#bank').val(b);
        $('#account').val(c);
        $('#amount').val(d);
        $('#voucher').val(e);
        $('#id').val(f);
        $('#total').val(g);
        $("#editModal").modal('show');
     });
    }

    function delfunc(a,b)
  {
  $(document).ready(function(){
  $('#delID').val(a);
  $('#voucherID').val(b);
  $("#delModal").modal('show');
  });
  }




    
</script>



@stop
