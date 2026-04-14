@extends('layouts_procurement.app')
@section('pageTitle')
    {{ strtoupper('Add Procurement Plan') }}
@endsection
@section('pageMenu', 'active')
@section('content')
    <!-- bootstrap css -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
    {{-- <link href="{{ asset('assets/libs/steppers/stepper.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">








    <div class="container">
        {{-- <div class="flashAlert">
            @if (session()->has('msg'))
                <div id="successMessage" class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('msg') }}
                </div>
            @endif
            @if (session()->has('warning'))
                <div id="successMessage" class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('warning') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div id="successMessage" class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('error') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div id="successMessage" class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('success') }}
                </div>
            @endif
        </div> --}}


        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default" style="border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

                    <div class="panel-heading"
                        style="background:#009688; color:#fff; padding:15px; border-radius:10px 10px 0 0;">
                        <h4 class="panel-title" style="margin:0; font-size:18px;">Procurement Plan</h4>
                    </div>

                    <div class="panel-body" style="padding:30px;">

                        <!-- STEP INDICATORS -->
                        <div class="stepper">
                            <div class="step-title active-step">
                                <div class="step-circle"></div>
                                <div>Procurement Plan Sheet</div>
                            </div>

                            <div class="step-title">
                                <div class="step-circle"></div>
                                <div>Planned Timelines</div>
                            </div>

                            <div class="step-title">
                                <div class="step-circle"></div>
                                <div>Planned Timelines (2)</div>
                            </div>

                            <div class="step-title">
                                <div class="step-circle"></div>
                                <div>Action Parties</div>
                            </div>

                            <div class="step-title">
                                <div class="step-circle"></div>
                                <div>Summary</div>
                            </div>
                        </div>

                        <!-- FORM CONTENT -->
                        <form id="myForm" action="{{ url('/procurement-new-plan') }}" method="POST">
                            @csrf

                            <!-- STEP 1 -->
                            <div class="step">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-firstname-input">Budget Year</label>
                                            <select class="form-control" name="budgetYear" required>
                                                @for ($i = 2020; $i <= 2040; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-lastname-input">Budget Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="budgetCode" class="form-control" required
                                                placeholder="Budget code" require>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-phoneno-input">Package Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="packageNumber" class="form-control" required
                                                placeholder="Package No">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Lot Number</label>
                                            <input type="text" name="lotNumber" class="form-control"
                                                placeholder="Lot No">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Procurement Plan Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="planDate" id="planDate" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Project Title <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="projectTitle" class="form-control" required
                                                placeholder="Project Title">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Procurement Category <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="category">

                                                <option value="">Select</option>
                                                @foreach ($category as $list)
                                                    <option value="{{ $list->contractCategoryID }}">
                                                        {{ $list->category_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Contract Type <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="contractType" id="contractType">
                                                <option value="">Select</option>
                                                @foreach ($contractType as $list)
                                                    <option value="{{ $list->procurement_typeID }}">{{ $list->type }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Budget Amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="budget" id="budget" class="form-control"
                                                required>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Project Estimate <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="estimate" id="estimate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input" style="font-size:13px;">Procurement
                                                Method (ICB,
                                                NCB, Direct, Selective, Repeat, Shopping)</label>
                                            <input type="text" name="procurementMethod" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Qualification (Pre/Post)</label>
                                            <input type="text" name="qualification" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-email-input">Review (Pre/Post)</label>
                                            <input type="text" name="review" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2 -->
                            <div class="step" style="display:none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-pancard-input">Preparation of Bidding Document &
                                            Advert</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="bidDocFrom" id="bidDocFrom"
                                                        class="form-control" placeholder="Bid Document From">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="bidDocTo" id="bidDocTo"
                                                        class="form-control" placeholder="Bid Document To">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-pancard-input">Approval for Bid Document &
                                            Advert</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="mdaApproveFrom" id="mdaApproveFrom"
                                                        class="form-control" placeholder="MDA Approval From">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="mdaApproveTo" id="mdaApproveTo"
                                                        class="form-control" placeholder="MDA Approval To">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-pancard-input">Advertisement for
                                            Prequalification/Express of
                                            Interest (EOI)</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="prequaliAdvertFrom"
                                                        id="preQualiAdvertFrom" class="form-control"
                                                        placeholder="Prequalification Advert From">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="preQualiAdvertTo" id="preQualiAdvertTo"
                                                        class="form-control" placeholder="Prequalification Advert To">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-pancard-input">Pre-qualification/EOI Closing/Opening
                                            Date</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>

                                                    <input type="date" name="preQualiClosingFrom"
                                                        id="preQualiClosingFrom" class="form-control"
                                                        placeholder="Prequalification Closing From">

                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="preQualiClosingTo" id="preQualiClosingTo"
                                                        class="form-control" placeholder="Prequalification Closing To">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />


                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Pre-qualification/EOI
                                            Evaluation</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="preQualiEvaluationFrom"
                                                        id="preQualiEvaluationFrom" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="preQualiEvaluationTo"
                                                        id="preQualiEvaluationTo" class="form-control">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Submission of Bid/Proposal
                                            Evaluation
                                            Report</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="submissionEvaluationFrom"
                                                        id="submissionEvaluationFrom" class="form-control"
                                                        placeholder="Submission of Evaluation From">

                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="submissionEvaluationTo"
                                                        id="submissionEvaluationTo" class="form-control"
                                                        placeholder="Submission of Evaluation To">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Approval for
                                            Pre-qualification/EOI</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="mdaApprovalPreQualiFrom"
                                                        id="mdaApprovalPreQualiFrom" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="mdaApprovalPreQualiTo"
                                                        id="mdaApprovalPreQualiTo" class="form-control">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Invitation To Tender/Request for
                                            Proporsals
                                            (RFP) & Submission Date</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="invitationTenderFrom"
                                                        id="invitationTenderFrom" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="invitationTenderTo"
                                                        id="invitationTenderTo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />


                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Bid/RFP Closing & Technical
                                            Bid/Proporsal
                                            Opening Date</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="technicalBidOpeningFrom"
                                                        id="technicalBidOpeningFrom" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="technicalBidOpeningTo"
                                                        id="technicalBidOpeningTo" class="form-control">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Technical Bid/Proposal
                                            Evaluation</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="technicalBidEvaluationFrom"
                                                        id="technicalBidEvaluationFrom" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="technicalBidEvaluationTo"
                                                        id="technicalBidEvaluationTo" class="form-control">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="row">


                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Financial Bid/Proposal
                                            Opening</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="financialBidOpeningFrom"
                                                        id="financialBidOpeningFrom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="financialBidOpeningTo"
                                                        id="financialBidOpeningTo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Pre-qualification/EOI Closing/Opening
                                            Date</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="preQualiCloseOpenFrom"
                                                        id="preQualiCloseOpenFrom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="preQualiCloseOpenTo"
                                                        id="preQualiCloseOpenTo" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr />


                            </div>

                            <!-- STEP 3 -->
                            <div class="step" style="display:none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Financial Evaluation</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="financialEvaluationFrom"
                                                        id="financialEvaluationFrom" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="financialEvaluationTo"
                                                        id="financialEvaluationTo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Submission of Bid/Proposal
                                            Evaluation
                                            Report</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="submissionEvaluationFrom"
                                                        id="submissionEvaluationFrom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="submissionEvaluationTo"
                                                        id="submissionEvaluationTo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Approval of No Objection Date</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="mdaObjectionFrom" id="mdaObjectionFrom"
                                                        class="form-control" placeholder="MDA Objection From">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="mdaObjectionTo" id="mdaObjectionTo"
                                                        class="form-control" placeholder="MDA Objection To">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Certifiable Amount</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="certifiableAmountFrom"
                                                        id="certifiableAmountFrom" class="form-control"
                                                        placeholder="Certifiable Amount From">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="certifiableAmountTo"
                                                        id="certifiableAmountTo" class="form-control"
                                                        placeholder="Certifiable Amount To">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">FEC Approval</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="fecApprovalFrom" id="fecApprovalFrom"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="fecApprovalTo" id="fecApprovalTo"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Date of Contract Offer</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="dateContractOfferFrom"
                                                        id="dateContractOfferFrom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="dateContractOfferTo"
                                                        id="dateContractOfferTo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />


                                <div class="row">

                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Date of Contract Signature</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="contractSignatureDateFrom"
                                                        id="contractSignatureDateFrom" class="form-control"
                                                        placeholder="Contract Signature Date From">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="contractSignatureDateTo"
                                                        id="contractSignatureDateTo" class="form-control"
                                                        placeholder="Contract Signature Date To">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Mobilization/Advance Payment</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="advancePaymentFrom"
                                                        id="advancePaymentFrom" class="form-control"
                                                        Placeholder="Advance Payment From">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="advancePaymentTo" id="advancePaymentTo"
                                                        class="form-control" Placeholder="Advance Payment To">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <hr />


                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="verticalnav-companyuin-input">Substantial Completion/Draft Final
                                            Report</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="draftFinalReportFrom"
                                                        id="draftFinalReportFrom" class="form-control"
                                                        placeholder="Substantial Completion/Draft Finan Report From">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="draftFinalReportTo"
                                                        id="draftFinalReportTo" class="form-control"
                                                        placeholder="Substantial Completion/Draft Finan Report To">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <label for="verticalnav-declaration-input">Arrival of Goods/Final
                                            Acceptance/Final
                                            Report</label>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">From</label>
                                                    <input type="date" name="finalAcceptanceFrom"
                                                        id="finalAcceptanceFrom" class="form-control"
                                                        placeholder="Arrival of Goods/Final Acceptance & Report From">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="verticalnav-pancard-input">To</label>
                                                    <input type="date" name="finalAcceptanceTo" id="finalAcceptanceTo"
                                                        class="form-control"
                                                        placeholder="Arrival of Goods/Final Acceptance & Report To">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                            </div>

                            <!-- STEP 4 -->
                            <div class="step" style="display:none;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-namecard-input">Action Party(Name/Designation)</label>
                                            <input type="text" class="form-control" id="actionPartyName"
                                                placeholder="Enter Name"><br>
                                            <select class="form-control form-select">
                                                <option selected>Select Designation</option>
                                                <option value="ps">Permanent Secretary</option>
                                                <option value="dir">Dirctor</option>
                                                <option value="assdir">Assistant Director</option>
                                                <option value="tbs">Tenders Board Secretary</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="verticalnav-namecard-input">Champion (Name/Designation)</label>
                                            <input type="text" class="form-control" id="PartyName"
                                                placeholder="Enter Name">
                                            <br>
                                            <select class="form-control form-select">
                                                <option selected>Select Designation</option>
                                                <option value="ps">Permanent Secretary</option>
                                                <option value="dir">Dirctor</option>
                                                <option value="assdir">Assistant Director</option>
                                                <option value="tbs">Tenders Board Secretary</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 5 -->
                            <div class="step" style="display:none;">
                                Here we show all the summary
                            </div>

                            <!-- BUTTONS -->
                            {{-- <div class="form-footer" style="margin-top: 30px;">
                                <button class="btn btn-primary" type="button" id="prevBtn"
                                    style="display:none;">Previous</button>

                                <button class="btn btn-success btn-next" type="button" id="nextBtn">Next</button>
                            </div> --}}

                            <!-- BUTTONS -->
                            <div class="form-footer"
                                style="margin-top: 30px; display: flex; justify-content: space-between;">
                                <button class="btn btn-primary" type="button" id="prevBtn"
                                    style="display:none;margin-right:10px;">Previous</button>
                                <button class="btn btn-success btn-next" type="button" id="nextBtn">Next</button>
                            </div>


                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>



@endsection


@section('styles')


    <style>
        /* Main Card */
        .card-wrapper {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
        }

        /* Stepper Container */
        .stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        /* Stepper Line */
        .stepper:before {
            content: "";
            position: absolute;
            top: 50%;
            /* vertically center */
            left: 10%;
            /* start a bit inside */
            right: 10%;
            /* end a bit before the edge */
            height: 3px;
            background: #bdece8;
            z-index: 1;
            transform: translateY(-50%);
        }

        /* Step Titles */
        .stepper .step-title {
            text-align: center;
            font-weight: 600;
            color: #666;
            width: 20%;
            font-size: 14px;
            position: relative;
            z-index: 2;
            /* ensure above line */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Stepper Circles */
        .stepper .step-circle {
            width: 25px;
            height: 25px;
            background: #bdece8;
            border-radius: 50%;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #fff;
            position: relative;
            transition: background 0.3s, color 0.3s;
        }

        /* Active Step */
        .step-title.active-step .step-circle {
            background: #0db4a3;
        }

        /* Active Step Text */
        .step-title.active-step {
            color: #0db4a3 !important;
            font-weight: 700 !important;
        }

        /* Form fields spacing */
        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-control {
            height: 40px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-shadow: none;
        }

        /* Next/Previous Buttons */
        .btn-next,
        #prevBtn {
            background: #009688;
            color: #fff;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            transition: background 0.3s;
            cursor: pointer;
        }

        #prevBtn {
            background: #6c757d;
        }

        .btn-next:hover {
            background: #007f73;
            color: #fff;
        }

        #prevBtn:hover {
            background: #5a6268;
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            @if (session()->has('msg'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: "{{ session('msg') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        popup: 'swal-popup',
                        title: 'swal-title'
                    },
                });
            @endif

            @if (session()->has('warning'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: "{{ session('warning') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        popup: 'swal-popup',
                        title: 'swal-title'
                    },
                });
            @endif

            @if (session()->has('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        popup: 'swal-popup',
                        title: 'swal-title'
                    },
                });
            @endif

            @if (session()->has('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        popup: 'swal-popup',
                        title: 'swal-title'
                    },
                });
            @endif

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentTab = 0;
            const steps = document.getElementsByClassName("step");
            const indicators = document.getElementsByClassName("step-title");
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');

            if (!nextBtn || !prevBtn) {
                console.error("Buttons not found!");
                return;
            }

            function showTab(n) {
                Array.from(steps).forEach(step => step.style.display = "none");
                steps[n].style.display = "block";

                Array.from(indicators).forEach(ind => ind.classList.remove("active-step"));
                indicators[n].classList.add("active-step");

                prevBtn.style.display = n === 0 ? "none" : "inline-block";
                nextBtn.innerHTML = n === steps.length - 1 ? "Submit" : "Next";
            }

            function validateStep() {
                const inputs = steps[currentTab].querySelectorAll("input, select, textarea");
                for (let input of inputs) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        return false;
                    }
                }
                return true;
            }

            function nextPrev(n) {
                console.log("Next clicked, currentTab:", currentTab);
                if (n === 1 && !validateStep()) return;

                currentTab += n;

                if (currentTab >= steps.length) {
                    document.getElementById("myForm").submit();
                    return;
                }

                if (currentTab < 0) currentTab = 0;

                showTab(currentTab);
            }

            nextBtn.addEventListener('click', () => nextPrev(1));
            prevBtn.addEventListener('click', () => nextPrev(-1));

            showTab(currentTab);
        });
    </script>
@endsection
