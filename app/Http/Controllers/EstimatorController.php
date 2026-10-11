<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Support\SeoMeta;
use Illuminate\Http\Request;

class EstimatorController extends Controller
{
    public function index(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'محاسبه‌گر و برآورد هوشمند پروژه | امیرمحمد بحرلو' : 'Smart Project Cost Estimator | AmirMohammad Baharlou',
            description: $locale === 'fa'
                ? 'محاسبه حدودی هزینه و زمان‌بندی پروژه نرم‌افزاری بر اساس نیازمندی‌ها، حجم کار و تکنولوژی‌های انتخابی.'
                : 'Interactive estimation tool for planning software project scopes, technical requirements and timelines.'
        );

        return view('pages.estimator', compact('seo', 'locale'));
    }

    public function calculate(Request $request, string $locale = 'fa')
    {
        $validated = $request->validate([
            'project_type' => ['required', 'string', 'in:mvp,full_system,threejs_creative,performance_audit'],
            'scale' => ['required', 'string', 'in:small,medium,enterprise'],
            'timeline' => ['required', 'string', 'in:rush,standard,relaxed'],
            'features' => ['nullable', 'array'],
        ]);

        // Base price points in Toman (million Tomans base unit)
        $basePrices = [
            'mvp' => 25,
            'full_system' => 55,
            'threejs_creative' => 40,
            'performance_audit' => 15,
        ];

        $scaleMultipliers = [
            'small' => 1.0,
            'medium' => 1.5,
            'enterprise' => 2.4,
        ];

        $timelineMultipliers = [
            'rush' => 1.3,
            'standard' => 1.0,
            'relaxed' => 0.9,
        ];

        $type = $validated['project_type'];
        $scale = $validated['scale'];
        $timeline = $validated['timeline'];
        $selectedFeatures = $validated['features'] ?? [];

        $featureCost = count($selectedFeatures) * 5; // 5M per custom feature add-on

        $base = $basePrices[$type] ?? 25;
        $total = ($base * ($scaleMultipliers[$scale] ?? 1.0) * ($timelineMultipliers[$timeline] ?? 1.0)) + $featureCost;
        $minEstimate = (int) round($total * 0.9);
        $maxEstimate = (int) round($total * 1.2);

        $estimate = Estimate::create([
            'scope_type' => $type,
            'estimated_amount' => (int) round($total * 10000000), // in Rials
            'currency' => 'IRT',
            'breakdown' => [
                'project_type' => $type,
                'scale' => $scale,
                'timeline' => $timeline,
                'features' => $selectedFeatures,
                'min_toman_million' => $minEstimate,
                'max_toman_million' => $maxEstimate,
            ],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status' => 'success',
            'public_id' => $estimate->public_id,
            'min_estimate' => $minEstimate,
            'max_estimate' => $maxEstimate,
            'currency' => $locale === 'fa' ? 'میلیون تومان' : 'Million Tomans',
        ]);
    }
}
