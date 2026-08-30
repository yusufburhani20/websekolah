@extends('layouts.public')

@section('title', $settings->nama_sekolah ?? 'SMK Idrisiyyah')

@section('content')

<!-- Hero Section -->
<section class="relative w-full h-[85vh] min-h-[600px] overflow-hidden group">
    <div class="swiper w-full h-full" id="hero-swiper">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
            <div class="swiper-slide relative">
                <img src="{{ asset((str_starts_with($slide->gambar ?: 'default1.jpg', 'assets') ? '' : 'assets/images/hero/') . ($slide->gambar ?: 'default1.jpg')) }}" alt="Hero" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';" />
                <!-- Solid Overlay instead of Gradient -->
                <div class="absolute inset-0 bg-slate-900/60"></div>
            </div>
            @empty
            <div class="swiper-slide relative">
                <div class="w-full h-full bg-brand-900"></div>
                <div class="absolute inset-0 bg-slate-900/60"></div>
            </div>
            @endforelse
        </div>
        <!-- Swiper Pagination & Navigation -->
        <div class="swiper-pagination !bottom-12"></div>
        <div class="swiper-button-prev !text-white/70 hover:!text-white !left-4 md:!left-8 after:!text-3xl opacity-0 group-hover:opacity-100 transition-opacity hidden sm:flex"></div>
        <div class="swiper-button-next !text-white/70 hover:!text-white !right-4 md:!right-8 after:!text-3xl opacity-0 group-hover:opacity-100 transition-opacity hidden sm:flex"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="absolute inset-0 z-10 flex items-center justify-center text-center px-4 pt-10">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-md leading-tight tracking-tight">
                {{ $settings->hero_judul ?? 'Selamat Datang di SMK Idrisiyyah' }}
            </h1>
            <p class="text-xl md:text-2xl leading-relaxed text-amber-400 mb-10 max-w-3xl mx-auto font-bold tracking-wider" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                {!! str_replace(',', ' <span class="mx-2 text-amber-500/50">&bull;</span> ', e($settings->hero_subjudul ?? 'Mencetak generasi unggul, siap kerja, berkarakter & menguasai teknologi modern')) !!}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(!empty($settings->hero_link_teks) && !empty($settings->hero_link))
                <a href="{{ $settings->hero_link }}" class="bg-amber-400 hover:bg-amber-500 text-brand-950 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:-translate-y-1 shadow-lg">
                    {{ $settings->hero_link_teks }}
                </a>
                @endif
                <a href="#program" class="bg-brand-800/40 hover:bg-brand-800/60 backdrop-blur-md border border-white/20 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300">
                    Jelajahi Program
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru (Overlap Hero) -->

@if($settings->info_sekolah_aktif && !empty($settings->info_sekolah_teks))
<!-- Running Text (Info Sekolah) -->
<div class="bg-brand-950 border-b border-brand-800 text-amber-400 py-2.5 overflow-hidden flex items-center relative z-20 shadow-xl">
    <div class="px-4 font-bold text-xs uppercase tracking-widest whitespace-nowrap bg-brand-950 relative z-10 flex items-center gap-2 border-r border-brand-800">
        <i class="fa-solid fa-bullhorn animate-pulse"></i> Info Sekolah
    </div>
    <div class="flex-1 overflow-hidden">
        <marquee scrollamount="5" class="text-sm font-medium tracking-wide flex items-center">
            {!! str_replace(',', ' <span class="mx-4 text-brand-600">|</span> ', e($settings->info_sekolah_teks)) !!}
        </marquee>
    </div>
</div>
@endif

