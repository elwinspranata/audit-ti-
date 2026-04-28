<?php

namespace App\Imports;

use App\Models\Level;
use App\Models\Quisioner;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

// Kelas ini akan menangani impor untuk satu sheet (misal: "Level 1")
class QuisionerSheetImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private $level;

    public function __construct(Level $level)
    {
        $this->level = $level;
    }

    /**
    * @param array $row
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Maatwebsite/Excel secara otomatis mengubah "Question Text" menjadi "question_text"
        $questionText = $row['question_text'] ?? null;

        if (empty(trim($questionText))) {
            return null; // Lewati baris ini jika pertanyaan kosong
        }

        // Buat kuesioner baru yang berelasi dengan level yang sudah ditemukan/dibuat
        return new Quisioner([
            'pertanyaan' => trim($questionText),
            'level_id'   => $this->level->id,
        ]);
    }
}

// Kelas utama ini akan memetakan setiap sheet ke kelas QuisionerSheetImport
class QuisionerImport implements WithMultipleSheets
{
    protected $kategoriId;

    public function __construct(int $kategoriId)
    {
        $this->kategoriId = $kategoriId;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Loop untuk 5 level, sesuai nama sheet di Excel Anda
        for ($i = 1; $i <= 5; $i++) {

            // Gunakan firstOrCreate untuk mencari Level berdasarkan nomor dan kategori.
            // Jika tidak ditemukan, Level baru akan dibuat.
            $level = Level::firstOrCreate(
                [
                    'kategori_id' => $this->kategoriId,
                    'level_number' => $i,
                ],
                [
                    // PERBAIKAN: Nama level sekarang hanya "Level 1", "Level 2", dst.
                    'nama_level' => 'Level ' . $i,
                ]
            );

            // Buat importer untuk sheet yang sesuai dengan level yang ditemukan/dibuat
            $sheets['Level ' . $i] = new QuisionerSheetImport($level);
        }

        return $sheets;
    }

    // Method getDefaultLevelName() dihapus karena tidak lagi digunakan.
}
