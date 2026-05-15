<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('label');           // e.g. "LAYANAN 1"
            $table->string('title');            // e.g. "Layanan Test Design Factor..."
            $table->text('description');        // Main description paragraph
            $table->text('description2')->nullable(); // Second description paragraph
            $table->json('features');           // Array of {name, detail}
            $table->text('closing_note')->nullable(); // Italic closing note
            $table->string('icon')->default('clipboard'); // Icon identifier
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_types');
    }
};
