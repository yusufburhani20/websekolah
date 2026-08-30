<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HeroSlide extends Model
{
    protected $guarded = [];

    protected function aktif(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $value === 'ya',
            set: fn (mixed $value) => $value ? 'ya' : 'tidak',
        );
    }
}