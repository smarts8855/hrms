@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Bids for Approval') }}
@endsection
@section('pageMenu', 'active')
@section('content')
    @include('procurement.Bank.layouts.messages')
    @php
        $para = base64_encode($contract->contract_detailsID);
    @endphp
    <h4 style="margin-left:14px; margin-bottom:15px;">LOT Number: {{ strtoupper($contract->lot_number) }}</h4>
    <h4 style="margin-left:14px; margin-bottom:15px;">Contract Title: {{ strtoupper($contract->contract_name) }}</h4>
    <h4 style="margin-left:14px; margin-bottom:15px;">Proposed Contract Amount:
        {{ number_format($contract->proposed_budget, 2) }}</h4>
    <span><a href="{{ url('/contracts-coments/' . $para) }}" target="_blank" class="btn btn-success btn-sm"> View
            Minutes</a></span>
    <span class="btn btn-success btn-sm" id="attach">Procurement Attachments</span>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default" style="border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ session('msg') }}
                    </div>
                @endif
                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
                <div class="panel-heading" style="font-size:16px; font-weight:bold;">
                    Bidding Summary
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table id="" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Contractor</th>
                                    <th>Bid Amount</th>
                                    <th>Awarded Amount</th>
                                    <th>Date Submitted</th>
                                    <th>Documents</th>
                                    <th>Recommended Bid</th>
                                    <th>Edit Amount</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>


                            <tbody>
                                <p style="display:none"></p>
                                <?php
                                $n = 1;
                                ?>

                                @foreach ($display as $data)
                                    @php
                                        // $doc = DB::table('tblcontractor_bidding_document')->where('biddingID','=',$data->contract_biddingID)->get();
                                        $doc = app(
                                            'App\Http\Controllers\procurement\ReuseableController',
                                        )->fetchBiddingDocument2(
                                            $data->contract_biddingID,
                                            $data->contractorID,
                                            $data->contractID,
                                        );
                                        $awarded = DB::table('tblcontract_award')
                                            ->where('contractID', '=', $data->contractID)
                                            ->where('contractorID', '=', $data->contractor_registrationID)
                                            ->count();
                                    @endphp
                                    <tr @if ($awarded == 1) style="background:green !important; color:white;" @endif
                                        @if ($data->recommendation == 1) style="background:orange;color:white;" @endif>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $data->company_name }}</td>
                                        <td align="right">{{ number_format($data->bidding_amount, 2) }}</td>
                                        <td align="right"> {{ number_format($data->awarded_amount, 2) }} </td>
                                        <td align="right">{{ date('jS M, Y', strtotime($data->date_submitted)) }}</td>
                                        <td>
                                            <span>{{ count($doc) }} document(s) </span> |
                                            <a class="viewDocs" href="javascript:void()"
                                                bidId="{{ $data->contract_biddingID }}"
                                                @if ($data->recommendation == 1) style="color:white;" @endif
                                                @if ($awarded == 1) style="color:white;" @endif>View Docs</a>

                                            <!-- Document View Modal -->
                                            <div id="docModal" class="modal fade doc{{ $data->contract_biddingID }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Bidding Documents</h3>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">&times;</button>

                                                            <p id="message"></p>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p id="docsAreas">
                                                                @foreach ($doc as $docs)
                                                                    <p>
                                                                        <a href="{{ url('/BiddingDocument/' . $docs->bidDocument) }}"
                                                                            style="font-size:16px;" target="_blank">
                                                                            {{ $docs->bid_doc_description }} | <i
                                                                                style="border-radius:48%;"
                                                                                class="fa fa-arrow-down btn btn-success"></i></a>
                                                                    </p>
                                                                @endforeach

                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning"
                                                                data-dismiss="modal">Close</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!--// Document View Modal end-->

                                        </td>
                                        <td>
                                            @if ($data->recommendation == 1)
                                                Recommended Bid
                                            @endif
                                        </td>
                                        <td><a href="javscript:void()" class="edit"
                                                bidId="{{ $data->contract_biddingID }}" amt="{{ $data->awarded_amount }}"
                                                contractorId="{{ $data->contractor_registrationID }}"
                                                contractId="{{ $data->contractID }}"
                                                @if ($awarded == 1 || $data->recommendation == 1) style="color:#FFF;" @endif>Edit Amount</a>
                                        </td>
                                        <td>
                                            @if ($ifApproved == 0)
                                                @if ($awarded == 1)
                                                    <p style="color:white; padding:0; margin:0">Awarded | <a
                                                            href="javascript:void()" style="color:#FFF;"
                                                            bidId="{{ $data->contract_biddingID }}"
                                                            contractorId="{{ $data->contractor_registrationID }}"
                                                            contractId="{{ $data->contractID }}" class="reverse">
                                                            Reverse</a></p>
                                                @elseif($data->recommendation == 1)
                                                    <a href="javascript:void()" bidId="{{ $data->contract_biddingID }}"
                                                        contractorId="{{ $data->contractor_registrationID }}"
                                                        contractId="{{ $data->contractID }}" class="award"
                                                        style="color:white; padding:0; margin:0"> Approve</a>
                                                @else
                                                    <a href="javascript:void()" bidId="{{ $data->contract_biddingID }}"
                                                        contractorId="{{ $data->contractor_registrationID }}"
                                                        contractId="{{ $data->contractID }}" class="award"> Approve</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7">
                                        @if ($ifApproved > 0)
                                            Already Approved
                                            <input type="submit" name="submit" class="btn btn-success float-right approve"
                                                id="{{ $contractID }}" value="Reverse">
                                        @else
                                            <input type="hidden" name="contract" class="btn btn-success"
                                                value="{{ $contractID }}">
                                            <input type="submit" name="submit"
                                                class="btn btn-success float-right approve" id="{{ $contractID }}"
                                                value="Award">
                                            <input type="submit" name="submit"
                                                class="btn btn-success float-right reject" id="{{ $contractID }}"
                                                value="Reject" style="margin-right:15px; margin-left:15px;">
                                        @endif

                                    </td>
                                </tr>
                                <form method="post" action="{{ url('/final-contract/award') }}">
                                    {{ csrf_field() }}
                                    <!--<tr>
                                                            <td colspan="7" >

                                                            <input type="hidden" name="contract" class="btn btn-success" value="{{ $contractID }}">
                                                            <input type="submit" name="submit" class="btn btn-success float-right" onclick="return confirmAction();" value="Approve">

                                                        </td>
                                                        </tr>-->
                                </form>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <!-- modal -->

    <div id="approveModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Make your comment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>
                <form method="post" action="{{ url('/contract/awarding') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">


                        <input type="hidden" name="bidid" class="bidid" />
                        <input type="hidden" name="contractID" class="contractID" />
                        <input type="hidden" name="contractorID" class="contractorID" />

                        <div class="form-group">
                            <label>Award Comment</label>
                            <textarea class="form-control" name="comment"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- modal -->


    <!---- *************** Rejection Modal *********************-->

    <div id="rejectModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Reason For Rejection</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>
                <form method="post" action="{{ url('/contract-approval/rejection') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">


                        <input type="hidden" name="bidid" id="bidid" />
                        <input type="hidden" name="contractID" id="contractID" />
                        <input type="hidden" name="contractorID" id="contractorID" />

                        <div class="form-group">
                            <label>Resean for Rejection</label>
                            <textarea class="form-control" name="comment"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- modal -->


    <!----**************** /// Reject Modal ****************-->


    <!--Edit Amount modal -->

    <div id="amountModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Adjust Award Amount</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>
                <form method="post" action="{{ url('/adjust/contract/amount') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">


                        <input type="hidden" name="bidid" class="bidid" />
                        <input type="hidden" name="contractID" class="contractID" />
                        <input type="hidden" name="contractorID" class="contractorID" />

                        <div class="form-group">
                            <label>Amount</label>
                            <input class="form-control" name="amount" id="adjAmount" placeholder="0">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--// Edit Amount modal -->


    <!-- Document View Modal -->
    <div id="docModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Make your comment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>

                <div class="modal-body">
                    <p id="docsArea">

                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary adv" id="adv">Save</button>
                </div>

            </div>
        </div>
    </div>
    <!--// Document View Modal end-->

    <!-- reverse modal -->

    <div id="reverseModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Make your comment</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>
                <form method="post" action="{{ url('/contract-award/reverse') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <input type="hidden" name="bidid" class="bidid" />
                        <input type="hidden" name="contractID" class="contractID" />
                        <input type="hidden" name="contractorID" class="contractorID" />

                        <h5>Do you really want to reverse this award?</h5>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary adv" id="adv">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- /// end reverse modal -->




    <!-- approval modal-->

    <div id="approveAwardModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Your Remark</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{ url('/final-contract/award') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Your Remark <span class="compulsory">*</span></label>
                                    <textarea class="form-control" name="remark" required></textarea>
                                    <input type="hidden" name="bidid" class="bidId" />
                                    <input type="hidden" name="contractId" class="contractId" />
                                    <input type="hidden" name="contractorId" class="contractorId" />

                                </div>
                            </div>

                        </div>
                        <div class="inputWrap" id="inputWrap">
                            <div class="wraps" id="'+n+'">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group dynFile">
                                            <label for="">Attach Document</label>
                                            <input type="file" name="document[]" class="form-control" id=''>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group dynInput">
                                            <label for="">Document Description</label>
                                            <input type="text" name="description[]" class="form-control"
                                                id=''>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="border-bottom:1px solid #eee; padding-bottom:10px;">
                                <div class="col-md-1">
                                    <button id="add" type="button"
                                        class="btn-sm btn btn-circle btn-info align-right"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12" style="padding-top:10px; margin-rigt:20px;">
                                <div class="col-md-2 float-right">
                                    <button class="btn btn-primary btn-sm" type="submit">Approve</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <p id="docsArea">

                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    <!-- aproval modal --></1-->


    <!-- Attachment modal-->

    <div id="attachmentModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Your Remark</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <p id="message"></p>
                </div>

                <div class="modal-body">
                    <p id="docsArea">
                    <h4>Procurement Attachment</h4>
                    @foreach ($procurementAttachedments as $list)
                        <p>
                            <a href="{{ asset('images/' . $list->file_name) }}" style="font-size:16px;" target="_blank">
                                {{ $list->file_description }} | <i style="border-radius:48%;"
                                    class="fa fa-arrow-down btn btn-success"></i></a>
                        </p>
                    @endforeach
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    <!-- aproval modal -->


