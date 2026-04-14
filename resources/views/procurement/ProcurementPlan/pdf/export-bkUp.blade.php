<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exported Procurement Plan Data</title>

    <style>
        /* Add your CSS styles here for PDF layout */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

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
                @if(session('msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> <br />
                    	{{ session('msg') }}</div>                        
                @endif
                @if(session('err'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
              			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Input Error!</strong> <br />
                    	{{ session('err') }}</div>                        
                @endif
            <div class="card-body">
                <h4 class="card-titlse text-center" >Procurement Plan Sheet</h4>
                <p class="card-title-desc"></p>
                <form method="post" action="{{url('/procurement/plan')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <table class="table table-bordered">
                  <tr>
                    <th><strong>BASIC DATA</strong></th>
                    <td scope="col" colspan="4">&nbsp;</td>
                  </tr>
                  <tr>
                    <th scope="row">Budget Year</th>
                    <td scope="col" colspan="4">
                        {{dd($report[0]->budget_year) ?? '' }} 
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Budget Code</th>
                    <td scope="col" colspan="4">{{$report[0]->budget_code ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Package Number</th>
                    <td scope="col" colspan="4">{{$report[0]->package_number ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Lot Number</th>
                    <td scope="col" colspan="4">{{$report[0]->lot_number ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Procurement Plan Date</th>
                    <td scope="col" colspan="4">{{date("jS M, Y", strtotime($report[0]->plan_date)) ?? ''}} </td>
                  </tr>
                  <tr>
                    <th scope="row">Project Title</th>
                    <td scope="col" colspan="4">&nbsp;{{$report[0]->project_title ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Procurement Category</th>
                    <td scope="col" colspan="4">{{$category[0]->category_name ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Contract Type</th>
                    <td scope="col" colspan="4">
                       {{$contractType[0]->type ?? '' }}
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Budget Amount</th>
                    <td scope="col" colspan="4">{{number_format($report[0]->budget_amount,2) ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Project Estimate</th>
                    <td scope="col" colspan="4">{{number_format($report[0]->estimate,2) ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Procurement Method(ICB, NCB, Direct, Selective, Repeat, Shopping</th>
                    <td scope="col" colspan="4">{{$report[0]->procurement_method ?? '' }} </td>
                  </tr>
                  <tr>
                    <th scope="row">Qualification(pre/Post)</th>
                    <th scope="col" colspan="4">{{$report[0]->qualification ?? '' }} </th>
                  </tr>
                  <tr>
                    <th scope="row">Review (Prior/Post)</th>
                    <th scope="col" colspan="4">{{$report[0]->review ?? '' }} </th>
                  </tr>
                  <tr>
                    <th scope="row"><h5>Planned Timelines</h5></th>
                    
                    <td><h5>From</h5></td>
                    <td><h5>To</h5></td>
                  
                  </tr>
                  <tr>
                    <th scope="row">Preparation of Bidding Document & Advert</th>
                    
                    <td> @if(empty($report[0]->bidDocFrom))  @else {{date("jS M, Y", strtotime($report[0]->bidDocFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->bidDocTo))  @else {{date("jS M, Y", strtotime($report[0]->bidDocTo)) ?? '' }} @endif</td>
                  
                  </tr>
                  <tr>
                    <th scope="row">Approval for Bidding Document & Advert</th>
                    <td>@if(empty($report[0]->mdaApproveFrom)) @else {{date("jS M, Y", strtotime($report[0]->mdaApproveFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->mdaApproveTo)) @else {{date("jS M, Y", strtotime($report[0]->mdaApproveTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Advertisement for Prequalification/Express of Interest (EOI)</th>
                    <td>@if(empty($report[0]->preQualiAdvertFrom)) @else {{date("jS M, Y", strtotime($report[0]->preQualiAdvertFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->preQualiAdvertTo)) @else {{date("jS M, Y", strtotime($report[0]->preQualiAdvertTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Pre-qualification/EOI Closing/Opening Date</th>
                    <td>@if(empty($report[0]->preQualiClosingFrom)) @else  {{date("jS M, Y", strtotime($report[0]->preQualiClosingFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->preQualiClosingTo)) @else {{date("jS M, Y", strtotime($report[0]->preQualiClosingTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Pre-qualification/EOI Evaluation</th>
                    <td>@if(empty($report[0]->preQualiEvaluationFrom)) @else {{date("jS M, Y", strtotime($report[0]->preQualiEvaluationFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->preQualiEvaluationTo)) @else {{date("jS M, Y", strtotime($report[0]->preQualiEvaluationTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Submission Pre-qualification/EOI Evaluation Report</th>
                    <td>@if(empty($report[0]->preQualiEvaluateReportFrom)) @else  {{date("jS M, Y", strtotime($report[0]->preQualiEvaluateReportFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->preQualiEvaluateReportTo)) @else  {{date("jS M, Y", strtotime($report[0]->preQualiEvaluateReportTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Approval for Pre-qualification/EOI</th>
                    <td>@if(empty($report[0]->mdaApprovalPreQualiFrom)) @else {{date("jS M, Y", strtotime($report[0]->mdaApprovalPreQualiFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->mdaApprovalPreQualiFrom)) @else {{date("jS M, Y", strtotime($report[0]->mdaApprovalPreQualiTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Invitation To Tender/Request for proporsals (RFP) & Submission Date</th>
                    <td> @if(empty($report[0]->invitationTenderFrom)) @else {{date("jS M, Y", strtotime($report[0]->invitationTenderFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->invitationTenderTo)) @else {{date("jS M, Y", strtotime($report[0]->invitationTenderTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Bid/RFP Closing & Technical Bid/Proporsal Opening Date</th>
                    <td>@if(empty($report[0]->technicalBidOpeningFrom )) @else  {{date("jS M, Y", strtotime($report[0]->technicalBidOpeningFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->technicalBidOpeningTo)) @else  {{date("jS M, Y", strtotime($report[0]->technicalBidOpeningTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Technical Bid/Proposal Evaluation</th>
                    <td>@if(empty($report[0]->technicalBidEvaluationFrom)) @else {{date("jS M, Y", strtotime($report[0]->technicalBidEvaluationFrom)) ?? '' }} @endif</td>
                    <td> @if(empty($report[0]->technicalBidEvaluationTo)) @else {{date("jS M, Y", strtotime($report[0]->technicalBidEvaluationTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Financial Bid/Proposal Opening</th>
                    <td>@if(empty($report[0]->financialBidOpeningFrom)) @else  {{date("jS M, Y", strtotime($report[0]->financialBidOpeningFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->financialBidOpeningTo)) @else {{date("jS M, Y", strtotime($report[0]->financialBidOpeningTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Pre-qualification/EOI Closing/Opening Date</th>
                    <td>@if(empty($report[0]->preQualiCloseOpenFrom)) @else {{date("jS M, Y", strtotime($report[0]->preQualiCloseOpenFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->preQualiCloseOpenTo)) @else  {{date("jS M, Y", strtotime($report[0]->preQualiCloseOpenTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Financial Evaluation</th>
                    <td>@if(empty($report[0]->financialEvaluationFrom)) @else  {{date("jS M, Y", strtotime($report[0]->financialEvaluationFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->financialEvaluationTo)) @else {{date("jS M, Y", strtotime($report[0]->financialEvaluationTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Submission of Bid/Proposal Evaluation Report</th>
                    <td>@if(empty($report[0]->submissionEvaluationFrom)) @else {{date("jS M, Y", strtotime($report[0]->submissionEvaluationFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->submissionEvaluationTo)) @else {{date("jS M, Y", strtotime($report[0]->submissionEvaluationTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Approval of No Objection Date</th>
                    <td>@if(empty($report[0]->mdaObjectionFrom)) @else  {{date("jS M, Y", strtotime($report[0]->mdaObjectionFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->mdaObjectionTo)) @else  {{date("jS M, Y", strtotime($report[0]->mdaObjectionTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Certifiable Amount</th>
                    <td>@if(empty($report[0]->certifiableAmountFrom)) @else {{date("jS M, Y", strtotime($report[0]->certifiableAmountFrom)) ?? '' }} @endif</td>
                    <td> @if(empty($report[0]->certifiableAmountTo)) @else {{date("jS M, Y", strtotime($report[0]->certifiableAmountTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">FEC Approval</th>
                    <td>@if(empty($report[0]->fecApprovalFrom)) @else  {{date("jS M, Y", strtotime($report[0]->fecApprovalFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->fecApprovalTo)) @else  {{date("jS M, Y", strtotime($report[0]->fecApprovalTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Date of Contract Offer</th>
                    <td>@if(empty($report[0]->dateContractOfferFrom)) @else {{date("jS M, Y", strtotime($report[0]->dateContractOfferFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->dateContractOfferTo)) @else  {{date("jS M, Y", strtotime($report[0]->dateContractOfferTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Date of Contract Signature</th>
                    <td>@if(empty($report[0]->contractSignatureDateFrom)) @else  {{date("jS M, Y", strtotime($report[0]->contractSignatureDateFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->contractSignatureDateTo)) @else  {{date("jS M, Y", strtotime($report[0]->contractSignatureDateTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Mobilization/Advance Payment</th>
                    <td>@if(empty($report[0]->advancePaymentFrom)) @else  {{date("jS M, Y", strtotime($report[0]->advancePaymentFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->advancePaymentTo)) @else {{date("jS M, Y", strtotime($report[0]->advancePaymentTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Substantial Completion/Draft Final Report</th>
                    <td> @if(empty($report[0]->draftFinalReportFrom)) @else {{date("jS M, Y", strtotime($report[0]->draftFinalReportFrom)) ?? '' }} @endif</td>
                    <td> @if(empty($report[0]->draftFinalReportTo)) @else {{date("jS M, Y", strtotime($report[0]->draftFinalReportTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row">Arrival of Goods/Final Acceptance/Final Report</th>
                    <td>@if(empty($report[0]->finalAcceptanceFrom)) @else {{date("jS M, Y", strtotime($report[0]->finalAcceptanceFrom)) ?? '' }} @endif</td>
                    <td>@if(empty($report[0]->finalAcceptanceTo)) @else {{date("jS M, Y", strtotime($report[0]->finalAcceptanceTo)) ?? '' }} @endif</td>
                  </tr>
                  <tr>
                    <th scope="row"><h5>Action Party(Name/Designation)</h5></th>
                    <th scope="row" colspan="4"></th>
                  </tr>
                  <tr>
                      <th scope="row">Champion (Name/Designation)</th>
                      <th scope="col" colspan="4"></th>
                  </tr>
                </table>
                
                </form>
                
            </div>
            
            
        </div>
        <!-- end card -->
    </div> <!-- end col -->
   </div>
</body>

</html>
