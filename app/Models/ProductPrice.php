<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = ['purchase_price', 'sale_price', 'start_date', 'end_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
