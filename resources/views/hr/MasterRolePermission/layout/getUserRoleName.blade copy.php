
@php
  $getRoleName = DB::table('assign_user_role')
    ->join('user_role', 'user_role.roleID', '=', 'assign_user_role.roleID')
    ->where('assign_user_role.userID', '=', Auth::user()->id)
    ->select('user_role.roleID', 'user_role.rolename')
    ->first();
@endphp
@if($getRoleName)
  <span><big>{{$getRoleName->rolename}}</big></span>
@elseif(DB::table('users')->where('id', Auth::user()->id)->where('user_type', 'Technical')->first())
  <span><b>Technical User</b></span>
@else
  <span><small>No Role Assigned Yet !</small></span>
@endif
