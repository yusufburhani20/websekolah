<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        
        $query = Document::where('publik', 1);
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        $kategori_list = Document::where('publik', 1)->select('kategori')->distinct()->pluck('kategori');
        
        return view('documents.index', compact('documents', 'kategori_list', 'kategori'));
    }
}
