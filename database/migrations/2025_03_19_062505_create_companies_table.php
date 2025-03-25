<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_email')->unique();
            $table->string('company_phone_number')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('website')->nullable();
            $table->string('industry')->nullable();
            $table->text('company_description')->nullable();
            $table->enum('company_status', ['active', 'inactive'])->default('active');
            $table->string('company_type')->nullable();
            $table->string('company_registration_number')->nullable();
            $table->string('company_tax_id')->nullable();
            $table->string('company_country')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_zip_code')->nullable();
            $table->string('company_hr_contact')->nullable();
            $table->string('company_finance_contact')->nullable();
            $table->string('company_support_email')->nullable();
            $table->string('company_support_phone')->nullable();
            $table->string('company_legal_name')->nullable();
            $table->unsignedBigInteger('company_parent_id')->nullable();
            $table->integer('company_branch_count')->default(0);
            $table->string('company_fax_number')->nullable();
            $table->string('company_social_facebook')->nullable();
            $table->string('company_social_linkedin')->nullable();
            $table->string('company_social_twitter')->nullable();
            $table->string('company_ceo_name')->nullable();
            $table->string('company_ceo_email')->nullable();
            $table->text('company_board_members')->nullable();
            $table->string('company_business_hours')->nullable();
            $table->string('company_emergency_contact')->nullable();
            $table->string('company_toll_free_number')->nullable();
            $table->text('company_insurance_details')->nullable();
            $table->string('company_bank_name')->nullable();
            $table->string('company_bank_account_no')->nullable();
            $table->string('company_ifsc_code')->nullable();
            $table->decimal('company_tax_percentage', 5, 2)->nullable();
            $table->string('company_currency')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('epfo_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('company_pan_number')->nullable();
            $table->date('founded_date')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
