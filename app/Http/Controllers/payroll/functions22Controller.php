<?php


namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class functions22Controller extends Controller
{

    public function getCourts()
    {
        $list = DB::table('tbl_court')->get();
        return $list;
    }

    public function getOneStaff($staffid)
    {
        //DB::enableQueryLog();
        $staffList = DB::table('tblper')
            //->join('tbldivision', 'tbldivision.divisionID', '=', 'tblper.divisionID')
            ->select('fileNo', 'surname', 'first_name', 'othernames')

            ->where('tblper.ID', '=', $staffid)
            ->where('tblper.staff_status', 1)
            ->first();
        //dd(DB::getQueryLog());
        return $staffList;
    }

    public function getCourtDivision($courtid)
    {
        $list = DB::table('tbldivision')->where('courtID', $courtid)->orderBy('division', 'Asc')->get();
        return $list;
    }

    public function getStaffinDivision($divisionid)
    {
        return DB::table('tblper')->where('divisionID', $divisionid)->where('staff_status', '=', 1)->get();
    }

    public function getCV($cvtype)
    {
        $list = DB::table('tblcvSetup')->where('status', 1)->whereNotBetween('ID', [8, 23])->where('particularID', $cvtype)->get();
        return $list;
    }
    public function getCVHEAD($cvtype)
    {
        $list = DB::table('tblcvSetup')
            ->where('status', 1)
            ->where('particularID', $cvtype)
            ->get();

        return $list;
    }
    public function getDesc()
    {
        $list = DB::table('tblcvSetup')->where('status', 1)->get();
        return $list;
    }
    public function getTableContent($staffid, $court, $division)
    {
        if ($staffid !== "") {
            $list = DB::Select("SELECT tblstaffCV.*,tblcvSetup.description
            ,(SELECT sum(`amount`) FROM `tblotherEarningDeduction` WHERE `staffcvid`=tblstaffCV.ID) as totaloffset
            ,(SELECT  Concat(`month`,' ' ,`year`)FROM `tblotherEarningDeduction` WHERE `staffcvid`=tblstaffCV.ID  order by `ID` desc limit 1) as lastperiod
            FROM `tblstaffCV` left join  tblcvSetup on tblcvSetup.ID=tblstaffCV.cvID WHERE `staffid`='$staffid'");
            return $list;
        } else {
            return [];
        }
    }

    public function staffEarnAndDeduction($division, $cvid)
    {
        $list = DB::Select("SELECT tblstaffCV.*,tblcvSetup.description,tblper.surname,tblper.first_name,tblper.othernames
            ,(SELECT sum(`amount`) FROM `tblotherEarningDeduction` WHERE `CVID`=tblstaffCV.ID) as totaloffset
            ,(SELECT  Concat(`month`,' ' ,`year`) FROM `tblotherEarningDeduction` order by `ID` desc limit 1) as lastperiod
            FROM `tblstaffCV`
            inner join tblper on tblper.ID=tblstaffCV.staffid
            left join  tblcvSetup on tblcvSetup.ID=tblstaffCV.cvID WHERE tblstaffCV.divisionID='$division' and tblstaffCV.cvID='$cvid'
            group by tblstaffCV.ID");

        // dd($list);

        return $list;
    }

    public function staffEarnAndDeductionNoDivision($cvid, $year = null, $month = null)
    {
        $params = [$cvid];
        
        $query = "
            SELECT
                tblstaffCV.*,
                tblcvSetup.description,
                tblper.surname,
                tblper.first_name,
                tblper.othernames,
                tblper.fileNo,
                oed.amount,
                oed.year,
                oed.month,
                (SELECT SUM(amount) FROM tblotherEarningDeduction WHERE staffcvid = tblstaffCV.ID) as totaloffset
            FROM tblstaffCV
            INNER JOIN tblotherEarningDeduction oed
                ON oed.staffcvid = tblstaffCV.ID
            INNER JOIN tblper
                ON tblper.ID = tblstaffCV.staffid
            LEFT JOIN tblcvSetup
                ON tblcvSetup.ID = tblstaffCV.cvID
            WHERE tblstaffCV.cvID = ?
        ";
        
        // Add year filter if provided - year is stored as VARCHAR
        if ($year) {
            $query .= " AND oed.year = ?";
            $params[] = (string)$year; // Convert to string to match VARCHAR
        }
        
        // Add month filter if provided - month is stored as VARCHAR (full month name in uppercase)
        if ($month) {
            // Convert month number to month name (uppercase to match database)
            $monthNames = [
                1 => 'JANUARY', 2 => 'FEBRUARY', 3 => 'MARCH', 4 => 'APRIL',
                5 => 'MAY', 6 => 'JUNE', 7 => 'JULY', 8 => 'AUGUST',
                9 => 'SEPTEMBER', 10 => 'OCTOBER', 11 => 'NOVEMBER', 12 => 'DECEMBER'
            ];
            
            $monthName = $monthNames[intval($month)];
            $query .= " AND UPPER(oed.month) = ?"; // UPPER to handle any case issues
            $params[] = $monthName;
        }
        
        $query .= " ORDER BY tblper.surname ASC";
        
        $list = DB::select($query, $params);
        
        return $list;
    }

    public function getTableContentold($staffid, $court, $division)
    {
        if ($staffid !== "") {
            $list = DB::table('tblstaffCV')
                ->where('staffid', $staffid)
                ->where('courtID', $court)
                ->where('divisionID', $division)
                ->leftjoin('tblcvSetup', 'tblcvSetup.ID', '=', 'tblstaffCV.cvID')
                ->select('tblcvSetup.description', 'tblstaffCV.*')
                ->get();
            return $list;
        } else {
            return [];
        }
    }

    public function getStaffInfo($fileNo)
    {


        $dataval = DB::table('tblper')
            ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblper.bankID')
            ->where('ID', $fileNo)->first();

        if ($dataval) {
            // dd($dataval);
            return $dataval;
        } else {
            $val = DB::SELECT("select '' as 'first_name', '' as 'surname', ''as 'othernames', '' as 'fileNo'");
            return $val[0];
        }
    }

    public function checker($court, $division, $staffid)
    {
        $res = DB::table('tblper')
            ->where('courtID', $court)
            ->where('divisionID', $division)
            ->where('ID', $staffid)
            ->get();
        if ($res !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteControlVariable($id)
    {
        return (DB::table('tblstaffCV')->where('ID', '=', $id)->delete());
    }

    public function editControlVariable($id, $amount, $remarks)
    {
        return DB::table('tblstaffCV')->where('ID', '=', $id)->update([
            'amount' => $amount,
            'remarks' => $remarks,
            'last_update' => date('Y-m-d')
        ]);
    }

    public function getEarningDeductionTableContent($court, $division, $status)
    {
        if (!empty($court) && !empty($division)) {
            if ($status == 'All') {
                $list = DB::table('tblstaffEarningDeduction')
                    ->where('tblstaffEarningDeduction.courtID', $court)
                    ->where('tblstaffEarningDeduction.divisionID', $division)
                    ->leftjoin('tblearningDeductions', 'tblstaffEarningDeduction.earningDeductionID', '=', 'tblearningDeductions.ID')
                    ->leftjoin('tblper', 'tblstaffEarningDeduction.fileNo', '=', 'tblper.fileNo')
                    ->select('tblearningDeductions.description', 'tblstaffEarningDeduction.*', 'tblper.fileNo', 'tblper.surname', 'tblper.first_name', 'tblper.othernames')
                    ->orderBy('status', 'asc')
                    ->get();
                //dd($list);
                return $list;
            } else {
                $list = DB::table('tblstaffEarningDeduction')
                    ->where('tblstaffEarningDeduction.courtID', $court)
                    ->where('tblstaffEarningDeduction.divisionID', $division)
                    ->where('tblstaffEarningDeduction.status', '=', $status)
                    ->leftjoin('tblearningDeductions', 'tblstaffEarningDeduction.earningDeductionID', '=', 'tblearningDeductions.ID')
                    ->leftjoin('tblper', 'tblstaffEarningDeduction.staffid', '=', 'tblper.ID')
                    ->select('tblearningDeductions.description', 'tblstaffEarningDeduction.*', 'tblper.fileNo', 'tblper.ID', 'tblper.surname', 'tblper.first_name', 'tblper.othernames')
                    ->orderBy('status', 'asc')
                    ->get();
                //dd($list);
                return $list;
            }
        } else {
            return [];
        }
    }

    public function updateEarningDeduction($fileno, $status, $user)
    {
        $timeofaction = date('Y-m-d H:i:s');
        DB::UPDATE("UPDATE tblstaffEarningDeduction SET `status` = '$status', `approvedBy` = '$user', `actionDate` = '$timeofaction' WHERE `ID` = '$fileno'");
    }

    public function getEarningDeductionSum($staffid, $year, $month)
    {
        $res = DB::table('tblstaffEarningDeduction')
            ->where('staffid', '=', $staffid)
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->where('year', '<>', 0)
            ->where('year', '<>', '')
            ->leftjoin('tblearningDeductions', 'tblstaffEarningDeduction.earningDeductionID', '=', 'tblearningDeductions.ID')
            ->select('tblearningDeductions.description', 'tblearningDeductions.particularID', 'tblstaffEarningDeduction.*')
            ->get();
        return $res;
    }

    public function getStaffControlVariableSum($staffid, $year, $month)
    {
        $res = DB::table('tblotherEarningDeduction')
            ->where('staffid', '=', $staffid)
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->where('year', '<>', 0)
            ->where('year', '<>', '')
            ->leftjoin('tblcvSetup', 'tblotherEarningDeduction.CVID', '=', 'tblcvSetup.ID')
            ->select('tblcvSetup.description', 'tblcvSetup.particularID', 'tblotherEarningDeduction.*')
            ->get();
        return $res;
    }

    public function getEarningDeductionList()
    {
        $res = DB::table('tblcvSetup')
            ->where('status', '=', 1)
            ->get();
        return $res;
    }

    public function MonthlyEarningDeductionReportDetails($court, $division, $type, $year, $month)
    {
        //dd($court,$division,$type,$year,$month);
        $res = DB::table('tblotherEarningDeduction')
            ->where('tblotherEarningDeduction.courtID', '=', $court)
            ->where('tblotherEarningDeduction.divisionID', '=', $division)
            ->where('CVID', '=', $type)
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->leftjoin('tblper', 'tblotherEarningDeduction.staffid', '=', 'tblper.ID')
            ->orderBy('particularID', 'asc')
            ->select('tblper.fileNo', 'tblper.ID', 'tblper.first_name', 'tblper.surname', 'tblper.othernames', 'tblotherEarningDeduction.*')
            ->get();
        return $res;
    }

    public function MonthlyEarningDeductionSummary($court, $division, $type, $year, $month)
    {
        $res = DB::table('tblotherEarningDeduction')
            ->where('tblotherEarningDeduction.courtID', '=', $court)
            ->where('tblotherEarningDeduction.divisionID', '=', $division)
            ->where('tblotherEarningDeduction.particularID', '=', $type)
            ->where('tblotherEarningDeduction.year', '=', $year)
            ->where('tblotherEarningDeduction.month', '=', $month)
            ->leftjoin('tblcvSetup', 'tblotherEarningDeduction.CVID', '=', 'tblcvSetup.ID')
            ->select('tblotherEarningDeduction.*', 'tblcvSetup.description')
            ->get();
        return $res;
    }

    public function getInfo($fileno, $clause, $table)
    {
        $res = DB::table($table)
            ->where($clause, '=', $fileno)
            ->first();
        return $res;
    }

    public function getEarningDeductionList2()
    {
        $res = DB::table('tblearningDeductions')
            ->where('status', '=', 1)
            ->get();
        return $res;
    }

    public function OccasionalEarningDeductionReportDetails($court, $division, $type, $year, $month)
    {
        //dd($court, $division, $type, $year, $month);
        $res = DB::table('tblstaffEarningDeduction')
            ->where('tblstaffEarningDeduction.courtID', '=', $court)
            ->where('tblstaffEarningDeduction.divisionID', '=', $division)
            ->where('tblstaffEarningDeduction.earningDeductionID', '=', $type)
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->where('tblstaffEarningDeduction.year', '<>', "")
            ->where('tblstaffEarningDeduction.month', '<>', "")
            ->leftjoin('tblearningDeductions', 'tblstaffEarningDeduction.earningDeductionID', '=', 'tblearningDeductions.ID')
            ->leftjoin('tblper', 'tblstaffEarningDeduction.fileNo', '=', 'tblper.fileNo')
            ->orderBy('particularID', 'asc')
            ->select('tblper.fileNo', 'tblper.first_name', 'tblper.surname', 'tblper.othernames', 'tblstaffEarningDeduction.*', 'tblearningDeductions.description')
            ->get();
        //dd($res);
        return $res;
    }

    public function OccasionalEarningDeductionSummary($court, $division, $type, $year, $month)
    {
        //dd($court, $division, $type, $year, $month);
        $res = DB::table('tblstaffEarningDeduction')
            ->where('tblstaffEarningDeduction.courtID', '=', $court)
            ->where('tblstaffEarningDeduction.divisionID', '=', $division)
            ->where('tblearningDeductions.particularID', '=', $type)
            ->where('tblstaffEarningDeduction.year', '=', $year)
            ->where('tblstaffEarningDeduction.month', '=', $month)
            ->where('tblstaffEarningDeduction.year', '<>', "")
            ->where('tblstaffEarningDeduction.month', '<>', "")
            ->leftjoin('tblearningDeductions', 'tblstaffEarningDeduction.earningDeductionID', '=', 'tblearningDeductions.ID')
            ->select('tblstaffEarningDeduction.*', 'tblearningDeductions.description')
            ->get();
        return $res;
    }

    public function checkWeekends($d, $end, $value = 0)
    {
        if ($d != $end) {
            $date = date("l", $d);
            if ($date === 'Sunday' || $date === "Saturday") {
                return $this->checkWeekends($d + 86400, $end, $value);
            } else {
                $value = $value + 1;
                return $this->checkWeekends($d + 86400, $end, $value);
            }
        } else {
            return $value;
        }
    }

    public function checkReturnDay($duech, $due)
    {
        if ($duech == "Sunday" || $duech == "Saturday") {
            $due = $due + 86400 + 86400;
            $duech = date("l", $due);
            return $this->checkReturnDay($duech, $due);
        } else {
            return $due;
        }
    }
    public function getRealTableContent($fileNo, $type)
    {
        if ($type == "") {
            $res = DB::table('tblTourSlashLeave')
                ->where('fileNo', $fileNo)
                ->where('fileNo', '<>', "")
                ->get();
            return $res;
        } else {
            $res = DB::table('tblTourSlashLeave')
                ->where('fileNo', $fileNo)
                ->where('fileNo', '<>', "")
                ->where('type', $type)
                ->where('type', '<>', "")
                ->get();
            return $res;
        }
    }

    public function CourtInfo()
    {
        $List = DB::Select("SELECT * FROM `tblsole_court`");
        return $List[0];
    }
    public function EarningDeductionType()
    {
        $List = DB::Select("SELECT * FROM `tblearningParticular`");
        return $List;
    }
    public function StaffCVlist($cv)
    {
        $List = DB::Select("SELECT *
,(SELECT `fileNo` FROM `tblper` WHERE `tblper`.`ID`=`tblstaffCV`.`staffid`) as fn
, (SELECT CONCAT( `surname` , ' ', `first_name` , ' ', `othernames` )FROM `tblper` WHERE `tblper`.`ID` = `tblstaffCV`.`staffid`) AS NAMES FROM `tblstaffCV` WHERE`cvID`='$cv'
order by `tblstaffCV`.`staffid`");

        return $List;
    }
    public function StaffBackloglist()
    {
        $List = DB::Select("SELECT *
,(SELECT `fileNo` FROM `tblper` WHERE `tblper`.`ID`=`tblbacklog`.`staffid`) as fn
, (SELECT CONCAT( `surname` , ' ', `first_name` , ' ', `othernames` )FROM `tblper` WHERE `tblper`.`ID` = `tblbacklog`.`staffid`) AS NAMES FROM `tblbacklog` WHERE 1 ");

        return $List;
    }
    public function StaffOvertimeSpecial()
    {
        $List = DB::Select("SELECT *
,(SELECT `fileNo` FROM `tblper` WHERE `tblper`.`ID`=`tblspecial_overtime_overide`.`staffid`) as fn
, (SELECT CONCAT( `surname` , ' ', `first_name` , ' ', `othernames` )FROM `tblper` WHERE `tblper`.`ID` = `tblspecial_overtime_overide`.`staffid`) AS NAMES FROM `tblspecial_overtime_overide` WHERE 1 ");

        return $List;
    }
}
