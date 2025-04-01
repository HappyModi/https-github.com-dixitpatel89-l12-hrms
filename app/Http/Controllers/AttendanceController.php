<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        // Get the authenticated user's company ID
        $companyId = auth()->user()->company_id;

        // Fetch employees based on the authenticated user's company ID
        $employees = Employee::where('company_id', $companyId)->get();

        return view('attendance.create', compact('employees'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'current_month_working_days' => 'required|integer|min:0',
            'current_month_leave_days' => 'required|integer|min:0',
        ]);

        $employeeId = $request->employee_id;
        $currentMonth = Carbon::now()->format('F Y');
        $previousMonth = Carbon::now()->subMonth()->format('F Y');

        // Check if attendance already exists for this month
        if (Attendance::where('employee_id', $employeeId)->where('month', $currentMonth)->exists()) {
            return redirect()->back()->with('error', 'Attendance for this employee already recorded for this month.');
        }

        // Fetch last month's attendance
        $lastAttendance = Attendance::where('employee_id', $employeeId)
            ->where('month', $previousMonth)
            ->first();

        Attendance::create([
            'employee_id' => $employeeId,
            'previous_month_working_days' => $lastAttendance->current_month_working_days ?? 0,
            'previous_month_leave_days' => $lastAttendance->current_month_leave_days ?? 0,
            'current_month_working_days' => $request->current_month_working_days,
            'current_month_leave_days' => $request->current_month_leave_days,
            'month' => $currentMonth,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function getPreviousMonthData($employeeId)
    {
        $previousMonth = Carbon::now()->subMonth()->format('F Y');
        $attendance = Attendance::where('employee_id', $employeeId)
            ->where('month', $previousMonth)
            ->first();

        return response()->json([
            'working_days' => $attendance->current_month_working_days ?? 0,
            'leave_days' => $attendance->current_month_leave_days ?? 0,
        ]);
    }
}
