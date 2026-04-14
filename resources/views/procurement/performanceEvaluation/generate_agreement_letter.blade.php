@extends('layouts_procurement.app')
@section('pageTitle', 'Agreement Letter')
@section('pageMenu', 'active')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('ShareView.operationCallBackAlert')
                <div class="card-body">
                    <p class="row">

                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">


                            <!-- Modal body -->
                            <div class="modal-body">
                                <h5 class=""> Awarded Amount: NGN {{ number_format($getList->awarded_amount, 2) }}</h5>
                                <form method="post" action="{{ route('generate-agreement-letter') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="cbid" name="cbid"
                                            value="{{ $getList->contract_biddingID }}">
                                        <label>Date: </label><input type="hidden" class="form-control" id="approval_amt"
                                            name="approval_amt" value="{{ $getList->awarded_amount }}">
                                        <input type="date" class="form-control" id="date_approval" name="date_approval"
                                            value="" required>
                                    </div>

                                    <div class="" align="left">
                                        <label class="control-label">Type Letter</label>
                                        <textarea id="tinymce_full" name="letter" style="width:100%; height:400px"></textarea>
                                        <br />
                                        Attach Document(Optional):

                                        <div id="files"> <input type="file" name='images1' /><br><input
                                                type="text" name="description1"
                                                class="form-control form-control form-control-a"
                                                placeholder="Enter File Description"></div>

                                        <input type="hidden" value=1 id="image" name="image" />
                                        <div style="cursor:pointer" onClick="AddFileUpload();">Attach more file</div>

                                    </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Create</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

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
    <script>
        function displayx(x) {

            document.getElementById("showForm").style.display = 'block';
        }

        function AddFileUpload() {

            var div = document.createElement('DIV');
            var img = document.getElementById("image").value;
            img = parseInt(img) + 1;
            div.innerHTML = "<br><input type = file name = images" + img + "> <br><input type = text name = description" +
                img + " placeholder='Enter file description' class='form-control form-control-a'><br>" +
                "<input id='Button' " + img +
                "  type='button' class='btn btn-primary btn-sm' value='Remove' onclick = 'RemoveFileUpload(this)' style='cursor:pointer;color:white' />";
            document.getElementById("image").value = img;
            document.getElementById("files").appendChild(div);
        }

        function RemoveFileUpload(div) {
            document.getElementById("files").removeChild(div.parentNode);
        }

        tinymce.init({
            width: "100%",
            plugins: "media"
        });

        tinymce.init({
            selector: "#tinymce_full",
            // Theme options
            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,

            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools", "media"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true,
            templates: [{
                    title: 'Test template 1',
                    content: 'Test 1'
                },
                {
                    title: 'Test template 2',
                    content: 'Test 2'
                }
            ]
        });
    </script>

    <script>
        function isValue(y) {
            alert('Award letter has not been created. Please create award letter');
        }
    </script>
    <script>
        $('#clear').on('click', function(e) {
            var $el = $('#control');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            document.getElementById("clear").style.display = 'none';
            document.getElementById("affidavitDesc").style.display = 'none'
        });
    </script>
@endsection
