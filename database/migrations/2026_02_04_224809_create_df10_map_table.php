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
        Schema::create('df10_map', function (Blueprint $table) {
            $table->id();
            $table->string('objective_code', 10);
            $table->decimal('first_mover', 8, 2);
            $table->decimal('follower', 8, 2);
            $table->decimal('slow_adopter', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('df10_map');
    }
};