@endsection

@section('styles')
    <style>
        .card-panel {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
            margin-bottom: 20px;
        }
    </style>


@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $("#adjAmount").on('keyup', function(evt) {
                //if (evt.which != 110 ){//not a fullstop
                //var n = parseFloat($(this).val().replace(/\,/g,''),10);

                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(
                        /(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
                //$(this).val(n.toLocaleString());
                //}
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.bn', function() {
                //alert(0);
                $('.wraps').last().remove();
                var id = this.id;
                var deleteindex = id[1];

                // Remove <div> with id
                $("#" + deleteindex).remove();

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#add').click(function() {
                var total_element = $(".wraps").length;
                var lastid = $(".wraps:last").attr("id");
                //var split_id = lastid.split('_');
                var n = Number(lastid) + 1;
                //alert(nextindex);
                $('#inputWrap').append(
                    `<div class="wraps" id="'+n+'">
        <div class="row">
        <div class="col-md-12">
        <a class="delete bn remove_bank_field_btn pull-right align-right" href="javascript::void()">Remove</a>
        </div>
        <div class="col-md-6">
        <div class="form-group dynFile">
            <label for="">Document</label>
            <input type="file" name="document[]" class="form-control" id=''>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group dynInput">
            <label for="">Document Description</label>
            <input type="text" name="description[]" class="form-control" id='' >
        </div>
        </div>

        </div>
        </div>`
                );
            });
            //end click function

            $('.delete').last().click(function() {
                $('.wraps').last().remove();
            });

        });
    </script>


    <script>
        function confirmAction() {
            var c = confirm('Do you actually want to approve?');
            if (c) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            $("#attach").click(function() {
                $('#attachmentModal').modal('show');
            });

        });
        $(document).ready(function() {

            $("table tr td .viewDocs").click(function() {

                var bid = $(this).attr('bidid');
                $('.doc' + bid).modal('show');

                /*$.ajax({

                      url: "{{ url('/get/docs') }}",

                      type: "post",
                      data: {'bidID': bid, '_token': $('input[name=_token]').val()},
                      success: function(data){
                          console.log(data);
                          $('#docsArea').empty();
                        $.each(data, function(index, obj){

                        var url = '';
                $("#docsArea").append('<p><a href="/BiddingDocument/'+obj.file_name+'" target="_blank">  '+obj.file_description+'  | <i class="fa fa-arrow-down"></i></a></p>');
                        });

                      //location.reload(true);

                      }
                    });*/



            });

        });
    </script>



    <script>
        $(document).ready(function() {

            $("table tr td .award").click(function() {
                var bid = $(this).attr('bidid');
                var contract = $(this).attr('contractId');
                var contractor = $(this).attr('contractorId');
                $('.bidid').val(bid);
                $('.contractID').val(contract);
                $('.contractorID').val(contractor);
                $("#approveModal").modal('show');

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("table tr td .approve").click(function() {
                // var bid = $(this).attr('bidid');
                var contract = $(this).attr('id');
                //var contractor = $(this).attr('contractorId');
                // $('.bidid').val(bid);
                $('.contractId').val(contract);
                //$('.contractorID').val(contractor);
                $("#approveAwardModal").modal('show');

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("table tr td .reverse").click(function() {
                var bid = $(this).attr('bidid');
                var contract = $(this).attr('contractId');
                var contractor = $(this).attr('contractorId');
                $('.bidid').val(bid);
                $('.contractID').val(contract);
                $('.contractorID').val(contractor);
                $("#reverseModal").modal('show');

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("table tr td .reject").click(function() {
                var bid = $(this).attr('bidid');
                var contract = $(this).attr('contractId');
                var contractor = $(this).attr('contractorId');
                $('#bidid').val(bid);
                $('#contractID').val(contract);
                $('#contractorID').val(contractor);
                $("#rejectModal").modal('show');

            });

        });
    </script>

    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function() {

            $("table tr td .edit").click(function() {
                var bid = $(this).attr('bidid');
                var contract = $(this).attr('contractId');
                var contractor = $(this).attr('contractorId');
                var awardedAmount = $(this).attr('amt');
                var amt = numberWithCommas(awardedAmount);
                $("#adjAmount").val(amt);
                $('.bidid').val(bid);
                $('.contractID').val(contract);
                $('.contractorID').val(contractor);
                $("#amountModal").modal('show');

            });

        });
    </script>
    <script type="text/javascript">
        var state = false
        var mike
        $('#to_secretary').prop('disabled', true)
        $('.recommend_option').click(function() {
            state = !state
            $('.recommend_option').prop('disabled', state)
            mike = $(this).val()
            $('#to_secretary').prop('disabled', !state)
            $("#recommendedID").val($(this).val());

            $(this).prop('disabled', false)
        });
        var x = document.getElementsByClassName('recommend_option')
    </script>

    <script>
        $("#adjustAmount").on('keyup', function(evt) {
            var n = parseFloat($(this).val().toFixed(2).replace(/\D/g, ''), 10);
            //var n = $(this).val().toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            if ($(this).val() == "") {
                $(this).val(0);
            } else {
                $(this).val(n.toLocaleString('en'));
            }
        });
    </script>
@endsection
