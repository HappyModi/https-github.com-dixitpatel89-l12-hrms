<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all(); // Fetch all companies
        $selectedCompanyId = session('selected_company', $companies->first()->id ?? null);
        $employees = Employee::where('company_id', $selectedCompanyId)->get();

        return view('dashboard', compact('companies', 'employees', 'selectedCompanyId'));
    }



    // ✅ Add this method
    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = new Company();
        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->company_phone_number = $request->company_phone_number;
        $company->save();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/logos'), $filename);
            $company->logo = 'uploads/logos/' . $filename;
            $company->save();
        }

        return redirect()->route('companies.index')->with('success', 'Company added successfully.');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
        ]);

        $company = Company::findOrFail($id);
        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->company_phone_number = $request->company_phone_number;
        $company->company_type = $request->company_type;
        $company->company_status = $request->company_status;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/logos'), $filename);
            $company->logo = 'uploads/logos/' . $filename;
        }

        $company->save();
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.show', compact('company'));
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // Delete logo file if exists
        if ($company->logo && file_exists(public_path($company->logo))) {
            unlink(public_path($company->logo));
        }

        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_companies', []);

        if (!empty($ids)) {
            Company::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Selected companies deleted successfully!');
        }

        return redirect()->back()->with('error', 'No companies selected for deletion.');
    }

    public function switchCompany(Request $request)
{
    $requestCompanyId = $request->company_id;
    // $abc=Employee::where('company_id',$requestCompanyId)->get();
    // dd($abc);
    $sessionCompanyId = session('selected_company');

    \Log::info('Request Company ID: ' . $requestCompanyId);
    \Log::info('Session Before: ' . $sessionCompanyId);

    // Only update session if there's a change
    if ($requestCompanyId != $sessionCompanyId) {
        session(['selected_company' => $requestCompanyId]);

        \Log::info('Session After: ' . session('selected_company'));
    }

    return redirect()->back();
}

    
    
}
