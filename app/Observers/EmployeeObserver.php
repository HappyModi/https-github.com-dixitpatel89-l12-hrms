<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'company_id' => $employee->company_id,
            'employee_id' => $employee->id,
            'action' => 'created',
            'description' => "New employee added: {$employee->name}",
        ]);
    }

    public function updated(Employee $employee)
    {
        $changes = $employee->getChanges();
        $oldValues = [];

        foreach ($changes as $field => $newValue) {
            $oldValues[$field] = $employee->getOriginal($field);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'company_id' => $employee->company_id,
            'employee_id' => $employee->id,
            'action' => 'updated',
            'description' => "Updated employee: {$employee->name}",
            'changes' => json_encode($oldValues),
        ]);
    }

    public function deleted(Employee $employee)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'company_id' => $employee->company_id,
            'employee_id' => $employee->id,
            'action' => 'deleted',
            'description' => "Deleted employee: {$employee->name}",
        ]);
    }
}

