<?php

// app/Models/ResubmissionRequest.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResubmissionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level_id',
        'status',
        'requested_at',
        'approved_by',
        'action_at',
        'admin_notes',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'action_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
