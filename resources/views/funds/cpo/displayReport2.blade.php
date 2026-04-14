@extends('layouts.layout')

@section('pageTitle')
All Transaction Details
@endsection

@section('content')
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
        
        

        <!--search all vouchers-->
        <div class="row">
              
             <h2 class="text-center">{{$company->companyName}}</h2>
             <h3 class="text-center">Vouchers</h3>

            

          <div class="col-sm-6">
          
         </div>
        </div>
        <!--Search all vouchers-->

         <!-- 1st column -->
      
      
      <br />
      <div class="table-responsive">
        <form action="{{url('/cpo/report')}}" method="post">
            {{ csrf_field() }}
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Beneficiary</th>
              <th>Contract Type</th>
              <th class="text-center">Total Amount <br /> &#8358;</th>
              <!--<th class="text-center">VAT<br /> &#8358;</th>
              <th class="text-center">TAX<br /> &#8358;</th>
              <th>Account No</th>
              <th>Bank</th>-->
              <th colspan="4"> Tick the box(es) to Process Mandate</th>
            </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($audited as $list)
         @php
          $staff = DB::table('tblvoucherBeneficiary')
          ->where('voucherID', '=',$list->transID)
          ->first();
          $count = DB::table('tblvoucherBeneficiary')
          ->where('voucherID', '=',$list->transID)
          ->count();
          @endphp

          <tr>
            <input type="hidden" name="id[]"  value="{{$list->transID}}"/>
            <td>{{$key++}}</td>
            <td>@if($list->companyID ==13) {{$list->payment_beneficiary}} @else {{$list->contractor}} @endif</td>
            <td>{{$list->contractType}}</td>
            <td>{{number_format($list->totalPayment,2)}}</td>
            <!--<td>@if($list->VATValue !=0){{number_format($list->VATValue,2)}} @endif</td>
            <td>@if($list->WHTValue !=0){{number_format($list->WHTValue,2)}} @endif</td>
            <td>{{$list->AccountNo}}</td>
            <td>{{$list->bank}}</td>-->
            
            <td width="80" align="center">
              
              <input type="checkbox" name="checkname[]" value="{{$list->transID}}">
            </td>
            
              <td width="120" align="center"><a href="{{url("/display/voucher/$list->transID")}}" class="btn btn-success btn-xs">Preview Voucher</a> </td>
             <td align="center"><div class="dropdown">
                     <a class="btn btn-danger btn-xs dropdown-toggle" href="{{url("/display/comment/$list->contractID")}}">
                         Supporting Documents

                     </a>

                 </div></td>
              <td align="center"><a href="javascript:void(0)" class="btn btn-primary btn-xs reject" id="{{$list->transID}}">Reject Voucher</a> </td>
          </tr>
          
        

         @endforeach
          
          </tbody>
        </table>
        @if($totalRows > 0)
        <input type="submit" name="submit" value="Generate" class="btn btn-success pull-right">
        @endif
      </form>
        </div>
        <br />
        
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>

  <!-- Modal HTML -->
<div id="myModal" class="modal fade myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{url('/cpo/reject')}}" style="margin-top:10px;">
                    {{ csrf_field() }}
                    <input type="hidden"  value="" name="transid" class="btn btn-success id" />

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Reason for rejecting</label>
                                <textarea name="remark" class="form-control remark" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 refer">
                            <div class="form-group">
                                <label for="month">RETURN TO:  <span style="color:red; font-weight: bold;">Please, select section to return voucher</span></label>
                                <select name="attension" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="3">Audit</option>
                                    <option value="2">Checking</option>
                                    <option value="1">Expenditure Control</option>
                                    <option value="0">Other Charges</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-success proceed" name="submit" value="Reject" />

                    <div id="desc">

                    </div>
                </form>


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
  $('.autocomplete-suggestions').css({
    color: 'red'
  });

  .autocomplete-suggestions{
    color:#66FFBA;
    height:125px; 
  }
    .table,tr,th,td{
        border: #9f9f9f solid 1px !important;
        font-size: 12px !important;
    }
  </style>
  @endsection
  @section('scripts')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("table tr td .reject").click(function(){
                var id = $(this).attr('id');
                $(".id").val(id);

                $("#myModal").modal('show');

            });
        });
    </script>
@endsection
