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
        'company_description', 'company_status', 'company_type',
        'company_registration_number', 'company_tax_id', 'company_country',
        'company_city', 'company_state', 'company_zip_code', 'company_hr_contact',
        'company_finance_contact', 'company_support_email', 'company_support_phone',
        'company_legal_name', 'company_parent_id', 'company_branch_count',
        'company_fax_number', 'company_social_facebook', 'company_social_linkedin',
        'company_social_twitter', 'company_ceo_name', 'company_ceo_email',
        'company_board_members', 'company_business_hours', 'company_emergency_contact',
        'company_toll_free_number', 'company_insurance_details', 'company_bank_name',
        'company_bank_account_no', 'company_ifsc_code', 'company_tax_percentage',
        'company_currency', 'gst_number', 'epfo_number', 'cin_number',
        'company_pan_number', 'founded_date', 'logo'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function templates()
    {
        return $this->hasMany(Template::class);
    }

}

