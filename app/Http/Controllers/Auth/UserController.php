<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\payroll\ParentController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends ParentController
{
    public function registerUser()
    {
        $data['divisions'] = DB::select('select * from tbldivision');
        $data['roles'] = DB::select('select * from user_role');
        return view('auth.register', $data);
    }
    public function storeUser(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'first_name'          => 'required|regex:/^[\pL\s\-]+$/u',
            'last_name'          => 'required|regex:/^[\pL\s\-]+$/u',
            'email_address'          => 'required|unique:users',
            'userName'              => 'required|unique:users',
            'role_id'        => 'required|numeric',
            'division'         => 'required',
            'isGlobal'        => 'required',
            'password'        => 'required|numeric',
        ]);

        $user = new User;
        //$password = str_random(8).rand(9003, 86479);
        $password = $request['password'];
        $user->name = trim($request['first_name']) . ' ' . trim($request['last_name']);
        //$user->username = trim( $request['first_name'] ).'_'.trim($request['last_name']);
        $user->username = trim($request['userName']);
        $user->password   = bcrypt(trim($password));
        $user->email_address = trim($request['email_address']);
        $user->user_type = 'NONTECHNICAL';
        $user->temp_pass = $password;
        $user->divisionID = $request['division'];
        $user->is_global = $request['isGlobal'];

        $user->first_login = 1;

        $user->save();

        //user id
        $user_id = User::latest()->first()->id;

        //save the role
        DB::table('assign_user_role')->insert([
            'userID' => $user_id,
            'roleID' => $request['role_id'],
            'created_at' => date('Y-m-d')
        ]);

        //dd($user->password);

        //send a mail
        // $this->mail_details( $user->email_address , $user->username , $password,  $user->name );
        $this->addLog('New user added');
        return back()->with('msg', 'New user added successfully!');
    }

    public function modifyUser(Request $request)
    {
        $data['error'] = "";
        $data['warning'] = "";
        $data['success'] = "";
        $data['names'] = $request['name'];
        $data['email'] = $request['email'];
        $data['role'] = $request['role'];
        $data['password'] = $request['password'];
        $data['status'] = $request['status'];
        $data['global'] = $request['global'];
        $data['division'] = $request['division'];
        $data['id'] = $request['id'];

        if (isset($_POST['edit'])) {
            // dd($request->all());
            $this->validate($request, [
                'name'             => 'required|regex:/^[\pL\s\-]+$/u',
                'email'                  => 'required|email',
                'role'               => 'required',
                'status'               => 'required',
                'division'            => 'required',
                'global'            => 'required'
            ]);
            DB::table('users')->where('id', $request['id'])->update([
                'name' => $data['names'],
                'email_address' => $data['email'],
                'status' => $data['status'],
                'is_global' => $data['global'],
                'divisionID' => $data['division'],
            ]);

            if ($request['password'] != '') {
                $this->validate($request, [
                    'email'                  => 'required|email',
                    'password'               => 'required|min:5',
                    'role'               => 'required',
                ]);
                DB::table('users')->where('id', $request['id'])->update([
                    'password' => bcrypt($request['password']),
                ]);
            }
            DB::table('assign_user_role')->where('userID', $request['id'])->update([
                'roleID' => $data['role'],
            ]);
            if ($request['status'] == '0') {
                DB::table('users')->where('id', $request['id'])->update([
                    'password' => 0,
                ]);
            }

            return back()->with('msg', 'User Profile successfully updated!');
        }
        //    $data['Rolelist'] = $this->Rolelist();
        //     $data['Statuslist'] = $this->Statuslist();

        $data['Rolelist'] = DB::table('user_role')->get();
        $data['divisionList'] = DB::table('tbldivision')->get();
        $data['users'] = DB::table('users')->join('assign_user_role', 'assign_user_role.userID', '=', 'users.id')
            ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
            ->leftjoin('tbldivision', 'tbldivision.divisionID', '=', 'users.divisionID')
            ->select('users.id', 'users.name', 'users.status', 'users.username', 'users.is_global', 'users.divisionID', 'users.email_address', 'tbldivision.division', 'user_role.rolename', 'user_role.roleID')->paginate(100);
        return view('auth.modify_user', $data);
    }

    public function editAccount()
    {
        //$data['userrole']='My role';
        $data['userrole'] = DB::table('assign_user_role')->select('user_role.rolename')
            ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
            ->where('assign_user_role.userID', '=', Auth::user()->id)->first()->rolename ?? '';
        return view('auth.editAccount', $data);
    }

    public function editAccountStore(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            //'fullName'      	   	=> 'required',
            //'userName'      	   	=> 'required',
            'password'                   => 'required|confirmed|min:5',
            'password_confirmation'    => 'required'
        ]);
        $userID = Auth::user()->id;

        // Check if new password is still default
        if ($request->password === '12345') {
            return back()->with('error', 'You cannot use the default password. Choose a new one.');
        }

        User::where('id', $userID)->update([
            //'name'        => $request->last_name ." ".$request->first_name,
            'password'    => bcrypt($request->password),
            'first_login' => (1),
            'username' => $request->userName,
        ]);

        // 🔥 VERY IMPORTANT SECURITY STEP
        // Auth::logoutOtherDevices($request->password);

        Session::forget('firstLogin');
        Session::put('firstLogin', 1);

        $this->addLog('Your password was updated successfully');
        return redirect('/')->with('msg', 'Your password was updated successfully!');
    }


    public function mail_details($email, $username, $pwd, $full_name)
    {

        $to = $email;
        $subject = "Account Creation Successful!";

        $header = "From: JIPPIS PORTAL " . "<info@mbrcomputers.net>" . "\r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-type: text/html \r\n";
        $message = "Dear $full_name, <br> Your Login profile for JIPPIS has been created. <br> your login details is as follow: <br> User Name: 	       $username <br> Password: $pwd <br> Kindly Change your password after login.<br>";

        $retval = mail($email, $subject, $message, $header);

        //dd($retval);


    }
}
