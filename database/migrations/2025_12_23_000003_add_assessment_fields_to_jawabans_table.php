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
        Schema::table('jawabans', function (Blueprint $table) {
            // Link jawaban ke assessment
            $table->foreignId('assessment_id')->nullable()->after('level_id')->constrained()->nullOnDelete();
            
            // Verification fields untuk auditor
            $table->enum('verification_status', ['pending', 'verified', 'needs_revision'])->default('pending')->after('jawaban');
            
            // Evidence/bukti pendukung - bisa file path atau link
            $table->string('evidence_type')->nullable()->after('verification_status'); // 'file' atau 'link'
            $table->text('evidence_path')->nullable()->after('evidence_type'); // Path file atau URL link
            $table->string('evidence_original_name')->nullable()->after('evidence_path'); // Nama asli file
            
            // Auditor notes
            $table->text('auditor_notes')->nullable()->after('evidence_original_name');
            $table->foreignId('verified_by')->nullable()->after('auditor_notes')->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawabans', function (Blueprint $table) {
            $table->dropForeign(['assessment_id']);
            $table->dropColumn('assessment_id');
            $table->dropColumn('verification_status');
            $table->dropColumn('evidence_type');
            $table->dropColumn('evidence_path');
            $table->dropColumn('evidence_original_name');
            $table->dropColumn('auditor_notes');
            $table->dropForeign(['verified_by']);
            $table->dropColumn('verified_by');
            $table->dropColumn('verified_at');
        });
    }
};
