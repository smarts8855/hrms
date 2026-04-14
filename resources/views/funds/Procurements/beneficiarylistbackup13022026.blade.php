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
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
        </div>


        <div class="box box-success">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('err'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Error!</strong> <br />
                                {{ session('err') }}
                            </div>
                        @endif
                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Success!</strong> <br />
                                {{ session('err') }}
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

                <form method="post" id="thisform1" name="thisform1">
                    {{ csrf_field() }}
                    <div class="box-body">
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

                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <label class="control-label">Staff name</label>
                                <select name="staffid" id="staffid" class="select_picker form-control"
                                    data-live-search="true" required>
                                    <option value="">-Select-</option>
                                    @php
                                        $staffid = old('staffid') ?? '';
                                    @endphp
                                    @foreach ($StaffInformation as $list)
                                        <option value="{{ $list->ID }}"
                                            @if ($staffid == $list->ID) selected @endif
                                            @if ($list->isClaimed == 1 && $list->staff_status == 0) style="background-color: #f8d7da; color: #721c24;" @endif>
                                            {{ $list->surname }} {{ $list->first_name }} {{ $list->othernames }} -
                                            ({{ $list->fileNo }})
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-5">
                                <label>Ammount</label>
                                <input type="text" name="amount" class="form-control money-format"
                                    placeholder="Amount" value="{{ isset($amount) ? $amount : '' }}"
                                    inputmode="decimal">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-success form-control" name="add">
                                    <i class="fa fa-btn fa-floppy-o"></i> Add Beneficiary
                                </button>
                            </div>
                        </div>
                        <input id ="delcode" type="hidden" name="delcode">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="box box-default">
        <div class="box-header with-border hidden-print">
            <h3 class="box-title">Bulk Upload Beneficiaries <span id='processing'></span></h3>
        </div>
        <div class="box box-info">
            <div class="box-body">

                <div class="alert alert-warning">
                    <strong>Important:</strong>
                    Instead of adding beneficiaries one by one, you can upload them using Excel.

                    <br><br>

                    <b>Excel must contain ONLY these columns:</b>

                    <ul>
                        <li>staff_id</li>
                        <li>amount</li>
                    </ul>

                    ✔ Do not rename the columns
                    ✔ Do not add extra columns
                    ✔ Ensure staff_id exists in the system

                    <br>

                    <a href="{{ route('download.beneficiary.template') }}" class="btn btn-primary btn-sm">
                        Download Sample Excel
                    </a>
                </div>

                <form action="{{ route('upload.beneficiaries') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-md-10">
                            <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv"
                                required>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-info form-control">
                                Upload Excel
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <div class="box box-default">
        <!-- ========================= TABLE CARD ========================= -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title text-uppercase">Beneficiary List</h4>
            </div>

            <div class="box-body">
                <div class="table-responsive" style="font-size: 12px; padding:10px;">
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr bgcolor="#c7c7c7">
                                <th width="1%">S/N</th>
                                <th>Beneficiary names </th>
                                <th>Amount </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $serialNum = 1;
                            $totalsum = 0;
                        @endphp
                        @foreach ($StaffInformation_Claim as $b)
                            @php $totalsum +=$b->staffamount; @endphp
                            <tr>
                                <td>{{ $serialNum++ }} </td>
                                <td>{{ $b->surname }} {{ $b->first_name }} {{ $b->othernames ?? '' }}</td>
                                <td>{{ number_format($b->staffamount, 2, '.', ',') }}</td>
                                <td>
                                    <a href="javascript: Editvalue('{{ $b->selectedID }}','{{ $b->staffamount }}','{{ str_replace("'", '', $b->surname) }}')"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <a
                                        href="javascript: DeleteRec('{{ $b->selectedID }}','{{ $b->staffamount }}','{{ str_replace("'", '', $b->surname) }}')"class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=2 style="font-size: 14px; font-weight:700; background-color: #e8f5e9;"
                                class="text-uppercase">Total</td>
                            <td style="font-size: 14px; font-weight:700; background-color: #e8f5e9;">
                                {{ number_format($totalsum, 2, '.', ',') }}
                            </td>


                            <td>
                                @if (round($totalclaim, 2) == round($totalsum, 2) && $totalclaim != 0)
                                    <a
                                        href="/create/staff-voucher/{{ $ID }}"class="btn btn-success text-uppercase">Raise
                                        voucher</a>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>


@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>


    {{-- <script>
        const input = document.getElementById('formatAmount');

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

            // Format integer with commas (STRING safe)
            newParts[0] = newParts[0]
                .replace(/^0+(?!$)/, '') // remove leading zeros
                .replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Limit decimals to 2
            if (newParts[1]) {
                newParts[1] = newParts[1].substring(0, 2);
            }

            this.value = newParts.join('.');
        });


        // Remove commas before Laravel receives it
        document.getElementById('form1').addEventListener('submit', function() {
            input.value = input.value.replace(/,/g, '');
        });
    </script> --}}

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
