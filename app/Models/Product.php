<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'brand_id',
        'product_name',
        'description',
        'price',
        'stock_unit',
        'stock',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        'supplier_id',
        'skin_type',
        'dimension',
        'volume_unit',
        'volume',
        'image',
        'date_manufactured',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function subSubCategory()
    {
        return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_product', 'product_id', 'discount_id')->using(DiscountProduct::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'stock_id');
    }

    // Implement business logic
    public function calculateDiscountedPrice()
    {
        // Ensure the discount is within the valid range
        $discount = max(0, min(100, $this->discount));
        return $this->price * (1 - $discount / 100);
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('path/to/default/image.jpg');
    }

    public function getStockLevel()
    {
        if ($this->stock->quantity == 0) {
            return 'Need for Restock';
        } elseif ($this->stock->quantity <= 10) {
            return 'Low';
        } elseif ($this->stock->quantity <= 50) {
            return 'Medium';
        } else {
            return 'High';
        }
    }


    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = max(0, min(100, $value));
    }
}
