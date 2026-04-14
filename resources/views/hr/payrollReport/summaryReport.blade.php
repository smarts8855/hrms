<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>JUDICIAL INTEGRATED PERSONNEL AND PAYROLL MANAGEMENT SYSTEM
...::...Payroll Report</title>

<style type="text/css">
<!--
.style25 {  font-family: Verdana, Arial, Helvetica, sans-serif;
  color: #FF0000;
}
a:link {
  text-decoration: none;
}
a:visited {
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
a:active {
  text-decoration: none;
}
body {
  background-image: url(asset('Images/nicn_bg.jpg'));
}
.tblborder {
  border-top-width: 1px;
  border-right-width: 1px;
  border-bottom-width: 1px;
  border-left-width: 1px;
  border-top-style: dotted;
  border-right-style: dotted;
  border-bottom-style: dotted;
  border-left-style: dotted;
}

@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

body,td,th {
  font-size: 15px;
  font-family: Verdana, Geneva, sans-serif;
}
-->
</style>
 <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}">
 </script>
</head>


<body background="{{asset('Images/nicn_bg.jpg')}}">
<div align="center"><h2><div>JUDICIAL INTEGRATED PERSONNEL AND PAYROLL MANAGEMENT SYSTEM
<br />
        PAYROLL</div><br />
</h2>
</div>


<table width="1802" border="0" cellpadding="0" cellspacing="0" style="font-size:18px" >
  <tr>
    <td>Payroll P.V. No:</td>
    <td><div align="left">Sheet No:</div></td>
  </tr>
  <tr>
    <td colspan="2"><h3>MINISTRY/DEPARTMENT: JUDICIAL INTEGRATED PERSONNEL AND PAYROLL MANAGEMENT SYSTEM
, 
@if($courtname != ''){{ $courtname->court_name }} @elseif($courtDivisions != '') {{$courtDivisions->court_name}}, {{$courtDivisions->division}} @endif</h3></td>
  </tr>
  <tr>
    <td width="1294">
    <strong>MONTH ENDING:  @if(session('schmonth'))
{{ session('schmonth') }}

@endif</strong><br/>       </td>
    <td width="508" align="right"></h3>Date Printed: {{ date("l, F d, Y") }}</td>
  </tr>
  <tr>
    <td><strong>

     @if(session('bank'))
{{ session('bank') }}

@endif

</strong> </td>
    <td>&nbsp;</td>
  </tr>
</table>
 
