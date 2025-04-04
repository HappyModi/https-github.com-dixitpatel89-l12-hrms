<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyContextMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $selectedCompanyId = null;

        if (session()->has('company_id')) {
            $selectedCompanyId =  session()->get('company_id');
            $company = Company::find($selectedCompanyId);
            session(['company_id' => $selectedCompanyId]);
        }else{
           $company = Company::first();
           session(['company_id' => $company->id]);
        }
        $companies = Company::get();
        view()->share([
            'companies' => $companies,
            'selectedCompany' => $company,
            'selectedCompanyId' => $selectedCompanyId,
        ]);

        return $next($request);
    }
}