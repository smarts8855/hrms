@extends('layouts_procurement.app')
@section('pageTitle', 'Edit Procurement Plan')
@section('pageMenu', 'active')
@section('content')



    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="text-center" style="margin:0;">Procurement Plan Sheet Update</h4>
                </div>

                <div class="panel-body">



                    <form method="post" action="{{ url('/edit/procurement-plan') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <table class="table table-bordered">
                            <tr>
                                <th><strong>BASIC DATA</strong></th>
                                <td scope="col" colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <th scope="row">Budget Year <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4">
                                    <select class="form-control" name="budgetYear" required>
                                        @for ($i = 2020; $i <= 2040; $i++)
                                            <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Budget Code <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="text" name="budgetCode"
                                        class="form-control" value="{{ $report->budget_code ?? '' }}" required></td>
                                <input type="hidden" name="id" class="form-control" value="{{ $report->id ?? '' }}">
                            </tr>
                            <tr>
                                <th scope="row">Package Number <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="text" name="packageNumber"
                                        class="form-control" value="{{ $report->package_number ?? '' }} " required></td>
                            </tr>
                            <tr>
                                <th scope="row">Lot Number <span class="text-danger"></span></th>
                                <td scope="col" colspan="4"><input type="text" name="lotNumber"
                                        class="form-control" value="{{ $report->lot_number ?? '' }} "></td>
                            </tr>
                            <tr>
                                <th scope="row">Procurement Plan Date <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="date" name="planDate" class="form-control"
                                        value="{{ $report->plan_date }}" required></td>
                            </tr>
                            <tr>
                                <th scope="row">Project Title <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4">&nbsp;<input type="text" name="projectTitle"
                                        class="form-control" value="{{ $report->project_title ?? '' }} " required></td>
                            </tr>
                            <tr>
                                <th scope="row">Procurement Category</th>
                                <td scope="col" colspan="4"><select class="form-control" name="category">

                                        <option value="">Select</option>
                                        @foreach ($category as $list)
                                            <option @if ($list->category_name == $report->category) selected @endif>
                                                {{ $list->category_name }}</option>
                                        @endforeach

                                    </select></td>
                            </tr>
                            <tr>
                                <th scope="row">Contract Type</th>
                                <td scope="col" colspan="4">
                                    <select class="form-control" name="contractType">

                                        <option value="">Select</option>
                                        @foreach ($contractType as $list)
                                            <option @if ($list->type == $report->contract_type) selected @endif>{{ $list->type }}
                                            </option>
                                        @endforeach

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Budget Amount <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="text" name="budget" id="budget"
                                        class="form-control" value="{{ $report->budget_amount ?? '' }} " required></td>
                            </tr>
                            <tr>
                                <th scope="row">Project Estimate</th>
                                <td scope="col" colspan="4"><input type="text" name="estimate" id="estimate"
                                        class="form-control" value="{{ $report->estimate ?? '' }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Procurement Method(ICB, NCB, Direct, Selective, Repeat, Shopping</th>
                                <td scope="col" colspan="4"><input type="text" name="procurementMethod"
                                        class="form-control" value="{{ $report->procurement_method ?? '' }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Qualification(pre/Post)</th>
                                <th scope="col" colspan="4"><input type="text" name="qualification"
                                        class="form-control" value="{{ $report->qualification ?? '' }}"></th>
                            </tr>
                            <tr>
                                <th scope="row">Review (Prior/Post)</th>
                                <th scope="col" colspan="4"><input type="text" name="review"
                                        class="form-control" value="{{ $report->review ?? '' }}"></th>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <h5>Planned Timelines</h5>
                                </th>

                                <td>
                                    <h5>From</h5>
                                </td>
                                <td>
                                    <h5>To</h5>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">Preparation of Bidding Document & Advert</th>

                                <td><input type="date" name="bidDocFrom" class="form-control"
                                        value="{{ $report->bidDocFrom }}"></td>
                                <td><input type="date" name="bidDocTo" class="form-control"
                                        value="{{ $report->bidDocTo }}"></td>

                            </tr>
                            <tr>
                                <th scope="row">Approval for Bidding Document & Advert</th>
                                <td><input type="date" name="mdaApproveFrom" class="form-control"
                                        value="{{ $report->mdaApproveFrom }}"></td>
                                <td><input type="date" name="mdaApproveTo" class="form-control"
                                        value="{{ $report->mdaApproveTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Advertisement for Prequalification/Express of Interest (EOI)</th>
                                <td><input type="date" name="prequaliAdvertFrom" class="form-control"
                                        value="{{ $report->preQualiAdvertFrom }}"></td>
                                <td><input type="date" name="preQualiAdvertTo" class="form-control"
                                        value="{{ $report->preQualiAdvertTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Pre-qualification/EOI Closing/Opening Date</th>
                                <td><input type="date" name="preQualiClosingFrom" class="form-control"
                                        value="{{ $report->preQualiClosingFrom }}"></td>
                                <td><input type="date" name="preQualiClosingTo" class="form-control"
                                        value="{{ $report->preQualiClosingTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Pre-qualification/EOI Evaluation</th>
                                <td><input type="date" name="preQualiEvaluationFrom" class="form-control"
                                        value="{{ $report->preQualiEvaluationFrom }}"></td>
                                <td><input type="date" name="preQualiEvaluationTo" class="form-control"
                                        value="{{ $report->preQualiEvaluationTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Submission Pre-qualification/EOI Evaluation Report</th>
                                <td><input type="date" name="preQualiEvaluateReportFrom" class="form-control"
                                        value="{{ $report->preQualiEvaluateReportFrom }}"></td>
                                <td><input type="date" name="preQualiEvaluateReportTo" class="form-control"
                                        value="{{ $report->preQualiEvaluateReportTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Approval for Pre-qualification/EOI</th>
                                <td><input type="date" name="mdaApprovalPreQualiFrom" class="form-control"
                                        value="{{ $report->mdaApprovalPreQualiFrom }}"></td>
                                <td><input type="date" name="mdaApprovalPreQualiTo" class="form-control"
                                        value="{{ $report->mdaApprovalPreQualiTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Invitation To Tender/Request for proporsals (RFP) & Submission Date</th>
                                <td><input type="date" name="invitationTenderFrom" class="form-control"
                                        value="{{ $report->invitationTenderFrom }}"></td>
                                <td><input type="date" name="invitationTenderTo" class="form-control"
                                        value="{{ $report->invitationTenderTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Bid/RFP Closing & Technical Bid/Proporsal Opening Date</th>
                                <td><input type="date" name="technicalBidOpeningFrom" class="form-control"
                                        value="{{ $report->technicalBidOpeningFrom }}"></td>
                                <td><input type="date" name="technicalBidOpeningTo" class="form-control"
                                        value="{{ $report->technicalBidOpeningTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Technical Bid/Proposal Evaluation</th>
                                <td><input type="date" name="technicalBidEvaluationFrom" class="form-control"
                                        value="{{ $report->technicalBidEvaluationFrom }}"></td>
                                <td><input type="date" name="technicalBidEvaluationTo" class="form-control"
                                        value="{{ $report->technicalBidEvaluationTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Financial Bid/Proposal Opening</th>
                                <td><input type="date" name="financialBidOpeningFrom" class="form-control"
                                        value="{{ $report->financialBidOpeningFrom }}"></td>
                                <td><input type="date" name="financialBidOpeningTo" class="form-control"
                                        value="{{ $report->financialBidOpeningTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Pre-qualification/EOI Closing/Opening Date</th>
                                <td><input type="date" name="preQualiCloseOpenFrom" class="form-control"
                                        value="{{ $report->preQualiCloseOpenFrom }}"></td>
                                <td><input type="date" name="preQualiCloseOpenTo" class="form-control"
                                        value="{{ $report->preQualiCloseOpenTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Financial Evaluation</th>
                                <td><input type="date" name="financialEvaluationFrom" class="form-control"
                                        value="{{ $report->financialEvaluationFrom }}"></td>
                                <td><input type="date" name="financialEvaluationTo" class="form-control"
                                        value="{{ $report->financialEvaluationTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Submission of Bid/Proposal Evaluation Report</th>
                                <td><input type="date" name="submissionEvaluationFrom" class="form-control"
                                        value="{{ $report->submissionEvaluationFrom }}"></td>
                                <td><input type="date" name="submissionEvaluationTo" class="form-control"
                                        value="{{ $report->submissionEvaluationTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Approval of No Objection Date</th>
                                <td><input type="date" name="mdaObjectionFrom" class="form-control"
                                        value="{{ $report->mdaObjectionFrom }}"></td>
                                <td><input type="date" name="mdaObjectionTo" class="form-control"
                                        value="{{ $report->mdaObjectionTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Certifiable Amount</th>
                                <td><input type="date" name="certifiableAmountFrom" class="form-control"
                                        value="{{ $report->certifiableAmountFrom }}"></td>
                                <td><input type="date" name="certifiableAmountTo" class="form-control"
                                        value="{{ $report->certifiableAmountTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">FEC Approval</th>
                                <td><input type="date" name="fecApprovalFrom" class="form-control"
                                        value="{{ $report->fecApprovalFrom }}"></td>
                                <td><input type="date" name="fecApprovalTo" class="form-control"
                                        value="{{ $report->fecApprovalTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Contract Offer</th>
                                <td><input type="date" name="dateContractOfferFrom" class="form-control"
                                        value="{{ $report->dateContractOfferFrom }}"></td>
                                <td><input type="date" name="dateContractOfferTo" class="form-control"
                                        value="{{ $report->dateContractOfferTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Contract Signature</th>
                                <td><input type="date" name="contractSignatureDateFrom" class="form-control"
                                        value="{{ $report->contractSignatureDateFrom }}"></td>
                                <td><input type="date" name="contractSignatureDateTo" class="form-control"
                                        value="{{ $report->contractSignatureDateTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Mobilization/Advance Payment</th>
                                <td><input type="date" name="advancePaymentFrom" class="form-control"
                                        value="{{ $report->advancePaymentFrom }}"></td>
                                <td><input type="date" name="advancePaymentTo" class="form-control"
                                        value="{{ $report->advancePaymentTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Substantial Completion/Draft Final Report</th>
                                <td><input type="date" name="draftFinalReportFrom" class="form-control"
                                        value="{{ $report->draftFinalReportFrom }}"></td>
                                <td><input type="date" name="draftFinalReportTo" class="form-control"
                                        value="{{ $report->draftFinalReportTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">Arrival of Goods/Final Acceptance/Final Report</th>
                                <td><input type="date" name="finalAcceptanceFrom" class="form-control"
                                        value="{{ $report->finalAcceptanceFrom }}"></td>
                                <td><input type="date" name="finalAcceptanceTo" class="form-control"
                                        value="{{ $report->finalAcceptanceTo }}"></td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <h5>Action Party(Name/Designation)</h5>
                                </th>
                                <th scope="row" colspan="4"></th>
                            </tr>
                            <tr>
                                <th scope="row">Champion (Name/Designation)</th>
                                <th scope="col" colspan="4"></th>
                            </tr>
                        </table>

                        <div class="text-right" style="padding-top:10px;">
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('styles')
    <style>
        .remove,
        .delete {
            margin-top: 30px;
            padding-top: 5px !important;
            padding-bottom: 0px !important;

            margin-bottom: 0px;
        }

        .fa-times {
            font-size: 30px;
            cursor: pointer;
        }

        .compulsory {
            color: red;
        }

        table tr th {
            font-size: 16px;
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
    <script src="{{ asset('assets/js/datepickerScripts.js') }}"></script>
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
        $("#biddingAmount").on('keyup', function() {
            var n = parseInt($(this).val().replace(/\D/g, ''), 10);
            if ($(this).val() == "") {
                $(this).val(0);
            } else {
                $(this).val(n.toLocaleString());
            }
        });

        /*  $(document).ready(function() {
                      $('#add').click(function() {
                       var total_element = $(".wraps").length;
                       var lastid = $(".wraps:last").attr("id");
                       //var split_id = lastid.split('_');
                      var n = Number(lastid) + 1;
                      //alert(nextindex);
                        $('#inputWrap').append(
                            `<div class="wraps" id="'+n+'">
    <div class="row">
    <div class="col-md-5">
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
    <span class="delete bn"><i class="fa fa-times"></i></span>
    </div>
    </div>`
                            );
                      });
                      //end click function

                      $('.delete').last().click (function () {
                    						$('.wraps').last().remove();
                    					});

                    });*/
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
        $(document).ready(function() {
            $("#budget").on('keyup', function(evt) {
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


        $(document).ready(function() {
            $("#estimate").on('keyup', function(evt) {
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
