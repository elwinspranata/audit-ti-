<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelNumberToLevelsTable extends Migration
{
    /**
     * Jalankan migration untuk menambahkan kolom level_number.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->integer('level_number')->after('kategori_id');  // Menambahkan kolom level_number setelah kategori_id
        });
    }

    /**
     * Rollback migration jika diperlukan.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('level_number');  // Menghapus kolom level_number
        });
    }
}
