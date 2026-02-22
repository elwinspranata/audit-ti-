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
        // Tabel untuk menyimpan Strategic Objectives (input DF1)
        Schema::create('design_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('factor_type')->default('DF1');

            // Strategic Objectives - Importance (1-5)
            $table->integer('growth_importance')->default(3);
            $table->integer('innovation_importance')->default(3);
            $table->integer('cost_importance')->default(3);
            $table->integer('stability_importance')->default(3);

            // Strategic Objectives - Baseline (1-5)
            $table->integer('growth_baseline')->default(3);
            $table->integer('innovation_baseline')->default(3);
            $table->integer('cost_baseline')->default(3);
            $table->integer('stability_baseline')->default(3);

            $table->timestamps();
        });

        // Tabel untuk menyimpan Governance/Management Objectives scores
        Schema::create('design_factor_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('design_factor_id')->constrained()->onDelete('cascade');
            $table->string('code'); // EDM01, APO01, etc.
            $table->decimal('score', 5, 1)->default(0); // Score value
            $table->decimal('baseline_score', 5, 1)->default(0); // Baseline Score value
            $table->decimal('relative_importance', 8, 2)->nullable(); // Calculated Relative Importance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_factor_items');
        Schema::dropIfExists('design_factors');
    }
};
