<?php
//
namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Library\AnyFileUploadClass;
use App\Http\Controllers\ReuseableController;
use Session;
use File;
use Auth;
use DB;
use App\Http\Controllers\Controller;

class unitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create (Request $request)
    {   
        $data['getUnit'] = DB::table('tblunits')->get();
       // dd($data['getUnit']);
        
        return view ('procurement.Units.unit', $data);
    }
    
    public function store(Request $request)
    {
        $getunitName          =   $request->input(['unitName']);
        if(DB::table('tblunits')->where('unit', $getunitName)->exists())
        {
            return redirect()->back()->with('error','This unit name already exist');
        }
        //Insert
        DB::table('tblunits')->insert(['unit'=>$getunitName]);
        return redirect()->back()->with('message', 'saved');
  
    }
    
    public function update (Request $request)
    {   $id                 =  $request->input('unitId');
        $getunitName        =   $request->input('unitName');
        //dd($request->all());
        //dd( $request['unitId'] );
        if(DB::table('tblunits')->where('unit', $getunitName)->exists())
        {
            return redirect()->back()->with('error','This unit name already exist');
        }
        //Update
        DB::table('tblunits')->where('unitID',$id)->update(['unit'=>$getunitName]);
        return redirect()->back()->with('message', 'Record updated successfully');
    }
    
    public function delete ($id)
    {   
        //check both tables too know if the $id are the same before executing delete.
        //$ID = DB::table('users')->where('user_unit', $id)->exists() == DB::table('tblcontract_bidding')->where('role_unit_id', $id)->exists();
        
        if (DB::table('users')->where('user_unit', $id)->exists() && DB::table('tblcontract_bidding')->where('role_unit_id', $id)->exists())
        {
            return back()->with('error', "This unit cannot be deleted because record is in use!");
        }else{
                DB::table('tblunits')->where('unitID',$id)->delete();
                return back()->with('message', 'record deleted successfully');
        }
    }
}