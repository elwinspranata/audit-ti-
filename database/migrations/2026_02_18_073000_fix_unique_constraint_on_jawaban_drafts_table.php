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
        Schema::table('jawaban_drafts', function (Blueprint $table) {
            // Add new unique constraint including assessment_id
            $table->unique(['user_id', 'level_id', 'assessment_id'], 'jawaban_drafts_user_id_level_id_assessment_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_drafts', function (Blueprint $table) {
            $table->dropUnique('jawaban_drafts_user_id_level_id_assessment_id_unique');
            $table->unique(['user_id', 'level_id']);
        });
    }
};
