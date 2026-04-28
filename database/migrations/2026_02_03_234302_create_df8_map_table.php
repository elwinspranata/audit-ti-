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
        Schema::create('df8_map', function (Blueprint $table) {
            $table->id();
            $table->string('objective_code');
            $table->decimal('outsourcing', 8, 1)->default(1.0);
            $table->decimal('cloud', 8, 1)->default(1.0);
            $table->decimal('insourcing', 8, 1)->default(1.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('df8_map');
    }
};
