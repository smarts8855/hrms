<?php

namespace App\Http\Controllers\funds;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ContractorController extends ParentController
{
    public function index(Request $request)
    {


        $data['error'] = "";
        $data['warning'] = "";
        $data['success'] = "";
        $contractor = trim($request['contractor']);
        $phone = trim($request['phone']);
        $address = trim($request['address']);
        $email = trim($request['email']);
        $bank = trim($request['bank']);
        $account = trim($request['account']);
        $sortcode = trim($request['sortcode']);
        $tin = trim($request['tin']);
        $id = trim($request['C_id']);
        $status = trim($request['status']);



        $data['contractorList'] = $this->getContractors();
        $data['banklist'] = $this->GetBankList(); //Pass the bank list to the data array

        if (isset($_POST['add'])) {

            $this->validate($request, [
                'contractor'          => 'required',
                'phone'                 => 'required',
            ]);

            DB::table('tblcontractor')->insert([
                'contractor' => $contractor,
                'address' => $address,
                'phoneNo' => $phone ? $phone : 0,
                'emailAddress' => $email ? $email : null,
                'Banker' => $bank ? $bank : 0,
                'AccountNo' => $account ? $account : 0,
                'sortCode' => $sortcode ? $sortcode : 0,
                'TIN' => $tin ? $tin : 0,
                'status' => 1
            ]);

            // $data['success'] = "$contractor successfully added";
            // $data['contractorList'] = $this->getContractors();
            // return view('funds.contractor.contractor', $data);
            return redirect()->back()->with('message', "$contractor successfully added");
        } else {

            if (isset($_POST['edit'])) {

                $this->validate($request, [
                    'contractor'          => 'required',
                    'phone'                 => 'required',
                ]);

                DB::table('tblcontractor')->where('id', $id)->update([
                    'contractor' => $contractor,
                    'address' => $address,
                    'phoneNo' => $phone,
                    'emailAddress' => $email,
                    'Banker' => $bank,
                    'AccountNo' => $account,
                    'sortCode' => $sortcode,
                    'TIN' => $tin,
                    'status' => $status,
                ]);

                // $data['success'] = "$contractor successfully Edited";
                // $data['contractorList'] = $this->getContractors();
                // return view('funds.contractor.contractor', $data);
                return redirect()->back()->with('message', "$contractor successfully updated");
            } elseif (isset($_POST['delete'])) {
                $id = trim($request['C_id']);
                $confirm = $this->checkContractor($id);

                if ($confirm == TRUE) {
                    $data['warning'] = "Contractor cannot be deleted";
                    $data['contractorList'] = $this->getContractors();
                    return view('funds.contractor.contractor', $data);
                } else {

                    DB::table('tblcontractor')->where('id', $id)->delete();
                    $data['success'] = "$contractor successfully Deleted";
                    $data['contractorList'] = $this->getContractors();
                    return view('funds.contractor.contractor', $data);
                }
            }
        }



        return view('funds.contractor.contractor', $data);
    }




    /********** THIS FUNCTION GETS ALL BANKS TO BE DISPLAYED ON THE LAYOUT ***************/

    public function GetBankList()
    {

        $bank = DB::table('tblbanklist')->select('bankID', 'bank')->get(); //Select all banks form database
        return $bank;
    }


    public function checkContractor($companyID)
    {

        $bank = DB::table('tblcontractDetails')
            ->select('*')
            ->where('companyID', $companyID)
            ->get(); //Select all banks form database
        return $bank;
    }


    public function getContractors()
    {

        $list = DB::table('tblcontractor')
            ->join('tblbanklist', 'tblbanklist.bankID', '=', 'tblcontractor.Banker')
            ->select('*')
            ->orderBy('status', 'asc')
            ->get();

        return $list;
    }
}
