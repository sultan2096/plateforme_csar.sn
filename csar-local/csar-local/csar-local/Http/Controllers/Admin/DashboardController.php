<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use App\Models\ContactMessage;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\NewsletterSubscriber;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalRequests = PublicRequest::count();
        $totalPersonnel = User::where('role_id', '!=', 1)->count();
        $totalWarehouses = Warehouse::where('is_active', true)->count();
        $totalFuel = 0; // calcul précis déplacé vers les stocks (par unité L)
        
        // Nouveaux messages et abonnés
        $newMessages = ContactMessage::where('is_read', false)->count();
        $newsletterSubscribers = NewsletterSubscriber::count();
        
        // Croissance hebdomadaire
        $lastWeek = Carbon::now()->subWeek();
        $requestsGrowth = $this->calculateGrowth(PublicRequest::class, $lastWeek);
        $personnelGrowth = $this->calculateGrowth(User::class, $lastWeek, [['role_id', '!=', 1]]);
        $warehousesGrowth = $this->calculateGrowth(Warehouse::class, $lastWeek, [['is_active', true]]);
        $messagesGrowth = $this->calculateGrowth(ContactMessage::class, $lastWeek);
        $newsletterGrowth = $this->calculateGrowth(NewsletterSubscriber::class, $lastWeek);
        
        // Changement carburant (optionnel)
        $fuelChange = 0;
        
        // État des stocks
        [$stockStatus, $totals] = $this->getStockStatus();
        $totalFuel = $totals['fuel_total'];
        
        // Activités récentes
        $recentActivities = $this->getRecentActivities();
        
        // Notifications
        $notifications = $this->getNotifications();
        
        // Données pour les graphiques
        $chartData = $this->getChartData();
        
        // Complétion du profil
        $profileCompletion = $this->getProfileCompletion();
        
        // Données pour la carte interactive
        $mapData = $this->getMapData();
        
        return view('admin.dashboard', compact(
            'totalRequests',
            'totalPersonnel', 
            'totalWarehouses',
            'totalFuel',
            'newMessages',
            'newsletterSubscribers',
            'requestsGrowth',
            'personnelGrowth',
            'warehousesGrowth',
            'messagesGrowth',
            'newsletterGrowth',
            'fuelChange',
            'stockStatus',
            'recentActivities',
            'notifications',
            'chartData',
            'profileCompletion',
            'mapData'
        ));
    }
    
    private function calculateGrowth($model, $since, $conditions = [])
    {
        $currentCount = $model::when($conditions, function($query) use ($conditions) {
            foreach ($conditions as $condition) {
                if (is_array($condition) && count($condition) >= 2) {
                    $operator = $condition[1];
                    $value = $condition[2] ?? null;
                    $query->where($condition[0], $operator, $value);
                } else {
                    continue;
                }
            }
        })->where('created_at', '>=', $since)->count();
        
        $previousCount = $model::when($conditions, function($query) use ($conditions) {
            foreach ($conditions as $condition) {
                if (is_array($condition) && count($condition) >= 2) {
                    $operator = $condition[1];
                    $value = $condition[2] ?? null;
                    $query->where($condition[0], $operator, $value);
                } else {
                    continue;
                }
            }
        })->whereBetween('created_at', [$since->copy()->subWeek(), $since])->count();
        
        if ($previousCount == 0) {
            return $currentCount > 0 ? 100 : 0;
        }
        
        return round((($currentCount - $previousCount) / $previousCount) * 100);
    }
    
    private function calculateFuelChange()
    {
        $currentFuel = Stock::where('type', 'carburant')->sum('quantity') ?? 0;
        $lastWeekFuel = Stock::where('type', 'carburant')
            ->where('updated_at', '>=', Carbon::now()->subWeek())
            ->sum('quantity') ?? 0;
        
        if ($lastWeekFuel == 0) {
            return $currentFuel > 0 ? 100 : 0;
        }
        
        return round((($currentFuel - $lastWeekFuel) / $lastWeekFuel) * 100);
    }
    
    private function getStockStatus()
    {
        $stocks = Stock::with('stockType')->get();
        $stockStatus = [];
        $foodTotal = 0;
        $fuelTotal = 0;
        
        foreach ($stocks as $stock) {
            $unit = optional($stock->stockType)->unit ?? 'kg';
            $category = strtolower($unit) === 'l' ? 'carburant' : 'alimentaire';

            // Sommes par catégorie
            if ($category === 'carburant') {
                $fuelTotal += (float) $stock->quantity;
            } else {
                $foodTotal += (float) $stock->quantity;
            }

            $max = (float) ($stock->max_quantity ?? 0);
            $qty = (float) ($stock->quantity ?? 0);
            $percentage = $max > 0 ? min(100, ($qty / $max) * 100) : 0;
            
            $status = 'good';
            if ($percentage < 20) {
                $status = 'critical';
            } elseif ($percentage < 50) {
                $status = 'warning';
            }
            
            $stockStatus[] = (object) [
                'name' => $stock->item_name,
                'quantity' => $qty,
                'unit' => $unit,
                'percentage' => (int) round($percentage),
                'status' => $status,
                'category' => $category,
            ];
        }
        
        // Ordonner: critiques d'abord
        usort($stockStatus, function ($a, $b) {
            $order = ['critical' => 0, 'warning' => 1, 'good' => 2];
            if ($order[$a->status] === $order[$b->status]) {
                return $b->percentage <=> $a->percentage; // plus rempli en bas
            }
            return $order[$a->status] <=> $order[$b->status];
        });
        
        // Limiter à 8 pour le tableau de bord
        $limited = array_slice($stockStatus, 0, 8);
        
        return [$limited, [
            'food_total' => $foodTotal,
            'fuel_total' => $fuelTotal,
        ]];
    }
    
    private function getRecentActivities()
    {
        $activities = collect();
        
        // Demandes récentes
        $recentRequests = PublicRequest::latest()->take(5)->get();
        foreach ($recentRequests as $request) {
            $activities->push((object) [
                'icon' => 'hand-holding-heart',
                'description' => "Nouvelle demande de {$request->full_name} ({$request->type})",
                'created_at' => $request->created_at
            ]);
        }
        
        // Messages récents
        $recentMessages = ContactMessage::latest()->take(3)->get();
        foreach ($recentMessages as $message) {
            $activities->push((object) [
                'icon' => 'envelope',
                'description' => "Nouveau message de {$message->full_name}",
                'created_at' => $message->created_at
            ]);
        }
        
        // Nouveaux abonnés
        $recentSubscribers = NewsletterSubscriber::latest()->take(2)->get();
        foreach ($recentSubscribers as $subscriber) {
            $activities->push((object) [
                'icon' => 'user-plus',
                'description' => "Nouvel abonné newsletter: {$subscriber->email}",
                'created_at' => $subscriber->created_at
            ]);
        }
        
        return $activities->sortByDesc('created_at')->take(8);
    }
    
    private function getNotifications()
    {
        $notifications = collect();
        
        // Messages non lus
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        if ($unreadMessages > 0) {
            $notifications->push((object) [
                'icon' => 'envelope',
                'message' => "{$unreadMessages} nouveau(x) message(s) non lu(s)",
                'read' => false,
                'created_at' => Carbon::now()
            ]);
        }
        
        // Demandes en attente
        $pendingRequests = PublicRequest::where('status', 'pending')->count();
        if ($pendingRequests > 0) {
            $notifications->push((object) [
                'icon' => 'clock',
                'message' => "{$pendingRequests} demande(s) en attente de traitement",
                'read' => false,
                'created_at' => Carbon::now()
            ]);
        }
        
        // Stocks critiques
        $criticalStocks = Stock::whereRaw('quantity <= max_quantity * 0.2')->count();
        if ($criticalStocks > 0) {
            $notifications->push((object) [
                'icon' => 'exclamation-triangle',
                'message' => "{$criticalStocks} stock(s) en niveau critique",
                'read' => false,
                'created_at' => Carbon::now()
            ]);
        }
        
        return $notifications->take(5);
    }
    
    private function getChartData()
    {
        $days = 7;
        $labels = [];
        $requestsData = [];
        $warehousesData = [];
        $fuelData = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m');
            
            $requestsData[] = PublicRequest::whereDate('created_at', $date)->count();
            $warehousesData[] = Warehouse::where('is_active', true)
                ->whereDate('created_at', $date)->count();
            
            // Données de carburant (somme des stocks de type 'L')
            $fuelData[] = Stock::whereHas('stockType', function($query) {
                $query->where('unit', 'L');
            })->whereDate('updated_at', $date)->sum('quantity') ?? 0;
        }
        
        return [
            'labels' => $labels,
            'requestsData' => $requestsData,
            'warehousesData' => $warehousesData,
            'fuelData' => $fuelData
        ];
    }
    
    private function getProfileCompletion()
    {
        $user = auth()->user();
        if (!$user) {
            return [
                'completion' => 0,
                'basicInfo' => 0,
                'profilePhoto' => false,
                'permissions' => 0
            ];
        }
        // Calcul factice du profil pour l'instant
        return [
            'completion' => 75,
            'basicInfo' => 100,
            'profilePhoto' => true,
            'permissions' => 50
        ];
}
    
