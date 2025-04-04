<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Illuminate\Support\Facades\View;

class SetCompanySession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $companies = $user->companies()->get();

            // If user has companies
            if ($companies->isNotEmpty()) {
                $selectedCompanyId = session('selected_company_id', $companies->first()->id);
                session(['selected_company_id' => $selectedCompanyId]); // persist

                $selectedCompany = Company::find($selectedCompanyId);

                View::share([
                    'companies' => $companies,
                    'selectedCompanyId' => $selectedCompanyId,
                    'selectedCompany' => $selectedCompany,
                ]);
            }
        }

        return $next($request);
    }
}       