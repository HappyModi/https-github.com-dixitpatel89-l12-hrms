<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->text('letter_body')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->text('letter_body')->change(); // Revert changes if needed
        });
    }
};
