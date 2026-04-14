<?php

namespace App\Http\Controllers\Repository;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;


class GlobalFunctionRepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function sampleName()
    {
        try{

        }catch(\Throwable $e)
        {

        }

    }//fun

}//end class
