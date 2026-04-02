<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add department_id to sub_departments
        try {
            Schema::table('sub_departments', function (Blueprint $table) {
                $table->unsignedBigInteger('department_id')->nullable()->after('company_id');
            });
        } catch (\Exception $e) {
            // Column may already exist
        }

        // Add sub_department_id to employees
        try {
            Schema::table('employees', function (Blueprint $table) {
                $table->unsignedBigInteger('sub_department_id')->nullable()->after('department_id');
            });
        } catch (\Exception $e) {
            // Column may already exist
        }
    }

    public function down(): void
    {
        try {
            Schema::table('sub_departments', function (Blueprint $table) {
                $table->dropColumn('department_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('sub_department_id');
            });
        } catch (\Exception $e) {}
    }
};
