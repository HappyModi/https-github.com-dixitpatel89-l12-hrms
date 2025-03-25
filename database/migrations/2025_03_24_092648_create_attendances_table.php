<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->integer('previous_month_working_days')->default(0);
            $table->integer('previous_month_leave_days')->default(0);
            $table->integer('current_month_working_days');
            $table->integer('current_month_leave_days');
            $table->string('month', 20); // Example: "March 2025"
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('attendances');
    }
};

