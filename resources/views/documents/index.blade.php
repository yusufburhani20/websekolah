@extends('layouts.public')

@section('title', 'Pusat Unduhan - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<!-- Page Header (Premium Modern) -->
<section class="bg-brand-950 py-16 md:py-20 relative overflow-hidden">
    <!-- Elegant Premium Background -->
    <div class="absolute inset-0 z-0">
        <!-- Abstract gradient blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[150%] rounded-full bg-gradient-to-r from-brand-800 to-amber-500 blur-[100px] transform rotate-12"></div>
            <div class="absolute top-[20%] -right-[10%] w-[40%] h-[120%] rounded-full bg-gradient-to-l from-brand-600 to-transparent blur-[80px] transform -rotate-12"></div>
        </div>
        <!-- Dot pattern overlay -->
        <div class="absolute inset-0" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px; opacity: 0.05;"></div>
    </div>
    
    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center flex flex-col items-center justify-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-800/80 backdrop-blur-md border border-brand-700 rounded-full text-amber-400 text-xs font-bold uppercase tracking-widest mb-6 shadow-lg">
            <i class="fa-solid fa-cloud-arrow-down animate-bounce"></i> File & Resources
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg tracking-tight">
            Pusat <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-amber-500">Unduhan</span>
        </h1>
        <p class="text-brand-100 max-w-2xl mx-auto text-base md:text-lg font-medium leading-relaxed">
            Akses dan unduh berbagai dokumen resmi, brosur, modul materi, hingga formulir pendaftaran sekolah secara mudah dan cepat.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
    
    <!-- Filter Kategori -->
    <div class="flex flex-wrap justify-center gap-3 mb-12">
        <a href="/dokumen" class="px-6 py-2.5 rounded-full text-sm font-bold tracking-wide transition-all duration-300 {{ !$kategori ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30 transform -translate-y-1' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300' }}">
            Semua Dokumen
        </a>
        @foreach($kategori_list as $kat)
        <a href="/dokumen?kategori={{ urlencode($kat) }}" class="px-6 py-2.5 rounded-full text-sm font-bold tracking-wide transition-all duration-300 {{ $kategori == $kat ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30 transform -translate-y-1' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300' }}">
            {{ $kat }}
        </a>
        @endforeach
    </div>

    <!-- Dokumen List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $doc)
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl transition-all duration-300 group flex flex-col h-full transform hover:-translate-y-1 relative overflow-hidden">
            
            <!-- Format Badge -->
            <div class="absolute top-0 right-0">
                @php
                    $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                    $isPdf = $ext === 'pdf';
                    $colorClass = $isPdf ? 'bg-red-500' : 'bg-brand-500';
                    $iconClass = $isPdf ? 'fa-file-pdf' : 'fa-file-lines';
                @endphp
                <div class="{{ $colorClass }} text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl shadow-md uppercase tracking-widest flex items-center gap-1.5">
                    <i class="fa-solid {{ $iconClass }}"></i> {{ $ext ?: 'DOC' }}
                </div>
            </div>

            <div class="flex items-start gap-4 mb-4 mt-2">
                <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 text-brand-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:bg-brand-50 transition-all duration-300 shadow-inner">
                    <i class="fa-solid {{ $iconClass }} text-2xl {{ $isPdf ? 'text-red-500' : 'text-brand-500' }}"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg leading-tight group-hover:text-brand-600 transition-colors line-clamp-2" title="{{ $doc->judul }}">{{ $doc->judul }}</h3>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="bg-brand-50 text-brand-600 px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider">{{ $doc->kategori }}</span>
                        <span class="text-xs text-slate-400 font-medium"><i class="fa-regular fa-calendar-days mr-1"></i> {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-auto pt-5 border-t border-slate-50 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Klik untuk {{ $isPdf ? 'membuka' : 'mengunduh' }}</span>
                <a href="{{ asset(str_starts_with($doc->file_path, 'assets') ? $doc->file_path : 'storage/' . $doc->file_path) }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-brand-600 text-slate-700 hover:text-white px-5 py-2 rounded-xl text-sm font-bold transition-colors duration-300">
                    <i class="fa-solid fa-cloud-arrow-down"></i> Akses File
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="text-slate-300 mb-5 animate-pulse"><i class="fa-regular fa-folder-open text-7xl"></i></div>
            <h3 class="text-xl font-bold text-slate-700">Tidak ada dokumen</h3>
            <p class="text-slate-500 mt-2">Dokumen dalam kategori ini belum tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-12">
        {{ $documents->appends(['kategori' => $kategori])->links('pagination::tailwind') }}
    </div>
</div>
@endsection