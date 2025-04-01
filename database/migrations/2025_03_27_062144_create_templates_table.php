<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Offer Letter, Appointment Letter, etc.
            $table->text('letter_body'); // Letter content with placeholders
            $table->unsignedBigInteger('company_id'); // Company ID for multi-company support
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};

