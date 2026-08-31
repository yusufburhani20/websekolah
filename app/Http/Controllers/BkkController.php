<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Company;

class BkkController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::with('company')
            ->where('is_active', true)
            ->where('batas_lamaran', '>=', now()->format('Y-m-d'));

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul_lowongan', 'like', '%' . $request->search . '%')
                  ->orWhere('posisi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('company', function($q2) use ($request) {
                      $q2->where('nama_perusahaan', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $vacancies = $query->latest()->paginate(12)->withQueryString();
        $companies = Company::all();

        return view('bkk.index', compact('vacancies', 'companies'));
    }

    public function show($id)
    {
        $vacancy = JobVacancy::with('company')->findOrFail($id);
        
        // Cek apakah lowongan masih aktif
        if (!$vacancy->is_active || $vacancy->batas_lamaran < now()->format('Y-m-d')) {
            return redirect('/bkk')->with('error', 'Lowongan kerja ini sudah ditutup.');
        }

        return view('bkk.show', compact('vacancy'));
    }
}
