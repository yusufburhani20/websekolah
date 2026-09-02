<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori'); // No default, so it shows all if not set
        
        $query = Teacher::where('aktif', 1);
        
        if ($kategori && $kategori !== 'Semua') {
            $query->where('kategori', 'like', '%' . $kategori . '%');
        }
        
        $teachers = $query->orderBy('urutan', 'asc')->orderBy('created_at', 'asc')->get();
        
        // Get all unique categories for dynamic buttons (optional) or just use 'Guru' and 'Staff' manually.
        // Let's pass the distinct categories just in case we want to use them.
        $kategories = Teacher::where('aktif', 1)
                        ->whereNotNull('kategori')
                        ->select('kategori')
                        ->distinct()
                        ->get()
                        ->pluck('kategori');
                        
        return view('teachers.index', compact('teachers', 'kategori', 'kategories'));
    }
}
