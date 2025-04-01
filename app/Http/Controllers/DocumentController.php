<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function generatePDF($employee_id, $template_type)
    {
        // Get Employee Data
        $employee = Employee::findOrFail($employee_id);

        // Generate document title dynamically
        $documentTitle = ucfirst($template_type) . " Letter";

        // Load the appropriate HTML template
        $pdf = Pdf::loadView('templates.' . $template_type, compact('employee'));

        // Generate Unique PDF Name
        $fileName = $employee->name . '-' . $template_type . '-' . time() . '.pdf';
        $filePath = 'documents/' . $fileName;

        // Store PDF in Storage
        Storage::put('public/' . $filePath, $pdf->output());

        // Automatically Store Data in `documents` Table
        $document = Document::create([
            'employee_id'    => $employee->id,
            'document_title' => $documentTitle,
            'pdf_path'       => 'storage/' . $filePath,
            'pdf_name'       => $fileName,
            'created_by'     => Auth::id(),
        ]);

        // Return JSON response with PDF URL
        return response()->json([
            'message'  => 'PDF generated successfully',
            'pdf_url'  => asset('storage/' . $filePath),
            'document' => $document
        ]);
    }

    public function index()
    {
        $documents = Document::with('employee')->latest()->get();
        return view('documents.index', compact('documents'));
    }
}
