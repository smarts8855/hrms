@extends('layouts.layout')

@section('pageTitle')
Staff List
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
        <div class="col-sm-12">
        <h2 class="text-center"></h2>

       <h3 class="text-center">Staff Payment List</h3>

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
              <th>Beneficiary </th>
              <th class="text-center">Amount ( &#8358;)</th>
              <th>Account No</th>
              <th>Bank</th>
             
            </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($staff as $list)
          <tr>
            
            <td>{{$key++}}</td>
            <td>{{$list->beneficiaryDetails}}</td>
            <td class="text-center">{{number_format($list->amount,2)}}</td>
            <td>{{$list->accountNo}}</td>
            <td>{{$list->bank}}</td>
           
          </tr>

         @endforeach
          
          </tbody>
        </table>
       
      </form>
        </div>
        <br />
        
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>

 


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

