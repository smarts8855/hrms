@extends('layouts.layout')

@section('pageTitle')
 FEDERAL GOVERNMENT OF NIGERIA
	PAYMENT VOUCHER TF1
@endsection

@section('content') 
<div align="center" style="padding:0 2%;" class="mview">
    <div class="row">
          <div class="col-md-12">
              <div align="center"><h2><strong>FEDERAL GOVERNMENT OF NIGERIA</strong></h2></div>
              <div align="center"><h5><strong>PAYMENT VOUCHER</strong></h5></div>
          </div>
      </div>
     
    <table class="table table-condensed" style="background: transparent;">
                <tr>
                    <td style="border: none;"><div class="text-left">Subhead: </div></td>
                    <td style="border: none;"><div class="text-right">Treasury F1</div></td>
                </tr>
                <tr>
                    <td  style="border: none;"><div class="text-left">Classification Code: </div></td>
                    <td style="border: none;"><div class="text-right">Date Printed: {{ date('l F d, Y') }}</div></td>
                </tr>
                @if($type == 'tax')
                <tr>
                    <td style="border: none;"><div class="text-left">Payee: </div></td>
                    <td style="border: none;"><div class="text-right">{{$payeAddress}}</div></td>
                </tr>
                @else
                <tr>
                    <td style="border: none;"><div class="text-left">Payee: </div></td>
                    <td style="border: none;"><div class="text-right"><Strong>{{$record -> name}}</strong>
                  {{ $getStatus }}</div></td>
                </tr>
                @endif
                
                <tr>
                    <td style="border: none;"><div class="text-left">Departmental No NICN/PE/..........................</div></td>
                    
                </tr>
                <tr>
                   <td style="border: none;"><div class="text-left"></div></td>
                    <td style="border: none;"><div class="text-right">Bank: {{$bankName}}</div></td>
                </tr>
    </table>


      <br />
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <table class="table table-responsive table-bordered mtable">
            <thead>
              <tr>
                  <th><div align="center">Date</div></th>
                  <th><div align="center">Detailed Description of Service/Work</div></th>
                  <th><div align="center">Rate </div></th>
                  <th> &#8358;&nbsp;&nbsp;&nbsp;K</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td align="center">{{$month}} &nbsp;&nbsp; {{$year}}</td>
                <td align="left">
                    @if($determinant->addressName == "Gross Emolument")
                    
                    Being Payment to the above named {{ $getStatus }}  as Salary arrears in respect of FJSC 2020 Promotion exercise. <br/>
                    See attached for detail
                    
                    @else
                  
                  Payment to the above named Organisation being 
                  <strong>{{$determinant -> addressName}}</strong> 
                  from 
                 
                  <Strong>{{$record -> name}}</strong>
                  {{ $getStatus }}
                  as salary arears in respect of FJSC {{$year}} promotion exercise. Vide Specification overleave for details. <br />
                  NIC/P/I.............
                  @endif
                </td>
                <td colspan="2" align="center"></td>
            </tr>
            <tr>
              <td colspan="1">{{$determinant->addressName}}</td>
                <td colspan="3">
                  <div align="right">
    
                        &#8358;{{number_format($totalSum, 2, '.', ', ')}}
                      
                  </div>
                </td>
            </tr>
          </tbody>
        </table>
    </div>
    </div>
    <br />


    <table>
        <tr>
            <td>
                <table style="background: transparent;">
                        <tr>
                            <td style="border: none;"> <div><strong> PAYABLE: </strong> ABUJA</div></td>
                        </tr>
                        <tr>
                            <td  style="border: none;"><div><strong>Name:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ................................................................</div></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><div><strong>Signature:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ................................................................</div></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><div><strong>Date:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ................................................................</div></td>
                        </tr>
                        <tr>
                            <td  style="border: none;"><div><strong>Paying Officer: </strong> &nbsp;&nbsp; .......................................................</div></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><div><strong>Signature: </strong> &nbsp;&nbsp;&nbsp;&nbsp; ................................................................</div></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><div><strong> Name in Block: </strong> &nbsp;&nbsp; ..........................................................</div></td>
                        </tr>
                  </table>
            </td>
            <td>
                <table class="table table-condensed" style="border: none;">
                        <tr>
                            <td style="border: none;">
                                <span class="text-left"><strong>CERTIFICATION</strong></span>
                                <br/>
                                <div align="left" style="word-wrap: break-word; -webkit-nbsp-mode: space; -webkit-line-break: after-white-space;">
                                    I certify the above amount is correct and was incurred under the Authority quoted that the service have <br /> been dully performed, that the rate/price charged is according to regulations and correct is fair and reasonable.<br />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border: none;">
                                <strong>Amount in words:</strong> <span id="result"></span> <br><br>
                            </td>
                        </tr>
                        <tr>
                          <td>Designation: <strong>CR</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature:</td>
                        </tr>
                        <tr><td>Date:.............................................</td></tr>
                        <tr><td>Signature:........................................</td></tr>
                </table>
            </td>
        </tr>
  </table>

    <br/>
    <br/>

  </div><!--end main div=center-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/number_to_word.js') }}"></script>
    <script type="text/javascript">
    var amount = "";
     var amount = "{{number_format($totalSum, 2, '.', '')}}";
    var money = amount.split('.');
    lookup();
        function lookup()
        {
            var words;
            var naira = money[0];
            var kobo = money[1];
            
            var word1 = toWords(naira)+" naira";
            var word2 = ", "+toWords(kobo)+" kobo";
            if(kobo != "00")
                words = word1+word2;
            else
                words = word1;
                document.getElementById('result').innerHTML = words.toUpperCase();
        }
    </script> 
@endsection 
@section('styles')
<style type="text/css">
  body { font-size: 15px; font-family: verdana;  }
.table.mtable { border: 1px solid #000; font-size:16px }
.table.mtable thead > tr > th { border-bottom: none; }
.table.mtable thead > tr > th, .table.mtable tbody > tr > th, .table.mtable tfoot > tr > th, .table.mtable thead > tr > td, .table.mtable tbody > tr > td, 
.table.mtable tfoot > tr > td { border: 1px solid #000; }
.mview {background-image: url({{asset('Images/watermark.jpg')}});}
</style>
@endsection