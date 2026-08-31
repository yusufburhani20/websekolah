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

    public function getFotoUrlAttribute()
    {
        $foto = $this->foto;
        
        if (empty($foto) || $foto === 'default-guru.png' || $foto === 'default1.jpg' || $foto === 'default.jpg') {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=1e3a8a&color=fff&size=512';
        }

        if (str_starts_with($foto, 'http')) {
            return $foto;
        }

        if (file_exists(public_path($foto))) {
            return asset($foto);
        }

        if (file_exists(public_path('assets/images/staff/' . $foto))) {
            return asset('assets/images/staff/' . $foto);
        }

        if (file_exists(storage_path('app/public/' . $foto))) {
            return asset('storage/' . $foto);
        }

        // Default fallback if stored in database but file is missing
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=1e3a8a&color=fff&size=512';
    }
}
