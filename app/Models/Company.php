<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id','company_name', 'company_email','letterhead','company_phone_number',
        'address_line_1', 'address_line_2', 'website', 'industry',
        'company_description', 'company_status','company_country',
        'company_city', 'company_state', 'company_zip_code', 'company_bank_name',
        'company_bank_account_no', 'company_ifsc_code','gst_number', 'epfo_number', 'cin_number',
        'company_pan_number', 'founded_date', 'logo'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'user_id');
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


}