<!-- Berita Terbaru -->
<section class="pt-12 pb-8 bg-slate-50 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto rounded-b-[3rem] shadow-sm mb-0">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 mb-2">Kabar Terbaru</h2>
            <div class="w-16 h-1.5 bg-amber-400 rounded-full"></div>
        </div>
        <a href="/berita" class="hidden md:flex text-brand-600 font-bold hover:text-amber-500 items-center gap-2 transition-colors">
            Lihat Semua Kabar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($latestPosts as $post)
        <a href="/berita/{{ $post->slug }}" class="group block bg-white rounded-3xl overflow-hidden shadow-xl shadow-slate-900/10 border border-slate-100 hover:shadow-2xl hover:shadow-slate-900/20 transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full">
            <div class="relative h-56 overflow-hidden bg-slate-100">
                <img src="{{ asset((str_starts_with(is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: (is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg')))) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                <div class="absolute top-4 left-4 bg-amber-400 text-brand-950 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-md">
                    {{ $post->kategori }}
                </div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-xs text-slate-400 mb-3 font-bold uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-regular fa-calendar-alt text-brand-500"></i>
                    {{ \Carbon\Carbon::parse($post->tanggal_posting)->format('d M Y') }}
                </p>
                <h3 class="text-xl font-bold text-brand-950 mb-3 group-hover:text-brand-600 line-clamp-2 leading-snug transition-colors">{{ $post->judul }}</h3>
                <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed mb-6 flex-1">{{ $post->ringkasan ?: strip_tags($post->isi) }}</p>
                <div class="mt-auto flex items-center gap-2 text-brand-600 font-bold text-sm group-hover:text-amber-500 transition-colors">
                    Baca selengkapnya <i class="fa-solid fa-arrow-right-long transition-transform group-hover:translate-x-2"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <div class="mt-8 text-center md:hidden">
        <a href="/berita" class="inline-flex text-brand-950 font-bold hover:text-white items-center gap-2 bg-amber-400 hover:bg-brand-600 px-6 py-3 rounded-full transition-colors shadow-md">
            Lihat Semua Kabar <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- Program Keahlian (Jurusan) -->
<section id="program" class="pt-8 pb-16 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-200 rounded-full mix-blend-multiply opacity-20 -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-200 rounded-full mix-blend-multiply opacity-20 translate-y-1/3 -translate-x-1/4"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-extrabold text-brand-950 mb-4 tracking-tight">Program Keahlian Unggulan</h2>
            <div class="w-24 h-1.5 bg-amber-400 mx-auto rounded-full mb-6"></div>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">Kami mempersiapkan tenaga profesional yang siap kerja, mandiri, dan berjiwa wirausaha di berbagai bidang industri modern.</p>
        </div>
        
        <style>
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
            .glass-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
            }
            .glass-card:hover {
                
            }
        </style>
        <div class="{{ $jurusans->count() == 2 ? 'flex flex-col md:flex-row justify-center max-w-5xl mx-auto [&>a]:w-full [&>a]:md:w-1/2' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3' }} gap-8">
            @forelse($jurusans as $jur)
            <a href="{{ str_starts_with($jur->slug, '/') || str_starts_with($jur->slug, 'http') ? $jur->slug : url('/jurusan/' . $jur->slug) }}" class="group block glass-card rounded-3xl p-8 hover:-translate-y-3 transition-all duration-500 relative overflow-hidden">
                
                
                <div class="relative z-10 flex flex-col h-full">
                    <!-- Floating Logo Container -->
                    <div class="animate-float mb-8 mt-2 relative">
                        <div class="w-28 h-28 mx-auto bg-white border border-slate-100 text-amber-400 rounded-3xl flex items-center justify-center text-6xl group-hover:border-amber-200 transition-all duration-500 relative z-10 transform group-hover:scale-110 group-hover:rotate-3 shadow-sm hover:shadow-md">
                            @if($jur->logo)
                                <img src="{{ asset((str_starts_with($jur->logo, 'assets') ? '' : 'assets/images/jurusan/') . $jur->logo) }}" alt="{{ $jur->singkatan }}" class="w-20 h-20 object-contain transition-all duration-500">
                            @else
                                <i class="fa-solid fa-laptop-code"></i>
                            @endif
                        </div>
                        
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-2xl font-extrabold text-brand-950 mb-3 group-hover:text-amber-500 transition-colors duration-300">{{ $jur->nama_jurusan }}</h3>
                        <div class="inline-block bg-white/80 backdrop-blur-sm text-brand-700 text-xs font-bold px-4 py-1.5 rounded-full mb-6 border border-brand-100 shadow-sm">{{ $jur->singkatan }}</div>
                        
                        <p class="text-slate-600 text-sm leading-relaxed mb-8 flex-1 line-clamp-3">
                            {{ $jur->deskripsi ?: 'Program keahlian yang membekali siswa dengan keterampilan praktis dan teoretis sesuai standar industri.' }}
                        </p>
                    </div>
                    
                    <div class="mt-auto flex items-center justify-center text-brand-600 font-bold group-hover:text-amber-500 transition-colors bg-white/50 rounded-2xl py-3 group-hover:bg-amber-50">
                        <span>Eksplorasi Program</span>
                        <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-10 bg-white rounded-3xl border border-slate-100 border-dashed">
                <i class="fa-solid fa-graduation-cap text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500">Data Program Keahlian belum ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>


