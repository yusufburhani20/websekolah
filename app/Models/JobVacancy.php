<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $fillable = [
        'company_id',
        'judul_lowongan',
        'posisi',
        'deskripsi_pekerjaan',
        'persyaratan',
        'tipe_pekerjaan',
        'lokasi_penempatan',
        'batas_lamaran',
        'is_active',
        'jurusan_terkait',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'batas_lamaran' => 'date',
        'jurusan_terkait' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
