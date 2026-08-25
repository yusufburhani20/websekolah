@extends('layouts.public')

@section('title', $page->judul . ' - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-16 text-center px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight">{{ $page->judul }}</h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($page->gambar)
    <div class="rounded-3xl overflow-hidden mb-10 shadow-lg">
        <img src="{{ asset('assets/images/halaman/' . $page->gambar) }}" alt="{{ $page->judul }}" class="w-full h-auto object-cover" onerror="this.onerror=null;this.src='{{ asset('assets/images/default1.jpg') }}';">
    </div>
    @endif
    
    <article class="prose prose-lg max-w-none text-slate-700 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100">
        {!! $page->konten !!}
    </article>
</div>
@endsection
