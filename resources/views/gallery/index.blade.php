@extends('layouts.public')

@section('title', 'Galeri - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

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
            <i class="fa-solid fa-camera-retro animate-pulse"></i> Album Dokumentasi
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg tracking-tight">
            Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-amber-500">Kegiatan</span>
        </h1>
        <p class="text-brand-100 max-w-2xl mx-auto text-base md:text-lg font-medium leading-relaxed">
            Jelajahi momen-momen berharga, fasilitas unggulan, dan prestasi membanggakan yang terekam abadi di lingkungan sekolah kami.
        </p>
    </div>
</section>
<!-- Filter Kategori -->
<section class="bg-white border-b border-slate-100 sticky top-20 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 overflow-x-auto py-4 hide-scrollbar">
            <a href="/galeri" class="px-5 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-colors {{ !$kategori ? 'bg-amber-400 text-brand-950' : 'bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-brand-950' }}">
                Semua Album
            </a>
            @foreach($kategories as $kat)
                @if($kat)
                <a href="/galeri?kategori={{ urlencode($kat) }}" class="px-5 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-colors {{ $kategori == $kat ? 'bg-amber-400 text-brand-950' : 'bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-brand-950' }}">
                    {{ $kat }}
                </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- Galeri Masonry Grid -->
<section class="py-16 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        @if($galleries->count() > 0)
        <!-- Masonry Layout -->
        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">
            @foreach($galleries as $item)
            @php
                $images = is_array($item->gambar) ? $item->gambar : (is_string($item->gambar) ? json_decode($item->gambar, true) ?? [$item->gambar] : ['default.jpg']);
                $cover = $images[0] ?? 'default.jpg';
                $count = count($images);
            @endphp
            
            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 relative cursor-pointer break-inside-avoid mb-6" onclick="openModal({{ json_encode($images) }}, '{{ addslashes($item->judul) }}', '{{ addslashes($item->deskripsi) }}')">
                
                <!-- Image Container -->
                <div class="relative overflow-hidden bg-slate-200">
                    <img src="{{ asset((str_starts_with($cover, 'assets') ? '' : 'assets/images/gallery/') . $cover) }}" alt="{{ $item->judul }}" loading="lazy" class="w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                    
                    <!-- Overlay Kategori -->
                    @if($item->kategori)
                    <div class="absolute top-3 right-3 bg-brand-950/80 backdrop-blur-sm text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md z-10">
                        {{ $item->kategori }}
                    </div>
                    @endif
                    
                    <!-- Overlay Photo Count -->
                    @if($count > 1)
                    <div class="absolute bottom-3 right-3 bg-brand-950/80 backdrop-blur-sm text-amber-400 text-xs font-bold px-3 py-1.5 rounded-xl shadow-md z-10 flex items-center gap-1.5 border border-brand-800">
                        <i class="fa-solid fa-images"></i> {{ $count }} Foto
                    </div>
                    @endif
                    
                    <!-- Hover Overlay Icon -->
                    <div class="absolute inset-0 bg-brand-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-0">
                        <div class="w-12 h-12 bg-amber-400 rounded-full flex items-center justify-center text-brand-950 transform scale-50 group-hover:scale-100 transition-transform duration-500 delay-100 shadow-xl">
                            <i class="fa-solid fa-expand text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-bold text-brand-950 group-hover:text-brand-600 transition-colors line-clamp-1" title="{{ $item->judul }}">{{ $item->judul }}</h3>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $galleries->appends(request()->query())->links() }}
        </div>
        
        @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm max-w-2xl mx-auto">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-regular fa-image text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-brand-950 mb-2">Belum Ada Album</h3>
            <p class="text-slate-500">Belum ada dokumentasi galeri yang diunggah untuk kategori ini.</p>
            @if($kategori)
            <a href="/galeri" class="inline-block mt-6 px-6 py-2.5 bg-brand-50 text-brand-600 font-bold rounded-full hover:bg-brand-100 transition-colors">
                Lihat Semua Kategori
            </a>
            @endif
        </div>
        @endif
        
    </div>
