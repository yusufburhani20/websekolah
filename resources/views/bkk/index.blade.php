@extends('layouts.public')

@section('title', 'Bursa Kerja Khusus (BKK) - ' . ($settings->nama_sekolah ?? 'SMK'))

@section('content')
<div class="pt-24 pb-12 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-100 rounded-full blur-3xl -mr-48 -mt-48 opacity-60"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl -ml-48 -mb-48 opacity-60"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Hero Section -->
        <div class="text-center mb-10 animate-fade-in-up">
            <span class="bg-brand-100 text-brand-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase mb-3 inline-block shadow-sm">Bursa Kerja Khusus (BKK)</span>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 mb-4 leading-tight">
                Temukan <span class="text-brand-600">Karir Impianmu</span><br>Bersama Mitra Kami
            </h1>
            <p class="text-base text-slate-600 max-w-2xl mx-auto leading-relaxed mb-6">
                Platform karir eksklusif untuk menjembatani lulusan dengan dunia industri. Temukan ribuan peluang kerja yang sesuai dengan passion dan keahlianmu.
            </p>

            <!-- Search Form -->
            <form action="{{ url('/bkk') }}" method="GET" class="max-w-3xl mx-auto bg-white p-2 rounded-2xl shadow-lg border border-slate-100 flex flex-col md:flex-row gap-2">
                <div class="flex-1 relative flex items-center">
                    <i class="fa-solid fa-search absolute left-4 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari posisi atau nama perusahaan..." class="w-full pl-12 pr-4 py-3 bg-transparent border-none focus:ring-0 text-slate-700 font-medium">
                </div>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-8 rounded-xl transition-all w-full md:w-auto shrink-0 shadow-md">
                    Cari Lowongan
                </button>
            </form>
        </div>

        <!-- Marquee Mitra (Optional) -->
        @if($companies->count() > 0)
        <div class="mb-16">
            <p class="text-center text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Dipercaya oleh Perusahaan Terkemuka</p>
            <div class="flex flex-wrap justify-center gap-8 items-center opacity-70 hover:opacity-100 transition-opacity">
                @foreach($companies->take(6) as $company)
                    <div class="flex flex-col items-center gap-2 grayscale hover:grayscale-0 transition-all cursor-help" title="{{ $company->nama_perusahaan }}">
                        @if($company->logo)
                            <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->nama_perusahaan }}" class="h-10 object-contain">
                        @else
                            <div class="font-bold text-xl text-slate-600">{{ $company->nama_perusahaan }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- List Lowongan -->
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Lowongan Terbaru</h2>
                <p class="text-slate-500 mt-1">Jangan lewatkan kesempatan berkarir di perusahaan terbaik.</p>
            </div>
            @if(request()->has('search') && request()->search != '')
                <a href="{{ url('/bkk') }}" class="text-brand-600 font-bold hover:text-brand-700 text-sm">Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i></a>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vacancies as $vacancy)
            <a href="{{ url('/bkk/' . $vacancy->id) }}" class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group relative overflow-hidden flex flex-col h-full">
                <!-- Highlight Tipe Pekerjaan -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-50 rounded-bl-full -mr-4 -mt-4 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-start gap-4 mb-4 relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 p-2 flex items-center justify-center shrink-0">
                        @if($vacancy->company->logo)
                            <img src="{{ Storage::url($vacancy->company->logo) }}" alt="{{ $vacancy->company->nama_perusahaan }}" class="max-w-full max-h-full object-contain">
                        @else
                            <i class="fa-solid fa-building text-2xl text-slate-300"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 group-hover:text-brand-600 transition-colors line-clamp-1">{{ $vacancy->judul_lowongan }}</h3>
                        <p class="text-sm font-medium text-slate-500">{{ $vacancy->company->nama_perusahaan }}</p>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600">
                            {{ $vacancy->tipe_pekerjaan }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                            <i class="fa-solid fa-location-dot mr-1 text-[10px]"></i> {{ $vacancy->lokasi_penempatan }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-slate-600 line-clamp-2 mb-6">
                        {{ strip_tags($vacancy->deskripsi_pekerjaan) }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-400 mt-auto">
                    <span class="flex items-center gap-1">
                        <i class="fa-regular fa-clock"></i> Diposting {{ $vacancy->created_at->diffForHumans() }}
                    </span>
                    <span class="text-red-500 font-bold">
                        Batas: {{ $vacancy->batas_lamaran->format('d M Y') }}
                    </span>
                </div>
            </a>
            @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-100">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4 mx-auto text-slate-300">
                    <i class="fa-solid fa-box-open text-4xl"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Lowongan</h4>
                <p class="text-slate-500 max-w-md mx-auto">Saat ini belum ada lowongan kerja yang tersedia atau sesuai dengan kriteria pencarian Anda.</p>
            </div>
            @endforelse
        </div>

        @if($vacancies->hasPages())
        <div class="mt-8">
            {{ $vacancies->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
