<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Http\Controllers\Repository\ContractRepoController;
use App\Http\Controllers\Controller;
use Auth;
use DB;


class ContractCategoryController extends Controller
{
    private $contractRepoController;

    //Class Contructor
    public function __construct()
    {
        $this->middleware('auth');
        //create new object of class::ContractRepoController
        try {
            $this->contractRepoController = new ContractRepoController;
        } catch (\Throwable $e) {
            $this->contractController = [];
        }
    }



    //create contract Category
    public function createContractCategory()
    {
        try {
            //calling a function from class object
            $data['getContractCategory'] = $this->contractRepoController->setCategoryArray($status = 1);
        } catch (\Throwable $e) {
            $data['getContractCategory'] = [];
        }

        return view('procurement.ContractCategory.contractCategory', $data);
    }

    //post contract Category
    public function postContractCategoryOLD(Request $request)
    {
        $this->validate($request, [
            'categoryName'          => 'required|string|max:200',
        ]);
        //start DB insertion
        $complete = 0;
        $categoryID = $request['categoryID'];
        if (DB::table('protblcontract_category')->where('contractCategoryID', '<>', $categoryID)->where('category_name', $request['categoryName'])->first()) {
            return redirect()->route('createContractCategory')->with('error', 'Sorry, duplicate record is not allowed! This record "' . $request['categoryName'] . '" already exist.');
        }
        try {
            if ($categoryID) {
                $complete = DB::table('protblcontract_category')->where('contractCategoryID', $categoryID)->update([
                    'category_name'     => $request['categoryName'],
                    'updated_at'        => date('Y-m-d'),
                    'created_by'        => (Auth::check() ? Auth::user()->id : null),
                ]);
            } else {
                $this->validate($request, [
                    'categoryName'          => 'required|unique:tblcontract_category,category_name|string|max:200',
                ]);
                $complete = DB::table('protblcontract_category')->insertGetId([
                    'category_name'     => $request['categoryName'],
                    'created_at'        => date('Y-m-d'),
                    'updated_at'        => date('Y-m-d'),
                    'created_by'        => (Auth::check() ? Auth::user()->id : null),
                ]);
            }
        } catch (\Throwable $e) {
        }
        //return after insertion is success/fail
        if ($complete) {
            return redirect()->route('createContractCategory')->with('message', 'Your record was created/updated successfully.');
        }

        return redirect()->route('createContractCategory')->with('error', 'Sorry, we cannot create/update your record ! Please, try again.');
    }

    public function postContractCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required|string|max:200',
        ]);

        $categoryID = $request->categoryID;

        // Check duplicate except current record
        if (
            DB::table('protblcontract_category')
            ->where('contractCategoryID', '<>', $categoryID)
            ->where('category_name', $request->categoryName)
            ->exists()
        ) {
            return redirect()->route('createContractCategory')
                ->with('error', 'Duplicate record! Category "' . $request->categoryName . '" already exists.');
        }

        try {

            if ($categoryID) {

                // UPDATE
                $complete = DB::table('protblcontract_category')
                    ->where('contractCategoryID', $categoryID)
                    ->update([
                        'category_name' => $request->categoryName,
                        'updated_at'    => now(),
                        'created_by'    => Auth::id(),
                    ]);
            } else {

                // CREATE
                $this->validate($request, [
                    'categoryName' => 'required|unique:protblcontract_category,category_name|max:200',
                ]);

                $complete = DB::table('protblcontract_category')
                    ->insertGetId([
                        'category_name' => $request->categoryName,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                        'created_by'    => Auth::id(),
                    ]);
            }
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return redirect()->route('createContractCategory')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }

        return redirect()->route('createContractCategory')
            ->with('msg', 'Record created/updated successfully.');
    }



    //Delete
    public function removeContractCategory($recordID = null)
    {
        $recordID = base64_decode($recordID);

        if (($recordID != null || DB::table('protblcontract_category')->where('contractCategoryID', $recordID)->first()) &&  !DB::table('tblcontract_details')->where('contract_categoryID', $recordID)->first()) {
            if (DB::table('protblcontract_category')->where('contractCategoryID', $recordID)->delete()) {
                return redirect()->route('createContractCategory')->with('msg', 'Your record was delete successfully.');
            } else {
                return redirect()->route('createContractCategory')->with('error', 'Sorry we cannot delete this record ! Try again');
            }
        } else {
            return redirect()->route('createContractCategory')->with('error', 'Sorry we cannot delete this record ! The record is in use.');
        }
    }
}//end class
