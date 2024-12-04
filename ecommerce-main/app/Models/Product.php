<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'discount',
        'category_id',
    ];

    protected $append = ['price_with_discount'];

    public function getPriceWithDiscountAttribute()
    {
        return number_format($this->price * (1 - $this->discount / 100), 0, ',', '.');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
