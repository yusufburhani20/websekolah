@extends('layouts.public')

@section('title', $page->judul . ' - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<!-- Header Page -->
<div class="bg-brand-950 pt-20 pb-32 text-center px-4 relative overflow-hidden">
    <!-- Dekorasi Background Solid (Tanpa Gradasi) -->
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
                        <span class="text-white font-semibold">{{ $page->judul }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">{{ $page->judul }}</h1>
    </div>
</div>

<!-- Main Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-20 mb-20">
    <div class="{{ $page->template == 'wide' ? 'block max-w-6xl mx-auto' : 'grid grid-cols-1 lg:grid-cols-3 gap-8' }}">
        
        <!-- Left Column: Content -->
        <div class="{{ $page->template == 'wide' ? 'w-full' : 'lg:col-span-2' }}">
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
                
                @if($page->gambar)
                <div class="rounded-2xl overflow-hidden mb-10 border border-slate-100">
                    <img src="{{ asset((str_starts_with($page->gambar, 'assets') ? '' : 'assets/images/halaman/') . $page->gambar) }}" alt="{{ $page->judul }}" class="w-full h-auto object-cover max-h-[500px]" onerror="this.onerror=null;this.style.display='none';">
                </div>
                @endif
                
                <!-- Prose Tipografi Kustom -->
                <article class="prose prose-lg max-w-none text-slate-700 
                    prose-headings:text-brand-900 prose-headings:font-bold 
                    prose-a:text-brand-600 hover:prose-a:text-amber-500 prose-a:transition-colors prose-a:font-semibold prose-a:no-underline
                    prose-blockquote:border-l-4 prose-blockquote:border-brand-500 prose-blockquote:bg-slate-50 prose-blockquote:py-2 prose-blockquote:px-5 prose-blockquote:rounded-r-xl prose-blockquote:not-italic prose-blockquote:text-brand-800
                    prose-img:rounded-2xl prose-img:border prose-img:border-slate-100 prose-img:shadow-sm
                    prose-li:marker:text-amber-500">
                    {!! $page->konten !!}
                </article>
                
                <!-- Share Button -->
                <div class="mt-12 pt-8 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Bagikan Halaman Ini</span>
                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 bg-slate-100 text-brand-600 hover:bg-brand-600 hover:text-white rounded-full flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($page->judul) }}" target="_blank" class="w-10 h-10 bg-slate-100 text-sky-500 hover:bg-sky-500 hover:text-white rounded-full flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($page->judul . ' - ' . url()->current()) }}" target="_blank" class="w-10 h-10 bg-slate-100 text-green-500 hover:bg-green-500 hover:text-white rounded-full flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        @if($page->template != 'wide')
        <!-- Right Column: Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            
            <!-- Widget: Pendaftaran (CTA) -->
            @if($settings->header_pendaftaran_aktif ?? false)
            <div class="bg-brand-900 rounded-3xl p-8 text-center border-t-8 border-amber-400 shadow-xl overflow-hidden relative">
                <!-- Dekorasi -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-800 rounded-full opacity-50 -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-5 text-amber-500 shadow-lg relative z-10">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl mb-3 relative z-10">Mari Bergabung!</h3>
                <p class="text-brand-100 text-sm mb-6 relative z-10">Jadilah bagian dari generasi unggul di {{ $settings->nama_sekolah ?? 'sekolah kami' }}.</p>
                <a href="{{ $settings->header_pendaftaran_url }}" class="block w-full bg-amber-400 hover:bg-amber-500 text-brand-950 font-bold py-3 px-4 rounded-xl transition-colors shadow-md relative z-10">
                    {{ $settings->header_pendaftaran_teks ?: 'Daftar Sekarang' }}
                </a>
            </div>
            @endif

            <!-- Widget: Navigasi Cepat -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <h4 class="font-bold text-brand-900 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-amber-500"></i> Informasi Lainnya
                </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="/berita" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-brand-600 font-medium transition-colors group">
                            <span>Berita & Informasi</span>
                            <i class="fa-solid fa-angle-right text-slate-300 group-hover:text-brand-500 transition-colors"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/guru" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-brand-600 font-medium transition-colors group">
                            <span>Direktori Guru</span>
                            <i class="fa-solid fa-angle-right text-slate-300 group-hover:text-brand-500 transition-colors"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/dokumen" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-brand-600 font-medium transition-colors group">
                            <span>Dokumen & Unduhan</span>
                            <i class="fa-solid fa-angle-right text-slate-300 group-hover:text-brand-500 transition-colors"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/kontak" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-brand-600 font-medium transition-colors group">
                            <span>Hubungi Kami</span>
                            <i class="fa-solid fa-angle-right text-slate-300 group-hover:text-brand-500 transition-colors"></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Widget: Kontak Cepat -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <h4 class="font-bold text-brand-900 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-regular fa-comments text-amber-500"></i> Butuh Bantuan?
                </h4>
                <p class="text-sm text-slate-500 mb-5">Hubungi layanan informasi kami jika Anda memiliki pertanyaan lebih lanjut.</p>
                
                @if(!empty($settings->whatsapp))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="flex items-center gap-3 bg-green-50 hover:bg-green-100 text-green-700 p-3 rounded-xl transition-colors font-semibold">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    Chat WhatsApp
                </a>
                @elseif(!empty($settings->telepon))
                <a href="tel:{{ $settings->telepon }}" class="flex items-center gap-3 bg-brand-50 hover:bg-brand-100 text-brand-700 p-3 rounded-xl transition-colors font-semibold">
                    <div class="w-8 h-8 bg-brand-600 text-white rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    {{ $settings->telepon }}
                </a>
                @endif
            </div>

        </div>
        @endif
    </div>
</div>
@endsection
