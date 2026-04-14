@extends('layouts_procurement.app')
@section('pageTitle', 'List of Contracts')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">

            <!-- Card / Panel -->
            <div class="panel panel-default">

                <!-- Alert Section -->
                {{-- <div class="panel-body">
                    @include('procurement.ShareView.operationCallBackAlert')
                </div> --}}

                <div class="panel-heading">
                    <h4 class="panel-title">Contract List</h4>
                </div>

                <div class="panel-body">

                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Lot No.</th>
                                <th>Contract</th>
                                <th>Contractor</th>
                                <th>Proposed Amount (NGN)</th>
                                <th>Awarded Amount (NGN)</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        @php $n = 1; @endphp

                        <tbody>
                            @foreach ($getList as $list)
                                <?php
                                $checkAprove = DB::table('tblapproval')->where('bidding_id', $list->contract_biddingID)->where('status_id', 3)->exists();

                                $para = base64_encode($list->contract_biddingID);
                                $parac = base64_encode($list->contract_detailsID);
                                ?>

                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td>{{ $list->lot_number }}</td>
                                    <td>{{ $list->contract_name }}</td>
                                    <td>{{ $list->company_name }}</td>
                                    <td align="right">{{ number_format($list->proposed_budget, 2) }}</td>
                                    <td align="right">{{ number_format($list->awarded_amount, 2) }}</td>

                                    <td>

                                        @if (($list->complete == 0 && $list->role_unit_id != 0) || ($list->complete == 5 && $list->role_unit_id == 0))
                                            <button class="btn btn-danger btn-sm">Awaiting Confirmation...</button>

                                            <a href="upload-payment-request/{{ $para }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                Upload
                                            </a>
                                        @elseif($list->complete == 5 && $list->role_unit_id != 0)
                                            <button class="btn btn-default btn-sm">Confirmed</button>
                                        @elseif($list->complete == 0 && $list->role_unit_id == 0)
                                            <button class="btn btn-primary btn-sm"
                                                onclick="confirmValue('{{ $list->contract_biddingID }}')">
                                                Confirm Completion
                                            </button>

                                            <a href="upload-payment-request/{{ $para }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                Upload
                                            </a>
                                        @endif

                                        <a href="view-contract-list/{{ $parac }}" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            View Contract
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal{{ $list->contract_biddingID }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Contract</h4>
                                            </div>

                                            <div class="modal-body">

                                                <form method="post" action="{{ route('push') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label>Unit:</label>
                                                        <select class="form-control" name="unit" required>
                                                            <option value="">--Select--</option>
                                                            @foreach ($units as $u)
                                                                <option value="{{ $u->unitID }}">{{ $u->unit }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <input type="hidden" name="cid"
                                                            value="{{ $list->contractID }}">
                                                        <input type="hidden" name="contractor"
                                                            value="{{ $list->contractorID }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Comment:</label>
                                                        <textarea class="form-control" rows="2" name="comment"></textarea>
                                                    </div>

                                                    <label>Attach documents (Optional)</label>
                                                    <div>
                                                        <input type="file" class="form-control" name="images1"><br>
                                                        <input type="text" class="form-control" name="file_description"
                                                            placeholder="Enter File Description"><br>
                                                    </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Push</button>
                                                <button type="button" class="btn btn-default"
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
    <link href="{{ asset('assets/css/select2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
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
        function confirmValue(id) {
            $("#myModal" + id).modal('show');
        }
    </script>
    <script>
        var counter = 0;

        function AddFileUpload(x) {
            var div = document.createElement('DIV');
            var img = document.getElementById("image").value;

            img = parseInt(img) + 1;
            div.innerHTML = "<hr><input type = file name = images" + img +
                " class='form-control form-control-a'> <br><input type = text name = description" + img +
                " placeholder='Enter file description' class='form-control form-control-a'><br>" +
                "<input id='Button' " + img +
                "  type='button' class='btn btn-outline-primary btn-sm' value='- Remove' onclick = 'RemoveFileUpload(this)' style='cursor:pointer;color:black' />";

            document.getElementById("image").value = img;
            document.getElementById("files" + x).appendChild(div);
        }

        function RemoveFileUpload(div) {
            document.getElementById("files").removeChild(div.parentNode);
        }
    </script>

@endsection
