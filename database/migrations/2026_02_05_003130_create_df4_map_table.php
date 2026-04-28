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
        Schema::create('df4_map', function (Blueprint $table) {
            $table->id();
            $table->string('objective_code')->unique();
            // 20 Input columns for IT Related Issues
            $table->float('it01')->default(0);
            $table->float('it02')->default(0);
            $table->float('it03')->default(0);
            $table->float('it04')->default(0);
            $table->float('it05')->default(0);
            $table->float('it06')->default(0);
            $table->float('it07')->default(0);
            $table->float('it08')->default(0);
            $table->float('it09')->default(0);
            $table->float('it10')->default(0);
            $table->float('it11')->default(0);
            $table->float('it12')->default(0);
            $table->float('it13')->default(0);
            $table->float('it14')->default(0);
            $table->float('it15')->default(0);
            $table->float('it16')->default(0);
            $table->float('it17')->default(0);
            $table->float('it18')->default(0);
            $table->float('it19')->default(0);
            $table->float('it20')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('df4_map');
    }
};
