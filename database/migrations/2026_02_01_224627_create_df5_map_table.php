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
        Schema::create('df5_map', function (Blueprint $table) {
            $table->id();
            $table->string('objective_code', 10)->unique(); // EDM01, APO01, etc.
            $table->decimal('high_value', 3, 1); // 1.0, 2.0, 3.0, 4.0
            $table->decimal('normal_value', 3, 1); // 1.0, 2.0, 3.0, 4.0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('df5_map');
    }
};
