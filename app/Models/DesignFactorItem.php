<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignFactorItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'design_factor_id',
        'code',
        'score',
        'baseline_score',
        'relative_importance',
    ];

    protected $casts = [
        'score' => 'float',
        'baseline_score' => 'float',
        'relative_importance' => 'float',
    ];

    /**
     * Get the design factor that owns this item.
     */
    public function designFactor()
    {
        return $this->belongsTo(DesignFactor::class);
    }

    /**
     * Calculate and update relative importance
     */
    public function calculateRelativeImportance(): float
    {
        if (!$this->designFactor) {
            return 0;
        }

        $relativeImportance = $this->designFactor->calculateRelativeImportance(
            $this->score,
            $this->baseline_score
        );

        $this->relative_importance = $relativeImportance;
        $this->save();

        return $relativeImportance;
    }

    /**
     * Get display color based on relative importance value
     */
    public function getDisplayColor(): string
    {
        if ($this->relative_importance === null) {
            return 'gray';
        }

        if ($this->relative_importance > 0) {
            return 'green';
        } elseif ($this->relative_importance < 0) {
            return 'red';
        }

        return 'gray';
    }
}
