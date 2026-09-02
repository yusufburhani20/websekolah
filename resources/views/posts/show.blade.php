@extends('layouts.public')

@section('title', $post->judul . ' - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<!-- Header Berita -->
<div class="bg-brand-950 pt-16 pb-32 text-center px-4 relative overflow-hidden">
    <!-- Dekorasi Background Solid -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-brand-800 rounded-full mix-blend-multiply opacity-20 -translate-y-1/2 -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-900 rounded-full mix-blend-multiply opacity-30 translate-y-1/2 translate-x-1/3"></div>
    
    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li class="inline-flex items-center">
                    <a href="/" class="text-slate-400 hover:text-white transition-colors"><i class="fa-solid fa-house mr-2 text-xs"></i>Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-slate-600 mx-2 text-[10px]"></i>
                        <a href="/berita" class="text-slate-400 hover:text-white transition-colors">Berita</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-slate-600 mx-2 text-[10px]"></i>
                        <span class="text-amber-400 font-semibold">{{ $post->kategori }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">{{ $post->judul }}</h1>
        
        <!-- Meta Info -->
        <div class="flex flex-wrap items-center justify-center gap-4 md:gap-8 text-sm font-medium">
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full text-white backdrop-blur-sm">
                <div class="w-6 h-6 bg-brand-500 rounded-full flex items-center justify-center"><i class="fa-solid fa-user-pen text-[10px]"></i></div>
                <span>Tim Redaksi</span>
            </div>
            <div class="flex items-center gap-2 text-slate-300">
                <i class="fa-regular fa-calendar-alt text-amber-400"></i>
                <span>{{ \Carbon\Carbon::parse($post->tanggal_posting)->format('d F Y') }}</span>
            </div>
            <div class="flex items-center gap-2 text-slate-300">
                <i class="fa-regular fa-clock text-amber-400"></i>
                @php $readTime = max(1, ceil(str_word_count(strip_tags($post->isi)) / 200)); @endphp
                <span>{{ $readTime }} Menit Baca</span>
            </div>
            <div class="flex items-center gap-2 text-slate-300">
                <i class="fa-regular fa-eye text-amber-400"></i>
                <span>{{ number_format($post->views) }} Dilihat</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-16 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- Main Article -->
        <div class="lg:col-span-3">
            <div class="bg-white p-6 md:p-10 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
                
                <!-- Featured Image -->
                @php
                    $galeri = is_array($post->foto) ? $post->foto : ($post->foto ? [$post->foto] : []);
                    $fotos = $post->thumbnail ? array_merge([$post->thumbnail], $galeri) : $galeri;
                    $fotos = array_filter($fotos);
                @endphp
                @if(count($fotos) > 1)
                    <div class="swiper post-slider mb-10 rounded-2xl overflow-hidden shadow-md border border-slate-100">
                        <div class="swiper-wrapper">
                            @foreach($fotos as $f)
                                <div class="swiper-slide">
                                    <img src="{{ asset((str_starts_with($f, 'assets') ? '' : 'assets/images/berita/') . ($f ?: 'default.jpg')) }}" alt="{{ $post->judul }}" class="w-full h-[400px] md:h-[500px] object-cover" loading="lazy">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next !text-white !bg-black/20 hover:!bg-black/50 !w-12 !h-12 !rounded-full backdrop-blur-sm transition-colors after:!text-xl"></div>
                        <div class="swiper-button-prev !text-white !bg-black/20 hover:!bg-black/50 !w-12 !h-12 !rounded-full backdrop-blur-sm transition-colors after:!text-xl"></div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            new Swiper('.post-slider', {
                                loop: true,
                                pagination: { el: '.swiper-pagination', clickable: true },
                                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                                autoplay: { delay: 4000 },
                            });
                        });
                    </script>
                @elseif(count($fotos) == 1)
                    <div class="rounded-2xl overflow-hidden mb-10 shadow-md border border-slate-100">
                        <img src="{{ asset((str_starts_with($post->thumbnail ?: ($fotos[0] ?? ''), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: ($fotos[0] ?? 'default.jpg'))) }}" alt="{{ $post->judul }}" class="w-full h-auto max-h-[500px] object-cover" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                    </div>
                @endif
                
                <!-- Article Content Custom Typography -->
                <article class="prose prose-lg max-w-none text-slate-700 
                    prose-headings:text-brand-950 prose-headings:font-bold 
                    prose-a:text-brand-600 hover:prose-a:text-amber-500 prose-a:transition-colors prose-a:font-semibold prose-a:no-underline
                    prose-blockquote:border-l-4 prose-blockquote:border-brand-500 prose-blockquote:bg-slate-50 prose-blockquote:py-3 prose-blockquote:px-6 prose-blockquote:rounded-r-xl prose-blockquote:not-italic prose-blockquote:text-brand-900 prose-blockquote:font-medium
                    prose-img:rounded-2xl prose-img:border prose-img:border-slate-100 prose-img:shadow-sm
                    prose-li:marker:text-amber-500">
                    {!! $post->isi !!}
                </article>
                
                <!-- Share (Solid Colors) -->
                <div class="mt-14 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="font-bold text-slate-800 uppercase tracking-wider text-sm flex items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-brand-500"></i> Bagikan Artikel Ini
                    </span>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-colors shadow-sm"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->judul) }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-colors shadow-sm"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->judul . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-100 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-colors shadow-sm"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-8">
                
                <!-- Popular Posts (Solid style) -->
                <div class="bg-white border border-slate-100 shadow-sm p-6 rounded-3xl">
                    <h3 class="font-bold text-lg text-brand-950 mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-amber-500"></i> Paling Banyak Dibaca
                    </h3>
                    <div class="space-y-5">
                        @foreach($popular_posts as $pop)
                        <a href="/berita/{{ $pop->slug }}" class="flex gap-4 group items-center">
                            <div class="w-20 h-20 flex-shrink-0 rounded-2xl overflow-hidden shadow-sm">
                                <img src="{{ asset((str_starts_with(is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($pop->thumbnail ?: (is_array($pop->foto) ? ($pop->foto[0] ?? 'default.jpg') : ($pop->foto ?: 'default.jpg')))) }}" alt="{{ $pop->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-brand-600 leading-snug mb-1.5 transition-colors">{{ $pop->judul }}</h4>
                                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-regular fa-calendar text-brand-400"></i>{{ \Carbon\Carbon::parse($pop->tanggal_posting)->format('d M y') }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                
                @if($related_posts->count() > 0)
                <!-- Related Posts -->
                <div class="bg-brand-950 border-t-8 border-amber-400 shadow-lg p-6 rounded-3xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-800 rounded-full opacity-50 -translate-y-1/2 translate-x-1/2"></div>
                    <h3 class="font-bold text-lg text-white mb-5 flex items-center gap-2 relative z-10">
                        <i class="fa-solid fa-link text-amber-400"></i> Berita Terkait
                    </h3>
                    <div class="space-y-4 relative z-10">
                        @foreach($related_posts as $rel)
                        <a href="/berita/{{ $rel->slug }}" class="block group border-b border-brand-800/50 pb-4 last:border-0 last:pb-0">
                            <h4 class="text-sm font-medium text-slate-300 group-hover:text-amber-400 leading-snug transition-colors">{{ $rel->judul }}</h4>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
            </div>
        </div>
        
    </div>
</div>

@php
    $schemaImage = count($fotos) > 0 ? asset((str_starts_with($post->thumbnail ?: ($fotos[0] ?? ''), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: ($fotos[0] ?? 'default.jpg'))) : asset('assets/images/logo.png');
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ $post->judul }}",
  "image": "{{ $schemaImage }}",
  "datePublished": "{{ \Carbon\Carbon::parse($post->tanggal_posting)->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "Tim Redaksi"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset((str_starts_with($settings->logo ?? '', 'assets') ? '' : 'assets/images/') . ($settings->logo ?? 'logo.png')) }}"
    }
  },
  "description": "{{ Str::limit(strip_tags($post->isi), 150) }}"
}
</script>
@endsection
