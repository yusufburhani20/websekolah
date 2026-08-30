<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public function getImageFieldsToOptimize()
    {
        return ['thumbnail', 'foto'];
    }
    use \App\Traits\OptimizesImagesToWebp;

    protected $guarded = [];
    
    protected $casts = [
        'foto' => 'array',
    ];
}
