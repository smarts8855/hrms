<?php

namespace App\Http\Controllers\Repository;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContractRepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Get Category
    public function setCategoryArray($status = 1)
    {
        try {
            return $setCategory = DB::table('protblcontract_category')->where('protblcontract_category.status', $status)
                ->leftJoin('users', 'users.id', '=', 'protblcontract_category.created_by')
                ->orderBy('protblcontract_category.contractCategoryID', 'Desc')
                ->get();
        } catch (\Throwable $e) {
            return [];
        }
    } //fun

    //Get Contract Details
    public function setContractDetailsArraybackup26022026($status = 1, $pagenation = null)
    {
        try {
            if (is_numeric($pagenation)) {
                if ($status == null) {
                    return $setContractDetail = DB::table('tblcontract_details')
                        ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                        ->leftJoin('protblstatus', 'protblstatus.statusID', '=', 'tblcontract_details.status')
                        ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                        ->leftjoin("tblcontract_bidding", 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
                        ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
                        ->groupBy('tblcontract_details.contract_detailsID')
                        ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                        // ->select('tblcontract_details.*', 'tblstatus.status_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name','tblcontractor_registration.company_name as contractor')
                        ->paginate($pagenation);
                } else {
                    return $setContractDetail = DB::table('tblcontract_details')->where('protblstatus.statusID', $status)
                        ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                        ->leftJoin('protblstatus', 'protblstatus.statusID', '=', 'tblcontract_details.status')
                        ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                        ->leftjoin("tblcontract_bidding", 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
                        ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
                        ->groupBy('tblcontract_details.contract_detailsID')
                        ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                        // ->select('tblcontract_details.*', 'tblstatus.status_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name','tblcontractor_registration.company_name as contractor')
                        ->paginate($pagenation);
                }
            } else {
                if ($status == null) {
                    return $setContractDetail = DB::table('tblcontract_details')
                        ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                        ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                        ->leftJoin('protblstatus', 'protblstatus.statusID', '=', 'tblcontract_details.status')
                        ->leftjoin("tblcontract_bidding", 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
                        ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
                        ->groupBy('tblcontract_details.contract_detailsID')
                        ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                        // ->select('tblcontract_details.*', 'tblstatus.status_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name','tblcontractor_registration.company_name as contractor')
                        ->get();
                } else {
                    return $setContractDetail = DB::table('tblcontract_details')->where('protblstatus.statusID', $status)
                        ->leftJoin('users', 'users.id', '=', 'tblcontract_details.created_by')
                        ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'tblcontract_details.contract_categoryID')
                        ->leftJoin('protblstatus', 'protblstatus.statusID', '=', 'tblcontract_details.status')
                        ->leftjoin("tblcontract_bidding", 'tblcontract_details.contract_detailsID', '=', 'tblcontract_bidding.contractID')
                        ->leftjoin('tblcontractor_registration', 'tblcontract_bidding.contractorID', '=', 'tblcontractor_registration.contractor_registrationID')
                        ->groupBy('tblcontract_details.contract_detailsID')
                        ->orderBy('tblcontract_details.contract_detailsID', 'Desc')
                        // ->select('tblcontract_details.*', 'tblstatus.status_name', 'name', 'id', 'contract_categoryID', 'status_code', 'category_name','tblcontractor_registration.company_name as contractor')
                        ->get();
                }
            }
        } catch (\Throwable $e) {
            return [];
        }
    } //fun


    public function setContractDetailsArray($status = 1, $pagenation = null)
    {
        try {
            $query = DB::table('tblcontract_details as c')
                ->leftJoin('users', 'users.id', '=', 'c.created_by')
                ->leftJoin('protblstatus', 'protblstatus.statusID', '=', 'c.status')
                ->join('protblcontract_category', 'protblcontract_category.contractCategoryID', '=', 'c.contract_categoryID')
                ->leftJoin('tblcontract_bidding as cb', 'c.contract_detailsID', '=', 'cb.contractID')
                ->leftJoin('tblcontractor_registration as cr', 'cb.contractorID', '=', 'cr.contractor_registrationID')
                ->leftJoin('contract_required_documents as crd', 'crd.tblcontract_detail_id', '=', 'c.contract_detailsID')
                ->groupBy('c.contract_detailsID')
                ->orderBy('c.contract_detailsID', 'Desc')
                ->select(
                    'c.*',
                    'users.name as created_by_name',
                    'protblstatus.status_name',
                    'protblcontract_category.category_name',
                    DB::raw('COUNT(crd.tblbid_required_doc_id) as doc_count')
                );


            if (!is_null($status)) {
                $query->where('protblstatus.statusID', $status);
            }

            if (is_numeric($pagenation)) {
                return $query->paginate($pagenation);
            }

            return $query->get();
        } catch (\Throwable $e) {
            // Log the error for debugging
            Log::error('Failed to fetch contracts: ' . $e->getMessage());
            return [];
        }
    } //fun




}//end class
