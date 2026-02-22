<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DesignFactor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'factor_type',
        'factor_name',
        'inputs', // JSON
        'extra_data', // JSON
        'is_completed',
        'is_locked',
    ];

    protected $casts = [
        'inputs' => 'array',
        'extra_data' => 'array',
        'is_completed' => 'boolean',
        'is_locked' => 'boolean',
    ];

    /**
     * Get raw DF1-DF4 RI sums (unscaled) per GMO code
     */
    public static function getRawPhase1Sums($userId)
    {
        $dfs = self::where('user_id', $userId)->whereIn('factor_type', ['DF1', 'DF2', 'DF3', 'DF4'])->get();
        $sums = [];
        
        foreach ($dfs as $df) {
            $items = $df->items;
            foreach ($items as $item) {
                if (!isset($sums[$item->code])) {
                    $sums[$item->code] = 0;
                }
                $sums[$item->code] += $item->relative_importance;
            }
        }

        return $sums;
    }

    /**
     * Get Aggregated and Scaled results for DF1-DF4 (Phase 1)
     * Excel Canvas formula: MROUND(TRUNC(100 * sum / MAX(ABS(all_sums))), 5)
     */
    public static function getScaledPhase1($userId)
    {
        $sums = self::getRawPhase1Sums($userId);

        if (empty($sums)) return [];

        // MAX(MAX(sums), ABS(MIN(sums))) = max absolute value
        $maxMagnitude = 0;
        foreach ($sums as $s) {
            if (abs($s) > $maxMagnitude) {
                $maxMagnitude = abs($s);
            }
        }

        $scaled = [];
        foreach ($sums as $code => $sum) {
            if ($maxMagnitude > 0) {
                // Excel uses TRUNC then MROUND(x, 5)
                $val = (100 * $sum) / $maxMagnitude;
                $truncated = (int)$val; // TRUNC toward zero
                // MROUND to nearest 5
                $scaled[$code] = (int)(round($truncated / 5) * 5);
            } else {
                $scaled[$code] = 0;
            }
        }

        return $scaled;
    }

    /**
     * Get Final Aggregated score for DF1-DF10
     * Excel Canvas formula: SUMPRODUCT(weights, DF1..DF4 RI) + SUMPRODUCT(weights, DF5..DF10 RI)
     * This uses RAW (unscaled) DF1-DF4 sums + DF5-DF10 adjustments
     */
    public static function getFinalSummary($userId)
    {
        // Phase 1: Raw DF1-DF4 RI sums (NOT scaled)
        $rawPhase1 = self::getRawPhase1Sums($userId);
        
        // Phase 2: Sum of DF5-DF10 adjustments
        $adjustments = [];
        $p2Filters = ['DF5', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'];
        $dfs = self::where('user_id', $userId)->whereIn('factor_type', $p2Filters)->get();
        
        foreach ($dfs as $df) {
            foreach ($df->items as $item) {
                if (!isset($adjustments[$item->code])) {
                    $adjustments[$item->code] = 0;
                }
                $adjustments[$item->code] += $item->relative_importance;
            }
        }

        $final = [];
        // Use all possible GMO codes
        $allCodes = array_unique(array_merge(array_keys($rawPhase1), array_keys($adjustments)));
        
        foreach ($allCodes as $code) {
            $p1 = $rawPhase1[$code] ?? 0;
            $p2 = $adjustments[$code] ?? 0;
            $final[$code] = $p1 + $p2;
        }

        return $final;
    }

    /**
     * Relationship to DesignFactorItem
     */
    public function items()
    {
        return $this->hasMany(DesignFactorItem::class);
    }

    /**
     * Get factor information/metadata by type
     */
    public static function getFactorInfo(string $type): array
    {
        $factors = [
            'DF1' => [
                'title' => 'Design Factor 1: Enterprise Strategy',
                'description' => 'Strategies consist of archetypes, each of which has a different impact on governance/management objectives.',
            ],
            'DF2' => [
                'title' => 'Design Factor 2: Enterprise Goals',
                'description' => 'Enterprise goals consist of a set of goals, each of which has a different impact on governance/management objectives.',
            ],
            'DF3' => [
                'title' => 'Design Factor 3: Risk Profile',
                'description' => 'Risk profile consists of a set of risk scenarios, each of which has a different impact on governance/management objectives.',
            ],
            'DF4' => [
                'title' => 'Design Factor 4: IT-Related Issues',
                'description' => 'IT-related issues consist of a set of issues, each of which has a different impact on governance/management objectives.',
            ],
            'DF5' => [
                'title' => 'Design Factor 5: Threat Landscape',
                'description' => 'Threat landscape consists of a set of threats, each of which has a different impact on governance/management objectives.',
            ],
            'DF6' => [
                'title' => 'Design Factor 6: Compliance Requirements',
                'description' => 'Compliance requirements consist of a set of requirements, each of which has a different impact on governance/management objectives.',
            ],
            'DF7' => [
                'title' => 'Design Factor 7: Importance of Role of IT',
                'description' => 'Role of IT consists of a set of roles, each of which has a different impact on governance/management objectives.',
            ],
            'DF8' => [
                'title' => 'Design Factor 8: Sourcing Model for IT',
                'description' => 'Sourcing model consists of a set of models, each of which has a different impact on governance/management objectives.',
            ],
            'DF9' => [
                'title' => 'Design Factor 9: IT Implementation Methods',
                'description' => 'IT implementation methods consist of a set of methods, each of which has a different impact on governance/management objectives.',
            ],
            'DF10' => [
                'title' => 'Design Factor 10: Technology Adoption Strategy',
                'description' => 'Technology adoption strategy consists of a set of strategies, each of which has a different impact on governance/management objectives.',
            ],
        ];

        return $factors[$type] ?? [
            'title' => 'Unknown Design Factor',
            'description' => 'No information available for this factor type.',
        ];
    }

    /**
     * Get metadata for specific factor type (possible values)
     */
    public static function getMetadata(string $type): array
    {
        if ($type === 'DF1') {
            return [
                'growth' => ['name' => 'Growth/Acquisition'],
                'innovation' => ['name' => 'Innovation/Differentiation'],
                'cost' => ['name' => 'Cost Leadership'],
                'stability' => ['name' => 'Client Service/Stability'],
            ];
        }

        if ($type === 'DF2') {
            return [
                'EG01' => ['name' => 'EG01: Portfolio of competitive products and services'],
                'EG02' => ['name' => 'EG02: Managed business risk'],
                'EG03' => ['name' => 'EG03: Compliance with external laws and regulations'],
                'EG04' => ['name' => 'EG04: Quality of financial information'],
                'EG05' => ['name' => 'EG05: Customer-oriented service culture'],
                'EG06' => ['name' => 'EG06: Business-service continuity and availability'],
                'EG07' => ['name' => 'EG07: Quality of management information'],
                'EG08' => ['name' => 'EG08: Optimization of internal business process functionality'],
                'EG09' => ['name' => 'EG09: Optimization of business process costs'],
                'EG10' => ['name' => 'EG10: Staff skills, motivation and productivity'],
                'EG11' => ['name' => 'EG11: Compliance with internal policies'],
                'EG12' => ['name' => 'EG12: Managed digital transformation programs'],
                'EG13' => ['name' => 'EG13: Product and business innovation'],
            ];
        }

        if ($type === 'DF3') {
            return [
                'RS01' => ['name' => 'IT investment decision making'],
                'RS02' => ['name' => 'Program & projects life cycle management'],
                'RS03' => ['name' => 'IT cost & oversight'],
                'RS04' => ['name' => 'IT expertise, skills & behavior'],
                'RS05' => ['name' => 'Enterprise/IT architecture'],
                'RS06' => ['name' => 'IT operational infrastructure incidents'],
                'RS07' => ['name' => 'Unauthorized actions'],
                'RS08' => ['name' => 'Software adoption/usage problems'],
                'RS09' => ['name' => 'Hardware incidents'],
                'RS10' => ['name' => 'Software failures'],
                'RS11' => ['name' => 'Logical attacks (hacking, malware, etc.)'],
                'RS12' => ['name' => 'Third-party/supplier incidents'],
                'RS13' => ['name' => 'Noncompliance'],
                'RS14' => ['name' => 'Geopolitical Issues'],
                'RS15' => ['name' => 'Industrial action'],
                'RS16' => ['name' => 'Acts of nature'],
                'RS17' => ['name' => 'Technology-based innovation'],
                'RS18' => ['name' => 'Environmental'],
                'RS19' => ['name' => 'Data & information management'],
            ];
        }

        if ($type === 'DF4') {
            return [
                'IT01' => ['name' => 'Frustration between different IT entities'],
                'IT02' => ['name' => 'Frustration between business and IT'],
                'IT03' => ['name' => 'Significant IT-related incidents'],
                'IT04' => ['name' => 'Service delivery problems by outsourcer'],
                'IT05' => ['name' => 'Failures to meet regulatory requirements'],
                'IT06' => ['name' => 'Regular audit findings'],
                'IT07' => ['name' => 'Substantial hidden and rogue IT spending'],
                'IT08' => ['name' => 'Duplications or overlaps'],
                'IT09' => ['name' => 'Insufficient IT resources'],
                'IT10' => ['name' => 'IT-enabled changes frequently failing'],
                'IT11' => ['name' => 'Reluctance by senior management'],
                'IT12' => ['name' => 'Complex IT operating model'],
                'IT13' => ['name' => 'Excessively high cost of IT'],
                'IT14' => ['name' => 'Obstructed implementation of new initiatives'],
                'IT15' => ['name' => 'Gap between business and tech knowledge'],
                'IT16' => ['name' => 'Regular issues with data quality'],
                'IT17' => ['name' => 'High level of end-user computing'],
                'IT18' => ['name' => 'Business implementing own solutions'],
                'IT19' => ['name' => 'Ignorance of privacy regulations'],
                'IT20' => ['name' => 'Inability to exploit new technologies'],
            ];
        }

        if ($type === 'DF5') {
            return [
                'high' => ['name' => 'Threat Landscape (High)'],
                'normal' => ['name' => 'Threat Landscape (Normal)'],
            ];
        }

        if ($type === 'DF6') {
            return [
                'high' => ['name' => 'High Compliance Requirements'],
                'normal' => ['name' => 'Normal Compliance Requirements'],
                'low' => ['name' => 'Low Compliance Requirements'],
            ];
        }

        if ($type === 'DF7') {
            return [
                'support' => ['name' => 'Support'],
                'factory' => ['name' => 'Factory'],
                'turnaround' => ['name' => 'Turnaround'],
                'strategic' => ['name' => 'Strategic'],
            ];
        }

        if ($type === 'DF8') {
            return [
                'outsourcing' => ['name' => 'Outsourcing'],
                'cloud' => ['name' => 'Cloud'],
                'insourced' => ['name' => 'Insourced'],
            ];
        }

        if ($type === 'DF9') {
            return [
                'agile' => ['name' => 'Agile'],
                'devops' => ['name' => 'DevOps'],
                'traditional' => ['name' => 'Traditional'],
            ];
        }

        if ($type === 'DF10') {
            return [
                'first_mover' => ['name' => 'First Mover'],
                'follower' => ['name' => 'Follower'],
                'slow_adopter' => ['name' => 'Slow Adopter'],
            ];
        }

        return [];
    }

    /**
     * Get default inputs for a new design factor
     */
    public static function getDefaultInputs(string $type): array
    {
        $metadata = self::getMetadata($type);
        $inputs = [];
        foreach ($metadata as $key => $data) {
            if ($type === 'DF3') {
                $inputs[$key] = ['impact' => 3, 'likelihood' => 3, 'baseline' => 9];
            } elseif ($type === 'DF4') {
                $inputs[$key] = ['importance' => 1, 'baseline' => 2];
            } elseif ($type === 'DF6') {
                if ($key === 'high') $inputs[$key] = ['importance' => 25, 'baseline' => 0];
                elseif ($key === 'normal') $inputs[$key] = ['importance' => 75, 'baseline' => 100];
                elseif ($key === 'low') $inputs[$key] = ['importance' => 0, 'baseline' => 0];
            } elseif ($type === 'DF8') {
                if ($key === 'outsourcing') $inputs[$key] = ['importance' => 10, 'baseline' => 33];
                elseif ($key === 'cloud') $inputs[$key] = ['importance' => 50, 'baseline' => 33];
                elseif ($key === 'insourced') $inputs[$key] = ['importance' => 40, 'baseline' => 34];
            } elseif ($type === 'DF9') {
                if ($key === 'agile') $inputs[$key] = ['importance' => 50, 'baseline' => 15];
                elseif ($key === 'devops') $inputs[$key] = ['importance' => 10, 'baseline' => 10];
                elseif ($key === 'traditional') $inputs[$key] = ['importance' => 40, 'baseline' => 75];
            } elseif ($type === 'DF10') {
                // Baselines from Excel: First Mover=15%, Follower=70%, Slow Adopter=15%
                if ($key === 'first_mover') $inputs[$key] = ['importance' => 75, 'baseline' => 15];
                elseif ($key === 'follower') $inputs[$key] = ['importance' => 15, 'baseline' => 70];
                elseif ($key === 'slow_adopter') $inputs[$key] = ['importance' => 10, 'baseline' => 15];
            } else {
                $inputs[$key] = ['importance' => 3, 'baseline' => 3];
            }
        }
        return $inputs;
    }

    /**
     * Get default COBIT items for specific factor type
     */
    public static function getDefaultCobitItems(string $type): array
    {
        $gmoCodes = ['EDM01','EDM02','EDM03','EDM04','EDM05','APO01','APO02','APO03','APO04','APO05','APO06','APO07','APO08','APO09','APO10','APO11','APO12','APO13','APO14','BAI01','BAI02','BAI03','BAI04','BAI05','BAI06','BAI07','BAI08','BAI09','BAI10','BAI11','DSS01','DSS02','DSS03','DSS04','DSS05','DSS06','MEA01','MEA02','MEA03','MEA04'];
        
        $items = [];
        foreach ($gmoCodes as $code) {
            $items[] = [
                'code' => $code,
                'score' => 0,
                'baseline_score' => 0,
                'relative_importance' => 0,
            ];
        }
        return $items;
    }

    /**
     * Calculate relative importance score
     */
    public function calculateRelativeImportance(float $score, float $baselineScore): float
    {
        if ($baselineScore == 0) return 0;

        if (in_array($this->factor_type, ['DF5', 'DF6', 'DF8', 'DF9', 'DF10'])) {
            $calculated = (100 * $score) / $baselineScore;
            return (round($calculated / 5) * 5) - 100;
        }

        $factor = $this->getWeightedFactor();
        $calculated = ($factor * 100 * $score) / $baselineScore;
        return (round($calculated / 5) * 5) - 100;
    }

    /**
     * Get average importance for current inputs
     */
    public function getAverageImportance(): float
    {
        $inputs = $this->inputs ?? [];
        if (empty($inputs)) return 0;

        $sum = 0; $count = 0;
        foreach ($inputs as $input) {
            if ($this->factor_type === 'DF3') {
                $sum += ($input['impact'] ?? 3) * ($input['likelihood'] ?? 3);
            } else {
                $sum += ($input['importance'] ?? 3);
            }
            $count++;
        }
        return $count > 0 ? $sum / $count : 0;
    }

    /**
     * Get average baseline for current inputs
     */
    public function getAverageBaseline(): float
    {
        $inputs = $this->inputs ?? [];
        if (empty($inputs)) return 0;

        $sum = 0; $count = 0;
        foreach ($inputs as $input) {
            $sum += ($input['baseline'] ?? 3);
            $count++;
        }
        return $count > 0 ? $sum / $count : 0;
    }

    /**
     * Get correction factor (Weighted Factor)
     */
    public function getWeightedFactor(): float
    {
        $avgImp = $this->getAverageImportance();
        $avgBase = $this->getAverageBaseline();
        return $avgImp > 0 ? $avgBase / $avgImp : 1.0;
    }

    /**
     * Get Objective Name (GMO)
     */
    public static function getObjectiveName(string $code): string
    {
        $names = [
            'EDM01' => 'Ensured Governance Framework Setting and Maintenance',
            'EDM02' => 'Ensured Benefits Delivery',
            'EDM03' => 'Ensured Risk Optimization',
            'EDM04' => 'Ensured Resource Optimization',
            'EDM05' => 'Ensured Stakeholder Engagement',
            'APO01' => 'Managed I&T Management Framework',
            'APO02' => 'Managed Strategy',
            'APO03' => 'Managed Enterprise Architecture',
            'APO04' => 'Managed Innovation',
            'APO05' => 'Managed Portfolio',
            'APO06' => 'Managed Budget and Costs',
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
            'BAI03' => 'Managed Solutions Identification and Build',
            'BAI04' => 'Managed Availability and Capacity',
            'BAI05' => 'Managed Organizational Change',
            'BAI06' => 'Managed IT Changes',
            'BAI07' => 'Managed IT Change Acceptance and Transitioning',
            'BAI08' => 'Managed Knowledge',
            'BAI09' => 'Managed Assets',
            'BAI10' => 'Managed Configuration',
            'BAI11' => 'Managed Projects',
            'DSS01' => 'Managed Operations',
            'DSS02' => 'Managed Service Requests and Incidents',
            'DSS03' => 'Managed Problems',
            'DSS04' => 'Managed Continuity',
            'DSS05' => 'Managed Security Services',
            'DSS06' => 'Managed Business Process Controls',
            'MEA01' => 'Managed Performance and Conformance Monitoring',
            'MEA02' => 'Managed System of Internal Control',
            'MEA03' => 'Managed Compliance with External Laws and Regulations',
            'MEA04' => 'Managed Assurance',
        ];
        return $names[$code] ?? $code;
    }

    /**
     * Recalculate all items based on current inputs
     */
    public function recalculateResults(): void
    {
        $results = $this->getCalculatedResults();
        $this->items()->delete();
        foreach ($results as $code => $data) {
            $this->items()->create([
                'code' => $code,
                'score' => $data['score'],
                'baseline_score' => $data['baseline_score'],
                'relative_importance' => $data['relative_importance'],
            ]);
        }
    }

    /**
     * Get calculated results without saving
     */
    public function getCalculatedResults(): array
    {
        $results = [];
        $inputs = $this->inputs ?? [];

        if ($this->factor_type === 'DF1') {
            $mapping = \App\Utils\CobitData::getDF1Mapping();
            $meta = array_keys(self::getMetadata('DF1'));
            foreach ($mapping as $code => $mapRow) {
                $score = 0; $baseline = 0;
                foreach ($meta as $idx => $key) {
                    $imp = isset($inputs[$key]['importance']) ? $inputs[$key]['importance'] : 3;
                    $score += $mapRow[$idx] * $imp;
                    $baseline += $mapRow[$idx] * 3;
                }
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        } elseif ($this->factor_type === 'DF2') {
            $eg2ag = \App\Utils\CobitData::getDF2EgToAgMapping();
            $ag2gmo = \App\Utils\CobitData::getDF2AgToGmoMapping();
            $agScores = array_fill(0, 13, 0); $agBaselines = array_fill(0, 13, 0);
            foreach ($eg2ag as $egCode => $agWeights) {
                $imp = isset($inputs[$egCode]['importance']) ? $inputs[$egCode]['importance'] : 3;
                foreach ($agWeights as $agIdx => $w) {
                    $agScores[$agIdx] += $w * $imp;
                    $agBaselines[$agIdx] += $w * 3;
                }
            }
            $gmoCodes = array_keys(collect(self::getDefaultCobitItems('DF1'))->keyBy('code')->toArray());
            foreach ($gmoCodes as $gIdx => $code) {
                $score = 0; $baseline = 0; $agIdx = 0;
                foreach ($ag2gmo as $agCode => $gmoWeights) {
                    $w = $gmoWeights[$gIdx] ?? 0;
                    $score += $w * $agScores[$agIdx];
                    $baseline += $w * $agBaselines[$agIdx];
                    $agIdx++;
                }
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        } elseif ($this->factor_type === 'DF3') {
            $mapping = \App\Utils\CobitData::getDF3Mapping();
            $meta = array_keys(self::getMetadata('DF3'));
            foreach ($mapping as $code => $mapRow) {
                $score = 0; $baseline = 0;
                foreach ($meta as $idx => $key) {
                    $imp = isset($inputs[$key]['impact']) ? $inputs[$key]['impact'] : 3;
                    $lik = isset($inputs[$key]['likelihood']) ? $inputs[$key]['likelihood'] : 3;
                    $score += $mapRow[$idx] * ($imp * $lik);
                    $baseline += $mapRow[$idx] * 9;
                }
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        } elseif ($this->factor_type === 'DF4') {
            $mapping = \App\Utils\CobitData::getDF4Mapping();
            $meta = array_keys(self::getMetadata('DF4'));
            foreach ($mapping as $code => $mapRow) {
                $score = 0; $baseline = 0;
                foreach ($meta as $idx => $key) {
                    $imp = isset($inputs[$key]['importance']) ? $inputs[$key]['importance'] : 1;
                    $score += $mapRow[$idx] * $imp;
                    $baseline += $mapRow[$idx] * 2;
                }
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        } elseif ($this->factor_type === 'DF7') {
            $mapping = \App\Utils\CobitData::getDF7Mapping();
            $meta = array_keys(self::getMetadata('DF7'));
            foreach ($mapping as $code => $mapRow) {
                $score = 0; $baseline = 0;
                foreach ($meta as $idx => $key) {
                    $imp = isset($inputs[$key]['importance']) ? $inputs[$key]['importance'] : 3;
                    $score += $mapRow[$idx] * $imp;
                    $baseline += $mapRow[$idx] * 3;
                }
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        } elseif ($this->factor_type === 'DF5') {
            $mapping = \App\Utils\CobitData::getDF5Mapping();
            foreach ($mapping as $code => $mapRow) {
                $score = ($mapRow[0] * (isset($inputs['high']['importance']) ? $inputs['high']['importance'] : 50) / 100) +
                         ($mapRow[1] * (isset($inputs['normal']['importance']) ? $inputs['normal']['importance'] : 50) / 100);
                $baseline = ($mapRow[0] * 33 / 100) + ($mapRow[1] * 67 / 100);
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        } elseif (in_array($this->factor_type, ['DF6', 'DF8', 'DF9', 'DF10'])) {
            $mapSet = match($this->factor_type) {
                'DF6' => \App\Utils\CobitData::getDF6Mapping(),
                'DF8' => \App\Utils\CobitData::getDF8Mapping(),
                'DF9' => \App\Utils\CobitData::getDF9Mapping(),
                'DF10' => \App\Utils\CobitData::getDF10Mapping(),
            };
            $meta = array_keys(self::getMetadata($this->factor_type));
            foreach ($mapSet as $code => $mapRow) {
                $score = 0; $baseline = 0;
                foreach ($meta as $idx => $key) {
                    $imp = isset($inputs[$key]['importance']) ? $inputs[$key]['importance'] : 0;
                    $base = isset($inputs[$key]['baseline']) ? $inputs[$key]['baseline'] : 0;
                    $w = $mapRow[$idx] ?? 0;
                    $score += $w * $imp / 100;
                    $baseline += $w * $base / 100;
                }
                $results[$code] = ['score' => $score, 'baseline_score' => $baseline];
            }
        }

        foreach ($results as $code => &$data) {
            $data['relative_importance'] = $this->calculateRelativeImportance($data['score'], $data['baseline_score']);
            $data['name'] = self::getObjectiveName($code);
        }
        return $results;
    }

    /**
     * Get Progress of user
     */
    public static function getProgress(int $userId): array
    {
        $types = ['DF1', 'DF2', 'DF3', 'DF4', 'DF5', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'];
        $progress = [];
        foreach ($types as $type) {
            $df = self::where('user_id', $userId)->where('factor_type', $type)->first();
            $progress[$type] = [
                'completed' => $df ? $df->is_completed : false,
                'locked' => $df ? $df->is_locked : false,
                'accessible' => true, // Simplified
            ];
        }
        return $progress;
    }

    public static function getDF10Mapping() { return \App\Utils\CobitData::getDF10Mapping(); }
    public static function getDF9Mapping() { return \App\Utils\CobitData::getDF9Mapping(); }
    public static function getDF8Mapping() { return \App\Utils\CobitData::getDF8Mapping(); }
    public static function getDF6Mapping() { return \App\Utils\CobitData::getDF6Mapping(); }
}
