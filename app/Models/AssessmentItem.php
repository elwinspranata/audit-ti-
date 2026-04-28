<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jawaban;

class AssessmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'cobit_item_id',
        'is_completed',
        'progress_percentage',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    /**
     * Relasi ke Assessment
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Relasi ke CobitItem
     */
    public function cobitItem()
    {
        return $this->belongsTo(CobitItem::class);
    }

    /**
     * Hitung progress untuk item ini
     */
    public function calculateProgress(): int
    {
        $assessment = $this->assessment;
        $cobitItem = $this->cobitItem;

        if (!$assessment || !$cobitItem) {
            return 0;
        }

        $totalQuestions = 0;
        $answeredQuestions = 0;

        foreach ($cobitItem->kategoris as $kategori) {
            foreach ($kategori->levels as $level) {
                $questionCount = $level->quisioners->count();
                $totalQuestions += $questionCount;

                $answeredCount = $assessment->jawabans()
                    ->where('level_id', $level->id)
                    ->count();
                $answeredQuestions += min($answeredCount, $questionCount);
            }
        }

        if ($totalQuestions === 0) {
            return 0;
        }

        return (int) round(($answeredQuestions / $totalQuestions) * 100);
    }

    /**
     * Check if this item has any answers needing revision
     */
    public function hasNeedsRevision(): bool
    {
        return Jawaban::where('assessment_id', $this->assessment_id)
            ->whereIn('level_id', $this->cobitItem->kategoris->flatMap(function($k) {
                return $k->levels;
            })->pluck('id'))
            ->where('verification_status', 'needs_revision')
            ->exists();
    }

    /**
     * Get progress attribute
     */
    public function getProgressAttribute(): int
    {
        return $this->progress_percentage;
    }

    /**
     * Hitung level maturitas (0-5) untuk item ini
     */
    public function calculateMaturityLevel(): int
    {
        $assessment = $this->assessment;
        $cobitItem = $this->cobitItem;

        if (!$assessment || !$cobitItem) {
            return 0;
        }

        $allLevels = [];
        foreach ($cobitItem->kategoris as $kategori) {
            foreach ($kategori->levels as $level) {
                // Extract level number from name (e.g. "Level 3" -> 3)
                $lvlNum = (int) filter_var($level->nama_level, FILTER_SANITIZE_NUMBER_INT);
                if ($lvlNum === 0) continue;

                $questionCount = $level->quisioners->count();
                $answeredCount = $assessment->jawabans()
                    ->where('level_id', $level->id)
                    ->count();
                
                $isCompleted = ($questionCount > 0 && $answeredCount >= $questionCount);
                
                if (!isset($allLevels[$lvlNum])) $allLevels[$lvlNum] = true;
                if (!$isCompleted) $allLevels[$lvlNum] = false;
            }
        }

        $maturityLevel = 0;
        for ($i = 1; $i <= 5; $i++) {
            if (isset($allLevels[$i]) && $allLevels[$i] === true) {
                $maturityLevel = $i;
            } else {
                break;
            }
        }

        return $maturityLevel;
    }

    /**
     * Update progress dan status completion
     */
    public function updateProgress(): void
    {
        $progress = $this->calculateProgress();
        $this->progress_percentage = $progress;
        $this->is_completed = $progress >= 100;
        $this->save();
    }
}
