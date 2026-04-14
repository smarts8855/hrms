<?php

namespace App\Http\Controllers\funds;

use DB;
use Illuminate\Http\Request;

class FundsProjectController extends function24Controller
{
    public function index(Request $request)
    {

        $data['success']       = "";
        $data['error']         = "";
        $data['Lists']         = $this->getList('tblallocation_type');
        $data['courtdivision'] = [];
        $data['getedj']        = [];

        $data['court']      = $request['court'];
        $data['division']   = $request['division'];
        $data['courtstaff'] = [];
        $data['cvdesc']     = [];
        $data['cvdesc1']    = $request['cvdesc'];
        $data['gezette']    = $request['gezette'];
        $data['startdate']  = $request['start-date'];
        $data['duedate']    = $request['due-date'];
        $data['returndate'] = $request['return-date'];
        $data['duration']   = $request['duration'];
        $data['type']       = $request['type'];
        $data['fileNo']     = $request['fileNo'];
        $data['amount']     = '';
        $data['status']     = '';

        if ($request['allocation']) {
            $allocation = trim($request['allocation']);
            $chk        = DB::table('tblallocation_type')->where('allocation', $allocation)->get();
            if (! $chk) {
                DB::table('tblallocation_type')->insert([
                    'allocation' => $allocation,
                    'status'     => 1,
                ]);
            } else {
                $data['error'] = "This allocation already exists";
            }
        }

        if ($request['edit-hidden']) {
            $id = $request['edit-hidden'];
            DB::table('tblallocation_type')->where('ID', $id)->update(['allocation' => $request['editable']]);
        }

        if ($request['deleteid']) {
            $id = $request['deleteid'];
            if (DB::table('tblallocation_type')->where('ID', $id)->update(['status' => 0])) {
                $data['success'] = "Record was deleted successfully!";
            }
        }

        if ($request['restoreid']) {
            $id = $request['restoreid'];
            if (DB::table('tblallocation_type')->where('ID', $id)->update(['status' => 1])) {
                $data['success'] = "Record was restored successfully!";
            }
        }

        $data['Lists'] = $this->getList('tblallocation_type');
        return view('FundsView.Allocate', $data);
    }

    // public function contractt(Request $request)
    // {
    //     $data['category']      = DB::table('tblcontract_category')->get();
    //     $data['success']       = "";
    //     $data['error']         = "";
    //     $data['Lists']         = $this->getList('tblcontractType');
    //     $data['courtdivision'] = [];
    //     $data['getedj']        = [];

    //     $data['court']      = $request['court'];
    //     $data['division']   = $request['division'];
    //     $data['courtstaff'] = [];
    //     $data['cvdesc']     = [];
    //     $data['cvdesc1']    = $request['cvdesc'];
    //     $data['gezette']    = $request['gezette'];
    //     $data['startdate']  = $request['start-date'];
    //     $data['duedate']    = $request['due-date'];
    //     $data['returndate'] = $request['return-date'];
    //     $data['duration']   = $request['duration'];
    //     $data['type']       = $request['type'];
    //     $data['fileNo']     = $request['fileNo'];
    //     $data['amount']     = '';
    //     $data['status']     = '';
    //     $data['categoryId'] = '';

    //     if ($request['contract']) {
    //         $contract = trim($request['contract']);
    //         $category = trim($request['category']);
    //         $chk      = DB::table('tblcontractType')->where('contractType', $contract)->get();
    //         if (! $chk) {
    //             DB::table('tblcontractType')->insert([
    //                 'contractType'      => $contract,
    //                 'contract_category' => $category,
    //                 'status'            => 1,
    //             ]);
    //         } else {
    //             $data['error'] = "This contract already exists";
    //         }
    //     }

    //     if ($request['edit-hidden']) {
    //         $id = $request['edit-hidden'];
    //         DB::table('tblcontractType')->where('ID', $id)->update(['contractType' => $request['editable'], 'contract_category' => $request['edit_category']]);
    //     }

    //     if ($request['deleteid']) {
    //         $id = $request['deleteid'];
    //         if (DB::table('tblcontractType')->where('ID', $id)->update(['status' => 0])) {
    //             $data['success'] = "Record was deleted successfully!";
    //         }
    //     }

