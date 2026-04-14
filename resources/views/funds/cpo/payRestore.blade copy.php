@extends('layouts.layout')

@section('pageTitle')
Restore Payment
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
        <div class="col-sm-12 hidden-print">
        <h2 class="text-center">{{$company->companyName}}</h2>
       <h3 class="text-center">Restore Generated Payments</h3>

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
        <form action="{{url('/cpo/restore')}}" method="post">
            {{ csrf_field() }}
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Batch</th>
              <th class="text-center">Amount ( &#8358;)</th>
              <!--<th>Account No</th>
              <th>Bank</th>-->
              <th>View Mandate</th>
              <th>Select to Restore</th>
            </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($audited as $list)
         @php
         
         $wtax   = DB::table('tblepayment')->where('batch','=',$list->batch)->sum('WHTValue');
         $vtax   = DB::table('tblepayment')->where('batch','=',$list->batch)->sum('VATValue');
         $amount = DB::table('tblepayment')->where('batch','=',$list->batch)->sum('amount');
         
         @endphp
          <tr>
             <input type="hidden" name="id[]"  value="{{$list->transID}}"/>
          
            <td>{{$key++}}</td>
            <td>@if($list->batch == ''){{$list->batch}} @else {{$list->adjusted_batch}} @endif</td>
            <td>{{number_format($amount + $vtax + $wtax,2)}}</td>
            <td><a href="{{url('/view/batch/'.$list->batch)}}" class="btn btn-success btn-xs" >Preview</a> </td>
            <td>
              
              <input type="checkbox" name="checkname[]" value="{{$list->batch}}">
            </td>
          </tr>

         @endforeach
          
          </tbody>
        </table>
       <!--<input type="submit" name="submit" value="Confirm" style="margin-left: 10px;margin-right: 10px;" class="btn btn-success pull-right hidden-print">-->
        <input type="submit" name="submit" value="Restore" class="btn btn-success pull-right">
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
  @endsection

@section('scripts')
<script src="{{asset('webFiles/js/owl.carousel.js')}}"></script>
<script src="{{asset('webFiles/js/slidebars.min.js')}}"></script>
<script src="{{asset('webFiles/js/jquery.countTo.js')}}"  type="text/javascript"></script>


<script type="text/javascript">

    $(document).ready(function() {

        //countTo

        $('.timer').countTo();

        //owl carousel

        $("#news-feed").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
            autoPlay:true
        });
    });

    $(window).on("resize",function(){
        var owl = $("#news-feed").data("owlCarousel");
        owl.reinit();
    });

</script>

@stop

