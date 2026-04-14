@extends('layouts.app')
@section('pageTitle', 'Financial Bid Evaluation')
@section('pageMenu', 'active')
@section('content')
@include('Bank.layouts.messages')
@if(count($datas)>0)
<div class="text-center">
<h3 style="margin-left:14px; margin-bottom:30px; font-weight:bold">Lot No: <span class="text-success">{{$datas[0]->lot_number}}</span> <br> Contract Title: <span class="text-success">{{$datas[0]->contract_name}}</span><br>
Amount: <span class="text-success"> {{number_format($datas[0]->proposed_budget,2)}}</span></h3>
<a href="{{'/contracts-coments/'.base64_encode($datas[0]->contract_detailsID)}}" target="_blank"><button class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">View Minutes</button></a>
<a href="{{'/requalify-bids/'.encrypt($datas[0]->contract_detailsID)}}" target="_blank"><button class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Disqualified Bids</button></a>
</div>
@if($files==null)

@else
<a href="{{ asset('images/' .$files->file_name) }}" target="_blank"><button class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Document Attached</button></a>
@endif

<div class="row">
    
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                  <table  class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Contractor</th>
                        <th>Bid Amount</th>
                        {{-- <th>Awarded Amount </th> --}}
                        <th>Date Submitted</th>
                        <th>Documents</th>
                        <th>Actions</th>
                      
                    </tr>
                    </thead>


                    <tbody>
                        <p>{{$counter=0}}</p>
                        
                        @foreach($datas as $data)
                   <!-- <tr data-stat={{$data->status}} data-recommendation="{{$data->recommendation}}"> -->
                   <tr>

                        <td>{{$counter=$counter+1}}</td>
                        <td>{{$data->company_name}}</td>
                      
                        <td style="text-align:right">{{number_format($data->bidding_amount,2)}}</td>
                        {{-- <td style="text-align:right">{{number_format($data->awarded_amount,2)}}</td> --}}
                        <td>{{date_format(date_create($data->date_submitted),"jS M Y")}}</td>
                        <td>
                             <span>{{count($data->documents)}} document(s) </span> |
                                      <a href={{'#contract'.$data->contract_biddingID}} data-target="{{'#file'.$data->contract_biddingID}}"
                                      data-toggle="modal" aria-expanded="false" aria-controls="multiCollapseExample1">view all</a>
                        </td>
                          <div class="modal fade" id={{'file'.$data->contract_biddingID}} tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Bidding Documents</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                        @foreach($data->documents as $key=>$document)
                                        
                                    <a href="{{ asset('BiddingDocument/' .$document->bidDocument) }}" target="_blank">{{$document->bid_doc_description}}</a> <br>
                                        @if($key+1==count($data->documents))
                                        @else
                                        <hr>
                                        @endif
                                        
                                    
                                        @endforeach
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                            </div>
                        </div>
                            </div>
                        
                        
                        <td>
                            @if(
                            ($data->contractStatus==1||$data->contractStatus==4) && ($data->current_location==0|| $data->current_location==1))
                            @if($data->status==0)
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target={{'#requalify'.$data->contract_biddingID}}>
                                         Requalify
                                        </button>
                            @else
                                <button type="button" class="btn btn-danger btn-sm"style="margin-bottom:5px;" data-toggle="modal" data-target={{'#disqualify'.$data->contract_biddingID}}>
                                         Disqualify
                                        </button>
                            @endif        
                                        <!-- Modal -->
                                         @if($data->status==0)
                                         <div class="modal fade" id={{'requalify'.$data->contract_biddingID}} tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                         @else
                                        <div class="modal fade" id={{'disqualify'.$data->contract_biddingID}} tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        @endif
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$data->company_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                               @if($data->status==0)
                                               <p style="color:grey;">Please give a reason for your Requalification of <br> {{$data->company_name.'s Contract'}}</p>
                                              <form method="POST" action={{'/procurement/bidding/requalify/'.$data->contract_biddingID}}>
                                               @else
                                              <p style="color:grey;">Please give a reason for your Disqualification of <br> {{$data->company_name.'s Contract'}}</p>
                                              <form method="POST" action={{'/procurement/bidding/disqualify/'.$data->contract_biddingID}}>
                                              @endif
                                                @csrf
                                                @method('PUT')
                                            {{-- <p style="color:grey;">Disqualification checklist</p> --}}
                                              <div class="row col-12">
                                                <label class="form-check-label" for="exampleCheck1"
                                                style="color:grey">Reason</label>
                                                <textarea name="disqualifyComment" class="form-control"
                                                ></textarea>
                                                   {{-- @if(isset($checklist) && $checklist)
                                                   @foreach($checklist as $key=>$checklists)
                                                    <div class="form-group form-check col-md-4">
                                                        <input type="checkbox" value= "{{$checklists->checklistID}}"
                                                        name="{{'checklist'.$key}}" class="form-check-input" id="exampleCheck1">
                                                        <label class="form-check-label" for="exampleCheck1" style="color:grey">{{$checklists->checklistName}}</label>
                                                        
                                                </div>
                                                   @endforeach
                                                   @endif --}}
                                                    {{-- <div class="form-group form-check col-md-4">
                                                        <input type="checkbox" name="other" class="form-check-input other" id="other">
                                                        <label class="form-check-label" for="exampleCheck1" style="color:grey">Other</label>
                                                        
                                                    </div>                                                   --}}
                                                </div>
                                              <!--  <div class="form-group">
                                                    <textarea name="comment" class="form-control" placeholder="reason"></textarea>
                                                </div> -->
                                                <div class="form-group">
                                                    <textarea style="visibility:hidden" name="comment" id="other-field" class="form-control other-field" placeholder="reason"></textarea>
                                                
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Cancel</button>
                                                @if($data->status==0)
                                                <button type="submit" class="btn btn-success">Requalify Contract</button>
                                                @else
                                                <button type="submit" class="btn btn-danger">Disqualify Contract</button>
                                                @endif
                                                </form>
                                              </div>
                                          </div>
                                        </div>
                                         </div>
                                  <button class="btn btn-sm btn-primary recommend_option" style="margin-bottom:5px;" data-toggle="modal" value={{$data->contract_biddingID}} data-recommendation={{$data->recommendation}} data-target={{'#recommend'.$data->contract_biddingID}}>Recommend</button>
                                  <!-- Modal -->
                                        <div class="modal fade" id={{'recommend'.$data->contract_biddingID}} tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5  class="modal-title" id="exampleModalLabel">{{$data->company_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                               <p style="color:grey;">Please give a reason for your Recommendation of <br> {{$data->company_name.'s Contract'}}</p>
                                               <form method="POST" action={{'/procurement/bidding/recommend/'.$data->contract_detailsID}}>
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                <input type="hidden" class="form-control" value={{$data->contract_biddingID}} name="biddingID"></div>
                                                <!-- <p style="color:grey;">Recommendation checklist</p>
                                              <div class="row col-12">
                                                   
                                                   @if(isset($checklist) && $checklist)
                                                   @foreach($checklist as $key=>$checklists)
                                                    <div class="form-group form-check col-md-4">
                                                        <input type="checkbox" value= "{{$checklists->checklistID}}"
                                                        name="{{'checklist'.$key}}" class="form-check-input" id="exampleCheck1">
                                                        <label class="form-check-label" for="exampleCheck1" style="color:grey">{{$checklists->checklistName}}</label>
                                                        
                                                </div>
                                                   @endforeach
                                                   @endif
                                                    <div class="form-group form-check col-md-4">
                                                        <input type="checkbox" name="other" class="form-check-input" id="other">
                                                        <label class="form-check-label" for="exampleCheck1" style="color:grey">Other</label>
                                                        
                                                    </div>                                                  
                                                </div>  -->  
                                                <div class="form-group">
                                                  <!--  <textarea style="visibility:hidden" name="comment" id="other-field" class="form-control" placeholder="reason"></textarea> -->
                                                  <textarea  name="comment" id="other-field" class="form-control" placeholder="reason"></textarea>
                                                </div>
                                               
                                                
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="submit" class="btn btn-success" >Recommend Bid</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                </form>
                                                 </div>
                                          </div>
                                        </div>
                                         </div> 
                                  
                                  
                        @endif
                        </td>
                    </tr>
                        @endforeach
                    
                    

                    </tbody>
                </table>
            </div>
         </div>   
            
    </div> <!-- end col -->
</div> <!-- end row -->

<button class="btn btn-primary status" id="statusee" data-toggle="modal" data-target="#comments">Bid Reports</button>
  <div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Contract Reports</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
          <div class="modal-body">
              <div style="margin-bottom:30px"><strong>Comments</strong></div>
            @if(count($comments)>0)
            @foreach($comments as $comment)
            <p style="font-size:14px"><em><span style="color:green">{{$comment->name}}</span>: {{$comment->comment_description}} <small style="color:red"> [{{date_format(date_create($comment->updated_at),"jS M Y")}}]</small></em></p>
            <hr>
           @endforeach
           @else
            <p>No Report</p>
           @endif
         </div>
         <div class="modal-footer">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
         </div>
         </div>
        </div>
       


 @if($datas[0]->current_location<2 && $contract->status==1)
<div class="row">

{{-- @if($contract->closed_bidding==1) --}}

<button style="margin-left:13px;" data-toggle="modal" data-target="#secretary" id="to_secretary" class="btn btn-success">Move to Accounting Officer</button>
<button  id="to_tenders" class="btn btn-success btn-warning" data-toggle="modal" data-target="#tenders">Move to Tenders Board</button>
<button  id="to_tenders" class="btn btn-primary" data-toggle="modal" data-target="#f_tenders">Move To Federal Judiciary Tenders Board</button>
<button  id="block" class="btn btn-dark" data-toggle="modal" data-target="#blocks">Cancel Bids</button>
{{-- @else
<button style="margin-left:13px;" data-toggle="modal" data-target="#warning" id="to_secretary" class="btn btn-success">Move to Accounting Officer</button>
<button  id="to_tenders" class="btn btn-success btn-warning" data-toggle="modal" data-target="#warning">Move to Tenders Board</button>
<button  id="to_tenders" class="btn btn-primary" data-toggle="modal" data-target="#warning">Move To Federal Judiciary Tenders Board</button>
<button  id="block" class="btn btn-dark" data-toggle="modal" data-target="#blocks">Cancel Bids</button>
@endif --}}

 <div class="modal fade" id="secretary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Move To Accounting Officer</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
           <div class="modal-body">
                    <p style="color:grey;">Please Add a comment</p>
                    <form method="POST" action="/procurement/approve/{{$datas[0]->contractID}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                    <textarea name="comment" class="form-control" placeholder="comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload Documents:</label>
                        <input name="image" type="file" class="form-control">
                    </div>
                    <div class="form-group">
                    <textarea name="description" class="form-control" placeholder="Document Description"></textarea>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Move</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </form>
                    </div>
         </div>
         </div>
        </div>

<div class="modal fade" id="warning" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
           <div class="modal-body">
                    <p style="color:grey;">You need to block bids before you can move</p>
                   
                    </div>
         </div>
         </div>
        </div>
        

 <!-- <form method="POST" action="/procurement/to-tenders/{{$datas[0]->contractID}}">
@csrf  -->



 <div class="modal fade" id="tenders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Move To Tenders Board</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
           <div class="modal-body">
                    <p style="color:grey;">Please give a reason for Moving To Tenders Board</p>
                    <form method="POST" action="/procurement/to-tenders/{{$datas[0]->contractID}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                    <textarea name="comment" class="form-control" placeholder="reason"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload Documents:</label>
                        <input name="image" type="file" class="form-control">
                    </div>
                    <div class="form-group">
                    <textarea name="description" class="form-control" placeholder="Document Description"></textarea>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Move</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </form>
                    </div>
         </div>
         </div>
        </div>
        
        



 <div class="modal fade" id="f_tenders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Move To Federal Judiciary Tenders Board</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
           <div class="modal-body">
                    <p style="color:grey;">Please give a reason for Moving To Federal Judiciary Tenders Board</p>
                    <form method="POST" action="/procurement/to-f-tenders/{{$datas[0]->contractID}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                    <textarea name="comment" class="form-control" placeholder="reason"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload Documents:</label>
                        <input name="image" type="file" class="form-control">
                    </div>
                    <div class="form-group">
                    <textarea name="description" class="form-control" placeholder="Document Description"></textarea>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Move</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </form>
                    </div>
         </div>
         </div>
        </div>

         <div class="modal fade" id="blocks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Cancel Bids</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
           <div class="modal-body">
                    <p style="color:grey;">Are you sure you would like to cancel contract</p>
                    <form method="POST" action="/procurement/to-block/{{base64_encode($datas[0]->contractID)}}" enctype="multipart/form-data">
                    @csrf
                        <label class="form-check-label" for="exampleCheck1" style="color:grey">Reason</label>
                          <textarea name="cancelContractComment" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Continue</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </form>
                    </div>
         </div>
         </div>
        </div>
</div>
@else
    <form method="POST" action="/procurement/approve/{{$datas[0]->contractID}}">
    @csrf

    <button type="submit" id="to_secretary" class="btn btn-success" disabled>
    @if($datas[0]->current_location==2)
        Location : Account Officer
    @elseif($datas[0]->current_location==3)
        Location : Tender's Board
    @elseif($datas[0]->current_location==5)
        Location : Federal Judiciary Tender's Board
    @else
        Location: Director Procurement
    @endif
    
    </button>
    </form>
    
    
        
        
@endif
@else
    <h3 style="margin-left:14px; margin-bottom:30px; font-weight:bold">Lot No: <span class="text-success">{{$contract->lot_number}}</span> <br> Contract Title: <span class="text-success">{{$contract->contract_name}}</span><br>
Amount: <span class="text-success"> {{number_format($contract->proposed_budget,2)}}</span></h3>
<a href="{{'/contract-comments/'.encrypt($contract->contract_detailsID)}}"><button class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">View Minutes</button></a>
<a href="{{'/requalify-bids/'.encrypt($contract->contract_detailsID)}}"><button class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Disqualified Bids</button></a>
@if($files==null)

@else
<a href="{{ asset('images/' .$files->file_name) }}" target="_blank"><button class="btn btn-success btn-sm" style="margin-left:14px; margin-top:-20px; margin-bottom:50px">Document Attached</button></a>
@endif

    <p>No Current Biddings Found</p>
@endif

@endsection

@section('styles')
 <style>
     .status{
         margin-bottom:15px;
     }
     #to_tenders{
         margin-left:15px;
     }
      #block{
         margin-left:15px;
     }
     
 </style>
