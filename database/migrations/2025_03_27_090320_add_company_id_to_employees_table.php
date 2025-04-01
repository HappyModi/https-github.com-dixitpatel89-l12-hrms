<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'company_id')) {
                $table->unsignedBigInteger('company_id')->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
};
