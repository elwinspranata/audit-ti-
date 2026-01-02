<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanDraft extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'level_id', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Level
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
