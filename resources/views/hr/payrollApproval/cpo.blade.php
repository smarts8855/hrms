<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>JUDICIAL INTEGRATED PERSONNEL AND PAYROLL MANAGEMENT SYSTEM
...::...Payroll Report</title>

<style type="text/css">

</style>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
 <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}">
 </script>
  <script src="{{ asset('assets/js/jQuery-2.2.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</head>


<body>
<div align="center">
  <h2>JUDICIAL INTEGRATED PERSONNEL AND PAYROLL MANAGEMENT SYSTEM
<br />
        PAYROLL<br />
</h2>
</div>

<div class="col-md-12">
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


<table class="" border="1" cellpadding="4" cellspacing="0">
  <tr>
   <td width="44" rowspan="2" align="center" valign="middle"><strong>FILE NO</strong></td>
    <td width="271" rowspan="2" align="center" valign="middle"><strong>NAME</strong></td>
    <td width="23" rowspan="2" align="center" valign="middle"><strong>GL</strong></td>
    <td width="23" rowspan="2" align="center" valign="middle"><strong>ST</strong></td>
    <td colspan="10" align="center" valign="top"><strong>EARNINGS</strong></td>
    <td colspan="5" align="center" valign="top"><strong>DEDUCTIONS</strong></td>
    <td width="80" rowspan="2" align="center" valign="middle"><strong>TOTAL EARNING</strong></td>
    <td width="70" rowspan="2" align="center" valign="middle"><strong>TOTAL DEDUCTION.</strong></td>
   <td width="70" rowspan="2" align="center" valign="middle"><strong>NETPAY</strong></td>
  </tr>
  <tr>
    <td width="75" align="center" valign="middle"><strong>BS</strong></td>
    <td width="96" align="center" valign="middle"><strong>HA</strong></td>


    <td width="90" align="center" valign="middle"><strong>TR</strong></td>
    <td width="67" align="center" valign="middle"><strong>FUR</strong></td>
    <td width="41" align="center" valign="middle"><strong>PEC</strong></td>
    <td width="82" align="center" valign="middle"><strong>UTI</strong></td>
    <td width="43" align="center" valign="middle"><strong>DR</strong></td>
    <td width="66" align="center" valign="middle"><strong>SER</strong></td>
    <td width="38" align="center" valign="middle"><strong>ARREARS</strong></td>
    <td width="52" align="center" valign="middle"><strong>OTHER</strong></td>

    <td width="74" align="center" valign="middle"><strong>TAX</strong></td>
    <td width="50" align="center" valign="middle"><strong>PENSION</strong></td>

    <td width="85" align="center" valign="middle"><strong>NHF</strong></td>
    <td width="85" align="center" valign="middle"><strong>ARREARS</strong></td>
    <td width="80" align="center" valign="middle"><strong>OTHER/DEDUCT.</strong></td>

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
  @endphp


  @foreach ($payroll_detail as $reports)
 @php
$fileNo = str_replace("/", "-", $reports->fileNo);
  @endphp
  <tr>
  <td align="right" >{{ $reports->fileNo }}</td>
  <td align="left" valign="middle" nowrap="nowrap">{{ $reports->name }}</td>
  <td width="23" align="center" valign="middle"> {{ $reports->grade }}</td>
  <td width="23" align="center" valign="middle">{{$reports->step}}</td>
  <td width="75" align="right"><?php $bstotal += $reports->Bs; ?> {{number_format($reports->Bs, 2, '.', ',')}}</td>
  <td width="96" align="right"><?php $hatotal += $reports->HA;  ?> {{number_format($reports->HA, 2, '.', ',')}}</td>

  <td width="90" align="right"> <?php $trtotal += $reports->TR; ?> {{number_format($reports->TR, 2, '.', ',') }}</td>

  <td width="67" align="right"><?php $furtotal += $reports->FUR; ?> {{number_format($reports->FUR,2, '.', ',') }}</td>
  <td width="41" align="right" valign="middle"><?php $pectotal += $reports->PEC;?> {{ number_format($reports->PEC, 2, '.', ',') }}</td>
  <td width="82" align="right"><?php $utitotal += $reports->UTI;?> {{ number_format($reports->UTI, 2, '.', ',')}}</td>
  <td width="82" align="right"><?php $drtotal += $reports->DR;?> {{ number_format($reports->DR, 2, '.', ',')}}</td>
  <td width="43" align="right"><?php $sertotal += $reports->SER; ?> {{number_format($reports->SER, 2, '.', ',')}}</td>
@if($reports->AEarn == "")
  <td width="66" align="right"><?php $e_arrearstotal += $reports->AEarn;?>{{number_format($reports->AEarn, 2, '.', ',')}}</td>
  @else
