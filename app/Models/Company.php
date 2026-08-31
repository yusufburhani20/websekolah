<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'logo',
        'deskripsi',
        'alamat',
        'website',
        'email',
        'no_telp',
    ];

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }
}
