<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignFactor6 extends Model
{
    use HasFactory;

    protected $table = 'design_factor6';

    protected $fillable = [
        'user_id',
        'importance_high',
        'importance_normal',
        'importance_low',
    ];

    protected $casts = [
        'importance_high' => 'decimal:2',
        'importance_normal' => 'decimal:2',
        'importance_low' => 'decimal:2',
    ];

    /**
     * Get the user that owns this DF6
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate scores using matrix multiplication
     * Formula: Score = (High_value × High%) + (Normal_value × Normal%) + (Low_value × Low%) / 100
     * 
     * Example for EDM01 with High=25%, Normal=75%, Low=0%:
     * Score = (3.0 × 25 + 2.0 × 75 + 1.0 × 0) / 100 = 225 / 100 = 2.25
     */
    public function calculateScores(): array
    {
        $df6MapData = Df6Map::orderBy('objective_code')->get();
        $scores = [];

        foreach ($df6MapData as $map) {
            // MMULT formula: divide by 100 to get correct score
            $score = (($map->high_value * $this->importance_high) +
                ($map->normal_value * $this->importance_normal) +
                ($map->low_value * $this->importance_low)) / 100;

            $scores[$map->objective_code] = $score;
        }

        return $scores;
    }

    /**
     * Get fixed baseline scores from specification
     * These are static values that don't change with user input
     */
    public static function calculateBaselineScores(): array
    {
        // Fixed baseline scores from specification
        return [
            'EDM01' => 2.00,
            'EDM02' => 1.00,
            'EDM03' => 2.00,
            'EDM04' => 1.00,
            'EDM05' => 1.00,
            'APO01' => 1.50,
            'APO02' => 1.00,
            'APO03' => 1.00,
            'APO04' => 1.00,
            'APO05' => 1.00,
            'APO06' => 1.00,
            'APO07' => 1.00,
            'APO08' => 1.00,
            'APO09' => 1.00,
            'APO10' => 1.00,
            'APO11' => 1.00,
            'APO12' => 2.00,
            'APO13' => 1.00,
            'APO14' => 1.50,
            'BAI01' => 1.00,
            'BAI02' => 1.00,
            'BAI03' => 1.00,
            'BAI04' => 1.00,
            'BAI05' => 1.00,
            'BAI06' => 1.00,
            'BAI07' => 1.00,
            'BAI08' => 1.00,
            'BAI09' => 1.00,
            'BAI10' => 1.00,
            'BAI11' => 1.00,
            'DSS01' => 1.00,
            'DSS02' => 1.00,
            'DSS03' => 1.00,
            'DSS04' => 1.00,
            'DSS05' => 1.00,
            'DSS06' => 1.00,
            'MEA01' => 1.00,
            'MEA02' => 1.00,
            'MEA03' => 2.00,
            'MEA04' => 2.00,
        ];
    }

    /**
     * Calculate relative importance for each objective
     * Formula: MROUND(100 × Score / Baseline, 5) - 100
     * 
     * Example for EDM01 with Score=2.25, Baseline=2.00:
     * calculated = 100 × 2.25 / 2.00 = 112.5
     * rounded = MROUND(112.5, 5) = 115
     * Relative_Importance = 115 - 100 = 15
     */
    public function calculateRelativeImportance(): array
    {
        $scores = $this->calculateScores();
        $baselineScores = self::calculateBaselineScores();
        $relativeImportance = [];

        foreach ($scores as $code => $score) {
            $baselineScore = $baselineScores[$code] ?? 1;

            if ($baselineScore == 0) {
                $relativeImportance[$code] = 0;
                continue;
            }

            // Calculate: 100 × Score / BaselineScore
            $calculated = (100 * $score) / $baselineScore;

            // MROUND to nearest 5: round(value / 5) * 5
            $rounded = round($calculated / 5) * 5;

            // Subtract 100
            $relativeImportance[$code] = $rounded - 100;
        }

        return $relativeImportance;
    }

    /**
     * Validate that importance values sum to 100
     */
    public function validateImportanceSum(): bool
    {
        $sum = $this->importance_high + $this->importance_normal + $this->importance_low;
        return abs($sum - 100.00) < 0.01; // Allow small floating point differences
    }
}
