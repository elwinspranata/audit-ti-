<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CobitItem extends Model
{
    use HasFactory;

    protected $fillable = ['nama_item', 'deskripsi', 'is_visible', 'required_level'];

    // Relasi ke Kategori
    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }

    /**
     * Boot method untuk handle delete cascade
     */
    protected static function boot()
    {
        parent::boot();

        // Event listener ketika model akan dihapus
        static::deleting(function ($cobitItem) {
            // Hapus semua kategori yang terkait terlebih dahulu
            $cobitItem->kategoris()->delete();
        });
    }

    /**
     * Memeriksa apakah semua level yang diperlukan untuk CobitItem ini
     * telah diselesaikan oleh pengguna yang diberikan.
     *
     * @param User $user Pengguna yang akan diperiksa.
     * @return bool True jika selesai, false jika belum.
     */
    public function isCompletedByUser(User $user): bool
    {
        // 1. Ambil SEMUA ID level yang DIBUTUHKAN untuk Cobit Item ini.
        $requiredLevelIds = $this->kategoris()
            ->with('levels') // Eager load levels dari kategori
            ->get()
            ->pluck('levels.*.id') // Pluck semua ID level
            ->flatten() // Ratakan array
            ->filter() // Hapus nilai null
            ->unique();

        // Jika tidak ada level yang dibutuhkan sama sekali, anggap belum selesai.
        if ($requiredLevelIds->isEmpty()) {
            return false;
        }

        // 2. Ambil SEMUA ID level yang SUDAH DIKERJAKAN oleh user untuk domain ini.
        $completedLevelIds = $user->jawabans()
            ->whereIn('level_id', $requiredLevelIds->all())
            ->pluck('level_id')
            ->unique();

        // 3. Bandingkan. Jika tidak ada level yang hilang, berarti selesai.
        $missingLevels = $requiredLevelIds->diff($completedLevelIds);

        return $missingLevels->isEmpty();
    }
}
