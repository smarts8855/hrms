<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <title> Refunds Details Report </title>
    
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
                    <h3>REFUND DETAILS REPORT</h3>  
                    {{-- <h4>ECONOMIC CODE EXPENDITURES</h4> --}} 
                    Printed: {{ date('F d, Y h:i:s a') }}
                </div>
                <br /><br />
                
                <table class="table table-hover table-responsive table-bordered">
                    
                    <thead>
                        <tr style="text-transform: uppercase;">
                            <th>
                                <div align="center"><b>SN</b></div> 
                            </th>
                             <th>
                                <div align="center"><b>Number of Voucher</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>From Whom Received</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Desc. of Receipt</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Economic Code NCOA</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Number of Treasury</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Amount TSA Bank</b></div> 
                            </th>
                            <th>
                                <div align="center"><b>Date</b></div> 
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        {{-- Print Refund --}}
                         @if(isset($getRefund) && $getRefund)
                            @foreach($getRefund as $key=>$value)
                            <tr>
                                <td>
                                    <div align="left"><h6>{{ (1+$key) }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ $value->number_of_voucher }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ $value->from_whom_received }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ $value->des_of_receipt }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ $value->economic_code_ncoa }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ $value->number_of_treasury }}</h6></div> 
                                </td>
                                <td>
                                    <div align="left"><h6>{{ number_format($value->amount_tsa_bank, 2) }}</h6></div> 
                                </td>
                                 <td>
                                    <div align="left"><h6>{{ date('d-m-Y', strtotime($value->date)) }}</h6></div> 
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                    
                </table>
                
            </div>
        </div>
        <div align="center">
            <a href="{{ redirect()->getUrlGenerator()->previous() }}"> Go Back </a>
        </div>
        <br /><br />
    </div>
        
        
        

</body>
</html>