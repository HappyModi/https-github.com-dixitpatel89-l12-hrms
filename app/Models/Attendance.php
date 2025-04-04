<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'employee_id', 'ctc', 'performance_bonus', 'leave_encashment', 'month_workdays',
        'leave_credits', 'lop_days', 'paid_days', 'variable_pay', 'basic', 'rent_allowance',
        'special_allowance', 'travel_leave_allowance', 'total_earning', 'professional_tax',
        'tds', 'loss_of_pay', 'total_deduction', 'final_pay', 'leave_balance'
    ];
}

