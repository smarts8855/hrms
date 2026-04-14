<?php

namespace App\Http\Controllers\funds;

use App\Http\Requests;
use App\Role;
use App\User;
use Entrust;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as rep;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BasefunctionController extends Controller
{


    public function VoultBalance($id)
    {
        //$period=$this->ActivePeriod();
        $accounttype = DB::table('tbleconomicCode')->where('ID', $id)->value('contractGroupID');
        // dd($id);
        $period = DB::table('tblactiveperiod')->where('contractTypeID', $accounttype)->value('year');
        return $this->RealVoultBalance($id, $period);
    }
    public function RealVoultBalance($id, $period)
    {
        $BAL = DB::select("SELECT (IFNULL(sum(`amount`),0)-(SELECT IFNULL( sum( `totalPayment` ) , 0 ) FROM `tblpaymentTransaction`
		WHERE (`tblpaymentTransaction`.`status`>'0')
		and `tblpaymentTransaction`.`economicCodeID` ='$id' and `tblpaymentTransaction`.`period`='$period' ))
		as balance  FROM `tblmonthlyAllocation` WHERE `status`='1' and `economicID`='$id' and `year`='$period'");
        if ($BAL) {
            return $BAL[0]->balance;
        } else {
            return '0';
        }
    }

    public function VoultBalanceWithoutCurrentRefNo($id, $refNo)
    {
        $accounttype = DB::table('tbleconomicCode')->where('ID', $id)->value('contractGroupID');
        // dd($id);
        $period = DB::table('tblactiveperiod')->where('contractTypeID', $accounttype)->value('year');
        $BAL = DB::select("SELECT (IFNULL(sum(`amount`),0)-(SELECT IFNULL( sum( `totalPayment` ) , 0 ) FROM `tblpaymentTransaction`
		WHERE (`tblpaymentTransaction`.`status`>'0')
		and `tblpaymentTransaction`.`economicCodeID` ='$id' and `tblpaymentTransaction`.`period`='$period' and `tblpaymentTransaction`.`ID`<>'$refNo' ))
		as balance  FROM `tblmonthlyAllocation` WHERE `status`='1' and `economicID`='$id' and `year`='$period'");
        if ($BAL) {
            return $BAL[0]->balance;
        } else {
            return '0';
        }
    }

    public function ContractBalance($id)
    {
        $BAL = DB::select("SELECT
		(`contractValue`-(SELECT IFNULL( sum( `totalPayment` ) , 0 ) FROM `tblpaymentTransaction`
		WHERE `tblpaymentTransaction`.`contractID` ='$id'))
		as balance FROM `tblcontractDetails` WHERE `ID`='$id'");
        if ($BAL) {
            return $BAL[0]->balance;
        } else {
            return '0';
        }
    }
    public function PaidContractBalance($id)
    {
        $BAL = DB::select("SELECT
		(`contractValue`-(SELECT IFNULL( sum( `totalPayment` ) , 0 ) FROM `tblpaymentTransaction`
		WHERE (`tblpaymentTransaction`.`vstage`>'0')
		and `tblpaymentTransaction`.`contractID` ='$id'))
		as balance FROM `tblcontractDetails` WHERE `ID`='$id'");
        if ($BAL) {
            return $BAL[0]->balance;
        } else {
            return '0';
        }
    }
    public function ContractBalanceForEdit($id)
    {
        $BAL = DB::select("SELECT
		(`contractValue`-(SELECT IFNULL( sum( `totalPayment` ) , 0 ) FROM `tblpaymentTransaction`
		WHERE (`tblpaymentTransaction`.`status`>'0')
		and `tblpaymentTransaction`.`contractID` ='$id'))
		as balance FROM `tblcontractDetails` WHERE `ID`='$id'");
        if ($BAL) {
            return $BAL[0]->balance;
        } else {
            return '0';
        }
    }

    public function ActivePeriod()
    {
        return DB::table('tblactiveperiod')->max('year');
        //$data=  DB::select("SELECT * FROM `tblactiveperiod`");
        //if($data){return $data[0]->year;}else{return "";}
    }

    public function NewActivePeriod($contractTypeID)
    {
        return DB::table('tblactiveperiod')->where('contractTypeID', $contractTypeID)->value('year');
    }

    public function TotalUnallocated($ecoID, $month, $year)
    {
        $totalalocation = 0;
        $totalreceived = 0;
        $data =  DB::select("SELECT `allocationValue` FROM `tblbudget` WHERE `economicCodeID`='$ecoID' and `Period`='$year'");
        if ($data) {
            $totalalocation = $data[0]->allocationValue;
        }
        $data =  DB::select("SELECT sum(`amount`) as totalreceived FROM `tblmonthlyAllocation` WHERE `economicID`='$ecoID' and `year`='$year' and `month`<>'$month' and `status`=1");
        if ($data) {
            $totalreceived = $data[0]->totalreceived;
        }
        return $totalalocation - $totalreceived;
    }

    public function VoucherFinancialInfo($voucherID)
    {
        // dd($voucherID);
        $contractValue = 0;
        $contractID = '';
        $data =  DB::select("SELECT `contractID`,`datePrepared` FROM `tblpaymentTransaction` WHERE `ID`='$voucherID'");
        if ($data) {
            $contractID = $data[0]->contractID;
            $datePrepared = $data[0]->datePrepared;
        }
        $data =  DB::select("SELECT `contractValue` FROM `tblcontractDetails` WHERE `ID`='$contractID'");
        if ($data) {
            $contractValue = $data[0]->contractValue;
        }

        $data =  DB::select("SELECT ('$contractValue'-IFNULL(sum(`totalPayment`),0)) as BBF FROM `tblpaymentTransaction` WHERE `contractID`='$contractID' and (`datePrepared` < '$datePrepared' or (`datePrepared` = '$datePrepared' and `ID`<'$voucherID' ))");
        if ($data) {
            $BBF = $data[0]->BBF;
        }
        return DB::select("SELECT '$contractValue' as contractValue, '$BBF' as BBF")[0];
    }
    public function VotebookUpdate($ecoID, $refNo, $remark, $amount, $trandate, $transtype, $period = '')
    {
        //$transtype=1 when liabilty taken is approved
        //$transtype=2 when liability is cleared
        //$transtype=3 when economic vote is funded from monthly allocation
        //$transtype=4 when already funded economic vote is reversed
        //$transtype=5 when liability cleared is rejected
        //$transtype=6 when an already liability taken is rejected
        if($transtype == 5 || $transtype == 6 || $transtype == 2 || $transtype == 1){
            $Vdetails = DB::table('tblpaymentTransaction')->where('tblpaymentTransaction.ID', $refNo)->leftJoin('tblcontractor', 'tblpaymentTransaction.companyID', '=', 'tblcontractor.id')->first();
            $newActivePeriod = DB::table('tblactiveperiod')->where('contractTypeID', $Vdetails->contractTypeID)->value('year');

            if ($Vdetails->contractTypeID == 4) {
                $contractTypeInFileNo =  "SCN/OC/CAP/";
            } else {
                if ($Vdetails->is_advances == 1) {
                    $contractTypeInFileNo = "SCN/ADV/";
                } elseif ($Vdetails->is_advances == 3) {
                    $contractTypeInFileNo = "SCN/PE/";
                } else {
                    $contractTypeInFileNo = "SCN/OC/";
                }
            }
            if ($Vdetails->contractTypeID == 6) {
                $contractTypeInFileNo =  "SCN/PE/";
            }
        }


        switch ($transtype) {
            case "1":
                $ref1 = '';
                $remark1 = '';
                $amt1 = '';
                $total = '';
                $bal1 = $this->VoultBalance($ecoID);
                $ref2 = $refNo;
                $amt2 = $amount;
                $amt3 = '0';
                $liatotaloutstanding = $this->OutstandingLiability($ecoID);
                $remark2 = $remark;
                $bal2 = $this->VoultBalance($ecoID);
                break;
            case "2":
                $ref1 = $refNo;
                $remark1 = $remark;
                $amt1 = $amount;
                $total = $this->TotalCleared($ecoID);;
                $bal1 = $this->VoultBalance($ecoID);
                $ref2 = '';
                $amt2 = '0';
                $amt3 = $this->LiiabilityCleared($refNo);
                $liatotaloutstanding = $this->OutstandingLiability($ecoID);
                $remark2 = "";
                $bal2 = $this->VoultBalance($ecoID);
                break;
            case "5":
                $ref1 = $refNo;
                $remark1 = $remark;
                $amt1 = "( $amount)";
                $total = $this->TotalCleared($ecoID);;
                $bal1 = $this->RealVoultBalance($ecoID, $period);
                $ref2 = '';
                $amt2 = '0';
                $amt3 = $this->LiiabilityCleared($refNo);
                $liatotaloutstanding = $this->OutstandingLiability($ecoID);
                $remark2 = "";
                $bal2 = $this->VoultBalance($ecoID);
                break;
            case "3":
                $ref1 = $refNo;
                $remark1 = $remark;
                $amt1 = "( $amount )";
                $total = '';
                $bal1 = $this->RealVoultBalance($ecoID, $period);
                $ref2 = '';
                $amt2 = '0';
                $amt3 = '';
                $liatotaloutstanding = $this->OutstandingLiability($ecoID);
                $remark2 = "";
                $bal2 = $this->RealVoultBalance($ecoID, $period);
                break;
            case "4":
                $ref1 = $refNo;
                $remark1 = $remark;
                $amt1 = "$amount";
                $total = '';
                $bal1 = $this->RealVoultBalance($ecoID, $period);
                $ref2 = '';
                $amt2 = '0';
                $amt3 = '';
                $liatotaloutstanding = $this->OutstandingLiability($ecoID);
                $remark2 = "";
                $bal2 = $this->VoultBalance($ecoID);
                break;
        }

        if ($transtype == 3 || $transtype == 4) {
            DB::table('tblvotebookrecord')->insert(array(
                'ecoID'            => $ecoID,
                'refNo'        => $ref1,
                'particular'    => $remark1,
                'payment'        => $amt1,
                'total'        => $total,
                'balance'    => $bal1,
                'liaref'        => $ref2,
                'incurred'        => $amt2,
                'cleared'      => $amt3,
                'liatotaloutstanding'  => $liatotaloutstanding,
                'remark'        => $remark2,
                'availablebal'   => $bal2,
                'trandate'        => $trandate,
                'transtype'        => $transtype,
                'period'        => $period,

            ));
        }
        if ($transtype == 5) {
            DB::table('tblvotebookrecord')->insert(array(
                'ecoID'            => $ecoID,
                'refNo'        => $contractTypeInFileNo . "" . $Vdetails->vref_no . "/" . date('Y', strtotime(trim($Vdetails->datePrepared))),
                'particular'    => $remark1,
                'payment'        => $amount,
                'total'        => $total,
                'balance'    => $bal2,
                'liaref'        => $ref2,
                'incurred'        => $amt2,
                'cleared'      => $amt3,
                'liatotaloutstanding'  => $liatotaloutstanding,
                'remark'        => "Votebook Line Withdrawal",
                'availablebal'   => $bal2,
                'trandate'        => $trandate,
                'transtype'        => $transtype,
                'period'        => $newActivePeriod,
                'cancel_status' => 1,

            ));
        }
        if ($transtype == 2) {
            $voucherRefs = $this->generateVoucherRefs($Vdetails);

            //vote balance without current $refNo
            $balWithoutCurrentRef = $this->VoultBalanceWithoutCurrentRefNo($ecoID, $refNo);
            $newBalWithoutRef = ($balWithoutCurrentRef - ($amt1 - ($Vdetails->WHTValue ? $Vdetails->WHTValue : 0) - ($Vdetails->VATValue ? $Vdetails->VATValue : 0) - ($Vdetails->stampduty ? $Vdetails->stampduty : 0)));
            //vote total cleared without current $refNo
            $totalWithoutCurrentRef = $this->TotalClearedWithoutCurrentRefNo($ecoID, $refNo);
            $newTotalWithoutRef = ($totalWithoutCurrentRef + ($amt1 - ($Vdetails->WHTValue ? $Vdetails->WHTValue : 0) - ($Vdetails->VATValue ? $Vdetails->VATValue : 0) - ($Vdetails->stampduty ? $Vdetails->stampduty : 0)));

            DB::table('tblvotebookrecord')->insert(array(
                'ecoID'            => $ecoID,
                'refNo'        => $contractTypeInFileNo . "" . $voucherRefs['main'] . "/" . date('Y', strtotime(trim($Vdetails->datePrepared))),
                'particular'    => $Vdetails->contractor . " " . $remark1,
                'payment'        => $amt1 - ($Vdetails->WHTValue ? $Vdetails->WHTValue : 0) - ($Vdetails->VATValue ? $Vdetails->VATValue : 0) - ($Vdetails->stampduty ? $Vdetails->stampduty : 0),
                'total'        => $newTotalWithoutRef,
                'balance'    => $newBalWithoutRef,
                'liaref'        => $ref2,
                'incurred'        => $amt2,
                'cleared'      => $amt3,
                'liatotaloutstanding'  => $liatotaloutstanding,
                'remark'        => "Payment Voucher",
                'availablebal'   => $newBalWithoutRef,
                'trandate'        => $trandate,
                'transtype'        => $transtype,
                'period'        => $newActivePeriod,

            ));
            $runningBalance = $newBalWithoutRef;
            $runningTotal = $newTotalWithoutRef;
            if ($Vdetails->WHTValue > 0) {
                $runningBalance -= $Vdetails->WHTValue;
                $runningTotal += $Vdetails->WHTValue;
                DB::table('tblvotebookrecord')->insert(array(
                    'ecoID'            => $ecoID,
                    'refNo'        => $contractTypeInFileNo . "" . $voucherRefs['wht'] . "/" . date('Y', strtotime(trim($Vdetails->datePrepared))),
                    'particular'    => $Vdetails->WHT . "%" . " TAX Deduction to " . $Vdetails->contractor . "for " . $remark1,
                    'payment'        => $Vdetails->WHTValue,
                    'total'        => $runningTotal,
                    'balance'    => $runningBalance,
                    'liaref'        => $ref2,
                    'incurred'        => $amt2,
                    'cleared'      => $amt3,
                    'liatotaloutstanding'  => $liatotaloutstanding,
                    'remark'        => "Payment Voucher",
                    'availablebal'   => $runningBalance,
                    'trandate'        => $trandate,
                    'transtype'        => $transtype,
                    'period'        => $newActivePeriod,

                ));
            }
            if ($Vdetails->VATValue > 0) {
                $runningBalance -= $Vdetails->VATValue;
                $runningTotal += $Vdetails->VATValue;
                DB::table('tblvotebookrecord')->insert(array(
                    'ecoID'            => $ecoID,
                    'refNo'        => $contractTypeInFileNo . "" . $voucherRefs['vat'] . "/" . date('Y', strtotime(trim($Vdetails->datePrepared))),
                    'particular'    => $Vdetails->VAT . "%" . " VAT Deduction to " . $Vdetails->contractor . "for " . $remark1,
                    'payment'        => $Vdetails->VATValue,
                    'total'        => $runningTotal,
                    'balance'    => $runningBalance,
                    'liaref'        => $ref2,
                    'incurred'        => $amt2,
                    'cleared'      => $amt3,
                    'liatotaloutstanding'  => $liatotaloutstanding,
                    'remark'        => "Payment Voucher",
                    'availablebal'   => $runningBalance,
                    'trandate'        => $trandate,
                    'transtype'        => $transtype,
                    'period'        => $newActivePeriod,

                ));
            }
            if ($Vdetails->stampduty > 0) {
                $runningBalance -= $Vdetails->stampduty;
                $runningTotal += $Vdetails->stampduty;
                DB::table('tblvotebookrecord')->insert(array(
                    'ecoID'            => $ecoID,
                    'refNo'        => $contractTypeInFileNo . "" . $voucherRefs['stamp'] . "/" . date('Y', strtotime(trim($Vdetails->datePrepared))),
                    'particular'    => $Vdetails->stampdutypercentage . "%" . " Stamp Duty Deduction to " . $Vdetails->contractor . "for " . $remark1,
                    'payment'        => $Vdetails->stampduty,
                    'total'        => $runningTotal,
                    'balance'    => $runningBalance,
                    'liaref'        => $ref2,
                    'incurred'        => $amt2,
                    'cleared'      => $amt3,
                    'liatotaloutstanding'  => $liatotaloutstanding,
                    'remark'        => "Payment Voucher",
                    'availablebal'   => $runningBalance,
                    'trandate'        => $trandate,
                    'transtype'        => $transtype,
                    'period'        => $newActivePeriod,

                ));
            }
        }
    }
    private function generateVoucherRefs($voucher)
    {
        $base = (int) $voucher->vref_no;
        $offset = 1;

        $refs = [
            'main' => $base
        ];

        if ($voucher->WHTValue > 0) {
            $refs['wht'] = $base + $offset++;
        }

        if ($voucher->VATValue > 0) {
            $refs['vat'] = $base + $offset++;
        }

        if ($voucher->stampduty > 0) {
            $refs['stamp'] = $base + $offset++;
        }

        return $refs;
    }
    public function OutstandingLiability($id)
    {
        return  DB::select("SELECT IFNULL( sum(`amount`),0) as tsum FROM `tblliability_taken` WHERE `economic_id`='$id' and `is_cleared`=0 ")[0]->tsum;
    }
    public function OutstandingLiabilityNew($id)
    {

        $ct = DB::table('tbleconomicCode')->where('ID', $id)->value('contractGroupID');
        $period = DB::table('tblactiveperiod')->where('contractTypeID', $ct)->value('year');
        //dd("$period");
        return  DB::select("SELECT IFNULL( sum(`amount`),0) as tsum FROM `tblliability_taken` WHERE `economic_id`='$id' and `is_cleared`=0 and `period`='$period'  and status=1")[0]->tsum;
    }

    public function LiiabilityCleared($id)
    {
        return  DB::select("SELECT IFNULL( sum(`amount`),0) as tsum FROM `tblliability_taken` WHERE `economic_id`='$id' and `is_cleared`=1 ")[0]->tsum;
        $value = '';
        $data =  DB::select("SELECT `totalPayment` FROM `tblpaymentTransaction` WHERE `ID`='$id'
	and exists(SELECT null FROM `create_contract` WHERE `create_contract`.`fileNo`=`tblpaymentTransaction`.`FileNo`) ");
        if ($data) {
            $value = $data[0]->totalPayment;
        }
        return $value;
    }


    public function TotalCleared($id)
    {
        $data =  DB::select("SELECT IFNULL(sum(totalPayment),0) as sumTotal FROM `tblpaymentTransaction` WHERE `status`>1 and `economicCodeID`='$id' ");
        if ($data) return $data[0]->sumTotal;
        return '0';
    }

    public function TotalClearedWithoutCurrentRefNo($id, $refNo)
    {
        $accounttype = DB::table('tbleconomicCode')->where('ID', $id)->value('contractGroupID');
        $period = DB::table('tblactiveperiod')->where('contractTypeID', $accounttype)->value('year');
        $data =  DB::select("SELECT IFNULL(sum(totalPayment),0) as sumTotal FROM `tblpaymentTransaction` WHERE `status`>1 and `tblpaymentTransaction`.`ID`<>'$refNo' and `economicCodeID`='$id'and `tblpaymentTransaction`.`period`='$period' and `tblpaymentTransaction`.`contractTypeID`='$accounttype'");
        if ($data) return $data[0]->sumTotal;
        return '0';
    }

    public function UnclearedLiability($fn)
    {
        if (!DB::select("SELECT null FROM `create_contract` WHERE `fileNo`='$fn' and `fileNo`<>''")) return 0;
        $BAL = DB::select("SELECT IFNULL(sum(`liability_amount`),0) as balance FROM `create_contract` WHERE `fileNo`='$fn'");
        $BAL2 = DB::select("SELECT IFNULL(sum(`totalPayment`),0) as balance FROM `tblpaymentTransaction` WHERE `FileNo`='$fn' and (`status`='6' or `status`='2')");
        if ($BAL) {
            return $BAL[0]->balance - $BAL2[0]->balance;
        } else {
            return '0';
        }
    }
    public function VoteInfo($id)
    {
        $data =  DB::select("SELECT *
	,(SELECT `allocation` FROM `tblallocation_type` WHERE `tblallocation_type`.`ID`=`tbleconomicCode`.`allocationID`) as allocationtype
	,(SELECT `contractType` FROM `tblcontractType` WHERE `tblcontractType`.`ID`=`tbleconomicCode`.`contractGroupID`) as EconomicGroup
	,(SELECT `economicHead` FROM `tbleconomicHead` WHERE `tbleconomicHead`.`ID`=`tbleconomicCode`.`economicHeadID`) as EconomicHead
	FROM `tbleconomicCode` WHERE `ID`='$id'");
        if ($data) {
            return $data[0];
        } else {
            return DB::select("SELECT '' as economicHeadID ,'' as ,''as contractGroupID ,'' as allocationID ,'' as allocationtype  ,'' as EconomicGroup,'' as EconomicHead,'' as economicCode, '' as description")[0];
        }
    }
    public function ContractAttachment($id)
    {
        // dd($id);
        //return DB::table('tblcontractfile')->SELECT('*')->where('contractid', $id)->get();
        return DB::SELECT("SELECT * FROM `tblcontractfile` WHERE `contractid`='$id'");
    }
    public function ClaimAttachment($id)
    {

        return DB::SELECT("SELECT * FROM `staffclaimfile` WHERE `claimID`='$id'");
    }
    public function preContractAttachment($id)
    {
        //return DB::table('tblcontractfile')->SELECT('*')->where('contractid', $id)->get();
        return DB::SELECT("SELECT * FROM `tblcontractfile` WHERE `contractid`='$id'");
    }
    public function ApprovalReferal($id)
    {
        return DB::SELECT("SELECT * FROM `tblaction_rank` WHERE `cont_payment_active`=1 and `status`=1 and `userid`<>'$id' ORDER BY rankorder");
    }
    public function paymemtstatus()
    {
        return DB::SELECT("SELECT * FROM `tblstatus` WHERE `payment`=1");
    }
    public function UnitLocation()
    {
        return DB::SELECT("SELECT * FROM `tblvoucherstages` WHERE `id`>-1");
    }
    public function AllVouchers($fro, $to, $loc = '')
    {
        $qloc = 1;
        if ($loc != '') if ($loc == 0) {
            $qloc = " (vstage=-1 or vstage=0) ";
        } else {
            $qloc = " vstage='$loc' ";
        }
        $timedate = "(DATE_FORMAT(`datePrepared`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit
   	 	,tblstatus.description as statusdesc, tbleconomicCode.description as ecotext,tblcontractType.contractType  FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
        WHERE $timedate and tblpaymentTransaction.trackID is null and $qloc  and tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 order by datePrepared DESC");
    }

    public function SalaryVoucherTrack($fro, $to, $loc = '')
    {
        $qloc = 1;
        if ($loc != '') if ($loc == 0) {
            $qloc = " (vstage=-1 or vstage=0) ";
        } else {
            $qloc = " vstage='$loc' ";
        }

        $timedate = "(DATE_FORMAT(`datePrepared`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit
   	 	,tblstatus.description as statusdesc, tbleconomicCode.description as ecotext,tblcontractType.contractType  FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
        WHERE $timedate and tblpaymentTransaction.contractTypeID=6 and tblpaymentTransaction.trackID is null and $qloc  and tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 order by datePrepared DESC");
    }

    public function AllAuditVouchers($fro, $to)
    {
        $timedate = "(DATE_FORMAT(`auditDate`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit,users.name
   	 	,tblstatus.description as statusdesc, tbleconomicCode.description as ecotext,tblcontractType.contractType  FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
        left join users on users.id=tblpaymentTransaction.auditedBy
        WHERE $timedate and tblpaymentTransaction.trackID is null and vstage>3  and tblpaymentTransaction.is_special=0 and  tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 order by auditDate DESC");
    }
    public function AllCheckedVouchers($fro, $to)
    {
        $timedate = "(DATE_FORMAT(`dateCheck`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit,users.name
   	 	,tblstatus.description as statusdesc, tbleconomicCode.description as ecotext,tblcontractType.contractType  FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
        left join users on users.id=tblpaymentTransaction.checkBy
        WHERE $timedate and tblpaymentTransaction.trackID is null and vstage >= 3  and tblpaymentTransaction.is_special = 0 and  tblpaymentTransaction.is_archive = 0 and tblpaymentTransaction.is_restore = 0 order by dateCheck DESC");
    }
    public function MyAuditVouchers($fro, $to)
    {
        $id = Auth::user()->id;
        $timedate = "(DATE_FORMAT(`auditDate`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit,users.name
   	 	,tblstatus.description as statusdesc, tbleconomicCode.description as ecotext,tblcontractType.contractType  FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
        left join users on users.id=tblpaymentTransaction.auditedBy
        WHERE $timedate and tblpaymentTransaction.trackID is null and vstage>3 and tblpaymentTransaction.auditedBy='$id' and tblpaymentTransaction.is_special=0 and  tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 order by auditDate DESC");
    }
    public function AllRecallableVouchers($loc = '')
    {
        $qloc = 1;
        if ($loc != '') if ($loc == 0) {
            $qloc = " (vstage=-1 or vstage=0) ";
        } else {
            $qloc = " vstage='$loc' ";
        }
        //$timedate= "(DATE_FORMAT(`datePrepared`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit
   	 	,tblstatus.description as statusdesc FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        WHERE  tblpaymentTransaction.trackID is null and $qloc  and tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 and tblpaymentTransaction.status<>6 order by datePrepared DESC");
    }
    public function AllAdvanceVouchers($fro, $to, $loc = '')
    {
        $qloc = 1;
        if ($loc != '') if ($loc == 0) {
            $qloc = " (vstage=-1 or vstage=0) ";
        } else {
            $qloc = " vstage='$loc' ";
        }
        $timedate = "(DATE_FORMAT(`datePrepared`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit
   	 	,tblstatus.description as statusdesc FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        WHERE $timedate and tblpaymentTransaction.is_advances=1 and  tblpaymentTransaction.is_retired = 0 and  tblpaymentTransaction.trackID is null and $qloc  and tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 order by datePrepared DESC");
    }
    public function AllAdvanceRetiredVouchers($fro, $to, $loc = '')
    {
        $qloc = 1;
        if ($loc != '') if ($loc == 0) {
            $qloc = " (vstage=-1 or vstage=0) ";
        } else {
            $qloc = " vstage='$loc' ";
        }
        $timedate = "(DATE_FORMAT(`datePrepared`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit
   	 	,tblstatus.description as statusdesc FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        WHERE $timedate and tblpaymentTransaction.is_advances=1 and  tblpaymentTransaction.is_retired = 1 and  tblpaymentTransaction.trackID is null and $qloc  and tblpaymentTransaction.is_archive=0 and tblpaymentTransaction.is_restore=0 order by datePrepared DESC");
    }
    public function AllArchiveVouchers($fro, $to, $loc = '')
    {
        $qloc = 1;
        // if($loc!='')if($loc==0 ){
        //         $qloc=" (vstage=-1 or vstage=0) ";
        //     }else{
        //         $qloc=" vstage='$loc' ";
        //     }
        //$timedate= "(DATE_FORMAT(`datePrepared`,'%Y-%m-%d') BETWEEN '$fro' AND '$to')";
        $timedate = 1;
        return DB::SELECT("SELECT tblpaymentTransaction.*,tblcontractDetails.ID AS conID,tblcontractDetails.ContractDescriptions,tbleconomicCode.economicCode,tblcontractor.contractor,tblvoucherstages.unit
   	 	,tblstatus.description as statusdesc FROM `tblpaymentTransaction`
   	 	left join tblcontractDetails on tblcontractDetails.ID=tblpaymentTransaction.contractID
        left join tbleconomicCode on tblpaymentTransaction.economicCodeID=tbleconomicCode.ID
        left join tblcontractor on tblcontractor.id=tblpaymentTransaction.companyID
        left join tblvoucherstages on tblvoucherstages.id=tblpaymentTransaction.vstage
        left join tblstatus on tblpaymentTransaction.status=tblstatus.code
        WHERE $timedate and tblpaymentTransaction.trackID is null and $qloc  and tblpaymentTransaction.is_archive=1  order by datePrepared DESC");
    }
    public function RefNo()
    {
        $alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        //$Reference= $initcode . implode($pass);
        return implode($pass);
    }

    public function UpdateAlertTable($description, $url, $awaitinguserid, $awaiting_designation, $task_table, $task_id, $status = 1)
    {
        $closeprevaction =     DB::table('tblalert')->where('task_table', $task_table)->where('task_id', $task_id)->update(['status' => 0,]);
        if ($status == 0) return true;
        DB::table('tblalert')->insert([
            'description'             => $description,
            'url'                     => $url,
            'initiatedby'             => Auth::user()->id,
            'awaitinguserid'          => ($awaitinguserid) ? $awaitinguserid : 0,
            'awaiting_designation'    => $awaiting_designation,
            'task_table'              => $task_table,
            'task_id'                 => $task_id,
            'status'                  => 1,
        ]);
        return true;
    }

    public function DefaultComment($office)
    {
        return    DB::table('tbldefault_comment')->where('office', $office)->get();
    }
    public function UpdateDefaultComment($id, $comment, $office)
    {
        $d_comment =     DB::table('tbldefault_comment')->where('id', $id)->value('comment');
        if ($d_comment) return $d_comment;
        if (!DB::table('tbldefault_comment')->where('comment', trim($comment))->where('office', $office)->first())
            DB::table('tbldefault_comment')->insert([
                'comment'             => trim($comment),
                'office'              => $office ? $office : 'NA',
                'created_by'          => Auth::user()->id,
            ]);
        return $comment;
    }
    public function VnextNo($contractTypeID)
    {
        // $cur =    DB::table('tblpaymentTransaction')->orderBy('vref_no', 'DESC')->value('vref_no');

        $currentYear = Carbon::now()->year;
        $cur =    DB::table('tblpaymentTransaction')->where('contractTypeID', $contractTypeID)
        ->whereYear('datePrepared', $currentYear)
        ->orderBy('vref_no', 'DESC')->first();
        return $cur ? ($cur->vref_no + $cur->voucherNoCount) : 1;
    }
    public function AllEconomicsCode()
    {
        return DB::select("SELECT tbleconomicCode.*,
	tblcontractType.contractType
	FROM `tbleconomicCode`
	left join tblcontractType on tblcontractType.ID=tbleconomicCode.contractGroupID
	WHERE tbleconomicCode.`status`=1 order by tbleconomicCode.economicCode");
    }
    public function ProcessDATE($id)
    {
        //dd($id);
        $ct = DB::table('tbleconomicCode')->where('ID', $id)->value('contractGroupID');
        $activeperiod = DB::table('tblactiveperiod')->where('contractTypeID', $ct)->value('year');
        //dd($activeperiod);
        if (!$activeperiod)  $activeperiod = DB::table('tblactiveperiod')->max('year');
        if ($activeperiod == date('Y')) return  date('Y-m-d');
        return $activeperiod . '-12-31';
    }
    public function ProcessPeriod($id)
    {
        $ct = DB::table('tbleconomicCode')->where('ID', $id)->value('contractGroupID');
        $activeperiod = DB::table('tblactiveperiod')->where('contractTypeID', $ct)->value('year');
        if (!$activeperiod)  $activeperiod = DB::table('tblactiveperiod')->max('year');
        return $activeperiod;
    }
}