</section>

<!-- Lightbox Modal with Slider -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-brand-950/95 backdrop-blur-lg" onclick="closeModal()"></div>
    <div class="relative z-10 w-full h-full flex flex-col justify-center items-center p-4 md:p-10">
        
        <!-- Top Bar -->
        <div class="absolute top-0 left-0 w-full p-6 flex justify-between items-center z-20">
            <div id="imageCounter" class="bg-brand-900/50 backdrop-blur-md text-amber-400 font-bold px-4 py-1.5 rounded-full text-sm border border-brand-800">
                1 / 1
            </div>
            <button onclick="closeModal()" class="w-10 h-10 bg-brand-900/50 backdrop-blur-md hover:bg-amber-400 hover:text-brand-950 text-white rounded-full flex items-center justify-center transition-all duration-300 border border-brand-800">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        
        <!-- Main Image -->
        <div class="relative w-full max-w-6xl max-h-[70vh] flex items-center justify-center group">
            
            <button id="prevBtn" onclick="prevImage(event)" class="absolute left-0 md:-left-12 w-12 h-12 bg-white/10 hover:bg-amber-400 text-white hover:text-brand-950 rounded-full flex items-center justify-center backdrop-blur-md transition-all duration-300 z-20 opacity-0 group-hover:opacity-100">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            
            <img id="modalImage" src="" alt="Gallery Image" class="max-w-full max-h-[70vh] object-contain rounded-xl shadow-2xl transition-all duration-300">
            
            <button id="nextBtn" onclick="nextImage(event)" class="absolute right-0 md:-right-12 w-12 h-12 bg-white/10 hover:bg-amber-400 text-white hover:text-brand-950 rounded-full flex items-center justify-center backdrop-blur-md transition-all duration-300 z-20 opacity-0 group-hover:opacity-100">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            
        </div>
        
        <!-- Caption -->
        <div class="mt-8 text-center max-w-3xl px-4 z-20">
            <h3 id="modalTitle" class="text-2xl font-bold text-white mb-3"></h3>
            <p id="modalDesc" class="text-brand-200 text-sm md:text-base leading-relaxed"></p>
        </div>
    </div>
</div>

<script>
    let currentImages = [];
    let currentIndex = 0;

    function openModal(images, title, desc) {
        currentImages = images;
        currentIndex = 0;
        
        updateModalImage();
        
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalDesc').textContent = desc || '';
        
        if(currentImages.length > 1) {
            document.getElementById('prevBtn').style.display = 'flex';
            document.getElementById('nextBtn').style.display = 'flex';
            document.getElementById('imageCounter').style.display = 'block';
        } else {
            document.getElementById('prevBtn').style.display = 'none';
            document.getElementById('nextBtn').style.display = 'none';
            document.getElementById('imageCounter').style.display = 'none';
        }
        
        const modal = document.getElementById('imageModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function updateModalImage() {
        if(!currentImages || currentImages.length === 0) return;
        
        let img = currentImages[currentIndex];
        let src = img.startsWith('assets') ? '/' + img : '/assets/images/gallery/' + img;
        
        // Add a small fade effect by toggling opacity
        const imgEl = document.getElementById('modalImage');
        imgEl.style.opacity = '0.5';
        setTimeout(() => {
            imgEl.src = src;
            imgEl.style.opacity = '1';
        }, 150);
        
        document.getElementById('imageCounter').textContent = (currentIndex + 1) + ' / ' + currentImages.length;
    }

    function nextImage(e) {
        if(e) e.stopPropagation();
        if(currentIndex < currentImages.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // loop
        }
        updateModalImage();
    }

    function prevImage(e) {
        if(e) e.stopPropagation();
        if(currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = currentImages.length - 1; // loop
        }
        updateModalImage();
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageModal');
        if (!modal.classList.contains('hidden')) {
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        }
    });
</script>

@endsection
