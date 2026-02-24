<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CobitItem;
use App\Models\Kategori;
use App\Models\Level;
use App\Models\Quisioner;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExcelQuisionerSeeder extends Seeder
{
    public function run()
    {
        $directory = base_path('resources/views/design-factors/KuisionerCobit/Excel Kuisioner-20260224T133802Z-1-001/Excel Kuisioner');
        $validDomains = ['EDM', 'APO', 'BAI', 'DSS', 'MEA', 'AP'];

        if (!File::exists($directory)) {
            $this->command->error("Directory not found: $directory");
            return;
        }

        $files = File::files($directory);
        $this->command->info("Found " . count($files) . " files.");

        foreach ($files as $file) {
            if (!in_array($file->getExtension(), ['xlsx', 'xls'])) continue;

            $filename = strtoupper($file->getFilename());
            $cobitCode = null;

            foreach ($validDomains as $domain) {
                if (preg_match('/' . $domain . '\s*(\d{1,2})/', $filename, $matches)) {
                    $normDomain = ($domain === 'AP') ? 'APO' : $domain;
                    $cobitCode = $normDomain . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                    break;
                }
            }
            
            if (!$cobitCode) {
                $this->command->warn("Could not extract COBIT code from filename: $filename");
                continue;
            }

            $this->command->info("Processing $filename (Code: $cobitCode)");

            try {
                $data = Excel::toArray([], $file->getRealPath());
                
                foreach ($data as $sheetIndex => $rows) {
                    if ($sheetIndex == 0) continue; 
                    
                    $levelNumber = $sheetIndex + 1;
                    if ($levelNumber > 5) continue;

                    $questionsInSheet = 0;
                    $sheetKategoriName = null;

                    foreach ($rows as $row) {
                        $questionText = $row[2] ?? null;
                        if ($this->isQuestion($questionText)) {
                            $kategoriRaw = $row[0] ?? null;
                            
                            if (!$sheetKategoriName) {
                                // Try to get a decent category name from this row or previous
                                if ($kategoriRaw && strlen($kategoriRaw) > 5 && !is_numeric($kategoriRaw)) {
                                    $sheetKategoriName = $this->cleanKategoriName($kategoriRaw, $cobitCode);
                                } else {
                                    $sheetKategoriName = "$cobitCode.01 - Management Practice";
                                }
                            }

                            // 1. CobitItem
                            $cobitItem = CobitItem::where('nama_item', $cobitCode)->first();
                            if (!$cobitItem) {
                                $cobitItem = CobitItem::create([
                                    'nama_item' => $cobitCode,
                                    'deskripsi' => "COBIT Item for $cobitCode"
                                ]);
                            }

                            // 2. Kategori
                            $kategori = Kategori::where('nama', $sheetKategoriName)->first();
                            if (!$kategori) {
                                $kategori = Kategori::create([
                                    'nama' => $sheetKategoriName,
                                    'cobit_item_id' => $cobitItem->id
                                ]);
                            }

                            // 3. Level
                            $level = Level::where('kategori_id', $kategori->id)
                                ->where('level_number', $levelNumber)
                                ->first();
                            
                            if (!$level) {
                                $level = Level::create([
                                    'kategori_id' => $kategori->id,
                                    'level_number' => $levelNumber,
                                    'nama_level' => "Level $levelNumber"
                                ]);
                            }

                            // 4. Quisioner
                            $exists = Quisioner::where('pertanyaan', trim($questionText))
                                ->where('level_id', $level->id)
                                ->exists();

                            if (!$exists) {
                                Quisioner::create([
                                    'pertanyaan' => trim($questionText),
                                    'level_id' => $level->id
                                ]);
                                $questionsInSheet++;
                            }
                        }
                    }

                    if ($questionsInSheet > 0) {
                        $this->command->info("  - Imported $questionsInSheet questions for Level $levelNumber in $sheetKategoriName");
                    }
                }

            } catch (\Exception $e) {
                $this->command->error("Error processing $filename: " . $e->getMessage());
            }
        }

        $this->command->info("Data import completed!");
    }

    private function isQuestion($text)
    {
        if (!is_string($text)) return false;
        $text = trim($text);
        return (Str::startsWith(strtolower($text), 'apakah') || Str::endsWith($text, '?'));
    }

    private function cleanKategoriName($raw, $code)
    {
        // Example: "COBIT 2019 EDM04.01 – Evaluate resource management"
        // If it starts with COBIT, try to clean it. If empty/null, use Code.
        if (empty($raw)) return "$code.01 - Default Category";
        
        $cleaned = trim($raw);
        // Replace newlines and extra spaces
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);
        
        return $cleaned;
    }
}
