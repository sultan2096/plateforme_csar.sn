<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechnicalPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class TechnicalPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = TechnicalPartner::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('organization', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $partners = $query
            ->orderByRaw('position IS NULL, position ASC')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total' => TechnicalPartner::count(),
            'active' => TechnicalPartner::where('status', 'active')->count(),
            'ong' => TechnicalPartner::where('type', 'ong')->count(),
            'agency' => TechnicalPartner::where('type', 'agency')->count(),
            'institution' => TechnicalPartner::where('type', 'institution')->count(),
            'private' => TechnicalPartner::where('type', 'private')->count(),
            'government' => TechnicalPartner::where('type', 'government')->count(),
            'featured' => TechnicalPartner::where('is_featured', true)->count(),
            'inactive' => TechnicalPartner::where('status', 'inactive')->count(),
            'pending' => TechnicalPartner::where('status', 'pending')->count(),
        ];

        $filters = $request->only(['search', 'type', 'status']);
        return view('admin.technical-partners.index', compact('partners', 'stats', 'filters'));
    }

    public function create()
    {
        return view('admin.technical-partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:technical_partners,slug',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'partnership_type' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending',
            'type' => 'required|in:ong,agency,institution,private,government',
            'organization' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'role' => 'nullable|string|max:255',
            'intervention_zone' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'position' => 'nullable|integer|min:1|max:999'
        ]);

        $data = $request->all();

        // Gestion du logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
            $data['logo'] = $logoPath;
        }

        // Auto-génération du slug si vide
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Gestion des zones d'intervention
        if ($request->filled('intervention_zone')) {
            $zones = json_decode($request->intervention_zone, true);
            $data['intervention_zone'] = is_array($zones) ? $zones : [];
        }

        // Gestion du checkbox is_featured
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        // Position par défaut si non spécifiée
        if (empty($data['position'])) {
            $lastPosition = TechnicalPartner::max('position') ?? 0;
            $data['position'] = $lastPosition + 10;
        }

        TechnicalPartner::create($data);

        return redirect()->route('admin.technical-partners.index')
            ->with('success', 'Partenaire technique créé avec succès.');
    }

    public function show(TechnicalPartner $technicalPartner)
    {
        return view('admin.technical-partners.show', compact('technicalPartner'));
    }

    public function edit(TechnicalPartner $technicalPartner)
    {
        return view('admin.technical-partners.edit', compact('technicalPartner'));
    }

    public function update(Request $request, TechnicalPartner $technicalPartner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:technical_partners,slug,' . $technicalPartner->id,
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'partnership_type' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending',
            'type' => 'required|in:ong,agency,institution,private,government',
            'organization' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'role' => 'nullable|string|max:255',
            'intervention_zone' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'position' => 'nullable|integer|min:1|max:999'
        ]);

        $data = $request->all();

        // Gestion du logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo
            if ($technicalPartner->logo) {
                Storage::disk('public')->delete($technicalPartner->logo);
            }

            $logoPath = $request->file('logo')->store('partners', 'public');
            $data['logo'] = $logoPath;
        }

        // Auto-génération du slug si vide
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Gestion des zones d'intervention
        if ($request->filled('intervention_zone')) {
            $zones = json_decode($request->intervention_zone, true);
            $data['intervention_zone'] = is_array($zones) ? $zones : [];
        }

        // Gestion du checkbox is_featured (depuis le formulaire principal ou depuis l'action toggle)
        if ($request->has('is_featured')) {
            $data['is_featured'] = $request->is_featured == '1' ? true : false;
        }

        $technicalPartner->update($data);

        try { Artisan::call('cache:clear'); } catch (\Throwable $e) {}

        return redirect()->route('admin.technical-partners.index')
            ->with('success', 'Partenaire technique mis à jour avec succès.');
    }

    public function destroy(TechnicalPartner $technicalPartner)
    {
        if ($technicalPartner->logo) {
            Storage::disk('public')->delete($technicalPartner->logo);
        }

        $technicalPartner->delete();
        return redirect()->route('admin.technical-partners.index')
            ->with('success', 'Partenaire technique supprimé avec succès.');
    }

    public function export()
    {
        $partners = TechnicalPartner::orderBy('created_at', 'desc')->get();

        $filename = 'technical_partners_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($partners) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Nom', 'Organisation', 'Type', 'Statut', 'Email', 'Téléphone', 'Site web']);
            foreach ($partners as $p) {
                fputcsv($out, [
                    $p->id,
                    $p->name,
                    $p->organization,
                    $p->type,
                    $p->status,
                    $p->email,
                    $p->phone,
                    $p->website,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reorder()
    {
        $partners = TechnicalPartner::orderBy('name')->get();
        $position = 10;
        foreach ($partners as $partner) {
            $partner->position = $position;
            $partner->save();
            $position += 10;
        }
        try { Artisan::call('cache:clear'); } catch (\Throwable $e) {}
        return redirect()->route('admin.technical-partners.index')->with('success', 'Réorganisation automatique effectuée.');
    }

    public function toggleFeatured(TechnicalPartner $technicalPartner)
    {
        $technicalPartner->update([
            'is_featured' => !$technicalPartner->is_featured
        ]);

        $message = $technicalPartner->is_featured 
            ? 'Partenaire marqué à la une avec succès.' 
            : 'Partenaire retiré de la une avec succès.';

        return redirect()->back()->with('success', $message);
    }

    public function updatePosition(Request $request, TechnicalPartner $technicalPartner)
    {
        $request->validate([
            'position' => 'required|integer|min:1|max:999'
        ]);

        $technicalPartner->update([
            'position' => $request->position
        ]);

        return redirect()->back()->with('success', 'Position mise à jour avec succès.');
    }

    public function reorderPartners(Request $request)
    {
        $positions = $request->validate([
            'positions' => 'required|array',
            'positions.*' => 'integer|exists:technical_partners,id'
        ]);

        foreach ($positions['positions'] as $position => $partnerId) {
            TechnicalPartner::where('id', $partnerId)->update([
                'position' => $position + 1
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Ordre mis à jour avec succès.']);
    }
}



