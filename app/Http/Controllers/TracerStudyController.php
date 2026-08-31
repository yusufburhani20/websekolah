<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TracerStudy;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class TracerStudyController extends Controller
{
    public function index(Request $request)
    {
        // For statistics
        $totalAlumni = TracerStudy::count();
        
        $allStatuses = TracerStudy::pluck('status');
        
        $statusCounts = ['Bekerja' => 0, 'Kuliah' => 0, 'Wirausaha' => 0, 'Mencari Kerja' => 0];
        foreach ($allStatuses as $statusArray) {
            if (is_array($statusArray)) {
                foreach ($statusArray as $s) {
                    if (isset($statusCounts[$s])) {
                        $statusCounts[$s]++;
                    }
                }
            }
        }

        $jurusanCounts = TracerStudy::select('jurusan_id', DB::raw('count(*) as total'))
            ->with('jurusan')
            ->groupBy('jurusan_id')
            ->get();

        // For the table list
        $query = TracerStudy::with('jurusan')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun_keluar', $request->tahun);
        }
        
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('jurusan_id', $request->jurusan);
        }

        if ($request->has('status') && $request->status != '') {
            $query->whereJsonContains('status', $request->status);
        }

        $alumnis = $query->paginate(20)->withQueryString();
        $jurusans = Jurusan::where('aktif', 1)->orderBy('nama_jurusan')->get();

        return view('tracer-study.index', compact('totalAlumni', 'statusCounts', 'jurusanCounts', 'alumnis', 'jurusans'));
    }

    public function create()
    {
        return view('tracer-study.create');
    }
}
