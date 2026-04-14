<?php

namespace App\Http\Controllers\procurement;
use Illuminate\Http\Request;
use DB;
use App\Models\Department;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{

    public function show(){
        $data = db::table('tbldepartments')->get();
        return view('procurement.department.department')->with('datas', $data);
    }
    public function update(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255|unique:tbldepartments,department'
            ]);
        Department::updateOrCreate(['departmentID'=>$request->id],
        ['department'=>$request->name]
        );
        return redirect('department')->with('success','Department List Updated');
    }
    public function delete(Request $request){
     
        Department::find($request->id)->delete();
        return redirect('department')->with('success','Department Deleted Successfully');
    }
}