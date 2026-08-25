@extends('layouts.public')

@section('title', 'Hubungi Kami - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-16 text-center px-4">
    <h1 class="text-4xl font-bold text-white mb-4">Hubungi Kami</h1>
    <p class="text-brand-100 max-w-2xl mx-auto">Punya pertanyaan atau butuh bantuan? Jangan ragu untuk mengirim pesan kepada kami.</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Form -->
        <div>
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/50">
                <h3 class="text-2xl font-bold text-brand-900 mb-6">Kirim Pesan</h3>
                
                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <p>{{ session('success') }}</p>
                </div>
                @endif
                
                <form action="/kontak" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors @error('nama') border-red-500 @enderror" placeholder="Masukkan nama Anda...">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors @error('email') border-red-500 @enderror" placeholder="Alamat email aktif...">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pesan</label>
                        <textarea name="pesan" rows="5" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors resize-none @error('pesan') border-red-500 @enderror" placeholder="Tuliskan pesan atau pertanyaan Anda...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 rounded-xl transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="fa-regular fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Info & Map -->
        <div>
            <div class="bg-brand-50 rounded-3xl p-8 mb-8 border border-brand-100">
                <h3 class="text-xl font-bold text-brand-900 mb-6">Informasi Kontak</h3>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-brand-500 flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 mb-1">Alamat</h4>
                            <p class="text-slate-600 leading-relaxed">{{ $settings->alamat ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-brand-500 flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-phone text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 mb-1">Telepon</h4>
                            <p class="text-slate-600">{{ $settings->telepon ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-brand-500 flex-shrink-0 shadow-sm">
                            <i class="fa-regular fa-envelope text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 mb-1">Email</h4>
                            <p class="text-slate-600">{{ $settings->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map -->
            @if($settings->maps_iframe)
            <div class="rounded-3xl overflow-hidden shadow-sm h-64 relative border border-slate-200">
                {!! $settings->maps_iframe !!}
            </div>
            @endif
        </div>
        
    </div>
</div>
@endsection
