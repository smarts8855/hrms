<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        // Share divisionName with all views
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $userID = Auth::id();
                $userDivision = DB::table('users')
                    ->join('tbldivision', 'users.divisionID', '=', 'tbldivision.divisionID')
                    ->where('users.id', $userID)
                    ->select('tbldivision.division')
                    ->first();
                    
                $divisionName = $userDivision ? $userDivision->division : 'No Division Assigned';
                $view->with('divisionName', $divisionName);
            }
        });
    }
}