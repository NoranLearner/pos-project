<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductPrice;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

use Illuminate\Database\Eloquent\SoftDeletes;

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

}
