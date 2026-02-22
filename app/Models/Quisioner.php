<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quisioner extends Model
{
    use HasFactory;

    protected $fillable = ['pertanyaan', 'jawaban', 'level_id'];  // Pastikan pertanyaan dan level_id bisa diisi

    // Relasi ke Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relasi ke Jawaban
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
