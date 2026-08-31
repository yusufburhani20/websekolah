<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\JobApplication;

class JobApplicationForm extends Component
{
    use WithFileUploads;

    public $vacancyId;
    public $nama_pelamar;
    public $tahun_lulus;
    public $no_hp;
    public $email;
    public $pesan_pengantar;
    public $file_cv;

    public $successMessage = false;

    public function mount($vacancyId)
    {
        $this->vacancyId = $vacancyId;
    }

    protected $rules = [
        'nama_pelamar' => 'required|string|max:255',
        'tahun_lulus' => 'required|numeric',
        'no_hp' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'pesan_pengantar' => 'nullable|string',
        'file_cv' => 'required|file|mimes:pdf|max:2048', // Max 2MB PDF
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi.',
        'email' => 'Format email tidak valid.',
        'numeric' => ':attribute harus berupa angka.',
        'file_cv.mimes' => 'File CV harus berformat PDF.',
        'file_cv.max' => 'Ukuran file CV maksimal 2MB.',
    ];

    public function submit()
    {
        $this->validate();

        $cvPath = $this->file_cv->store('cv_pelamar', 'public');

        JobApplication::create([
            'job_vacancy_id' => $this->vacancyId,
            'nama_pelamar' => $this->nama_pelamar,
            'tahun_lulus' => $this->tahun_lulus,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'pesan_pengantar' => $this->pesan_pengantar,
            'file_cv' => $cvPath,
            'status_lamaran' => 'Menunggu',
        ]);

        $this->successMessage = true;
        $this->reset(['nama_pelamar', 'tahun_lulus', 'no_hp', 'email', 'pesan_pengantar', 'file_cv']);
    }

    public function render()
    {
        return view('livewire.job-application-form');
    }
}
