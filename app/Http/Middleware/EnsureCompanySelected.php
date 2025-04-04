<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCompanySelected
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!session()->has('selected_company_id')) {
                $firstCompany = $user->companies()->first();
                if ($firstCompany) {
                    session(['selected_company_id' => $firstCompany->id]);
                }
            }
        }

        return $next($request);
    }
}

