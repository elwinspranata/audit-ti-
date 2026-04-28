<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Df10Map extends Model
{
    use HasFactory;

    protected $table = 'df10_map';

    protected $fillable = [
        'objective_code',
        'first_mover',
        'follower',
        'slow_adopter',
    ];
}