<table class="table table-condense table-responsive" border="1" cellpadding="4" cellspacing="0">
  <tr class="th-row">
    <!--<td width="44" rowspan="2" align="center" valign="middle"><strong>FILE NO</strong></td>
    <td width="271" rowspan="2" align="center" valign="middle"><strong>NAME</strong></td>
    <td width="23" rowspan="2" align="center" valign="middle"><strong>GL</strong></td>
    <td width="23" rowspan="2" align="center" valign="middle"><strong>ST</strong></td>-->
    <td colspan="4" align="center" valign="top"><strong>EARNINGS</strong></td>
    <td colspan="6" align="center" valign="top"><strong>DEDUCTIONS</strong></td>

    <td width="70" rowspan="2" align="center" valign="middle"><strong>TOTAL DEDUCTION.</strong></td>
    <td width="70" rowspan="2" align="center" valign="middle"><strong>NET BASIC <br/> SALARY</strong></td>
    <td width="75" rowspan="2" align="center" valign ="middle"><strong> JUSU </strong></td>
    <td width="75" rowspan="2" align="center" valign ="middle"><strong> TOTAL NET <BR/> EMOLUMENT </strong></td>
  </tr>
  <tr>
    <td width="90" align="center" valign="middle"><strong>BASIC <br/> (CONSOLIDATED)</strong></td>
    


    <td width="38" align="center" valign="middle"><strong>TOTAL <BR/>ARREARS <BR/> EARNING</strong></td>
    <td width="52" align="center" valign="middle"><strong>OVERTIME/<BR/>ACT ALL.</strong></td>
    <td width="80" align="center" valign="middle"><strong>GROSS<br/> EMOLUMENT</strong></td>

    <td width="74" align="center" valign="middle"><strong>TAX</strong></td>
    <td width="50" align="center" valign="middle"><strong>PENSION</strong></td>
     <td width="50" align="center" valign="middle"><strong>UNION DUES</strong></td>
    <td width="85" align="center" valign="middle"><strong>NHF</strong></td>
    <td width="85" align="center" valign="middle"><strong>TOTAL <BR/>ARREARS <BR/>DEDUCTION</strong></td>
    <td width="80" align="center" valign="middle"><strong>COOP/ADV.</strong></td>

  </tr>

  @php
    $bstotal = 0.00;
    $hatotal = 0.00;
    $trtotal = 0;
    $furtotal = 0;
    $taxtotal = 0;
    $pectotal = 0;
    $utitotal = 0;
    $drtotal = 0;
    $sertotal = 0;
    $e_arrearstotal = 0;
    $e_otherstotal = 0;
    $pentotal = 0;
    $nhftotal = 0;
    $d_arrearstotal = 0;
    $d_othertotal = 0;
    $earntotal = 0;
    $deducttotal = 0;
    $netpaytotal = 0;
    $uniontotal = 0;
    $totalNetEmolu = 0;
  @endphp


  @foreach ($summary_detail as $reports)
    @php
      $fileNo = str_replace("/", "-", $reports->fileNo);
    @endphp
    <tr>
      <!--<td align="right" >{{ $reports->fileNo }}</td>
      <td align="left" valign="middle" nowrap="nowrap">{{ $reports->name }}</td>
      <td width="23" align="center" valign="middle"> {{ $reports->grade }}</td>
      <td width="23" align="center" valign="middle">{{$reports->step}}</td>-->
      <td width="75" align="right"><?php $bstotal += $reports->Bs; ?> {{number_format($reports->Bs, 2, '.', ',')}}</td>
      
      @if($reports->AEarn == "")
        <td width="66" align="right"><?php $e_arrearstotal += $reports->AEarn;?>{{number_format($reports->AEarn, 2, '.', ',')}}</td>
      @else
        <td width="66" align="right"><?php $e_arrearstotal += $reports->AEarn;?><a href="{{url("/con-payrollReport/arrears/$reports->courtID/$fileNo/$reports->year/$reports->month")}}" target="_blank">{{number_format($reports->AEarn, 2, '.', ',')}}</a></td>
      @endif
      <td width="38" align="right"><?php $e_otherstotal += $reports->OEarn;?> {{number_format($reports->OEarn, 2, '.', ',')}}</td>
      <td width="80" align="right" style="background:#0cf; opacity:0.8"><?php $earntotal += $reports->TEarn;?> <strong>{{number_format($reports->TEarn - $reports->PEC, 2, '.', ',')}} </strong></td>

      <td width="52" align="right"><?php $taxtotal += $reports->TAX;?> {{number_format($reports->TAX, 2, '.', ',')}}</td>
      <td width="74" align="right"><?php $pentotal += $reports->PEN;?> {{number_format($reports->PEN, 2, '.', ',')}}</td>
       <td width="74" align="right"><?php $uniontotal += $reports->UD;?> {{number_format($reports->UD, 2, '.', ',')}}</td>
      <td width="50" align="right"><?php $nhftotal += $reports->NHF;?> {{number_format($reports->NHF, 2, '.', ',')}}</td>

      @if($reports->AD == "")
        <td width="85" align="right"><?php $d_arrearstotal += $reports->AD;?> {{number_format($reports->AD, 2, '.', ',')}}</td>
      @else
        <td width="85" align="right"><?php $d_arrearstotal += $reports->AD;?>
          <a href="{{url("/con-payrollReport/arrears/$reports->courtID/$fileNo/$reports->year/$reports->month")}}" target="_blank">
            {{number_format($reports->AD, 2, '.', ',')}}
          </a>
        </td>
      @endif
      <td width="85" align="right"><?php $d_othertotal += $reports->OD;?> {{number_format($reports->OD, 2, '.', ',')}}</td>

      <td width="82" align="right" style="background:#0cf;opacity:0.8;"><?php $deducttotal += $reports->TD;?> <strong> {{number_format($reports->TD, 2, '.', ',')}}</strong></td>
      <td width="82" align="right"><?php $netpaytotal += $reports->NetPay - $reports->PEC;?> {{number_format($reports->NetPay - $reports->PEC, 2, '.', ',')}}</td>
      <td width="41" align="right" valign="middle"><?php $pectotal += $reports->PEC;?> {{ number_format($reports->PEC, 2, '.', ',') }}</td>
      <td width="82" align="right"><?php $totalNetEmolu += $reports->NetPay;?> {{number_format($reports->NetPay, 2, '.', ',')}}</td>
    </tr>

  @endforeach


  <tr>

    <td align="right"><strong>{{ number_format($bstotal, 2, '.', ',') }}</strong></td>
    
        <td align="right"><strong>{{ number_format($e_arrearstotal, 2, '.', ',') }} </strong></td>
    <td align="right"><strong>{{ number_format($e_otherstotal, 2, '.', ',') }}</strong></td>
    <td align="right"><strong>{{ number_format($earntotal, 2, '.', ',') }}</strong></td>

    <td align="right"><strong>{{ number_format($taxtotal, 2, '.', ',') }}</strong></td>
    <td align="right"><strong>{{ number_format($pentotal, 2, '.', ',') }} </strong></td>
    <td align="right"><strong>{{ number_format($uniontotal, 2, '.', ',') }} </strong></td>

    <td align="right"><strong>{{ number_format($nhftotal, 2, '.', ',') }}</strong></td>
    <td align="right"><strong>{{  number_format($d_arrearstotal, 2, '.', ',') }}</strong></td>
    <td align="right"><strong>{{ number_format($d_othertotal, 2, '.', ',') }}</strong></td>


    <td align="right"><strong>{{ number_format($deducttotal, 2, '.', ',') }}</strong></td>
    <td align="right"><strong>{{ number_format($netpaytotal, 2, '.', ',') }}</strong></td>
     <td align="right"><strong>{{ number_format($pectotal, 2, '.', ',') }}</strong></td>
     <td align="right"><strong>{{ number_format($totalNetEmolu, 2, '.', ',') }}</strong></td>
  </tr>
