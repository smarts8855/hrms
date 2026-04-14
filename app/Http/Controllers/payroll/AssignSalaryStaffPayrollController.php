<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignSalaryStaffPayrollController extends MasterRolePermissionController
{
    public function index_04_02_2026()
    {
        //salary staff on user_role table has id/roleID of 5, so select them
        $data['users'] = DB::table('users')->join('assign_user_role', 'assign_user_role.userID', '=', 'users.id')
            //    ->where('assign_user_role.roleID', '=', 5)
            //    ->orWhere('assign_user_role.roleID', '=', 20)
            ->select('users.id', 'users.name', 'username')->get();

        $data['divisions'] = DB::table('tbldivision')->select('division', 'divisionID')->get();
        $data['banks'] = DB::table('tblbanklist')->select('bankID', 'bank')->get();

        $data['assigned'] = DB::table('assign_salary_staff')
            ->join('users', 'users.id', '=', 'assign_salary_staff.user_id')
            ->join('tbldivision', 'tbldivision.divisionID', '=', 'assign_salary_staff.division_id')
            ->join('tblbanklist', 'tblbanklist.bankID', '=', 'assign_salary_staff.bank_id')
            ->join('user_role', 'user_role.roleID', '=', 'assign_salary_staff.role_id')
            ->select(
                'assign_salary_staff.id',
                'users.id as userID',
                'users.name',
                'users.username',
                'tbldivision.divisionID as divID',
                'tbldivision.division',
                'tblbanklist.bank',
                'tblbanklist.bankID',
                'user_role.rolename'
            )
            ->orderBy('users.username', 'ASC')
            ->paginate('50');
        // dd($data);
        return view('payroll.assignSalaryStaffPayroll.index', $data);
    }

    public function index()
    {
        // 1. Get logged-in user's roleID
        $loggedRole = DB::table('assign_user_role')
            ->where('userID', auth()->id())
            ->value('roleID');

        // 2. Map roles
        $roleMap = [
            25 => 31,
            34 => 35,
            36 => 37,
        ];

        // 3. Check if user is Super Admin (roleID = 1)
        $isSuperAdmin = ($loggedRole == 1);

        // 4. Determine which users to show
        $targetRole = $roleMap[$loggedRole] ?? null;

        // 5. Load filtered users OR all users for super admin
        $data['users'] = DB::table('users')
            ->join('assign_user_role', 'assign_user_role.userID', '=', 'users.id')
            ->when(!$isSuperAdmin && $targetRole, function ($query) use ($targetRole) {
                return $query->where('assign_user_role.roleID', $targetRole);
            })
            ->select('users.id', 'users.name', 'users.username')
            ->get();

        // Other data
        $data['divisions'] = DB::table('tbldivision')->select('division', 'divisionID')->get();
        $data['banks'] = DB::table('tblbanklist')->select('bankID', 'bank')->get();

      
        $data['assigned'] = DB::table('assign_salary_staff')
            ->join('users', 'users.id', '=', 'assign_salary_staff.user_id')
            ->join('tbldivision', 'tbldivision.divisionID', '=', 'assign_salary_staff.division_id')
            ->join('tblbanklist', 'tblbanklist.bankID', '=', 'assign_salary_staff.bank_id')
            ->join('user_role', 'user_role.roleID', '=', 'assign_salary_staff.role_id')
            ->when(!$isSuperAdmin && $targetRole, function ($query) use ($targetRole) {
                return $query->where('assign_salary_staff.role_id', $targetRole);
            })
            ->select(
                'assign_salary_staff.id',
                'users.id as userID',
                'users.name',
                'users.username',
                'tbldivision.divisionID as divID',
                'tbldivision.division',
                'tblbanklist.bank',
                'tblbanklist.bankID',
                'user_role.rolename'
            )
            ->orderBy('users.username', 'ASC')
            ->paginate(50);


        return view('payroll.assignSalaryStaffPayroll.index', $data);
    }


    public function store_04_02_2026(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'user'     => 'required',
            'division'      => 'required',
            'bank'        => 'required'
        ]);

        //get the staffs role
        $staffRole = DB::table('assign_user_role')->where('userID', '=', $request['user'])->first();
        if (!$staffRole) {
            return back()->with('error', 'Opps! Staff has no assigned role');
        }

        //check if division and bank is already assigned
        $check = DB::table('assign_salary_staff')->where('bank_id', '=', $request['bank'])->where('division_id', '=', $request['division'])->where('role_id', '=', $staffRole->roleID)->first();
        if ($check) {
            return back()->with('error_message', 'Opps! You have already assigned bank');
        }

        try {

            DB::table('assign_salary_staff')->insert([
                'user_id' => $request['user'],
                'division_id' => $request['division'],
                'bank_id' => $request['bank'],
                'role_id' => $staffRole->roleID,
            ]);
            return back()->with('message', 'You have successfully assigned bank to salary staff');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Opps! Something went wrong');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user'     => 'required',
            'division' => 'required',
            'bank'     => 'required|array', // IMPORTANT
            'bank.*'   => 'required'        // each bank must have a value
        ]);

        // get staff role
        $staffRole = DB::table('assign_user_role')
            ->where('userID', $request->user)
            ->first();

        if (!$staffRole) {
            return back()->with('error', 'Opps! Staff has no assigned role');
        }

        foreach ($request->bank as $bankID) {

            // check if this bank + division + role are already assigned
            $check = DB::table('assign_salary_staff')
                ->where('bank_id', $bankID)
                ->where('division_id', $request->division)
                ->where('role_id', $staffRole->roleID)
                ->first();

            if ($check) {
                // Skip duplicates – do not stop process
                continue;
            }

            DB::table('assign_salary_staff')->insert([
                'user_id'     => $request->user,
                'division_id' => $request->division,
                'bank_id'     => $bankID,
                'role_id'     => $staffRole->roleID,
            ]);
        }

        return back()->with('message', 'You have successfully assigned selected banks');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'user'     => 'required',
            'division'      => 'required',
            'bank'        => 'required'
        ]);

        //get the staffs role
        $staffRole = DB::table('assign_user_role')->where('userID', '=', $request['user'])->first();
        //check if division and bank is already assigned
        $check = DB::table('assign_salary_staff')->where('bank_id', '=', $request['bank'])->where('division_id', '=', $request['division'])->where('role_id', '=', $staffRole->roleID)->first();
        if ($check) {
            return back()->with('error_message', 'Opps! You have already assigned bank and division');
        }

        try {

            DB::table('assign_salary_staff')->where('id', $id)->update([
                'user_id' => $request['user'],
                'division_id' => $request['division'],
                'bank_id' => $request['bank'],
                'role_id' => $staffRole->roleID,
            ]);
            return back()->with('message', 'You have successfully updated assignment');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Opps! Something went wrong');
        }
    }




    public function destroy($id)
    {
        // dd($id);
        $destroy = DB::table('assign_salary_staff')->where('id', '=', $id)->delete();
        if ($destroy) {
            return back()->with('message', 'You have successfully deleted assignment');
        }
    }

    public function payroll()
    {
        $data['courtDivisions'] = DB::table('assign_salary_staff')->join('tbldivision', 'tbldivision.divisionID', '=', 'assign_salary_staff.division_id')->where('assign_salary_staff.user_id', Auth::user()->id)->groupBy('assign_salary_staff.division_id')->get();
        // $data['banks'] = DB::table('assign_salary_staff');
        return view("payroll.assignSalaryStaffPayroll.salaryStaffPayroll", $data);
    }

    public function getBanksAssignedToStaff($id)
    {
        $banks = DB::table('assign_salary_staff')->join('tblbanklist', 'tblbanklist.bankID', '=', 'assign_salary_staff.bank_id')
            ->where('assign_salary_staff.user_id', Auth::user()->id)->where('assign_salary_staff.division_id', '=', $id)->select('tblbanklist.bankID', 'tblbanklist.bank')->get();
        return response()->json($banks);
    }
}
