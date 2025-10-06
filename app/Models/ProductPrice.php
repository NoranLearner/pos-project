<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductPrice extends Model
{
    protected $fillable = ['product_id', 'purchase_price', 'sale_price', 'start_date', 'end_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
