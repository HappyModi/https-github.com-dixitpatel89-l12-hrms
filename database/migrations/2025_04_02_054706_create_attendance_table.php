<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->decimal('ctc', 10, 2)->default(0);
            $table->decimal('performance_bonus', 10, 2)->default(0);
            $table->decimal('leave_encashment', 10, 2)->default(0);
            $table->integer('month_workdays')->default(30);
            $table->decimal('leave_credits', 10, 2)->default(0);
            $table->integer('lop_days')->default(0);
            $table->integer('paid_days')->default(30);
            $table->decimal('variable_pay', 10, 2)->default(0);
            $table->decimal('basic', 10, 2)->default(0);
            $table->decimal('rent_allowance', 10, 2)->default(0);
            $table->decimal('special_allowance', 10, 2)->default(0);
            $table->decimal('travel_leave_allowance', 10, 2)->default(0);
            $table->decimal('total_earning', 10, 2)->default(0);
            $table->decimal('professional_tax', 10, 2)->default(0);
            $table->decimal('tds', 10, 2)->default(0);
            $table->decimal('loss_of_pay', 10, 2)->default(0);
            $table->decimal('total_deduction', 10, 2)->default(0);
            $table->decimal('final_pay', 10, 2)->default(0);
            $table->decimal('leave_balance', 10, 2)->default(0);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance');
    }
};
