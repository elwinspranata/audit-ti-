<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'admin_notes',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'verified_by',
        'verified_at',
        'submitted_at',
        'completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'verified_at' => 'datetime',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING_SUBMISSION = 'pending_submission';
    const STATUS_PENDING_APPROVAL = 'pending_approval';
    const STATUS_APPROVED = 'approved';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';

    /**
     * Relasi ke User pemilik assessment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke AssessmentItem
     */
    public function items()
    {
        return $this->hasMany(AssessmentItem::class);
    }

    /**
     * Relasi ke CobitItems melalui AssessmentItem
     */
    public function cobitItems()
    {
        return $this->belongsToMany(CobitItem::class, 'assessment_items')
            ->withPivot('is_completed', 'progress_percentage')
            ->withTimestamps();
    }

    /**
     * Relasi ke Jawaban dalam assessment ini
     */
    public function jawabans()
    {
        return $this->hasMany(Jawaban::class);
    }

    /**
     * Relasi ke Admin yang approve
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relasi ke Auditor yang verifikasi
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check apakah assessment bisa diedit oleh user
     */
    public function canBeEdited(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING_SUBMISSION,
            self::STATUS_APPROVED,
            self::STATUS_IN_PROGRESS,
        ]);
    }

    /**
     * Check apakah user sudah punya assessment aktif
     */
    public static function hasActiveAssessment($userId): bool
    {
        return self::where('user_id', $userId)
            ->whereNotIn('status', [self::STATUS_VERIFIED, self::STATUS_REJECTED])
            ->exists();
    }

    /**
     * Get assessment aktif user
     */
    public static function getActiveAssessment($userId)
    {
        return self::where('user_id', $userId)
            ->whereNotIn('status', [self::STATUS_VERIFIED, self::STATUS_REJECTED])
            ->first();
    }

    /**
     * Hitung progress keseluruhan assessment
     */
    public function calculateProgress(): int
    {
        $items = $this->items()->with('cobitItem.kategoris.levels.quisioners')->get();
        
        if ($items->isEmpty()) {
            return 0;
        }

        $totalQuestions = 0;
        $answeredQuestions = 0;

        foreach ($items as $item) {
            foreach ($item->cobitItem->kategoris as $kategori) {
                foreach ($kategori->levels as $level) {
                    $questionCount = $level->quisioners->count();
                    $totalQuestions += $questionCount;
                    
                    $answeredCount = $this->jawabans()
                        ->where('level_id', $level->id)
                        ->count();
                    $answeredQuestions += min($answeredCount, $questionCount);
                }
            }
        }

        if ($totalQuestions === 0) {
            return 0;
        }

        return (int) round(($answeredQuestions / $totalQuestions) * 100);
    }

    /**
     * Get status label untuk display
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING_SUBMISSION => 'Draft',
            self::STATUS_PENDING_APPROVAL => 'Menunggu Persetujuan',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_COMPLETED => 'Selesai - Menunggu Verifikasi',
            self::STATUS_VERIFIED => 'Terverifikasi',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Get status color untuk badge
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING_SUBMISSION => 'gray',
            self::STATUS_PENDING_APPROVAL => 'yellow',
            self::STATUS_APPROVED => 'blue',
            self::STATUS_IN_PROGRESS => 'indigo',
            self::STATUS_COMPLETED => 'orange',
            self::STATUS_VERIFIED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }

    /**
     * Get progress percentage as attribute
     */
    public function getProgressAttribute(): int
    {
        return $this->calculateProgress();
    }
}
