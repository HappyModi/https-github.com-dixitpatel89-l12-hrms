<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use App\Models\Template;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all companies
        $companies = Company::all();

        // Fetch all templates
        $templates = Template::all();

        // Get company_id from request or use the first company's ID as default
        $selectedCompanyId = $request->query('company_id', optional($companies->first())->id);

        // Fetch employees for the selected company
        $employees = Employee::where('company_id', $selectedCompanyId)->get();

        // Get selected company details
        $selectedCompany = $companies->firstWhere('id', $selectedCompanyId);

        return view('companies.index', compact('templates', 'companies', 'employees', 'selectedCompany', 'selectedCompanyId'));
    }
    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'letterhead' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = new Company();
        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->company_phone_number = $request->company_phone_number;
        $company->save();

        if ($request->hasFile('logo')) {
            $company->logo = $request->file('logo')->store('logos', 'public');
            $company->save();
        }

        if ($request->hasFile('letterhead')) {
            $company->letterhead = $request->file('letterhead')->store('letterheads', 'public');
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'letterhead' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = Company::findOrFail($id);
        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->company_phone_number = $request->company_phone_number;
        $company->company_type = $request->company_type;
        $company->company_status = $request->company_status;

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $company->logo = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('letterhead')) {
            if ($company->letterhead) {
                Storage::disk('public')->delete($company->letterhead);
            }
            $company->letterhead = $request->file('letterhead')->store('letterheads', 'public');
        }

        $company->save();
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        if ($company->letterhead) {
            Storage::disk('public')->delete($company->letterhead);
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
        // Get all companies
        $companies = Company::all();

        // Get company_id from request or use the first company's ID as default
        $companyId = $request->query('company_id', optional($companies->first())->id);

        // Redirect to the employee list page with selected company_id
        return redirect()->route('employees.index', ['company_id' => $companyId]);
    }
    public function setCompany(Request $request)
    {
        $companyId = $request->query('company_id'); // Get company_id from URL

        // Redirect to the appropriate page with selected company_id
        return redirect()->back()->withInput(['company_id' => $companyId]);
    }
}
