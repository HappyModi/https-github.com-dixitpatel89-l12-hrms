<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'document_title',
        'pdf_path',
        'pdf_name',
        'created_at',
        'created_by'
    ];
}
