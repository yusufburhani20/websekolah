@extends('layouts.public')

@section('title', $post->judul . ' - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-12 text-center px-4">
    <div class="max-w-4xl mx-auto">
        <div class="inline-block bg-amber-500 text-white text-sm font-bold px-4 py-1 rounded-full uppercase tracking-wider mb-4">
            {{ $post->kategori }}
        </div>
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">{{ $post->judul }}</h1>
        <div class="flex items-center justify-center gap-6 text-brand-100 text-sm">
            <span><i class="fa-regular fa-calendar mr-2"></i> {{ \Carbon\Carbon::parse($post->tanggal_posting)->format('d F Y') }}</span>
            <span><i class="fa-regular fa-eye mr-2"></i> {{ $post->views }}x dibaca</span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- Main Article -->
        <div class="lg:col-span-3">
            <!-- Featured Image -->
            @php
                $galeri = is_array($post->foto) ? $post->foto : ($post->foto ? [$post->foto] : []);
                $fotos = $post->thumbnail ? array_merge([$post->thumbnail], $galeri) : $galeri;
                // Pastikan menghapus nilai kosong
                $fotos = array_filter($fotos);
            @endphp
            @if(count($fotos) > 1)
                <div class="swiper post-slider mb-10 rounded-3xl overflow-hidden shadow-lg">
                    <div class="swiper-wrapper">
                        @foreach($fotos as $f)
                            <div class="swiper-slide">
                                <img src="{{ asset((str_starts_with($f, 'assets') ? '' : 'assets/images/berita/') . ($f ?: 'default.jpg')) }}" alt="{{ $post->judul }}" class="w-full h-[500px] object-cover">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next" style="color: white;"></div>
                    <div class="swiper-button-prev" style="color: white;"></div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        new Swiper('.post-slider', {
                            loop: true,
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            autoplay: {
                                delay: 3000,
                            },
                        });
                    });
                </script>
            @else
                <div class="rounded-3xl overflow-hidden mb-10 shadow-lg">
                    <img src="{{ asset((str_starts_with($post->thumbnail ?: ($fotos[0] ?? ''), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: ($fotos[0] ?? 'default.jpg'))) }}" alt="{{ $post->judul }}" class="w-full h-auto object-cover" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                </div>
            @endif
            
            <!-- Article Content -->
            <article class="prose prose-lg max-w-none text-slate-700">
                {!! $post->isi !!}
            </article>
            
            
            
            <!-- Share -->
            <div class="mt-12 pt-8 border-t border-slate-200 flex items-center justify-between">
                <span class="font-semibold text-slate-800">Bagikan Artikel Ini:</span>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->judul) }}" target="_blank" class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center hover:bg-sky-600 transition-colors"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->judul . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Popular Posts -->
            <div class="bg-slate-50 border border-slate-100 p-6 rounded-3xl mb-8 sticky top-28">
                <h3 class="font-bold text-lg text-slate-800 mb-6 border-l-4 border-brand-500 pl-3">Terpopuler</h3>
                <div class="space-y-6">
                    @foreach($popular_posts as $pop)
                    <a href="/berita/{{ $pop->slug }}" class="flex gap-4 group">
                        <div class="w-24 h-20 flex-shrink-0 rounded-xl overflow-hidden shadow-sm">
                            <img src="{{ asset((str_starts_with(is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($pop->thumbnail ?: (is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg')))) }}" alt="{{ $pop->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-brand-600 leading-tight mb-2">{{ $pop->judul }}</h4>
                            <p class="text-xs text-slate-500"><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($pop->tanggal_posting)->format('d M') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                @if($related_posts->count() > 0)
                <h3 class="font-bold text-lg text-slate-800 mb-6 mt-10 border-l-4 border-brand-500 pl-3">Terkait</h3>
                <div class="space-y-4">
                    @foreach($related_posts as $rel)
                    <a href="/berita/{{ $rel->slug }}" class="block group">
                        <h4 class="text-sm font-semibold text-slate-700 group-hover:text-brand-600 leading-tight mb-1">{{ $rel->judul }}</h4>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        
    </div>
</div>
@endsection
