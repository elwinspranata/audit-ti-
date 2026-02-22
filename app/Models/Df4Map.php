<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Df4Map extends Model
{
    use HasFactory;

    protected $table = 'df4_map';

    protected $fillable = [
        'objective_code',
        'it01',
        'it02',
        'it03',
        'it04',
        'it05',
        'it06',
        'it07',
        'it08',
        'it09',
        'it10',
        'it11',
        'it12',
        'it13',
        'it14',
        'it15',
        'it16',
        'it17',
        'it18',
        'it19',
        'it20',
    ];

    protected $casts = [
        'it01' => 'float',
        'it02' => 'float',
        'it03' => 'float',
        'it04' => 'float',
        'it05' => 'float',
        'it06' => 'float',
        'it07' => 'float',
        'it08' => 'float',
        'it09' => 'float',
        'it10' => 'float',
        'it11' => 'float',
        'it12' => 'float',
        'it13' => 'float',
        'it14' => 'float',
        'it15' => 'float',
        'it16' => 'float',
        'it17' => 'float',
        'it18' => 'float',
        'it19' => 'float',
        'it20' => 'float',
    ];
}
