@extends('layouts_procurement.app')
@section('pageTitle', 'Agreement Letter')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card (Panel) -->
            <div class="panel panel-default" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.12);">

                <!-- Panel Heading -->
                <div class="panel-heading" style="background:#fff; border-bottom:1px solid #ddd;">
                    <h4 class="panel-title" style="margin:0; font-weight:bold;">
                        @yield('pageTitle')
                    </h4>
                </div>

                <!-- Panel Body -->
                <div class="panel-body">

                    @include('procurement.ShareView.operationCallBackAlert')

                    <p class="row">
                        <?php $para = base64_encode($id); ?>
                        <a href="/contracts-coments/{{ $para }}" target="_blank"
                            class="btn btn-success btn-sm text-white">View Minutes</a>
                    </p>

                    <table class="table table-striped table-bordered table-responsive nowrap" style="width: 100%;">

                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Lot No.</th>
                                <th>Contract</th>
                                <th>Contractor</th>
                                <th>Proposed Amount (NGN)</th>
                                <th>Awarded Amount (NGN)</th>
                                <th>Date Issued</th>
                                <th>Bid Document</th>
                                <th>Agreement Letter</th>
                            </tr>
                        </thead>

                        @php $n = 1; @endphp
                        <tbody>

                            @foreach ($getList as $list)
                                <?php
                                $checkx = DB::table('tblaward_letter')->where('bidding_id', $list->contract_biddingID)->exists();
                                
                                $para = base64_encode($list->contract_biddingID);
                                ?>

                                @if ($list->is_agreement != 0)
                                    <tr
                                        @if ($list->is_agreement == 1) style="background-color:#c4f8e9;"
                                    @elseif ($list->is_agreement == 2)
                                        style="background-color:#ddfcd8;" @endif>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $list->lot_number }}</td>
                                        <td>{{ $list->contract_name }}</td>
                                        <td>{{ $list->company_name }}</td>
                                        <td class="text-right">{{ number_format($list->proposed_budget, 2) }}</td>
                                        <td class="text-right">{{ number_format($list->awarded_amount, 2) }}</td>

                                        <td>
                                            @if ($checkx)
                                                @php
                                                    $dateissued = DB::table('tblaward_letter')
                                                        ->where('bidding_id', $list->contract_biddingID)
                                                        ->first();
                                                @endphp
                                                {{ date('jS M, Y', strtotime($dateissued->date_issued)) }}
                                            @endif
                                        </td>

                                        <td>
                                            <a href="/view-bidding-document/{{ $para }}" target="_blank">
                                                View bidding document
                                            </a>
                                        </td>

                                        <td style="width: 185px">
                                            @if ($list->is_agreement == 1)
                                                <a href="/generate-letter/{{ $para }}" target="_blank">
                                                    <button class="btn btn-primary btn-sm">Generate Letter</button>
                                                </a>

                                                <button class="btn btn-success btn-sm"
                                                    onclick="returnLetter('{{ $list->contract_biddingID }}')">
                                                    Return
                                                </button>
                                            @elseif ($list->is_agreement == 2)
                                                <a href="/view-agreement-letter/{{ $para }}" target="_blank">
                                                    <button class="btn btn-default btn-sm">View</button>
                                                </a>

                                                <a href="/edit-agreement-letter/{{ $para }}" target="_blank">
                                                    <button class="btn btn-secondary btn-sm">Edit</button>
                                                </a>

                                                <button class="btn btn-primary btn-sm"
                                                    onclick="pushLetter('{{ $para }}')">
                                                    Push
                                                </button>

                                                @if ($list->accept_status == 0)
                                                    <button class="btn btn-success btn-sm"
                                                        onclick="reverseLetter('{{ $list->contract_biddingID }}')">
                                                        Reverse
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endif

                                <!-- Your modals remain unchanged here -->

                                <!-- The Modal -->
                                <div class="modal" id="myModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal body -->
                                            <div class="modal-body">

                                                <form method="post" action="{{ route('return-letter') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" class="form-control" id="bid" name="bid"
                                                        value="{{ $list->contract_biddingID }}">

                                                    <div style="background-color:#ccc">
                                                        <h3>
                                                            <center>Are you sure?</center>
                                                        </h3>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Optional"></textarea>
                                                    </div>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit"
                                                    class="btn btn-success waves-effect waves-light">Yes</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">No</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="myModalx{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal body -->
                                            <div class="modal-body">

                                                <form method="post" action="{{ route('reverse-letter') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" class="form-control" id="bid" name="bid"
                                                        value="{{ $list->contract_biddingID }}">

                                                    <div style="background-color:#ccc">
                                                        <h3>
                                                            <center>Are you sure?</center>
                                                        </h3>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Optional"></textarea>
                                                    </div>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit"
                                                    class="btn btn-success waves-effect waves-light">Yes</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">No</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                                <!--Agreement Letter Modal-->
                                <div class="modal" id="agreeletterModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Agreement Letter</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h5 class=""> Awarded Amount: NGN
                                                    {{ number_format($list->awarded_amount, 2) }}</h5>
                                                <form method="post" action="{{ route('generate-agreement-letter') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="cbid"
                                                            name="cbid" value="{{ $list->contract_biddingID }}">
                                                        <label>Date: </label><input type="hidden" class="form-control"
                                                            id="approval_amt" name="approval_amt"
                                                            value="{{ $list->awarded_amount }}">
                                                        <input type="date" class="form-control" id="date_approval"
                                                            name="date_approval" value="" required>
                                                    </div>

                                                    <div class="" align="left">
                                                        <label class="control-label">Type Letter</label>
                                                        <textarea id="tinymce_full{{ $list->contract_biddingID }}" name="letter" style="width:100%; height:400px"></textarea>
                                                        <br />
                                                        Upload Agreement Document(Optional):
                                                        <div id="files{{ $list->contract_biddingID }}">
                                                            <a id="clear"
                                                                style="color:green;display:none;cursor:pointer"><i
                                                                    class="fa fa-remove"></i></a>
                                                            <input type="file" id="agreement_letter"
                                                                name="agreement_letter1" class="form-control-file border"
                                                                oninput="displayx({{ $list->contract_biddingID }})">
                                                            <div id="showForm{{ $list->contract_biddingID }}"
                                                                style="display:none">
                                                                <input type="text" class="form-control col-md-4"
                                                                    id="documentdesc" name="document_description1"
                                                                    placeholder="Please enter ducument description">
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <input type="hidden" value=1 id="image"
                                                            name="agreement_letter" />
                                                        <div style="cursor:pointer"
                                                            onClick="AddFileUpload({{ $list->contract_biddingID }});">
                                                            Attach more file</div>
                                                    </div>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit"
                                                    class="btn btn-success waves-effect waves-light">Create</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </tbody>
                    </table>

                </div> <!-- panel-body -->

            </div> <!-- panel -->

        </div>
    </div>


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
        function Test() {
            alert("testing");
        }

        var counter = 0;

        $('#clear').on('click', function(e) {
            var $el = $('#control');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            document.getElementById("clear").style.display = 'none';
            document.getElementById("affidavitDesc").style.display = 'none'
        });
    </script>

    <script>
        function pushLetter(x) {
            var y = confirm('Are you sure?');
            if (y == true) {
                document.location = "/push-agreement-letter/" + x;
            }
        }

        function displayx(x) {
            //var r  = document.getElementById('documentdesc').value

            document.getElementById("showForm" + x).style.display = 'block';
            // alert('fhfghdfdffd');
        }

        function AddFileUpload(x) {
            var div = document.createElement('DIV');
            var img = document.getElementById("image").value;

            img = parseInt(img) + 1;
            div.innerHTML = "<br><input type = file name = agreement_letter" + img +
                "> <br><input type = text name = document_description" + img +
                " placeholder='Enter file description' class='form-control col-md-4 form-control-a'><br>";

            document.getElementById("image").value = img;
            document.getElementById("files" + x).appendChild(div);
        }

        function RemoveFileUpload() {

            var img = document.getElementById("image").value;
            img = parseInt(img) + 1;
            var myobj = document.getElementsByName("agreement_letter" + 2);
            var myobj2 = document.getElementsByName("document_description" + 2);
            myobj.remove();
            myobj2.remove();
        }

        function returnLetter(x) {
            $("#myModal" + x).modal('show');
        }

        function reverseLetter(x) {
            $("#myModalx" + x).modal('show');
        }

        function agreeLetter(x) {
            tinymce.init({
                width: "100%",
                plugins: "media"
            });

            tinymce.init({
                selector: "#tinymce_full" + x,
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

            $("#agreeletterModal" + x).modal('show');
        }
    </script>

    <script>
        function isValue(y) {
            alert('Award letter has not been created. Please create award letter');
        }
    </script>
@endsection
