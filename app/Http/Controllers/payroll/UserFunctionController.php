<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterRolePermissionController;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class UserFunctionController extends MasterRolePermissionController
{
    // assigning user functions by pitoff
    public function create()
    {
        $data['users'] = DB::table('user_role')->get();
        $data['assignedFunctions'] = DB::table('user_role')->where('can_check', '!=', 0)
        ->orwhere('can_submit_salary', '!=', 0)
        ->orwhere('can_authorize_salary', '!=', 0)
        ->orwhere('can_audit', '!=', 0)
        ->orwhere('can_cpo', '!=', 0)->paginate(50);
        return view('MasterRolePermission.assignUserFunction.index', $data);
    }

    public function createAbility(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'user' => 'required'
        ]);
        $user = $request['user'];
        $canSubmit = $request['can_submit_salary'] ?? 0;
        $canAuth = $request['can_authorize_salary'] ?? 0;
        $canCheck = $request['can_check'] ?? 0;
        $canAudit = $request['can_audit'] ?? 0;
        $canCpo = $request['can_cpo'] ?? 0;
        // dd($canAudit);

        try {
            $updateAbility = DB::table('user_role')->where('roleID', '=', $user)->update([
                'can_submit_salary' => $canSubmit,
                'can_authorize_salary' => $canAuth,
                'can_check' => $canCheck,
                'can_audit' => $canAudit,
                'can_cpo' => $canCpo
            ]);
            return back()->with('message', 'You have successfully assigned ability to user');

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
    }

    public function updateAbility(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'user' => 'required'
        ]);
        $user = $request['user'];
        $canSubmit = $request['can_submit_salary'] ?? 0;
        $canAuth = $request['can_authorize_salary'] ?? 0;
        $canCheck = $request['can_check'] ?? 0;
        $canAudit = $request['can_audit'] ?? 0;
        $canCpo = $request['can_cpo'] ?? 0;
        // dd($canAudit);

        try {
            $updateAbility = DB::table('user_role')->where('roleID', '=', $user)->update([
                'can_submit_salary' => $canSubmit,
                'can_authorize_salary' => $canAuth,
                'can_check' => $canCheck,
                'can_audit' => $canAudit,
                'can_cpo' => $canCpo
            ]);
            return back()->with('message', 'You have successfully assigned ability to user');

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error_message', 'unable to assign ability to user');
        }
    }

}
