<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Http\Controllers\ReuseableController;
use App\Http\Controllers\Controller;
use File;
use PDF;
use Illuminate\Support\Str;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\TblprocurementPlan;
use Illuminate\Support\Facades\Log;

class ProcurementPlanController extends Controller
{

    public function procurementPlan()
    {
        $data['display'] = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->where('tblcontract_bidding.status', '=', 3)
            ->get();
        $data['contractType'] = DB::table('tblprocurement_type')->get();
        $data['category'] = DB::table('protblcontract_category')->get();
        return view('procurement.ProcurementPlan.plan', $data);
    }


    public function newprocurementPlan()
    {
        $data['display'] = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->where('tblcontract_bidding.status', '=', 3)
            ->get();
        $data['contractType'] = DB::table('tblprocurement_type')->get();
        $data['category'] = DB::table('protblcontract_category')->get();

        // dd($data['contractType']);
        return view('procurement.ProcurementPlan.newplan2', $data);
    }


    public function procurementPlanAction(Request $request)
    {
        if ($request['budgetCode'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', 'Budget code cannot be empty, enter the code.');
        }
        if ($request['projectTitle'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', 'Budget Title cannot be empty, enter the code.');
        }
        if ($request['estimate'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', 'Budget estimate cannot be empty, enter the code.');
        }
        if ($request['budget'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', 'Budget amount cannot be empty, enter the code.');
        }
        // if ($request['project_title'] == "") {
        //     return redirect()->back()->withInput($request->all())->with('msg', 'Project Title cannot be empty, enter the code.');
        // }
        if ($request['category'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', 'Budget Category cannot be empty, select a category.');
        }
        if ($request['packageNumber'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', 'Package number cannot be empty, enter the number.');
        }
        if ($request['contractType'] == "") {
            return redirect()->back()->withInput($request->all())->with('msg', ' Contract Type cannot be empty, select one.');
        }

        // $this->validate($request, [
        //     'budgetCode'        => 'required',
        //     'projectTitle'      => 'required',
        //     'estimate'          => 'required',
        //     'budget'            => 'required',
        //     'project_title'     => 'required',
        //     'category'          => 'required',
        //     'package_number'    => 'required',
        //     'contract_type'     => 'required'
        // ]);

        // if(!$validation){
        //      dd($request->all());
        // }else{
        //     dd("Input properly submitted");
        // }

        $data['display'] = DB::table('tblprocurement_plan')->insert([
            'budget_year' => $request['budgetYear'],
            'budget_code' => $request['budgetCode'],
            'package_number' => $request['packageNumber'],
            'lot_number' => $request['lotNumber'],
            'plan_date' => $request['planDate'],
            'project_title' => $request['projectTitle'],
            'category' => $request['category'],
            'contract_type' => $request['contractType'],
            'budget_amount' => str_replace(",", "", $request['budget']),
            'estimate' => str_replace(",", "", $request['estimate']),
            'procurement_method' =>  $request['procurementMethod'],
            'qualification' => $request['qualification'],
            'review' => $request['review'],
            'bidDocFrom' => $request['bidDocFrom'],
            'bidDocTo' => $request['bidDocTo'],

            'mdaApproveFrom' => $request['mdaApproveFrom'],
            'mdaApproveTo' => $request['mdaApproveTo'],
            'preQualiAdvertFrom' => $request['prequaliAdvertFrom'],
            'preQualiAdvertTo' => $request['preQualiAdvertTo'],
            'preQualiClosingFrom' => $request['preQualiClosingFrom'],
            'preQualiClosingTo' => $request['preQualiClosingTo'],
            'preQualiEvaluationFrom' => $request['preQualiEvaluationFrom'],
            'preQualiEvaluationTo' => $request['preQualiEvaluationTo'],
            'preQualiEvaluateReportFrom' => $request['preQualiEvaluateReportFrom'],
            'preQualiEvaluateReportTo' => $request['preQualiEvaluateReportTo'],
            'mdaApprovalPreQualiFrom' => $request['mdaApprovalPreQualiFrom'],
            'mdaApprovalPreQualiTo' => $request['mdaApprovalPreQualiTo'],
            'invitationTenderFrom' => $request['invitationTenderFrom'],
            'invitationTenderTo' => $request['invitationTenderTo'],
            'technicalBidOpeningFrom' => $request['technicalBidOpeningFrom'],
            'technicalBidOpeningTo' => $request['technicalBidOpeningTo'],
            'technicalBidEvaluationFrom' => $request['technicalBidEvaluationFrom'],
            'technicalBidEvaluationTo' => $request['technicalBidEvaluationTo'],
            'financialBidOpeningFrom' => $request['financialBidOpeningFrom'],
            'financialBidOpeningTo' => $request['financialBidOpeningTo'],
            'preQualiCloseOpenFrom' => $request['preQualiCloseOpenFrom'],
            'preQualiCloseOpenTo' => $request['preQualiCloseOpenTo'],
            'financialEvaluationFrom' => $request['financialEvaluationFrom'],
            'financialEvaluationTo' => $request['financialEvaluationTo'],
            'submissionEvaluationFrom' => $request['submissionEvaluationFrom'],
            'submissionEvaluationTo' => $request['submissionEvaluationTo'],
            'mdaObjectionFrom' => $request['mdaObjectionFrom'],
            'mdaObjectionTo' => $request['mdaObjectionTo'],
            'certifiableAmountFrom' => $request['certifiableAmountFrom'],
            'certifiableAmountTo' => $request['certifiableAmountTo'],
            'fecApprovalFrom' => $request['fecApprovalFrom'],
            'fecApprovalTo' => $request['fecApprovalTo'],
            'dateContractOfferFrom' => $request['dateContractOfferFrom'],
            'dateContractOfferTo' => $request['dateContractOfferTo'],
            'contractSignatureDateFrom' => $request['contractSignatureDateFrom'],
            'contractSignatureDateTo' => $request['contractSignatureDateTo'],
            'advancePaymentFrom' => $request['advancePaymentFrom'],
            'advancePaymentTo' => $request['advancePaymentTo'],
            'draftFinalReportFrom' => $request['draftFinalReportFrom'],
            'draftFinalReportTo' => $request['draftFinalReportTo'],
            'finalAcceptanceFrom' => $request['finalAcceptanceFrom'],
            'finalAcceptanceTo' => $request['finalAcceptanceTo'],
            'created_at' => date('Y-m-d'),

        ]);

        return redirect('/view/procurement-plan')->with('msg', 'Successfully created a plan');
    }

    public function procurementPlanReport()
    {
        $data['display'] = DB::table('tblprocurement_plan')->orderBy('id', 'DESC')->get();
        return view('procurement.ProcurementPlan.planList', $data);
    }
    public function viewProcurementPlan($id)
    {
        $data['report'] = DB::table('tblprocurement_plan')->find($id);

        // $data['report'] = DB::table('tblprocurement_plan AS TP')
        //     ->leftJoin('tblprocurement_type AS PType', 'PType.procurement_typeID', '=', 'TP.contract_type')
        //     ->leftJoin('tblcontract_category AS category', 'category.contractCategoryID', '=', 'TP.category')
        //     ->where('id', '=', $id)->first();
        $data['contractType'] = DB::table('tblprocurement_type')->where('tblprocurement_type.procurement_typeID', $data['report']->contract_type)->get();
        $data['category'] = DB::table('protblcontract_category')->where('protblcontract_category.contractCategoryID', $data['report']->category)->get();
        return view('procurement.ProcurementPlan.planReport', $data);
    }

    public function exportProcurementPlan($id)
    {

        $data['report'] = DB::table('tblprocurement_plan AS TP')
            ->select('*')
            ->leftJoin('tblprocurement_type AS PType', 'PType.procurement_typeID', '=', 'TP.contract_type')
            ->leftJoin('tblcontract_category AS Category', 'TP.category', '=', 'Category.contractCategoryID')
            ->leftJoin('tblprocurement_type AS Type', 'TP.contract_type', '=', 'Type.procurement_typeID')
            ->where('TP.id', '=', $id)
            ->get();
        return $data;
        return view('procurement.ProcurementPlan.pdf.export', $data);
    }

    public function dataForExport($id)
    {
        // dd($request);
        $data['report'] = DB::table('tblprocurement_plan AS TP')
            ->select('*')
            ->leftJoin('tblprocurement_type AS PType', 'PType.procurement_typeID', '=', 'TP.contract_type')
            ->leftJoin('protblcontract_category AS Category', 'TP.category', '=', 'Category.contractCategoryID')
            ->leftJoin('tblprocurement_type AS Type', 'TP.contract_type', '=', 'Type.procurement_typeID')
            ->where('TP.id', '=', $id)
            ->get()->toArray();
        return $data;
        return view('procurement.ProcurementPlan.pdf.export', $data);
    }

    public function exportPlanOLD(Request $request)
    {
        try {
            $id = $request->planId;
            $rowData = $this->dataForExport($id);

            dd($rowData);
            $pdf = PDF::loadView(
                'procurement.ProcurementPlan.pdf.export',
                $rowData = [
                    'report' => $report,
                    'category' => $category,
                    'contractType' => $contractType
                ]
            )
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(), // Adjust as needed
                    'chroot' => public_path(),  // Adjust as needed
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'dpi' => 96,  // DPI setting (default is 96)
                    'fontHeightRatio' => 1.1,  // Adjust as needed
                    'defaultFont' => 'Helvetica',  // Default font family
                    'font_size' => 12,  // Set the font size
                ]);



            // $filename = 'exported_procurement_plan_' . $rowData['report'][0]->project_title . '_' . $rowData['report'][0]->budget_code . '_' . now()->format('Y_m_d_His') . '.pdf';
            $filename = 'exported_procurement_plan_' . $rowData['report'][0]->project_title . '_' . $rowData['report'][0]->budget_code . '_' . now()->format('Y_m_d_His') . '.pdf';


            // Download the PDF with the modified filename
            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error generating PDF',
                'details' => $e->getMessage()  // temporarily add this for debugging
            ], 500);
        }
    }



    public function exportPlanOLD2(Request $request)
    {
        try {
            $id = $request->planId;
            $rowData = $this->dataForExport($id);

            $report = $rowData['report'][0];

            $filename = 'procurement_plan_'
                . \Str::slug($report->project_title) . '_'
                . \Str::slug($report->budget_code) . '_'
                . now()->format('Y_m_d_His') . '.pdf';

            $pdf = PDF::loadView('procurement.ProcurementPlan.pdf.export', [
                'report' => $report,
                'category' => $report->category_name,
                'contractType' => $report->type
            ])
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'dpi' => 96,
                    'defaultFont' => 'Helvetica'
                ]);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'error' => 'Error generating PDF',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function exportPlan($id)
    {
        try {

            $rowData = $this->dataForExport($id);

            if (!isset($rowData['report'][0])) {
                throw new \Exception("No report found for the selected Procurement Plan.");
            }

            $report = $rowData['report'][0];

            $filename = 'procurement_plan_' .
                \Str::slug($report->project_title) . '_' .
                \Str::slug($report->budget_code) . '_' .
                now()->format('Y_m_d_His') . '.pdf';

            $pdf = PDF::loadView('procurement.ProcurementPlan.pdf.export', [
                'report' => $report,
                'category' => $report->category_name,
                'contractType' => $report->type
            ])
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'dpi' => 96,
                    'defaultFont' => 'Helvetica'
                ]);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'error' => 'Error generating PDF',
                'details' => $e->getMessage(),
            ], 500);
        }
    }




    public function procurementRecords()
    {
        $data['records'] = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->join('tblapproval', 'tblcontract_bidding.contract_biddingID', '=', 'tblapproval.bidding_id')
            ->where('tblcontract_bidding.status', '=', 3)
            ->get();
        return view('procurement.ProcurementPlan.records', $data);
    }



    public function searchProcurementRecords(Request $request)
    {
        $data['records'] = DB::table('tblcontract_details')
            ->join('tblcontract_bidding', 'tblcontract_bidding.contractID', '=', 'tblcontract_details.contract_detailsID')
            ->join('tblcontractor_registration', 'tblcontractor_registration.contractor_registrationID', '=', 'tblcontract_bidding.contractorID')
            ->leftjoin('tblapproval', 'tblcontract_bidding.contract_biddingID', '=', 'tblapproval.bidding_id')
            ->whereBetween('tblcontract_details.approval_date', [date('Y-m-d', strtotime(trim($request['startDate']))), date('Y-m-d', strtotime(trim($request['endDate'])))])
            ->where('tblcontract_bidding.status', '=', 3)
            ->get();
        return view('procurement.ProcurementPlan.records', $data);
    }

    public function editProcurementPlan($id)
    {
        $data['report'] = DB::table('tblprocurement_plan')
            ->leftJoin('tblprocurement_type', 'tblprocurement_type.procurement_typeID', '=', 'tblprocurement_plan.contract_type')
            ->where('id', '=', $id)->first();
        $data['contractType'] = DB::table('tblprocurement_type')->get();
        $data['category'] = DB::table('protblcontract_category')->get();

        return view('procurement.ProcurementPlan.edit', $data);
    }

    public function updateProcurementPlan(Request $request)
    {
        $data['display'] = DB::table('tblprocurement_plan')->where('id', '=', $request['id'])->update([
            'budget_year' => $request['budgetYear'],
            'budget_code' => $request['budgetCode'],
            'package_number' => $request['packageNumber'],
            'lot_number' => $request['lotNumber'],
            'plan_date' => $request['planDate'],
            'project_title' => $request['projectTitle'],
            'category' => $request['category'],
            'contract_type' => $request['contractType'],
            'budget_amount' => str_replace(",", "", $request['budget']),
            'estimate' => str_replace(",", "", $request['estimate']),
            'procurement_method' =>  $request['procurementMethod'],
            'qualification' => $request['qualification'],
            'review' => $request['review'],
            'bidDocFrom' => $request['bidDocFrom'],
            'bidDocTo' => $request['bidDocTo'],

            'mdaApproveFrom' => $request['mdaApproveFrom'],
            'mdaApproveTo' => $request['mdaApproveTo'],
            'preQualiAdvertFrom' => $request['prequaliAdvertFrom'],
            'preQualiAdvertTo' => $request['preQualiAdvertTo'],
            'preQualiClosingFrom' => $request['preQualiClosingFrom'],
            'preQualiClosingTo' => $request['preQualiClosingTo'],
            'preQualiEvaluationFrom' => $request['preQualiEvaluationFrom'],
            'preQualiEvaluationTo' => $request['preQualiEvaluationTo'],
            'preQualiEvaluateReportFrom' => $request['preQualiEvaluateReportFrom'],
            'preQualiEvaluateReportTo' => $request['preQualiEvaluateReportTo'],
            'mdaApprovalPreQualiFrom' => $request['mdaApprovalPreQualiFrom'],
            'mdaApprovalPreQualiTo' => $request['mdaApprovalPreQualiTo'],
            'invitationTenderFrom' => $request['invitationTenderFrom'],
            'invitationTenderTo' => $request['invitationTenderTo'],
            'technicalBidOpeningFrom' => $request['technicalBidOpeningFrom'],
            'technicalBidOpeningTo' => $request['technicalBidOpeningTo'],
            'technicalBidEvaluationFrom' => $request['technicalBidEvaluationFrom'],
            'technicalBidEvaluationTo' => $request['technicalBidEvaluationTo'],
            'financialBidOpeningFrom' => $request['financialBidOpeningFrom'],
            'financialBidOpeningTo' => $request['financialBidOpeningTo'],
            'preQualiCloseOpenFrom' => $request['preQualiCloseOpenFrom'],
            'preQualiCloseOpenTo' => $request['preQualiCloseOpenTo'],
            'financialEvaluationFrom' => $request['financialEvaluationFrom'],
            'financialEvaluationTo' => $request['financialEvaluationTo'],
            'submissionEvaluationFrom' => $request['submissionEvaluationFrom'],
            'submissionEvaluationTo' => $request['submissionEvaluationTo'],
            'mdaObjectionFrom' => $request['mdaObjectionFrom'],
            'mdaObjectionTo' => $request['mdaObjectionTo'],
            'certifiableAmountFrom' => $request['certifiableAmountFrom'],
            'certifiableAmountTo' => $request['certifiableAmountTo'],
            'fecApprovalFrom' => $request['fecApprovalFrom'],
            'fecApprovalTo' => $request['fecApprovalTo'],
            'dateContractOfferFrom' => $request['dateContractOfferFrom'],
            'dateContractOfferTo' => $request['dateContractOfferTo'],
            'contractSignatureDateFrom' => $request['contractSignatureDateFrom'],
            'contractSignatureDateTo' => $request['contractSignatureDateTo'],
            'advancePaymentFrom' => $request['advancePaymentFrom'],
            'advancePaymentTo' => $request['advancePaymentTo'],
            'draftFinalReportFrom' => $request['draftFinalReportFrom'],
            'draftFinalReportTo' => $request['draftFinalReportTo'],
            'finalAcceptanceFrom' => $request['finalAcceptanceFrom'],
            'finalAcceptanceTo' => $request['finalAcceptanceTo'],
            'created_at' => date('Y-m-d'),

        ]);
        return back()->with('msg', 'Successfully Updated');
    }
}
