@extends('layouts.app')
@section('pageTitle', 'List of Award Letters')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            @include('ShareView.operationCallBackAlert')
            <div class="card-body">
                <p class="row">
                 
                <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Contract</th>
                        <th>Contractor</th>
                        <th>Contract Amount (NGN)</th>
                        <th>Date Issued</th>
                        <th>Status</th>
                       
                    </tr>
                    </thead>

                    @php
                    $n=1;
                    @endphp
                    <tbody>
                    @foreach($getList as $list)
                        
                        <?php
                            
                            $para = base64_encode($list->award_letterID);
                        ?>
                   
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$list->contract_name}}</td>
                        <td>{{$list->company_name}}</td>
                        <td align="right">{{number_format($list->proposed_budget,2)}}</td>
                         <td>{{$list->date_issued}}</td>
                        <td style="font-size:12px;">
                            
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/view-letter/{{$para}}" target="_blank"><button class="btn btn-sm btn-secondary waves-effect waves-light" class="form-check-input">View Letter</button></a>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/edit-letter/{{$para}}" target="_blank"><button class="btn btn-sm btn-danger waves-effect waves-light" class="form-check-input">Edit</button></a>
                        </td>
                    </tr>
                     
                    <!-- The Modal -->
                    <div class="modal" id="myModal{{$list->contract_biddingID}}">
                      <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                    
                                  <form method="post" action="{{ route('push-to-secretary') }}" enctype="multipart/form-data">  
                                  @csrf
                                 
                                  <input type="hidden" class="form-control" id="bid" name="bid" value="{{ $list->contract_biddingID}}">
                                
                                <div style="background-color:#ccc">
                                  <h3><center>Are you sure you want to send to Secretary?</center></h3>
                                </div> 
                                 <div class="form-group">
                                  <label for="comment">Comment:</label>
                                  <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Optional"></textarea>
                                </div> 
                                
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary waves-effect waves-light">Push</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                                </form>
                            </div>
                          </div>
                        </div>
                        
                         <!--Award Letter Modal-->
                    <div class="modal" id="awardletterModal{{$list->contract_biddingID}}">
                      <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title"> Award Letter</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                    
                                  <form method="post" action="{{ route('save-award-letter') }}" enctype="multipart/form-data">  
                                  @csrf
                                  <div class="form-group">
                                      <label class="control-label">Date Issue</label>
                                  <input type="hidden" class="form-control" id="cbid" name="cbid" value="{{ $list->contract_biddingID}}">
                                  <input type="hidden" class="form-control" id="approval_amt" name="approval_amt" value="{{ $list->awarded_amount}}">
                                  <input type="date" class="form-control" id="date_approval" name="date_approval" value="">
                                </div>
                                 <div class="form-group">
                                  <label class="control-label">Type Letter</label>
                                    <textarea id="tinymce_full{{$list->contract_biddingID}}" name="letter" style="width:100%; height:400px"></textarea>
                                </div> 
                                
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary waves-effect waves-light">Create</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                                </form>
                            </div>
                          </div>
                        </div>
                   
                    
                    <script>
                       
                        function awardLetter(x)
                        {
                            tinymce.init({
                        	width: "100%",
                            plugins: "media"
                            });        
                            
                            tinymce.init({
                                selector: "#tinymce_full"+x,
                                // Theme options
                                theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
                                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                                theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
                                theme_advanced_toolbar_location : "top",
                                theme_advanced_toolbar_align : "left",
                                theme_advanced_statusbar_location : "bottom",
                                theme_advanced_resizing : true,
                               
                                plugins: [
                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                    "insertdatetime media nonbreaking save table contextmenu directionality",
                                    "emoticons template paste textcolor colorpicker textpattern imagetools","media"
                                ],
                                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                                toolbar2: "print preview media | forecolor backcolor emoticons",
                                image_advtab: true,
                                templates: [
                                    {title: 'Test template 1', content: 'Test 1'},
                                    {title: 'Test template 2', content: 'Test 2'}
                                ]
                            });
                    
                        	$("#awardletterModal"+x).modal('show');
                        }
                      
                    </script>
                    
                    <script>
                       
                        function confirmValue(x)
                        {
                            //alert(x);
                            //document.getElementById('contrator').value=y;
                         	$("#myModal"+x).modal('show');
                            
                        }
                        
                    </script>
                   
                    
                    @endforeach
                    </tbody>
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

@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

@endsection
