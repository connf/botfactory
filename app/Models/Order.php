<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'bot_name',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function items()
    {
    	return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'sku', 'id', 'sku');
    }

    public function category()
    {
        // Get most prevalent category
        return Category::find($this->products()->get()
            ->groupBy('category_id')
            ->sortByDesc(function($categories) {
                return $categories->count();
            })->first()
        ->first()["category_id"]);
    }
}
