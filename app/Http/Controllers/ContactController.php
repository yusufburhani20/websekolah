<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
        ]);
        
        $validated['status'] = 'baru';
        
        ContactMessage::create($validated);
        
        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera merespon.');
    }
}
