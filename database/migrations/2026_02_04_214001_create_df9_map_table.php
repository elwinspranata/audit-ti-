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
        Schema::create('df9_map', function (Blueprint $table) {
            $table->id();
            $table->string('objective_code');
            $table->decimal('agile', 8, 1)->default(1.0);
            $table->decimal('devops', 8, 1)->default(1.0);
            $table->decimal('traditional', 8, 1)->default(1.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('df9_map');
    }
};
