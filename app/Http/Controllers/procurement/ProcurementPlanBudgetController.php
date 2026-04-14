<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use Session;
use File;
use PDF;
use Mail;
use App\Models\User;
use App\Mail\SubmitNeedNotice;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProcurementPlanBudgetController extends Controller
{

    //function to view list of all the biddings
    public function needsTitle()
    {

        $data['getList'] = DB::table('tblneeds_title')->get();
        return view('procurement.procurement_plan_budget.add-needs-title', $data);
    }


    public function saveNeedsTitle(Request $request)
    {
        $needs_title   =   $request->input('needs_title');
        $needs_date          =   $request->input('needs_date');

        $this->validate($request, [
            'needs_title'  => 'string|required',
            'needs_date'   => 'date'
        ]);

        DB::table('tblneeds_title')->insert(['title' => $needs_title, 'date' => $needs_date]);

        return back()->with('msg', 'Successfully added!');
    }

    public function deleteNeedsTitle($id)
    {
        if (DB::table('tblneed_assessment')->where('needs_titleID', base64_decode($id))->exists()) {
            return back()->with('error', 'Cannot delete. Record is in used!');
        }
        DB::table('tblneeds_title')->where('needs_titleID', base64_decode($id))->delete();

        return back()->with('msg', 'Successfully deleted!');
    }

    public function deleteNeeds($id)
    {
        DB::table('tblneed_assessment')->where('needsID', base64_decode($id))->delete();

        return back()->with('msg', 'Successfully deleted!');
    }

    public function openNeedsTitle($id)
    {

        DB::table('tblneeds_title')->where('needs_titleID', base64_decode($id))->update(['status' => 1]);

        return back()->with('msg', 'Successfully open!');
    }

    public function closeNeedsTitle($id)
    {

        DB::table('tblneeds_title')->where('needs_titleID', base64_decode($id))->update(['status' => 0]);

        return back()->with('msg', 'Successfully close!');
    }

    public function updateNeedsTitle(Request $request)
    {
        $request->validate([
            'needs_title' => 'required|string|max:255',
            'needs_date' => 'required|date',
            'id' => 'required|exists:tblneeds_title,needs_titleID'
        ]);

        try {
            DB::table('tblneeds_title')
                ->where('needs_titleID', $request->input('id'))
                ->update([
                    'title' => $request->input('needs_title'),
                    'date' => $request->input('needs_date'),
                ]);

            return back()->with('msg', 'Successfully updated');
        } catch (\Exception $e) {
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    //view needs assessment from the departments
    public function viewNeedsAssessment()
    {

        $data['getList'] = DB::table('tblneeds_title')->get();

        return view('procurement.procurement_plan_budget.view_needs_assessment', $data);
    }

    public function categorisedNeedsAssessment($id)
    {
        //dd(base64_decode($id));
        $data['title'] = DB::table('tblneeds_title')->where('needs_titleID', base64_decode($id))->first();

        $data['categoryList'] = DB::table('tblcategories')->get();
        $data['item'] = DB::table('tblitems')->get();
        $data['id'] = base64_decode($id);

        $data['getList'] = DB::table('tblneed_assessment')
            ->where('needs_titleID', base64_decode($id))
            //->join('role','tblneed_assessment.departmentID','=','role.roleID')
            // ->leftjoin('tblunits', 'tblunits.unitID', '=', 'tblneed_assessment.departmentID')
            ->leftjoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
            ->groupBy('tblneed_assessment.departmentID')

            ->get();
        // dd($data['getList']);
        return view('procurement.procurement_plan_budget.categorised_needs_assessment', $data);
    }

    public function viewDepartmentalNeeds($id)
    {
        //dd($request->all());
        $data['categoryList'] = DB::table('tblcategories')->get();
        $data['itemList'] = DB::table('tblitems')->get();

        $data['getList'] = DB::table('tblneed_assessment')
            ->where('departmentID', base64_decode($id))
            ->join('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftjoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
            ->select(
                '*',
                'tblcategories.categoryID',
                'tblcategories.category',
                'tblitems.itemID',
                'tblitems.item',
            )
            ->get();
        //dd($data['getList']);
        return view('procurement.procurement_plan_budget.submitted_needs', $data);
    }

    //submit needs by department
    public function submitNeeds()
    {
        $data['getList'] = DB::table('tblneeds_title')->where('status', 1)->get();

        //dd($data['getList']);
        return view('procurement.procurement_plan_budget.add_needs_bydepartments', $data);
    }

    public function submitNeedsAssessment_19_02_2026($id)
    {
        $data['title'] = DB::table('tblneeds_title')->where('needs_titleID', base64_decode($id))->first();
        $data['categoryList'] = DB::table('tblcategories')->get();
        $data['itemList'] = DB::table('tblitems')->get();
        $data['id'] = base64_decode($id);

        // $data['loggedInUser'] = Auth::user()->id;

        // $data['userUnit'] = DB::table('tblper')
        //     ->join('tbldepartment', 'tblper.departmentID', '=', 'tbldepartment.id')
        //     // ->join('tbldepartment', 'users.user_unit', '=', 'tbldepartment.id')
        //     ->where('tblper.UserID', Auth::user()->id)
        //     // ->join('tblunits', 'users.user_unit', '=', 'tblunits.unitID')
        //     ->first();

        dd(
            Auth::user()->id,
            DB::table('tblper')->where('UserID', Auth::user()->id)->first()
        );


        $data['userUnit'] = DB::table('tblper')
            ->where('tblper.UserID', Auth::user()->id)
            ->join('tbldepartment', 'tblper.departmentID', '=', 'tbldepartment.id')
            ->select(
                'tblper.*',
                'tbldepartment.department as department_name',
                'tbldepartment.id as department_id'
            )
            ->first();


        // dd($data['userUnit']);

        // $data['getList'] = DB::table('tblneed_assessment')
        //     ->where('departmentID', Auth::user()->user_unit)
        //     ->where('needs_titleID', base64_decode($id))
        //     ->leftjoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
        //     ->leftjoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
        //     ->select(
        //         '*',
        //         'tblcategories.categoryID',
        //         'tblcategories.category',
        //         'tblitems.itemID',
        //         'tblitems.item',
        //     )
        //     ->get();

        $data['getList'] = DB::table('tblneed_assessment')
            ->where('tblneed_assessment.departmentID', $per->departmentID)
            ->where('tblneed_assessment.needs_titleID', base64_decode($id))

            // Join the department table
            ->leftJoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')

            // Join the categories and items
            ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')

            ->select(
                'tblneed_assessment.*',
                'tbldepartment.department as department_name',
                'tblcategories.category',
                'tblitems.item'
            )
            ->get();

        //dd($data);
        return view('procurement.procurement_plan_budget.submit-needs', $data);
    }

    public function submitNeedsAssessment1($id)
    {
        $decodedId = base64_decode($id);

        // Basic info
        $data['title']         = DB::table('tblneeds_title')->where('needs_titleID', $decodedId)->first();
        $data['categoryList']  = DB::table('tblcategories')->get();
        $data['itemList']      = DB::table('tblitems')->get();
        $data['id']            = $decodedId;

        // ============================
        // 1. GET CURRENT USER WITH is_global STATUS FROM USERS TABLE
        // ============================
        $currentUser = Auth::user();
        
        // Get is_global status from users table
        $userGlobalStatus = DB::table('users')
            ->where('id', $currentUser->id)
            ->value('is_global');
        
        $data['is_global'] = $userGlobalStatus;

        // ============================
        // 2. GET USER PERMISSIONS/DEPARTMENT FROM tblper
        // ============================
        $per = DB::table('tblper')
            ->where('UserID', $currentUser->id)
            ->first();

        // ============================
        // 3. HANDLE DEPARTMENT BASED ON is_global AND tblper RECORD
        // ============================
        
        // Initialize userUnit as null
        $data['userUnit'] = null;
        $data['selectedDepartmentId'] = null;
        
        if ($userGlobalStatus == 1) {
            // Global user - we'll show department dropdown in the view
            // No need to fetch specific department
            $data['userUnit'] = (object)[
                'department_name' => 'Select Department Below',
                'has_department' => false
            ];
            
            // For global users, we don't filter by department in getList initially
            // You might want to show all or none initially
            $departmentFilter = null;
        } else {
            // Non-global user - must have department in tblper
            if ($per) {
                $data['userUnit'] = DB::table('tblper')
                    ->join('tbldepartment', 'tblper.departmentID', '=', 'tbldepartment.id')
                    ->where('tblper.UserID', $currentUser->id)
                    ->select(
                        'tblper.*',
                        'tbldepartment.department as department_name',
                        'tbldepartment.id as department_id'
                    )
                    ->first();
                
                $departmentFilter = $per->departmentID;
            } else {
                // User has no department record in tblper
                $data['userUnit'] = (object)[
                    'department_name' => 'No department assigned',
                    'has_department' => false
                ];
                $departmentFilter = null;
            }
        }

        // ============================
        // 4. GET NEED ASSESSMENT LIST (with conditional department filter)
        // ============================
        $query = DB::table('tblneed_assessment')
            ->where('tblneed_assessment.needs_titleID', $decodedId)
            ->leftJoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
            ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
            ->select(
                'tblneed_assessment.*',
                'tbldepartment.department as department_name',
                'tblcategories.category',
                'tblitems.item'
            );
        
        // Apply department filter only for non-global users with department
        if ($userGlobalStatus == 0 && $departmentFilter) {
            $query->where('tblneed_assessment.departmentID', $departmentFilter);
        }
        
        $data['getList'] = $query->get();
        
        // ============================
        // 5. GET ALL DEPARTMENTS FOR GLOBAL USER DROPDOWN
        // ============================
        if ($userGlobalStatus == 1) {
            $data['departments'] = DB::table('tbldepartment')->get();
        }

        return view('procurement.procurement_plan_budget.submit-needs', $data);
    }

    public function submitNeedsAssessment2($id)
    {
        $decodedId = base64_decode($id);

        // Basic info
        $data['title']         = DB::table('tblneeds_title')->where('needs_titleID', $decodedId)->first();
        $data['categoryList']  = DB::table('tblcategories')->get();
        $data['itemList']      = DB::table('tblitems')->get();
        $data['id']            = $decodedId;

        // ============================
        // 1. GET CURRENT USER WITH is_global STATUS FROM USERS TABLE
        // ============================
        $currentUser = Auth::user();
        
        // Get is_global status from users table
        $userGlobalStatus = DB::table('users')
            ->where('id', $currentUser->id)
            ->value('is_global');
        
        $data['is_global'] = $userGlobalStatus;

        // ============================
        // 2. GET USER PERMISSIONS/DEPARTMENT FROM tblper
        // ============================
        $per = DB::table('tblper')
            ->where('UserID', $currentUser->id)
            ->first();

        // ============================
        // 3. HANDLE DEPARTMENT BASED ON is_global AND tblper RECORD
        // ============================
        
        // Initialize userUnit as null
        $data['userUnit'] = null;
        $data['selectedDepartmentId'] = null;
        
        if ($userGlobalStatus == 1) {
            // Global user - we'll show department dropdown in the view
            // No need to fetch specific department
            $data['userUnit'] = (object)[
                'department_name' => 'Select Department Below',
                'has_department' => false
            ];
            
            // For global users, we don't filter by department in getList initially
            // You might want to show all or none initially
            $departmentFilter = null;
        } else {
            // Non-global user - must have department in tblper
            if ($per) {
                $data['userUnit'] = DB::table('tblper')
                    ->join('tbldepartment', 'tblper.departmentID', '=', 'tbldepartment.id')
                    ->where('tblper.UserID', $currentUser->id)
                    ->select(
                        'tblper.*',
                        'tbldepartment.department as department_name',
                        'tbldepartment.id as department_id'
                    )
                    ->first();
                
                $departmentFilter = $per->departmentID;
            } else {
                // User has no department record in tblper
                $data['userUnit'] = (object)[
                    'department_name' => 'No department assigned',
                    'has_department' => false
                ];
                $departmentFilter = null;
            }
        }

        // ============================
        // 4. GET NEED ASSESSMENT LIST (with conditional department filter)
        // ============================
        $query = DB::table('tblneed_assessment')
            ->where('tblneed_assessment.needs_titleID', $decodedId)
            ->leftJoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
            ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
            ->select(
                'tblneed_assessment.*',
                'tbldepartment.department as department_name',
                'tblcategories.category',
                'tblitems.item'
            );
        
        // Apply department filter only for non-global users with department
        if ($userGlobalStatus == 0 && $departmentFilter) {
            $query->where('tblneed_assessment.departmentID', $departmentFilter);
        }
        
        $data['getList'] = $query->get();
        
        // ============================
        // 5. GET ALL DEPARTMENTS FOR GLOBAL USER DROPDOWN
        // ============================
        if ($userGlobalStatus == 1) {
            $data['departments'] = DB::table('tbldepartment')->get();
        }

        // ============================
        // 6. GET ALL SPECIFICATIONS FOR AUTOMATIC LOADING
        // ============================
        $data['allSpecifications'] = DB::table('tblspecifications')->get();

        return view('procurement.procurement_plan_budget.submit-needs', $data);
    }

    public function submitNeedsAssessment3($id)
{
    $decodedId = base64_decode($id);

    // Basic info
    $data['title']         = DB::table('tblneeds_title')->where('needs_titleID', $decodedId)->first();
    $data['categoryList']  = DB::table('tblcategories')->get();
    $data['itemList']      = DB::table('tblitems')->get();
    $data['id']            = $decodedId;

    // ============================
    // 1. GET CURRENT USER WITH is_global STATUS FROM USERS TABLE
    // ============================
    $currentUser = Auth::user();
    
    // Get is_global status from users table
    $userGlobalStatus = DB::table('users')
        ->where('id', $currentUser->id)
        ->value('is_global');
    
    $data['is_global'] = $userGlobalStatus;

    // ============================
    // 2. GET USER PERMISSIONS/DEPARTMENT FROM tblper
    // ============================
    $per = DB::table('tblper')
        ->where('UserID', $currentUser->id)
        ->first();

    // ============================
    // 3. HANDLE DEPARTMENT BASED ON is_global AND tblper RECORD
    // ============================
    
    // Initialize userUnit as null
    $data['userUnit'] = null;
    $data['selectedDepartmentId'] = null;
    $data['userDepartmentId'] = null;
    
    if ($userGlobalStatus == 1) {
        // Global user - we'll show department dropdown in the view
        $data['userUnit'] = (object)[
            'department_name' => 'Select Department Below',
            'has_department' => false
        ];
        
        // For global users, we don't filter by department in getList initially
        $departmentFilter = null;
    } else {
        // Non-global user - must have department in tblper
        if ($per) {
            $data['userUnit'] = DB::table('tblper')
                ->join('tbldepartment', 'tblper.departmentID', '=', 'tbldepartment.id')
                ->where('tblper.UserID', $currentUser->id)
                ->select(
                    'tblper.*',
                    'tbldepartment.department as department_name',
                    'tbldepartment.id as department_id'
                )
                ->first();
            
            $departmentFilter = $per->departmentID;
            $data['userDepartmentId'] = $per->departmentID;
        } else {
            // User has no department record in tblper
            $data['userUnit'] = (object)[
                'department_name' => 'No department assigned',
                'has_department' => false
            ];
            $departmentFilter = null;
        }
    }

    // ============================
    // 4. GET ALL EXISTING ITEMS PER DEPARTMENT FOR UNIQUENESS CHECK
    // ============================
    $existingItemsByDepartment = [];
    
    if ($userGlobalStatus == 1) {
        // For global users, get all existing items grouped by department
        $allExisting = DB::table('tblneed_assessment')
            ->where('needs_titleID', $decodedId)
            ->select('departmentID', 'itemID', 'categoryID')
            ->get();
        
        foreach ($allExisting as $record) {
            if (!isset($existingItemsByDepartment[$record->departmentID])) {
                $existingItemsByDepartment[$record->departmentID] = [];
            }
            $existingItemsByDepartment[$record->departmentID][$record->itemID] = $record->categoryID;
        }
    } else {
        // For regular users, get existing items for their department
        if ($departmentFilter) {
            $existingForDept = DB::table('tblneed_assessment')
                ->where('needs_titleID', $decodedId)
                ->where('departmentID', $departmentFilter)
                ->select('itemID', 'categoryID')
                ->get();
            
            foreach ($existingForDept as $record) {
                $existingItemsByDepartment[$departmentFilter][$record->itemID] = $record->categoryID;
            }
        }
    }
    
    $data['existingItemsByDepartment'] = $existingItemsByDepartment;

    // ============================
    // 5. GET NEED ASSESSMENT LIST (with conditional department filter)
    // ============================
    $query = DB::table('tblneed_assessment')
        ->where('tblneed_assessment.needs_titleID', $decodedId)
        ->leftJoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
        ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
        ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
        ->select(
            'tblneed_assessment.*',
            'tbldepartment.department as department_name',
            'tblcategories.category',
            'tblitems.item'
        );
    
    // Apply department filter only for non-global users with department
    if ($userGlobalStatus == 0 && $departmentFilter) {
        $query->where('tblneed_assessment.departmentID', $departmentFilter);
    }
    
    $data['getList'] = $query->get();
    
    // ============================
    // 6. GET ALL DEPARTMENTS FOR GLOBAL USER DROPDOWN
    // ============================
    if ($userGlobalStatus == 1) {
        $data['departments'] = DB::table('tbldepartment')->get();
    }

    // ============================
    // 7. GET ALL SPECIFICATIONS FOR AUTOMATIC LOADING
    // ============================
    $data['allSpecifications'] = DB::table('tblspecifications')->get();

    return view('procurement.procurement_plan_budget.submit-needs', $data);
}

public function submitNeedsAssessment($id)
{
    $decodedId = base64_decode($id);

    // Basic info
    $data['title']         = DB::table('tblneeds_title')->where('needs_titleID', $decodedId)->first();
    $data['categoryList']  = DB::table('tblcategories')->get();
    $data['itemList']      = DB::table('tblitems')->get();
    $data['id']            = $decodedId;

    // ============================
    // 1. GET CURRENT USER WITH is_global STATUS FROM USERS TABLE
    // ============================
    $currentUser = Auth::user();
    
    // Get is_global status from users table
    $userGlobalStatus = DB::table('users')
        ->where('id', $currentUser->id)
        ->value('is_global');
    
    $data['is_global'] = $userGlobalStatus;

    // ============================
    // 2. GET USER PERMISSIONS/DEPARTMENT FROM tblper
    // ============================
    $per = DB::table('tblper')
        ->where('UserID', $currentUser->id)
        ->first();

    // ============================
    // 3. HANDLE DEPARTMENT BASED ON is_global AND tblper RECORD
    // ============================
    
    // Initialize userUnit as null
    $data['userUnit'] = null;
    $data['selectedDepartmentId'] = null;
    $data['userDepartmentId'] = null;
    
    if ($userGlobalStatus == 1) {
        // Global user - we'll show department dropdown in the view
        $data['userUnit'] = (object)[
            'department_name' => 'Select Department Below',
            'has_department' => false
        ];
        
        // For global users, we don't filter by department in getList initially
        $departmentFilter = null;
    } else {
        // Non-global user - must have department in tblper
        if ($per) {
            $data['userUnit'] = DB::table('tblper')
                ->join('tbldepartment', 'tblper.departmentID', '=', 'tbldepartment.id')
                ->where('tblper.UserID', $currentUser->id)
                ->select(
                    'tblper.*',
                    'tbldepartment.department as department_name',
                    'tbldepartment.id as department_id'
                )
                ->first();
            
            $departmentFilter = $per->departmentID;
            $data['userDepartmentId'] = $per->departmentID;
        } else {
            // User has no department record in tblper
            $data['userUnit'] = (object)[
                'department_name' => 'No department assigned',
                'has_department' => false
            ];
            $departmentFilter = null;
        }
    }

    // ============================
    // 4. GET ALL EXISTING ITEMS PER DEPARTMENT FOR UNIQUENESS CHECK
    // ============================
    $existingItemsByDepartment = [];
    
    if ($userGlobalStatus == 1) {
        // For global users, get all existing items grouped by department
        $allExisting = DB::table('tblneed_assessment')
            ->where('needs_titleID', $decodedId)
            ->whereNotNull('itemID') // Only items, not services
            ->select('departmentID', 'itemID', 'categoryID')
            ->distinct('itemID') // Get unique items per department
            ->get();
        
        foreach ($allExisting as $record) {
            if (!isset($existingItemsByDepartment[$record->departmentID])) {
                $existingItemsByDepartment[$record->departmentID] = [];
            }
            $existingItemsByDepartment[$record->departmentID][$record->itemID] = $record->categoryID;
        }
    } else {
        // For regular users, get existing items for their department
        if ($departmentFilter) {
            $existingForDept = DB::table('tblneed_assessment')
                ->where('needs_titleID', $decodedId)
                ->where('departmentID', $departmentFilter)
                ->whereNotNull('itemID')
                ->select('itemID', 'categoryID')
                ->distinct('itemID')
                ->get();
            
            foreach ($existingForDept as $record) {
                $existingItemsByDepartment[$departmentFilter][$record->itemID] = $record->categoryID;
            }
        }
    }
    
    $data['existingItemsByDepartment'] = $existingItemsByDepartment;

    // ============================
    // 5. GET NEED ASSESSMENT LIST (grouped by item for display)
    // ============================
    $query = DB::table('tblneed_assessment')
        ->where('tblneed_assessment.needs_titleID', $decodedId)
        ->leftJoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
        ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
        ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
        ->leftJoin('tblspecifications', 'tblneed_assessment.specificationID', '=', 'tblspecifications.specificationID')
        ->select(
            'tblneed_assessment.*',
            'tbldepartment.department as department_name',
            'tblcategories.category',
            'tblitems.item',
            'tblspecifications.specification'
        )
        ->orderBy('tblneed_assessment.created_at', 'desc');
    
    // Apply department filter only for non-global users with department
    if ($userGlobalStatus == 0 && $departmentFilter) {
        $query->where('tblneed_assessment.departmentID', $departmentFilter);
    }
    
    $allRecords = $query->get();
    
    // Group records by item for display (like in tblmarket_survey)
    $groupedList = [];
    foreach ($allRecords as $record) {
        if ($record->categoryID == 5) {
            // Services - show as individual records
            $groupedList[] = $record;
        } else {
            // Items with specifications - group by itemID
            $key = $record->itemID . '_' . $record->departmentID;
            
            if (!isset($groupedList[$key])) {
                $groupedList[$key] = (object)[
                    'needsID' => $record->needsID,
                    'categoryID' => $record->categoryID,
                    'category' => $record->category,
                    'itemID' => $record->itemID,
                    'item' => $record->item,
                    'departmentID' => $record->departmentID,
                    'department_name' => $record->department_name,
                    'quantity' => $record->quantity,
                    'brief_justification' => $record->brief_justification,
                    'specifications' => [],
                    'specification_ids' => []
                ];
            }
            
            // Add specification to the group
            if ($record->specification) {
                $groupedList[$key]->specifications[] = $record->specification;
                $groupedList[$key]->specification_ids[] = $record->specificationID;
            }
        }
    }
    
    // Convert to indexed array for display
    $data['getList'] = array_values($groupedList);
    
    // ============================
    // 6. GET ALL DEPARTMENTS FOR GLOBAL USER DROPDOWN
    // ============================
    if ($userGlobalStatus == 1) {
        $data['departments'] = DB::table('tbldepartment')->get();
    }

    // ============================
    // 7. GET ALL SPECIFICATIONS FOR AUTOMATIC LOADING
    // ============================
    $data['allSpecifications'] = DB::table('tblspecifications')->get();

    return view('procurement.procurement_plan_budget.submit-needs', $data);
}

    public function  getItemFromCategory(Request $request)
    {

        $data = DB::table('tblitems')->where('categoryID', $request->get('category_id'))->get();

        return response()->json($data);
    }

    public function  saveNeedsAssessmentOLD(Request $request)
    {
        //dd($request->all());
        $category   =   $request->input('category');
        $item       =   $request->input('item');
        $description =   $request->input('description');
        $brief_justification =   $request->input('brief_justification');
        $quantity   =   $request->input('quantity');
        $other_item =   $request->input('other_item');

        $this->validate($request, [
            'category'  => 'required',

        ]);

        if ($other_item != null) {

            $this->validate($request, [

                'category'  => 'required',
                'other_item'  => 'string|required',

            ]);

            $getItemId = DB::table('tblitems')->insertGetId([
                'categoryID' => $category,
                'item'       => $other_item,
            ]);



            DB::table('tblneed_assessment')->insert([
                'needs_titleID' => $request->input('titleID'),
                'departmentID' => Auth::user()->user_unit,
                'categoryID'   => $category,
                'itemID'       => $getItemId,
                'quantity'     => $quantity,
                'description' => $description,
                'brief_justification' => $brief_justification,
            ]);
        } else {

            if (
                $category != 5 && DB::table('tblneed_assessment')->where('needs_titleID', $request->titleID)
                ->where('itemID', $item)
                ->where('departmentID', Auth::user()->user_unit)
                ->exists()
            ) {
                return back()->with('error', 'Item exists!');
            }

            if ($category == 5) {
                DB::table('tblneed_assessment')->insert([
                    'needs_titleID' => $request->input('titleID'),
                    'departmentID' => Auth::user()->user_unit,
                    'categoryID'   => $category,
                    'itemID'       => null,
                    'quantity'     => null,
                    'description' => $description,
                    'brief_justification' => $brief_justification,
                ]);
            } else {
                DB::table('tblneed_assessment')->insert([

                    'needs_titleID' => $request->input('titleID'),
                    'departmentID' => Auth::user()->user_unit,
                    'categoryID' => $category,
                    'itemID' => $item,
                    'quantity' => $quantity,
                    'description' => $description,
                    'brief_justification' => $brief_justification,
                ]);
            }
            return back()->with('msg', 'Successfully added!');
        }

        return back()->with('msg', 'Successfully added!');
    }

    public function saveNeedsAssessment_19_02_2026(Request $request)
    {
        // Allow only user_role = 12
        // if (Auth::user()->user_role != 12) {
        //     return back()->with('error', 'You are not allowed to submit needs.');
        // }

        $category           = $request->input('category');
        $item               = $request->input('item');
        $description        = $request->input('description');
        $brief_justification = $request->input('brief_justification');
        $quantity           = $request->input('quantity');
        $other_item         = $request->input('other_item');

        $this->validate($request, [
            'category' => 'required',
        ]);

        if ($other_item != null) {

            $this->validate($request, [
                'category'   => 'required',
                'other_item' => 'string|required',
            ]);

            $getItemId = DB::table('tblitems')->insertGetId([
                'categoryID' => $category,
                'item'       => $other_item,
            ]);

            $per = DB::table('tblper')
                ->where('UserID', Auth::user()->id)
                ->first();

            DB::table('tblneed_assessment')->insert([
                'needs_titleID'       => $request->input('titleID'),
                // 'departmentID'        => Auth::user()->user_unit,
                'departmentID'        => $per->departmentID,
                'categoryID'          => $category,
                'itemID'              => $getItemId,
                'quantity'            => $quantity,
                'description'         => $description,
                'brief_justification' => $brief_justification,
            ]);

            return back()->with('msg', 'Successfully added!');
        }


        if (
            $category != 5 &&
            DB::table('tblneed_assessment')
            ->where('needs_titleID', $request->titleID)
            ->where('itemID', $item)
            ->where('departmentID', $per->departmentID)
            ->exists()
        ) {
            return back()->with('error', 'Item exists!');
        }

        if ($category == 5) {
            DB::table('tblneed_assessment')->insert([
                'needs_titleID'       => $request->input('titleID'),
                'departmentID'        => $per->departmentID,
                'categoryID'          => $category,
                'itemID'              => null,
                'quantity'            => null,
                'description'         => $description,
                'brief_justification' => $brief_justification,
            ]);
        } else {
            DB::table('tblneed_assessment')->insert([
                'needs_titleID'       => $request->input('titleID'),
                'departmentID'        => $per->departmentID,
                'categoryID'          => $category,
                'itemID'              => $item,
                'quantity'            => $quantity,
                'description'         => $description,
                'brief_justification' => $brief_justification,
            ]);
        }

        return back()->with('msg', 'Successfully added!');
    }

    public function saveNeedsAssessment01(Request $request)
    {
        // ============================
        // 1. VALIDATION
        // ============================
        $this->validate($request, [
            'category' => 'required'
        ]);

        $category            = $request->input('category');
        $item                = $request->input('item');
        $description         = $request->input('description');
        $brief_justification = $request->input('brief_justification');
        $quantity            = $request->input('quantity');
        $other_item          = $request->input('other_item');

        // ============================
        // 2. GET CURRENT USER AND CHECK GLOBAL STATUS
        // ============================
        $currentUser = Auth::user();
        
        // Check if user is global from users table
        $userGlobalStatus = DB::table('users')
            ->where('id', $currentUser->id)
            ->value('is_global');

        // ============================
        // 3. GET DEPARTMENT ID BASED ON USER TYPE
        // ============================
        $departmentID = null;
        
        if ($userGlobalStatus == 1) {
            // Global user - must select department from form
            if (!$request->department) {
                return back()->with('error', 'Please select a department for this need.')->withInput();
            }
            $departmentID = $request->department;
        } else {
            // Non-global user - get department from tblper
            $per = DB::table('tblper')
                ->where('UserID', $currentUser->id)
                ->first();

            if (!$per) {
                return back()->with('error', 'User does not exist in tblper table.');
            }
            $departmentID = $per->departmentID;
        }

        // ============================
        // 4. IF USER ENTERED A CUSTOM "OTHER ITEM"
        // ============================
        if (!empty($other_item)) {

            $this->validate($request, [
                'other_item' => 'required|string',
            ]);

            // Insert new item into items table
            $getItemId = DB::table('tblitems')->insertGetId([
                'categoryID' => $category,
                'item'       => $other_item
            ]);

            // Insert needs assessment
            DB::table('tblneed_assessment')->insert([
                'needs_titleID'       => $request->input('titleID'),
                'departmentID'        => $departmentID,
                'categoryID'          => $category,
                'itemID'              => $getItemId,
                'quantity'            => $quantity,
                'description'         => $description,
                'brief_justification' => $brief_justification,
            ]);

            return back()->with('msg', 'Successfully added!');
        }

        // ============================
        // 5. PREVENT DUPLICATE ENTRIES (only for non-global or if we have department)
        // ============================
        if ($category != 5 && $departmentID) {
            $exists = DB::table('tblneed_assessment')
                ->where('needs_titleID', $request->titleID)
                ->where('itemID', $item)
                ->where('departmentID', $departmentID)
                ->exists();
                
            if ($exists) {
                return back()->with('error', 'Item already exists!');
            }
        }

        // ============================
        // 6. INSERT RECORD BASED ON CATEGORY TYPE
        // ============================
        if ($category == 5) {
            // Category 5: no item or quantity
            DB::table('tblneed_assessment')->insert([
                'needs_titleID'       => $request->input('titleID'),
                'departmentID'        => $departmentID,
                'categoryID'          => $category,
                'itemID'              => null,
                'quantity'            => null,
                'description'         => $description,
                'brief_justification' => $brief_justification,
            ]);
        } else {
            // Normal category
            DB::table('tblneed_assessment')->insert([
                'needs_titleID'       => $request->input('titleID'),
                'departmentID'        => $departmentID,
                'categoryID'          => $category,
                'itemID'              => $item,
                'quantity'            => $quantity,
                'description'         => $description,
                'brief_justification' => $brief_justification,
            ]);
        }

        return back()->with('msg', 'Successfully added!');
    }

    public function saveNeedsAssessment2(Request $request)
    {
        try {
            // Get all input
            $input = $request->all();
            
            // Prepare base data WITHOUT created_at and updated_at
            $data = [
                'needs_titleID' => $input['titleID'],
                'categoryID' => $input['category'],
                'itemID' => $input['item'] ?? null,
                'quantity' => $input['quantity'],
                'brief_justification' => $input['brief_justification']
            ];

            // Handle specifications
            if (isset($input['specifications']) && !empty($input['specifications']) && $input['specifications'] != '[]') {
                $data['specifications'] = $input['specifications']; // Store as JSON string
                $data['description'] = null;
            } else {
                $data['description'] = $input['description'] ?? null;
                $data['specifications'] = null;
            }

            // Handle department
            if (Auth::user()->is_global == 1) {
                $data['departmentID'] = $input['department'] ?? null;
            } else {
                $per = DB::table('tblper')->where('UserID', Auth::user()->id)->first();
                $data['departmentID'] = $per->departmentID ?? null;
            }

            // Debug: Uncomment to see exactly what's being inserted
            // dd($data);

            // Insert
            DB::table('tblneed_assessment')->insert($data);

            return redirect()->back()->with('msg', 'Saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving record: ' . $e->getMessage());
        }
    }


    public function saveNeedsAssessment(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Get all input
            $input = $request->all();
            
            // Handle department
            $departmentID = null;
            if (Auth::user()->is_global == 1) {
                $departmentID = $input['department'] ?? null;
            } else {
                $per = DB::table('tblper')->where('UserID', Auth::user()->id)->first();
                $departmentID = $per->departmentID ?? null;
            }

            // Check if this is a service (category 5) or regular item
            if ($input['category'] == 5) {
                // SERVICES CATEGORY - Insert single row with description
                DB::table('tblneed_assessment')->insert([
                    'needs_titleID' => $input['titleID'],
                    'categoryID' => $input['category'],
                    'itemID' => null, // No item for services
                    'description' => $input['description'] ?? null,
                    'specificationID' => null, // No specification ID
                    'quantity' => $input['quantity'],
                    'brief_justification' => $input['brief_justification'],
                    'departmentID' => $departmentID,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                $message = 'Service needs assessment saved successfully!';
            } else {
                // REGULAR ITEMS WITH SPECIFICATIONS - Insert multiple rows (one per specification)
                $itemID = $input['item'];
                $specIds = isset($input['specification_ids']) ? explode(',', $input['specification_ids']) : [];
                
                if (empty($specIds)) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'No specifications selected for this item.');
                }
                
                // Insert one row per specification (like tblmarket_survey)
                foreach ($specIds as $specId) {
                    if (!empty($specId)) {
                        DB::table('tblneed_assessment')->insert([
                            'needs_titleID' => $input['titleID'],
                            'categoryID' => $input['category'],
                            'itemID' => $itemID,
                            'specificationID' => $specId, // Store as INT
                            'description' => null,
                            'quantity' => $input['quantity'],
                            'brief_justification' => $input['brief_justification'],
                            'departmentID' => $departmentID,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
                
                $message = count($specIds) . ' specification(s) saved successfully!';
            }

            DB::commit();
            return redirect()->back()->with('msg', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error saving record: ' . $e->getMessage());
        }
    }

    public function  updateNeedsAssessment01(Request $request)
    {


        $category   =   $request->input('category');
        $item       =   $request->input('item');
        $description =   $request->input('description');
        $brief_justification =   $request->input('brief_justification');
        $quantity   =   $request->input('quantity');
        //$other_item =   $request->input('other_item');

        // $this->validate($request, [
        //     'category'  =>'required',

        // ]);

        // if($other_item!=null) {

        //     $this->validate($request, [

        //     'category'  =>'required',
        //     'other_item'  =>'string|required',

        //     ]);

        //     $getItemId = DB::table('tblitems')->insertGetId([
        //     'categoryID' => $category,
        //     'item'       => $other_item,
        //     ]);

        //     DB::table('tblneed_assessment')->insert([

        //     'needs_titleID'=> $request->input('titleID'),
        //     'departmentID' => Auth::user()->user_role,
        //     'categoryID'   => $category,
        //     'itemID'       => $getItemId,
        //     'quantity'     => $quantity,

        //     ]);

        // }else {

        //if(DB::table('tblneed_assessment')->where('itemID',$item)->exists()){return back()->with('error','Item exists!');}

        if ($category == 5) {
            DB::table('tblneed_assessment')
                ->where('needsID', $request->input('id'))
                ->update([
                    'categoryID' => $category,
                    'itemID' => null,
                    'quantity' => null,
                    'description' => $description,
                    'brief_justification' => $brief_justification,
                ]);
        } else {
            DB::table('tblneed_assessment')
                ->where('needsID', $request->input('id'))
                ->update([
                    'categoryID' => $category,
                    'itemID' => $item,
                    'quantity' => $quantity,
                    'description' => $description,
                    'brief_justification' => $brief_justification,
                ]);
            //}

        }
        return back()->with('msg', 'Successfully updated!');
    }

    public function updateNeedsAssessment1(Request $request)
    {
        try {
            $needsID = $request->input('id');
            
            $data = [
                'categoryID' => $request->input('category'),
                'itemID' => $request->input('item'),
                'quantity' => $request->input('quantity'),
                'brief_justification' => $request->input('brief_justification')
            ];

            // Handle specifications or description
            $specifications = $request->input('edit_specifications');
            $description = $request->input('description');

            if ($specifications && $specifications != '[]') {
                $data['specifications'] = $specifications;
                $data['description'] = null;
            } else {
                $data['description'] = $description;
                $data['specifications'] = null;
            }

            // Debug: Uncomment to see what's being updated
            // dd($data);

            // Update the record
            DB::table('tblneed_assessment')
                ->where('needsID', $needsID)
                ->update($data);

            return redirect()->back()->with('msg', 'Needs assessment updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating record: ' . $e->getMessage());
        }
    }

    public function updateNeedsAssessment(Request $request)
{
    try {
        DB::beginTransaction();
        
        $needsID = $request->input('id');
        
        // Get the original record to check category and get item/department info
        $original = DB::table('tblneed_assessment')->where('needsID', $needsID)->first();
        
        if (!$original) {
            return redirect()->back()->with('error', 'Record not found.');
        }
        
        // Check if this is a service (category 5) or regular item
        if ($original->categoryID == 5) {
            // SERVICES CATEGORY - Update single record
            DB::table('tblneed_assessment')
                ->where('needsID', $needsID)
                ->update([
                    'description' => $request->input('description'),
                    'quantity' => $request->input('quantity'),
                    'brief_justification' => $request->input('brief_justification'),
                    'updated_at' => now()
                ]);
            
            $message = 'Service needs assessment updated successfully.';
        } else {
            // REGULAR ITEMS WITH SPECIFICATIONS - Update multiple rows
            
            // Get all records with same item and department (the whole group)
            $records = DB::table('tblneed_assessment')
                ->where('itemID', $original->itemID)
                ->where('departmentID', $original->departmentID)
                ->where('needs_titleID', $original->needs_titleID)
                ->where('categoryID', $original->categoryID)
                ->get();
            
            // Get new specification IDs from the edit form
            $newSpecIds = [];
            if ($request->has('edit_specification_ids') && !empty($request->edit_specification_ids)) {
                $newSpecIds = explode(',', $request->edit_specification_ids);
                // Clean up empty values
                $newSpecIds = array_filter($newSpecIds, function($id) {
                    return !empty($id);
                });
            }
            
            if (empty($newSpecIds)) {
                DB::rollBack();
                return redirect()->back()->with('error', 'No specifications selected for this item.');
            }
            
            // Get existing specification IDs from the records
            $existingSpecIds = $records->pluck('specificationID')->toArray();
            
            // Find specifications to delete (in existing but not in new)
            $specsToDelete = array_diff($existingSpecIds, $newSpecIds);
            
            // Find specifications to add (in new but not in existing)
            $specsToAdd = array_diff($newSpecIds, $existingSpecIds);
            
            // Delete records for specifications that were removed
            if (!empty($specsToDelete)) {
                DB::table('tblneed_assessment')
                    ->where('itemID', $original->itemID)
                    ->where('departmentID', $original->departmentID)
                    ->where('needs_titleID', $original->needs_titleID)
                    ->whereIn('specificationID', $specsToDelete)
                    ->delete();
            }
            
            // Update existing records with new quantity and justification
            foreach ($records as $record) {
                if (in_array($record->specificationID, $newSpecIds)) {
                    // This specification should be kept - update it
                    DB::table('tblneed_assessment')
                        ->where('needsID', $record->needsID)
                        ->update([
                            'quantity' => $request->input('quantity'),
                            'brief_justification' => $request->input('brief_justification'),
                            'updated_at' => now()
                        ]);
                }
            }
            
            // Add new records for specifications that were added
            foreach ($specsToAdd as $specId) {
                DB::table('tblneed_assessment')->insert([
                    'needs_titleID' => $original->needs_titleID,
                    'categoryID' => $original->categoryID,
                    'itemID' => $original->itemID,
                    'specificationID' => $specId,
                    'description' => null,
                    'quantity' => $request->input('quantity'),
                    'brief_justification' => $request->input('brief_justification'),
                    'departmentID' => $original->departmentID,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            $message = count($newSpecIds) . ' specification(s) updated successfully.';
        }

        DB::commit();
        return redirect()->back()->with('msg', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error updating record: ' . $e->getMessage());
    }
}
    public function deleteNeedsAssessment($id)
    {


        DB::table('tblneed_assessment')->where('needsID', base64_decode($id))->delete();

        return back()->with('msg', 'Successfully deleted!');
    }


    public function getAllNeeds_19_02_26()
    {
        //dd(Auth::user()->id);
        $data['title'] = DB::table('tblneeds_title')->first();
        //$data['title'] = DB::table('tblneeds_title')->where('needs_titleID',base64_decode($id))->first();
        $data['categoryList'] = DB::table('tblcategories')->get();
        $data['itemList'] = DB::table('tblitems')->get();
        //$data['id'] = base64_decode($id);

        $data['getList'] = DB::table('tblneed_assessment')
            //->where('departmentID',Auth::user()->user_role)
            //->where('needs_titleID',base64_decode($id))
            ->leftjoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftjoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
            ->leftjoin('tblunits', 'tblneed_assessment.departmentID', '=', 'tblunits.unitID')
            ->select(
                '*',
                'tblcategories.categoryID',
                'tblcategories.category',
                'tblitems.itemID',
                'tblitems.item',
                'tblunits.unit',
            )
            ->get();
        //dd($data);
        return view('procurement.procurement_plan_budget.view-all-needs', $data);
    }

    public function getAllNeeds()
    {
        $data['title'] = DB::table('tblneeds_title')->first();
        $data['categoryList'] = DB::table('tblcategories')->get();
        $data['itemList'] = DB::table('tblitems')->get();

        $data['getList'] = DB::table('tblneed_assessment')
            ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')

            // USE tbldepartment INSTEAD OF tblunits
            // ->leftJoin('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
            ->Join('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')

            ->select(
                'tblneed_assessment.*',
                'tblcategories.category',
                'tblitems.item',
                'tbldepartment.department as department_name'
            )
            ->orderBy('tbldepartment.department') // ensures grouping is correct
            ->get();

        return view('procurement.procurement_plan_budget.view-all-needs', $data);
    }


    public function generatePDFNeed(Request $request)
    {
        try {

            $rowData = $this->getAllNeedsData();

            // dd($rowData);
            // Pass the data to the view
            $pdf = PDF::loadView('procurement.procurement_plan_budget.pdf.exportneeds', compact('rowData'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(), // to load images in the pdf page
                    'chroot' => public_path()   // to load images in the pdf page
                ]);

            // Generate a timestamp to append to the filename
            $timestamp = now()->format('Y_m_d_His');

            // Define the filename with a timestamp
            $filename = 'exported_rows_' . $timestamp . '.pdf';

            // Download the PDF with the modified filename
            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log the exception for further investigation
            Log::error($e);

            // Return an error response
            return response()->json(['error' => 'Error generating PDF'], 500);
        }
    }

    public function getAllNeedsData()
    {
        return DB::table('tblneed_assessment')
            ->orderBy('needsID', 'desc')
            ->leftJoin('tblcategories', 'tblneed_assessment.categoryID', '=', 'tblcategories.categoryID')
            ->leftJoin('tblitems', 'tblneed_assessment.itemID', '=', 'tblitems.itemID')
            // ->leftJoin('tblunits', 'tblneed_assessment.departmentID', '=', 'tblunits.unitID')
            ->Join('tbldepartment', 'tblneed_assessment.departmentID', '=', 'tbldepartment.id')
            ->select(
                'tblneed_assessment.*',
                'tblcategories.categoryID',
                'tblcategories.category',
                'tblitems.itemID',
                'tblitems.item',
                'tbldepartment.department as department_name' // Alias department as unit
                //'tblunits.unit as department' // Alias department as unit
            )
            ->get();
    }


    public function getNotification()
    {
        $userRole = Auth::user()->user_role;

        // Check if the user has role ID 6
        if ($userRole != 6) {
            abort(403, 'Unauthorized');
        }

        $data['notification'] = DB::table('tblnotifications')
            ->where('receiverRoleID', $userRole)
            ->count();

        $data['getNotificationList'] = DB::table('tblnotifications')
            ->where('receiverRoleID', $userRole)
            ->leftJoin('tblunits', 'tblnotifications.senderUnitID', '=', 'tblunits.unitID')
            ->leftJoin('users', 'tblnotifications.senderUserID', '=', 'users.id')
            ->select(
                '*',
                'tblunits.unit',
                'users.name'
            )
            ->get();
        //dd($data['getNotificationList']);

        return view('procurement.procurement_plan_budget.view-all-notifications', $data);
    }



    public function saveNotification(Request $request)
    {

        $this->validate($request, [
            'item' => 'required',
            'reason' => 'required',
        ]);

        // Fetch the role ID from the database
        $userRole = DB::table('role')->where('roleID', 6)->value('roleID');
        //dd($userRole);

        DB::table('tblnotifications')->insert([
            'senderUserID' => Auth::user()->id,
            'senderUnitID' => Auth::user()->user_unit,
            'receiverRoleID' => $userRole,
            'item' => $request->input('item'),
            'reason' => $request->input('reason'),
            'is_read' => 0
        ]);

        return back()->with('msg', 'Successfully sent Notification!');
    }


    public function deleteNotification($id)
    {
        DB::table('tblnotifications')->where('notificationID', base64_decode($id))->delete();

        return back()->with('msg', 'Successfully deleted!');
    }


    public function markNotificationAsRead($notificationID)
    {
        // Update the notification in the database to mark it as read
        DB::table('tblnotifications')
            ->where('notificationID', $notificationID)
            ->update(['is_read' => 1]);

        // You can return a response if needed
        return response()->json(['message' => 'Notification marked as read']);
    }

    public function getUpdatedNotificationCount()
    {
        $userRole = Auth::user()->user_role;

        if ($userRole != 6) {
            abort(403, 'Unauthorized');
        }

        $notificationCount = DB::table('tblnotifications')
            ->where('receiverRoleID', $userRole)
            ->where('is_read', 0) // Count only unread notifications
            ->count();

        return response()->json(['notificationCount' => $notificationCount]);
    }


    public function sendNoticeForNeedSusmission(Request $request)
    {
        // dd($request->message);
        $users = DB::table('users')->where('user_role', 12)->get();
        $mssg = $request->message;
        $subject = "Notice of Need Submission";

        foreach ($users as $key => $user) {
            $name = $user->name;
            Mail::to($user->email)->send(new SubmitNeedNotice($name, $mssg, $subject));
            $saveNotification = DB::table('need_submission_notifications')->insert([
                'message_to' => $user->id,
                'email' => $user->email,
                'message' => $mssg,
                'message_by' => Auth::user()->id,
                'message_at' => date("Y-m-d h:m:s")
            ]);
        }
        return back()->with('msg', 'Email has been sent successfully to the concerned officers!');
    }

    public function getSpecificationsByItem($itemID)
    {
        $specifications = DB::table('tblspecifications')
            ->where('itemID', $itemID)
            ->get();
        
        return response()->json($specifications);
    }
    public function deptNeedsAssessment()
    {
        $data['title']         = DB::table('tblneeds_title')->first();
        $data['getCategory']   = DB::table('tblcategories')->get();
        $data['getDepartment'] = DB::table('tbldepartment')->get();

        $data['getList'] = collect();     // empty list on first load
        $data['grandTotal'] = 0;          // avoid undefined

        return view('procurement.procurement_plan_budget.dept_needs_assessment', $data);
    }


    public function needAssessmentReport(Request $request)
    {
        $data['title']         = DB::table('tblneeds_title')->first();
        $data['getCategory']   = DB::table('tblcategories')->get();
        $data['getDepartment'] = DB::table('tbldepartment')->get();

        $categoryId   = $request->input('category');
        $departmentId = $request->input('department');

        $query = DB::table('tblneed_assessment as na')
            ->leftJoin('tblitems as i', 'na.itemID', '=', 'i.itemID')
            ->select(
                'na.*',
                'i.itemID',
                'i.item',
                DB::raw('SUM(na.quantity) as total_quantity')
            );

        if (!empty($categoryId)) {
            $query->where('na.categoryID', $categoryId);
        }

        if (!empty($departmentId)) {
            $query->where('na.departmentID', $departmentId);
        }

        $data['getList'] = $query
            ->groupBy('i.itemID', 'i.item')
            ->orderBy('i.item')
            ->get();

        // ✅ Grand total quantity
        $data['grandTotal'] = (int) $data['getList']->sum('total_quantity');

        return view('procurement.procurement_plan_budget.dept_needs_assessment', $data);
    }

    public function checkItemExistsForDepartment1(Request $request)
    {
        $itemId = $request->item_id;
        $categoryId = $request->category_id;
        $departmentId = $request->department_id;
        $titleId = $request->title_id;
        
        $exists = DB::table('tblneed_assessment')
            ->where('needs_titleID', $titleId)
            ->where('departmentID', $departmentId)
            ->where('itemID', $itemId)
            ->where('categoryID', $categoryId)
            ->exists();
        
        return response()->json(['exists' => $exists]);
    }

    public function checkItemExistsForDepartment(Request $request)
    {
        $itemId = $request->item_id;
        $categoryId = $request->category_id;
        $departmentId = $request->department_id;
        $titleId = $request->title_id;
        
        $exists = DB::table('tblneed_assessment')
            ->where('needs_titleID', $titleId)
            ->where('departmentID', $departmentId)
            ->where('itemID', $itemId)
            ->where('categoryID', $categoryId)
            ->exists();
        
        return response()->json(['exists' => $exists]);
    }
}//end class
