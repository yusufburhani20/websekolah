<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => 'array',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
