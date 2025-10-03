<?php

namespace App\Models;

use App\Models\Image;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['image', 'parent', 'deleted_at'];

    // Self Relationship

    public function parentData()
    {
        return $this->belongsTo(Category::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent', 'id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
