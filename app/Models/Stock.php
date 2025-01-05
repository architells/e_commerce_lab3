<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockHistory;

class Stock extends Model
{
    use HasFactory;
    
    protected $table = 'stocks';
    protected $primaryKey = 'stock_id';
    protected $fillable = ['product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function history()
    {
        return $this->hasMany(StockHistory::class, 'stock_id', 'stock_id');
    }

    public function incrementStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();

        $this->history()->create([
            'quantity_change' => $quantity,
            'action' => 'increment',
        ]);
    }

    public function decrementStock($quantity)
    {
        $this->quantity -= $quantity;
        $this->save();

        $this->history()->create([
            'quantity_change' => $quantity,
            'action' => 'decrement',
        ]);
    }

    public function getStockLevel()
    {
        if ($this->quantity > 100) {
            return 'High';
        } elseif ($this->quantity > 50) {
            return 'Medium';
        } else {
            return 'Low';
        }
    }
    
}
