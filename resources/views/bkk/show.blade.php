@extends('layouts.public')

@section('title', $vacancy->judul_lowongan . ' di ' . $vacancy->company->nama_perusahaan . ' - BKK ' . ($settings->nama_sekolah ?? 'SMK'))

@section('content')
<div class="pt-32 pb-20 bg-slate-50 relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm font-medium text-slate-500">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="hover:text-brand-600 transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-[10px] mx-2"></i>
                        <a href="{{ url('/bkk') }}" class="hover:text-brand-600 transition-colors">BKK</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-[10px] mx-2"></i>
                        <span class="text-slate-400 line-clamp-1 max-w-[200px]">{{ $vacancy->judul_lowongan }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Lowongan -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-50 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
                    
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6 relative z-10 mb-8">
                        <div class="w-24 h-24 rounded-2xl bg-slate-50 border border-slate-100 p-3 flex items-center justify-center shrink-0 shadow-sm">
                            @if($vacancy->company->logo)
                                <img src="{{ Storage::url($vacancy->company->logo) }}" alt="{{ $vacancy->company->nama_perusahaan }}" class="max-w-full max-h-full object-contain">
                            @else
                                <i class="fa-solid fa-building text-4xl text-slate-300"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $vacancy->judul_lowongan }}</h1>
                            <div class="text-lg font-bold text-brand-600 mb-4">{{ $vacancy->company->nama_perusahaan }}</div>
                            <div class="flex flex-wrap gap-3">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-brand-50 text-brand-600 border border-brand-100">
                                    <i class="fa-solid fa-briefcase mr-2 text-brand-400"></i> {{ $vacancy->tipe_pekerjaan }}
                                </span>
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-slate-50 text-slate-600 border border-slate-200">
                                    <i class="fa-solid fa-location-dot mr-2 text-slate-400"></i> {{ $vacancy->lokasi_penempatan }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6 border-t border-slate-100">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Posisi</p>
                            <p class="font-bold text-slate-700">{{ $vacancy->posisi }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Batas Akhir</p>
                            <p class="font-bold text-red-500">{{ $vacancy->batas_lamaran->format('d M Y') }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jurusan Terkait</p>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @if($vacancy->jurusan_terkait && is_array($vacancy->jurusan_terkait))
                                    @foreach($vacancy->jurusan_terkait as $jurId)
                                        @php $j = \App\Models\Jurusan::find($jurId); @endphp
                                        @if($j)
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-xs font-bold">{{ $j->singkatan ?: $j->nama_jurusan }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-sm font-medium text-slate-600">Terbuka untuk Umum</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Pekerjaan -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        Deskripsi Pekerjaan
                    </h3>
                    <div class="prose prose-slate max-w-none prose-headings:font-bold prose-a:text-brand-600">
                        {!! $vacancy->deskripsi_pekerjaan !!}
                    </div>
                </div>

                <!-- Persyaratan -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        Persyaratan
                    </h3>
                    <div class="prose prose-slate max-w-none prose-headings:font-bold prose-a:text-brand-600">
                        {!! $vacancy->persyaratan !!}
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan (Form & Profil) -->
            <div class="space-y-6 relative">
                <div class="sticky top-24 space-y-6">
                    <!-- CTA Apply -->
                    <div class="bg-gradient-to-br from-brand-600 to-brand-800 rounded-3xl p-6 text-white shadow-xl shadow-brand-500/30 text-center">
                        <h4 class="text-xl font-bold mb-2">Tertarik dengan posisi ini?</h4>
                        <p class="text-brand-100 text-sm mb-6">Segera kirimkan lamaran dan CV terbaikmu sebelum batas waktu berakhir.</p>
                        
                        <!-- Panggil komponen livewire untuk form lamaran -->
                        @livewire('job-application-form', ['vacancyId' => $vacancy->id])
                    </div>

                    <!-- Profil Perusahaan -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Tentang Perusahaan</h3>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 p-1.5 flex items-center justify-center shrink-0">
                                @if($vacancy->company->logo)
                                    <img src="{{ Storage::url($vacancy->company->logo) }}" alt="{{ $vacancy->company->nama_perusahaan }}" class="max-w-full max-h-full object-contain">
                                @else
                                    <i class="fa-solid fa-building text-xl text-slate-300"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $vacancy->company->nama_perusahaan }}</h4>
                            </div>
                        </div>

                        @if($vacancy->company->deskripsi)
                        <p class="text-sm text-slate-600 mb-4 line-clamp-4">
                            {{ $vacancy->company->deskripsi }}
                        </p>
                        @endif

                        <ul class="space-y-3 text-sm text-slate-600">
                            @if($vacancy->company->alamat)
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-location-dot mt-1 text-slate-400"></i>
                                <span>{{ $vacancy->company->alamat }}</span>
                            </li>
                            @endif
                            @if($vacancy->company->website)
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-globe text-slate-400"></i>
                                <a href="{{ Str::startsWith($vacancy->company->website, 'http') ? $vacancy->company->website : 'https://'.$vacancy->company->website }}" target="_blank" rel="noopener noreferrer" class="text-brand-600 hover:underline">{{ $vacancy->company->website }}</a>
                            </li>
                            @endif
                            @if($vacancy->company->email)
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-envelope text-slate-400"></i>
                                <a href="mailto:{{ $vacancy->company->email }}" class="text-brand-600 hover:underline">{{ $vacancy->company->email }}</a>
                            </li>
                            @endif
                            @if($vacancy->company->no_telp)
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-phone text-slate-400"></i>
                                <span>{{ $vacancy->company->no_telp }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
