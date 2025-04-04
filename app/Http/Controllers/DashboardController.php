<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $selectedCompanyId = session('selected_company_id');
        $employees = Employee::where('company_id', $selectedCompanyId)->get();

        return view('dashboard', compact('employees'));
    }

}
