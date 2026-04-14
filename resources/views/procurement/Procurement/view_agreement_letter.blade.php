@extends('layouts_procurement.app')
@section('pageTitle', 'Print Agreement Letter')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            @include('ShareView.operationCallBackAlert')
            <div class="card-body">
                
                <table width="100%" height="auto" border="0" >
                  <tr>
                    <td>{!! $getList->agreement_letter ?? '' !!}</td>
                  </tr>
                  @if($getDocExist==false)
                  
                  @else
                  <tr class="no-print">
                     
                      <td><label><u>More Options</u></label><br>@foreach($getDocList as $list)<a href="/agreementDocument/{{ $list->document }}" target="_blank"> <i class="fa fa-file"></i> {{ $list->document_desc }}</a><br> @endforeach</td>
                     
                  </tr>
                 
                  @endif
                  <?php   $agreement_letterID = base64_encode($getList->agreement_letterID);  ?>
                  <tr class="no-print">
                     
                    <td>
                         <p>&nbsp;</p>
                        @if($getList->accept_status==1)
                            <button class="btn btn-secondary btn-sm">Already Confirmed</button>
                        @elseif($getList->accept_status==0)
                        <hr>
                            <button class="btn btn-outline-info btn-sm" onclick="ConfirmAgreementLetter('{{ $agreement_letterID }}')">Confirm Agreement Letter</button>
                        @endif
                    </td>
                  </tr>
                </table>
                
            </div>
            
        </div>
    </div> <!-- end col -->
   
</div> <!-- end row -->

<!-- Modal  -->

<!-- Button to Open the Modal -->
<!-- The Modal -->
</div>

<!-- End Modal-->

@endsection

@section('styles')
<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }

</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

<script>
    function ConfirmAgreementLetter(x) {
        
        var yesNo = confirm('Are you sure?');
        if(yesNo==true) {
            //call action
            document.location="/confirm-agreement/"+x;
        }
    }
</script>

@endsection
