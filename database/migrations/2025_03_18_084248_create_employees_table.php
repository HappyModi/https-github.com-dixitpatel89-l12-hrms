<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('full_name', 100);
            $table->string('employee_email', 255)->unique();
            $table->string('position')->nullable();
            $table->string('phone_number', 20);
            $table->string('alternate_phone', 20)->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('nationality', 100)->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('work_location')->nullable();
            $table->string('shift_timings')->nullable();
            $table->decimal('bonus', 10, 2)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code', 50)->nullable();
            $table->string('pan_number', 50)->nullable();
            $table->string('aadhar_number', 50)->nullable();
            $table->string('gst_number', 50)->nullable();
            $table->string('uan_number', 50)->nullable();
            $table->string('esic_number', 50)->nullable();
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->string('project_assigned')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->string('github_profile')->nullable();
            $table->string('driving_license_number')->nullable();
            $table->date('join_date');
            $table->integer('probation_period')->nullable();
            $table->date('probation_end_date')->nullable();
            $table->date('confirmation_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->date('last_working_date')->nullable();
            $table->integer('leave_balance')->default(0);
            $table->string('profile_image')->nullable();
            $table->decimal('salary', 10, 2);
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
