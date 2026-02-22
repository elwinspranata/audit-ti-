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
        Schema::table('design_factors', function (Blueprint $table) {
            // Tambahkan kolom untuk input dinamis
            $table->json('inputs')->nullable()->after('factor_type');
            $table->string('factor_name')->nullable()->after('factor_type');
            $table->json('extra_data')->nullable()->after('inputs');

            // Hapus kolom spesifik DF1
            $table->dropColumn([
                'growth_importance',
                'innovation_importance',
                'cost_importance',
                'stability_importance',
                'growth_baseline',
                'innovation_baseline',
                'cost_baseline',
                'stability_baseline'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('design_factors', function (Blueprint $table) {
            $table->dropColumn(['inputs', 'factor_name', 'extra_data']);

            // Kembalikan kolom spesifik DF1
            $table->integer('growth_importance')->default(3);
            $table->integer('innovation_importance')->default(3);
            $table->integer('cost_importance')->default(3);
            $table->integer('stability_importance')->default(3);
            $table->integer('growth_baseline')->default(3);
            $table->integer('innovation_baseline')->default(3);
            $table->integer('cost_baseline')->default(3);
            $table->integer('stability_baseline')->default(3);
        });
    }
};
