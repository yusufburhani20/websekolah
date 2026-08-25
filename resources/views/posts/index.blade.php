@extends('layouts.public')

@section('title', 'Berita & Artikel - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-16 text-center">
    <h1 class="text-4xl font-bold text-white mb-4">Berita & Artikel</h1>
    <p class="text-brand-100 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar kegiatan dan prestasi di sekolah kami.</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($posts as $post)
                <a href="/berita/{{ $post->slug }}" class="group block bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset((str_starts_with(is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: (is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg')))) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                        <div class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $post->kategori }}
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-slate-500 mb-2"><i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($post->tanggal_posting)->format('d M Y') }}</p>
                        <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-brand-600 line-clamp-2 leading-tight">{{ $post->judul }}</h3>
                        <p class="text-slate-600 text-sm line-clamp-2">{{ $post->ringkasan ?: strip_tags($post->isi) }}</p>
                    </div>
                </a>
                @empty
                <div class="col-span-3 text-center py-12">
                    <div class="text-slate-400 mb-4"><i class="fa-regular fa-folder-open text-6xl"></i></div>
                    <h3 class="text-xl font-bold text-slate-700">Belum ada berita</h3>
                    <p class="text-slate-500">Coba cari dengan kata kunci lain.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Search -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl mb-8">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-l-4 border-brand-500 pl-3">Cari Berita</h3>
                <form action="/berita" method="GET">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Kata kunci..." class="w-full border border-slate-300 rounded-xl py-2 pl-4 pr-10 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-brand-500"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            
            <!-- Categories -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl mb-8">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-l-4 border-brand-500 pl-3">Kategori</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/berita" class="flex items-center text-slate-600 hover:text-brand-600 {{ !request('kategori') ? 'text-brand-600 font-semibold' : '' }}">
                            <i class="fa-solid fa-chevron-right text-xs mr-2"></i> Semua Kategori
                        </a>
                    </li>
                    @foreach($kategori_list as $kategori)
                    <li>
                        <a href="/berita?kategori={{ urlencode($kategori) }}" class="flex items-center text-slate-600 hover:text-brand-600 {{ request('kategori') == $kategori ? 'text-brand-600 font-semibold' : '' }}">
                            <i class="fa-solid fa-chevron-right text-xs mr-2"></i> {{ $kategori }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Popular Posts -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-l-4 border-brand-500 pl-3">Berita Terpopuler</h3>
                <div class="space-y-4">
                    @foreach($popular_posts as $pop)
                    <a href="/berita/{{ $pop->slug }}" class="flex gap-4 group">
                        <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                            <img src="{{ asset((str_starts_with(is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($pop->thumbnail ?: (is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg')))) }}" alt="{{ $pop->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-brand-600 leading-tight mb-1">{{ $pop->judul }}</h4>
                            <p class="text-xs text-slate-500"><i class="fa-regular fa-eye mr-1"></i>{{ $pop->views }} views</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
