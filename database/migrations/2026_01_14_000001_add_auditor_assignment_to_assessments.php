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
        Schema::table('assessments', function (Blueprint $table) {
            // Auditor yang ditugaskan untuk assessment ini
            $table->foreignId('assigned_auditor_id')
                ->nullable()
                ->after('verified_at')
                ->constrained('users')
                ->nullOnDelete();
            
            // Waktu auditor ditugaskan
            $table->timestamp('assigned_at')->nullable()->after('assigned_auditor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropForeign(['assigned_auditor_id']);
            $table->dropColumn(['assigned_auditor_id', 'assigned_at']);
        });
    }
};
