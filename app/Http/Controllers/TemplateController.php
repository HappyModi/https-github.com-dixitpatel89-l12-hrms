<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Employee;
use App\Models\Document;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::all();
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'letter_body' => 'required',
            'company_id' => 'required|exists:companies,id'
        ]);
    
        $template = Template::create($request->all());
        
        if ($template) {
            return redirect()->route('templates.index')->with('success', 'Template added successfully!');
        } else {
            return back()->with('error', 'Failed to save template.');
        }
    }
        public function edit($id)
{
    $template = Template::findOrFail($id);
    return view('templates.edit', compact('template'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'letter_body' => 'required',
        ]);

        $template = Template::findOrFail($id);
        $template->update([
            'name' => $request->name,
            'letter_body' => $request->letter_body,
        ]);

        return redirect()->route('templates.index')->with('success', 'Template updated successfully');
    }

    public function generateLetter($employeeId, $templateId)
    {
        $employee = Employee::findOrFail($employeeId);
        $template = Template::findOrFail($templateId);

        $placeholders = [
            '{name}' => $employee->name,
            '{designation}' => $employee->designation,
            '{company}' => $employee->company->name,
            '{joindate}' => $employee->joining_date,
            '{amount}' => $employee->salary,
            '{email}' => $employee->email,
            '{contactno}' => $employee->phone,
        ];

        $letterBody = str_replace(array_keys($placeholders), array_values($placeholders), $template->letter_body);
        return view('letters.generate', compact('letterBody', 'template', 'employee'));
    }

    public function downloadPDF($employeeId, $templateId)
    {
        $employee = Employee::findOrFail($employeeId);
        $template = Template::findOrFail($templateId);

        $placeholders = [
            '{name}' => $employee->name,
            '{designation}' => $employee->designation,
            '{company}' => $employee->company->name,
            '{joindate}' => $employee->joining_date,
            '{amount}' => $employee->salary,
            '{email}' => $employee->email,
            '{contactno}' => $employee->phone,
        ];

        $letterBody = str_replace(array_keys($placeholders), array_values($placeholders), $template->letter_body);
        $pdf = Pdf::loadView('letters.pdf', compact('letterBody', 'template', 'employee'));

        $fileName = $employee->name . '_' . $template->name . '.pdf';
        $pdfPath = 'uploads/documents/' . $fileName;

        Document::create([
            'employee_id' => $employee->id,
            'document_title' => $template->name,
            'pdf_path' => $pdfPath,
            'pdf_name' => $fileName,
            'created_by' => auth()->id(),
        ]);

        return $pdf->download($fileName);
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template deleted successfully');
    }

}
