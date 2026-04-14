<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BaseFileNumberSearchController extends Controller
{
    protected $layoutData = [];
    
    public function __construct()
    {
        // Set common layout variables for public access
        $this->layoutData = [
            'divisionName' => 'Payroll System',
            'user' => null, // Set user to null for public routes
            'division' => null,
            // Add other common variables that your layout expects
        ];
    }
    
    protected function view($view, $data = [])
    {
        return view($view, array_merge($this->layoutData, $data));
    }
}