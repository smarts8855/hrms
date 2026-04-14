@extends('layouts.layout')

@section('pageTitle')
Generated Payment
@endsection

@section('content')
    <div class="modal">I'm the Modal Window!</div>
<div class="box-body">

    <div class="box-body hidden-print">
    <div class="row">
      <div class="col-sm-12">
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> <br />
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif

        @if(session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> <br />
          {{ session('msg') }}
        </div>                        
        @endif

        @if(session('err'))
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Operation Error !</strong> <br />
          {{ session('err') }}
        </div>                        
        @endif
      </div>
    </div><!-- /row -->
  </div><!-- /div -->


  <div class="box-body">
        <div class="col-sm-12 hidden-print">
         <h2 class="text-center">{{$company->companyName}}</h2>
       <h3 class="text-center">Generated Payment</h3>

         <br /> 

        <!--search all vouchers-->
        <div class="row hidden-print">
            <div class="col-sm-6">

            </div>

          <div class="col-sm-6">
          
         </div>
        </div>
        <!--Search all vouchers-->

         <!-- 1st column -->
      
      
      <br />
      <div>
        <form action="{{url('/cpo/confirm')}}" method="post">
            {{ csrf_field() }}
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Beneficiary</th>
              <th class="text-center">Amount ( &#8358;)</th>
              <th>Account No</th>
              <th>Bank</th>
              <th colspan="3"> Select Appropriate <span>Un Check All</span> <input type="checkbox" class="check" name="checkAll" id="checkAll" checked/> </th>
            </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($audited as $list)
             @php
             $v = DB::table('tblVATWHTPayee')
             ->join('tblbanklist','tblbanklist.bankID','=','tblVATWHTPayee.bankid')
             ->where('ID','=',$list->VATPayeeID)->first();
             $w = DB::table('tblVATWHTPayee')
             ->join('tblbanklist','tblbanklist.bankID','=','tblVATWHTPayee.bankid')
             ->where('ID','=',$list->WHTPayeeID)->first();
              //$v = DB::table('tblbanklist')->where('bankID','=',$list->VATPayeeID)->first();
              if($list->companyID == 13)
              {
               $beneficiary = $list->payment_beneficiary;
              }
              else
              {
              $beneficiary = $list->contractor;
              }
              
             @endphp
          <tr>
            <input type="hidden" name="id[]"  value="{{$list->transID}}"/>
            <input type="hidden" name="contractor[]"  value="{{$beneficiary}}"/>
            <input type="hidden" name="amount[]"  value="{{$list->amtPayable}}"/>
            <input type="hidden" name="accountNo[]"  value="{{$list->AccountNo}}"/>
            <input type="hidden" name="bank[]"  value="{{$list->bank}}"/>
            <input type="hidden" name="bankBranch[]"  value="{{$list->bank_branch}}"/>
              <input type="hidden" name="vatAmount[]"  value="{{$list->VATValue}}"/>
              <input type="hidden" name="whtAmount[]"  value="{{$list->WHTValue}}"/>
            <input type="hidden" name="purpose[]"  value="{{$list->paymentDescription}}"/>
            @if(count((array)$v) !=0)
              <input type="hidden" name="vatPayee[]"  value="@if($v->payee != ''){{$v->payee}} @endif"/>
              <input type="hidden" name="vatBranch[]"  value="{{$v->bank_branch}}"/>
              <input type="hidden" name="vatBank[]"  value="{{$v->bank}}"/>
               <input type="hidden" name="vatAccount[]"  value="{{$v->accountno}}"/>
               <input type="hidden" name="vatSortCode[]"  value="{{$v->sort_code}}"/>
               @else
               <input type="hidden" name="vatPayee[]"  value=""/>
              <input type="hidden" name="vatBranch[]"  value=""/>
              <input type="hidden" name="vatBank[]"  value=""/>
               <input type="hidden" name="vatAccount[]"  value=""/>
               <input type="hidden" name="vatSortCode[]"  value=""/>
               @endif
               
              @if(count((array)$w) !=0)
              <input type="hidden" name="whtPayee[]"  value="{{$w->payee}} "/>
              
              <input type="hidden" name="whtBranch[]"  value="{{$w->bank_branch}}"/>
              
              <input type="hidden" name="whtBank[]"  value="{{$w->bank}}"/>

             
              <input type="hidden" name="whtAccount[]"  value="{{$w->accountno}}"/>
              
              <input type="hidden" name="whtSortCode[]"  value="{{$w->sort_code}}"/>
              @else
              <input type="hidden" name="whtPayee[]"  value=""/>
              
              <input type="hidden" name="whtBranch[]"  value=""/>
              
              <input type="hidden" name="whtBank[]"  value=""/>

             
              <input type="hidden" name="whtAccount[]"  value=""/>
              
              <input type="hidden" name="whtSortCode[]"  value=""/>
              @endif


            <td>{{$key++}}</td>
            <td>@if($list->companyID == 13) {{$list->payment_beneficiary}} @else {{$list->contractor}} @endif</td>
            <td class="text-center">{{number_format($list->amtPayable,2)}}</td>
            <td>{{$list->AccountNo}}</td>
            <td>{{$list->bank}}</td>
            <td>  
              <input type="checkbox" class="ckbox" name="checkname[]" checked="checked" value="{{$list->transID}}">
            </td>
          </tr>

         @endforeach
          
          </tbody>
        </table>
        <div class="col-md-12">
        <div class="pull-right hidden-print" style="margin-right:30px;">
        {{-- <label>is this Capital Or Overhead Payment ?</label>
        <select name="contractType" class="form-control" id="contractType">
            <option value=""></option>
            <option value="1">Overhead</option>
            <option value="4">Capital</option>
        </select> --}}
        <input type="hidden" name="contractType" value="{{$audited[0]->contractTypeID}}">
        <label>Select Payment Bank</label>
        <select name="contractTypeBank" class="form-control" id="contractTypeBank">
          @foreach ($contractTypeBanks as $ctbank)
            <option value="{{$ctbank->id}}">{{$ctbank->bank}} - {{$ctbank->account_no}} ({{$ctbank->contractType}})</option>
          @endforeach
        </select>
        </div>
        </div>
        <div class="clearfix"></div>
        <br/>
     
        <input type="submit" name="submit" value="Confirm" onclick="return validate();" class="btn btn-success pull-right hidden-print confirm" style="margin-left:20px;"> &nbsp;&nbsp;
        <input type="submit" name="submit" value="Return All" class="btn btn-success pull-right hidden-print" id="returnAll"> &nbsp;&nbsp;
      </form>
        </div>
        <br />
        
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>

  <!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <div id="desc"></div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<!--///// end modal -->


  @endsection

  @section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

  <style type="text/css">
    .status
    {
      font-size: 15px;
      padding: 0px;
      height: 100%;
     
    }

    .textbox { 
    border: 1px;
    background-color: #66FFBA; 
    outline:0; 
    height:25px; 
    width: 275px; 
  } 


  .autocomplete-suggestions{
    color:#66FFBA;
    height:125px; 
  }
    .table,tr,td{
        border: #9f9f9f solid 1px !important;
        font-size: 12px !important;
    }
     .table thead tr th
     {
      font-weight: 700;
      font-size: 17px;
      border: #9f9f9f solid 1px 
     }
  </style>
  @endsection
  
  
  @section('scripts')
  <script type="text/javascript">
  $(document).ready(function(){
  
$('.ckboxNotUsed').on('click',function(){
  var id = $(this).val();
 var ischecked = $(this).is(":checked");
  //alert(ischecked);

 $.ajax({
 // headers: {'X-CSRF-TOKEN': $token},
  url: "{{ url('update/pay-generated') }}",
  type: "post",
  data: {'transID':id,'ischecked':ischecked, '_token': $('input[name=_token]').val()},
  success: function(data){
     // console.log(data);
  //location.reload(true);
  }
});

});
 });
 
</script>

<script>
$(document).ready(function(){
  $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

$("#checkAll").click(function () {
    
var totalCheckboxes = $('input:checkbox').length;

});

});

</script>

<script>
     
</script>

<script>
   $(document).ready(function(){
  
 $('.confirm').click(function(){
 
var ctype = $("#contractType").val();


 
});
});
</script>
  
@endsection


