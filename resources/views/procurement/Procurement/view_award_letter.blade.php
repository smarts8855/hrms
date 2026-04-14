@extends('layouts_procurement.app')
@section('pageTitle', 'Print Award Letter')
@section('pageMenu', 'active')
@section('content')

<div class="box-body" style="background:#FFF;">
    <div class="row">
        <div class="col-md-12">
            <!-- Header (hidden when printing) -->
            <div class="box-header with-border hidden-print">
                <div class="row">
                    <div class="col-md-6 text-right">
                        <h4 style="font-size: 14px;">
                            <i class="fa fa-print"></i> Award Letter Preview
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Award Letter Content -->
            <div class="award-letter-content" style="page-break-inside: avoid;">
                <div class="card">
                    <div class="card-body">
                        {!! $getList->award_letter ?? '' !!}
                    </div>
                </div>
            </div>

            <!-- Bottom Print Button (hidden when printing) -->
            <div class="text-center hidden-print mt-4">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fa fa-print mr-1"></i> Print Award Letter
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    @page {
        margin: 10mm;
        size: auto;
    }
    
    .hidden-print {
        display: none !important;
    }
    
    body {
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
        font-size: 14pt !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        height: auto !important;
        width: auto !important;
        overflow: visible !important;
    }
    
    html {
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        width: auto !important;
    }
    
    .award-letter-content {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 14pt !important;
        page-break-inside: avoid;
        page-break-after: avoid;
        height: auto !important;
        width: 100% !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
        page-break-inside: avoid;
        page-break-after: avoid;
    }
    
    .card-body {
        padding: 0 !important;
        margin: 0 !important;
        font-size: 14pt !important;
        page-break-inside: avoid;
        page-break-after: avoid;
    }
    
    /* Remove any potential overflow */
    * {
        overflow: visible !important;
        max-height: none !important;
    }
}

@media screen {
    .btn {
        border-radius: 6px;
        margin: 5px;
    }
    .card {
        border-radius: 8px;
        margin: 10px 0;
    }
    .award-letter-content {
        font-size: 16px;
    }
}
</style>

<script>
function optimizeForPrint() {
    // Remove any extra elements that might cause blank pages
    const style = document.createElement('style');
    style.innerHTML = `
        @media print {
            body * {
                visibility: hidden;
            }
            .award-letter-content,
            .award-letter-content * {
                visibility: visible;
            }
            .award-letter-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    `;
    document.head.appendChild(style);
}

document.addEventListener('DOMContentLoaded', function() {
    const printButtons = document.querySelectorAll('button[onclick*="print"]');
    printButtons.forEach(button => {
        button.onclick = function() {
            optimizeForPrint();
            setTimeout(() => {
                window.print();
            }, 100);
        };
    });
});
</script>

@endsection