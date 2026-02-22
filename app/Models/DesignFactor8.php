<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignFactor8 extends Model
{
    use HasFactory;

    protected $table = 'design_factor8';

    protected $fillable = [
        'user_id',
        'importance_outsourcing',
        'importance_cloud',
        'importance_insourced',
    ];

    protected $casts = [
        'importance_outsourcing' => 'decimal:2',
        'importance_cloud' => 'decimal:2',
        'importance_insourced' => 'decimal:2',
    ];

    /**
     * Get the user that owns this DF8
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate scores using matrix multiplication
     * Score = MMULT(DF8map, Importance)
     */
    public function calculateScores(): array
    {
        $df8MapData = Df8Map::orderBy('objective_code')->get();
        $scores = [];

        foreach ($df8MapData as $map) {
            $score = ($map->outsourcing * $this->importance_outsourcing) +
                ($map->cloud * $this->importance_cloud) +
                ($map->insourcing * $this->importance_insourced);

            $scores[$map->objective_code] = $score / 100; // Dividing by 100 because importance is in %
        }

        return $scores;
    }

    /**
     * Calculate baseline scores using fixed baseline values
     * Baseline: Outsourcing=33%, Cloud=33%, Insourced=34%
     */
    public static function calculateBaselineScores(): array
    {
        $df8MapData = Df8Map::orderBy('objective_code')->get();
        $baselineScores = [];

        $baselineOutsourcing = 33.00;
        $baselineCloud = 33.00;
        $baselineInsourced = 34.00;

        foreach ($df8MapData as $map) {
            $baselineScore = ($map->outsourcing * $baselineOutsourcing) +
                ($map->cloud * $baselineCloud) +
                ($map->insourcing * $baselineInsourced);

            $baselineScores[$map->objective_code] = $baselineScore / 100;
        }

        return $baselineScores;
    }

    /**
     * Calculate relative importance for each objective
     * Formula: IFERROR(MROUND((100*Score/BaselineScore);5)-100;0)
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

            // Calculate: 100 * Score / BaselineScore
            $calculated = (100 * $score) / $baselineScore;

            // MROUND to nearest 5
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
        $sum = $this->importance_outsourcing + $this->importance_cloud + $this->importance_insourced;
        return abs($sum - 100.00) < 0.01;
    }
}
