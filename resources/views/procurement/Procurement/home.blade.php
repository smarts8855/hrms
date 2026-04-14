@extends('layouts.app')
@section('pageTitle', 'Procurement')
@section('pageMenu', 'active')
@section('content')
@include('Bank.layouts.messages')
 
<div class="row" style="margin-top:150px;">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap table-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th style="max-width:30px;">Contractor</th>
                        <th>Contract</th>
                        <th>Contract Amount</th>
                        <th>Date Submitted</th>
                        <th>Bid Document</th>
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody >
                @foreach($datas as $data)
                    <tr>
                              <th scope="row align-items-center">{{$data->contract_biddingID}}</th>
                              <td>{{$data->company_name}}</td>
                              <td>{{$data->contractor_remark}}</td>
                              <td>{{$data->bidding_amount}}</td>
                              <td>{{$data->created_at}}</td>
                              <td>
                               
                                   
                                      <span>{{count($data->documents)}} document(s) </span>
                                      <a data-toggle="collapse" href={{'#contract'.$data->contract_biddingID}} aria-expanded="false" aria-controls="multiCollapseExample1">view all</a>
                                    <div class="collapse multi-collapse" id={{'contract'.$data->contract_biddingID}}>
                                         @foreach($data->documents as $document)
                                            <p>{{$document->file_name}}</p>
                                         @endforeach
                                    </div>
                                
                              </td>
                              <td>
                                   <button style="margin-bottom:15px"type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target={{'#disqualify'.$data->contract_biddingID}}>
                                         Disqualify
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id={{'disqualify'.$data->contract_biddingID}} tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$data->company_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                               Are you sure you want to disqualify {{$data->company_name.'s Contract'}}
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form method="POST" action={{'procurement/disqualify/'.$data->contract_biddingID}}>
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary">Disqualify Contract</button>
                                                </form>
                                                 </div>
                                          </div>
                                        </div>
                                         </div>
                                  <button class="btn btn-sm btn-primary recommend_option" value={{$data->contract_biddingID}}>Recommend</button>
                                  
                                           
                              </td>
                    </tr>
                @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<div>
<button id="to_secretary" class="btn btn-success">Move to Secretary</button>
</div>                                              

@endsection

@section('styles')
   
@endsection

@section('scripts')
<script type="text/javascript">
    var state = false
    var mike
    $('#to_secretary').prop('disabled',true)
    $('.recommend_option').click(function(){
        state = !state
        $('.recommend_option').prop('disabled',state)
        mike = $(this).val()
        $('#to_secretary').prop('disabled',!state)
        $(this).prop('disabled',false)
    });   
    $('#to_secretary').click(function(){
        var address = "procurement/approve/" +mike
        $.ajax({
                  url: address ,
                  type: 'POST',
                  data: { bidding_id: mike, _token: '{{csrf_token()}}' },
                  success:function(){
                      window.location="/procurement"
                  }
}).then(function (response) { // a 2xx response
    var message = response.data.success;
    // display the message
}).error(function (error) { // a 4xx response
    // display an error message
});
        
    })
    var x = document.getElementsByClassName('recommend_option')
 
</script>
@endsection
