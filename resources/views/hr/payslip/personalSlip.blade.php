@extends('layouts.layout')
@section('content')
<div class="box-body" style="background:#FFF;">

    <div class="col-md-12" style="background:#FFF;">
      <section style="background:#FFF;">

          <div  align="center"><span  class="banner"><h2 style="font-weight: 700;color: green">{{$courtName}}</h2></span>
            <table class="table table-bordered table-condensed" align="right">
              <tr>
                <td colspan="4"><div align="center"><strong>
                  STAFF PAY SLIP</strong></div></td>
                </tr>
               
                <tr>
                
                  <td colspan="2"><div align="left">File No: <strong>{{ $reports->fileNo}} </strong> 
                  @if($reports->employee_type ==3)
                   <span>Grade: <strong> CONSOLIDATED</strong> </span>
                   
                    @else
                    <span>Grade: <strong> {{ $reports->grade}} </strong> </span>
                    <span>Step: <strong> {{ $reports->step}} </strong> </span>
                    @endif
                    <br />
                    Full Name: <strong>{{ $reports->surname.' '.$reports->first_name.' '.$reports->othernames}}<br />    
                  </strong>Account No: <strong>  
                  {{$reports->AccNo}} <br />
                </strong>Bank Name: <strong> {{$bank->bank}} 
              </strong><br />        
              Date Printed: <strong> {{Date("F d, Y")}} </strong><br />
              Month: <strong>  {{$reports->month}}  </strong><br />
              Year: <strong> {{$reports->year}}  </strong><br />
             </div>
            </td>
            <td colspan="2" align="right" valign="bottom"><img src="{{asset("passport/$reports->picture")}}" width="150" /></td>
            
          </tr>
          
          <tr>
            <td colspan="4"><div align="right"><a  class= "no-print" href = "{{ url('/payslip/create') }}">Back</a></div></td>
          </tr> 
          <br>
          <br>
          
        </table>

            <div class="row">
              <div class="slip-wrapper">
                <div class="row">
                  <div class="col-xs-6 col-sm-6"><h4>EARNINGS</h4></div>
                  <div class="col-xs-6 col-sm-6"><h4>DEDUCTIONS</h4></div>
                </div>
              <div class=" col-xs-5 border" style="height:250px;">
                <div class="row">
                <div class="col-xs-6 text-left"><strong>BASIC SALARY</strong> </div>
                <div class="col-xs-6 text-right"><strong> {{number_format($reports->Bs, 2, '.', ',')}}</strong> </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>JUSU</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->PEC, 2, '.', ',')}}</strong> </div>
                </div>
                
                @if($reports->SOT != 0)
                <!--<div class="row">
                  <div class="col-xs-6 text-left"><strong>SPECIAL OVERTIME</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->SOT, 2, '.', ',')}}</strong> </div>
                </div>-->
                @endif
                <!--<div class="row">
                  <div class="col-xs-6 text-left"><strong>SERVENT</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->SER, 2, '.', ',')}}</strong> </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>DRIVER</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->DR, 2, '.', ',')}}</strong> </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>HOUSING</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->HA, 2, '.', ',')}}</strong> </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>UTILITY</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->UTI, 2, '.', ',')}}</strong> </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>FURNITURE</strong> </div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->FUR, 2, '.', ',')}}</strong> </div>
                </div>-->
                 @if($reports->AEarn != 0)
          
          <div class="row">
             <div class="col-xs-6 text-left"><strong>Arears Earning</strong></div>  
             <div class="col-xs-6 text-right"><strong>{{number_format($reports->AEarn, 2, '.', ',')}}</div>
          </div>
          
          @endif


                @if(count($other_earn) > 0 )
                  @foreach($other_earn as $list)
                    <div class="row">
                      <div class="col-xs-6 text-left" style="padding-right:0px;"><strong> {{strtoupper($list->description)}}  </strong></div>
                      <div class="col-xs-6 text-right"><strong> {{number_format($list->amount, 2, '.', ',')}}</strong></div>
                    </div>
                  @endforeach
                @endif


              </div>
                <div class="col-xs-1"></div>
              <div class="col-xs-5 border lt" style="height:250px;">
                <div class="row">
                <div class="col-xs-6 text-left"><strong>TAX</strong></div>
                <div class="col-xs-6 text-right"><strong>{{number_format($reports->TAX, 2, '.', ',')}}</strong></div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>PENSION</strong></div>
                  <div class="col-xs-6 text-right"><strong>{{number_format($reports->PEN, 2, '.', ',')}}</strong></div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong>NHF</strong></div>
                  <div class="col-xs-6 text-right"><strong>{{number_format($reports->NHF, 2, '.', ',')}}</strong></div>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left"><strong> UNION DUES  </strong></div>
                  <div class="col-xs-6 text-right"><strong> {{number_format($reports->UD, 2, '.', ',')}}</strong></div>
                </div>
                  @if($reports->AD != 0)
          
          <div class="row">
             <div class="col-xs-6 text-left"><strong>Arears Deduction</strong></div>  
             <div class="col-xs-6 text-right"><strong>{{number_format($reports->AD, 2, '.', ',')}}</div>
          </div>
          
          @endif
                @if(count($other_deduct) > 0 )
                  @foreach($other_deduct as $list)
                    <div class="row">
                      <div class="col-xs-6 text-left" style="padding-right:0px;"><strong> {{$list->description}}  </strong></div>
                      <div class="col-xs-6 text-right"><strong> {{number_format($list->amount, 2, '.', ',')}}</strong></div>
                    </div>
                  @endforeach
                @endif

              </div>
                <div class="clearfix"></div>
                <div class=" col-xs-5 border">
                  <div class="col-xs-6 text-left"><strong> TOTAL EARNING</strong></div>
                <div class="col-xs-6 text-right" style="padding-right:0px;"><strong> {{number_format($reports->TEarn, 2, '.', ',')}}</strong></div>
                </div>
                <div class="col-xs-1"></div>
                <div class=" col-xs-5 border lt l" >
                  <div class="col-xs-6 text-left"><strong> TOTAL DEDUCTION</strong></div>
                  <div class="col-xs-6 text-right" style="padding-right:0px;"><strong> {{number_format($reports->TD, 2, '.', ',')}}</strong></div>
                </div>
              </div>

              <div class="clearfix"></div>
              <div class=" col-xs-9">
                <div class="col-xs-6 text-left pr"><h3> NET EMOLUMENT FOR THE MONTH</h3></div>
                <div class="col-xs-6 text-right" style="padding-right:0px;"><h3> {{number_format($reports->NetPay, 2, '.', ',')}}</h3></div>
              </div>
            </div>

      </div>
      <div class="col-md-12" style="padding-left:1px;">
      <table width="700" border="" class="tables">
      <tr>
      <td width="150"><strong>PREPARED BY: </strong></td>
      <td></td>
      </tr>
      <tr>
      <td width="150"><strong>SIGNATURE: </strong></td>
      <td></td>
      </tr>
      </table>
      
      </div>
      <div class="col-md-2 hidden-print" style = "margin-top:20px;"><a href="javascript:0" onclick="window.print();return false;" class="btn btn-success">print</a></div>
    </section>
  </div>
</div>
</div>
@endsection
@section('scripts')
  <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
@endsection

@section('styles')
<style type="text/css">
.table { border: 1px solid #000; font-size:16px }
.table thead > tr > th { border-bottom: none; }
.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #000; }
  .slip-wrapper
  {
    border: 1px solid #333;
    padding: 15px;
    width:100%;
    float: left;
  }
  .border
  {
    border: 1px solid #333;
  }
  .tables
  {
  margin-top: 20px;
   border:none;
  }
  .tables tr td 
  {
  padding : 15px 6px;
  border:none;
  margin-bottom:10px;
  
  }

</style>
<style type="text/css" media="print">
 .col-xs-6.text-left h3, .col-xs-6.text-right h3
 {
   font-size: 16px;
 }
 .pr
 {
  padding:0px;
 }
  .col-xs-5
  {
    width:48%;
  }
  .lt{
    margin-left:2%;
  }
  .l .col-xs-6
  {
    padding:0px;
  }
  
  
</style>
@endsection