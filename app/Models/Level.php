<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $fillable = ['nama_level', 'kategori_id', 'level_number'];

    // --- RELASI YANG DITAMBAHKAN ---

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function quisioners()
    {
        return $this->hasMany(Quisioner::class);
    }

    public function jawabans()
    {
        return $this->hasMany(Jawaban::class);
    }

    public function resubmissionRequests()
    {
        return $this->hasMany(ResubmissionRequest::class);
    }

    // --- HELPER METHOD (SUDAH BENAR) ---

    public function isCompletedByUser($user, $assessmentId = null)
    {
        if (!$user) return false;
        $query = $this->jawabans()->where('user_id', $user->id);
        if ($assessmentId) {
            $query->where('assessment_id', $assessmentId);
        }
        $answeredCount = $query->count();
        return $answeredCount > 0 && $answeredCount >= $this->quisioners()->count();
    }

    public function isFullyAchievedByUser($user, $startDate = null, $endDate = null, $assessmentId = null)
    {
        if (!$user) {
            return false;
        }

        // In COBIT, a level is achieved if all answers are 'F' (Fully) or 'L' (Largely).
        $query = $this->jawabans()->where('user_id', $user->id)->whereIn('jawaban', ['F', 'L']);

        if ($assessmentId) {
            $query->where('assessment_id', $assessmentId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $achievedCount = $query->count();
        $totalCount = $this->quisioners()->count();
        
        return $achievedCount === $totalCount && $totalCount > 0;
    }

    public function hasActiveResubmissionRequest($user, $assessmentId = null)
    {
        if (!$user) return false;
        $query = $this->resubmissionRequests()
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved']);
            
        if ($assessmentId) {
            $query->where('assessment_id', $assessmentId);
        }

        return $query->exists();
    }

    public function isApprovedForResubmission($user, $assessmentId = null)
    {
        if (!$user) return false;
        $query = $this->resubmissionRequests()
            ->where('user_id', $user->id)
            ->where('status', 'approved');
            
        if ($assessmentId) {
            $query->where('assessment_id', $assessmentId);
        }

        return $query->exists();
    }
}
