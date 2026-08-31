<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_vacancy_id',
        'nama_pelamar',
        'tahun_lulus',
        'no_hp',
        'email',
        'pesan_pengantar',
        'file_cv',
        'status_lamaran',
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
