<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/xxxx_xx_xx_xxxxxx_add_extra_fields_to_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->string('phone_number')->nullable()->after('email');
    $table->string('company_name')->nullable()->after('phone_number');
    $table->string('department')->nullable()->after('company_name');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
