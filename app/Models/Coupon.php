<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'starts_at',
        'expires_at',
        'usage_limit',
        'used_count',
        'is_active',
        'package_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function isValid($packageId = null)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->package_id !== null && $packageId !== null && $this->package_id != $packageId) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return ($this->value / 100) * $amount;
        }

        return min($this->value, $amount);
    }
}
