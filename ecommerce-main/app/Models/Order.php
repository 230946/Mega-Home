<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'discount',
        'notes',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function products()
    {
        // order_product have: product_id, order_id, quantity, subtotal
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'subtotal');
    }
}
