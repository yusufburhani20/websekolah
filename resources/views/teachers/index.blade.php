@extends('layouts.public')

@section('title', 'Direktori Guru & Staff - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-16 text-center px-4">
    <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">Direktori Guru & Staff</h1>
    
    <div class="inline-flex bg-white/10 backdrop-blur-md rounded-full p-1">
        <a href="/guru?kategori=Guru" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $kategori == 'Guru' ? 'bg-amber-500 text-white shadow-lg' : 'text-brand-100 hover:text-white' }}">
            Guru Pengajar
        </a>
        <a href="/guru?kategori=Staff" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $kategori == 'Staff' ? 'bg-amber-500 text-white shadow-lg' : 'text-brand-100 hover:text-white' }}">
            Staff & Tenaga Kependidikan
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($teachers as $teacher)
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
            <div class="aspect-w-3 aspect-h-4 bg-slate-100 relative overflow-hidden">
                <img src="{{ asset('assets/images/guru/' . ($teacher->foto ?: 'default.jpg')) }}" alt="{{ $teacher->nama }}" class="w-full h-full object-cover object-top filter group-hover:brightness-110 transition-all duration-500" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                    @if($teacher->motto)
                    <p class="text-white/90 text-sm italic">"{{ $teacher->motto }}"</p>
                    @endif
                </div>
            </div>
            <div class="p-6 text-center">
                <h3 class="font-bold text-lg text-slate-800 mb-1 group-hover:text-brand-600 transition-colors">{{ $teacher->nama }}</h3>
                <p class="text-brand-500 text-sm font-medium mb-3">{{ $teacher->jabatan ?? $teacher->bidang }}</p>
                @if($teacher->nidn)
                <p class="text-xs text-slate-500 mb-1">NIP/NIDN: {{ $teacher->nidn }}</p>
                @endif
                <div class="w-12 h-1 bg-amber-500 rounded-full mx-auto mt-4 group-hover:w-full transition-all duration-300"></div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20">
            <div class="text-slate-300 mb-4"><i class="fa-solid fa-users-slash text-6xl"></i></div>
            <h3 class="text-xl font-bold text-slate-600">Data {{ $kategori }} belum tersedia</h3>
        </div>
        @endforelse
    </div>
    
    <div class="mt-12">
        {{ $teachers->appends(['kategori' => $kategori])->links('pagination::tailwind') }}
    </div>
</div>
@endsection
