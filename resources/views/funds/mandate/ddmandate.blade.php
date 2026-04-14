@extends('layouts.layout')

@section('pageTitle')
    Generated Payment
@endsection

@section('content')
    <div class="box-body" style="background:#FFF;">
        <div class="box-body hidden-print">
            <div class="row">
                <div class="col-sm-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> <br />
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> <br />
                            {{ session('msg') }}
                        </div>
                    @endif

                    @if (session('err'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <strong>Operation Error !</strong> <br />
                            {{ session('err') }}
                        </div>
                    @endif
                </div>
            </div><!-- /row -->
        </div><!-- /div -->


        <div class="box-body">
            <div class="col-sm-12 hidden-print">
                <h2 class="text-center"></h2>
                <h3 class="text-center">Generated Payment</h3>

                <br />

                <!--search all vouchers-->
                <div class="row hidden-print">
                    <div class="col-sm-6">

                    </div>

                    <div class="col-sm-6">

                    </div>
                </div>
                <!--Search all vouchers-->

                <!-- 1st column -->


                <br />
                <div>
                    <form action="{{ url('/dd/mandatere') }}" method="post">
                        {{ csrf_field() }}
                        <table id="myTable" class="table table-bordered" cellpadding="10">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>BATCH NUMBER</th>
                                    <th class="text-center">TOTAL AMOUNT ( &#8358;)</th>
                                    <th>View Remark</th>
                                    <th>Preview</th>
                                    <th>PROCCESS</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $key = 1; @endphp
                                @if (count($vouchers) > 0 && $vouchers != '')
                                    @foreach ($vouchers as $list)
                                        <tr>
                                            <input type="hidden" name="id[]" checked value="{{ $list->TID }}" />
                                            <input type="hidden" name="batch" value="{{ $list->batch }}" />

                                            <td>{{ $key++ }}</td>
                                            <td>{{ $list->adjusted_batch }}</td>
                                            <td class="text-center">{{ number_format($list->totalPayment, 2) }}</td>
                                            <td width="30"><a href="{{ url('/display/comments/' . $list->batch) }}"
                                                    target="_blank" class="btn btn-success btn-xs" id="{{ $list->batch }}"
                                                    val="{{ $list->TID }}">View Remarks</a></td>
                                            <td width="50"><a href="{{ url('/view/batch/' . $list->batch) }}"
                                                    class="btn btn-success btn-xs">Preview</a> </td>
                                            <td width="50"><a href="javascript:void()"
                                                    class="btn btn-success btn-xs pro" id="{{ $list->batch }}"
                                                    val="{{ $list->TID }}">Process</a> </td>
                                            <td>
                                                @if ($list->rejection_status == 1)
                                                    This batch was rejected by {{ $list->rejected_by }} - <a
                                                        href="javascript:void()" class="btn btn-success btn-xs reason"
                                                        id="{{ $list->batch }}" val="{{ $list->TID }}"> View Reason
                                                    </a>
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center"> No Mandate Available !</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>

                    </form>
                </div>
                <br />

                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

        <!-- Modal HTML -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">

                        <div id="desc">
                            @if ($cmt != 0)
                                @foreach ($cmt as $list)
                                    <div id="desc">

                                        <strong>{{ $list->name }} : </strong> <span>{{ $list->comment }}</span>

                                    </div>
                                @endforeach
                            @endif
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
        <!--///// end modal -->

        <!-- Modal HTML -->
        <form action="{{ url('/dd/mandate') }}" method="post">
            {{ csrf_field() }}
            <div id="approveModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Confirmation</h4>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="id" id="tid" value="" />
                            <input type="hidden" name="batch" id="batch" value="" />

                            <div class="form-group" style="margin-bottom:10px;">
                                <div class="col-sm-122">
                                    <label class="control-label"><b>Enter Remarks</b></label>
                                </div>
                                <div class="col-sm-122">
                                    <textarea name="instruction" id="instruction" class="form-control" placeholder="e.g Pay a sum amount of XXXXX"> </textarea>
                                </div>
                                <div class="col-sm-122">
                                    <label class="control-label"><b>Refer to</b></label>
                                </div>
                                <div class="col-sm-122">
                                    <select required name="attension" class="form-control">
                                        <option value="">Select</option>
                                        @if ($codes != '')
                                            @foreach ($codes as $list)
                                                <option value="{{ $list->code }}">{{ $list->description }}</option>
                                            @endforeach
                                            <option value="CPO">CPO</option>
                                            <option value="FA">Final Approval</option>
                                        @endif
                                    </select>
                                </div>

                            </div>



                            <div class="clearfix"></div>



                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="submit" value="Process"
                                class="btn btn-success pull-right hidden-print" style="margin-top:10px;margin-left:20px">
                            <input type="submit" name="submit" value="Reject"
                                class="btn btn-danger pull-right hidden-print" style="margin-top:10px;margin-left:20px;">

                            <button type="button" class="btn btn-default"
                                style="margin-top:10px;margin-left:20px;">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--///// end modal -->

        <!--Rejection reason Modal HTML -->
        <div id="rejectModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Reason For Rejecting</h4>
                    </div>
                    <div class="modal-body">

                        <div id="reason">

                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
        <!--///// end Rejection reason Modal -->

    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">

    <style type="text/css">
        .status {
            font-size: 15px;
            padding: 0px;
            height: 100%;

        }

        .textbox {
            border: 1px;
            background-color: #66FFBA;
            outline: 0;
            height: 25px;
            width: 275px;
        }

        .autocomplete-suggestions {
            color: #66FFBA;
            height: 125px;
        }

        .table,
        tr,
        td {
            border: #9f9f9f solid 1px !important;
            font-size: 12px !important;
        }

        .table thead tr th {
            font-weight: 700;
            font-size: 17px;
            border: #9f9f9f solid 1px
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".com").click(function() {
                $("#myModal").modal('show');
            });
        });




        $(document).ready(function() {

            $(".pro").click(function() {
                $("#approveModal").modal('show');
                var id = $(this).attr('val');
                var batch = $(this).attr('id');
                //alert(batch);
                $('#tid').val(id);
                $('#batch').val(batch);

            });

        });

        $(document).ready(function() {

            $(".reason").click(function() {

                var id = $(this).attr('val');
                var batch = $(this).attr('id');

                $.ajax({
                    // headers: {'X-CSRF-TOKEN': $token},
                    url: "{{ url('/rejection/reason') }}",

                    type: "post",
                    data: {
                        'batch': batch,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        //location.reload(true);
                        console.log(data.comment);
                        $('#reason').html(data.comment);
                    }
                });


                $("#rejectModal").modal('show');

            });

        });
    </script>
@endsection
