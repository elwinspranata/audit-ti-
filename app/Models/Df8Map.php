<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Df8Map extends Model
{
    use HasFactory;

    protected $table = 'df8_map';

    protected $fillable = [
        'objective_code',
        'outsourcing',
        'cloud',
        'insourcing',
    ];

    protected $casts = [
        'outsourcing' => 'decimal:1',
        'cloud' => 'decimal:1',
        'insourcing' => 'decimal:1',
    ];

    /**
     * Get objective name from code
     */
    public function getObjectiveNameAttribute(): string
    {
        $names = [
            'EDM01' => 'Ensured Governance Framework Setting & Maintenance',
            'EDM02' => 'Ensured Benefits Delivery',
            'EDM03' => 'Ensured Risk Optimization',
            'EDM04' => 'Ensured Resource Optimization',
            'EDM05' => 'Ensured Stakeholder Engagement',
            'APO01' => 'Managed I&T Management Framework',
            'APO02' => 'Managed Strategy',
            'APO03' => 'Managed Enterprise Architecture',
            'APO04' => 'Managed Innovation',
            'APO05' => 'Managed Portfolio',
            'APO06' => 'Managed Budget & Costs',
            'APO07' => 'Managed Human Resources',
            'APO08' => 'Managed Relationships',
            'APO09' => 'Managed Service Agreements',
            'APO10' => 'Managed Vendors',
            'APO11' => 'Managed Quality',
            'APO12' => 'Managed Risk',
            'APO13' => 'Managed Security',
            'APO14' => 'Managed Data',
            'BAI01' => 'Managed Programs',
            'BAI02' => 'Managed Requirements Definition',
            'BAI03' => 'Managed Solutions Identification & Build',
            'BAI04' => 'Managed Availability & Capacity',
            'BAI05' => 'Managed Organizational Change',
            'BAI06' => 'Managed IT Changes',
            'BAI07' => 'Managed IT Change Acceptance and Transitioning',
            'BAI08' => 'Managed Knowledge',
            'BAI09' => 'Managed Assets',
            'BAI10' => 'Managed Configuration',
            'BAI11' => 'Managed Projects',
            'DSS01' => 'Managed Operations',
            'DSS02' => 'Managed Service Requests & Incidents',
            'DSS03' => 'Managed Problems',
            'DSS04' => 'Managed Continuity',
            'DSS05' => 'Managed Security Services',
            'DSS06' => 'Managed Business Process Controls',
            'MEA01' => 'Managed Performance and Conformance Monitoring',
            'MEA02' => 'Managed System of Internal Control',
            'MEA03' => 'Managed Compliance with External Requirements',
            'MEA04' => 'Managed Assurance',
        ];

        return $names[$this->objective_code] ?? $this->objective_code;
    }
}
