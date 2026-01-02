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
        Schema::create('assessment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('cobit_item_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false); // Apakah semua questionnaire sudah diisi
            $table->integer('progress_percentage')->default(0); // Persentase progress
            $table->timestamps();
            
            // Unique constraint: satu assessment tidak boleh punya duplicate cobit item
            $table->unique(['assessment_id', 'cobit_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_items');
    }
};
