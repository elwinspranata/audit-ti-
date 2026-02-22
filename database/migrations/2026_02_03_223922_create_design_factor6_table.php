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
        Schema::create('design_factor6', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('importance_high', 5, 2)->default(33.33); // Percentage (0-100)
            $table->decimal('importance_normal', 5, 2)->default(33.33); // Percentage (0-100)
            $table->decimal('importance_low', 5, 2)->default(33.34); // Percentage (0-100)
            $table->timestamps();

            // One DF6 per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_factor6');
    }
};
