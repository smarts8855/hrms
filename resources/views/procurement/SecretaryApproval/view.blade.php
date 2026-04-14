@extends('layouts_procurement.app')
@section('pageTitle', 'List of Bidding Contracts')
@section('pageMenu', 'active')
@section('content')




    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card Replacement -->
            <div class="panel panel-default" style="border-radius:6px; box-shadow:0 0 5px rgba(0,0,0,0.1);">
                @php  $getName = DB::table('tblcontract_details')->where('contract_detailsID',$id)->first();  @endphp

                <!-- Header -->
                <div class="panel-heading" style="background:#f7f7f7; border-radius:6px 6px 0 0;">
                    @include('procurement.ShareView.operationCallBackAlert')

                    <h3 class="panel-title text-center" style="font-size:18px; font-weight:bold;">
                        Lot No.: <span class="text-success">{{ $getName->lot_number }}</span><br>
                        Contract Title: <span class="text-success">{{ $getName->contract_name }}</span><br>
                        Contract Amount:
                        <span class="text-success">{{ number_format($getName->proposed_budget, 2) }}</span>
                    </h3>
                </div>

                <!-- Body -->
                <div class="panel-body">

                    <?php $para = base64_encode($id); ?>

                    <a href="/contracts-coments/{{ $para }}" target="_blank"
                        class="btn btn-success btn-sm text-white">View Minutes</a>

                    <br><br>

                    <!-- Your Table -->
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Contractor</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Submitted Docs</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $n=1; @endphp

                            @foreach ($getList as $list)
                                <tr @if ($list->recommendation == 1) style="background:#c9ffe5" @endif>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $list->company_name }}</td>
                                    <td align="right">{{ number_format($list->bidding_amount, 2) }}</td>
                                    <td>{{ date('jS M, Y', strtotime($list->date_submitted)) }}</td>

                                    <td>
                                        <i data-toggle="modal" data-target="#myModal{{ $list->contract_biddingID }}"
                                            style="cursor:pointer">View</i>
                                    </td>

                                    <td>
                                        <button data-toggle="modal"
                                            data-target="#approvalModal{{ $list->contract_biddingID }}"
                                            class="btn btn-primary btn-sm">
                                            Award
                                        </button>

                                        <button data-toggle="modal"
                                            data-target="#rejectModal{{ $list->contract_biddingID }}"
                                            class="btn btn-danger btn-sm">
                                            Reject
                                        </button>
                                    </td>
                                </tr>

                                <!-- Your existing modals remain the same below -->

                                <!-- The Modal -->
                                <div class="modal" id="myModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Bidding Documents</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <?php
                                                $documents = app('App\Http\Controllers\procurement\ReuseableController')->fetchBiddingDocument2($list->contract_biddingID, $list->contractorID, $list->contractID);
                                                ?>
                                                @foreach ($documents as $a)
                                                    <a href="BiddingDocument/{{ $a->bidDocument }}" target="_blank">
                                                        <p style="background-color:light-green;font-size:18px"
                                                            class="fa fa-file"> {{ $a->bid_doc_description }} | <i
                                                                class="fa fa-arrow-down"></i>
                                                    </a></p>
                                                    <hr>
                                                @endforeach
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="amtModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Amount</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form method="post" action="{{ route('updateAmt') }}">
                                                @csrf
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="id"
                                                            id="id" value="{{ $list->contract_biddingID }}"
                                                            required>
                                                        <label for="usr">Amount:</label>
                                                        <input type="text" class="form-control bidAmt" name="amount"
                                                            id="biddingAmount{{ $list->contract_biddingID }}"
                                                            value="{{ $list->awarded_amount }}" required>
                                                    </div>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!--approve for single contractor-->
                                <div class="modal" id="apprModal{{ $list->contract_biddingID }}" tabindex="-1"
                                    role="dialog" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('approveBidder') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="cidx"
                                                            name="cidx" value="{{ $list->contract_biddingID }}">
                                                        <input type="hidden" class="form-control" id="contractorID"
                                                            name="contractorID"
                                                            value="{{ $list->contractor_registrationID }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Enter Comment(Optional)"></textarea>
                                                    </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-danger"
                                                    id="nonaward{{ $list->contract_biddingID }}" data-dismiss="modal"
                                                    onclick="nonAward({{ $list->contract_biddingID }})">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!--disapprove for single contractor-->
                                <div class="modal" id="disapprModal{{ $list->contract_biddingID }}" tabindex="-1"
                                    role="dialog" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('approveBidder') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="cidx"
                                                            name="cidx" value="{{ $list->contract_biddingID }}">
                                                        <input type="hidden" class="form-control" id="contractorID"
                                                            name="contractorID"
                                                            value="{{ $list->contractor_registrationID }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Enter Comment(Optional)"></textarea>
                                                    </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-danger"
                                                    id="naward{{ $list->contract_biddingID }}" data-dismiss="modal"
                                                    onclick="nAward({{ $list->contract_biddingID }})">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal" id="approvalModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Award Contract</h4>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <?php
                                                $comments = app('App\Http\Controllers\procurement\ReuseableController')->getComments($list->contractID);
                                                ?>
                                                <div style="padding: 15px; height:150px; overflow-y: scroll;">
                                                    <h6 class="modal-title"><strong>Comments:</strong></h6>
                                                    <br />
                                                    @foreach ($comments as $c)
                                                        <p
                                                            style="font-style:italic; border-bottom:solid;border-width:thin">
                                                            <strong
                                                                style="font-weight:bold;color:green">{{ $c->name }}:</strong>
                                                            {{ $c->comment_description }} <i
                                                                style="font-size:11px;color:red">[{{ $c->created_at }}]</i>
                                                        </p>
                                                    @endforeach
                                                </div>

                                                <form method="post" action="{{ route('approve') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        {{-- <label for="usr">Date:</label> --}}
                                                        {{-- <input type="date" class="form-control" id="date" name="date" required> --}}
                                                        <input type="hidden" class="form-control" id="cid"
                                                            name="cid" value="{{ $list->contractID }}">
                                                        <input type="hidden" class="form-control"
                                                            name="contractorBiddingId"
                                                            value="{{ $list->contract_biddingID }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Optional"></textarea>
                                                    </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Award</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="rejectModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Reject Contract</h4>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>

                                            <?php
                                            $comments = app('App\Http\Controllers\procurement\ReuseableController')->getComments($list->contractID);
                                            ?>
                                            <div style="padding: 15px;height:150px;overflow-y: scroll;">
                                                <h6 class="modal-title"><strong>Comments:</strong></h6>
                                                <br />
                                                @foreach ($comments as $c)
                                                    <p style="font-style:italic; border-bottom:solid;border-width:thin">
                                                        <strong
                                                            style="font-weight:bold;color:green">{{ $c->name }}:</strong>
                                                        {{ $c->comment_description }} <i
                                                            style="font-size:11px;color:red">[{{ $c->created_at }}]</i>
                                                    </p>
                                                @endforeach
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('reject') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        {{-- <label for="usr">Date:</label> --}}
                                                        {{-- <input type="date" class="form-control" id="date" name="date" required> --}}
                                                        <input type="hidden" class="form-control" id="cid"
                                                            name="cid" value="{{ $list->contractID }}">
                                                        <input type="hidden" class="form-control"
                                                            name="contractorBiddingId"
                                                            value="{{ $list->contract_biddingID }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Comment:</label>
                                                        <textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Optional"></textarea>
                                                    </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Reject</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- End Modal-->
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $biddingID = session()->get('bidding_id');
                        $contractorID = session()->get('contractor_id');
                        $contractID = session()->get('contract_id');

                    @endphp
                    <div id="showDIV" style="">

                        {{-- @php $true = DB::table('tblapproval')->where('contract_id',$contractID)->exists(); @endphp
                            @if ($true) <button  data-toggle="modal" data-target="#approvalModal"  class="btn btn-outline-primary" id="approval_comment" style="margin-left:6px;">Award Contract</button>@else @endif --}}

                        {{-- <button  data-toggle="modal" data-target="#rejectModal" class="btn btn-outline-success" id="" style="margin-left:6px;">Reject Contract</button> --}}
                    </div>

                </div>

            </div>
            <!-- End Card -->

        </div>
    </div>




    <!-- Modal  -->

    <!-- Button to Open the Modal -->
    <!-- The Modal -->


    <!-- End Modal-->

