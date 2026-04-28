<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('design_factor_items', function (Blueprint $table) {
            $table->decimal('score', 5, 2)->change();
            $table->decimal('baseline_score', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_factor_items', function (Blueprint $table) {
            $table->decimal('score', 5, 1)->change();
            $table->decimal('baseline_score', 5, 1)->change();
        });
    }
};
