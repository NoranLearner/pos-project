<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [ 'client_id', 'total_price' ];

    // client has many orders
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // order has many products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order_pivot')->withPivot('quantity');
    }
}
