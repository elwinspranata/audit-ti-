<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_resubmission_requests_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resubmission_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            // $table->foreignId('cobit_item_id')->constrained()->onDelete('cascade'); // Opsional, jika level unik per cobit item
            // $table->foreignId('kategori_id')->constrained()->onDelete('cascade'); // Opsional
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamp('requested_at')->useCurrent();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // ID Admin yang menyetujui
            $table->timestamp('action_at')->nullable(); // Waktu disetujui/ditolak
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->timestamps();

            $table->unique(['user_id', 'level_id', 'status'], 'user_level_pending_request_unique'); // User hanya bisa punya 1 request pending per level
        });
    }

    public function down()
    {
        Schema::dropIfExists('resubmission_requests');
    }
};
