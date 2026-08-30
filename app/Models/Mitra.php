<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{

    public function getImageFieldsToOptimize()
    {
        return ['logo'];
    }
    use \App\Traits\OptimizesImagesToWebp;

    protected $guarded = [];

    //
}
