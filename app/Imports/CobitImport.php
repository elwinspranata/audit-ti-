<?php

namespace App\Imports;

use App\Models\CobitItem;
use App\Models\Kategori;
use App\Models\Level;
use App\Models\Quisioner;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class CobitImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            // 1. Cari atau buat CobitItem (tidak akan ada duplikat nama_item)
            $cobitItem = CobitItem::firstOrCreate(
                ['nama_item' => trim($row['nama_item'])],
                ['deskripsi' => $row['deskripsi'] ?? 'Tidak ada deskripsi.']
            );

            // 2. Cari atau buat Kategori di dalam CobitItem tersebut
            $kategori = Kategori::firstOrCreate(
                [
                    'nama' => trim($row['nama_kategori']),
                    'cobit_item_id' => $cobitItem->id
                ]
            );

            // 3. Cari atau buat Level di dalam Kategori tersebut (Mencegah duplikasi Level)
            $level = Level::firstOrCreate(
                [
                    'level_number' => trim($row['level_number']),
                    'kategori_id' => $kategori->id,
                ],
                [
                    // 'nama_level' akan diisi hanya jika record baru dibuat
                    'nama_level' => $row['nama_level'] ?? ('Level ' . trim($row['level_number']))
                ]
            );

            // 4. Buat Quisioner baru untuk Level tersebut
            // Kita tidak menggunakan firstOrCreate di sini karena setiap pertanyaan adalah unik
            Quisioner::create([
                'pertanyaan' => trim($row['pertanyaan']),
                'level_id' => $level->id,
            ]);

            // 5. Logika pembuatan Jawaban dihapus karena tidak sesuai alur.
            // Jawaban dibuat oleh pengguna, bukan saat impor data.
        }
    }

    /**
     * Aturan validasi untuk setiap baris.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama_item' => 'required|string',
            'nama_kategori' => 'required|string',
            'level_number' => 'required|integer',
            'pertanyaan' => 'required|string',
        ];
    }
}
