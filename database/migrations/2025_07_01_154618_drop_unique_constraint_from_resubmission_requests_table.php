<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resubmission_requests', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                // 1. Hapus foreign key yang ada terlebih dahulu.
                $table->dropForeign(['user_id']);
                $table->dropForeign(['level_id']);

                // 2. Sekarang, hapus index unik yang menyebabkan error.
                $table->dropUnique('user_level_pending_request_unique');

                // 3. Buat kembali foreign key yang tadi dihapus.
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resubmission_requests', function (Blueprint $table) {
            // Jika Anda ingin mengembalikan constraint saat rollback, tambahkan kode ini.
            $table->unique(['user_id', 'level_id', 'status'], 'user_level_pending_request_unique');
        });
    }
};
