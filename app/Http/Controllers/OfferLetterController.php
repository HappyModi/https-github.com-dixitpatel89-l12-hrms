<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Template;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class OfferLetterController extends Controller
{
    // public function showOfferLetter($id)
    // {
    //     $employee = Employee::with('company')->findOrFail($id);
    //     $template = Template::where('name', 'Offer Letter')->where('company_id', $employee->company_id)->firstOrFail();

    //     // Replace placeholders with actual data
    //     $placeholders = [
    //         '{{name}}' => $employee->name,
    //         '{{designation}}' => $employee->designation,
    //         '{{joindate}}' => Carbon::parse($employee->join_date)->format('d M Y'),
    //         '{{amount}}' => $employee->salary,
    //         '{{email}}' => $employee->email,
    //         '{{contactno}}' => $employee->phone,
    //         '{{company}}' => $employee->company->name,
    //         '{{owner}}' => $employee->company->owner_name,
    //         '{{date}}' => now()->format('d M Y'),
    //         '{{address1}}' => $employee->address_line1,
    //         '{{address}}' => $employee->address_line2,
    //         '{{dist}}' => $employee->district,
    //         '{{pin}}' => $employee->pincode,
    //         '{{reference}}' => 'EMP',
    //         '{{employeeId}}' => $employee->id,
    //     ];

    //     $letterBody = str_replace(array_keys($placeholders), array_values($placeholders), $template->letter_body);

    //     return view('employees.offer-letter', compact('letterBody', 'employee'));
    // }

    // public function downloadOfferLetter($id)
    // {
    //     $employee = Employee::with('company')->findOrFail($id);
    //     $template = Template::where('name', 'Offer Letter')->where('company_id', $employee->company_id)->firstOrFail();

    //     // Replace placeholders
    //     $placeholders = [
    //         '{{name}}' => $employee->name,
    //         '{{designation}}' => $employee->designation,
    //         '{{joindate}}' => Carbon::parse($employee->join_date)->format('d M Y'),
    //         '{{amount}}' => $employee->salary,
    //         '{{email}}' => $employee->email,
    //         '{{contactno}}' => $employee->phone,
    //         '{{company}}' => $employee->company->name,
    //         '{{owner}}' => $employee->company->owner_name,
    //         '{{date}}' => now()->format('d M Y'),
    //         '{{address1}}' => $employee->address_line1,
    //         '{{address}}' => $employee->address_line2,
    //         '{{dist}}' => $employee->district,
    //         '{{pin}}' => $employee->pincode,
    //         '{{reference}}' => 'EMP',
    //         '{{employeeId}}' => $employee->id,
    //     ];

    //     $letterBody = str_replace(array_keys($placeholders), array_values($placeholders), $template->letter_body);

    //     $pdf = Pdf::loadView('employees.offer-letter-pdf', compact('letterBody'));

    //     // Store the PDF in storage and return it as a download
    //     $pdfPath = 'offer_letters/' . $employee->id . '_offer_letter.pdf';
    //     Storage::put('public/' . $pdfPath, $pdf->output());

    //     return response()->download(storage_path('app/public/' . $pdfPath));
    // }
    
    public function generateOfferLetter($id)
    {
        // Find the employee and associated company
        $employee = Employee::findOrFail($id);
        $company = Company::findOrFail($employee->company_id);
        $template = Template::where('name', 'offer letter2')->firstOrFail();
    
        // Replace placeholders in the stored template
        $content = str_replace(
            ['{{ employee_name }}', '{{ job_title }}', '{{ company_email }}', '{{ company_name }}', '{{ salary }}', '{{ joining_date }}', '{{date}}'],
            [$employee->full_name, $employee->job_title, $company->company_email, $company->company_name, number_format($employee->salary, 2), $employee->employment_date, now()->format('d M Y')],
            $template->letter_body
        );
    
        // Get the letterhead image from the company table
        $letterheadPath = $company->letterhead ? storage_path('app/public/' . $company->letterhead) : null;
    
        // Convert the image to Base64 if it exists
        if ($letterheadPath && file_exists($letterheadPath)) {
            $imageData = file_get_contents($letterheadPath);
            $base64Image = 'data:image/png;base64,' . base64_encode($imageData);
        } else {
            $base64Image = ''; // Fallback if no letterhead exists
        }
    
        // CSS to make the letterhead cover the full page
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
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, "Offer_Letter_{$employee->id}.pdf");
    }
    

    
}
