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
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('level')->default(1)->after('price'); // 1: Basic, 2: Pro, 3: Enterprise
        });

        Schema::table('cobit_items', function (Blueprint $table) {
            $table->integer('required_level')->default(1)->after('is_visible');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('active_package_id')->nullable()->constrained('packages')->onDelete('set null')->after('subscription_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_package_id']);
            $table->dropColumn('active_package_id');
        });

        Schema::table('cobit_items', function (Blueprint $table) {
            $table->dropColumn('required_level');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
