<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
