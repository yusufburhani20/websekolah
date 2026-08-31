@extends('layouts.public')

@section('title', 'Formulir Tracer Study - ' . ($settings->nama_sekolah ?? 'SMK'))

@section('content')
<div class="pt-32 pb-20 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-60"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-50 rounded-full blur-3xl -ml-32 -mb-32 opacity-60"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12 animate-fade-in-up">
                <span class="bg-brand-100 text-brand-600 px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase mb-4 inline-block shadow-sm shadow-brand-200/50">Tracer Study</span>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 mb-4 leading-tight">
                    Formulir Pendataan <span class="text-brand-600">Alumni</span>
                </h1>
                <p class="text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Bantu kami melacak perkembangan alumni {{ $settings->nama_sekolah ?? 'SMK' }}. Data Anda sangat berarti untuk peningkatan kualitas pendidikan di sekolah kami.
                </p>
                <div class="mt-6 flex justify-center">
                    <a href="{{ url('/tracer-study') }}" class="inline-flex items-center text-brand-600 font-bold hover:text-brand-700 hover:underline">
                        <i class="fa-solid fa-chart-pie mr-2"></i> Lihat Hasil Tracer Study
                    </a>
                </div>
            </div>

            <!-- Livewire Form -->
            @livewire('tracer-study-form')
        </div>
    </div>
</div>
@endsection
