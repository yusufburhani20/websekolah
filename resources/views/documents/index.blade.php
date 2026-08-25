@extends('layouts.public')

@section('title', 'Dokumen Publik - ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))

@section('content')
<div class="bg-brand-900 py-16 text-center px-4">
    <h1 class="text-4xl font-bold text-white mb-4">Dokumen Unduhan</h1>
    <p class="text-brand-100 max-w-2xl mx-auto">Pusat unduhan dokumen resmi, brosur, materi, dan formulir pendaftaran.</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Filter Kategori -->
    <div class="flex flex-wrap justify-center gap-3 mb-10">
        <a href="/dokumen" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !$kategori ? 'bg-amber-500 text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Semua Dokumen
        </a>
        @foreach($kategori_list as $kat)
        <a href="/dokumen?kategori={{ urlencode($kat) }}" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $kategori == $kat ? 'bg-amber-500 text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            {{ $kat }}
        </a>
        @endforeach
    </div>

    <!-- Tabel Dokumen -->
    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider border-b border-slate-200">
                        <th class="p-6 font-semibold">Nama Dokumen</th>
                        <th class="p-6 font-semibold">Kategori</th>
                        <th class="p-6 font-semibold">Tanggal Upload</th>
                        <th class="p-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-500 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-regular fa-file-pdf text-xl"></i>
                                </div>
                                <span class="font-bold text-slate-800 group-hover:text-brand-600 transition-colors">{{ $doc->judul }}</span>
                            </div>
                        </td>
                        <td class="p-6 text-sm text-slate-600">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $doc->kategori }}</span>
                        </td>
                        <td class="p-6 text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y') }}
                        </td>
                        <td class="p-6 text-right">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-50 hover:bg-brand-600 text-brand-600 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                                <i class="fa-solid fa-download"></i> Unduh
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="text-slate-300 mb-4"><i class="fa-regular fa-folder-open text-5xl"></i></div>
                            <h3 class="text-lg font-bold text-slate-600">Tidak ada dokumen tersedia</h3>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-8">
        {{ $documents->appends(['kategori' => $kategori])->links('pagination::tailwind') }}
    </div>
</div>
@endsection
