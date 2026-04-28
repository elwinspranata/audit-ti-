<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'level',
        'description',
        'duration_days',
        'is_active',
        'is_popular',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Relasi ke fitur-fitur paket
     */
    public function features()
    {
        return $this->hasMany(PackageFeature::class)->orderBy('sort_order');
    }

    /**
     * Relasi ke transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi ke kupon
     */
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * Scope: hanya paket aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