@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <script>
        function awardValue(x) {
            //alert(x);

            var contractID = x;

            $("#award" + x).empty();
            //$("#award"+x).append(" ");
            $.ajax({

                url: murl + '/approve-contractor',
                type: "post",
                data: {
                    'contractID': contractID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {

                    //console.log(data);
                    $("#award" + x).empty();
                    //$("#award"+x).append(" ");
                    //document.getElementById("recommend"+x).style.display="none";

                }
            });

            $("#apprModal" + x).attr('style', 'display:block;');
            $('#apprModal' + x).modal({
                backdrop: true,
                keyboard: false,
                show: true
            });
            $('#apprModal' + x).data('bs.modal').options.backdrop = 'static';
            $("#apprModal" + x).modal('show')

        }

        function disapproveValue(x) {
            //alert(x);
            var contractID = x;

            $("#award" + x).empty();
            //$("#award"+x).append(" ");
            $.ajax({

                url: murl + '/remove-contractor',
                type: "post",
                data: {
                    'contractID': contractID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {

                    //console.log(data);
                    $("#award" + x).empty();
                    //$("#award"+x).append(" ");

                }
            });


            $("#disapprModal" + x).modal('show')

        }
        //non award function
        function nonAward(y) {

            var btnNon = document.getElementById("nonaward" + y).value;
            var contractID = y;

            $("#award" + y).empty();


            $.ajax({

                url: murl + '/remove-contractor',
                type: "post",
                data: {
                    'contractID': contractID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {

                    //console.log(data);
                    $("#award" + y).empty();
                    //$("#award"+y).append(" ");
                }

            });

        }

        //award
        function nAward(y) {

            var btnNon = document.getElementById("naward" + y).value;
            var contractID = y;

            $("#award" + y).empty();

            $.ajax({

                url: murl + '/approve-contractor',
                type: "post",
                data: {
                    'contractID': contractID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {

                    //console.log(data);
                    $("#award" + y).empty();
                    //$("#award"+y).append(" ");
                }

            });

        }
    </script>

    <script>
        $(document).ready(function() {
            $(".bidAmt").on('keyup', function(evt) {
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
@endsection
