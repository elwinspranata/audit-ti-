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
            $table->foreignId('assessment_id')->nullable()->after('level_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_drafts', function (Blueprint $table) {
            $table->dropForeign(['assessment_id']);
            $table->dropColumn('assessment_id');
        });
    }
};
