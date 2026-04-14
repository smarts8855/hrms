<?php

namespace App\Http\Controllers\funds;

use Illuminate\Support\Facades\Log;
use App\Http\Requests;
//use Illuminate\Http\Request;
use App\Http\Controllers;
use Carbon\Carbon;
use Entrust;
use Session;
use Excel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class function24Controller extends BasefunctionController
{

    public $valerrors;

    public function addLogg($operation, $title)
    {
        $ip = Request::ip();
        $url = Request::fullUrl();
        $userID = Auth::user()->id;
        $nowInNigeria = Carbon::now('Africa/Lagos');
        $cmpname = php_uname('a');
        $host = $_SERVER['HTTP_HOST'];
        DB::table('audit_log')->insert(
            [
                'comp_name' => $cmpname,
                'user_id' => $userID,
                'date' => $nowInNigeria,
                'ip_addr' => $ip,
                'operation' => $operation,
                'host' => $host,
                'referer' => $url,
                'action_title' => $title
            ]
        );
        return;
    }

    public function getList($table)
    {
        $list = DB::table($table)
            ->leftjoin('tblcontract_category', 'tblcontractType.contract_category', '=', 'tblcontract_category.id')
            ->orderby('status', 'desc')
            ->get();
        return $list;
    }

    public function getEconomicCode($allocation, $accthead)
    {
        //dd($allocation." ".$contract);

        $list = DB::table('tbleconomicCode')->where('allocationID', $allocation)->where('contractGroupID', $accthead)->get();
        if ($list) {
            return $list;
        } else {
            return [];
        }
    }
    public function getEconomicCode2($allocation, $contract)
    {

        $list = DB::table('tbleconomicCode')->where('allocationID', session('alloc'))->where('contractGroupID', $contract)->get();
        if ($list) {
            return $list;
        } else {
            return [];
        }
    }

    public function getAllocation()
    {
        $list = DB::table('tblallocation_type')->where('status', 1)->get();
        if ($list) {
            return $list;
        } else {
            return [];
        }
    }

    public function getContract()
    {
        $list = DB::table('tblcontractType')->where('status', 1)->get();
        if ($list) {
            return $list;
        } else {
            return [];
        }
    }
    public function getContractType()
    {
        $list = DB::table('tblcontractType')->where('status', 1)->get();
        if ($list) {
            return $list;
        } else {
            return [];
        }
    }

    public function getBeneficiary()
    {
        $list = DB::table('tblcontractor')->where('status', 1)->where('id', '<>', 13)->orderby('contractor')->get();
        return $list;
    }

    public function getProcurement()
    {
        $list = DB::table('tblcontractDetails')->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
            ->where('companyID', '!=', '13')
            ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblcontractDetails.createdBy', '=', 'users.id')
            ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor', 'users.name')->orderBy('approvalStatus', 'asc')->orderBy('dateAward', 'asc')->get();
        return $list;
    }
    public function getProcurementReassignable()
    {
        $list = DB::table('tblcontractDetails')->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
            ->where('companyID', '!=', '13')->where('approvalStatus', '=', '0')
            ->where('is_archive', '=', '0')
            ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblcontractDetails.createdBy', '=', 'users.id')
            ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor', 'users.name')->orderBy('ID', 'DESC')->get();
        return $list;
    }
    public function getProcurementReassignable2()
    {
        $list = DB::table('tblcontractDetails')->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
            ->where('companyID', '=', '13')->where('approvalStatus', '=', '0')
            ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblcontractDetails.createdBy', '=', 'users.id')
            ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor', 'users.name')->orderBy('approvalStatus', 'asc')->orderBy('dateAward', 'asc')->get();
        return $list;
    }
    public function getStaffProcurement()
    {
        $list = DB::table('tblcontractDetails')
            ->where('companyID', '13')
            ->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblcontractDetails.createdby', '=', 'users.id')
            ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor', 'users.name')->orderBy('approvalStatus', 'asc')->orderBy('dateAward', 'asc')->get();
        return $list;
    }

    public function getUnproccessedStaffClaim()
    {
        $list = DB::table('tblcontractDetails')
            ->where('companyID', '13')
            ->where('tblcontractDetails.contract_Type', '!=', 6)
            ->where('approvalStatus', 0)->where('is_archive', 0)
            ->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblcontractDetails.createdby', '=', 'users.id')
            ->leftjoin('tblaction_rank', 'tblcontractDetails.awaitingActionby', '=', 'tblaction_rank.code')
            ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor', 'users.name', 'tblaction_rank.description')->orderBy('ID', 'DESC')->get();
        return $list;
    }

    public function getTable($contracttype, $status)
    {
        if ($status == "All") {
            $list = DB::table('tblcontractDetails')
                ->where('contract_Type', $contracttype)
                ->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
                ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
                ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor')
                ->orderBy('approvalStatus', 'asc')
                ->orderBy('paymentStatus', 'asc')
                ->get();
        } else {
            $list = DB::table('tblcontractDetails')
                ->where('contract_Type', $contracttype)->where('approvalStatus', $status)
                ->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
                ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
                ->select('tblcontractDetails.*', 'tblcontractType.contractType', 'tblcontractor.contractor')
                ->orderBy('approvalStatus', 'asc')
                ->orderBy('paymentStatus', 'asc')
                ->get();
        }
        return $list;
    }
    public function getTable2($contracttype, $status, $suerid)
    {
        $qstatus = "`approvalStatus`='$status'";
        if ($status == "All" || $status == "") {
            $qstatus = 1;
        }
        //$qstatus=1;
        $qcontracttype = 1;
        if ($contracttype != "") {
            $qcontracttype = "`contract_Type`='$contracttype'";
        }


        $data =  DB::select("SELECT tblcontractDetails.*,users.name
	,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
	 FROM `tblcontractDetails`
	 left join users on  tblcontractDetails.createdBy=users.id
	 WHERE $qstatus and $qcontracttype and `is_archive`=0
	 and exists (SELECT null FROM `tblaction_rank` WHERE `tblaction_rank`.`code`=`tblcontractDetails`.`awaitingActionby` and `tblaction_rank`.`userid`='$suerid') order by `approvalStatus` asc, `paymentStatus` asc");
        return $data;
    }
    public function getContractQueryReport($contracttype, $status, $getTime1, $getTime2)
    {
        $qstatus = "`paymentStatus`='$status'";
        if ($status == "All" || $status == "") {
            $qstatus = 1;
        }
        $qcontracttype = 1;
        if ($contracttype != "") {
            $qcontracttype = "`contract_Type`='$contracttype'";
        }


        $data =  DB::select("SELECT *
	,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
	 FROM `tblcontractDetails` WHERE $qstatus and $qcontracttype and (dateAward BETWEEN '$getTime1' AND '$getTime2')
	  order by `approvalStatus` asc, `paymentStatus` asc");
        return $data;
    }
    public function getTable3($type, $bene, $contId, $unit)
    {
        $qcontracttype = 1;
        if ($type != "") {
            $qcontracttype = "`contract_Type`='$type'";
        }
        $qbene = 1;
        if ($bene != "") {
            $qbene = "`companyID`='$bene'";
        }
        $qcontId = 1;
        if ($contId != "") {
            $qcontId = "`fileNo`='$contId'";
        }
        $data =  DB::select("SELECT *
	,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
	 FROM `tblcontractDetails` WHERE $qbene and $qcontracttype and $qcontId
	 and approvalStatus = 1 AND openclose = 1 and awaitingActionby='$unit' ");
        return $data;
    }


    public function AllocationVoucher($userId)
    {
        $data =  DB::select("SELECT *
	,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
	 FROM `tblcontractDetails` WHERE `OC_staffId`='$userId'
	 and approvalStatus = 1 AND openclose = 1 ");
        //dd($data);
        return $data;
    }

    public function getFileNos()
    {
        $list = DB::table('tblcontractDetails')->select('fileNo', 'ID')->get();
        return $list;
    }

    public function getInfo($id)
    {
        $res = DB::table('tblcontractDetails')
            ->where('tblcontractDetails.ID', $id)
            ->leftjoin('tblcontractType', 'tblcontractDetails.contract_Type', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractor', 'tblcontractDetails.companyID', '=', 'tblcontractor.id')
            ->first();
        return $res;
    }

    public function validater($source, $values = [], $names = [], $view = 'CreateContract.createcontract')
    {



        if (!empty($source) && !empty($values)) {
            foreach ($values as $key => $value) {
                if (strpos($value, '|') !== false) {
                    $exp = explode('|', $value);
                    $emp_index = array_search('', $exp); //remove empty array index
                    array_slice($exp, $emp_index);
                    $checks = $exp;
                    foreach ($checks as $check) {
                        if ($check == 'required') {
                            if ($source[$key] == "" || empty($source[$key])) {
                                if (isset($names[$key])) {
                                    $this->valerrors[] = "{$names[$key]} is required";
                                } else {
                                    $this->valerrors[] = "{$source[$key]} is required";
                                }
                            }
                        }

                        if (strpos($check, 'required_unless') !== false) {
                            $breakcoma = explode(':', $check)[1];

                            $fieldunless = explode(',', $breakcoma)[0];
                            $valueunless = explode(',', $breakcoma)[1];

                            if ($source[$fieldunless] === $valueunless) {
                                if ($source[$key] == "" || empty($source[$key])) {
                                    if (isset($names[$key])) {
                                        $this->valerrors[] = "{$names[$key]} is required";
                                    } else {
                                        $this->valerrors[] = "{$source[$key]} is required";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($value == 'required') {
                        if ($source[$key] == "" || empty($source[$key])) {
                            if (isset($names[$key])) {
                                $this->valerrors[] = "{$names[$key]} is required";
                            } else {
                                $this->valerrors[] = "{$source[$key]} is required";
                            }
                        }
                    }

                    if (strpos($value, 'required_unless') !== false) {
                        $breakcoma = explode(':', $value)[1];

                        $fieldunless = explode(',', $breakcoma)[0];
                        $valueunless = explode(',', $breakcoma)[1];

                        if ($source[$fieldunless] === $valueunless) {
                            if ($source[$key] == "" || empty($source[$key])) {
                                if (isset($names[$key])) {
                                    $this->valerrors[] = "{$names[$key]} is required";

                                    //this->valerrors[] = "{$source[$key]} is required";);
                                } else {
                                    $this->valerrors[] = "{$source[$key]} is required";
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!empty($this->valerrors)) {
            return false;
        }
    }

    public function ContractDetails($contId)
    {
        $data =  DB::select("SELECT *
	,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
	,(SELECT `contractType` FROM `tblcontractType` WHERE `tblcontractType`.`ID`=`tblcontractDetails`.`contract_Type`) as EcoGroup
	 FROM `tblcontractDetails` WHERE `ID`='$contId'");
        if ($data)
            return $data[0];
        return null;
    }

    public function UnitStaff($unit)
    {
        return DB::select("SELECT *,  (SELECT `name` FROM `users` WHERE `users`.`id`=`tblstaff_section`.`user_id`) as Names FROM `tblstaff_section` WHERE `section`='$unit'");
    }

    public function MyUnChecked($id)
    {

        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 2)
            ->where('tblpaymentTransaction.checkBy', $id)
            ->select('tblpaymentTransaction.*',  'tbleconomicCode.description as ecotext', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.dateAward', 'tblcontractDetails.file_ex', 'tblcontractDetails.ContractDescriptions', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('checkbyStatus', 'asc')->orderBy('datePrepared', 'desc')->orderBy('dateAward', 'asc')->get();
    }
    public function UnChecked()
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 2)
            ->select('tblpaymentTransaction.*',  'tbleconomicCode.description as ecotext', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.dateAward', 'tblcontractDetails.file_ex', 'tblcontractDetails.ContractDescriptions', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('checkbyStatus', 'asc')->orderBy('datePrepared', 'desc')->orderBy('dateAward', 'asc')->get();
    }

    public function AdvancedToChecking()
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->leftjoin('tblliability_taken', 'tblliability_taken.contractID', 'tblpaymentTransaction.contractID')
            ->where('tblpaymentTransaction.vstage', 999)
            ->where('tblpaymentTransaction.status', 2)
            // ->where('tblliability_taken.status', 1)
            ->select('tblpaymentTransaction.*',  'tbleconomicCode.description as ecotext', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.dateAward', 'tblcontractDetails.file_ex', 'tblcontractDetails.ContractDescriptions', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', DB::raw('tblcontractDetails.ID AS conID'))
            // ->orderBy('checkbyStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();
    }

    public function CheckedAdvanceVoucherFnc()
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->leftjoin('tblliability_taken', 'tblliability_taken.contractID', 'tblpaymentTransaction.contractID')
            ->where('tblpaymentTransaction.vstage', -3)
            ->where('tblpaymentTransaction.status', 2)
            // ->where('tblliability_taken.status', 1)
            ->select('tblpaymentTransaction.*',  'tbleconomicCode.description as ecotext', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.dateAward', 'tblcontractDetails.file_ex', 'tblcontractDetails.ContractDescriptions', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', DB::raw('tblcontractDetails.ID AS conID'))
            // ->orderBy('checkbyStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();
    }

    public function MyUnAuditted($id)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            //->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.datePrepared', '>', '2021-06-30')
            ->where('tblpaymentTransaction.vstage', 3)
            ->where('tblpaymentTransaction.auditedBy', $id)
            ->select('tblpaymentTransaction.*',  'tbleconomicCode.description as ecotext', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.dateAward', 'tblcontractDetails.file_ex', 'tblcontractDetails.ContractDescriptions', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('checkbyStatus', 'asc')->orderBy('datePrepared', 'desc')->orderBy('dateAward', 'asc')->get();
    }

    public function UnAuditted()
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            //->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            //->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 3)
            ->where('tblpaymentTransaction.datePrepared', '>', '2021-11-30')
            ->select(
                'tblpaymentTransaction.*',
                'tbleconomicCode.description as ecotext',
                'tblcontractor.contractor',
                'tblcontractType.contractType',
                'tbleconomicCode.economicCode',
                //, 'tblallocation_type.allocation',
                'tblcontractDetails.contractValue',
                'tblcontractDetails.dateAward',
                'tblcontractDetails.ContractDescriptions',
                'tblcontractDetails.beneficiary',
                'tblcontractDetails.voucherType',
                DB::raw('tblcontractDetails.ID AS conID')
            )
            ->orderBy('checkbyStatus', 'asc')->orderBy('datePrepared', 'desc')->orderBy('dateAward', 'asc')->get();
    }

    public function UnFundClearance($getSearchFrom = null, $getSearchTo = null, $getSearchYear = null)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 1)
            ->where('tblpaymentTransaction.status', 0)
            //->whereBetween('tblpaymentTransaction.dateCreated', [$getSearchFrom, $getSearchTo])
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('tblpaymentTransaction.dateCreated', 'desc')
            //->orderBy('liabilityStatus', 'asc')
            //->orderBy('dateAward', 'asc')
            ->get();
    }

    public function UnFundClearanceStatus2($getSearchFrom = null, $getSearchTo = null, $getSearchYear = null)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 1)
            ->where('tblpaymentTransaction.status', 2)
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('tblpaymentTransaction.dateCreated', 'desc')
            ->get();
    }

    public function UnFundClearanceAdvance($getSearchFrom = null, $getSearchTo = null, $getSearchYear = null)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 999)
            ->where('tblpaymentTransaction.status', 0)
            //->whereBetween('tblpaymentTransaction.dateCreated', [$getSearchFrom, $getSearchTo])
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('tblpaymentTransaction.dateCreated', 'desc')
            //->orderBy('liabilityStatus', 'asc')
            //->orderBy('dateAward', 'asc')
            ->get();
    }

    public function UnFundClearancePersonnel($getSearchFrom = null, $getSearchTo = null, $getSearchYear = null)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', -2)
            ->where('tblpaymentTransaction.status', 0)
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('tblpaymentTransaction.dateCreated', 'desc')
            ->get();
    }

    public function ClearedTransaction($from, $to)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->whereBetween('dateTakingLiability', [$from, $to])
            ->where('tblpaymentTransaction.status', '>', 0)
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('liabilityStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();
    }
    public function UnFundClearance2()
    {
        return DB::table('tblpaymentTransaction20200707')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction20200707.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction20200707.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction20200707.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction20200707.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction20200707.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction20200707.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction20200707.vstage', 1)
            ->select('tblpaymentTransaction20200707.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('liabilityStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();;
    }
    public function MyUnFundClearance($id)
    {
        // dd($id);
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 1)
            // ->where('tblpaymentTransaction.status', '<', 2)
            ->where('tblpaymentTransaction.status', 0)
            ->where('tblpaymentTransaction.liabilityBy', $id)
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('liabilityStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();
    }

    public function ECfinalClearance()
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.vstage', 1)->where('tblpaymentTransaction.status', 2)
            //->where('tblpaymentTransaction.liabilityBy',$id )
            ->select('tblpaymentTransaction.*', 'tblcontractor.contractor', 'tblcontractType.contractType', 'tbleconomicCode.economicCode', 'tblallocation_type.allocation', 'tblcontractDetails.contractValue', 'tblcontractDetails.file_ex', 'tblcontractDetails.beneficiary', 'tblcontractDetails.voucherType', 'tblcontractDetails.ContractDescriptions', DB::raw('tblcontractDetails.ID AS conID'))
            ->orderBy('liabilityStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();
    }


    public function VourcherGroup($data)
    {

        foreach ($data as $key => $value) {
            $lis = (array) $value;
            $lis['balance'] = $this->VoucherFinancialInfo($value->ID);

            $com = DB::table('tblcomments')->where('paymentID', $value->ID)->orwhere('affectedID', $value->contractID)->get();
            $lis['comment'] = "";
            $lis['comment2'] = "";
            if ($com) {

                foreach ($com as $k => $list) {

                    $newline = (array) $list;
                    $name = '';
                    $newline['name'] = $name;
                    $date = strtotime($list->added);
                    $newline['comment'] = str_replace("\r\n", "<br>", $list->comment);
                    $newline['date_added'] = date("F j, Y", $date);
                    $newline['time'] = date("g:i a", $date);
                    $newline = (object) $newline;
                    $com[$k] = $newline;
                }
                $lis['comment'] = json_encode($com);
            }
            $com2 = [];
            if ($com2) {
                foreach ($com2 as $k => $list) {
                    //$newline = (array) $list;
                    $newline = (array) [];
                    $name = DB::table('users')->where('id', $list->userID)->first()->name;
                    $newline['name'] = $name;
                    $newline['comment'] = str_replace("\r\n", "<br>", $list->comment);
                    $date = strtotime($list->date);
                    $newline['date_added'] = date("F j, Y", $date);
                    $newline['time'] = date("g:i a", $date);
                    $newline = (object) $newline;
                    $com2[$k] = $newline;
                }
                $lis['comment2'] = json_encode($com2);
            }
            $value = (object) $lis;
            $data[$key]  = $value;
        }

        return  $data;
    }


    public function VourcherGroupWithBalances($data)
    {
        foreach ($data as $key => $value) {
            // dd($value);
            $lis = (array) $value;
            $lis['balance'] = $this->VoucherFinancialInfo($value->ID);
            $lis['votebal'] = $this->VoultBalance($value->economicCodeID);
            $lis['OutstandingLiability'] = $this->OutstandingLiabilityNew($value->economicCodeID);
            $voteinfo = $this->VoteInfo($value->economicCodeID);
            $lis['voteinfo'] = $voteinfo->description;
            $com = DB::table('tblcomments')->where('affectedID', $value->ID)->orwhere('affectedID', $value->contractID)->get();
            $lis['comments'] = "";
            $lis['comments2'] = '';
            $value = (object) $lis;
            $data[$key]  = $value;
        }
        return  $data;
    }

    public function VourcherGroupWithBalances2($data)
    {
        foreach ($data as $key => $value) {
            $lis = (array) $value;
            $lis['balance'] = $this->VoucherFinancialInfo($value->ID);
            $lis['votebal'] = $this->VoultBalance($value->economicCodeID);
            $lis['OutstandingLiability'] = $this->OutstandingLiabilityNew($value->economicCodeID); //0;//
            $voteinfo = $this->VoteInfo($value->economicCodeID);
            $lis['voteinfo'] = $voteinfo->description;
            $value = (object) $lis;
            $data[$key]  = $value;
        }
        return  $data;
    }
    public function StaffEconomicsCode()
    {
        return DB::select("SELECT tbleconomicCode.*,
	tblcontractType.contractType
	FROM `tbleconomicCode`
	left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
	WHERE `contractGroupID`<>'4' and tbleconomicCode.`status`=1");
    }
    public function Ecodetails($id)
    {
        return DB::select("SELECT * FROM `tbleconomicCode` WHERE `ID`='$id'");
    }


    public function ClaimBenefeciary($id)
    {
        // return DB::select("SELECT tblselectedstaffclaim.*
        //                  ,tblStaffInformation.account_no
        //                  ,tblStaffInformation.bankID
        //                  ,tblStaffInformation.sort_code
        //                  ,tblStaffInformation.account_no
        //                 ,tblStaffInformation.full_name
        //                 ,(staffamount-(SELECT IFNULL(sum(tblvoucherBeneficiary.`amount`),0)  FROM `tblvoucherBeneficiary` WHERE tblvoucherBeneficiary.`claim_selected_staff`=tblselectedstaffclaim.selectedID)) as amtpending
        //                 FROM `tblselectedstaffclaim`
        //                 left join tblStaffInformation on tblselectedstaffclaim.staffID=tblStaffInformation.staffID
        //                 WHERE `tblselectedstaffclaim`.claimID ='$id' ");
        return DB::select("SELECT tblselectedstaffclaim.*
                     ,tblper.AccNo
                     ,tblper.bankID
                    --  ,tblStaffInformation.sort_code
                    --  ,tblStaffInformation.account_no
                    ,tblper.surname
					,tblper.first_name
					,tblper.othernames
                    ,tblper.fileNo
                    ,(staffamount-(SELECT IFNULL(sum(tblvoucherBeneficiary.`amount`),0)  FROM `tblvoucherBeneficiary` WHERE tblvoucherBeneficiary.`claim_selected_staff`=tblselectedstaffclaim.selectedID)) as amtpending
                    FROM `tblselectedstaffclaim`
                    left join tblper on tblselectedstaffclaim.staffID=tblper.ID
                    WHERE `tblselectedstaffclaim`.claimID ='$id' order by `tblselectedstaffclaim`.selectedID");
    }



    public function ClaimBenefeciaryNew($id)
    {
        return DB::table('tblselectedstaffclaim')
            ->leftJoin('tblper', 'tblselectedstaffclaim.staffID', '=', 'tblper.ID')
            ->select(
                'tblselectedstaffclaim.*',
                'tblper.AccNo',
                'tblper.bankID',
                'tblper.surname',
                'tblper.first_name',
                'tblper.othernames',
                'tblper.fileNo',

                'tblper.claimAccountNo',
                'tblper.claimBankId',
                'tblper.claimBankSortCode',

                DB::raw('(staffamount - (
                SELECT IFNULL(SUM(amount),0)
                FROM tblvoucherBeneficiary
                WHERE claim_selected_staff = tblselectedstaffclaim.selectedID
            )) as amtpending')
            )
            ->where('tblselectedstaffclaim.claimID', $id)
            ->orderBy('tblselectedstaffclaim.selectedID')
            ->get();
    }



    public function ContractVoucherList($id)
    {
        return DB::table('tblpaymentTransaction')
            ->leftjoin('tblcontractType', 'tblpaymentTransaction.contractTypeID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblpaymentTransaction.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')
            ->leftjoin('tbleconomicCode', 'tblpaymentTransaction.economicCodeID', '=', 'tbleconomicCode.ID')
            ->leftjoin('tblallocation_type', 'tblpaymentTransaction.allocationType', '=', 'tblallocation_type.ID')
            ->leftjoin('tblVATWHTPayee', 'tblpaymentTransaction.VATPayeeID', '=', 'tblVATWHTPayee.ID')
            ->where('tblpaymentTransaction.contractID', $id)->where('tblpaymentTransaction.is_restore', 0)
            ->select(
                'tblpaymentTransaction.*',
                'tblcontractor.contractor',
                'tblcontractType.contractType',
                'tbleconomicCode.economicCode',
                'tbleconomicCode.description',
                'tblallocation_type.allocation',
                'tblcontractDetails.contractValue',
                'tblcontractDetails.file_ex',
                'tblcontractDetails.beneficiary',
                'tblcontractDetails.voucherType',
                'tblcontractDetails.ContractDescriptions',
                DB::raw('tblcontractDetails.ID AS conID')
            )
            ->orderBy('liabilityStatus', 'asc')
            ->orderBy('dateAward', 'asc')->get();
    }
    public function UnprecessApprovedList($id, $ptype = '')
    {
        $qptype = 1;
        if ($ptype == 1) {
            $qptype = " `tblcontractDetails`.`companyID`=13";
        }
        if ($ptype == 2) {
            $qptype = " `tblcontractDetails`.`companyID`<>13";
        }
        $qid = "`awaitingActionby`='$id'";
        if ($id == "All" || $id == "") {
            $qid = 1;
        }
        // $data =  DB::select("SELECT *
        // ,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
        //  FROM `tblcontractDetails` WHERE $qid and approvalStatus= 0 and  `openclose`=0 and $qptype and `awaitingActionby`<>'OC'and `awaitingActionby`<>'AD' and `is_archive`=0 order by `approvalStatus` asc, `paymentStatus` asc");
        // return $data;
        $data =  DB::select("SELECT *
        ,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
         FROM `tblcontractDetails` WHERE $qid and $qptype and `awaitingActionby`<>'AD' and `is_archive`=0 and `contract_type` <> 6 order by `approvalStatus` asc, `paymentStatus` asc, `ID` desc");
        return $data;
    }
    public function UnprecessApprovedListSalary($id, $ptype = '')
    {
        $qptype = 1;
        if ($ptype == 1) {
            $qptype = " `tblcontractDetails`.`companyID`=13";
        }
        if ($ptype == 2) {
            $qptype = " `tblcontractDetails`.`companyID`<>13";
        }
        $qid = "`awaitingActionby`='$id'";
        if ($id == "All" || $id == "") {
            $qid = 1;
        }
        $data =  DB::select("SELECT *
        ,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
         FROM `tblcontractDetails` WHERE $qid and $qptype and `awaitingActionby` = 'SA' and `approvalStatus`=0 and `openclose`=0 and `is_archive`=0 and `contract_type` = 6 order by `approvalStatus` asc, `paymentStatus` asc, `ID` desc");
        return $data;
    }
    public function ArchiveApprovedList($id, $ptype = '')
    {
        $qptype = 1;
        if ($ptype == 1) {
            $qptype = " `tblcontractDetails`.`companyID`=13";
        }
        if ($ptype == 2) {
            $qptype = " `tblcontractDetails`.`companyID`<>13";
        }
        $qid = "`awaitingActionby`='$id'";
        if ($id == "All" || $id == "") {
            $qid = 1;
        }
        $data =  DB::select("SELECT *
        ,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
         FROM `tblcontractDetails` WHERE $qid and `openclose`=0 and $qptype and `awaitingActionby`<>'OC' and `is_archive`=1 order by `approvalStatus` asc, `paymentStatus` asc");
        return $data;
    }
    public function ClearedApprovedList($ptype = '')
    {
        $qptype = 1;
        if ($ptype == 1) {
            $qptype = " `tblcontractDetails`.`companyID`=13";
        }
        if ($ptype == 2) {
            $qptype = " `tblcontractDetails`.`companyID`<>13";
        }
        $data =  DB::select("SELECT *
        ,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
         FROM `tblcontractDetails` WHERE  $qptype and `awaitingActionby`='OC' order by `approvalStatus` asc, `paymentStatus` asc");
        return $data;
    }
    public function FindApprovedDocument($id)
    {
        $qid = "`awaitingActionby`='$id'";
        if ($id == "All" || $id == "") {
            $qid = 1;
        }
        $data =  DB::select("SELECT *
        ,(SELECT `contractor` FROM `tblcontractor` WHERE `tblcontractor`.`id`=`tblcontractDetails`.`companyID`) as contractor
         FROM `tblcontractDetails` WHERE $qid and `openclose`=1  order by `approvalStatus` asc, `paymentStatus` asc");
        return $data;
    }
    public function Staff_Contract()
    {
        return json_decode('[{"id":"1","text":"Staff Payment"},{"id":"2","text":"Contract Payment"}]');
    }
    public function ContractLiabilityRecord($status, $is_cleared, $getSearchFrom = null, $getSearchTo = null, $getSearchYear = null)
    {

        $list = DB::table('tblliability_taken')
            ->leftjoin('tbleconomicCode', 'tblliability_taken.economic_id', '=', 'tbleconomicCode.ID')
            ->where('beneficiary_id', '!=', '13')
            ->where('is_rejected', '!=', '1')
            ->where('tblliability_taken.is_staff', '==', 0)
            //->where('tblliability_taken.status', $status)
            //->where('is_cleared',$is_cleared )
            ->leftjoin('tblcontractor', 'tblliability_taken.beneficiary_id', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblliability_taken.created_by', '=', 'users.id')
            ->leftjoin('tblcontractType', 'tbleconomicCode.contractGroupID', '=', 'tblcontractType.ID')
            //->whereBetween('tblliability_taken.date_awarded', [$getSearchFrom, $getSearchTo])
            ->select('tblliability_taken.*',  'tblcontractor.contractor',  'tbleconomicCode.description as ecotext', 'users.name', 'tbleconomicCode.economicCode', 'tblcontractType.contractType')
            ->orderBy('status', 'asc')
            ->orderBy('date_awarded', 'asc')
            ->get();
        return $list;
    }
    public function ContractLiabilityRecord2($status, $is_cleared, $getSearchFrom = null, $getSearchTo = null, $getSearchYear = null)
    {

        $list = DB::table('tblliability_taken')
            ->leftjoin('tbleconomicCode', 'tblliability_taken.economic_id', '=', 'tbleconomicCode.ID')
            // ->where('beneficiary_id', '!=', '13')
            // ->where('is_rejected', '!=', '1')
            ->where('tblliability_taken.is_staff', 1)
            //->where('tblliability_taken.status', $status)
            //->where('is_cleared',$is_cleared )
            ->leftjoin('tblcontractor', 'tblliability_taken.beneficiary_id', '=', 'tblcontractor.id')
            ->leftjoin('users', 'tblliability_taken.created_by', '=', 'users.id')
            ->leftjoin('tblcontractType', 'tbleconomicCode.contractGroupID', '=', 'tblcontractType.ID')
            ->leftjoin('tblcontractDetails', 'tblliability_taken.contractID', '=', 'tblcontractDetails.ID')
            ->leftjoin('tblpaymentTransaction', 'tblpaymentTransaction.contractID', '=', 'tblliability_taken.contractID')
            //->whereBetween('tblliability_taken.date_awarded', [$getSearchFrom, $getSearchTo])
            ->select('tblliability_taken.*',  'tblcontractor.contractor',  'tbleconomicCode.description as ecotext', 'users.name', 'tbleconomicCode.economicCode', 'tblcontractType.contractType', 'tblpaymentTransaction.voucherFileNo')
            ->orderBy('status', 'asc')
            ->orderBy('date_awarded', 'asc')
            ->get();
        return $list;
    }
}
