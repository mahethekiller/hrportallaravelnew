<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sidebar_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Display name: "Employees"
            $table->string('slug')->unique(); // Unique key: "employees"
            $table->string('icon');           // Bootstrap icon: "bi-people"
            $table->string('route');          // Route name: "employees.index"
            $table->string('active_match');   // URL match pattern for active state
            $table->string('section')->default('general'); // Section group: "core_hr", "recruitment"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_external')->default(false); // Opens in new tab
            $table->timestamps();
        });

        Schema::create('role_sidebar_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('sidebar_module_id');
            $table->timestamps();
            $table->unique(['role_id', 'sidebar_module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_sidebar_modules');
        Schema::dropIfExists('sidebar_modules');
    }
};
