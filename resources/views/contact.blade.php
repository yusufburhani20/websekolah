@extends('layouts.public')

@section('title', 'Hubungi Kami - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<!-- Header Kontak -->
<div class="bg-brand-950 pt-16 pb-32 text-center px-4 relative overflow-hidden">
    <!-- Dekorasi Background Solid -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-800 rounded-full mix-blend-multiply opacity-20 -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-900 rounded-full mix-blend-multiply opacity-40 translate-y-1/2 -translate-x-1/3"></div>
    
    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li class="inline-flex items-center">
                    <a href="/" class="text-slate-300 hover:text-white inline-flex items-center transition-colors">
                        <i class="fa-solid fa-house mr-2 text-xs"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-slate-500 mx-2 text-[10px]"></i>
                        <span class="text-white font-semibold">Hubungi Kami</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">Mari Terhubung!</h1>
        <p class="text-brand-100 max-w-2xl mx-auto text-lg">Punya pertanyaan, masukan, atau butuh bantuan? Jangan ragu untuk mengirim pesan kepada kami kapan saja.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-16 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Kolom Form (Lebih Lebar) -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl p-8 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50">
                <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-6">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fa-regular fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-950">Kirim Pesan Online</h3>
                        <p class="text-slate-500 text-sm">Tim kami akan membalas pesan Anda melalui email secepatnya.</p>
                    </div>
                </div>
                
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl mb-8 flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                    <div>
                        <h4 class="text-green-800 font-bold mb-1">Pesan Terkirim!</h4>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                @endif
                
                <form action="/kontak" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all @error('nama') border-red-500 bg-red-50 @enderror" placeholder="Budi Santoso">
                            @error('nama')
                                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all @error('email') border-red-500 bg-red-50 @enderror" placeholder="budi@email.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Isi Pesan</label>
                        <textarea name="pesan" rows="6" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all resize-none @error('pesan') border-red-500 bg-red-50 @enderror" placeholder="Tuliskan pesan, pertanyaan, atau keluhan Anda di sini...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Kotak Captcha Modern -->
                    <div class="mb-8 bg-brand-50 p-6 rounded-2xl border border-brand-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <label class="block text-sm font-bold text-brand-900 mb-1">Verifikasi Keamanan</label>
                            <p class="text-xs text-brand-600/80">Buktikan Anda bukan robot pengirim spam.</p>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <div class="bg-white border border-brand-200 text-brand-900 font-extrabold text-xl w-12 h-12 flex items-center justify-center rounded-xl shadow-sm">
                                {{ $angka1 ?? 0 }}
                            </div>
                            <span class="text-brand-400 font-bold text-lg"><i class="fa-solid fa-plus"></i></span>
                            <div class="bg-white border border-brand-200 text-brand-900 font-extrabold text-xl w-12 h-12 flex items-center justify-center rounded-xl shadow-sm">
                                {{ $angka2 ?? 0 }}
                            </div>
                            <span class="text-brand-400 font-bold text-lg mx-1">=</span>
                            <div class="relative w-20">
                                <input type="number" name="captcha" required class="w-full border-2 border-amber-400 rounded-xl px-3 h-12 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/20 text-xl font-bold text-center transition-all bg-white @error('captcha') border-red-500 @enderror" placeholder="?">
                            </div>
                        </div>
                    </div>
                    @error('captcha')
                        <p class="text-red-500 text-sm mb-6 font-semibold bg-red-50 py-2 px-4 rounded-lg"><i class="fa-solid fa-triangle-exclamation mr-1.5"></i> {{ $message }}</p>
                    @enderror
                    
                    <button type="submit" class="w-full md:w-auto px-10 bg-amber-400 hover:bg-amber-500 text-brand-950 font-extrabold text-lg py-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-3">
                        Kirim Pesan Sekarang <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Kolom Info & Peta -->
        <div class="lg:col-span-5 space-y-8">
            
            <!-- Kartu Info -->
            <div class="bg-brand-950 rounded-3xl p-8 md:p-10 border-t-8 border-amber-400 shadow-xl overflow-hidden relative">
                <!-- Dekorasi Watermark -->
                <i class="fa-solid fa-headset absolute -bottom-6 -right-6 text-9xl text-brand-800 opacity-30 transform -rotate-12"></i>
                
                <h3 class="text-2xl font-bold text-white mb-8 relative z-10">Detail Kontak Resmi</h3>
                
                <div class="space-y-8 relative z-10">
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-brand-800 text-amber-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-amber-400 group-hover:text-brand-950 transition-colors">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-300 mb-1 text-sm uppercase tracking-wider">Alamat Sekolah</h4>
                            <p class="text-white leading-relaxed">{{ $settings->alamat ?? 'Belum ada data alamat' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-brand-800 text-amber-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-amber-400 group-hover:text-brand-950 transition-colors">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-300 mb-1 text-sm uppercase tracking-wider">Telepon / WhatsApp</h4>
                            <p class="text-white font-medium text-lg">{{ $settings->telepon ?? '-' }}</p>
                            @if(!empty($settings->whatsapp))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-amber-400 hover:text-white mt-1 transition-colors">
                                <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-brand-800 text-amber-400 rounded-full flex items-center justify-center text-lg flex-shrink-0 group-hover:bg-amber-400 group-hover:text-brand-950 transition-colors">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-300 mb-1 text-sm uppercase tracking-wider">Email Resmi</h4>
                            <a href="mailto:{{ $settings->email ?? '' }}" class="text-white hover:text-amber-400 font-medium transition-colors">{{ $settings->email ?? '-' }}</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Peta (Map) -->
            @if($settings->maps_iframe)
            <div class="bg-white p-2 rounded-3xl border border-slate-100 shadow-sm">
                <div class="rounded-2xl overflow-hidden h-[300px] relative bg-slate-100 group">
                    <!-- Overlap penanda hover -->
                    <div class="absolute inset-0 bg-brand-900/10 z-10 pointer-events-none group-hover:opacity-0 transition-opacity duration-500"></div>
                    
                    <div class="w-full h-full grayscale group-hover:grayscale-0 transition-all duration-700">
                        {!! preg_replace('/width="[^"]*"/', 'width="100%"', preg_replace('/height="[^"]*"/', 'height="100%"', $settings->maps_iframe)) !!}
                    </div>
                </div>
            </div>
            @endif
            
        </div>
        
    </div>
</div>
@endsection
