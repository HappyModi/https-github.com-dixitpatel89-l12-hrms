<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Company;
use App\Models\Employee;
use App\Observers\EmployeeObserver;
use App\Observers\CompanyObserver;

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
        // View Composer for sharing companies with all views
        View::composer('*', function ($view) {
            $companies = Company::all();
            $view->with('companies', $companies);
        });

        // Register Observers
        Employee::observe(EmployeeObserver::class);
        Company::observe(CompanyObserver::class);
    }
}
