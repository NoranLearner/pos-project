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

    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
