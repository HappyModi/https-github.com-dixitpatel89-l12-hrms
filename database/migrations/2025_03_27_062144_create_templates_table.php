<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // Company ID for multi-company support
            $table->string('name')->nullable(); // Offer Letter, Appointment Letter, etc.
            $table->text('letter_body')->nullable(); // Letter content with placeholders
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};

