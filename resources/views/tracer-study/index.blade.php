@extends('layouts.public')

@section('title', 'Hasil Tracer Study - ' . ($settings->nama_sekolah ?? 'SMK'))

@section('content')
<div class="pt-32 pb-20 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-60"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-50 rounded-full blur-3xl -ml-32 -mb-32 opacity-60"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 animate-fade-in-up">
            <span class="bg-brand-100 text-brand-600 px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase mb-4 inline-block shadow-sm shadow-brand-200/50">Tracer Study</span>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 mb-4 leading-tight">
                Hasil Pendataan <span class="text-brand-600">Alumni</span>
            </h1>
            <p class="text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Berikut adalah data dan statistik keterserapan alumni {{ $settings->nama_sekolah ?? 'SMK' }} di dunia kerja, wirausaha, maupun pendidikan tinggi.
            </p>
            <div class="mt-6 flex justify-center">
                <a href="{{ url('/tracer-study/isi') }}" class="inline-flex items-center bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-brand-500/30">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Isi Formulir Tracer Study
                </a>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">Total Data</p>
                    <h3 class="text-xl font-black text-slate-800">{{ $totalAlumni }}</h3>
                </div>
            </div>
            @foreach($statusCounts as $statusName => $total)
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0
                    {{ $statusName == 'Bekerja' ? 'bg-emerald-100 text-emerald-600' : 
                       ($statusName == 'Kuliah' ? 'bg-blue-100 text-blue-600' : 
                       ($statusName == 'Wirausaha' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600')) }}">
                    <i class="fa-solid {{ $statusName == 'Bekerja' ? 'fa-briefcase' : 
                                         ($statusName == 'Kuliah' ? 'fa-graduation-cap' : 
                                         ($statusName == 'Wirausaha' ? 'fa-store' : 'fa-magnifying-glass')) }} text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">{{ $statusName }}</p>
                    <h3 class="text-xl font-black text-slate-800">{{ $total }}</h3>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Chart Section -->
        <div class="mt-8 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Grafik Keterserapan Lulusan</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6">Distribusi status alumni didasarkan pada data tracer study terbaru. Sebagian besar alumni kami dapat langsung terserap di dunia kerja atau melanjutkan pendidikan ke jenjang yang lebih tinggi.</p>
                    
                    <div class="space-y-4">
                        @foreach($statusCounts as $statusName => $total)
                        @php
                            $percentage = $totalAlumni > 0 ? round(($total / $totalAlumni) * 100) : 0;
                            $colorClass = $statusName == 'Bekerja' ? 'bg-emerald-500' : 
                                         ($statusName == 'Kuliah' ? 'bg-blue-500' : 
                                         ($statusName == 'Wirausaha' ? 'bg-amber-500' : 'bg-red-500'));
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm font-bold mb-1">
                                <span class="text-slate-700">{{ $statusName }}</span>
                                <span class="text-slate-500">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="relative flex justify-center items-center">
                    <div class="w-64 h-64 md:w-80 md:h-80">
                        <canvas id="tracerChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-t-3xl border border-b-0 border-slate-100 p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
            <form action="{{ url('/tracer-study') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Cari nama alumni...">
                    </div>
                </div>
                <div>
                    <select name="jurusan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all appearance-none">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <input type="number" name="tahun" value="{{ request('tahun') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Tahun Lulus">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold px-6 rounded-xl transition-all shadow-md">
                        Cari
                    </button>
                    @if(request()->has('search') || request()->has('jurusan') || request()->has('tahun'))
                    <a href="{{ url('/tracer-study') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-bold px-4 rounded-xl transition-all flex items-center justify-center">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Data -->
        <div class="bg-white rounded-b-3xl border border-slate-100 shadow-sm overflow-hidden animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Nama Alumni</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Lulus</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Jurusan</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Pekerjaan/Instansi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($alumnis as $alumni)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $alumni->nama_lengkap }}</div>
                                <div class="text-xs text-slate-400 mt-1"><i class="fa-solid fa-venus-mars mr-1"></i> {{ $alumni->jenis_kelamin }}</div>
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-600">{{ $alumni->tahun_keluar }}</td>
                            <td class="py-4 px-6 font-medium text-slate-600">{{ $alumni->jurusan->nama_jurusan ?? '-' }}</td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($alumni->status as $stat)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                        {{ $stat == 'Bekerja' ? 'bg-emerald-100 text-emerald-700' : 
                                           ($stat == 'Kuliah' ? 'bg-blue-100 text-blue-700' : 
                                           ($stat == 'Wirausaha' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')) }}">
                                        {{ $stat }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if(in_array('Bekerja', $alumni->status) || in_array('Wirausaha', $alumni->status))
                                <div class="font-medium text-slate-700">{{ $alumni->pekerjaan ?: $alumni->bidang_usaha ?: '-' }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $alumni->nama_perusahaan ?: '-' }}</div>
                                @endif
                                
                                @if(in_array('Kuliah', $alumni->status))
                                <div class="font-medium text-slate-700 {{ in_array('Bekerja', $alumni->status) || in_array('Wirausaha', $alumni->status) ? 'mt-2 border-t border-slate-100 pt-2' : '' }}">{{ $alumni->jurusan_kuliah ?: '-' }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $alumni->kampus ?: '-' }}</div>
                                @endif

                                @if(in_array('Mencari Kerja', $alumni->status))
                                <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                        <i class="fa-solid fa-magnifying-glass text-4xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Data</h4>
                                    <p class="text-slate-500 text-sm max-w-md mx-auto">Kami tidak dapat menemukan data alumni yang sesuai dengan filter pencarian Anda. Silakan coba kriteria pencarian lain.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($alumnis->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $alumnis->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('tracerChart');
        if(ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Bekerja', 'Kuliah', 'Wirausaha', 'Mencari Kerja'],
                    datasets: [{
                        data: [
                            {{ $statusCounts['Bekerja'] ?? 0 }}, 
                            {{ $statusCounts['Kuliah'] ?? 0 }}, 
                            {{ $statusCounts['Wirausaha'] ?? 0 }}, 
                            {{ $statusCounts['Mencari Kerja'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#10b981', // emerald-500
                            '#3b82f6', // blue-500
                            '#f59e0b', // amber-500
                            '#ef4444'  // red-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false // We use our own custom legend bars
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' Orang';
                                    }
                                    return label;
                                }
                            },
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 14, family: "'Inter', sans-serif" },
                            bodyFont: { size: 13, family: "'Inter', sans-serif" }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
