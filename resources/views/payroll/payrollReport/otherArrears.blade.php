@extends('layouts.layout')
@section('content')
<div class="box-body">
  <div>
    <div class="col-md-12">
      @php
      function dateDiff($date2, $date1)
     {
      list($year2, $mth2, $day2) = explode("-", $date2);
      list($year1, $mth1, $day1) = explode("-", $date1);
      if ($year1 > $year2) dd('Invalid Input - dates do not match');
      //$days_month = 0;
      $days_month = cal_days_in_month(CAL_GREGORIAN, $mth1, $year1);
      $day_diff = 0;

      if($year2 == $year1){
        $mth_diff = $mth2 - $mth1;
      }
      else{
        $yr_diff = $year2 - $year1;
        $mth_diff = (12 * $yr_diff) - $mth1 + $mth2;
      }
      if($day1 > 1){
        $mth_diff--;
        //dd($mth1.",".$year1);
        $day_diff = $days_month - $day1 + 1;
      }

      $result = array('months'=>$mth_diff, 'days'=> $day_diff, 'days_of_month'=>$days_month);
      return($result);
    }
     list($year1, $mth1, $day1) = explode("-", $oarrears->dueDate);
    $days_month = cal_days_in_month(CAL_GREGORIAN, $mth1, $year1);
   
    $basic     = $oarrears->newBasic - $oarrears->oldBasic;
    $peculiar  = $oarrears->newPeculiar - $oarrears->oldPeculiar;
    $leave     = $oarrears->newLeave_bonus - $oarrears->oldLeave_bonus;
    $pension   = $oarrears->newPension - $oarrears->oldPension;
    $tax       = $oarrears->newTax - $oarrears->oldTax;
    $nhf       = $oarrears->newNhf - $oarrears->oldNhf;
    $transport       = $oarrears->newTransport - $oarrears->oldTransport;
    $meal       = $oarrears->newMeal - $oarrears->oldMeal;
    $furniture       = $oarrears->newFurniture - $oarrears->oldFurniture;
    $servant       = $oarrears->newServant - $oarrears->oldServant;
     $housing       = $oarrears->newHousing - $oarrears->oldHousing;
    $driver      = $oarrears->newDriver - $oarrears->oldDriver;
    $utility       = $oarrears->newUtility - $oarrears->oldUtility;
    $union     = $oarrears->newUnionDues - $oarrears->oldUnionDues;
    $diff      = dateDiff($oarrears->date, $oarrears->dueDate);
    $months    = $varimonth['months'];// $diff['months'];
    //$earnvariation = ($basic + $peculiar + $leave) * $months;
     //$deductvariation =($tax + $nhf + $union + $pension) * $months;

     //$months    = $diff['months']-1;
    //$earnvariation = (($basic + $peculiar + $leave + $driver + $utility + $servant + $furniture + $meal + $transport + $housing) * $months) +  (($basic + $peculiar + $leave + $driver + $utility + $servant + $furniture + $meal + $transport + $housing) * ($diff['days']/$diff['days_of_month']));
     //$deductvariation =(($tax + $nhf + $union + $pension) * $months) + (($tax + $nhf + $union + $pension) * ($diff['days']/$diff['days_of_month']));
     
     $earnvariation = (($basic + $peculiar + $leave + $driver + $utility + $servant + $furniture + $meal + $transport + $housing) * $months) +  (($basic + $peculiar + $leave + $driver + $utility + $servant + $furniture + $meal + $transport + $housing) * ($varimonth['days']/$varimonth['days_of_month']));
     $deductvariation =(($tax + $nhf + $union + $pension) * $months) + (($tax + $nhf + $union + $pension) * ($varimonth['days']/$varimonth['days_of_month']));


      @endphp

      <section>
        <div>
          <div  align="center"><span  class="banner"><h2 style="font-weight: 700;color: green">{{$courtName->court_name}}</h2></span>
            <table class="table table-bordered table-condensed" align="right">
              <tr>
                <td colspan="4"><div align="center"><strong>
                  Arrears Information </strong></div></td>
                </tr>
            
                <tr>
                  <td colspan="2"><div align="left">File No: <strong>{{$oarrears->fileNo}} </strong> <br/>
                    <span>Old Grade: <strong> {{$oarrears->oldGrade}} </strong> </span>
                    <span>Old Step: <strong> {{ $oarrears->OldStep}} </strong> </span>
                    <br />
                    <span>New Grade: <strong> {{ $oarrears->newGrade}} </strong> </span>
                    <span>New Step: <strong> {{ $oarrears->newStep}} </strong> </span>
                    <br />
                    
                 
              <span>Number of Months: <strong>{{$months}}</strong></span><br />        
              Date Printed: <strong> {{Date("F d, Y")}} </strong><br />
              Month: <strong>  {{$oarrears->month}}  </strong><br />
              Year: <strong> {{$oarrears->year}}  </strong><br />
              Division: <strong></strong></div>
            </td>
            <td colspan="2" align="right" valign="bottom"><img src="passport/{{$oarrears->year}}.jpg" width="150" /></td>
          </tr>
          <tr>
            <td colspan="4"><div align="right"><a  class= "no-print" href = "{{ url('/payslip/create') }}"></a></div></td>
          </tr> 
          <br>
          <br>
          <tr>
            <td><strong>Arrears Earnings</strong><br /></td>
            <td><div align="center"><strong>Old Amount</strong></div></td>
            <td><div align="center"><strong>New Amount</strong></div></td>
            <td><strong>Variation</strong></td>
          </tr>
          <tr>
            <td>Basic</td>
            <td>{{number_format($oarrears->oldBasic, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newBasic, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newBasic - $oarrears->oldBasic, 2, '.', ',')}}</td>
          </tr>
           
           <tr>
            <td>Utility</td>
            <td>{{number_format($oarrears->oldUtility, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newUtility, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newUtility - $oarrears->oldUtility, 2, '.', ',')}}</td>
          </tr>

           <tr>
            <td>Transport</td>
            <td>{{number_format($oarrears->oldTransport, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newTransport, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newTransport - $oarrears->oldTransport, 2, '.', ',')}}</td>
          </tr>

           <tr>
            <td>Housing</td>
            <td>{{number_format($oarrears->oldHousing, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newHousing, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newHousing - $oarrears->oldHousing, 2, '.', ',')}}</td>
          </tr>

            <tr>
            <td>Servant</td>
            <td>{{number_format($oarrears->oldServant, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newServant, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newServant - $oarrears->oldServant, 2, '.', ',')}}</td>
            </tr>

            <tr>
            <td>Meal</td>
            <td>{{number_format($oarrears->oldMeal, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newMeal, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newMeal - $oarrears->oldMeal, 2, '.', ',')}}</td>
          </tr>

           <tr>
            <td>Driver</td>
            <td>{{number_format($oarrears->oldDriver, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newDriver, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newDriver - $oarrears->oldDriver, 2, '.', ',')}}</td>
          </tr>

           <tr>
            <td>Furniture</td>
            <td>{{number_format($oarrears->oldFurniture, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newFurniture, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newFurniture - $oarrears->oldFurniture, 2, '.', ',')}}</td>
          </tr>

          <tr>
            <td>Peculiar</td>
            <td>{{number_format($oarrears->oldPeculiar, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newPeculiar, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newPeculiar - $oarrears->oldPeculiar, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Leave Bonus</td>
            <td>{{number_format($oarrears->oldLeave_bonus, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newLeave_bonus, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newLeave_bonus - $oarrears->oldLeave_bonus, 2, '.', ',')}}</td>
          </tr>
          
          <tr style="border: none;">
            <td>TOTAL for {{$months}} Months Arrears</td>
            <td></td>
            <td></td>
            <td><strong>{{number_format($earnvariation, 2, '.', ',')}}</strong></td>
          </tr>



          <br>
          <br>
          <tr>
            <td><strong>Arrears Deductions</strong><br /></td>
            <td><div align="center"><strong>Old Amount</strong></div></td>
            <td><div align="center"><strong>New Amount</strong></div></td>
            <td><strong>Variation</strong></td>
          </tr>
          
            <td>Tax</td>
            <td>{{number_format($oarrears->oldTax, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newTax, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newTax - $oarrears->oldTax, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Pension</td>
            <td>{{number_format($oarrears->oldPension, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newPension, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newPension - $oarrears->oldPension, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>NHF</td>
            <td>{{number_format($oarrears->oldNhf, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newNhf, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newNhf - $oarrears->oldNhf, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Union Dues</td>
            <td>{{number_format($oarrears->oldUnionDues, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newUnionDues, 2, '.', ',')}}</td>
            <td>{{number_format($oarrears->newUnionDues - $oarrears->oldUnionDues, 2, '.', ',')}}</td>
          </tr>
          <tr style="border: none;">
            <td>TOTAL for {{$months}} Months Arrears</td>
            <td></td>
            <td></td>
            <td><strong>{{number_format($deductvariation, 2, '.', ',')}}</strong></td>
          </tr>

           
        </table>
      </div>
    </section>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}">
@endsection

@section('styles')
<style type="text/css">
.table { border: 1px solid #000; font-size:16px }
.table thead > tr > th { border-bottom: none; }
.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #000; }
</style>
@endsection