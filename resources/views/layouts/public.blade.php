<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Website Resmi ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah') . ' - Mencetak generasi unggul, berkarakter dan menguasai teknologi.')">
    <meta property="og:title" content="@yield('title', $settings->nama_sekolah ?? 'SMK Idrisiyyah')">
    <meta property="og:description" content="@yield('meta_description', 'Website Resmi ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah'))">
    <meta property="og:image" content="@yield('meta_image', asset((str_starts_with($settings->logo ?? '', 'assets') ? '' : 'assets/images/') . ($settings->logo ?? 'logo.png')))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', $settings->nama_sekolah ?? 'SMK Idrisiyyah')</title>
    @if(!empty($settings->favicon))
    <link rel="icon" type="image/png" href="{{ asset((str_starts_with($settings->favicon ?? '', 'assets') ? '' : 'assets/images/') . ($settings->favicon ?? 'logo.png')) }}">
    <link rel="shortcut icon" href="{{ asset((str_starts_with($settings->favicon ?? '', 'assets') ? '' : 'assets/images/') . ($settings->favicon ?? 'logo.png')) }}">
    <link rel="apple-touch-icon" href="{{ asset((str_starts_with($settings->favicon ?? '', 'assets') ? '' : 'assets/images/') . ($settings->favicon ?? 'logo.png')) }}">
    @else
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                            900: '#1e3a8a', 950: '#172554',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
    @yield('head')

    <!-- Org Chart Styles -->
    <style>
