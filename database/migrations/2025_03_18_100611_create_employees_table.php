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
            $table->id();
            $table->unsignedBigInteger('company_id');
            // Roles can be stored in various ways. Here, we store them as JSON or text
            $table->text('roles')->nullable(); // e.g. ["Super Admin","Employee"]

            // Personal Information
            $table->string('full_name')->nullable();
            $table->string('employee_email')->unique();
            $table->string('phone_number')->nullable();
            $table->decimal('salary', 10, 2)->nullable();

            // Emergency Contact
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_name')->nullable();

            // Address Details
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();

            // Employee Details (files, etc.)
            $table->string('profile_image')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('identity_proof')->nullable();
            $table->string('pancard_image')->nullable();

            // Bank Details
            $table->string('bank_detail_photo')->nullable();
            $table->string('bank_holder_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('ifsc_code')->nullable();

            // Educational Details (file uploads)
            $table->string('ssc_marksheet')->nullable();
            $table->string('hsc_marksheet')->nullable();
            $table->string('graduation_marksheet')->nullable();
            $table->string('master_degree_marksheet')->nullable();

            // Position
            $table->date('employment_date')->nullable();
            $table->date('release_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
