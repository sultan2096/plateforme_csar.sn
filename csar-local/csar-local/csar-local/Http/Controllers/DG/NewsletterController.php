<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsletterController extends Controller
{
    /**
     * Afficher la liste des abonnés à la newsletter
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();
        
        // Filtres
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $subscribers = $query->orderBy('created_at', 'desc')->paginate(50);
        
        // Statistiques
        $stats = [
            'total_subscribers' => NewsletterSubscriber::count(),
            'active_subscribers' => NewsletterSubscriber::where('is_active', true)->count(),
            'inactive_subscribers' => NewsletterSubscriber::where('is_active', false)->count(),
            'new_this_month' => NewsletterSubscriber::whereMonth('created_at', now()->month)->count(),
            'new_this_week' => NewsletterSubscriber::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        
        return view('dg.newsletter.index', compact('subscribers', 'stats'));
    }
    
    /**
     * Afficher les détails d'un abonné
     */
    public function show($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        return view('dg.newsletter.show', compact('subscriber'));
    }
    
    /**
     * Exporter la liste des abonnés en CSV
     */
    public function exportCsv(Request $request)
    {
        $query = NewsletterSubscriber::query();
        
        // Appliquer les mêmes filtres que l'index
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $subscribers = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'newsletter-abonnes-' . date('Y-m-d-H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Statut',
                'Date d\'inscription',
                'Dernière activité'
            ]);
            
            // Données
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->id,
                    $subscriber->name,
                    $subscriber->email,
                    $subscriber->is_active ? 'Actif' : 'Inactif',
                    $subscriber->created_at->format('d/m/Y H:i'),
                    $subscriber->updated_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Afficher l'historique des inscriptions
     */
    public function history(Request $request)
    {
        $query = NewsletterSubscriber::query();
        
        // Filtres par période
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }
        
        $subscribers = $query->orderBy('created_at', 'desc')->paginate(100);
        
        // Statistiques d'évolution
        $evolution = $this->getEvolutionStats();
        
        return view('dg.newsletter.history', compact('subscribers', 'evolution'));
    }
    
    /**
     * Obtenir les statistiques d'évolution
     */
    private function getEvolutionStats()
    {
        $stats = [];
        
        // Évolution sur les 12 derniers mois
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = NewsletterSubscriber::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $stats[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }
        
        return $stats;
    }
}
