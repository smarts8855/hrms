@extends('layouts.app')
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
                    <td><label><u>More Options</u></label><br> 
                    @foreach($getDocList as $list)
                        <a href="/agreementDocument/{{ $list->document }}"><i class="fa fa-file"></i> {{ $list->document_desc }}</a><br>
                    @endforeach
                    </td>
                  </tr>
                  @endif
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

@endsection
