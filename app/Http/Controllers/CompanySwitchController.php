<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CompanySwitchController extends Controller
{
    public function switch(Request $request)
    {
        $user = Auth::user();
        $company_id = $request->company_id;

        // if ($user->companies()->where('companies.id', $companyId)->exists()) {
            session(['company_id' => $company_id]);
        // }
        // return redirect()->route('dashboard');
        return back()->with('success', 'Company switched successfully.');
    }
}


