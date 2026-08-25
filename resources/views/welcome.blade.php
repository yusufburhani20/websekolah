@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="relative w-full h-[80vh] min-h-[600px] overflow-hidden">
    <div class="swiper w-full h-full" id="hero-swiper">
        <div class="swiper-wrapper">
            @forelse($heroSlides as $slide)
            <div class="swiper-slide relative">
                <img src="{{ asset('assets/images/hero/' . ($slide->gambar ?: 'default1.jpg')) }}" alt="Hero" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';" />
                <div class="absolute inset-0 bg-slate-900/60"></div>
            </div>
            @empty
            <div class="swiper-slide relative">
                <div class="w-full h-full bg-brand-900"></div>
                <div class="absolute inset-0 bg-slate-900/60"></div>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Hero Content -->
    <div class="absolute inset-0 z-10 flex items-center justify-center text-center px-4">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-lg leading-tight tracking-tight">
                {{ $settings->hero_judul ?? 'Selamat Datang di SMK Idrisiyyah' }}
            </h1>
            <p class="text-lg md:text-2xl text-slate-200 mb-10 max-w-2xl mx-auto font-light">
                {{ $settings->hero_subjudul ?? 'Mencetak generasi unggul, siap kerja, berkarakter & menguasai teknologi modern' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($settings->header_pendaftaran_aktif ?? false)
                <a href="{{ $settings->header_pendaftaran_url }}" class="bg-amber-500 hover:bg-amber-400 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:-translate-y-1 shadow-xl shadow-amber-500/30">
                    Daftar Sekarang
                </a>
                @endif
                <a href="#program" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300">
                    Jelajahi Program
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-brand-900 mb-4">Kenapa Memilih Kami?</h2>
            <div class="w-24 h-1 bg-brand-500 mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($homeFeatures as $feature)
            <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-xl transition-all duration-300 group transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-6 text-brand-600 text-3xl group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                    <i class="{{ $feature->ikon }}"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">{{ $feature->judul }}</h3>
                <p class="text-slate-600 leading-relaxed">{{ $feature->teks }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Program Section -->
<section id="program" class="py-20 bg-brand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-brand-900 mb-4">{{ $settings->program_judul ?? 'Program Unggulan' }}</h2>
            <p class="text-brand-600 max-w-2xl mx-auto">{{ $settings->program_teks ?? '' }}</p>
            <div class="w-24 h-1 bg-brand-500 mx-auto rounded-full mt-4"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($homePrograms as $program)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-5 text-amber-600 text-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                    <i class="{{ $program->ikon }}"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $program->judul }}</h3>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $program->teks }}</p>
                @if($program->link_url)
                <a href="{{ $program->link_url }}" class="mt-4 inline-block text-brand-600 font-medium text-sm hover:text-brand-800">Selengkapnya &rarr;</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Statistik & Berita Terbaru -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Statistik Chart -->
            <div class="lg:col-span-1">
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 h-full">
                    <h3 class="text-xl font-bold text-brand-900 mb-6">{{ $settings->chart_judul ?? 'Statistik Siswa' }}</h3>
                    <canvas id="studentChart" class="w-full"></canvas>
                </div>
            </div>
            
            <!-- Berita Terbaru -->
            <div class="lg:col-span-2">
                <div class="flex justify-between items-end mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-brand-900">Berita Terbaru</h2>
                    <a href="/berita" class="text-brand-600 font-semibold hover:text-brand-800 flex items-center gap-2">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($latestPosts as $post)
                    <a href="/berita/{{ $post->slug }}" class="group block bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset((str_starts_with(is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg'), 'assets') ? '' : 'assets/images/berita/') . ($post->thumbnail ?: (is_array($post->foto) ? ($post->foto[0] ?? 'default.jpg') : ($post->foto ?: 'default.jpg')))) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                            <div class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $post->kategori }}
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-500 mb-2"><i class="fa-regular fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($post->tanggal_posting)->format('d M Y') }}</p>
                            <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-brand-600 line-clamp-2">{{ $post->judul }}</h3>
                            <p class="text-slate-600 text-sm line-clamp-3">{{ $post->ringkasan ?: strip_tags($post->isi) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@push('scripts')
<script>
    new Swiper('#hero-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
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
                        label: '{{ $settings->chart_label_1 ?? "Siswa TKJ" }}',
                        data: {!! json_encode($studentCharts->pluck('nilai_1')) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    },
                    {
                        label: '{{ $settings->chart_label_2 ?? "Siswa Akuntansi" }}',
                        data: {!! json_encode($studentCharts->pluck('nilai_2')) !!},
                        backgroundColor: '#f59e0b',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
</script>

@endpush