.org-chart-wrapper {
  --navy: #1E3A6E;
  --navy-soft: #EAF0FA;
  --amber: #F0A202;
  --amber-soft: #FDF3DC;
  --teal: #2E8B74;
  --teal-soft: #E7F5F1;
  --ink: #1F2430;
  --muted: #64748B;
  --line: #C7D2E0;
  --card-bg: #FFFFFF;
  max-width: 1100px;
  margin: 0 auto;
  padding: 2.5rem 1.25rem 3rem;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
  color: var(--ink);
  box-sizing: border-box;
}
.org-chart-wrapper * { box-sizing: border-box; }
.org-header { text-align: center; margin-bottom: 2.75rem; }
.org-eyebrow { display: inline-block; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--amber); margin-bottom: 0.4rem; }
.org-title { font-size: clamp(1.5rem, 4vw, 2.25rem); font-weight: 800; letter-spacing: -0.01em; margin: 0; color: var(--navy); }
.org-top { display: flex; justify-content: center; margin-bottom: 0; }
.org-card { display: block !important; text-decoration: none !important; color: inherit !important; background: var(--card-bg); border: 1px solid var(--line) !important; border-radius: 12px; padding: 0.9rem 1.1rem; box-shadow: 0 1px 2px rgba(20, 30, 60, 0.05); transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease; position: relative; }
.org-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(20, 40, 80, 0.12); border-color: var(--navy) !important; }
.org-card:focus-visible { outline: 2.5px solid var(--amber); outline-offset: 2px; }
.org-role { font-size: 0.7rem !important; font-weight: 700 !important; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted) !important; margin: 0 0 0.15rem !important; }
.org-name { font-size: 0.92rem !important; font-weight: 600 !important; margin: 0 !important; color: var(--ink) !important; }
.org-card .org-link-icon { position: absolute; top: 0.7rem; right: 0.7rem; font-size: 0.7rem; color: var(--muted); opacity: 0; transition: opacity 0.15s ease; }
.org-card:hover .org-link-icon { opacity: 1; }
.org-card--principal { background: var(--navy); border-color: var(--navy) !important; text-align: center; min-width: 280px; padding: 1.1rem 1.5rem; }
.org-card--principal .org-role { color: #B9CBEA !important; }
.org-card--principal .org-name { color: #fff !important; font-size: 1.05rem !important; }
.org-card--principal:hover { border-color: var(--amber) !important; }
.org-trunk { width: 2px; height: 2rem; background: var(--amber); margin: 0 auto; }
.org-branch-bar { height: 2px; background: var(--amber); margin: 0 5%; }
.org-drops { display: grid; grid-template-columns: 1fr 1fr 1fr; }
.org-drop { width: 2px; height: 1.75rem; background: var(--amber); margin: 0 auto; }
.org-columns { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; align-items: start; }
.org-column { display: flex; flex-direction: column; align-items: stretch; }
.org-column-head { text-align: center; margin-bottom: 0.9rem; }
.org-column--kurikulum .org-card--head { border-top: 3px solid var(--navy) !important; }
.org-column--kesiswaan .org-card--head { border-top: 3px solid var(--teal) !important; }
.org-column--admin .org-card--head { border-top: 3px solid var(--amber) !important; background: var(--amber-soft); }
.org-stem { width: 2px; flex: 0 0 auto; height: 1.25rem; background: var(--line); margin: 0 auto; }
.org-sublist { display: flex; flex-direction: column; gap: 0.6rem; position: relative; padding-left: 0; }
.org-column--kurikulum .org-card:hover { border-color: var(--navy) !important; }
.org-column--kesiswaan .org-card:hover { border-color: var(--teal) !important; }
.org-column--admin .org-card { background: #fff; }
.org-column--admin .org-card:hover { border-color: var(--amber) !important; }
.org-subgroup { margin-top: 0.6rem; padding-top: 0.7rem; border-top: 1px dashed var(--line); display: flex; flex-direction: column; gap: 0.6rem; }
.org-subgroup-label { font-size: 0.68rem !important; font-weight: 700 !important; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted) !important; text-align: center; margin-bottom: 0.1rem !important; }
.org-note { text-align: center; margin-top: 2.5rem !important; font-size: 0.78rem !important; color: var(--muted) !important; }
@media (max-width: 760px) {
  .org-branch-bar, .org-drops { display: none; }
  .org-columns { grid-template-columns: 1fr; gap: 2rem; }
  .org-column::before { content: ""; display: block; width: 2px; height: 1.5rem; background: var(--amber); margin: 0 auto 0.5rem; }
}
@media (prefers-reduced-motion: reduce) { .org-card { transition: none; } }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-slate-50 flex flex-col min-h-screen">

    <!-- Top Bar (Header Pengumuman) -->
    <div class="bg-brand-950 text-white/80 py-0 text-xs border-b border-brand-800 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-stretch min-h-[38px]">

            <!-- Kiri: Kontak & Akreditasi -->
            <div class="flex items-center divide-x divide-white/10 overflow-hidden">
                @if(!empty($settings->email))
                <a href="mailto:{{ $settings->email }}" class="hidden lg:flex items-center gap-2 px-4 h-full hover:bg-white/5 hover:text-white transition-colors duration-200 py-2.5 whitespace-nowrap">
                    <i class="fa-regular fa-envelope text-brand-400"></i>
                    <span>{{ $settings->email }}</span>
                </a>
                @endif
                @if(!empty($settings->telepon))
                <a href="tel:{{ $settings->telepon }}" class="hidden md:flex items-center gap-2 px-4 hover:bg-white/5 hover:text-white transition-colors duration-200 py-2.5 whitespace-nowrap">
                    <i class="fa-solid fa-phone text-brand-400"></i>
                    <span>{{ $settings->telepon }}</span>
                </a>
                @endif
                @if($settings->header_akreditasi_aktif ?? false)
                <a href="{{ $settings->header_akreditasi_url ?: '#' }}" 
                   target="_blank"
                   class="hidden sm:flex items-center px-3 lg:px-4 hover:bg-white/5 transition-colors duration-200 py-2 group whitespace-nowrap">
                    <div class="flex items-center gap-1.5 bg-amber-400 text-brand-950 px-3 py-1 rounded-full shadow-[0_0_10px_rgba(245,158,11,0.2)] group-hover:shadow-[0_0_15px_rgba(245,158,11,0.5)] transition-all">
                        <i class="fa-solid fa-award text-[10px]"></i>
                        <span class="font-extrabold text-[10px] lg:text-xs uppercase tracking-wide">Akreditasi {{ $settings->header_akreditasi_teks }}</span>
                    </div>
                </a>
                @endif
            </div>

                        <!-- Kanan: Sosial Media & Pendaftaran -->
            <div class="flex items-center divide-x divide-white/10 w-full sm:w-auto justify-between sm:justify-end">
                @if($settings->sidebar_show_sosmed ?? true)
                <div class="flex items-center px-4 gap-2.5 py-1.5 flex-1 sm:flex-none justify-start sm:justify-center">
                    @if(!empty($settings->facebook))
                    <a href="{{ $settings->facebook }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors duration-300" title="Facebook">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    @endif
                    @if(!empty($settings->instagram))
                    <a href="{{ $settings->instagram }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-pink-600 rounded-full flex items-center justify-center transition-colors duration-300" title="Instagram">
                        <i class="fa-brands fa-instagram text-xs"></i>
                    </a>
                    @endif
                    @if(!empty($settings->youtube))
                    <a href="{{ $settings->youtube }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors duration-300" title="YouTube">
                        <i class="fa-brands fa-youtube text-xs"></i>
                    </a>
                    @endif
                    @if(!empty($settings->twitter))
                    <a href="{{ $settings->twitter }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-sky-500 rounded-full flex items-center justify-center transition-colors duration-300" title="Twitter/X">
                        <i class="fa-brands fa-x-twitter text-xs"></i>
                    </a>
                    @endif
                    @if(!empty($settings->tiktok))
                    <a href="{{ $settings->tiktok }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-black rounded-full flex items-center justify-center transition-colors duration-300" title="TikTok">
                        <i class="fa-brands fa-tiktok text-xs"></i>
                    </a>
                    @endif
                    @if(!empty($settings->whatsapp))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-green-500 rounded-full flex items-center justify-center transition-colors duration-300" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-xs"></i>
                    </a>
                    @endif
                    @if(!empty($settings->telegram))
                    <a href="{{ $settings->telegram }}" target="_blank" class="w-7 h-7 bg-white/10 hover:bg-sky-600 rounded-full flex items-center justify-center transition-colors duration-300" title="Telegram">
                        <i class="fa-brands fa-telegram text-xs"></i>
                    </a>
                    @endif
                </div>
                @endif
                @if($settings->header_pendaftaran_aktif ?? false)
                <a href="{{ $settings->header_pendaftaran_url }}"
                   @if($settings->header_pendaftaran_newtab ?? false) target="_blank" @endif
                   class="flex items-center gap-2 px-5 bg-amber-500 hover:bg-amber-400 text-white font-semibold transition-colors duration-200 py-2.5 h-full whitespace-nowrap flex-shrink-0 text-sm">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span class="hidden xs:inline">{{ $settings->header_pendaftaran_teks ?: 'Daftar Sekarang' }}</span>
                    <span class="inline xs:hidden">Daftar</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50 w-full transition-all duration-300 shadow-sm" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        @if(!empty($settings->logo))
                        <img src="{{ asset((str_starts_with($settings->logo ?? '', 'assets') ? '' : 'assets/images/') . ($settings->logo ?? 'logo.png')) }}" alt="Logo" class="h-12 w-auto transform transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.style.display='none'">
                        @else
                        <div class="h-12 w-12 bg-brand-600 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-lg">
                            {{ substr($settings->nama_sekolah ?? 'S', 0, 1) }}
                        </div>
                        @endif
                        <span class="font-bold text-xl md:text-2xl tracking-tight text-brand-900 group-hover:text-brand-600 transition-colors">
                            {{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}
                        </span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    @foreach($menus as $menu)
                        @if($menu->children->count() > 0)
                        <div class="relative group py-2">
                            <button class="flex items-center gap-1 text-gray-600 hover:text-brand-600 font-medium transition-colors focus:outline-none">
                                {{ $menu->nama_menu }}
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                            </button>
                            <span class="absolute -bottom-1 left-1/2 w-0 h-1 bg-amber-400 transition-all duration-300 group-hover:w-full group-hover:left-0 rounded-full"></span>
                            <!-- Dropdown -->
                            <div class="absolute left-0 top-full mt-1 w-52 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top -translate-y-2 group-hover:translate-y-0 z-50">
                                <div class="py-2">
                                    @foreach($menu->children as $child)
                                    <a href="{{ url($child->url) }}" target="{{ $child->target ?? '_self' }}" class="block px-4 py-2.5 text-sm text-gray-600 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                                        {{ $child->nama_menu }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @else
                        <a href="{{ url($menu->url) }}" target="{{ $menu->target ?? '_self' }}" class="text-gray-600 hover:text-brand-600 font-medium transition-colors relative group py-2">
                            {{ $menu->nama_menu }}
                            <span class="absolute -bottom-1 left-1/2 w-0 h-1 bg-amber-400 transition-all duration-300 group-hover:w-full group-hover:left-0 rounded-full"></span>
                        </a>
                        @endif
                    @endforeach
                </div>

                <!-- Mobile Hamburger -->
                <div class="flex md:hidden items-center">
                    <button @click="mobileOpen = !mobileOpen" class="text-gray-600 hover:text-brand-600 p-2">
                        <i class="fa-solid fa-bars text-xl" x-show="!mobileOpen"></i>
                        <i class="fa-solid fa-xmark text-xl" x-show="mobileOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-cloak class="md:hidden bg-white border-t border-gray-100 shadow-2xl max-h-[70vh] overflow-y-auto">
            <div class="px-4 py-2 flex flex-col">
                @foreach($menus as $menu)
                    @if($menu->children->count() > 0)
                        <div x-data="{ open: false }" class="border-b border-slate-100 last:border-0">
                            <button @click="open = !open" class="flex items-center justify-between w-full py-3.5 px-2 text-brand-950 hover:text-brand-600 font-bold transition-colors">
                                <span>{{ $menu->nama_menu }}</span>
                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180 text-brand-600': open}"></i>
                                </div>
                            </button>
                            <div x-show="open" style="display: none;" class="pl-4 pb-3 space-y-1">
                                @foreach($menu->children as $child)
                                <a href="{{ url($child->url) }}" class="block py-2.5 px-4 text-sm text-slate-600 font-medium hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-colors border-l-2 border-slate-200 hover:border-amber-400">
                                    {{ $child->nama_menu }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ url($menu->url) }}" class="block py-3.5 px-2 text-brand-950 hover:text-brand-600 font-bold transition-colors border-b border-slate-100 last:border-0">
                            {{ $menu->nama_menu }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-950 pt-16 pb-8 border-t-[6px] border-brand-500 text-slate-300 mt-20 relative overflow-hidden">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-700/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-500/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                
                <!-- Kolom 1: Identitas Sekolah -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        @if(!empty($settings->logo))
                        <img src="{{ asset((str_starts_with($settings->logo ?? '', 'assets') ? '' : 'assets/images/') . ($settings->logo ?? 'logo.png')) }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
                        @endif
                        <h3 class="text-xl font-bold text-white">{{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}</h3>
                    </div>
                    @if(!empty($settings->deskripsi_web))
                    <p class="text-slate-400 text-sm leading-relaxed mb-5">{{ $settings->deskripsi_web }}</p>
                    @endif
                    
                    @if($settings->header_akreditasi_aktif ?? false)
                    <div class="mb-6 inline-block">
                        <a href="{{ $settings->header_akreditasi_url ?: '#' }}" target="_blank" class="group flex items-center gap-3 bg-white/5 border border-white/10 hover:border-amber-500/40 hover:bg-white/10 px-4 py-2.5 rounded-2xl transition-all duration-300">
                            <div class="flex items-center justify-center w-10 h-10 bg-amber-400 text-brand-950 rounded-xl shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-award text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-0.5">Terakreditasi BAN-S/M</p>
                                <p class="text-white font-bold text-sm">Peringkat <span class="text-amber-400">{{ $settings->header_akreditasi_teks }}</span></p>
                            </div>
                        </a>
                    </div>
                    @endif
                    
                    <!-- Sosial Media -->
                    @if($settings->sidebar_show_sosmed ?? true)
                    <div class="flex items-center gap-3 flex-wrap">
                        @if(!empty($settings->facebook))
                        <a href="{{ $settings->facebook }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors duration-300" title="Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        @endif
                        @if(!empty($settings->instagram))
                        <a href="{{ $settings->instagram }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-pink-600 rounded-full flex items-center justify-center transition-colors duration-300" title="Instagram">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        @endif
                        @if(!empty($settings->youtube))
                        <a href="{{ $settings->youtube }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors duration-300" title="YouTube">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        @endif
                        @if(!empty($settings->twitter))
                        <a href="{{ $settings->twitter }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-sky-500 rounded-full flex items-center justify-center transition-colors duration-300" title="Twitter/X">
                            <i class="fa-brands fa-x-twitter text-sm"></i>
                        </a>
                        @endif
                        @if(!empty($settings->tiktok))
                        <a href="{{ $settings->tiktok }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-black rounded-full flex items-center justify-center transition-colors duration-300" title="TikTok">
                            <i class="fa-brands fa-tiktok text-sm"></i>
                        </a>
                        @endif
                        @if(!empty($settings->whatsapp))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-green-500 rounded-full flex items-center justify-center transition-colors duration-300" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                        @endif
                        @if(!empty($settings->telegram))
                        <a href="{{ $settings->telegram }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-sky-600 rounded-full flex items-center justify-center transition-colors duration-300" title="Telegram">
                            <i class="fa-brands fa-telegram text-sm"></i>
                        </a>
                        @endif
                    </div>
                    @endif
                    @if(!empty($settings->maps_iframe))
                    <div class="mt-8">
                        <h4 class="text-white font-semibold text-base mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-brand-400"></i> Lokasi Kami
                        </h4>
                        <!-- Tambahkan filter: grayscale-0 contrast-100 agar Maps tetap berwarna cerah -->
                        <div class="rounded-xl overflow-hidden border border-white/10 shadow-lg grayscale-0 contrast-100" style="height:180px;">
                            {!! preg_replace('/width="[^"]*"/', 'width="100%"', preg_replace('/height="[^"]*"/', 'height="180"', $settings->maps_iframe)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Kolom 2: Kontak -->
                <div class="space-y-6">
                    <div>
                        <h4 class="text-white font-semibold text-lg mb-4 pb-2 border-b border-white/10">Kontak Kami</h4>
                        <ul class="space-y-3 text-sm">
                            @if(!empty($settings->alamat))
                            <li class="flex gap-3">
                                <i class="fa-solid fa-location-dot text-brand-400 mt-0.5 w-4 flex-shrink-0"></i>
                                <span class="text-slate-400 leading-relaxed">{{ $settings->alamat }}</span>
                            </li>
                            @endif
                            @if(!empty($settings->telepon))
                            <li class="flex gap-3 items-center">
                                <i class="fa-solid fa-phone text-brand-400 w-4 flex-shrink-0"></i>
                                <a href="tel:{{ $settings->telepon }}" class="text-slate-400 hover:text-amber-400 transition-colors hover:translate-x-1 inline-block transform duration-300">{{ $settings->telepon }}</a>
                            </li>
                            @endif
                            @if(!empty($settings->email))
                            <li class="flex gap-3 items-center">
                                <i class="fa-regular fa-envelope text-brand-400 w-4 flex-shrink-0"></i>
                                <a href="mailto:{{ $settings->email }}" class="text-slate-400 hover:text-amber-400 transition-colors hover:translate-x-1 inline-block transform duration-300">{{ $settings->email }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    
                </div>

                <!-- Kolom 3: Menu Navigasi -->
                <div>
                    <h4 class="text-white font-semibold text-lg mb-5 pb-2 border-b border-white/10">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="group inline-flex items-center text-slate-400 hover:text-amber-400 transition-all duration-300"><i class="fa-solid fa-angle-right text-[10px] opacity-0 -ml-2 mr-0 group-hover:opacity-100 group-hover:ml-0 group-hover:mr-2 transition-all duration-300"></i>Beranda</a></li>
                        <li><a href="/berita" class="group inline-flex items-center text-slate-400 hover:text-amber-400 transition-all duration-300"><i class="fa-solid fa-angle-right text-[10px] opacity-0 -ml-2 mr-0 group-hover:opacity-100 group-hover:ml-0 group-hover:mr-2 transition-all duration-300"></i>Berita</a></li>
                        <li><a href="/dokumen" class="group inline-flex items-center text-slate-400 hover:text-amber-400 transition-all duration-300"><i class="fa-solid fa-angle-right text-[10px] opacity-0 -ml-2 mr-0 group-hover:opacity-100 group-hover:ml-0 group-hover:mr-2 transition-all duration-300"></i>Dokumen</a></li>
                        <li><a href="/guru" class="group inline-flex items-center text-slate-400 hover:text-amber-400 transition-all duration-300"><i class="fa-solid fa-angle-right text-[10px] opacity-0 -ml-2 mr-0 group-hover:opacity-100 group-hover:ml-0 group-hover:mr-2 transition-all duration-300"></i>Guru & Staf</a></li>
                        <li><a href="/kontak" class="group inline-flex items-center text-slate-400 hover:text-amber-400 transition-all duration-300"><i class="fa-solid fa-angle-right text-[10px] opacity-0 -ml-2 mr-0 group-hover:opacity-100 group-hover:ml-0 group-hover:mr-2 transition-all duration-300"></i>Kontak</a></li>
                        @foreach($menus->take(4) as $menu)
                        @if(!in_array(strtolower($menu->nama_menu), ['beranda', 'berita', 'dokumen', 'kontak']))
                        <li><a href="{{ url($menu->url) }}" class="group inline-flex items-center text-slate-400 hover:text-amber-400 transition-all duration-300"><i class="fa-solid fa-angle-right text-[10px] opacity-0 -ml-2 mr-0 group-hover:opacity-100 group-hover:ml-0 group-hover:mr-2 transition-all duration-300"></i>{{ $menu->nama_menu }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>



            <!-- Copyright -->
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} {{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}. All rights reserved.</p>
                <p>Designed with ❤️ for Education</p>
            </div>
        </div>
    </footer>

    <!-- Popup Beranda -->
    @if(($settings->popup_aktif ?? false) && !empty($settings->popup_gambar))
    <div x-data="{ open: !sessionStorage.getItem('popup_seen') }" 
         x-init="if(open) sessionStorage.setItem('popup_seen', 'true')" 
         x-show="open" x-cloak
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
         @click.self="open = false">
        <div class="relative max-w-lg w-full animate-bounce-once">
            <button @click="open = false" class="absolute -top-4 -right-4 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-lg text-gray-700 hover:bg-red-500 hover:text-white transition-colors z-10">
                <i class="fa-solid fa-xmark"></i>
            </button>
            @if(!empty($settings->popup_url))
            <a href="{{ $settings->popup_url }}" target="_blank">
            @endif
                <img src="{{ asset((str_starts_with($settings->popup_gambar ?? '', 'assets') ? '' : 'assets/images/') . ($settings->popup_gambar ?? '')) }}" alt="Pengumuman" class="w-full rounded-2xl shadow-2xl">
            @if(!empty($settings->popup_url))
            </a>
            @endif
        </div>
    </div>
    @endif

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @stack('scripts')

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 left-6 bg-brand-600 text-white w-12 h-12 rounded-full shadow-[0_4px_14px_0_rgba(0,118,255,0.39)] hover:shadow-[0_6px_20px_rgba(0,118,255,0.23)] flex items-center justify-center opacity-0 invisible transition-all duration-500 hover:bg-brand-500 hover:-translate-y-1.5 z-50 cursor-pointer">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        // Back to Top functionality
        const bttButton = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                bttButton.classList.remove("opacity-0", "invisible");
                bttButton.classList.add("opacity-100", "visible");
            } else {
                bttButton.classList.add("opacity-0", "invisible");
                bttButton.classList.remove("opacity-100", "visible");
            }
        });
        bttButton.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    </script>
    <!-- Floating Contact Widget -->
    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 font-sans">
        <!-- Menu Items -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="flex flex-col items-end gap-3"
             style="display: none;">
             
             @if(!empty($settings->whatsapp))
             @php 
                $wa_url = str_starts_with($settings->whatsapp, 'http') ? $settings->whatsapp : 'https://wa.me/' . preg_replace('/[^0-9]/', '', (substr($settings->whatsapp, 0, 1) == '0' ? '62' . substr($settings->whatsapp, 1) : $settings->whatsapp));
             @endphp
             <a href="{{ $wa_url }}" target="_blank" class="flex items-center gap-3 bg-[#25D366] text-white px-4 py-2 rounded-full shadow-lg hover:bg-[#128C7E] transition-colors transform hover:-translate-y-1">
                 <span class="font-bold text-sm tracking-wide">WhatsApp</span>
                 <div class="bg-white/20 p-2 rounded-full w-8 h-8 flex items-center justify-center"><i class="fa-brands fa-whatsapp text-lg"></i></div>
             </a>
             @endif
             
             @if(!empty($settings->telegram))
             @php 
                $tg_url = str_starts_with($settings->telegram, 'http') ? $settings->telegram : 'https://t.me/' . str_replace('@', '', $settings->telegram);
             @endphp
             <a href="{{ $tg_url }}" target="_blank" class="flex items-center gap-3 bg-[#0088cc] text-white px-4 py-2 rounded-full shadow-lg hover:bg-[#0077b5] transition-colors transform hover:-translate-y-1">
                 <span class="font-bold text-sm tracking-wide">Telegram</span>
                 <div class="bg-white/20 p-2 rounded-full w-8 h-8 flex items-center justify-center"><i class="fa-brands fa-telegram text-lg"></i></div>
             </a>
             @endif
        </div>

        <!-- Main Button -->
        <button @click="open = !open" class="bg-amber-500 hover:bg-amber-400 text-white w-14 h-14 rounded-full shadow-xl shadow-amber-500/30 flex items-center justify-center transition-all duration-300 transform hover:scale-110">
            <i class="fa-solid fa-headset text-2xl transition-transform duration-300" :class="{'rotate-90 scale-0': open, 'rotate-0 scale-100': !open}"></i>
            <i class="fa-solid fa-xmark text-2xl absolute transition-transform duration-300" :class="{'rotate-0 scale-100': open, '-rotate-90 scale-0': !open}"></i>
        </button>
    </div>

</body>
</html>
