<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Define tables that need the company_id column
        $tables = ['employees', 'users', 'templates']; // Add more tables if needed

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'company_id')) {
                    $table->unsignedBigInteger('company_id')->after('id');
                    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        $tables = ['employees', 'users', 'templates'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'company_id')) {
                    $table->dropForeign([$table . '_company_id_foreign']);
                    $table->dropColumn('company_id');
                }
            });
        }
    }
};
