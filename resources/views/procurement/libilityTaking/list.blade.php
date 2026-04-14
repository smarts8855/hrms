@extends('layouts_procurement.app')
@section('pageTitle', 'Contracts ready for Liability Taking')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">

            <!-- Bootstrap 3 Card Equivalent -->
            <div class="panel panel-default" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">

                <!-- Panel Heading -->
                <div class="panel-heading" style="background:#fff; border-bottom:1px solid #ddd;">
                    <h4 class="panel-title" style="margin:0; font-weight:600;">Awarded Contracts</h4>
                </div>

                <!-- Panel Body -->
                <div class="panel-body">



                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Contractor</th>
                                <th>Contract</th>
                                <th>Awarded Amount</th>
                                <th>Award Date</th>
                                <th>View Award Letter</th>
                                <th>Move to Director Finance</th>
                            </tr>
                        </thead>

                        @php $n = 1; @endphp

                        <tbody>
                            @foreach ($display as $list)
                                <?php $para = base64_encode($list->contract_biddingID); ?>
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $list->company_name }}</td>
                                    <td>{{ $list->contract_name }}</td>
                                    <td align="right">{{ number_format($list->bidding_amount, 2) }}</td>
                                    <td>{{ date('jS M, Y', strtotime($list->date_submitted)) }}</td>

                                    <td>
                                        <a href="{{ url('/view-letter/' . $para) }}" class="btn btn-primary btn-sm">
                                            View Award Letter
                                        </a>
                                    </td>

                                    <td>
                                        <a href="javascript:void()" class="btn btn-success btn-sm" id="minute"
                                            bidid="{{ $list->contract_biddingID }}"
                                            contractorID="{{ $list->contractorID }}">
                                            Move To Director
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div> <!-- panel-body -->

            </div> <!-- panel -->

        </div> <!-- col -->
    </div> <!-- row -->



    <!-- Modal -->




    <div id="remarkModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">
                        Contract Recommendation for Liability Taking
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- CARD / PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <form class="form-horizontal" method="post" action="{{ url('/contracts-for-libility') }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="remark" class="control-label">Remark</label>
                                    <textarea name="remark" class="form-control" rows="4"></textarea>

                                    <input type="hidden" name="bidID" id="bidID" />
                                    <input type="hidden" name="contractorID" id="contractorID" />
                                </div>

                                <div class="form-group text-center" style="margin-top: 15px;">
                                    <button class="btn btn-primary" type="submit">Proceed</button>
                                </div>

                            </form>

                        </div>
                    </div>
                    <!-- END CARD / PANEL -->

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>





    <!--end modal-->



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

        .swal-popup {
            padding: 10px !important;
        }

        .swal-title {
            font-size: 13px !important;
            font-weight: bold;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('msg'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end', // top-end, top-start, bottom-end, etc.
                icon: 'success',
                title: '{{ session('msg') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-popup',
                    title: 'swal-title'
                },
            });
        </script>
    @endif






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
        $(document).ready(function() {

            $(".table tr td #minute").click(function() {
                var bidid = $(this).attr('bidid');
                var contractorID = $(this).attr('contractorID');
                $('#bidID').val(bidid);
                $('#contractorID').val(contractorID);
                $("#remarkModal").modal('show');

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
@endsection
