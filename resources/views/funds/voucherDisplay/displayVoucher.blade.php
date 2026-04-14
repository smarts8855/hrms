@extends('layouts.layout')
@section('pageTitle')
    {{ strtoupper(' You can print your voucher here') }}
@endsection
@section('content')
    
    <!--PAYMENT VOUCHER-->
    <div class="box-body" id="main" style="background: #fff;">
        <div style="margin: 0 10px;" id="report2">
            @if ($list->contractTypeID == 4 || $list->contractTypeID == 10)
                @include('funds.voucherDisplay.capitalVoucherTemplate')
            @endif
            @if ($list->contractTypeID == 1 || $list->contractTypeID == 6)
                @if ($list->WHTValue > 0 || $list->VATValue > 0 || $list->stampduty > 0)
                    {{-- payment with deductions --}}
                    @include('funds.voucherDisplay.recurrentVoucherTemplate')
                @endif
                @if ($list->WHTValue == 0 && $list->VATValue == 0 && $list->stampduty == 0)
                    {{-- direct payment without deductions --}}
                    @include('funds.voucherDisplay.recurrentVoucherNoDeducTemplate')
                @endif
                
            @endif
        </div>
    </div>
@endsection
