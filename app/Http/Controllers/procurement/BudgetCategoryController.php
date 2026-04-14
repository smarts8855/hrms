<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use App\Http\Controllers\Controller;
use Session;
use File;
use Auth;
use DB;

//Budget Items, Category and market_ survey
//Route::get('create-item',               'BudgetItemController@create')->name('createBudgetItem');


class BudgetCategoryController extends Controller
{
    public function __construct() {}


    //create item page
    public function createCategory()
    {
        $data['getBudgetCategory'] = [];
        try {
            $data['getBudgetCategory'] =  DB::table('tblcategories')->orderby('categoryID', 'desc')->get();
        } catch (\Throwable $e) {
        }

        return view('procurement.BudgetMarket.categoryView', $data);
    }

    //save item
    public function saveCategory(Request $request)
    {
        $success = null;
        $this->validate($request, [
            'category'         => 'required|max:220',
        ]);
        $recordID = $request['recordID'];
        try {
            if ($recordID) {
                $success = DB::table('tblcategories')->where('categoryID', $recordID)->update(['category' => $request['category']]);
            } else {
                $success = DB::table('tblcategories')->insertGetId(['category' => $request['category']]);
            }
        } catch (\Throwable $e) {
        }
        if ($success) {
            return redirect()->back()->with('message', 'Your record was created/updated successfully.');
        }
        return redirect()->back()->with('error', 'Sorry, we cannot create your record now. Please try again.');
    }


    //Delete category
    public function deleteCategory($categoryID = null)
    {
        $categoryID = base64_decode($categoryID);
        if ($categoryID && !DB::table('tblitems')->where('categoryID', $categoryID)->first()) {
            $success = null;
            try {
                $success = DB::table('tblcategories')->where('categoryID', $categoryID)->delete();
            } catch (\Throwable $e) {
            }
            if ($success) {
                return redirect()->back()->with('message', 'Your record was deleted successfully.');
            }
        }
        return redirect()->back()->with('error', 'Sorry, we are unable to delete your record. The record might be in used. Please try again.');
    }
}//end class
