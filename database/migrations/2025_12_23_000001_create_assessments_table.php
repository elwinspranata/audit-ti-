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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable(); // Nama assessment
            $table->enum('status', [
                'pending_submission', // User sedang memilih proses TI
                'pending_approval',   // Menunggu approval admin
                'approved',           // Disetujui admin, user bisa mulai mengisi
                'in_progress',        // User sedang mengisi questionnaire
                'completed',          // User selesai mengisi, menunggu verifikasi auditor
                'verified',           // Auditor sudah verifikasi
                'rejected'            // Ditolak admin
            ])->default('pending_submission');
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('submitted_at')->nullable(); // Waktu user submit untuk approval
            $table->timestamp('completed_at')->nullable(); // Waktu user selesai mengisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
