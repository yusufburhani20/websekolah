@extends('layouts.public')

@section('title', $jurusan->nama_jurusan . ' - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-16 text-center px-4">
    <div class="max-w-4xl mx-auto">
        @if($jurusan->logo)
        <img src="{{ asset('assets/images/jurusan/' . $jurusan->logo) }}" alt="Logo {{ $jurusan->singkatan }}" class="w-24 h-24 mx-auto mb-6 bg-white p-2 rounded-2xl shadow-lg" onerror="this.style.display='none';">
        @endif
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">{{ $jurusan->nama_jurusan }}</h1>
        <p class="text-brand-200 text-xl font-medium">{{ $jurusan->singkatan }}</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Tentang Jurusan -->
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100 mb-12">
        <h2 class="text-2xl font-bold text-brand-900 mb-6 border-l-4 border-brand-500 pl-4">Tentang Kompetensi Keahlian</h2>
        <article class="prose prose-lg max-w-none text-slate-700">
            {!! $jurusan->deskripsi ?: '<p class="text-slate-500 italic">Informasi deskripsi kompetensi keahlian belum tersedia.</p>' !!}
        </article>
    </div>
    
    <!-- Guru Produktif -->
    @if($teachers->count() > 0)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-brand-900 mb-8 border-l-4 border-brand-500 pl-4">Guru Produktif</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($teachers as $teacher)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 text-center flex flex-col items-center group hover:shadow-xl transition-all duration-300">
                <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-4 border-slate-50 group-hover:border-brand-100 transition-colors">
                    <img src="{{ asset('assets/images/guru/' . ($teacher->foto ?: 'default.jpg')) }}" alt="{{ $teacher->nama }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                </div>
                <h3 class="font-bold text-slate-800 mb-1 group-hover:text-brand-600">{{ $teacher->nama }}</h3>
                <p class="text-brand-500 text-sm font-medium">{{ $teacher->bidang ?? 'Guru Produktif' }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
