<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'auditor_id',
        'executive_summary',
        'background',
        'scope',
        'methodology',
        'findings',
        'recommendations',
        'conclusion',
        'overall_score',
        'capability_level',
        'status',
        'finalized_at',
        // Joint Risk Assessment fields
        'report_title',
        'company_name',
        'company_address',
        'sign_off_authority',
        'audit_director',
        'audit_director_phone',
        'audit_manager',
        'audit_manager_phone',
        'lead_auditor_name',
        'lead_auditor_phone',
        'maturity_rating_actual',
        'maturity_rating_target',
        'issues_priority_a',
        'issues_priority_b',
        'issues_priority_c',
        'observations_optimized',
        'observations_managed',
        'observations_defined',
        'observations_repeatable',
        'observations_initial',
        'prior_audit_name',
        'prior_audit_date',
        'officer_name',
        'officer_title',
        'officer_response',
        'officer_response_date',
        'reportable_issues',
        'strategic_focal_points',
        'it_process_focal_points',
        'control_focal_points',
        'distribution_list',
        'workflow_description',
    ];

    protected $casts = [
        'findings' => 'array',
        'recommendations' => 'array',
        'finalized_at' => 'datetime',
        'prior_audit_date' => 'date',
        'officer_response_date' => 'date',
        'reportable_issues' => 'array',
        'strategic_focal_points' => 'array',
        'it_process_focal_points' => 'array',
        'control_focal_points' => 'array',
        'distribution_list' => 'array',
        'maturity_rating_actual' => 'float',
        'maturity_rating_target' => 'float',
    ];

    /**
     * Status constants
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_FINAL = 'final';

    /**
     * Relasi ke Assessment
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Relasi ke Auditor (User)
     */
    public function auditor()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    /**
     * Check apakah laporan sudah final
     */
    public function isFinal(): bool
    {
        return $this->status === self::STATUS_FINAL;
    }

    /**
     * Check apakah laporan bisa diedit
     */
    public function canBeEdited(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Get status label untuk display
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_FINAL => 'Final',
            default => 'Unknown',
        };
    }

    /**
     * Get status color untuk badge
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'yellow',
            self::STATUS_FINAL => 'green',
            default => 'gray',
        };
    }

    /**
     * Get capability level label
     */
    public function getCapabilityLabelAttribute(): string
    {
        return match($this->capability_level) {
            0 => 'Level 0 - Incomplete Process',
            1 => 'Level 1 - Performed Process',
            2 => 'Level 2 - Managed Process',
            3 => 'Level 3 - Established Process',
            4 => 'Level 4 - Predictable Process',
            5 => 'Level 5 - Optimizing Process',
            default => 'Not Assessed',
        };
    }
}
