@extends('layouts.public')

@section('title', 'Direktori Guru & Staff - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<!-- Header Direktori -->
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
                        <span class="text-white font-semibold">Direktori Guru & Staff</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-8 leading-tight">SDM Unggul & Berdedikasi</h1>
        
        <!-- Toggle Switch Kategori -->
        <div class="flex flex-wrap justify-center gap-2 bg-brand-900/50 p-1.5 rounded-full border border-brand-800/50 shadow-inner max-w-fit mx-auto">
            <a href="/guru" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ !$kategori || $kategori == 'Semua' ? 'bg-amber-400 text-brand-950 shadow-md' : 'text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-users mr-1.5"></i> Semua
            </a>
            @foreach($kategories as $kat)
            @if($kat)
            <a href="/guru?kategori={{ urlencode($kat) }}" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ $kategori == $kat ? 'bg-amber-400 text-brand-950 shadow-md' : 'text-slate-400 hover:text-white' }}">
                {{ $kat }}
            </a>
            @endif
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-16 mb-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($teachers as $teacher)
        <div class="bg-white rounded-3xl overflow-hidden shadow-xl shadow-slate-200/40 border border-slate-50 group hover:shadow-2xl hover:shadow-slate-200/60 transition-all duration-500 transform hover:-translate-y-2 flex flex-col">
            <!-- Foto Guru -->
            <div class="aspect-w-3 aspect-h-4 bg-slate-100 relative overflow-hidden">
                <img src="{{ asset((str_starts_with($teacher->foto, 'assets') ? '' : 'assets/images/staff/') . ($teacher->foto ?: 'default.jpg')) }}" alt="{{ $teacher->nama }}" class="w-full h-full object-cover object-top filter group-hover:brightness-110 transition-all duration-700" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                
                <!-- Motto Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-brand-950 via-brand-950/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center p-6 text-center">
                    @if($teacher->motto)
                    <p class="text-white font-medium text-sm italic">"{{ $teacher->motto }}"</p>
                    @endif
                </div>
            </div>
            
            <!-- Detail Info -->
            <div class="p-6 text-center flex-1 flex flex-col">
                <h3 class="font-extrabold text-lg text-brand-950 mb-1 group-hover:text-brand-600 transition-colors">{{ $teacher->nama }}</h3>
                <p class="text-slate-500 text-sm font-semibold mb-3">{{ $teacher->jabatan ?? $teacher->bidang }}</p>
                @if($teacher->nidn)
                <p class="text-xs text-slate-400 font-medium mb-4">NUPTK: {{ $teacher->nidn }}</p>
                @endif
                
                <div class="w-12 h-1 bg-brand-100 rounded-full mx-auto mt-auto mb-4 group-hover:bg-amber-400 group-hover:w-16 transition-all duration-500"></div>
                
                <!-- Tombol Administrasi Web -->
                @if($teacher->link_web)
                <a href="{{ $teacher->link_web }}" target="_blank" class="block w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs py-3 px-4 rounded-xl transition-all duration-300 mt-2">
                    <i class="fa-solid fa-link mr-1.5"></i> Buka Perangkat Ajar
                </a>
                @else
                <button disabled class="block w-full bg-orange-200 text-white font-bold text-xs py-3 px-4 rounded-xl mt-2 cursor-not-allowed" title="Perangkat ajar belum tersedia">
                    <i class="fa-solid fa-link-slash mr-1.5"></i> Buka Perangkat Ajar
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-3xl border border-slate-100 shadow-sm text-center py-24">
            <div class="w-24 h-24 bg-brand-50 text-brand-400 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-users-slash text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-brand-950 mb-2">Data {{ $kategori }} Belum Tersedia</h3>
            <p class="text-slate-500">Silakan tambahkan data melalui panel dashboard administrator.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-16">
        {{ $teachers->appends(['kategori' => $kategori])->links('pagination::tailwind') }}
    </div>
</div>
@endsection
