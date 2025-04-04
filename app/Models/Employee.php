<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'roles',
        'full_name',
        'employee_email',
        'phone_number',
        'salary',
        'emergency_contact',
        'emergency_contact_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'profile_image',
        'address_proof',
        'identity_proof',
        'pancard_image',
        'bank_detail_photo',
        'bank_holder_name',
        'bank_account_number',
        'bank_branch_name',
        'ifsc_code',
        'ssc_marksheet',
        'hsc_marksheet',
        'graduation_marksheet',
        'master_degree_marksheet',
        'employment_date',
        'release_date',
        'status',
    ];

    // If you store roles as JSON, you can decode them automatically
    public function getRolesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setRolesAttribute($value)
    {
        $this->attributes['roles'] = json_encode($value);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'employee_id');
    }

}
