<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $companyId =  request()->get('company_id');
       $company =  Company::find($companyId);
    //    dd($company->logo);
        return view('dashboard', compact('company'));
    }

    public function companyDashboard()
    {
    
        return view('dashboard');
    }

    public function hrDashboard()
    {
        return view('dashboard');
    }
}
