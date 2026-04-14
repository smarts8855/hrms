@extends('layouts.layout')

@section('pageTitle')
    Generated Payment
@endsection

@section('content')
    <div class="modal">I'm the Modal Window!</div>
    <div class="box-body">

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
                <h2 class="text-center">{{ $company->companyName }}</h2>
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
                    <form action="{{ url('/cpo/confirm') }}" method="post">
                        {{ csrf_field() }}
                        <table id="myTable" class="table table-bordered" cellpadding="10">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Beneficiary</th>
                                    <th>Contract Type</th>
                                    <th class="text-center">Amount ( &#8358;)</th>
                                    <th class="text-center">Payment Description</th>
                                    {{-- <th>Account No</th>
                                    <th>Bank</th> --}}
                                    <th colspan=""> Select Appropriate <br><span>Un Check All</span> <input type="checkbox"
                                            class="check" name="checkAll" id="checkAll" checked /> </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $key = 1; @endphp
                                    @forelse ($audited as $list)
                                        @php
                                            $v = DB::table('tblVATWHTPayee')
                                                ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblVATWHTPayee.bankid')
                                                ->where('ID', '=', $list->VATPayeeID)
                                                ->first();
                                            $w = DB::table('tblVATWHTPayee')
                                                ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblVATWHTPayee.bankid')
                                                ->where('ID', '=', $list->WHTPayeeID)
                                                ->first();
                                            //$v = DB::table('tblbanklist')->where('bankID','=',$list->VATPayeeID)->first();
                                            if ($list->companyID == 13) {
                                                $beneficiary = $list->payment_beneficiary;
                                            } else {
                                                $beneficiary = $list->contractor;
                                            }

                                        @endphp
                                        <tr>
                                            <input type="hidden" name="id[]" value="{{ $list->transID }}" />
                                            <input type="hidden" name="contractor[{{ $list->transID }}]" value="{{ $beneficiary }}" />
                                            <input type="hidden" name="contractorTIN[{{ $list->transID }}]" value="{{ $list->TIN }}" />
                                            <input type="hidden" name="amount[{{ $list->transID }}]" value="{{ $list->amtPayable }}" />
                                            <input type="hidden" name="accountNo[{{ $list->transID }}]" value="{{ $list->AccountNo }}" />
                                            <input type="hidden" name="bank[{{ $list->transID }}]" value="{{ $list->bank }}" />
                                            <input type="hidden" name="bankBranch[{{ $list->transID }}]" value="{{ $list->bank_branch }}" />
                                            <input type="hidden" name="bankSortCode[{{ $list->transID }}]" value="{{ $list->bsortcode }}" />
                                            <input type="hidden" name="vatAmount[{{ $list->transID }}]" value="{{ $list->VATValue }}" />
                                            <input type="hidden" name="whtAmount[{{ $list->transID }}]" value="{{ $list->WHTValue }}" />
                                            <input type="hidden" name="stampDuty[{{ $list->transID }}]" value="{{ $list->stampduty }}" />
                                            <input type="hidden" name="purpose[{{ $list->transID }}]" value="{{ $list->paymentDescription }}" />
                                            @if (count((array) $v) != 0)
                                                <input type="hidden" name="vatPayee[{{ $list->transID }}]"
                                                    value="@if ($v->payee != '') {{ $v->payee }} @endif" />
                                                <input type="hidden" name="vatBranch[{{ $list->transID }}]" value="{{ $v->bank_branch }}" />
                                                <input type="hidden" name="vatBank[{{ $list->transID }}]" value="{{ $v->bank }}" />
                                                <input type="hidden" name="vatAccount[{{ $list->transID }}]" value="{{ $v->accountno }}" />
                                                <input type="hidden" name="vatSortCode[{{ $list->transID }}]" value="{{ $v->sort_code }}" />
                                            {{-- @else
                                                <input type="hidden" name="vatPayee[]" value="" />
                                                <input type="hidden" name="vatBranch[]" value="" />
                                                <input type="hidden" name="vatBank[]" value="" />
                                                <input type="hidden" name="vatAccount[]" value="" />
                                                <input type="hidden" name="vatSortCode[]" value="" /> --}}
                                            @endif

                                            @if (count((array) $w) != 0)
                                                <input type="hidden" name="whtPayee[{{ $list->transID }}]" value="{{ $w->payee }} " />

                                                <input type="hidden" name="whtBranch[{{ $list->transID }}]" value="{{ $w->bank_branch }}" />

                                                <input type="hidden" name="whtBank[{{ $list->transID }}]" value="{{ $w->bank }}" />

                                                <input type="hidden" name="whtAccount[{{ $list->transID }}]" value="{{ $w->accountno }}" />

                                                <input type="hidden" name="whtSortCode[{{ $list->transID }}]" value="{{ $w->sort_code }}" />
                                            {{-- @else
                                                <input type="hidden" name="whtPayee[]" value="" />

                                                <input type="hidden" name="whtBranch[]" value="" />

                                                <input type="hidden" name="whtBank[]" value="" />


                                                <input type="hidden" name="whtAccount[]" value="" />

                                                <input type="hidden" name="whtSortCode[]" value="" /> --}}
                                            @endif


                                            <td>{{ $key++ }}</td>
                                            <td>{{$list->voucherFileNo ?? ''}}<br>
                                                @if ($list->companyID == 13)
                                                    {{-- {{ $list->payment_beneficiary }} --}}
                                                    {{$list->claimBene}}
                                                @else
                                                    {{ $list->contractor }}
                                                @endif
                                            </td>
                                            <td>{{$list->epaymentCT}}</td>
                                            <td class="text-center">{{ number_format($list->amtPayable, 2) }}</td>
                                            <td><textarea type="text" class="ckbox" name="cpoPaymentPurpose[{{ $list->transID }}]"> {{ $list->contDesc }} </textarea> </td>
                                            {{-- <td>{{ $list->AccountNo }}</td>
                                            <td>{{ $list->bank }}</td> --}}
                                            <td>
                                                <input type="checkbox" class="ckbox" name="checkname[]" checked="checked"
                                                    value="{{ $list->transID }}">
                                            </td>
                                            <td>
                                            @if ($list->isClaimId && $list->beneficiary_count == 0)
                                                <a href="{{ url("/cpo-add-beneficiaries/$list->transID") }}"
                                                    class="btn btn-success btn-xs">
                                                Add Beneficiaries
                                                </a>
                                            @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td style="text-align: center;" colspan="4">No E-payment has been initiated</td>
                                        </tr>
                                    @endforelse
                                

                            </tbody>
                        </table>
                        <div class="col-md-12">
                            <div class="pull-right hidden-print" style="margin-right:30px;">
                                {{-- <label>is this Capital Or Overhead Payment ?</label>
        <select name="contractType" class="form-control" id="contractType">
            <option value=""></option>
            <option value="1">Overhead</option>
            <option value="4">Capital</option>
        </select> --}}
                                @if(count($audited) > 0)
                                <input type="hidden" name="contractType" value="{{ $audited[0]->contractTypeID }}">
                                <label><span style="color: red;">***</span>Please Select Payment Bank <span style="color: red;">***</span></label>
                                <select name="contractTypeBank" class="form-control" id="contractTypeBank">
                                    <option value="">Select Bank</option>
                                    @foreach ($contractTypeBanks as $ctbank)
                                        <option value="{{ $ctbank->id }}">{{ $ctbank->bank }} -
                                            {{ $ctbank->account_no }} ({{ $ctbank->contractType }})</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />

                        <input type="submit" name="submit" value="Confirm" 
                        onclick="return validate();"
                            class="btn btn-success pull-right hidden-print confirm" style="margin-left:20px;">
                        &nbsp;&nbsp;
                        <input type="submit" name="submit" value="Return All"
                            class="btn btn-success pull-right hidden-print" id="returnAll"> &nbsp;&nbsp;
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
                        <div id="desc"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
        <!--///// end modal -->


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

                $('.ckboxNotUsed').on('click', function() {
                    var id = $(this).val();
                    var ischecked = $(this).is(":checked");
                    //alert(ischecked);

                    $.ajax({
                        // headers: {'X-CSRF-TOKEN': $token},
                        url: "{{ url('update/pay-generated') }}",
                        type: "post",
                        data: {
                            'transID': id,
                            'ischecked': ischecked,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(data) {
                            // console.log(data);
                            //location.reload(true);
                        }
                    });

                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $("#checkAll").change(function() {
                    $("input:checkbox").prop('checked', $(this).prop("checked"));
                });

                $("#checkAll").click(function() {

                    var totalCheckboxes = $('input:checkbox').length;

                });

            });
        </script>

        <script></script>

        <script>
            $(document).ready(function() {

                $('.confirm').click(function() {

                    var ctype = $("#contractType").val();



                });
            });
        </script>
        <script>
        $(document).ready(function() {

            $('#confirmBtn').on('click', function(e) {

                // If validate exists, run it
                if (typeof validate === "function") {

                    var isValid = validate();

                    if (isValid === false) {
                        return false; // stop only if explicitly false
                    }
                }

                // Allow normal form submission
                $(this)
                    .val('Processing...')
                    .prop('disabled', true);

                return true; // VERY IMPORTANT
            });

        });
        </script>
    @endsection