@if($settings->show_sambutan ?? true)
<!-- Sambutan Kepala Sekolah -->
<section class="py-16 bg-white relative">
    <!-- Dotted Pattern Background -->
    <div class="absolute inset-0" style="background-image: radial-gradient(#e2e8f0 1px, transparent 1px); background-size: 20px 20px; opacity: 0.5;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-brand-950 rounded-[3rem] p-8 md:p-16 shadow-2xl relative overflow-visible">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                
                <!-- Foto Kepala Sekolah (Out of bounds effect) -->
                <div class="relative mt-8 lg:mt-0 order-2 lg:order-1">
                    <div class="absolute inset-0 bg-amber-400 rounded-3xl transform rotate-3 scale-105 opacity-50"></div>
                    <div class="absolute inset-0 bg-brand-800 rounded-3xl transform -rotate-3 scale-105"></div>
                    
                    <div class="bg-slate-200 rounded-3xl overflow-visible relative z-10 border-4 border-white shadow-xl h-[400px] lg:h-[500px]">
                        @if(!empty($settings->sambutan_foto))
                        <!-- Foto sengaja ditarik ke atas sedikit agar keluar kotak -->
                        <img src="{{ asset((str_starts_with($settings->sambutan_foto, 'assets') ? '' : 'assets/images/') . $settings->sambutan_foto) }}" alt="Kepala Sekolah" class="w-full h-[110%] object-cover object-top absolute bottom-0 left-0 rounded-b-3xl" onerror="this.onerror=null;this.src='{{ asset('assets/images/default_user.png') }}';">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 rounded-3xl">
                            <i class="fa-solid fa-user-tie text-9xl"></i>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Teks Sambutan -->
                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-800 rounded-full text-amber-400 text-xs font-bold uppercase tracking-wider mb-6">
                        <i class="fa-solid fa-quote-left"></i> Pesan Pimpinan
                    </div>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">Sambutan <br><span class="text-amber-400">Kepala Sekolah</span></h2>
                    
                    <div class="relative">
                        <i class="fa-solid fa-quote-left text-6xl absolute -top-4 -left-6 text-brand-800 opacity-50 z-0"></i>
                        <p class="text-slate-300 leading-relaxed text-lg italic relative z-10 mb-8 font-medium text-justify">
                            "{{ Str::limit($settings->sambutan_teks ?? 'Selamat datang di website resmi sekolah kami. Kami berkomitmen memberikan pendidikan terbaik.', 400) }}"
                        </p>
                    </div>
                    
                    <div class="border-l-4 border-amber-400 pl-4 mt-6">
                        <h4 class="font-bold text-white text-xl">{{ $settings->sambutan_nama ?? 'Bpk. Kepala Sekolah' }}</h4>
                        <p class="text-sm text-brand-300">Kepala Sekolah {{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endif


<!-- Statistik Angka & Grafik -->
@if($settings->show_statistik ?? true)
<section class="py-16 bg-brand-950 relative overflow-hidden">
    <!-- Solid Dekorasi -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-900 rounded-full mix-blend-multiply opacity-50 -translate-y-1/2 translate-x-1/3"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Angka -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white mb-24">
            @if(!empty($settings->stat_mahasantri))
            <div class="bg-brand-900/50 p-6 rounded-3xl border border-brand-800 backdrop-blur-sm">
                <div class="w-12 h-12 bg-amber-400 text-brand-950 rounded-xl flex items-center justify-center text-xl mx-auto mb-4"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="text-4xl md:text-5xl font-extrabold mb-1">{{ $settings->stat_mahasantri }}<span class="text-amber-400">+</span></div>
                <div class="text-brand-300 font-medium text-sm uppercase tracking-widest">Siswa Aktif</div>
            </div>
            @endif
            @if(!empty($settings->stat_dosen))
            <div class="bg-brand-900/50 p-6 rounded-3xl border border-brand-800 backdrop-blur-sm">
                <div class="w-12 h-12 bg-amber-400 text-brand-950 rounded-xl flex items-center justify-center text-xl mx-auto mb-4"><i class="fa-solid fa-chalkboard-user"></i></div>
                <div class="text-4xl md:text-5xl font-extrabold mb-1">{{ $settings->stat_dosen }}<span class="text-amber-400">+</span></div>
                <div class="text-brand-300 font-medium text-sm uppercase tracking-widest">Guru & Staf</div>
            </div>
            @endif
            @if(!empty($settings->stat_alumni))
            <div class="bg-brand-900/50 p-6 rounded-3xl border border-brand-800 backdrop-blur-sm">
                <div class="w-12 h-12 bg-amber-400 text-brand-950 rounded-xl flex items-center justify-center text-xl mx-auto mb-4"><i class="fa-solid fa-award"></i></div>
                <div class="text-4xl md:text-5xl font-extrabold mb-1">{{ $settings->stat_alumni }}<span class="text-amber-400">+</span></div>
                <div class="text-brand-300 font-medium text-sm uppercase tracking-widest">Alumni Sukses</div>
            </div>
            @endif
            @if(!empty($settings->stat_prodi))
            <div class="bg-brand-900/50 p-6 rounded-3xl border border-brand-800 backdrop-blur-sm">
                <div class="w-12 h-12 bg-amber-400 text-brand-950 rounded-xl flex items-center justify-center text-xl mx-auto mb-4"><i class="fa-solid fa-laptop-code"></i></div>
                <div class="text-4xl md:text-5xl font-extrabold mb-1">{{ $settings->stat_prodi }}</div>
                <div class="text-brand-300 font-medium text-sm uppercase tracking-widest">Program Keahlian</div>
            </div>
            @endif
        </div>
        
        <!-- Grafik -->
        @if($settings->show_chart ?? true)
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-4">{{ $settings->chart_judul ?? 'Statistik Perkembangan Siswa' }}</h2>
                <div class="w-16 h-1.5 bg-amber-400 mx-auto rounded-full"></div>
            </div>
            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-2xl">
                <canvas id="studentChart" class="w-full" style="max-height: 400px;"></canvas>
            </div>
        </div>
        @endif
        
    </div>
</section>
@endif


@if($settings->show_keunggulan ?? true)
<!-- Kenapa Memilih Kami? -->
<section class="py-16 bg-white relative overflow-hidden">
    <!-- Dotted Pattern Background -->
    <div class="absolute inset-0" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 30px 30px; opacity: 0.3;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-brand-50 border border-brand-100 rounded-full text-brand-600 text-xs font-bold uppercase tracking-wider mb-4">
                <i class="fa-solid fa-star text-amber-400"></i> Keunggulan Sekolah
            </div>
            <h2 class="text-3xl md:text-5xl font-extrabold text-brand-950 mb-4">Kenapa Memilih Kami?</h2>
            <div class="w-24 h-1.5 bg-amber-400 mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($homeFeatures as $feature)
            <div class="bg-white rounded-[2rem] p-8 border-2 border-slate-50 shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:border-brand-100 transition-all duration-300 group transform hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-50 rounded-bl-full -mr-12 -mt-12 transition-transform duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center mb-6 text-brand-600 text-3xl group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 relative z-10 shadow-sm">
                    <i class="{{ $feature->ikon }}"></i>
                </div>
                <h3 class="text-xl font-extrabold text-brand-950 mb-3 relative z-10">{{ $feature->judul }}</h3>
                <p class="text-slate-500 leading-relaxed text-sm relative z-10">{{ $feature->teks }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


<!-- Mitra Industri -->
<section class="py-16 bg-brand-50 border-t border-brand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 mb-2">Mitra Dunia Usaha & Dunia Industri</h2>
        <p class="text-slate-500 mb-12 font-medium">Bekerja sama erat dengan ratusan perusahaan terkemuka untuk penyaluran lulusan dan prakerin.</p>
        
        @if(isset($mitras) && $mitras->count() > 0)
        <!-- Grid Logo -->
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70 hover:opacity-100 transition-opacity duration-300">
            @foreach($mitras as $mitra)
                @if($mitra->link_web)
                <a href="{{ $mitra->link_web }}" target="_blank" class="block grayscale hover:grayscale-0 transition-all duration-300 transform hover:scale-110">
                @else
                <div class="block grayscale hover:grayscale-0 transition-all duration-300 transform hover:scale-110">
                @endif
                
                @if($mitra->logo)
                    <img src="{{ asset((str_starts_with($mitra->logo, 'assets') ? '' : 'assets/images/mitra/') . $mitra->logo) }}" alt="{{ $mitra->nama_perusahaan }}" class="h-12 md:h-16 w-auto object-contain" title="{{ $mitra->nama_perusahaan }}">
                @else
                    <div class="px-6 py-3 bg-white shadow-sm border border-slate-100 rounded-xl font-bold text-slate-400">{{ $mitra->nama_perusahaan }}</div>
                @endif
                
                @if($mitra->link_web)
                </a>
                @else
                </div>
                @endif
            @endforeach
        </div>
        @else
        <!-- Placeholder Mitra -->
        <div class="flex flex-wrap justify-center items-center gap-12 opacity-30 grayscale">
            <div class="px-8 py-4 bg-white shadow-sm rounded-2xl font-bold text-slate-500 text-xl border border-slate-200">PT Industri Nusantara</div>
            <div class="px-8 py-4 bg-white shadow-sm rounded-2xl font-bold text-slate-500 text-xl border border-slate-200">Teknologi Mandiri</div>
            <div class="px-8 py-4 bg-white shadow-sm rounded-2xl font-bold text-slate-500 text-xl border border-slate-200">Bank Syariah Sejahtera</div>
        </div>
        <p class="text-xs text-slate-400 mt-6">*Data mitra industri dapat ditambahkan melalui panel admin.</p>
        @endif
    </div>
</section>

@endsection


@push('scripts')
<style>
    .swiper-pagination-bullet { background: rgba(255,255,255,0.5); opacity: 1; }
    .swiper-pagination-bullet-active { background: #FFC72C; width: 32px; border-radius: 4px; transition: width 0.3s ease; }
</style>
<script>
    new Swiper('#hero-swiper', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        keyboard: {
            enabled: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('studentChart');
    if(ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($studentCharts->pluck('tahun')) !!},
                datasets: [
                    {
                        label: '{{ $settings->chart_label_1 ?? "Siswa Laki-laki" }}',
                        data: {!! json_encode($studentCharts->pluck('nilai_1')) !!},
                        backgroundColor: '#1e3a8a', // brand-900
                        borderRadius: 6
                    },
                    {
                        label: '{{ $settings->chart_label_2 ?? "Siswa Perempuan" }}',
                        data: {!! json_encode($studentCharts->pluck('nilai_2')) !!},
                        backgroundColor: '#fbbf24', // amber-400
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
</script>

@endpush
