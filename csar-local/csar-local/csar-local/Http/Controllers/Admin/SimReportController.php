<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SimReportController extends Controller
{
    public function index()
    {
        $reports = SimReport::orderBy('report_date', 'desc')->paginate(15);
        // Fournir un tableau $stats pour éviter les erreurs de vue si référencé
        $stats = [
            'total' => SimReport::count(),
            'published' => SimReport::where('is_published', true)->count(),
        ];
        return view('admin.sim-reports.index', compact('reports', 'stats'));
    }

    public function create()
    {
        return view('admin.sim-reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'report_date' => 'required|date',
            'status' => 'required|in:draft,review,published,archived',
            'summary' => 'nullable|string',
            'context_objectives' => 'nullable|string',
            'methodology' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'supply_level' => 'nullable|string',
            'price_analysis' => 'nullable|string',
            'regional_distribution' => 'nullable|string',
            'key_trends' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'annexes' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['is_published'] = ($request->status === 'published');
        
        // Gestion du document PDF
        if ($request->hasFile('document_file')) {
            $documentPath = $request->file('document_file')->store('sim-reports/documents', 'public');
            $data['document_file'] = $documentPath;
        }
        
        // Gestion de l'image de couverture
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('sim-reports/images', 'public');
            $data['cover_image'] = $imagePath;
        }

        SimReport::create($data);

        return redirect()->route('admin.sim-reports.index')
            ->with('success', 'Rapport SIM créé avec succès.');
    }

    public function show(SimReport $simReport)
    {
        return view('admin.sim-reports.show', compact('simReport'));
    }

    public function edit(SimReport $simReport)
    {
        return view('admin.sim-reports.edit', compact('simReport'));
    }

    public function update(Request $request, SimReport $simReport)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'report_date' => 'required|date',
            'summary' => 'required|string',
            'price_analysis' => 'required|array',
            'supply_analysis' => 'required|array',
            'regional_analysis' => 'required|array',
            'recommendations' => 'nullable|string',
            'is_published' => 'boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            if ($simReport->file_path) {
                Storage::disk('public')->delete($simReport->file_path);
            }
            
            $filePath = $request->file('file')->store('sim-reports', 'public');
            $data['file_path'] = $filePath;
        }

        $simReport->update($data);

        return redirect()->route('admin.sim-reports.index')
            ->with('success', 'Rapport SIM mis à jour avec succès.');
    }

    public function destroy(SimReport $simReport)
    {
        if ($simReport->file_path) {
            Storage::disk('public')->delete($simReport->file_path);
        }
        
        $simReport->delete();
        return redirect()->route('admin.sim-reports.index')
            ->with('success', 'Rapport SIM supprimé avec succès.');
    }

    public function togglePublish(SimReport $simReport)
    {
        $simReport->update(['is_published' => !$simReport->is_published]);
        return redirect()->route('admin.sim-reports.index')
            ->with('success', 'Statut de publication mis à jour.');
    }
}



