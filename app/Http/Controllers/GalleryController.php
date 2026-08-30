<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        
        $query = Gallery::where('aktif', 1);
        
        if ($kategori) {
            $query->where('kategori', 'like', '%' . $kategori . '%');
        }
        
        $galleries = $query->latest()->paginate(16);
        $kategories = Gallery::where('aktif', 1)
                        ->whereNotNull('kategori')
                        ->select('kategori')
                        ->distinct()
                        ->get()
                        ->pluck('kategori');
                        
        return view('gallery.index', compact('galleries', 'kategori', 'kategories'));
    }
}
