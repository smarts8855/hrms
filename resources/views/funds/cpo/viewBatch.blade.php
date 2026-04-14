@extends('layouts.layout')

@section('pageTitle')
E-payment For Batch : {{$current_batch}}
@endsection

@section('content')
<div class="box-body">

    <div class="box-body">
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
        <div class="col-sm-12">
      <h2 class="text-center hidden-print">{{$company->companyName}}</h2>
       <h3 class="text-center">Batch Payment List ({{$current_batch}})</h3>

      <br /> 

        

         <!-- 1st column -->
      
      
      <br />

        @if($status->mandate_status !=3)

                <div class="alert alert-warning alert-dismissible" role="alert">

                    <strong>This Mandate Cannot be printed. Reason: Awaiting Approval</strong> <br />

                </div>
            @endif
      <div>
        <form action="{{url('/cpo/restore')}}" method="post">
            {{ csrf_field() }}
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Beneficiary</th>
              <th class="text-center">Amount ( &#8358;)</th>
              <th class="text-center">VAT<br /> &#8358;</th>
              <th class="text-center">TAX<br /> &#8358;</th>
              <th>Account No</th>
              <th>Bank</th>
             </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($audited as $list)
          <tr>       
            <td>{{$key++}}</td>
            <td>{{$list->contractor}}</td>
            <td class=" text-right" style="">{{number_format($list->amount,2)}}</td>
            <td class="text-right">{{number_format($list->VATValue,2)}}</td>
            <td class="text-right">{{number_format($list->WHTValue,2)}}</td>
            <td>{{$list->accountNo}}</td>
            <td>{{$list->bank}}</td>
           
          </tr>
         @endforeach
          <tr>       
            <td><strong>TOTAL</strong></td>
            <td></td>
            <td class="text-right"><strong>{{number_format($sum,2)}}</strong></td>
            <td class="text-right"><strong>{{number_format($vatSum,2)}}</strong></td>
            <td class="text-right"><strong>{{number_format($whtSum,2)}}</strong></td>
            <td></td>
            <td></td>
           
          </tr>
          </tbody>
        </table>
             </form>
        </div>
        <br />
        
      <!-- /.col -->
      
      
      <!-- print and back buttons -->

<div class="button-wrapper hidden-print" style="margin-bottom: 30px; margin-top:0px;">

	<div class="col-md-2 pull-left">
		<a href="{{ URL::previous() }}" class="btn btn-success">Go Back</a>
	</div>
	<div class="col-md-2 pull-right">
		<a href="#" class="btn btn-success print-window">Print</a>
	</div>

</div>

<!-- End print and back buttons -->
      
      
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
  $('.autocomplete-suggestions').css({
    color: 'red'
  });

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

@php
        if($status->mandate_status != 3)
        {
        echo '<style type="text/css" media="print">
            body
            {
                display: none;
                visibility: hidden;
            }
        </style>';
}
        @endphp

  @endsection

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/js/daterangepicker.js')}}"></script>
  <script type="text/javascript">
  
    $('.print-window').click(function() {
    window.print();
    });
  
    $( function() {
      $("#dateTo").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true, 
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#dateTo").val(dateFormatted);
          },
    });

  } );

$( function() {
      $("#dateFrom").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true, 
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#dateFrom").val(dateFormatted);
          },
    });

  } );

  </script>

    @php
    if($status->mandate_status != 3)
    {
          echo '<script type="text/javascript">
    $(document).ready(function(){

        function copyToClipboard() {
  // Create a "hidden" input
  var aux = document.createElement("input");
  // Assign it the value of the specified element
  aux.setAttribute("value", "Você não pode mais dar printscreen. Isto faz parte da nova medida de segurança do sistema.");
  // Append it to the body
  document.body.appendChild(aux);
  // Highlight its content
  aux.select();
  // Copy the highlighted text
  document.execCommand("copy");
  // Remove it from the body
  document.body.removeChild(aux);
  //ert("Print screen desabilitado.");
}

$(window).keyup(function(e){
  if(e.keyCode == 44){
    copyToClipboard();
  }
});




    });

    $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });
</script>';
}
@endphp


  @endsection