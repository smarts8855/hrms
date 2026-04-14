<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <title> Payment Details Report </title>
    
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
                    <h3>PAYMENT DETAILS REPORT</h3>  
                    <h4>{{ isset($getEconomicDetails) ? $getEconomicDetails : '' }}</h4>
                    Printed: {{ date('F d, Y - h:i: a') }}
                </div>
                <br /><br />
                
                <table class="table table-hover table-responsive table-bordered">
                    
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th>
                                <div align="center"><b>SN</b></div> 
                            </th>
                             <th>
                                <div align="center"><b>Payment Description</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Amount</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Date Prepared</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Liability Date</b></div> 
                            </th>
                            <th>
                                <div align="center"></div> 
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        {{-- Print Payment Details --}}
                         @if(isset($getPaymentDetails) && $getPaymentDetails)
                            @php
                                $totalAmount = 0.0;
                            @endphp
                            @foreach($getPaymentDetails as $key=>$value)
                            @php
                                $totalAmount +=  $value->totalPayment;
                            @endphp
                            <tr>
                                <td>
                                    <div align="left"><h6>{{ (1+$key) }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ $value->paymentDescription }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ is_numeric($value->totalPayment) ? number_format($value->totalPayment, 2) : 0 }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ date('d-m-Y', strtotime($value->datePrepared )) }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ date('d-m-Y', strtotime($value->dateTakingLiability)) }}</h6></div> 
                                </td>
                                 <td>
                                    <div align="left">
                                        <a href="{{ Route::has('ViewVoucherDetails') ? Route('ViewVoucherDetails', ['id'=>$value->ID]) : 'javascript:;' }}" title="view voucher details">View</a>
                                    </div> 
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-right">TOTAL AMOUNT: </td>
                                <td colspan="4" class="text-left"><b>{{ is_numeric($totalAmount) ? number_format($totalAmount, 2) : 0 }}</b></td>
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