<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    use HasFactory;

    protected $fillable = [
        'employee_id', 
        'previous_month_working_days', 
        'previous_month_leave_days',
        'current_month_working_days',
        'current_month_leave_days',
        'month'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