    //     if ($request['restoreid']) {
    //         $id = $request['restoreid'];
    //         if (DB::table('tblcontractType')->where('ID', $id)->update(['status' => 1])) {
    //             $data['success'] = "Record was restored successfully!";
    //         }
    //     }

    //     $data['Lists'] = $this->getList('tblcontractType');
    //     return view('funds.FundsView.contracttype', $data);
    // }

    public function showContractType(Request $request)
    {
        $data['category']      = DB::table('tblcontract_category')->get();
        $data['Lists']         = $this->getList('tblcontractType');
        $data['success']       = "";
        $data['error']         = "";
        $data['status']        = "";
        $data['categoryId']    = "";

        return view('funds.FundsView.contracttype', $data);
    }


    public function storeContractType(Request $request)
    {
        $contract = trim($request->contract);
        $category = trim($request->category);

        if ($request->filled('contract')) {
            $chk = DB::table('tblcontractType')->where('contractType', $contract)->first();

            if ($chk) {
                return redirect()->back()->with('error', 'This contract already exists!');
            }

            DB::table('tblcontractType')->insert([
                'contractType'      => $contract,
                'contract_category' => $category,
                'status'            => 1,
            ]);

            return redirect()->back()->with('success', 'Contract type added successfully!');
        }

        if ($request->filled('edit-hidden')) {
            DB::table('tblcontractType')->where('ID', $request->input('edit-hidden'))->update([
                'contractType'      => $request->editable,
                'contract_category' => $request->edit_category,
            ]);
            return redirect()->back()->with('success', 'Contract type updated successfully!');
        }

        if ($request->filled('deleteid')) {
            DB::table('tblcontractType')->where('ID', $request->input('deleteid'))->update(['status' => 0]);
            return redirect()->back()->with('success', 'Contract type deactivate successfully!');
        }

        if ($request->filled('restoreid')) {
            DB::table('tblcontractType')->where('ID', $request->input('restoreid'))->update(['status' => 1]);
            return redirect()->back()->with('success', 'Contract type restored successfully!');
        }

        return redirect()->back()->with('error', 'No valid action detected.');
    }



    public function delete($id)
    {
        DB::table('tblTourSlashLeave')->where('id', '=', $id)->delete();
        return redirect('/tourslash/leave/' . $id);
    }

    public function ajax($start, $end)
    {

        if (strpos($start, ',') !== false) {
            $start = date('Y') . '-' . date('m') . '-' . date('d');
        }

        if (strpos($end, ',') !== false) {
            $end = date('Y') . '-' . date('m') . '-' . date('d');
        }

        $e     = explode('-', $end);
        $s     = explode('-', $start);
        $start = mktime(0, 0, 0, $s[1], $s[2], $s[0]); //$start . ' ' . $end;
        $end   = mktime(0, 0, 0, $e[1], $e[2], $e[0]);
        // echo date("Y-m-d", $start) . '/' . date("Y-m-d", $end);
        // $data['dat'] = $start . '/' . $end;
        if ($end < $start) {
            return "0000-00-00/0000-00-00/0000-00-00/0";
        } else {
            $startdaychk = date("l", mktime(0, 0, 0, $s[1], $s[2], $s[0]));
            $enddaycheck = date("l", mktime(0, 0, 0, $e[1], $e[2], $e[0]));

            if ($startdaychk == "Saturday" || $startdaychk == "Sunday") {
                return "0000-00-00/0000-00-00/0000-00-00/0";
            } elseif ($enddaycheck == "Saturday" || $enddaycheck == "Sunday") {
                return "0000-00-00/0000-00-00/0000-00-00/0";
            } else {

                $days = $this->checkWeekends($start, $end);

                //echo $end + 86400 . " ";
                //$due = date("Y-m-d", $end + 86400);
                $due    = $end + 86400;
                $duechk = date("l", $due);
                // echo $duechk . ' ';
                if ($duechk == "Saturday") {
                    $due = $due + 86400 + 86400;
                }
                $due   = date("Y-m-d", $due);
                $start = date("Y-m-d", $start);
                $end   = date("Y-m-d", $end);
                return $start . '/' . $end . '/' . $due . '/' . $days;
                //return fasview('TourSlashLeave.ajax', $data);
            }
        }
    }
}
