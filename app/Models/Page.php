<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    public function getImageFieldsToOptimize()
    {
        return ['gambar'];
    }
    use \App\Traits\OptimizesImagesToWebp;

    protected $guarded = [];
}
