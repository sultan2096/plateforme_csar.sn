<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use Illuminate\Http\Request;
use PDF;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PublicRequest::query();
        
        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('region')) {
            $query->where('region', 'like', '%' . $request->region . '%');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $requests = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Statistiques pour les filtres
        $stats = [
            'total' => PublicRequest::count(),
            'aide' => PublicRequest::where('type', 'aide')->count(),
            'partenariat' => PublicRequest::where('type', 'partenariat')->count(),
            'audience' => PublicRequest::where('type', 'audience')->count(),
            'autre' => PublicRequest::where('type', 'autre')->count(),
            'pending' => PublicRequest::where('status', 'pending')->count(),
            'approved' => PublicRequest::where('status', 'approved')->count(),
            'rejected' => PublicRequest::where('status', 'rejected')->count(),
        ];
        
        return view('dg.requests.index', compact('requests', 'stats'));
    }
    
    public function show($id)
    {
        $request = PublicRequest::findOrFail($id);
        return view('dg.requests.show', compact('request'));
    }
    
    public function approve($id)
    {
        \Log::info("Tentative d'approbation de la demande ID: " . $id);
        
        try {
            $request = PublicRequest::findOrFail($id);
            \Log::info("Demande trouvée: " . $request->full_name . " - Statut actuel: " . $request->status);
            
            $request->update(['status' => 'approved']);
            \Log::info("Demande approuvée avec succès");
            
            return redirect()->route('dg.requests.show', $id)
                ->with('success', 'Demande approuvée avec succès.');
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l'approbation: " . $e->getMessage());
            return redirect()->route('dg.requests.show', $id)
                ->with('error', 'Erreur lors de l\'approbation: ' . $e->getMessage());
        }
    }
    
    public function reject($id)
    {
        \Log::info("Tentative de rejet de la demande ID: " . $id);
        
        try {
            $request = PublicRequest::findOrFail($id);
            \Log::info("Demande trouvée: " . $request->full_name . " - Statut actuel: " . $request->status);
            
            $request->update(['status' => 'rejected']);
            \Log::info("Demande rejetée avec succès");
            
            return redirect()->route('dg.requests.show', $id)
                ->with('success', 'Demande rejetée.');
        } catch (\Exception $e) {
            \Log::error("Erreur lors du rejet: " . $e->getMessage());
            return redirect()->route('dg.requests.show', $id)
                ->with('error', 'Erreur lors du rejet: ' . $e->getMessage());
        }
    }
    
    public function complete($id)
    {
        $request = PublicRequest::findOrFail($id);
        $request->update(['status' => 'completed']);
        
        return redirect()->route('dg.requests.show', $id)
            ->with('success', 'Demande marquée comme terminée.');
    }
    
    public function export(Request $request)
    {
        $query = PublicRequest::query();
        
        // Appliquer les mêmes filtres que l'index
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('region')) {
            $query->where('region', 'like', '%' . $request->region . '%');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $requests = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('dg.requests.export', compact('requests'));
        
        return $pdf->download('demandes-csar-' . date('Y-m-d') . '.pdf');
    }
}
