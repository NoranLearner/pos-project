<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'phone', 'address'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
