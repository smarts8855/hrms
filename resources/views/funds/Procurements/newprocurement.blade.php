@extends('layouts.layout')
@section('pageTitle')
    Initiate Contract Payment
@endsection



@section('content')

    <div class="box box-default">
        <div class="box-body box-profile">
            <div class="box-header with-border hidden-print">
                <h3 class="box-title">@yield('pageTitle') <span id='processing'></span></h3>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('funds.Share.message')

                            <form class="form-horizontal" id="form1" role="form" method="post" action=""
                                enctype="multipart/form-data">
                                {{ csrf_field() }}


                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Contract File No:</label>
                                        <input extarea required class="form-control" id="fileno"
                                            placeholder="e.g SCN/XXXX" name="fileno" value="{{ old('fileno') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="control-label">Approval Page:</label>
                                        <input extarea required class="form-control" id="approvalpage" placeholder="e.g 12"
                                            name="approvalpage" value="{{ old('approvalpage') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Contract Type(optional)</label>
                                        <select class="form-control" id="contracttype" name="contracttype" required>
                                            <option value="">Select Contract</option>
                                            @foreach ($contractlist as $list)
                                            @if($list->ID != 6)
                                                <option value="{{ $list->ID }}"
                                                    {{ old('contracttype') == $list->ID ? 'selected' : '' }}>
                                                    {{ $list->contractType }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-3">
                                        <label class="control-label">Contract Value</label>
                                        <input required class="form-control" id="contractvalue"
                                            value="{{ old('contractvalue') ? $contractvalue : '' }}"
                                            placeholder="e.g. N100000" type="text" name="contractvalue">
                                    </div> --}}


                                    <div class="col-md-3">
                                        <label class="control-label">Contract Value</label>
                                        <input required class="form-control" id="contractvalue"
                                            value="{{ old('contractvalue') }}" placeholder="e.g. N100000" type="text"
                                            name="contractvalue">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <label class="control-label">Beneficiary Name</label>
                                        <select required id="companyid" name="companyid" class="select_picker form-control"
                                            data-live-search="true">
                                            <option value="">Select Company</option>
                                            @foreach ($companyDetails as $list)
                                                <option value="{{ $list->id }}"
                                                    {{ old('companyid') == $list->id ? 'selected' : '' }}>
                                                    {{ $list->contractor }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="control-label">Date Awarded</label>
                                        <input required readonly class="form-control" id="todayDate" autocomplete="off"
                                            name="date_awarded" value="{{ old('date_awarded') }}">
                                    </div>

                                    {{-- <div class="col-md-3">
                                            <label class="control-label">Attach file</label>
                                            <input class="form-control" type="file" id="file" autocomplete="off"
                                                name="filex">
                                        </div> --}}
                                    <div class="col-md-3">
                                        <label class="control-label">
                                            Attach file <small class="text-danger">(Max: 5MB)</small>
                                        </label>

                                        <input class="form-control" type="file" id="file" name="filex"
                                            accept=".pdf,.jpg,.jpeg,.png,.gif">

                                        {{-- <small class="text-muted">
                                                Allowed formats: PDF, JPG, PNG • Maximum size: 1MB
                                            </small>
                                        </div> --}}
                                    </div>

                                    <div class="col-md-3">
                                        <label class="control-label">Action by</label>
                                        <select required name="attension" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($officers as $list)
                                                <option value="{{ $list->code }}">{{ $list->description }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" value="{{ Auth::user()->username }}" id="createdby"
                                            name="createdby">
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- <div class="col-md-3">
                                            <label class="control-label" style="margin-top: 20px;">
                                                
                                                <input type="checkbox" id="is_part_payment" name="is_part_payment" value="1">
                                                Is Part Payment
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Amount</label>
                                            <input class="form-control"
                                                id="payment_amount"
                                                name="part_amount"
                                                type="text"
                                                readonly>
                                        </div> --}}
                                    <div class="col-md-9">
                                        <label class="control-label">Contract Description</label>
                                        <textarea required class="form-control" id="contract-desc" rows="1" name="contract-desc">{{ old('contract-desc') }}</textarea>
                                    </div>


                                    {{-- <div class="col-md-3">
                                            <label class="control-label">TIN:</label>
                                            <input required class="form-control" id="tin" name="tin"
                                                value="{{ old('tin') }}">
                                        </div> --}}

                                    <div class="col-md-3">
                                        <label class="control-label" style="visibility: hidden">Submit:</label>
                                        <button class="form-control btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>




                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================= TABLE CARD ========================= -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title text-uppercase">Initiated Contract Payment</h4>
                </div>

                <div class="box-body">
                    <div class="table-responsive" style="font-size: 12px; padding:10px;">
                        <table id="res_tab" class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr bgcolor="#c7c7c7">
                                    <th>S/N</th>
                                    <th>Entry No</th>
                                    <th>File No</th>
                                    <th>A.Page</th>
                                    <th>TIN</th>
                                    <th style="word-wrap: break-word; white-space: normal;">Contract Type</th>
                                    <th style="word-wrap: break-word; white-space: normal;">Contract Description</th>
                                    <th style="word-wrap: break-word; white-space: normal;">Contract Value (₦)</th>
                                    <th>Company</th>
                                    <th>Created BY</th>
                                    <th style="word-wrap: break-word; white-space: normal;">Approved Status</th>
                                    <th>Next officer</th>
                                    <!--<th>Approved Date</th>-->
                                    <th colspan="3">Action</th>
                                </tr>
                            </thead>
                            @php $i = 1; @endphp
                            <tbody>

                                @foreach ($procurementlist as $list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $list->ID }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">{{ $list->fileNo }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">
                                            {{ $list->ref_no ? $list->ref_no : 'NA' }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">{{ $list->tin }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">{{ $list->contractType }}
                                        </td>
                                        <td style="word-wrap: break-word; white-space: normal;">
                                            {{ $list->ContractDescriptions }}</td>
                                        @php $list->contractValue = $list->contractValue; @endphp
                                        <td>{{ number_format($list->contractValue, 2) }}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">{{ $list->contractor }}
                                        </td>
                                        <td>{{ $list->name }}</td>

                                        <td>
                                            @if ($list->approvalStatus == 1)
                                                <span class="label label-success">Approved </span>
                                            @elseif($list->approvalStatus == 2)
                                                <span class="label label-success">Rejected </span>
                                            @else
                                                <span class="label label-danger">Pending</span>
                                            @endif
                                        </td>

                                        <td>{{ $list->awaitingActionby }}</td>
                                        <td colspan="3">
                                            @if ($list->approvalStatus == 0)
                                                <div style="white-space: nowrap;">
                                                    {{-- <button
                                                        onclick="return editfunc('{{ $list->ID }}', '{{ $list->fileNo }}', '{{ $list->contract_Type }}','{{ $list->ContractDescriptions }}','{{ $list->contractValue }}','{{ $list->companyID }}','{{ $list->dateAward }}','{{ $list->awaitingActionby }}', '{{ $list->ref_no }}', '{{ $list->tin }}')"
                                                        class="btn btn-success btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button> --}}
                                                    @if ($list->paymentStatus == 0 || $list->paymentStatus == '')
                                                        <button
                                                            onclick='editfunc(
                                                            {{ $list->ID }},
                                                            @json($list->fileNo),
                                                            @json($list->contract_Type),
                                                            @json($list->ContractDescriptions),
                                                            @json($list->contractValue),
                                                            @json($list->companyID),
                                                            @json($list->dateAward),
                                                            @json($list->awaitingActionby),
                                                            @json($list->ref_no),
                                                            @json($list->tin)
                                                        )'
                                                            class="btn btn-success btn-xs">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    @endif

                                                    <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                        class="btn btn-success btn-xs">View</a>
                                                </div>
                                            @elseif($list->approvalStatus == 2)
                                                <div style="white-space: nowrap;">
                                                    {{-- <button
                                                        onclick="return editfunc('{{ $list->ID }}', '{{ $list->fileNo }}', '{{ $list->contract_Type }}','{{ $list->ContractDescriptions }}','{{ $list->contractValue }}','{{ $list->companyID }}','{{ $list->dateAward }}'),'{{ $list->awaitingActionby }}')"
                                                        class="btn btn-success btn-xs">
                                                        <i class="fa fa-edit "></i>

                                                    </button> --}}

                                                    <button
                                                        onclick='editfunc(
                                                            {{ $list->ID }},
                                                            @json($list->fileNo),
                                                            @json($list->contract_Type),
                                                            @json($list->ContractDescriptions),
                                                            @json($list->contractValue),
                                                            @json($list->companyID),
                                                            @json($list->dateAward),
                                                            @json($list->awaitingActionby)
                                                        )'
                                                        class="btn btn-success btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                        class="btn btn-success btn-xs">View</a>
                                                </div>
                                            @else
                                                <a href="/display/comment/{{ $list->ID }}" target="_blank"
                                                    class="btn btn-success btn-xs">View</a>
                                            @endif


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <input type="hidden" value="" id="co" name="court">
                    <input type="hidden" value="" id="di" name="division">
                    <input type="hidden" value="" name="status">
                    <input type="hidden" value="" name="chosen" id="chosen">
                    <input type="hidden" value="" id="type" name="type">


                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="editpartModal" name="editpartModal" role="form" method="POST"
                    action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class=" control-label">File No:</label>
                                <input type="text" value="" name="file_no" id="file_no" readonly
                                    class="form-control">
                                <input type="hidden" value="" name="id" id="eid">
                            </div>
                            <div class="col-sm-6">
                                <label class=" control-label">Approval Page:</label>
                                <input type="text" value="" name="approvalpage" id="refNo"
                                    class="form-control">
                            </div>

                            <div class="col-sm-6">
                                <label class=" control-label">Contract Type</label>
                                <select name="contr_type" id="contr_type" class="form-control">
                                    @foreach ($contractlist as $list)
                                        @if($list->ID != 6)
                                        <option value="{{ $list->ID }}">{{ $list->contractType }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-sm-6">
                                <label class="control-label">Contract Values</label>
                                <input type="text" value="" name="contr_val" id="contr_val" placeholder=""
                                    class="form-control">
                            </div>

                            <div class="col-sm-6">
                                <label class="control-label"> Company </label>
                                <select name="company" id="company" class="form-control">
                                    <option value=""></option>
                                    @foreach ($companyDetails as $list)
                                        <option value="{{ $list->id }}">{{ $list->contractor }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="control-label">Date Awarded</label>
                                <input type="text" value="" name="dateawd" id="dateawd" autocomplete="off"
                                    class="form-control">
                            </div>



                            <div class="col-sm-6">
                                <label class=" control-label">Reassing to</label>
                                <select name="actionby" id="actionbyid" class="form-control">
                                    @foreach ($officers as $list)
                                        <option value="{{ $list->code }}">{{ $list->description }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-6">
                                <label class="control-label">TIN</label>
                                <input type="text" value="" name="tin" id="editTin" placeholder=""
                                    class="form-control">
                            </div>

                            <div class="col-sm-12">
                                <label class="control-label">Upload project file</label>
                                <input type="file" value="" name="filex" id="dateawd" autocomplete="off"
                                    class="form-control">
                            </div>

                            <div class="col-sm-12">
                                <label class="control-label">Contract Description</label>
                                <textarea name="contr_desc" id="contr_desc" class="form-control"> </textarea>
                            </div>

                            <input type="hidden" id="edit-hidden" name="edit-hidden" value="">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


    <!--reason modal-->
    <div id="reasonModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reason for rejection</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="control-label"><i id="msg-reason"></i></label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <!--<button type="Submit" class="btn btn-success" id="putedit"></button>-->
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>


            </div>

        </div>
    </div>
    <!--end of reason-->

    <div id="DeleteModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to delete this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="deleteid" name="deleteid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <div id="RestoreModal" class="modal fade">
        <div class="modal-dialog box box-default" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Restore Variable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <div class="col-sm-12">
                                <label class="col-sm-9 control-label"><b>Are you sure you want to restore this
                                        record?</b></label>
                            </div>
                            <input type="hidden" id="restoreid" name="restoreid" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>



    <div id="attachModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">File Attachment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="deletevariableModal" role="form" method="POST" action=""
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group" style="margin: 0 10px;">
                            <input type="hidden" class="form-control" id="cid" name="id">
                            <div class="col-sm-12">

                                <label class="control-label">
                                    <h5>File Description </h5>
                                </label>
                                <input required class="form-control" autocomplete="off" name="attachment_description">

                            </div>
                            <div class="col-sm-12">

                                <label class="control-label">Attach File:</label>
                                <input type="file" name="filename" class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="btn-attachment">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.min.css') }}">
@stop

@section('styles')
    <style type="text/css">
        .modal-dialog {
            width: 13cm
        }

        .modal-header {

            background-color: #006600;

            color: #FFF;

        }

        #partStatus {
            width: 2.5cm
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        $(function() {
            $("#todayDate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

    <script>
        document.getElementById('contractvalue').addEventListener('input', function(e) {
            let value = e.target.value;

            // Remove everything except digits and decimal point
            value = value.replace(/[^\d.]/g, '');

            // Allow only one decimal point
            const parts = value.split('.');
            if (parts.length > 2) {
                parts.splice(2); // keep only first decimal
            }

            // Format integer part with commas
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // Combine integer and decimal parts
            e.target.value = parts.join('.');
        });

        document.getElementById('payment_amount').addEventListener('input', function(e) {
            let value = e.target.value;

            // Remove everything except digits and decimal point
            value = value.replace(/[^\d.]/g, '');

            // Allow only one decimal point
            const parts = value.split('.');
            if (parts.length > 2) {
                parts.splice(2); // keep only first decimal
            }

            // Format integer part with commas
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // Combine integer and decimal parts
            e.target.value = parts.join('.');
        });
    </script>

    <script>
        const contrValInput = document.getElementById('contr_val');

        contrValInput.addEventListener('input', function() {
            let value = this.value.replace(/,/g, ''); // remove existing commas

            // Split integer and decimal parts
            let parts = value.split('.');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? '.' + parts[1] : '';

            // Add commas to integer part
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // Combine
            this.value = integerPart + decimalPart;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const contractValue = document.getElementById('contractvalue');
            const partPaymentCheckbox = document.getElementById('is_part_payment');
            const amountField = document.getElementById('payment_amount');

            function syncAmount() {
                if (!partPaymentCheckbox.checked) {
                    // Not part payment → amount = contract value
                    amountField.value = contractValue.value;
                    amountField.readOnly = true;
                } else {
                    // Part payment → user enters amount
                    amountField.value = '';
                    amountField.readOnly = false;
                    amountField.focus();
                }
            }

            // When checkbox changes
            partPaymentCheckbox.addEventListener('change', syncAmount);

            // When contract value changes
            contractValue.addEventListener('input', function() {
                if (!partPaymentCheckbox.checked) {
                    amountField.value = contractValue.value;
                }
            });

            // Initial load
            syncAmount();
        });
    </script>

    <script>
        function editfunc(a, b, c, d, e, f, g, h, ref_no, tin) {
            $("#reasonModal").modal('hide');
            document.getElementById('file_no').value = b;
            document.getElementById('eid').value = a;

            var opt = document.getElementById('contr_type');
            for (i = 0; i < opt.length; i++) {
                if (opt.options[i].value == c) opt.options[i].selected = "selected";
            }

            document.getElementById('contr_desc').value = d;
            // document.getElementById('contr_val').value = e;
            document.getElementById('contr_val').value = Number(e).toLocaleString('en-US');

            document.getElementById('edit-hidden').value = 1;
            document.getElementById('actionbyid').value = h;

            var opt2 = document.getElementById('company');
            for (i = 0; i < opt2.length; i++) {
                if (opt2.options[i].value == f) opt2.options[i].selected = "selected";
            }

            document.getElementById('dateawd').value = g;

            document.getElementById('refNo').value = ref_no;
            document.getElementById('editTin').value = tin;
            console.log(ref_no);
            $("#editModal").modal('show');
        }
    </script>

    <script>
        $('.select_picker').selectpicker({
            style: 'btn-default',
            size: 4
        });

        $('#res_tab').DataTable({
            "iDisplayLength": 100
        });


        $("#contractvalue").blur(function(evt) {
            if (evt.which != 190) { //not a fullstop
                var n = parseFloat($(this).val().replace(/\,/g, ''), 10);
                $(this).val(n.toLocaleString());
            }
        });

        $(function() {
            $("#dateawd").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });

        $("#check-all").change(function() {
            $(".checkitem").prop("checked", $(this).prop("checked"))
        })
        $(".checkitem").change(function() {
            if ($(this).prop("checked") == false) {
                $("#check-all").prop("checked", false)
            }
            if ($(".checkitem:checked").length == $(".checkitem").length) {
                $("#check-all").prop("checked", true)
            }
        })

        function approve(a = '') {
            if (a !== '') {
                document.getElementById('chosen').value = a;
                // alert(a);
            }
            co = document.getElementById('court').value;
            div = document.getElementById('division').value;
            document.getElementById('co').value = co;
            document.getElementById('di').value = div;
            document.getElementById('type').value = 1;
            document.getElementById('form2').submit();
            return false;
        }

        function reject(a = '') {
            if (a !== '') {
                document.getElementById('chosen').value = a;
                //alert(a);
            }
            co = document.getElementById('court').value;
            div = document.getElementById('division').value;
            document.getElementById('co').value = co;
            document.getElementById('di').value = div;
            document.getElementById('type').value = 2;
            document.getElementById('form2').submit();
            return false;
        }

        function viewReason(reason, a, b, c, d, e, f, g) {
            //document.getElementById('putedit').setAttribute("onclick", "editfunc('"a"','"b"','"c"','"d"','"e"','"f"','"g"')");
            document.getElementById('msg-reason').innerText = reason;

            $("#reasonModal").modal('show')

        }

        function delet(a = '') {
            if (confirm('Are you sure you want to delete this record!')) {
                if (a !== '') {
                    document.getElementById('chosen').value = a;
                    //alert(a);
                }
                co = document.getElementById('court').value;
                div = document.getElementById('division').value;
                document.getElementById('co').value = co;
                document.getElementById('di').value = div;
                document.getElementById('type').value = 3;
                document.getElementById('form2').submit();
            }
            return false;

            function deletefunc(x) {
                //$('#deleteid').val() = x;

                document.getElementById('deleteid').value = x;
                $("#DeleteModal").modal('show');
            }

            function addattachment(x) {
                document.getElementById('cid').value = x;
                $("#attachModal").modal('show');
            }
        }
    </script>

    <script>
        document.getElementById('companyid').addEventListener('change', function() {
            const companyId = this.value;
            const tinInput = document.getElementById('tin');

            tinInput.value = ''; // reset first

            if (!companyId) return;

            fetch(`/company/get-tin/${companyId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.tin) {
                        tinInput.value = data.tin;
                        tinInput.readOnly = true; // optional: prevent editing
                    } else {
                        tinInput.readOnly = false;
                    }
                })
                .catch(() => {
                    tinInput.readOnly = false;
                });
        });
    </script>

@stop
