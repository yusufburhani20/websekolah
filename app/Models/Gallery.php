<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    public function getImageFieldsToOptimize()
    {
        return ['gambar'];
    }
    use \App\Traits\OptimizesImagesToWebp;

    protected $guarded = [];
    
    protected $casts = [
        'gambar' => 'array',
        'aktif' => 'boolean',
    ];
}
