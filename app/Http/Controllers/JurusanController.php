<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Teacher;

class JurusanController extends Controller
{
    public function show($slug)
    {
        $jurusan = Jurusan::where('slug', $slug)->where('aktif', 1)->firstOrFail();
        $teachers = Teacher::where('jurusan_id', $jurusan->id)->where('aktif', 1)->get();
        
        return view('jurusans.show', compact('jurusan', 'teachers'));
    }
}
