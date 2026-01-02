<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'jawaban', 
        'quisioner_id', 
        'user_id', 
        'level_id',
        'assessment_id',
        'verification_status',
        'evidence_type',
        'evidence_path',
        'evidence_original_name',
        'auditor_notes',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * Verification status constants
     */
    const VERIFICATION_PENDING = 'pending';
    const VERIFICATION_VERIFIED = 'verified';
    const VERIFICATION_NEEDS_REVISION = 'needs_revision';

    /**
     * Evidence type constants
     */
    const EVIDENCE_TYPE_FILE = 'file';
    const EVIDENCE_TYPE_LINK = 'link';

    // Relasi ke Quisioner
    public function quisioner()
    {
        return $this->belongsTo(Quisioner::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relasi ke Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // Relasi ke Auditor yang memverifikasi
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check apakah jawaban sudah diverifikasi
     */
    public function isVerified(): bool
    {
        return $this->verification_status === self::VERIFICATION_VERIFIED;
    }

    /**
     * Check apakah jawaban perlu revisi
     */
    public function needsRevision(): bool
    {
        return $this->verification_status === self::VERIFICATION_NEEDS_REVISION;
    }

    /**
     * Get verification status label
     */
    public function getVerificationLabelAttribute(): string
    {
        return match($this->verification_status) {
            self::VERIFICATION_PENDING => 'Menunggu Verifikasi',
            self::VERIFICATION_VERIFIED => 'Terverifikasi',
            self::VERIFICATION_NEEDS_REVISION => 'Perlu Revisi',
            default => 'Unknown',
        };
    }

    /**
     * Get verification status color
     */
    public function getVerificationColorAttribute(): string
    {
        return match($this->verification_status) {
            self::VERIFICATION_PENDING => 'yellow',
            self::VERIFICATION_VERIFIED => 'green',
            self::VERIFICATION_NEEDS_REVISION => 'red',
            default => 'gray',
        };
    }

    /**
     * Check apakah ada bukti pendukung
     */
    public function hasEvidence(): bool
    {
        return !empty($this->evidence_path);
    }
}

