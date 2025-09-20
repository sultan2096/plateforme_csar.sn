<?php

namespace App\Http\Controllers\DG;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques agrégées
        $stats = [
            'total_requests' => PublicRequest::count(),
            'pending_requests' => PublicRequest::where('status', 'pending')->count(),
            'approved_requests' => PublicRequest::where('status', 'approved')->count(),
            'rejected_requests' => PublicRequest::where('status', 'rejected')->count(),
            'total_personnel' => User::where('role_id', '!=', 1)->count(), // Exclure les admins
            'total_warehouses' => Warehouse::where('is_active', true)->count(),
            'total_fuel' => \DB::table('stocks')
                ->join('stock_types', 'stocks.stock_type_id', '=', 'stock_types.id')
                ->where('stock_types.name', 'fuel')
                ->sum('stocks.quantity'),
            'total_food' => \DB::table('stocks')
                ->join('stock_types', 'stocks.stock_type_id', '=', 'stock_types.id')
                ->where('stock_types.name', 'food')
                ->sum('stocks.quantity'),
            'total_equipment' => \DB::table('stocks')
                ->join('stock_types', 'stocks.stock_type_id', '=', 'stock_types.id')
                ->where('stock_types.name', 'equipment')
                ->sum('stocks.quantity'),
        ];

        // Graphiques d'évolution
        $chartData = $this->getChartData();
        
        // Notifications récentes
        $notifications = $this->getNotifications();
        
        // Activité récente
        $recentActivity = $this->getRecentActivity();

        return view('dg.dashboard', compact('stats', 'chartData', 'notifications', 'recentActivity'));
    }

    private function getChartData()
    {
        // Évolution des demandes par mois (6 derniers mois)
        $requestsData = collect(range(1, 6))->map(function ($month) {
            $date = Carbon::now()->subMonths(6 - $month);
            $total = PublicRequest::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $pending = PublicRequest::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'pending')
                ->count();
            $approved = PublicRequest::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'approved')
                ->count();

            return [
                'month' => $date->format('M Y'),
                'total' => $total,
                'pending' => $pending,
                'approved' => $approved
            ];
        });

        // Évolution du carburant par mois (6 derniers mois)
        $fuelData = collect(range(1, 6))->map(function ($month) {
            $date = Carbon::now()->subMonths(6 - $month);
            $total = \DB::table('stocks')
                ->join('stock_types', 'stocks.stock_type_id', '=', 'stock_types.id')
                ->where('stock_types.name', 'fuel')
                ->whereYear('stocks.created_at', $date->year)
                ->whereMonth('stocks.created_at', $date->month)
                ->sum('stocks.quantity');
            return [
                'month' => $date->format('M Y'),
                'total' => $total
            ];
        });

        // Répartition des entrepôts par statut
        $warehouseStatuses = [
            'Actif' => Warehouse::where('is_active', true)->count(),
            'Inactif' => Warehouse::where('is_active', false)->count()
        ];
        $warehouseData = collect($warehouseStatuses)->map(function($count, $status) {
            return [
                'status' => $status,
                'count' => $count
            ];
        })->values();

        // Répartition du personnel par rôle
        $personnelData = User::selectRaw('role_id, count(*) as count')
            ->where('role_id', '!=', 1) // Exclure les admins
            ->groupBy('role_id')
            ->get()
            ->map(function ($item) {
                $roleNames = [
                    2 => 'Directeur Général',
                    3 => 'Responsable Entrepôt',
                    4 => 'Agent CSAR'
                ];
                return [
                    'role' => $roleNames[$item->role_id] ?? 'Inconnu',
                    'count' => $item->count
                ];
            });

        // Flux de stock par type
        $stockData = \DB::table('stocks')
            ->join('stock_types', 'stocks.stock_type_id', '=', 'stock_types.id')
            ->selectRaw('stock_types.name as type, sum(stocks.quantity) as total')
            ->groupBy('stock_types.name')
            ->get()
            ->map(function ($item) {
                $typeNames = [
                    'food' => 'Denrées',
                    'equipment' => 'Matériel',
                    'fuel' => 'Carburant'
                ];
                return [
                    'type' => $typeNames[$item->type] ?? $item->type,
                    'total' => $item->total
                ];
            });

        return [
            'requests' => $requestsData->toArray(),
            'personnel' => $personnelData->toArray(),
            'stock' => $stockData->toArray(),
            'fuel' => $fuelData->toArray(),
            'warehouses' => $warehouseData->toArray()
        ];
    }

    private function getNotifications()
    {
        $notifications = [];

        // Nouvelles demandes
        $newRequests = PublicRequest::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        if ($newRequests > 0) {
            $notifications[] = [
                'type' => 'request',
                'message' => "{$newRequests} nouvelle(s) demande(s) reçue(s) cette semaine",
                'icon' => 'fas fa-file-alt',
                'color' => 'blue'
            ];
        }

        // Nouveaux messages
        $newMessages = ContactMessage::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        if ($newMessages > 0) {
            $notifications[] = [
                'type' => 'message',
                'message' => "{$newMessages} nouveau(x) message(s) reçu(s)",
                'icon' => 'fas fa-envelope',
                'color' => 'green'
            ];
        }

        // Nouveau personnel
        $newPersonnel = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        if ($newPersonnel > 0) {
            $notifications[] = [
                'type' => 'personnel',
                'message' => "{$newPersonnel} nouveau(x) membre(s) du personnel",
                'icon' => 'fas fa-user-plus',
                'color' => 'orange'
            ];
        }

        return $notifications;
    }

    private function getRecentActivity()
    {
        $activities = [];

        // Demandes récentes
        $recentRequests = PublicRequest::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentRequests as $request) {
            $activities[] = [
                'type' => 'request',
                'title' => "Nouvelle demande {$request->type}",
                'description' => "Demande de {$request->full_name} - {$request->region}",
                'time' => $request->created_at->diffForHumans(),
                'status' => $request->status
            ];
        }

        // Messages récents
        $recentMessages = ContactMessage::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentMessages as $message) {
            $activities[] = [
                'type' => 'message',
                'title' => "Nouveau message de {$message->name}",
                'description' => Str::limit($message->message, 50),
                'time' => $message->created_at->diffForHumans(),
                'status' => 'unread'
            ];
        }

        // Trier par date
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 8);
    }
}
