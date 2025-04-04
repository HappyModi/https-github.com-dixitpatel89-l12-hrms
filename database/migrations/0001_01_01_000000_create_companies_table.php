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
            $table->string('logo')->nullable();
            $table->string('letterhead')->nullable();
            $table->string('company_email')->unique();
            $table->string('company_phone_number')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('website')->nullable();
            $table->string('industry')->nullable();
            $table->text('company_description')->nullable();
            $table->enum('company_status', ['active', 'inactive'])->default('active');
            $table->string('company_country')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_zip_code')->nullable();
            // $table->unsignedBigInteger('company_parent_id')->nullable();
            $table->string('company_bank_name')->nullable();
            $table->string('company_bank_account_no')->nullable();
            $table->string('company_ifsc_code')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('epfo_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('company_pan_number')->nullable();
            $table->date('founded_date')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
