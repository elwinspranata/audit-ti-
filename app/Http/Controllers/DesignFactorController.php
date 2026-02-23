<?php

namespace App\Http\Controllers;

use App\Models\DesignFactor;
use App\Models\DesignFactorItem;
use App\Models\DesignFactor5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignFactorController extends Controller
{
    /**
     * Display the design factor calculator.
     */
    public function index(string $type = 'DF1')
    {
        $user = Auth::user();

        // Sequential access guard: redirect if trying to access a DF that isn't unlocked yet
        if ($type !== 'DF1') {
            $progress = DesignFactor::getProgress($user->id);
            if (isset($progress[$type]) && !$progress[$type]['accessible']) {
                return redirect()->route('design-factors.index', 'DF1')
                    ->with('error', "Anda harus menyelesaikan Design Factor sebelumnya terlebih dahulu.");
            }
        }

        // Get or create model
        $designFactor = DesignFactor::where('user_id', $user->id)
            ->where('factor_type', $type)
            ->first();

        if (!$designFactor) {
            $designFactor = DesignFactor::create([
                'user_id' => $user->id,
                'factor_type' => $type,
                'factor_name' => DesignFactor::getFactorInfo($type)['title'],
                'inputs' => DesignFactor::getDefaultInputs($type),
                'is_completed' => false,
            ]);
            $designFactor->recalculateResults();
        }

        // Get calculated results for display
        $results = $designFactor->getCalculatedResults();

        // Flatten results for blade compat
        $flatResults = [];
        foreach ($results as $code => $data) {
            $flatResults[] = array_merge(['code' => $code], $data);
        }

        $avgImp = $designFactor->getAverageImportance();
        $weight = $designFactor->getWeightedFactor();
        $metadata = DesignFactor::getMetadata($type);
        $factorInfo = DesignFactor::getFactorInfo($type);
        $progress = DesignFactor::getProgress($user->id);

        // All mappings for Blade use
        $mappings = [
            'df1Mapping' => \App\Utils\CobitData::getDF1Mapping(),
            'df2EgAgMapping' => \App\Utils\CobitData::getDF2EgToAgMapping(),
            'df2AgGmoMapping' => \App\Utils\CobitData::getDF2AgToGmoMapping(),
            'df3Mapping' => \App\Utils\CobitData::getDF3Mapping(),
            'df4Mapping' => \App\Utils\CobitData::getDF4Mapping(),
            'df5Mapping' => \App\Utils\CobitData::getDF5Mapping(),
            'df6Mapping' => \App\Utils\CobitData::getDF6Mapping(),
            'df7Mapping' => \App\Utils\CobitData::getDF7Mapping(),
            'df8Mapping' => \App\Utils\CobitData::getDF8Mapping(),
            'df9Mapping' => \App\Utils\CobitData::getDF9Mapping(),
            'df10Mapping' => \App\Utils\CobitData::getDF10Mapping(),
        ];

        return view('design-factors.index', array_merge($mappings, [
            'designFactor' => $designFactor,
            'results' => $flatResults,
            'factorInfo' => $factorInfo,
            'avgImp' => $avgImp,
            'weight' => $weight,
            'metadata' => $metadata,
            'progress' => $progress,
            'type' => $type,
            'df5' => ($type === 'DF5' ? $designFactor : null),
            'df6' => ($type === 'DF6' ? $designFactor : null),
            'df8' => ($type === 'DF8' ? $designFactor : null),
        ]));
    }

    /**
     * Store/Update design factor data.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('factor_type', 'DF1');

        $designFactor = DesignFactor::where('user_id', $user->id)
            ->where('factor_type', $type)
            ->first();

        if ($designFactor && $designFactor->is_locked) {
            return redirect()->back()->with('error', "Design Factor $type is locked.");
        }

        $inputs = $request->input('inputs');

        // Handle specialized mappings for DF5, DF6, DF8 etc. that don't use 'inputs[]' nested array in blade
        if (!$inputs) {
            if ($type === 'DF5') {
                $inputs = [
                    'high' => ['importance' => $request->input('importance_high'), 'baseline' => 33],
                    'normal' => ['importance' => $request->input('importance_normal'), 'baseline' => 67],
                ];
            } elseif ($type === 'DF6') {
                $inputs = [
                    'high' => ['importance' => $request->input('importance_high'), 'baseline' => 0],
                    'normal' => ['importance' => $request->input('importance_normal'), 'baseline' => 100],
                    'low' => ['importance' => $request->input('importance_low'), 'baseline' => 0],
                ];
            } elseif ($type === 'DF8') {
                $inputs = [
                    'outsourcing' => ['importance' => $request->input('importance_outsourcing'), 'baseline' => 33],
                    'cloud' => ['importance' => $request->input('importance_cloud'), 'baseline' => 33],
                    'insourced' => ['importance' => $request->input('importance_insourced'), 'baseline' => 34],
                ];
            } elseif ($type === 'DF9') {
                $inputs = [
                    'agile' => ['importance' => $request->input('agile'), 'baseline' => 15],
                    'devops' => ['importance' => $request->input('devops'), 'baseline' => 10],
                    'traditional' => ['importance' => $request->input('traditional'), 'baseline' => 75],
                ];
            } elseif ($type === 'DF10') {
                // Baselines from Excel: First Mover=15%, Follower=70%, Slow Adopter=15%
                $inputs = [
                    'first_mover' => ['importance' => $request->input('first_mover'), 'baseline' => 15],
                    'follower' => ['importance' => $request->input('follower'), 'baseline' => 70],
                    'slow_adopter' => ['importance' => $request->input('slow_adopter'), 'baseline' => 15],
                ];
            }
        }

        if (!$designFactor) {
            $designFactor = new DesignFactor();
            $designFactor->user_id = $user->id;
            $designFactor->factor_type = $type;
            $designFactor->factor_name = DesignFactor::getFactorInfo($type)['title'];
        }

        $designFactor->inputs = $inputs;
        $designFactor->is_completed = true;
        $designFactor->save();
        $designFactor->recalculateResults();

        return redirect()->route('design-factors.index', $type)->with('success', "Design Factor $type updated.");
    }

    /**
     * API calculate logic (for AJAX)
     */
    public function calculate(Request $request)
    {
        $type = $request->input('factor_type');
        $inputs = $request->input('inputs');

        if (!$inputs) {
            if ($type === 'DF5') {
                $inputs = [
                    'high' => ['importance' => $request->input('importance_high'), 'baseline' => 33],
                    'normal' => ['importance' => $request->input('importance_normal'), 'baseline' => 67],
                ];
            } elseif ($type === 'DF6') {
                $inputs = [
                    'high' => ['importance' => $request->input('importance_high'), 'baseline' => 0],
                    'normal' => ['importance' => $request->input('importance_normal'), 'baseline' => 100],
                    'low' => ['importance' => $request->input('importance_low'), 'baseline' => 0],
                ];
            } elseif ($type === 'DF8') {
                $inputs = [
                    'outsourcing' => ['importance' => $request->input('importance_outsourcing'), 'baseline' => 33],
                    'cloud' => ['importance' => $request->input('importance_cloud'), 'baseline' => 33],
                    'insourced' => ['importance' => $request->input('importance_insourced'), 'baseline' => 34],
                ];
            } elseif ($type === 'DF9') {
                $inputs = [
                    'agile' => ['importance' => $request->input('agile'), 'baseline' => 15],
                    'devops' => ['importance' => $request->input('devops'), 'baseline' => 10],
                    'traditional' => ['importance' => $request->input('traditional'), 'baseline' => 75],
                ];
            } elseif ($type === 'DF10') {
                // Baselines from Excel: First Mover=15%, Follower=70%, Slow Adopter=15%
                $inputs = [
                    'first_mover' => ['importance' => $request->input('first_mover'), 'baseline' => 15],
                    'follower' => ['importance' => $request->input('follower'), 'baseline' => 70],
                    'slow_adopter' => ['importance' => $request->input('slow_adopter'), 'baseline' => 15],
                ];
            }
        }

        $tempDf = new DesignFactor(['factor_type' => $type, 'inputs' => $inputs]);
        $results = $tempDf->getCalculatedResults();

        $flatResults = [];
        foreach ($results as $code => $data) {
            $flatResults[] = array_merge(['code' => $code], $data);
        }

        return response()->json([
            'success' => true,
            'results' => $flatResults,
            'avgImp' => $tempDf->getAverageImportance(),
            'weight' => $tempDf->getWeightedFactor(),
        ]);
    }

    public function calculateDf5(Request $request)
    {
        return $this->calculate($request);
    }
    public function calculateDf6(Request $request)
    {
        return $this->calculate($request);
    }
    public function calculateDf8(Request $request)
    {
        return $this->calculate($request);
    }
    public function calculateDf9(Request $request)
    {
        return $this->calculate($request);
    }
    public function calculateDf10(Request $request)
    {
        return $this->calculate($request);
    }

    /**
     * Show aggregated summary for DF1-DF4
     */
    public function summary()
    {
        $user = Auth::user();
        $aggregated = DesignFactor::getScaledPhase1($user->id);

        $dfData = [];
        foreach (['DF1', 'DF2', 'DF3', 'DF4'] as $type) {
            $df = DesignFactor::where('user_id', $user->id)->where('factor_type', $type)->first();
            $dfData[$type] = $df ? $df->items : [];
        }

        return view('design-factors.summary', [
            'results' => $aggregated,
            'df1Data' => $dfData['DF1'],
            'df2Data' => $dfData['DF2'],
            'df3Data' => $dfData['DF3'],
            'df4Data' => $dfData['DF4'],
            'progress' => DesignFactor::getProgress($user->id),
            'isLocked' => DesignFactor::where('user_id', $user->id)->where('factor_type', 'DF1')->first()?->is_locked ?? false,
        ]);
    }

    /**
     * Show aggregated summary for DF5-DF10
     */
    public function summaryDf510()
    {
        $user = Auth::user();
        $aggregated = DesignFactor::getFinalSummary($user->id);

        $dfData = [];
        foreach (['DF5', 'DF6', 'DF7', 'DF8', 'DF9', 'DF10'] as $type) {
            $df = DesignFactor::where('user_id', $user->id)->where('factor_type', $type)->first();
            $dfData[$type] = $df ? $df->items : [];
        }

        return view('design-factors.summary-df510', [
            'results' => $aggregated,
            'df5Data' => $dfData['DF5'],
            'df6Data' => $dfData['DF6'],
            'df7Data' => $dfData['DF7'],
            'df8Data' => $dfData['DF8'],
            'df9Data' => $dfData['DF9'],
            'df10Data' => $dfData['DF10'],
            'progress' => DesignFactor::getProgress($user->id),
        ]);
    }

    public function lockSummary()
    {
        $user = Auth::user();
        DesignFactor::where('user_id', $user->id)
            ->whereIn('factor_type', ['DF1', 'DF2', 'DF3', 'DF4'])
            ->update(['is_locked' => true]);

        return redirect()->route('design-factors.summary')->with('success', 'DF1-DF4 Locked.');
    }

    public function resetAll()
    {
        $user = Auth::user();
        DesignFactor::where('user_id', $user->id)->delete();
        DesignFactorItem::whereHas('designFactor', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->delete();

        return redirect()->route('design-factors.index')->with('success', 'Reset complete.');
    }
}
