<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{

    public function getImageFieldsToOptimize()
    {
        return ['foto'];
    }
    use \App\Traits\OptimizesImagesToWebp;

    protected $guarded = [];

    //
}
