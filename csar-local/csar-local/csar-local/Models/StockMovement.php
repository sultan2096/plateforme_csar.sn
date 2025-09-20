<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'warehouse_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'reason',
        'reference',
        'created_by'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'quantity_before' => 'decimal:2',
        'quantity_after' => 'decimal:2',
    ];

    /**
     * Relation avec l'entrepôt
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Relation avec l'utilisateur (responsable)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation avec le stock
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Scope pour filtrer par entrepôt
     */
    public function scopeForWarehouse($query, $warehouseId)
    {
        return $query->where('warehouse_id', $warehouseId);
    }

    /**
     * Scope pour filtrer par type de mouvement
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopeInPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Obtenir le stock actuel d'un produit dans un entrepôt
     */
    public static function getCurrentStock($warehouseId, $productName)
    {
        $stock = Stock::where('warehouse_id', $warehouseId)
            ->where('item_name', $productName)
            ->first();

        return $stock ? $stock->quantity : 0;
    }

    /**
     * Calculer le stock après un mouvement
     */
    public static function calculateStockAfter($warehouseId, $productName, $quantity, $type)
    {
        $currentStock = self::getCurrentStock($warehouseId, $productName);
        
        if ($type === 'in') {
            return $currentStock + $quantity;
        } else {
            return max(0, $currentStock - $quantity); // Ne pas aller en négatif
        }
    }
}
