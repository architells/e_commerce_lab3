<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DiscountProduct extends Pivot
{
    protected $primaryKey = 'id';
    protected $table = 'discount_product';

    protected $fillable = [
        'discount_id',
        'product_id',
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Define the relationship to the Discount model
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
