<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        $angka1 = rand(1, 9);
        $angka2 = rand(1, 9);
        session(['captcha_hasil' => $angka1 + $angka2]);
        
        return view('contact', compact('angka1', 'angka2'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
            'captcha' => 'required|numeric|in:' . session('captcha_hasil'),
        ], [
            'captcha.in' => 'Jawaban verifikasi salah. Silakan coba lagi.'
        ]);
        
        $validated = $request->only(['nama', 'email', 'pesan']);
        $validated['status'] = 'baru';
        
        ContactMessage::create($validated);
        
        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera merespon.');
    }
}
