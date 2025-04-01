<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Template;
use Dompdf\Dompdf;
use Dompdf\Options;

class EmployeeController extends Controller
{
    public function index(Request $request)
{
    // Get selected company_id from URL, fallback to authenticated user's company_id
    $companyId = $request->query('company_id', auth()->user()->company_id);

    // Fetch employees of the selected company and eager load the company relation
    $employees = Employee::with('company') // Move with() before get()
                        ->where('company_id', $companyId)
                        ->paginate(10); // Use pagination

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
        $generatedDocuments = Document::where('employee_id', $id)->orderBy('created_at', 'desc')->get();
        return view('employees.show', compact('employee', 'generatedDocuments'));
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

    public function bulkDelete(Request $request)
{
    $employeeIds = $request->input('employee_ids');

    if (!empty($employeeIds)) {
        Employee::whereIn('id', $employeeIds)->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
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

    public function toggleStatus($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = $employee->status == 'Active' ? 'Inactive' : 'Active';
        $employee->save();

        return response()->json(['status' => $employee->status, 'message' => 'Status updated successfully']);
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

    public function generateEmployeeLetter($id, $letterType)
    {
        $employee = Employee::findOrFail($id);
        $company = Company::findOrFail($employee->company_id);
    
        $letterNames = [
            'offer_letter' => 'Offer Letter',
            'appointment_letter' => 'Appointment Letter',
            'experience_letter' => 'Experience Letter',
            'appraisal_letter' => 'Appraisal Letter',
            'confirmation_letter' => 'Confirmation Letter',
            'relieving_letter' => 'Relieving Letter',
        ];
    
        if (!isset($letterNames[$letterType])) {
            return redirect()->back()->with('error', 'Invalid letter type selected.');
        }
    
        $template = Template::where('name', $letterNames[$letterType])->firstOrFail();
    
        // Replace placeholders in letter content
        $content = str_replace(
            ['{{ employee_name }}', '{{ job_title }}', '{{ company_email }}', '{{ company_name }}', '{{ salary }}', '{{ joining_date }}', '{{ date }}'],
            [$employee->full_name, $employee->job_title, $company->company_email, $company->company_name, number_format($employee->salary, 2), $employee->employment_date, now()->format('d M Y')],
            $template->letter_body
        );
    
        // Get letterhead image path from storage
        $letterheadPath = $company->letterhead ? storage_path('app/public/' . $company->letterhead) : null;
        
        // Convert image to Base64 if it exists
        if ($letterheadPath && file_exists($letterheadPath)) {
            $imageData = file_get_contents($letterheadPath);
            $base64Image = 'data:image/png;base64,' . base64_encode($imageData);
        } else {
            $base64Image = ''; // Fallback if no letterhead exists
        }
    
        // Construct the HTML with the letterhead as background
        $html = '
        <html>
        <head>
            <style>
                @page {
                    size: A4 portrait;
                    margin: 0;
                }
                body {
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                    background-image: url("' . $base64Image . '");
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    font-family: Arial, sans-serif;
                }
                .content {
                    position: absolute;
                    top: 10%;
                    left: 10%;
                    width: 80%;
                    font-size: 14px;
                    color: #000;
                }
            </style>
        </head>
        <body>
            <div class="content">
                ' . $content . '
            </div>
        </body>
        </html>';
    
        // Initialize Dompdf with options
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Return PDF for download
        return response()->streamDownload(function () use ($dompdf, $letterType, $employee) {
            echo $dompdf->output();
        }, "{$letterNames[$letterType]}_{$employee->id}.pdf");
    }
}
