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
    $months    = $diff['months'];
    //$earnvariation = ($basic + $peculiar + $leave) * $months;
     //$deductvariation =($tax + $nhf + $union + $pension) * $months;
     

     //$months    = $diff['months']-1;
    $earnvariation = (($basic + $peculiar + $leave + $driver + $utility + $servant + $furniture + $meal + $transport + $housing) * $months) +  (($basic + $peculiar + $leave + $driver + $utility + $servant + $furniture + $meal + $transport + $housing) * ($diff['days']/$diff['days_of_month']));
     $deductvariation =(($tax + $nhf + $union + $pension) * $months) + (($tax + $nhf + $union + $pension) * ($diff['days']/$diff['days_of_month']));

$totalBasicArrearsNormal = $earnvariation-$deductvariation;

      @endphp
      
      <?php
      // arrears overdue
      
      ?>

      <section>
        <div>
          <div  align="center"><span  class="banner"><h2 style="font-weight: 700;color: green">{{$courtName->court_name}}</h2></span>
            <table class="table table-bordered table-condensed" align="right">
              <tr>
                <td colspan="4"><div align="center"><strong>
                  Arrears Information </strong></div></td>
                </tr>
            
                <tr>
                  <td colspan="2"><div align="left">File No: <strong>{{$fn->fileNo}} </strong> <br/>
                  @if($oarrears->oldGrade ==0 && $oarrears->OldStep ==0)
                  <span><strong> New Appointment  </strong> </span>
                  @else
                    <span>Old Grade: <strong> {{$oarrears->oldGrade}} </strong> </span>
                    <span>Old Step: <strong> {{ $oarrears->OldStep}} </strong> </span>
                    @endif
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
            <td align="center"><strong>Variation</strong></td>
          </tr>
          <tr>
            <td>Basic</td>
            <td align="center">{{number_format($oarrears->oldBasic, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newBasic, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newBasic - $oarrears->oldBasic, 2, '.', ',')}}</td>
          </tr>
           

          <tr>
            <td>JUSU</td>
            <td align="center">{{number_format($oarrears->oldPeculiar, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newPeculiar, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newPeculiar - $oarrears->oldPeculiar, 2, '.', ',')}}</td>
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
            <td align="center"><strong>Variation</strong></td>
          </tr>
          
            <td>Tax</td>
            <td align="center">{{number_format($oarrears->oldTax, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newTax, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newTax - $oarrears->oldTax, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Pension</td>
            <td align="center">{{number_format($oarrears->oldPension, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newPension, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newPension - $oarrears->oldPension, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>NHF</td>
            <td align="center">{{number_format($oarrears->oldNhf, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newNhf, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newNhf - $oarrears->oldNhf, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Union Dues</td>
            <td align="center">{{number_format($oarrears->oldUnionDues, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newUnionDues, 2, '.', ',')}}</td>
            <td align="center">{{number_format($oarrears->newUnionDues - $oarrears->oldUnionDues, 2, '.', ',')}}</td>
          </tr>
          <tr style="border: none;">
            <td>TOTAL for {{$months}} Months Arrears</td>
            <td></td>
            <td></td>
            <td><strong>{{number_format($deductvariation, 2, '.', ',')}}</strong></td>
          </tr>

           
        </table>
        
        
                 
         
      </div>
      @php
      $totalBasicArrearsOverDue =$totalBasicArrearsNormal ;
      @endphp
      @if($overDues != '')
      @foreach($overDues as $overDue)
      <?php
      $total= 0;
      list($year2, $mth2, $day2) = explode("-", $overDue->dueDate);
    $days_monthOverDue = cal_days_in_month(CAL_GREGORIAN, $mth2, $year2);
   
    $basicOverDue     = $overDue->newBasic - $overDue->oldBasic;
    $peculiarOverDue  = $overDue->newPeculiar - $overDue->oldPeculiar;
    $leaveOverDue     = $overDue->newLeave_bonus - $overDue->oldLeave_bonus;
    $pensionOverDue   = $overDue->newPension - $overDue->oldPension;
    $taxOverDue       = $overDue->newTax - $overDue->oldTax;
    $nhfOverDue       = $overDue->newNhf - $overDue->oldNhf;
    
    $transportOverDue       = $overDue->newTransport - $overDue->oldTransport;
    $mealOverDue       = $overDue->newMeal - $overDue->oldMeal;
    $furnitureOverDue       = $overDue->newFurniture - $overDue->oldFurniture;
    
    $servantOverDue       = $overDue->newServant - $overDue->oldServant;
     $housingOverDue       = $overDue->newHousing - $overDue->oldHousing;
    $driverOverDue      = $overDue->newDriver - $overDue->oldDriver;
    $utilityOverDue       = $overDue->newUtility - $overDue->oldUtility;
    
    $unionOverDue     = $overDue->newUnionDues - $overDue->oldUnionDues;
    $diffOverDue      = dateDiff($overDue->overdueDate, $overDue->dueDate);
    $monthsOverDue    = $diffOverDue['months'];
    
    //$earnvariation = ($basic + $peculiar + $leave) * $months;
     //$deductvariation =($tax + $nhf + $union + $pension) * $months;
     //$months    = $diff['months']-1;
     
       
     
     
    $earnvariationOverDue = (($basicOverDue + $peculiarOverDue + $leaveOverDue + $driverOverDue + $utilityOverDue + $servantOverDue + $furnitureOverDue + $mealOverDue + $transportOverDue + $housingOverDue) * $monthsOverDue) +  (($basicOverDue + $peculiarOverDue + $leaveOverDue + $driverOverDue + $utilityOverDue + $servantOverDue + $furnitureOverDue + $mealOverDue + $transportOverDue + $housingOverDue) * ($diffOverDue['days']/$diffOverDue['days_of_month']));
     $deductvariationOverDue =(($taxOverDue + $nhfOverDue + $unionOverDue + $pensionOverDue) * $monthsOverDue) + (($taxOverDue + $nhfOverDue + $unionOverDue + $pensionOverDue) * ($diffOverDue['days']/$diffOverDue['days_of_month']));
     
  
       $totalBasicArrearsOverDue += $earnvariationOverDue-$deductvariationOverDue ;
      
     ?>
      
      <table class="table table-bordered table-condensed" align="right">
              <tr>
                <td colspan="4"><div align="center"><strong>
                  <h2>Arrears Overdue Information </h2></strong></div></td>
                </tr>
            
                <tr>
                  <td colspan="2"><div align="left">File No: <strong>{{$fn->fileNo}} </strong> <br/>
                  @if($overDue->oldGrade ==0 && $overDue->OldStep ==0)
                  <span><strong> New Appointment  </strong> </span>
                  @else
                    <span>Old Grade: <strong> {{$overDue->oldGrade}} </strong> </span>
                    <span>Old Step: <strong> {{ $overDue->OldStep}} </strong> </span>
                    @endif
                    <br />
                    <span>New Grade: <strong> {{ $overDue->newGrade}} </strong> </span>
                    <span>New Step: <strong> {{ $overDue->newStep}} </strong> </span>
                    <br />
                    
                 
              <span>Number of Months: <strong>{{$monthsOverDue}}</strong></span><br />        
              Date Printed: <strong> {{Date("F d, Y")}} </strong><br />
              Month: <strong>  {{$overDue->month}}  </strong><br />
              Year: <strong> {{$overDue->year}}  </strong><br />
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
            <td align="center"><strong>Variation</strong></td>
          </tr>
          <tr>
            <td>Basic</td>
            <td align="center">{{number_format($overDue->oldBasic, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newBasic, 2, '.', ',')}}</td>
            <td align="center"> {{number_format($overDue->newBasic - $overDue->oldBasic, 2, '.', ',')}}</td>
          </tr>
           

          <tr>
            <td>JUSU</td>
            <td align="center">{{number_format($overDue->oldPeculiar, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newPeculiar, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newPeculiar - $overDue->oldPeculiar, 2, '.', ',')}}</td>
          </tr>

          
          <tr style="border: none;">
            <td>TOTAL for {{$monthsOverDue}} Months Arrears</td>
            <td></td>
            <td></td>
            <td><strong>{{number_format($earnvariationOverDue, 2, '.', ',')}}</strong></td>
          </tr>



          <br>
          <br>
          <tr>
            <td><strong>Arrears Deductions</strong><br /></td>
            <td><div align="center"><strong>Old Amount</strong></div></td>
            <td><div align="center"><strong>New Amount</strong></div></td>
            <td align="center"><strong>Variation</strong></td>
          </tr>
          
            <td>Tax</td>
            <td align="center">{{number_format($overDue->oldTax, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newTax, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newTax - $overDue->oldTax, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Pension</td>
            <td align="center">{{number_format($overDue->oldPension, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newPension, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newPension - $overDue->oldPension, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>NHF</td>
            <td align="center">{{number_format($overDue->oldNhf, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newNhf, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newNhf - $overDue->oldNhf, 2, '.', ',')}}</td>
          </tr>
          <tr>
            <td>Union Dues</td>
            <td align="center">{{number_format($overDue->oldUnionDues, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newUnionDues, 2, '.', ',')}}</td>
            <td align="center">{{number_format($overDue->newUnionDues - $overDue->oldUnionDues, 2, '.', ',')}}</td>
          </tr>
          <tr style="border: none;">
            <td>TOTAL for {{$monthsOverDue}} Months Arrears</td>
            <td></td>
            <td></td>
            <td><strong>{{number_format($deductvariationOverDue, 2, '.', ',')}}</strong></td>
          </tr>

           
        </table>
        @endforeach
         @endif
         <div>Total Arrears Earned: <strong> {{number_format($totalBasicArrearsOverDue,2)}}</strong></div>
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
</style>
@endsection