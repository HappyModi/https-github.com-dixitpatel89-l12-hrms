<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller
{
    public function index()
    {
        $companyId = session('selected_company', auth()->user()->company_id);

        // Fetch employees of the selected company and eager load the company relation
        $employees = Employee::where('company_id', $companyId)
                            ->with('company')
                            ->paginate(10);

        return view('employees.index', compact('employees'));
}


    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'employee_email' => 'required|email|unique:employees',
            'full_name' => 'required|string',
            'status' => 'required|in:Active,Inactive',
            'phone_number' => 'nullable|regex:/^[0-9]{10}$/',
            'company_id' => 'required|exists:companies,id'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('employee_files', 'public');
            $data['profile_image'] = $path;
        }

        $data['roles'] = json_encode($request->input('roles', []));

        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }


    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_email' => 'required|email|unique:employees,employee_email,' . $employee->id,
            'full_name' => 'required|string',
            'status' => 'required|in:Active,Inactive',
            'phone_number' => 'nullable|regex:/^[0-9]{10}$/'
        ]);

        $data = $request->except(['roles', 'profile_image']);
        $data['roles'] = json_encode($request->input('roles', []));

        if ($request->hasFile('profile_image')) {
            if ($employee->profile_image) {
                Storage::disk('public')->delete($employee->profile_image);
            }
            $path = $request->file('profile_image')->store('employee_files', 'public');
            $data['profile_image'] = $path;
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function deleteMultiple(Request $request)
    {
        if ($request->has('ids')) {
            Employee::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'No IDs provided']);
    }

    public function destroy(Employee $employee)
    {
        if ($employee->profile_image) {
            Storage::disk('public')->delete($employee->profile_image);
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function dashboard()
    {
        $companyId = session('selected_company', auth()->user()->company_id);
    
        // Fetch companies for dropdown
        $companies = Company::all();
    
        // Fetch employees or any other data needed
        $employees = Employee::where('company_id', $companyId)->get();
    
        return view('dashboard', compact('companies', 'employees', 'companyId'));
    }
    

    public function switchCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        session(['selected_company' => $request->company_id]);

        return redirect()->route('dashboard')->with('success', 'Company switched successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $employee = Employee::findOrFail($request->id);
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true, 'status' => $employee->status]);
    }

    public function changeStatus(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }


    public function generateSalaryPdf(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $company = auth()->user()->company; // Get currently logged-in user's company

        $data = [
            'employee' => $employee,
            'company' => $company, // Pass company details
            'month' => $request->month,
            'basic' => $request->basic,
            'hra' => $request->hra,
            'special_allowance' => $request->special_allowance,
            'lta' => $request->lta,
            'bonus' => $request->bonus,
            'leave_encashment' => $request->leave_encashment,
            'gross_earnings' => $request->gross_earnings,
            'income_tax' => $request->income_tax,
            'professional_tax' => $request->professional_tax,
            'lop' => $request->lop,
            'total_deductions' => $request->total_deductions,
            'net_salary' => $request->net_salary,
            'paid_days' => $request->paid_days,
            'lop_days' => $request->lop_days
        ];

        $pdf = Pdf::loadView('employees.salary_slip_pdf', $data);
        
        return $pdf->download('SalarySlip.pdf');
    }




}
