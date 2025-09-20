<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicContent;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Utiliser la version la plus récente par clé pour éviter les doublons
        $aboutContent = PublicContent::where('section', 'about')
            ->orderByDesc('updated_at')
            ->get()
            ->keyBy('key_name');

        $agents = $aboutContent->get('agents_count')?->value
            ?? $aboutContent->get('about_agents_count')?->value
            ?? '137';
        $warehouses = $aboutContent->get('warehouses_count')?->value
            ?? $aboutContent->get('about_warehouses_count')?->value
            ?? '70';
        $capacity = $aboutContent->get('capacity_count')?->value
            ?? $aboutContent->get('about_capacity_tonnes')?->value
            ?? '86000';
        $experience = $aboutContent->get('experience_count')?->value
            ?? $aboutContent->get('about_years_experience')?->value
            ?? '15';

        $stats = [
            'agents' => $agents,
            'warehouses' => $warehouses,
            'capacity' => $capacity,
            'experience' => $experience,
        ];
        
        return view('public.about', compact('aboutContent', 'stats'));
    }
}
