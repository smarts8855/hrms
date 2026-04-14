@extends('layouts.layout')
@section('pageTitle')
    Beneficiary setup/adjustment
@endsection
@section('content')
    <div id="editModal" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"> Claim modification </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to modify the claim value, Do you still want to continue?</h5>
                        <div class="form-group" style="margin: 5 10px;">
                            <div class="col-sm-12">
                                <input type="text" value="" id="ename" class="form-control" readonly>
                            </div>

                        </div>

                        <div class="form-group" style="margin: 5 10px;">
                            <div class="col-sm-12">
                                <label class="control-label">Amount</b></label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" value="" name="amount" id="eamount"
                                    class="form-control money-format">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="Submit" name="update" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden" id="ebeneid" name="beneid" value="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="deleteModal" class="modal fade">
        <form class="form-horizontal" role="form" method="post" action="">
            {{ csrf_field() }}
            <div class="modal-dialog box-default" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Record removal </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5> You are about to delete this record, Do you still want to continue?</h5>
                        <div class="form-group" style="margin: 5 10px;">
                            <div class="col-sm-12">
                                <input type="text" value="" id="dname" class="form-control" readonly>
                            </div>

                        </div>

                        <div class="form-group" style="margin: 5 10px;">
                            <div class="col-sm-12">
                                <label class="control-label">Amount</b></label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" value="" name="amount" id="damount" class="form-control"
                                    readonly>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="Submit" name="delete" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden" id="dbeneid" name="beneid" value="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Raise Staff Claim Voucher</h3>
        </div>


        <div class="row">
            <div class="col-md-12">

                <!-- Error from header (Excel headers or claim not found) -->
                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif

                <!-- Success or info message -->
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Info:</strong> <br />
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Laravel validation errors (like required file, claimid) -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Validation Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>


        <div class="box-body">

            <!-- TAB CONTENT -->
            <div class="tab-content" style="margin-top:20px;">

                <div role="tabpanel" class="tab-pane fade in active" id="bulk">


                    <form action="{{ route('upload.beneficiaries') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="col-md-12">
                                <label class="control-label">Claim Description</label>
                                <select name="claimid" id="claimid" onchange="ReloadForm()" class="form-control">
                                    <option value="">-Select-</option>
                                    @php
                                        if (old('claimid') != '') {
                                            $claimid = old('claimid');
                                        }
                                    @endphp
                                    @foreach ($Claimlist as $list)
                                        <option value="{{ $list->claimid }}"
                                            @if ($claimid == $list->claimid) {{ 'selected' }} @endif>
                                            {{ $list->contractValue }}|({{ $list->ContractDescriptions }}):{{ $list->beneficiary }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-4">
                                <a
                                        href="/create/staff-voucher/{{ $ID }}"class="btn btn-success text-uppercase">Raise
                                        voucher</a>
                            </div>
                        </div>

                    </form>
                    <br>
                </div>

                


            </div> <!-- END tab-content -->
        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <script>
        const inputs = document.querySelectorAll('.money-format');

        inputs.forEach(input => {

            input.addEventListener('input', function() {

                let value = this.value;

                // Remove EVERYTHING except digits and dot
                value = value.replace(/[^\d.]/g, '');

                // Prevent multiple dots
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts[1];
                }

                let newParts = value.split('.');

                // Format integer with commas
                newParts[0] = newParts[0]
                    .replace(/^0+(?!$)/, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Limit decimals to 2
                if (newParts[1]) {
                    newParts[1] = newParts[1].substring(0, 2);
                }

                this.value = newParts.join('.');
            });
        });


        // Remove commas before Laravel receives it
        document.getElementById('form1').addEventListener('submit', function() {

            document.querySelectorAll('.money-format').forEach(input => {
                input.value = input.value.replace(/,/g, '');
            });

        });
    </script>



    <script type="text/javascript">
        $('.select_picker').selectpicker({
            style: 'btn-default',
            size: 4
        });

        function ReloadForm() {
            document.getElementById('thisform1').submit();
            return;
        }

        function Editvalue(id, amt, name) {
            document.getElementById('ebeneid').value = id;
            document.getElementById('eamount').value = amt;
            document.getElementById('ename').value = name;
            $("#editModal").modal('show');
        }

        function DeleteRec(id, amt, name) {
            document.getElementById('dbeneid').value = id;
            document.getElementById('damount').value = amt;
            document.getElementById('dname').value = name;
            $("#deleteModal").modal('show');
        }
    </script>
@endsection