<td width="66" align="right"><?php $e_arrearstotal += $reports->AEarn;?><a href="{{url("/payrollReport/arrears/$reports->courtID/$fileNo/$reports->year/$reports->month")}}" target="_blank">{{number_format($reports->AEarn, 2, '.', ',')}}</a></td>
   @endif
  <td width="38" align="right"><?php $e_otherstotal += $reports->OEarn;?> {{number_format($reports->OEarn, 2, '.', ',')}}</td>

  <td width="52" align="right"><?php $taxtotal += $reports->TAX;?> {{number_format($reports->TAX, 2, '.', ',')}}</td>
  <td width="74" align="right"><?php $pentotal += $reports->PEN;?> {{number_format($reports->PEN, 2, '.', ',')}}</td>
  <td width="50" align="right"><?php $nhftotal += $reports->NHF;?> {{number_format($reports->NHF, 2, '.', ',')}}</td>

   @if($reports->AD == "")
  <td width="85" align="right"><?php $d_arrearstotal += $reports->AD;?> {{number_format($reports->AD, 2, '.', ',')}}</td>
  @else
  <td width="85" align="right"><?php $d_arrearstotal += $reports->AD;?>
    <a href="{{url("/payrollReport/arrears/$reports->courtID/$fileNo/$reports->year/$reports->month")}}" target="_blank">
    {{number_format($reports->AD, 2, '.', ',')}}
    </a>
  </td>
  @endif
  <td width="85" align="right"><?php $d_othertotal += $reports->OD;?> {{number_format($reports->OD, 2, '.', ',')}}</td>
  <td width="80" align="right"><?php $earntotal += $reports->TEarn;?> {{number_format($reports->TEarn, 2, '.', ',')}}</td>
  <td width="82" align="right"><?php $deducttotal += $reports->TD;?> {{number_format($reports->TD, 2, '.', ',')}}</td>
  <td width="82" align="right"><?php $netpaytotal += $reports->NetPay;?> {{number_format($reports->NetPay, 2, '.', ',')}}</td>
  </tr>

  


  
  @endforeach
  <tr><td colspan="4" align="right"><strong>TOTAL</strong></td>

  <td align="right"><strong>{{ number_format($bstotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($hatotal, 2, '.', ',') }} </strong></td>


  <td align="right"><strong>{{ number_format($trtotal, 2, '.', ',') }} </strong></td>
  <td align="right"><strong>{{ number_format($furtotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($pectotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($utitotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($drtotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($sertotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($e_arrearstotal, 2, '.', ',') }} </strong></td>
  <td align="right"><strong>{{ number_format($e_otherstotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($taxtotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($pentotal, 2, '.', ',') }} </strong></td>

  <td align="right"><strong>{{ number_format($nhftotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{  number_format($d_arrearstotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($d_othertotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($earntotal, 2, '.', ',') }}</strong></td>

  <td align="right"><strong>{{ number_format($deducttotal, 2, '.', ',') }}</strong></td>
  <td align="right"><strong>{{ number_format($netpaytotal, 2, '.', ',') }}</strong></td>
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

 </table>
</div>
<!-- Table Key -->


<br>
  <div >
                        <h2>  <a  class= "no-print" type="submit" class="btn btn-success btn-sm pull-right" href = "{{ url()->previous()  }}">Back</a>
                        </h2></div>
<div align="center">
@if(count( $payroll_detail ) > 0)
 <input type="submit"  value="Process" class="btn btn-success" id="btn" />
 @endif

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
        @foreach($comments as $list)
          <div class="comment" style="border-bottom: dashed;">
            <p>
              <strong>{{$list->name}}: </strong> On {{date('jS F Y', strtotime($list->updated_at))}} Says,<span></span>
            </p>
            <p>{{$list->comment}}</p>
          </div>
        @endforeach
        <form method="post" action="{{url('/payroll/cpo')}}" style="margin-top:10px;">
          {{ csrf_field() }}
          <input type="hidden"  value="{{$year}}" name="year" class="btn btn-success" />
          <input type="hidden"  value="{{$month}}" name="month" class="btn btn-success" />
          <!--<input type="hidden"  value="{{$court}}" name="court" class="btn btn-success" />-->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="month">Remark</label>
               <textarea name="remark" class="form-control" required></textarea>
              </div>
            </div>
            <div class="col-md-12 refer">
              <div class="form-group">
                <label for="month">Refer To  <span style="color:red; font-weight: bold;">Please, select who will take action</span></label>
                <select name="attension" class="form-control" required>
                  <option value="">Select</option>
                  <option value="ES">ES: Executive Secretary</option>
                  <option value="DFA">DFA: Director, Finance and Account</option>
                  <option value="DDFA">DDFA: Deputy Director, Finance and Account</option>
                  <option value="CA">CA: Chief Accountant</option>
                  <option value="return">return for Recomputation</option>
                  <!--<option value="FA">Final Approval</option>-->
                </select>
              </div>
            </div>
          </div>
          @if ($CourtInfo->courtstatus==1)
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Court</label>
                <select name="court" id="court" class="form-control" style="font-size: 13px;" required>
                  <option value="">Select Court</option>
                  @foreach($courts as $court)
                    @if($court->id == session('anycourt'))
                      <option value="{{$court->id}}" selected="selected">{{$court->court_name}}</option>
                    @else
                      <option value="{{$court->id}}" @if(old('court') == $court->id) selected @endif>{{$court->court_name}}</option>
                    @endif
                  @endforeach
                </select>

              </div>
            </div>
          @else
            <input type="hidden" id="court" name="court" value="{{$CourtInfo->courtid}}">
          @endif

          <input type="submit" class="btn btn-success proceed" name="submit" value="Clear and Proceed" />

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
<script type="text/javascript">
    $(document).ready(function(){
        $("#btn").click(function(){
            $("#myModal").modal('show');
        });
    });

    /*$(document).ready(function(){
        $(".refer").hide();
        $(".proceed").hide();
        $(".audit").click(function(){
            $(".proceed").show();
            $(".audit").hide();
            $(".refer").show();

        });
    });*/
</script>
</body>
</html>