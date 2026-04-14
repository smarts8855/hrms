@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Add Procurement Plan') }}
@endsection

@section('pageMenu', 'active')
@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                        {{ session('msg') }}
                    </div>
                @endif
                @if (session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                        {{ session('err') }}
                    </div>
                @endif
                <div class="card-body">
                    <h4 class="card-titlse text-center">Procurement Plan Sheet</h4>
                    <p class="card-title-desc"></p>
                    <form method="post" action="{{ url('/procurement-plan') }}" enctype="multipart/form-data">
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
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th scope="row">Package Number <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="text" name="packageNumber"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th scope="row">Lot Number <span class="text-danger"></span></th>
                                <td scope="col" colspan="4"><input type="text" name="lotNumber"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Procurement Plan Date <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="text" name="planDate" id="planDate"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th scope="row">Project Title <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4">&nbsp;<input type="text" name="projectTitle"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th scope="row">Procurement Category</th>
                                <td scope="col" colspan="4"><select class="form-control" name="category">

                                        <option value="">Select</option>
                                        @foreach ($category as $list)
                                            <option>{{ $list->category_name }}</option>
                                        @endforeach

                                    </select></td>
                            </tr>
                            <tr>
                                <th scope="row">Contract Type</th>
                                <td scope="col" colspan="4">
                                    <select class="form-control" name="contractType">

                                        <option value="">Select</option>
                                        @foreach ($contractType as $list)
                                            <option>{{ $list->type }}</option>
                                        @endforeach

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Budget Amount <span class="text-danger">*</span></th>
                                <td scope="col" colspan="4"><input type="text" name="budget" id="budget"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th scope="row">Project Estimate</th>
                                <td scope="col" colspan="4"><input type="text" name="estimate" id="estimate"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Procurement Method(ICB, NCB, Direct, Selective, Repeat, Shopping</th>
                                <td scope="col" colspan="4"><input type="text" name="procurementMethod"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Qualification(pre/Post)</th>
                                <th scope="col" colspan="4"><input type="text" name="qualification"
                                        class="form-control"></th>
                            </tr>
                            <tr>
                                <th scope="row">Review (Prior/Post)</th>
                                <th scope="col" colspan="4"><input type="text" name="review"
                                        class="form-control"></th>
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

                                <td><input type="text" name="bidDocFrom" id="bidDocFrom" class="form-control"></td>
                                <td><input type="text" name="bidDocTo" id="bidDocTo" class="form-control"></td>

                            </tr>
                            <tr>
                                <th scope="row"> Approval for Bidding Document & Advert</th>
                                <td><input type="text" name="mdaApproveFrom" id="mdaApproveFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="mdaApproveTo" id="mdaApproveTo" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Advertisement for Prequalification/Express of Interest (EOI)</th>
                                <td><input type="text" name="prequaliAdvertFrom" id="preQualiAdvertFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="preQualiAdvertTo" id="preQualiAdvertTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Pre-qualification/EOI Closing/Opening Date</th>
                                <td><input type="text" name="preQualiClosingFrom" id="preQualiClosingFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="preQualiClosingTo" id="preQualiClosingTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Pre-qualification/EOI Evaluation</th>
                                <td><input type="text" name="preQualiEvaluationFrom" id="preQualiEvaluationFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="preQualiEvaluationTo" id="preQualiEvaluationTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Submission Pre-qualification/EOI Evaluation Report</th>
                                <td><input type="text" name="preQualiEvaluateReportFrom"
                                        id="preQualiEvaluateReportFrom" class="form-control"></td>
                                <td><input type="text" name="preQualiEvaluateReportTo" id="preQualiEvaluateReportTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Approval for Pre-qualification/EOI</th>
                                <td><input type="text" name="mdaApprovalPreQualiFrom" id="mdaApprovalPreQualiFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="mdaApprovalPreQualiTo" id="mdaApprovalPreQualiTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Invitation To Tender/Request for Proporsals (RFP) & Submission Date</th>
                                <td><input type="text" name="invitationTenderFrom" id="invitationTenderFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="invitationTenderTo" id="invitationTenderTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Bid/RFP Closing & Technical Bid/Proporsal Opening Date</th>
                                <td><input type="text" name="technicalBidOpeningFrom" id="technicalBidOpeningFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="technicalBidOpeningTo" id="technicalBidOpeningTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Technical Bid/Proposal Evaluation</th>
                                <td><input type="text" name="technicalBidEvaluationFrom"
                                        id="technicalBidEvaluationFrom" class="form-control"></td>
                                <td><input type="text" name="technicalBidEvaluationTo" id="technicalBidEvaluationTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Financial Bid/Proposal Opening</th>
                                <td><input type="text" name="financialBidOpeningFrom" id="financialBidOpeningFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="financialBidOpeningTo" id="financialBidOpeningTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Pre-qualification/EOI Closing/Opening Date</th>
                                <td><input type="text" name="preQualiCloseOpenFrom" id="preQualiCloseOpenFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="preQualiCloseOpenTo" id="preQualiCloseOpenTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Financial Evaluation</th>
                                <td><input type="text" name="financialEvaluationFrom" id="financialEvaluationFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="financialEvaluationTo" id="financialEvaluationTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Submission of Bid/Proposal Evaluation Report</th>
                                <td><input type="text" name="submissionEvaluationFrom" id="submissionEvaluationFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="submissionEvaluationTo" id="submissionEvaluationTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Approval of No Objection Date</th>
                                <td><input type="text" name="mdaObjectionFrom" id="mdaObjectionFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="mdaObjectionTo" id="mdaObjectionTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Certifiable Amount</th>
                                <td><input type="text" name="certifiableAmountFrom" id="certifiableAmountFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="certifiableAmountTo" id="certifiableAmountTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">FEC Approval</th>
                                <td><input type="text" name="fecApprovalFrom" id="fecApprovalFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="fecApprovalTo" id="fecApprovalTo" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Contract Offer</th>
                                <td><input type="text" name="dateContractOfferFrom" id="dateContractOfferFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="dateContractOfferTo" id="dateContractOfferTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Contract Signature</th>
                                <td><input type="text" name="contractSignatureDateFrom" id="contractSignatureDateFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="contractSignatureDateTo" id="contractSignatureDateTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Mobilization/Advance Payment</th>
                                <td><input type="text" name="advancePaymentFrom" id="advancePaymentFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="advancePaymentTo" id="advancePaymentTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Substantial Completion/Draft Final Report</th>
                                <td><input type="text" name="draftFinalReportFrom" id="draftFinalReportFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="draftFinalReportTo" id="draftFinalReportTo"
                                        class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row">Arrival of Goods/Final Acceptance/Final Report</th>
                                <td><input type="text" name="finalAcceptanceFrom" id="finalAcceptanceFrom"
                                        class="form-control"></td>
                                <td><input type="text" name="finalAcceptanceTo" id="finalAcceptanceTo"
                                        class="form-control"></td>
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

                        <div class="col-md-12" style="padding-top:10px;">
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </form>

                </div>


            </div>
            <!-- end card -->
        </div> <!-- end col -->
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
    </style>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/datepickerScripts.js') }}"></script>

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

    <script>
        function selectDate(selector) {
            $("#" + selector).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:2090', // specifying a hard coded year range
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd-mm-yy",
                onSelect: function(dateText, inst) {
                    var theDate = new Date(Date.parse($(this).datepicker('getDate')));
                    var dateFormatted = $.datepicker.formatDate('dd-mm-yy', theDate);
                    $('#'
                        selector).val($.datepicker.formatDate('dd-mm-yy', theDate));
                },
            });
        }
    </script>



@endsection
