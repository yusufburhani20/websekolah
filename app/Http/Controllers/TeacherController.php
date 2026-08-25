<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori', 'Guru');
        $teachers = Teacher::where('aktif', 1)
                    ->where('kategori', $kategori)
                    ->orderBy('urutan')
                    ->paginate(12);
                    
        return view('teachers.index', compact('teachers', 'kategori'));
    }
}