@endsection

@section('scripts')
<script type="text/javascript">
        var display = true
        $('.other').on('change',function(){
            if(display==true){
            $('.other-field').css("visibility", "visible");
            display=false;
            }
            else{
              $('.other-field').css("visibility", "hidden"); 
              display = true
            }
            
        })
        $('.cancel').on('click',function(){
        $('.other-field').css("visibility", "hidden"); 
              display = true })
     var recommended = $("tr[data-recommendation='1']");
     $(recommended).css("background-color","rgba(12,113,8,0.7)");
    //  $(recommended).css("background-color","rgba(144,238,144,0.7)");
     $(recommended).css("color","white");
     var bidStatus = $("tr[data-stat='0']");
     $(bidStatus).css("background-color","rgba(220,20,60,0.4)");
     $(bidStatus).css("color","white");
      /*  if(recommended.length==0){
             $('#to_secretary').prop('disabled',true)
             $('#to_tenders').prop('disabled',true)
        }
        else{
           var buttonRecommended = $("button[data-recommendation='1']");
           $(buttonRecommended).prop('disabled',true) 
        } */
     
   /* var state = false
    var mike
    $('#to_secretary').prop('disabled',true)
    $('.recommend_option').click(function(){
        state = !state
        $('.recommend_option').prop('disabled',state)
        mike = $(this).val()
        $('#to_secretary').prop('disabled',!state)
        $("#recommendedID").val($(this).val());
        
        $(this).prop('disabled',false)
    });   
    var x = document.getElementsByClassName('recommend_option') */
 
</script>
@endsection