@extends('layouts.public')

@section('title', 'Berita & Artikel - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<!-- Header Page -->
<div class="bg-brand-950 pt-16 pb-24 text-center px-4 relative overflow-hidden">
    <!-- Dekorasi Background Solid (Tanpa Gradasi) -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-800 rounded-full mix-blend-multiply opacity-20 -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-900 rounded-full mix-blend-multiply opacity-40 translate-y-1/2 -translate-x-1/3"></div>
    
    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex justify-center mb-4" aria-label="Breadcrumb">
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
                        <span class="text-white font-semibold">Berita</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">Berita & Informasi</h1>
        <p class="text-brand-100 max-w-2xl mx-auto text-lg">Dapatkan informasi terbaru seputar kegiatan, prestasi, dan pengumuman resmi dari sekolah kami.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-10 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Main Content -->
        <div class="lg:col-span-3">
            
            @if(count($posts) > 0)
                <!-- Featured Post (Berita Pertama) -->
                @php $featured = $posts->first(); @endphp
                <a href="/berita/{{ $featured->slug }}" class="group block bg-white rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 border border-slate-100 mb-10 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 h-full">
                        <div class="relative h-64 md:h-full overflow-hidden">
                            <img src="{{ asset((str_starts_with(is_array($featured->foto) ? ($featured->foto[0] ?? 'default.jpg') : ($featured->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($featured->thumbnail ?: (is_array($featured->foto) ? ($featured->foto[0] ?? 'default.jpg') : ($featured->foto ?: 'default.jpg')))) }}" alt="{{ $featured->judul }}" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                            <div class="absolute top-4 left-4 bg-amber-400 text-brand-950 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-md">
                                {{ $featured->kategori }}
                            </div>
                        </div>
                        <div class="p-8 md:p-10 flex flex-col justify-center">
                            <div class="flex items-center gap-4 mb-4">
                                <span class="text-sm font-semibold text-slate-500 flex items-center gap-2">
                                    <i class="fa-regular fa-calendar-alt text-brand-500"></i> {{ \Carbon\Carbon::parse($featured->tanggal_posting)->format('d M Y') }}
                                </span>
                                <span class="text-sm font-semibold text-slate-500 flex items-center gap-2">
                                    <i class="fa-regular fa-eye text-brand-500"></i> {{ $featured->views }}x
                                </span>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-bold text-brand-950 mb-4 group-hover:text-brand-600 leading-tight transition-colors">{{ $featured->judul }}</h2>
                            <p class="text-slate-600 mb-6 line-clamp-3 leading-relaxed">{{ $featured->ringkasan ?: strip_tags($featured->isi) }}</p>
                            <div class="mt-auto inline-flex items-center gap-2 text-brand-600 font-bold uppercase tracking-wider text-sm group-hover:text-brand-800 transition-colors">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right-long transition-transform group-hover:translate-x-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Grid Posts (Berita Selanjutnya) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    @foreach($posts->skip(1) as $post)
                    <a href="/berita/{{ $post->slug }}" class="group flex flex-col bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-md hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ asset((str_starts_with(is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: (is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg')))) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                            <div class="absolute top-4 left-4 bg-amber-400 text-brand-950 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                                {{ $post->kategori }}
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <p class="text-sm font-medium text-slate-500 mb-3 flex items-center gap-2">
                                <i class="fa-regular fa-calendar-alt text-brand-400"></i> {{ \Carbon\Carbon::parse($post->tanggal_posting)->format('d M Y') }}
                            </p>
                            <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-brand-600 line-clamp-2 leading-snug transition-colors">{{ $post->judul }}</h3>
                            <p class="text-slate-600 text-sm line-clamp-2 leading-relaxed mb-4 flex-1">{{ $post->ringkasan ?: strip_tags($post->isi) }}</p>
                            <div class="inline-flex items-center gap-2 text-brand-600 font-semibold text-sm group-hover:text-brand-800 transition-colors">
                                Baca artikel <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm text-center py-20">
                    <div class="w-24 h-24 bg-brand-50 text-brand-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-regular fa-folder-open text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum ada berita</h3>
                    <p class="text-slate-500">Coba cari dengan kata kunci atau kategori lain.</p>
                </div>
            @endif
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Search -->
            <div class="bg-white border border-slate-100 shadow-sm p-6 rounded-3xl">
                <h3 class="font-bold text-lg text-brand-950 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-amber-500"></i> Cari Berita
                </h3>
                <form action="/berita" method="GET">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..." class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl py-3 pl-4 pr-12 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
                        <button type="submit" class="absolute right-2 top-2 w-8 h-8 flex items-center justify-center bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition-colors">
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Categories -->
            <div class="bg-white border border-slate-100 shadow-sm p-6 rounded-3xl">
                <h3 class="font-bold text-lg text-brand-950 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-tags text-amber-500"></i> Kategori Topik
                </h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/berita" class="flex items-center justify-between p-3 rounded-xl hover:bg-brand-50 text-slate-600 hover:text-brand-700 font-medium transition-colors {{ !request('kategori') ? 'bg-brand-50 text-brand-700' : '' }}">
                            <span>Semua Berita</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </li>
                    @foreach($kategori_list as $kategori)
                    <li>
                        <a href="/berita?kategori={{ urlencode($kategori) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-brand-50 text-slate-600 hover:text-brand-700 font-medium transition-colors {{ request('kategori') == $kategori ? 'bg-brand-50 text-brand-700' : '' }}">
                            <span>{{ $kategori }}</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Popular Posts -->
            <div class="bg-white border border-slate-100 shadow-sm p-6 rounded-3xl">
                <h3 class="font-bold text-lg text-brand-950 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-amber-500"></i> Sedang Hangat
                </h3>
                <div class="space-y-5">
                    @foreach($popular_posts as $pop)
                    <a href="/berita/{{ $pop->slug }}" class="flex gap-4 group items-center">
                        <div class="w-20 h-20 flex-shrink-0 rounded-2xl overflow-hidden shadow-sm">
                            <img src="{{ asset((str_starts_with(is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($pop->thumbnail ?: (is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg')))) }}" alt="{{ $pop->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-brand-600 leading-snug mb-1.5 transition-colors">{{ $pop->judul }}</h4>
                            <p class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                <i class="fa-regular fa-eye text-brand-400"></i>{{ number_format($pop->views) }} x
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
