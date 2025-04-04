<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Employee;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // Fetch all employees
        return view('attendance.index', compact('employees'));
    }

    public function create()
    {
        return view('attendance.create');
    }

    public function store(Request $request)
    {
        // Debug: Print request data
        // dd($request->all());
    
        // Validate request
        $request->validate([
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:employees,id',
            'ctc' => 'required|array',
            'ctc.*' => 'numeric',
            'performance_bonus' => 'nullable|array',
            'performance_bonus.*' => 'nullable|numeric',
            'leave_encashment' => 'nullable|array',
            'leave_encashment.*' => 'nullable|numeric',
            'leave_credits' => 'nullable|array',
            'leave_credits.*' => 'nullable|numeric',
        ]);
    
        // Loop through all employees and store attendance
        foreach ($request->employee_id as $key => $employeeId) {
            $ctc = $request->ctc[$key];
            $performanceBonus = $request->performance_bonus[$key] ?? 0;
            $leaveEncashment = $request->leave_encashment[$key] ?? 0;
            $leaveCredits = $request->leave_credits[$key] ?? 0;
    
            // Salary Breakdown Calculations
            $basic = ($ctc / 12) * 0.50;
            $rentAllowance = ($ctc / 12) * 0.25;
            $specialAllowance = ($ctc / 12) * 0.15;
            $travelLeaveAllowance = ($ctc / 12) * 0.10;
            $variablePay = $ctc * 0.18;
    
            // Total Earnings
            $totalEarnings = $basic + $rentAllowance + $specialAllowance + $travelLeaveAllowance + $performanceBonus + $leaveEncashment;
    
            // Professional Tax Calculation
            $professionalTax = ($ctc >= 12000) ? 200 : (($ctc >= 9000) ? 150 : (($ctc >= 6000) ? 80 : 0));
    
            // Default Values
            $tds = 0;
            $lossOfPay = 0;
            $totalDeduction = $professionalTax + $tds + $lossOfPay;
            $finalPay = $totalEarnings - $totalDeduction;
    
            // Store Attendance Record
            Attendance::create([
                'employee_id' => $employeeId,
                'ctc' => $ctc,
                'performance_bonus' => $performanceBonus,
                'leave_encashment' => $leaveEncashment,
                'month_workdays' => 30,
                'leave_credits' => $leaveCredits,
                'lop_days' => 0,
                'paid_days' => 30,
                'variable_pay' => $variablePay,
                'basic' => $basic,
                'rent_allowance' => $rentAllowance,
                'special_allowance' => $specialAllowance,
                'travel_leave_allowance' => $travelLeaveAllowance,
                'total_earning' => $totalEarnings,
                'professional_tax' => $professionalTax,
                'tds' => $tds,
                'loss_of_pay' => $lossOfPay,
                'total_deduction' => $totalDeduction,
                'final_pay' => $finalPay,
                'leave_balance' => $leaveCredits,
            ]);
        }
    
        return redirect()->route('attendance.create')->with('success', 'Attendance added successfully!');
    }
    

}

