<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PublicRequest::with('assignedTo');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        $requests = $query->latest()->paginate(20);
        $agents = User::where('role_id', 4)->get(); // Agents

        return view('admin.requests.index', compact('requests', 'agents'));
    }

    public function show(PublicRequest $request)
    {
        $request->load('assignedTo');
        // Marquer comme vue quand on ouvre la fiche
        $request->markAsViewed();
        return view('admin.requests.show', compact('request'));
    }

    public function update(Request $request, PublicRequest $publicRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_comment' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $publicRequest->update($validated);

        if ($request->status !== 'pending') {
            $publicRequest->update(['processed_date' => now()]);
        }

        // Toute action d'update sur le statut signifie que la demande a été vue
        $publicRequest->markAsViewed();

        return redirect()->back()->with('success', 'Demande mise à jour avec succès');
    }

    public function updateStatus(Request $request, PublicRequest $publicRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $publicRequest->update($validated);

        if ($request->status !== 'pending') {
            $publicRequest->update(['processed_date' => now()]);
        }

        // Marquer comme vue lors du changement de statut
        $publicRequest->markAsViewed();

        $statusMessages = [
            'approved' => 'Demande approuvée avec succès',
            'rejected' => 'Demande rejetée',
            'completed' => 'Demande marquée comme terminée',
            'pending' => 'Demande remise en attente'
        ];

        return redirect()->back()->with('success', $statusMessages[$request->status] ?? 'Statut mis à jour avec succès');
    }

    public function exportPdf(PublicRequest $request)
    {
        // Logique d'export PDF avec DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.requests.pdf', compact('request'));
        return $pdf->download('demande-' . $request->tracking_code . '.pdf');
    }

    public function exportExcel()
    {
        // Logique d'export Excel
        $requests = PublicRequest::with('assignedTo')->get();
        
        $filename = 'demandes-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return response()->json([
            'message' => 'Export Excel en cours...',
            'filename' => $filename
        ]);
    }

    /**
     * Afficher le formulaire de création d'une demande
     */
    public function create()
    {
        $agents = User::where('role_id', 4)->get(); // Agents
        $regions = [
            'Dakar', 'Thiès', 'Diourbel', 'Fatick', 'Kaolack', 'Kolda', 'Louga', 
            'Matam', 'Saint-Louis', 'Tambacounda', 'Ziguinchor', 'Kaffrine', 
            'Kédougou', 'Sédhiou'
        ];
        
        return view('admin.requests.create', compact('agents', 'regions'));
    }

    /**
     * Enregistrer une nouvelle demande
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:help,partnership,audience',
            'region' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'status' => 'required|in:pending,approved,rejected,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_comment' => 'nullable|string'
        ]);

        // Générer un code de suivi unique
        $trackingCode = 'CSAR-' . date('Y') . '-' . strtoupper(uniqid());

        $validated['tracking_code'] = $trackingCode;
        $validated['submitted_date'] = now();

        PublicRequest::create($validated);

        return redirect()->route('admin.requests.index')
            ->with('success', 'Demande créée avec succès. Code de suivi: ' . $trackingCode);
    }

    /**
     * Afficher le formulaire d'édition d'une demande
     */
    public function edit(PublicRequest $request)
    {
        $agents = User::where('role_id', 4)->get(); // Agents
        $regions = [
            'Dakar', 'Thiès', 'Diourbel', 'Fatick', 'Kaolack', 'Kolda', 'Louga', 
            'Matam', 'Saint-Louis', 'Tambacounda', 'Ziguinchor', 'Kaffrine', 
            'Kédougou', 'Sédhiou'
        ];
        
        return view('admin.requests.edit', compact('request', 'agents', 'regions'));
    }

    /**
     * Mettre à jour une demande
     */
    public function updateRequest(Request $request, PublicRequest $publicRequest)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:help,partnership,audience',
            'region' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            'status' => 'required|in:pending,approved,rejected,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_comment' => 'nullable|string'
        ]);

        $publicRequest->update($validated);

        return redirect()->route('admin.requests.index')
            ->with('success', 'Demande mise à jour avec succès');
    }

    /**
     * Supprimer une demande
     */
    public function destroy(PublicRequest $request)
    {
        $trackingCode = $request->tracking_code;
        $request->delete();

        return redirect()->route('admin.requests.index')
            ->with('success', 'Demande supprimée avec succès. Code: ' . $trackingCode);
    }
} 