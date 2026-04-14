<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <title> Treasure Cashbook Report </title>
    
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <style type="text/css">
            .page-margin{
                margin: 5px;
            }
        </style>
        <script type="text/javascript" src="{{ asset('assets/js/number_to_word.js') }}"></script>
    </head>
<body>
    
    
    <div class="box box-default page-margin">
        <div class="row">
            <div class="col-md-12">
                
                <div align="center" style="text-transform: uppercase;">
                    <h3>TREASURE CASHBOOK</h3>  
                    <h4>{{ isset($accountTypeName) ? $accountTypeName : 'ECONOMIC CODE EXPENDITURES' }}</h4>  
                    Printed: {{ date('F d, Y h:i:s a') }}
                </div>
                <br /><br />
                
                <table class="table table-hover table-responsive table-bordered">
                    
                    <thead>
                        {{-- Print Economic Codes --}}
                        @if(isset($getEconomicCode) && $getEconomicCode)
                        <tr style="text-transform: uppercase;">
                            <th>
                                E-Code
                                <hr />
                                Month
                            </th>
                            @foreach($getEconomicCode as $eCodeKey=>$eCode)
                                <th>
                                    <div align="center"><h6>{{ $eCode->description }} <br /> <b>({{ substr($eCode->Code, 0, 4) . $eCode->economicCode }})</b></h6></div> 
                                </th>
                            @endforeach
                            <th>
                                <div align="center"><b>Total</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Allocation</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Refund</b></div> 
                            </th>
                        </tr>
                        @endif
                    </thead>
                    
                    <tbody>
                        {{-- Print Months --}}
                         @if(isset($monthOfTheYear) && $monthOfTheYear)
                            @foreach($monthOfTheYear as $monthKey=>$month)
                            <tr>
                                <td>
                                    <div align="left"><h6>{{ $month }}</h6></div> 
                                </td>
                                {{-- Print Expenditure --}}
                                @if(isset($getEconomicCode) && $getEconomicCode)
                                    @foreach($getEconomicCode as $eCodeKey=>$eCode)
                                        <td>
                                            @if(isset($eCodeExpense) && $eCodeExpense[$month][$eCode->eCodeID])
                                                <a href="{{ (Route::has('viewPaymentDetailsFromCashbook') ? Route('viewPaymentDetailsFromCashbook', ['ec'=>$eCode->economicCode, 'eh'=>$eCode->Code, 'y'=>(isset($getYear) ? $getYear : null), 'm'=>$month]) : 'javascript') }}" title="View Details">
                                                    <div align="center" class="{{ isset($eCodeExpense) && ($eCodeExpense[$month][$eCode->eCodeID] < 0) ? 'text-danger' : 'text-info' }}"><b> {{ isset($eCodeExpense) ? number_format($eCodeExpense[$month][$eCode->eCodeID], 2) : 0.0 }} </b></div> 
                                                </a>
                                            @else
                                                <div align="center" class="{{ isset($eCodeExpense) && ($eCodeExpense[$month][$eCode->eCodeID] < 0) ? 'text-danger' : 'text-success' }}"><b> {{ isset($eCodeExpense) ? number_format($eCodeExpense[$month][$eCode->eCodeID], 2) : 0.0 }} </b></div> 
                                            @endif
                                        </td>
                                    @endforeach
                                @endif
                                {{-- Print Total, Exp. Alloc. --}}
                                <td>
                                    <div align="center"><b> {{ isset($totalMonthlyExp) ? number_format($totalMonthlyExp[$month], 2) : 0.0 }} </b></div> 
                                </td>
                                <td>
                                    <div align="center"><b> {{ isset($getTotalMonthlyAllocation) ? number_format($getTotalMonthlyAllocation[$month], 2) : 0.0 }} </b></div> 
                                </td>
                                <td>
                                    <div align="center">
                                        <a href="{{ (Route::has('viewRefundDetails') ? Route('viewRefundDetails', ['ec'=>(isset($getAllEconomicCode) ? json_encode($getAllEconomicCode) : []), 'y'=>(isset($getYear) ? $getYear : null), 'm'=>$month]) : 'javascript') }}" title="View Details">
                                            <b> {{ isset($getTotalMonthlyRefund) ? number_format($getTotalMonthlyRefund[$month], 2) : 0.0 }} </b>
                                        </a>
                                    </div> 
                                </td>
                            </tr>
                            @endforeach
                            <tr class="text-center" style="background: #000000; color:#ffffff;"> 
                                <td> <b>TOTAL: </b> </td>
                                @if(isset($getEconomicCode))
                                    @foreach($getEconomicCode as $codeKey => $value)
                                        <td>
                                            <b> {{ isset($getTotalEcodeExpenditureYear) ? number_format(($getTotalEcodeExpenditureYear[$value->eCodeID]), 2) : 0.0 }} </b>
                                        </td>
                                    @endforeach
                                @endif
                                <td> <b>{{ (isset($sumTotalExpForYear) ? number_format($sumTotalExpForYear, 2) : 0.0) }}</b> </td>
                                <td> <b>{{ (isset($sumTotalAllocForYear) ? number_format($sumTotalAllocForYear, 2) : 0.0) }}</b> </td>
                                <td> <b>{{ (isset($sumTotalRefundForYear) ? number_format($sumTotalRefundForYear, 2) : 0.0) }}</b> </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>
        <div align="center">
            <a href="{{ redirect()->getUrlGenerator()->previous()  }}"> Go Back </a>
        </div>
        <br /><br />
    </div>
        
        
        

</body>
</html>