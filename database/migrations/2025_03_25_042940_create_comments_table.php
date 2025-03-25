<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User who performed the action
            $table->unsignedBigInteger('company_id')->nullable(); // Company affected
            $table->unsignedBigInteger('employee_id')->nullable(); // Employee affected
            $table->string('action'); // Action type: created, updated, deleted
            $table->text('description'); // Details of the action
            $table->json('changes')->nullable(); // Stores old values (for updates)
            $table->timestamps(); // Time of action
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
