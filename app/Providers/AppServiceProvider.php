<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Company;
use App\Models\Employee;
use App\Observers\EmployeeObserver;
use App\Observers\CompanyObserver;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
     public function boot()
    {
        // Share the list of companies and the selected company with all views
        // View::composer('*', function ($view) {
        //     $companies = Company::all();
        //     $selectedCompany = Session::get('selected_company');

        //     $view->with([
        //         'companies' => $companies, 
        //         'selectedCompany' => $selectedCompany
        //     ]);
        // });
    }
}


