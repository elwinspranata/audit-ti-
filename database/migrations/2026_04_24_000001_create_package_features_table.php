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
        // Add is_active and is_popular columns to packages table
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('duration_days');
            $table->boolean('is_popular')->default(false)->after('is_active');
        });

        // Create package_features table
        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->string('feature_name');
            $table->boolean('is_included')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_features');

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'is_popular']);
        });
    }
};
