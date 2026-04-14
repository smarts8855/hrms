@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('List of Contracts for Approval') }}
@endsection
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card Replacement -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="margin:0; font-weight:bold;">List of Contracts for Approval</h4>
                </div>

                <div class="panel-body">

                    <!-- Search Form -->
                    <form class="form-horizontal" method="post" action="{{ url('/view-bidded-contracts') }}" novalidate>
                        {{ csrf_field() }}

                        <div class="row" style="padding: 18px">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Select Contract</label>
                                    <select name="contract" class="form-control select2" id="contract">
                                        <option value="">Select</option>
                                        @foreach ($contract as $list)
                                            <option value="{{ $list->contract_detailsID }}"
                                                @if ($list->contract_detailsID == session('contractSession')) selected @endif>
                                                {{ $list->contract_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <input type="submit" class="btn btn-success btn-block" value="Search" />
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Lot Number</th>
                                    <th>Contract</th>
                                    <th>Description</th>
                                    <th>Proposed Budget</th>
                                    <th>Proposed Deadline</th>
                                    <th>Minutes</th>
                                    <th>View Bids</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $n = 1; @endphp

                                @foreach ($contract as $list)
                                    <?php
                                    $para = base64_encode($list->contract_detailsID);
                                    $countWords = str_word_count($list->contract_description);
                                    $pieces = explode(' ', $list->contract_description);
                                    $partDesc = implode(' ', array_splice($pieces, 0, 5));
                                    ?>
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $list->lot_number }}</td>
                                        <td>{{ $list->contract_name }}</td>

                                        <td>
                                            @if ($countWords > 5)
                                                {{ $partDesc }}...
                                                <a href="javascript:void(0)" class="btn btn-link btn-xs more"
                                                    id="{{ $list->contract_detailsID }}">
                                                    Read More
                                                </a>
                                            @else
                                                {{ $list->contract_description }}
                                            @endif
                                        </td>

                                        <!-- Modal -->
                                        <div id="docModal" class="modal fade read{{ $list->contract_detailsID }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h3 class="modal-title">Description</h3>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>{{ $list->contract_description }}</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <td align="right">{{ number_format($list->proposed_budget, 2) }}</td>
                                        <td align="right">
                                            {{ date('jS M, Y', strtotime($list->proposed_time_frame)) }}
                                        </td>

                                        <td>
                                            <a href="{{ url('/contracts-coments/' . $para) }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                View Minutes
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ url('/preview-all-bids/' . $para) }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                View Bids
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- End Panel -->

        </div>
    </div> <!-- end row -->


    <!-- Modal For Bidding Editing -->


@endsection

@section('styles')
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ccc !important;
            border-radius: 0px !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(".table tr td .editButton").click(function() {
                var id = $(this).attr('id');
                $('#bidID').val(id);
                $.ajax({
                    url: murl + '/fetch-bid',
                    type: "post",
                    data: {
                        'bidID': id,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {

                        $('#date').val(data.date_submitted);
                        $('#contractorRemark').val(data.contractor_remark);
                        $('#biddingAmount').val(data.bidding_amount);
                        $('#contract').append('<option value="' + data.contract_detailsID +
                            '" selected>' + data.contract_name + '</option>');
                        $('#contractor').append('<option value="' + data
                            .contractor_registrationID + '" selected>' + data.company_name +
                            '</option>');
                    }
                });

                $(".bidEdit").modal('show');

            });
        });
    </script>
    <script>
        $('.select2').select2();
    </script>

    <script>
        function confirmDelete() {
            $val = confirm('Do you actually want to delete');
            if ($val) {
                return true
            } else {
                return false;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#contractor").change(function() {
                $(".cont").val('');
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("table tr td .more").click(function() {

                var bid = $(this).attr('id');
                $('.read' + bid).modal('show');

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
@endsection