</table>

<h2 style="margin-top:10px; color:green; margin-left:20px;">KEY</h2>
<!--Table Key -->

<table class="table-condense table-responsive hidden-print" border="1" cellpadding="4" cellspacing="0" style="margin-left:20px;">
  <tr>
    <th scope="col">ABBREVIATION</th>
    <th scope="col">MEANING</th>
  </tr>
  <tr>
    <td>BS</td>
    <td>Basic Salary</td>
  </tr>
  <tr>
    <td>HA</td>
    <td>Housing Allowance</td>
  </tr>
  <tr>
    <td>TR</td>
    <td>Transport Furniture</td>
  </tr>
  <tr>
    <td>FUR</td>
    <td>Furniture Allowance</td>
  </tr>
  <tr>
    <td>PEC</td>
    <td>peculiar</td>
  </tr>
  <tr>
    <td>UTI</td>
    <td>Utility</td>
  </tr>
  <tr>
    <td>DR</td>
    <td>Driver Allowance</td>
  </tr>
  <tr>
    <td>SER</td>
    <td>Servant</td>
  </tr>
  <tr>
    <td>PEN</td>
    <td>Pension</td>
  </tr>
  <tr>
    <td>NHF</td>
    <td>National Housing Fund</td>
  </tr>
  
 <table>

<!-- Table Key --> 


<br>
  <div >
                        <h2>  <a  class= "no-print" type="submit" class="btn btn-success btn-sm pull-right" href = "{{ url('/payrollReport/create') }}">Back</a>
                        </h2></div>
<div align="center">
  
</div>
</body>
</html>