<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CompanyObserver
{
    public function created(Company $company)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
            'action' => 'created',
            'description' => "New company added: {$company->company_name}",
        ]);
    }

    public function updated(Company $company)
    {
        $changes = $company->getChanges();
        $oldValues = [];

        foreach ($changes as $field => $newValue) {
            $oldValues[$field] = $company->getOriginal($field);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
            'action' => 'updated',
            'description' => "Updated company: {$company->company_name}",
            'changes' => json_encode($oldValues),
        ]);
    }

    public function deleted(Company $company)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
            'action' => 'deleted',
            'description' => "Deleted company: {$company->company_name}",
        ]);
    }
}
