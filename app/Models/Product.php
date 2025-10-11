<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Order;
use App\Models\Category;
use App\Models\ProductPrice;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['category_id', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function currentSalePrice()
    {
        return $this->hasOne(ProductPrice::class)
        ->whereNull('end_date')
        ->orWhere('end_date', '>=', now())
        ->latest('start_date');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function oldestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
    }

    public function newestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->latestOfMany();
    }

    public function bestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->ofMany('likes', 'max');
    }

    public function imagesCount()
    {
        return $this->morphMany(Image::class, 'imageable')->count();
    }

    // order has many products
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order_pivot');
    }

}
