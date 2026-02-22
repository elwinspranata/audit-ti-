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
        Schema::create('audit_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('auditor_id')->constrained('users')->onDelete('cascade');
            
            // Report content
            $table->text('executive_summary')->nullable(); // Ringkasan eksekutif
            $table->text('scope')->nullable(); // Ruang lingkup audit
            $table->text('methodology')->nullable(); // Metodologi audit
            $table->json('findings')->nullable(); // Temuan-temuan audit
            $table->json('recommendations')->nullable(); // Rekomendasi perbaikan
            $table->text('conclusion')->nullable(); // Kesimpulan
            
            // Scoring
            $table->integer('overall_score')->nullable(); // Skor keseluruhan (0-100)
            $table->integer('capability_level')->nullable(); // Level kapabilitas (0-5)
            
            // Status
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamp('finalized_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_reports');
    }
};
