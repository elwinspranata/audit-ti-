<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            $table->enum('jawaban', ['N', 'P', 'L', 'F']); // Kolom untuk jawaban N, P, L, F
            $table->foreignId('quisioner_id')->constrained('quisioners')->onDelete('cascade'); // Relasi ke quisioners
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade'); // Relasi ke users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawabans');
    }
}
