<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function create($id)
    {
        $vacancy = JobVacancy::with('company')->findOrFail($id);

        return view('bkk.apply', compact('vacancy'));
    }

    public function store(Request $request, $id)
    {
        $vacancy = JobVacancy::findOrFail($id);

        $validated = $request->validate([
            'nama_pelamar' => 'required|string|max:255',
            'tahun_lulus' => 'required|numeric',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'pesan_pengantar' => 'nullable|string',
            'file_cv' => 'required|file|mimes:pdf|max:2048', // Max 2MB PDF
        ], [
            'required' => ':attribute wajib diisi.',
            'email' => 'Format email tidak valid.',
            'numeric' => ':attribute harus berupa angka.',
            'file_cv.mimes' => 'File CV harus berformat PDF.',
            'file_cv.max' => 'Ukuran file CV maksimal 2MB.',
        ]);

        $cvPath = $request->file('file_cv')->store('cv_pelamar', 'public');

        JobApplication::create([
            'job_vacancy_id' => $vacancy->id,
            'nama_pelamar' => $validated['nama_pelamar'],
            'tahun_lulus' => $validated['tahun_lulus'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'pesan_pengantar' => $validated['pesan_pengantar'] ?? null,
            'file_cv' => $cvPath,
            'status_lamaran' => 'Menunggu',
        ]);

        return redirect()->route('bkk.show', $vacancy->id)->with('success', 'Terima kasih, lamaran dan CV Anda telah berhasil dikirimkan. Semoga beruntung!');
    }
}
