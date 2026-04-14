@extends('layouts.app')
@section('pageTitle', 'Edit Agreement Letter')
@section('pageMenu', 'active')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            @include('ShareView.operationCallBackAlert')
            <div class="card-body">
                  <form method="post" action="{{ route('update-agreement-letter') }}" enctype="multipart/form-data">  
                                  @csrf
                
                <table width="100%" height="auto" border="0" >
                    <tr>
                    <td> Awarded Amount (NGN): {{ number_format($getList->awarded_amt,2) }}<br></td>
                  </tr>
                  <tr>
                    <td><label>Date:</label><input type="date" class="form-control" id="date_award" name="date_award" value="{{ $getList->date_issued}}"><br></td>
                  </tr>
                  <tr>
                    <td><label>Letter</label><textarea id="tinymce_full" name="letter" style="width:100%; height:400px">{!! $getList->agreement_letter !!}</textarea><br></td>
                  </tr>
                  @if($getDocExist==false)
                  
                  <tr>
                    <td><a onclick="addLetter('{{$getList->bidding_id}}')" style="cursor:pointer"><i class="fa fa-plus"></i> Add Document</a></td>
                  </tr>
                  @else
                  
                  <tr>
                    <td><label><u>More Options</u></label><br>
                    @foreach($getDocList as $list)
                        <a href="/agreementDocument/{{ $list->document }}"><i class="fa fa-file"></i> {{ $list->document_desc }}</a> | <a onclick="editLetter('{{$list->agreementID}}')" style="cursor:pointer"><i class="fa fa-edit"></i> Edit</a> | <a onclick="removeLetter('{{$list->agreementID}}')" style="cursor:pointer"><i class="fa fa-trash"></i> Delete</a><br>
                    @endforeach
                    </td>
                    
                  </tr>
                  @endif
                </table>
                <input type="hidden" class="form-control" id="cbid" name="cbid" value="{{ $getList->bidding_id}}">
                <br>
                
                <p>&nbsp;</p>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </form>
            </div>
            
        </div>
    </div> <!-- end col -->
   
</div> <!-- end row -->

<!-- Modal  -->
<!--Agreement Letter Modal-->
                    <div class="modal" id="agreedocumentModal">
                      <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title"> Upload Agreement Document</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                               
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                  
                                  <form method="post" action="{{ route('update-agreement-document') }}" enctype="multipart/form-data">  
                                  @csrf
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" id="cbidy" name="cbid" value="{{ $getList->agreement_letterID}}">
                                   
                                   </div>
                                
                                 <div class="" align="left">
                                    Agreement Document:
                                    <input type="file" id="agreement_letter" name="agreement_letter" class="form-control-file border" oninput="displayx()">
                                    <input type="text" class="form-control col-md-8" id="document_descriptionx" name="document_description" style="display:none" placeholder="Please enter ducument description">
                                </div> 
                                    
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              </div>
                                </form>
                            </div>
                          </div>
                        </div>
                        
                        <div class="modal" id="adddocumentModal{{$getList->bidding_id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title"> Agreement Document</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                               
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                  
                                  <form method="post" action="{{ route('add-agreement-document') }}" enctype="multipart/form-data">  
                                  @csrf
                                  <div class="form-group">
                                  <input type="hidden" class="form-control" id="cbid" name="cbid" value="{{ $getList->agreement_letterID}}">
                                   
                                   </div>
                                
                                 <div class="" align="left">
                                    Add Agreement Document:
                                    <input type="file" id="agreement_letter" name="agreement_letter" class="form-control-file border" oninput="display()">
                                    <input type="text" class="form-control col-md-6" id="document_description" name="document_description" style="display:none" placeholder="Please enter ducument description">
                                </div> 
                                    
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Add</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              </div>
                                </form>
                            </div>
                          </div>
                        </div>
                        
                        <div class="modal" id="removedocumentModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                               
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                  
                                  <form method="post" action="{{ route('remove-agreement-document') }}" enctype="multipart/form-data">  
                                  @csrf
                                  <div class="form-group">
                                      <center><h4 class="modal-title"> Are you sure?</h4></center>
                                  <input type="hidden" class="form-control" id="cbidx" name="cbid">
                                   
                                   </div>
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                              </div>
                                </form>
                            </div>
                          </div>
                        </div>
                   
<!-- Button to Open the Modal -->
<!-- The Modal -->
</div>

<!-- End Modal-->

@endsection

@section('styles')

@endsection

@section('scripts')
<script>
                    function display(){
                           document.getElementById('document_description').style.display="block";
                       }
                       
                    function displayx(){
                           document.getElementById('document_descriptionx').style.display="block";
                       }
                       
                    function editLetter(x) {
                           document.getElementById('cbidy').value=x;
                           $("#agreedocumentModal").modal('show');
                        }
                        
                    function addLetter(x) {
                           
                        	$("#adddocumentModal"+x).modal('show');
                        }
                        
                    function removeLetter(x) {
                            //alert('ddd');
                            document.getElementById('cbidx').value=x;
                        	$("#removedocumentModal").modal('show');
                        }
                        
                        
                            tinymce.init({
                        	width: "100%",
                            plugins: "media"
                            });        
                            
                            tinymce.init({
                                selector: "#tinymce_full",
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
</script>

<script src="{{ asset('assets/js/select2.min.js') }}"></script>

@endsection
