<?php

namespace App\Services;

use App\Models\CobitItem;
use App\Models\Jawaban;
use App\Models\User;

class UserProgressService
{
    /**
     * Menghitung dan mengembalikan data progres untuk pengguna tertentu.
     *
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public function getProgressData(User $user)
    {
        // Ambil semua jawaban pengguna dan kelompokkan berdasarkan level_id
        $userAnswersByLevel = Jawaban::where('user_id', $user->id)
            ->get()
            ->groupBy('level_id');

        // Ambil semua Cobit Item yang relevan dengan relasi yang dibutuhkan
        $cobitItems = CobitItem::with(['kategoris.levels.quisioners'])
            ->where('is_visible', true)
            ->get();

        // Gunakan ->map() untuk memproses setiap item dan menghitung progresnya
        return $cobitItems->map(function ($item) use ($userAnswersByLevel) {

            $kategoriData = $item->kategoris->map(function ($kategori) use ($userAnswersByLevel) {

                $levelData = $kategori->levels->map(function ($level) use ($userAnswersByLevel) {

                    $totalQuisioners = $level->quisioners->count();

                    $answeredQuisioners = isset($userAnswersByLevel[$level->id])
                        ? $userAnswersByLevel[$level->id]->pluck('quisioner_id')->unique()->count()
                        : 0;

                    $isCompleted = ($totalQuisioners > 0) && ($answeredQuisioners >= $totalQuisioners);

                    // --- PERBAIKAN DI SINI ---
                    return [
                        'id' => $level->id,
                        'nama_level' => $level->nama_level,
                        'total_quisioners' => $totalQuisioners,
                        'answered_quisioners' => $answeredQuisioners,
                        'is_completed' => $isCompleted,
                        // Mengganti 'progress_percentage' menjadi 'percentage' agar cocok dengan view
                        'percentage' => ($totalQuisioners > 0) ? round(($answeredQuisioners / $totalQuisioners) * 100) : 0,
                    ];
                });

                return [
                    'id' => $kategori->id,
                    'nama_kategori' => $kategori->nama,
                    'levels' => $levelData,
                    'total_levels_in_kategori' => $levelData->count(),
                    'completed_levels_in_kategori' => $levelData->where('is_completed', true)->count(),
                ];
            });

            // Hitung total level untuk keseluruhan item ini
            $totalLevelsInItem = 0;
            $completedLevelsInItem = 0;

            foreach ($kategoriData as $kategori) {
                $totalLevelsInItem += $kategori['total_levels_in_kategori'];
                $completedLevelsInItem += $kategori['completed_levels_in_kategori'];
            }

            return [
                'id' => $item->id,
                'nama_item' => $item->nama_item,
                'kategoris' => $kategoriData,
                'total_levels_in_item' => $totalLevelsInItem,
                'completed_levels_in_item' => $completedLevelsInItem,
            ];
        });
    }
}
