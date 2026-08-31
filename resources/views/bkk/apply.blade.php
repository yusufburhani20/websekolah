@extends('layouts.public')
@section('title', 'Lamar Pekerjaan - ' . $vacancy->posisi)

@section('content')
<div class="bg-slate-50 py-12 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Back -->
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('bkk.show', $vacancy->id) }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-brand-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Lowongan
            </a>
            <div class="text-sm text-slate-400 font-medium hidden sm:block">
                BKK <i class="fa-solid fa-chevron-right text-[10px] mx-2"></i> {{ $vacancy->company->nama_perusahaan }} <i class="fa-solid fa-chevron-right text-[10px] mx-2"></i> Formulir
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-brand-600 px-8 py-10 text-white text-center">
                <h1 class="text-3xl font-bold mb-3">Formulir Lamaran Kerja</h1>
                <p class="text-brand-100 max-w-2xl mx-auto">Silakan lengkapi data diri Anda dengan benar untuk melamar posisi <strong class="text-white">{{ $vacancy->posisi }}</strong> di <strong class="text-white">{{ $vacancy->company->nama_perusahaan }}</strong>.</p>
            </div>

            <!-- Form Body -->
            <form action="{{ route('bkk.store_application', $vacancy->id) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12">
                @csrf
                
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                        <strong class="font-bold flex items-center mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Mohon perbaiki kesalahan berikut:</strong>
                        <ul class="list-disc pl-5 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_pelamar" value="{{ old('nama_pelamar') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all text-slate-800" placeholder="Sesuai KTP atau Ijazah" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tahun Lulus -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Lulus *</label>
                            <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all text-slate-800" placeholder="Misal: {{ date('Y') }}" required>
                        </div>
                        <!-- No HP -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. HP (WhatsApp) *</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all text-slate-800" placeholder="081234567890" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all text-slate-800" placeholder="email@contoh.com" required>
                    </div>

                    <!-- Pesan Pengantar -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Pengantar (Cover Letter)</label>
                        <textarea name="pesan_pengantar" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all text-slate-800 resize-none" placeholder="Perkenalkan diri Anda secara singkat dan sebutkan mengapa Anda cocok untuk posisi ini...">{{ old('pesan_pengantar') }}</textarea>
                    </div>

                    <!-- Upload CV -->
                    <div class="bg-brand-50 rounded-2xl p-6 border border-brand-100">
                        <label class="block text-sm font-bold text-brand-900 mb-2">Upload CV / Resume *</label>
                        <p class="text-xs text-brand-600 mb-4 font-medium">Hanya menerima format PDF. Ukuran maksimal 2MB.</p>
                        
                        <input type="file" name="file_cv" accept=".pdf" required
                               class="block w-full text-sm text-slate-500
                                      file:mr-4 file:py-3 file:px-6
                                      file:rounded-xl file:border-0
                                      file:text-sm file:font-bold
                                      file:bg-brand-600 file:text-white
                                      hover:file:bg-brand-700 file:transition-colors file:cursor-pointer
                                      cursor-pointer bg-white border border-slate-200 rounded-xl px-4 py-3">
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <a href="{{ route('bkk.show', $vacancy->id) }}" class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">Batal</a>
                    <button type="submit" onclick="this.innerHTML='<i class=\'fa-solid fa-spinner fa-spin mr-2\'></i> Mengirim...'; this.classList.add('opacity-75', 'cursor-not-allowed')" class="px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-brand-500/30 flex items-center">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Lamaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
