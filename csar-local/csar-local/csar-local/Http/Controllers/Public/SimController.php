<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SimReport;
use App\Models\News;
use Illuminate\Http\Request;

class SimController extends Controller
{
    public function index()
    {
        $reports = SimReport::published()->latest()->paginate(10);
        $latestReport = SimReport::published()->latest()->first();
        
        return view('public.sim.index', compact('reports', 'latestReport'));
    }

    public function show(SimReport $simReport)
    {
        if (!$simReport->is_published) {
            abort(404);
        }

        $relatedReports = SimReport::published()
            ->where('id', '!=', $simReport->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.sim.show', compact('simReport', 'relatedReports'));
    }

    public function dashboard()
    {
        $latestReport = SimReport::published()->latest()->first();
        $recentReports = SimReport::published()->latest()->take(5)->get();
        
        // Statistiques des prix (si un rapport récent existe)
        $priceStats = null;
        if ($latestReport && $latestReport->price_analysis) {
            $priceStats = $this->extractPriceStats($latestReport->price_analysis);
        }

        return view('public.sim.dashboard', compact('latestReport', 'recentReports', 'priceStats'));
    }

    private function extractPriceStats($priceAnalysis)
    {
        $stats = [
            'total_products' => 0,
            'price_increases' => 0,
            'price_decreases' => 0,
            'stable_prices' => 0,
            'highest_increase' => ['product' => '', 'percentage' => 0],
            'highest_decrease' => ['product' => '', 'percentage' => 0],
            'categories' => []
        ];

        foreach ($priceAnalysis as $category => $products) {
            $stats['categories'][$category] = [
                'total' => 0,
                'increases' => 0,
                'decreases' => 0,
                'stable' => 0
            ];

            foreach ($products as $product => $data) {
                $stats['total_products']++;
                $stats['categories'][$category]['total']++;

                if (isset($data['variation_mensuelle'])) {
                    $variation = $data['variation_mensuelle'];
                    
                    if ($variation > 2) {
                        $stats['price_increases']++;
                        $stats['categories'][$category]['increases']++;
                        
                        if ($variation > $stats['highest_increase']['percentage']) {
                            $stats['highest_increase'] = [
                                'product' => $product,
                                'percentage' => $variation
                            ];
                        }
                    } elseif ($variation < -2) {
                        $stats['price_decreases']++;
                        $stats['categories'][$category]['decreases']++;
                        
                        if ($variation < $stats['highest_decrease']['percentage']) {
                            $stats['highest_decrease'] = [
                                'product' => $product,
                                'percentage' => $variation
                            ];
                        }
                    } else {
                        $stats['stable_prices']++;
                        $stats['categories'][$category]['stable']++;
                    }
                }
            }
        }

        return $stats;
    }

    public function prices()
    {
        $latestReport = SimReport::published()->latest()->first();
        $priceData = $latestReport ? $latestReport->price_analysis : [];
        
        return view('public.sim.prices', compact('priceData', 'latestReport'));
    }

    public function supply()
    {
        $latestReport = SimReport::published()->latest()->first();
        $supplyData = $latestReport ? $latestReport->supply_analysis : [];
        
        return view('public.sim.supply', compact('supplyData', 'latestReport'));
    }

    public function regional()
    {
        $latestReport = SimReport::published()->latest()->first();
        $regionalData = $latestReport ? $latestReport->regional_analysis : [];
        
        return view('public.sim.regional', compact('regionalData', 'latestReport'));
    }

    public function distributions()
    {
        return view('public.sim.distributions');
    }

    public function magasins()
    {
        return view('public.sim.magasins');
    }

    public function operations()
    {
        return view('public.sim.operations');
    }
}



