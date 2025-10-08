<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'phones', 'address'];

    protected $casts = [
        'phones' => 'array',
    ];

    protected function Name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
        );
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
