@extends('layouts.app')
@section('pageTitle', 'Procurement')
@section('pageMenu', 'active')

@section('content')
@include('Bank.layouts.messages')
<div class="card col-9">

<div class="top card-header">
    
</div>
<div class="card-body">
<div id="print-content">
<div>
    <p>File No:<span style="color:red">AWD</span><span>{{date("Y").'/'}}{{$datas[0]->approvalID}}</span></p>
    <p>Date: {{$datas[0]->approval_date}}</p>
    <p>Contractor Name:{{$datas[0]->company_name}}</p>
    <p>Contractor Address:{{$datas[0]->address}}</p>
</div>
<div>
    <strong><center>LETTER OF AWARD</center></strong><br>
</div>
<div class="write-up">
    <p>Dear</p>
    <p>We are pleased to inform you that the contract has been awarded to you.</p><p> for execution now only
    where the Successful Bidder has been designated as the Prime Contractor and the Multiple Employer Workplace exists.</p><p> Sign, or seal if Required by company articles,
    and return the executed contract, including where the applicable Prime Contractor Agreement, to this office. Do not alter the contract(s) in any way.
    The Ministry will accept contract documents executed and then scanned and returned electronically to the Ministry</p>
    
</div>
</div>
<button class="btn btn-outline-dark" onclick="printDiv('print-content')">Print</button>
</div>

</div>
@endsection

@section('styles')
<style>
  .col-9{
      padding:0px;
      margin:0px auto;
  }
  .top{
        height:40px;
        width:100%;
        background-color:darkblue;}
    .write-up{
        line-height:150%;
        color:black;
    }
    button{
        float:right;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        w=window.open();
        w.document.write(printContents);
        w.print();
        w.close();
    }
</script>
@endsection