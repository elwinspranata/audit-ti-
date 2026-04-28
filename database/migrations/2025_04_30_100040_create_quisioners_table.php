<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuisionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quisioners', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade'); // Relasi dengan tabel levels
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
        Schema::dropIfExists('quisioners');
    }
}