private function getMapData()
    {
        // Récupérer les entrepôts avec leurs coordonnées
        $warehouses = Warehouse::where('is_active', true)
            ->select('name', 'address', 'region', 'city', 'latitude', 'longitude', 'capacity')
            ->get()
            ->map(function ($warehouse) {
                return [
                    'lat' => (float) $warehouse->latitude,
                    'lng' => (float) $warehouse->longitude,
                    'name' => $warehouse->name,
                    'status' => 'active',
                    'capacity' => $warehouse->capacity . 'L',
                    'address' => $warehouse->address . ', ' . $warehouse->city
                ];
            });

        // Récupérer les demandes récentes avec géolocalisation
        $requests = PublicRequest::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('type', 'status', 'full_name', 'region', 'latitude', 'longitude', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($request) {
                return [
                    'lat' => (float) $request->latitude,
                    'lng' => (float) $request->longitude,
                    'type' => $request->type,
                    'status' => $request->status,
                    'name' => $request->full_name,
                    'region' => $request->region,
                    'date' => $request->created_at->format('d/m/Y')
                ];
            });

        // Si aucune donnée réelle, ajouter des données de test
        if ($warehouses->isEmpty()) {
            $warehouses = collect([
                [
                    'lat' => 14.7167,
                    'lng' => -17.4677,
                    'name' => 'Entrepôt Central CSAR',
                    'status' => 'active',
                    'capacity' => '50000L',
                    'address' => 'Dakar, Sénégal'
                ],
                [
                    'lat' => 14.7667,
                    'lng' => -17.3667,
                    'name' => 'Magasin de Stockage Thiès',
                    'status' => 'active',
                    'capacity' => '30000L',
                    'address' => 'Thiès, Sénégal'
                ],
                [
                    'lat' => 14.7833,
                    'lng' => -16.9333,
                    'name' => 'Entrepôt Kaolack',
                    'status' => 'active',
                    'capacity' => '25000L',
                    'address' => 'Kaolack, Sénégal'
                ]
            ]);
        }

        if ($requests->isEmpty()) {
            $requests = collect([
                [
                    'lat' => 14.7167,
                    'lng' => -17.4677,
                    'type' => 'Aide alimentaire',
                    'status' => 'pending',
                    'name' => 'Famille Diop',
                    'region' => 'Dakar',
                    'date' => now()->format('d/m/Y')
                ],
                [
                    'lat' => 14.7667,
                    'lng' => -17.3667,
                    'type' => 'Carburant',
                    'status' => 'approved',
                    'name' => 'Association Thiès',
                    'region' => 'Thiès',
                    'date' => now()->subDays(2)->format('d/m/Y')
                ],
                [
                    'lat' => 14.7833,
                    'lng' => -16.9333,
                    'type' => 'Aide médicale',
                    'status' => 'completed',
                    'name' => 'Centre de santé Kaolack',
                    'region' => 'Kaolack',
                    'date' => now()->subDays(5)->format('d/m/Y')
                ]
            ]);
        }

        return [
            'warehouses' => $warehouses,
            'requests' => $requests
        ];
    }
} 